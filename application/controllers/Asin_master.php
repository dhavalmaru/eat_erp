<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Asin_master extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('asin_master_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->asin_master_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->asin_master_model->get_data();

            load_view('asin_master/asin_master_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->asin_master_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['product_name'] = $result[0]->product_name;
            $data['asin'] = $result[0]->asin;
        }

        echo json_encode($data);
    }

    public function add(){
        $result=$this->asin_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->asin_master_model->get_access();
                load_view('asin_master/asin_master_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->asin_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->asin_master_model->get_access();
                $data['data'] = $this->asin_master_model->get_data('', $id);

                load_view('asin_master/asin_master_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->asin_master_model->save_data();
        redirect(base_url().'index.php/asin_master');
    }

    public function update($id){
        $this->asin_master_model->save_data($id);
        redirect(base_url().'index.php/asin_master');
    }

    public function check_asin_availablity(){
        $result = $this->asin_master_model->check_asin_availablity();
        echo $result;
    }
}
?>