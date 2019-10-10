<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Exp_cat_master_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Credit_Debit_Note' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from exp_cat_master".$cond." order by updated_date desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $data = array(
        'category' => $this->input->post('category'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'updated_by' => $curusr,
        'updated_date' => $now
    );
    // echo $data;
    if($id==''){
        $data['created_by']=$curusr;
        $data['created_date']=$now;

        $this->db->insert('exp_cat_master',$data);
        $id=$this->db->insert_id();
        $action='Expense Category Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('exp_cat_master',$data);
        $action='Expense Category Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Exp_Cat_Master';
    $logarray['cnt_name']='Exp_Cat_Master';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_category_availablity(){
    $id=$this->input->post('id');
    $category=$this->input->post('category');

    // $id="";

    $query=$this->db->query("select * from exp_cat_master where id!='".$id."' and category='".$category."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>