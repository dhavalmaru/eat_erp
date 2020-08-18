<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Order extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('order_model');
        $this->load->model('box_model');
        $this->load->model('product_model');
        $this->load->model('payment_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->order_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->order_model->get_data();

        //     load_view('order/order_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }

        $this->checkstatus('pending');
    }

    public function get_data($status){
        // $status = 'Approved';

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        // $status = intval($this->input->get("status"));

        $r = $this->order_model->get_data($status);
        $data = array();

        for($i=0;$i<count($r);$i++){
            $data[] = array(
                        '<input type="checkbox" id="check_'.$i.'" class="check icheckbox" name="check_val[]" value="'.$r[$i]->id.'" onChange="set_checkbox(this);" />
                        <input type="hidden" id="input_check_'.$i.'" name="check[]" value="false" />',

                        $i+1,

						'<a href="'.base_url().'index.php/order/edit/'.$r[$i]->id.'"  class=""><i style="vertical:middle;text-align:center" class="fa fa-edit"></i></a>',

                        '<span style="display:none;">
                        <input type="hidden" id="date_of_processing_'.$i.'" name="date_of_processing[]" value="'.$r[$i]->date_of_processing.'" />'.
                            (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('Ymd',strtotime($r[$i]->date_of_processing)):'')
                        .'</span>'.
                        (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('d/m/Y',strtotime($r[$i]->date_of_processing)):''),
                        
                        $r[$i]->id,

                        $r[$i]->retailer_name,

                        $r[$i]->distributor_name,

                        $r[$i]->location,

                        $r[$i]->sales_rep_name,

                        $r[$i]->invoice_amount,

                        (($r[$i]->modified_on!=null && $r[$i]->modified_on!='')?date('d/m/Y',strtotime($r[$i]->modified_on)):''),

                        '<input type="hidden" id="dlvery_status_'.$i.'" name="dlvery_status[]" value="'.$r[$i]->delivery_status.'" />'.
                        
                        $r[$i]->delivery_status
                    );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => count($r),
                        "recordsFiltered" => count($r),
                        "data" => $data
                        // ,
                        // "columns" => $columns
                    );
        echo json_encode($output);
    }

    public function checkstatus($status=''){
        $result=$this->order_model->get_access();
        $selectedstatus="Select Status";
        if(count($result)>0) {
            $curusr = $this->session->userdata('session_id');

            $data['access']=$result;
            if($status=='All') {
                $status='';
            }
            $data['data']=$this->order_model->get_data($status);
            
            $count_data=$this->order_model->get_data();
            
            $pending=0;
            $delivered=0;
            $cancelled=0;
            
            //responsive drop down list code 
            if($status=="delivered") {
                $selectedstatus='Delivered';//$status;
            } else if($status=="pending") {
                $selectedstatus='Pending';//$status;
            } else if($status=="cancelled") {
                $selectedstatus='Cancelled';//$status;
            } else {
                $selectedstatus=$status;
            }
            //responsive drop down list code 
            
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if ((strtoupper(trim($count_data[$i]->status))=="APPROVED" || strtoupper(trim($count_data[$i]->status))=="ACTIVE") && 
                                ($count_data[$i]->delivery_status==null || $count_data[$i]->delivery_status==''))
                        $pending=$pending+1;
                    else if ((strtoupper(trim($count_data[$i]->status))=="APPROVED" || strtoupper(trim($count_data[$i]->status))=="ACTIVE") && 
                                strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED")
                        $delivered=$delivered+1;
                    else if ((strtoupper(trim($count_data[$i]->status))=="APPROVED" || strtoupper(trim($count_data[$i]->status))=="ACTIVE") && 
                                strtoupper(trim($count_data[$i]->delivery_status))=="CANCELLED")
                        $cancelled=$cancelled+1;
                }
            }
            $data['selectedstatus']=$selectedstatus;
            $data['pending']=$pending;
            $data['delivered']=$delivered;
            $data['cancelled']=$cancelled;
            $data['all']=count($count_data);
            $data['status']=$status;

            load_view('order/order_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function set_delivery_status(){
        $this->order_model->set_delivery_status();
        redirect(base_url().'index.php/order');
    }

    public function edit($id){
        $result=$this->order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->order_model->get_access();
                $data['distributor'] = $this->order_model->get_distributors('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['data'] = $this->order_model->get_data('', $id);
                $data['order_items'] = $this->order_model->get_order_items($id);
                
                load_view('order/order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save($id=""){
        $id = $this->order_model->save_data($id);
        redirect(base_url().'index.php/order');
    }

    public function test_offer_api(){
        load_view_without_data('order/test_offer_api');
    }

    public function set_offer_data(){
        $response = array();

        try{
            $response = $this->order_model->set_offer_data();
        } catch (Exception $e) {
            $response = array(
                            'status'=>'Error',
                            'message'=>$e->getMessage()
                        );
        } finally {
            echo json_encode($response);
        }

        return $response;
    }

    public function sodexo(){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            $curusr = $this->session->userdata('session_id');

            $data['access']=$result;

            $sql = "select * from sodexo_transaction order by modified_on desc";
            $data['data']=$this->db->query($sql)->result();

            load_view('order/sodexo_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                              
            break;
            default:
                if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: hlaSKUbnU9XWXTFaFhtPVHd0Hx6NQzYYNv0hQNTwUeDirXymcOSpEiuUXK4GGAGi',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // echo json_encode($curl);
        // echo '<br/><br/>';
        // echo $curl;
        // echo '<br/><br/>';

        $info = curl_getinfo($curl);
        // echo json_encode($info);
        // echo '<br/><br/>';

        // EXECUTE:
        $result = curl_exec($curl);

        $info = curl_getinfo($curl);
        // echo json_encode($info);
        // echo '<br/><br/>';

        if(!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        return $result;
    }

    public function set_transaction($request_id="", $amount=0, $mobile_no="", $email_id="") {
        $now=date('Y-m-d H:i:s');

        if($mobile_no!=""){
            $mobile_no = urldecode($mobile_no);
            $mobile_no = str_replace('+91', '', $mobile_no);
            $mobile_no = str_replace(' ', '', $mobile_no);
            // echo $mobile_no;
            // echo '<br/><br/>';
        }

        if($email_id!=""){
            $email_id = urldecode($email_id);
            // echo $email_id;
            // echo '<br/><br/>';
        }

        $amount = str_replace(',', '', $amount);
        

        $amount_arr = array("currency"=>"INR", "value"=>$amount);
        $merchantInfo = array("aid"=>"201712", "mid"=>"092010001124019", "tid"=>"92198782");
        $purposes = array(array("purpose"=>"FOOD", "amount"=>$amount_arr));
        // $purposes = array("purpose"=>"FOOD", "amount"=>$amount);

        // $hash = "req_spar_vbdjkahffoasdh874627wqufid";
        // $hash = password_hash('Delta123', PASSWORD_DEFAULT);
        // $request_id = "Delta123";

        // $source_id = "src_wqe47hxfjksor89y4";
        
        $source_id = "";

        if($mobile_no!="" && $mobile_no!="0" && $mobile_no!=null && $email_id!="" && $email_id!="0" && $email_id!=null) {
            $sql = "select * from sodexo_source_id where mobile_no = '$mobile_no' and email_id = '$email_id'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0) {
                if(isset($result[0]->source_id)) $source_id = $result[0]->source_id;
            }
        }
        if($source_id=="" || $source_id=="0" || $source_id==null) {
            if($mobile_no!="" && $mobile_no!="0" && $mobile_no!=null) {
                $sql = "select * from sodexo_source_id where mobile_no = '$mobile_no'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0) {
                    if(isset($result[0]->source_id)) $source_id = $result[0]->source_id;
                }
            }
        }
        if($source_id=="" || $source_id=="0" || $source_id==null) {
            if($email_id!="" && $email_id!="0" && $email_id!=null) {
                $sql = "select * from sodexo_source_id where email_id = '$email_id'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0) {
                    if(isset($result[0]->source_id)) $source_id = $result[0]->source_id;
                }
            }
        }

        $new_request_id = $request_id;
        $id = '';

        $sql = "select * from sodexo_transaction where request_id = '$request_id' and transaction_state <> 'AUTHORIZED'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0) {
            $id = $result[0]->id;

            if(isset($result[0]->counter)) {
                $counter = intval($result[0]->counter);
            } else {
                $counter = 0;
            }

            $counter = $counter + 1;

            $data = array("counter"=>$counter);

            $this->db->where('request_id', $request_id);
            $this->db->update('sodexo_transaction', $data);

            $new_request_id = $request_id.'-'.$counter;
            $data = array("request_id"=>$request_id,
                            "counter"=>$counter,
                            "new_request_id"=>$new_request_id,
                            "created_on" => $now,
                            "modified_on" => $now);
            $this->db->insert('sodexo_request_id', $data);
        }

        if($source_id!="") {
            $data = array("requestId"=>$new_request_id,
                            "sourceId"=>$source_id,
                            "amount"=>$amount_arr,
                            "merchantInfo"=>$merchantInfo,
                            "purposes"=>$purposes,
                            "failureUrl"=>base_url()."index.php/Order/failed",
                            "successUrl"=>base_url()."index.php/Order/success");
        } else {
            $data = array("requestId"=>$new_request_id,
                            // "sourceId"=>$source_id,
                            "amount"=>$amount_arr,
                            "merchantInfo"=>$merchantInfo,
                            "purposes"=>$purposes,
                            "failureUrl"=>base_url()."index.php/Order/failed",
                            "successUrl"=>base_url()."index.php/Order/success");
        }
        
        $data = json_encode($data);
        // echo $data;
        // echo '<br/><br/>';

        $result = $this->callAPI("POST", "https://pay.gw.zetapay.in/v1.0/sodexo/transactions", $data);
        // echo $result;
        // echo '<br/><br/>';

        $result = json_decode($result);

        $transaction_id = "";
        $transaction_state = "";
        $redirect_user_to = "";

        if(isset($result->transactionId)) {
            $transaction_id = $result->transactionId;
        }
        if(isset($result->transactionState)) {
            $transaction_state = $result->transactionState;
        }
        if(isset($result->sourceId)) {
            if($result->sourceId!='' && $result->sourceId!="0" && $result->sourceId!=null){
                if($source_id != $result->sourceId) {
                    $this->set_source_id($source_id, $mobile_no, $email_id);
                }
            }
        }
        if(isset($result->redirectUserTo)) {
            $redirect_user_to = $result->redirectUserTo;
        }

        $data = array(
            'request_id' => $request_id,
            'amount' => $amount,
            'mobile_no' => $mobile_no,
            'email_id' => $email_id,
            'source_id' => $source_id,
            'transaction_id' => $transaction_id,
            'transaction_state' => $transaction_state,
            'redirect_user_to' => $redirect_user_to,
            'modified_on' => $now
        );

        // echo json_encode($data);
        // echo '<br/><br/>';

        if($id=='') {
            $data['created_on'] = $now;
            $this->db->insert('sodexo_transaction', $data);
        } else {
            $this->db->where('id', $id);
            $this->db->update('sodexo_transaction', $data);
        }

        if($redirect_user_to==""){
            redirect('https://eatanytime.in/pages/payment-failed', 'refresh');
        } else {
            redirect($redirect_user_to, 'refresh');
        }
    }

    public function success() {
        $reason = $this->input->get('reason');
        $request_id = $this->input->get('q');

        // $request_id = 'Request201';
        // echo $request_id;
        // echo '<br/><br/>';
        // $request_id = base64_encode($request_id);
        // echo $request_id;
        // echo '<br/><br/>';
        // $request_id = base64_decode($request_id);
        // echo $request_id;
        // echo '<br/><br/>';

        $this->get_transaction($request_id);

        // echo 'Transaction Successfull.';

        redirect('https://eatanytime.in/pages/payment-successful', 'refresh');
    }

    public function failed() {
        $reason = $this->input->get('reason');
        $request_id = $this->input->get('q');

        // echo $reason;
        // echo '<br/><br/>';
        // echo $request_id;
        // echo '<br/><br/>';

        $this->get_transaction($request_id, $reason);

        // echo 'Transaction Failed';

        redirect('https://eatanytime.in/pages/payment-failed', 'refresh');
    }

    public function get_transaction($request_id="", $reason="") {
        $result = $this->callAPI("GET", "https://pay.gw.zetapay.in/v1.0/sodexo/transactions/request_id/".$request_id, '');
        // echo $result;
        // echo '<br/><br/>';

        $amount = "";
        $source_id = "";
        $transaction_id = "";
        $transaction_state = "";
        $failure_reason = "";
        $request_time = "";
        $retrieval_reference_number = "";
        $transaction_receipt = "";
        $authorised_amount = 0;
        $receipt_id = "";
        $payee_info = "";
        $payer_info = "";
        $authorisation_time = "";
        $trace_id = "";
        $error_code = "";
        $error_type = "";
        $error_message = "";
        $additional_info = "";

        $result = json_decode($result);

        if(isset($result->amount)) {
            $amount_arr = $result->amount;
            if(isset($amount_arr->value)) {
                $amount = $amount_arr->value;
            }
        }
        if(isset($result->transactionId)) {
            $transaction_id = $result->transactionId;
        }
        if(isset($result->transactionState)) {
            $transaction_state = $result->transactionState;
        }
        if(isset($result->failureReason)) {
            $failure_reason = $result->failureReason;
        }
        if($failure_reason==""){
            $failure_reason = $reason;
        }
        if(isset($result->sourceId)) {
            $source_id = $result->sourceId;
        }
        if(isset($result->requestTime)) {
            $request_time = $result->requestTime;
        }
        if(isset($result->retrievalReferenceNumber)) {
            $retrieval_reference_number = $result->retrievalReferenceNumber;
        }
        if(isset($result->transactionReceipt)) {
            $transaction_receipt = $result->transactionReceipt;

            if(isset($transaction_receipt->authorisedAmount)) {
                $authorisedAmount = $transaction_receipt->authorisedAmount;
                if(isset($authorisedAmount->amount)) {
                    $authorised_amount = $authorisedAmount->amount;
                }
            }

            if(isset($transaction_receipt->receiptID)) {
                $receipt_id = $transaction_receipt->receiptID;
            }
            if(isset($transaction_receipt->payeeInfo)) {
                $payee_info = json_encode($transaction_receipt->payeeInfo);
            }
            if(isset($transaction_receipt->payerInfo)) {
                $payer_info = json_encode($transaction_receipt->payerInfo);
            }
            if(isset($transaction_receipt->authorisationTime)) {
                $authorisation_time = $transaction_receipt->authorisationTime;
            }

            $transaction_receipt = json_encode($transaction_receipt);
        }

        if(isset($result->traceId)) {
            $trace_id = $result->traceId;
        }
        if(isset($result->errorCode)) {
            $error_code = $result->errorCode;
        }
        if(isset($result->errorType)) {
            $error_type = $result->errorType;
        }
        if(isset($result->errorMessage)) {
            $error_message = $result->errorMessage;
        }
        if(isset($result->additionalInfo)) {
            $additional_info = $result->additionalInfo;
        }

        $now=date('Y-m-d H:i:s');

        $data = array(
                    'source_id'=>$source_id,
                    'transaction_id'=>$transaction_id,
                    'transaction_state'=>$transaction_state,
                    'failure_reason'=>$failure_reason,
                    'request_time'=>$request_time,
                    'retrieval_reference_number'=>$retrieval_reference_number,
                    'transaction_receipt'=>$transaction_receipt,
                    'authorised_amount'=>$authorised_amount,
                    'receipt_id'=>$receipt_id,
                    'payee_info'=>$payee_info,
                    'payer_info'=>$payer_info,
                    'authorisation_time'=>$authorisation_time,
                    'trace_id'=>$trace_id,
                    'error_code'=>$error_code,
                    'error_type'=>$error_type,
                    'error_message'=>$error_message,
                    'additional_info'=>$additional_info,
                    'modified_on'=>$now
                );

        $id = '';

        $sql = "select * from sodexo_transaction where request_id = '$request_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0) {
            $id = $result[0]->id;
            $request_id = $result[0]->request_id;
            $mobile_no = $result[0]->mobile_no;
            $email_id = $result[0]->email_id;
        } else {
            $sql = "select * from sodexo_request_id where request_id = '$request_id' or new_request_id = '$request_id'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0) {
                $request_id = $result[0]->request_id;

                $sql = "update sodexo_request_id set status='".$transaction_state."', modified_on='".$now."' where id = '".$result[0]->id."'";
                $this->db->query($sql);

                $sql = "select * from sodexo_transaction where request_id = '$request_id'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0) {
                    $id = $result[0]->id;
                    $request_id = $result[0]->request_id;
                    $mobile_no = $result[0]->mobile_no;
                    $email_id = $result[0]->email_id;
                }
            }
        }

        if($id!='') {
            // echo $source_id;
            // echo '<br/><br/>';
            // echo $mobile_no;
            // echo '<br/><br/>';
            // echo $email_id;
            // echo '<br/><br/>';
            // echo json_encode($result);
            // echo '<br/><br/>';

            $this->db->where('id', $id);
            $this->db->update('sodexo_transaction', $data);

            if($source_id!=''){
                if($mobile_no!='' || $email_id!='') {
                    $this->set_source_id($source_id, $mobile_no, $email_id);
                }
            }

            // $email_id = $result[0]->email_id;
            // if($email_id!='') {
            //     $this->send_email($email_id, $request_id, $authorised_amount);
            // }

        } else {
            // echo $source_id;
            // echo '<br/><br/>';
            // echo $mobile_no;
            // echo '<br/><br/>';
            // echo $email_id;
            // echo '<br/><br/>';
            // echo json_encode($result);
            // echo '<br/><br/>';

            $data['request_id'] = $request_id;
            $data['amount'] = $amount;
            $data['redirect_user_to'] = "https://pay.gw.zetapay.in/v1.0/sodexo/transactions/initiate?q=".$transaction_id;
            $data['created_on'] = $now;

            // echo json_encode($data);
            // echo '<br/><br/>';

            $this->db->insert('sodexo_transaction', $data);
        }
    }

    public function send_email($email_to, $request_id, $amount) {
        // $now=date('Y-m-d H:i:s');
        // $curusr=$this->session->userdata('session_id');
        $login_name = $this->session->userdata('login_name');
        
        // $email_ref_id = '';
        // $email_type = 'distributor_po_mismatch';
        $email_from = 'orders@eatanytime.in';
        $email_sender = 'Wholesome Habits Pvt Ltd';
        $email_to = 'prasad.bhisale@otbconsulting.co.in';
        $email_cc = 'prasad.bhisale@otbconsulting.co.in';
        $email_bcc = 'prasad.bhisale@otbconsulting.co.in';
        $email_subject = 'Order Details';
        $email_body = 'Hi, Order No '.$request_id.' for amount '.$amount.' is processed successfully.';
        
        // $email_cc = 'dhaval.maru@otbconsulting.co.in';

        $message = '<html>
                        <head>
                        <style type="text/css">
                            pre {
                                font: small/1.5 Arial,Helvetica,sans-serif;
                            }
                        </style>
                        </head>
                        <body><pre>'.$email_body.'</pre><br/><br/>
                        Team EAT Anytime<br/><br/>'.ucwords(trim($login_name)).'
                        </body>
                        </html>';

        $mailSent=send_email_new($email_from, $email_sender, $email_to, $email_subject, $message, $email_bcc, $email_cc);

        if($mailSent==1){
            $status = 1;
        } else {
            $status = 0;
        }

        return $status;
    }

    public function set_source_id($source_id="", $mobile_no="", $email_id="") {
        // echo $source_id;
        // echo '<br/><br/>';
        // echo $mobile_no;
        // echo '<br/><br/>';
        // echo $email_id;
        // echo '<br/><br/>';

        if($source_id!="") {
            $blFlag = false;
            $id = 0;
            $sourceId = '';

            if($mobile_no!="" && $mobile_no!="0" && $mobile_no!=null && $email_id!="" && $email_id!="0" && $email_id!=null) {
                $sql = "select * from sodexo_source_id where mobile_no = '$mobile_no' and email_id = '$email_id'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0) {
                    if(isset($result[0]->id)) {
                        $blFlag = true;
                        $id = $result[0]->id;
                        $sourceId = $result[0]->source_id;
                    }
                }
            }
            if($id=="" || $id=="0" || $id==null || $blFlag==false) {
                if($mobile_no!="" && $mobile_no!="0" && $mobile_no!=null) {
                    $sql = "select * from sodexo_source_id where mobile_no = '$mobile_no'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)>0) {
                        if(isset($result[0]->id)) {
                            $blFlag = true;
                            $id = $result[0]->id;
                            $sourceId = $result[0]->source_id;
                        }
                    }
                }
            }
            if($id=="" || $id=="0" || $id==null || $blFlag==false) {
                if($email_id!="" && $email_id!="0" && $email_id!=null) {
                    $sql = "select * from sodexo_source_id where email_id = '$email_id'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)>0) {
                        if(isset($result[0]->id)) {
                            $blFlag = true;
                            $id = $result[0]->id;
                            $sourceId = $result[0]->source_id;
                        }
                    }
                }
            }

            // echo $id;
            // echo '<br/><br/>';
            // echo $source_id;
            // echo '<br/><br/>';
            // echo $mobile_no;
            // echo '<br/><br/>';
            // echo $email_id;
            // echo '<br/><br/>';

            if(isset($mobile_no) || isset($email_id)) {
                if(($mobile_no!="" && $mobile_no!="0") || ($email_id!="" && $email_id!="0")) {
                    if($sourceId!=$source_id) {
                        $now=date('Y-m-d H:i:s');
                        
                        $data = array(
                                    'source_id'=>$source_id,
                                    'modified_on'=>$now
                                );

                        // echo json_encode($data);
                        // echo '<br/><br/>';

                        if($id!="" && $id!="0" && $id!=null && $blFlag==true) {
                            // echo 'Update';
                            // echo '<br/><br/>';
                            $this->db->where('id', $id);
                            $this->db->update('sodexo_source_id', $data);
                        } else {
                            // echo 'Insert';
                            // echo '<br/><br/>';
                            $data['mobile_no'] = $mobile_no;
                            $data['email_id'] = $email_id;
                            $data['created_on'] = $now;
                            $this->db->insert('sodexo_source_id', $data);
                        }
                    }
                }
            }
        }
    }

    public function sodexo_upload_files(){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            $curusr = $this->session->userdata('session_id');

            $data['access']=$result;

            $sql = "select * from sodexo_upload_files order by modified_on desc";
            $data['data']=$this->db->query($sql)->result();

            load_view('order/sodexo_upload_files', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function send_sodexo_upload_file() {
        $this->order_model->send_sodexo_upload_file();
    }
}
?>