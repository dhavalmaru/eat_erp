<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Shopify extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('Shopify_model');
        $this->load->model('distributor_out_model');
        $this->load->model('tax_invoice_model');
        $this->load->library('excel');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->Shopify_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            // $data['data'] = $this->Shopify_model->get_data();

            load_view('shopify/shopify_upload', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data(){
        // $status = 'Approved';

        // $draw = intval($this->input->get("draw"));
        // $start = intval($this->input->get("start"));
        // $length = intval($this->input->get("length"));
        // $status = intval($this->input->get("status"));

        // $draw = 1;
        // $start = 0;
        // $length = 10;
        // $search_value = '';
        // $status = '';

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $status = $this->input->post("status");

        $search_val = $search['value'];

        // echo $draw;
        // echo '<br/><br/>';
        // echo $start;
        // echo '<br/><br/>';
        // echo $length;
        // echo '<br/><br/>';
        // echo json_encode($search);
        // echo '<br/><br/>';
        // echo $status;
        // echo '<br/><br/>';
        // echo $search_val;
        // echo '<br/><br/>';

        $result = $this->Shopify_model->get_list_data($start, $length, $search_val);
        // echo json_encode($result);
        // echo '<br/><br/>';

        $totalRecords = 0;
        $count = $result['count'];
        if(count($count)>0) $totalRecords = $count[0]->total_records;

        $r = $result['rows'];

        $data = array();

        for($i=0;$i<count($r);$i++){
            $action = '';

            if($r[$i]->status=='Uploading'){
                $action = '<a href="'.base_url().'index.php/shopify/upload_file_data/'.$r[$i]->id.'">
                                <button type="button" class="btn btn-default">Upload Data</button>
                            </a>';
            } else if($r[$i]->status=='Pending') {
                // $action = '<a href="'.base_url().'index.php/shopify/approve_file_data/'.$r[$i]->id.'" style="margin-right: 5px;">
                //                 <button type="button" class="btn btn-success">Approve File</button>
                //             </a>
                //             <a href="'.base_url().'index.php/shopify/reject_file_data/'.$r[$i]->id.'">
                //                 <button type="button" class="btn btn-danger">Reject File</button>
                //             </a>';
                $action = '';
            } else if($r[$i]->status=='Approved') {
                // $action = '<a href="'.base_url().'index.php/shopify/get_file_invoices/'.$r[$i]->id.'" style="margin-right: 5px;" target="_blank">
                //                 <button type="button" class="btn btn-success">Get Invoices</button>
                //             </a>';
                $action = '';
            }

            $data[] = array(
                        $i+$start+1,

                        '<span style="display:none;">'.
                            (($r[$i]->upload_date!=null && $r[$i]->upload_date!='')?date('Ymd',strtotime($r[$i]->upload_date)):'')
                        .'</span>'.
                        (($r[$i]->upload_date!=null && $r[$i]->upload_date!='')?date('d/m/Y',strtotime($r[$i]->upload_date)):''),

                        $r[$i]->file_name,

                        $r[$i]->status,

                        $r[$i]->remarks,

                        '<a href="'.base_url().'assets/uploads/shopify/'.$r[$i]->file_name.'" target="_blank">
                            <span class="fa fa-download" style="font-size:20px;"></span>
                        </a>',

                        (($r[$i]->error_file_name!=null && $r[$i]->error_file_name!='')? '<a href="'.base_url().'assets/uploads/shopify/'.$r[$i]->error_file_name.'" target="_blank">
                            <span class="fa fa-download" style="font-size:20px;"></span>
                        </a>': ''),

                        (($r[$i]->check_file_name!=null && $r[$i]->check_file_name!='')? '<a href="'.base_url().'assets/uploads/shopify/'.$r[$i]->check_file_name.'" target="_blank">
                            <span class="fa fa-download" style="font-size:20px;"></span>
                        </a>': ''),

                        $action
                    );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => $totalRecords,
                        "recordsFiltered" => $totalRecords,
                        "data" => $data
                        // ,
                        // "columns" => $columns
                    );
        echo json_encode($output);
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
                // $temp = 1; // Do Nothing
                if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 961da4084030e115a2c1bfc90c4e17b9',
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

    public function orders() {
        // $start_date = '2020-10-01';
        // $end_date = '2020-10-03';

        // for($i=0; $i<31; $i++){
        //     $updated_at_min = $start_date."T00:00:00";
        //     $updated_at_max = $end_date."T00:00:00";

        //     echo $updated_at_min;
        //     echo "<br/><br/>";
        //     echo $updated_at_max;
        //     echo "<br/><br/>";

        //     $this->get_orders($updated_at_min, $updated_at_max);

        //     $updated_at_min = $start_date."T12:00:00";
        //     $updated_at_max = $end_date."T12:00:00";

        //     echo $updated_at_min;
        //     echo "<br/><br/>";
        //     echo $updated_at_max;
        //     echo "<br/><br/>";

        //     $this->get_orders($updated_at_min, $updated_at_max);

        //     $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
        //     $end_date = date("Y-m-d", strtotime("+1 day", strtotime($end_date)));
        // }

        $date = date('Y-m-d');
        $time = date('H:i:s', time() - 5400);
        echo "Time: ".$date."T".$time."Z<br/><br/>";
        $updated_at_min = $date."T".$time;
        $this->get_orders($updated_at_min);

        $date = date('Y-m-d');
        $time = date('H:i:s', time() - 32400);
        echo "Time: ".$date."T".$time."Z<br/><br/>";
        $updated_at_min = $date."T".$time;
        $this->get_orders($updated_at_min);

        $date = date('Y-m-d');
        $time = date('H:i:s', time() - 44100);
        echo "Time: ".$date."T".$time."Z<br/><br/>";
        $updated_at_min = $date."T".$time;
        $this->get_orders($updated_at_min);

        $date = date('Y-m-d', strtotime('-1 days'));
        $time = date('H:i:s', time() - 23400);
        echo "Time: ".$date."T".$time."Z<br/><br/>";
        $updated_at_min = $date."T".$time;
        $this->get_orders($updated_at_min);

        $date = date('Y-m-d', strtotime('-1 days'));
        $time = date('H:i:s', time() - 44100);
        echo "Time: ".$date."T".$time."Z<br/><br/>";
        $updated_at_min = $date."T".$time;
        $this->get_orders($updated_at_min);

        $date = date('Y-m-d', strtotime('-2 days'));
        $time = date('H:i:s', time() - 23400);
        echo "Time: ".$date."T".$time."Z<br/><br/>";
        $updated_at_min = $date."T".$time;
        $this->get_orders($updated_at_min);

        $date = date('Y-m-d', strtotime('-2 days'));
        $time = date('H:i:s', time() - 44100);
        echo "Time: ".$date."T".$time."Z<br/><br/>";
        $updated_at_min = $date."T".$time;
        $this->get_orders($updated_at_min);
    }

    public function get_orders($updated_at_min="", $updated_at_max="") {
        $now=date('Y-m-d H:i:s');
        $curusr='191';

        $order_id = '';

        // $updated_at_min="2020-10-10T14:00:00";

        // $result = $this->callAPI("GET", "https://961da4084030e115a2c1bfc90c4e17b9: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@eat-anytime.myshopify.com/admin/api/2020-10/orders.json?updated_at_min=".$updated_at_min, "");

        // $result = $this->callAPI("GET", "https://961da4084030e115a2c1bfc90c4e17b9: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@eat-anytime.myshopify.com/admin/api/2020-10/orders.json?financial_status=pending&limit=250&since_id=".$order_id, "");

        // $result = $this->callAPI("GET", "https://961da4084030e115a2c1bfc90c4e17b9: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@eat-anytime.myshopify.com/admin/api/2020-10/orders.json?financial_status=pending&limit=250&updated_at_min=".$updated_at_min."&updated_at_max=".$updated_at_max, "");

        $result = $this->callAPI("GET", "https://961da4084030e115a2c1bfc90c4e17b9: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@eat-anytime.myshopify.com/admin/api/2020-10/orders.json?financial_status=pending&limit=250&updated_at_min=".$updated_at_min, "");

        // echo "Response";
        // echo '<br/><br/>';
        // echo json_encode($result);
        // echo '<br/><br/>';

        // var_dump($result);
        // echo '<br/><br/>';

        $res = json_decode($result);
        $orders = $res->orders;

        // var_dump($res);
        // echo '<br/><br/>';

        echo "order Count: ".count($orders);
        echo '<br/><br/>';

        for($i=0; $i<count($orders); $i++){
            // echo json_encode($orders[$i]);
            // echo '<br/><br/>';

            $id = '';
            $order_id = '';
            $name = '';
            $financial_status = '';

            if(isset($orders[$i]->id)) $order_id = $orders[$i]->id;
            if(isset($orders[$i]->name)) $name = $orders[$i]->name;
            if(isset($orders[$i]->financial_status)) $financial_status = $orders[$i]->financial_status;

            $sql = "select * from shopify_orders where order_id = '$order_id'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0){
                $id = $result[0]->id;
            }

            if($id!='') {
                $data = array(
                            'financial_status'=>$financial_status,
                            'modified_by'=>$curusr,
                            'modified_on'=>$now
                        );

                $this->db->where('id', $id);
                $this->db->update('shopify_orders', $data);
            } else {
                $gateway = '';
                $created_at = '';
                $total_price = 0;
                $subtotal_price = 0;
                $total_tax = 0;
                $total_discounts = 0;
                $total_line_items_price = 0;
                $billing_address = [];
                $shipping_address = [];
                $customer = [];

                if(isset($orders[$i]->gateway)) $gateway = $orders[$i]->gateway;
                if(isset($orders[$i]->created_at)) $created_at = $orders[$i]->created_at;
                if(isset($orders[$i]->billing_address)) $billing_address = $orders[$i]->billing_address;
                if(isset($orders[$i]->shipping_address)) $shipping_address = $orders[$i]->shipping_address;
                if(isset($orders[$i]->customer)) $customer = $orders[$i]->customer;

                $date_of_processing = date('Y-m-d');
                if($created_at!=''){
                    if(strpos($created_at, 'T')!==false){
                        $date_of_processing = substr($created_at, 0, strpos($created_at, 'T'));
                    }
                }

                if(isset($orders[$i]->total_price)) {
                    if(is_numeric($orders[$i]->total_price)) {
                        $total_price = doubleval($orders[$i]->total_price);
                    }
                }
                if(isset($orders[$i]->subtotal_price)) {
                    if(is_numeric($orders[$i]->subtotal_price)) {
                        $subtotal_price = doubleval($orders[$i]->subtotal_price);
                    }
                }
                if(isset($orders[$i]->total_tax)) {
                    if(is_numeric($orders[$i]->total_tax)) {
                        $total_tax = doubleval($orders[$i]->total_tax);
                    }
                }
                if(isset($orders[$i]->total_discounts)) {
                    if(is_numeric($orders[$i]->total_discounts)) {
                        $total_discounts = doubleval($orders[$i]->total_discounts);
                    }
                }
                if(isset($orders[$i]->total_line_items_price)) {
                    if(is_numeric($orders[$i]->total_line_items_price)) {
                        $total_line_items_price = doubleval($orders[$i]->total_line_items_price);
                    }
                }

                if(strtoupper(trim($gateway))=='CRED'){
                    $distributor_id = 1728;
                } else if(strtoupper(trim($gateway))=='CASH_ON_DELIVERY'){
                    $distributor_id = 1751;
                } else {
                    $distributor_id = 626;
                }

                $delivery_status = 'delivered';
                $due_date = $date_of_processing;
                $delivery_date = $date_of_processing;
                $date_of_dispatch = $date_of_processing;

                $amount = $subtotal_price - $total_tax;
                $tax_amount = $total_tax;
                $final_amount = $subtotal_price;
                if($total_line_items_price!=0){
                    $discount = round($total_discounts*100/$total_line_items_price,2);
                } else {
                    $discount = 0;
                }
                $shipping_charges = $total_price-$subtotal_price;
                $invoice_amount = round($total_price, 0);
                $round_off_amount = $invoice_amount - $total_price;

                $b_address1 = '';
                $b_phone = '';
                $b_city = '';
                $b_zip = '';
                $b_province = '';
                $b_country = '';
                $b_address2 = '';
                $b_name = '';

                if(isset($billing_address->address1)) $b_address1 = $billing_address->address1;
                if(isset($billing_address->phone)) $b_phone = $billing_address->phone;
                if(isset($billing_address->city)) $b_city = $billing_address->city;
                if(isset($billing_address->zip)) $b_zip = $billing_address->zip;
                if(isset($billing_address->province)) $b_province = $billing_address->province;
                if(isset($billing_address->country)) $b_country = $billing_address->country;
                if(isset($billing_address->address2)) $b_address2 = $billing_address->address2;
                if(isset($billing_address->name)) $b_name = $billing_address->name;

                $s_address1 = '';
                $s_phone = '';
                $s_city = '';
                $s_zip = '';
                $s_province = '';
                $s_country = '';
                $s_address2 = '';
                $s_name = '';

                if(isset($shipping_address->address1)) $s_address1 = $shipping_address->address1;
                if(isset($shipping_address->phone)) $s_phone = $shipping_address->phone;
                if(isset($shipping_address->city)) $s_city = $shipping_address->city;
                if(isset($shipping_address->zip)) $s_zip = $shipping_address->zip;
                if(isset($shipping_address->province)) $s_province = $shipping_address->province;
                if(isset($shipping_address->country)) $s_country = $shipping_address->country;
                if(isset($shipping_address->address2)) $s_address2 = $shipping_address->address2;
                if(isset($shipping_address->name)) $s_name = $shipping_address->name;

                $client_name = $b_name;
                $address = $b_address1.' '.$b_address2;
                $city = $b_city;
                $pincode = $b_zip;
                $state = $b_province;
                $country = $b_country;
                $mobile_no = $b_phone;

                $sql = "select * from state_master where state_name = '$state'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $state_code = $result[0]->state_code;
                } else {
                    $state_code = null;
                }

                $cgst_amount = 0;
                $sgst_amount = 0;
                $igst_amount =0;

                if($state_code=='27'){
                    $cgst_amount = $tax_amount/2;
                    $sgst_amount = $tax_amount/2;
                } else {
                    $igst_amount = $tax_amount;
                }

                if($b_address1!=$s_address1 || $b_address2!=$s_address2 || $b_phone!=$s_phone || $b_city!=$s_city || $b_zip!=$s_zip || $b_province!=$s_province || $b_country!=$s_country) {
                    $shipping_address = 'no';
                    $con_name = $s_name;
                    $con_address = $s_address1.' '.$s_address2;
                    $con_city = $s_city;
                    $con_pincode = $s_zip;
                    $con_state = $s_province;
                    $con_country = $s_country;

                    $sql = "select * from state_master where state_name = '$con_state'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0){
                        $con_state_code = $result[0]->state_code;
                    } else {
                        $con_state_code = null;
                    }
                } else {
                    $shipping_address = 'yes';
                    $con_name = null;
                    $con_address = null;
                    $con_city = null;
                    $con_pincode = null;
                    $con_state = null;
                    $con_country = null;
                    $con_state_code = null;
                }
                
                $data = array(
                            'order_id'=>$order_id,
                            'date_of_processing'=>$date_of_processing,
                            'depot_id'=>'2',
                            'distributor_id'=>$distributor_id,
                            'amount'=>$amount,
                            'tax_per'=>1,
                            'tax_amount'=>$tax_amount,
                            'final_amount'=>$final_amount,
                            'due_date'=>$due_date,
                            'order_no'=>$name,
                            'status'=>'Approved',
                            'remarks'=>'This is system generated entry.',
                            'created_by'=>$curusr,
                            'created_on'=>$now,
                            'modified_by'=>$curusr,
                            'modified_on'=>$now,
                            'client_name'=>$client_name,
                            'address'=>$address,
                            'city'=>$city,
                            'pincode'=>$pincode,
                            'state'=>$state,
                            'country'=>$country,
                            'mobile_no'=>$mobile_no,
                            'discount'=>$discount,
                            'delivery_status'=>$delivery_status,
                            'delivery_date'=>$delivery_date,
                            'cgst'=>1,
                            'sgst'=>1,
                            'igst'=>1,
                            'cgst_amount'=>$cgst_amount,
                            'sgst_amount'=>$sgst_amount,
                            'igst_amount'=>$igst_amount,
                            'reverse_charge'=>'no',
                            'shipping_address'=>$shipping_address,
                            'con_name'=>$con_name,
                            'con_address'=>$con_address,
                            'con_city'=>$con_city,
                            'con_pincode'=>$con_pincode,
                            'con_state'=>$con_state,
                            'con_country'=>$con_country,
                            'con_state_code'=>$con_state_code,
                            'con_gst_number'=>null,
                            'state_code'=>$state_code,
                            'round_off_amount'=>$round_off_amount,
                            'invoice_amount'=>$invoice_amount,
                            'invoice_date'=>null,
                            'freezed'=>0,
                            'basis_of_sales'=>'PO Number',
                            'email_date_time'=>$now,
                            'date_of_dispatch'=>$date_of_dispatch,
                            'shipping_charges'=>$shipping_charges,
                            'financial_status'=>$financial_status
                        );

                $this->db->insert('shopify_orders', $data);
            }
            
            echo json_encode($data);
            echo '<br/><br/>';
        }

        echo 'Order Id : '.$order_id;
        echo '<br/><br/>';

        return $order_id;
    }

    public function get_transaction($order_id="") {
        $now=date('Y-m-d H:i:s');
        $curusr='191';

        // $result = $this->callAPI("GET", "https://pay.gw.zetapay.in/v1.0/sodexo/transactions/request_id/".$request_id, '');

        // echo "Get Transaction";
        // echo '<br/><br/>';

        $result = $this->callAPI("GET", "https://961da4084030e115a2c1bfc90c4e17b9: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@eat-anytime.myshopify.com/admin/orders/".$order_id."/transactions.json", "");

        // echo "Response";
        // echo '<br/><br/>';
        // echo json_encode($result);
        // echo '<br/><br/>';

        // var_dump($result);
        // echo '<br/><br/>';

        $res = json_decode($result);
        $transactions = $res->transactions;

        for($i=0; $i<count($transactions); $i++){
            // echo json_encode($orders[$i]);
            // echo '<br/><br/>';

            $parent_id = '';
            $amount = 0;

            if(isset($transactions[$i]->id)) $parent_id = $transactions[$i]->id;
            if(isset($transactions[$i]->amount)) $amount = $transactions[$i]->amount;

            // $transaction = array(
            //                     "kind"=>"capture",
            //                     "gateway"=>"manual",
            //                     "amount"=>$amount,
            //                     "parent_id"=>$parent_id,
            //                     "status"=>"success",
            //                     "currency"=>"INR"
            //                 );

            $transaction = array(
                                "kind"=>"sale",
                                "source"=>"external",
                                "amount"=>$amount,
                                "parent_id"=>$parent_id,
                                "status"=>"success",
                                "currency"=>"INR"
                            );

            $data['transaction'] = $transaction;

            $data = json_encode($data);
            echo $data;
            echo '<br/><br/>';

            $result = $this->callAPI("POST", "https://961da4084030e115a2c1bfc90c4e17b9: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@eat-anytime.myshopify.com/admin/orders/".$order_id."/transactions.json", $data);
            echo $result;
            echo '<br/><br/>';

            return $result;
        }
    }

    function download_upload_format(){
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Shopify_upload_format.xlsx';
        // $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(1);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Paid');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Unpaid');
        $status_cnt = 4;

        $objPHPExcel->setActiveSheetIndex(0);
        $row = 5;
        $sql = "select A.*, B.depot_name, C.distributor_name 
                from shopify_orders A 
                left join depot_master B on (A.depot_id=B.id) 
                left join distributor_master C on (A.distributor_id=C.id) 
                where A.financial_status='pending'
                order by A.id";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $data) {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('P'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$A$2:$A$'.($status_cnt-1));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, date('d-m-Y', strtotime($data->date_of_processing)));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data->depot_name);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $data->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $data->client_name);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data->address);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data->city);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data->pincode);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data->mobile_no);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data->order_no);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data->discount);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data->final_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data->cgst_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $data->sgst_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data->igst_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data->amount);
            $row = $row+1;
        }

        $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $filename='Shopify_upload_format.xlsx';
        
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        // header('Content-Type: application/pdf');
        // header('Content-Disposition: attachment;filename="01simple.pdf"');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
        // $objWriter->save('php://output');
    }

    public function upload_file(){
        $now=date('Y-m-d H:i:s');
        $curdate=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');

        $upload_path=$this->config->item('upload_path');
        $path=$upload_path.'shopify';
        if(!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        $path = $path . '/';

        $config = array(
            'upload_path' => $path,
            'allowed_types' => "xlsx",
            'overwrite' => TRUE,
            'max_size' => "2048000", 
            'max_height' => "768",
            'max_width' => "1024"
        );

        $file_name = $_FILES["upload"]['name'];
        if(strrpos($file_name, '.')>0){
            $file_ext = substr($file_name, strrpos($file_name, '.'));
        } else {
            $file_ext = '.xlsx';
        }
        $file_name = substr($file_name, 0, strrpos($file_name, '.'));
        $file_name = str_replace(' ', "_", $file_name);
        $file_name = preg_replace('/[^A-Za-z0-9_\-]/', '', $file_name);
        $new_name = time().'_'.$file_name.$file_ext;

        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload')){ 
            $this->upload->display_errors();
        } else {
            $uploadDetailArray = $this->upload->data();
        }

        $file_name = $uploadDetailArray['file_name'];
        // print_r($file_name); echo '<br/><br/>';
        $filename = $path.$uploadDetailArray['file_name'];
        // $this->upload_file_data($filename);
        // print_r($filename);
        // $filename = str_replace('/', '\\', $filename);
        // print_r($filename);
        // exit;

        $sql = "insert into shopify_upload_files (file_name, file_path, upload_date, status, created_by, created_on, modified_by, modified_on) VALUES ('".$file_name."', '".$path."', '".$curdate."', 'Uploading', '".$curusr."', '".$now."', '".$curusr."', '".$now."')";
        $this->db->query($sql);
        // $file_id = $this->db->insert_id();

        sleep(0.50);

        $this->session->set_flashdata('success', 'File Upload Succeded.<br/>Please upload file data.');
        $this->session->keep_flashdata('success');
        redirect(base_url().'index.php/shopify');
    }

    public function check_stock($type, $depot_id, $item_id, $qty){
        if($type=='Bar'){
            $url = base_url().'index.php/Stock/check_bar_qty_availablity_for_depot';
            $params = array('depot_id' => $depot_id, 'product_id' => $item_id, 'qty' => $qty);
        } else {
            $url = base_url().'index.php/Stock/check_box_qty_availablity_for_depot';
            $params = array('depot_id' => $depot_id, 'box_id' => $item_id, 'qty' => $qty);
        }
        
        $result = 1;
        $query_content = http_build_query($params);
        $fp = fopen($url, 'r', FALSE, // do not use_include_path
        stream_context_create([
            'http' => [
                'header'  => [ // header array does not need '\r\n'
                    'Content-type: application/x-www-form-urlencoded',
                    'Content-Length: ' . strlen($query_content)
                ],
                'method'  => 'POST',
                'content' => $query_content
            ]
        ]));
        if ($fp === FALSE) {
            // echo json_encode(['error' => 'Failed to get contents...']);
        } else {
            $result = stream_get_contents($fp);
        }
        fclose($fp);
        return $result;
    }

    public function upload_file_data($file_id){
        $now=date('Y-m-d H:i:s');
        $curdate=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');

        $sql = "select * from shopify_upload_files where id='$file_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $file_path = $result[0]->file_path;
            $file_name = $result[0]->file_name;
            $filename = $result[0]->file_path.$result[0]->file_name;
        } else {
            $file_path = '';
            $file_name = '';
            $filename = '';
        }

        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($filename);
        $objPHPExcel->setActiveSheetIndex(0);
        $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->setCellValue('R4', 'Error Remark');
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
        $objerror = 0;
        $error_line = '';
        $order_array = [];

        for($i=5; $i<=$highestrow; $i++){
            $creation_date = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
            // $depot = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            // $distributor_name = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            // $name_of_customer = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            // $address = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
            // $city = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            // $pincode = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            // $mobile_no = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            $po_no = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
            // $discount = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
            // $value = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
            $status = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
            $remarks = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
            $error = '';

            //-------------- Validation Start ------------------------------
                $bl_error_line = false;

                if($creation_date==''){
                    $error.='Creation date cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $creation_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($creation_date));
                    if(validateDate($creation_date, 'Y-m-d')==false){
                        $error.='Creation date should be in d-m-Y format.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }
                }

                // if($depot==''){
                //     $error.='Depot Name cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else {
                //     $sql = "select * from depot_master where depot_name='$depot'";
                //     $result = $this->db->query($sql)->result();
                //     if(count($result)==0){
                //         $error.='Depot Name '.$depot.' not found.';
                //         $objerror=1;
                //         if($bl_error_line==false){
                //             $error_line.=$i.', ';
                //             $bl_error_line=true;
                //         }
                //     } else {
                //         $depot_id = $result[0]->id;
                //         $depot_state = $result[0]->state;
                //         $depot_state_code = $result[0]->state_code;
                //     }
                // }
                // if($distributor_name==''){
                //     $error.='Distributor Name cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else {
                //     $sql = "select * from distributor_master where distributor_name='$distributor_name'";
                //     $result = $this->db->query($sql)->result();
                //     if(count($result)==0){
                //         $error.='Distributor Name '.$distributor_name.' not found.';
                //         $objerror=1;
                //         if($bl_error_line==false){
                //             $error_line.=$i.', ';
                //             $bl_error_line=true;
                //         }
                //     } else {
                //         $distributor_id = $result[0]->id;
                //     }
                // }
                // if($name_of_customer==''){
                //     $error.='Name of Customer cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // }
                // if($address==''){
                //     $error.='Address cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // }
                // if($city==''){
                //     $error.='City cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } 
                // // else {
                // //     $sql = "select B.state_name, B.state_code, C.country_name from city_master A 
                // //             left join state_master B on (A.state_id=B.id) 
                // //             left join country_master C on (B.country_id=C.id) 
                // //             where A.city_name='$city'";
                // //     $result = $this->db->query($sql)->result();
                // //     if(count($result)==0){
                // //         $error.='City '.$city.' not found.';
                // //         $objerror=1;
                // //         if($bl_error_line==false){
                // //            $error_line.=$i.', ';
                // //            $bl_error_line=true;
                // //        }
                // //     } else {
                // //         $state_name = $result[0]->state_name;
                // //         $state_code = $result[0]->state_code;
                // //         $country_name = $result[0]->country_name;
                // //     }
                // // }
                // if($pincode==''){
                //     $error.='Pincode cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else {
                //     $sql = "select B.state_name, B.state_code, C.country_name 
                //             from pincode_master A 
                //             left join state_master B on (A.state_id=B.id) 
                //             left join country_master C on (B.country_id=C.id) 
                //             where A.pincode='$pincode'";
                //     $result = $this->db->query($sql)->result();
                //     if(count($result)==0){
                //         $error.='Pincode '.$city.' not found.';
                //         $objerror=1;
                //         if($bl_error_line==false){
                //             $error_line.=$i.', ';
                //             $bl_error_line=true;
                //         }
                //     } else {
                //         $state_name = $result[0]->state_name;
                //         $state_code = $result[0]->state_code;
                //         $country_name = $result[0]->country_name;
                //     }
                // }
                // if($mobile_no==''){
                //     $error.='Mobile No cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // }
                if($po_no==''){
                    $error.='PO No cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $po_no = str_replace('"', '', $po_no);
                    $po_no = str_replace("'", "", $po_no);

                    $sql = "select * from shopify_orders where order_no='$po_no'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)==0){
                        $error.='PO No '.$po_no.' not found.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }

                    // $sql = "select * from distributor_out where order_no='$po_no' and status<>'Rejected' and status<>'InActive'";
                    // $result = $this->db->query($sql)->result();
                    // if(count($result)>0){
                    //     $error.='PO No '.$po_no.' already exist.';
                    //     $objerror=1;
                    //     if($bl_error_line==false){
                    //         $error_line.=$i.', ';
                    //         $bl_error_line=true;
                    //     }
                    // } else {
                    //     $sql = "select * from shopify_upload_details where order_no='$po_no' and status<>'Rejected' and status<>'InActive'";
                    //     $result = $this->db->query($sql)->result();
                    //     if(count($result)>0){
                    //         $error.='PO No '.$po_no.' already exist.';
                    //         $objerror=1;
                    //         if($bl_error_line==false){
                    //             $error_line.=$i.', ';
                    //             $bl_error_line=true;
                    //         }
                    //     }
                    // }
                }
                
                // if($sku_qty==''){
                //     $error.='Quantity cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else if($sku_qty<=0) {
                //     $error.='Quantity should be greater than zero.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else {
                //     $sku_qty = round(doubleval($sku_qty),2);
                // }
                // if($sku_mrp==''){
                //     $error.='MRP cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else if($sku_mrp<=0) {
                //     $error.='MRP should be greater than zero.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else {
                //     $sku_mrp = round(doubleval($sku_mrp),2);
                // }
                // if($sku_value==''){
                //     $error.='Total Realisation Value cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else if($sku_value<=0) {
                //     $error.='Total Realisation Value should be greater than zero.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else {
                //     $sku_value = round(doubleval($sku_value),2);
                // }
                // if($sku_batch_no==''){
                //     $error.='Batch No cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else {
                //     $sql = "select * from batch_master where batch_no='$sku_batch_no'";
                //     $result = $this->db->query($sql)->result();
                //     if(count($result)==0){
                //         $error.='Batch No '.$sku_batch_no.' not found.';
                //         $objerror=1;
                //         if($bl_error_line==false){
                //             $error_line.=$i.', ';
                //             $bl_error_line=true;
                //         }
                //     } else {
                //         $batch_id = $result[0]->id;
                //     }
                // }

                // if($sku_type==''){
                //     $error.='Type cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else if($sku_type!='Bar' && $sku_type!='Box' && $sku_type!='Combo_box'){
                //     $error.='Type should be Bar, Box or Combo_box.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // }
                // if($sku_name==''){
                //     $error.='SKU Name cannot be blank.';
                //     $objerror=1;
                //     if($bl_error_line==false){
                //         $error_line.=$i.', ';
                //         $bl_error_line=true;
                //     }
                // } else {
                //     if($sku_type=='Bar'){
                //         $sql = "select * from product_master where product_name='$sku_name'";
                //         $result = $this->db->query($sql)->result();
                //         if(count($result)==0){
                //             $error.='SKU Name '.$sku_name.' not found.';
                //             $objerror=1;
                //             if($bl_error_line==false){
                //                 $error_line.=$i.', ';
                //                 $bl_error_line=true;
                //             }
                //         } else {
                //             $item_id = $result[0]->id;
                //             $item_grams = $result[0]->grams;
                //             $item_rate = $result[0]->rate;
                //             $item_tax_per = $result[0]->tax_percentage;

                //             $item_data[$a++] = array('sku_type'=>$sku_type,
                //                                     'sku_name'=>$sku_name,
                //                                     'sku_qty'=>$sku_qty,
                //                                     'item_id'=>$item_id,
                //                                     'item_grams'=>$item_grams,
                //                                     'item_rate'=>$item_rate,
                //                                     'item_tax_per'=>$item_tax_per,
                //                                     'combo_box_id'=>0
                //                                 );
                //         }
                //     } else if($sku_type=='Box'){
                //         $sql = "select * from box_master where box_name='$sku_name'";
                //         $result = $this->db->query($sql)->result();
                //         if(count($result)==0){
                //             $error.='SKU Name '.$sku_name.' not found.';
                //             $objerror=1;
                //             if($bl_error_line==false){
                //                 $error_line.=$i.', ';
                //                 $bl_error_line=true;
                //             }
                //         } else {
                //             $item_id = $result[0]->id;
                //             $item_grams = $result[0]->grams;
                //             $item_rate = $result[0]->rate;
                //             $item_tax_per = $result[0]->tax_percentage;

                //             $item_data[$a++] = array('sku_type'=>$sku_type,
                //                                     'sku_name'=>$sku_name,
                //                                     'sku_qty'=>$sku_qty,
                //                                     'item_id'=>$item_id,
                //                                     'item_grams'=>$item_grams,
                //                                     'item_rate'=>$item_rate,
                //                                     'item_tax_per'=>$item_tax_per,
                //                                     'combo_box_id'=>0
                //                                 );
                //         }
                //     } else if($sku_type=='Combo_box'){
                //         $sql = "select * from combo_box_master where combo_box_name='$sku_name'";
                //         $result = $this->db->query($sql)->result();
                //         if(count($result)==0){
                //             $error.='SKU Name '.$sku_name.' not found.';
                //             $objerror=1;
                //             if($bl_error_line==false){
                //                 $error_line.=$i.', ';
                //                 $bl_error_line=true;
                //             }
                //         } else {
                //             $combo_box_id = $result[0]->id;

                //             $sql = "select A.type as item_type, A.item_id, A.qty as item_qty, 
                //                     case when A.type='Bar' then B.product_name else C.box_name end as item_name, 
                //                     case when A.type='Bar' then B.grams else C.grams end as item_grams, 
                //                     case when A.type='Bar' then B.rate else C.rate end as item_rate, 
                //                     case when A.type='Bar' then B.tax_percentage else C.tax_percentage end as item_tax_per from 
                //                     (select * from combo_box_items where combo_box_id = '$combo_box_id') A 
                //                     left join 
                //                     (select * from product_master) B 
                //                     on (A.type='Bar' and A.item_id=B.id) 
                //                     left join 
                //                     (select * from box_master) C 
                //                     on (A.type='Box' and A.item_id=C.id)";
                //             $result = $this->db->query($sql)->result();
                //             if(count($result)==0){
                //                 $error.='Combo Box '.$sku_name.' items not found.';
                //                 $objerror=1;
                //                 if($bl_error_line==false){
                //                     $error_line.=$i.', ';
                //                     $bl_error_line=true;
                //                 }
                //             } else {
                //                 for($k=0; $k<count($result); $k++){
                //                     $item_type = $result[$k]->item_type;
                //                     $item_name = $result[$k]->item_name;
                //                     $item_qty = $result[$k]->item_qty;
                //                     $item_id = $result[$k]->item_id;
                //                     $item_grams = $result[$k]->item_grams;
                //                     $item_rate = $result[$k]->item_rate;
                //                     $item_tax_per = $result[$k]->item_tax_per;

                //                     $item_data[$a++] = array('sku_type'=>$item_type,
                //                                             'sku_name'=>$item_name,
                //                                             'sku_qty'=>doubleval($sku_qty)*doubleval($item_qty),
                //                                             'item_id'=>$item_id,
                //                                             'item_grams'=>$item_grams,
                //                                             'item_rate'=>$item_rate,
                //                                             'item_tax_per'=>$item_tax_per,
                //                                             'combo_box_id'=>$combo_box_id
                //                                         );
                //                 }
                //             }
                //         }
                //     }
                // }
                

                // for($a=0; $a<count($item_data); $a++){
                //     $sku_type = $item_data[$a]['sku_type'];
                //     $item_id = $item_data[$a]['item_id'];
                //     $sku_qty = $item_data[$a]['sku_qty'];

                //     if(isset($stock_arr[$sku_type.'_'.$item_id])){
                //         $stock_arr[$sku_type.'_'.$item_id] = $stock_arr[$sku_type.'_'.$item_id]+$sku_qty;
                //     } else {
                //         $stock_arr[$sku_type.'_'.$item_id] = $sku_qty;
                //     }

                //     if($objerror!=1){
                //         $result = $this->check_stock($sku_type, $depot_id, $item_id, $stock_arr[$sku_type.'_'.$item_id]);
                //         if($result){
                //             $error.='Qty is not enough in selected depot.';
                //             $objerror=1;
                //             if($bl_error_line==false){
                //                 $error_line.=$i.', ';
                //                 $bl_error_line=true;
                //             }
                //         }
                //     }
                // }

                if($status==''){
                    $error.='Status cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else if(strtoupper(trim($status))!='PAID' && strtoupper(trim($status))!='UNPAID'){
                    $error.='Status should be Paid or Unpaid.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                }
                
                if($error!=""){
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $error);
                    $objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getAlignment()->setWrapText(true);  
                }
            //-------------- Validation End ------------------------------

            if($objerror!=1){
                $bl_flag=false;
                $j=0;
                $sku_array = [];
                $k=0;

                for($j=0; $j<count($order_array); $j++){
                    if($order_array[$j]['po_no']==$po_no){
                        $bl_flag=true;
                        break;
                    }
                }

                if($bl_flag==false){
                    $j=count($order_array);

                    // $order_array[$j]['creation_date']=FormatDate($creation_date);
                    $order_array[$j]['creation_date']=$creation_date;
                    // $order_array[$j]['depot']=$depot;
                    // $order_array[$j]['depot_id']=$depot_id;
                    // $order_array[$j]['depot_state']=$depot_state;
                    // $order_array[$j]['depot_state_code']=$depot_state_code;
                    // // $order_array[$j]['order_approve_date']=$order_approve_date;
                    // $order_array[$j]['distributor_name']=$distributor_name;
                    // $order_array[$j]['distributor_id']=$distributor_id;
                    // $order_array[$j]['name_of_customer']=$name_of_customer;
                    // $order_array[$j]['address']=$address;
                    // $order_array[$j]['city']=$city;
                    // $order_array[$j]['pincode']=$pincode;
                    // $order_array[$j]['state_name']=$state_name;
                    // $order_array[$j]['state_code']=$state_code;
                    // $order_array[$j]['country_name']=$country_name;
                    // $order_array[$j]['mobile_no']=$mobile_no;
                    $order_array[$j]['po_no']=$po_no;
                    $order_array[$j]['status']=$status;
                    $order_array[$j]['remarks']=$remarks;
                    // $order_array[$j]['total_order_amt']=0;
                    // $order_array[$j]['total_order_value']=0;
                    $order_array[$j]['row_num']=$i;

                    $k=0;
                } 
                // else {
                //     $sku_array=$order_array[$j]['sku_array'];
                //     $k=count($sku_array);
                // }

                // for($a=0; $a<count($item_data); $a++){
                //     $sku_array[$k]['sku_type']=$item_data[$a]['sku_type'];
                //     $sku_array[$k]['sku_name']=$item_data[$a]['sku_name'];
                //     $sku_array[$k]['item_id']=$item_data[$a]['item_id'];
                //     $sku_array[$k]['item_grams']=$item_data[$a]['item_grams'];
                //     $sku_array[$k]['item_rate']=$item_data[$a]['item_rate'];
                //     $sku_array[$k]['item_tax_per']=$item_data[$a]['item_tax_per'];
                //     $sku_array[$k]['sku_qty']=$item_data[$a]['sku_qty'];
                //     $sku_array[$k]['combo_box_id']=$item_data[$a]['combo_box_id'];
                //     $sku_array[$k]['batch_id']=$batch_id;
                //     $sku_array[$k]['row_num']=$i;


                //     $order_array[$j]['sku_array']=$sku_array;

                //     $order_array[$j]['total_order_amt']=doubleval($order_array[$j]['total_order_amt'])+doubleval($item_data[$a]['sku_qty']*$item_data[$a]['item_rate']);

                //     $k = $k + 1;
                // }

                // $order_array[$j]['total_order_value']=doubleval($order_array[$j]['total_order_value'])+doubleval($sku_value);
            }
        }

        $upload_path=$this->config->item('upload_path');
        $path=$upload_path.'shopify/';
        if(strrpos($file_name, '.')>0){
            $ext = substr($file_name, strrpos($file_name, '.'));
        } else {
            $ext = '.xlsx';
        }

        if($objerror==1){
            $error_file_path = $path;
            $error_file_name = time().'_file_'.$file_id.'_error'.$ext;
            $status = 'Error';
            // $remarks = 'There are errors in file on line '.$error_line.'. <br/>Please check - '.$error_file_name;
            $remarks = 'Please check - '.$error_file_name.' file for errors.';

            // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename="'.$error_file_name.'"');
            // header('Cache-Control: max-age=0');
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            // $objWriter->save('php://output');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($error_file_path.$error_file_name);
        
            sleep(0.50);

            $sql = "update shopify_upload_files set error_file_path='".$error_file_path."', error_file_name='".$error_file_name."', status = '".$status."', remarks = '".$remarks."', modified_by = '".$curusr."', modified_on = '".$now."' where id='".$file_id."'";
            $this->db->query($sql);

            sleep(0.50);

            $this->session->set_flashdata('error', $remarks);
            $this->session->keep_flashdata('error');
        } else {
            // for($i=0; $i<count($order_array); $i++){
            //     $total_order_amt = $order_array[$i]['total_order_amt'];
            //     $total_order_value = $order_array[$i]['total_order_value'];
            //     if($order_array[$i]['depot_state']==$order_array[$i]['state_name']){
            //         $tax_type = 'Intra';
            //     } else {
            //         $tax_type = 'Inter';
            //     }

            //     $total_discount_amt = $total_order_amt - $total_order_value;
            //     $discount_per = 0;
            //     if($total_order_amt!=0){
            //       $discount_per=round(($total_discount_amt/$total_order_amt)*100,2);
            //     }

            //     $tot_amount = 0;
            //     $tot_cgst_amount = 0;
            //     $tot_sgst_amount = 0;
            //     $tot_igst_amount = 0;
            //     $tot_tax_amount = 0;
            //     $tot_order_amount = 0;
            //     $k = 0;

            //     $sku_array = $order_array[$i]['sku_array'];

            //     for($j=0; $j<count($sku_array); $j++) {
            //         // echo json_encode($sku_array[$j]);
            //         // echo '<br/><br/>';

            //         $qty = doubleval($sku_array[$j]['sku_qty']);
            //         $sell_rate = 0;
            //         $rate = doubleval($sku_array[$j]['item_rate']);
            //         $amount = 0;
            //         $cgst_amt = 0;
            //         $sgst_amt = 0;
            //         $igst_amt = 0;
            //         $tax_amt = 0;
            //         $total_amt = 0;
            //         $margin_per = 0;
            //         $promo_margin = 0;
            //         $tax_per = doubleval($sku_array[$j]['item_tax_per']);

            //         $sell_rate = $rate - (($rate*$discount_per)/100);
            //         if($tax_per!=0){
            //             $sell_rate = $sell_rate/(100+$tax_per)*100;
            //         }

            //         if($tax_type=='Intra'){
            //             $cgst=$tax_per/2;
            //             $sgst=$tax_per/2;
            //             $igst=0;
            //         } else {
            //             $cgst=0;
            //             $sgst=0;
            //             $igst=$tax_per;
            //         }

            //         $cgst_amt = round($qty*(($sell_rate*$cgst)/100),2);
            //         $sgst_amt = round($qty*(($sell_rate*$sgst)/100),2);
            //         $igst_amt = round($qty*(($sell_rate*$igst)/100),2);
            //         // $tax_amt = round($qty*(($sell_rate*$tax_per)/100),2);
            //         $tax_amt = $cgst_amt+$sgst_amt+$igst_amt;

            //         $amount = round(($qty*$sell_rate),2);
            //         $total_amt = round((round($amount,2) + round($tax_amt,2)),2);

            //         $tot_amount = $tot_amount + $amount;
            //         $tot_tax_amount = $tot_tax_amount + $tax_amt;
            //         $tot_order_amount = $tot_order_amount + $total_amt;

            //         $tot_cgst_amount = $tot_cgst_amount + $cgst_amt;
            //         $tot_sgst_amount = $tot_sgst_amount + $sgst_amt;
            //         $tot_igst_amount = $tot_igst_amount + $igst_amt;

            //         $sku_array[$j]['sell_rate'] = $sell_rate;
            //         $sku_array[$j]['amount'] = $amount;
            //         $sku_array[$j]['cgst_amt'] = $cgst_amt;
            //         $sku_array[$j]['sgst_amt'] = $sgst_amt;
            //         $sku_array[$j]['igst_amt'] = $igst_amt;
            //         $sku_array[$j]['tax_amt'] = $tax_amt;
            //         $sku_array[$j]['total_amt'] = $total_amt;
            //         $sku_array[$j]['margin_per'] = $margin_per;
            //         $sku_array[$j]['promo_margin'] = $promo_margin;

            //         $row_num = $sku_array[$j]['row_num'];

            //         $cell_cgst_amt = $objPHPExcel->getActiveSheet()->getCell('P'.$row_num)->getCalculatedValue();
            //         $cell_sgst_amt = $objPHPExcel->getActiveSheet()->getCell('Q'.$row_num)->getCalculatedValue();
            //         $cell_igst_amt = $objPHPExcel->getActiveSheet()->getCell('R'.$row_num)->getCalculatedValue();
            //         $cell_amount = $objPHPExcel->getActiveSheet()->getCell('S'.$row_num)->getCalculatedValue();

            //         if($cell_cgst_amt==''){
            //             $cell_cgst_amt = $cgst_amt;
            //         } else {
            //             $cell_cgst_amt = doubleval($cell_cgst_amt)+doubleval($cgst_amt);
            //         }
            //         if($cell_sgst_amt==''){
            //             $cell_sgst_amt = $sgst_amt;
            //         } else {
            //             $cell_sgst_amt = doubleval($cell_sgst_amt)+doubleval($sgst_amt);
            //         }
            //         if($cell_igst_amt==''){
            //             $cell_igst_amt = $igst_amt;
            //         } else {
            //             $cell_igst_amt = doubleval($cell_igst_amt)+doubleval($igst_amt);
            //         }
            //         if($cell_amount==''){
            //             $cell_amount = $amount;
            //         } else {
            //             $cell_amount = doubleval($cell_amount)+doubleval($amount);
            //         }

            //         $objPHPExcel->getActiveSheet()->setCellValue('P'.$row_num, $cell_cgst_amt);
            //         $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row_num, $cell_sgst_amt);
            //         $objPHPExcel->getActiveSheet()->setCellValue('R'.$row_num, $cell_igst_amt);
            //         $objPHPExcel->getActiveSheet()->setCellValue('S'.$row_num, $cell_amount);
            //     }

            //     $round_off_amt = round(round($tot_order_amount,0) - round($tot_order_amount,2),2);
            //     $invoice_amount = round($tot_order_amount,0);

            //     $order_array[$i]['discount'] = $discount_per;
            //     $order_array[$i]['amount'] = $tot_amount;
            //     $order_array[$i]['tax_amount'] = $tot_tax_amount;
            //     $order_array[$i]['cgst_amount'] = $tot_cgst_amount;
            //     $order_array[$i]['sgst_amount'] = $tot_sgst_amount;
            //     $order_array[$i]['igst_amount'] = $tot_igst_amount;
            //     $order_array[$i]['final_amount'] = $tot_order_amount;
            //     $order_array[$i]['round_off_amount'] = $round_off_amt;
            //     $order_array[$i]['invoice_amount'] = $invoice_amount;

            //     $order_array[$i]['sku_array'] = $sku_array;
            // }

            // echo json_encode($order_array);
            // echo '<br/><br/>';

            $success_cnt = 0;
            $fail_cnt = 0;

            for($k=0; $k<count($order_array); $k++) {
                $date_of_processing = $order_array[$k]['creation_date'];
                // $depot_id = $order_array[$k]['depot_id'];
                // $distributor_id = $order_array[$k]['distributor_id'];
                // $tot_amount = $order_array[$k]['amount'];
                // $tot_tax_amount = $order_array[$k]['tax_amount'];
                // $tot_order_amount = $order_array[$k]['final_amount'];
                $po_no = $order_array[$k]['po_no'];
                // $client_name = addslashes($order_array[$k]['name_of_customer']);
                // $address = addslashes($order_array[$k]['address']);
                // $city = $order_array[$k]['city'];
                // $pincode = $order_array[$k]['pincode'];
                // $state = $order_array[$k]['state_name'];
                // $country = $order_array[$k]['country_name'];
                // $phone = $order_array[$k]['mobile_no'];
                // $discount_per = $order_array[$k]['discount'];
                // $delivery_status='Delivered';
                // $delivery_date="'".$curdate."'";
                // $tot_cgst_amount = $order_array[$k]['cgst_amount'];
                // $tot_sgst_amount = $order_array[$k]['sgst_amount'];
                // $tot_igst_amount = $order_array[$k]['igst_amount'];
                // $state_code = $order_array[$k]['state_code'];
                // $round_off_amt = $order_array[$k]['round_off_amount'];
                // $invoice_amount = $order_array[$k]['invoice_amount'];
                $status = $order_array[$k]['status'];
                $remarks = $order_array[$k]['remarks'];

                // $sku_array = $order_array[$k]['sku_array'];

                $row_num = $order_array[$k]['row_num'];

                if(strtoupper(trim($status))=="PAID"){
                    $row_status = 'Failed';

                    $sql = "select * from shopify_orders where order_no = '$po_no'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)>0){
                        if(isset($result[0]->order_id)){
                            if($result[0]->order_id!=''){
                                $order_id = $result[0]->order_id;

                                $response = $this->get_transaction($order_id);

                                $res = json_decode($response);
                                $transaction = $res->transaction;

                                $status = '';

                                if(isset($transaction->status)) $status = $transaction->status;

                                if(strtoupper(trim($status))=='SUCCESS'){
                                    $sql = "update shopify_orders set financial_status='paid', upload_status = '$status', modified_by = '$curusr', modified_on = '$now' where order_no = '$po_no'";

                                    if ($this->db->query($sql) === TRUE) {
                                        $row_status = 'Success';
                                    }
                                }
                            }
                        }
                    }
                    
                    if($row_status=='Success'){
                        $success_cnt = $success_cnt + 1;

                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$row_num, 'Success');
                    } else {
                        $fail_cnt = $fail_cnt + 1;

                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$row_num, 'Failed');
                    }
                }
                
                // $sql = "insert into shopify_upload_details (file_id, date_of_processing, invoice_no, depot_id, distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, modified_by, modified_on, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, date_of_dispatch, delivery_status, delivery_date, delivery_sales_rep_id, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, round_off_amount, invoice_amount, ref_id, invoice_date, email_date_time, basis_of_sales, email_from, email_approved_by, gstin, created_by, created_on) VALUES ('".$file_id."', '".$date_of_processing."', '', '".$depot_id."', '".$distributor_id."', Null, ".$tot_amount.", Null, 1, ".$tot_tax_amount.", ".$tot_order_amount.", '".$curdate."', '".$po_no."', Null, Null, Null, Null, Null, 'Pending', '".$remarks."', '".$curusr."', '".$now."', '".$client_name."', '".$address."', '".$city."', '".$pincode."', '".$state."', '".$country."', '".$phone."', ".$discount_per.", Null, '".$curdate."', '".$delivery_status."', ".$delivery_date.", Null, '', '', 1, 1, 1, ".$tot_cgst_amount.", ".$tot_sgst_amount.", ".$tot_igst_amount.", 'no', 'yes', Null, Null, Null, Null, Null, Null, Null, Null, Null, '".$state_code."', ".$round_off_amt.", ".$invoice_amount.", Null, Null, '".$now."', 'PO Number', '', '', '', '".$curusr."', '".$now."')";
                // if ($this->db->query($sql) === TRUE) {
                //     $distributor_out_id = $this->db->insert_id();

                //     for($j=0; $j<count($sku_array); $j++) {
                //         $sql = "insert into shopify_upload_items (distributor_out_id, type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, margin_per, promo_margin, tax_percentage, batch_no, batch_qty, combo_box_id) VALUES ('".$distributor_out_id."', '".$sku_array[$j]['sku_type']."', '".$sku_array[$j]['item_id']."', '".$sku_array[$j]['sku_qty']."', '".$sku_array[$j]['sell_rate']."', '".$sku_array[$j]['item_grams']."', '".$sku_array[$j]['item_rate']."', '".$sku_array[$j]['amount']."', '".$sku_array[$j]['cgst_amt']."', '".$sku_array[$j]['sgst_amt']."', '".$sku_array[$j]['igst_amt']."', '".$sku_array[$j]['tax_amt']."', '".$sku_array[$j]['total_amt']."', '".$sku_array[$j]['margin_per']."', '".$sku_array[$j]['promo_margin']."', '".$sku_array[$j]['item_tax_per']."', '".$sku_array[$j]['batch_id']."', '".$sku_array[$j]['sku_qty']."', '".$sku_array[$j]['combo_box_id']."')";
                //         if ($this->db->query($sql) === TRUE) {
                //             $success_cnt = $success_cnt + 1;
                //         } else {
                //             $fail_cnt = $fail_cnt + 1;
                //         }
                //     }
                // } else {
                //     $fail_cnt = $fail_cnt + 1;
                // }
            }

            $check_file_path = $path;
            $check_file_name = time().'_file_'.$file_id.'_check'.$ext;
            $status = 'Pending';
            $remarks = 'No of records uploaded - '.$success_cnt.'<br/>No of records failed - '.$fail_cnt;

            // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename="'.$error_file_name.'"');
            // header('Cache-Control: max-age=0');
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            // $objWriter->save('php://output');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($check_file_path.$check_file_name);
        
            sleep(0.50);

            $sql = "update shopify_upload_files set check_file_path='".$check_file_path."', check_file_name='".$check_file_name."', status = '".$status."', remarks = '".$remarks."', modified_by = '".$curusr."', modified_on = '".$now."' where id='".$file_id."'";
            $this->db->query($sql);

            sleep(0.50);

            // echo $remarks;
            $this->session->set_flashdata('success', $remarks);
            $this->session->keep_flashdata('success');
        }

        // echo $remarks;

        redirect(base_url().'index.php/shopify');
    }

    public function common_excel($objValidation){
        $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
        $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
        $objValidation->setAllowBlank(false);
        $objValidation->setShowInputMessage(true);
        $objValidation->setShowErrorMessage(true);
        $objValidation->setShowDropDown(true);
        $objValidation->setErrorTitle('Input error');
        $objValidation->setError('Value is not in list.');
        $objValidation->setPromptTitle('Pick from list');
        $objValidation->setPrompt('Please pick a value from the drop-down list.');/*
        $objValidation->setFormula1('"'.$distname.'"');*/
    }

    public function approve_file_data($file_id){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $sql = "select * from shopify_upload_details where status='Pending' and file_id='$file_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $sql = "insert into distributor_out (date_of_processing, invoice_no, depot_id, 
                            distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, voucher_no, gate_pass_no, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, delivery_status, delivery_date, delivery_sales_rep_id, receivable_doc, distributor_in_id, distributor_in_type, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, sample_type, gifting_remarks, promoter_sales_rep_id, blogger_name, blogger_address, blogger_phone_no, blogger_email_id, round_off_amount, invoice_amount, ref_id, invoice_date, gatepass_date, gpid, freezed, tracking_id, basis_of_sales, email_from, email_approved_by, email_date_time, distributor_po_id, comments, gstin, modified_approved_date, proof_of_dispatch, date_of_dispatch, person_receiving, proof_of_delivery, ref_invoice_no, ref_invoice_details, ref_invoice_date, file_id)
                        select date_of_processing, invoice_no, depot_id, distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, voucher_no, gate_pass_no, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, delivery_status, delivery_date, delivery_sales_rep_id, receivable_doc, distributor_in_id, distributor_in_type, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, sample_type, gifting_remarks, promoter_sales_rep_id, blogger_name, blogger_address, blogger_phone_no, blogger_email_id, round_off_amount, invoice_amount, ref_id, invoice_date, gatepass_date, gpid, freezed, tracking_id, basis_of_sales, email_from, email_approved_by, email_date_time, distributor_po_id, comments, gstin, modified_approved_date, proof_of_dispatch, date_of_dispatch, person_receiving, proof_of_delivery, ref_invoice_no, ref_invoice_details, ref_invoice_date, '".$file_id."' 
                        from shopify_upload_details where id = '".$result[$i]->id."'";
                $this->db->query($sql);
                $id = $this->db->insert_id();

                $sql = "insert into distributor_out_items (distributor_out_id, type, item_id, qty, sell_rate, 
                            grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, batch_no, batch_qty, margin_per, tax_percentage, promo_margin, combo_box_id)
                        select '".$id."', type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, batch_no, batch_qty, margin_per, tax_percentage, promo_margin, combo_box_id 
                        from shopify_upload_items where distributor_out_id = '".$result[$i]->id."'";
                $this->db->query($sql);

                $this->distributor_out_model->save_approved_data($id);
            }

            $sql = "update shopify_upload_files set status='Approved', approved_by='$curusr', approved_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $sql = "update shopify_upload_details set status='Approved', approved_by='$curusr', approved_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $this->session->set_flashdata('success', 'File approve succeded.');
            $this->session->keep_flashdata('success');
        } else {
            $this->session->set_flashdata('success', 'No data found.');
            $this->session->keep_flashdata('success');
        }

        redirect(base_url().'index.php/shopify');
    }

    public function reject_file_data($file_id){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $sql = "select * from shopify_upload_details where status='Pending' and file_id='$file_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $sql = "update shopify_upload_files set status='Rejected', rejected_by='$curusr', rejected_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $sql = "update shopify_upload_details set status='Rejected', rejected_by='$curusr', rejected_on='$now' where file_id='$file_id'";
            $this->db->query($sql);

            $this->session->set_flashdata('success', 'File rejection succeded.');
            $this->session->keep_flashdata('success');
        } else {
            $this->session->set_flashdata('success', 'No data found.');
            $this->session->keep_flashdata('success');
        }

        redirect(base_url().'index.php/shopify');
    }

    public function get_file_invoices($file_id){
        $sql = "select id from distributor_out where file_id='$file_id'";
        $result = $this->db->query($sql)->result_array();

        $dist_out_id = '';
        $dist_out_id_arr = array();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                // $dist_out_id_arr[] = $result[$i]['id'];
                $dist_out_id = $dist_out_id . $result[$i]['id'] . ', ';
            }
        }

        // echo '<pre>'; print_r($dist_out_id_arr); echo '</pre>';
        // exit;

        // $dist_out_id = '';
        // if(count($result)>0){
        //     $dist_out_id = implode(', ', $result);
        // }

        if($dist_out_id!=''){
            $dist_out_id = substr($dist_out_id, 0, strlen($dist_out_id)-2);
        }

        // echo $dist_out_id;
        // exit;

        if($dist_out_id!=''){
            $this->tax_invoice_model->generate_multiple_tax_invoice($dist_out_id);
        }
    }
}
?>