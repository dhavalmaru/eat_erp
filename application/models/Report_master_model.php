<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Report_master_model Extends CI_Model{

function __Construct(){
    parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id=''){
    if($status!=""){
        if($status=='Approved'){
            $cond=" where status='Approved'";
        }
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

    $sql = "select * from report_master".$cond;
    $result = $this->db->query($sql)->result();
    return $result;
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $data = array(
        'report_name' => $this->input->post('report_name'),
        'sender_name' => $this->input->post('sender_name'),
        'from_email' => $this->input->post('from_email'),
        'to_email' => $this->input->post('to_email'),
        'cc_email' => $this->input->post('cc_email'),
        'bcc_email' => $this->input->post('bcc_email'),
        'status' => $this->input->post('status'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('report_master',$data);
        $id=$this->db->insert_id();
        $action='Report Master Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('report_master',$data);
        $action='Report Master Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Report_Master';
    $logarray['cnt_name']='Report_Master';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_report_name_availablity(){
    $id=$this->input->post('id');
    $report_name=$this->input->post('report_name');

    // $id="6";
    // $report_name="Admin";

    $query=$this->db->query("SELECT * FROM report_master WHERE id!='".$id."' and report_name='".$report_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>