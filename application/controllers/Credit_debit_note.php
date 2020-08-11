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
        $this->load->model('exp_cat_master_model');
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

    public function get_data($status){
        // $status = 'Approved';

        // $draw = intval($this->input->get("draw"));
        // $start = intval($this->input->get("start"));
        // $length = intval($this->input->get("length"));
        // $status = intval($this->input->get("status"));

        // $draw = 1;
        // $start = 0;
        // $length = 10;
        // $search_value = '';
        // $status = '';

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $status = $this->input->post("status");

        $search_val = $search['value'];

        // echo $draw;
        // echo '<br/><br/>';
        // echo $start;
        // echo '<br/><br/>';
        // echo $length;
        // echo '<br/><br/>';
        // echo json_encode($search);
        // echo '<br/><br/>';
        // echo $status;
        // echo '<br/><br/>';
        // echo $search_val;
        // echo '<br/><br/>';

        $result = $this->credit_debit_note_model->get_list_data($status, $start, $length, $search_val);
        // echo json_encode($result);
        // echo '<br/><br/>';

        $totalRecords = 0;
        $count = $result['count'];
        if(count($count)>0) $totalRecords = $count[0]->total_records;

        $r = $result['rows'];

        $data = array();

        for($i=0;$i<count($r);$i++){
            $data[] = array(
                        $i+$start+1,

                        '<span style="display:none;">'.
                            (($r[$i]->date_of_transaction!=null && $r[$i]->date_of_transaction!='')?date('Ymd',strtotime($r[$i]->date_of_transaction)):'')
                        .'</span>'.
                        (($r[$i]->date_of_transaction!=null && $r[$i]->date_of_transaction!='')?date('d/m/Y',strtotime($r[$i]->date_of_transaction)):''),

                        '<a href="'.base_url().'index.php/credit_debit_note/edit/'.$r[$i]->id.'" class=""><i class="fa fa-edit"></i></a>',

                        (($r[$i]->ref_no!=null && $r[$i]->ref_no!='')? '<a href="'.base_url().'index.php/credit_debit_note/view_credit_debit_note/'.$r[$i]->id.'" target="_blank"><span class="fa fa-file-pdf-o" style="font-size:20px;text-align:center;vertical-align:middle;"></span></a>': ''),

                        $r[$i]->ref_no,

                        $r[$i]->distributor_name,

                        $r[$i]->transaction,

                        format_money($r[$i]->amount,2),

                        $r[$i]->remarks
                    );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => $totalRecords,
                        "recordsFiltered" => $totalRecords,
                        "data" => $data
                        // ,
                        // "columns" => $columns
                    );
        echo json_encode($output);
    }
    
    public function checkstatus($status=''){
        $result=$this->credit_debit_note_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;

            $count_data = array();
            $count_data=$this->credit_debit_note_model->get_data_count();
            
            $total_count=0;
            $approved=0;
            $pending=0;
            $rejected=0;
            $inactive=0;

            if (count($count_data)>0){
                $total_count=$count_data[0]->total_count;
                $approved=$count_data[0]->approved;
                $pending=$count_data[0]->pending;
                $rejected=$count_data[0]->rejected;
                $inactive=$count_data[0]->inactive;
            }

            $data['status']=$status;
            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inactive']=$inactive;
            $data['all']=$total_count;

            load_view('credit_debit_note/credit_debit_note_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_invoice() { 
        $postData = $this->input->post();
        $distributor_id = $postData['distributor_id'];
        $data = $this->credit_debit_note_model->get_invoice($distributor_id);

        $options = '<option value="">Select</option>';
        for($i=0; $i<count($data); $i++){
            $options = $options . '<option value="'.$data[$i]->invoice_no.'">'.$data[$i]->invoice_no.'</option>';
        }
        echo $options;
    }
    
    public function add(){
        $result=$this->credit_debit_note_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['exp_category'] = $this->exp_cat_master_model->get_data('Approved');

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
                $data['exp_category'] = $this->exp_cat_master_model->get_data('Approved');
				$distributor_id=$data['data'][0]->distributor_id;
				$data['invoice'] = $this->credit_debit_note_model->get_invoice($distributor_id);

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
        // echo 'Approved';

        echo '<script>window.open("'.base_url().'index.php/credit_debit_note", "_parent")</script>';
        // redirect(base_url().'index.php/credit_debit_note');
    }
        
    public function view_credit_debit_note($id){
        $this->credit_debit_note_model->view_credit_debit_note($id);
    }

}
?>