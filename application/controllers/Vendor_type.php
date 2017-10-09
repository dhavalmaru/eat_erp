<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Vendor_type extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('vendor_type_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->vendor_type_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->vendor_type_model->get_data();

            load_view('vendor_type/vendor_type_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->vendor_type_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->vendor_type_model->get_access();

                load_view('vendor_type/vendor_type_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->vendor_type_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->vendor_type_model->get_access();
                $data['data'] = $this->vendor_type_model->get_data('', $id);

                load_view('vendor_type/vendor_type_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->vendor_type_model->save_data();
        redirect(base_url().'index.php/vendor_type');
    }

    public function update($id){
        $this->vendor_type_model->save_data($id);
        redirect(base_url().'index.php/vendor_type');
    }

    public function check_vendor_type_availablity(){
        $result = $this->vendor_type_model->check_vendor_type_availablity();
        echo $result;
    }
}
?>