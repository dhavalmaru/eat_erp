<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Batch_master extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('batch_master_model');
        $this->load->model('production_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->batch_master_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->batch_master_model->get_data();

            load_view('batch_master/batch_master_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

	public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->batch_master_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['batch_no'] = $result[0]->batch_no;
        }

        echo json_encode($data);
    }
	
    public function add($p_id='', $module=''){
        $result=$this->batch_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->batch_master_model->get_access();
                $data['p_id'] = $p_id;
                $data['production'] = $this->production_model->get_data('Approved');
                $data['module'] = $module;

                load_view('batch_master/batch_master_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id, $module=''){
        $result=$this->batch_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->batch_master_model->get_access();
                $data['data'] = $this->batch_master_model->get_data('', $id);
				$data['batch_doc'] = $this->batch_master_model->get_batch_doc($id);
                $data['production'] = $this->production_model->get_data('Approved');
                $data['module'] = $module;

                load_view('batch_master/batch_master_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->batch_master_model->save_data();
        // redirect(base_url().'index.php/batch_master');
    }

    public function update($id){
        $this->batch_master_model->save_data($id);
        // redirect(base_url().'index.php/batch_master');
    }

    public function check_batch_id_availablity(){
        $result = $this->batch_master_model->check_batch_id_availablity();
        echo $result;
    }
    
}
?>