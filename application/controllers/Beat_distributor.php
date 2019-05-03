<?php

if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Beat_distributor extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('beat_distributor_model');
        $this->load->database();
    }

    public function index(){
        $result=$this->beat_distributor_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->beat_distributor_model->get_data();
            load_view('beat_distributor/beat_distributor_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->beat_distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->beat_distributor_model->get_access();
                $data['beat_plan'] = $this->beat_distributor_model->get_beat_plans();
                $data['distributor'] = $this->beat_distributor_model->get_distributors();
                load_view('beat_distributor/beat_distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($beat_id){
        $result=$this->beat_distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->beat_distributor_model->get_access();
                $data['data'] = $this->beat_distributor_model->get_data('Approved', $beat_id);
                $data['beat_plan'] = $this->beat_distributor_model->get_beat_plans($beat_id);
                $data['distributor'] = $this->beat_distributor_model->get_distributors($beat_id);
                $data['distributor_beat_plans'] = $this->beat_distributor_model->get_beat_distributors($beat_id);
                load_view('beat_distributor/beat_distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->beat_distributor_model->save_data();
        redirect(base_url().'index.php/beat_distributor');
    }

    public function update($beat_id){
        $this->beat_distributor_model->save_data($beat_id);
        redirect(base_url().'index.php/beat_distributor');
    }
}
?>