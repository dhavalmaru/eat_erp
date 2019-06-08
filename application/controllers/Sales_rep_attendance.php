<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_attendance extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('Sales_rep_attendance_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->Sales_rep_attendance_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->Sales_rep_attendance_model->get_data();
            $data['sales_rep']=$this->Sales_rep_attendance_model->get_sales_rep();

            load_view('sales_rep_attendance/sales_rep_attendance_details', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->Sales_rep_attendance_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->Sales_rep_attendance_model->get_access();
                $data['sales_rep']=$this->Sales_rep_attendance_model->get_sales_rep();
                $data['data'] = $this->Sales_rep_attendance_model->get_data();
                load_view('sales_rep_attendance/sales_rep_attendance_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->Sales_rep_attendance_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->Sales_rep_attendance_model->get_access();
                $data['sales_rep']=$this->Sales_rep_attendance_model->get_sales_rep();
                $data['data'] = $this->Sales_rep_attendance_model->get_data();
                $data['data1'] = $this->Sales_rep_attendance_model->get_data($id);

                load_view('sales_rep_attendance/sales_rep_attendance_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->Sales_rep_attendance_model->save_data();
        redirect(base_url().'index.php/sales_rep_attendance');
    }

    public function update($id){
        $this->Sales_rep_attendance_model->save_data($id);
        redirect(base_url().'index.php/sales_rep_attendance');
    }
}
?>