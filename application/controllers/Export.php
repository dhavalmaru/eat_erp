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
        }
        else if($rep_id==26){
             $data['report_type'] = 'Distributor Transfer Report';
             $data['report_name'] = 'Distributor Transfer Report';
             $data['sample_report_name'] = 'distributor_transfer.xls';
        }
        else if($rep_id==27){
            $data['report_type'] = 'Raw Material Stock Report';
            $data['report_name'] = 'Raw Material Stock Report';
            $data['sample_report_name'] = 'Raw_Material_Stock_IN_OUT.xls';
        }
		else if($rep_id==28){
             $data['report_type'] = 'Gt Stock Report';
             $data['report_name'] = 'Gt Stock Reoprts';
             $data['sample_report_name'] = 'distributor_transfer.xls';
        }
        else if($rep_id==29){
             $data['report_type'] = 'Sales Attendence';
             $data['report_name'] = 'Sales Attendence Report';
             $data['sample_report_name'] = 'sales_attendence.xls';
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

                $this->export_model->generate_sale_invoice_report($invoicelevel, $invoicelevelsalesreturn, $invoicelevelsample,$date_of_processing,$date_of_accounting,$flag);
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
        }
        else if($rep_id==26) {
             $this->export_model->generate_distributor_transfer_report();
        }
        else if($rep_id==27) {
            $this->export_model->get_raw_material_stock_report();
        }
		
		else if($rep_id==28) {
             $this->export_model->generate_gt_stock_report();
		}
        else if($rep_id==29) {
             $this->export_model->generate_sales_attendence_report();
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
    
    public function send_mt_stock_tracker() {
        $this->export_model->send_mt_stock_tracker();
    }
    
    public function get_production_exception_report(){
        $tbody ='';
        $from_email = 'cs@eatanytime.co.in';
        $from_email_sender = 'Wholesome Habits Pvt Ltd';
        
        $task = $this->export_model->get_task_cnt();
        $pre_production = $this->export_model->get_pre_production_cnt();
        $post_production = $this->export_model->get_post_production_cnt();

        $date = date("d.m.Y");
        $tbody ='';

        if(count($task)>0 || count($pre_production) || count($post_production)) {
            $tbody ='<!DOCTYPE html">
                        <html>
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            <style type="text/css">
                                body {margin: 0; padding: 20px; min-width: 100%!important;font-family "Arial,Helvetica,sans-serif";}
                                img {height: auto;}
                                .content { max-width: 600px;}
                                .header {padding:  20px;}
                                .innerpadding {padding: 30px 30px 30px 30px;}
                                /*.innerpadding1 {padding: 0px 30px 30px 30px;}*/

                                .innerpadding1 tbody td  .innerpadding1 tbody th
                                {
                                border:1px solid #000!important;
                                padding: 0 8px!important;

                                }

                                .borderbottom {border-bottom: 1px solid #f2eeed;}
                                .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
                                .h1, .h2, .bodycopy {color: #fff; font-family: sans-serif;}
                                .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
                                .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
                                .bodycopy {font-size: 16px; line-height: 22px;}
                                .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
                                .button a {color: #ffffff; text-decoration: none;}
                                .footer {padding: 20px 30px 15px 30px;}
                                .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
                                .footercopy a {color: #ffffff; text-decoration: underline;}

                                @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                                body[yahoo] .hide {display: none!important;}
                                body[yahoo] .buttonwrapper {background-color: transparent!important;}
                                body[yahoo] .button {padding: 0px!important;}
                                body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
                                body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
                                }

                                /*@media only screen and (min-device-width: 601px) {
                                .content {width: 600px !important;}
                                .col425 {width: 425px!important;}
                                .col380 {width: 380px!important;}
                                }*/
                                table, th, td {

                                border-collapse: collapse;
                                padding: 0 8px!important;

                                }
                                th,td {
                                padding: 0 8px!important;
                                text-align: left;

                                }

                                th 
                                {
                                color: #fff!important;
                                }
                                .total
                                {
                                    color: #333333;
                                    font-size: 28px;
                                    font-family: Arial,Helvetica,sans-serif;
                                }
                                .used
                                {
                                    color: #666666;
                                    font-size: 20px;
                                    font-family: Arial,Helvetica,sans-serif;
                                }
                                .team_head
                                {
                                    font-size:36px;
                                    font-weight:normal;
                                    color:#fff;
                                    font-family: "Arial,Helvetica,sans-serif";
                                }
                                .date
                                {
                                    font-size:16px;
                                    color:#fff;
                                }
                                .upper_table td
                                {
                                    border:1px solid #000;
                                    text-align:center;
                                         padding: 10px;
                                    
                                }
                                .body_table tbody 
                                {
                                    border:1px solid #000;
                                    background-color:#fff;
                                    color: #000;
                                }
                                .body_table tbody td
                                {
                                    color:#000!important;
                                    padding:0 8px!important;
                                }
                            </style>
                        </head>

                        <body yahoo bgcolor="" style="margin-top:20px;"margin-bottom:20px;">
                        Dear All,
                        <br><br>
                        
                        Kindly find the updated Production Exception report As On '.$date.'
                        
                        <br><br>

                        <table width="350px" bgcolor="" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">';

                        if(count($task)>0) {
                            $tbody.='<tr>
                                <td class="innerpadding1 " style="">
                                <h3>Other Task </h3>
                                <table  class="body_table" style="border-collapse: collapse;width:100%;border:1px solid #000!important;">
                                <thead>
                                    <tr style=" background-color:#002060;color:#fff ;border-bottom: 1px solid #000;font-weight: bold;">
                            
                                      <th width="200" style="border-right: 1px solid #000;padding: 0 8px;text-align:left;width:200px">Employee Name</th>
                                      <th style="border-right: 1px solid #000;padding: 0 8px;text-align: left;width:70px;">Open</th>
                                      <th style="border-right: 1px solid #000;padding: 0 8px;text-align: left;width:70px;">Overdue</th>
                                    </tr>
                                </thead>
                                <tbody style="border:1px solid #000;
                                                background-color: #fff;
                                                color: #000;">';

                            for($i=0; $i<count($task); $i++)
                            {
                                $tbody.= '<tr>
                                    <td style="border-right: 1px solid #000;text-transform:uppercase;font-weight:bold;padding: 0 8px; border-bottom: 1px solid #000;text-align: left;">'.$task[$i]->user_name.'</td>
                                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: right;padding: 0 8px;">'.$task[$i]->open_task.'</td>
                                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: right;padding: 0 8px;">'.$task[$i]->overdue.'</td>
                                
                                    </tr>'; 
                            }
                            
                            $tbody.='</tbody>
                                          </table>
                                        </td>
                                      </tr>';
                        }

                        if(count($pre_production)>0) {
                            $tbody.='<tr>
                                    <td class="innerpadding1 " style="">
                                    <br>
                                    <h3>Pre Production </h3>
                                    <table  class="body_table" style="border-collapse: collapse;width:100%;border:1px solid #000!important;;">
                                    <thead>
                                        <tr style=" background-color:#002060 ;color:#fff ;border-bottom: 1px solid #000;font-weight: bold;">
                                            <th width="300" style="border-right: 1px solid #000;padding:0 8px;text-align:left;width:300px">Production ID</th>
                                            <th style="border-right: 1px solid #000;padding:0 8px;text-align: left;width:70px;">Open</th>
                                            <th style="border-right: 1px solid #000;padding:0 8px;text-align: left;width:70px;">Overdue</th>
                                        </tr>
                                    </thead>
                                    <tbody style="border:1px solid #000;background-color: #fff;color: #000;">';
                                    
                            for($i=0; $i<count($pre_production); $i++)
                            {
                                $tbody.= '<tr>
                                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;padding: 0 8px;width:200px">'.$pre_production[$i]->p_id.'</td>
                                    <td style="border-right: 1px solid #000;text-align: right;border-bottom: 1px solid #000;padding: 0 8px;">'.$pre_production[$i]->open.'</td>
                                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: right;padding: 0 8px;">'.$pre_production[$i]->overdue.'</td>
                                    
                                    </tr>'; 
                            }

                            $tbody.='</tbody>
                                          </table>
                                        </td>
                                      </tr>';
                        }

                        if(count($post_production)>0) {
                            $tbody.='<tr>
                                    <td class="innerpadding1 " style="">
                                    <br>
                                    <h3>Post Production </h3>
                                   <table  class="body_table" style="border-collapse: collapse;width:100%;border:1px solid #000!important;;">
                                    <thead>
                                        <tr style=" background-color:#002060 ;color:#fff ;border-bottom: 1px solid #000;font-weight: bold;">
                                
                                          <th width="300" style="border-right: 1px solid #000;padding:0 8px;text-align:left;width:300px">Production ID</th>
                                          <th style="border-right: 1px solid #000;padding:0 8px;text-align: left;width:70px;" >Open</th>
                                          <th style="border-right: 1px solid #000;padding:0 8px;text-align: left;width:70px;">  
                                                Overdue</th>
                                         
                                          
                                          
                                        </tr>
                                    </thead>
                                    <tbody style="border:1px solid #000;background-color: #fff;color: #000;">';
                                    
                            for($i=0; $i<count($post_production); $i++)
                            {
                                $tbody.= '<tr>
                                            <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;padding: 0 8px;width:200px">'.$post_production[$i]->p_id.'</td>
                                            <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: right;padding: 0 8px;">'.$post_production[$i]->open.'</td>
                                            <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: right;padding: 0 8px;">'.$post_production[$i]->overdue.'</td>
                                        </tr>'; 
                            }

                            $tbody.='</tbody>
                                          </table>
                                        </td>
                                      </tr>';
                        }

                        $tbody.='</table>
                                <!--[if (gte mso 9)|(IE)]>
                                      </td>
                                    </tr>
                                </table>
                                <![endif]-->
                                </td>
                              </tr>
                            </table>

                            <!--analytics-->

                            </body>
                            </html>';
        }
        
        echo $tbody;

        $task_dtl = $this->export_model->get_task_dtl();
        $pre_production_dtl = $this->export_model->get_pre_production_dtl();
        $post_production_dtl = $this->export_model->get_post_production_dtl();

        $filename = '';
        $path = '';
        if(count($task_dtl)>0 || count($pre_production_dtl)>0 || count($post_production_dtl)>0) {
            $this->load->library('excel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $col_name[]=array();
            for($i=0; $i<=20; $i++) {
                $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
            }

            $row=1;
            $col=0;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Wholesome Habits Private Limited");
            $row=$row+2;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Exception Reporting - Production");
            $row=$row+2;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Reporting Date - " . (($date!=null && $date!="")?date("d/m/Y",strtotime($date)):""));

            if(count($task_dtl)>0){
                $row=$row+3;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Task Details');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row)->getFont()->setBold(true);

                $row=$row+2;
                $start_row=$row;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Sr No');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'User Name');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Subject Detail');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Due Date');

                $sr_no = 1;
                for($i=0; $i<count($task_dtl); $i++) {
                    $row=$row+1;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $sr_no++);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $task_dtl[$i]->user_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $task_dtl[$i]->subject_detail);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $task_dtl[$i]->due_date);
                }

                $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':D'.$start_row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':D'.$row)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
            }

            if(count($pre_production_dtl)>0){
                $row=$row+3;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Pre Production Details');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row)->getFont()->setBold(true);

                $row=$row+2;
                $start_row=$row;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Sr No');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Production Id');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Notification');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Due Date');

                $sr_no = 1;
                for($i=0; $i<count($pre_production_dtl); $i++) {
                    $row=$row+1;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $sr_no++);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $pre_production_dtl[$i]->p_id);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $pre_production_dtl[$i]->notification);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $pre_production_dtl[$i]->notification_date);
                }

                $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':D'.$start_row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':D'.$row)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
            }

            if(count($post_production_dtl)>0){
                $row=$row+3;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Post Production Details');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row)->getFont()->setBold(true);

                $row=$row+2;
                $start_row=$row;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Sr No');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Production Id');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Notification');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Due Date');

                $sr_no = 1;
                for($i=0; $i<count($post_production_dtl); $i++) {
                    $row=$row+1;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $sr_no++);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $post_production_dtl[$i]->p_id);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $post_production_dtl[$i]->notification);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $post_production_dtl[$i]->notification_date);
                }

                $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':D'.$start_row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':D'.$row)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
            }

            for ($col = 1; $col <= 20; $col++) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            }

            $filename = 'Production_Report_'.date('d-m-Y').'.xls';
            $path = 'C:/wamp64/www/eat_erp/assets/uploads/production_reports/';
            // $path  = '/home/eatangcp/public_html/test/assets/uploads/production_reports/';
            // $path='/home/eatangcp/public_html/eat_erp/assets/uploads/production_reports/';

            $upload_path = 'C:/wamp64/www/eat_erp/assets/uploads/production_reports';
            // $upload_path = '/home/eatangcp/public_html/test/assets/uploads/production_reports';
            // $upload_path = '/home/eatangcp/public_html/eat_erp/assets/uploads/production_reports';
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment;filename="'.$filename.'"');
            // header('Cache-Control: max-age=0');
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            // $objWriter->save('php://output');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
            $objWriter->save($path.$filename);
        }

        $attachment = $path.$filename;
        // $attachment = 'C:\wamp64\www\eat_erp\assets\uploads\production_reports\Production_Report_'.date('d-m-Y').'.xls';
        // $attachment = '';


        //// $to_email = "dhaval.maru@pecanreams.com";
        //$bcc = "dhaval.maru@pecanreams.com";

        // $to_email = "ashwini.patil@pecanreams.com";
        // $bcc = "ashwini.patil@pecanreams.com";
        
        $to_email = "prasad.bhisale@pecanreams.com";
        $cc = "dhaval.maru@pecanreams.com";
        $bcc = "prasad.bhisale@pecanreams.com";
        
        /*$to_email = "ravi.hirode@eatanytime.co.in, mukesh.yadav@eatanytime.co.in, sulochana.waghmare@eatanytime.co.in, manorama.mishra@eatanytime.co.in, mahesh.ms@eatanytime.co.in, yash.doshi@eatanytime.in, darshan.dhany@eatanytime.co.in, sachin.pal@eatanytime.co.in, girish.rai@eatanytime.in, nitin.kumar@eatanytime.co.in, urvi.bhayani@eatanytime.co.in, mohil.telawade@eatanytime.co.in";
        $bcc = "ashwini.patil@pecanreams.com, dhaval.maru@pecanreams.com, sangeeta.yadav@pecanreams.com,prasad.bhisale@pecanreams.com";
        $cc = "rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in, operations@eatanytime.in, mis@eatanytime.in, priti.tripathi@eatanytime.in";*/

        $subject = 'Production Exception Report -'.date("d F Y",strtotime("now"));

        echo '<br/><br/>mail '.$mailSent=send_email_new($from_email, $from_email_sender, $to_email, $subject, $tbody, $bcc, $cc, $attachment);
        if ($mailSent==1) {
            echo "Send";
        } else {
            echo "NOT Send".$mailSent;
        }

        // load_view('invoice/emailer', $data); 
    }

    public function send_sales_rep_exception_report() {
        $this->export_model->sales_rep_exception_report();
    }
} 
?>