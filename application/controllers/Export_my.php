<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Export extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Load the Library
        // $this->load->library("excel");
        // Load the Model();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
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
        } else if($rep_id==20){
            $data['report_type'] = 'Ledger Balance Report';
            $data['report_name'] = 'Ledger Balance Report';
            $data['sample_report_name'] = 'ledger_balance_report.xlsx';
        } else if($rep_id==21){
            $data['report_type'] = 'Ledger Balance Report';
            $data['report_name'] = 'Ledger Balance Report';
            $data['sample_report_name'] = 'ledger_balance_report.xlsx';
        }
			else if($rep_id==22)
		{
            $data['report_type'] = 'Sales_rep_daily_tracker';
            $data['report_name'] = 'Sales Rep Daily Tracker Report';
            $data['sample_report_name'] = 'Sales_rep_daily_tracker.xls';
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

            $this->load->library('zip');

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

            // $path  = 'C:/wamp64/www/eat_erp_test/assets/uploads/excel_upload/';
            // $path  = '/home/eatangcp/public_html/test/assets/uploads/excel_upload/';
            $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/excel_upload/';
            
            $flag = 0;

            if(($invoicelevel!="" || $invoicelevelsalesreturn!="" || $invoicelevelsample!="") && ($sales!='' || $ssallocation!='' || $salesreturn!='' || $sample!='' || $credit_debit!='' || $status_type!=''))
            {
                $flag=1;
            }
            if($invoicelevel!="" || $invoicelevelsalesreturn!="" || $invoicelevelsample!="") {

                $this->export_model->generate_sale_invoice_report($invoicelevel, $invoicelevelsalesreturn, $invoicelevelsample,$flag);
                if($flag==1)
                    $this->zip->read_file($path.'Sale_Invoice_Report.xls');
            
            }

            // echo $date_of_accounting;
            // echo '<br/><br/>';
            // echo $date_of_processing;

            if($sales!='' || $ssallocation!='' || $salesreturn!='' || $sample!='' || $credit_debit!='' || $status_type!='')
            {
                $this->export_model->generate_sale_invoice_sku_report($sales,$ssallocation,$salesreturn,$sample,$credit_debit,$status_type,$date_of_processing,$date_of_accounting,$flag);

                if($flag==1)
                    $this->zip->read_file($path.'Sale_Invoice_Sku_Report.xls');
            }

            /*$this->_archieve_and_download('Sales_Report.zip');*/
             if($flag==1)
                 $this->zip->download('Sales_Report.zip');
            /*$this->load->helper("file");
            delete_files('C:/xampp/htdocs/eat_erp_new_30/'.'Sale_Invoice_Report.xls');
            delete_files('C:/xampp/htdocs/eat_erp_new_30/'.'Sale_Invoice_Sku_Report.xls');*/

        } else if($rep_id==19) {
            $this->export_model->generate_sample_expired_report();
        } else if($rep_id==20) {
            $this->export_model->generate_distributor_balance_ledger_report();
        } else if($rep_id==21) {
            $this->export_model->upload_distributor_balance_ledger_report();
        }
		else if($rep_id==22) {
            $this->export_model->generate_sales_representative_daily_report();
        }
        
        $this->set_report_criteria($rep_id);
    }

    public function upload_file() {
        $filePath='uploads/excel_upload/';
        $upload_path = './' . $filePath;
        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $config = array(
            'upload_path' => $filePath,
            'allowed_types' => "xls",
            'overwrite' => TRUE,
            'max_size' => "2048000", 
            'max_height' => "768",
            'max_width' => "1024"
        );
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');  

        $new_name = time().'_'.str_replace(' ', "_", $_FILES["upload"]['name']);
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload')) { 
            $this->upload->display_errors();
        } else {
            $imageDetailArray = $this->upload->data();
        }

        $path=FCPATH;
        $path=str_replace('\\', '/', $path);
        $path=$path.'uploads/excel_upload/';

        $file = $path.$new_name;

        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(0);
        $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->setCellValue('F6', 'Error Remark');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objerror = 0;
        $error_line = '';
        $batch_array = array();

        for($k=7;$k<=$highestrow;$k++) { 
            $error = '';
            $tally_name = $objPHPExcel->getActiveSheet()->getCell('A'.$k)->getValue();
            $opening_bal = $objPHPExcel->getActiveSheet()->getCell('B'.$k)->getValue();
            $debit_bal = $objPHPExcel->getActiveSheet()->getCell('C'.$k)->getValue();
            $credit_bal = $objPHPExcel->getActiveSheet()->getCell('D'.$k)->getValue();
            $closing_bal = ($opening_bal+$debit_bal)-$credit_bal;         

            if($tally_name!='') {
                $tally_result = $this->db->query("Select * from tally_report Where tally_name='$tally_name' and date(added_on)=date(now())")->result();
                if(count($tally_result)>0) {
                    $this->db->where('tally_report_id', $tally_result[0]->tally_report_id);
                    $this->db->delete('tally_report');
                } 

                $result = $this->db->query("Select * from distributor_master Where tally_name='$tally_name'")->result();
                $this->db->last_query();

                if(count($result)>0) {
                    $batch_array[] = array(
                            "tally_name"=>$tally_name,
                            "opening_balance"=>$opening_bal,
                            "debit_bal"=>$debit_bal,
                            "credit_bal"=>$credit_bal,
                            "closing_bal"=>$closing_bal,
                            "added_by"=>$curusr,
                            "added_on"=>$now,
                            "distributer_id"=>$result[0]->id);
                } else {
                    $error ='Tally Name does not found';
                    $objerror =1;
                } 
            } else {
                $error ='Tally Name Is Empty';
                $objerror =1;
            } 
            
            if($error!="") {
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$k, $error);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getAlignment()->setWrapText(true); 
                $objerror =1; 
            }
        }

        if(count($batch_array)>0) {
            $this->db->insert_batch('tally_report',$batch_array);
        }

        if($objerror==1) {
            // $filename='Tally_upload_errors'.'_'.time().'.xlsx';
            // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename="'.$filename.'"');
            // header('Cache-Control: max-age=0');
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            // $objWriter->save('php://output');
            // redirect(base_url().'index.php/Export/set_report_criteria/21');

            $filename='Tally_upload_errors'.'_'.time().'.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');

            $this->session->set_flashdata('error', 'File uploaded with errors.');
        } else {
            $this->session->set_flashdata('error', 'File uploaded successfully.');
        }

        redirect(base_url().'index.php/Export/set_report_criteria/21');
    }

    private function _archieve_and_download($filename) {
        // create zip file on server
        $this->zip->archive('C:/xampp/htdocs/eat_erp_new_30/'.$filename);
         
        // prompt user to download the zip file
        $this->zip->download($filename);
    }

    public function generate_distributor_out_sku_details($status) {

        $this->export_model->generate_sale_invoice_sku_report('Sales','','','','',$status);
        /*$this->distributor_out_model->get_distributor_out_data1($status);*/
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

    public function send_exception_report() {
        $this->export_model->send_exception_report();
    }
} 
?>