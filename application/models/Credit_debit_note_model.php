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
    $sql = "select distinct invoice_no from distributor_out where status='Approved' and distributor_id='".$distributor_id."' and invoice_no<>''";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_data_count(){
    $sql = "select count(id) as total_count, sum(case when status='Approved' then 1 else 0 end) as approved, sum(case when (status='Pending'or status='Deleted') then 1 else 0 end) as pending, sum(case when status='Rejected' then 1 else 0 end) as rejected, sum(case when status='Inactive' then 1 else 0 end) as inactive from credit_debit_note where remarks!='Adjusted through Ledger Balance'";
    $query = $this->db->query($sql);
    return $query->result();
}

function get_list_data($status='', $start=0, $length=0, $search_val=''){
    $curusr = $this->session->userdata('session_id');

    if($status!=""){
        if($status=="Pending"){
            $cond=" and A.status='Pending' or A.status='Deleted'";
        } else{
            $cond=" and A.status='".$status."'";
        }
    } else {
        $cond="";
    }

    $cond2="";
    if($search_val!=''){
        $cond2=" and (A.id like '%".$search_val."%' or DATE_FORMAT(A.date_of_transaction, '%d/%m/%Y') like '%".$search_val."%' or A.ref_no like '%".$search_val."%' or A.transaction like '%".$search_val."%' or A.amount like '%".$search_val."%' or A.remarks like '%".$search_val."%' or B.distributor_name like '%".$search_val."%')";
    }

    $data = array();

    $sql = "select count(A.id) as total_records from credit_debit_note A left join distributor_master B on (A.distributor_id=B.id) where A.remarks!='Adjusted through Ledger Balance' ".$cond.$cond2;
    $query=$this->db->query($sql);
    $data['count']=$query->result();

    $limit = "";
    if($start>0 && $length>0) $limit .= " limit ".$start.", ".$length;
    elseif($length>0) $limit .= " limit ".$length;

    $sql = "select A.id, A.date_of_transaction, A.ref_no, B.distributor_name, A.transaction, A.amount, A.remarks 
            from credit_debit_note A 
            left join distributor_master B on (A.distributor_id=B.id) 
            where A.remarks!='Adjusted through Ledger Balance' ".$cond.$cond2." 
            order by A.modified_on desc ".$limit;
    $query=$this->db->query($sql);
    $data['rows']=$query->result();

    return $data;
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
            on (A.distributor_id=B.id)
            Where A.remarks!='Adjusted through Ledger Balance'
            order by A.modified_on desc";
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
                $reference = '';
                if($transaction=='Credit Note'){
                    // $reference = 'credit_note';
                    $reference = 'CN';
                } else if($transaction=='Debit Note'){
                    // $reference = 'debit_note';
                    $reference = 'DN';
                } else if($transaction=='Expense Voucher'){
                    // $reference = 'exp';
                    $reference = 'EXP';
                } else {
                    // $reference = 'exp_rev';
                    $reference = 'EXPREV';
                }

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
                            if(strpos($financial_year,'-')!==false){
                                $financial_year = substr($financial_year, 0, strpos($financial_year,'-')-1);
                            }
                        }
                    } else {
                        $financial_year="";
                    }
                    
                    // $ref_no = 'WHPL/'.$reference.'/'.$financial_year.'/'.strval($series);
                    $ref_no = 'WHPL/'.$financial_year.'-'.$reference.'/'.strval($series);
                } else {
                    // if($transaction=='Credit Note'){
                    //     $ref_no = str_replace('debit_note', 'credit_note', $ref_no);
                    // } else {
                    //     $ref_no = str_replace('credit_note', 'debit_note', $ref_no);
                    // }

                    $str1 = substr($ref_no, 0, strpos($ref_no, '/')+1);
                    $str2 = substr($ref_no, strpos($ref_no, '/')+1);
                    $str2 = substr($str2, strpos($str2, '/'));

                    $ref_no = $str1.$reference.$str2;
                }

                if($ref_id!=null && $ref_id!=''){
                    $modified_approved_date = NULL;
                    $get_modified_approved_date_result = $this->db->select('modified_approved_date')->where('id',$id)->get('credit_debit_note')->result();

                    if(count($get_modified_approved_date_result)>0){
                       $modified_approved_date = $get_modified_approved_date_result[0]->modified_approved_date;
                        
                        if($modified_approved_date!=null && $modified_approved_date!=""){
                            $modified_approved_date = date("Y-m-d");
                        } else {
                            $modified_approved_date = NULL;
                        }
                    } else {
                       $modified_approved_date = NULL;
                    }

                    if($modified_approved_date!=null && $modified_approved_date!=""){
                        $sql = "Update credit_debit_note A, credit_debit_note B 
                            Set A.date_of_transaction=B.date_of_transaction, A.distributor_id=B.distributor_id, 
                                A.transaction=B.transaction, A.amount=B.amount, A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', A.ref_no='$ref_no', 
                                A.ref_date='$ref_date', A.modified_approved_date='$modified_approved_date', 
                                A.amount_without_tax=B.amount_without_tax, A.tax=B.tax, 
                                A.igst=B.igst, A.cgst=B.cgst, A.sgst=B.sgst, A.distributor_type=B.distributor_type, 
                                A.invoice_no=B.invoice_no, A.freezed=B.freezed, A.distributor_out_id=B.distributor_out_id, 
                                A.distributor_in_id=B.distributor_in_id, A.exp_category_id=B.exp_category_id 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    } else {
                        $sql = "Update credit_debit_note A, credit_debit_note B 
                            Set A.date_of_transaction=B.date_of_transaction, A.distributor_id=B.distributor_id, 
                                A.transaction=B.transaction, A.amount=B.amount, A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now', A.ref_no='$ref_no', 
                                A.ref_date='$ref_date', A.modified_approved_date=NULL, 
                                A.amount_without_tax=B.amount_without_tax, A.tax=B.tax, 
                                A.igst=B.igst, A.cgst=B.cgst, A.sgst=B.sgst, A.distributor_type=B.distributor_type, 
                                A.invoice_no=B.invoice_no, A.freezed=B.freezed, A.distributor_out_id=B.distributor_out_id, 
                                A.distributor_in_id=B.distributor_in_id, A.exp_category_id=B.exp_category_id 
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    }
                    
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

                echo '<script>var win=window.open("'.base_url().'index.php/credit_debit_note/view_credit_debit_note/'.$id.'");
                    win.print();
                    </script>';
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
            'remarks' => str_replace("'", "", $this->input->post('remarks')),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id,
            'ref_no' => $this->input->post('ref_no'),
            'ref_date' => $ref_date,
            'exp_category_id' => $this->input->post('exp_category_id')
        );

        $date_p=strtotime($date_of_transaction);
        $current_d=strtotime($now);

        if($ref_id!=null && $ref_id!="")
        {
            $data['modified_approved_date']=$now;
        }

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

    $sql = "select A.*, concat(B.first_name, ' ', B.last_name) as createdby, 
                concat(C.first_name, ' ', C.last_name) as modifiedby, 
                concat(D.first_name, ' ', D.last_name) as approvedby 
            from credit_debit_note A 
            left join user_master B on(A.created_by=B.id) 
            left join user_master C on(A.modified_by=C.id) 
            left join user_master D on(A.approved_by=D.id) 
            where A.id = '$id'";
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