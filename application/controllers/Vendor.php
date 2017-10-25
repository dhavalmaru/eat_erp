<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Vendor extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('vendor_model');
        $this->load->model('vendor_type_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->vendor_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->vendor_model->get_data();

            load_view('vendor/vendor_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

	
	public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->raw_material_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['rm_name'] = $result[0]->rm_name;
            $data['hsn_code'] = $result[0]->hsn_code;
            $data['rate'] = $result[0]->rate;
        }

        echo json_encode($data);
    }
	
	
	
	
    public function add(){
        $result=$this->vendor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->vendor_model->get_access();
                $data['type'] = $this->vendor_type_model->get_data('Approved');

                load_view('vendor/vendor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->vendor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->vendor_model->get_access();
                $data['data'] = $this->vendor_model->get_data('', $id);
                $data['type'] = $this->vendor_type_model->get_data('Approved');
                $data['vendor_contacts'] = $this->vendor_model->get_vendor_contacts($id);

                load_view('vendor/vendor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->vendor_model->save_data();
        redirect(base_url().'index.php/vendor');
    }

    public function update($id){
        $this->vendor_model->save_data($id);
        redirect(base_url().'index.php/vendor');
    }

    public function check_vendor_availablity(){
        $result = $this->vendor_model->check_vendor_availablity();
        echo $result;
    }
}
?>