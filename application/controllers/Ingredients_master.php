<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Ingredients_master extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('ingredients_master_model');
        $this->load->model('product_model');
        $this->load->model('depot_model');
        $this->load->model('batch_master_model');
        $this->load->model('raw_material_model');
        $this->load->model('stock_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->ingredients_master_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->ingredients_master_model->get_data();

            load_view('ingredients_master/ingredients_master_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->ingredients_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->ingredients_master_model->get_access();
                $data['product'] = $this->product_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');

                load_view('ingredients_master/ingredients_master_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->ingredients_master_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->ingredients_master_model->get_access();
                $data['data'] = $this->ingredients_master_model->get_data('', $id);
                $data['product'] = $this->product_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['raw_material_stock'] = $this->ingredients_master_model->get_batch_raw_material($id);

                load_view('ingredients_master/ingredients_master_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->ingredients_master_model->save_data();
        redirect(base_url().'index.php/ingredients_master');
    }

    public function update($id){
        $this->ingredients_master_model->save_data($id);
        redirect(base_url().'index.php/ingredients_master');
    }

	    public function get_batch_raw_material1(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->ingredients_master_model->get_batch_raw_material1($id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['raw_material_id'][$i] = $result[$i]->rm_id;
                $data['qty'][$i] = $result[$i]->qty_per_batch;
              
            }
        }

        echo json_encode($data);
    }
	public function check_product_id_availablity(){
        $result = $this->ingredients_master_model->check_product_id_availablity();
        echo $result;
    }
	
    public function check_batch_id_availablity(){
        $result = $this->batch_processing_model->check_batch_id_availablity();
        echo $result;
    }
    
    public function check_raw_material_availablity(){
        $result = $this->stock_model->check_raw_material_availablity();
        echo $result;
    }

    public function check_raw_material_qty_availablity(){
        $result = $this->stock_model->check_raw_material_qty_availablity();
        echo $result;
    }
}
?>