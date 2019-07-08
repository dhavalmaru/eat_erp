<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Report_master extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('report_master_model');
        $this->load->database();
    }

    public function index(){
        $result=$this->report_master_model->get_access();
        if(count($result)>0) {
            $data['access'] = $result;
            $data['data'] = $this->report_master_model->get_data();
            load_view('report_master/report_master_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->report_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                load_view('report_master/report_master_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->report_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->report_master_model->get_data('', $id);
                $data['id']=$id;

                load_view('report_master/report_master_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->report_master_model->save_data();
        redirect(base_url().'index.php/report_master');
    }

    public function update($id){
        $this->report_master_model->save_data($id);
        redirect(base_url().'index.php/report_master');
    }

}
?>