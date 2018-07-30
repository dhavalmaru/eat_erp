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


  function get_invoice($distributor_id){
   
    $sql = "select invoice_no from distributor_out where distributor_id='".$distributor_id  ."'";
    $query=$this->db->query($sql);
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

    $ref_date=$this->input->post('ref_date');
    if($ref_date==''){
        $ref_date=NULL;
    } else {
        $ref_date=formatdate($ref_date);
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
        $ref_no = $this->input->post('ref_no');
        $transaction = $this->input->post('transaction');

        $remarks = $this->input->post('remarks');
        
        if($status == 'Rejected'){
            $sql = "Update credit_debit_note Set status='$status', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Credit_debit_note Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                if($ref_no==null || $ref_no==''){
                    $sql="select * from series_master where type='Credit_debit_note'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0){
                        $series=intval($result[0]->series)+1;

                        $sql="update series_master set series = '$series' where type = 'Credit_debit_note'";
                        $this->db->query($sql);
                    } else {
                        $series=1;

                        $sql="insert into series_master (type, series) values ('Credit_debit_note', '$series')";
                        $this->db->query($sql);
                    }

                    if($ref_date==null || $ref_date==''){
                        $ref_date = date('Y-m-d');
                    }

                    if (isset($ref_date)){
                        if($ref_date==''){
                            $financial_year="";
                        } else {
                            $financial_year=calculateFiscalYearForDate($ref_date);
                        }
                    } else {
                        $financial_year="";
                    }
                    
                    if($transaction=='Credit Note'){
                        $ref_no = 'WHPL/credit_note/'.$financial_year.'/'.strval($series);
                    } else {
                        $ref_no = 'WHPL/debit_note/'.$financial_year.'/'.strval($series);
                    }
                } else {
                    if($transaction=='Credit Note'){
                        $ref_no = str_replace('debit_note', 'credit_note', $ref_no);
                    } else {
                        $ref_no = str_replace('credit_note', 'debit_note', $ref_no);
                    }
                }

                if($ref_id!=null && $ref_id!=''){
                    $sql = "Update credit_debit_note A, credit_debit_note B 
                            Set A.date_of_transaction=B.date_of_transaction, A.distributor_id=B.distributor_id, 
                                A.transaction=B.transaction, A.amount=B.amount, A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', 
                                A.ref_no='$ref_no', A.ref_date='$ref_date' 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from credit_debit_note where id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update credit_debit_note A 
                            Set A.status='$status', A.remarks='$remarks', 
                                A.approved_by='$curusr', A.approved_on='$now', 
                                A.ref_no='$ref_no', A.ref_date='$ref_date' 
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
            'invoice_no' => $this->input->post('invoice_no'),
            'distributor_type' => $this->input->post('distributor_type'),
            'amount' => format_number($this->input->post('total_amount'),2),
            'tax' => format_number($this->input->post('tax'),2),
            'igst' => format_number($this->input->post('igst'),2),
            'cgst' => format_number($this->input->post('cgst'),2),
            'sgst' => format_number($this->input->post('sgst'),2),
            'amount_without_tax' => format_number($this->input->post('amount_without_tax'),2),
            'status' => $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id,
            'ref_no' => $this->input->post('ref_no'),
            'ref_date' => $ref_date
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

function view_credit_debit_note($id) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $sql = "select * from credit_debit_note where id = '$id'";
    $query=$this->db->query($sql);
    $query_result=$query->result();
    if(count($query_result)>0){
        $final_data['credit_debit_note'] = $query_result;

        $distributor_id = $query_result[0]->distributor_id;

        $final_data['total_amount_in_words']=convert_number_to_words($query_result[0]->amount) . ' Only';

        $result = $this->distributor_model->get_data('', $distributor_id);
        $data = array();
        if(count($result)>0){
            $send_invoice = $result[0]->send_invoice;
            $class = $result[0]->class;
            $distributor_name=$result[0]->distributor_name;
            $state=$result[0]->state;
            $email_id=$result[0]->email_id;
            $mobile=$result[0]->mobile;
            $tin_number=$result[0]->tin_number;
            $cst_number=$result[0]->cst_number;
            $sales_rep_name=$result[0]->sales_rep_name;
            $state_code=$result[0]->state_code;
            $gst_number=$result[0]->gst_number;

            $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

            $data['distributor_name']=$distributor_name;
            $data['address']=$address;
            $data['tin_number']=$tin_number;
            $data['sales_rep_name']=$sales_rep_name;
            
            $data['state']=$state;
            $data['state_code']=$state_code;
            $data['gst_number']=$gst_number;
        }

        $final_data['distributor'] = $data;

        $this->load->library('parser');
        $output = $this->parser->parse('credit_debit_note/credit_debit_note.php',$final_data,true);
        $this->output->set_output($output);
    }
}



}
?>