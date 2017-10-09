<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Bank extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->model('bank_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->bank_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->bank_model->get_data();

            load_view('bank/bank_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->bank_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->bank_model->get_access();

                load_view('bank/bank_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->bank_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->bank_model->get_access();
                $data['data'] = $this->bank_model->get_data('', $id);
                $data['bank_sign'] = $this->bank_model->get_bank_authority($id);

                load_view('bank/bank_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->bank_model->save_data();
        redirect(base_url().'index.php/bank');
    }

    public function update($id){
        $this->bank_model->save_data($id);
        redirect(base_url().'index.php/bank');
    }

    public function check_bank_availablity(){
        $result = $this->bank_model->check_bank_availablity();
        echo $result;
    }

    public function loadbanks() {
        $term = "t";
                
        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $abc=array();

        $query=$this->db->query("select * from 
                                (select b_id, concat(b_name, ' - ', b_accountnumber) as bank_detail from bank_master 
                                    where b_status='Approved' and b_gid='$gid') A 
                                where A.bank_detail like '%" . $term . "%';");
        $result=$query->result();
        
        foreach($result as $row) {
            $abc[] = array('value' => $row->b_id, 'label' => $row->bank_detail);
        }

        // echo $query;
        echo json_encode($abc);
    }
}
?>