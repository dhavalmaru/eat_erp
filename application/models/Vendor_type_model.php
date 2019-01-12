<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Vendor_type_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Vendor_Type' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from vendor_type_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'vendor_type' => $this->input->post('vendor_type'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('vendor_type_master',$data);
        $id=$this->db->insert_id();
        $action='Vendor Type Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('vendor_type_master',$data);
        $action='Vendor Type Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Vendor_Type';
    $logarray['cnt_name']='Vendor_Type';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_vendor_type_availablity(){
    $id=$this->input->post('id');
    $vendor_type=$this->input->post('vendor_type');

    // $id="";

    $query=$this->db->query("SELECT * FROM vendor_type_master WHERE id!='".$id."' and vendor_type='".$vendor_type."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>