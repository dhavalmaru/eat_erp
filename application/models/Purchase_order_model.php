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

function get_purchase_order_nos($vendor_id){
    $sql = "select * from purchase_order where status='Approved' and vendor_id = '$vendor_id'";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_purchase_order_payment_details($id){
    $sql = "select * from purchase_order_payment_details where purchase_order_id = '$id'";
    $query=$this->db->query($sql);
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
    
    $data = array(
        'order_date' => $order_date,
        'vendor_id' => $this->input->post('vendor_id'),
        'depot_id' => $this->input->post('depot_id'),
        'amount' => format_number($this->input->post('total_amount'),2),
        'delivery_date' => $delivery_date,
        'shipping_method' => $this->input->post('shipping_method'),
        'shipping_term' => $this->input->post('shipping_term'),
        'status' => $this->input->post('status'),
        'remarks' => $this->input->post('remarks'),
        'modified_by' => $curusr,
        'modified_on' => $now
    );

    if($id==''){
        $data['created_by']=$curusr;
        $data['created_on']=$now;

        $this->db->insert('purchase_order',$data);
        $id=$this->db->insert_id();
        $action='Purchase Order Entry Created.';
    } else {
        $this->db->where('id', $id);
        $this->db->update('purchase_order',$data);
        $action='Purchase Order Entry Modified.';
    }

    $this->db->where('purchase_order_id', $id);
    $this->db->delete('purchase_order_items');

    $raw_material=$this->input->post('raw_material[]');
    $qty=$this->input->post('qty[]');
    $rate=$this->input->post('rate[]');
    $cst=$this->input->post('cst[]');
    $amount=$this->input->post('amount[]');

    for ($k=0; $k<count($raw_material); $k++) {
        if(isset($raw_material[$k]) and $raw_material[$k]!="") {
            $item_id=$raw_material[$k];
            $data = array(
                        'purchase_order_id' => $id,
                        'item_id' => $item_id,
                        'qty' => format_number($qty[$k],2),
                        'rate' => format_number($rate[$k],2),
                        'cst' => format_number($cst[$k],2),
                        'amount' => format_number($amount[$k],2)
                    );
            $this->db->insert('purchase_order_items', $data);
        }
    }

    $logarray['table_id']=$id;
    $logarray['module_name']='Purchase_Order';
    $logarray['cnt_name']='Purchase_Order';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);

    // $this->tax_invoice_model->generate_tax_invoice($id);
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

    $sql = "select * from purchase_order where id = '$id'";
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
    } else {
        $order_date=null;
        $total_amount=0;
        $depot_id=0;
        $vendor_id=0;
        $shipping_method=null;
        $shipping_term=null;
        $delivery_date=null;
    }
    $data['total_amount']=round($total_amount,2);
    $data['order_date']=$order_date;
    $data['shipping_method']=$shipping_method;
    $data['shipping_term']=$shipping_term;
    $data['delivery_date']=$delivery_date;

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
    
    $order_no = 'WHPL/'.$financial_year.'/'.strval($id);
    $data['order_no']=$order_no;

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