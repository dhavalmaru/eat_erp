<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_location extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_location_model');
        $this->load->model('sales_rep_distributor_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_location_model->get_data();

            load_view('sales_rep_location/sales_rep_location_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_location_model->get_access();
                $data['distributor'] = $this->sales_rep_distributor_model->get_data1('Approved');

                load_view('sales_rep_location/sales_rep_location_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->sales_rep_location_model->get_data('', $id);
                $data['distributor'] = $this->sales_rep_distributor_model->get_data('Approved');

                load_view('sales_rep_location/sales_rep_location_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save($id=""){
        if($id == ""){
            $this->sales_rep_location_model->save_data();
        } else {
            $this->sales_rep_location_model->save_data($id);
        }

        if($this->input->post('distributor_status')=="Place Order") {
            $result=$this->sales_rep_distributor_model->get_access();
            if(count($result)>0) {
                if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                    $data['access'] = $result;
                    $data['distributor_name'] = $this->input->post('distributor_name');
                }
            }
        }

        if(isset($data)){
            load_view('sales_rep_distributor/sales_rep_distributor_details', $data);
        } else {
            redirect(base_url().'index.php/sales_rep_location');
        }
    }

    public function check_date_of_visit(){
        $result = $this->sales_rep_location_model->check_date_of_visit();
        echo $result;
    }
}
?>