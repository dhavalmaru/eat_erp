<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Area extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('area_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->area_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->area_model->get_data();

            load_view('area/area_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->area_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->area_model->get_access();

                load_view('area/area_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->area_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->area_model->get_access();
                $data['data'] = $this->area_model->get_data('', $id);

                load_view('area/area_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->area_model->save_data();
        redirect(base_url().'index.php/area');
    }

    public function update($id){
        $this->area_model->save_data($id);
        redirect(base_url().'index.php/area');
    }

    public function check_area_availablity(){
        $result = $this->area_model->check_area_availablity();
        echo $result;
    }
}
?>