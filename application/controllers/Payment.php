<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Payment extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('payment_model');
        $this->load->model('bank_model');
        $this->load->model('distributor_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->payment_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->payment_model->get_data();

        //     load_view('payment/payment_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }

        $this->checkstatus('Approved');
    }

    public function checkstatus($status=''){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->payment_model->get_data($status);

            $count_data=$this->payment_model->get_data();
            $approved=0;
            $pending=0;
            $rejected=0;
            $inactive=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING" || strtoupper(trim($count_data[$i]->status))=="DELETED")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inactive']=$inactive;
            $data['all']=count($count_data);

            load_view('payment/payment_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_total_outstanding(){
        $id=$this->input->post('id');
        $distributor_id=$this->input->post('distributor_id');
        $module=$this->input->post('module');

        // $id=1;
        // $distributor_id=1;
        // $module='';

        $result=$this->payment_model->get_total_outstanding($id, $distributor_id, $module);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['total_outstanding'] = $result[0]->total_outstanding;
        }

        echo json_encode($data);
    }

    public function get_invoice_nos(){
        $id=$this->input->post('id');
        $distributor_id=$this->input->post('distributor_id');
        // $distributor_id=1;

        $result=$this->payment_model->get_invoice_nos($id, $distributor_id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['invoice_no'][$i]=$result[$i]->invoice_no;
            }
        }

        echo json_encode($data);
    }

    public function get_invoice_details(){
        $id=$this->input->post('id');
        $invoice_no=$this->input->post('invoice_no');
        // $invoice_no=1;

        $result=$this->payment_model->get_invoice_details($id, $invoice_no);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['client_name'] = $result[0]->client_name;
            $data['final_amount'] = $result[0]->final_amount;
        }

        echo json_encode($data);
    }

    public function add(){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['bank'] = $this->bank_model->get_data('Approved');

                load_view('payment/payment_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                
                $id = $this->payment_model->get_pending_data($id);
                
                $data['data'] = $this->payment_model->get_data('', $id);
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['bank'] = $this->bank_model->get_data('Approved');
                $data['payment_items'] = $this->payment_model->get_payment_items($id);
                $data['denomination'] = $this->payment_model->get_payment_slip_denomination($id);

                load_view('payment/payment_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->payment_model->save_data();
        redirect(base_url().'index.php/payment');
    }

    public function update($id){
        $this->payment_model->save_data($id);
        redirect(base_url().'index.php/payment');
    }

    public function view_payment_slip($id){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $this->payment_model->generate_payment_slip($id);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

}
?>