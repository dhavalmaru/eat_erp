<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Purchase_order extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('purchase_order_model');
        $this->load->model('depot_model');
        $this->load->model('vendor_model');
        $this->load->model('raw_material_model');
        $this->load->library('encryption');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->purchase_order_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->purchase_order_model->get_data();

            load_view('purchase_order/purchase_order_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_data(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->purchase_order_model->get_data('', $id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['vendor_id'] = $result[0]->vendor_id;
            $data['depot_id'] = $result[0]->depot_id;
        }

        echo json_encode($data);
    }

    public function get_purchase_order_items(){
        $id=$this->input->post('id');
        // $id=1;

        $result=$this->purchase_order_model->get_purchase_order_items($id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['item_id'][$i] = $result[$i]->item_id;
                $data['qty'][$i] = $result[$i]->qty;
                $data['hsn_code'][$i] = $result[$i]->hsn_code;
                $data['rate'][$i] = $result[$i]->rate;
                $data['tax_per'][$i] = $result[$i]->tax_per;
                $data['amount'][$i] = $result[$i]->amount;
				$data['cgst_amt'][$i] = $result[$i]->cgst_amt;
				$data['sgst_amt'][$i] = $result[$i]->sgst_amt;
				$data['igst_amt'][$i] = $result[$i]->igst_amt;
                $data['tax_amt'][$i] = $result[$i]->tax_amt;
                $data['total_amt'][$i] = $result[$i]->total_amt;
            }
        }

        echo json_encode($data);
    }

    public function get_purchase_order_nos(){
        $vendor_id=$this->input->post('vendor_id');
        // $vendor_id=3;

        $result=$this->purchase_order_model->get_purchase_order_nos($vendor_id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['order_date'][$i] = (($result[$i]->order_date!=null && $result[$i]->order_date!='')?date('d/m/Y',strtotime($result[$i]->order_date)):'');
                $data['id'][$i] = $result[$i]->id;
            }
        }

        echo json_encode($data);
    }

    public function add(){
        $result=$this->purchase_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->purchase_order_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['vendor'] = $this->vendor_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');

                load_view('purchase_order/purchase_order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->purchase_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->purchase_order_model->get_access();
                $data['data'] = $this->purchase_order_model->get_data('', $id);
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['vendor'] = $this->vendor_model->get_data('Approved');
                $data['raw_material'] = $this->raw_material_model->get_data('Approved');
                $data['purchase_order_items'] = $this->purchase_order_model->get_purchase_order_items($id);

                load_view('purchase_order/purchase_order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->purchase_order_model->save_data();
        redirect(base_url().'index.php/purchase_order');
    }

    public function update($id){
        $this->purchase_order_model->save_data($id);
        redirect(base_url().'index.php/purchase_order');
    }
	
	public function get_vendor_state($id){
		$result=$this->purchase_order_model->get_vendor_state($id);
		$data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['state'][$i] = $result[$i]->state;
				echo $data['state'][$i];
			} 
		} else {
			echo "state_not_found";
		}
    }
	
	public function get_rate($id){    
    	$result=$this->purchase_order_model->get_rate($id);    
    	//echo $result;
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['rate'][$i] = $result[$i]->rate;
				echo $data['rate'][$i];
			}
		} else {
			echo "0.00";
		}
    }
	
	public function get_hsn($id){   
	$result=$this->purchase_order_model->get_hsn($id);
	//echo $result;
    $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            for($i=0; $i<count($result); $i++){
                $data['hsn_code'][$i] = $result[$i]->hsn_code;
				echo $data['hsn_code'][$i];
			}
		}
		else
		{
			echo "0000";
		}
    }
    
    public function check_box_availablity(){
        $result = $this->purchase_order_model->check_box_availablity();
        echo $result;
    }

    public function check_box_qty_availablity(){
        $result = $this->purchase_order_model->check_box_qty_availablity();
        echo $result;
    }

    public function check_product_availablity(){
        $result = $this->purchase_order_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->purchase_order_model->check_product_qty_availablity();
        echo $result;
    }

    public function view_purchase_order($id){
        $result=$this->purchase_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $this->purchase_order_model->generate_purchase_order($id);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view_po(){
        $id=$this->input->post('id');
        $id=$this->encryption->decrypt($id);
        $this->purchase_order_model->generate_purchase_order($id);
    }

    public function send_email($id){
        $this->purchase_order_model->send_email($id);
        redirect(base_url().'index.php/purchase_order');
    }

    public function view_payment_details($id){
        $result=$this->purchase_order_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->purchase_order_model->get_access();
                $data['data'] = $this->purchase_order_model->get_data('', $id);
                $data['distributor_payment_details'] = $this->purchase_order_model->get_purchase_order_payment_details($id);

                load_view('purchase_order/purchase_order_payment_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save_payment_details(){
        $this->purchase_order_model->save_payment_details();
        redirect(base_url().'index.php/purchase_order');
    }

    public function update_payment_details($id){
        $this->purchase_order_model->save_payment_details($id);
        redirect(base_url().'index.php/purchase_order');
    }
}
?>