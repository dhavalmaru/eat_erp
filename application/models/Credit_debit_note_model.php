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
        if($status=="Pending"){
            $cond=" where status='Pending' or status='Deleted'";
        } else{
            $cond=" where status='".$status."'";
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

    $sql = "select A.*, B.distributor_name from 
            (select * from credit_debit_note".$cond.") A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id=B.id) order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM credit_debit_note WHERE ref_id = '$id' and status!='InActive'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
    }

    return $id;
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $action='';

    $date_of_transaction=$this->input->post('date_of_transaction');
    if($date_of_transaction==''){
        $date_of_transaction=NULL;
    } else {
        $date_of_transaction=formatdate($date_of_transaction);
    }

    if($this->input->post('btn_approve')!=null || $this->input->post('btn_reject')!=null){
        if($this->input->post('btn_approve')!=null){
            if($this->input->post('status')=="Deleted"){
                $status = 'InActive';
            } else {
                $status = 'Approved';
            }
        } else {
            $status = 'Rejected';
        }

        $ref_id = $this->input->post('ref_id');

        $remarks = $this->input->post('remarks');
        
        if($status == 'Rejected'){
            $sql = "Update credit_debit_note Set status='$status', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Credit_debit_note Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                if($ref_id!=null && $ref_id!=''){
                    $sql = "Update credit_debit_note A, credit_debit_note B 
                            Set A.date_of_transaction=B.date_of_transaction, A.distributor_id=B.distributor_id, 
                                A.transaction=B.transaction, A.amount=B.amount, A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from credit_debit_note where id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update credit_debit_note A 
                            Set A.status='$status', A.remarks='$remarks', 
                                A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }
                $action='Credit_debit_note Entry '.$status.'.';
            }
        }
    } else {
        if($this->input->post('btn_delete')!=null){
            if($this->input->post('status')=="Approved"){
                $status = 'Deleted';
            } else {
                $status = 'InActive';
            }
        } else {
            $status = 'Pending';
        }

        if($this->input->post('status')=="Approved"){
            $ref_id = $id;
            $id = '';
        } else {
            $ref_id = $this->input->post('ref_id');
        }

        if($ref_id==""){
            $ref_id = null;
        }

        $data = array(
            'date_of_transaction' => $date_of_transaction,
            'distributor_id' => $this->input->post('distributor_id'),
            'transaction' => $this->input->post('transaction'),
            'amount' => format_number($this->input->post('amount'),2),
            'status' => $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id
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
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Credit_debit_note';
    $logarray['cnt_name']='Credit_debit_note';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}
}
?>