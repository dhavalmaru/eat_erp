<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_upload extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_upload_model');
        $this->load->model('distributor_out_model');
        $this->load->library('excel');
        $this->load->database();
    }

    //index function
    public function index(){
        $result=$this->sales_upload_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data'] = $this->sales_upload_model->get_data();

            load_view('sales_upload/sales_upload', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function download_upload_format(){
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Sales_upload_format.xlsx';
        // $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $objPHPExcel->setActiveSheetIndex(1);

        $row = 2;
        $sql = "select * from depot_master where status='Approved' order by depot_name";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $dist) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $dist->depot_name);
            $row = $row+1;
        }
        $depot_cnt = $row;

        $row = 2;
        $sql = "select * from distributor_master where status='Approved' order by distributor_name";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $dist) {
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dist->distributor_name);
            $row = $row+1;
        }
        $dist_cnt = $row;

        $row = 2;
        $sql = "select * from city_master where status='1' order by city_name";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $dist) {
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dist->city_name);
            $row = $row+1;
        }
        $city_cnt = $row;

        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Bar');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Box');
        $type_cnt = 4;

        $row = 2;
        $sql = "select * from product_master where status='Approved' order by product_name";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $dist) {
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $dist->product_name);
            $row = $row+1;
        }
        $product_cnt = $row;
        $objPHPExcel->addNamedRange(new PHPExcel_NamedRange('Bar', $objPHPExcel->getActiveSheet(), 'I2:I'.($row-1)));

        $row = 2;
        $sql = "select * from box_master where status='Approved' order by box_name";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $dist) {
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $dist->box_name);
            $row = $row+1;
        }
        $box_cnt = $row;
        $objPHPExcel->addNamedRange(new PHPExcel_NamedRange('Box', $objPHPExcel->getActiveSheet(), 'K2:K'.($row-1)));

        $row = 2;
        $date = date("Y-m-d", strtotime("-9 months"));
        $sql = "select * from batch_master where date_of_processing >= '$date' and status = 'Approved' and batch_no!=''";
        $result  = $this->db->query($sql)->result();
        foreach($result  as $dist) {
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $dist->batch_no);
            $row = $row+1;
        }
        $batch_cnt = $row;

        $objPHPExcel->setActiveSheetIndex(0);
        for($row=5; $row<=105; $row++) {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$A$2:$A$'.($depot_cnt-1));

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$C$2:$C$'.($dist_cnt-1));

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$E$2:$E$'.($city_cnt-1));

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('J'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$G$2:$G$'.($type_cnt-1));

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('K'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=IF(J'.$row.'="",J'.$row.',INDIRECT(J'.$row.'))');

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('T'.$row)->getDataValidation();
            $this->common_excel($objValidation);
            $objValidation->setFormula1('=Sheet2!$M$2:$M$'.($batch_cnt-1));
        }

        $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $filename='sales_upload_format.xlsx';
        
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
        // $file = 'E:/wamp64/www/eat_erp/assets/uploads/sales_upload/1580471219_sales_upload_format_1.xlsx';
        $file = 'E:/wamp64/www/eat_erp/assets/uploads/sales_upload/1580554512_GOQII_sales_upload_format.xlsx';
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
        // $filename='sales_upload_format.xlsx';
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
        $file = 'E:/wamp64/www/eat_erp/assets/uploads/sales_upload/1580471219_sales_upload_format_1.xlsx';
        $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->setActiveSheetIndex(0);
        // $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        // $objPHPExcel->getActiveSheet()->setCellValue('W4', 'Error Remark');
        
        // $objPHPExcel->getSheetByName('Sheet2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $filename='sales_upload_format.xlsx';

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
        $path=$upload_path.'sales_upload/';
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

        $sql = "insert into sales_upload_files (file_name, file_path, upload_date, status, created_by, created_on, modified_by, modified_on) VALUES ('".$file_name."', '".$path."', '".$curdate."', 'Uploading', '".$curusr."', '".$now."', '".$curusr."', '".$now."')";
        $this->db->query($sql);
        // $file_id = $this->db->insert_id();

        sleep(0.50);

        $this->session->set_flashdata('success', 'File Upload Succeded.<br/>Please upload file data.');
        $this->session->keep_flashdata('success');
        redirect(base_url().'index.php/Sales_upload');
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

        $sql = "select * from sales_upload_files where id='$file_id'";
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
        $objPHPExcel->getActiveSheet()->setCellValue('W4', 'Error Remark');
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
        $objerror = 0;
        $error_line = '';
        $order_array = [];

        for($i=5; $i<=$highestrow; $i++){
            $creation_date = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
            $depot = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $distributor_name = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $name_of_customer = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $address = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
            $city = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $pincode = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $mobile_no = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            $po_no = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
            $sku_type = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
            $sku_name = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
            $sku_qty = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
            $sku_mrp = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
            $sku_discount = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
            $sku_value = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
            $sku_batch_no = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
            $track_id = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
            $remarks = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
            $error = '';
            $depot_id = '';
            $depot_state = '';
            $depot_state_code = '';
            $distributor_id = '';
            $state_name = '';
            $state_code = '';
            $country_name = '';
            $item_id = '';
            $item_grams = '';
            $item_rate = '';
            $item_tax_per = '';
            $batch_id = '';
            $stock_arr = [];

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
                if($depot==''){
                    $error.='Depot Name cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $sql = "select * from depot_master where depot_name='$depot'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)==0){
                        $error.='Depot Name '.$depot.' not found.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $depot_id = $result[0]->id;
                        $depot_state = $result[0]->state;
                        $depot_state_code = $result[0]->state_code;
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
                if($name_of_customer==''){
                    $error.='Name of Customer cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                }
                if($address==''){
                    $error.='Address cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                }
                if($city==''){
                    $error.='City cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } 
                // else {
                //     $sql = "select B.state_name, B.state_code, C.country_name from city_master A 
                //             left join state_master B on (A.state_id=B.id) 
                //             left join country_master C on (B.country_id=C.id) 
                //             where A.city_name='$city'";
                //     $result = $this->db->query($sql)->result();
                //     if(count($result)==0){
                //         $error.='City '.$city.' not found.';
                //         $objerror=1;
                //         if($bl_error_line==false){
                //            $error_line.=$i.', ';
                //            $bl_error_line=true;
                //        }
                //     } else {
                //         $state_name = $result[0]->state_name;
                //         $state_code = $result[0]->state_code;
                //         $country_name = $result[0]->country_name;
                //     }
                // }
                if($pincode==''){
                    $error.='Pincode cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $sql = "select B.state_name, B.state_code, C.country_name 
                            from pincode_master A 
                            left join state_master B on (A.state_id=B.id) 
                            left join country_master C on (B.country_id=C.id) 
                            where A.pincode='$pincode'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)==0){
                        $error.='Pincode '.$city.' not found.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $state_name = $result[0]->state_name;
                        $state_code = $result[0]->state_code;
                        $country_name = $result[0]->country_name;
                    }
                }
                if($mobile_no==''){
                    $error.='Mobile No cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                }
                if($po_no==''){
                    $error.='PO No cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $po_no = str_replace('"', '', $po_no);
                    $po_no = str_replace("'", "", $po_no);

                    $sql = "select * from distributor_out where order_no='$po_no'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)>0){
                        $error.='PO No '.$po_no.' already exist.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $sql = "select * from sales_upload_details where order_no='$po_no' and status<>'Rejected'";
                        $result = $this->db->query($sql)->result();
                        if(count($result)>0){
                            $error.='PO No '.$po_no.' already exist.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        }
                    }
                }
                if($sku_type==''){
                    $error.='Type cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else if($sku_type!='Bar' && $sku_type!='Box'){
                    $error.='Type should be Bar or Box.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                }
                if($sku_name==''){
                    $error.='SKU Name cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    if($sku_type=='Bar'){
                        $sql = "select * from product_master where product_name='$sku_name'";
                        $result = $this->db->query($sql)->result();
                        if(count($result)==0){
                            $error.='SKU Name '.$sku_name.' not found.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        } else {
                            $item_id = $result[0]->id;
                            $item_grams = $result[0]->grams;
                            $item_rate = $result[0]->rate;
                            $item_tax_per = $result[0]->tax_percentage;
                        }
                    } else {
                        $sql = "select * from box_master where box_name='$sku_name'";
                        $result = $this->db->query($sql)->result();
                        if(count($result)==0){
                            $error.='SKU Name '.$sku_name.' not found.';
                            $objerror=1;
                            if($bl_error_line==false){
                                $error_line.=$i.', ';
                                $bl_error_line=true;
                            }
                        } else {
                            $item_id = $result[0]->id;
                            $item_grams = $result[0]->grams;
                            $item_rate = $result[0]->rate;
                            $item_tax_per = $result[0]->tax_percentage;
                        }
                    }
                }
                if($sku_qty==''){
                    $error.='Quantity cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else if($sku_qty<=0) {
                    $error.='Quantity should be greater than zero.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $sku_qty = round(doubleval($sku_qty),2);
                }
                if($sku_mrp==''){
                    $error.='MRP cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else if($sku_mrp<=0) {
                    $error.='MRP should be greater than zero.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $sku_mrp = round(doubleval($sku_mrp),2);
                }
                if($sku_value==''){
                    $error.='Total Realisation Value cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else if($sku_value<=0) {
                    $error.='Total Realisation Value should be greater than zero.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $sku_value = round(doubleval($sku_value),2);
                }
                if($sku_batch_no==''){
                    $error.='Batch No cannot be blank.';
                    $objerror=1;
                    if($bl_error_line==false){
                        $error_line.=$i.', ';
                        $bl_error_line=true;
                    }
                } else {
                    $sql = "select * from batch_master where batch_no='$sku_batch_no'";
                    $result = $this->db->query($sql)->result();
                    if(count($result)==0){
                        $error.='Batch No '.$sku_batch_no.' not found.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    } else {
                        $batch_id = $result[0]->id;
                    }
                }

                if(isset($stock_arr[$sku_type.'_'.$item_id])){
                    $stock_arr[$sku_type.'_'.$item_id] = $stock_arr[$sku_type.'_'.$item_id]+$sku_qty;
                } else {
                    $stock_arr[$sku_type.'_'.$item_id] = $sku_qty;
                }

                if($objerror!=1){
                    $result = $this->check_stock($sku_type, $depot_id, $item_id, $stock_arr[$sku_type.'_'.$item_id]);
                    if($result){
                        $error.='Qty is not enough in selected depot.';
                        $objerror=1;
                        if($bl_error_line==false){
                            $error_line.=$i.', ';
                            $bl_error_line=true;
                        }
                    }
                }
                
                if($error!=""){
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $error);
                    $objPHPExcel->getActiveSheet()->getStyle('W'.$i)->getAlignment()->setWrapText(true);  
                }
            //-------------- Validation End ------------------------------

            if($objerror!=1){
                $bl_flag=false;
                $j=0;
                $sku_array = [];
                $k=0;

                for($j=0; $j<count($order_array); $j++){
                    if($order_array[$j]['po_no']==$po_no){
                        $bl_flag=true;
                        break;
                    }
                }

                if($bl_flag==false){
                    $j=count($order_array);

                    $order_array[$j]['creation_date']=FormatDate($creation_date);
                    $order_array[$j]['depot']=$depot;
                    $order_array[$j]['depot_id']=$depot_id;
                    $order_array[$j]['depot_state']=$depot_state;
                    $order_array[$j]['depot_state_code']=$depot_state_code;
                    // $order_array[$j]['order_approve_date']=$order_approve_date;
                    $order_array[$j]['distributor_name']=$distributor_name;
                    $order_array[$j]['distributor_id']=$distributor_id;
                    $order_array[$j]['name_of_customer']=$name_of_customer;
                    $order_array[$j]['address']=$address;
                    $order_array[$j]['city']=$city;
                    $order_array[$j]['pincode']=$pincode;
                    $order_array[$j]['state_name']=$state_name;
                    $order_array[$j]['state_code']=$state_code;
                    $order_array[$j]['country_name']=$country_name;
                    $order_array[$j]['mobile_no']=$mobile_no;
                    $order_array[$j]['po_no']=$po_no;
                    $order_array[$j]['track_id']=$track_id;
                    $order_array[$j]['remarks']=$remarks;
                    $order_array[$j]['total_order_amt']=0;
                    $order_array[$j]['total_order_value']=0;

                    $k=0;
                } else {
                    $sku_array=$order_array[$j]['sku_array'];
                    $k=count($sku_array);
                }

                $sku_array[$k]['sku_type']=$sku_type;
                $sku_array[$k]['sku_name']=$sku_name;
                $sku_array[$k]['item_id']=$item_id;
                $sku_array[$k]['item_grams']=$item_grams;
                $sku_array[$k]['item_rate']=$item_rate;
                $sku_array[$k]['item_tax_per']=$item_tax_per;
                $sku_array[$k]['sku_qty']=$sku_qty;
                $sku_array[$k]['sku_mrp']=$sku_mrp;
                $sku_array[$k]['sku_discount']=$sku_discount;
                $sku_array[$k]['sku_value']=$sku_value;
                $sku_array[$k]['sku_batch_no']=$sku_batch_no;
                $sku_array[$k]['batch_id']=$batch_id;
                $sku_array[$k]['row_num']=$i;

                $order_array[$j]['sku_array']=$sku_array;

                $order_array[$j]['total_order_amt']=doubleval($order_array[$j]['total_order_amt'])+doubleval($sku_qty*$item_rate);
                $order_array[$j]['total_order_value']=doubleval($order_array[$j]['total_order_value'])+doubleval($sku_value);
            }
        }

        $upload_path=$this->config->item('upload_path');
        $path=$upload_path.'sales_upload/';
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

            $sql = "update sales_upload_files set error_file_path='".$error_file_path."', error_file_name='".$error_file_name."', status = '".$status."', remarks = '".$remarks."', modified_by = '".$curusr."', modified_on = '".$now."' where id='".$file_id."'";
            $this->db->query($sql);

            sleep(0.50);

            $this->session->set_flashdata('error', $remarks);
            $this->session->keep_flashdata('error');
        } else {
            for($i=0; $i<count($order_array); $i++){
                $total_order_amt = $order_array[$i]['total_order_amt'];
                $total_order_value = $order_array[$i]['total_order_value'];
                if($order_array[$i]['depot_state']==$order_array[$i]['state_name']){
                    $tax_type = 'Intra';
                } else {
                    $tax_type = 'Inter';
                }

                $total_discount_amt = $total_order_amt - $total_order_value;
                $discount_per = 0;
                if($total_order_amt!=0){
                  $discount_per=round(($total_discount_amt/$total_order_amt)*100,2);
                }

                $tot_amount = 0;
                $tot_cgst_amount = 0;
                $tot_sgst_amount = 0;
                $tot_igst_amount = 0;
                $tot_tax_amount = 0;
                $tot_order_amount = 0;
                $k = 0;

                $sku_array = $order_array[$i]['sku_array'];

                for($j=0; $j<count($sku_array); $j++) {
                    // echo json_encode($sku_array[$j]);
                    // echo '<br/><br/>';

                    $qty = doubleval($sku_array[$j]['sku_qty']);
                    $sell_rate = 0;
                    $rate = doubleval($sku_array[$j]['item_rate']);
                    $amount = 0;
                    $cgst_amt = 0;
                    $sgst_amt = 0;
                    $igst_amt = 0;
                    $tax_amt = 0;
                    $total_amt = 0;
                    $margin_per = 0;
                    $promo_margin = 0;
                    $tax_per = doubleval($sku_array[$j]['item_tax_per']);

                    $sell_rate = $rate - (($rate*$discount_per)/100);
                    if($tax_per!=0){
                        $sell_rate = $sell_rate/(100+$tax_per)*100;
                    }

                    if($tax_type=='Intra'){
                        $cgst=$tax_per/2;
                        $sgst=$tax_per/2;
                        $igst=0;
                    } else {
                        $cgst=0;
                        $sgst=0;
                        $igst=$tax_per;
                    }

                    $cgst_amt = round($qty*(($sell_rate*$cgst)/100),2);
                    $sgst_amt = round($qty*(($sell_rate*$sgst)/100),2);
                    $igst_amt = round($qty*(($sell_rate*$igst)/100),2);
                    // $tax_amt = round($qty*(($sell_rate*$tax_per)/100),2);
                    $tax_amt = $cgst_amt+$sgst_amt+$igst_amt;

                    $amount = round(($qty*$sell_rate),2);
                    $total_amt = round((round($amount,2) + round($tax_amt,2)),2);

                    $tot_amount = $tot_amount + $amount;
                    $tot_tax_amount = $tot_tax_amount + $tax_amt;
                    $tot_order_amount = $tot_order_amount + $total_amt;

                    $tot_cgst_amount = $tot_cgst_amount + $cgst_amt;
                    $tot_sgst_amount = $tot_sgst_amount + $sgst_amt;
                    $tot_igst_amount = $tot_igst_amount + $igst_amt;

                    $sku_array[$j]['sell_rate'] = $sell_rate;
                    $sku_array[$j]['amount'] = $amount;
                    $sku_array[$j]['cgst_amt'] = $cgst_amt;
                    $sku_array[$j]['sgst_amt'] = $sgst_amt;
                    $sku_array[$j]['igst_amt'] = $igst_amt;
                    $sku_array[$j]['tax_amt'] = $tax_amt;
                    $sku_array[$j]['total_amt'] = $total_amt;
                    $sku_array[$j]['margin_per'] = $margin_per;
                    $sku_array[$j]['promo_margin'] = $promo_margin;

                    $row_num = $sku_array[$j]['row_num'];
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row_num, $cgst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row_num, $sgst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row_num, $igst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row_num, $amount);
                }

                $round_off_amt = round(round($tot_order_amount,0) - round($tot_order_amount,2),2);
                $invoice_amount = round($tot_order_amount,0);

                $order_array[$i]['discount'] = $discount_per;
                $order_array[$i]['amount'] = $tot_amount;
                $order_array[$i]['tax_amount'] = $tot_tax_amount;
                $order_array[$i]['cgst_amount'] = $tot_cgst_amount;
                $order_array[$i]['sgst_amount'] = $tot_sgst_amount;
                $order_array[$i]['igst_amount'] = $tot_igst_amount;
                $order_array[$i]['final_amount'] = $tot_order_amount;
                $order_array[$i]['round_off_amount'] = $round_off_amt;
                $order_array[$i]['invoice_amount'] = $invoice_amount;

                $order_array[$i]['sku_array'] = $sku_array;
            }

            // echo json_encode($order_array);
            // echo '<br/><br/>';

            $success_cnt = 0;
            $fail_cnt = 0;

            for($k=0; $k<count($order_array); $k++) {
                $date_of_processing = $order_array[$k]['creation_date'];
                $depot_id = $order_array[$k]['depot_id'];
                $distributor_id = $order_array[$k]['distributor_id'];
                $tot_amount = $order_array[$k]['amount'];
                $tot_tax_amount = $order_array[$k]['tax_amount'];
                $tot_order_amount = $order_array[$k]['final_amount'];
                $po_no = $order_array[$k]['po_no'];
                $client_name = addslashes($order_array[$k]['name_of_customer']);
                $address = addslashes($order_array[$k]['address']);
                $city = $order_array[$k]['city'];
                $pincode = $order_array[$k]['pincode'];
                $state = $order_array[$k]['state_name'];
                $country = $order_array[$k]['country_name'];
                $phone = $order_array[$k]['mobile_no'];
                $discount_per = $order_array[$k]['discount'];
                $delivery_status='Delivered';
                $delivery_date="'".$curdate."'";
                $tot_cgst_amount = $order_array[$k]['cgst_amount'];
                $tot_sgst_amount = $order_array[$k]['sgst_amount'];
                $tot_igst_amount = $order_array[$k]['igst_amount'];
                $state_code = $order_array[$k]['state_code'];
                $round_off_amt = $order_array[$k]['round_off_amount'];
                $invoice_amount = $order_array[$k]['invoice_amount'];
                $remarks = $order_array[$k]['remarks'];

                $sku_array = $order_array[$k]['sku_array'];

                $sql = "insert into sales_upload_details (file_id, date_of_processing, invoice_no, depot_id, distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, modified_by, modified_on, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, date_of_dispatch, delivery_status, delivery_date, delivery_sales_rep_id, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, round_off_amount, invoice_amount, ref_id, invoice_date, email_date_time, basis_of_sales, email_from, email_approved_by, gstin, created_by, created_on) VALUES ('".$file_id."', '".$date_of_processing."', '', '".$depot_id."', '".$distributor_id."', Null, ".$tot_amount.", Null, 1, ".$tot_tax_amount.", ".$tot_order_amount.", '".$curdate."', '".$po_no."', Null, Null, Null, Null, Null, 'Pending', '".$remarks."', '".$curusr."', '".$now."', '".$client_name."', '".$address."', '".$city."', '".$pincode."', '".$state."', '".$country."', '".$phone."', ".$discount_per.", Null, '".$curdate."', '".$delivery_status."', ".$delivery_date.", Null, '', '', 1, 1, 1, ".$tot_cgst_amount.", ".$tot_sgst_amount.", ".$tot_igst_amount.", 'no', 'yes', Null, Null, Null, Null, Null, Null, Null, Null, Null, '".$state_code."', ".$round_off_amt.", ".$invoice_amount.", Null, Null, '".$now."', 'PO Number', '', '', '', '".$curusr."', '".$now."')";
                if ($this->db->query($sql) === TRUE) {
                    $distributor_out_id = $this->db->insert_id();

                    for($j=0; $j<count($sku_array); $j++) {
                        $sql = "insert into sales_upload_items (distributor_out_id, type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, margin_per, promo_margin, tax_percentage, batch_no, batch_qty) VALUES ('".$distributor_out_id."', '".$sku_array[$j]['sku_type']."', '".$sku_array[$j]['item_id']."', '".$sku_array[$j]['sku_qty']."', '".$sku_array[$j]['sell_rate']."', '".$sku_array[$j]['item_grams']."', '".$sku_array[$j]['item_rate']."', '".$sku_array[$j]['amount']."', '".$sku_array[$j]['cgst_amt']."', '".$sku_array[$j]['sgst_amt']."', '".$sku_array[$j]['igst_amt']."', '".$sku_array[$j]['tax_amt']."', '".$sku_array[$j]['total_amt']."', '".$sku_array[$j]['margin_per']."', '".$sku_array[$j]['promo_margin']."', '".$sku_array[$j]['item_tax_per']."', '".$sku_array[$j]['batch_id']."', '".$sku_array[$j]['sku_qty']."')";
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

            $sql = "update sales_upload_files set check_file_path='".$check_file_path."', check_file_name='".$check_file_name."', status = '".$status."', remarks = '".$remarks."', modified_by = '".$curusr."', modified_on = '".$now."' where id='".$file_id."'";
            $this->db->query($sql);

            sleep(0.50);

            // echo $remarks;
            $this->session->set_flashdata('success', $remarks);
            $this->session->keep_flashdata('success');
        }

        // echo $remarks;

        redirect(base_url().'index.php/Sales_upload');
    }

    public function common_excel($objValidation)
    {
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

        $sql = "select * from sales_upload_details where status='Pending' and file_id='$file_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $sql = "insert into distributor_out (date_of_processing, invoice_no, depot_id, 
                            distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, voucher_no, gate_pass_no, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, delivery_status, delivery_date, delivery_sales_rep_id, receivable_doc, distributor_in_id, distributor_in_type, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, sample_type, gifting_remarks, promoter_sales_rep_id, blogger_name, blogger_address, blogger_phone_no, blogger_email_id, round_off_amount, invoice_amount, ref_id, invoice_date, gatepass_date, gpid, freezed, tracking_id, basis_of_sales, email_from, email_approved_by, email_date_time, distributor_po_id, comments, gstin, modified_approved_date, proof_of_dispatch, date_of_dispatch, person_receiving, proof_of_delivery, ref_invoice_no, ref_invoice_details, ref_invoice_date)
                        select date_of_processing, invoice_no, depot_id, distributor_id, sales_rep_id, amount, tax, tax_per, tax_amount, final_amount, due_date, order_no, order_date, supplier_ref, despatch_doc_no, despatch_through, destination, status, remarks, created_by, created_on, modified_by, modified_on, approved_by, approved_on, rejected_by, rejected_on, voucher_no, gate_pass_no, client_name, address, city, pincode, state, country, mobile_no, discount, sample_distributor_id, delivery_status, delivery_date, delivery_sales_rep_id, receivable_doc, distributor_in_id, distributor_in_type, transport_type, vehicle_number, cgst, sgst, igst, cgst_amount, sgst_amount, igst_amount, reverse_charge, shipping_address, distributor_consignee_id, con_name, con_address, con_city, con_pincode, con_state, con_country, con_state_code, con_gst_number, state_code, sample_type, gifting_remarks, promoter_sales_rep_id, blogger_name, blogger_address, blogger_phone_no, blogger_email_id, round_off_amount, invoice_amount, ref_id, invoice_date, gatepass_date, gpid, freezed, tracking_id, basis_of_sales, email_from, email_approved_by, email_date_time, distributor_po_id, comments, gstin, modified_approved_date, proof_of_dispatch, date_of_dispatch, person_receiving, proof_of_delivery, ref_invoice_no, ref_invoice_details, ref_invoice_date 
                        from sales_upload_details where id = '".$result[$i]->id."'";
                $this->db->query($sql);
                $id = $this->db->insert_id();

                $sql = "insert into distributor_out_items (distributor_out_id, type, item_id, qty, sell_rate, 
                            grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, batch_no, batch_qty, margin_per, tax_percentage, promo_margin)
                        select '".$id."', type, item_id, qty, sell_rate, grams, rate, amount, cgst_amt, sgst_amt, igst_amt, tax_amt, total_amt, batch_no, batch_qty, margin_per, tax_percentage, promo_margin 
                        from sales_upload_items where distributor_out_id = '".$result[$i]->id."'";
                $this->db->query($sql);

                $this->distributor_out_model->save_approved_data($id);
            }

            $sql = "update sales_upload_files set status='Approved', approved_by='$curusr', approved_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $sql = "update sales_upload_details set status='Approved', approved_by='$curusr', approved_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $this->session->set_flashdata('success', 'File approve succeded.');
            $this->session->keep_flashdata('success');
        } else {
            $this->session->set_flashdata('success', 'No data found.');
            $this->session->keep_flashdata('success');
        }

        redirect(base_url().'index.php/Sales_upload');
    }

    public function reject_file_data($file_id){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $sql = "select * from sales_upload_details where status='Pending' and file_id='$file_id'";
        $result = $this->db->query($sql)->result();
        if(count($result)>0){
            $sql = "update sales_upload_files set status='Rejected', rejected_by='$curusr', rejected_on='$now' where id='$file_id'";
            $this->db->query($sql);

            $sql = "update sales_upload_details set status='Rejected', rejected_by='$curusr', rejected_on='$now' where file_id='$file_id'";
            $this->db->query($sql);

            $this->session->set_flashdata('success', 'File rejection succeded.');
            $this->session->keep_flashdata('success');
        } else {
            $this->session->set_flashdata('success', 'No data found.');
            $this->session->keep_flashdata('success');
        }

        redirect(base_url().'index.php/Sales_upload');
    }
}
?>