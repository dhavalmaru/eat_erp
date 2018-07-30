<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class sr_mapping extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sr_mapping_model');
        $this->load->model('sales_rep_model');
        $this->load->model('area_model');
        $this->load->model('distributor_type_model');
        $this->load->model('zone_model');
        $this->load->model('location_model');
        $this->load->model('relationship_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sr_mapping_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sr_mapping_model->get_data('');

            load_view('sr_mapping_master/sr_mapping_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

		public function get_store(){ 
   
    $postData = $this->input->post();
	$zone_id = $postData['zone_id'];
    $data = $this->sr_mapping_model->get_store($zone_id);
    echo json_encode($data); 
    }
	
	
	  public function get_zone(){ 
   
    $postData = $this->input->post();
	$type_id = $postData['type_id'];
    $data = $this->sr_mapping_model->get_zone($type_id);
    echo json_encode($data); 
	}
	
	public function get_area(){ 
   
    $postData = $this->input->post();
    $type_id = $postData['type_id'];
	$zone_id = $postData['zone_id'];
    $data = $this->sr_mapping_model->get_area($type_id, $zone_id);
    echo json_encode($data); 
	}
	
	
	
    public function get_location(){ 
        $postData = $this->input->post();
		$area_id1 = $postData['area_id1'];
		$zone_id = $postData['zone_id'];
        $data = $this->sr_mapping_model->get_location($area_id1,$zone_id);
        echo json_encode($data); 
    }
	
	public function get_area_location(){ 
        $postData = $this->input->post();
        $area_id = $postData['area_id'];
        $zone_id = $postData['zone_id'];
        $data = $this->sr_mapping_model->get_area_location($area_id,$zone_id);
        echo json_encode($data); 
    }
	
    public function add(){
        $result=$this->sr_mapping_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                $data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
               // $data['area'] = $this->area_model->get_data('Approved');
                $data['type'] = $this->distributor_type_model->get_data('Approved');
               // $data['zone'] = $this->zone_model->get_data('Approved');
                $data['location_normal'] = $this->location_model->get_data('Approved');
                //$data['location'] = $this->sr_mapping_model->get_data('Approved');
              //  $data['area1'] = $this->relationship_model->get_data('Approved');
         

                load_view('sr_mapping_master/sr_mapping_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
		
        $result=$this->sr_mapping_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->sr_mapping_model->get_data($id);
				$data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
            
                $data['type'] = $this->distributor_type_model->get_data('Approved');
               
                $data['location_normal'] = $this->location_model->get_data('Approved');
				$type_id=$data['data'][0]->type_id;
				$area_id1=$data['data'][0]->area_id1;	
				$zone_id=$data['data'][0]->zone_id;
				 $data['zone'] = $this->sr_mapping_model->get_zone($type_id);
				$data['store'] = $this->sr_mapping_model->get_store($zone_id);
					
				$data['area'] = $this->sr_mapping_model->get_area($type_id, $zone_id);	
					
								
					
				
			
			
		
				$data['location'] = $this->sr_mapping_model->get_location($area_id1,$zone_id);
				//$data['location'] = $this->sr_mapping_model->get_location_data($store_id,$zone_id);
                load_view('sr_mapping_master/sr_mapping_details', $data);
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
            $this->sr_mapping_model->save_data();
        } else {
            $this->sr_mapping_model->save_data($id);
        }

        redirect(base_url().'index.php/sr_mapping');
    }
   public function update($id){
        $this->sr_mapping_model->save_data($id);
        redirect(base_url().'index.php/sr_mapping');
    }
    public function check_date_of_visit(){
        $result = $this->sr_mapping_model->check_date_of_visit();
        echo $result;
    }
	public function get_sr_name()
	{ 
    // POST data 
    $postData = $this->input->post();
    
    // load model 
    // get data 
    $data = $this->sr_mapping_model->get_sr_name1($postData);
    echo json_encode($data); 
  }
  



	
	 public function check_mapping_availablity(){
        $result = $this->sr_mapping_model->check_mapping_availablity();
        echo $result;
    }
	
	

	
	
	
}


?>