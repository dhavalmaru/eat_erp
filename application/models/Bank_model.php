<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Bank_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('document_model');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bank_Master' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
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

    $sql = "select * from bank_master".$cond." order by modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_bank_authority($id){
    $sql = "select * from bank_authorizedsignatory where ath_bnk_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $b_bal_ref_date=$this->input->post('b_bal_ref_date');
    if($b_bal_ref_date==''){
        $b_bal_ref_date=NULL;
    } else {
        $b_bal_ref_date=formatdate($b_bal_ref_date);
    }
    
    $data = array(
        'b_name' => $this->input->post('bank_name'),
        'registered_address' => $this->input->post('registered_address'),
        'registered_phone' => $this->input->post('registered_phone'),
        'registered_email' => $this->input->post('registered_email'),
        'b_branch' => $this->input->post('bank_branch'),
        'b_address' => $this->input->post('bank_address'),
        'b_landmark' => $this->input->post('bank_landmark'),
        'b_city' => $this->input->post('bank_city'),
        'b_pincode' => $this->input->post('bank_pincode'),
        'b_state' => $this->input->post('bank_state'),
        'b_country' => $this->input->post('bank_country'),
        'b_accounttype' => $this->input->post('account_type'),
        'b_accountnumber' => $this->input->post('account_no'),
        'b_customerid' => $this->input->post('customer_id'),
        'b_ifsc' => $this->input->post('ifsc'),
        'b_micr' => $this->input->post('micr'),
        'b_relationshipmanager' => $this->input->post('relation_manager'),
        'b_phone_number' => $this->input->post('phone_no'),
        'b_openingbalance' => format_number($this->input->post('opening_balance')),
        'b_bal_ref_date' => $b_bal_ref_date,
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('bank_master',$data);
        $id=$this->db->insert_id();
        $action='Bank Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('bank_master',$data);
        $action='Bank Modified.';
    }

    $this->db->where('ath_bnk_id', $id);
    $this->db->delete('bank_authorizedsignatory');

    $ath_name=$this->input->post('auth_name[]');
    $ath_purpose=$this->input->post('auth_purpose[]');
    $ath_type=$this->input->post('auth_type[]');
    for ($i=0; $i < count($ath_name); $i++) {
        if(isset($ath_name[$i]) and $ath_name[$i]!="") {
            $data = array(
                        'ath_bnk_id' => $id,
                        'ath_name' =>  $ath_name[$i],
                        'ath_purpose' => $ath_purpose[$i],
                        'ath_type' => $ath_type[$i]
                    );
            $this->db->insert('bank_authorizedsignatory', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Bank';
    $logarray['cnt_name']='Bank';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function check_bank_availablity(){
    $id=$this->input->post('id');
    $bank_name=$this->input->post('bank_name');

    // $id="";

    $query=$this->db->query("SELECT * FROM bank_master WHERE id!='".$id."' and bank_name='".$bank_name."'");
    $result=$query->result();

    if (count($result)>0){
        return 1;
    } else {
        return 0;
    }
}

}
?>