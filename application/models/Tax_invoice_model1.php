<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Tax_invoice_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('distributor_model');
    $this->load->model('distributor_out_model');
    $this->load->model('sales_rep_model');
}

function generate_tax_invoice($id) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $result = $this->distributor_out_model->get_data('', $id);
    if(count($result)>0){
        $distributor_id=$result[0]->distributor_id;
        $invoice_no=$result[0]->invoice_no;
        $voucher_no=$result[0]->voucher_no;
        $gate_pass_no=$result[0]->gate_pass_no;
        $date_of_processing=$result[0]->date_of_processing;
        $total_amount=floatval($result[0]->amount);
        $order_no=$result[0]->order_no;
        $order_date=$result[0]->order_date;
        $supplier_ref=$result[0]->supplier_ref;
        $despatch_doc_no=$result[0]->despatch_doc_no;
        $despatch_through=$result[0]->despatch_through;
        $destination=$result[0]->destination;
        $cst=$result[0]->cst;
        $cst_amount=$result[0]->cst_amount;
        $total_amount_with_tax=$result[0]->final_amount;
        $created_by=$result[0]->created_by;
        $sample_distributor_id=$result[0]->sample_distributor_id;
        $client_name=$result[0]->client_name;
        $client_address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);
    } else {
        $distributor_id=0;
        $invoice_no=null;
        $voucher_no=null;
        $gate_pass_no=null;
        $date_of_processing=null;
        $total_amount=0;
        $order_no=null;
        $order_date=null;
        $supplier_ref=null;
        $despatch_doc_no=null;
        $despatch_through=null;
        $destination=null;
        $cst=null;
        $cst_amount=0;
        $total_amount_with_tax=0;
        $created_by=null;
        $sample_distributor_id=null;
        $client_name=null;
        $client_address = null;
    }
    $data['total_amount']=round($total_amount,0);
    $data['order_no']=$order_no;
    $data['order_date']=$order_date;
    $data['supplier_ref']=$supplier_ref;
    $data['despatch_doc_no']=$despatch_doc_no;
    $data['despatch_through']=$despatch_through;
    $data['destination']=$destination;
    $data['cst']=$cst;
    $data['cst_amount']=round($cst_amount,2);
    $total_amount_with_tax=round($total_amount_with_tax,0);
    $data['total_amount_with_tax']=$total_amount_with_tax;
    $data['created_by']=$created_by;

    $result = $this->distributor_model->get_data('', $distributor_id);
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

        $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

        $data['distributor_name']=$distributor_name;
        $data['address']=$address;
        $data['tin_number']=$tin_number;
        $data['sales_rep_name']=$sales_rep_name;
        $data['total_amount_in_words']=convert_number_to_words($total_amount_with_tax) . ' Only';

        $sql = "select E.*, case when E.type='Box' then E.box_name else E.product_name end as description from 
                (select C.*, B.box_name from 
                (select A.*, B.product_name from 
                (select type, qty, sell_rate, rate, amount, case when type='Box' then item_id else null end as box_id, 
                    case when type='Bar' then item_id else null end as bar_id from distributor_out_items 
                    where distributor_out_id = '$id') A 
                left join 
                (select * from product_master) B 
                on (A.bar_id=B.id)) C 
                left join 
                (select * from box_master) B 
                on (C.box_id=B.id)) E";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $data['description']=$result;
        }

        if (strtoupper(trim($class))=='SAMPLE') {
            if($voucher_no==null || $voucher_no==''){
                $sql="select * from series_master where type='Voucher'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $series=intval($result[0]->series)+1;

                    $sql="update series_master set series = '$series' where type = 'Voucher'";
                    $this->db->query($sql);
                } else {
                    $series=1;

                    $sql="insert into series_master (type, series) values ('Voucher', '$series')";
                    $this->db->query($sql);
                }

                if (isset($date_of_processing)){
                    $financial_year=calculateFiscalYearForDate($date_of_processing);
                } else {
                    $financial_year="";
                }
                
                $voucher_no = 'WHPL/'.$financial_year.'/voucher/'.strval($series);

                $sql="update distributor_out set voucher_no = '$voucher_no' where id = '$id'";
                $this->db->query($sql);
            }

            if($gate_pass_no==null || $gate_pass_no==''){
                $sql="select * from series_master where type='Gate_Pass'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $series=intval($result[0]->series)+1;

                    $sql="update series_master set series = '$series' where type = 'Gate_Pass'";
                    $this->db->query($sql);
                } else {
                    $series=1;

                    $sql="insert into series_master (type, series) values ('Gate_Pass', '$series')";
                    $this->db->query($sql);
                }

                if (isset($date_of_processing)){
                    $financial_year=calculateFiscalYearForDate($date_of_processing);
                } else {
                    $financial_year="";
                }
                
                $gate_pass_no = 'WHPL/'.$financial_year.'/gate_pass/'.strval($series);

                $sql="update distributor_out set gate_pass_no = '$gate_pass_no' where id = '$id'";
                $this->db->query($sql);
            }

            $data['voucher_no']=$voucher_no;
            $data['gate_pass_no']=$gate_pass_no;
            $data['date_of_processing']=$date_of_processing;

            if(strtoupper(trim($distributor_name))=='DIRECT' || strtoupper(trim($distributor_name))=='AMAZON DIRECT'){
                $data['distributor_name']=$client_name;
                $data['address']=$client_address;
            } else {
                $data['distributor_name']=$distributor_name;
                $data['address']=$address;
            }
            
            $result = $this->distributor_model->get_data('', $sample_distributor_id);
            if(count($result)>0){
                $send_invoice = $result[0]->send_invoice;
                $class = $result[0]->class;
                $distributor_name=$result[0]->distributor_name;
                $state=$result[0]->state;
                $email_id=$result[0]->email_id;
                $mobile=$result[0]->mobile;
                $tin_number=$result[0]->tin_number;
                $cst_number=$result[0]->cst_number;
                // $sales_rep_name=$result[0]->sales_rep_name;

                $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

                $data['distributor_name']=$distributor_name;
                $data['address']=$address;
                $data['tin_number']=$tin_number;
                // $data['sales_rep_name']=$sales_rep_name;
            }
            
            $this->load->library('parser');
            $output = $this->parser->parse('invoice/voucher.php',$data,true);
            $pdf='';   
            if ($pdf=='print')
                $this->_gen_pdf($output);
            else
                $this->output->set_output($output);

            // if($view!=true){
            //     redirect(base_url().'index.php/distributor_out');
            // }
        } else if ($send_invoice==1) {
            if($invoice_no==null || $invoice_no==''){
                $sql="select * from series_master where type='Tax_Invoice'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $series=intval($result[0]->series)+1;

                    $sql="update series_master set series = '$series' where type = 'Tax_Invoice'";
                    $this->db->query($sql);
                } else {
                    $series=1;

                    $sql="insert into series_master (type, series) values ('Tax_Invoice', '$series')";
                    $this->db->query($sql);
                }

                if (isset($date_of_processing)){
                    $financial_year=calculateFiscalYearForDate($date_of_processing);
                } else {
                    $financial_year="";
                }
                
                $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);

                $sql="update distributor_out set invoice_no = '$invoice_no' where id = '$id'";
                $this->db->query($sql);

                $sql="update distributor_out set invoice_no = '$invoice_no' where id = '$id'";
                $this->db->query($sql);
            }

            $data['invoice_no']=$invoice_no;
            $data['date_of_processing']=$date_of_processing;

            if(strtoupper(trim($distributor_name))=='DIRECT' || strtoupper(trim($distributor_name))=='AMAZON DIRECT'){
                $data['distributor_name']=$client_name;
                $data['address']=$client_address;
            } else {
                $data['distributor_name']=$distributor_name;
                $data['address']=$address;
            }

            $this->load->library('parser');
            $output = $this->parser->parse('invoice/tax_invoice.php',$data,true);
            $pdf='';   
            if ($pdf=='print')
                $this->_gen_pdf($output);
            else
                $this->output->set_output($output);

            // if($view!=true){
            //     redirect(base_url().'index.php/distributor_out');
            // }
        }
    }

    return $invoice_no;
}

function generate_gate_pass() {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $check=$this->input->post('check');
    $sales_rep_id=$this->input->post('sales_rep_id');

    // echo $sales_rep_id;
    // echo '<br/>';

    // for($i=0; $i<count($check); $i++){
    //     echo $check[$i];
    //     echo '<br/>';
    // }

    $invoice_details = array();
    $voucher_details = array();
    $final_data = array();



    $inv_cnt = 0;
    $vou_cnt = 0;

    for($i=0; $i<count($check); $i++){
        $id = $check[$i];
        $result = $this->distributor_out_model->get_data('', $id);
        if(count($result)>0){
            $distributor_id=$result[0]->distributor_id;
            $invoice_no=$result[0]->invoice_no;
            $voucher_no=$result[0]->voucher_no;
            $gate_pass_no=$result[0]->gate_pass_no;
            $date_of_processing=$result[0]->date_of_processing;
            $total_amount=floatval($result[0]->amount);
            $order_no=$result[0]->order_no;
            $order_date=$result[0]->order_date;
            $supplier_ref=$result[0]->supplier_ref;
            $despatch_doc_no=$result[0]->despatch_doc_no;
            $despatch_through=$result[0]->despatch_through;
            $destination=$result[0]->destination;
            $cst=$result[0]->cst;
            $cst_amount=$result[0]->cst_amount;
            $total_amount_with_tax=$result[0]->final_amount;
            $created_by=$result[0]->created_by;
            $sample_distributor_id=$result[0]->sample_distributor_id;
            $client_name=$result[0]->client_name;
            $client_address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);
        } else {
            $distributor_id=0;
            $invoice_no=null;
            $voucher_no=null;
            $gate_pass_no=null;
            $date_of_processing=null;
            $total_amount=0;
            $order_no=null;
            $order_date=null;
            $supplier_ref=null;
            $despatch_doc_no=null;
            $despatch_through=null;
            $destination=null;
            $cst=null;
            $cst_amount=0;
            $total_amount_with_tax=0;
            $created_by=null;
            $sample_distributor_id=null;
            $client_name=null;
            $client_address = null;
        }
        $data['total_amount']=round($total_amount,0);
        $data['order_no']=$order_no;
        $data['order_date']=$order_date;
        $data['supplier_ref']=$supplier_ref;
        $data['despatch_doc_no']=$despatch_doc_no;
        $data['despatch_through']=$despatch_through;
        $data['destination']=$destination;
        $data['cst']=$cst;
        $data['cst_amount']=round($cst_amount,2);
        $total_amount_with_tax=round($total_amount_with_tax,0);
        $data['total_amount_with_tax']=$total_amount_with_tax;
        $data['created_by']=$created_by;

        $result = $this->distributor_model->get_data('', $distributor_id);
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

            $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

            $data['distributor_name']=$distributor_name;
            $data['address']=$address;
            $data['tin_number']=$tin_number;
            $data['sales_rep_name']=$sales_rep_name;
            $data['total_amount_in_words']=convert_number_to_words($total_amount_with_tax) . ' Only';

            $sql = "select E.*, case when E.type='Box' then E.box_name else E.product_name end as description from 
                    (select C.*, B.box_name from 
                    (select A.*, B.product_name from 
                    (select type, qty, sell_rate, rate, amount, case when type='Box' then item_id else null end as box_id, 
                        case when type='Bar' then item_id else null end as bar_id from distributor_out_items 
                        where distributor_out_id = '$id') A 
                    left join 
                    (select * from product_master) B 
                    on (A.bar_id=B.id)) C 
                    left join 
                    (select * from box_master) B 
                    on (C.box_id=B.id)) E";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0){
                $data['description']=$result;
            }

            if (strtoupper(trim($class))=='SAMPLE') {
                if($voucher_no==null || $voucher_no==''){
                    $sql="select * from series_master where type='Voucher'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0){
                        $series=intval($result[0]->series)+1;

                        $sql="update series_master set series = '$series' where type = 'Voucher'";
                        $this->db->query($sql);
                    } else {
                        $series=1;

                        $sql="insert into series_master (type, series) values ('Voucher', '$series')";
                        $this->db->query($sql);
                    }

                    if (isset($date_of_processing)){
                        $financial_year=calculateFiscalYearForDate($date_of_processing);
                    } else {
                        $financial_year="";
                    }
                    
                    $voucher_no = 'WHPL/'.$financial_year.'/voucher/'.strval($series);

                    $sql="update distributor_out set voucher_no = '$voucher_no' where id = '$id'";
                    $this->db->query($sql);
                }

                if($gate_pass_no==null || $gate_pass_no==''){
                    $sql="select * from series_master where type='Gate_Pass'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0){
                        $series=intval($result[0]->series)+1;

                        $sql="update series_master set series = '$series' where type = 'Gate_Pass'";
                        $this->db->query($sql);
                    } else {
                        $series=1;

                        $sql="insert into series_master (type, series) values ('Gate_Pass', '$series')";
                        $this->db->query($sql);
                    }

                    if (isset($date_of_processing)){
                        $financial_year=calculateFiscalYearForDate($date_of_processing);
                    } else {
                        $financial_year="";
                    }
                    
                    $gate_pass_no = 'WHPL/'.$financial_year.'/gate_pass/'.strval($series);

                    $sql="update distributor_out set gate_pass_no = '$gate_pass_no' where id = '$id'";
                    $this->db->query($sql);
                }

                $data['voucher_no']=$voucher_no;
                $data['gate_pass_no']=$gate_pass_no;
                $data['date_of_processing']=$date_of_processing;

                if(strtoupper(trim($distributor_name))=='DIRECT' || strtoupper(trim($distributor_name))=='AMAZON DIRECT'){
                    $data['distributor_name']=$client_name;
                    $data['address']=$client_address;
                } else {
                    $data['distributor_name']=$distributor_name;
                    $data['address']=$address;
                }
                
                $result = $this->distributor_model->get_data('', $sample_distributor_id);
                if(count($result)>0){
                    $send_invoice = $result[0]->send_invoice;
                    $class = $result[0]->class;
                    $distributor_name=$result[0]->distributor_name;
                    $state=$result[0]->state;
                    $email_id=$result[0]->email_id;
                    $mobile=$result[0]->mobile;
                    $tin_number=$result[0]->tin_number;
                    $cst_number=$result[0]->cst_number;
                    // $sales_rep_name=$result[0]->sales_rep_name;

                    $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

                    $data['distributor_name']=$distributor_name;
                    $data['address']=$address;
                    $data['tin_number']=$tin_number;
                    // $data['sales_rep_name']=$sales_rep_name;
                }
                
                $voucher_details[$vou_cnt] = $data;
                $vou_cnt = $vou_cnt + 1;

            } else if ($send_invoice==1) {
                if($invoice_no==null || $invoice_no==''){
                    $sql="select * from series_master where type='Tax_Invoice'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0){
                        $series=intval($result[0]->series)+1;

                        $sql="update series_master set series = '$series' where type = 'Tax_Invoice'";
                        $this->db->query($sql);
                    } else {
                        $series=1;

                        $sql="insert into series_master (type, series) values ('Tax_Invoice', '$series')";
                        $this->db->query($sql);
                    }

                    if (isset($date_of_processing)){
                        $financial_year=calculateFiscalYearForDate($date_of_processing);
                    } else {
                        $financial_year="";
                    }
                    
                    $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);

                    $sql="update distributor_out set invoice_no = '$invoice_no' where id = '$id'";
                    $this->db->query($sql);
                }

                $data['invoice_no']=$invoice_no;
                $data['date_of_processing']=$date_of_processing;

                if(strtoupper(trim($distributor_name))=='DIRECT' || strtoupper(trim($distributor_name))=='AMAZON DIRECT'){
                    $data['distributor_name']=$client_name;
                    $data['address']=$client_address;
                } else {
                    $data['distributor_name']=$distributor_name;
                    $data['address']=$address;
                }
                
                $invoice_details[$inv_cnt] = $data;
                $inv_cnt = $inv_cnt + 1;

            }
        }

        // $invoice_details[$i] = $data;
        // return $invoice_no;
    }

    $final_data['invoice_details'] = $invoice_details;
    $final_data['voucher_details'] = $voucher_details;
    $final_data['sales_rep_details'] = $this->sales_rep_model->get_data('Approved', $sales_rep_id);

    $final_data['sku_details']=array();
    $final_data['delivery_for']=array();
    $final_data['pending_payments']=array();
    $final_data['distributor_details']=array();

    if(count($check)>0){
        $distributor_out_id = implode(", ", $check);
    } else {
        $distributor_out_id = "";
    }
    
    if($distributor_out_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $sql = "update distributor_out set delivery_status = 'GP Issued', delivery_sales_rep_id = '$sales_rep_id', 
                modified_by = '$curusr', modified_on = '$now' 
                where id in (".$distributor_out_id.")";
        $this->db->query($sql);

        $data['sku_details']=array();
        $sql = "select AA.sku_name, AA.type, sum(AA.qty) as total_qty from 
                (select A.*, case when A.type='Bar' then B.product_name else C.box_name end as sku_name 
                    from distributor_out_items A left join product_master B on(A.item_id=B.id and A.type='Bar') 
                    left join box_master C on(A.item_id=C.id and A.type='Box') 
                    where A.distributor_out_id in (".$distributor_out_id.")) AA group by AA.sku_name, AA.type";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $final_data['sku_details']=$result;
        }

        $final_data['delivery_for']=array();
        $sql = "select A.*, datediff(curdate(), A.date_of_processing) as days, B.distributor_name 
                from distributor_out A left join distributor_master B on(A.distributor_id=B.id) 
                where A.id in (".$distributor_out_id.")";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $final_data['delivery_for']=$result;
        }

        $final_data['pending_payments']=array();
        $sql = "select DD.distributor_id, DD.distributor_name, DD.total_pending_amount, EE.invoice_date, EE.invoice_no, EE.invoice_amount, EE.voucher_no from 
                (select CC.distributor_id, CC.distributor_name, sum(pending_amount) as total_pending_amount from 
                (select AA.*, ifnull(BB.payment_amount,0) as payment_amount, (round(AA.final_amount,0)-ifnull(BB.payment_amount,0)) as pending_amount from 
                (select A.*, B.distributor_name from distributor_out A left join distributor_master B on(A.distributor_id=B.id) 
                    where A.status = 'Approved' and A.invoice_no is not null and A.invoice_no!='' and 
                    A.distributor_id in (select distinct distributor_id from distributor_out where id in (".$distributor_out_id."))) AA 
                left join 
                (select A.id, B.distributor_id, B.invoice_no, round(B.payment_amount,0) as payment_amount from payment_details A left join payment_details_items B 
                    on(A.id=B.payment_id) where A.status = 'Approved') BB 
                on (AA.distributor_id = BB.distributor_id and AA.invoice_no = BB.invoice_no)) CC 
                group by CC.distributor_id, CC.distributor_name) DD 
                left join 
                (select CC.distributor_id, CC.distributor_name, CC.date_of_processing as invoice_date, CC.invoice_no, 
                    sum(CC.pending_amount) as invoice_amount, CC.voucher_no from 
                (select AA.*, ifnull(BB.payment_amount,0) as payment_amount, (round(AA.final_amount,0)-ifnull(BB.payment_amount,0)) as pending_amount from 
                (select A.*, B.distributor_name from distributor_out A left join distributor_master B on(A.distributor_id=B.id) 
                    where A.status = 'Approved' and A.invoice_no is not null and A.invoice_no!='' and 
                    A.distributor_id in (select distinct distributor_id from distributor_out where id in (".$distributor_out_id."))) AA 
                left join 
                (select A.id, B.distributor_id, B.invoice_no, round(B.payment_amount,0) as payment_amount from payment_details A left join payment_details_items B 
                    on(A.id=B.payment_id) where A.status = 'Approved') BB 
                on (AA.distributor_id = BB.distributor_id and AA.invoice_no = BB.invoice_no)) CC where CC.pending_amount > 0 
                group by CC.distributor_id, CC.distributor_name, CC.date_of_processing, CC.invoice_no) EE 
                on (DD.distributor_id = EE.distributor_id and DD.distributor_name = EE.distributor_name) 
                order by DD.distributor_id, EE.invoice_date";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $final_data['pending_payments']=$result;
        }


        $distributor = array();
        // $sql = "select distinct distributor_id from distributor_out where id in (".$distributor_out_id.")";
        // $query=$this->db->query($sql);
        // $distributor=$query->result();

        // for($i=0; $i<count($distributor); $i++){
        //     $final_data['distributor_details'][$i]=$this->distributor_model->get_data('Approved', $distributor[$i]->distributor_id);
        //     $final_data['distributor_payments'][$i]=array();
        //     $final_data['distributor_payments_ageing'][$i]=array();

        //     $sql = "select DD.distributor_id, DD.distributor_name, DD.total_pending_amount, EE.invoice_date, EE.invoice_no, EE.invoice_amount, EE.voucher_no from 
        //             (select CC.distributor_id, CC.distributor_name, sum(pending_amount) as total_pending_amount from 
        //             (select AA.*, ifnull(BB.payment_amount,0) as payment_amount, (round(AA.final_amount,0)-ifnull(BB.payment_amount,0)) as pending_amount from 
        //             (select A.*, B.distributor_name from distributor_out A left join distributor_master B on(A.distributor_id=B.id) 
        //                 where A.status = 'Approved' and A.invoice_no is not null and A.invoice_no!='' and 
        //                 A.distributor_id = '".$distributor[$i]->distributor_id."') AA 
        //             left join 
        //             (select A.id, B.distributor_id, B.invoice_no, round(B.payment_amount,0) as payment_amount from payment_details A left join payment_details_items B 
        //                 on(A.id=B.payment_id) where A.status = 'Approved') BB 
        //             on (AA.distributor_id = BB.distributor_id and AA.invoice_no = BB.invoice_no)) CC 
        //             group by CC.distributor_id, CC.distributor_name) DD 
        //             left join 
        //             (select CC.distributor_id, CC.distributor_name, CC.date_of_processing as invoice_date, CC.invoice_no, 
        //                 sum(CC.pending_amount) as invoice_amount, CC.voucher_no from 
        //             (select AA.*, ifnull(BB.payment_amount,0) as payment_amount, (round(AA.final_amount,0)-ifnull(BB.payment_amount,0)) as pending_amount from 
        //             (select A.*, B.distributor_name from distributor_out A left join distributor_master B on(A.distributor_id=B.id) 
        //                 where A.status = 'Approved' and A.invoice_no is not null and A.invoice_no!='' and 
        //                 A.distributor_id = '".$distributor[$i]->distributor_id."') AA 
        //             left join 
        //             (select A.id, B.distributor_id, B.invoice_no, round(B.payment_amount,0) as payment_amount from payment_details A left join payment_details_items B 
        //                 on(A.id=B.payment_id) where A.status = 'Approved') BB 
        //             on (AA.distributor_id = BB.distributor_id and AA.invoice_no = BB.invoice_no)) CC where CC.pending_amount > 0 
        //             group by CC.distributor_id, CC.distributor_name, CC.date_of_processing, CC.invoice_no) EE 
        //             on (DD.distributor_id = EE.distributor_id and DD.distributor_name = EE.distributor_name) 
        //             order by DD.distributor_id, EE.invoice_date";
        //     $query=$this->db->query($sql);
        //     $result=$query->result();
        //     if(count($result)>0){
        //         $final_data['distributor_payments'][$i]=$result;
        //     }

        //     $date = date('Y-m-d');
        //     $sql = "select G.*, (G.days_30_45+G.days_46_60) as days_30_60, H.distributor_name from 
        //             (select F.distributor_id, F.days_0_30, F.days_30_45, F.days_46_60, F.days_61_90, F.days_91_above, 
        //                 (F.days_0_30+F.days_30_45+F.days_46_60+F.days_61_90+F.days_91_above) as tot_receivable from 
        //             (select E.distributor_id, case when (E.days_91_above-E.paid_amount)>0 then 
        //                 (E.days_91_above-E.paid_amount) else 0 end as days_91_above, 
        //             case when (E.days_91_above-E.paid_amount)>0 then E.days_61_90 else case when 
        //                 (E.days_61_90-(E.paid_amount-E.days_91_above))>0 then 
        //                 (E.days_61_90-(E.paid_amount-E.days_91_above)) else 0 end end as days_61_90, 
        //             case when (E.days_61_90-(E.paid_amount-E.days_91_above))>0 then 
        //             E.days_46_60 else case when (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90))>0 then 
        //             (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90)) else 0 end end as days_46_60, 
        //             case when (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90))>0 then E.days_30_45 else case 
        //                 when (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60))>0 
        //                 then (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60)) else 0 end end as days_30_45, 
        //             case when (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60))>0 then E.days_0_30 else case 
        //                 when (E.days_0_30-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60-E.days_30_45))>0 
        //                 then (E.days_0_30-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60-E.days_30_45)) else 0 end end as days_0_30 from 
        //             (select C.distributor_id, C.days_0_30, C.days_30_45, C.days_46_60, C.days_61_90, C.days_91_above, 
        //                 ifnull(D.paid_amount,0) as paid_amount from 
        //             (select distributor_id, ifnull(round(sum(days_0_30),0),0) as days_0_30, 
        //                 ifnull(round(sum(days_30_45),0),0) as days_30_45, 
        //                 ifnull(round(sum(days_46_60),0),0) as days_46_60, 
        //             ifnull(round(sum(days_61_90),0),0) as days_61_90, ifnull(round(sum(days_91_above),0),0) as days_91_above from 
        //             (select distributor_id, case when no_of_days<30 then final_amount else 0 end as days_0_30, 
        //             case when no_of_days>=30 and no_of_days<=45 then final_amount else 0 end as days_30_45, 
        //             case when no_of_days>=46 and no_of_days<=60 then final_amount else 0 end as days_46_60, 
        //             case when no_of_days>=61 and no_of_days<=90 then final_amount else 0 end as days_61_90, 
        //             case when no_of_days>=91 then final_amount else 0 end as days_91_above from 
        //             (select id, distributor_id, datediff('$date', date_of_processing) as no_of_days, 
        //                 round(final_amount,0) as final_amount from distributor_out where status = 'Approved' and date_of_processing<='$date') A) B 
        //             group by distributor_id) C 
        //             left join 
        //             (select distributor_id, round(sum(payment_amount),0) as paid_amount from payment_details_items 
        //                 where payment_id in (select distinct id from payment_details where status = 'Approved' and 
        //                     date_of_deposit<='$date') group by distributor_id) D 
        //             on (C.distributor_id = D.distributor_id)) E) F) G 
        //             left join 
        //             (select * from distributor_master) H 
        //             on (G.distributor_id = H.id) where G.distributor_id = '".$distributor[$i]->distributor_id."' and 
        //             G.tot_receivable > 0";
        //     $query=$this->db->query($sql);
        //     $result=$query->result();
        //     if(count($result)>0){
        //         $final_data['distributor_payments_ageing'][$i]=$result;
        //     }

        //     $total_amount = 0;
        //     for($j=0; $j<count($final_data['distributor_payments'][$i]); $j++){
        //         if(isset($final_data['distributor_payments'][$i][$j]->invoice_amount)){
        //             $total_amount = $total_amount + floatval($final_data['distributor_payments'][$i][$j]->invoice_amount);
        //         }
        //     }
        //     $final_data['total_amount'][$i]=$total_amount;
        // }
    }
    

    // echo json_encode($final_data['distributor_payments']);
    // echo '<br/>';
    // echo json_encode($final_data['distributor_payments_ageing']);
    // // echo json_encode($final_data);
    load_view('invoice/gate_pass', $final_data);
}

function set_delivery_status() {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $check=$this->input->post('check');
    $delivery_status=$this->input->post('delivery_status');
    $status=$this->input->post('status');

    $distributor_out_id = implode(", ", $check);

    if($distributor_out_id!=""){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');
        $sql = "update distributor_out set delivery_status = '$delivery_status', status = '$status', 
                modified_by = '$curusr', modified_on = '$now' 
                where id in (".$distributor_out_id.")";
        $this->db->query($sql);
    }
}

function test(){
    $this->load->library('mpdf/mpdf');
    require_once(dirname(__FILE__) . '/../libraries/PHPExcel/Settings.php');

    $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
    $rendererLibraryPath = dirname(__FILE__) . '/../libraries/mpdf';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("TEST PDF")
      ->setLastModifiedBy("TEST")
      ->setTitle("TEST PDF")
      ->setSubject("TEST PDF")
      ->setDescription("TEST PDF")
      ->setKeywords("TEST PDF")
      ->setCategory("TEST PDF");

    $objPHPExcel->setActiveSheetIndex(0);

    // Field names in the first row
    $fields = $query->list_fields();
    $col = 0;
    foreach ($fields as $field)
    {
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
    $col++;
    }

    // Fetching the table data
    $row = 2;
    foreach($query->result() as $data)
    {
    $col = 0;
    foreach ($fields as $field)
    {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
      $col++;
    }

    $row++;
    }

    $objPHPExcel->setActiveSheetIndex(0);

    if (!PHPExcel_Settings::setPdfRenderer(
      $rendererName,
      $rendererLibraryPath
    ))
    {
    die(
      'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
      '<br />' .
      'at the top of this script as appropriate for your directory structure' . '<br/>' .
      $rendererName . '<br/>' .
      $rendererLibraryPath . '<br/>'
    );
    }

    // Redirect output to a client’s web browser (PDF)
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="'.$file_name.'.pdf"');
    header('Cache-Control: max-age=0');

    $objWriter = IOFactory::createWriter($objPHPExcel, 'PDF');
    $objWriter->save('php://output');
}

function test2(){
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Tax_Invoice.xls';
    $this->load->library('excel');

    $reader = PHPExcel_IOFactory::createReader('Excel5');
    $spreadsheet = $reader->load($file);

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="from-template.pdf"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'PDF');
    $writer->save('php://output');
    // die();
}

function gen_pdf(){
    $html="<html><body>Hiiiiiiiiiii</body></html>";
    $paper='A4';


    $this->load->library('mpdf57/mpdf');               
    $mpdf=new mPDF('utf-8',$paper);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}


private function _gen_pdf($html,$paper='A4'){
    // $this->load->library('mpdf60/mpdf');               
    // $mpdf=new mPDF('utf-8',$paper);
    // $mpdf->WriteHTML($html);
    // $mpdf->Output();

    //actually, you can pass mPDF parameter on this load() function
    $this->load->library('m_pdf');
    $pdf = $this->m_pdf->load();
    //generate the PDF!
    $pdf->WriteHTML($html,2);
    //offer it to user via browser download! (The PDF won't be saved on your server HDD)
    $pdf->Output($pdfFilePath, "D");
} 
}
?>