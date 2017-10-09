<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_distributor extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_distributor_model');
        $this->load->model('sales_rep_order_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_distributor_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_distributor_model->get_data();

            load_view('sales_rep_distributor/sales_rep_distributor_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sales_rep_distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_distributor_model->get_access();

                load_view('sales_rep_distributor/sales_rep_distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->sales_rep_distributor_model->get_data('', $id);

                load_view('sales_rep_distributor/sales_rep_distributor_details', $data);
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
            $id = $this->sales_rep_distributor_model->save_data();
        } else {
            $id = substr($id, 2);
            $id = $this->sales_rep_distributor_model->save_data($id);
        }

        if($this->input->post('place_order')=="Yes") {
            redirect(base_url().'index.php/Sales_rep_order/add_order/'.$id);
        } else {
            redirect(base_url().'index.php/sales_rep_distributor');
        }
    }

    // public function save(){
    //     $this->sales_rep_distributor_model->save_data();
    //     redirect(base_url().'index.php/sales_rep_distributor');
    // }

    // public function update($id){
    //     $this->sales_rep_distributor_model->save_data($id);
    //     redirect(base_url().'index.php/sales_rep_distributor');
    // }
}
?>