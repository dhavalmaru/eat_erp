<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Combo_box extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('combo_box_model');
        $this->load->model('product_model');
        $this->load->model('box_model');
        $this->load->model('category_master_model','category');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->combo_box_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->combo_box_model->get_data();

            load_view('combo_box/combo_box_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->combo_box_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['combo_box_name'] = $result[0]->combo_box_name;
            $data['barcode'] = $result[0]->barcode;
            $data['grams'] = $result[0]->grams;
            $data['rate'] = $result[0]->rate;
            $data['cost'] = $result[0]->cost;
        }

        echo json_encode($data);
    }

    public function get_items(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->combo_box_model->get_combo_box_items($id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['item_id'][$i]=$result[$i]->item_id;
                $data['item_name'][$i]=$result[$i]->item_name;
                $data['qty'][$i]=$result[$i]->qty;
            }
        }

        echo json_encode($data);
    }

    public function add(){
        $result=$this->combo_box_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->combo_box_model->get_access();
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['category_detail']=$this->category->getCategoryDetails();

                load_view('combo_box/combo_box_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->combo_box_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->combo_box_model->get_access();
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['data'] = $this->combo_box_model->get_data('', $id);
                $data['combo_box_items'] = $this->combo_box_model->get_combo_box_items($id);
                $data['category_detail']=$this->category->getCategoryDetails();
                load_view('combo_box/combo_box_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->combo_box_model->save_data();
        redirect(base_url().'index.php/combo_box');
    }

    public function update($id){
        $this->combo_box_model->save_data($id);
        redirect(base_url().'index.php/combo_box');
    }

    public function check_combo_box_name_availablity(){
        $result = $this->combo_box_model->check_combo_box_name_availablity();
        echo $result;
    }
    
    public function check_barcode_availablity(){
        $result = $this->combo_box_model->check_barcode_availablity();
        echo $result;
    }
    
    public function check_sku_code_availablity(){
        $result = $this->combo_box_model->check_sku_code_availablity();
        echo $result;
    }
    
    public function check_asin_availablity(){
        $result = $this->combo_box_model->check_asin_availablity();
        echo $result;
    }
}
?>