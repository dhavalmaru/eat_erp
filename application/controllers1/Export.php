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
        } 
        // else if($rep_id==12){
        //     $data['report_type'] = 'Asset Level';
        //     $data['report_name'] = 'Asset Level Purchase Variance Report';
        //     $data['sample_report_name'] = 'Asset_Level_-_Purchase_Variance_Report.xlsx';
        //     $data['txn_type'] = 'Purchase';
        //     $data['purchase_data'] = $this->export_model_asset_level->getProperty();
        // } 
        // else if($rep_id==13){
        //     $data['report_type'] = 'Asset Level';
        //     $data['report_name'] = 'Asset Level Related Party Report';
        //     $data['sample_report_name'] = 'Asset_Level_-_Related_Party_Reports.xlsx';
        //     $data['txn_type'] = 'Purchase';
        //     $data['purchase_data'] = $this->export_model_asset_level->getProperty();
        // } else if($rep_id==14){
        //     $data['report_type'] = 'Asset Level';
        //     $data['report_name'] = 'Asset Level Rent Report';
        //     $data['sample_report_name'] = 'Asset_Level_-_Rent_Report.xlsx';
        //     $data['txn_type'] = 'Rent';
        //     $data['purchase_data'] = $this->export_model_asset_level->get_rent_properties();
        // } else if($rep_id==15){
        //     $data['report_type'] = 'Asset Level';
        //     $data['report_name'] = 'Asset Level Sale Report';
        //     $data['sample_report_name'] = 'Asset_Level_-_Sale_Report.xlsx';
        //     $data['txn_type'] = 'Sale';
        //     $data['purchase_data'] = $this->export_model_asset_level->get_sale_properties();
        // } else if($rep_id==16){
        //     $data['report_type'] = 'Asset Level';
        //     $data['report_name'] = 'Asset Level Sale Variance Report';
        //     $data['sample_report_name'] = 'Asset_Level_-_Sale_Variance_Report.xlsx';
        //     $data['txn_type'] = 'Sale';
        //     $data['purchase_data'] = $this->export_model_asset_level->get_sale_properties();
        // } else if($rep_id==12){
        //     $data['report_type']='Asset Level';
        //     $data['report_id']=$rep_id;
        //     $data['report_name']='Asset Level Purchase Variance';
        //     $data['purchase_data']=$this->export_model_asset_level->getProperty();
        // }

        $data['report_id'] = $rep_id;
        $data['distributor'] = $this->distributor_model->get_data('Approved');

        load_view('reports/download_report',$data);
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
            $this->export_model->generate_distributor_ledger_report();
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
        } 
        // else if($rep_id==12) {
        //     $this->export_model->generate_asset_level_purchase_varience();
        // } 
        // else if($rep_id==13) {
        //     $this->export_model_asset_level->generate_asset_level_related_party_report();
        // } else if($rep_id==14) {
        //     $this->export_model_asset_level->generate_asset_level_rent_report();
        // } else if($rep_id==15) {
        //     $this->export_model_asset_level->generate_asset_level_sale_report();
        // } else if($rep_id==16) {
        //     $this->export_model_asset_level->generate_asset_level_sale_variance_report();
        // }
        
        $this->set_report_criteria($rep_id);
    }
}
 ?>