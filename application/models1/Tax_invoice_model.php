<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Tax_invoice_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('distributor_model');
    $this->load->model('distributor_out_model');
}

// function generate_tax_invoice($id, $view=false) {
function generate_tax_invoice($id) {
    $now=date('Y-m-d H:i:s');
    $curusr=$this->session->userdata('session_id');

    $result = $this->distributor_out_model->get_data('', $id);
    if(count($result)>0){
        $distributor_id=$result[0]->distributor_id;
        $invoice_no=$result[0]->invoice_no;
        $voucher_no=$result[0]->voucher_no;
        $gate_pass_no=$result[0]->gate_pass_no;
        $date_of_processing=$result[0]->date_of_processing;
        $total_amount=floatval($result[0]->amount);
        $order_no=$result[0]->order_no;
        $order_date=$result[0]->order_date;
        $supplier_ref=$result[0]->supplier_ref;
        $despatch_doc_no=$result[0]->despatch_doc_no;
        $despatch_through=$result[0]->despatch_through;
        $destination=$result[0]->destination;
        $cst=$result[0]->cst;
        $cst_amount=$result[0]->cst_amount;
        $total_amount_with_tax=$result[0]->final_amount;
        $created_by=$result[0]->created_by;
        $sample_distributor_id=$result[0]->sample_distributor_id;
        $client_name=$result[0]->client_name;
        $client_address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);
    } else {
        $distributor_id=0;
        $invoice_no=null;
        $voucher_no=null;
        $gate_pass_no=null;
        $date_of_processing=null;
        $total_amount=0;
        $order_no=null;
        $order_date=null;
        $supplier_ref=null;
        $despatch_doc_no=null;
        $despatch_through=null;
        $destination=null;
        $cst=null;
        $cst_amount=0;
        $total_amount_with_tax=0;
        $created_by=null;
        $sample_distributor_id=null;
        $client_name=null;
        $client_address = null;
    }
    $data['total_amount']=round($total_amount,0);
    $data['order_no']=$order_no;
    $data['order_date']=$order_date;
    $data['supplier_ref']=$supplier_ref;
    $data['despatch_doc_no']=$despatch_doc_no;
    $data['despatch_through']=$despatch_through;
    $data['destination']=$destination;
    $data['cst']=$cst;
    $data['cst_amount']=round($cst_amount,2);
    $total_amount_with_tax=round($total_amount_with_tax,0);
    $data['total_amount_with_tax']=$total_amount_with_tax;
    $data['created_by']=$created_by;

    $result = $this->distributor_model->get_data('', $distributor_id);
    if(count($result)>0){
        $send_invoice = $result[0]->send_invoice;
        $class = $result[0]->class;
        $distributor_name=$result[0]->distributor_name;
        $state=$result[0]->state;
        $email_id=$result[0]->email_id;
        $mobile=$result[0]->mobile;
        $tin_number=$result[0]->tin_number;
        $cst_number=$result[0]->cst_number;
        $sales_rep_name=$result[0]->sales_rep_name;

        $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

        $data['distributor_name']=$distributor_name;
        $data['address']=$address;
        $data['tin_number']=$tin_number;
        $data['sales_rep_name']=$sales_rep_name;
        $data['total_amount_in_words']=convert_number_to_words($total_amount_with_tax) . ' Only';

        $sql = "select E.*, case when E.type='Box' then E.box_name else E.product_name end as description from 
                (select C.*, B.box_name from 
                (select A.*, B.product_name from 
                (select type, qty, sell_rate, rate, amount, case when type='Box' then item_id else null end as box_id, 
                    case when type='Bar' then item_id else null end as bar_id from distributor_out_items 
                    where distributor_out_id = '$id') A 
                left join 
                (select * from product_master) B 
                on (A.bar_id=B.id)) C 
                left join 
                (select * from box_master) B 
                on (C.box_id=B.id)) E";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $data['description']=$result;
        }

        if (strtoupper(trim($class))=='SAMPLE') {
            if($voucher_no==null || $voucher_no==''){
                $sql="select * from series_master where type='Voucher'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $series=intval($result[0]->series)+1;

                    $sql="update series_master set series = '$series' where type = 'Voucher'";
                    $this->db->query($sql);
                } else {
                    $series=1;

                    $sql="insert into series_master (type, series) values ('Voucher', '$series')";
                    $this->db->query($sql);
                }

                if (isset($date_of_processing)){
                    $financial_year=calculateFiscalYearForDate($date_of_processing);
                } else {
                    $financial_year="";
                }
                
                $voucher_no = 'WHPL/'.$financial_year.'/voucher/'.strval($series);

                $sql="update distributor_out set voucher_no = '$voucher_no' where id = '$id'";
                $this->db->query($sql);
            }

            if($gate_pass_no==null || $gate_pass_no==''){
                $sql="select * from series_master where type='Gate_Pass'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $series=intval($result[0]->series)+1;

                    $sql="update series_master set series = '$series' where type = 'Gate_Pass'";
                    $this->db->query($sql);
                } else {
                    $series=1;

                    $sql="insert into series_master (type, series) values ('Gate_Pass', '$series')";
                    $this->db->query($sql);
                }

                if (isset($date_of_processing)){
                    $financial_year=calculateFiscalYearForDate($date_of_processing);
                } else {
                    $financial_year="";
                }
                
                $gate_pass_no = 'WHPL/'.$financial_year.'/gate_pass/'.strval($series);

                $sql="update distributor_out set gate_pass_no = '$gate_pass_no' where id = '$id'";
                $this->db->query($sql);
            }

            $data['voucher_no']=$voucher_no;
            $data['gate_pass_no']=$gate_pass_no;
            $data['date_of_processing']=$date_of_processing;

            if(strtoupper(trim($distributor_name))=='DIRECT'){
                $data['distributor_name']=$client_name;
                $data['address']=$client_address;
            } else {
                $data['distributor_name']=$distributor_name;
                $data['address']=$address;
            }
            
            $result = $this->distributor_model->get_data('', $sample_distributor_id);
            if(count($result)>0){
                $send_invoice = $result[0]->send_invoice;
                $class = $result[0]->class;
                $distributor_name=$result[0]->distributor_name;
                $state=$result[0]->state;
                $email_id=$result[0]->email_id;
                $mobile=$result[0]->mobile;
                $tin_number=$result[0]->tin_number;
                $cst_number=$result[0]->cst_number;
                // $sales_rep_name=$result[0]->sales_rep_name;

                $address = get_address($result[0]->address, "", $result[0]->city, $result[0]->pincode, $result[0]->state, $result[0]->country);

                $data['distributor_name']=$distributor_name;
                $data['address']=$address;
                $data['tin_number']=$tin_number;
                // $data['sales_rep_name']=$sales_rep_name;
            }
            
            $this->load->library('parser');
            $output = $this->parser->parse('invoice/voucher.php',$data,true);
            $pdf='';   
            if ($pdf=='print')
                $this->_gen_pdf($output);
            else
                $this->output->set_output($output);

            // if($view!=true){
            //     redirect(base_url().'index.php/distributor_out');
            // }
        } else if ($send_invoice==1) {
            if($invoice_no==null || $invoice_no==''){
                $sql="select * from series_master where type='Tax_Invoice'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    $series=intval($result[0]->series)+1;

                    $sql="update series_master set series = '$series' where type = 'Tax_Invoice'";
                    $this->db->query($sql);
                } else {
                    $series=1;

                    $sql="insert into series_master (type, series) values ('Tax_Invoice', '$series')";
                    $this->db->query($sql);
                }

                if (isset($date_of_processing)){
                    $financial_year=calculateFiscalYearForDate($date_of_processing);
                } else {
                    $financial_year="";
                }
                
                $invoice_no = 'WHPL/'.$financial_year.'/'.strval($series);

                $sql="update distributor_out set invoice_no = '$invoice_no' where id = '$id'";
                $this->db->query($sql);

                $sql="update distributor_out set invoice_no = '$invoice_no' where id = '$id'";
                $this->db->query($sql);
            }

            $data['invoice_no']=$invoice_no;
            $data['date_of_processing']=$date_of_processing;

            if(strtoupper(trim($distributor_name))=='DIRECT'){
                $data['distributor_name']=$client_name;
                $data['address']=$client_address;
            } else {
                $data['distributor_name']=$distributor_name;
                $data['address']=$address;
            }

            $this->load->library('parser');
            $output = $this->parser->parse('invoice/tax_invoice.php',$data,true);
            $pdf='';   
            if ($pdf=='print')
                $this->_gen_pdf($output);
            else
                $this->output->set_output($output);

            // if($view!=true){
            //     redirect(base_url().'index.php/distributor_out');
            // }
        }
    }

    return $invoice_no;
}

function test(){
    $this->load->library('mpdf/mpdf');
    require_once(dirname(__FILE__) . '/../libraries/PHPExcel/Settings.php');

    $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
    $rendererLibraryPath = dirname(__FILE__) . '/../libraries/mpdf';

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->getProperties()->setCreator("TEST PDF")
      ->setLastModifiedBy("TEST")
      ->setTitle("TEST PDF")
      ->setSubject("TEST PDF")
      ->setDescription("TEST PDF")
      ->setKeywords("TEST PDF")
      ->setCategory("TEST PDF");

    $objPHPExcel->setActiveSheetIndex(0);

    // Field names in the first row
    $fields = $query->list_fields();
    $col = 0;
    foreach ($fields as $field)
    {
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
    $col++;
    }

    // Fetching the table data
    $row = 2;
    foreach($query->result() as $data)
    {
    $col = 0;
    foreach ($fields as $field)
    {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
      $col++;
    }

    $row++;
    }

    $objPHPExcel->setActiveSheetIndex(0);

    if (!PHPExcel_Settings::setPdfRenderer(
      $rendererName,
      $rendererLibraryPath
    ))
    {
    die(
      'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
      '<br />' .
      'at the top of this script as appropriate for your directory structure' . '<br/>' .
      $rendererName . '<br/>' .
      $rendererLibraryPath . '<br/>'
    );
    }

    // Redirect output to a client’s web browser (PDF)
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="'.$file_name.'.pdf"');
    header('Cache-Control: max-age=0');

    $objWriter = IOFactory::createWriter($objPHPExcel, 'PDF');
    $objWriter->save('php://output');
}

function test2(){
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Tax_Invoice.xls';
    $this->load->library('excel');

    $reader = PHPExcel_IOFactory::createReader('Excel5');
    $spreadsheet = $reader->load($file);

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="from-template.pdf"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'PDF');
    $writer->save('php://output');
    // die();
}

function gen_pdf(){
    $html="<html><body>Hiiiiiiiiiii</body></html>";
    $paper='A4';


    $this->load->library('mpdf57/mpdf');               
    $mpdf=new mPDF('utf-8',$paper);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
}


private function _gen_pdf($html,$paper='A4'){
    // $this->load->library('mpdf60/mpdf');               
    // $mpdf=new mPDF('utf-8',$paper);
    // $mpdf->WriteHTML($html);
    // $mpdf->Output();

    //actually, you can pass mPDF parameter on this load() function
    $this->load->library('m_pdf');
    $pdf = $this->m_pdf->load();
    //generate the PDF!
    $pdf->WriteHTML($html,2);
    //offer it to user via browser download! (The PDF won't be saved on your server HDD)
    $pdf->Output($pdfFilePath, "D");
} 
}
?>