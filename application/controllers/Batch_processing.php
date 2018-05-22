<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Batch_processing extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('batch_processing_model');
        $this->load->model('product_model');
        $this->load->model('depot_model');
        $this->load->model('batch_master_model');
        $this->load->model('raw_material_model');
       // $this->load->model('ingredients_master');
        $this->load->model('stock_model');
        $this->load->database();
    }

    //index function
	
    public function index(){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->batch_processing_model->get_data();

            load_view('batch_processing/batch_processing_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

	    // public function get_data(){
        // $id=$this->input->post('id');
       // $id=1;

        // $result=$this->batch_processing_model->get_data('', $id);
        // $data['result'] = 0;
        // if(count($result)>0) {
            // $data['result'] = 1;
            // $data['product_id'] = $result[0]->product_id;
            // $data['no_of_batch'] = $result[0]->no_of_batch;
          
        // }

        // echo json_encode($data);
    // }
    public function add(){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->batch_processing_model->get_access();
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['batch_no'] = $this->batch_master_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');

                load_view('batch_processing/batch_processing_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->batch_processing_model->get_access();
                $data['data'] = $this->batch_processing_model->get_data('', $id);
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['batch_no'] = $this->batch_master_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['raw_material_stock'] = $this->batch_processing_model->get_batch_raw_material($id);
              
				   $data['batch_images'] = $this->batch_processing_model->get_batch_images($id);
				
				    // $query=$this->db->query("SELECT * FROM batch_images WHERE batch_processing_id = '$id'");
                // $result=$query->result();
                // if(count($result)>0){
                    // $data['batch_images']=$result;
                // }

                load_view('batch_processing/batch_processing_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
		    public function get_batch_raw_material1(){
			$product_id=$this->input->post('product_id');
        // $id=1;

        $result=$this->batch_processing_model->get_batch_raw_material1($product_id);
		
        // $data['result'] = 0;
        // if(count($result)>0) {
            // $data['result'] = 1;
            // for($i=0; $i<count($result); $i++){
                // $data['raw_material_id'][$i] = $result[$i]->rm_id;
                // $data['qty'][$i] = $result[$i]->qty_per_batch;
              
            // }
        // }

        echo json_encode($result);
    }
	

    public function save(){
		
		
        $this->batch_processing_model->save_data();
   
        redirect(base_url().'index.php/batch_processing');
    }

    public function update($id){
        $this->batch_processing_model->save_data($id);
        redirect(base_url().'index.php/batch_processing');
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

    public function view_batch_processing_receipt($id){
        $data['data'] = $this->batch_processing_model->get_data('', $id);
        $data['batch_processing_items'] = $this->batch_processing_model->get_batch_raw_material($id);

        load_view('invoice/batch_processing_receipt', $data);
    }
}
?>