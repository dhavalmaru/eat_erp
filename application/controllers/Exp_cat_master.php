<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Exp_cat_master extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('exp_cat_master_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->exp_cat_master_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->exp_cat_master_model->get_data();

            load_view('exp_category/exp_cat_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->exp_cat_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->exp_cat_master_model->get_access();
                load_view('exp_category/exp_cat_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id, $module=''){
        $result=$this->exp_cat_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->exp_cat_master_model->get_access();
                $data['data'] = $this->exp_cat_master_model->get_data('', $id);

                load_view('exp_category/exp_cat_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->exp_cat_master_model->save_data();
        redirect(base_url().'index.php/exp_cat_master');
    }

    public function update($id){
        $this->exp_cat_master_model->save_data($id);
        redirect(base_url().'index.php/exp_cat_master');
    }

    public function check_category_availablity(){
        $result = $this->exp_cat_master_model->check_category_availablity();
        echo $result;
    }
    
}
?>