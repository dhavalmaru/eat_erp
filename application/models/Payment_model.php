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

                    $id = $ref_id;
                } else {
                    $sql = "Update payment_details A 
                            Set A.status='$status', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

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

        $data = array(
            'date_of_deposit' => $date_of_deposit,
            'bank_id' => $this->input->post('bank_id'),
            'payment_mode' => $this->input->post('payment_mode'),
            'total_amount' => format_number($this->input->post('total_amount'),2),
            'status' => $status,
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id
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

        for ($k=0; $k<count($distributor_id); $k++) {
            if(isset($distributor_id[$k]) and $distributor_id[$k]!="") {
                $data = array(
                            'payment_id' => $id,
                            'distributor_id' => $distributor_id[$k],
                            'ref_no' => $ref_no[$k],
                            'bank_name' => $bank_name[$k],
                            'bank_city' => $bank_city[$k],
                            'invoice_no' => $invoice_no[$k],
                            'payment_amount' => format_number($payment_amount[$k],2)
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