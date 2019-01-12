<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class store_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Store_Master' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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
	
		$sql = "Select  G.*,H.store_name from 
            (Select  E.*,F.location from 
            (Select  A.*,D.zone from 
            (select * from store_master".$cond.") A 
            left join 
            (select * from zone_master)D
			on (A.zone_id=D.id))E
			 left join 
			(select * from location_master)F
			on (E.location_id=F.id))G
			left join 
			(select * from relationship_master)H
			on (G.store_id=H.id)			
			where G.status='Approved' order by G.modified_on desc";
	
	

   // $sql = "select * from store_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'store_id' => $this->input->post('store_id'),
        'zone_id' => $this->input->post('zone_id'),
        'location_id' => $this->input->post('location_id'),
        'category' => $this->input->post('category'),
		'google_address' => $this->input->post('google_address'),
		'latitude' => $this->input->post('st_latitude'),
        'longitude' => $this->input->post('st_longitude'),
       // 'area_id' => $this->input->post('area_id'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('store_master',$data);
        $id=$this->db->insert_id();
        $action='Store Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('store_master',$data);
        $action='Store Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Store_Master';
    $logarray['cnt_name']='Store_Master';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}
 

 
 
function check_store_availablity(){
    $id=$this->input->post('id');
    $store_name=$this->input->post('store_name');

   $id="";

    $query=$this->db->query("SELECT * FROM relationship_master WHERE id!='".$id."' and store_name='".$store_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>