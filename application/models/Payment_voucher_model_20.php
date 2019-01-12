<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Payment_voucher_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function save_data(){

    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');
    $invoice_date=$this->input->post('invoice_date');
    $id=$this->input->post('id');    

    if($invoice_date==''){
        $invoice_date=NULL;
    } else {
        $invoice_date=formatdate($invoice_date);
    }

    $status = 'Approved';
   


    if($id=="")
    {
        $data = array(
            'default_state'=> $this->input->post('depot_state'),
            'vendor_state'=> $this->input->post('vendor_state'),
            'vendor_id' => $this->input->post('vendor_id'),
            'requestor_id' => $curusr,
            'final_amount' => format_number($this->input->post('final_amount'),2),
            'total_payable'=> format_number($this->input->post('total_payable'),2),
            "tds_per" => $this->input->post('tds_per'),
            'status' => $status,
            'created_by' => $curusr,
            'created_on' => $now,
            'modified_by' => $curusr,
            'modified_on' => $now,
            'invoice_no' => $this->input->post('invoice_no'),
            'invoice_date' => $invoice_date,
            'type_use' => $this->input->post('type_use'),
            'type'=>$this->input->post('type'),
            'po_no'=>$this->input->post('po_no'),
            'attached'=>$this->input->post('attached'),
            'tdsamount'=>$this->input->post('tdsamount'),
            'remark'=>$this->input->post('remark')
        );
        $sql="select * from series_master where type='Payment_Voucher'";
        $query=$this->db->query($sql);
        $result=$query->result();
        $series=intval($result[0]->series)+1;
        $sql="update series_master set series = '$series' where type = 'Paymen_Voucher'";
        $this->db->query($sql);
        $ref_no = 'WHPL/Payment_Voucher/'.strval($series);
        $data['voucher_no'] = $ref_no;    

        $this->db->insert('payment_voucher_detail',$data);
        $insert_id = $this->db->insert_id(); 

          
    }
    else
    {
        $data = array(
            'default_state'=> $this->input->post('depot_state'),
            'vendor_state'=> $this->input->post('vendor_state'),
            'vendor_id' => $this->input->post('vendor_id'),
            'final_amount' => format_number($this->input->post('final_amount'),2),
            'total_payable'=> format_number($this->input->post('total_payable'),2),
            "tds_per" => $this->input->post('tds_per'),
            'status' => $status,
            'modified_by' => $curusr,
            'modified_on' => $now,
            'invoice_no' => $this->input->post('invoice_no'),
            'invoice_date' => $invoice_date,
            'type_use' => $this->input->post('type_use'),
            'type'=>$this->input->post('type'),
            'po_no'=>$this->input->post('po_no'),
            'attached'=>$this->input->post('attached'),
            'tdsamount'=>$this->input->post('tdsamount'),
            'remark'=>$this->input->post('remark')
        );

        $this->db->where('id',$id)->update('payment_voucher_detail',$data);
        $this->db->where('payment_voucher_id', $id)->delete('payment_voucher_items');
        $insert_id = $id;    
    }


    $particulars = $this->input->post('particulars');
    $qty = $this->input->post('qty');
    $rate = $this->input->post('rate');
    $amount = $this->input->post('amount');
    $tax = $this->input->post('tax');
    $cgst_amt = $this->input->post('cgst_amt');
    $sgst_amt = $this->input->post('sgst_amt');
    $igst_amt = $this->input->post('igst_amt');
    $total_amt = $this->input->post('total_amt');


    $item_batch = [];

    for($i=0;$i<count($particulars);$i++)
    {
        $item_batch[] = array(
                              "payment_voucher_id"=>$insert_id,
                              "particulars"=>$particulars[$i],
                              "qty"=>$qty[$i],
                              "rate"=>$rate[$i],
                              "amount"=>$amount[$i],
                              "tax_per"=>$tax[$i],
                              "cgst_amt"=>$cgst_amt[$i],
                              "sgst_amt"=>$sgst_amt[$i],
                              "igst_amt"=>$igst_amt[$i],
                              "total_amt"=>$total_amt[$i],
                              );
    }

    $this->db->insert_batch('payment_voucher_items',$item_batch);

 }

public function get_vendor($vendor_id='')
{   
    if($vendor_id!="")
        $where = 'and id='.$vendor_id;
    else
        $where = '';

    
    $this->db->select('*');
    $this->db->where('status = "Approved" '.$where);
    $result=$this->db->get('vendor_master')->result();
    return  $result;
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

    $user_id=$this->session->userdata('session_id');
    $role_id=$this->session->userdata('role_id');

    $cond2 = '';
    if($role_id!=1)
    {
        $cond2 = ' Where requestor_id='.$user_id;
    }

   /* $sql = "Select A.*,B.* from 
            Select * from (
            Select A.* ,B.user_name
            (Select vendor_state,default_state,vendor_id,requestor_id,tds_per,total_payable,final_amount,type_use ,invoice_date,invoice_no,voucher_no,status,id as payment_voucher_id,type,po_no,attached
            from payment_voucher_detail ".$cond.")A 
            left join
            (Select user_name,id from user) B on A.requestor_id=B.id
            )A
            Left JOIN
            (SELECT vendor_name,id,gst_number from vendor_master) B
            on A.vendor_id=B.id";*/
    $sql = "Select A.* ,B.* from 
            (Select * from 
            (Select A.* ,B.user_name,B.id as user_id  from 
            (Select vendor_state,default_state,vendor_id,requestor_id,tds_per,total_payable,final_amount,type_use ,invoice_date,
            invoice_no,voucher_no,status,id as payment_voucher_id,type,po_no,attached,created_on,tdsamount,remark
            from payment_voucher_detail ".$cond.")A 
            left join (Select CONCAT(first_name,' ',last_name) as user_name,id from user_master) B 
            on A.requestor_id=B.id )A )A
            Left JOIN 
            (SELECT vendor_name,id,gst_number from vendor_master) B on A.vendor_id=B.id ". $cond2.' Order By A.payment_voucher_id DESC ';

    $query=$this->db->query($sql);
    return $query->result();
}


public function payment_voucher_list($id)
{
    $sql = "Select * from payment_voucher_items Where payment_voucher_id=".$id;
    $query=$this->db->query($sql);
    return $query->result();
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Payment' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}


}
?>