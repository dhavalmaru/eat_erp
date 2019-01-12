<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard_sales_rep extends CI_Controller
{
    public function __construct(){
        parent::__construct();
      
        $this->load->helper('common_functions');
        $this->load->model('dashboard_sales_rep_model');
        $this->load->model('sales_rep_distributor_model');
        $this->load->model('sales_rep_order_model');
        $this->load->model('sales_rep_location_model');
        $this->load->model('sales_rep_payment_receivable_model');
    }

    //index function
    public function dashboard(){
        load_view_without_data('dashboard/dashboard_first_screen');
    }

    public function index(){
        $result=$this->dashboard_sales_rep_model->get_access();
        if(count($result)>0) {
            // $data['total_sale']=$this->dashboard_sales_rep_model->get_total_sale();
            // $data['total_dist']=$this->dashboard_sales_rep_model->get_total_distributor();
            $data['total_receivable']=$this->dashboard_sales_rep_model->get_total_receivable();
            $data['target']=$this->dashboard_sales_rep_model->get_target();
            $data['payment_receivable']=$this->sales_rep_payment_receivable_model->get_data();
			//$data['data1'] = $this->dashboard_sales_rep_model->get_data_dist();
			$data['data2'] = $this->sales_rep_order_model->get_data();
			$data['data1'] = $this->sales_rep_distributor_model->get_data();
			$data['data3'] = $this->dashboard_sales_rep_model->get_data_loc();
            $data['sales_rep_id']=$this->session->userdata('sales_rep_id');

            load_view('dashboard/dashboard_sales_rep_details', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_sale_details() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));

        // $from_date = '2016-07-15';
        // $to_date = '2017-02-13';
        $result = [];

        $data['total_sale']=$this->dashboard_sales_rep_model->get_total_sale($from_date, $to_date);

        if(count($data['total_sale'])>0){
            $total_sale['total_amount'] = $data['total_sale'][0]->total_amount;
            $total_sale['total_bar'] = $data['total_sale'][0]->total_bar;
            $total_sale['total_box'] = $data['total_sale'][0]->total_box;
            $result['total_sale']=$total_sale;
        }

        $data['total_dist']=$this->dashboard_sales_rep_model->get_total_distributor($from_date, $to_date);
        if(count($data['total_dist'])>0){
            $total_dist['tot_dist'] = $data['total_dist'][0]->tot_dist;
            $total_dist['tot_g_trade'] = $data['total_dist'][0]->tot_g_trade;
            $total_dist['tot_m_trade'] = $data['total_dist'][0]->tot_m_trade;
            $total_dist['tot_e_com'] = $data['total_dist'][0]->tot_e_com;
            $result['total_dist']=$total_dist;
        }

        echo json_encode($result);
    }

    public function get_month_wise_sale() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));

        // $from_date = '2016-07-15';
        // $to_date = '2017-02-01';

        $json_data = array();
        $item_name = array();

        $data = $this->dashboard_sales_rep_model->get_months($from_date, $to_date);
        for ($i=0;$i<count($data);$i++) {
            $json_data[0][$i]=$data[$i]->month_name;
            $item_name[0]='';
        }

        $i=0;
        $prev_item='';
        $item='';
        $data = $this->dashboard_sales_rep_model->get_month_wise_sale($from_date, $to_date);
        for ($j=0;$j<count($data);$j++) {
            $item=$data[$j]->item;

            if($item!=''){
                if($item!=$prev_item){
                    $i=$i+1;
                    $prev_item=$item;
                    for($a=0; $a<count($json_data[0]); $a++){
                        $json_data[$i][$a]=0;
                        $item_name[$i]='';
                    }
                }

                for($a=0; $a<count($json_data[0]); $a++){
                    if($json_data[0][$a]==$data[$j]->month_name){
                        if(isset($data[$j]->sales)){
                            $json_data[$i][$a]=round($data[$j]->sales,0);
                            $item_name[$i]=$data[$j]->item;
                        } else {
                            $json_data[$i][$a]=0;
                            $item_name[$i]='';
                        }
                    }
                }
            }
        }
        
        $result['json_data']=$json_data;
        $result['item_name']=$item_name;
        echo json_encode($result);
    }

    public function get_rout_plan_details() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));

        // $from_date = '2016-07-15';
        // $to_date = '2017-02-01';

        $json_data = array();

        $data = $this->dashboard_sales_rep_model->get_rout_plan_details($from_date, $to_date);
        for ($i=0;$i<count($data);$i++) {
            $json_data['distributor_name'][$i]=$data[$i]->distributor_name;
            $json_data['area'][$i]=$data[$i]->area;
            $json_data['latitude'][$i]=$data[$i]->latitude;
            $json_data['longitude'][$i]=$data[$i]->longitude;
        }

        $result['json_data']=$json_data;
        echo json_encode($result);
    }
    
}
?>