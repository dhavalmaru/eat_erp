<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_target extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_target_model');
        $this->load->model('sales_rep_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_target_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_target_model->get_data();

            load_view('sales_rep_target/sales_rep_target_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sales_rep_target_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_target_model->get_access();
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');

                load_view('sales_rep_target/sales_rep_target_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_target_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->sales_rep_target_model->get_data('', $id);
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');

                load_view('sales_rep_target/sales_rep_target_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save($id=""){
        if($id == ""){
            $this->sales_rep_target_model->save_data();
        } else {
            $this->sales_rep_target_model->save_data($id);
        }

        redirect(base_url().'index.php/sales_rep_target');
    }

    public function test(){
        $min_date = date('Y-m-d', strtotime("2016-01-01"));
        $date = date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))));
        while ($date>=$min_date) {
            echo date('M-y', strtotime($date));
            echo '<br>';
            $date = date('Y-m-d', strtotime("-1 months", strtotime($date)));
        }
    }
}
?>