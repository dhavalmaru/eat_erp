<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard_promoter extends CI_Controller
{
    public function __construct(){
        parent::__construct();
      
        $this->load->helper('common_functions');
        $this->load->model('dashboard_promoter_model');
        $this->load->model('sales_rep_payment_receivable_model');
    }

    //index function
    public function dashboard(){
        load_view_without_data('dashboard/dashboard_first_screen');
    }

    public function index(){
        $result=$this->dashboard_promoter_model->get_access();
        if(count($result)>0) {
            // $data['total_sale']=$this->dashboard_sales_rep_model->get_total_sale();
            // $data['total_dist']=$this->dashboard_sales_rep_model->get_total_distributor();
            $data['checkout_status']=$this->dashboard_promoter_model->get_checkout_status();
            $data['store']=$this->dashboard_promoter_model->get_store();
            // $data['target']=$this->dashboard_promoter_model->get_target();
            // $data['payment_receivable']=$this->sales_rep_payment_receivable_model->get_data();
                $data['sales_rep_id']=$this->session->userdata('sales_rep_id');

            load_view('dashboard/dashboard_promoter_details', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
}
?>