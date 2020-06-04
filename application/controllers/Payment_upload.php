<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Payment_upload extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('payment_upload_model');
        $this->load->model('distributor_out_model');
        $this->load->model('tax_invoice_model');
        $this->load->library('excel');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->payment_upload_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->payment_upload_model->get_data();

            load_view('payment/payment_upload', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function download_upload_format(){
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Payment_upload_format.xlsx';
        // $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(1);

        $row = 2;
        $sql = "select * from bank_master where status='Approved' order by b_name";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $data) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data->b_name);
            $row = $row+1;
        }
        $bank_cnt = $row;

        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Cash');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Cheque');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'NEFT');
        $payment_mode_cnt = 5;

        $row = 2;
        $sql = "select * from distributor_master where status='Approved' order by distributor_name";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $data) {
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data->distributor_name);
            $row = $row+1;
        }
        $dist_cnt = $row;

        $objPHPExcel->setActiveSheetIndex(0);
        for($row=5; $row<=105; $row++) {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$A$2:$A$'.($bank_cnt-1));

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$C$2:$C$'.($payment_mode_cnt-1));

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$E$2:$E$'.($dist_cnt-1));
        }

        $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $filename='payment_upload_format.xlsx';
        
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        // header('Content-Type: application/pdf');
        // header('Content-Disposition: attachment;filename="01simple.pdf"');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
        // $objWriter->save('php://output');
    }

    public function test(){
        // $template_path=$this->config->item('template_path');
        // $file = 'E:/wamp64/www/eat_erp/assets/uploads/payment_upload/1580471219_payment_upload_format_1.xlsx';
        $file = 'E:/wamp64/www/eat_erp/assets/uploads/payment_upload/1580554512_GOQII_payment_upload_format.xlsx';
        // $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $objPHPExcel->setActiveSheetIndex(0);
        $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->setCellValue('W4', 'Error Remark');

        $creation_date = $objPHPExcel->getActiveSheet()->getCell('A5')->getValue();
        $creation_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($creation_date));
        echo $creation_date;
        echo '<br/><br/>';

        if(validateDate($creation_date, 'Y-m-d')==false){
            echo 'not valid';
        } else {
            echo 'valid';
        }

        unset($objPHPExcel);

        // $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        // $filename='payment_upload_format.xlsx';
        // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter->save('php://output');

        // $url = base_url().'index.php/Stock/check_box_availablity_for_depot';
        // $r = new HttpRequest($url, HttpRequest::METH_POST);
        // // $r->setOptions(array('cookies' => array('lang' => 'de')));
        // $r->addPostFields(array('depot_id' => 'mike', 'box_id' => '49'));

        // try {
        //     echo $r->send()->getBody();
        // } catch (HttpException $ex) {
        //     echo $ex;
        // }

        // $url = base_url().'index.php/Stock/check_box_availablity_for_depot';
        // $url = base_url().'index.php/Stock/check_box_qty_availablity_for_depot';
        // $params = array('depot_id' => '2', 'box_id' => '56', 'qty' => '5');

        // $query_content = http_build_query($params);
        // $fp = fopen($url, 'r', FALSE, // do not use_include_path
        // stream_context_create([
        //     'http' => [
        //         'header'  => [ // header array does not need '\r\n'
        //             'Content-type: application/x-www-form-urlencoded',
        //             'Content-Length: ' . strlen($query_content)
        //         ],
        //         'method'  => 'POST',
        //         'content' => $query_content
        //     ]
        // ]));
        // if ($fp === FALSE) {
        //     echo json_encode(['error' => 'Failed to get contents...']);
        // }
        // $result = stream_get_contents($fp); // no maxlength/offset
        // fclose($fp);
        // echo $result;
    }

    public function test_upload(){
        //Check valid spreadsheet has been uploaded
        // echo 'test_upload';
        // exit;

        if(isset($_FILES['upload'])){
            if($_FILES['upload']['name']){
                if(!$_FILES['upload']['error'])
                {
                    $inputFile = $_FILES['upload']['name'];
                    $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
                    if($extension == 'XLSX' || $extension == 'ODS'){

                        //Read spreadsheeet workbook
                        try {
                            $inputFile = $_FILES['upload']['tmp_name'];
                            $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                            $objPHPExcel = $objReader->load($inputFile);
                        } catch(Exception $e) {
                            die($e->getMessage());
                        }

                        //Get worksheet dimensions
                        $sheet = $objPHPExcel->getSheet(0); 
                        $highestRow = $sheet->getHighestRow(); 
                        $highestColumn = $sheet->getHighestColumn();

                        echo $sheet->cell('A1').getValue();

                        //Loop through each row of the worksheet in turn
                        // for ($row = 1; $row <= $highestRow; $row++){ 
                            //  Read a row of data into an array
                            // echo $sheet->cell('A1').getValue();
                            // $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                            // echo json_encode($rowData);
                            //Insert into database
                        // }
                    }
                    else{
                        echo "Please upload an XLSX or ODS file";
                    }
                }
                else{
                    echo $_FILES['spreadsheet']['error'];
                }
            }
        }

        $template_path=$this->config->item('template_path');
        $file = 'E:/wamp64/www/eat_erp/assets/uploads/payment_upload/1580471219_payment_upload_format_1.xlsx';
        $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->setActiveSheetIndex(0);
        // $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        // $objPHPExcel->getActiveSheet()->setCellValue('W4', 'Error Remark');
        
        // $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $filename='payment_upload_format.xlsx';

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        sleep(0.50);

        echo 'upload file';
        exit;
    }

    public function upload_file(){
        $now=date('Y-m-d H:i:s');
        $curdate=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');

        $upload_path=$this->config->item('upload_path');
        $path=$upload_path.'payment_upload/';
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
        // $filename = str_replace('/', '\\', $filename);
        // print_r($filename);
        // exit;

        $sql = "insert into payment_upload_files (file_name, file_path, upload_date, status, created_by, created_on, modified_by, modified_on) VALUES ('".$file_name."', '".$path."', '".$curdate."', 'Uploading', '".$curusr."', '".$now."', '".$curusr."', '".$now."')";
        $this->db->query($sql);
        // $file_id = $this->db->insert_id();

        sleep(0.50);

        $this->session->set_flashdata('success', 'File Upload Succeded.<br/>Please upload file data.');
        $this->session->keep_flashdata('success');
        redirect(base_url().'index.php/Payment_upload');
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

    public function upload_file_data($file_id){
        $now=date('Y-m-d H:i:s');
        $curdate=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');

        $sql = "select * from payment_upload_files where id='$file_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $file_path = $result[0]->file_path;
            $file_name = $result[0]->file_name;
            $filename = $result[0]->file_path.$result[0]->file_name;
        } else {
            $file_path = '';
            $file_name = '';
            $filename = '';
        }

        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($filename);
        $objPHPExcel->setActiveSheetIndex(0);
        $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $objPHPExcel->getActiveSheet()->setCellValue('I4', 'Error Remark');
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objerror = 0;
        $error_line = '';
        $payment_array = [];

        for($i=5; $i<=$highestrow; $i++){
            $creation_date = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
            $bank = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $payment_mode = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $distributor_name = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $invoice_no = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
            $neft_no = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $payment_amount = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $remarks = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            $error = '';
            $bank_id = '';
            $distributor_id = '';
            $invoice_amount = 0;
            $balance_amount = 0;

            //-------------- Validation Start ------------------------------
                $bl_error_line = false;

                if($creation_date==''){
                    $error.='Creation date cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $creation_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($creation_date));
                    if(validateDate($creation_date, 'Y-m-d')==false){
                        $error.='Creation date should be in d-m-Y format.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }
                }

                if($bank==''){
                    $error.='Bank Name cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $sql = "select * from bank_master where b_name='$bank'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)==0){
                        $error.='Bank Name '.$bank.' not found.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $bank_id = $result[0]->id;
                    }
                }
                if($payment_mode==''){
                    $error.='Payment Mode cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    if($payment_mode!='Cash' && $payment_mode!='Cheque' && $payment_mode!='NEFT'){
                        $error.='Payment Mode should be Cash, Cheque or NEFT.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }
                }
                if($distributor_name==''){
                    $error.='Distributor Name cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $sql = "select * from distributor_master where distributor_name='$distributor_name'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)==0){
                        $error.='Distributor Name '.$distributor_name.' not found.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $distributor_id = $result[0]->id;
                    }
                }
                if($invoice_no==''){
                    $error.='Invoice No cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else if($invoice_no=='On Account'){
                    // Do Nothing
                } else {
                    $invoice_no = str_replace('"', '', $invoice_no);
                    $invoice_no = str_replace("'", "", $invoice_no);

                    $sql = "select * from distributor_out where status = 'Approved' and invoice_no='$invoice_no'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)==0){
                        $error.='Invoice No '.$invoice_no.' Not Found.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $sql = "select * from 
                                (select A.distributor_id, A.invoice_no, A.client_name, A.invoice_amount, (ifnull(A.invoice_amount,0)-ifnull(B.tot_payment_amount,0)) as balance_amount,
                                    (ifnull(A.invoice_amount,0)-ifnull(B.tot_payment_amount,0)-ifnull(C.tot_payment_amount,0)) as final_amount from 
                                (select * from distributor_out where status = 'Approved' and invoice_no = '$invoice_no') A 
                                left join 
                                (select A.distributor_id, A.invoice_no, sum(A.payment_amount) as tot_payment_amount from payment_details_items A left join payment_details B on (A.payment_id=B.id) 
                                    where A.invoice_no = '$invoice_no' and B.status = 'Approved' group by A.distributor_id, A.invoice_no) B 
                                on (A.distributor_id=B.distributor_id and A.invoice_no=B.invoice_no) 
                                left join 
                                (select A.distributor_id, A.invoice_no, sum(A.payment_amount) as tot_payment_amount from payment_upload_items A left join payment_upload_details B on (A.payment_id=B.id) 
                                    where A.invoice_no = '$invoice_no' and B.status <> 'Rejected' group by A.distributor_id, A.invoice_no) C 
                                on (A.distributor_id=C.distributor_id and A.invoice_no=C.invoice_no)) D";
                        $result = $this->db->query($sql)->result();
                        if(count($result)==0){
                            $error.='Invoice No '.$invoice_no.' Not Found.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        } else {
                            $invoice_amount = $result[0]->invoice_amount;
                            $balance_amount = $result[0]->balance_amount;
                            $final_amount = $result[0]->final_amount;
                            if(!is_numeric($final_amount)){
                                $final_amount = 0;
                            }

                            if($final_amount<=-5){
                                // echo $sql;
                                // echo '<br/><br/>'
                                $error.=$sql.' Payment Amount '.$payment_amount.' is greater than balance invoice amount.';
                                $objerror=1;
                                if($bl_error_line==false){
                                    $error_line.=$i.', ';
                                    $bl_error_line=true;
                                }
                            }
                        }
                    }
                }
                if($neft_no==''){
                    $error.='NEFT No cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                }
                if($payment_amount==''){
                    $error.='Payment Amount cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else if($payment_amount==0){
                    $error.='Payment Amount should be greater zero.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                }

                if($error!=""){
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $error);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setWrapText(true);  
                }
            //-------------- Validation End ------------------------------

            if($objerror!=1){
                $bl_flag=false;
                $j=0;
                $items_array = [];
                $k=0;

                for($j=0; $j<count($payment_array); $j++){
                    if($payment_array[$j]['date_of_deposit']==$creation_date && $payment_array[$j]['bank_id']==$bank_id && $payment_array[$j]['payment_mode']==$payment_mode){
                        $bl_flag=true;
                        break;
                    }
                }

                if($bl_flag==false){
                    $j=count($payment_array);

                    // $payment_array[$j]['date_of_deposit']=FormatDate($date_of_deposit);
                    $payment_array[$j]['date_of_deposit']=$creation_date;
                    $payment_array[$j]['bank_id']=$bank_id;
                    $payment_array[$j]['payment_mode']=$payment_mode;
                    $payment_array[$j]['remarks']=$remarks;
                    $payment_array[$j]['total_amount']=0;

                    $k=0;
                } else {
                    $items_array=$payment_array[$j]['items_array'];
                    $k=count($items_array);
                }

                $items_array[$k]['distributor_id']=$distributor_id;
                $items_array[$k]['ref_no']=$neft_no;
                $items_array[$k]['invoice_no']=$invoice_no;
                $items_array[$k]['payment_amount']=$payment_amount;
                $items_array[$k]['row_num']=$i;
                $items_array[$k]['invoice_amount']=$invoice_amount;
                $items_array[$k]['balance_amount']=$balance_amount;
                $items_array[$k]['final_amount']=$final_amount;

                $payment_array[$j]['items_array']=$items_array;

                $payment_array[$j]['total_amount']=doubleval($payment_array[$j]['total_amount'])+doubleval($payment_amount);
            }
        }

        $upload_path=$this->config->item('upload_path');
        $path=$upload_path.'payment_upload/';
        if(strrpos($file_name, '.')>0){
            $ext = substr($file_name, strrpos($file_name, '.'));
        } else {
            $ext = '.xlsx';
        }

        if($objerror==1){
            $error_file_path = $path;
            $error_file_name = time().'_file_'.$file_id.'_error'.$ext;
            $status = 'Error';
            // $remarks = 'There are errors in file on line '.$error_line.'. <br/>Please check - '.$error_file_name;
            $remarks = 'Please check - '.$error_file_name.' file for errors.';

            // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename="'.$error_file_name.'"');
            // header('Cache-Control: max-age=0');
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            // $objWriter->save('php://output');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($error_file_path.$error_file_name);
        
            sleep(0.50);

            $sql = "update payment_upload_files set error_file_path='".$error_file_path."', error_file_name='".$error_file_name."', status = '".$status."', remarks = '".$remarks."', modified_by = '".$curusr."', modified_on = '".$now."' where id='".$file_id."'";
            $this->db->query($sql);

            sleep(0.50);

            $this->session->set_flashdata('error', $remarks);
            $this->session->keep_flashdata('error');
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('I4', 'Inv Amount');
            $objPHPExcel->getActiveSheet()->setCellValue('J4', 'Bal Amount');

            for($i=0; $i<count($payment_array); $i++){
                $items_array = $payment_array[$i]['items_array'];

                for($j=0; $j<count($items_array); $j++) {
                    $row_num = $items_array[$j]['row_num'];
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row_num, $items_array[$j]['invoice_amount']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row_num, $items_array[$j]['final_amount']);
                }
            }

            // echo json_encode($payment_array);
            // echo '<br/><br/>';

            $success_cnt = 0;
            $fail_cnt = 0;

            for($k=0; $k<count($payment_array); $k++) {
                $date_of_deposit = $payment_array[$k]['date_of_deposit'];
                $bank_id = $payment_array[$k]['bank_id'];
                $payment_mode = $payment_array[$k]['payment_mode'];
                $total_amount = $payment_array[$k]['total_amount'];
                $remarks = $payment_array[$k]['remarks'];

                $items_array = $payment_array[$k]['items_array'];

                $sql = "insert into payment_upload_details (file_id, date_of_deposit, bank_id, payment_mode, total_amount, status, remarks, created_by, created_on, modified_by, modified_on) VALUES ('".$file_id."', '".$date_of_deposit."', '".$bank_id."', '".$payment_mode."', ".$total_amount.", 'Pending', '".$remarks."', '".$curusr."', '".$now."', '".$curusr."', '".$now."')";
                if ($this->db->query($sql) === TRUE) {
                    $payment_id = $this->db->insert_id();

                    for($j=0; $j<count($items_array); $j++) {
                        $sql = "insert into payment_upload_items (payment_id, distributor_id, ref_no, invoice_no, payment_amount) VALUES ('".$payment_id."', '".$items_array[$j]['distributor_id']."', '".$items_array[$j]['ref_no']."', '".$items_array[$j]['invoice_no']."', '".$items_array[$j]['payment_amount']."')";
                        if ($this->db->query($sql) === TRUE) {
                            $success_cnt = $success_cnt + 1;
                        } else {
                            $fail_cnt = $fail_cnt + 1;
                        }
                    }
                } else {
                    $fail_cnt = $fail_cnt + 1;
                }
            }

            $check_file_path = $path;
            $check_file_name = time().'_file_'.$file_id.'_check'.$ext;
            $status = 'Pending';
            $remarks = 'No of records uploaded - '.$success_cnt.'<br/>No of records failed - '.$fail_cnt;

            // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment;filename="'.$error_file_name.'"');
            // header('Cache-Control: max-age=0');
            // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            // $objWriter->save('php://output');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($check_file_path.$check_file_name);
        
            sleep(0.50);

            $sql = "update payment_upload_files set check_file_path='".$check_file_path."', check_file_name='".$check_file_name."', status = '".$status."', remarks = '".$remarks."', modified_by = '".$curusr."', modified_on = '".$now."' where id='".$file_id."'";
            $this->db->query($sql);

            sleep(0.50);

            // echo $remarks;
            $this->session->set_flashdata('success', $remarks);
            $this->session->keep_flashdata('success');
        }

        // echo $remarks;

        redirect(base_url().'index.php/Payment_upload');
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

    public function approve_file_data($file_id){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $sql = "select * from payment_upload_details where status='Pending' and file_id='$file_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $sql = "insert into payment_details (date_of_deposit, bank_id, payment_mode, total_amount, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, distributor_out_id, ref_id, modified_approved_date, file_id) 
                    select date_of_deposit, bank_id, payment_mode, total_amount, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, distributor_out_id, ref_id, modified_approved_date, '".$file_id."' 
                    from payment_upload_details where id = '".$result[$i]->id."'";
                $this->db->query($sql);
                $id = $this->db->insert_id();

                $sql = "insert into payment_details_items (payment_id, distributor_id, ref_no, invoice_no, bank_name, 
                            bank_city, payment_amount, settlement_id, settlement_start_date, settlement_end_date) 
                        select '".$id."', distributor_id, ref_no, invoice_no, bank_name, 
                            bank_city, payment_amount, settlement_id, settlement_start_date, settlement_end_date 
                        from payment_upload_items where payment_id = '".$result[$i]->id."'";
                $this->db->query($sql);
            }

            $sql = "update payment_upload_files set status='Approved', approved_by='$curusr', approved_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $sql = "update payment_upload_details set status='Approved', approved_by='$curusr', approved_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $this->session->set_flashdata('success', 'File approve succeded.');
            $this->session->keep_flashdata('success');
        } else {
            $this->session->set_flashdata('success', 'No data found.');
            $this->session->keep_flashdata('success');
        }

        redirect(base_url().'index.php/Payment_upload');
    }

    public function reject_file_data($file_id){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $sql = "select * from payment_upload_details where status='Pending' and file_id='$file_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $sql = "update payment_upload_files set status='Rejected', rejected_by='$curusr', rejected_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $sql = "update payment_upload_details set status='Rejected', rejected_by='$curusr', rejected_on='$now' where file_id='$file_id'";
            $this->db->query($sql);

            $this->session->set_flashdata('success', 'File rejection succeded.');
            $this->session->keep_flashdata('success');
        } else {
            $this->session->set_flashdata('success', 'No data found.');
            $this->session->keep_flashdata('success');
        }

        redirect(base_url().'index.php/Payment_upload');
    }

    public function get_file_invoices($file_id){
        $sql = "select id from distributor_out where file_id='$file_id'";
        $result = $this->db->query($sql)->result_array();

        $dist_out_id = '';
        $dist_out_id_arr = array();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                // $dist_out_id_arr[] = $result[$i]['id'];
                $dist_out_id = $dist_out_id . $result[$i]['id'] . ', ';
            }
        }

        // echo '<pre>'; print_r($dist_out_id_arr); echo '</pre>';
        // exit;

        // $dist_out_id = '';
        // if(count($result)>0){
        //     $dist_out_id = implode(', ', $result);
        // }

        if($dist_out_id!=''){
            $dist_out_id = substr($dist_out_id, 0, strlen($dist_out_id)-2);
        }

        // echo $dist_out_id;
        // exit;

        if($dist_out_id!=''){
            $this->tax_invoice_model->generate_multiple_tax_invoice($dist_out_id);
        }
    }
}
?>