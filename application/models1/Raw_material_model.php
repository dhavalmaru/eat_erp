<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Raw_material_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Raw_Material' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from raw_material_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'rm_name' => $this->input->post('rm_name'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('raw_material_master',$data);
        $id=$this->db->insert_id();
        $action='Raw Material Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('raw_material_master',$data);
        $action='Raw Material Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Raw_Material';
    $logarray['cnt_name']='Raw_Material';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_raw_material_name_availablity(){
    $id=$this->input->post('id');
    $rm_name=$this->input->post('rm_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM raw_material_master WHERE id!='".$id."' and rm_name='".$rm_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>