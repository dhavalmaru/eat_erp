<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_order extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_order_model');
        $this->load->model('box_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_order_model->get_data();

            load_view('sales_rep_order/sales_rep_order_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_order_model->get_access();
                $data['distributor'] = $this->sales_rep_order_model->get_distributors('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');

                load_view('sales_rep_order/sales_rep_order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sales_rep_order_model->get_access();
                $data['distributor'] = $this->sales_rep_order_model->get_distributors('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['data'] = $this->sales_rep_order_model->get_data('', $id);
                $data['sales_rep_order_items'] = $this->sales_rep_order_model->get_sales_rep_order_items($id);
                
                load_view('sales_rep_order/sales_rep_order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add_order($id){
        $result=$this->sales_rep_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sales_rep_order_model->get_access();
                $data['distributor'] = $this->sales_rep_order_model->get_distributors('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                // $data['distributor_id'] = 's_'.$id;
                $data['distributor_id'] = $id;
                
                load_view('sales_rep_order/sales_rep_order_details', $data);
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
            $id = $this->sales_rep_order_model->save_data();
        } else {
            $id = substr($id, 2);
            $id = $this->sales_rep_order_model->save_data($id);
        }

        redirect(base_url().'index.php/sales_rep_order');
    }

    // public function save(){
    //     $this->sales_rep_order_model->save_data();
    //     redirect(base_url().'index.php/sales_rep_order');
    // }

    // public function update($id){
    //     $this->sales_rep_order_model->save_data($id);
    //     redirect(base_url().'index.php/sales_rep_order');
    // }
    
    public function get_distributor_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->sales_rep_order_model->get_distributors('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['distributor_name'] = $result[0]->distributor_name;
            $data['sell_out'] = $result[0]->sell_out;
        }

        echo json_encode($data);
    }

    public function check_box_availablity(){
        $result = $this->sales_rep_order_model->check_box_availablity();
        echo $result;
    }

    public function check_box_qty_availablity(){
        $result = $this->sales_rep_order_model->check_box_qty_availablity();
        echo $result;
    }

    public function check_product_availablity(){
        $result = $this->sales_rep_order_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->sales_rep_order_model->check_product_qty_availablity();
        echo $result;
    }

}
?>