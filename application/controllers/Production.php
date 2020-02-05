<?php

if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Production extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('production_model');
        $this->load->model('product_model');
        $this->load->model('raw_material_model');
        $this->load->database();
    }

    public function index(){
        // $result=$this->production_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->production_model->get_data();

        //     load_view('production/production_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }

        $this->checkstatus('requested');
    }

    public function test_add_days(){
        // $confirm_from_date='2018-12-18';
        // $duration_in_days='1';
        // $notification_date=date('Y-m-d', strtotime($confirm_from_date. ' + '.$duration_in_days.' day'));
        // echo $notification_date;

        $confirm_from_date='2018-12-18';
        $duration_in_days='5';
        $date = new DateTime($confirm_from_date);
        $date->modify('+'.$duration_in_days.' day');
        $notification_date = $date->format('Y-m-d');
        echo $notification_date;
    }

    public function test_send_mail(){
        $subject = 'Request for Confirmation of Production - ';
        $message = '<html><body>
                    Hi, <br/><br/> 
                    Request you to confirm the production availability for the below mentioned dates.<br/><br/>
                    Dates - <br/>
                    Total No of Days - <br/>
                    Remarks - <br/><br/>
                    Please confirm the same asap so that we can start the Raw Material Procurement asap. 
                    Also please send us the closing stock of Raw Material immediately.<br/><br/>
                    Team EAT Anytime<br/><br/>
                    </body></html>';

        $mailSent=send_email_new('prasad.bhisale@otbconsulting.co.in', 'Wholesome Habits Pvt Ltd', 'prasad.bhisale@otbconsulting.co.in', $subject, $message, 'prasad.bhisale@otbconsulting.co.in', 'prasad.bhisale@otbconsulting.co.in');
        echo $mailSent;
    }

    public function checkstatus($status=''){
        $result=$this->production_model->get_access();
        $selectedstatus="Select Status";
        if(count($result)>0) {
            $curusr = $this->session->userdata('session_id');

            $data['access']=$result;
            if($status=='All') {
                $status='';
            }
            $data['data']=$this->production_model->get_data($status);
            
            $count_data=$this->production_model->get_data();
            
            $requested=0;
            $confirmed=0;
            $batch_confirmed=0;
            $raw_material_confirmed=0;
            $inactive=0;
            
            //responsive drop down list code 
            if($status=="requested") {
                $selectedstatus='requested';//$status;
            } else if($status=="confirmed") {
                $selectedstatus='confirmed';//$status;
            } else if($status=="batch_confirmed") {
                $selectedstatus='batch_confirmed';//$status;
            } else if($status=="raw_material_confirmed") {
                $selectedstatus='raw_material_confirmed';//$status;
            } else if($status=="inactive") {
                $selectedstatus='inactive';//$status;
            } else {
                $selectedstatus=$status;
            }
            //responsive drop down list code 
            
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;

                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && 
                        strtoupper(trim($count_data[$i]->p_status))=="REQUESTED")
                        $requested=$requested+1;

                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && 
                        strtoupper(trim($count_data[$i]->p_status))=="CONFIRMED")
                        $confirmed=$confirmed+1;

                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && 
                        strtoupper(trim($count_data[$i]->p_status))=="BATCH CONFIRMED")
                        $batch_confirmed=$batch_confirmed+1;

                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && 
                        strtoupper(trim($count_data[$i]->p_status))=="RAW MATERIAL CONFIRMED")
                        $raw_material_confirmed=$raw_material_confirmed+1;
                }
            }

            $data['selectedstatus']=$selectedstatus;
            $data['inactive']=$inactive;
            $data['requested']=$requested;
            $data['confirmed']=$confirmed;
            $data['batch_confirmed']=$batch_confirmed;
            $data['raw_material_confirmed']=$raw_material_confirmed;
            $data['all']=count($count_data);
            $data['status']=$status;

            load_view('production/production_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function post($status=''){
        $result=$this->production_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->production_model->get_post_production_data();

            load_view('production/post_production_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data($status) {
        // $status = 'Approved';

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        // $status = intval($this->input->get("status"));

        $r = $this->production_model->get_data($status);
        // echo "<pre>";
        // print_r($r[0]);
        // echo "</pre>";
        // die();
        $data = array();

        for($i=0; $i<count($r); $i++){
            if($status=='requested') {
                $ulr = '<a href="'.base_url('index.php/production/edit/requested/'.$r[$i]->id).'"><i class="fa fa-edit"></i></a>';
                $ulr2 = '<a href="'.base_url('index.php/production/edit/confirmed/'.$r[$i]->id).'"><i class="fa fa-check-square"></i></a>';
            } else if($status=='confirmed') {
                $ulr = '<a href="'.base_url('index.php/production/edit/confirmed/'.$r[$i]->id).'"><i class="fa fa-edit"></i></a>';
                $ulr2 = '<a href="'.base_url('index.php/production/edit/batch_confirmed/'.$r[$i]->id).'"><i class="fa fa-check-square"></i></a>';
            } else if($status=='batch_confirmed') {
                $ulr = '<a href="'.base_url('index.php/production/edit/batch_confirmed/'.$r[$i]->id).'"><i class="fa fa-edit"></i></a>';
                $ulr2 = '<a href="'.base_url('index.php/production/edit/raw_material_confirmed/'.$r[$i]->id).'"><i class="fa fa-check-square"></i></a>';
            } else if($status=='raw_material_confirmed') {
                $ulr = '<a href="'.base_url('index.php/production/edit/raw_material_confirmed/'.$r[$i]->id).'"><i class="fa fa-edit"></i></a>';
                $ulr2 = '';
            } else if($status=='inactive') {
                $ulr = '<a href="'.base_url('index.php/production/edit/inactive/'.$r[$i]->id).'"><i class="fa fa-edit"></i></a>';
                $ulr2 = '';
            }

            $data[] = array(
                        $i+1,

                        $ulr,

                        $ulr2,

                        $r[$i]->p_id,

                        (($r[$i]->from_date!=null && $r[$i]->from_date!='')?date('d/m/Y',strtotime($r[$i]->from_date)):''),

                        (($r[$i]->to_date!=null && $r[$i]->to_date!='')?date('d/m/Y',strtotime($r[$i]->to_date)):''),

                        $r[$i]->manufacturer_name,

                        (($r[$i]->confirm_from_date!=null && $r[$i]->confirm_from_date!='')?date('d/m/Y',strtotime($r[$i]->confirm_from_date)):''),

                        (($r[$i]->confirm_to_date!=null && $r[$i]->confirm_to_date!='')?date('d/m/Y',strtotime($r[$i]->confirm_to_date)):''),

                        $r[$i]->p_status
                    );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => count($r),
                        "recordsFiltered" => count($r),
                        "data" => $data
                    );
        echo json_encode($output);
    }

    public function add(){
        $result=$this->production_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->production_model->get_access();
                $data['p_id'] = $this->production_model->get_production_id();
                $data['depot'] = $this->production_model->get_manufacturer();

                load_view('production/production_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($status='', $id=''){
        $result=$this->production_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->production_model->get_access();
                $data['data'] = $this->production_model->get_data('', $id);
                $data['depot'] = $this->production_model->get_manufacturer();
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['batch_items'] = $this->production_model->get_batch_items($id);
                $data['raw_material_items'] = $this->production_model->get_batch_raw_materials($id);
                $preliminary_details = $this->production_model->get_preliminary_details($id);
                if(count($preliminary_details)>0){
                    $data['preliminary_details'] = $preliminary_details;
                }
                $data['email_to'] = $this->production_model->get_manufacturer_emails($id);

                if($status=='preliminary_check') {
                    load_view('production/preliminary_check', $data);
                } else if($status=='requested') {
                    load_view('production/production_details', $data);
                } else if($status=='confirmed') {
                    load_view('production/confirm_details', $data);
                } else if($status=='batch_confirmed') {
                    load_view('production/confirm_batch', $data);
                } else if($status=='raw_material_confirmed') {
                    load_view('production/confirm_raw_material', $data);
                } else {
                    load_view('production/production_details', $data);
                }
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->production_model->save_data();
        redirect(base_url().'index.php/production');
    }

    public function update($id){
        $this->production_model->save_data($id);
        redirect(base_url().'index.php/production');
    }

    public function confirm($id){
        $this->production_model->confirm($id);
        redirect(base_url().'index.php/production/checkstatus/confirmed');
    }

    public function confirm_batch($id){
        $this->production_model->confirm_batch($id);
        redirect(base_url().'index.php/production/checkstatus/batch_confirmed');
    }

    public function confirm_raw_material($id){
        $this->production_model->confirm_raw_material($id);
        redirect(base_url().'index.php/production/checkstatus/raw_material_confirmed');
    }

    public function preliminary_check($id=''){
        $this->production_model->preliminary_check($id);
        redirect(base_url().'index.php/dashboard');
    }

    public function get_total_bar_qty(){
        $product_id = $this->input->post('product_id');
        $total_batch_bar = 0;
        $data = $this->production_model->get_product_details($product_id);
        if(isset($data)){
            if(count($data)>0){
                $total_batch_bar = $data[0]->total_batch_bar;
            }
        }
        $result['bar_qty'] = $total_batch_bar;
        echo json_encode($result);
    }

    public function post_details($id){
        $result=$this->production_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->production_model->get_access();
                $data['production_id'] = $id;
                $data['data'] = $this->production_model->get_data('', $id);
                $data['batch_master'] = $this->production_model->get_production_batch_nos($id);
                $data['batch_processing'] = $this->production_model->get_production_batch_processing($id);
                $data['bar_to_box'] = $this->production_model->get_production_bar_to_box($id);
                $data['depot_transfer'] = $this->production_model->get_production_depot_transfer($id);
                $data['raw_material_check_doc'] = $this->production_model->get_production_documents($id, 'raw_material_check');
                $data['sorting_doc'] = $this->production_model->get_production_documents($id, 'sorting');
                $data['processing_doc'] = $this->production_model->get_production_documents($id, 'processing');
                $data['quality_control_doc'] = $this->production_model->get_production_documents($id, 'quality_control');
                $data['packaging_doc'] = $this->production_model->get_production_documents($id, 'packaging');
                $data['qc_report_doc'] = $this->production_model->get_production_documents($id, 'qc_report');
                $data['erp_updating_doc'] = $this->production_model->get_production_documents($id, 'erp_updating');
                $data['physical_rm_doc'] = $this->production_model->get_production_documents($id, 'physical_rm');
                $data['recon_of_rm_doc'] = $this->production_model->get_production_documents($id, 'recon_of_rm');
                $data['raw_material_recon'] = $this->production_model->get_production_raw_material_recon($id);

                load_view('production/post_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function upload_documents($id){
        $this->production_model->upload_documents($id);
        redirect(base_url().'index.php/production/post_details/'.$id);
    }

    public function view_production_report($id='', $approve=''){
        $result=$this->production_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $this->production_model->generate_production_report($id, $approve);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update_report($id){
        $this->production_model->update_report($id);
        redirect(base_url().'index.php/production/post_details/'.$id);
    }
}
?>