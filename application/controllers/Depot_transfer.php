<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Depot_transfer extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('depot_transfer_model');
        $this->load->model('depot_model');
        $this->load->model('raw_material_model');
        $this->load->model('box_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->depot_transfer_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->depot_transfer_model->get_data();

            load_view('depot_transfer/depot_transfer_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->depot_transfer_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->depot_transfer_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');

                load_view('depot_transfer/depot_transfer_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->depot_transfer_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->depot_transfer_model->get_access();
                $data['data'] = $this->depot_transfer_model->get_data('', $id);
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['depot_transfer_items'] = $this->depot_transfer_model->get_depot_transfer_items($id);

                load_view('depot_transfer/depot_transfer_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->depot_transfer_model->save_data();
        redirect(base_url().'index.php/depot_transfer');
    }

    public function update($id){
        $this->depot_transfer_model->save_data($id);
        redirect(base_url().'index.php/depot_transfer');
    }

    public function check_raw_material_availablity(){
        $result = $this->depot_transfer_model->check_raw_material_availablity();
        echo $result;
    }

    public function check_raw_material_qty_availablity(){
        $result = $this->depot_transfer_model->check_raw_material_qty_availablity();
        echo $result;
    }
    
    public function check_product_availablity(){
        $result = $this->depot_transfer_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->depot_transfer_model->check_product_qty_availablity();
        echo $result;
    }
}
?>