<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class relationship extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('relationship_model');
        $this->load->model('distributor_type_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->relationship_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->relationship_model->get_data();

            load_view('relationship_master/store_rel_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->relationship_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->relationship_model->get_access();
                $data['type'] = $this->distributor_type_model->get_data('Approved');

                load_view('relationship_master/store_rel_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->relationship_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->relationship_model->get_access();
                $data['data'] = $this->relationship_model->get_data('', $id);
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                load_view('relationship_master/store_rel_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->relationship_model->save_data();
        redirect(base_url().'index.php/relationship');
    }

    public function update($id){
        $this->relationship_model->save_data($id);
        redirect(base_url().'index.php/relationship');
    }

    public function check_store_availablity(){
        $result = $this->relationship_model->check_store_availablity();
        echo $result;
    }
}
?>