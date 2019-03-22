<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('document_model');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from sales_rep_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data_promoter($status='', $id=''){
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

    $sql = "select * from sales_rep_master where status='Approved' and sr_type='Promoter' order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'sales_rep_name' => $this->input->post('sales_rep_name'),
        'pan_no' => $this->input->post('pan_no'),
        'email_id' => $this->input->post('email_id'),
        'mobile' => $this->input->post('mobile'),
        'kyc_done' => $this->input->post('kyc_done'),
        'teritory' => $this->input->post('teritory'),
        'target_pm' => format_number($this->input->post('target_pm'),2),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now,
        'sr_type' => $this->input->post('sr_type')
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_rep_master',$data);
        $id=$this->db->insert_id();
        $action='Sales Representative Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('sales_rep_master',$data);
        $action='Sales Representative Modified.';
    }

    $this->document_model->insert_doc($id, 'Sales_Rep');

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep';
    $logarray['cnt_name']='Sales_Rep';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    $email_id=$this->input->post('email_id');
    $query=$this->db->query("SELECT * FROM user_master WHERE email_id='".$email_id."' or sales_rep_id='".$id."'");
    $result=$query->result();
    if (count($result)==0){
        $data = array(
            'first_name' => $this->input->post('sales_rep_name'),
            'email_id' => $this->input->post('email_id'),
            'password' =>  'pass@123',
            'mobile' => $this->input->post('mobile'),
            'role_id' => '8',
            'status' => $this->input->post('status'),
            'remarks' => $this->input->post('remarks'),
            'created_by' => $curusr,
            'created_on' => $now,
            'modified_by' => $curusr,
            'modified_on' => $now,
            'sales_rep_id' => $id
        );

        $this->db->insert('user_master',$data);
        $logarray['table_id']=$this->db->insert_id();
        $logarray['module_name']='User';
        $logarray['cnt_name']='User';
        $logarray['action']='User Created.';
        $this->user_access_log_model->insertAccessLog($logarray);
    }
}

function check_sales_rep_availablity(){
    $id=$this->input->post('id');
    $sales_rep_name=$this->input->post('sales_rep_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM sales_rep_master WHERE id!='".$id."' and sales_rep_name='".$sales_rep_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

function get_sales_rep_details($date){
    $query=$this->db->query("select distinct A.sales_rep_id, B.sales_rep_name, B.email_id from sales_rep_location A left join sales_rep_master B on (A.sales_rep_id=B.id) where A.date_of_visit = '$date'");
    return $query->result();
}
}
?>