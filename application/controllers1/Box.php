<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Box extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('box_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->box_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->box_model->get_data();

            load_view('box/box_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->box_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['box_name'] = $result[0]->box_name;
            $data['barcode'] = $result[0]->barcode;
            $data['grams'] = $result[0]->grams;
            $data['rate'] = $result[0]->rate;
        }

        echo json_encode($data);
    }

    public function get_products(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->box_model->get_box_product($id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['product'][$i]=$result[$i]->product_id;
                $data['product_name'][$i]=$result[$i]->product_name;
                $data['qty'][$i]=$result[$i]->qty;
            }
        }

        echo json_encode($data);
    }

    public function add(){
        $result=$this->box_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->box_model->get_access();
                $data['product'] = $this->product_model->get_data('Approved');

                load_view('box/box_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->box_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->box_model->get_access();
                $data['product'] = $this->product_model->get_data('Approved');
                $data['data'] = $this->box_model->get_data('', $id);
                $data['box_products'] = $this->box_model->get_box_product($id);

                load_view('box/box_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->box_model->save_data();
        redirect(base_url().'index.php/box');
    }

    public function update($id){
        $this->box_model->save_data($id);
        redirect(base_url().'index.php/box');
    }

    public function check_box_name_availablity(){
        $result = $this->box_model->check_box_name_availablity();
        echo $result;
    }
    
    public function check_barcode_availablity(){
        $result = $this->box_model->check_barcode_availablity();
        echo $result;
    }
}
?>