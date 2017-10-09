<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor_transfer extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('distributor_transfer_model');
        $this->load->model('distributor_model');
        $this->load->model('box_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->distributor_transfer_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->distributor_transfer_model->get_data();

            load_view('distributor_transfer/distributor_transfer_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->distributor_transfer_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->distributor_transfer_model->get_access();
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');

                load_view('distributor_transfer/distributor_transfer_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->distributor_transfer_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_transfer_model->get_access();
                $data['data'] = $this->distributor_transfer_model->get_data('', $id);
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_transfer_items'] = $this->distributor_transfer_model->get_distributor_transfer_items($id);

                load_view('distributor_transfer/distributor_transfer_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->distributor_transfer_model->save_data();
        redirect(base_url().'index.php/distributor_transfer');
    }

    public function update($id){
        $this->distributor_transfer_model->save_data($id);
        redirect(base_url().'index.php/distributor_transfer');
    }

    public function check_product_availablity(){
        $result = $this->distributor_transfer_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->distributor_transfer_model->check_product_qty_availablity();
        echo $result;
    }
}
?>