<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Payment extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('payment_model');
        $this->load->model('bank_model');
        $this->load->model('distributor_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->payment_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->payment_model->get_data();

        //     load_view('payment/payment_list', $data);
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

        $result = $this->payment_model->get_list_data($status, $start, $length, $search_val);
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
                            (($r[$i]->date_of_deposit!=null && $r[$i]->date_of_deposit!='')?date('Ymd',strtotime($r[$i]->date_of_deposit)):'')
                        .'</span>'.
                        (($r[$i]->date_of_deposit!=null && $r[$i]->date_of_deposit!='')?date('d/m/Y',strtotime($r[$i]->date_of_deposit)):''),

                        '<a href="'.base_url().'index.php/payment/edit/'.$r[$i]->id.'" class=""><i class="fa fa-edit"></i></a>',

                        ((strtoupper(trim($r[$i]->status))=='APPROVED')? '<a href="'.base_url().'index.php/payment/view_payment_slip/'.$r[$i]->id.'" target="_blank"><span class="fa fa-file-pdf-o" style="font-size:20px;text-align:center;vertical-align:middle;"></span></a>': ''),

                        $r[$i]->id,

                        $r[$i]->b_name,

                        ((strlen(trim($r[$i]->distributor_name))>50)? '<span class="distributor_name" data-attr="'.$r[$i]->distributor_name.'" style="cursor:pointer">'.substr($r[$i]->distributor_name,0,30).' <span style="color:#41a541"> &nbsp Read More...</span> </span>': $r[$i]->distributor_name),

                        format_money($r[$i]->total_amount,2)
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
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['status']=$status;
            // $data['data']=$this->payment_model->get_data($status);

            $count_data = array();
            $count_data=$this->payment_model->get_data_count();
            
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

            // $count_data=$this->payment_model->get_data();
            // $approved=0;
            // $pending=0;
            // $rejected=0;
            // $inactive=0;

            // if (count($result)>0){
            //     for($i=0;$i<count($count_data);$i++){
            //         if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
            //             $approved=$approved+1;
            //         else if (strtoupper(trim($count_data[$i]->status))=="PENDING" || strtoupper(trim($count_data[$i]->status))=="DELETED")
            //             $pending=$pending+1;
            //         else if (strtoupper(trim($count_data[$i]->status))=="REJECTED")
            //             $rejected=$rejected+1;
            //         else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
            //             $inactive=$inactive+1;
            //     }
            // }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inactive']=$inactive;
            $data['all']=$total_count;

            load_view('payment/payment_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_total_outstanding(){
        $id=$this->input->post('id');
        $distributor_id=$this->input->post('distributor_id');
        $module=$this->input->post('module');

        // $id=1;
        // $distributor_id=1;
        // $module='';

        $result=$this->payment_model->get_total_outstanding($id, $distributor_id, $module);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['total_outstanding'] = $result[0]->total_outstanding;
        }

        echo json_encode($data);
    }

    public function get_invoice_nos(){
        $id=$this->input->post('id');
        $distributor_id=$this->input->post('distributor_id');
        // $distributor_id=1;

        $result=$this->payment_model->get_invoice_nos($id, $distributor_id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['invoice_no'][$i]=$result[$i]->invoice_no;
            }
        }

        echo json_encode($data);
    }

    public function get_invoice_details(){
        $id=$this->input->post('id');
        $invoice_no=$this->input->post('invoice_no');
        // $invoice_no=1;

        $result=$this->payment_model->get_invoice_details($id, $invoice_no);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['client_name'] = $result[0]->client_name;
            $data['final_amount'] = $result[0]->final_amount;
        }

        echo json_encode($data);
    }

    public function add(){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $result;
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['bank'] = $this->bank_model->get_data('Approved');

                load_view('payment/payment_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                
                $id = $this->payment_model->get_pending_data($id);
                
                $data['data'] = $this->payment_model->get_data('', $id);
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['bank'] = $this->bank_model->get_data('Approved');
                $data['payment_items'] = $this->payment_model->get_payment_items($id);
                $data['denomination'] = $this->payment_model->get_payment_slip_denomination($id);

                load_view('payment/payment_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->payment_model->save_data();
        redirect(base_url().'index.php/payment');
    }

    public function update($id){
        $this->payment_model->save_data($id);
        // redirect(base_url().'index.php/payment');
        // echo '<script>window.open("'.base_url().'index.php/payment", "_parent")</script>';
    }

    public function view_payment_slip($id){
        $result=$this->payment_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $this->payment_model->generate_payment_slip($id);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

}
?>