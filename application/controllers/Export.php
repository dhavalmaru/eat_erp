<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Export extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the Library
        // $this->load->library("excel");
        // Load the Model
        $this->load->helper('common_functions');
        $this->load->model("export_model");
        $this->load->model("distributor_model");
		$this->load->model("sales_rep_model");
        $this->load->model("accountledger_model");
        // $this->load->model("export_model_asset_level");
    }

    public function index() {
        // $this->excel->setActiveSheetIndex(0);
        // // Gets all the data using MY_Model.php
        // $data = $this->export_model->get_all();

        // $this->excel->stream('contact_details.xls', $data);



        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Users list');
 
        // load database
        // $this->load->database();
 
        // load model
        // $this->load->model('userModel');
 
        // get all users in array formate
        // $users = $this->userModel->get_users();
        $users = $this->export_model->get_all();
 
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($users);
 
        $filename='just_some_random_name.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function set_report_criteria($rep_id){
        $data = array();
        if($rep_id==1){
            $data['report_type'] = 'Stock Details';
            $data['report_name'] = 'Sale Invoice Report';
            $data['sample_report_name'] = 'Sale_Invoice_Report.xlsx';
        } else if($rep_id==2){
            $data['report_type'] = 'Stock Details';
            $data['report_name'] = 'Raw Material Stock Report';
            $data['sample_report_name'] = 'Raw_Material_Stock_Report.xlsx';
        } else if($rep_id==3){
            $data['report_type'] = 'Stock Details';
            $data['report_name'] = 'Production Report';
            $data['sample_report_name'] = 'Production_Report.xlsx';
        } else if($rep_id==4){
            $data['report_type'] = 'Stock Details';
            $data['report_name'] = 'Product Stock Report';
            $data['sample_report_name'] = 'Product_Stock_Report.xlsx';
        } else if($rep_id==5){
            $data['report_type'] = 'Stock Details';
            $data['report_name'] = 'Distributor Ledger Report';
            $data['sample_report_name'] = 'Distributor_Ledger_Reports.xlsx';
        } else if($rep_id==6){
            $data['report_type'] = 'Aging Wise';
            $data['report_name'] = 'Aging Wise Report';
            $data['sample_report_name'] = 'Aging_Wise_Report.xlsx';
        } else if($rep_id==7){
            $data['report_type'] = 'Distributor Wise';
            $data['report_name'] = 'Distributor Wise Report';
            $data['sample_report_name'] = 'Distributor_Wise_Report.xlsx';
        } else if($rep_id==8){
            $data['report_type'] = 'Sales Return';
            $data['report_name'] = 'Sales Return Report';
            $data['sample_report_name'] = 'Sales_Return_Report.xlsx';
        } else if($rep_id==9){
            $data['report_type'] = 'Payment Receivable';
            $data['report_name'] = 'Payment Receivable Report';
            $data['sample_report_name'] = 'Payment_Receivable_Reports.xlsx';
        } else if($rep_id==10){
            $data['report_type'] = 'Purchase Order';
            $data['report_name'] = 'Purchase Order Report';
            $data['sample_report_name'] = 'Purchase_Order_Report.xlsx';
        } else if($rep_id==11){
            $data['report_type'] = 'Production Data';
            $data['report_name'] = 'Production Data Report';
            $data['sample_report_name'] = 'Production_Data_Report.xlsx';
        } else if($rep_id==13){
            $data['report_type'] = 'Sales Representative Location';
            $data['report_name'] = 'Sales Representative Location Report';
            $data['sample_report_name'] = 'Sales_Representative_Report.xlsx';
        } else if($rep_id==14){
            $data['report_type'] = 'All Distributor Ledger';
            $data['report_name'] = 'All Distributor Ledger Report';
            $data['sample_report_name'] = 'All_Distributor_Ledger_Report.xlsx';
        } else if($rep_id==15){
            $data['report_type'] = 'Promoter Stock';
            $data['report_name'] = 'Promoter Sales';
            $data['sample_report_name'] = 'Promoter_Stock_Report.xlsx';
        } else if($rep_id==16){
            $data['report_type'] = 'Ledger Report';
            $data['report_name'] = 'Ledger Report';
            $data['sample_report_name'] = 'Ledger_Report.xlsx';
        } else if($rep_id==17){
            $data['report_type'] = 'Trial Balance Report';
            $data['report_name'] = 'Trial Balance Report';
            $data['sample_report_name'] = 'Trial_Balance_Report.xlsx';
        } else if($rep_id==18){
            $data['report_type'] = 'Stock Details';
            $data['report_name'] = 'Sales Report';
            $data['sample_report_name'] = 'Sale_Invoice_SKU_Report.xlsx';
        } else if($rep_id==19){
            $data['report_type'] = 'Sample & Expired Report';
            $data['report_name'] = 'Sample & Expired Report';
            $data['sample_report_name'] = 'Sample_&_Expired_Report.xlsx';
        }

        if($rep_id==16 || $rep_id==17){
            $this->getledgerreport();
        } else {
            $data['report_id'] = $rep_id;
            $data['distributor'] = $this->distributor_model->get_data('Approved');
            $data['salesrep'] = $this->sales_rep_model->get_data_dist('Approved');
            $data['promoter'] = $this->sales_rep_model->get_data_promoter('Approved');
            $data['ledger'] = $this->accountledger_model->get_ledger_data('Approved');

            load_view('reports/download_report',$data);
        }
    }

    public function generate_report($rep_id) {
        if($rep_id==1) {
            $this->export_model->generate_sale_invoice_report();
        } else if($rep_id==2) {
            $this->export_model->generate_raw_material_stock_report();
        } else if($rep_id==3) {
            $this->export_model->generate_production_report();
        } else if($rep_id==4) {
            $this->export_model->generate_product_stock_report();
        } else if($rep_id==5) {
            //if($this->input->post('download') == "Download Report") {
            $this->export_model->generate_distributor_ledger_report();
            //}
            //else {
                
            //}
        } else if($rep_id==6) {
            $this->export_model->generate_agingwise_report();
        } else if($rep_id==7) {
            $this->export_model->generate_distributorwise_report();
        } else if($rep_id==8) {
            $this->export_model->generate_sales_return_report();
        } else if($rep_id==9) {
            $this->export_model->generate_payment_receivable_report();
        } else if($rep_id==10) {
            $this->export_model->generate_purchase_order_report();
        } else if($rep_id==11) {
            $this->export_model->generate_production_data_report();
        } else if($rep_id==13) {
            $this->export_model->generate_sales_representative_location_report();
        } else if($rep_id==14) {
            $this->export_model->generate_credit_debit_report();
        } else if($rep_id==15) {
            $this->export_model->generate_promoter_stock_report();
        } else if($rep_id==16) {
            $this->getledgerreport();
        } else if($rep_id==17) {
            $this->gettrialbalancereport();
        } else if($rep_id==18) {
            $sales=$this->input->post('sales');
            $ssallocation=$this->input->post('ssallocation');
            $salesreturn=$this->input->post('salesreturn');
            $sample=$this->input->post('sample');
            $credit_debit=$this->input->post('credit_debit');
            $date_of_processing=$this->input->post('date_of_processing');
            $date_of_accounting=$this->input->post('date_of_accounting');
            $invoicelevel=$this->input->post('invoicelevel');
            $invoicelevelsalesreturn=$this->input->post('invoicelevelsalesreturn');
            $invoicelevelsample=$this->input->post('invoicelevelsample');
            // echo $invoicelevel;
            // echo '<br>';
            // echo $invoicelevelsalesreturn;
            // echo '<br>';
            // echo $invoicelevelsample;
            $status_type='';
            if($invoicelevel=="" || $invoicelevelsalesreturn=="" || $invoicelevelsample=="") {
                $this->export_model->generate_sale_invoice_sku_report($sales,$ssallocation,$salesreturn,$sample,$credit_debit,$status_type,$date_of_processing,$date_of_accounting);
                // echo 'dop'.$date_of_processing.' doa'.$date_of_accounting;
            }
            else {
                $this->export_model->generate_sale_invoice_report($invoicelevel, $invoicelevelsalesreturn, $invoicelevelsample);
            }
        } else if($rep_id==19) {
            $this->export_model->generate_sample_expired_report();
        }
        
        $this->set_report_criteria($rep_id);
    }

    public function generate_distributor_out_sku_details($status) {
        $this->export_model->generate_sale_invoice_sku_report('Sales','','','','',$status);
    }

    public function generate_ledger_report() {
        
        $result = $this->export_model->view_distributor_ledger_report();

        echo $result;
    }

    public function getledgerreport() {
        $download = $this->input->post('download');

        if($download == "Download Report"){
            $this->export_model->generate_ledger_report();
        }

        $ledger_id = $this->input->post('ledger_id');
        $narration = $this->input->post('narration');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        if($from_date==''){
            $from_date=NULL;
        } else {
            $from_date = formatdate($this->input->post('from_date'));
        }

        if($to_date==''){
            $to_date=NULL;
        } else {
            $to_date = formatdate($this->input->post('to_date'));
        }
        
        $opening_bal = 0;
        $opening_bal_type = 'Cr';
        $balance = 0;
        $result = $this->export_model->getOpeningBal($ledger_id, $from_date);
        if(count($result)>0){
            $opening_bal = floatval($result[0]['opening_bal']);
        }

        $data = $this->export_model->getLedger($ledger_id, $from_date, $to_date);
        
        $ledger = $this->accountledger_model->get_ledger_data('Approved');

        $access = $this->export_model->get_access();

        if(count($access)>0){
            $access[0]->r_export = '1';
        }

        load_view('reports/ledger_report',['ledger' => $ledger, 'opening_bal' => $opening_bal, 
                                            'data' => $data, 'ledger_id' => $ledger_id, 
                                            'from_date' => $from_date, 'to_date' => $to_date, 'narration' => $narration,
                                            'report_type' => 'Ledger Report', 'report_name' => 'Ledger Report', 
                                            'sample_report_name' => 'Ledger_Report.xlsx']);
    }

    public function gettrialbalancereport() {
        $download = $this->input->post('download');

        if($download == "Download Report"){
            $this->export_model->generate_trailbalance_report();
        }

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        if($from_date==''){
            $from_date=NULL;
        } else {
            $from_date = formatdate($this->input->post('from_date'));
        }

        if($to_date==''){
            $to_date=NULL;
        } else {
            $to_date = formatdate($this->input->post('to_date'));
        }
        
        $data = $this->export_model->getTrialBalance($from_date, $to_date);
        
        // $access = $this->export_model->get_access();

        // if(count($access)>0){
        //     $access[0]->r_export = '1';
        // }

        load_view('reports/trial_balance_report',['data' => $data, 'from_date' => $from_date, 'to_date' => $to_date, 
                                            'report_type' => 'Trial Balance Report', 'report_name' => 'Trial Balance Report', 
                                            'sample_report_name' => 'Trial_Balance_Report.xlsx']);
    }
}
 ?>