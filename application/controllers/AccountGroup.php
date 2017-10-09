<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class AccountGroup extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('distributor_model');
        $this->load->model('sales_rep_model');
        $this->load->model('area_model');
        $this->load->model('distributor_type_model');
        $this->load->model('zone_model');
        $this->load->model('AccountGroup_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->distributor_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->distributor_model->get_data();

        //     load_view('distributor/distributor_list', $data);
        // } else {
        //     echo "You donot have access to this page.";
        // }

        $this->checkstatus();
    }

    public function checkstatus($status=''){
        $result=$this->AccountGroup_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->AccountGroup_model->get_group_data($status);

            $count_data=$this->AccountGroup_model->get_group_data();
            $active=0;
            $inactive=0;
            $pending=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $active=$active+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING")
                        $pending=$pending+1;
                }
            }

            $data['active']=$active;
            $data['inactive']=$inactive;
            $data['pending']=$pending;
            $data['all']=count($count_data);

            load_view('accounts_group/accounts_group_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->AccountGroup_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['product_name'] = $result[0]->distributor_name;
            $data['sell_out'] = $result[0]->sell_out;
            $data['state'] = $result[0]->state;
            $data['sales_rep_id'] = $result[0]->sales_rep_id;
            $data['credit_period'] = $result[0]->credit_period;
            $data['class'] = $result[0]->class;
        }

        echo json_encode($data);
    }

    public function add(){
        $result=$this->AccountGroup_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                $data['prim_acc'] = $this->AccountGroup_model->get_data('Approved');

                load_view('accounts_group/accounts_group_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->AccountGroup_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->AccountGroup_model->get_group_data('', $id);
                $data['prim_acc'] = $this->AccountGroup_model->get_data('Approved');

                load_view('accounts_group/accounts_group_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->AccountGroup_model->save_data();
        redirect(base_url().'index.php/AccountGroup');
    }

    public function update($id){
        $this->AccountGroup_model->save_data($id);
        redirect(base_url().'index.php/AccountGroup');
    }

    public function check_group_availablity(){
        $result = $this->AccountGroup_model->check_group_availablity();
        echo $result;
    }
}
?>