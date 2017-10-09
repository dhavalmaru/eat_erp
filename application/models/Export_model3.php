<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Export_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function get_distributor_out_details($from_date, $to_date) {
    $sql = "select I.*, J.item_name from 
            (select M.*, H.sales_rep_name from 
            (select G.*, L.distributor_type from 
            (select E.*, F.distributor_name, F.sell_out, F.type_id from 
            (select C.*, D.depot_name from 
            (select A.*, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount from 
            (select * from distributor_out where status='Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
            left join 
            (select * from distributor_out_items) B 
            on (A.id=B.distributor_out_id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id=D.id)) E 
            left join 
            (select * from distributor_master) F 
            on (E.distributor_id=F.id)) G 
            left join
            (select * from distributor_type_master) L 
            on (G.type_id=L.id)) M 
            left join 
            (select * from sales_rep_master) H 
            on (M.sales_rep_id=H.id)) I 
            left join 
            (select id, 'Raw Material' as type, rm_name as item_name from raw_material_master where status='Approved' 
            union all 
            select id, 'Bar' as type, product_name as item_name from product_master where status='Approved' 
            union all 
            select id, 'Box' as type, box_name as item_name from box_master where status='Approved' ) J 
            on (I.item_id=J.id and I.type=J.type)";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function generate_sale_invoice_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $data = $this->get_distributor_out_details($from_date, $to_date);

    if(count($data)>0) {
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Sale_Invoice.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $row=3;
        for($i=0; $i<count($data); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data[$i]->date_of_processing);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data[$i]->invoice_no);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->qty);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->sell_rate);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->sell_out);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->amount);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->cst_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->final_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $data[$i]->depot_name);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$i]->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->distributor_type);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->sales_rep_name);
            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $data[$i]->due_date);
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $data[$i]->order_no);
            $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$i]->order_date);

            $row=$row+1;
        }

        $row=$row-1;

        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1'.':S'.$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $filename='Sale_Invoice_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Sale Invoice report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}

function generate_raw_material_stock_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));

    $sql = "select distinct date_of_receipt from raw_material_in where status='Approved' and date_of_receipt is not null and 
            date_of_receipt>='$from_date' and date_of_receipt<='$to_date' 
            order by date_of_receipt";
    $query=$this->db->query($sql);
    $data=$query->result();
    if(count($data)>0) {
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Raw_Material_Stock.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $total_col=count($data);
        $col_name[]=array();
        for($i=0; $i<=$total_col+20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $objPHPExcel->getActiveSheet()->insertNewColumnBefore('B', $total_col);
        $col=1;
        for($j=0; $j<$total_col; $j++){
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'1', 'Stock In 1');
            if(isset($data[$j]->date_of_receipt) && $data[$j]->date_of_receipt!=''){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'2', $data[$j]->date_of_receipt);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'2', 'no date');
            }
            $col=$col+1;
        }

        $sql = "select C.*, D.rm_name from 
                (select A.*, B.raw_material_id, B.qty, B.rate, B.amount from 
                (select * from raw_material_in where status='Approved' and 
                    date_of_receipt>='$from_date' and date_of_receipt<='$to_date') A 
                left join 
                (select * from raw_material_stock) B 
                on (A.id=B.raw_material_in_id)) C 
                left join 
                (select * from raw_material_master) D 
                on (C.raw_material_id=D.id) 
                order by C.raw_material_id, C.date_of_receipt";
        $query=$this->db->query($sql);
        $data=$query->result();
        if(count($data)>0) {
            $raw_material_id=0;
            $prev_raw_material_id=0;
            $row=2;

            for($i=0;$i<count($data);$i++){
                $raw_material_id=$data[$i]->raw_material_id;

                if($raw_material_id<>$prev_raw_material_id){
                    $prev_raw_material_id=$raw_material_id;
                    $row=$row+1;
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data[$i]->rm_name);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$total_col].$row, $data[$i]->raw_material_id);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[1+$total_col].$row, '=sum('.$col_name[1].$row.':'.$col_name[1+$total_col-1].$row.')');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$total_col].$row, '='.$col_name[1+$total_col].$row.'-'.$col_name[2+$total_col].$row.')');
                }
                
                $col=1;
                $date_of_receipt=$data[$i]->date_of_receipt;
                for($j=0; $j<=$total_col; $j++){
                    $excel_date=$objPHPExcel->getActiveSheet()->getCell($col_name[$col].'2')->getValue();

                    if($excel_date==$date_of_receipt){
                        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row), $data[$i]->qty);
                        if(isset($qty[$date_of_receipt])){
                            $qty[$date_of_receipt]=$qty[$date_of_receipt]+$data[$i]->qty;
                        } else {
                            $qty[$date_of_receipt]=$data[$i]->qty;
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row), $qty[$date_of_receipt]);
                        break;
                    }
                    
                    $col=$col+1;
                }
            }
        }

        $sql="select raw_material_id, sum(qty) as total_qty from batch_raw_material 
            where raw_material_id in (select distinct id from batch_processing where status='Approved' and 
                    date_of_processing>='$from_date' and date_of_processing<='$to_date') 
            group by raw_material_id";
        $query=$this->db->query($sql);
        $data=$query->result();
        if(count($data)>0) {
            for($i=0;$i<count($data);$i++){
                $raw_material_id=$data[$i]->raw_material_id;
                for($j=2;$j<=$row;$j++){
                    $excel_raw_material_id=$objPHPExcel->getActiveSheet()->getCell($col_name[4+$total_col].$j)->getValue();

                    if($excel_raw_material_id==$raw_material_id){
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[2+$total_col].$j, $data[$i]->total_qty);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$total_col].$j, '');
                        break;
                    }
                }
            }
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[3+$total_col].'2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1'.':'.$col_name[3+$total_col].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[3+$total_col].'2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));

        $filename='Raw_Material_Stock_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Raw Material Stock report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function generate_production_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));

    $sql = "select * from raw_material_master where status = 'Approved' order by id";
    $query=$this->db->query($sql);
    $data=$query->result();
    if(count($data)>0) {
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Production.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $col_name[]=array();
        for($i=0; $i<=1000; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=4;
        for($i=0; $i<count($data); $i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data[$i]->id);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data[$i]->rm_name);
            $row=$row+1;
        }
        $total_row=$row-1;
        $col=1;
        
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+1), 'Input Total');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+2), 'Output Total');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+3), 'No of Bars');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+4), 'Wastage');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+5), 'Process Loss');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+6), 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+7), 'Anticipted Wastage %');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+8), 'Actual Wastage %');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+9), 'Wastage Variance');

        $sql = "select * from raw_material_master where status = 'Approved' order by id";
        $query=$this->db->query($sql);
        $data=$query->result();
        if(count($data)>0) {
            $sql = "select C.*, D.raw_material_id, D.qty from 
                    (select A.*, B.product_name from 
                    (select * from batch_processing where status = 'Approved' and 
                        date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
                    left join 
                    (select * from product_master) B 
                    on (A.product_id=B.id)) C 
                    left join 
                    (select * from batch_raw_material) D 
                    on (C.id=D.batch_processing_id) 
                    order by C.date_of_processing, C.product_id, D.raw_material_id";
            $query=$this->db->query($sql);
            $data=$query->result();
            if(count($data)>0) {
                $date_of_processing='';
                $prev_date_of_processing='';
                $product_id='';
                $prev_product_id='';

                for($i=0; $i<count($data); $i++){
                    $date_of_processing=$data[$i]->date_of_processing;
                    $product_id=$data[$i]->product_id;

                    if($date_of_processing!=$prev_date_of_processing || $product_id!=$prev_product_id){
                        $prev_date_of_processing=$date_of_processing;
                        $prev_product_id=$product_id;

                        $col=$col+1;
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'2', $date_of_processing);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'3', $data[$i]->product_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+1), '=sum('.$col_name[$col].'4:'.$col_name[$col].strval($total_row).')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+3), $data[$i]->qty_in_bar);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+4), $data[$i]->actual_wastage);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+6), '=sum('.$col_name[$col].strval($total_row+1).','.$col_name[$col].strval($total_row+4).','.$col_name[$col].strval($total_row+5).')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+7), $data[$i]->anticipated_wastage);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+8), $data[$i]->wastage_percent);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+9), $data[$i]->wastage_variance);
                    }

                    $raw_material_id=$data[$i]->raw_material_id;

                    for($j=4; $j<=$total_row; $j++){
                        $excel_raw_material_id=$objPHPExcel->getActiveSheet()->getCell('A'.$j)->getValue();
                        if($excel_raw_material_id==$raw_material_id){
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$j, $data[$i]->qty);
                            break;
                        }
                    }
                }
            }

            $start_col=$col+1;

            $sql = "select C.product_id, C.product_name, D.raw_material_id, sum(D.qty) as total_qty from 
                    (select A.*, B.product_name from 
                    (select * from batch_processing where status = 'Approved' and 
                        date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
                    left join 
                    (select * from product_master) B 
                    on (A.product_id=B.id)) C 
                    left join 
                    (select * from batch_raw_material) D 
                    on (C.id=D.batch_processing_id) 
                    group by C.product_id, C.product_name, D.raw_material_id 
                    order by C.product_id, C.product_name, D.raw_material_id";
            $query=$this->db->query($sql);
            $data=$query->result();
            if(count($data)>0) {
                $product_id='';
                $prev_product_id='';

                for($i=0; $i<count($data); $i++){
                    $product_id=$data[$i]->product_id;

                    if($product_id!=$prev_product_id){
                        $prev_product_id=$product_id;

                        $col=$col+1;

                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'3', $data[$i]->product_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+1), '=sum('.$col_name[$col].'4:'.$col_name[$col].strval($total_row).')');
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+6), '=sum('.$col_name[$col].strval($total_row+1).','.$col_name[$col].strval($total_row+4).','.$col_name[$col].strval($total_row+5).')');
                        
                        $sql = "select product_id, sum(qty_in_bar) as tot_qty_in_bar, sum(actual_wastage) as tot_actual_wastage, 
                                    avg(wastage_percent) as tot_wastage_percent, avg(anticipated_wastage) as tot_anticipated_wastage, 
                                    avg(wastage_variance) as tot_wastage_variance from batch_processing 
                                where status = 'Approved' and product_id = '$product_id' and 
                                    date_of_processing>='$from_date' and date_of_processing<='$to_date' 
                                group by product_id order by product_id";
                        $query=$this->db->query($sql);
                        $data2=$query->result();
                        if(count($data2)>0) {
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+3), $data2[0]->tot_qty_in_bar);
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+4), $data2[0]->tot_actual_wastage);
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+7), $data2[0]->tot_anticipated_wastage);
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+8), $data2[0]->tot_wastage_percent);
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($total_row+9), $data2[0]->tot_wastage_variance);
                        }
                    }

                    $raw_material_id=$data[$i]->raw_material_id;

                    for($j=4; $j<=$total_row; $j++){
                        $excel_raw_material_id=$objPHPExcel->getActiveSheet()->getCell('A'.$j)->getValue();
                        if($excel_raw_material_id==$raw_material_id){
                            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$j, $data[$i]->total_qty);
                            break;
                        }
                    }
                }
            }
        }

        $end_col=$col;
        $col=$col+1;
        for($j=4; $j<=$total_row; $j++){
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($j), '=sum('.$col_name[$start_col].strval($j).':'.$col_name[$end_col].strval($j).')');
        }
        
        $end_col=$col;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$start_col].'2','Total Production');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$end_col].'3','Total');
        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$start_col].'2:'.$col_name[$end_col].'2');
        $objPHPExcel->getActiveSheet()->getStyle($col_name[$start_col].'2')->applyFromArray(array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('B2:'.$col_name[$col].'3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B'.strval($total_row+1).':'.$col_name[$col].strval($total_row+9))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B2:'.$col_name[$col].strval($total_row+9))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('B2:'.$col_name[$col].'3')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('B'.strval($total_row+1).':'.$col_name[$col].strval($total_row+2))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('B'.strval($total_row+5).':'.$col_name[$col].strval($total_row+5))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'FFFF00'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('B'.strval($total_row+6).':'.$col_name[$col].strval($total_row+6))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('B2:B'.strval($total_row+9))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[$start_col].'2:'.$col_name[$end_col].strval($total_row+9))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
        // foreach(range('B',$col_name[$end_col]) as $columnID) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        // }

        $filename='Production_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Production report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function get_product_stock_details($from_date, $to_date) {
    $sql = "select * from 
            (select KK.depot_id, KK.item_id, KK.opening_qty, KK.production_qty, KK.sale_qty, KK.sale_return_qty, KK.type, KK.item_name, KK.unit_weight, LL.state, LL.city, LL.depot_name from 
            (select II.depot_id, II.product_id as item_id, II.opening_qty, II.production_qty, II.sale_qty, II.sale_return_qty, II.type, JJ.product_name as item_name, JJ.grams as unit_weight from 
            (select GG.depot_id, GG.product_id, GG.opening_qty, GG.production_qty, GG.sale_qty, HH.sale_return_qty, 'Bar' as type from 
            (select EE.depot_id, EE.product_id, EE.opening_qty, EE.production_qty, FF.sale_qty from 
            (select CC.depot_id, CC.product_id, CC.opening_qty, DD.production_qty from 
            (select AA.depot_id, AA.product_id, BB.opening_qty from 
            (select distinct depot_id, product_id from 
            (select depot_id, product_id from batch_processing where status = 'Approved' 
            union all 
            select A.depot_id, B.product_id from 
            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved') A 
            left join 
            (select depot_transfer_id, item_id as product_id from depot_transfer_items where type = 'Bar') B 
            on (A.id=B.depot_transfer_id) 
            where B.product_id is not null 
            union all 
            select A.depot_id, B.product_id from 
            (select id, depot_id from distributor_in where status = 'Approved') A 
            left join 
            (select distributor_in_id, item_id as product_id from distributor_in_items where type = 'Bar') B 
            on (A.id=B.distributor_in_id) 
            where B.product_id is not null 
            union all 
            select C.depot_id, D.product_id from 
            (select A.depot_id, B.box_id from 
            (select id, depot_id from box_to_bar where status = 'Approved') A 
            left join 
            (select box_to_bar_id, box_id from box_to_bar_qty) B 
            on (A.id=B.box_to_bar_id) 
            where B.box_id is not null) C 
            left join 
            (select * from box_product) D 
            on (C.box_id=D.box_id) 
            where D.product_id is not null) E) AA 


            Left join 


            (select F.depot_id, F.product_id, ifnull(F.tot_qty_in,0)-ifnull(G.tot_qty_out,0) as opening_qty from 
            (select E.depot_id, E.product_id, sum(E.tot_qty) as tot_qty_in from 
            (select depot_id, product_id, sum(qty_in_bar) as tot_qty from batch_processing where status = 'Approved' and date_of_processing<'$from_date' group by depot_id, product_id 
            union all 
            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 
            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer<'$from_date') A 
            left join 
            (select depot_transfer_id, item_id as product_id, qty from depot_transfer_items where type = 'Bar') B 
            on (A.id=B.depot_transfer_id) 
            where B.product_id is not null 
            group by A.depot_id, B.product_id 
            union all 
            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select distributor_in_id, item_id as product_id, qty from distributor_in_items where type = 'Bar') B 
            on (A.id=B.distributor_in_id) 
            where B.product_id is not null 
            group by A.depot_id, B.product_id 
            union all 
            select C.depot_id, D.product_id, ifnull(C.tot_qty,0)*ifnull(D.qty,0) as tot_qty from 
            (select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from box_to_bar where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select box_to_bar_id, box_id, qty from box_to_bar_qty) B 
            on (A.id=B.box_to_bar_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) C 
            left join 
            (select * from box_product) D 
            on (C.box_id=D.box_id) 
            where D.product_id is not null) E 
            group by E.depot_id, E.product_id) F 

            left join 

            (select E.depot_id, E.product_id, sum(E.tot_qty) as tot_qty_out from 
            (select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 
            (select id, depot_out_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer<'$from_date') A 
            left join 
            (select depot_transfer_id, item_id as product_id, qty from depot_transfer_items where type = 'Bar') B 
            on (A.id=B.depot_transfer_id) 
            where B.product_id is not null 
            group by A.depot_id, B.product_id 
            union all 
            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select distributor_out_id, item_id as product_id, qty from distributor_out_items where type = 'Bar') B 
            on (A.id=B.distributor_out_id) 
            where B.product_id is not null 
            group by A.depot_id, B.product_id 
            union all 
            select C.depot_id, D.product_id, ifnull(C.tot_qty,0)*ifnull(D.qty,0) as tot_qty from 
            (select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from bar_to_box where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select bar_to_box_id, box_id, qty from bar_to_box_qty) B 
            on (A.id=B.bar_to_box_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) C 
            left join 
            (select * from box_product) D 
            on (C.box_id=D.box_id) 
            where D.product_id is not null) E 
            group by E.depot_id, E.product_id) G 
            on (F.depot_id=G.depot_id and F.product_id=G.product_id)) BB 
            on (AA.depot_id=BB.depot_id and AA.product_id=BB.product_id)) CC 


            left join 


            (select F.depot_id, F.product_id, ifnull(F.tot_qty_in,0)-ifnull(G.tot_qty_out,0) as production_qty from 
            (select E.depot_id, E.product_id, sum(E.tot_qty) as tot_qty_in from 
            (select depot_id, product_id, sum(qty_in_bar) as tot_qty from batch_processing where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date' group by depot_id, product_id 
            union all 
            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 
            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>='$from_date' and date_of_transfer<='$to_date') A 
            left join 
            (select depot_transfer_id, item_id as product_id, qty from depot_transfer_items where type = 'Bar') B 
            on (A.id=B.depot_transfer_id) 
            where B.product_id is not null 
            group by A.depot_id, B.product_id 
            union all 
            select C.depot_id, D.product_id, ifnull(C.tot_qty,0)*ifnull(D.qty,0) as tot_qty from 
            (select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from box_to_bar where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
            left join 
            (select box_to_bar_id, box_id, qty from box_to_bar_qty) B 
            on (A.id=B.box_to_bar_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) C 
            left join 
            (select * from box_product) D 
            on (C.box_id=D.box_id) 
            where D.product_id is not null) E 
            group by E.depot_id, E.product_id) F 

            left join 

            (select E.depot_id, E.product_id, sum(E.tot_qty) as tot_qty_out from 
            (select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 
            (select id, depot_out_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>='$from_date' and date_of_transfer<='$to_date') A 
            left join 
            (select depot_transfer_id, item_id as product_id, qty from depot_transfer_items where type = 'Bar') B 
            on (A.id=B.depot_transfer_id) 
            where B.product_id is not null 
            group by A.depot_id, B.product_id 
            union all 
            select C.depot_id, D.product_id, ifnull(C.tot_qty,0)*ifnull(D.qty,0) as tot_qty from 
            (select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from bar_to_box where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
            left join 
            (select bar_to_box_id, box_id, qty from bar_to_box_qty) B 
            on (A.id=B.bar_to_box_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) C 
            left join 
            (select * from box_product) D 
            on (C.box_id=D.box_id) 
            where D.product_id is not null) E 
            group by E.depot_id, E.product_id) G 
            on (F.depot_id=G.depot_id and F.product_id=G.product_id)) DD 
            on (CC.depot_id=DD.depot_id and CC.product_id=DD.product_id)) EE 


            left join 


            (select A.depot_id, B.product_id, sum(B.qty) as sale_qty from 
            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
            left join 
            (select distributor_out_id, item_id as product_id, qty from distributor_out_items where type = 'Bar') B 
            on (A.id=B.distributor_out_id) 
            where B.product_id is not null 
            group by A.depot_id, B.product_id) FF 
            on (EE.depot_id=FF.depot_id and EE.product_id=FF.product_id)) GG 


            Left join 


            (select A.depot_id, B.product_id, sum(B.qty) as sale_return_qty from 
            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select distributor_in_id, item_id as product_id, qty from distributor_in_items where type = 'Bar') B 
            on (A.id=B.distributor_in_id) 
            where B.product_id is not null 
            group by A.depot_id, B.product_id) HH 
            on (GG.depot_id=HH.depot_id and GG.product_id=HH.product_id)) II 


            left join 


            (select * from product_master) JJ 
            on (II.product_id=JJ.id)) KK 


            left join 


            (select * from depot_master) LL 
            on(KK.depot_id=LL.id)


            union all 


            select KK.depot_id, KK.item_id, KK.opening_qty, KK.production_qty, KK.sale_qty, KK.sale_return_qty, KK.type, KK.item_name, KK.unit_weight, LL.state, LL.city, LL.depot_name from 
            (select II.depot_id, II.box_id as item_id, II.opening_qty, II.production_qty, II.sale_qty, II.sale_return_qty, II.type, JJ.box_name as item_name, JJ.grams as unit_weight from 
            (select GG.depot_id, GG.box_id, GG.opening_qty, GG.production_qty, GG.sale_qty, HH.sale_return_qty, 'Box' as type from 
            (select EE.depot_id, EE.box_id, EE.opening_qty, EE.production_qty, FF.sale_qty from 
            (select CC.depot_id, CC.box_id, CC.opening_qty, DD.production_qty from 
            (select AA.depot_id, AA.box_id, BB.opening_qty from 
            (select distinct depot_id, box_id from 
            (select A.depot_id, B.box_id from 
            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved') A 
            left join 
            (select depot_transfer_id, item_id as box_id from depot_transfer_items where type = 'Box') B 
            on (A.id=B.depot_transfer_id) 
            where B.box_id is not null 
            union all 
            select A.depot_id, B.box_id from 
            (select id, depot_id from distributor_in where status = 'Approved') A 
            left join 
            (select distributor_in_id, item_id as box_id from distributor_in_items where type = 'Box') B 
            on (A.id=B.distributor_in_id) 
            where B.box_id is not null 
            union all 
            select A.depot_id, B.box_id from 
            (select id, depot_id from bar_to_box where status = 'Approved') A 
            left join 
            (select bar_to_box_id, box_id from bar_to_box_qty) B 
            on (A.id=B.bar_to_box_id) 
            where B.box_id is not null) E) AA 


            Left join 


            (select F.depot_id, F.box_id, ifnull(F.tot_qty_in,0)-ifnull(G.tot_qty_out,0) as opening_qty from 
            (select E.depot_id, E.box_id, sum(E.tot_qty) as tot_qty_in from 
            (select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer<'$from_date') A 
            left join 
            (select depot_transfer_id, item_id as box_id, qty from depot_transfer_items where type = 'Box') B 
            on (A.id=B.depot_transfer_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id 
            union all 
            select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select distributor_in_id, item_id as box_id, qty from distributor_in_items where type = 'Box') B 
            on (A.id=B.distributor_in_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id 
            union all 
            select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from bar_to_box where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select bar_to_box_id, box_id, qty from bar_to_box_qty) B 
            on (A.id=B.bar_to_box_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) E 
            group by E.depot_id, E.box_id) F 

            left join 

            (select E.depot_id, E.box_id, sum(E.tot_qty) as tot_qty_out from 
            (select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_out_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer<'$from_date') A 
            left join 
            (select depot_transfer_id, item_id as box_id, qty from depot_transfer_items where type = 'Box') B 
            on (A.id=B.depot_transfer_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id 
            union all 
            select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select distributor_out_id, item_id as box_id, qty from distributor_out_items where type = 'Box') B 
            on (A.id=B.distributor_out_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id 
            union all 
            select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from box_to_bar where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select box_to_bar_id, box_id, qty from box_to_bar_qty) B 
            on (A.id=B.box_to_bar_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) E 
            group by E.depot_id, E.box_id) G 
            on (F.depot_id=G.depot_id and F.box_id=G.box_id)) BB 
            on (AA.depot_id=BB.depot_id and AA.box_id=BB.box_id)) CC 


            left join 


            (select F.depot_id, F.box_id, ifnull(F.tot_qty_in,0)-ifnull(G.tot_qty_out,0) as production_qty from 
            (select E.depot_id, E.box_id, sum(E.tot_qty) as tot_qty_in from 
            (select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>='$from_date' and date_of_transfer<='$to_date') A 
            left join 
            (select depot_transfer_id, item_id as box_id, qty from depot_transfer_items where type = 'Box') B 
            on (A.id=B.depot_transfer_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id 
            union all 
            select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from bar_to_box where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
            left join 
            (select bar_to_box_id, box_id, qty from bar_to_box_qty) B 
            on (A.id=B.bar_to_box_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) E 
            group by E.depot_id, E.box_id) F 

            left join 

            (select E.depot_id, E.box_id, sum(E.tot_qty) as tot_qty_out from 
            (select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_out_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>='$from_date' and date_of_transfer<='$to_date') A 
            left join 
            (select depot_transfer_id, item_id as box_id, qty from depot_transfer_items where type = 'Box') B 
            on (A.id=B.depot_transfer_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id 
            union all 
            select A.depot_id, B.box_id, sum(B.qty) as tot_qty from 
            (select id, depot_id from box_to_bar where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
            left join 
            (select box_to_bar_id, box_id, qty from box_to_bar_qty) B 
            on (A.id=B.box_to_bar_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) E 
            group by E.depot_id, E.box_id) G 
            on (F.depot_id=G.depot_id and F.box_id=G.box_id)) DD 
            on (CC.depot_id=DD.depot_id and CC.box_id=DD.box_id)) EE 


            left join 


            (select A.depot_id, B.box_id, sum(B.qty) as sale_qty from 
            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 
            left join 
            (select distributor_out_id, item_id as box_id, qty from distributor_out_items where type = 'Box') B 
            on (A.id=B.distributor_out_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) FF 
            on (EE.depot_id=FF.depot_id and EE.box_id=FF.box_id)) GG 


            Left join 


            (select A.depot_id, B.box_id, sum(B.qty) as sale_return_qty from 
            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing<'$from_date') A 
            left join 
            (select distributor_in_id, item_id as box_id, qty from distributor_in_items where type = 'Box') B 
            on (A.id=B.distributor_in_id) 
            where B.box_id is not null 
            group by A.depot_id, B.box_id) HH 
            on (GG.depot_id=HH.depot_id and GG.box_id=HH.box_id)) II 


            left join 


            (select * from box_master) JJ 
            on (II.box_id=JJ.id)) KK 


            left join 


            (select * from depot_master) LL 
            on(KK.depot_id=LL.id)) MM 
            order by MM.depot_name, MM.type, MM.item_name";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function generate_product_stock_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $data = $this->get_product_stock_details($from_date, $to_date);
    
    if(count($data)>0) {
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Product_Stock.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=1;
        $col=0;
        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->state);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->city);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->depot_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->unit_weight);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->opening_qty);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->production_qty);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->sale_qty);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->sale_return_qty);
            // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, '');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, '=+'.$col_name[$col+6].$row.'+'.$col_name[$col+7].$row.'-'.$col_name[$col+8].$row.'+'.$col_name[$col+9].$row.'-'.$col_name[$col+10].$row);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+11].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $filename='Product_Stock_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Product Stock report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function generate_distributor_ledger_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $distributor_id = $this->input->post('distributor_id');
    
    $sql = "select ref_date, reference,debit_amount,credit_amount,rdate from 
    (select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, invoice_no as reference, final_amount as debit_amount, null as credit_amount ,date_of_processing as rdate
                from distributor_out where status = 'Approved' and distributor_id = '$distributor_id' and 
                date_of_processing>='$from_date' and date_of_processing<='$to_date' 
            union all 
            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 'Sales Return' as reference, null as debit_amount, final_amount as credit_amount ,date_of_processing as rdate
                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 
                date_of_processing>='$from_date' and date_of_processing<='$to_date' 
            union all 
            select * from 
            (select DATE_FORMAT(A.date_of_deposit,'%d/%m/%Y') as ref_date, B.invoice_no as reference, null as debit_amount, B.payment_amount as credit_amount,A.date_of_deposit as rdate from 
            (select * from payment_details where status = 'Approved' and 
                date_of_deposit>='$from_date' and date_of_deposit<='$to_date') A 
            left join 
            (select * from payment_details_items where distributor_id = '$distributor_id') B 
            on (A.id=B.payment_id)) C where C.credit_amount is not null 
            union all 
            select DATE_FORMAT(date_of_transaction,'%d/%m/%Y') as ref_date, transaction as reference, 
                    case when transaction='Debit Note' then amount end as debit_amount, 
                    case when transaction='Credit Note' then amount end as credit_amount,date_of_transaction as rdate 
                from credit_debit_note where status = 'Approved' and distributor_id = '$distributor_id' and 
                date_of_transaction>='$from_date' and date_of_transaction<='$to_date') A order by A.rdate asc";
    $query=$this->db->query($sql);
    $data=$query->result();

    $sql1 = "select distributor_name from distributor_master where id='$distributor_id'";
    $query1=$this->db->query($sql1);
    $data1=$query1->result();
    
    if(count($data)>0) {
        // $template_path=$this->config->item('template_path');
        // $file = $template_path.'Product_Stock.xls';
        // $this->load->library('excel');
        // $objPHPExcel = PHPExcel_IOFactory::load($file);

        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row1=1;

        $row=6;
        $col=0;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Distributor Name:");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $data1[0]->distributor_name);
        $row1=$row1+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "From Date:");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $this->input->post('from_date'));
        $row1=$row1+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "To Date:");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $this->input->post('to_date'));

        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Ref Date');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Reference');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Debit');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Credit');

        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->ref_date);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->reference);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->debit_amount);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->credit_amount);
        }

        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, '=sum('.$col_name[$col+2].'2'.':'.$col_name[$col+2].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, '=sum('.$col_name[$col+3].'2'.':'.$col_name[$col+3].strval($row-1).')');
        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, '='.$col_name[$col+2].strval($row-1).'-'.$col_name[$col+3].strval($row-1));
        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row-1).':'.$col_name[$col+1].strval($row-1));
        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row).':'.$col_name[$col+2].strval($row));

        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[$col+3].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col !== 'D'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            if($col == 'H'){
                break;
            }
        }

        $filename='Distributor_Ledger_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Distributor ledger report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}


function view_distributor_ledger_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $distributor_id = $this->input->post('distributor_id');
    
    $sql = "select ref_date, reference,debit_amount,credit_amount,rdate from 
    (select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, invoice_no as reference, final_amount as debit_amount, null as credit_amount ,date_of_processing as rdate
                from distributor_out where status = 'Approved' and distributor_id = '$distributor_id' and 
                date_of_processing>='$from_date' and date_of_processing<='$to_date' 
            union all 
            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 'Sales Return' as reference, null as debit_amount, final_amount as credit_amount ,date_of_processing as rdate
                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 
                date_of_processing>='$from_date' and date_of_processing<='$to_date' 
            union all 
            select * from 
            (select DATE_FORMAT(A.date_of_deposit,'%d/%m/%Y') as ref_date, B.invoice_no as reference, null as debit_amount, B.payment_amount as credit_amount,A.date_of_deposit as rdate from 
            (select * from payment_details where status = 'Approved' and 
                date_of_deposit>='$from_date' and date_of_deposit<='$to_date') A 
            left join 
            (select * from payment_details_items where distributor_id = '$distributor_id') B 
            on (A.id=B.payment_id)) C where C.credit_amount is not null 
            union all 
            select DATE_FORMAT(date_of_transaction,'%d/%m/%Y') as ref_date, transaction as reference, 
                    case when transaction='Debit Note' then amount end as debit_amount, 
                    case when transaction='Credit Note' then amount end as credit_amount,date_of_transaction as rdate 
                from credit_debit_note where status = 'Approved' and distributor_id = '$distributor_id' and 
                date_of_transaction>='$from_date' and date_of_transaction<='$to_date') A order by A.rdate asc";
    $query=$this->db->query($sql);
    $data=$query->result();

    return $data;

}


function generate_agingwise_report() {
    $date = formatdate($this->input->post('date'));
    
    // $sql = "select G.*, H.distributor_name from 
    //         (select F.distributor_id, F.days_30_45, F.days_46_60, F.days_61_90, F.days_91_above, 
    //             (F.days_30_45+F.days_46_60+F.days_61_90+F.days_91_above) as tot_receivable from 
    //         (select E.distributor_id, case when (E.days_30_45-E.paid_amount)>0 then 
    //             (E.days_30_45-E.paid_amount) else 0 end as days_30_45, 
    //         case when (E.days_30_45-E.paid_amount)>0 then E.days_46_60 else case when 
    //             (E.days_46_60-(E.paid_amount-E.days_30_45))>0 then 
    //             (E.days_46_60-(E.paid_amount-E.days_30_45)) else 0 end end as days_46_60, 
    //         case when (E.days_46_60-(E.paid_amount-E.days_30_45))>0 then 
    //         E.days_61_90 else case when (E.days_61_90-(E.paid_amount-E.days_30_45-E.days_46_60))>0 then 
    //         (E.days_61_90-(E.paid_amount-E.days_30_45-E.days_46_60)) else 0 end end as days_61_90, 
    //         case when (E.days_61_90-(E.paid_amount-E.days_30_45-E.days_46_60))>0 then E.days_91_above else case 
    //             when (E.days_91_above-(E.paid_amount-E.days_30_45-E.days_46_60-E.days_61_90))>0 
    //             then (E.days_91_above-(E.paid_amount-E.days_30_45-E.days_46_60-E.days_61_90)) else 0 end end as days_91_above from 
    //         (select C.distributor_id, C.days_30_45, C.days_46_60, C.days_61_90, C.days_91_above, 
    //             ifnull(D.paid_amount,0) as paid_amount from 
    //         (select distributor_id, ifnull(round(sum(days_30_45),0),0) as days_30_45, 
    //             ifnull(round(sum(days_46_60),0),0) as days_46_60, 
    //         ifnull(round(sum(days_61_90),0),0) as days_61_90, ifnull(round(sum(days_91_above),0),0) as days_91_above from 
    //         (select distributor_id, case when no_of_days>=30 and no_of_days<=45 then final_amount else 0 end as days_30_45, 
    //         case when no_of_days>=46 and no_of_days<=60 then final_amount else 0 end as days_46_60, 
    //         case when no_of_days>=61 and no_of_days<=90 then final_amount else 0 end as days_61_90, 
    //         case when no_of_days>=91 then final_amount else 0 end as days_91_above from 
    //         (select id, distributor_id, datediff('$date', date_of_processing) as no_of_days, 
    //             final_amount from distributor_out where status = 'Approved' and date_of_processing<='$date') A) B 
    //         group by distributor_id) C 
    //         left join 
    //         (select distributor_id, round(sum(payment_amount),0) as paid_amount from payment_details_items 
    //             where payment_id in (select distinct id from payment_details where status = 'Approved' and 
    //                 date_of_deposit<='$date') group by distributor_id) D 
    //         on (C.distributor_id = D.distributor_id)) E) F) G 
    //         left join 
    //         (select * from distributor_master) H 
    //         on (G.distributor_id = H.id) where G.tot_receivable > 0";

    $sql = "select G.*, H.distributor_name from 
            (select F.distributor_id, F.days_0_30, F.days_30_45, F.days_46_60, F.days_61_90, F.days_91_above, 
                (F.days_0_30+F.days_30_45+F.days_46_60+F.days_61_90+F.days_91_above) as tot_receivable from 
            (select E.distributor_id, case when (E.days_91_above-E.paid_amount)>0 then 
                (E.days_91_above-E.paid_amount) else 0 end as days_91_above, 
            case when (E.days_91_above-E.paid_amount)>0 then E.days_61_90 else case when 
                (E.days_61_90-(E.paid_amount-E.days_91_above))>0 then 
                (E.days_61_90-(E.paid_amount-E.days_91_above)) else 0 end end as days_61_90, 
            case when (E.days_61_90-(E.paid_amount-E.days_91_above))>0 then 
            E.days_46_60 else case when (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90))>0 then 
            (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90)) else 0 end end as days_46_60, 
            case when (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90))>0 then E.days_30_45 else case 
                when (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60))>0 
                then (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60)) else 0 end end as days_30_45, 
            case when (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60))>0 then E.days_0_30 else case 
                when (E.days_0_30-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60-E.days_30_45))>0 
                then (E.days_0_30-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60-E.days_30_45)) else 0 end end as days_0_30 from 
            (select C.distributor_id, C.days_0_30, C.days_30_45, C.days_46_60, C.days_61_90, C.days_91_above, 
                ifnull(D.paid_amount,0) as paid_amount from 
            (select distributor_id, ifnull(round(sum(days_0_30),0),0) as days_0_30, 
                ifnull(round(sum(days_30_45),0),0) as days_30_45, 
                ifnull(round(sum(days_46_60),0),0) as days_46_60, 
            ifnull(round(sum(days_61_90),0),0) as days_61_90, ifnull(round(sum(days_91_above),0),0) as days_91_above from 
            (select distributor_id, case when no_of_days<30 then final_amount else 0 end as days_0_30, 
            case when no_of_days>=30 and no_of_days<=45 then final_amount else 0 end as days_30_45, 
            case when no_of_days>=46 and no_of_days<=60 then final_amount else 0 end as days_46_60, 
            case when no_of_days>=61 and no_of_days<=90 then final_amount else 0 end as days_61_90, 
            case when no_of_days>=91 then final_amount else 0 end as days_91_above from 
            (select id, distributor_id, datediff('$date', date_of_processing) as no_of_days, 
                final_amount from distributor_out where status = 'Approved' and date_of_processing<='$date') A) B 
            group by distributor_id) C 
            left join 
            (select distributor_id, round(sum(payment_amount),0) as paid_amount from payment_details_items 
                where payment_id in (select distinct id from payment_details where status = 'Approved' and 
                    date_of_deposit<='$date') group by distributor_id) D 
            on (C.distributor_id = D.distributor_id)) E) F) G 
            left join 
            (select * from distributor_master) H 
            on (G.distributor_id = H.id) where G.tot_receivable > 0";
    $query=$this->db->query($sql);
    $data=$query->result();
    
    if(count($data)>0) {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=1;
        $col=0;

        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Distributor Id");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Distributor Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "0 - 30 Days");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "30 - 45 Days");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "46 - 60 Days");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "61 - 90 Days");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "91+");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Total Receivable");

        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->distributor_id);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->days_0_30);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->days_30_45);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->days_46_60);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->days_61_90);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->days_91_above);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->tot_receivable);
        }

        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, '=sum('.$col_name[$col+2].'2'.':'.$col_name[$col+2].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, '=sum('.$col_name[$col+3].'2'.':'.$col_name[$col+3].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, '=sum('.$col_name[$col+5].'2'.':'.$col_name[$col+5].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=sum('.$col_name[$col+6].'2'.':'.$col_name[$col+6].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, '=sum('.$col_name[$col+7].'2'.':'.$col_name[$col+7].strval($row-1).')');
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+7].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        for($col = 'A'; $col < 'I'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $filename='Agingwise_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Agingwise report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function generate_distributorwise_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));

    // $sql = "select K.*, date_format(date(modified_on),'%d-%b-%Y') as modified_date, 
    //         case when L.no_of_days <= 90 then 'Active' when L.no_of_days <= 180 then 'Inactive' else 'Dormant' end as d_status from 
    //         (select I.*, J.contact_person as c_contact_person, J.email_id as c_email_id, J.mobile as c_mobile from
    //         (select G.*, H.zone from 
    //         (select E.*, F.distributor_type from 
    //         (select C.*, D.area from 
    //         (select A.*, B.sales_rep_name from 
    //         (select * from distributor_master where status = 'Approved' and date(modified_on) >= date '$from_date' and date(modified_on) <= date '$to_date') A 
    //         left join 
    //         (select * from sales_rep_master) B 
    //         on (A.sales_rep_id = B.id)) C 
    //         left join 
    //         (select * from area_master) D 
    //         on (C.area_id = D.id)) E 
    //         left join 
    //         (select * from distributor_type_master) F 
    //         on (E.type_id = F.id)) G 
    //         left join 
    //         (select * from zone_master) H 
    //         on (G.zone_id = H.id)) I 
    //         left join 
    //         (select * from distributor_contacts A where A.id = (select min(id) from distributor_contacts B where A.distributor_id=B.distributor_id)) J 
    //         on (I.id = J.distributor_id)) K 
    //         left join 
    //         (select distributor_id, ifnull(min(no_of_days),0) as no_of_days from 
    //         (select distributor_id, datediff(curdate(), date_of_processing) as no_of_days from distributor_out where status = 'Approved') A group by distributor_id) L 
    //         on (K.id = L.distributor_id) order by K.id";
    $sql = "select K.*, date_format(date(modified_on),'%d-%b-%Y') as modified_date, 
            case when L.no_of_days <= 90 then 'Active' when L.no_of_days <= 180 then 'Inactive' else 'Dormant' end as d_status from 
            (select M.*, J.contact_person as c_contact_person, J.email_id as c_email_id, J.mobile as c_mobile from
            (select I.*, N.location from 
            (select G.*, H.zone from 
            (select E.*, F.distributor_type from 
            (select C.*, D.area from 
            (select A.*, B.sales_rep_name from 
            (select * from distributor_master where status = 'Approved' and date(modified_on) >= date '$from_date' and date(modified_on) <= date '$to_date') A 
            left join 
            (select * from sales_rep_master) B 
            on (A.sales_rep_id = B.id)) C 
            left join 
            (select * from area_master) D 
            on (C.area_id = D.id)) E 
            left join 
            (select * from distributor_type_master) F 
            on (E.type_id = F.id)) G 
            left join 
            (select * from zone_master) H 
            on (G.zone_id = H.id)) I 
            left join 
            (select * from location_master) N 
            on (I.location_id = N.id)) M 
            left join 
            (select * from distributor_contacts A where A.id = (select min(id) from distributor_contacts B where A.distributor_id=B.distributor_id)) J 
            on (M.id = J.distributor_id)) K 
            left join 
            (select distributor_id, ifnull(min(no_of_days),0) as no_of_days from 
            (select distributor_id, datediff(curdate(), date_of_processing) as no_of_days from distributor_out where status = 'Approved') A group by distributor_id) L 
            on (K.id = L.distributor_id) order by K.id";
    $query=$this->db->query($sql);
    $data=$query->result();
    
    if(count($data)>0) {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=30; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=1;
        $col=0;

        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Distributor Id");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Distributor Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Address");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "City");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Pincode");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "State");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Country");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Email Id");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Mobile ");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Tin Number");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Cst Number");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Sales Representative");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Margin On MRP (In %)");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Generate Invoice ");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, "Credit Period (In Days) ");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, "Class ");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, "Area");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, "Type");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, "Zone");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, "Location");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, "Contact Person *");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, "Email Id");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, "Mobile *");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, "Status");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, "Modified On");


        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->id);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->address);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->city);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->pincode);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->state);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->country);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->email_id);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->mobile);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->tin_number);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->cst_number);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->sales_rep_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->sell_out);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->send_invoice);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->credit_period);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, $data[$i]->class);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->area);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, $data[$i]->distributor_type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, $data[$i]->zone);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->location);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->c_contact_person);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->c_email_id);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, $data[$i]->c_mobile);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $data[$i]->d_status);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, $data[$i]->modified_date);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+24].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        for($col = 'A'; $col < 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $filename='Distributorwise_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Distributorwise report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function generate_sales_return_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    
    $sql = "select K.*, case when K.type = 'Box' then K.box_name else K.product_name end as item_name from 
            (select I.*, J.product_name from 
            (select G.*, H.box_name from 
            (select E.*, F.depot_name from 
            (select C.*, D.distributor_name, D.sell_out from 
            (select A.*, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate from 
            (select * from distributor_in where status = 'Approved' and 
                date_of_processing >= '$from_date' and date_of_processing <= '$to_date') A 
            left join 
            (select * from distributor_in_items) B 
            on (A.id = B.distributor_in_id)) C 
            left join 
            (select * from distributor_master) D 
            on (C.distributor_id = D.id)) E 
            left join 
            (select * from depot_master) F 
            on (E.depot_id = F.id)) G 
            left join 
            (select * from box_master) H 
            on (G.item_id = H.id)) I 
            left join 
            (select * from product_master) J 
            on (I.item_id = J.id)) K 
            order by K.id";
    $query=$this->db->query($sql);
    $data=$query->result();
    
    if(count($data)>0) {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=1;
        $col=0;

        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Date of Return");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Distributor Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Name of Product");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Box/Bar");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Qty");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "MRP");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Sell Rate");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Margin");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Amount (exld Tax)");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "VAT/CST");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Total Amount");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Depot");


        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->date_of_processing);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->qty);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, round($data[$i]->sell_rate,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->sell_out);

            $qty = floatval($data[$i]->qty);
            $sell_rate = floatval($data[$i]->sell_rate);
            // $rate = floatval($data[$i]->rate);
            // $sell_out = floatval($data[$i]->sell_out);
            $cst = floatval($data[$i]->cst);

            $amount = $qty * $sell_rate;
            $cst_amount = $amount * $cst / 100;
            $total_amount = $amount + $cst_amount;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, round($amount,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, round($cst_amount,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, round($total_amount,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->depot_name);
        }

        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, '=sum('.$col_name[$col+8].'2'.':'.$col_name[$col+8].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, '=sum('.$col_name[$col+9].'2'.':'.$col_name[$col+9].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, '=sum('.$col_name[$col+10].'2'.':'.$col_name[$col+10].strval($row-1).')');
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+11].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        for($col = 'A'; $col <= 'L'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $filename='Sales_Return_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Sales Return report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function generate_payment_receivable_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    
    $sql = "select K.*, case when K.type = 'Box' then K.box_name else K.product_name end as item_name, L.sales_rep_name from 
            (select I.*, J.product_name from 
            (select G.*, H.box_name from 
            (select E.*, F.depot_name from 
            (select C.*, D.distributor_name, D.sell_out from 
            (select A.*, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate from 
            (select * from distributor_out where status = 'Approved' and 
                date_of_processing >= '$from_date' and date_of_processing <= '$to_date') A 
            left join 
            (select * from distributor_out_items) B 
            on (A.id = B.distributor_out_id)) C 
            left join 
            (select * from distributor_master) D 
            on (C.distributor_id = D.id)) E 
            left join 
            (select * from depot_master) F 
            on (E.depot_id = F.id)) G 
            left join 
            (select * from box_master) H 
            on (G.item_id = H.id)) I 
            left join 
            (select * from product_master) J 
            on (I.item_id = J.id)) K 
            left join 
            (select * from sales_rep_master) L 
            on (K.sales_rep_id = L.id)
            order by K.id";
    $query=$this->db->query($sql);
    $data=$query->result();
    
    if(count($data)>0) {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=1;
        $col=0;

        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Date");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Invoice No");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Name of Product");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Box/Bar");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Qty");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "MRP");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Sell Rate");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Margin");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Amount (exld Tax)");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "VAT/CST");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Total Amount");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Depot");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Distributor");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Sales Representative");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, "Payment Due Date");

        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->date_of_processing);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->invoice_no);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->qty);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, round($data[$i]->sell_rate,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->sell_out);

            $qty = floatval($data[$i]->qty);
            $sell_rate = floatval($data[$i]->sell_rate);
            // $rate = floatval($data[$i]->rate);
            // $sell_out = floatval($data[$i]->sell_out);
            $cst = floatval($data[$i]->cst);

            $amount = $qty * $sell_rate;
            $cst_amount = $amount * $cst / 100;
            $total_amount = $amount + $cst_amount;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, round($amount,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, round($cst_amount,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, round($total_amount,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->depot_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->sales_rep_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->due_date);
        }

        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, '=sum('.$col_name[$col+8].'2'.':'.$col_name[$col+8].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, '=sum('.$col_name[$col+9].'2'.':'.$col_name[$col+9].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, '=sum('.$col_name[$col+10].'2'.':'.$col_name[$col+10].strval($row-1).')');
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+14].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        for($col = 'A'; $col <= 'O'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $filename='Payment_Receivable_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Payment Receivable report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function generate_purchase_order_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    
    $sql = "select E.*, F.rm_name from 
            (select C.*, D.vendor_name from 
            (select A.*, B.item_id, B.qty, B.rate, B.cst, B.amount as item_amount from 
            (select * from purchase_order where status = 'Approved' and order_date >= '$from_date' and order_date <= '$to_date') A 
            left join 
            (select * from purchase_order_items) B 
            on (A.id = B.purchase_order_id)) C 
            left join 
            (select * from vendor_master) D 
            on (C.vendor_id = D.id)) E 
            left join 
            (select * from raw_material_master) F 
            on (E.item_id = F.id) 
            order by E.id";
    $query=$this->db->query($sql);
    $data=$query->result();
    
    if(count($data)>0) {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=1;
        $col=0;

        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "PO Date");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Vendor Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Material name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Qty (in Kg)");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Rate");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "VAT/CST");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Total Amount");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Delivery Date");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Total Amount (In Rs) ");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Shipping Method");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Shipping Term");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Remarks");

        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->order_date);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->vendor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->rm_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->qty);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->cst);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, round($data[$i]->item_amount,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->delivery_date);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, round($data[$i]->amount,0));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->shipping_method);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->shipping_term);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->remarks);
        }

        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=sum('.$col_name[$col+6].'2'.':'.$col_name[$col+6].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, '=sum('.$col_name[$col+8].'2'.':'.$col_name[$col+8].strval($row-1).')');
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+11].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        for($col = 'A'; $col <= 'L'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $filename='Purchase_Order_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Purchase Order report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

function generate_production_data_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    
    $sql = "select C.*, D.depot_name from 
            (select A.*, B.product_name from 
            (select * from batch_processing where status = 'Approved' and 
                date_of_processing >= '$from_date' and date_of_processing <= '$to_date') A 
            left join 
            (select * from product_master) B 
            on (A.product_id = B.id)) C 
            left join 
            (select * from depot_master) D 
            on (C.depot_id = D.id) 
            order by C.id";
    $query=$this->db->query($sql);
    $data=$query->result();
    
    if(count($data)>0) {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=1;
        $col=0;

        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Batch Id");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Date of processing");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Depot Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Product Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Input Kg");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Output KG");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Qty in Bar");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Actual Wasteage Kg");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Wastage %");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Anticipted Wastage%");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Wastage Variance (In %) ");

        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->batch_id_as_per_fssai);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->date_of_processing);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->depot_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->product_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, round($data[$i]->total_kg,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, round($data[$i]->output_kg,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->qty_in_bar);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, round($data[$i]->actual_wastage,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, round($data[$i]->wastage_percent,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, round($data[$i]->anticipated_wastage,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, round($data[$i]->wastage_variance,2));
        }

        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, '=sum('.$col_name[$col+5].'2'.':'.$col_name[$col+5].strval($row-1).')');
        
        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+10].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        for($col = 'A'; $col <= 'K'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $filename='Production_Data_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Production Data report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}



function get_sales_rep_loc_data($sales_rep, $from_date, $to_date){
    $sql = "select A.*,TIME(A.modified_on) as modified_on_time, B.sales_rep_name, B.email_id, abs(timestampdiff(minute,A.modified_on,(select t2.modified_on from sales_rep_location t2 where t2.id < A.id order by t2.id desc limit 1))) as diff,C.area from sales_rep_location A left join sales_rep_master B on A.sales_rep_id = B.id left join sales_rep_area C on (A.date_of_visit=C.date_of_visit and A.sales_rep_id=C.sales_rep_id) where A.status = 'Approved' and A.date_of_visit >= '$from_date' and A.date_of_visit <= '$to_date' and A.sales_rep_id = '$sales_rep' order by A.modified_on asc";
    // $sql = "select A.*,TIME(A.modified_on) as modified_on_time, B.sales_rep_name, B.email_id, abs(timestampdiff(minute,A.modified_on,(select t2.modified_on from sales_rep_location t2
    //     where t2.id < A.id order by t2.id desc limit 1))) as diff from sales_rep_location A left join sales_rep_master B on A.sales_rep_id = B.id where A.status = 'Approved' and A.date_of_visit >= '$from_date' and A.date_of_visit <= '$to_date' and A.sales_rep_id = '$sales_rep' order by A.modified_on asc";
    // $sql = "select A.*,TIME(A.modified_on) as modified_on_time, B.sales_rep_name from 
    //         (select * from sales_rep_location where status = 'Approved' and 
    //             date_of_visit >= '$from_date' and date_of_visit <= '$to_date' and sales_rep_id = '$sales_rep') A 
    //         left join 
    //         (select * from sales_rep_master) B 
    //         on (A.sales_rep_id = B.id)  
    //         order by A.modified_on desc";
    $query=$this->db->query($sql);
    return $query->result();
}

function generate_sales_representative_location_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
	$sales_rep = $this->input->post('salesrep_id');
    
    $data=$this->get_sales_rep_loc_data($sales_rep, $from_date, $to_date);
    
    if(count($data)>0) {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row1=1;


        $row=6;
        $col=0;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Sales Representative Name:");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $data[0]->sales_rep_name);
        $row1=$row1+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "From Date:");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $this->input->post('from_date'));
        $row1=$row1+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "To Date:");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $this->input->post('to_date'));
        //$row1=$row1+1;
        
        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Date of Visit");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Sales Representative Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Area Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Distributor Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Distributor Type");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Visit Status");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Remarks");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Creation Date");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Time");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Time Difference");

        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->date_of_visit);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->sales_rep_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->area);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->distributor_type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->distributor_status);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->remarks);
			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->modified_on);
			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->modified_on_time);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->diff.' minutes');
        }

        // $row=$row+1;
        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-1).')');
        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, '=sum('.$col_name[$col+5].'2'.':'.$col_name[$col+5].strval($row-1).')');
        
        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[$col+9].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'D9D9D9'
            )
        ));
        for($col = 'A'; $col <= 'J'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $filename='Sales_Representative_Location_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Sales Representative Location report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}



function generate_credit_debit_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
	// $sales_rep = $this->input->post('salesrep_id');
    
    $sql = "select d.date_of_processing as ref_date, d.invoice_no as reference, d.final_amount as debit_amount, null as credit_amount, m.distributor_name 
                from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 
                d.date_of_processing>='$from_date' and d.date_of_processing<='$to_date' 
            union all 
            select d.date_of_processing as ref_date, null as reference, null as debit_amount, d.final_amount as credit_amount, m.distributor_name 
                from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 
                d.date_of_processing>='$from_date' and d.date_of_processing<='$to_date' 
            union all 
            select * from 
            (select A.date_of_deposit as ref_date, B.invoice_no as reference, null as debit_amount, B.payment_amount as credit_amount, E.distributor_name from 
            (select * from payment_details where status = 'Approved' and 
                date_of_deposit>='$from_date' and date_of_deposit<='$to_date') A 
            left join 
            (select * from payment_details_items) B 
            on (A.id=B.payment_id)
			left join
			(select * from distributor_master) E
			on (E.id=B.distributor_id)) C where C.credit_amount is not null 
            union all 
            select d.date_of_transaction as ref_date, d.transaction as reference, 
                    case when d.transaction='Debit Note' then amount end as debit_amount, 
                    case when d.transaction='Credit Note' then amount end as credit_amount , m.distributor_name
                from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' and 
                d.date_of_transaction>='$from_date' and d.date_of_transaction<='$to_date'";
    $query=$this->db->query($sql);
    $data=$query->result();
    
    if(count($data)>0) {
        // $template_path=$this->config->item('template_path');
        // $file = $template_path.'Product_Stock.xls';
        // $this->load->library('excel');
        // $objPHPExcel = PHPExcel_IOFactory::load($file);

        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row=1;
        $col=0;

        //------------ setting headers of excel -------------
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Ref Date');
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Distributor Name');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Reference');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Debit');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Credit');

        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->ref_date);
			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->reference);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->debit_amount);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->credit_amount);
        }

        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, '=sum('.$col_name[$col+3].'2'.':'.$col_name[$col+3].strval($row-2).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-2).')');
        $row=$row+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '='.$col_name[$col+3].strval($row-2).'-'.$col_name[$col+4].strval($row-2));
        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row-2).':'.$col_name[$col+2].strval($row-2));
        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row).':'.$col_name[$col+3].strval($row));

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+4].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        for($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            if($col == 'I'){
                break;
            }
        }

        $filename='All_Distributor_Ledger_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='All Distributor ledger report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}

}
?>