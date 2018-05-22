<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor_sale_in extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('distributor_sale_in_model');
        $this->load->model('box_model');
        $this->load->model('distributor_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->distributor_sale_in_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->distributor_sale_in_model->get_data();
            //$data['sale_in'] = $this->distributor_sale_in_model->get_store($postData);

            load_view('distributor_sale_in/distributor_sale_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
 public function get_store(){ 
   
    $postData = $this->input->post();
	$zone_id = $postData['zone_id'];
    $data = $this->distributor_sale_in_model->get_store($zone_id);

    echo json_encode($data); 
    }

	 public function get_location_data(){ 
   
    $postData = $this->input->post();
		$zone_id = $postData['zone_id'];
		$store_id = $postData['store_id'];
    $data = $this->distributor_sale_in_model->get_location_data($store_id,$zone_id);
    echo json_encode($data); 
    }
    public function add(){
        $result=$this->distributor_sale_in_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->distributor_sale_in_model->get_access();
                $data['distributor'] = $this->distributor_model->get_data('Approved', '', 'super stockist');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
				//$data['store'] = $this->distributor_sale_in_model->get_store();
				//$data['location'] = $this->distributor_sale_in_model->get_location_data();
				//$data['location'] = $this->distributor_sale_in_model->get_location();
				$data['zone'] = $this->distributor_sale_in_model->get_zone();
                load_view('distributor_sale_in/distributor_sale_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->distributor_sale_in_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_sale_in_model->get_access();
                $data['data'] = $this->distributor_sale_in_model->get_data('', $id);
                $data['distributor'] = $this->distributor_model->get_data('Approved', '', 'super stockist');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_sale_items'] = $this->distributor_sale_in_model->get_distributor_sale_items($id);
                $data['zone'] = $this->distributor_sale_in_model->get_zone();
				$zone_id=$data['data'][0]->zone_id;
				
				$data['store'] = $this->distributor_sale_in_model->get_store($zone_id);
				$store_id=$data['data'][0]->store_id;
				$data['location'] = $this->distributor_sale_in_model->get_location_data($store_id,$zone_id);
				//$data['location'] = $this->distributor_sale_in_model->get_location();
                load_view('distributor_sale_in/distributor_sale_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->distributor_sale_in_model->save_data();
        redirect(base_url().'index.php/distributor_sale_in');
    }

    public function update($id){
        $this->distributor_sale_in_model->save_data($id);
        redirect(base_url().'index.php/distributor_sale_in');
    }

    // public function save_super_stockist_distributor(){
        // $this->distributor_sale_model->save_super_stockist_distributor();
        // $data = $this->distributor_sale_model->get_super_stockist_distributor();
        // $result = '<option value="">Select</option>';
        // for($i=0; $i<count($data); $i++){
            // $result = $result . '<option value="'.$data[$i]->id.'">'.$data[$i]->distributor_name.'</option>';
        // }
        // echo $result;
    // }
}
?>