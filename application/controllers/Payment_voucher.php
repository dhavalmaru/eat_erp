<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Payment_voucher extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_model');
        $this->load->model('document_model');
        $this->load->model('export_model');
        $this->load->model('Payment_voucher_model','payment_voucher');
        $this->load->database();
        $this->load->model('vendor_model');
        $this->load->model('raw_material_model');
        $this->load->model('purchase_order_model');
    }

    //index function
    public function index(){

        $this->checkstatus('');
    }

    public function add()
    {   
        $data['raw_material'] = $this->raw_material_model->get_data('Approved');
        $id = $this->input->post('vendor_id');
        $data['vendor'] = $this->vendor_model->get_data('Approved',$id);
        load_view('payment_voucher/payment_voucher_detail', $data);
    }

    public function payment_voucher_receipt($id='')
    {
          $this->checkstatus('',$id,$list=1);

    }

    public function get_gstin()
    {
        $vendor_id = $this->input->post('vendor_id');
        $result = $this->payment_voucher->get_vendor($vendor_id);
        if(count($result)>0)
            echo json_encode($result);
        else
            echo 0;    
    }

    public function save(){
        $this->payment_voucher->save_data();
        redirect(base_url().'index.php/payment_voucher');
    }

   
    public function checkstatus($status='',$id='',$list=''){
        $result=$this->payment_voucher->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->payment_voucher->get_data($status,$id);

            $count_data=$this->payment_voucher->get_data();
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
            
            if($list!='')
            {
                $data['payment_voucher']=$this->payment_voucher->payment_voucher_list($id);
                load_view('payment_voucher/payment_voucher_receipt', $data);
            }
            else
            {
                load_view('payment_voucher/payment_voucher_list', $data);
            }
            

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    public function edit($id){
        $result=$this->payment_voucher->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;
                $data['vendor'] = $this->vendor_model->get_data();
                $data['data']=$this->payment_voucher->get_data('',$id);
                if(count($data['data'])>0)
                {
                   $vendor_id = $data['data'][0]->vendor_id;
                   $result=$this->purchase_order_model->get_purchase_order_nos($vendor_id);
                   $data['purchase_order'] = $result;
                }
                
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['payment_voucher']=$this->payment_voucher->payment_voucher_list($id);
                load_view('payment_voucher/payment_voucher_detail', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_purchase_order_nos(){
        $vendor_id=$this->input->post('vendor_id');
        // $vendor_id=3;

        $result=$this->purchase_order_model->get_purchase_order_nos_by_status($vendor_id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['order_date'][$i] = (($result[$i]->order_date!=null && $result[$i]->order_date!='')?date('d/m/Y',strtotime($result[$i]->order_date)):'');
                $data['id'][$i] = $result[$i]->id;
                $data['po_no'][$i] = $result[$i]->po_no;
            }
        }

        echo json_encode($data);
    }

}
?>