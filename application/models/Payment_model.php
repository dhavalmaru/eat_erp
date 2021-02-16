<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Payment_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('tax_invoice_model');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Payment' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data_count(){
    $sql = "select count(id) as total_count, sum(case when status='Approved' then 1 else 0 end) as approved, sum(case when (status='Pending'or status='Deleted') then 1 else 0 end) as pending, sum(case when status='Rejected' then 1 else 0 end) as rejected, sum(case when status='Inactive' then 1 else 0 end) as inactive from payment_details";
    $query = $this->db->query($sql);
    return $query->result();
}

function get_list_data($status='', $start=0, $length=0, $search_val=''){
    $curusr = $this->session->userdata('session_id');

    if($status!=""){
        if($status=="Pending"){
            $cond=" where A.status='Pending' or A.status='Deleted'";
        } else{
            $cond=" where A.status='".$status."'";
        }
    } else {
        $cond="";
    }

    $cond2="";
    if($search_val!=''){
        // $cond2=" and (E.id like '%".$search_val."%' or DATE_FORMAT(E.date_of_deposit, '%d/%m/%Y') like '%".$search_val."%' or E.b_name like '%".$search_val."%' or E.total_amount like '%".$search_val."%' or F.distributor_name like '%".$search_val."%') and F.distributor_name is not null and F.distributor_name<>''";

        $cond2=" where (G.id like '%".$search_val."%' or DATE_FORMAT(G.date_of_deposit, '%d/%m/%Y') like '%".$search_val."%' or G.b_name like '%".$search_val."%' or G.total_amount like '%".$search_val."%' or G.distributor_name like '%".$search_val."%')";
    }

    $data = array();

    $sql = "select count(G.id) as total_records from 
            (select E.*, F.distributor_name from 
            (select C.*, D.b_name from 
            (select A.id, A.date_of_deposit, A.bank_id, A.total_amount, A.modified_on 
            from payment_details A ".$cond.") C 
            left join 
            (select * from bank_master) D 
            on (C.bank_id=D.id)) E 
            left join 
            (select A.payment_id, group_concat(B.distributor_name) as distributor_name from payment_details_items A 
                left join distributor_master B on(A.distributor_id = B.id) group by A.payment_id) F 
            on (E.id = F.payment_id)) G".$cond2;
    $query=$this->db->query($sql);
    $data['count']=$query->result();

    $limit = "";
    if($start>0 && $length>0) $limit .= " limit ".$start.", ".$length;
    elseif($length>0) $limit .= " limit ".$length;
    if($search_val!=''){
        $cond2 = $cond2 . " order by G.modified_on desc ".$limit;
    } else {
        $cond = $cond . " order by A.modified_on desc ".$limit;
    }

    $sql = "select G.* from 
            (select E.*, F.distributor_name from 
            (select C.*, D.b_name from 
            (select A.id, A.date_of_deposit, A.bank_id, A.status, A.total_amount, A.modified_on 
            from payment_details A ".$cond.") C 
            left join 
            (select * from bank_master) D 
            on (C.bank_id=D.id)) E 
            left join 
            (select C.payment_id, group_concat(C.distributor_name) as distributor_name from 
            (select distinct A.payment_id, B.distributor_name from payment_details_items A 
                left join distributor_master B on(A.distributor_id = B.id)) C group by C.payment_id) F 
            on (E.id = F.payment_id)) G".$cond2;

    // $sql = "select E.*, F.distributor_name from 
    //         (select C.*, D.b_name from 
    //         (select A.id, A.date_of_deposit, A.bank_id, A.status, A.total_amount, A.modified_on 
    //         from payment_details A where A.id is not null ".$cond.") C 
    //         left join 
    //         (select * from bank_master) D 
    //         on (C.bank_id=D.id)) E 
    //         left join 
    //         (select A.payment_id, group_concat(B.distributor_name) as distributor_name from payment_details_items A 
    //             left join distributor_master B on(A.distributor_id = B.id) group by A.payment_id) F 
    //         on (E.id = F.payment_id)".$cond2." 
    //         order by E.modified_on desc ".$limit;
    $query=$this->db->query($sql);
    $data['rows']=$query->result();

    return $data;
}

function get_data($status='', $id=''){
    if($status!=""){
        if($status=="Pending"){
            $cond=" where A.status='Pending' or A.status='Deleted'";
        } else{
            $cond=" where A.status='".$status."'";
        }
    } else {
        $cond="";
    }

    if($id!=""){
        if($cond=="") {
            $cond=" where A.id='".$id."'";
        } else {
            $cond=$cond." and A.id='".$id."'";
        }
    }

    $sql = "select E.*, F.distributor_name from 
            (select C.*, D.b_name, D.b_branch from 
            (select A.*, concat(B.first_name, ' ', B.last_name) as createdby, 
                concat(C.first_name, ' ', C.last_name) as modifiedby, 
                concat(D.first_name, ' ', D.last_name) as approvedby 
            from payment_details A 
            left join user_master B on(A.created_by=B.id) 
            left join user_master C on(A.modified_by=C.id) 
            left join user_master D on(A.approved_by=D.id) ".$cond.") C 
            left join 
            (select * from bank_master) D 
            on (C.bank_id=D.id)) E 
            left join 
            (select A.payment_id, group_concat(B.distributor_name) as distributor_name from payment_details_items A 
                left join distributor_master B on(A.distributor_id = B.id) group by A.payment_id) F 
            on (E.id = F.payment_id) 
            order by E.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM payment_details WHERE ref_id = '$id' and status!='InActive'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
    }

    return $id;
}

function get_payment_items($id){
    $sql = "select * from payment_details_items where payment_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_payment_slip_denomination($id){
    $sql = "select * from payment_slip_denomination where payment_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_total_outstanding($id, $distributor_id, $module){
    $payment_cond="";
    if($module=="payment"){
        $payment_cond=" and id<>'$id' ";
    }
    
    $credit_debit_note_cond="";
    if($module=="credit_debit_note"){
        $credit_debit_note_cond=" and id<>'$id' ";
    }

    $sql = "select A.distributor_id, sum((ifnull(A.total_amount,0)-ifnull(C.paid_amount,0))) as total_outstanding from 
            (select distributor_id, sum(invoice_amount) as total_amount from distributor_out 
                where status = 'Approved' and distributor_id = '$distributor_id' group by distributor_id) A 
            left join 
            (select B.distributor_id, sum(B.paid_amount) as paid_amount from 
            (select distributor_id, sum(payment_amount) as paid_amount from payment_details_items 
                where distributor_id = '$distributor_id' and payment_id in (select distinct id from payment_details 
                where status = 'Approved' ".$payment_cond.") group by distributor_id 
            union all 
            select distributor_id, sum(case when transaction = 'Debit Note' then (amount*-1) else amount end) as paid_amount from credit_debit_note 
                where status = 'Approved' and distributor_id = '$distributor_id' ".$credit_debit_note_cond." group by distributor_id 
            union all 
            select distributor_id, sum(final_amount) as paid_amount from distributor_in 
                where status = 'Approved' and distributor_id = '$distributor_id' group by distributor_id) B 
            group by B.distributor_id) C 
            on (A.distributor_id=C.distributor_id) 
            group by A.distributor_id";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_invoice_nos($id, $distributor_id){
    $sql = "select * from 
            (select A.distributor_id, A.invoice_no, (ifnull(A.invoice_amount,0)-ifnull(B.tot_payment_amount,0)) as bal_amount from 
            (select * from distributor_out where status = 'Approved' and distributor_id = '$distributor_id') A 
            left join 
            (select distributor_id, invoice_no, sum(payment_amount) as tot_payment_amount from payment_details_items 
                where distributor_id = '$distributor_id' and payment_id in (select distinct id from payment_details 
                    where status = 'Approved' and id <> '$id') group by distributor_id, invoice_no) B 
            on (A.distributor_id=B.distributor_id and A.invoice_no=B.invoice_no)) C 
            where C.bal_amount > 0";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_invoice_details($id, $invoice_no){
    $sql = "select * from 
            (select A.distributor_id, A.invoice_no, A.client_name, 
                (ifnull(A.invoice_amount,0)-ifnull(B.tot_payment_amount,0)) as final_amount from 
            (select * from distributor_out where status = 'Approved' and invoice_no = '$invoice_no') A 
            left join 
            (select distributor_id, invoice_no, sum(payment_amount) as tot_payment_amount from payment_details_items 
                where invoice_no = '$invoice_no' and payment_id in (select distinct id from payment_details 
                    where status = 'Approved' and id <> '$id') group by distributor_id, invoice_no) B 
            on (A.distributor_id=B.distributor_id and A.invoice_no=B.invoice_no)) C";
    $query=$this->db->query($sql);
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $action='';

    $date_of_deposit=$this->input->post('date_of_deposit');
    if($date_of_deposit==''){
        $date_of_deposit=NULL;
    } else {
        $date_of_deposit=formatdate($date_of_deposit);
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
        $file_id = $this->input->post('file_id');

        $remarks = $this->input->post('remarks');

        if($status == 'Rejected'){
            $sql = "Update payment_details Set status='$status', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Payment Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                if($ref_id!=null && $ref_id!=''){

                    $modified_approved_date = NULL;
                    $get_modified_approved_date_result = $this->db->select('modified_approved_date')->where('id',$id)->get('payment_details')->result();

                    if(count($get_modified_approved_date_result)>0)
                    {
                       $modified_approved_date = $get_modified_approved_date_result[0]->modified_approved_date;
                        
                        if($modified_approved_date!=null && $modified_approved_date!="")
                        {
                            $modified_approved_date = date("Y-m-d");
                        }else
                        {
                            $modified_approved_date = NULL;
                        }
                    }
                    else
                    {
                       $modified_approved_date = NULL;
                    }

                    if($modified_approved_date!=null && $modified_approved_date!=null)
                    {
                        $sql = "Update payment_details A, payment_details B 
                            Set A.date_of_deposit=B.date_of_deposit, A.bank_id=B.bank_id, A.payment_mode=B.payment_mode,
                                A.total_amount=B.total_amount, A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now',A.modified_approved_date='$modified_approved_date'
                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    }
                    else
                    {
                         $sql = "Update payment_details A, payment_details B 
                            Set A.date_of_deposit=B.date_of_deposit, A.bank_id=B.bank_id, A.payment_mode=B.payment_mode,
                                A.total_amount=B.total_amount, A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by, A.modified_on=B.modified_on, 
                                A.approved_by='$curusr', A.approved_on='$now',A.modified_approved_date=NULL

                            WHERE A.id = '$ref_id' and B.id = '$id'";
                    }
                   
                    $this->db->query($sql);

                    $sql = "Delete from payment_details where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from payment_details_items WHERE payment_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update payment_details_items set payment_id='$ref_id' WHERE payment_id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from payment_slip_denomination WHERE payment_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update payment_slip_denomination set payment_id='$ref_id' WHERE payment_id = '$id'";
                    $this->db->query($sql);

                    $sql = "Update payment_upload_details Set status='$status', approved_by='$curusr', approved_on='$now' where file_id = '$file_id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update payment_details A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $this->generate_credit_debit_note($id, $status);

                $action='Payment Entry '.$status.'.';
                echo '<script>
                var win = window.open("'.base_url().'index.php/payment/view_payment_slip/'.$id.'");
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

        $file_id = $this->input->post('file_id');

        if($file_id==""){
            $file_id = null;
        }

        $data = array(
            'date_of_deposit' => $date_of_deposit,
            'bank_id' => $this->input->post('bank_id'),
            'payment_mode' => $this->input->post('payment_mode'),
            'total_amount' => format_number($this->input->post('total_amount'),2),
            'status' => $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id,
            'file_id' => $file_id
        );

        $date_p=strtotime($date_of_deposit);
        $current_d=strtotime($now);

        if($ref_id!=null && $ref_id!="")
        {
            $data['modified_approved_date']=$now;
        }

        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            if($this->input->post('status')=="Approved"){
                $action='Payment Entry Modified.';
            } else {
                $action='Payment Entry Created.';
            }

            $this->db->insert('payment_details',$data);
            $id=$this->db->insert_id();

        } else {
            $this->db->where('id', $id);
            $this->db->update('payment_details',$data);
            $action='Payment Entry Modified.';
        }

        $this->db->where('payment_id', $id);
        $this->db->delete('payment_details_items');

        $distributor_id=$this->input->post('distributor_id[]');
        $ref_no=$this->input->post('ref_no[]');
        $bank_name=$this->input->post('bank_name[]');
        $bank_city=$this->input->post('bank_city[]');
        $invoice_no=$this->input->post('invoice_no[]');
        $payment_amount=$this->input->post('payment_amount[]');
        $settlement_id=$this->input->post('settlement_id[]');
        $settlement_start_date=$this->input->post('settlement_start_date[]');
        $settlement_end_date=$this->input->post('settlement_end_date[]');
        $credit_debit=$this->input->post('credit_debit[]');
        $tax=$this->input->post('tax[]');
        $narration=$this->input->post('narration[]');

        for($k=0; $k<count($distributor_id); $k++) {
            if(isset($distributor_id[$k]) and $distributor_id[$k]!="") {
                $payment_amt = format_number($payment_amount[$k],2);
                // $credit_debit_val = '';
                // $narration_val = '';

                // if($payment_amt<0){
                //     $credit_debit_val = $credit_debit[$k];
                //     $narration_val = $narration[$k];
                // }

                $data = array(
                            'payment_id' => $id,
                            'distributor_id' => $distributor_id[$k],
                            'ref_no' => $ref_no[$k],
                            'bank_name' => $bank_name[$k],
                            'bank_city' => $bank_city[$k],
                            'invoice_no' => $invoice_no[$k],
                            'payment_amount' => format_number($payment_amount[$k],2),
                            'settlement_id' => $settlement_id[$k],
                            'settlement_start_date' => (($settlement_start_date[$k]=='')? Null: $settlement_start_date[$k]),
                            'settlement_end_date' => (($settlement_end_date[$k]=='')? Null: $settlement_end_date[$k]),
                            'credit_debit' => $credit_debit[$k],
                            'tax' => $tax[$k],
                            'narration' => $narration[$k]
                        );
                $this->db->insert('payment_details_items', $data);
            }
        }

        $this->db->where('payment_id', $id);
        $this->db->delete('payment_slip_denomination');

        if($this->input->post('payment_mode')=='Cash'){
            $data = array(
                'payment_id' => $id,
                'denomination_2000' => ($this->input->post('denomination_2000')=='')?null:$this->input->post('denomination_2000'),
                'denomination_1000' => ($this->input->post('denomination_1000')=='')?null:$this->input->post('denomination_1000'),
                'denomination_500' => ($this->input->post('denomination_500')=='')?null:$this->input->post('denomination_500'),
                'denomination_100' => ($this->input->post('denomination_100')=='')?null:$this->input->post('denomination_100'),
                'denomination_50' => ($this->input->post('denomination_50')=='')?null:$this->input->post('denomination_50'),
                'denomination_20' => ($this->input->post('denomination_20')=='')?null:$this->input->post('denomination_20'),
                'denomination_10' => ($this->input->post('denomination_10')=='')?null:$this->input->post('denomination_10'),
                'denomination_other' => ($this->input->post('denomination_other')=='')?null:$this->input->post('denomination_other'),
                'denomination_other_amount' => ($this->input->post('denomination_other_amount')=='')?null:$this->input->post('denomination_other_amount')
            );
            $this->db->insert('payment_slip_denomination',$data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Payment';
    $logarray['cnt_name']='Payment';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function generate_credit_debit_note($id='', $status=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $action='';

    // $date_of_transaction=$this->input->post('date_of_deposit');
    // if($date_of_transaction==''){
    //     $date_of_transaction=NULL;
    // } else {
    //     $date_of_transaction=formatdate($date_of_transaction);
    // }

    $date_of_transaction=date('Y-m-d');
    $upload_type='';

    $sql = "select * from payment_details where id = '$id'";
    $result = $this->db->query($sql)->result();
    if(count($result)>0){
        $date_of_transaction=$result[0]->date_of_deposit;
        $upload_type=$result[0]->upload_type;
    }
    
    $ref_date='';

    // echo '1';
    // echo '<br/><br/>';

    if($status!=''){
        // echo $status;
        // echo '<br/><br/>';

        if($status!='Approved'){
            $sql = "Update credit_debit_note Set status='$status', approved_by='$curusr', approved_on='$now' where payment_id = '$id'";
            $this->db->query($sql);

            // $action='Credit_debit_note Entry '.$status.'.';
        } else {
            $sql = "Update credit_debit_note Set status='InActive', remarks = concat(remarks, ' System generated update for payment entry modification.'), approved_by='$curusr', approved_on='$now' where payment_id = '$id'";
            $this->db->query($sql);

            // $distributor_id=$this->input->post('distributor_id[]');
            // $ref_no=$this->input->post('ref_no[]');
            // $bank_name=$this->input->post('bank_name[]');
            // $bank_city=$this->input->post('bank_city[]');
            // $invoice_no=$this->input->post('invoice_no[]');
            // $payment_amount=$this->input->post('payment_amount[]');
            // $settlement_id=$this->input->post('settlement_id[]');
            // $settlement_start_date=$this->input->post('settlement_start_date[]');
            // $settlement_end_date=$this->input->post('settlement_end_date[]');
            // $credit_debit=$this->input->post('credit_debit[]');
            // $tax=$this->input->post('tax[]');
            // $narration=$this->input->post('narration[]');

            $sql = "select * from payment_details_items where payment_id = '$id'";
            $result = $this->db->query($sql)->result();

            // echo count($result);
            // echo '<br/><br/>';
        
            if(count($result)>0){
                for($k=0; $k<count($result); $k++) {
                    $distributor_id=$result[$k]->distributor_id;
                    $ref_no=$result[$k]->ref_no;
                    $bank_name=$result[$k]->bank_name;
                    $bank_city=$result[$k]->bank_city;
                    $invoice_no=$result[$k]->invoice_no;
                    $payment_amount=$result[$k]->payment_amount;
                    $settlement_id=$result[$k]->settlement_id;
                    $settlement_start_date=$result[$k]->settlement_start_date;
                    $settlement_end_date=$result[$k]->settlement_end_date;
                    $credit_debit=$result[$k]->credit_debit;
                    $tax=$result[$k]->tax;
                    $narration=$result[$k]->narration;
                    $commission=$result[$k]->commission;
                    $gst=$result[$k]->gst;
                    $unique_ref_no=$result[$k]->unique_ref_no;
                    
                    if(isset($distributor_id) && $distributor_id!="") {
                        $payment_amt = format_number($payment_amount,2);
                        // $credit_debit_val = '';
                        // $narration_val = '';

                        // if($payment_amt<0){
                        //     $credit_debit_val = $credit_debit;
                        //     $narration_val = $narration;
                        // }

                        if(strtoupper(trim($credit_debit))=='YES'){
                            if($upload_type=='Paytm' || $upload_type=='Razorpay'){
                                $transaction = 'Credit Note';
                                $reference = 'CN';
                            } else {
                                if($payment_amt<0){
                                    $transaction = 'Credit Note';
                                    $reference = 'CN';
                                    $payment_amt = $payment_amt*-1;
                                } else {
                                    $transaction = 'Debit Note';
                                    $reference = 'DN';
                                }
                            }

                            $sql="select * from series_master where type='Credit_debit_note'";
                            $query=$this->db->query($sql);
                            $result2=$query->result();
                            if(count($result2)>0){
                                $series=intval($result2[0]->series)+1;

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

                            if($invoice_no=='On Account'){
                                $distributor_type = 'Promotion';
                                $inv_no = '';
                            } else {
                                $distributor_type = 'Invoice';
                                $inv_no = $invoice_no;
                            }

                            if($upload_type=='Paytm' || $upload_type=='Razorpay'){
                                if(strtoupper(trim($tax))=='YES'){
                                    $tax = round($gst,2);
                                    $amount = round($commission,2);
                                    $igst = 0;
                                    $cgst = 0;
                                    $sgst = 0;

                                    $state_code = '';
                                    $sql="select * from distributor_master where id='$distributor_id'";
                                    $query=$this->db->query($sql);
                                    $result2=$query->result();
                                    if(count($result2)>0){
                                        $state_code=$result2[0]->state_code;
                                    }

                                    if($state_code=='27'){
                                        $cgst = round($tax/2,2);
                                        $sgst = round($tax/2,2);
                                    } else {
                                        $igst = round($tax,2);
                                    }
                                } else {
                                    $tax = 0;
                                    $amount = round($commission,2);
                                    $igst = 0;
                                    $cgst = 0;
                                    $sgst = 0;
                                }

                                $payment_amt = $amount + $tax;
                            } else {
                                if(strtoupper(trim($tax))=='YES'){
                                    $tax = 18;
                                    $amount = round($payment_amt/1.18,2);
                                    $igst = 0;
                                    $cgst = 0;
                                    $sgst = 0;

                                    $state_code = '';
                                    $sql="select * from distributor_master where id='$distributor_id'";
                                    $query=$this->db->query($sql);
                                    $result2=$query->result();
                                    if(count($result2)>0){
                                        $state_code=$result2[0]->state_code;
                                    }

                                    if($state_code=='27'){
                                        $cgst = round($amount*($tax/2)/100,2);
                                        $sgst = round($amount*($tax/2)/100,2);
                                    } else {
                                        $igst = round($amount*$tax/100,2);
                                    }
                                } else {
                                    $tax = 0;
                                    $amount = round($payment_amt,2);
                                    $igst = 0;
                                    $cgst = 0;
                                    $sgst = 0;
                                }
                            }

                            $data = array(
                                        'date_of_transaction' => $date_of_transaction,
                                        'distributor_id' => $distributor_id,
                                        'transaction' => $transaction,
                                        'invoice_no' => $inv_no,
                                        'distributor_type' => $distributor_type,
                                        'amount' => $payment_amt,
                                        'tax' => $tax,
                                        'igst' => $igst,
                                        'cgst' => $cgst,
                                        'sgst' => $sgst,
                                        'amount_without_tax' => $amount,
                                        'status' => $status,
                                        'remarks' => str_replace("'", "", $narration),
                                        'created_by' => $curusr,
                                        'created_on' => $now,
                                        'modified_by' => $curusr,
                                        'modified_on' => $now,
                                        'approved_by' => $curusr,
                                        'approved_on' => $now,
                                        // 'ref_id' => $ref_id,
                                        'ref_no' => $ref_no,
                                        'ref_date' => $ref_date,
                                        'exp_category_id' => '6',
                                        'payment_id' => $id
                                    );

                            // echo json_encode($data);
                            // echo '<br/><br/>';

                            $this->db->insert('credit_debit_note',$data);
                            $credit_debit_note_id=$this->db->insert_id();
                            $action='Credit_debit_note Entry Created By System For Payment.';
                    
                            $logarray['table_id']=$credit_debit_note_id;
                            $logarray['module_name']='Credit_debit_note';
                            $logarray['cnt_name']='Credit_debit_note';
                            $logarray['action']=$action;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        }
                    }
                }
            }
        }
    }
}

function generate_payment_slip($id) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $data['id']=$id;

    $result=$this->get_data('', $id);
    if(count($result)>0){
        $date_of_deposit=$result[0]->date_of_deposit;
        $total_amount=floatval($result[0]->total_amount);
        $b_name=$result[0]->b_name;
        $b_branch=$result[0]->b_branch;
        $createdby=$result[0]->createdby;
        $modifiedby=$result[0]->modifiedby;
        $approvedby=$result[0]->approvedby;
        $approved_on=$result[0]->approved_on;
        $modified_on=$result[0]->modified_on;
        $created_on=$result[0]->created_on;
    } else {
        $date_of_deposit=null;
        $total_amount=0;
        $b_name='';
        $b_branch='';
    }
    $data['total_amount']=round($total_amount,2);
    $data['date_of_deposit']=$date_of_deposit;
    $data['total_amount_in_words']=convert_number_to_words($total_amount) . ' Only';
    $data['b_name']=$b_name;
    $data['b_branch']=$b_branch;
    $data['createdby']=$createdby;
    $data['modifiedby']=$modifiedby;
    $data['approvedby']=$approvedby;
    $data['approved_on']=$approved_on;
    $data['modified_on']=$modified_on;
    $data['created_on']=$created_on;

    if(isset($date_of_deposit) && $date_of_deposit!=''){
        $y1=substr($date_of_deposit, 0, 1);
        $y2=substr($date_of_deposit, 1, 1);
        $y3=substr($date_of_deposit, 2, 1);
        $y4=substr($date_of_deposit, 3, 1);

        $m1=substr($date_of_deposit, 5, 1);
        $m2=substr($date_of_deposit, 6, 1);

        $d1=substr($date_of_deposit, 8, 1);
        $d2=substr($date_of_deposit, 9, 1);
    } else {
        $y1="";
        $y2="";
        $y3="";
        $y4="";

        $m1="";
        $m2="";

        $d1="";
        $d2="";
    }
    
    $data['y1']=$y1;
    $data['y2']=$y2;
    $data['y3']=$y3;
    $data['y4']=$y4;

    $data['m1']=$m1;
    $data['m2']=$m2;

    $data['d1']=$d1;
    $data['d2']=$d2;

    $sql = "select A.payment_mode, A.date_of_deposit, case when A.payment_mode='Cash' then null else B.ref_no end as cheque_no, 
                    B.id, B.payment_id, B.ref_no, case when A.payment_mode='Cheque' then B.bank_name else null end as bank_name, 
                    case when A.payment_mode='Cheque' then B.bank_city else null end as bank_city, B.invoice_no, 
                    B.payment_amount, A.status, A.remarks, A.created_by, A.created_on, A.modified_by, A.modified_on, 
                    A.approved_by, A.approved_on, A.rejected_by, A.rejected_on from 
            (select * from payment_details where id = '$id') A 
            left join 
            (select * from payment_details_items where payment_id = '$id') B 
            on (A.id = B.payment_id)";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $data['items']=$result;

        if($result[0]->payment_mode=='Cash'){
            $data['denomination'] = $this->get_payment_slip_denomination($id);
        }
    }

    $sql = "select A.*, B.distributor_name from 
            (select * from payment_details_items where payment_id = '$id') A 
            left join 
            (select * from distributor_master) B 
            on (A.distributor_id = B.id)";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $data['distributor']=$result;
    }

    $this->load->library('parser');
    $output = $this->parser->parse('payment/payment_slip.php',$data,true);
    $pdf='';   
    if ($pdf=='print')
        $this->_gen_pdf($output);
    else
        $this->output->set_output($output);
}

}
?>