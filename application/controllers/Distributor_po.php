<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor_po extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->helper('common_functions');
        $this->load->model('distributor_po_model');
        $this->load->model('relationship_model');
        $this->load->model('distributor_type_model');
        $this->load->model('zone_model');
        $this->load->model('location_model');
        $this->load->model('box_model');
        $this->load->model('depot_model');
        $this->load->model('sales_rep_model');
        $this->load->model('distributor_model');
        $this->load->model('product_model');
        $this->load->model('tax_invoice_model');
        $this->load->model('bank_model');
        $this->load->model('email_model');
        $this->load->database();
    }

    public function index(){
        $this->checkstatus('pending_for_delivery');
    }

    public function get_distributors(){
        $delivery_through = $this->input->post("delivery_through");
        $distributor_id = $this->input->post("distributor_id");

        // $delivery_through = 'WHPL';
        // $distributor_id = '';

        if(strtoupper(trim($delivery_through))=='WHPL'){
            $class="normal";
        } else {
            $class="super stockist";
        }
        $data = $this->distributor_po_model->get_distributor('Approved', '', $class);

        $result = '<option value="">Select</option>';
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                if($data[$i]->id==$distributor_id){
                    $result = $result . '<option value="'.$data[$i]->id.'" selected>'.$data[$i]->distributor_name.'</option>';
                } else {
                    $result = $result . '<option value="'.$data[$i]->id.'">'.$data[$i]->distributor_name.'</option>';
                }
            }
        }
        echo $result;
    }

    public function get_zones(){
        $type_id = $this->input->post("type_id");
        $zone_id = $this->input->post("zone_id");
        $data = $this->distributor_po_model->get_zone_data('Approved', $type_id);

        $result = '<option value="">Select</option>';
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                if($data[$i]->id==$zone_id){
                    $result = $result . '<option value="'.$data[$i]->id.'" selected>'.$data[$i]->zone.'</option>';
                } else {
                    $result = $result . '<option value="'.$data[$i]->id.'">'.$data[$i]->zone.'</option>';
                }
            }
        }
        echo $result;
    }

    public function get_stores(){
        $type_id = $this->input->post("type_id");
        $zone_id = $this->input->post("zone_id");
        $store_id = $this->input->post("store_id");
        $data = $this->distributor_po_model->get_store_data('Approved', $type_id, $zone_id);

        $result = '<option value="">Select</option>';
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                if($data[$i]->id==$store_id){
                    $result = $result . '<option value="'.$data[$i]->store_id.'" selected>'.$data[$i]->store_name.'</option>';
                } else {
                    $result = $result . '<option value="'.$data[$i]->store_id.'">'.$data[$i]->store_name.'</option>';
                }
            }
        }
        echo $result;
    }

    public function get_locations(){
        $type_id = $this->input->post("type_id");
        $zone_id = $this->input->post("zone_id");
        $store_id = $this->input->post("store_id");
        $location_id = $this->input->post("location_id");
        $data = $this->distributor_po_model->get_location_data('Approved', $type_id, $zone_id, $store_id);

        $result = '<option value="">Select</option>';
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                if($data[$i]->id==$location_id){
                    $result = $result . '<option value="'.$data[$i]->location_id.'" selected>'.$data[$i]->location.'</option>';
                } else {
                    $result = $result . '<option value="'.$data[$i]->location_id.'">'.$data[$i]->location.'</option>';
                }
            }
        }
        echo $result;
    }

    public function get_data($status) {
        // $status = 'Approved';

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $r = $this->distributor_po_model->get_distributor_po_data1($status);
        $data = array();
        //. '-' . $r[$i]->client_name
        for($i=0;$i<count($r);$i++){
            if($status=='pending_for_delivery' || $status=='gt_dp' || $status=='pending_merchendizer_delivery'){
                $data[] = array(
                            '<input type="checkbox" id="check_'.$i.'" class="check icheckbox" name="check_val[]" value="'.$r[$i]->id.'" onChange="set_checkbox(this);" style="display: none;" />
                            <input type="hidden" id="input_check_'.$i.'" name="check[]" value="false" />
                            &nbsp;
                            <span class="fa fa-comments" onclick="get_delivery_comments(this);" style="cursor:pointer" id="'.$r[$i]->id.'"></span >',

                            $i+1,

                            '<span style="display:none;">
                            <input type="hidden" id="date_of_po_'.$i.'" name="date_of_po[]" value="'.$r[$i]->date_of_po.'" />'.
                                (($r[$i]->date_of_po!=null && $r[$i]->date_of_po!='')?date('Ymd',strtotime($r[$i]->date_of_po)):'')
                            .'</span>'.
                            (($r[$i]->date_of_po!=null && $r[$i]->date_of_po!='')?date('d/m/Y',strtotime($r[$i]->date_of_po)):''),

                            (($status=='pending_for_delivery' || $status=='gt_dp')?
                                '<a href="'.base_url().'index.php/distributor_po/recon/'.$r[$i]->id.'" class=""><i class="fa fa-edit"></i></a>':
                                '<a href="'.base_url().'index.php/distributor_po/edit/'.$r[$i]->id.'" class=""><i class="fa fa-edit"></i></a>'),

                            ((strtoupper(trim($r[$i]->distributor_name))=='DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='AMAZON DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NYKAA DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($r[$i]->distributor_name))=='PAYTM DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='UNFACTORY DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EMBRACE DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NEULIFE DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='FLIPKART DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='GOQII DIRECT')? $r[$i]->distributor_name  : $r[$i]->distributor_name),

                            $r[$i]->po_number,

                            $r[$i]->location,

                            $r[$i]->store_name,

                            $r[$i]->days_to_expiry,

                            $r[$i]->invoice_amount,

                            '<input type="hidden" id="dlvery_status_'.$i.'" name="dlvery_status[]" value="'.$r[$i]->delivery_status.'" />'.
                            ($r[$i]->delivery_status=='Pending'?'Delivered Pending Merchandiser Approval':$r[$i]->delivery_status),

                            $r[$i]->mismatch_type
                        );
            } else {
                $data[] = array(
                            '<input type="checkbox" id="check_'.$i.'" class="check icheckbox" name="check_val[]" value="'.$r[$i]->id.'" onChange="set_checkbox(this);" />
                            <input type="hidden" id="input_check_'.$i.'" name="check[]" value="false" />',

                            $i+1,

                            '<span style="display:none;">
                            <input type="hidden" id="date_of_po_'.$i.'" name="date_of_po[]" value="'.$r[$i]->date_of_po.'" />'.
                                (($r[$i]->date_of_po!=null && $r[$i]->date_of_po!='')?date('Ymd',strtotime($r[$i]->date_of_po)):'')
                            .'</span>'.
                            (($r[$i]->date_of_po!=null && $r[$i]->date_of_po!='')?date('d/m/Y',strtotime($r[$i]->date_of_po)):''),

                            '<a href="'.base_url().'index.php/distributor_po/edit/'.$r[$i]->id.'" class=""><i class="fa fa-edit"></i></a>',
                           
                            ((strtoupper(trim($r[$i]->distributor_name))=='DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='AMAZON DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NYKAA DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($r[$i]->distributor_name))=='PAYTM DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='UNFACTORY DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EMBRACE DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NEULIFE DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='FLIPKART DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='GOQII DIRECT')? $r[$i]->distributor_name : $r[$i]->distributor_name),

                            $r[$i]->po_number,

                            $r[$i]->location,

                            $r[$i]->store_name,

                            $r[$i]->days_to_expiry,

                            $r[$i]->invoice_amount,

                            '<input type="hidden" id="dlvery_status_'.$i.'" name="dlvery_status[]" value="'.$r[$i]->delivery_status.'" />'.
                            ($r[$i]->delivery_status=='Pending'?'Delivered Pending Merchandiser Approval':$r[$i]->delivery_status),

                            $r[$i]->mismatch_type
                        );
            }
        }

        // echo json_encode($data);

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
        $result=$this->distributor_po_model->get_access();
        $selectedstatus="Select Status";
        if(count($result)>0) {
            $curusr = $this->session->userdata('session_id');

            $data['access']=$result;
            if($status=='All') {
                $status='';
            }
            $data['data']=$this->distributor_po_model->get_distributor_po_data1($status);
            
            $count_data=$this->distributor_po_model->get_distributor_po_data1();
            
            $active=0;
            $inactive=0;
            $pending=0;
            $pending_for_approval=0;
            $pending_for_delivery=0;
            $gp_issued=0;
            $delivered_not_complete=0;
            $pending_merchendiser_delivery=0;
            $delivered=0;
            $mismatch=0;
            $gt_dp=0;
            
            //responsive drop down list code 
            if($status=="Approved") {
                $selectedstatus='Approved';//$status;
            } else if($status=="pending") {
                $selectedstatus='Pending';//$status;
            } else if($status=="pending_for_approval") {
                $selectedstatus='Approval Pending';//$status;
            } else if($status=="InActive") {
                $selectedstatus='Cancelled';//$status;
            } else if($status=="pending_for_delivery") {
                $selectedstatus='Delivery Pending';//$status;
            } else if($status=="gt_dp") {
                $selectedstatus='GT DP';//$status;
            } else if($status=="delivered_not_complete") {
                $selectedstatus="InComplete";
            } else if($status=="pending_merchendiser_delivery") {
                $selectedstatus="Delivered pending merchandiser Approval ";
            } else if($status=="Delivered") {
                $selectedstatus="Delivered";
            } else if($status=="mismatch") {
                $selectedstatus="mismatch";
            } else {
                $selectedstatus=$status;
            }
            //responsive drop down list code 
            
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_through))!="WHPL"){
                        $active=$active+1;
                    }
                    
                    if ($count_data[$i]->mismatch=='1')
                        $mismatch=$mismatch+1;
                    else if ((strtoupper(trim($count_data[$i]->status))=="PENDING" || 
                            strtoupper(trim($count_data[$i]->status))=="DELETED") && $count_data[$i]->mismatch!='1')
                        $pending_for_approval=$pending_for_approval+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && ($count_data[$i]->type_id=='7' || $count_data[$i]->type_id=='4') && $count_data[$i]->delivery_status=='' && strtoupper(trim($count_data[$i]->delivery_through))!="WHPL")
                        $pending_for_delivery=$pending_for_delivery+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && $count_data[$i]->type_id=='3' && $count_data[$i]->delivery_status=='' && strtoupper(trim($count_data[$i]->delivery_through))!="WHPL")
                        $gt_dp=$gt_dp+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && 
                                (strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED")  && strtoupper(trim($count_data[$i]->delivery_through))!="WHPL")
                        $delivered=$delivered+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && 
                                (strtoupper(trim($count_data[$i]->delivery_status))=="PENDING") && strtoupper(trim($count_data[$i]->delivery_through))!="WHPL")
                        $pending_merchendiser_delivery=$pending_merchendiser_delivery+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE" && 
                                strtoupper(trim($count_data[$i]->delivery_status))=="CANCELLED")
                        $inactive=$inactive+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING" && 
                                ($count_data[$i]->delivery_status==null || $count_data[$i]->delivery_status==''))
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_status))=="GP ISSUED" && strtoupper(trim($count_data[$i]->delivery_through))!="WHPL")
                        $gp_issued=$gp_issued+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED NOT COMPLETE" && strtoupper(trim($count_data[$i]->delivery_through))!="WHPL")
                        $delivered_not_complete=$delivered_not_complete+1;
                }
            }

            $data['selectedstatus']=$selectedstatus;
            $data['active']=$active;
            $data['inactive']=$inactive;
            $data['pending']=$pending;
            $data['pending_for_approval']=$pending_for_approval;
            $data['pending_for_delivery']=$pending_for_delivery;
            $data['gt_dp']=$gt_dp;
            $data['pending_merchendiser_delivery']=$pending_merchendiser_delivery;
            $data['gp_issued']=$gp_issued;
            $data['delivered']=$delivered;
            $data['mismatch']=$mismatch;
            $data['delivered_not_complete']=$delivered_not_complete;
            $data['all']=count($count_data);
            $data['status']=$status;
            $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');

            $query=$this->db->query("SELECT * FROM sales_rep_master WHERE sr_type='Merchandizer'");
            $result=$query->result();
            $data['sales_rep1']=$result;

            load_view('distributor_po/distributor_po_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->distributor_po_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->distributor_po_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data_without_sample('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->distributor_po_model->get_zone_data('Approved');
                $data['store'] = $this->distributor_po_model->get_store_data('Approved');
                $data['location'] = $this->location_model->get_data('Approved');
                $data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['bank'] = $this->bank_model->get_data('Approved');
                $data['email'] = $this->email_model->get_email_details('', 'distributor_po_mismatch');

                load_view('distributor_po/distributor_po_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->distributor_po_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_po_model->get_access();
                $id = $this->distributor_po_model->get_pending_data($id);
                $data['data'] = $this->distributor_po_model->get_distributor_po_data('', $id);

                if(count($data['data'])>0){
                    $type_id=$data['data'][0]->type_id;
                    $zone_id=$data['data'][0]->zone_id;
                    $store_id=$data['data'][0]->store_id;
                } else {
                    $type_id='';
                    $zone_id='';
                    $store_id='';
                }

                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data_without_sample('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->distributor_po_model->get_zone_data('Approved', $type_id);
                $data['store'] = $this->distributor_po_model->get_store_data('Approved', $type_id, $zone_id);
                $data['location'] = $this->distributor_po_model->get_location_data('Approved', $type_id, $zone_id, $store_id);
                $data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_po_items'] = $this->distributor_po_model->get_distributor_po_items($id);
                $data['bank'] = $this->bank_model->get_data('Approved');
                $email = $this->email_model->get_email_details($id, 'distributor_po_mismatch');

                if(count($email)>0){
                    $data['email'] = $email;
                }
                
                // $data['distributor_payment_details'] = $this->distributor_po_model->get_distributor_payment_details($id);

                load_view('distributor_po/distributor_po_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function recon($id){
        $result=$this->distributor_po_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_po_model->get_access();
                $id = $this->distributor_po_model->get_pending_data($id);
                $data['data'] = $this->distributor_po_model->get_distributor_po_data('', $id);

                if(count($data['data'])>0){
                    $type_id=$data['data'][0]->type_id;
                    $zone_id=$data['data'][0]->zone_id;
                    $store_id=$data['data'][0]->store_id;
                } else {
                    $type_id='';
                    $zone_id='';
                    $store_id='';
                }

                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data_without_sample('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->distributor_po_model->get_zone_data('Approved', $type_id);
                $data['store'] = $this->distributor_po_model->get_store_data('Approved', $type_id, $zone_id);
                $data['location'] = $this->distributor_po_model->get_location_data('Approved', $type_id, $zone_id, $store_id);
                $data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_po_items'] = $this->distributor_po_model->get_distributor_po_recon_items($id);
                $data['bank'] = $this->bank_model->get_data('Approved');
                // $data['distributor_payment_details'] = $this->distributor_po_model->get_distributor_payment_details($id);

                load_view('distributor_po/distributor_po_recon', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_product_details(){
        $id=$this->input->post('id');
        $distributor_id=$this->input->post('distributor_id');
        $store_id=$this->input->post('store_id');
        $delivery_through=$this->input->post('delivery_through');
        // $id=1;
        if($delivery_through=='Distributor')
        {
           $result=$this->distributor_po_model->get_relationship_product_details('', $id, $store_id);
        }else
        {
            $result=$this->distributor_po_model->get_distributor_product_details('', $id, $distributor_id);
        }
        
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['product_name'] = $result[0]->product_name;
            $data['barcode'] = $result[0]->barcode;
            $data['grams'] = $result[0]->grams;
            $data['avg_grams'] = $result[0]->avg_grams;
            $data['rate'] = $result[0]->rate;
            $data['cost'] = $result[0]->cost;
            $data['anticipated_wastage'] = $result[0]->anticipated_wastage;
            $data['tax_percentage'] = $result[0]->tax_percentage;
            $data['margin'] = 0;
            if(isset($result[0]->margin)){
                $data['margin'] = $result[0]->margin;
            } else if(isset($result[0]->inv_margin)){
                $data['margin'] = $result[0]->inv_margin;
            }
            $data['pro_margin'] = $result[0]->pro_margin;
        }

        echo json_encode($data);
    }

    public function get_box_details(){
        $id=$this->input->post('id');
        $distributor_id=$this->input->post('distributor_id');
        $store_id=$this->input->post('store_id');
        $delivery_through=$this->input->post('delivery_through');
        // $id=1;
        if($delivery_through=='WHPL')
        {
           $result=$this->distributor_po_model->get_distributor_box_details('', $id, $distributor_id);
           
        }else
        {
            $result=$this->distributor_po_model->get_relationship_box_details('', $id, $store_id);
        }
        
        
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['box_name'] = $result[0]->box_name;
            $data['barcode'] = $result[0]->barcode;
            $data['grams'] = $result[0]->grams;
            $data['rate'] = $result[0]->rate;
            $data['cost'] = $result[0]->cost;
            $data['tax_percentage'] = $result[0]->tax_percentage;
            $data['margin'] = 0;
            if(isset($result[0]->inv_margin)){
                $data['margin'] = $result[0]->inv_margin;
            } else if(isset($result[0]->margin)){
                $data['margin'] = $result[0]->margin;
            }
            $data['pro_margin'] = $result[0]->pro_margin;
        }

        echo json_encode($data);
    }

    public function send_email(){
        $result = $this->distributor_po_model->send_email();

        $result = str_replace('<pre>', '', $result);
        $result = str_replace('<pre>', '', $result);
        $result = trim($result);
        echo $result;
    }

    public function save(){
        $this->distributor_po_model->save_data();
        redirect(base_url().'index.php/distributor_po/checkstatus/pending_for_approval');
    }

    public function update($id){
        $this->distributor_po_model->save_data($id);
        redirect(base_url().'index.php/distributor_po/checkstatus/pending_for_approval');
    }
    
    public function update_recon($id){
        $this->distributor_po_model->update_recon($id);
        redirect(base_url().'index.php/distributor_po/checkstatus/pending_for_delivery');
    }
    
    public function set_delivery_status(){
        $this->distributor_po_model->set_delivery_status();
        redirect(base_url().'index.php/distributor_po');
    }

    public function generate_po_delivery_report() {
        $this->distributor_po_model->generate_po_delivery_report();
    }

    public function send_po_delivery_report() {
        $this->distributor_po_model->send_po_delivery_report();
    }

    public function po_summary_report() {
        $this->distributor_po_model->po_summary_report();
    }

    public function authorise(){
        $status=$this->input->post('status');
        $form_status = $this->input->post('form_status');

        if($status=="Approved"){
            $this->distributor_po_model->approve_records();
        } else {
            $this->distributor_po_model->reject_records();
        }

        redirect(base_url().'index.php/distributor_po/checkstatus/pending_for_approval');
    }

    public function set_delivery_status1(){
        // echo 'Hii';

        $this->distributor_po_model->set_delivery_status();
        $status=$this->input->post('status');
        if($status=='InActive') {
            redirect(base_url().'index.php/distributor_po');
        }
    }

    public function set_sku_batch(){
        $this->distributor_po_model->set_sku_batch();
        $status=$this->input->post('status');
        if($status=='InActive') {
            redirect(base_url().'index.php/distributor_po');
        }
    }

    public function get_comments(){
        $id=$this->input->post('id');
        $result = $this->distributor_po_model->get_comments($id);
        if(count($result)>0) {
            echo json_encode($result[0]);
        } else {
            echo 0;
        }
    }

    public function add_comments(){
       $result = $this->distributor_po_model->save_comments();
       redirect($_SERVER['HTTP_REFERER']); 
    }

	public function check_po_number_availablity() {
		$result = $this->distributor_po_model->check_po_number_availablity();
		echo $result;
	}
	
	public function check_po_number_availablity_whpl() {
		$result = $this->distributor_po_model->check_po_number_availablity_whpl();
		echo $result;
	}
}
?>