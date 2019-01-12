<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Merchandiser_location extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('merchandiser_location_model');
        $this->load->model('merchandiser_beat_plan_model');
        $this->load->model('store_model');
      //	$this->load->model('Sr_beat_plan_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    // public function (){
        // $result=$this->merchandiser_location_model->get_access();
        // if(count($result)>0) {
            // $data['access']=$result;
           // $data['data'] = $this->merchandiser_location_model->get_data();
            // $data['data'] = $this->Sr_beat_plan_model->get_data();

            // load_view('merchandiser/merchandiser_list', $data);
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
	public function locations($status='')
		{
			$result=$this->merchandiser_location_model->get_access();
			if(count($result)>0) {
				load_view_without_data('merchandiser/merchandiser_location_map');
			} else {
				echo '<script>alert("You donot have access to this page.");</script>';
				$this->load->view('login/main_page');
			}
    
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
        
        $result=$this->merchandiser_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->merchandiser_location_model->get_data('Approved','',$frequency);
			//$data['data1'] = $this->merchandiser_location_model->get_data1();
			
			$data['checkstatus'] = $frequency;

            load_view('merchandiser/merchandiser_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    public function add($id){ 
        $result=$this->merchandiser_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->merchandiser_location_model->get_access();
                $data['distributor'] = $this->merchandiser_beat_plan_model->get_data('Approved',$id,'');
                $data['bar'] = $this->product_model->get_data('Approved','','1');
                $data['bar_details'] = $this->product_model->get_data('Approved','','1');

                $date = date("Y-m-d", strtotime("-6 months"));

                // $sql = "select * from batch_processing where date_of_processing >= '$date' and status = 'Approved' and batch_id_as_per_fssai!=''";
                // $query=$this->db->query($sql);
                // $data['batch'] = $query->result();

                $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
                $query=$this->db->query($sql);
                $data['batch'] = $query->result();

                load_view('merchandiser/merchandiser_location', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id=''){
        $result=$this->merchandiser_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
				//$data['data'] = $this->merchandiser_location_model->get_data1('Approved','','');
				$data['data'] = $this->merchandiser_location_model->get_data('Approved',$id,'');
				$data['distributor'] = $this->merchandiser_location_model->get_data('Approved',$id,'');
                $data['bar'] = $this->product_model->get_data('Approved','','1');
                $data['bar_details'] = $this->product_model->get_data('Approved','','1');
                $data['stock_details'] = $this->merchandiser_location_model->get_merchandiser_stock_details($data['data'][0]->mid);
				$data['batch_images'] = $this->merchandiser_location_model->get_merchandiser_stock_images($id);
                $date = date("Y-m-d", strtotime("-12 months"));
                
            
                $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
                $query=$this->db->query($sql);
                $data['batch'] = $query->result();

                load_view('merchandiser/merchandiser_location', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        
        $id  = $this->input->post('id');

        if($id == ""){
            $this->merchandiser_location_model->save_data('');
        } 
		else {
            $this->merchandiser_location_model->save_data($id);
        }
        
        redirect(base_url().'index.php/merchandiser_location');
        
    }

     	
    public function get_store_locations(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->merchandiser_beat_plan_model->get_data('Approved',$id,'');
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['google_address'] = $result[0]->google_address;
            $data['latitude'] = $result[0]->latitude;
            $data['longitude'] = $result[0]->longitude;
           
        }

        echo json_encode($data);
    }
	
	 public function save_seq()
	 {
			$sales_rep_id=$this->input->post('sales_rep_id'); 
			$id=$this->input->post('id'); 
			$isedit=$this->input->post('isedit'); 
			
			if($isedit==''){	
		  $sql= "select max(seq) as seq from merchandiser_beat_plan where sales_rep_id='$sales_rep_id' and date_of_processing=date(now())";
		  
		  $result = $this->db->query($sql)->result_array();
		  $seq = $result[0]['seq'];	  
		  $seq = $seq+1;
		  $data = array( 
				'seq'=>$seq
			);
		  $this->db->where('id', $id);
		  $this->db->update('merchandiser_beat_plan', $data);
          echo $seq;
	 }
	 }
	
	
	 public function check_seq(){
	  $sales_rep_id=$this->input->post('sales_rep_id'); 
	  $id=$this->input->post('id'); 
      $sql= "select max(seq) as seq from merchandiser_beat_plan where sales_rep_id='$sales_rep_id' and date_of_processing=date(now())";
	  $result = $this->db->query($sql)->result_array();
	  echo $seq = $result[0]['seq'];
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
       $result = $this->db->query('Select DISTINCT sales_rep_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='merchandizer' and   id NOT IN($sales_rep_id)")->result();
       $this->db->last_query();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->sales_rep_name);
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

    public function set_socket()
    {
       
    }

    public function test_data()
    {
       /*$one_array = array(0=>1,1=>2,2=>3,3=>4,4=>5);
       $two_array = array(0=>1,1=>2,2=>3,3=>4,4=>5);

       echo '$a == $b is ', var_dump($one_array==$two_array); */
    }
     
}
?>