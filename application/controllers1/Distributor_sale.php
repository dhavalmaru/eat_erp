<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor_sale extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('distributor_sale_model');
        $this->load->model('box_model');
        $this->load->model('distributor_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->distributor_sale_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->distributor_sale_model->get_data();

            load_view('distributor_sale/distributor_sale_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->distributor_sale_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->distributor_sale_model->get_access();
                $data['distributor'] = $this->distributor_model->get_data('Approved', '', 'super stockist');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');

                load_view('distributor_sale/distributor_sale_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->distributor_sale_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_sale_model->get_access();
                $data['data'] = $this->distributor_sale_model->get_data('', $id);
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_sale_items'] = $this->distributor_sale_model->get_distributor_sale_items($id);

                load_view('distributor_sale/distributor_sale_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->distributor_sale_model->save_data();
        redirect(base_url().'index.php/distributor_sale');
    }

    public function update($id){
        $this->distributor_sale_model->save_data($id);
        redirect(base_url().'index.php/distributor_sale');
    }
}
?>