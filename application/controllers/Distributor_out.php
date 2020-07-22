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

        $result = $this->distributor_out_model->get_list_data($status, $start, $length, $search_val);
        // echo json_encode($result);
        // echo '<br/><br/>';

        $totalRecords = 0;
        $count = $result['count'];
        if(count($count)>0) $totalRecords = $count[0]->total_records;

        $r = $result['rows'];

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
                            $i+$start+1,
                            

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

                            $i+$start+1,
                            

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
                        "recordsTotal" => $totalRecords,
                        "recordsFiltered" => $totalRecords,
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

            if($status=="Approved") $selectedstatus='Approved';
            else if($status=="pending") $selectedstatus='Pending';
            else if($status=="pending_for_approval") $selectedstatus='Approval Pending';
            else if($status=="InActive") $selectedstatus='Cancelled';
            else if($status=="pending_for_delivery") $selectedstatus='Delivery Pending';
            else if($status=="gp_issued") $selectedstatus='GP Issued';
            else if($status=="delivered_not_complete") $selectedstatus="InComplete";
            else $selectedstatus=$status;

            // $data['data']=$this->distributor_out_model->get_distributor_out_data1($status);
            // $count_data=$this->distributor_out_model->get_distributor_out_data1();
            
            // $data['data']=$this->distributor_out_model->get_list_data($status);

            $count_data = array();
            $count_data=$this->distributor_out_model->get_data_count();
			
            $total_count=0;
            $active=0;
            $inactive=0;
            $pending=0;
            $pending_for_approval=0;
            $pending_for_delivery=0;
            $gp_issued=0;
            $delivered_not_complete=0;

            if (count($count_data)>0){
                $total_count=$count_data[0]->total_count;
                $active=$count_data[0]->active;
                $inactive=$count_data[0]->inactive;
                $pending=$count_data[0]->pending;
                $pending_for_approval=$count_data[0]->pending_for_approval;
                $pending_for_delivery=$count_data[0]->pending_for_delivery;
                $gp_issued=$count_data[0]->gp_issued;
                $delivered_not_complete=$count_data[0]->delivered_not_complete;
            }
			
            // if (count($result)>0){
            //     for($i=0;$i<count($count_data);$i++){
            //         if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
            //             $active=$active+1;
						
            //         if ((strtoupper(trim($count_data[$i]->status))=="PENDING" && 
            //             (strtoupper(trim($count_data[$i]->delivery_status))=="PENDING" || 
            //                 strtoupper(trim($count_data[$i]->delivery_status))=="GP ISSUED" || 
            //                 strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED NOT COMPLETE" || 
            //                 strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED")) || 
            //             strtoupper(trim($count_data[$i]->status))=="DELETED")
            //             $pending_for_approval=$pending_for_approval+1;
						
            //         else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && 
            //                     (strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED" || $count_data[$i]->delivery_status==null))
            //             // $active=$active+1;
            //             $active=$active;
            //         else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
            //             $inactive=$inactive+1;
					
            //         else if (strtoupper(trim($count_data[$i]->status))=="PENDING" && 
            //                     ($count_data[$i]->delivery_status==null || $count_data[$i]->delivery_status==''))
            //             $pending=$pending+1;
						
            //         else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_status))=="PENDING")
            //             $pending_for_delivery=$pending_for_delivery+1;
					
            //         else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_status))=="GP ISSUED")
            //             $gp_issued=$gp_issued+1;
					
            //         else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED NOT COMPLETE")
            //             $delivered_not_complete=$delivered_not_complete+1;
					
            //     }
            // }

            $data['status']=$status;
			$data['selectedstatus']=$selectedstatus;
            $data['all']=$total_count;
            $data['active']=$active;
            $data['inactive']=$inactive;
            $data['pending']=$pending;
            $data['pending_for_approval']=$pending_for_approval;
            $data['pending_for_delivery']=$pending_for_delivery;
            $data['gp_issued']=$gp_issued;
            $data['delivered_not_complete']=$delivered_not_complete;

            // $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');

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

    public function common_excel($objValidation){
        $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
        $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
        $objValidation->setAllowBlank(false);
        $objValidation->setShowInputMessage(true);
        $objValidation->setShowErrorMessage(true);
        $objValidation->setShowDropDown(true);
        $objValidation->setErrorTitle('Input error');
        $objValidation->setError('Value is not in list.');
        $objValidation->setPromptTitle('Pick from list');
        $objValidation->setPrompt('Please pick a value from the drop-down list.');/*
        $objValidation->setFormula1('"'.$distname.'"');*/
    }

    public function download_sales_data($status){
        $data = $this->distributor_out_model->get_sales_item_data($status);

        if(count($data)>0){
            $this->load->library('excel');

            $objPHPExcel = new PHPExcel();

            // Set properties
            $objPHPExcel->getProperties()->setCreator("OTB Innovtech")
                             ->setLastModifiedBy("OTB Innovtech")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

            $objPHPExcel->setActiveSheetIndex(0);

            $sheetCount = $objPHPExcel->getSheetCount();
            if($sheetCount<2){
                $objPHPExcel->createSheet();
            }
            $objPHPExcel->setActiveSheetIndex(1);
            // $sht_name = $objPHPExcel->getActiveSheet()->getTitle();
            $sht_name = 'Sheet2';
            $objPHPExcel->getActiveSheet()->setTitle($sht_name);

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Batch No');
            $row = 2;
            $date = date("Y-m-d", strtotime("-9 months"));
            $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
            $result  = $this->db->query($sql)->result();
            foreach($result  as $dist) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $dist->batch_no);
                $row = $row+1;
            }
            $batch_cnt = $row;

            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Sales Rep');
            $row = 2;
            $sql = "select * from sales_rep_master where sr_type='Merchandizer'";
            $result  = $this->db->query($sql)->result();
            foreach($result  as $dist) {
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dist->sales_rep_name);
                $row = $row+1;
            }
            $sales_rep_cnt = $row;

            $col_name[]=array();
            for($i=0; $i<=20; $i++) {
                $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
            }

            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

            $row=1;
            $col=0;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Id');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Sales Id');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Date Of Processing');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Distributor Name');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Location');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Item Name');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Qty');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Date Of Dispatch');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Delivery Person');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Tracking Id');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Batch No');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Batch Qty');

            for($i=0; $i<count($data); $i++) {
                $row=$row+1;
                $col=0;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->sales_item_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, date('d-m-Y', strtotime($data[$i]->date_of_processing)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->distributor_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->item_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->qty);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, '');

                $objValidation = $objPHPExcel->getActiveSheet()->getCell($col_name[$col++].$row)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('='.$sht_name.'!$C$2:$C$'.($sales_rep_cnt-1));

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, '');

                $objValidation = $objPHPExcel->getActiveSheet()->getCell($col_name[$col++].$row)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('='.$sht_name.'!$A$2:$A$'.($batch_cnt-1));

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, '');

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, '');
            }

            $objPHPExcel->getActiveSheet()->freezePane('A2');
            $objPHPExcel->getActiveSheet()->getStyle('C2:C'.$row)->getNumberFormat()->setFormatCode('dd-mm-yyyy');

            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
            for($col = 'H'; $col !== 'M'; $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }

            // $objPHPExcel->getActiveSheet()->protectCells('A1:F'.$row, 'php');
            // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);

            // $objPHPExcel->getActiveSheet()->getProtection()->setPassword('php');
            // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
            // $objPHPExcel->getActiveSheet()->getStyle('H2:M'.$row)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

            $objPHPExcel->getSheet(1)->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);

            $filename='sales_dispatch_upload_format.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('success', 'No data found.');
            $this->session->keep_flashdata('success');
        }
        
        redirect(base_url().'index.php/distributor_out/checkstatus/'.$status);
    }

    public function upload_file(){
        $now=date('Y-m-d H:i:s');
        $curdate=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');

        $upload_path=$this->config->item('upload_path');
        $path=$upload_path.'sales_dispatch_upload/';
        $config = array(
            'upload_path' => $path,
            'allowed_types' => "xlsx",
            'overwrite' => TRUE,
            'max_size' => "2048000", 
            'max_height' => "768",
            'max_width' => "1024"
        );

        $file_name = $_FILES["upload"]['name'];
        if(strrpos($file_name, '.')>0){
            $file_ext = substr($file_name, strrpos($file_name, '.'));
        } else {
            $file_ext = '.xlsx';
        }
        $file_name = substr($file_name, 0, strrpos($file_name, '.'));
        $file_name = str_replace(' ', "_", $file_name);
        $file_name = preg_replace('/[^A-Za-z0-9_\-]/', '', $file_name);
        $new_name = time().'_'.$file_name.$file_ext;

        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload')){ 
            $this->upload->display_errors();
        } else {
            $uploadDetailArray = $this->upload->data();
        }

        $file_name = $uploadDetailArray['file_name'];
        // print_r($file_name); echo '<br/><br/>';
        $filename = $path.$uploadDetailArray['file_name'];
        // $this->upload_file_data($filename);
        // print_r($filename);
        // echo '<br/><br/>';
        // $filename = str_replace('/', '\\', $filename);
        // print_r($filename);
        // exit;

        $this->upload_file_data($filename);

        // $sql = "insert into sales_upload_files (file_name, file_path, upload_date, status, created_by, created_on, modified_by, modified_on) VALUES ('".$file_name."', '".$path."', '".$curdate."', 'Uploading', '".$curusr."', '".$now."', '".$curusr."', '".$now."')";
        // $this->db->query($sql);
        // // $file_id = $this->db->insert_id();

        // sleep(0.50);

        // $this->session->set_flashdata('success', 'File Upload Succeded.<br/>Please upload file data.');
        // $this->session->keep_flashdata('success');
        // redirect(base_url().'index.php/Sales_upload');
    }

    public function upload_file_data($filename){
        try{
            $now=date('Y-m-d H:i:s');
            $curdate=date('Y-m-d');
            $curusr=$this->session->userdata('session_id');

            // $sql = "select * from sales_upload_files where id='$file_id'";
            // $result = $this->db->query($sql)->result();
            // if(count($result)>0){
            //     $file_path = $result[0]->file_path;
            //     $file_name = $result[0]->file_name;
            //     $filename = $result[0]->file_path.$result[0]->file_name;
            // } else {
            //     $file_path = '';
            //     $file_name = '';
            //     $filename = '';
            // }

            if($filename!=''){
                if(strpos($filename, '/')===false){
                    $this->session->set_flashdata('error', 'File not found');
                    $this->session->keep_flashdata('error');
                    exit;
                }
                $file_path = substr($filename, 0, strrpos($filename, '/'));
                $file_name = substr($filename, strrpos($filename, '/')+1);
            }

            // echo $file_name;
            // echo '<br/><br/>';

            $this->load->library('excel');

            // echo 'Loaded';
            // echo '<br/><br/>';
            
            $objPHPExcel = PHPExcel_IOFactory::load($filename);
            $objPHPExcel->setActiveSheetIndex(0);
            $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Error Remark');
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
            $objerror = 0;
            $error_line = '';
            $order_array = [];
            $sales_id_array = [];

            for($i=2; $i<=$highestrow; $i++){
                $sales_item_id = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                $sales_id = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $qty = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                $date_of_dispatch = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $delivery_person = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                $tracking_id = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                $batch_no = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
                $batch_qty = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();

                $qty = round(doubleval($qty),2);
                
                $error = '';
                $sales_rep_id = '';
                $batch_id = '';

                if($sales_item_id==''){
                    continue;
                }

                if(isset($order_array[$sales_id])){
                    $cnt = count($order_array[$sales_id]);
                } else {
                    $cnt = 0;
                    $sales_id_array[] = $sales_id;
                }

                $order_array[$sales_id][$cnt] = array('sales_item_id'=>$sales_item_id,
                                                    'qty'=>$qty, 
                                                    'date_of_dispatch'=>$date_of_dispatch, 
                                                    'delivery_person'=>$delivery_person, 
                                                    'tracking_id'=>$tracking_id, 
                                                    'batch_no'=>$batch_no, 
                                                    'batch_qty'=>$batch_qty,
                                                    'sales_rep_id'=>$sales_rep_id,
                                                    'batch_id'=>'',
                                                    'batch_id_text'=>'',
                                                    'batch_qty_text'=>'',
                                                    'total_batch_qty'=>'');

                //-------------- Validation Start ------------------------------
                    $bl_error_line = false;
                    $bl_empty = false;
                    $bl_not_empty = false;

                    if($date_of_dispatch==''){
                        $bl_empty = true;
                    } else {
                        $bl_not_empty = true;
                    }
                    if($delivery_person==''){
                        $bl_empty = true;
                    } else {
                        $bl_not_empty = true;
                    }
                    if($tracking_id==''){
                        $bl_empty = true;
                    } else {
                        $bl_not_empty = true;
                    }
                    if($batch_no==''){
                        $bl_empty = true;
                    } else {
                        $bl_not_empty = true;
                    }
                    if($batch_qty==''){
                        $bl_empty = true;
                    } else {
                        $bl_not_empty = true;
                    }

                    if($bl_empty==true && $bl_not_empty==false){
                        continue;
                    } else if($bl_empty==true && $bl_not_empty==true) {
                        $error.='All values should be filled.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }

                    if($sales_item_id==''){
                        $error.='Id cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $sql = "select * from distributor_out_items where id='$sales_item_id' and distributor_out_id='$sales_id'";
                        $result = $this->db->query($sql)->result();
                        if(count($result)==0){
                            $error.='Id '.$sales_item_id.' not found.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        } else {
                            $qty2 = round(doubleval($result[0]->qty),2);
                            if($qty2!=$qty){
                                $error.='Quantity is different from atcual qty.';
                                $objerror=1;
                                if($bl_error_line==false){
                                    $error_line.=$i.', ';
                                    $bl_error_line=true;
                                }
                            }
                        }
                    }
                    if($sales_id==''){
                        $error.='Sales Id cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $sql = "select * from distributor_out where id='$sales_id'";
                        $result = $this->db->query($sql)->result();
                        if(count($result)==0){
                            $error.='Sales Id '.$sales_id.' not found.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        } else {
                            $delivery_status = $result[0]->delivery_status;
                            if(strtoupper(trim($delivery_status))!='PENDING'){
                                $error.='Sales Delivery status should be pending.';
                                $objerror=1;
                                if($bl_error_line==false){
                                    $error_line.=$i.', ';
                                    $bl_error_line=true;
                                }
                            }
                        }
                    }
                    if($date_of_dispatch==''){
                        $error.='Date Of Dispatch cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $date_of_dispatch = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($date_of_dispatch));
                        if(validateDate($date_of_dispatch, 'Y-m-d')==false){
                            $error.='Date Of Dispatch should be in d-m-Y format.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        }
                    }
                    if($delivery_person==''){
                        $error.='Delivery Person cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $sql = "select * from sales_rep_master where sales_rep_name='$delivery_person'";
                        $result = $this->db->query($sql)->result();
                        if(count($result)==0){
                            $error.='Delivery Person '.$delivery_person.' not found.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        } else {
                            $sales_rep_id = $result[0]->id;
                        }
                    }
                    if($tracking_id==''){
                        $error.='Tracking Id cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }
                    if($batch_qty==''){
                        $error.='Batch Qty cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else if($batch_qty<=0) {
                        $error.='Batch Qty should be greater than zero.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $batch_qty = round(doubleval($batch_qty),2);
                    }
                    $qty = round(doubleval($qty),2);
                    if($batch_qty>$qty){
                        $error.='Batch Qty should be less than SKU Qty.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }
                    if($batch_no==''){
                        $error.='Batch No cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $sql = "select * from batch_master where batch_no='$batch_no'";
                        $result = $this->db->query($sql)->result();
                        if(count($result)==0){
                            $error.='Batch No '.$batch_no.' not found.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        } else {
                            $batch_id = $result[0]->id;
                        }
                    }

                    $arr = $order_array[$sales_id][$cnt];
                    $arr['date_of_dispatch'] = $date_of_dispatch;
                    $arr['qty'] = $qty;
                    $arr['batch_qty'] = $batch_qty;
                    $arr['sales_rep_id'] = $sales_rep_id;
                    $arr['batch_id'] = $batch_id;
                    $arr['batch_id_text'] = $batch_id;
                    $arr['batch_qty_text'] = $batch_qty;
                    $arr['total_batch_qty'] = $batch_qty;

                    $batch_id_text = $batch_id;
                    $total_batch_qty = $batch_qty;
                    $batch_qty_text = $batch_qty;

                    for($j=0; $j<count($order_array[$sales_id]); $j++){
                        if($j!=$cnt){
                            $arr2 = $order_array[$sales_id][$j];

                            if($arr2['date_of_dispatch']=='' || $arr2['delivery_person']=='' || $arr2['tracking_id']=='' || $arr2['batch_no']=='' || $arr2['batch_qty']==''){
                                if(strpos($error, 'Enter values for all items of particular order.')===false){
                                    $error.='Enter values for all items of particular order.';
                                    $objerror=1;
                                    if($bl_error_line==false){
                                        $error_line.=$i.', ';
                                        $bl_error_line=true;
                                    }
                                }
                            }

                            if($arr2['sales_item_id']==$sales_item_id){
                                $arr2['total_batch_qty'] = round(doubleval($arr2['total_batch_qty']),2)+$batch_qty;
                                $arr2['batch_id_text'] = $arr2['batch_id_text'].', '.$batch_id;
                                $arr2['batch_qty_text'] = $arr2['batch_qty_text'].', '.$batch_qty;

                                $order_array[$sales_id][$j] = $arr2;

                                $batch_id_text = $arr2['batch_id_text'];
                                $batch_qty_text = $arr2['batch_qty_text'];
                                $total_batch_qty = $total_batch_qty + round(doubleval($arr2['batch_qty']),2);
                            }
                        }
                    }

                    if($qty<$total_batch_qty){
                        $error.='Total batch qty should not greater than qty.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }

                    $arr['batch_id_text'] = $batch_id_text;
                    $arr['batch_qty_text'] = $batch_qty_text;
                    $arr['total_batch_qty'] = $total_batch_qty;

                    $order_array[$sales_id][$cnt] = $arr;

                    if($error!=""){
                        $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $error);
                        // $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getAlignment()->setWrapText(false);  
                    }
                //-------------- Validation End ------------------------------
            }

            if($objerror!=1){
                for($i=2; $i<=$highestrow; $i++){
                    $sales_item_id = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                    $sales_id = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                    $qty = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                    $date_of_dispatch = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                    $error = '';

                    if($date_of_dispatch!=''){
                        $qty = round(doubleval($qty),2);

                        if(isset($order_array[$sales_id])){
                            for($j=0; $j<count($order_array[$sales_id]); $j++){
                                $arr2 = $order_array[$sales_id][$j];

                                if($arr2['sales_item_id']!=$sales_item_id){
                                    if($arr2['date_of_dispatch']=='' || $arr2['delivery_person']=='' || $arr2['tracking_id']=='' || $arr2['batch_no']=='' || $arr2['batch_qty']==''){
                                        if(strpos($error, 'Enter values for all items of particular order.')===false){
                                            $error.='Enter values for all items of particular order.';
                                            $objerror=1;
                                            if($bl_error_line==false){
                                                $error_line.=$i.', ';
                                                $bl_error_line=true;
                                            }
                                        }
                                    }
                                }
                                

                                if($arr2['sales_item_id']==$sales_item_id){
                                    $total_batch_qty = round(doubleval($arr2['total_batch_qty']),2);
                                    if($total_batch_qty!=$qty){
                                        $error='Total batch qty should be equal to qty.';
                                        $objerror=1;
                                        if($bl_error_line==false){
                                            $error_line.=$i.', ';
                                            $bl_error_line=true;
                                        }
                                    }
                                } 
                            }
                        }
                        if($error!=""){
                            $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $error);
                        }
                    }
                }
            }

            if($objerror==1){
                $upload_path=$this->config->item('upload_path');
                $path=$upload_path.'sales_dispatch_upload/';
                if(strrpos($file_name, '.')>0){
                    $ext = substr($file_name, strrpos($file_name, '.'));
                } else {
                    $ext = '.xlsx';
                }

                $error_file_path = $path;
                $error_file_name = time().'_sales_dispatch_upload_file_error'.$ext;
                $status = 'Error';
                // $remarks = 'There are errors in file on line '.$error_line.'. <br/>Please check - '.$error_file_name;
                $remarks = 'Please check - '.$error_file_name.' file for errors.<br/>
                            <a href="'.base_url().'assets/uploads/sales_dispatch_upload/'.$error_file_name.'" style="color:lime; text-decoration: underline;">Click Here</a> to download error file.';

                // echo $remarks;
                // echo '<br/><br/>';

                // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                // header('Content-Disposition: attachment;filename="'.$error_file_name.'"');
                // header('Cache-Control: max-age=0');
                // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                // $objWriter->save('php://output');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save($error_file_path.$error_file_name);
            
                sleep(0.50);

                $this->session->set_flashdata('error', $remarks);
                $this->session->keep_flashdata('error');
            } else {
                $success_cnt = 0;

                // echo '<pre>'; print_r($sales_id_array); echo '</pre><br/><br/>';
                // echo '<pre>'; print_r($order_array); echo '</pre><br/><br/>';

                for($i=0; $i<count($sales_id_array); $i++){
                    $sales_id = $sales_id_array[$i];

                    if(count($order_array[$sales_id])>0){
                        $arr = $order_array[$sales_id][0];

                        if($arr['batch_id']!=''){
                            for($j=0; $j<count($order_array[$sales_id]); $j++){
                                $arr = $order_array[$sales_id][$j];
                                $item_id = $arr['sales_item_id'];
                                $batch_id_text = $arr['batch_id_text'];
                                $batch_qty_text = $arr['batch_qty_text'];

                                $sql = "update distributor_out_items set batch_no = '$batch_id_text', batch_qty = '$batch_qty_text' where id = '$item_id'";
                                // echo $sql;
                                // echo '<br/><br/>';
                                $this->db->query($sql);

                                $success_cnt = $success_cnt + 1;
                            }

                            $delivery_status = 'GP Issued';
                            $sales_rep_id = $arr['sales_rep_id'];
                            $tracking_id = $arr['tracking_id'];
                            $date_of_dispatch = $arr['date_of_dispatch'];

                            $sql = "update distributor_out set delivery_status = '$delivery_status', delivery_sales_rep_id = '$sales_rep_id', tracking_id='$tracking_id', modified_by = '$curusr', modified_on = '$now', gatepass_date = '$now', date_of_dispatch='$date_of_dispatch' where id in (".$sales_id.")";
                            // echo $sql;
                            // echo '<br/><br/>';
                            $this->db->query($sql);

                            // $this->tax_invoice_model->generate_gate_pass($sales_id);
                        }
                    }
                }

                $remarks = 'No of records uploaded - '.$success_cnt;

                // echo $remarks;
                // echo '<br/><br/>';

                $this->session->set_flashdata('success', $remarks);
                $this->session->keep_flashdata('success');
            }

            // echo $remarks;

            redirect(base_url().'index.php/Distributor_out/checkstatus/pending_for_delivery');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function download_pending_sales_data($status){
        $data = $this->distributor_out_model->get_pending_sales_data($status);

        if(count($data)>0){
            $this->load->library('excel');

            $objPHPExcel = new PHPExcel();

            // Set properties
            $objPHPExcel->getProperties()->setCreator("OTB Innovtech")
                             ->setLastModifiedBy("OTB Innovtech")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

            $objPHPExcel->setActiveSheetIndex(0);

            $sheetCount = $objPHPExcel->getSheetCount();
            if($sheetCount<2){
                $objPHPExcel->createSheet();
            }
            $objPHPExcel->setActiveSheetIndex(1);
            // $sht_name = $objPHPExcel->getActiveSheet()->getTitle();
            $sht_name = 'Sheet2';
            $objPHPExcel->getActiveSheet()->setTitle($sht_name);

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Delivery Status');
            $row = 2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row++, 'Pending');
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row++, 'GP Issued');
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row++, 'Delivered Not Complete');
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row++, 'Delivered');
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row++, 'Cancelled');
            $delivery_status_cnt = $row;

            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Status');
            $row = 2;
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row++, 'Approved');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row++, 'Rejected');
            $status_cnt = $row;

            $col_name[]=array();
            for($i=0; $i<=20; $i++) {
                $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
            }

            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');

            $row=1;
            $col=0;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Id');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Date Of Processing');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Distributor Name');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Depot Name');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Invoice Amount');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Delivery Status');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, 'Status');

            for($i=0; $i<count($data); $i++) {
                $row=$row+1;
                $col=0;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, date('d-m-Y', strtotime($data[$i]->date_of_processing)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->distributor_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->depot_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->invoice_amount);

                $objValidation = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].$row)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('='.$sht_name.'!$A$2:$A$'.($delivery_status_cnt));

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->delivery_status);

                $objValidation = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].$row)->getDataValidation();
                $this->common_excel($objValidation);
                $objValidation->setFormula1('='.$sht_name.'!$C$2:$C$'.($status_cnt));

                // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col++].$row, $data[$i]->status);
            }

            $objPHPExcel->getActiveSheet()->freezePane('A2');

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(16);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            for($col='E'; $col!=='H'; $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }

            // $objPHPExcel->getActiveSheet()->protectCells('A1:F'.$row, 'php');
            // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);

            // $objPHPExcel->getActiveSheet()->getProtection()->setPassword('php');
            // $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
            // $objPHPExcel->getActiveSheet()->getStyle('H2:M'.$row)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

            $objPHPExcel->getSheet(1)->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);

            $filename='pending_sales_data_upload_format.xlsx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        } else {
            $this->session->set_flashdata('success', 'No data found.');
            $this->session->keep_flashdata('success');
        }
        
        redirect(base_url().'index.php/distributor_out/checkstatus/'.$status);
    }

    public function upload_pending_sales_data_file(){
        $now=date('Y-m-d H:i:s');
        $curdate=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');

        $upload_path=$this->config->item('upload_path');
        $path=$upload_path.'pending_sales_data_upload/';
        if(!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        $config = array(
            'upload_path' => $path,
            'allowed_types' => "xlsx",
            'overwrite' => TRUE,
            'max_size' => "2048000", 
            'max_height' => "768",
            'max_width' => "1024"
        );

        $file_name = $_FILES["upload"]['name'];
        if(strrpos($file_name, '.')>0){
            $file_ext = substr($file_name, strrpos($file_name, '.'));
        } else {
            $file_ext = '.xlsx';
        }
        $file_name = substr($file_name, 0, strrpos($file_name, '.'));
        $file_name = str_replace(' ', "_", $file_name);
        $file_name = preg_replace('/[^A-Za-z0-9_\-]/', '', $file_name);
        $new_name = time().'_'.$file_name.$file_ext;

        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload')){ 
            $this->upload->display_errors();
        } else {
            $uploadDetailArray = $this->upload->data();
        }

        $file_name = $uploadDetailArray['file_name'];
        // print_r($file_name); echo '<br/><br/>';
        $filename = $path.$uploadDetailArray['file_name'];
        // $this->upload_file_data($filename);
        // print_r($filename);
        // echo '<br/><br/>';
        // $filename = str_replace('/', '\\', $filename);
        // print_r($filename);
        // exit;

        $this->upload_pending_sales_data($filename);

        // $sql = "insert into sales_upload_files (file_name, file_path, upload_date, status, created_by, created_on, modified_by, modified_on) VALUES ('".$file_name."', '".$path."', '".$curdate."', 'Uploading', '".$curusr."', '".$now."', '".$curusr."', '".$now."')";
        // $this->db->query($sql);
        // // $file_id = $this->db->insert_id();

        // sleep(0.50);

        // $this->session->set_flashdata('success', 'File Upload Succeded.<br/>Please upload file data.');
        // $this->session->keep_flashdata('success');
        // redirect(base_url().'index.php/Sales_upload');
    }

    public function upload_pending_sales_data($filename){
        try{
            $now=date('Y-m-d H:i:s');
            $curdate=date('Y-m-d');
            $curusr=$this->session->userdata('session_id');

            // $sql = "select * from sales_upload_files where id='$file_id'";
            // $result = $this->db->query($sql)->result();
            // if(count($result)>0){
            //     $file_path = $result[0]->file_path;
            //     $file_name = $result[0]->file_name;
            //     $filename = $result[0]->file_path.$result[0]->file_name;
            // } else {
            //     $file_path = '';
            //     $file_name = '';
            //     $filename = '';
            // }

            if($filename!=''){
                if(strpos($filename, '/')===false){
                    $this->session->set_flashdata('error', 'File not found');
                    $this->session->keep_flashdata('error');
                    exit;
                }
                $file_path = substr($filename, 0, strrpos($filename, '/'));
                $file_name = substr($filename, strrpos($filename, '/')+1);
            }

            // echo $file_name;
            // echo '<br/><br/>';

            $this->load->library('excel');

            // echo 'Loaded';
            // echo '<br/><br/>';
            
            $objPHPExcel = PHPExcel_IOFactory::load($filename);
            $objPHPExcel->setActiveSheetIndex(0);
            $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Error Remark');
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $objerror = 0;
            $error_line = '';
            $order_array = [];
            $sales_id_array = [];
            $stock_array = [];
            $row_array = [];
            $product_array = [];

            $sql = "select * from product_master";
            $result = $this->db->query($sql)->result();
            for($i=0; $i<count($result); $i++){
                $product_array['Bar_'.$result[$i]->id] = $result[$i]->product_name;
            }

            $sql = "select * from box_master";
            $result = $this->db->query($sql)->result();
            for($i=0; $i<count($result); $i++){
                $product_array['Box_'.$result[$i]->id] = $result[$i]->box_name;
            }

            for($i=2; $i<=$highestrow; $i++){
                $sales_id = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                $inv_amt = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $delivery_status = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                $status = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();

                $inv_amt = round(doubleval($inv_amt),2);

                $error = '';

                if($sales_id==''){
                    continue;
                }

                if(isset($order_array[$sales_id])){
                    $cnt = count($order_array[$sales_id]);
                } else {
                    $cnt = 0;
                    $sales_id_array[] = $sales_id;
                }

                $order_array[$sales_id] = array('sales_id'=>$sales_id,
                                                'delivery_status'=>$delivery_status, 
                                                'status'=>$status);

                //-------------- Validation Start ------------------------------
                    $bl_error_line = false;
                    $bl_empty = false;
                    $bl_not_empty = false;

                    if($delivery_status==''){
                        $bl_empty = true;
                    } else {
                        $bl_not_empty = true;
                    }
                    if($status==''){
                        $bl_empty = true;
                    } else {
                        $bl_not_empty = true;
                    }

                    if($bl_empty==true && $bl_not_empty==false){
                        continue;
                    } else if($bl_empty==true && $bl_not_empty==true) {
                        $error.='All values should be filled.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }

                    if($sales_id==''){
                        $error.='Sales Id cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $sql = "select * from distributor_out where id='$sales_id'";
                        $result = $this->db->query($sql)->result();
                        if(count($result)==0){
                            $error.='Sales Id '.$sales_id.' not found.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        } else {
                            $invoice_amount = round(doubleval($result[0]->invoice_amount),2);
                            $depot_id = $result[0]->depot_id;
                            $ref_id = $result[0]->ref_id;

                            if($invoice_amount==0){
                                $error.='Invoice amount is zero.';
                                $objerror=1;
                                if($bl_error_line==false){
                                    $error_line.=$i.', ';
                                    $bl_error_line=true;
                                }
                            }
                            if($inv_amt!=$invoice_amount){
                                $error.='Invoice amount does not match.';
                                $objerror=1;
                                if($bl_error_line==false){
                                    $error_line.=$i.', ';
                                    $bl_error_line=true;
                                }
                            }

                            if(strtoupper(trim($result[0]->status))=='APPROVED'){
                                $error.='Sales already approved.';
                                $objerror=1;
                                if($bl_error_line==false){
                                    $error_line.=$i.', ';
                                    $bl_error_line=true;
                                }
                            }

                            if(isset($ref_id)){
                                if($ref_id!=''){
                                    $error.='This is already approved entry. Approve it manually.';
                                    $objerror=1;
                                    if($bl_error_line==false){
                                        $error_line.=$i.', ';
                                        $bl_error_line=true;
                                    }
                                }
                            }

                            $sql = "select * from distributor_out_items where distributor_out_id='$sales_id'";
                            $result = $this->db->query($sql)->result();
                            if(count($result)==0){
                                $error.='Please add sales items.';
                                $objerror=1;
                                if($bl_error_line==false){
                                    $error_line.=$i.', ';
                                    $bl_error_line=true;
                                }
                            } else {
                                if(strtoupper(trim($status))=='APPROVED'){
                                    for($j=0; $j<count($result); $j++){
                                        $type = $result[$j]->type;
                                        $item_id = $result[$j]->item_id;
                                        $qty = $result[$j]->qty;

                                        if(!isset($item_id) || $item_id==0){
                                            $error.='Please select item in all entries.';
                                            $objerror=1;
                                            if($bl_error_line==false){
                                                $error_line.=$i.', ';
                                                $bl_error_line=true;
                                            }
                                        } else {
                                            $bl_found = false;
                                            if(array_key_exists($depot_id, $stock_array)){
                                                if(array_key_exists($type.'_'.$item_id, $stock_array[$depot_id])){
                                                    $bl_found = true;
                                                }
                                            }

                                            if($bl_found==false){
                                                $stock_array[$depot_id][$type.'_'.$item_id] = intval($qty);
                                            } else {
                                                $stock_array[$depot_id][$type.'_'.$item_id] = intval($stock_array[$depot_id][$type.'_'.$item_id]) + intval($qty);
                                            }

                                            if(array_key_exists($type.'_'.$item_id, $row_array)){
                                                $row_array[$type.'_'.$item_id] = $row_array[$type.'_'.$item_id].','.strval($i);
                                            } else {
                                                $row_array[$type.'_'.$item_id] = strval($i);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if($delivery_status==''){
                        $error.='Delivery Status cannot be blank.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }

                    if($error!=""){
                        $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $error);
                        // $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getAlignment()->setWrapText(false);  
                    }

                    // $objPHPExcel->getActiveSheet()->setCellValue('I1', json_encode($stock_array));
                    // $objPHPExcel->getActiveSheet()->setCellValue('J1', json_encode($row_array));

                    foreach ($stock_array as $depot_id => $qty_array) {
                        foreach ($qty_array as $key => $value) {
                            if(strpos($key, '_')!==false) {
                                $item_array = explode('_', $key);
                                $result2 = $this->check_stock($item_array[0], $depot_id, $item_array[1], $value);
                                if($result2){
                                    if(array_key_exists($key, $product_array)) {
                                        $error=$product_array[$key].' Qty is not enough in selected depot.';
                                    } else {
                                        $error=$key.' Qty is not enough in selected depot.';
                                    }
                                    
                                    $objerror=1;

                                    // if($bl_error_line==false){
                                    //     $error_line.=$i.', ';
                                    //     $bl_error_line=true;
                                    // }

                                    if(array_key_exists($key, $row_array)) {
                                        if(strpos($row_array[$key], ',')!==false) {
                                            $row_index_array = explode(',', $row_array[$key]);
                                            foreach ($row_index_array as $row_index) {
                                                $cell_value = $objPHPExcel->getActiveSheet()->getCell('H'.$row_index)->getCalculatedValue();
                                                if($cell_value!=''){
                                                    if(strpos($cell_value, $error)===False){
                                                        $objPHPExcel->getActiveSheet()->setCellValue('H'.$row_index, $cell_value.$error);
                                                    }
                                                } else {
                                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row_index, $error);
                                                    $error_line.=$row_index.', ';
                                                }
                                            }
                                        } else {
                                            $cell_value = $objPHPExcel->getActiveSheet()->getCell('H'.$row_array[$key])->getCalculatedValue();
                                            if($cell_value!=''){
                                                if(strpos($cell_value, $error)===False){
                                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row_array[$key], $cell_value.$error);
                                                }
                                            } else {
                                                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row_array[$key], $error);
                                                $error_line.=$row_index.', ';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                //-------------- Validation End ------------------------------
            }

            if($objerror==1){
                $upload_path=$this->config->item('upload_path');
                $path=$upload_path.'pending_sales_data_upload/';
                if(strrpos($file_name, '.')>0){
                    $ext = substr($file_name, strrpos($file_name, '.'));
                } else {
                    $ext = '.xlsx';
                }

                $error_file_path = $path;
                $error_file_name = time().'_pending_sales_data_upload_file_error'.$ext;
                $status = 'Error';
                // $remarks = 'There are errors in file on line '.$error_line.'. <br/>Please check - '.$error_file_name;
                $remarks = 'Please check - '.$error_file_name.' file for errors.<br/>
                            <a href="'.base_url().'assets/uploads/pending_sales_data_upload/'.$error_file_name.'" style="color:lime; text-decoration: underline;">Click Here</a> to download error file.';

                // echo $remarks;
                // echo '<br/><br/>';

                // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                // header('Content-Disposition: attachment;filename="'.$error_file_name.'"');
                // header('Cache-Control: max-age=0');
                // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                // $objWriter->save('php://output');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save($error_file_path.$error_file_name);
            
                sleep(0.50);

                $this->session->set_flashdata('error', $remarks);
                $this->session->keep_flashdata('error');
            } else {
                $success_cnt = 0;

                // echo '<pre>'; print_r($sales_id_array); echo '</pre><br/><br/>';
                // echo '<pre>'; print_r($order_array); echo '</pre><br/><br/>';

                for($i=0; $i<count($sales_id_array); $i++){
                    $sales_id = $sales_id_array[$i];

                    if(count($order_array[$sales_id])>0){
                        $arr = $order_array[$sales_id];

                        if($arr['delivery_status']!=''){
                            $delivery_status = $arr['delivery_status'];
                            $status = $arr['status'];

                            if(strtoupper(trim($status))=='APPROVED') {
                                $sql = "update distributor_out set delivery_status = '$delivery_status', status = '$status', modified_by = '$curusr', modified_on = '$now', approved_by = '$curusr', approved_on = '$now' where id in (".$sales_id.")";
                                // echo $sql;
                                // echo '<br/><br/>';
                                $this->db->query($sql);

                                $this->distributor_out_model->approve_pending_sales_data($sales_id);

                                $success_cnt = $success_cnt + 1;
                            }

                            // $this->tax_invoice_model->generate_gate_pass($sales_id);
                        }
                    }
                }

                $remarks = 'No of records uploaded - '.$success_cnt;

                // echo $remarks;
                // echo '<br/><br/>';

                $this->session->set_flashdata('success', $remarks);
                $this->session->keep_flashdata('success');
            }

            // echo $remarks;

            redirect(base_url().'index.php/Distributor_out/checkstatus/pending_for_approval');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function check_stock($type, $depot_id, $item_id, $qty){
        if($type=='Bar'){
            $url = base_url().'index.php/Stock/check_bar_qty_availablity_for_depot';
            $params = array('depot_id' => $depot_id, 'product_id' => $item_id, 'qty' => $qty);
        } else {
            $url = base_url().'index.php/Stock/check_box_qty_availablity_for_depot';
            $params = array('depot_id' => $depot_id, 'box_id' => $item_id, 'qty' => $qty);
        }
        
        $result = 1;
        $query_content = http_build_query($params);
        $fp = fopen($url, 'r', FALSE, // do not use_include_path
        stream_context_create([
            'http' => [
                'header'  => [ // header array does not need '\r\n'
                    'Content-type: application/x-www-form-urlencoded',
                    'Content-Length: ' . strlen($query_content)
                ],
                'method'  => 'POST',
                'content' => $query_content
            ]
        ]));
        if ($fp === FALSE) {
            // echo json_encode(['error' => 'Failed to get contents...']);
        } else {
            $result = stream_get_contents($fp);
        }
        fclose($fp);
        return $result;
    }

    public function approve_records_from_backend(){
        $distributor_out_id = array(26640, 26659, 26999, 27002, 27005, 27064, 27066, 27068, 27069, 27166, 27088, 27090, 27248, 27259, 27275, 27439, 27343, 27348, 27353, 27648, 27649, 27650, 27651, 27652, 27653, 27654, 27655, 27607, 27640, 27641, 27642, 27643, 27644, 27645, 27646, 27647, 27656, 27657, 27658, 27659, 27667, 27668, 27669, 27670, 27671, 27672, 27673, 27674, 27675, 27676, 27677, 27678, 27679, 27680, 27681, 27682, 27685, 27739, 27740, 27741, 27742, 27743, 27760, 27761, 27762, 27763, 27764, 27765, 27766, 27767, 27768, 27769, 27770, 27771, 27772, 27773, 27774, 27775, 27776, 27779);

        $this->distributor_out_model->approve_records_from_backend($distributor_out_id);
    }
}
?>