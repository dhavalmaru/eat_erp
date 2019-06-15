<?php

if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Beat_master extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('beat_model');
        $this->load->database();
    }

    public function index(){
        $result=$this->beat_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->beat_model->get_data();
            load_view('beat_plan/beat_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->beat_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->beat_model->get_access();
                $data['type'] = $this->beat_model->get_type();
                $data['zone'] = $this->beat_model->get_zone();
				$data['area'] = $this->beat_model->get_area();
                $data['store'] = $this->beat_model->get_store();
                $data['location'] = $this->beat_model->get_location();
                $data['beat_id'] = $this->beat_model->get_beat_id();
                load_view('beat_plan/beat_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->beat_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->beat_model->get_access();
                $data['data'] = $this->beat_model->get_data('', $id);

                $type_id = "";
                $zone_id = "";
                $area_id = "";
                $store_id = "";
                $location_id = "";

                if(count($data['data'])>0){
                    $type_id = $data['data'][0]->type_id;
                    $zone_id = $data['data'][0]->zone_id;
                    $area_id = $data['data'][0]->area_id;
                    $store_id = $data['data'][0]->store_id;
                    $location_id = explode(',', $data['data'][0]->location_id);
                }

				$data['type'] = $this->beat_model->get_type();
                $data['zone'] = $this->beat_model->get_zone($type_id);
                $data['area'] = $this->beat_model->get_area($type_id, $zone_id);
                $data['store'] = $this->beat_model->get_store($type_id, $zone_id);
                $data['location'] = $this->beat_model->get_location($type_id, $zone_id, $area_id);
                $data['beat_details'] = $this->beat_model->get_retailer($id, $type_id, $zone_id, $area_id, $location_id);
                $data['beat_locations'] = $this->beat_model->get_beat_locations($id);

                load_view('beat_plan/beat_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->beat_model->save_data();
        redirect(base_url().'index.php/beat_master');
    }

    public function update($id){
        $this->beat_model->save_data($id);
        redirect(base_url().'index.php/beat_master');
    }
	
	public function get_zone(){ 
        $type_id = $this->input->post('type_id');
        $data = $this->beat_model->get_zone($type_id);
        echo json_encode($data); 
	}

    public function get_area(){ 
        $type_id = $this->input->post('type_id');
        $zone_id = $this->input->post('zone_id');
        $data = $this->beat_model->get_zone($type_id, $zone_id);
        echo json_encode($data); 
    }

    public function get_store(){ 
        $type_id = $this->input->post('type_id');
        $zone_id = $this->input->post('zone_id');
        $data = $this->beat_model->get_store($type_id, $zone_id);
        echo json_encode($data); 
    }

    public function get_location(){ 
        $type_id = $this->input->post('type_id');
        $zone_id = $this->input->post('zone_id');
        $area_id = $this->input->post('area_id');
        $data = $this->beat_model->get_location($type_id, $zone_id, $area_id);
        echo json_encode($data); 
    }

    public function get_retailer(){ 
        $beat_id = $this->input->post('id');
        $type_id = $this->input->post('type_id');
        $zone_id = $this->input->post('zone_id');
        $area_id = $this->input->post('area_id');
        $location_id = $this->input->post('location_id');

        // $beat_id = '';
        // $type_id = '3';
        // $zone_id = '7';
        // $area_id = '';
        // $location_id = array(18);

        $data = $this->beat_model->get_retailer($beat_id, $type_id, $zone_id, $area_id, $location_id);
        echo json_encode($data); 
    }

    public function check_beat_name_availablity(){
        $result = $this->beat_model->check_beat_name_availablity();
        echo $result;
    }

    public function upload_file(){
        $this->beat_model->upload_file();
        redirect(base_url().'index.php/beat_master');
    }

    public function download_csv(){
        $this->beat_model->download_csv();
        // redirect(base_url().'index.php/beat_master');
    }

}
?>