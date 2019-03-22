<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor_out extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
		$this->load->library('form_validation');
        $this->load->helper('common_functions');
        $this->load->model('distributor_out_model');
        $this->load->model('box_model');
        $this->load->model('depot_model');
        $this->load->model('sales_rep_model');
        $this->load->model('distributor_model');
        $this->load->model('product_model');
        $this->load->model('tax_invoice_model');
        $this->load->model('bank_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->distributor_out_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->distributor_out_model->get_data();

        //     load_view('distributor_out/distributor_out_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }

        $this->checkstatus('Approved');
    }

    function select_validate($distributor_id){
        if($distributor_id=="amazon direct"){
            $this->form_validation->set_message('select_validate', 'order no should be in 333-7777777-7777777');
            return false;
        } else {
            return true;
        }
    }

    public function get_data($status){
        // $status = 'Approved';

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        // $status = intval($this->input->get("status"));

        $r = $this->distributor_out_model->get_distributor_out_data1($status);
		// echo "<pre>";
		// print_r($r[0]);
		// echo "</pre>";
		// die();
        $data = array();

        for($i=0;$i<count($r);$i++){
            if($status=='pending_for_delivery' || $status=='gp_issued'){
                /*<input type="checkbox" id="check_'.$i.'" class="check icheckbox" name="check_val[]" value="'.$r[$i]->id.'" onChange="set_checkbox(this);" />
                            <input type="hidden" id="input_check_'.$i.'" name="check[]" value="false" />*/
                $com = '';
                if($status=='pending_for_delivery')
                {
                    $ulr = '<a href="'.base_url('index.php/distributor_out/get_batch_details/'.$r[$i]->id).'" target="_blank">Delivery Person</a>
                        &nbsp;
                            
                            <span class="fa fa-comments" onclick="get_delivery_comments(this);" style="cursor:pointer" id="'.$r[$i]->id.'"></span >
                    ';

                }
                else if($status=='gp_issued')
                {
                    $ulr = '<a href="javascript:void(0)" id="gp_issued_'.$i.'" onclick="get_batch_details(this);" data-distributor="'.$r[$i]->id.'" data-deliverystatus ="'.$r[$i]->delivery_status.'">Delivery Status</a>
                    &nbsp;
                            
                            <span class="fa fa-comments" onclick="get_delivery_comments(this);" style="cursor:pointer" id="'.$r[$i]->id.'"></span >';
                }

                 /*
                    ((($r[$i]->invoice_no!=null && $r[$i]->invoice_no!='') || ($r[$i]->voucher_no!=null && $r[$i]->voucher_no!=''))?
                                '<a href="'.
                                            ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                            base_url().'index.php/distributor_out/view_tax_invoice_old/'.$r[$i]->id:
                                            base_url().'index.php/distributor_out/view_tax_invoice/'.$r[$i]->id).
                                        '" target="_blank"> 
                                    <span class="fa fa-file-pdf-o" style="font-size:20px;"></span>
                                </a>'
                                :''),


                                '<a href="'.($r[$i]->proof_of_delivery!=NULL?base_url('assets/uploads/delivery_proof').'/'.$r[$i]->proof_of_delivery:'javascript:void(0)').'" target="_blank"> 
                                    '.($r[$i]->proof_of_delivery!=NULL?'<span class="fa fa-file-pdf-o" style="font-size:20px;"></span>':'').'
                                </a>'

                */

                $data[] = array(
                            $ulr,
                            $i+1,

                            '<span style="display:none;">
                            <input type="hidden" id="date_of_processing_'.$i.'" name="date_of_processing[]" value="'.$r[$i]->date_of_processing.'" />'.
                                (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('Ymd',strtotime($r[$i]->date_of_processing)):'')
                            .'</span>'.
                            (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('d/m/Y',strtotime($r[$i]->date_of_processing)):''),
									  '<a href="'.base_url().'index.php/distributor_out/edit/'.$r[$i]->d_id.'" class=""><i class="fa fa-edit"></i></a>',
							
							  '<a href="'.($r[$i]->proof_of_delivery!=NULL?base_url('assets/uploads/delivery_proof').'/'.$r[$i]->proof_of_delivery:'javascript:void(0)').'" target="_blank"> 
                                '.($r[$i]->proof_of_delivery!=NULL?'<span class="fa fa-file-pdf-o" style="font-size:20px;"></span>':'').'
                            </a>',

                            '<span style="display:none;">
                            <input type="hidden" id="invoice_no_'.$i.'" name="invoice_no[]" value="'.$r[$i]->invoice_no.'" />'.
                                (isset($r[$i]->invoice_no)?str_pad(substr($r[$i]->invoice_no, strrpos($r[$i]->invoice_no, "/")+1),10,"0",STR_PAD_LEFT):'')
                            .'</span>'.
                            ((($r[$i]->invoice_no!=null && $r[$i]->invoice_no!=''))?
                                '<a href="'.
                                            ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                            base_url().'index.php/distributor_out/view_tax_invoice_old/'.$r[$i]->id:
                                            base_url().'index.php/distributor_out/view_tax_invoice/'.$r[$i]->id).
                                        '" target="_blank"> 
                                    '.$r[$i]->invoice_no.'
                                </a>'
                                :''),

                            '<span style="display:none;">
                            <input type="hidden" id="invoice_date_'.$i.'" name="invoice_date[]" value="'.$r[$i]->invoice_date.'" />'.
                                (($r[$i]->invoice_date!=null && $r[$i]->invoice_date!='')?date('Ymd',strtotime($r[$i]->invoice_date)):'')
                            .'</span>'.
                            (($r[$i]->invoice_date!=null && $r[$i]->invoice_date!='')?date('d/m/Y',strtotime($r[$i]->invoice_date)):''),

                           

                            ((strtoupper(trim($r[$i]->distributor_name))=='DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='AMAZON DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NYKAA DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($r[$i]->distributor_name))=='1MG TECHNOLOGIES PRIVATE LIMITED')? $r[$i]->distributor_name . '-' . $r[$i]->client_name : $r[$i]->distributor_name),

                            $r[$i]->order_no,

                            $r[$i]->location,

                       

                            $r[$i]->invoice_amount,

                            // (($r[$i]->modified_on!=null && $r[$i]->modified_on!='')?date('d/m/Y',strtotime($r[$i]->modified_on)):''),

                            // (($r[$i]->status=="InActive")?"Cancelled":$r[$i]->status),

                            '<input type="hidden" id="dlvery_status_'.$i.'" name="dlvery_status[]" value="'.$r[$i]->delivery_status.'" />'.
                            $r[$i]->delivery_status,

                            // $r[$i]->del_person_name,
							// 

                            '<a href="'.
                                        ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                        base_url().'index.php/distributor_out/view_gate_pass_old/'.$r[$i]->id:
                                        base_url().'index.php/distributor_out/view_gate_pass/'.$r[$i]->id).
                                    '" target="_blank">  <span class="fa fa-file-pdf-o" style="font-size:20px;"></span>
                            </a>',

                            '<a href="#"><span class="fa fa-eye">Resend Invoice</span></a>',
							$r[$i]->tracking_id
							 
                        );
            } else {
                $data[] = array(
                            '<input type="checkbox" id="check_'.$i.'" class="check icheckbox" name="check_val[]" value="'.$r[$i]->id.'" onChange="set_checkbox(this);" />
                            <input type="hidden" id="input_check_'.$i.'" name="check[]" value="false" />',

                            $i+1,

                            '<span style="display:none;">
                            <input type="hidden" id="date_of_processing_'.$i.'" name="date_of_processing[]" value="'.$r[$i]->date_of_processing.'" />'.
                                (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('Ymd',strtotime($r[$i]->date_of_processing)):'')
                            .'</span>'.
                          
                                (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('d/m/Y',strtotime($r[$i]->date_of_processing)):''),
                           
								  '<a href="'.base_url().'index.php/distributor_out/edit/'.$r[$i]->d_id.'" class=""><i class="fa fa-edit"></i></a>',
								 '<a href="'.($r[$i]->proof_of_delivery!=NULL?base_url('assets/uploads/delivery_proof').'/'.$r[$i]->proof_of_delivery:'javascript:void(0)').'" target="_blank"> 
                                '.($r[$i]->proof_of_delivery!=NULL?'<span class="fa fa-file-pdf-o" style="font-size:20px;"></span>':'').'
                            </a>',
								  
                            '<span style="display:none;">
                            <input type="hidden" id="invoice_no_'.$i.'" name="invoice_no[]" value="'.$r[$i]->invoice_no.'" />'.
                                (isset($r[$i]->invoice_no)?str_pad(substr($r[$i]->invoice_no, strrpos($r[$i]->invoice_no, "/")+1),10,"0",STR_PAD_LEFT):'')
                            .'</span>'.
                            ((($r[$i]->invoice_no!=null && $r[$i]->invoice_no!=''))?
                                '<a href="'.
                                            ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                            base_url().'index.php/distributor_out/view_tax_invoice_old/'.$r[$i]->id:
                                            base_url().'index.php/distributor_out/view_tax_invoice/'.$r[$i]->id).
                                        '" target="_blank"> 
                                    '.$r[$i]->invoice_no.'
                                </a>'
                                :''),
                            '<span style="display:none;">
                            <input type="hidden" id="invoice_date_'.$i.'" name="invoice_date[]" value="'.$r[$i]->invoice_date.'" />'.
                                (($r[$i]->invoice_date!=null && $r[$i]->invoice_date!='')?date('Ymd',strtotime($r[$i]->invoice_date)):'')
                            .'</span>'.
                            (($r[$i]->invoice_date!=null && $r[$i]->invoice_date!='')?date('d/m/Y',strtotime($r[$i]->invoice_date)):''),

                          
                            ((strtoupper(trim($r[$i]->distributor_name))=='DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='AMAZON DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NYKAA DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($r[$i]->distributor_name))=='1MG TECHNOLOGIES PRIVATE LIMITED')? $r[$i]->distributor_name . '-' . $r[$i]->client_name : $r[$i]->distributor_name),

                            $r[$i]->order_no,

                            $r[$i]->location,

                          

                            $r[$i]->invoice_amount,

                            // (($r[$i]->modified_on!=null && $r[$i]->modified_on!='')?date('d/m/Y',strtotime($r[$i]->modified_on)):''),

                            // (($r[$i]->status=="InActive")?"Cancelled":$r[$i]->status),

                            '<input type="hidden" id="dlvery_status_'.$i.'" name="dlvery_status[]" value="'.$r[$i]->delivery_status.'" />'.
                            $r[$i]->delivery_status,

                            // $r[$i]->del_person_name,

                        

                            '<a href="'.
                                        ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                        base_url().'index.php/distributor_out/view_gate_pass_old/'.$r[$i]->id:
                                        base_url().'index.php/distributor_out/view_gate_pass/'.$r[$i]->id).
                                    '" target="_blank">  <span class="fa fa-file-pdf-o" style="font-size:20px;"></span>
                            </a>',

                            '<a href="#"><span class="fa fa-eye">Resend Invoice</span></a>',
                           $r[$i]->tracking_id

                        );
            }
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => count($r),
                        "recordsFiltered" => count($r),
                        "data" => $data
                        // ,
                        // "columns" => $columns
                    );
        echo json_encode($output);
    }

    public function checkstatus($status=''){
        $result=$this->distributor_out_model->get_access();
		$selectedstatus="Select Status";
        if(count($result)>0) {
            $curusr = $this->session->userdata('session_id');

            $data['access']=$result;
			if($status=='All') {
				$status='';
			}
            $data['data']=$this->distributor_out_model->get_distributor_out_data1($status);
			
            $count_data=$this->distributor_out_model->get_distributor_out_data1();
			
            $active=0;
            $inactive=0;
            $pending=0;
            $pending_for_approval=0;
            $pending_for_delivery=0;
            $gp_issued=0;
            $delivered_not_complete=0;
			
			//responsive drop down list code 
			if($status=="Approved")
			{
				$selectedstatus='Approved';//$status;
			}
			else if($status=="pending")
			{
				$selectedstatus='Pending';//$status;
			}
			else if($status=="pending_for_approval")
			{
				$selectedstatus='Approval Pending';//$status;
			}
			else if($status=="InActive")
			{
				$selectedstatus='Cancelled';//$status;
			}
			else if($status=="pending_for_delivery")
			{
				$selectedstatus='Delivery Pending';//$status;
			}
			else if($status=="gp_issued")
			{
				$selectedstatus='GP Issued';//$status;
			}
			else if($status=="delivered_not_complete")
			{
				$selectedstatus="InComplete";
			}
			else
			{
				$selectedstatus=$status;
			}
			//responsive drop down list code 
			
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $active=$active+1;
						

                    if ((strtoupper(trim($count_data[$i]->status))=="PENDING" && 
                        (strtoupper(trim($count_data[$i]->delivery_status))=="PENDING" || 
                            strtoupper(trim($count_data[$i]->delivery_status))=="GP ISSUED" || 
                            strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED NOT COMPLETE" || 
                            strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED")) || 
                        strtoupper(trim($count_data[$i]->status))=="DELETED")
                        $pending_for_approval=$pending_for_approval+1;
						
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && 
                                (strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED" || $count_data[$i]->delivery_status==null))
                        // $active=$active+1;
                        $active=$active;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
					
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING" && 
                                ($count_data[$i]->delivery_status==null || $count_data[$i]->delivery_status==''))
                        $pending=$pending+1;
						
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_status))=="PENDING")
                        $pending_for_delivery=$pending_for_delivery+1;
					
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_status))=="GP ISSUED")
                        $gp_issued=$gp_issued+1;
					
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED NOT COMPLETE")
                        $delivered_not_complete=$delivered_not_complete+1;
					
                }
            }
			$data['selectedstatus']=$selectedstatus;
            $data['active']=$active;
            $data['inactive']=$inactive;
            $data['pending']=$pending;
            $data['pending_for_approval']=$pending_for_approval;
            $data['pending_for_delivery']=$pending_for_delivery;
            $data['gp_issued']=$gp_issued;
            $data['delivered_not_complete']=$delivered_not_complete;
            $data['all']=count($count_data);
            $data['status']=$status;
            $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');

    		$query=$this->db->query("SELECT * FROM sales_rep_master WHERE sr_type='Merchandizer'");
            $result=$query->result();
            $data['sales_rep1']=$result;
            
            load_view('distributor_out/distributor_out_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function product_expired($status=''){
        $result=$this->distributor_out_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            if($status=='All') {
                $status='';
            }
            $data['data']=$this->distributor_out_model->get_distributor_out_expired_data($status);

            $count_data=$this->distributor_out_model->get_distributor_out_expired_data();
            $active=0;
            $inactive=0;
            $pending=0;
            $pending_for_delivery=0;
            $gp_issued=0;
            $delivered_not_complete=0;


            $data['active']=$active;
            $data['all']=count($count_data);
            $data['status']=$status;
            $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');

            load_view('distributor_out/distributor_out_expired_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->distributor_out_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->distributor_out_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data_without_sample('Approved');
                $data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['bank'] = $this->bank_model->get_data('Approved');

                load_view('distributor_out/distributor_out_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($d_id){
        $result=$this->distributor_out_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_out_model->get_access();

                $id = $this->distributor_out_model->get_pending_data($d_id);
                if($id!=''){
                    $d_id = substr($d_id, 0, strpos($d_id, "_")+1) . $id;
                }

                $data['data'] = $this->distributor_out_model->get_distributor_out_data('', $d_id);
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['sales_rep'] = $this->sales_rep_model->get_data_dist('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_out_items'] = $this->distributor_out_model->get_distributor_out_items($d_id);
                $data['bank'] = $this->bank_model->get_data('Approved');
                // $data['distributor_payment_details'] = $this->distributor_out_model->get_distributor_payment_details($id);

                load_view('distributor_out/distributor_out_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_dist_consignee(){
        $distributor_id = $this->input->post('distributor_id');
        $dist_cons_id = $this->input->post('dist_cons_id');
        $data = $this->distributor_out_model->get_dist_consignee($distributor_id);

        $result = '<option value="">Select</option>';
        if(count($data)>0){
            for($i=0; $i<count($data); $i++){
                if($data[$i]->id==$dist_cons_id){
                    $result = $result . '<option value="'.$data[$i]->id.'" selected>'.$data[$i]->address.'</option>';
                } else {
                    $result = $result . '<option value="'.$data[$i]->id.'">'.$data[$i]->address.'</option>';
                }
            }
        }
        echo $result;
    }

    public function save(){
        $this->distributor_out_model->save_data();
        redirect(base_url().'index.php/distributor_out/checkstatus/pending_for_delivery');
    }

    public function update($id){
        $this->distributor_out_model->save_data($id);
        // redirect(base_url().'index.php/distributor_out/checkstatus/pending_for_delivery');
        echo '<script>window.open("'.base_url().'index.php/distributor_out/checkstatus/pending_for_delivery", "_parent")</script>';
    }
    
    public function check_box_availablity(){
        $result = $this->distributor_out_model->check_box_availablity();
        echo $result;
    }

    public function check_box_qty_availablity(){
        $result = $this->distributor_out_model->check_box_qty_availablity();
        echo $result;
    }

    public function check_product_availablity(){
        $result = $this->distributor_out_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->distributor_out_model->check_product_qty_availablity();
        echo $result;
    }

    public function view_tax_invoice_old($id){
        $this->tax_invoice_model->generate_tax_invoice_old($id);
    }

    public function generate_gate_pass_old(){
        $this->tax_invoice_model->generate_gate_pass_old();
    }

    public function generate_gate_pass_old_print(){
        $this->tax_invoice_model->generate_gate_pass_old_print();
    }

    public function view_gate_pass_old($distid){
        $this->tax_invoice_model->view_gate_pass_old($distid);
    }

    public function view_tax_invoice($id){
        $this->tax_invoice_model->generate_tax_invoice($id);
    }

    public function generate_gate_pass(){
        $this->tax_invoice_model->generate_gate_pass();
    }

    public function view_gate_pass($distid){
        $this->tax_invoice_model->view_gate_pass($distid);
    }

    public function authorise(){
        $status=$this->input->post('status');
        $form_status = $this->input->post('form_status');

        if($status=="Approved"){
            $this->distributor_out_model->approve_records();
        } else {
            $this->distributor_out_model->reject_records();
        }

        redirect(base_url().'index.php/distributor_out/checkstatus/pending_for_approval');
    }

    public function set_delivery_status(){
        // echo 'Hii';

        $this->distributor_out_model->set_delivery_status();
        $status=$this->input->post('status');
        if($status=='InActive') {
            redirect(base_url().'index.php/distributor_out');
        }
    }

    public function set_sku_batch(){
        $this->distributor_out_model->set_sku_batch();
        $status=$this->input->post('status');
        if($status=='InActive') {
            redirect(base_url().'index.php/distributor_out');
        }
    }

    public function set_delivery_status2(){
        $this->distributor_out_model->set_delivery_status();
        redirect(base_url().'index.php/distributor_out/checkstatus/gp_issued');
    }

    public function check_file_name(){
        $filename = $this->input->post('filename');
        $check1=$this->input->post('check');
        $check = array();
        $j=0;

        for($i=0; $i<count($check1); $i++){
            if($check1[$i]!='false'){
                $check[$j] = $check1[$i];
                $j = $j + 1;
            }
        }

        $distributor_out_id = $check1;

        $result = $this->db->query("Select proof_of_delivery from distributor_out Where  proof_of_delivery='$filename'")->result();

       if(count($result)==0)
         echo 0;
       else
         echo 1;
    }

    public function get_batch_details($distributor_out_id){
        $result=$this->distributor_out_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_out_model->get_access();
                $data['data'] = $this->distributor_out_model->get_sku_details($distributor_out_id);
                $data['batch_details'] = $this->distributor_out_model->get_batch_details();

                /*$check1=$this->input->post('check');
				$tracking_id=$this->input->post('tracking_id');
                $check = array();
                $j=0;
                for($i=0; $i<count($check1); $i++){
                    if($check1[$i]!='false'){
                        $check[$j] = $check1[$i];
                        $j = $j + 1;
                    }
                }
                $distributor_out_id = implode(", ", $check);*/
                $data['distributor_out_id']=$distributor_out_id;

                $query=$this->db->query("SELECT * FROM sales_rep_master WHERE sr_type='Merchandizer'");
                $result=$query->result();
                $data['sales_rep1']=$result;

                // dump($data['data']);

                load_view('distributor_out/distributor_out_sku_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function view_payment_details($id){
        //     $result=$this->distributor_out_model->get_access();
        //     if(count($result)>0) {
        //         if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
        //             $data['access'] = $this->distributor_out_model->get_access();
        //             $data['data'] = $this->distributor_out_model->get_data('', $id);
        //             $data['distributor_payment_details'] = $this->distributor_out_model->get_distributor_payment_details($id);

        //             load_view('distributor_out/distributor_payment_details', $data);
        //         } else {
        //             echo "Unauthorized access";
        //         }
        //     } else {
        //         echo "You donot have access to this page.";
        //     }
    // }

    // public function save_payment_details(){
        //     $this->distributor_out_model->save_payment_details();
        //     redirect(base_url().'index.php/distributor_out');
    // }

    // public function update_payment_details($id){
        //     $this->distributor_out_model->save_payment_details($id);
        //     redirect(base_url().'index.php/distributor_out');
    // }
    
    public function generate_invoice(){
        $this->tax_invoice_model->generate_tax_invoice(5);
        // $this->tax_invoice_model->gen_pdf();
        // load_view_without_data('pdf_output');

        // $this->load->helper('dompdf_helper');
        // $html = $this->load->view('invoice/tax_invoice', '', true);
        // $filename ="Tax Invoice";
        // pdf_create($html, $filename='');
    }

    public function save_download(){ 
        // //load mPDF library
        // $this->load->library('m_pdf');
        // //load mPDF library
 
 
        // //now pass the data//
         $this->data['title']="MY PDF TITLE 1.";
         $this->data['description']="";
         $this->data['description']="";
        //  //now pass the data
 
        
        // $html=$this->load->view('invoice/tax_invoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
     
        // //this the the PDF filename that user will get to download
        // $pdfFilePath ="mypdfName-".time()."-download.pdf";
 
        
        // //actually, you can pass mPDF parameter on this load() function
        // $pdf = $this->m_pdf->load();
        // //generate the PDF!
        // $pdf->WriteHTML($html,2);
        // //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        // $pdf->Output($pdfFilePath, "D");
         
        
        $this->load->library('m_pdf');
        $html = $this->load->view('invoice/tax_invoice',$this->data,true);
        $m_pdf = $this->m_pdf->load();
        $m_pdf->WriteHTML($html);
        // $filepath = getcwd()."/assets/other_uploads/pdf_files/";
        $filepath = getcwd()."/assets/Tax_Invoice/";
        $filename ="mypdfName-".time()."-download.pdf";
        $m_pdf->Output($filepath.$filename, "F");
    }

    public function check_order_id_availablity() {
		$result = $this->distributor_out_model->check_order_id_availablity();
		echo $result;
	}

    public function get_product_percentage($product_id,$distributor_id) {
        $result = $this->distributor_out_model->get_product_percentage($product_id,$distributor_id);

        if(count($result)>0) {
           echo json_encode($result[0]);
        }
        else{
            echo 0;
        }
    }

    public function get_product_details(){
        $id=$this->input->post('id');
        $distributor_id=$this->input->post('distributor_id');
        // $id=1;

        $result=$this->distributor_out_model->get_product_details('', $id, $distributor_id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['product_name'] = $result[0]->product_name;
            $data['barcode'] = $result[0]->barcode;
            $data['grams'] = $result[0]->grams;
            $data['avg_grams'] = $result[0]->avg_grams;
            $data['rate'] = $result[0]->rate;
            $data['cost'] = $result[0]->cost;
            $data['anticipated_wastage'] = $result[0]->anticipated_wastage;
            $data['tax_percentage'] = $result[0]->tax_percentage;
            $data['inv_margin'] = $result[0]->inv_margin;
            $data['pro_margin'] = $result[0]->pro_margin;
        }

        echo json_encode($data);
    }

    public function set_invoice_debit_note(){
        $this->distributor_out_model->set_debit_note('6527');
    }

    public function get_box_details(){
        $id=$this->input->post('id');
        $distributor_id=$this->input->post('distributor_id');
        // $id=1;

        $result=$this->distributor_out_model->get_box_details('', $id, $distributor_id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['box_name'] = $result[0]->box_name;
            $data['barcode'] = $result[0]->barcode;
            $data['grams'] = $result[0]->grams;
            $data['rate'] = $result[0]->rate;
            $data['cost'] = $result[0]->cost;
            $data['tax_percentage'] = $result[0]->tax_percentage;
            $data['inv_margin'] = $result[0]->inv_margin;
            $data['pro_margin'] = $result[0]->pro_margin;
        }

        echo json_encode($data);
    }

    public function get_comments(){
        $id=$this->input->post('id');
        $result = $this->distributor_out_model->get_comments($id);
        if(count($result)>0)
        {
            echo json_encode($result[0]);
        }
        else
        {
            echo 0;
        }
    }

    public function add_comments(){
       $result = $this->distributor_out_model->save_comments();
       redirect($_SERVER['HTTP_REFERER']); 
    }

}
?>