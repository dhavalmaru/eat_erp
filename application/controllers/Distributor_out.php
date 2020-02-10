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

                            $r[$i]->depot_name,

                            // ((strtoupper(trim($r[$i]->distributor_name))=='DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='AMAZON DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NYKAA DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($r[$i]->distributor_name))=='1MG TECHNOLOGIES PRIVATE LIMITED' || strtoupper(trim($r[$i]->distributor_name))=='PAYTM DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='UNFACTORY DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EMBRACE DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NEULIFE DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='FLIPKART DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='GOQII DIRECT')? $r[$i]->distributor_name . '-' . $r[$i]->client_name : $r[$i]->distributor_name),

                            ((strtoupper(trim($r[$i]->class))=='DIRECT')? $r[$i]->distributor_name . '-' . $r[$i]->client_name : $r[$i]->distributor_name),

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
                            $r[$i]->tracking_id,
                            
                            
                            
                            '<a href="'.($r[$i]->credit_debit_note_id!=NULL?base_url('index.php/credit_debit_note/view_credit_debit_note/').'/'.$r[$i]->credit_debit_note_id:'javascript:void(0)').'" target="_blank"> 
                                '.($r[$i]->credit_debit_note_id!=NULL?'<span class="fa fa-file-pdf-o" style="font-size:20px;"></span>':'').'
                            </a>',
                             
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

                            $r[$i]->depot_name,

                            // ((strtoupper(trim($r[$i]->distributor_name))=='DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='AMAZON DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NYKAA DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($r[$i]->distributor_name))=='1MG TECHNOLOGIES PRIVATE LIMITED' || strtoupper(trim($r[$i]->distributor_name))=='PAYTM DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='UNFACTORY DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='EMBRACE DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='NEULIFE DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='FLIPKART DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='GOQII DIRECT')? $r[$i]->distributor_name . '-' . $r[$i]->client_name : $r[$i]->distributor_name),

                            ((strtoupper(trim($r[$i]->class))=='DIRECT')? $r[$i]->distributor_name . '-' . $r[$i]->client_name : $r[$i]->distributor_name),

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
                           $r[$i]->tracking_id,
                           '<a href="'.($r[$i]->credit_debit_note_id!=NULL?base_url('index.php/credit_debit_note/view_credit_debit_note/').'/'.$r[$i]->credit_debit_note_id:'javascript:void(0)').'" target="_blank"> 
                                '.($r[$i]->credit_debit_note_id!=NULL?'<span class="fa fa-file-pdf-o" style="font-size:20px;"></span>':'').'
                            </a>',


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

    public function save_approved_data(){
        // $arr = [15383, 15384, 15391, 15392, 15397, 15399, 15400, 15425, 15426, 15427, 15428, 15429, 15437, 15445, 15447, 15448, 15457, 15458, 15460, 15469, 15480, 15482, 15494, 15495, 15497, 15498, 15501, 15504, 15506, 15507, 15508, 15509, 15510, 15515, 15516, 15517, 15588, 15590, 15592, 15593, 15594, 15595, 15597, 15598, 15599, 15600, 15601, 15603, 15604, 15606, 15607, 15608, 15609, 15610, 15611, 15612, 15613, 15614, 15616, 15618, 15620, 15622, 15623, 15624, 15626, 15627, 15628, 15629, 15630, 15631, 15633, 15634, 15636, 15637, 15638, 15639, 15640, 15642, 15643, 15645, 15647, 15649, 15651, 15653, 15655, 15656, 15657, 15659, 15661, 15663, 15665, 15667, 15668, 15669, 15671, 15672, 15673, 15674, 15675, 15676, 15677, 15679, 15681, 15682, 15684, 15686, 15687, 15689, 15691, 15693, 15695, 15697, 15699, 15701, 15703, 15704, 15705, 15706, 15707, 15708, 15709, 15712, 15713, 15714, 15715, 15717, 15719, 15721, 15722, 15723, 15725, 15726, 15727, 15728, 15729, 15730, 15731, 15732, 15733, 15734, 15735, 15736, 15737, 15738, 15739, 15740, 15741, 15742, 15743, 15744, 15745, 15746, 15751, 15754, 15755, 15756, 15759, 15760, 15761, 15762, 15763, 15766, 15767, 15769, 15770, 15774, 15775, 15776, 15777, 15779, 15780, 15781, 15782, 15783, 15784, 15785, 15786, 15787, 15788, 15793, 15795, 15798, 15800, 15801, 15802, 15807, 15808, 15809, 15810, 15811, 15812, 15813, 15814, 15815, 15816, 15818, 15819, 15820, 15821, 15822, 15823, 15824, 15825, 15826, 15827, 15828, 15829, 15831, 15833, 15834, 15835, 15836, 15838, 15844, 15845, 15846, 15849, 15850, 15851, 15852, 15853, 15863, 15864, 15865, 15871, 15873, 15874, 15879, 15880, 15881, 15884, 15885, 15888, 15889, 15892, 15893, 15895, 15899, 15901, 15903, 15904, 15905, 15906, 15911, 15912, 15913, 15915, 15918, 15919, 15920, 15921, 15922, 15923, 15924, 15925, 15926, 15927, 15928, 15929, 15930, 15931, 15932, 15933, 15934, 15935, 15936, 15937, 15938, 15939, 15940, 15941, 15942, 15943, 15944, 15945, 15946, 15947, 15948, 15950, 15952, 15953, 15954, 15955, 15956, 15958, 15959, 15960, 15961, 15963, 15965, 15966, 15967, 15976, 15977, 15978, 15979, 15980, 15981, 15982, 15983, 15984, 15985, 15986, 15987, 15988, 15989, 15990, 15991, 15992, 15993, 15995, 15997, 15998, 15999, 16000, 16001, 16002, 16003, 16004, 16005, 16006, 16007, 16008, 16009, 16010, 16011, 16012, 16014, 16015, 16016, 16017, 16018, 16019, 16020, 16021, 16022, 16023, 16024, 16025, 16026, 16027, 16028, 16029, 16030, 16031, 16032, 16033, 16034, 16035, 16036, 16037, 16038, 16039, 16040, 16042, 16043, 16044, 16045, 16046, 16047, 16053, 16055, 16057, 16060, 16062, 16063, 16064, 16065, 16066, 16067, 16070, 16071, 16074, 16075, 16076, 16077, 16078, 16079, 16080, 16081, 16082, 16083, 16084, 16085, 16086, 16087, 16088, 16090, 16091, 16093, 16095, 16096, 16099, 16100, 16101, 16102, 16103, 16104, 16105, 16106, 16107, 16108, 16109, 16110, 16111, 16112, 16113, 16114, 16115, 16116, 16117, 16118, 16119, 16120, 16121, 16122, 16123, 16124, 16125, 16126, 16127, 16128, 16129, 16130, 16131, 16132, 16133, 16134, 16135, 16136, 16137, 16138, 16139, 16140, 16141, 16142, 16143, 16144, 16145, 16146, 16147, 16148, 16149, 16150, 16151, 16152, 16153, 16154, 16155, 16156, 16157, 16158, 16159, 16160, 16161, 16162, 16163, 16164, 16165, 16166, 16167, 16168, 16169, 16170, 16171, 16172, 16173, 16174, 16175, 16176, 16177, 16178, 16179, 16180, 16181, 16182, 16183, 16184, 16185, 16186, 16187, 16188, 16189, 16190, 16191, 16192, 16193, 16194, 16195, 16196, 16197, 16198, 16199, 16200, 16201, 16202, 16203, 16204, 16205, 16206, 16207, 16208, 16209, 16210, 16211, 16212, 16213, 16214, 16215, 16216, 16217, 16218, 16219, 16220, 16221, 16222, 16223, 16224, 16225, 16226, 16227, 16228, 16229, 16230, 16231, 16232, 16233, 16234, 16235, 16236, 16237, 16238, 16239, 16240, 16241, 16242, 16243, 16244, 16245, 16246, 16247, 16248, 16249, 16250, 16251, 16252, 16253, 16254, 16255, 16256, 16257, 16258, 16259, 16260, 16261, 16262, 16263, 16264, 16265, 16266, 16267, 16268, 16269, 16270, 16271, 16272, 16273, 16274, 16275, 16276, 16277, 16278, 16279, 16280, 16281, 16282, 16283, 16284, 16285, 16286, 16287, 16288, 16292, 16296, 16299, 16301, 16304, 16307, 16308, 16310, 16311, 16313, 16314, 16315, 16316, 16317, 16318, 16319, 16320, 16321, 16322, 16323, 16324, 16325, 16326, 16327, 16328, 16329, 16330, 16331, 16332, 16333, 16334, 16335, 16336, 16337, 16338, 16339, 16340, 16341, 16342, 16343, 16344, 16345, 16346, 16347, 16348, 16349, 16350, 16351, 16352, 16353, 16354, 16355, 16356, 16357, 16358, 16359, 16360, 16361, 16362, 16363, 16364, 16365, 16366, 16367, 16368, 16369, 16370, 16371, 16372, 16373, 16379, 16458, 16460, 16462, 16463, 16464, 16465, 16466, 16467, 16468, 16470, 16471, 16473, 16474, 16475, 16476, 16477, 16479, 16480, 16481, 16483, 16485, 16486, 16487, 16491, 16493, 16494, 16495, 16497, 16501, 16503, 16504, 16505, 16513, 16514, 16515, 16520, 16522, 16523, 16537, 16539, 16540, 16541, 16542, 16543, 16544, 16570, 16573, 16574, 16576, 16581, 16582, 16583, 16626, 16630, 16631, 16648, 16649, 16650, 16651, 16652, 16653, 16655, 16657, 16658, 16659, 16661, 16664, 16665, 16671, 16672, 16673, 16676, 16678, 16680, 16681, 16682, 16684, 16685, 16695, 16697, 16699, 16700, 16701, 16702, 16703, 16704, 16706, 16717, 16718, 16720, 16721, 16722, 16723, 16725, 16729, 16730, 16731, 16733, 16734, 16735, 16737, 16739, 16742, 16743, 16744, 16746, 16747, 16748, 16749, 16750, 16751, 16752, 16753, 16754, 16755, 16756, 16757, 16758, 16759, 16760, 16761, 16762, 16763, 16764, 16765, 16766, 16767, 16768, 16769, 16770, 16771, 16772, 16773, 16774, 16775, 16776, 16777, 16778, 16779, 16781, 16782, 16783, 16784, 16785, 16786, 16787, 16788, 16789, 16790, 16791, 16792, 16793, 16794, 16795, 16796, 16797, 16798, 16799, 16800, 16801, 16802, 16803, 16804, 16805, 16806, 16807, 16808, 16809, 16810, 16811, 16812, 16813, 16814, 16815, 16816, 16817, 16818, 16819, 16820, 16821, 16822, 16823, 16824, 16825, 16826, 16827, 16828, 16829, 16830, 16831, 16832, 16833, 16834, 16835, 16836, 16837, 16838, 16839, 16840, 16841, 16842, 16843, 16844, 16845, 16846, 16847, 16848, 16849, 16850, 16851, 16852, 16853, 16854, 16855, 16856, 16857, 16858, 16859, 16860, 16861, 16862, 16863, 16864, 16865, 16866, 16867, 16868, 16869, 16870, 16871, 16872, 16873, 16874, 16875, 16876, 16877, 16878, 16879, 16880, 16881, 16882, 16883, 16884, 16885, 16886, 16887, 16888, 16889, 16890, 16891, 16892, 16893, 16894, 16895, 16896, 16897, 16898, 16899, 16900, 16901, 16902, 16903, 16904, 16905, 16906, 16907, 16908, 16909, 16910, 16911, 16912, 16913, 16914, 16915, 16916, 16917, 16918, 16919, 16920, 16921, 16922, 16923, 16924, 16925, 16926, 16927, 16928, 16929, 16930, 16931, 16932, 16933, 16934, 16935, 16936, 16937, 16938, 16939, 16940, 16941, 16942, 16943, 16944, 16945, 16946, 16947, 16948, 16949, 16950, 16951, 16952, 16953, 16954, 16955, 16956, 16957, 16958, 16959, 16960, 16961, 16962, 16963, 16964, 16965, 16966, 16967, 16968, 16969, 16970, 16971, 16972, 16976, 16982, 16983, 16986, 16987, 16988, 16990, 16991, 16992, 16993, 16994, 16995, 16996, 16997, 16999, 17000, 17003, 17007, 17008, 17009, 17010, 17011, 17012, 17013, 17015, 17016, 17020, 17021, 17022, 17023, 17024, 17025, 17027, 17028, 17029, 17031, 17032, 17033, 17034, 17035, 17036, 17037, 17038, 17039, 17040, 17041, 17042, 17043, 17044, 17045, 17046, 17047, 17048, 17051, 17052, 17053, 17054, 17055, 17056, 17057, 17058, 17059, 17060, 17061, 17064, 17065, 17066, 17067, 17068, 17070, 17071, 17073, 17074, 17075, 17076, 17077, 17078, 17082, 17087, 17088, 17089, 17090, 17091, 17094, 17095, 17096, 17097, 17098, 17099, 17100, 17101, 17102, 17103, 17104, 17105, 17106, 17107, 17108, 17109, 17111, 17112, 17113, 17114, 17116, 17117, 17118, 17119, 17120, 17121, 17122, 17123, 17124, 17125, 17126, 17127, 17128, 17129, 17130, 17131, 17132, 17133, 17134, 17144, 17146, 17147, 17148, 17152, 17155, 17156, 17157, 17161, 17163, 17164, 17176, 17185, 17187, 17200, 17212, 17226, 17228, 17229, 17230, 17231, 17232, 17233, 17234, 17235, 17236, 17237, 17238, 17239, 17240, 17241, 17242, 17243, 17245, 17246, 17247, 17248, 17249, 17250, 17251, 17252, 17253, 17254, 17255, 17257, 17258, 17260, 17261, 17262, 17263, 17264];

        $arr = [17213, 17214, 17215, 17216, 17217, 17218, 17219, 17220, 17221, 17222, 17223, 17224, 17225, 17244, 17259, 17291, 17292, 17295, 17298, 17300, 17303, 17304, 17306, 17307, 17308, 17310, 17311, 17312, 17314, 17315, 17322, 17323, 17471, 17472, 17473, 17474, 17475, 17476, 17477, 17478, 17479, 17480, 17481, 17482, 17483, 17484, 17485, 17486, 17487, 17488, 17489, 17490, 17491, 17492, 17493, 17494, 17495, 17496, 17497, 17498, 17499, 17500, 17501, 17502, 17503, 17504, 17505, 17506, 17507, 17508, 17509, 17510, 17511, 17512, 17513, 17514, 17515, 17516, 17517, 17518, 17519, 17520, 17521, 17522, 17523, 17524, 17525, 17526, 17527, 17528, 17529, 17530, 17531, 17532, 17533, 17534, 17535, 17536, 17537, 17538, 17539, 17540, 17541, 17542, 17543, 17544, 17545, 17546, 17547, 17548, 17549, 17550, 17551, 17552, 17553, 17554, 17555, 17556, 17557, 17558, 17559, 17560, 17561, 17562, 17563, 17564, 17565, 17566, 17567, 17568, 17569, 17570, 17571, 17572, 17573, 17574, 17575, 17576, 17577, 17578, 17579, 17580, 17581, 17582, 17583, 17584, 17585, 17586, 17587, 17588, 17589, 17590, 17591, 17592, 17593, 17594, 17595, 17596, 17597, 17598, 17599, 17600, 17601, 17602, 17603, 17604, 17605, 17606, 17607, 17608, 17609, 17610, 17611, 17612, 17613, 17614, 17615, 17616, 17617, 17618, 17619, 17620, 17621, 17622, 17623, 17624, 17625, 17626, 17627, 17628, 17629, 17630, 17631, 17632, 17633, 17634, 17635, 17636, 17637, 17638, 17639, 17640, 17641, 17642, 17643, 17644, 17645, 17646, 17647, 17648, 17649, 17650, 17651, 17652, 17653, 17654, 17655, 17656, 17657, 17658, 17659, 17660, 17661, 17662, 17663, 17664, 17665, 17666, 17667, 17668, 17669, 17670, 17671, 17672, 17673, 17674, 17675, 17676, 17677, 17678, 17679, 17680, 17681, 17682, 17683, 17684, 17685, 17686, 17687, 17688, 17689, 17690, 17691, 17692, 17693, 17694, 17695, 17696, 17697, 17698, 17699, 17701, 17702, 17703, 17704, 17705, 17706, 17707, 17708, 17709, 17710, 17711, 17712, 17713, 17714, 17715, 17716, 17717, 17718, 17719, 17720, 17721, 17722, 17723, 17724, 17725, 17726, 17727, 17728, 17729, 17730, 17731, 17732, 17733, 17734, 17735, 17736, 17737, 17738, 17739, 17740, 17741];

        // $arr = [15710, 15711];
        // $arr = [15383];
        for($i=0; $i<count($arr); $i++) {
            $this->distributor_out_model->save_approved_data($arr[$i]);
        }
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

    public function view_tax_invoice_test($id){
        $this->tax_invoice_model->generate_tax_invoice_test($id);
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