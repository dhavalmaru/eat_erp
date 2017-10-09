<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Product extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->product_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->product_model->get_data();

            load_view('product/product_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->product_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['product_name'] = $result[0]->product_name;
            $data['barcode'] = $result[0]->barcode;
            $data['grams'] = $result[0]->grams;
            $data['avg_grams'] = $result[0]->avg_grams;
            $data['rate'] = $result[0]->rate;
            $data['anticipated_wastage'] = $result[0]->anticipated_wastage;
        }

        echo json_encode($data);
    }

    public function add(){
        $result=$this->product_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->product_model->get_access();

                load_view('product/product_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->product_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->product_model->get_access();
                $data['data'] = $this->product_model->get_data('', $id);

                load_view('product/product_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->product_model->save_data();
        redirect(base_url().'index.php/product');
    }

    public function update($id){
        $this->product_model->save_data($id);
        redirect(base_url().'index.php/product');
    }

    public function check_product_availablity(){
        $result = $this->product_model->check_product_availablity();
        echo $result;
    }
}
?>