<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_location extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_location_model');
        $this->load->model('sales_rep_distributor_model');
        $this->load->model('distributor_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_rep_location_model->get_data();

            load_view('sales_rep_location/sales_rep_location_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    

    public function add(){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                // echo $this->session->userdata('sales_rep_id');
                
                $data['access'] = $this->sales_rep_location_model->get_access();
                $data['distributor'] = $this->sales_rep_distributor_model->get_data2('Approved');
                $data['zone'] = $this->sales_rep_location_model->get_zone();
                $data['area'] = $this->sales_rep_location_model->get_area();
                $data['location'] = $this->sales_rep_location_model->get_locations();

                load_view('sales_rep_location/sales_rep_location_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->sales_rep_location_model->get_data('', $id);
                $data['data1'] = $this->sales_rep_location_model->get_data_qty('', $id);
                $data['distributor'] = $this->sales_rep_distributor_model->get_data2('Approved');
                $data['zone'] = $this->sales_rep_location_model->get_zone();

                if(count($data['data'])>0){
                    $zone_id = $data['data'][0]->zone_id;
                    $area_id = $data['data'][0]->area_id;
                }
                
                $data['area'] = $this->sales_rep_location_model->get_area($zone_id);
                $data['location'] = $this->sales_rep_location_model->get_locations($zone_id, $area_id);

                load_view('sales_rep_location/sales_rep_location_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save($id=""){
       if($this->input->post('srld') == "Place Order") {
            if($id == ""){
                $this->sales_rep_location_model->save_data('','Place Order');
            } else {
                $this->sales_rep_location_model->save_data($id, 'Place Order');
            }
        }
        else if($this->input->post('srld') == "Follow Up") {
            if($id == ""){
                $this->sales_rep_location_model->save_data('','Follow Up');
            } else {
                $this->sales_rep_location_model->save_data($id,'Follow Up');
            }
        }
        else {
            if($id == ""){
                $this->sales_rep_location_model->save_data('','Not Interested');
            } else {
                $this->sales_rep_location_model->save_data($id,'Not Interested');
            }
        }

        if($this->input->post('srld') == "Place Order") {
            if($this->input->post('distributor_type')=="Old"){
                $id = $this->input->post('distributor_id');
                redirect(base_url().'index.php/sales_rep_order/add_order/'.$id);
            } else {
                $result=$this->sales_rep_distributor_model->get_access();
                if(count($result)>0) {
                    if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                        $zone_id = $this->input->post('zone_id');
                        $area_id = $this->input->post('area_id');

                        $data['zone'] = $this->sales_rep_location_model->get_zone();
                        $data['area'] = $this->sales_rep_location_model->get_area($zone_id);
                        $data['location'] = $this->sales_rep_location_model->get_locations($zone_id, $area_id);

                        $data['access'] = $result;
                        $data['distributor'] = $this->sales_rep_location_model->get_distributors($zone_id, $area_id);
                        $data['distributor_name'] = $this->input->post('distributor_name');
                        $data['zone_id'] = $this->input->post('zone_id');
                        $data['area_id'] = $this->input->post('area_id');
                        $data['location_id'] = $this->input->post('location_id');
                        load_view('sales_rep_distributor/sales_rep_distributor_details', $data);
                    }
                } 
            }
        }
        else {
            redirect(base_url().'index.php/sales_rep_location');
        }
        
    }

    public function check_date_of_visit(){
        $result = $this->sales_rep_location_model->check_date_of_visit();
        echo $result;
    }

    public function get_distributor_details() {
        $postData = $this->input->post();
        $distributor_id = $postData['distributor_id'];
        $data = $this->distributor_model->get_data('', $distributor_id);

        echo json_encode($data);
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
	

    public function get_location_data(){ 
        $postData = $this->input->post();
        $zone_id = $postData['zone_id'];
        $store_id = $postData['store_id'];
        $id = $postData['id'];
        $data = $this->sales_rep_location_model->get_location_data($store_id,$zone_id,$id);
        echo json_encode($data); 
    }

	public function get_retailer(){ 
        $postData = $this->input->post();
        $zone_id = $postData['zone_id'];
        $area_id = $postData['area_id'];
        $location_id = $postData['location_id'];
		$dist_type = $postData['dist_type'];
		$distributor_id = $postData['distributor_id'];
		               // $data['distributor'] = $this->sales_rep_distributor_model->get_data2('Approved');
		if($dist_type=='New')
			$data = $this->sales_rep_distributor_model->get_data2('','' ,$zone_id, $area_id, $location_id);
		else
			$data = $this->sales_rep_distributor_model->get_data2('Approved','' ,$zone_id, $area_id, $location_id);

        $retailer = '<option value="">Select</option>';
        for($i=0; $i<count($data); $i++){
			
			if($distributor_id!="")
				$select = "selected";
			else
				$select = '';
			
            $retailer = $retailer . '<option value="'.$data[$i]->id.'" "'.$select.'">'.$data[$i]->distributor_name.'</option>';
        }

        echo $retailer;
    }

    public function get_location(){
        $data = null;
        $query=$this->sales_rep_location_model->get_location();
        if(count($query)>0) {
            for($i=0; $i<count($query); $i++){
                $data[$i]['id'] = $query[$i]->id;
                $data[$i]['sales_rep_id'] = $query[$i]->sales_rep_id;
                $data[$i]['date_of_visit'] = $query[$i]->date_of_visit;
                $data[$i]['sales_rep_name'] = $query[$i]->sales_rep_name;
                $data[$i]['store_name'] = $query[$i]->store_name;
                $data[$i]['login_time'] = $query[$i]->modified_on;
                $data[$i]['login_latitude'] = $query[$i]->latitude;
                $data[$i]['login_longitude'] = $query[$i]->longitude;
                $data[$i]['logout_time'] = $query[$i]->logout_time;
                $data[$i]['logout_latitude'] = $query[$i]->logout_latitude;
                $data[$i]['logout_longitude'] = $query[$i]->logout_longitude;
            }
        }

        echo json_encode($data);
    }

    public function get_closing_stock(){
        // $data['result'] = 0;
        // $query=$this->sales_rep_location_model->get_closing_stock();
        // if(count($query)>0) {
        //     // for($i=0; $i<count($query); $i++){
        //         $i=0;
        //         $data['result'] = 1;
        //         $data['id'] = $query[$i]->id;
        //         $data['orange_bar'] = $query[$i]->orange_bar;
        //         $data['mint_bar'] = $query[$i]->mint_bar;
        //         $data['butterscotch_bar'] = $query[$i]->butterscotch_bar;
        //         $data['chocopeanut_bar'] = $query[$i]->chocopeanut_bar;
        //         $data['bambaiyachaat_bar'] = $query[$i]->bambaiyachaat_bar;
        //         $data['mangoginger_bar'] = $query[$i]->mangoginger_bar;
        //         $data['sales_rep_loc_id'] = $query[$i]->sales_rep_loc_id;
        //     // }
        // }

        $data = $this->sales_rep_location_model->get_closing_stock();

        echo json_encode($data);
    }
}
?>