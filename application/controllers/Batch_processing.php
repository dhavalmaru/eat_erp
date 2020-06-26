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
        $this->load->model('production_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
           $this->checkstatus('Approved');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status=''){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->batch_processing_model->get_data($status);

            $count_data=$this->batch_processing_model->get_data();
            $approved=0;
            $pending=0;
            $rejected=0;
            $inactive=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING" || strtoupper(trim($count_data[$i]->status))=="DELETED")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inactive']=$inactive;
            $data['status']=$status;
            $data['all']=count($count_data);

            load_view('batch_processing/batch_processing_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data_ajax($status=''){
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $data=$this->batch_processing_model->get_data($status);
        $records = array();
        for ($i=0; $i < count($data); $i++) { 
                $records[] =  array(
                        $i+1,   
                        '<span style="display:none;">'.(($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('Ymd',strtotime($data[$i]->date_of_processing)):'').'</span>'.(($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''),							
                        '<a href="'.base_url().'index.php/batch_processing/edit/'.$data[$i]->id.'"><i class="fa fa-edit"></i></a>',
                        '<a href="'.base_url().'index.php/batch_processing/view_batch_processing_receipt/'.$data[$i]->id.'" target="_blank"><span class="fa fa-file-pdf-o" style=""></span></a>',
                        ''.$data[$i]->batch_no.'',
                        ''.$data[$i]->depot_name.'',
                        ''.$data[$i]->product_name.'',
                        ''.format_money($data[$i]->qty_in_bar,2).'',
                        ''.format_money($data[$i]->actual_wastage,2).''
                    );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => count($data),
                        "recordsFiltered" => count($data),
                        "data" => $records
                    );
        echo json_encode($output); 
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

    public function add($p_id='', $module=''){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->batch_processing_model->get_access();
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['batch_no'] = $this->batch_master_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['p_id'] = $p_id;
                $data['production'] = $this->production_model->get_data('Approved');
                $data['module'] = $module;
                if($p_id!=''){
                    $data['p_data'] = $this->production_model->get_data('', $p_id);
                }

                load_view('batch_processing/batch_processing_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id, $module=''){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->batch_processing_model->get_access();
                $id = $this->batch_processing_model->get_pending_data($id);
                $data['data'] = $this->batch_processing_model->get_data('', $id);
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['batch_no'] = $this->batch_master_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['raw_material_stock'] = $this->batch_processing_model->get_batch_raw_material($id);
                
				$data['batch_images'] = $this->batch_processing_model->get_batch_images($id);

                $data['production'] = $this->production_model->get_data('Approved');
                $data['module'] = $module;
				
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
        // redirect(base_url().'index.php/batch_processing');
    }

    public function update($id){
        $this->batch_processing_model->save_data($id);
        //  redirect(base_url().'index.php/batch_processing');
	    // echo '<script>window.open("'.base_url().'index.php/batch_processing", "_parent")</script>';
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

    public function add_tentative($p_id='', $module=''){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->batch_processing_model->get_access();
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['batch_no'] = $this->batch_master_model->get_data('Approved');
                $data['p_id'] = $p_id;
                $data['production'] = $this->production_model->get_data('Approved');
                $data['module'] = $module;
                if($p_id!=''){
                    $data['p_data'] = $this->production_model->get_data('', $p_id);
                }

                load_view('batch_processing/tentative_stock_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit_tentative($id, $module=''){
        $result=$this->batch_processing_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->batch_processing_model->get_access();
                $id = $this->batch_processing_model->get_pending_data($id);
                $data['data'] = $this->batch_processing_model->get_data('', $id);
                $data['product'] = $this->product_model->get_data('Approved');
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['batch_no'] = $this->batch_master_model->get_data('Approved');
                $data['production'] = $this->production_model->get_data('Approved');
                $data['module'] = $module;
                
                load_view('batch_processing/tentative_stock_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function save_tentative(){
        $this->batch_processing_model->save_tentative_data();
        // redirect(base_url().'index.php/batch_processing');
    }

    public function update_tentative($id){
        $this->batch_processing_model->save_tentative_data($id);
        //  redirect(base_url().'index.php/batch_processing');
        // echo '<script>window.open("'.base_url().'index.php/batch_processing", "_parent")</script>';
    }
}
?>