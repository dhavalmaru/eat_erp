<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Credit_debit_note extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('credit_debit_note_model');
        $this->load->model('distributor_model');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->credit_debit_note_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->credit_debit_note_model->get_data();

            load_view('credit_debit_note/credit_debit_note_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->credit_debit_note_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                $data['distributor'] = $this->distributor_model->get_data('Approved');

                load_view('credit_debit_note/credit_debit_note_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->credit_debit_note_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['data'] = $this->credit_debit_note_model->get_data('', $id);
                $data['distributor'] = $this->distributor_model->get_data('Approved');

                load_view('credit_debit_note/credit_debit_note_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->credit_debit_note_model->save_data();
        redirect(base_url().'index.php/credit_debit_note');
    }

    public function update($id){
        $this->credit_debit_note_model->save_data($id);
        redirect(base_url().'index.php/credit_debit_note');
    }
}
?>