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

        $this->checkstatus('pending_for_delivery');
    }

    public function get_data($status){
        // $status = 'Approved';

        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        // $status = intval($this->input->get("status"));

        $r = $this->distributor_out_model->get_distributor_out_data1($status);
        $data = array();

        for($i=0;$i<count($r);$i++){
            if($status=='pending_for_delivery' || $status=='gp_issued' || $status=='pending_for_approval'){
                $data[] = array(
                            '<input type="checkbox" id="check_'.$i.'" class="check icheckbox" name="check_val[]" value="'.$r[$i]->id.'" onChange="set_checkbox(this);" />
                            <input type="hidden" id="input_check_'.$i.'" name="check[]" value="false" />',

                            $i+1,

                            '<span style="display:none;">'.
                                (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('Ymd',strtotime($r[$i]->date_of_processing)):'')
                            .'</span>'.
                            (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('d/m/Y',strtotime($r[$i]->date_of_processing)):''),

                            '<span style="display:none;">'.
                                (isset($r[$i]->invoice_no)?str_pad(substr($r[$i]->invoice_no, strrpos($r[$i]->invoice_no, "/")+1),10,"0",STR_PAD_LEFT):'')
                            .'</span>'.
                            $r[$i]->invoice_no,

                            $r[$i]->depot_name,

                            ((strtoupper(trim($r[$i]->distributor_name))=='DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='AMAZON DIRECT')? $r[$i]->distributor_name . '-' . $r[$i]->client_name : $r[$i]->distributor_name),

                            $r[$i]->location,

                            $r[$i]->sales_rep_name,

                            $r[$i]->invoice_amount,

                            (($r[$i]->modified_on!=null && $r[$i]->modified_on!='')?date('d/m/Y',strtotime($r[$i]->modified_on)):''),

                            (($r[$i]->status=="InActive")?"Cancelled":$r[$i]->status),

                            '<input type="hidden" id="dlvery_status_'.$i.'" name="dlvery_status[]" value="'.$r[$i]->delivery_status.'" />'.
                            $r[$i]->delivery_status,

                            $r[$i]->del_person_name,

                            ((($r[$i]->invoice_no!=null && $r[$i]->invoice_no!='') || ($r[$i]->voucher_no!=null && $r[$i]->voucher_no!=''))?
                                '<a href="'.
                                            ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                            base_url().'index.php/distributor_out/view_tax_invoice_old/'.$r[$i]->id:
                                            base_url().'index.php/distributor_out/view_tax_invoice/'.$r[$i]->id).
                                        '" target="_blank"> 
                                    <span class="fa fa-file-pdf-o"></span>
                                </a>'
                                :''),

                            '<a href="'.
                                        ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                        base_url().'index.php/distributor_out/view_gate_pass_old/'.$r[$i]->id:
                                        base_url().'index.php/distributor_out/view_gate_pass/'.$r[$i]->id).
                                    '" target="_blank">  <span class="fa fa-file-pdf-o"></span>
                            </a>',

                            '<a href="#"><span class="fa fa-eye">Resend Invoice</span></a>'
                        );
            } else {
                $data[] = array(
                            '<input type="checkbox" id="check_'.$i.'" class="check icheckbox" name="check_val[]" value="'.$r[$i]->id.'" onChange="set_checkbox(this);" />
                            <input type="hidden" id="input_check_'.$i.'" name="check[]" value="false" />',

                            $i+1,

                            '<span style="display:none;">'.
                                (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('Ymd',strtotime($r[$i]->date_of_processing)):'')
                            .'</span>'.
                            '<a href="'.base_url().'index.php/distributor_out/edit/'.$r[$i]->d_id.'">'.
                                (($r[$i]->date_of_processing!=null && $r[$i]->date_of_processing!='')?date('d/m/Y',strtotime($r[$i]->date_of_processing)):'').
                            '</a>',

                            '<span style="display:none;">'.
                                (isset($r[$i]->invoice_no)?str_pad(substr($r[$i]->invoice_no, strrpos($r[$i]->invoice_no, "/")+1),10,"0",STR_PAD_LEFT):'')
                            .'</span>'.
                            $r[$i]->invoice_no,

                            $r[$i]->depot_name,

                            ((strtoupper(trim($r[$i]->distributor_name))=='DIRECT' || strtoupper(trim($r[$i]->distributor_name))=='AMAZON DIRECT')? $r[$i]->distributor_name . '-' . $r[$i]->client_name : $r[$i]->distributor_name),

                            $r[$i]->location,

                            $r[$i]->sales_rep_name,

                            $r[$i]->invoice_amount,

                            (($r[$i]->modified_on!=null && $r[$i]->modified_on!='')?date('d/m/Y',strtotime($r[$i]->modified_on)):''),

                            (($r[$i]->status=="InActive")?"Cancelled":$r[$i]->status),

                            '<input type="hidden" id="dlvery_status_'.$i.'" name="dlvery_status[]" value="'.$r[$i]->delivery_status.'" />'.
                            $r[$i]->delivery_status,

                            $r[$i]->del_person_name,

                            ((($r[$i]->invoice_no!=null && $r[$i]->invoice_no!='') || ($r[$i]->voucher_no!=null && $r[$i]->voucher_no!=''))?
                                '<a href="'.
                                            ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                            base_url().'index.php/distributor_out/view_tax_invoice_old/'.$r[$i]->id:
                                            base_url().'index.php/distributor_out/view_tax_invoice/'.$r[$i]->id).
                                        '" target="_blank"> 
                                    <span class="fa fa-file-pdf-o"></span>
                                </a>'
                                :''),

                            '<a href="'.
                                        ((strtotime($r[$i]->date_of_processing)<strtotime('2017-07-01'))?
                                        base_url().'index.php/distributor_out/view_gate_pass_old/'.$r[$i]->id:
                                        base_url().'index.php/distributor_out/view_gate_pass/'.$r[$i]->id).
                                    '" target="_blank">  <span class="fa fa-file-pdf-o"></span>
                            </a>',

                            '<a href="#"><span class="fa fa-eye">Resend Invoice</span></a>'
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
        if(count($result)>0) {
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

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="APPROVED")
                        $active=$active+1;


                    if (strtoupper(trim($count_data[$i]->status))=="PENDING" && (strtoupper(trim($count_data[$i]->delivery_status))=="GP ISSUED" || strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED NOT COMPLETE" || strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED"))
                        $pending_for_approval=$pending_for_approval+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="APPROVED" && (strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED" || $count_data[$i]->delivery_status==null))
                        // $active=$active+1;
                        $active=$active;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="PENDING")
                        $pending=$pending+1;
                    else if ((strtoupper(trim($count_data[$i]->status))=="APPROVED" || strtoupper(trim($count_data[$i]->status))=="REJECTED") && strtoupper(trim($count_data[$i]->delivery_status))=="PENDING")
                        $pending_for_delivery=$pending_for_delivery+1;
                    else if ((strtoupper(trim($count_data[$i]->status))=="APPROVED" || strtoupper(trim($count_data[$i]->status))=="REJECTED") && strtoupper(trim($count_data[$i]->delivery_status))=="GP ISSUED")
                        $gp_issued=$gp_issued+1;
                    else if ((strtoupper(trim($count_data[$i]->status))=="APPROVED" || strtoupper(trim($count_data[$i]->status))=="REJECTED") && strtoupper(trim($count_data[$i]->delivery_status))=="DELIVERED NOT COMPLETE")
                        $delivered_not_complete=$delivered_not_complete+1;
                }
            }

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
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
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
                $data['data'] = $this->distributor_out_model->get_distributor_out_data('', $d_id);
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
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
        redirect(base_url().'index.php/distributor_out/checkstatus/pending_for_delivery');
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

        if($status=="Approved"){
            $this->distributor_out_model->approve_records();
        } else {
            $this->distributor_out_model->reject_records();
        }
    }

    public function set_delivery_status(){
        // echo 'Hii';

        $this->distributor_out_model->set_delivery_status();
        // redirect(base_url().'index.php/distributor_out/checkstatus/gp_issued');
    }

    public function set_delivery_status2(){
        $this->distributor_out_model->set_delivery_status();
        redirect(base_url().'index.php/distributor_out/checkstatus/gp_issued');
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

}
?>