<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_target_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep_Target' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select A.*, B.sales_rep_name from 
            (select * from sales_rep_target".$cond.") A 
            left join 
            (select * from sales_rep_master) B 
            on (A.sales_rep_id=B.id) order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    
    $data = array(
        'sales_rep_id' => $this->input->post('sales_rep_id'),
        'month' => $this->input->post('month'),
        'target' => format_number($this->input->post('target'),2),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('sales_rep_target',$data);
        $id=$this->db->insert_id();
        $action='Sales Rep Target Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('sales_rep_target',$data);
        $action='Sales Rep Target Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Sales_Rep_Target';
    $logarray['cnt_name']='Sales_Rep_Target';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

}
?>