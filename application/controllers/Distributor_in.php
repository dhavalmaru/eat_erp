<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Distributor_in extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('distributor_in_model');
        $this->load->model('box_model');
        $this->load->model('depot_model');
        $this->load->model('sales_rep_model');
        $this->load->model('distributor_model');
        $this->load->model('product_model');
        $this->load->model('credit_debit_note_model');
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->distributor_in_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->distributor_in_model->get_data();

        //     load_view('distributor_in/distributor_in_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }
        
        $this->checkstatus('Approved');
    }

    public function get_data($status=''){
       $draw = intval($this->input->get("draw"));
       $start = intval($this->input->get("start"));
       $length = intval($this->input->get("length"));
       /*$data = $this->distributor_in_model->get_data($status);*/
       $records = array();
       $data=$this->distributor_in_model->get_data($status);
       for ($i=0; $i < count($data); $i++) { 
                $records[] =  array(
                        $i+1,
                         (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''),
                        '<a href="'.base_url().'index.php/distributor_in/edit/'.$data[$i]->id.'"><i class="fa fa-edit">',
                         '<a class="hide_col" href="'.base_url().'index.php/distributor_in/view_sales_return_receipt/'.$data[$i]->id.'" target="_blank"><span class="fa fa-file-pdf-o" style="font-size:20px;"></span></a>',
                  
                       
                        ''.$data[$i]->sales_return_no.'',
                        ''.$data[$i]->order_no.'',
                      
                        ''.$data[$i]->distributor_name.'',
                    
                        ''.format_money($data[$i]->final_amount,2).'',
                        
                        '<a href="'.($data[$i]->credit_debit_note_id!=NULL?base_url('index.php/credit_debit_note/view_credit_debit_note/').'/'.$data[$i]->credit_debit_note_id:'javascript:void(0)').'" target="_blank"> 
                                '.($data[$i]->credit_debit_note_id!=NULL?'<span class="fa fa-file-pdf-o" style="font-size:20px;"></span>':'').'
                            </a>',
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
        $result=$this->distributor_in_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            /*$data['data']=$this->distributor_in_model->get_data($status);*/

            $count_data=$this->distributor_in_model->get_data();
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
            $data['status']=$status;

            load_view('distributor_in/distributor_in_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_invoice() { 
        $postData = $this->input->post();
        $distributor_id = $postData['distributor_id'];
        $invoice_no = $postData['invoice_no'];
        $data = $this->distributor_in_model->get_invoice($distributor_id);

        $options = '<option value="">Select</option>';
        for($i=0; $i<count($data); $i++){
            $options .= '<option value="'.$data[$i]->invoice_no.'"'.(($data[$i]->invoice_no==$invoice_no)? ' selected': '').'>'.$data[$i]->invoice_no.'</option>';
        }

        $final_data = array('options'=>$options);

        echo json_encode($final_data); 
    }

    public function get_invoice_details() {
        $postData = $this->input->post();
        $invoice_no = $postData['invoice_no'];
        $data = $this->distributor_in_model->get_invoice_details($invoice_no);
        $box = $this->box_model->get_data('Approved');
        $bar = $this->product_model->get_data('Approved');
        
        $date = date("Y-m-d", strtotime("-9 months"));
        $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
        $query = $this->db->query($sql);
        $batch = $query->result();

        $invoice_details = '';

        for($i=0; $i<count($data); $i++){
            $bar_details = '<option value="">Select</option>';
            if(isset($bar)){
                for($k=0; $k < count($bar) ; $k++){
                    $selected = '';
                    if($data[$i]->type=='Bar' && $data[$i]->item_id==$bar[$k]->id){
                        $selected = ' selected';
                    }

                    $bar_details .= '<option value="'.$bar[$k]->id.'"'.$selected.'>'.$bar[$k]->product_name.'</option>';
                }
            }

            $box_details = '<option value="">Select</option>';
            if(isset($box)){
                for($k=0; $k < count($box) ; $k++){
                    $selected = '';
                    if($data[$i]->type=='Box' && $data[$i]->item_id==$box[$k]->id){
                        $selected = ' selected';
                    }

                    $box_details .= '<option value="'.$box[$k]->id.'"'.$selected.'>'.$box[$k]->box_name.'</option>';
                }
            }

            $batch_details = '<option value="">Select</option>';
            if(isset($batch)){
                for($k=0; $k < count($batch) ; $k++){
                    $selected = '';
                    if($data[$i]->batch_no==$batch[$k]->id){
                        $selected = ' selected';
                    }

                    $batch_details .= '<option value="'.$batch[$k]->id.'"'.$selected.'>'.$batch[$k]->batch_no.'</option>';
                }
            }

            $bar_style = '';
            $box_style = '';
            $bar_type = '';
            $box_type = '';
            if($data[$i]->type=='Bar'){
                $box_style = 'display: none;';
                $bar_type = ' selected';
            } else {
                $bar_style = 'display: none;';
                $box_type = ' selected';
            }

            $invoice_details .= '<tr id="box_'.$i.'_row">'.
                                    '<td>'.
                                        '<select name="type[]" class="form-control type" id="type_'.$i.'">'.
                                            '<option value="">Select</option>'.
                                            '<option value="Bar"'.$bar_type.'>Bar</option>'.
                                            '<option value="Box"'.$box_type.'>Box</option>'.
                                        '</select>'.
                                    '</td>'.
                                    '<td>'.
                                        '<select name="bar[]" class="form-control bar" id="bar_'.$i.'" data-error="#err_item_'.$i.'" style="'.$bar_style.'">'.$bar_details.
                                        '</select>'.
                                        '<select name="box[]" class="form-control box" id="box_'.$i.'" data-error="#err_item_'.$i.'" style="'.$box_style.'">'.$box_details.
                                        '</select>'.
                                        '<div id="err_item_'.$i.'"></div>'.
                                    '</td>'.
                                    '<td>'.
                                        '<input type="text" class="form-control qty" name="qty[]" id="qty_'.$i.'" placeholder="Qty" value="'.$data[$i]->qty.'"/>'.
                                    '</td>'.
                                    '<td class="print_hide">'.
                                        '<input type="text" class="form-control rate" name="rate[]" id="rate_'.$i.'" placeholder="Rate" value="'.$data[$i]->qty.'" readonly />'.
                                    '</td>'.
                                    '<td>'.
                                        '<input type="hidden" class="form-control" name="cgst[]" id="cgst_'.$i.'" placeholder="cgst" value="0" readonly />'.
                                        '<input type="hidden" class="form-control" name="sgst[]" id="sgst_'.$i.'" placeholder="sgst" value="0" readonly />'.
                                        '<input type="hidden" class="form-control" name="igst[]" id="igst_'.$i.'" placeholder="igst" value="0" readonly />'.
                                        '<input type="hidden" class="form-control tax_per" name="tax_per[]" id="tax_per_'.$i.'" placeholder="tax_per" value="'.$data[$i]->tax_percentage.'"/>'.
                                        '<input type="hidden" class="form-control sell_margin" name="sell_margin[]" id="sell_margin_'.$i.'" placeholder="Sell Margin" value="0"/>'.
                                        '<input type="hidden" class="form-control promo_margin" name="promo_margin[]" id="promo_margin_'.$i.'" placeholder="Promo Margin" value="'.$data[$i]->promo_margin.'"/>'.
                                        '<input type="text" class="form-control sell_rate" name="sell_rate[]" id="sell_rate_'.$i.'" placeholder="Sell Rate" value="'.$data[$i]->sell_rate.'"/>'.
                                    '</td>'.
                                    '<td style="display: none;">'.
                                        '<input type="text" class="form-control cost_rate" name="cost_rate[]" id="cost_rate_'.$i.'" placeholder="Cost Rate" value="'.$data[$i]->rate.'"/>'.
                                    '</td>'.
                                    '<td style="display: none;">'.
                                        '<input type="text" class="form-control grams" name="grams[]" id="grams_'.$i.'" placeholder="Grams" value="'.$data[$i]->grams.'" readonly />'.
                                    '</td>'.
                                    '<td class="print_hide">'.
                                        '<input type="text" class="form-control amount" name="amount[]" id="amount_'.$i.'" placeholder="Amount" value="'.$data[$i]->amount.'" readonly />'.
                                    '</td>'.
                                    '<!-- <td>'.
                                        '<input type="text" class="form-control vat1" name="vat1[]" id="vat1_'.$i.'" placeholder="VAT" value="" readonly />'.
                                    '</td> -->'.
                                    '<td class="print_hide">'.
                                        '<input type="text" class="form-control cgst_amt" name="cgst_amt[]" id="cgst_amt_'.$i.'" placeholder="CGST Amount" value="'.$data[$i]->cgst_amt.'" readonly />'.
                                    '</td>'.
                                    '<td class="print_hide">'.
                                        '<input type="text" class="form-control sgst_amt" name="sgst_amt[]" id="sgst_amt_'.$i.'" placeholder="SGST Amount" value="'.$data[$i]->sgst_amt.'" readonly />'.
                                    '</td>'.
                                    '<td class="print_hide">'.
                                        '<input type="text" class="form-control igst_amt" name="igst_amt[]" id="igst_amt_'.$i.'" placeholder="IGST Amount" value="'.$data[$i]->igst_amt.'" readonly />'.
                                    '</td>'.
                                    '<td class="print_hide">'.
                                        '<input type="text" class="form-control tax_amt" name="tax_amt[]" id="tax_amt_'.$i.'" placeholder="VAT" value="'.$data[$i]->tax_amt.'" readonly />'.
                                    '</td>'.
                                    '<td>'.
                                        '<input type="text" class="form-control total_amt" name="total_amt[]" id="total_amt_'.$i.'" placeholder="Total Amount" value="'.$data[$i]->total_amt.'" readonly />'.
                                    '</td>'.
                                    '<td style="display: none;">'.
                                        '<input type="text" class="form-control cost_total_amt" name="cost_total_amt[]" id="cost_total_amt_'.$i.'" placeholder="Cost Total Amount" value="'.$data[$i]->amount.'" readonly />'.
                                    '</td>'.
                                    '<td>'.
                                        '<select name="batch_no[]" class="form-control batch_no" id="batch_no_'.$i.'" data-error="#err_batch_no_'.$i.'">'.$batch_details.
                                        '</select>'.
                                        '<div id="err_batch_no_'.$i.'"></div>'.
                                    '</td>'.
                                    '<td style="text-align:center;" class="print_hide table_action">'.
                                        '<a id="box_'.$i.'_row_delete" class="delete_row_new" href="#"><span class="fa trash fa-trash-o"  ></span></a>'.
                                    '</td>'.
                                '</tr>';
        }

        $final_data = array('discount'=>0, 'invoice_details'=>$invoice_details);

        if(count($data)>0){
            $final_data['discount'] = $data[0]->discount;
        }

        echo json_encode($final_data);
    }
    
    public function add(){
        $result=$this->distributor_in_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->distributor_in_model->get_access();
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');

                $date = date("Y-m-d", strtotime("-9 months"));
                $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
                $query = $this->db->query($sql);
                $data['batch'] = $query->result();

                load_view('distributor_in/distributor_in_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->distributor_in_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->distributor_in_model->get_access();

                $id = $this->distributor_in_model->get_pending_data($id);
                
                $data['data'] = $result = $this->distributor_in_model->get_data('', $id);
                $data['depot'] = $this->depot_model->get_data('Approved');
                $data['distributor'] = $this->distributor_model->get_data('Approved');
                $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
                $data['box'] = $this->box_model->get_data('Approved');
                $data['bar'] = $this->product_model->get_data('Approved');
                $data['distributor_in_items'] = $this->distributor_in_model->get_distributor_in_items($id);
                $data['distributor_in_items_ex'] = $this->distributor_in_model->get_distributor_in_items_ex($id);
                if(count($result)>0)
                {
                    if($result[0]->sales_type=='Invoice')
                    {
                        $data['invoice_nos'] = $this->credit_debit_note_model->get_invoice($result[0]->distributor_id);
                    }
                }
               
                $date = new DateTime($data['data'][0]->date_of_processing);
                $date->modify('-9 month');
                $date = $date->format('Y-m-d');
                // echo $date;

                $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
                $query = $this->db->query($sql);
                $data['batch'] = $query->result();

                load_view('distributor_in/distributor_in_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->distributor_in_model->save_data();
        redirect(base_url().'index.php/distributor_in');
    }

    public function update($id){
        $this->distributor_in_model->save_data($id);
       // redirect(base_url().'index.php/distributor_in');
		 echo '<script>window.open("'.base_url().'index.php/distributor_in", "_parent")</script>';
    }

    public function view_sales_return_receipt($id){
        $data['data'] = $this->distributor_in_model->get_data('', $id);
        $data['distributor_in_items'] = $this->distributor_in_model->get_distributor_in_items_for_receipt($id);
        $data['distributor_exchange_items'] = $this->distributor_in_model->get_distributor_out_items_for_exchange($id);

        if(count($data['data'])>0){
            $data['total_amount_in_words']=convert_number_to_words($data['data'][0]->final_amount) . ' Only';
        }

        load_view('invoice/sales_return_receipt', $data);
    }
    
    public function check_box_availablity(){
        $result = $this->distributor_in_model->check_box_availablity();
        echo $result;
    }

    public function check_box_qty_availablity(){
        $result = $this->distributor_in_model->check_box_qty_availablity();
        echo $result;
    }

    public function check_product_availablity(){
        $result = $this->distributor_in_model->check_product_availablity();
        echo $result;
    }

    public function check_product_qty_availablity(){
        $result = $this->distributor_in_model->check_product_qty_availablity();
        echo $result;
    }

    public function get_product_percentage($product_id,$distributor_id){
        $result = $this->distributor_in_model->get_product_percentage($product_id,$distributor_id);

        if(count($result)>0) {
           echo json_encode($result[0]);
        }
        else{
            echo 0;
        }
    }

    public function get_box_percentage($product_id,$distributor_id){
        $result = $this->distributor_in_model->get_box_percentage($product_id,$distributor_id);

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

}
?>