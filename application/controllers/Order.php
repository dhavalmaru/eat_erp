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
}
?>