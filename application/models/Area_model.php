<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Area_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Area' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
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
$sql = "Select  C.*,D.zone from(select A.*, B.distributor_type from 
            (select * from area_master".$cond.") A 
            left join 
            (select * from distributor_type_master) B 
            on (A.type_id=B.id))C
			 left join 
            (select * from zone_master)D
			on (C.zone_id=D.id)			
			where C.status='Approved' order by C.modified_on desc";
    //$sql = "select * from area_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'area' => $this->input->post('area'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'type_id' => $this->input->post('type_id'),
        'zone_id' => $this->input->post('zone_id'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('area_master',$data);
        $id=$this->db->insert_id();
        $action='Area Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('area_master',$data);
        $action='Area Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Area';
    $logarray['cnt_name']='Area';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}
 function get_zone($postData){
    $response = array();
 
    // Select record
    $this->db->select('id,zone');
    $this->db->where('type_id', $postData['type_id']);
    $q = $this->db->get('zone_master');
    $response = $q->result_array();

    return $response;
  }
function check_area_availablity(){
    $id=$this->input->post('id');
    $area=$this->input->post('area');

    // $id="";

    $query=$this->db->query("SELECT * FROM area_master WHERE id!='".$id."' and area='".$area."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>