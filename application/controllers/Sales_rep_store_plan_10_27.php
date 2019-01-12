<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_store_plan extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('Sales_location_model');
        $this->load->model('Sales_rep_route_plan_model');
        $this->load->model('sales_rep_location_model');
        $this->load->model('sales_rep_distributor_model');    
        $this->load->model('store_model');
      //	$this->load->model('Sr_beat_plan_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    // public function (){
        // $result=$this->Sales_location_model->get_access();
        // if(count($result)>0) {
            // $data['access']=$result;
           // $data['data'] = $this->Sales_location_model->get_data();
            // $data['data'] = $this->Sr_beat_plan_model->get_data();

            // load_view('merchandiser/sales_rep_list_view', $data);
        // } else {
            // echo '<script>alert("You donot have access to this page.");</script>';
            // $this->load->view('login/main_page');
        // }
    // }

     public function index(){
       
        $day = date('l');
        /*$m = date('F');
        $year = date('Y');
        $set_days = '';

        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $set_days = 'Alternate '.$day;
        }
        else
        {
            $set_days = 'Every '.$day;
        }*/
        
        $this->checkstatus($day);
    }
	
    public function checkstatus($frequency=''){

        $day = $frequency;
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }

        $result=$this->Sales_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->Sales_location_model->get_data('Approved','',$frequency);
			//$data['data1'] = $this->Sales_location_model->get_data1();
			
			$data['checkstatus'] = $frequency;

            load_view('sales_rep/sales_rep_list_view', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    public function add($id='',$get_frequency=''){
        $result=$this->sales_rep_location_model->get_access();
        $day =  date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_location_model->get_access();
                $data['distributor'] = $this->sales_rep_distributor_model->get_data2('Approved');
               
                if($id=='')
                {
                    /*$data['data']=$this->Sales_location_model->get_data('Approved','','');*/
                 
                    $data['data'] = [(object)array('distributor_type'=>'New','frequency'=>$frequency)];
                    
                }
                else
                {
                    if($get_frequency==$day)
                    {
                     
                      $data['data']=$this->Sales_location_model->get_data('Approved',$id,$frequency);           
                    }
                    else
                    {
                       
                       $data['data']=$this->Sales_location_model->get_data('Approved',$id);           
                    }
                    
                    
                }


                /*
                echo "<pre>";
                print_r($data);
                echo "</pre>";

                die();*/


                $sales_rep_id=$this->session->userdata('sales_rep_id');
            
               $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and is_edit='edit' and frequency='$frequency' and sales_rep_id='$sales_rep_id'";
                $get_maxcount = $this->db->query($sql)->result_array();

                $data['sequence_count'] = $get_maxcount[0]['sequence']+1;
                $data['store_plan']=$this->Sales_location_model->get_data('Approved',$id,'');
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
                $data['data']=$this->Sales_location_model->get_data('Approved',$id,'');
                $data['data1'] = $this->sales_rep_location_model->get_data_qty('', $data['data'][0]->mid);
                $data['distributor'] = $this->sales_rep_distributor_model->get_data2('Approved');
               $data['zone'] = $this->sales_rep_location_model->get_zone();
               $data['area'] = $this->sales_rep_location_model->get_area();
               $data['location'] = $this->sales_rep_location_model->get_locations();

                /*if(count($data['data'])>0){
                    $zone_id = $data['data'][0]->zone_id;
                    $area_id = $data['data'][0]->area_id;
                }
                
                $data['area'] = $this->sales_rep_location_model->get_area($zone_id);
                $data['location'] = $this->sales_rep_location_model->get_locations($zone_id, $area_id);*/

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
        /*$id  = $this->input->post('id');

        if($id == ""){
            $this->Sales_location_model->save_data('');
        } 
		else {
            $this->Sales_location_model->save_data($id);
        }*/

        $user_id=$this->session->userdata('sales_rep_id');

        if($this->input->post('srld') == "Place Order") {
            if($id == ""){
                $this->Sales_location_model->save_data('','Place Order');
            } else {
                $this->Sales_location_model->save_data($id, 'Place Order');
            }
        }
        else if($this->input->post('srld') == "Follow Up") {
            if($id == ""){
                $this->Sales_location_model->save_data('','Follow Up');
            } else {
                $this->Sales_location_model->save_data($id,'Follow Up');
            }
        }
        else {
            if($id == ""){
                $this->Sales_location_model->save_data('','Not Interested');
            } else {
                $this->Sales_location_model->save_data($id,'Not Interested');
            }
        }    

        if($this->input->post('srld') == "Place Order") {
            if($this->input->post('distributor_type')=="Old"){
                $id = $this->input->post('distributor_id');
                redirect(base_url().'index.php/Sales_rep_order/add_order/'.$id);
            } else {
                $result=$this->sales_rep_distributor_model->get_access();
                if(count($result)>0) {
                    if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                        $id = $this->input->post('store_id');
                        if($this->input->post('place_order')=="Yes") {
                            if($id=="")
                            {
                               
                                $distributor_name  = $this->input->post('distributor_name');
                                $result = $this->db->query("Select concat('s_',id) as id from sales_rep_distributors Where distributor_name='$distributor_name' and sales_rep_id='$user_id'")->result_array();
                                $id = $result[0]['id'];
                            }
                            /*$zone_id = $id;*/
                            $area_id = $this->input->post('area_id');
                            $array = array();
                            $data['id'] = $id;
                            $zone_id = $this->input->post('zone_id');
                            $area_id = $this->input->post('area_id');
                            $distributor_id = substr($id, 2);
                            $get_detail = $this->db->select("distributor_name,gst_number,zone_id,location_id,area_id,margin,remarks,document_name,margin,doc_document,master_distributor_id as distributor_id ")->where('id',$distributor_id)->get('sales_rep_distributors')->result();
                            $data['data'] =$get_detail;
                            $data['zone'] = $this->sales_rep_location_model->get_zone();
                            $data['area'] = $this->sales_rep_location_model->get_area($zone_id);
                            $data['location'] = $this->sales_rep_location_model->get_locations($zone_id, $area_id);
                            $result1=$this->sales_rep_distributor_model->get_access();
                            $data['access'] = $result1;
                            $data['distributor'] = $this->sales_rep_location_model->get_distributors($zone_id, $area_id);
                            $data['distributor_name'] = $this->input->post('distributor_name');
                            $data['zone_id'] = $this->input->post('zone_id');
                            $data['area_id'] = $this->input->post('area_id');
                            $data['location_id'] = $this->input->post('location_id');

                            load_view('sales_rep_distributor/sales_rep_distributor_details',$data);
                            //redirect(base_url().'index.php/sales_rep_distributor/add/'.$id);
                            /*redirect(base_url().'index.php/Sales_rep_order/add_order/'.$id);*/
                        } else {
                            redirect(base_url().'index.php/sales_rep_distributor');
                        }
                    }
                } 
            }
        }
        else {
            redirect(base_url().'index.php/Sales_rep_store_plan');
        }

        //redirect(base_url().'index.php/Sales_rep_store_plan');
        
    }
     	
    public function get_lat_long(){
        $id=$this->input->post('id');
        $result=$this->Sales_location_model->get_lat_long($id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['google_address'] = $result[0]->google_address;
            $data['latitude'] = $result[0]->latitude;
            $data['longitude'] = $result[0]->longitude;
           
        }

        echo json_encode($data);
    }

    public function locations($status='')
    {
        $result=$this->Sales_rep_route_plan_model->get_access();
        if(count($result)>0) {
            load_view_without_data('sales_rep_location/sales_rep_location_map');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }

    }
	
    public function test_function()
    {
        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $set_days = '';

        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $set_days = 'Alternate '.$day;
        }
        else
        {
            $set_days = 'Every '.$day;
        }

        echo $set_days;
    }

    public function get_alternate($day,$m,$year)
    {
        
        $date1 = date('d-m-Y', strtotime('second '.$day.' of '.$m.' '.$year));
        $date2 = date('d-m-Y', strtotime('fourth '.$day.' of '.$m.' '.$year));

        $todaysdate = date('d-m-Y');
        if($date1==$todaysdate) 
        {
            return true;
        }
        elseif($date2==$todaysdate)
        {
            return true;
        }
        else
        {
           return false;
        }
    }

    public function sales_rep_not_mapped($status='')
    {
        $result = $this->db->query('Select DISTINCT sales_rep_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='Sales Representative' and   id NOT IN($sales_rep_id)")->result();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='sales_rep_not_mapped.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function merchandizer_not_mapped($status='')
    {
       $result = $this->db->query('Select DISTINCT merchendizer_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='merchandiser' and   id NOT IN($sales_rep_id)")->result();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='sales_rep_not_mapped.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function store_not_mapped($status='')
    {
        $result = $this->db->query('Select DISTINCT store_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("select * from relationship_master  Where status='Approved'")->result();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='sales_rep_not_mapped.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function retailer_not_mapped($status='')
    {
       $result = $this->db->query('Select DISTINCT dist_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->dist_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("SELECT * from distributor_master Where status='Approved' and   id NOT IN($sales_rep_id)")->result();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='sales_rep_not_mapped.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }   
    
    

    public function test_data()
    {
       /*$one_array = array(0=>1,1=>2,2=>3,3=>4,4=>5);
       $two_array = array(0=>1,1=>2,2=>3,3=>4,4=>5);
        echo '$a == $b is ', var_dump($one_array==$two_array); */
    }
     
}
?>