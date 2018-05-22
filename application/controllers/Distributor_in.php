<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor_in extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('distributor_in_model');
        $this->load->model('box_model');
        $this->load->model('depot_model');
        $this->load->model('sales_rep_model');
        $this->load->model('distributor_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->distributor_in_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->distributor_in_model->get_data();

        //     load_view('distributor_in/distributor_in_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }
        
        $this->checkstatus('Approved');
    }

    public function checkstatus($status=''){
        $result=$this->distributor_in_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->distributor_in_model->get_data($status);

            $count_data=$this->distributor_in_model->get_data();
            $approved=0;
            $pending=0;
            $rejected=0;
            $inactive=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING" || strtoupper(trim($count_data[$i]->status))=="DELETED")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inactive']=$inactive;
            $data['all']=count($count_data);

            load_view('distributor_in/distributor_in_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->distributor_in_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->distributor_in_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');

                $date = date("Y-m-d", strtotime("-6 months"));
                $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
                $query = $this->db->query($sql);
                $data['batch'] = $query->result();

                load_view('distributor_in/distributor_in_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->distributor_in_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_in_model->get_access();

                $id = $this->distributor_in_model->get_pending_data($id);
                
                $data['data'] = $this->distributor_in_model->get_data('', $id);
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_in_items'] = $this->distributor_in_model->get_distributor_in_items($id);
                $data['distributor_in_items_ex'] = $this->distributor_in_model->get_distributor_in_items_ex($id);

                $date = new DateTime($data['data'][0]->date_of_processing);
                $date->modify('-6 month');
                $date = $date->format('Y-m-d');
                // echo $date;

                $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
                $query = $this->db->query($sql);
                $data['batch'] = $query->result();

                load_view('distributor_in/distributor_in_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->distributor_in_model->save_data();
        redirect(base_url().'index.php/distributor_in');
    }

    public function update($id){
        $this->distributor_in_model->save_data($id);
        redirect(base_url().'index.php/distributor_in');
    }

    public function view_sales_return_receipt($id){
        $data['data'] = $this->distributor_in_model->get_data('', $id);
        $data['distributor_in_items'] = $this->distributor_in_model->get_distributor_in_items_for_receipt($id);
        $data['distributor_exchange_items'] = $this->distributor_in_model->get_distributor_out_items_for_exchange($id);

        if(count($data['data'])>0){
            $data['total_amount_in_words']=convert_number_to_words($data['data'][0]->final_amount) . ' Only';
        }

        load_view('invoice/sales_return_receipt', $data);
    }
    
    public function check_box_availablity(){
        $result = $this->distributor_in_model->check_box_availablity();
        echo $result;
    }

    public function check_box_qty_availablity(){
        $result = $this->distributor_in_model->check_box_qty_availablity();
        echo $result;
    }

    public function check_product_availablity(){
        $result = $this->distributor_in_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->distributor_in_model->check_product_qty_availablity();
        echo $result;
    }

}
?>