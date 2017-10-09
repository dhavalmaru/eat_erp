<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Credit_debit_note_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('tax_invoice_model');
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

    $sql = "select A.*, B.distributor_name from 
            (select * from credit_debit_note".$cond.") A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id) order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $date_of_transaction=$this->input->post('date_of_transaction');
    if($date_of_transaction==''){
        $date_of_transaction=NULL;
    } else {
        $date_of_transaction=formatdate($date_of_transaction);
    }

    $data = array(
        'date_of_transaction' => $date_of_transaction,
        'distributor_id' => $this->input->post('distributor_id'),
        'transaction' => $this->input->post('transaction'),
        'amount' => format_number($this->input->post('amount'),2),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('credit_debit_note',$data);
        $id=$this->db->insert_id();
        $action='Credit_debit_note Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('credit_debit_note',$data);
        $action='Credit_debit_note Entry Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Credit_debit_note';
    $logarray['cnt_name']='Credit_debit_note';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}
}
?>