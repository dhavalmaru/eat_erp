<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class AccountLedger_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Acc_Ledger' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data($status='', $id='', $class=''){
    if($status!=""){
        $cond=" where status='".$status."'";
    } else {
        $cond="";
    }

    $sql = "select * from account_group_master ".$cond." order by group_name";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_ledger_data($status='', $id='', $class=''){
    if($status!=""){
        $cond=" where status='".$status."'";
    } else {
        $cond="";
    }

    if($id!="") {
        if($cond=="") {
            $cond=" where id='".$id."'";
        } else {
            $cond=$cond." and id='".$id."'";
        }
    }

    
    $sql = "select D.*, E.group_name from 
            (select * from 
            ((select id, ledger_name, opening_balance, trans_type, fk_group_id, status, ledger_type 
                from account_ledger_master)) C ".$cond.") D 
            left join 
            (select * from account_group_master) E 
            on (D.fk_group_id=E.id) order by D.ledger_name asc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_distributor_contacts($id){
    $sql = "select * from distributor_contacts where distributor_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id='') {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $data = array(
        'ledger_name' => $this->input->post('ledger_name'),
        'fk_group_id' => $this->input->post('fk_group_id'),
        'opening_balance' => $this->input->post('opening_balance'),
        'trans_type' => $this->input->post('trans_type'),
        'ledger_type' => $this->input->post('ledger_type'),
        'updated_by' => $curusr,
        'updated_date' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_date']=$now;
        $data['status']='Pending';

        $this->db->insert('account_ledger_master',$data);
        $id=$this->db->insert_id();
        $action='Ledger Created.';
    } else {
        $data['status']=$this->input->post('status');

        $this->db->where('id', $id);
        $this->db->update('account_ledger_master',$data);
        $action='Ledger Modified.';
    }

    

    $logarray['table_id']=$id;
    $logarray['module_name']='Accounting Ledger';
    $logarray['cnt_name']='Accounting Ledger';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_ledger_availablity(){
    $id=$this->input->post('id');
    $ledger_name=$this->input->post('ledger_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM account_ledger_master WHERE id!='".$id."' and ledger_name='".$ledger_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

function set_ledger($ref_id, $ref_type, $ledger_name){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $group_id = '';
    $group_name = '';

    if($ref_type=='Distributor'){
        $group_id = '9';
        $group_name = 'Current Asset';
    }

    $data = array(
        'ledger_name' => $ledger_name,
        'ref_id' => $ref_id,
        'ref_type' => $ref_type,
        'status' => 'Approved',
        'updated_by' => $curusr,
        'updated_date' => $now
    );

    $sql = "select * from account_ledger_master where ref_id = '$ref_id' and ref_type = '$ref_type'";
    $query = $this->db->query($sql);
    $result = $query->result();

    if(count($result)==0){
        $data['fk_group_id']=$group_id;
        $data['ledger_type']=$group_name;
        $data['created_by']=$curusr;
        $data['created_date']=$now;

        $this->db->insert('account_ledger_master',$data);
        $id=$this->db->insert_id();
        $action='Ledger Created.';
    } else {
        $id=$result[0]->id;

        $this->db->where('id', $id);
        $this->db->update('account_ledger_master',$data);
        $action='Ledger Modified.';
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Accounting Ledger';
    $logarray['cnt_name']='Accounting Ledger';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}
}
?>