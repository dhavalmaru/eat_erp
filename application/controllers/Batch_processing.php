<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Batch_processing extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('batch_processing_model');
        $this->load->model('product_model');
        $this->load->model('depot_model');
        $this->load->model('raw_material_model');
        $this->load->model('stock_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->batch_processing_model->get_data();

            load_view('batch_processing/batch_processing_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->batch_processing_model->get_access();
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');

                load_view('batch_processing/batch_processing_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->batch_processing_model->get_access();
                $data['data'] = $this->batch_processing_model->get_data('', $id);
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['raw_material_stock'] = $this->batch_processing_model->get_batch_raw_material($id);

                load_view('batch_processing/batch_processing_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->batch_processing_model->save_data();
        redirect(base_url().'index.php/batch_processing');
    }

    public function update($id){
        $this->batch_processing_model->save_data($id);
        redirect(base_url().'index.php/batch_processing');
    }

    public function check_batch_id_availablity(){
        $result = $this->batch_processing_model->check_batch_id_availablity();
        echo $result;
    }
    
    public function check_raw_material_availablity(){
        $result = $this->stock_model->check_raw_material_availablity();
        echo $result;
    }

    public function check_raw_material_qty_availablity(){
        $result = $this->stock_model->check_raw_material_qty_availablity();
        echo $result;
    }
}
?>