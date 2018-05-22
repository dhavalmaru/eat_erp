<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class store extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('relationship_model');
		$this->load->model('area_model');
        $this->load->model('distributor_type_model');
        $this->load->model('zone_model');
        $this->load->model('store_model');
        $this->load->model('location_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->store_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->store_model->get_data();

            load_view('store_master/store_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
	
	 public function locations($status=''){
        $result=$this->store_model->get_access();
        if(count($result)>0) {
            load_view_without_data('store_master/store_loc_map');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function get_store_locations($id){
        // $result=$this->store_model->get_access();
        // if(count($result)>0) {
			      // $query = $this->store_model->get_data('', $id);
        
            // if(count($query)>0) {
                // for($i=0; $i<count($query); $i++){
                  
                  
                    // $data[$i][1] = $query[$i]->google_address;
                    // $data[$i][2] = 'Location 1 URL';
                // }
            // }
		// $data['data'] = $this->store_model->get_data('', $id);
            // echo json_encode($data);
        // } else {
            // echo '<script>alert("You donot have access to this page.");</script>';
            // $this->load->view('login/main_page');
        // }
    // }

	
    public function get_store_locations(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->store_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['google_address'] = $result[0]->google_address;
            $data['latitude'] = $result[0]->latitude;
            $data['longitude'] = $result[0]->longitude;
           
        }

        echo json_encode($data);
    }
	
    public function add(){
        $result=$this->store_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->store_model->get_access();
				$data['store_rel'] = $this->relationship_model->get_data('Approved');
                $data['area'] = $this->area_model->get_data('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->zone_model->get_data('Approved','','ss_stores');
				$data['location'] = $this->location_model->get_data('Approved','','ss_stores');
                load_view('store_master/store_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->store_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->store_model->get_access();
                $data['data'] = $this->store_model->get_data('', $id);
				$data['store_rel'] = $this->relationship_model->get_data('Approved');
                $data['area'] = $this->area_model->get_data('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
                $data['zone'] = $this->zone_model->get_data('Approved','','ss_stores');
				$data['location'] = $this->location_model->get_data('Approved','','ss_stores');
                load_view('store_master/store_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->store_model->save_data();
        redirect(base_url().'index.php/store');
    }

    public function update($id){
        $this->store_model->save_data($id);
        redirect(base_url().'index.php/store');
    }
	
	public function get_zone(){ 
   
    $postData = $this->input->post();

    $data = $this->area_model->get_zone($postData);
    echo json_encode($data); 
	}

	
  public function check_store_availablity(){
         $result = $this->relationship_model->check_store_availablity();
         echo $result;
     }
}
?>