<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard_mobile_app extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('dashboard_sales_rep_model');
        $this->load->model('sales_rep_distributor_model');
        $this->load->model('sales_rep_order_model');
		$this->load->model('Sales_location_model');
        $this->load->model('sales_rep_payment_receivable_model');
		$this->load->model('store_model');
        $this->load->model('product_model');
        $this->load->model('sr_beat_plan_model');
        $this->load->database();
        $this->load->model('Sales_Attendence_model');
    }

    public function get_alternate($day,$m,$year){
        
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

    public function get_dashboard_data_api(){
        $frequency = date('l');

        switch ($frequency) {
            case 'Monday':
                $temp_date = $mon = date('Y-m-d', strtotime('Monday this week'));
                break;
            case 'Tuesday':
                $temp_date = $mon = date('Y-m-d', strtotime('Tuesday this week'));
                break;
            case 'Wednesday':
                $temp_date = $mon = date('Y-m-d', strtotime('Wednesday this week'));
                break;  
            case 'Thursday':
                $temp_date = $mon = date('Y-m-d', strtotime('Thursday this week'));
                break;  
            case 'Friday':
                $temp_date = $mon = date('Y-m-d', strtotime('Friday this week'));
                break;
            case 'Saturday':
                $temp_date = $mon = date('Y-m-d', strtotime('Saturday this week'));
                break; 
            case 'Sunday':
                $temp_date = $mon = date('Y-m-d', strtotime('Sunday this week'));
                break; 
            default:
                case $frequency:
                $temp_date = $mon = date('Y-m-d', strtotime($frequency.' this week'));
                break;
        }

        $day = $frequency;
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }

        // echo $day;
        // echo '<br/>';
        // echo $frequency;
        // echo '<br/>';

        $sales_rep_id = urldecode($this->input->post('sales_rep_id'));

        // $sales_rep_id = 2;

        // $data['data']=$this->Sales_location_model->get_data('Approved', '', $frequency, $temp_date, $sales_rep_id);
        // $data['merchendizer']=$result2=$this->Sales_location_model->get_merchendiser_data('Approved', '', $frequency, $temp_date, $sales_rep_id);
        // $data['mt_followup']=$this->Sales_location_model->get_mtfollowup('', $temp_date, $sales_rep_id);
        // $data['gt_followup']=$this->Sales_location_model->get_gtfollowup('', $temp_date, $sales_rep_id);
        // $data['checkstatus'] = $frequency;
        // $data['current_day'] = date('l');
        // $data['total_receivable']=$this->dashboard_sales_rep_model->get_total_receivable($sales_rep_id);
        // $data['target']=$this->dashboard_sales_rep_model->get_target($sales_rep_id);
        // $data['orders'] = $this->Sales_location_model->get_todaysorder($sales_rep_id);
        // $data['pendingsorder'] = $this->Sales_location_model->get_pendingsorder($sales_rep_id);
        // $data['sales_rep_id']=$sales_rep_id;
        // $data['checkstatus'] = $frequency;

        $data['reporting_manager_id']='';
        $data['distributor_id_og']='';
        $data['beat_id_og']='';
        $data['distributor_id']='';
        $data['beat_id']='';
        $data['beat_status']='Approved';
        $data['distributor_name']='';
        $data['beat_name']='';

        $data['beat_details'] = $this->Sales_location_model->get_new_beat_details($sales_rep_id);
        if(count($data['beat_details'])>0){
            $data['reporting_manager_id']=$data['beat_details'][0]->reporting_manager_id;

            $beat_status = $data['beat_details'][0]->status;
            if(strtoupper(trim($beat_status))=="PENDING" || strtoupper(trim($beat_status))=="REJECTED"){
                $data['distributor_id_og']=$data['beat_details'][0]->dist_id1;
                $data['beat_id_og']=$data['beat_details'][0]->beat_id1;
            } else {
                $data['distributor_id_og']=$data['beat_details'][0]->dist_id2;
                $data['beat_id_og']=$data['beat_details'][0]->beat_id2;
            }
            
            if(strtoupper(trim($beat_status))=="PENDING" || strtoupper(trim($beat_status))=="APPROVED"){
                $data['distributor_id']=$data['beat_details'][0]->dist_id2;
                $data['beat_id']=$data['beat_details'][0]->beat_id2;
                $data['distributor_name']=$data['beat_details'][0]->distributor_name2;
                $data['beat_name']=$data['beat_details'][0]->beat_name2;
            } else {
                $data['distributor_id']=$data['beat_details'][0]->dist_id1;
                $data['beat_id']=$data['beat_details'][0]->beat_id1;
                $data['distributor_name']=$data['beat_details'][0]->distributor_name1;
                $data['beat_name']=$data['beat_details'][0]->beat_name1;
            }
            
            if(strtoupper(trim($beat_status))=="REJECTED"){
                $data['beat_status']="Approved";
            } else {
                $data['beat_status']=$data['beat_details'][0]->status;
            }
        }

        // echo $data['distributor_name'];
        // echo '<br/>';

        if($data['distributor_id']=="") {
            $data['beat_details'] = $this->Sales_location_model->get_beat_details($day, $sales_rep_id);
            if(count($data['beat_details'])>0){
                $data['reporting_manager_id']=$data['beat_details'][0]->reporting_manager_id;

                if($frequency == 'Alternate '.$day){
                    $data['distributor_id_og']=$data['beat_details'][0]->alternate_dist;
                    $data['beat_id_og']=$data['beat_details'][0]->alternate_beat;
                    $data['distributor_id']=$data['beat_details'][0]->alternate_dist;
                    $data['beat_id']=$data['beat_details'][0]->alternate_beat;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name2;
                    $data['beat_name']=$data['beat_details'][0]->beat_name2;
                } else {
                    $data['distributor_id_og']=$data['beat_details'][0]->every_dist;
                    $data['beat_id_og']=$data['beat_details'][0]->every_beat;
                    $data['distributor_id']=$data['beat_details'][0]->every_dist;
                    $data['beat_id']=$data['beat_details'][0]->every_beat;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name2;
                    $data['beat_name']=$data['beat_details'][0]->beat_name2;
                }
            }
        }

        // echo $data['distributor_name'];
        // echo '<br/>';

        // $this->session->set_userdata('distributor_id', $data['distributor_id']);
        // $this->session->set_userdata('beat_id', $data['beat_id']);
        
        $data['distributor'] = $this->Sales_location_model->get_distributors();
        $data['beat'] = $this->Sales_location_model->get_beat_plan($data['distributor_id']);
        $data['pending_beat_plan'] = $this->Sales_location_model->get_pending_beat_plan($sales_rep_id);

        $data['result'] = '1';
        $data['msg'] = 'Successful';

        echo json_encode($data);
    }

    public function get_beat_plan_api(){ 
        $distributor_id = urldecode($this->input->post('distributor_id'));
        // $distributor_id = 1298;
        $data = $this->Sales_location_model->get_beat_plan($distributor_id);
        echo json_encode($data);
    }

    public function set_beat_plan_api(){
        $reporting_manager_id = urldecode($this->input->post('reporting_manager_id'));
        $distributor_id_og = urldecode($this->input->post('distributor_id_og'));
        $beat_id_og = urldecode($this->input->post('beat_id_og'));
        $distributor_id = urldecode($this->input->post('distributor_id'));
        $beat_id = urldecode($this->input->post('beat_id'));
        $sales_rep_id = urldecode($this->input->post('sales_rep_id'));
        $curusr = urldecode($this->input->post('session_id'));

        // $sales_rep_id = 40;

        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate = $this->get_alternate($day, $m, $year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }

        $data = $this->Sales_location_model->set_beat_plan($reporting_manager_id, $distributor_id_og, $beat_id_og, $distributor_id, $beat_id, $sales_rep_id, $curusr, $frequency);
        echo $data;
    }

    public function set_original_beat_plan_api(){
        $reporting_manager_id = $this->input->post('reporting_manager_id');
        $distributor_id_og = $this->input->post('distributor_id_og');
        $beat_id_og = $this->input->post('beat_id_og');
        $distributor_id = $this->input->post('distributor_id');
        $beat_id = $this->input->post('beat_id');
        $sales_rep_id = $this->session->userdata('sales_rep_id');
        $curusr=$this->session->userdata('session_id');

        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }

        $data = $this->Sales_location_model->set_original_beat_plan($reporting_manager_id, $distributor_id_og, $beat_id_og, $distributor_id, $beat_id, $sales_rep_id, $curusr, $frequency);
        echo json_encode($data);
    }

    public function approve_beat_plan_api(){
        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day, $m, $year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }
        $curusr = urldecode($this->input->post('session_id'));
        $pending_id = $this->input->post('pending_id');
        $status = urldecode($this->input->post('status'));

        // $curusr = '151';
        // $pending_id = ['5'];
        // $status = 'Approved';

        $pending_id_arr = [$pending_id];

        if($status==null || $status==''){
            $status = 'Pending';
        }
        
        $data = $this->Sales_location_model->approve_beat_plan($frequency, $pending_id_arr, $curusr, $status);
        echo $data;
    }
    
    public function get_visit_details_api(){
        $sales_rep_id = 2;
        $curusr='151';
        if($this->input->post('sales_rep_id')){
            $sales_rep_id = $this->input->post('sales_rep_id');
        }
        if($this->input->post('session_id')){
            $curusr = $this->input->post('session_id');
        }
        
        $data = $this->dashboard_sales_rep_model->get_visit_details($sales_rep_id, $curusr);
        echo json_encode($data);
    }

    public function get_order_details_api(){
        $sales_rep_id = 2;
        if($this->input->post('sales_rep_id')){
            $sales_rep_id = $this->input->post('sales_rep_id');
        }
        
        $data = $this->dashboard_sales_rep_model->get_order_details($sales_rep_id);
        echo json_encode($data);
    }

    public function get_version_api(){
        $sql = "select * from version_master";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $version = $result[0]->version;
        } else {
            $version = '1.1';
        }

        echo $version;
    }
}
?>