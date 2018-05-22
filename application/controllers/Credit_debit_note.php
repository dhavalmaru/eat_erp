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
        // $result=$this->credit_debit_note_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->credit_debit_note_model->get_data();

        //     load_view('credit_debit_note/credit_debit_note_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }

        $this->checkstatus('Approved');
    }

    public function checkstatus($status=''){
        $result=$this->credit_debit_note_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->credit_debit_note_model->get_data($status);

            $count_data=$this->credit_debit_note_model->get_data();
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
                
                $id = $this->credit_debit_note_model->get_pending_data($id);
                
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
        
    public function view_credit_debit_note($id){
        $this->credit_debit_note_model->view_credit_debit_note($id);
    }

}
?>