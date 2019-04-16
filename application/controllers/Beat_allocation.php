<?php

if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Beat_allocation extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('beat_allocation_model');
        $this->load->database();
    }

    public function index(){
        $result=$this->beat_allocation_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->beat_allocation_model->get_data();
            load_view('beat_allocation/beat_allocation_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->beat_allocation_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->beat_allocation_model->get_access();
                $data['allocations'] = $this->beat_allocation_model->get_beat_allocations();
                $data['type'] = $this->beat_allocation_model->get_type();
                $data['sales_rep'] = $this->beat_allocation_model->get_sales_rep();
                $data['rep_manager'] = $this->beat_allocation_model->get_sales_rep();
                $data['distributor'] = $this->beat_allocation_model->get_distributors();
                $data['beat_plan'] = $this->beat_allocation_model->get_beat_plan();

                load_view('beat_allocation/beat_allocation_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($sales_rep_id){
        $result=$this->beat_allocation_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->beat_allocation_model->get_access();
                $data['data'] = $this->beat_allocation_model->get_data('Approved', $sales_rep_id);
                $data['allocations'] = $this->beat_allocation_model->get_beat_allocations($sales_rep_id);
                $data['type'] = $this->beat_allocation_model->get_type();
                $data['sales_rep'] = $this->beat_allocation_model->get_sales_rep($sales_rep_id);
                $data['rep_manager'] = $this->beat_allocation_model->get_sales_rep();
                $data['distributor'] = $this->beat_allocation_model->get_distributors();
                $data['beat_plan'] = $this->beat_allocation_model->get_beat_plan();

                // echo json_encode($data['beat_plan']);

                load_view('beat_allocation/beat_allocation_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->beat_allocation_model->save_data();
        redirect(base_url().'index.php/beat_allocation');
    }

    public function update($sales_rep_id){
        $this->beat_allocation_model->save_data($sales_rep_id);
        redirect(base_url().'index.php/beat_allocation');
    }
	
	public function get_beat_plan(){ 
        $distributor_id = $this->input->post('distributor_id');
        $type_id = $this->input->post('type_id');
        $data = $this->beat_allocation_model->get_beat_plan($distributor_id, $type_id);
        echo json_encode($data); 
	}
}
?>