<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Promoter_location extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('promoter_location_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->promoter_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->promoter_location_model->get_data();

            load_view('promoter_location/promoter_location_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->promoter_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->promoter_location_model->get_access();
                $data['distributor'] = $this->promoter_location_model->get_dist_list();

                load_view('promoter_location/promoter_location_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->promoter_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->promoter_location_model->get_data('', $id);
                $data['data1'] = $this->promoter_location_model->get_data_qty('', $id);
                $data['distributor'] = $this->promoter_location_model->get_data('Approved');

                load_view('promoter_location/promoter_location_details', $data);
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
            $this->promoter_location_model->save_data('');
        } else {
            $this->promoter_location_model->save_data($id);
        }

        redirect(base_url().'index.php/dashboard_promoter');
        
    }

    public function check_date_of_visit(){
        $result = $this->promoter_location_model->check_date_of_visit();
        echo $result;
    }
}
?>