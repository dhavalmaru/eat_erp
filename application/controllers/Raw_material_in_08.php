<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Raw_material_in extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('raw_material_in_model');
        $this->load->model('vendor_model');
        $this->load->model('depot_model');
        $this->load->model('raw_material_model');
        $this->load->model('purchase_order_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->raw_material_in_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->raw_material_in_model->get_data();

            load_view('raw_material_in/raw_material_in_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->raw_material_in_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->raw_material_in_model->get_access();
                $data['vendor'] = $this->vendor_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['purchase_order'] = $this->purchase_order_model->get_data('Approved');
				 

                load_view('raw_material_in/raw_material_in_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->raw_material_in_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->raw_material_in_model->get_access();
                $data['data'] = $this->raw_material_in_model->get_data('', $id);
                $data['vendor'] = $this->vendor_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['purchase_order'] = $this->purchase_order_model->get_data('Approved');
                $data['raw_material_stock'] = $this->raw_material_in_model->get_raw_material_stock($id);

                load_view('raw_material_in/raw_material_in_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->raw_material_in_model->save_data();
        redirect(base_url().'index.php/raw_material_in');
    }

    public function update($id){
        $this->raw_material_in_model->save_data($id);
        redirect(base_url().'index.php/raw_material_in');
    }

}
?>