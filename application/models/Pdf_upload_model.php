<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}
use setasign\Fpdi\Fpdi;
use Smalot\PdfParser\Parser;

class Pdf_upload_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Out' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
        return $query->result();
    }

    function get_list_data($start=0, $length=0, $search_val=''){
        $curusr = $this->session->userdata('session_id');

        $cond="";
        if($search_val!=''){
            $cond=" where (id like '%".$search_val."%' or DATE_FORMAT(upload_date, '%d/%m/%Y') like '%".$search_val."%' or file_name like '%".$search_val."%' or file_path like '%".$search_val."%' or check_file_name like '%".$search_val."%' or check_file_path like '%".$search_val."%')";
        }

        $data = array();

        $sql = "select count(id) as total_records from pdf_upload_files ".$cond;
        $query=$this->db->query($sql);
        $data['count']=$query->result();

        $limit = "";
        if($start>0 && $length>0) $limit .= " limit ".$start.", ".$length;
        elseif($length>0) $limit .= " limit ".$length;

        $sql = "select * from pdf_upload_files ".$cond." order by modified_on desc".$limit;
        $query=$this->db->query($sql);
        $data['rows']=$query->result();

        return $data;
    }

    function get_data($status='', $id=''){
        if($status!=""){
            $cond=" where status='".$status."'";
        } else {
            $cond="";
        }

        if($id!=""){
            if($cond=="") {
                $cond=" where id='".$id."'";
            } else {
                $cond=$cond." and id='".$id."'";
            }
        }

        $sql = "select * from pdf_upload_files".$cond." order by modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function edit_pdf($file_id){
        try {
            require_once(APPPATH.'libraries/PDF/fpdf181/fpdf.php');
            require_once(APPPATH.'libraries/PDF/fpdi2/src/autoload.php');
            require_once(APPPATH.'libraries/PDF/pdfparser/src/Smalot/PdfParser/Parser.php');

            $file_path = '';
            $file_name = '';
            $output_file_name = '';

            $sql = "SELECT * FROM pdf_upload_files WHERE id='$file_id'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $file_path = $result[0]->file_path;
                $file_name = $result[0]->file_name;
            }

            $fileName = $file_path.$file_name;

            $parser = new Parser();
            $pdf = $parser->parseFile($fileName);
            $pages = $pdf->getPages();
            $i = 1;
            $invoiceArr = [];
            $yAxis = [];

            $pdf = new FPDI();
            $pdf->setSourceFile($fileName);

            foreach ($pages as $page) {
                $text = '';
                $textArr = [];
                $y = 230;

                $text = $page->getText();

                if(isset($text)) {
                    if($text!='') {
                        if(strpos($text, 'Invoice Date')!==False) {
                            $text = substr($text, strpos($text, 'Invoice Date')+12);
                            $text2 = $text;
                            
                            while(strpos($text2, '|')!==False) {
                                $text2 = substr($text2, strpos($text2, '|')+1);
                                $text2 = trim($text2);

                                if(strpos($text2, '|')!==False) {
                                    $text3 = substr($text2, 0, strpos($text2, '|'));
                                    $y = $y + 12;
                                } else {
                                    $text3 = $text2;
                                }
                                $text3 = trim($text3);

                                if(strlen($text3)>=10){
                                    $text4 = substr($text3, 0, 10);
                                } else {
                                    $text4 = $text3;
                                }

                                $text4 = trim($text4);

                                $textArr[] = $text4;
                            }
                        }
                    }
                }

                if(count($textArr)==0) {
                    $pdf->AddPage();
                    $tplIdx = $pdf->importPage($i++);
                    $pdf->useTemplate($tplIdx);
                } else {
                    $yAxis[$i] = $y;
                    $invoiceArr[$i++] = $textArr;
                }
            }

            foreach ($invoiceArr as $i => $textArr) {
                $y = $yAxis[$i];

                $pdf->AddPage();
                $tplIdx = $pdf->importPage($i);
                $pdf->useTemplate($tplIdx);
                $pdf->SetFont('Arial', 'B', '15');
                $pdf->SetTextColor(225, 10, 10);
                $pdf->SetXY(10, $y);
                $pdf->MultiCell(190, 8, 'Dispatch Instructions', 1, 'C');
                $y = $y + 8;
                
                foreach ($textArr as $key => $value) {
                    $box_name = '';

                    $sql = "SELECT * FROM asin_master WHERE asin='$value'";
                    $query=$this->db->query($sql);
                    $result=$query->result();
                    if(count($result)>0) {
                        $box_name = $result[0]->product_name;
                    }

                    $pdf->SetXY(10, $y);

                    $pdf_text = $value.' : '.$box_name;
                    $pdf->MultiCell(190, 8, $value.' : '.$box_name, 1);
                    if(strlen($pdf_text)>68){
                        $y = $y + 16;
                    } else {
                        $y = $y + 8;
                    }

                    if($y>=270) {
                        $pdf->AddPage();
                        $y = 8;
                    }
                }
            }

            $file_name = time().'_file_'.$file_id.'.pdf';
            $fileName = $file_path.$file_name;

            $pdf->Output($fileName, 'F');

            $sql = "UPDATE pdf_upload_files SET status='Uploaded', check_file_path='$file_path', check_file_name='$file_name' WHERE id='$file_id'";
            $this->db->query($sql);

            $output_file_name = $file_name;

            return $output_file_name;
        } catch (Exception $e) {
            return "";
        }
    }
}
?>