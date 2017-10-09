<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Stock extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('stock_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->batch_processing_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->batch_processing_model->get_data();

        //     load_view('batch_processing/batch_processing_list', $data);
        // } else {
        //     echo "You donot have access to this page.";
        // }
    }

    public function check_raw_material_availablity(){
        $result = $this->stock_model->check_raw_material_availablity();
        echo $result;
    }

    public function check_raw_material_qty_availablity(){
        $result = $this->stock_model->check_raw_material_qty_availablity();
        echo $result;
    }

    public function check_bar_availablity_for_depot(){
        $result = $this->stock_model->check_bar_availablity_for_depot();
        echo $result;
    }

    public function check_bar_qty_availablity_for_depot(){
        $result = $this->stock_model->check_bar_qty_availablity_for_depot();
        echo $result;
    }

    public function check_box_availablity_for_depot(){
        $result = $this->stock_model->check_box_availablity_for_depot();
        echo $result;
    }

    public function check_box_qty_availablity_for_depot(){
        $result = $this->stock_model->check_box_qty_availablity_for_depot();
        echo $result;
    }

    public function check_bar_availablity_for_distributor(){
        $result = $this->stock_model->check_bar_availablity_for_distributor();
        echo $result;
    }

    public function check_bar_qty_availablity_for_distributor(){
        $result = $this->stock_model->check_bar_qty_availablity_for_distributor();
        echo $result;
    }

    public function check_box_availablity_for_distributor(){
        $result = $this->stock_model->check_box_availablity_for_distributor();
        echo $result;
    }

    public function check_box_qty_availablity_for_distributor(){
        $result = $this->stock_model->check_box_qty_availablity_for_distributor();
        echo $result;
    }

    public function get_depot_bar_qty(){
        $result=$this->stock_model->get_depot_bar_qty();
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['product_id'][$i]=$result[$i]->product_id;
                $data['product_name'][$i]=$result[$i]->product_name;
                $data['qty'][$i]=$result[$i]->tot_qty;
            }
        }

        echo json_encode($data);
    }

}
?>