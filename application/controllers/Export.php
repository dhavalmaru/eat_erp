<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Export extends CI_Controller {
    public function __construct() {
        // ini_set('max_execution_time', 1000); 
        // ini_set('memory_limit','2048M');

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
        $this->load->model('depot_model');
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
		} else if($rep_id==22){
            $data['report_type'] = 'Loader Screen Report';
            $data['report_name'] = 'Loader Screen Report';
            $data['sample_report_name'] = 'screen_loader_time_report.xlsx';
        } else if($rep_id==23){
            $data['report_type'] = 'sales_rep_route_plan';
            $data['report_name'] = 'Sales Representative Route Plan ';
            $data['sample_report_name'] = 'sales_rep_route_plan.xls';
        } else if($rep_id==24){
            $data['report_type'] = 'merchendizer_rep_route_plan';
            $data['report_name'] = 'Merchandizer Route Plan';
            $data['sample_report_name'] = 'merchendizer_rep_route_plan.xls';
        } else if($rep_id==25){
            $data['report_type'] = 'MT Stock Tracker';
            $data['report_name'] = 'MT Stock Tracker';
            $data['sample_report_name'] = 'mt_stock_tracker.xls';
        } else if($rep_id==26){
            $data['report_type'] = 'Distributor Transfer Report';
            $data['report_name'] = 'Distributor Transfer Report';
            $data['sample_report_name'] = 'distributor_transfer.xls';
        } else if($rep_id==27){
            $data['report_type'] = 'Raw Material Stock Report';
            $data['report_name'] = 'Raw Material Stock Report';
            $data['sample_report_name'] = 'Raw_Material_Stock_IN_OUT.xls';
        } else if($rep_id==28){
            $data['report_type'] = 'Gt Stock Report';
            $data['report_name'] = 'Gt Stock Reoprts';
            $data['sample_report_name'] = 'distributor_transfer.xls';
        } else if($rep_id==29){
            $data['report_type'] = 'Sales Attendence';
            $data['report_name'] = 'Sales Attendence Report';
            $data['sample_report_name'] = 'sales_attendence.xls';
        } else if($rep_id==30){
            $data['report_type'] = 'gt_store';
            $data['report_name'] = 'GT Store Health Report';
            $data['sample_report_name'] = 'store_wise_sales.xls';
        } else if($rep_id==31){
            $data['report_type'] = 'Monthly Sales';
            $data['report_name'] = 'Monthly Sales Overview Report';
            $data['sample_report_name'] = 'monthly_sales_overview.xls';
        } else if($rep_id==32){
            $data['report_type'] = 'Zonewise Monthly Sales';
            $data['report_name'] = 'Zonewise Monthly Sales Overview Report';
            $data['sample_report_name'] = 'zonewise_monthly_sales_overview.xls';
        } else if($rep_id==33){
            $data['report_type'] = 'Beat Plan Analysis';
            $data['report_name'] = 'Beat Plan Analysis Report';
            $data['sample_report_name'] = 'Beat_plan_analysis_report.xls';
        } else if($rep_id==34){
            $data['report_type'] = 'Daily sales performance report';
            $data['report_name'] = 'Daily sales performance report';
            $data['sample_report_name'] = 'Daily_sales_performance_report.xls';
        } else if($rep_id==35){
            $data['report_type'] = 'Daily Merchandizer performance report';
            $data['report_name'] = 'Daily Merchandizer performance report';
            $data['sample_report_name'] = 'Daily_merchandiser_performance_report.xls';
        } else if($rep_id==36){
            $data['report_type'] = 'Sales Summary report';
            $data['report_name'] = 'Sales Summary report';
            $data['sample_report_name'] = 'Sales_summary_report.xls';
        }

        if($rep_id==16 || $rep_id==17){
            $this->getledgerreport();
        } else {
            $data['report_id'] = $rep_id;
            $data['distributor'] = $this->distributor_model->get_data('Approved');
            $data['salesrep'] = $this->sales_rep_model->get_data_dist('Approved');
            $data['promoter'] = $this->sales_rep_model->get_data_promoter('Approved');
            $data['ledger'] = $this->accountledger_model->get_ledger_data('Approved');
            $data['depot'] = $this->depot_model->get_data('Approved');
            $data['upload_telly_report'] = $this->export_model->get_upload_telly_report();
            $data['location'] = $this->export_model->get_gt_location();
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
			  $remark_visibility=$this->input->post('remark_visibility');
            //if($this->input->post('download') == "Download Report") {
            $this->export_model->generate_distributor_ledger_report($remark_visibility);
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
            $dist_transfer=$this->input->post('dist_transfer');
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
            // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/excel_upload/';

            $path = $this->config->item('upload_path').'excel_upload/';
            
            $flag = 0;

            if(($invoicelevel!="" || $invoicelevelsalesreturn!="" || $invoicelevelsample!="") && ($sales!='' || $ssallocation!='' || $salesreturn!='' || $sample!='' || $credit_debit!='' || $status_type!='' || $dist_transfer!=''))
            {
                $flag=1;
            }
            if($invoicelevel!="" || $invoicelevelsalesreturn!="" || $invoicelevelsample!="") {

                $this->export_model->generate_sale_invoice_report($invoicelevel, $invoicelevelsalesreturn, $invoicelevelsample,$date_of_processing,$date_of_accounting,$flag);
                if($flag==1)
                    $this->zip->read_file($path.'Sale_Invoice_Report.xls');
            
            }

            // echo $date_of_accounting;
            // echo '<br/><br/>';
            // echo $date_of_processing;

            // echo $dist_transfer;

            if($sales!='' || $ssallocation!='' || $salesreturn!='' || $sample!='' || $credit_debit!='' || $status_type!='' || $dist_transfer!='')
            {
                $this->export_model->generate_sale_invoice_sku_report($sales,$ssallocation,$salesreturn,$sample,$credit_debit,$status_type,$date_of_processing,$date_of_accounting,$flag,$dist_transfer);

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
            if($this->input->post('btn_adjus')!=null)
            {
                $result = $this->export_model->get_adjustment_bal();
                $adjusmentbal = $result[0]->adjusmentbal;
                $adjusmentbal = floatval($adjusmentbal);
                if($adjusmentbal>floatval(100.00))
                {
                   $this->session->set_flashdata('adj_message', 'Total Adjustment Amount Should be Less Then 100');
                }
                else
                {
                    $leager_result = $this->export_model->get_ledger_details();
                    $now=date('Y-m-d H:i:s');
                    $curusr=$this->session->userdata('session_id');
                    $batch_unique_array = [];


                     if(count($leager_result)>0)
                    {
                        for ($i=0; $i <count($leager_result) ; $i++) { 
                                $transaction = $leager_result[$i]['transaction_type'];
                                $dist_id = $leager_result[$i]['dist_id'];
                                $amount = $leager_result[$i]['closingbalance'];
                                $data = array(
                                    'date_of_transaction' => $now,
                                    'distributor_id' => $dist_id,
                                    'transaction' => $transaction,
                                    'invoice_no' => NULL,
                                    'distributor_type' => 'Promotion',
                                    'amount' => abs($amount),
                                    'tax' => NULL,
                                    'igst' => NULL,
                                    'cgst' => NULL,
                                    'sgst' => NULL,
                                    'amount_without_tax' => NULL,
                                    'status' => 'Approved',
                                    'remarks' => 'Adjusted through Ledger Balance',
                                    'created_by' => $curusr,
                                    'created_on' => $now,
                                    'modified_by' => $curusr,
                                    'modified_on' => $now,
                                    'ref_id' => NULL,
                                    'ref_no' => NULL,
                                    'ref_date' => NULL
                                );
                                $batch_unique_array[]=$data; 
                        }
                    }

                    if(count($batch_unique_array)>0)
                    {
                        $this->export_model->save_credit_debit($batch_unique_array);
                        $this->session->set_flashdata('adj_message', 'Closing balance Adjusted'); 
                    }
                    else
                    {
                        $this->session->set_flashdata('adj_message', 'Ledger Entries Not found');  
                    }
                    
                }
            }
            else
            {
             if($this->input->post('excel_upload')!='' && $this->input->post('includes_twenty')!=20)
                {
                    $this->export_model->upload_distributor_balance_ledger_report();
                }
                else
                {
                    $this->export_model->generate_distributor_balance_ledger_report();
                }   
            }

            

            /*$this->export_model->generate_distributor_balance_ledger_report();*/
        } else if($rep_id==21) {
            $this->export_model->upload_distributor_balance_ledger_report();
        } else if($rep_id==22) {
            $this->export_model->generate_loader_screen_report();
        } else if($rep_id==23) {
            $result1 = $this->export_model->sales_rep_route_plan();
            $result2 = $this->export_model->sales_rep_route_plan_summary();

            $from_date = formatdate($this->input->post('from_date'));
            $to_date = formatdate($this->input->post('to_date'));    

            $template_path=$this->config->item('template_path');
            $file = $template_path.'sales_rep_route_plan.xls';
            $this->load->library('excel');
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $objPHPExcel->setActiveSheetIndex(0);

            $col_name[]=array();
            for($i=0; $i<=10; $i++) {
                $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
            }

            $row=1;
            $col=0;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "From Date");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $from_date);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "To Date");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $to_date);


            $row=3;
            $col=0;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "SR NO");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Retailer Name");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Sales Rep name");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Route Day");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Last Visit");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Days From Visit");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Total No of  Orders as of Today");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Total Current Inventory");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Total no of Orders Between Dates");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Qty of Orders");

             $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->applyFromArray(array(

                'borders' => array(

                    'allborders' => array(

                        'style' => PHPExcel_Style_Border::BORDER_THIN

                    )

                )

            ));

            $row=$row+1;

            for($j=0;$j<count($result1);$j++)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,($j+1));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $result1[$j]->distributor_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $result1[$j]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result1[$j]->frequency);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $result1[$j]->last_visit);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $result1[$j]->days_diff);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $result1[$j]->totalnooforders);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $result1[$j]->current_stock);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $result1[$j]->betweennooforders);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $result1[$j]->total_ods_unit);                

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->applyFromArray(array(

                    'borders' => array(

                        'allborders' => array(

                            'style' => PHPExcel_Style_Border::BORDER_THIN

                        )

                    )

                ));

                $row = $row+1;
            }

            for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            }

            $objPHPExcel->setActiveSheetIndex(1);
            $row=1;
            $col=0;
            $col_name[]=array();
            for($i=0; $i<=10; $i++) {
                $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Summary Report ");

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);

            $row = $row+1;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "SR NO");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Sales Rep name");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Total Retailers");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Planned Routes");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Visited Routes");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Last Visit Between 1 to 10 days");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Last Visit Between 10 to 20 days");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Last Visit >=20 days");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);

    

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray(array(

                'borders' => array(

                    'allborders' => array(

                        'style' => PHPExcel_Style_Border::BORDER_THIN

                    )

                )

            ));


            $row = $row+1;

            for($j=0;$j<count($result2);$j++)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,($j+1));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $result2[$j]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $result2[$j]->total_store);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result2[$j]->planned_store);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $result2[$j]->visited_store);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $result2[$j]->betweenten);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $result2[$j]->betweentwenty);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $result2[$j]->betweenthirty);
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray(array(

                    'borders' => array(

                        'allborders' => array(

                            'style' => PHPExcel_Style_Border::BORDER_THIN

                        )

                    )

                ));

                $row = $row+1;
            }      

            for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            }

            $filename = 'sales_rep_route_plan.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else if($rep_id==24) {
            $result1 = $this->export_model->merchendizer_rep_route_plan();
            $result2 = $this->export_model->merchendizer_rep_route_plan_summary();

            $from_date = formatdate($this->input->post('from_date'));
            $to_date = formatdate($this->input->post('to_date'));    

            $template_path=$this->config->item('template_path');
            $file = $template_path.'merchendizer_rep_route_plan.xls';
            $this->load->library('excel');
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $objPHPExcel->setActiveSheetIndex(0);

            $col_name[]=array();
            for($i=0; $i<=10; $i++) {
                $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
            }

            $row=1;
            $col=0;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "From Date");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $from_date);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "To Date");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $to_date);


            $row=3;
            $col=0;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "SR NO");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Retailer Name");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Sales Rep name");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Route Day");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Last Visit");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Days From Visit");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Total Current Inventory");

             $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(

                'borders' => array(

                    'allborders' => array(

                        'style' => PHPExcel_Style_Border::BORDER_THIN

                    )

                )

            ));

            $row=$row+1;

            for($j=0;$j<count($result1);$j++)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,($j+1));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,($result1[$j]->store_name.'( - '.$result1[$j]->location.' )'));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $result1[$j]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result1[$j]->frequency);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $result1[$j]->last_visit);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $result1[$j]->days_diff);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $result1[$j]->current_stock);               

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(

                    'borders' => array(

                        'allborders' => array(

                            'style' => PHPExcel_Style_Border::BORDER_THIN

                        )

                    )

                ));

                $row = $row+1;
            }

            for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            }

            $objPHPExcel->setActiveSheetIndex(1);
            $row=1;
            $col=0;
            $col_name[]=array();
            for($i=0; $i<=10; $i++) {
                $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Summary Report ");

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);

            $row = $row+1;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "SR NO");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Sales Rep name");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Total Retailers");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Planned Routes");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Visited Routes");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Last Visit Between 1 to 10 days");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Last Visit Between 10 to 20 days");
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Last Visit >=20 days");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);

    

            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray(array(

                'borders' => array(

                    'allborders' => array(

                        'style' => PHPExcel_Style_Border::BORDER_THIN

                    )

                )

            ));


            $row = $row+1;

            for($j=0;$j<count($result2);$j++)
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,($j+1));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $result2[$j]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $result2[$j]->total_store);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result2[$j]->planned_store);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $result2[$j]->visited_store);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $result2[$j]->betweenten);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $result2[$j]->betweentwenty);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $result2[$j]->betweenthirty);
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->applyFromArray(array(

                    'borders' => array(

                        'allborders' => array(

                            'style' => PHPExcel_Style_Border::BORDER_THIN

                        )

                    )

                ));

                $row = $row+1;
            }      

            for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            }

            $filename = 'merchendizer_rep_route_plan.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        } else if($rep_id==25) {
            $this->export_model->generate_mt_stock_report();
        } else if($rep_id==26) {
             $this->export_model->generate_distributor_transfer_report();
        } else if($rep_id==27) {
            $this->export_model->get_raw_material_stock_report();
        } else if($rep_id==28) {
             $this->export_model->generate_gt_stock_report();
		} else if($rep_id==29) {
             $this->export_model->generate_sales_attendence_report();
        } else if($rep_id==30) {
            $location = $this->input->post("location");
            $this->export_model->gt_store_report('save',$location);
        } else if($rep_id==31) {
            $this->export_model->generate_monthly_sales_overview_report();
        } else if($rep_id==32) {
            $this->export_model->generate_monthly_sales_overview_zonewise_report();
        } else if($rep_id==33) {
            $this->export_model->generate_beat_analysis_report();
        } else if($rep_id==34) {
            $this->export_model->generate_daily_sales_performance_report();
        } else if($rep_id==35) {
            $this->export_model->generate_daily_merchandiser_performance_report();
        } else if($rep_id==36) {
            if($this->input->post('from_date')=="" && $this->input->post('to_date')=="")
            {
                $from_date = '2017-01-01';
                $to_date = date("Y-m-d");
            }
            else
            {
                $from_date = formatdate($this->input->post('from_date'));
                $to_date = formatdate($this->input->post('to_date'));
            }

            $this->export_model->generate_sales_summary_report($from_date, $to_date);
        }
        
        $this->set_report_criteria($rep_id);
    }

    public function test_month(){
        // $start = new DateTime('2018-04-25');
        // $start->modify('first day of this month');
        // $end = new DateTime('2019-06-20');
        // $end->modify('first day of next month');
        // $interval = DateInterval::createFromDateString('1 month');
        // $period = new DatePeriod($start, $interval, $end);

        // foreach ($period as $dt) {
        //     echo $dt->format("M-y") . "<br>\n";
        //     echo $dt->format("m") . "<br>\n";
        // }

        // echo json_encode($period);

        // $this->export_model->generate_monthly_sales_overview_report();
        $this->export_model->generate_monthly_sales_overview_zonewise_report();
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
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Error Remark');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objerror = 0;
        $error_line = '';
        $batch_array = array();

        for($k=2;$k<=$highestrow;$k++) { 
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
            $filename = $new_name;
            $telly_date = date("Y-m-d");//formatdate($this->input->post('telly_date'));
            $data = array("telly_date"=>$telly_date,
                          "file_name"=>$filename,
                          "added_by"=>$curusr,
                          "added_on"=>$now);
            $this->db->insert('telly_report_upload',$data);
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

        redirect(base_url().'index.php/Export/set_report_criteria/20');
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
        $remark_visibility=$this->input->post('remark_visibility');
        $result = $this->export_model->view_distributor_ledger_report($remark_visibility);

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

    public function view_system_report($rep_id) {
       $result = $this->export_model->view_generate_distributor_balance_ledger_report();
       echo $result;
    }
    
    public function send_product_stock_report() {
        $this->export_model->send_product_stock_report();
    }
    
    public function send_mt_stock_tracker() {
        $this->export_model->send_mt_stock_tracker();
    }
    
    public function send_mt_stock_tracker_weekly() {
        $this->export_model->send_mt_stock_tracker_weekly();
    }
    
    public function send_production_exception_report(){
        $this->export_model->send_production_exception_report();
    }

    public function send_sales_rep_exception_report() {
        $this->export_model->sales_rep_exception_report();
    }

    public function gt_store_report() {
      $this->export_model->gt_store_report();
    }

    public function test_mail() {
        $message = '<html>
                    <body>
                        <h3>Wholesome Habits Private Limited</h3>
                        <h4>Test</h4>
                        <br/><br/>
                        Regards,
                        <br/><br/>
                        CS
                    </body>
                    </html>';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'Wholesome Habits Pvt Ltd';
        $subject = 'Test Mail';

        $to_email = "prasad.bhisale@otbconsulting.co.in";
        $cc = 'prasad.bhisale@otbconsulting.co.in';
        $bcc = 'prasad.bhisale@otbconsulting.co.in';

        $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, '');

        // $mailSent=1;
        
        // echo $message;
        // echo '<br/><br/>';
        echo $mailSent;
        echo '<br/><br/>';
    }
    
    public function send_beat_analysis_report() {
        $this->export_model->send_beat_analysis_report('Weekly');
    }
    
    public function send_daily_sales_performance_report() {
        $this->export_model->send_daily_sales_performance_report();
    }
    
    public function send_daily_merchandiser_performance_report() {
        $this->export_model->send_daily_merchandiser_performance_report();
    }
    
    public function send_weekly_sales_performance_report() {
        $this->export_model->send_daily_sales_performance_report('Weekly');
    }
    
    public function send_weekly_merchandiser_performance_report() {
        $this->export_model->send_daily_merchandiser_performance_report('Weekly');
    }
    
    public function generate_sales_summary_report($month, $year){
        if($month=="" || $year=="" || is_numeric($month)==false || is_numeric($year)==false)
        {
            $from_date = '2017-01-01';
            $to_date = date("Y-m-d");
        }
        else
        {
            if(strlen($month)==1){
                $month = '0'.$month;
            }

            $from_date = $year.'-'.$month.'-01';
            $to_date = $year.'-'.$month;

            $month = intval($month);

            if($month==2){
                $year = intval($year);
                if(($year%4)==0){
                    $to_date = $to_date.'-29';
                } else {
                    $to_date = $to_date.'-28';
                }
            } else if($month==4 || $month==6 || $month==9 || $month==11){
                $to_date = $to_date.'-30';
            } else {
                $to_date = $to_date.'-31';
            }
        }

        $this->export_model->generate_sales_summary_report($from_date, $to_date);
    }
} 
?>