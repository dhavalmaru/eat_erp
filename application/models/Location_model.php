<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Location_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Area' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id='', $zone_type=''){
    if($status!=""){
        $cond=" where status='".$status."'";
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }

    if($zone_type=="ss_stores"){
        if($cond=="") {
            $cond=" where (type_id='4' or type_id='7')";
        } else {
            $cond=$cond." and (type_id='4' or type_id='7')";
        }
    }

	$sql = "Select  E.*,F.area from(Select  C.*,D.zone from(select A.*, B.distributor_type from 
            (select * from location_master".$cond.") A 
            left join 
            (select * from distributor_type_master) B 
            on (A.type_id=B.id))C
			 left join 
            (select * from zone_master)D
			on (C.zone_id=D.id))E
			 left join 
			(select * from area_master)F
			on (E.area_id=F.id)				
			where E.status='Approved' order by E.modified_on desc";
   // $sql = "select * from location_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'type_id' => $this->input->post('type_id'),
        'area_id' => $this->input->post('area_id'),
        'zone_id' => $this->input->post('zone_id'),
        'location' => $this->input->post('location'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('location_master',$data);
        $id=$this->db->insert_id();
        $action='Location Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('location_master',$data);
        $action='Location Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Location';
    $logarray['cnt_name']='Location';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

  function get_area($postData){
    $response = array();
 
    // Select record
    $this->db->select('id,area');
    $this->db->where('zone_id', $postData['zone_id']);
    $q = $this->db->get('area_master');
    $response = $q->result_array();

    return $response;
  }
function check_location_availablity(){
    $id=$this->input->post('id');
    $location=$this->input->post('location');

    // $id="";

    $query=$this->db->query("SELECT * FROM location_master WHERE id!='".$id."' and location='".$location."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>