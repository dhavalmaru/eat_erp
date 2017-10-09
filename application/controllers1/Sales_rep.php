<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_model');
        $this->load->model('document_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_model->get_data();

            load_view('sales_rep/sales_rep_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_model->get_access();

                load_view('sales_rep/sales_rep_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sales_rep_model->get_access();
                $data['data'] = $this->sales_rep_model->get_data('', $id);

                $docs=$this->document_model->edit_view_doc('', $id, 'Sales_Rep');
                $data=array_merge($data, $docs);

                load_view('sales_rep/sales_rep_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->sales_rep_model->save_data();
        redirect(base_url().'index.php/sales_rep');
    }

    public function update($id){
        $this->sales_rep_model->save_data($id);
        redirect(base_url().'index.php/sales_rep');
    }

    public function check_sales_rep_availablity(){
        $result = $this->sales_rep_model->check_sales_rep_availablity();
        echo $result;
    }

    public function sales_rep_route_plan(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            $data['access'] = $result;
            $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
            load_view('sales_rep/sales_rep_route_plan', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

}
?>