<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_distributor extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_distributor_model');
        $this->load->model('sales_rep_order_model');
        $this->load->model('sales_rep_location_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_distributor_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_distributor_model->get_data();

            load_view('sales_rep_distributor/sales_rep_distributor_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	public function index_admin(){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_distributor_model->get_data();

            load_view('sales_rep_distributor/admin_sales_rep_distributor_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sales_rep_distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_distributor_model->get_access();
                $data['distributor'] = $this->sales_rep_distributor_model->get_distributors();
                $data['zone'] = $this->sales_rep_distributor_model->get_zone();
                $data['area'] = $this->sales_rep_distributor_model->get_area();
                $data['location'] = $this->sales_rep_distributor_model->get_locations();

                load_view('sales_rep_distributor/sales_rep_distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	public function admin_add(){
        $data['access'] = $this->sales_rep_location_model->get_access();
        //$visit_detail = $this->session->userdata('visit_detail');

         $zone_id = $this->input->post('zone_id');
         $area_id = $this->input->post('area_id');
		 $data['zone'] = $this->sales_rep_location_model->get_zone();
                                $data['area'] = $this->sales_rep_location_model->get_area($zone_id);
                                $data['location'] = $this->sales_rep_location_model->get_locations($zone_id, $area_id);
						$data['distributor'] = $this->sales_rep_distributor_model->get_distributors();
                              
		   load_view('sales_rep_distributor/admin_sales_rep_distributor_details', $data);
    }
	
	

    public function edit($id){
        $result=$this->sales_rep_distributor_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->sales_rep_distributor_model->get_data('', $id);
                $data['distributor'] = $this->sales_rep_distributor_model->get_distributors();
                $data['zone'] = $this->sales_rep_distributor_model->get_zone();

                if(count($data['data'])>0){
                    $zone_id = $data['data'][0]->zone_id;
                    $area_id = $data['data'][0]->area_id;
                }
                
                $data['area'] = $this->sales_rep_distributor_model->get_area($zone_id);
                $data['location'] = $this->sales_rep_distributor_model->get_locations($zone_id, $area_id);

                load_view('sales_rep_distributor/sales_rep_distributor_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	 public function admin_edit($id){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->sales_rep_distributor_model->get_data('', $id);
              //  $data['distributor'] = $this->sales_rep_distributor_model->get_distributors();
                $data['zone'] = $this->sales_rep_distributor_model->get_zone();
				$zone_id="";
				$area_id="";
				$location_id="";
				if(count($data['data'])>0){
                    $zone_id = $data['data'][0]->zone_id;
                    $area_id = $data['data'][0]->area_id;
                    $location_id = $data['data'][0]->location_id;
                }
                
                $data['area'] = $this->sales_rep_distributor_model->get_area($zone_id);
                $data['location'] = $this->sales_rep_distributor_model->get_locations($zone_id, $area_id);
                //$data['location'] = $this->sales_rep_distributor_model->get_locations($zone_id, $area_id);

                load_view('sales_rep_distributor/admin_sales_rep_distributor_details', $data);
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
            $id = $this->sales_rep_location_model->save_data();
            $id = 's_'.$id;
        } else {
            $distributor_id = substr($id, 2);
            $this->sales_rep_distributor_model->save_data($distributor_id);
        }

        if($this->input->post('place_order')=="Yes") {
            redirect(base_url().'index.php/Sales_rep_order/add_order/'.$id);
        } else {
            redirect(base_url().'index.php/sales_rep_distributor');
        }
    }
	
	
	 public function admin_save($id=""){
        if($id == ""){
            $id = $this->sales_rep_distributor_model->save_data();
            $id = 's_'.$id;
        } else {
            $distributor_id = substr($id, 2);
            $this->sales_rep_distributor_model->save_data($distributor_id);
        }

      
            redirect(base_url().'index.php/sales_rep_distributor/admin_sales_rep_distributor_details');
        
    }
	
	
	

    public function get_area(){ 
        $postData = $this->input->post();
        $zone_id = $postData['zone_id'];
        $data = $this->sales_rep_location_model->get_area($zone_id);

        $area = '<option value="">Select</option>';
        for($i=0; $i<count($data); $i++){
            $area = $area . '<option value="'.$data[$i]->area_id.'">'.$data[$i]->area.'</option>';
        }

        echo $area; 
    }

    public function get_locations(){ 
        $postData = $this->input->post();
        $zone_id = $postData['zone_id'];
        $area_id = $postData['area_id'];
        $data = $this->sales_rep_location_model->get_locations($zone_id, $area_id);

        $location = '<option value="">Select</option>';
        for($i=0; $i<count($data); $i++){
            $location = $location . '<option value="'.$data[$i]->id.'">'.$data[$i]->location.'</option>';
        }

        echo $location;
    }
	public function check_distributor_availablity(){
        $result = $this->sales_rep_distributor_model->check_distributor_availablity();
        echo $result;
    }	
    // public function save(){
    //     $this->sales_rep_distributor_model->save_data();
    //     redirect(base_url().'index.php/sales_rep_distributor');
    // }

    // public function update($id){
    //     $this->sales_rep_distributor_model->save_data($id);
    //     redirect(base_url().'index.php/sales_rep_distributor');
    // }
}
?>