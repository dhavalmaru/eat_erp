<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Purchase_order_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('tax_invoice_model');
    $this->load->library('encryption');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase_Order' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_pending_data($id=''){
    $query=$this->db->query("SELECT * FROM purchase_order WHERE ref_id = '$id' and status!='InActive'");
    $result=$query->result();
    if (count($result)>0){
        $id = $result[0]->id;
    }

    return $id;
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

    $sql = "select C.*, D.depot_name from 
            (select A.*, B.vendor_name from 
            (select * from purchase_order".$cond.") A 
            left join 
            (select * from vendor_master) B 
            on (A.vendor_id=B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id) order by C.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_purchase_order_items($id){
    $sql = "select * from purchase_order_items where purchase_order_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_raw_material_in_items($id){
    $sql = "Select Distinct B.* from 
            (Select * from raw_material_in) A
            left JOIN
            (Select * from raw_material_stock ) B
            on A.id=B.raw_material_in_id
            Where A.purchase_order_id='$id' and  A.status='Approved'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_purchase_order_nos($vendor_id){
    $sql = "select * from purchase_order where status='Approved' and vendor_id = '$vendor_id' and (po_status NOT IN('Raw Material IN','Closed') or po_status is null)";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_purchase_order_nos_by_status($vendor_id){
    $sql = "select * from purchase_order where status='Approved' and vendor_id = '$vendor_id' and (po_status NOT IN('Advance','Closed') or po_status is null)";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_purchase_order_payment_details($id){
    $sql = "select * from purchase_order_payment_details where purchase_order_id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_vendor_state($id){
    $sql = "select state from vendor_master where id = '$id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_rate($id){
    $sql = "select rate from raw_material_master where id = $id";
    $query=$this->db->query($sql);
	//echo $sql;
    return $query->result();
}

function get_hsn($id){
    $sql = "select hsn_code from raw_material_master where id = $id";
    $query=$this->db->query($sql);
	//echo $sql;
    return $query->result();
}

function save_data($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $order_date=$this->input->post('order_date');
    if($order_date==''){
        $order_date=NULL;
    } else {
        $order_date=formatdate($order_date);
    }

    $delivery_date=$this->input->post('delivery_date');
    if($delivery_date==''){
        $delivery_date=NULL;
    } else {
        $delivery_date=formatdate($delivery_date);
    }

    $po_no = $this->input->post('po_no');

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


        $id;
        $ref_id = $this->input->post('ref_id');

        $remarks = $this->input->post('remarks');

        if($status == 'Rejected'){
            $sql = "Update purchase_order Set status='$status', approved_by='$curusr', approved_on='$now' where id = '$id'";
            $this->db->query($sql);

            $action='Payment Entry '.$status.'.';
        } else {
            if($id!='' || $ref_id!=''){
                if($po_no==null || $po_no=='')
                    {
                        
                        $sql="select * from series_master where type='Purchase_Order'";
                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if(count($result)>0)
                        {
                            $series=intval($result[0]->series)+1;
                            
                             if (isset($order_date)){
                                    $financial_year=calculateFiscalYearForDate($order_date);
                                } else {
                                    $financial_year="";
                                }
                                
                                $po_no = 'WHPL/'.$financial_year.'/'.strval($series);
                            $sql="update series_master set series = '$series' where type = 'Purchase_Order'";
                            $this->db->query($sql);
                        }
                        else
                        {
                            $series=1;
                              if (isset($order_date)){
                                    $financial_year=calculateFiscalYearForDate($order_date);
                                } else {
                                    $financial_year="";
                                }
                            $po_no = 'WHPL/'.$financial_year.'/'.strval($series);
                            $sql="insert into series_master (type, series) values ('Purchase_Order', '$series')";
                            $this->db->query($sql);
                        } 
                    }

                if($ref_id!=null && $ref_id!=''){
                    $sql = "Update purchase_order A, purchase_order B 
                            Set A.order_date=B.order_date, A.depot_id=B.depot_id, A.vendor_id=B.vendor_id,
                                A.amount=B.amount,
                                A.other_charges=B.other_charges,
                                A.other_charges_amount=B.other_charges_amount,
                                A.shipping_method=B.shipping_method,
                                A.shipping_term=B.shipping_term,
                                A.delivery_date=B.delivery_date,
                                A.po_status=B.po_status,
                                A.po_no='$po_no',
                                A.status='$status', A.remarks='$remarks', 
                                A.modified_by=B.modified_by,A.modified_on=B.modified_on,A.approved_by='$curusr', A.approved_on='$now' 
                                WHERE A.id = '$ref_id' and B.id = '$id'";
                    $this->db->query($sql);
                    
                    $sql = "Delete from purchase_order where id = '$id'";
                    $this->db->query($sql);

                    $sql = "Delete from purchase_order_items WHERE purchase_order_id = '$ref_id'";
                    $this->db->query($sql);

                    $sql = "Update purchase_order_items set purchase_order_id='$ref_id' WHERE purchase_order_id = '$id'";
                    $this->db->query($sql);

                    $id = $ref_id;
                } else {
                    $sql = "Update purchase_order A 
                            Set A.status='$status',A.po_no='$po_no', A.remarks='$remarks', A.approved_by='$curusr', A.approved_on='$now' 
                            WHERE A.id = '$id'";
                    $this->db->query($sql);
                }

                $action='Purchase Entry '.$status.'.';
            }
        }
    }else {
        if($this->input->post('btn_delete')!=null){
            if($this->input->post('status')=="Approved"){
                $status = 'Deleted';
            } else {
                $status = 'InActive';
            }
        } else {
            $status = 'Pending';
        }

        $this->input->post('status');

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
            'order_date' => $order_date,
            'vendor_id' => $this->input->post('vendor_id'),
            'depot_id' => $this->input->post('depot_id'),
            'amount' => format_number($this->input->post('total_amount'),2),
            'other_charges' => $this->input->post('other_charges'),
            'other_charges_amount' => format_number($this->input->post('other_charges_amount'),2),
            'delivery_date' => $delivery_date,
            'shipping_method' => $this->input->post('shipping_method'),
            'shipping_term' => $this->input->post('shipping_term'),
            'status' => $this->input->post('status'),
            'remarks' => $this->input->post('remarks'),
            'modified_by' => $curusr,
            'modified_on' => $now,
            'ref_id' => $ref_id,
            'status' => $status,
            'po_status'=>'Open'
        );
        if($id==''){
            $data['created_by']=$curusr;
            $data['created_on']=$now;

            if($this->input->post('status')=="Approved"){
                $action='Purchase Entry Modified.';
            } else {
                $action='Purchase Entry Created.';
            }

            $this->db->insert('purchase_order',$data);
            $id=$this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('purchase_order',$data);
            $action='Payment Entry Modified.';
        }

        $this->db->where('purchase_order_id', $id);
        $this->db->delete('purchase_order_items');

        $raw_material=$this->input->post('raw_material[]');
        $item_desc=$this->input->post('item_desc[]');
        $qty=$this->input->post('qty[]');
        $hsn_code=$this->input->post('hsn_code[]');
        $rate=$this->input->post('rate[]');
        $tax_per=$this->input->post('tax_per[]');
        $amount=$this->input->post('amount[]');
        $cgst_amt=$this->input->post('cgst_amt[]');
        $sgst_amt=$this->input->post('sgst_amt[]');
        $igst_amt=$this->input->post('igst_amt[]');
        $tax_amt=$this->input->post('tax_amt[]');
        $total_amt=$this->input->post('total_amt[]');
        
        for ($k=0; $k<count($raw_material); $k++) {
            if(isset($raw_material[$k]) and $raw_material[$k]!="") {
                $item_id=$raw_material[$k];
                $data = array(
                            'purchase_order_id' => $id,
                            'item_id' => $item_id,
                            'item_desc' => $item_desc[$k],
                            'qty' => format_number($qty[$k],2),
                            'hsn_code'=>$hsn_code[$k],
                            'rate' => format_number($rate[$k],2),
                            'tax_per' => format_number($tax_per[$k],2),
                            'amount' => format_number($amount[$k],2),
                            'cgst_amt' => format_number($cgst_amt[$k],2),
                            'sgst_amt' => format_number($sgst_amt[$k],2),
                            'igst_amt' => format_number($igst_amt[$k],2),
                            'tax_amt' => format_number($tax_amt[$k],2),
                            'total_amt' => format_number($total_amt[$k],2)
                        );
                $this->db->insert('purchase_order_items', $data);
            }
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Purchase_Order';
    $logarray['cnt_name']='Purchase_Order';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function save_payment_details($id=''){
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $this->db->where('purchase_order_id', $id);
    $this->db->delete('purchase_order_payment_details');

    $payment_mode=$this->input->post('payment_mode[]');
    $ref_no=$this->input->post('ref_no[]');
    $payment_date=$this->input->post('payment_date[]');
    $payment_amount=$this->input->post('payment_amount[]');

    for ($k=0; $k<count($payment_mode); $k++) {
        if(isset($payment_mode[$k]) and $payment_mode[$k]!="") {
            $p_date=$payment_date[$k];
            if($p_date==''){
                $p_date=NULL;
            }
            else{
                $p_date=formatdate($p_date);
            }

            $data = array(
                        'purchase_order_id' => $id,
                        'payment_mode' => $payment_mode[$k],
                        'ref_no' => $ref_no[$k],
                        'payment_date' => $p_date,
                        'payment_amount' => format_number($payment_amount[$k],2)
                    );
            $this->db->insert('purchase_order_payment_details', $data);
        }
    }

    $action='Purchase Order Payment Details Modified.';

    $logarray['table_id']=$id;
    $logarray['module_name']='Purchase_Order';
    $logarray['cnt_name']='Purchase_Order';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function send_email($id){
    $sql = "select * from purchase_order where id = '$id'";
    $query=$this->db->query($sql);
    $result = $query->result();
    if(count($result)>0){
        $vendor_id=$result[0]->vendor_id;
        $order_date=$result[0]->order_date;
        $total_amount=floatval($result[0]->amount);

        if (isset($order_date)){
            $financial_year=calculateFiscalYearForDate($order_date);
        } else {
            $financial_year="";
        }
        
        $order_no = 'WHPL/'.$financial_year.'/'.strval($id);

        $sql = "select * from vendor_master where id = '$vendor_id'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $vendor_name=$result[0]->vendor_name;
            $contact_person=$result[0]->contact_person;
            $tin_number=$result[0]->tin_number;
            $cst_number=$result[0]->cst_number;
            $email_id=$result[0]->email_id;

            if($email_id!=''){
                $from_email = 'cs@eatanytime.in';
                $from_email_sender = 'Wholesome Habits Pvt Ltd';
                $to_email = $email_id;
                $bcc = 'vaibhav.desai@eatanytime.in, rishit.sanghvi@otbconsulting.co.in, swapnil.darekar@otbconsulting.co.in';
                $subject = 'Purchase Order from Wholesome Habits Pvt Ltd';
                // $message = '<html><head></head><body>Dear, '.$vendor_name.',<br /><br />' .
                //             'Please find our purchase order link to this email.' .
                //             '<br /><br />Thank you<br />Team eatanytime' .
                //             '<br /><br />' .
                //             '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----------------   Purchase Order Summary  -------------------<br />' .
                //             '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Order No. : '.$order_no.'<br />' .
                //             '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Order Date: '.(($order_date!=null && $order_date!='')?date('d-M-y',strtotime($order_date)):'').'<br />' .
                //             '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: Rs '.$total_amount.'<br />' .
                //             '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Link: <a href="'.base_url().'index.php/purchase_order/view_po/'.$this->encryption->encrypt($id).'" target="_blank">View Purchase Order</a><br />' .
                //             '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----------------------------------------------------------------' .
                //             '</body></html>';

                $message = '<html><head></head><body>Dear, '.$vendor_name.',<br /><br />' .
                            'Please find our purchase order link to this email.' .
                            '<br /><br />Thank you<br />Team eatanytime' .
                            '<br /><br />' .
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----------------   Purchase Order Summary  -------------------<br />' .
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Order No. : '.$order_no.'<br />' .
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Purchase Order Date: '.(($order_date!=null && $order_date!='')?date('d-M-y',strtotime($order_date)):'').'<br />' .
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total: Rs '.$total_amount.'<br />' . 
                            '<form method="post" action="'.base_url().'index.php/purchase_order/view_po" target="_blank">' . 
                            '<input type="hidden" name="id" value="'.$this->encryption->encrypt($id).'" />' . 
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Link: <a><input type="submit" value="View Purchase Order" style="border: none; background: none; color: blue; text-decoration: underline; cursor: pointer;"></a></form><br />' .
                            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----------------------------------------------------------------' .
                            '</body></html>';
                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc);
                if ($mailSent==1) {
                    echo "<script>alert('Mail sent.');</script>";
                } else {
                    echo "<script>alert('Mail sending failed.');</script>";
                }
            } else {
                echo "<script>alert('Please update vendor email id.');</script>";
            }
        }
    }
}

function generate_purchase_order($id) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $sql = "select A.*, concat(B.first_name, ' ', B.last_name) as createdby, 
            concat(C.first_name, ' ', C.last_name) as modifiedby, 
            concat(D.first_name, ' ', D.last_name) as approvedby 
            from purchase_order A left join user_master B on(A.created_by=B.id) 
            left join user_master C on(A.modified_by=C.id) 
            left join user_master D on(A.approved_by=D.id) where A.id = '$id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $order_date=$result[0]->order_date;
        $total_amount=floatval($result[0]->amount);
        $depot_id=$result[0]->depot_id;
        $vendor_id=$result[0]->vendor_id;
        $shipping_method=$result[0]->shipping_method;
        $shipping_term=$result[0]->shipping_term;
        $delivery_date=$result[0]->delivery_date;
        $po_no=$result[0]->po_no;
        $other_charges_amount=$result[0]->other_charges_amount;
        $other_charges=$result[0]->other_charges;
        $remarks=$result[0]->remarks;
        $createdby=$result[0]->createdby;
        $modifiedby=$result[0]->modifiedby;
        $approvedby=$result[0]->approvedby;
    } else {
        $order_date=null;
        $total_amount=0;
        $depot_id=0;
        $vendor_id=0;
        $shipping_method=null;
        $shipping_term=null;
        $delivery_date=null;
        $po_no=null;
        $other_charges_amount=null;
        $other_charges=null;
        $remarks=null;
        $createdby=null;
        $modifiedby=null;
        $approvedby=null;
    }
    $data['total_amount']=round($total_amount,2);
    $data['order_date']=$order_date;
    $data['shipping_method']=$shipping_method;
    $data['shipping_term']=$shipping_term;
    $data['delivery_date']=$delivery_date;
    $data['other_charges_amount']=$other_charges_amount;
    $data['other_charges']=$other_charges;
    $data['remarks']=$remarks;
    $data['createdby']=$createdby;
    $data['modifiedby']=$modifiedby;
    $data['approvedby']=$approvedby;

    $sql = "select * from depot_master where id = '$depot_id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $depot_name=$result[0]->depot_name;
        $contact_person=$result[0]->contact_person;

        $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

        $data['depot_name']=$depot_name;
        $data['depot_contact_person']=$contact_person;
        $data['depot_address']=$address;
    }

    $sql = "select * from vendor_master where id = '$vendor_id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $vendor_name=$result[0]->vendor_name;
        $contact_person=$result[0]->contact_person;
        $tin_number=$result[0]->tin_number;
        $cst_number=$result[0]->cst_number;
        $gst_number=$result[0]->gst_number;

        $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

        $data['vendor_name']=$vendor_name;
        $data['vendor_contact_person']=$contact_person;
        $data['vendor_address']=$address;
        $data['vendor_tin_number']=$tin_number;
        $data['vendor_cst_number']=$cst_number;
        $data['vendor_gst_number']=$gst_number;
    }

    $sql = "select A.*, B.rm_name from 
            (select * from purchase_order_items where purchase_order_id = '$id') A 
            left join 
            (select * from raw_material_master) B 
            on (A.item_id=B.id)";
    $query=$this->db->query($sql);
    $result=$query->result();
    if(count($result)>0){
        $data['items']=$result;
    }

    if (isset($order_date)){
        $financial_year=calculateFiscalYearForDate($order_date);
    } else {
        $financial_year="";
    }
    
    /*$order_no = 'WHPL/'.$financial_year.'/'.strval($id);*/
    $data['order_no']=$po_no;

    $this->load->library('parser');
    // $data = $this->data->getdata();
    if(strtotime($order_date)<strtotime('2017-07-01')){
        $output = $this->parser->parse('purchase_order/purchase_order_old.php',$data,true);
    } else {
        $output = $this->parser->parse('purchase_order/purchase_order.php',$data,true);
    }
    
    $pdf='';   
    if ($pdf=='print')
        $this->_gen_pdf($output);
    else
        $this->output->set_output($output);
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