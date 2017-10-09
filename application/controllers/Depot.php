<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Depot extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('depot_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->depot_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->depot_model->get_data();

            load_view('depot/depot_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->depot_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->depot_model->get_access();

                load_view('depot/depot_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->depot_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->depot_model->get_access();
                $data['data'] = $this->depot_model->get_data('', $id);
                $data['depot_contacts'] = $this->depot_model->get_depot_contacts($id);

                load_view('depot/depot_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->depot_model->save_data();
        redirect(base_url().'index.php/depot');
    }

    public function update($id){
        $this->depot_model->save_data($id);
        redirect(base_url().'index.php/depot');
    }

    public function check_depot_availablity(){
        $result = $this->depot_model->check_depot_availablity();
        echo $result;
    }

    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->depot_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['state'] = $result[0]->state;
        }

        echo json_encode($data);
    }

}
?>