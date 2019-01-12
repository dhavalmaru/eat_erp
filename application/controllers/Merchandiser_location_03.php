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
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->merchandiser_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->merchandiser_location_model->get_data();

            load_view('merchandiser/merchandiser_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    

    public function add(){
        $result=$this->merchandiser_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->merchandiser_location_model->get_access();
                $data['distributor'] = $this->merchandiser_location_model->get_dist_list();
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

    public function edit($id){
        $result=$this->merchandiser_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->merchandiser_location_model->get_data('', $id);
                $data['distributor'] = $this->merchandiser_location_model->get_dist_list();
                $data['bar'] = $this->product_model->get_data('Approved','','1');
                $data['bar_details'] = $this->product_model->get_data('Approved','','1');
                $data['stock_details'] = $this->merchandiser_location_model->get_merchandiser_stock_details($id);

                $date = date("Y-m-d", strtotime("-12 months"));
                
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

    public function save($id=""){
       
        if($id == ""){
            $this->merchandiser_location_model->save_data('');
        } else {
            $this->merchandiser_location_model->save_data($id);
        }
        
        redirect(base_url().'index.php/merchandiser_location');
        
    }

     

     
}
?>