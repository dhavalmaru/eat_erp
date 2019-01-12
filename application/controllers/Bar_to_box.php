<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Bar_to_box extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('box_model');
        $this->load->model('bar_to_box_model');
        $this->load->model('depot_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->bar_to_box_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->bar_to_box_model->get_data();
            
            load_view('bar_to_box/bar_to_box_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->bar_to_box_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->bar_to_box_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $date = date("Y-m-d", strtotime("-6 months"));
                $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
                $query = $this->db->query($sql);
                $data['batch'] = $query->result();
                load_view('bar_to_box/bar_to_box_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->bar_to_box_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->bar_to_box_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['data'] = $this->bar_to_box_model->get_data('', $id);
                $data['bar_to_boxes'] = $this->bar_to_box_model->get_bar_to_box_qty($id);
                $date = date("Y-m-d", strtotime("-6 months"));
                $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
                $query = $this->db->query($sql);
                $data['batch'] = $query->result();
                load_view('bar_to_box/bar_to_box_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->bar_to_box_model->save_data();
        redirect(base_url().'index.php/bar_to_box');
    }

    public function update($id){
        $this->bar_to_box_model->save_data($id);
        redirect(base_url().'index.php/bar_to_box');
    }

    public function check_product_availablity(){
        $result = $this->bar_to_box_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->bar_to_box_model->check_product_qty_availablity();
        echo $result;
    }
}
?>