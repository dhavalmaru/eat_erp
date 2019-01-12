<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sample_out extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sample_out_model');
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
        // $result=$this->sample_out_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->sample_out_model->get_data();

        //     load_view('distributor_out/distributor_out_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }

        $this->checkstatus('pending_for_delivery');
    }

    public function get_data($status='')
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $data=$this->sample_out_model->get_distributor_out_data1($status);
        $records = array();
        for ($i=0; $i < count($data); $i++) { 
                $records[] =  array(
                        '<input type="checkbox" id="check_<?php echo $i; ?>" class="check icheckbox" name="check[]" value="'.$data[$i]->id.'" />',
                        $i+1,                       
                        '<span style="display:none;">'.(($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('Ymd',strtotime($data[$i]->date_of_processing)):'').'</span>'.(($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''),
                        '<a href="'.base_url().'index.php/sample_out/edit/'.$data[$i]->d_id.'" class=""><i class="fa fa-edit"></i></a>',
                        ''.(($data[$i]->invoice_no!=null && $data[$i]->invoice_no!='') || ($data[$i]->voucher_no!=null && $data[$i]->voucher_no!='')?'<a href="'.base_url().'index.php/sample_out/view_tax_invoice/'.$data[$i]->id.'" target="_blank">  <span class="fa fa-file-pdf-o">':'').'',
                        '<span style="display:none;">'.(isset($data[$i]->voucher_no)?str_pad(substr($data[$i]->voucher_no, strrpos($data[$i]->voucher_no, "/")+1),10,"0",STR_PAD_LEFT):'').'</span>'.$data[$i]->voucher_no.'',
                   
                        ''.$data[$i]->distributor_name.'',
                        ''.$data[$i]->location.'',
               
                        ''.format_money($data[$i]->final_amount,2).'',
                      
                   
                        ''.$data[$i]->delivery_status.'<input type="hidden" id="dlvery_status_'.$i.'" name="dlvery_status[]" value="'.$data[$i]->delivery_status.'" />',
               
                        /*''.(($data[$i]->invoice_no!=null && $data[$i]->invoice_no!='') || ($data[$i]->voucher_no!=null && $data[$i]->voucher_no!='')?'<a href="'.base_url().'index.php/sample_out/view_tax_invoice/'.$data[$i]->id.'" target="_blank"><span class="fa fa-file-pdf-o"></span></a>':'').'',*/
                    );
      }

      $output = array(
                        "draw" => $draw,
                        "recordsTotal" => count($data),
                        "recordsFiltered" => count($data),
                        "data" => $records
                    );
       echo json_encode($output); 
    }

    public function checkstatus($status=''){
        $result=$this->sample_out_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
			if($status=='All') {
				$status='';
			}
            /*$data['data']=$this->sample_out_model->get_distributor_out_data1($status);*/

            $count_data=$this->sample_out_model->get_distributor_out_data1();
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

            load_view('distributor_out/sample_out_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add(){
        $result=$this->sample_out_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sample_out_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data_with_sample('Approved');
                $data['distributor1'] = $this->distributor_model->get_data_without_sample('Approved');
                $where = array('status'=>'Approved','sr_type'=>'Sales Representative');
                $data['sales_rep'] = $this->db->select('*')->where($where)->get('sales_rep_master')->result();//$this->sales_rep_model->get_data_dist('Approved','','Sales Representative');
                $where1 = array('status'=>'Approved','sr_type'=>'Promoter');
                $data['promoter'] = $this->db->select('*')->where($where1)->get('sales_rep_master')->result();
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['bank'] = $this->bank_model->get_data('Approved');

                load_view('distributor_out/sample_out_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($d_id){
        $result=$this->sample_out_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sample_out_model->get_access();
                $data['data'] = $this->sample_out_model->get_distributor_out_data('', $d_id);
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data_with_sample('Approved');
                $data['distributor1'] = $this->distributor_model->get_data_without_sample('Approved');
                $where = array('status'=>'Approved','sr_type'=>'Sales Representative');
                $data['sales_rep'] = $this->db->select('*')->where($where)->get('sales_rep_master')->result();//$this->sales_rep_model->get_data_dist('Approved','','Sales Representative');
                $where1 = array('status'=>'Approved','sr_type'=>'Promoter');
                $data['promoter'] = $this->db->select('*')->where($where1)->get('sales_rep_master')->result();
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_out_items'] = $this->sample_out_model->get_distributor_out_items($d_id);
                $data['bank'] = $this->bank_model->get_data('Approved');
                // $data['distributor_payment_details'] = $this->sample_out_model->get_distributor_payment_details($id);
                load_view('distributor_out/sample_out_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->sample_out_model->save_data();
        redirect(base_url().'index.php/sample_out/checkstatus/pending_for_approval');
    }

    public function update($id){
        $this->sample_out_model->save_data($id);
        redirect(base_url().'index.php/sample_out/checkstatus/pending_for_delivery');
    }
    
    public function check_box_availablity(){
        $result = $this->sample_out_model->check_box_availablity();
        echo $result;
    }

    public function check_box_qty_availablity(){
        $result = $this->sample_out_model->check_box_qty_availablity();
        echo $result;
    }

    public function check_product_availablity(){
        $result = $this->sample_out_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->sample_out_model->check_product_qty_availablity();
        echo $result;
    }

    public function view_tax_invoice($id){
        $this->tax_invoice_model->generate_tax_invoice($id);
    }

    public function generate_gate_pass(){
        $this->tax_invoice_model->generate_gate_pass();
    }

    public function authorise(){
        $status=$this->input->post('status');

        if($status=="Approved"){
            $this->sample_out_model->approve_records();
        } else {
            $this->sample_out_model->reject_records();
        }
    }

    public function view_gate_pass($distid){
        $this->tax_invoice_model->view_gate_pass($distid);
    }

    // public function set_delivery_status(){
    //     $this->sample_out_model->set_delivery_status();
    //     redirect(base_url().'index.php/sample_out/checkstatus/gp_issued');
    // }

    public function set_delivery_status(){
        // echo 'Hii';

        $this->sample_out_model->set_delivery_status();
        $status=$this->input->post('status');
        if($status=='InActive') {
            redirect(base_url().'index.php/sample_out');
        }
    }

    public function set_sku_batch(){
        $this->sample_out_model->set_sku_batch();
        $status=$this->input->post('status');
        if($status=='InActive') {
            redirect(base_url().'index.php/sample_out');
        }
    }

    public function set_delivery_status2(){
        $this->sample_out_model->set_delivery_status();
        redirect(base_url().'index.php/sample_out/checkstatus/gp_issued');
    }

    public function get_batch_details(){
        $result=$this->sample_out_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sample_out_model->get_access();
                $data['data'] = $this->sample_out_model->get_sku_details();
                $data['batch_details'] = $this->sample_out_model->get_batch_details();

                $check1=$this->input->post('check');
                $check = array();
                $j=0;
                for($i=0; $i<count($check1); $i++){
                    if($check1[$i]!='false'){
                        $check[$j] = $check1[$i];
                        $j = $j + 1;
                    }
                }
                $distributor_out_id = implode(", ", $check);
                $data['distributor_out_id']=$distributor_out_id;

                $query=$this->db->query("SELECT * FROM sales_rep_master WHERE sr_type='Merchandizer'");
                $result=$query->result();
                $data['sales_rep1']=$result;

                // dump($data['data']);

                load_view('distributor_out/sample_out_sku_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // public function view_payment_details($id){
    //     $result=$this->sample_out_model->get_access();
    //     if(count($result)>0) {
    //         if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
    //             $data['access'] = $this->sample_out_model->get_access();
    //             $data['data'] = $this->sample_out_model->get_data('', $id);
    //             $data['distributor_payment_details'] = $this->sample_out_model->get_distributor_payment_details($id);

    //             load_view('distributor_out/distributor_payment_details', $data);
    //         } else {
    //             echo "Unauthorized access";
    //         }
    //     } else {
    //         echo "You donot have access to this page.";
    //     }
    // }

    // public function save_payment_details(){
    //     $this->sample_out_model->save_payment_details();
    //     redirect(base_url().'index.php/distributor_out');
    // }

    // public function update_payment_details($id){
    //     $this->sample_out_model->save_payment_details($id);
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

    public function save_download()
  { 
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