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



function get_access(){

    $role_id=$this->session->userdata('role_id');

    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Reports' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");

    return $query->result();

}



function get_distributor_out_details($from_date, $to_date) {

    // $sql = "select L.*, M.area from 

    //         (select I.*, K.location from 

    //         (select M.*, H.sales_rep_name from 

    //         (select G.*, L.distributor_type from 

    //         (select E.*, F.distributor_name, F.sell_out, F.type_id, F.location_id, F.city as distributor_city, F.area_id from 

    //         (select C.*, D.depot_name from 

    //         (select *, WEEK(date_of_processing,2)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',

    //                             MONTH(date_of_processing),'-',1),'%Y-%m-%d'),2)+1 as dweek 

    //             from distributor_out where (status='Approved' or status='InActive') and 

    //                     date_of_processing>='$from_date' and date_of_processing<='$to_date') C 

    //         left join 

    //         (select * from depot_master) D 

    //         on (C.depot_id=D.id)) E 

    //         left join 

    //         (select * from distributor_master where distributor_name not like '%Sample%' and distributor_name not like '%Product Expired%') F 

    //         on (E.distributor_id=F.id)) G 

    //         left join

    //         (select * from distributor_type_master) L 

    //         on (G.type_id=L.id)) M 

    //         left join 

    //         (select * from sales_rep_master) H 

    //         on (M.sales_rep_id=H.id)) I 

    //         left join 

    //         (select * from location_master) K 

    //         on (I.location_id=K.id)) L 

    //         left join 

    //         (select * from area_master) M 

    //         on (L.area_id=M.id) 

    //         where L.distributor_id!='1' and L.distributor_id!='189' 

    //         order by L.date_of_processing desc";



    $sql = "select N.*, O.zone as dist_zone from 

            (select L.*, M.area from 

            (select I.*, K.location from 

            (select M.*, H.sales_rep_name from 

            (select G.*, L.distributor_type from 

            (select E.*, F.distributor_name, F.sell_out, F.type_id, F.zone_id,F.location_id, 
                    F.city as distributor_city, F.area_id, F.class, F.state as dist_state, 
                    F.state_code as dist_state_code, F.gst_number as dist_gst_no from 

            (select C.*, D.depot_name from 

            (select *, WEEK(invoice_date,1)-WEEK(STR_TO_DATE(concat(YEAR(invoice_date),'-',

                                MONTH(invoice_date),'-',1),'%Y-%m-%d'),1)+1 as dweek 

                from distributor_out where (status='Approved' or status='InActive') and 

                        invoice_date>='$from_date' and invoice_date<='$to_date') C 

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

            (select * from location_master) K 

            on (I.location_id=K.id)) L 

            left join 

            (select * from area_master) M 

            on (L.area_id=M.id)) N 

            left join 

            (select * from zone_master) O 

            on (N.zone_id=O.id)

            where N.class!='sample' or N.class is null 

            order by N.invoice_date desc";

    $query=$this->db->query($sql);

    $result=$query->result();

    $this->db->last_query();

    return $result;

}

function get_sample_expired_details($from_date, $to_date) {

    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek from 

            (select A.*, A.id as sampleid, C.depot_name, D.distributor_name, D.sell_out, D.type_id,

                D.zone_id,D.area_id, D.location_id, D.city as distributor_city, D.class, 

                E.distributor_type, F.sales_rep_name, G.location, I.distributor_name as dname, H.area, 

                D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, 

                J.zone as dist_zone 

                from distributor_out A 

                left join depot_master C on(A.depot_id=C.id) 

                left join distributor_master D on(A.distributor_id=D.id) 

                left join distributor_master I on(A.sample_distributor_id=I.id) 

                left join distributor_type_master E on(D.type_id=E.id) 
                
                left join sales_rep_master F on(A.sales_rep_id=F.id)

                left join location_master G on(D.location_id=G.id) 

                left join area_master H on(D.area_id=H.id) 
				
                left join zone_master J on(D.zone_id=J.id) 
                
            where (A.status='Approved' ) and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date') AA 

            where AA.class='sample' and AA.class is not null";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;

}

function get_distributor_in_details($from_date, $to_date) {

    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek from 

            (select A.*, A.id as srid, C.depot_name, D.distributor_name, D.sell_out, D.type_id, D.location_id, 

                D.city as distributor_city, D.class, D.state as dist_state, D.state_code as dist_state_code, 

                D.gst_number as dist_gst_no, I.zone as dist_zone, 

                E.distributor_type, F.sales_rep_name, G.location, H.area 

            from distributor_in A 

                left join depot_master C on(A.depot_id=C.id) 

                left join distributor_master D on(A.distributor_id=D.id) 

                left join distributor_type_master E on(D.type_id=E.id) 

                left join location_master G on(D.location_id=G.id) 

                left join area_master H on(D.area_id=H.id) 

                left join zone_master I on(D.zone_id=I.id) 
				
				left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id ) 
				
				left join sales_rep_master F on(A.sales_rep_id=F.id AND J.reporting_manager_id=F.id) 

            where (A.status='Approved') and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date') AA 

            where AA.class!='sample' or AA.class is null";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;

}


function generate_sale_invoice_report($invoicelevel, $invoicelevelsalesreturn, $invoicelevelsample,$flag) {

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

    

    $row=9;

    $template_path=$this->config->item('template_path');

    $file = $template_path.'Sale_Invoice.xls';

    $this->load->library('excel');

    $objPHPExcel = PHPExcel_IOFactory::load($file);

    $tax_per=0;

    $cstamt=0;

    $round_off_amt=0;

    $include="";

    $fromdate=date("d-m-Y", strtotime($from_date));

    $todate=date("d-m-Y", strtotime($to_date));

    $objPHPExcel->getActiveSheet()->setCellValue('B5', $fromdate);

    $objPHPExcel->getActiveSheet()->setCellValue('E5', $todate);

    if($invoicelevel!="") {

        $include=$include.'Sales, ';

        $data = $this->get_distributor_out_details($from_date, $to_date);

        // echo $invoicelevel;
        // echo '<br>';
        // echo count($data);
        // echo '<br>';

        if(count($data)>0) {

            for($i=0; $i<count($data); $i++) {

                $dop=date("d-m-Y", strtotime($data[$i]->invoice_date));

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop);

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->dweek);

                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, "SALES");

                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->invoice_no);

                $status = $data[$i]->status;

                if($status=="InActive") {

                    $status='Cancelled';

                }

                if($status=='Cancelled') {

                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '0');

                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '0');

                    // $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '0');

                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '0');

                } else {

                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->amount);

                    $cstamt=$data[$i]->amount;

                    if($data[$i]->tax_amount==null || $data[$i]->tax_amount==''){
                        $tax_amt = 0;
                        $cgst_amt = 0;
                        $sgst_amt = 0;
                        $igst_amt = 0;
                    } else {
                        $tax_amt = $data[$i]->tax_amount;
                        if($data[$i]->igst_amount==null || $data[$i]->igst_amount=='' || $data[$i]->igst_amount==0){
                            $cgst_amt = round($tax_amt/2,2);
                            $sgst_amt = $tax_amt - $cgst_amt;
                            $igst_amt = 0;
                        } else {
                            $cgst_amt = 0;
                            $sgst_amt = 0;
                            $igst_amt = $tax_amt;
                        }
                    }
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $cgst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $sgst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $igst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $tax_amt);

                    $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $round_off_amt);

                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, round($data[$i]->final_amount));

                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->depot_name);

                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->distributor_name);

                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $data[$i]->distributor_type);

                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $data[$i]->dist_state_code);

                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$i]->dist_state);

                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->dist_gst_no);

                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->dist_zone);

                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->area);

                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->distributor_city);

                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->location);

                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->sales_rep_name);

                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->due_date);

                    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->order_no);

                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->order_date);

                }

                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->remarks);

                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->id);

                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $status);

                $row=$row+1;

            }

        }

    }

    if($invoicelevelsample!="") {

        $include=$include.'Sample & Product Expired, ';

        $data = $this->get_sample_expired_details($from_date, $to_date);

        // echo $invoicelevelsample;
        // echo '<br>';
        // echo count($data);
        // echo '<br>';
    
        for($i=0; $i<count($data); $i++) {

            $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop1);

            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->dweek);

            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, "Sample & Product Expired");

            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->voucher_no);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->amount);

                $cstamt=$data[$i]->amount;

                if($data[$i]->tax_amount==null || $data[$i]->tax_amount==''){
                    $tax_amt = 0;
                    $cgst_amt = 0;
                    $sgst_amt = 0;
                    $igst_amt = 0;
                } else {
                    $tax_amt = $data[$i]->tax_amount;
                    if($data[$i]->igst_amount==null || $data[$i]->igst_amount=='' || $data[$i]->igst_amount==0){
                        $cgst_amt = round($tax_amt/2,2);
                        $sgst_amt = $tax_amt - $cgst_amt;
                        $igst_amt = 0;
                    } else {
                        $cgst_amt = 0;
                        $sgst_amt = 0;
                        $igst_amt = $tax_amt;
                    }
                }
                
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $cgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $sgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $igst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $tax_amt);

                $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $round_off_amt);

                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, round($data[$i]->final_amount));

                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->depot_name);

                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->dname);

                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $data[$i]->distributor_type);

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $data[$i]->dist_state_code);

                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$i]->dist_state);

                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->dist_gst_no);

                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->dist_zone);

                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->area);

                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->distributor_city);

                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->location);

                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->sales_rep_name);

                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->due_date);

                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->sample_type);

                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->order_date);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->remarks);

            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->sampleid);

            // $status = $data[$i]->status;

            // if($status=="InActive") {

            //     $status='Cancelled';

            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $status);

            $row=$row+1;

        }

    }

    if($invoicelevelsalesreturn!="") {

        $include=$include.'Sales Return, ';

        $data = $this->get_distributor_in_details($from_date, $to_date);    

        // echo $invoicelevelsalesreturn;
        // echo '<br>';
        // echo count($data);
        // echo '<br>';
    
        for($i=0; $i<count($data); $i++) {

            $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop1);

            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->dweek);

            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, 'SALES RETURN');

            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->sales_return_no);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->amount);

                $cstamt=$data[$i]->amount;

                if($data[$i]->tax_amount==null || $data[$i]->tax_amount==''){
                    $tax_amt = 0;
                    $cgst_amt = 0;
                    $sgst_amt = 0;
                    $igst_amt = 0;
                } else {
                    $tax_amt = $data[$i]->tax_amount;
                    if($data[$i]->igst_amount==null || $data[$i]->igst_amount=='' || $data[$i]->igst_amount==0){
                        $cgst_amt = round($tax_amt/2,2);
                        $sgst_amt = $tax_amt - $cgst_amt;
                        $igst_amt = 0;
                    } else {
                        $cgst_amt = 0;
                        $sgst_amt = 0;
                        $igst_amt = $tax_amt;
                    }
                }
                
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $cgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $sgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $igst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $tax_amt);

                $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $round_off_amt);

                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, round($data[$i]->final_amount));

                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->depot_name);

                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->distributor_name);

                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $data[$i]->distributor_type);

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $data[$i]->dist_state_code);

                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$i]->dist_state);

                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->dist_gst_no);

                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->dist_zone);

                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->area);

                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->distributor_city);

                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->location);

                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->sales_rep_name);

                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '');

                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, '');

                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, '');
            }



            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->remarks);

            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->srid);

            // $status = $data[$i]->status;

            // if($status=="InActive") {

            //     $status='Cancelled';

            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $status);

            $row=$row+1;
        }

    }

    $row=$row-1;

    // $include=substr($include, 0, strlen($include)-2);

    // $objPHPExcel->getActiveSheet()->setCellValue('B5', $include);



    $objPHPExcel->getActiveSheet()->getStyle('A8:AE8')->getFont()->setBold(true);

    

    $objPHPExcel->getActiveSheet()->getStyle('A8'.':AE'.$row)->applyFromArray(array(

        'borders' => array(

            'allborders' => array(

                'style' => PHPExcel_Style_Border::BORDER_THIN

            )

        )

    ));


    for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
    }


    $filename='Sale_Invoice_Report.xls';

    $path  = '/home/eatangcp/public_html/test/assets/uploads/excel_upload/';

    if($flag==0)
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    else
    {
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save($path.$filename);
    }

    $logarray['table_id']=$this->session->userdata('session_id');

    $logarray['module_name']='Reports';

    $logarray['cnt_name']='Reports';

    $logarray['action']='Sale Invoice report generated.';

    $this->user_access_log_model->insertAccessLog($logarray);

    // } else {

    //     echo '<script>alert("No data found");</script>';

    // }

}



function get_distributor_out_sku_details($from_date, $to_date, $status='', $date_of_processing='', $date_of_accounting='') {

    // $sql = "select L.*, J.item_name, J.quantity, J.short_name from

    //         (select I.*, K.location from  

    //         (select M.*, H.sales_rep_name from 

    //         (select G.*, L.distributor_type from 

    //         (select E.*, F.distributor_name, F.sell_out, F.type_id, F.location_id, F.city as distributor_city from 

    //         (select C.*, D.depot_name from 

    //         (select A.*, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount from 

    //         (select *, MONTHNAME(STR_TO_DATE(month(date_of_processing),'%m')) as dmonth from distributor_out 

    //             where status='Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 

    //         left join 

    //         (select * from distributor_out_items) B 

    //         on (A.id=B.distributor_out_id)) C 

    //         left join 

    //         (select * from depot_master) D 

    //         on (C.depot_id=D.id)) E 

    //         left join 

    //         (select * from distributor_master) F 

    //         on (E.distributor_id=F.id)) G 

    //         left join

    //         (select * from distributor_type_master) L 

    //         on (G.type_id=L.id)) M 

    //         left join 

    //         (select * from sales_rep_master) H 

    //         on (M.sales_rep_id=H.id)) I 

    //         left join 

    //         (select * from location_master) K 

    //         on (I.location_id=K.id)) L 

    //         left join 

    //         (select id, 'Raw Material' as type, rm_name as item_name, null as quantity, null as short_name from raw_material_master 

    //             where status='Approved' 

    //         union all 

    //         select id, 'Bar' as type, product_name as item_name, null as quantity, short_name from product_master 

    //             where status='Approved' 

    //         union all 

    //         select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name from box_master m 

    //         left join box_product p on m.id=p.box_id where m.status='Approved' group by m.id) J 

    //         on (L.item_id=J.id and L.type=J.type)";



    // $sql = "select AA.*, WEEK(date_of_processing,2)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),2)+1 as dweek, 

    //             BB.item_name, BB.quantity, BB.short_name from 

    //         (select A.*,A.id as saleid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

    //             C.depot_name, D.distributor_name, D.sell_out, D.type_id, D.location_id, D.city as distributor_city, 

    //             E.distributor_type, F.sales_rep_name, G.location, H.area 

    //         from distributor_out A 

    //             left join distributor_out_items B on(A.id=B.distributor_out_id) 

    //             left join depot_master C on(A.depot_id=C.id) 

    //             left join distributor_master D on(A.distributor_id=D.id) 

    //             left join distributor_type_master E on(D.type_id=E.id) 

    //             left join sales_rep_master F on(A.sales_rep_id=F.id) 

    //             left join location_master G on(D.location_id=G.id) 

    //             left join area_master H on(D.area_id=H.id) 

    //         where A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' and A.status='Approved') AA 

    //         left join 

    //         (select id, 'Bar' as type, product_name as item_name, null as quantity, short_name from product_master 

    //             where status='Approved' 

    //         union all 

    //         select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name 

    //         from box_master m left join box_product p on m.id=p.box_id 

    //         where m.status='Approved' group by m.id) BB 

    //         on (AA.item_id=BB.id and AA.type=BB.type) 

    //         where AA.distributor_name not like '%sample%' and AA.distributor_name not like '%Product Expired%' order by date_of_processing";


    if ($status=="Approved"){
        $cond=" where status='Approved' and (distributor_id!='1' and distributor_id!='189')";
    } else if ($status=="pending"){
        $cond=" where ((status='Pending' and (delivery_status is null or delivery_status = '')) or status='Rejected') and 
                        (distributor_id!='1' and distributor_id!='189')";
    } else if ($status=="pending_for_approval"){
        $cond=" where ((status='Pending' and (delivery_status='Pending' or delivery_status='GP Issued' or 
                            delivery_status='Delivered Not Complete' or delivery_status='Delivered')) or status='Deleted') and 
                            (distributor_id!='1' and distributor_id!='189')";
    } else if ($status=="pending_for_delivery"){
        $cond=" where status='Approved' and delivery_status='Pending' and (distributor_id!='1' and distributor_id!='189')";
    } else if ($status=="gp_issued"){
        $cond=" where status='Approved' and delivery_status='GP Issued' and (distributor_id!='1' and distributor_id!='189')";
    } else if ($status=="delivered_not_complete"){
        $cond=" where status='Approved' and delivery_status='Delivered Not Complete' and 
                        (distributor_id!='1' and distributor_id!='189')";
    } else if ($status!="") {
        $cond=" where status='".$status."' and (distributor_id!='1' and distributor_id!='189')";
    } else {
        $cond="";
    }

    $ddateofprocess="";

    if( $date_of_processing != '' && $date_of_accounting=='') {
        $ddateofprocess = "A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' ";
    }
    else {
        $ddateofprocess = "A.invoice_date>='$from_date' and A.invoice_date<='$to_date' ";
    }
    


    $sql = "select * from 

            (select AA.*, WEEK(invoice_date,1)-WEEK(STR_TO_DATE(concat(YEAR(invoice_date),'-',MONTH(invoice_date),'-',1),'%Y-%m-%d'),1)+1 as dweek, 

                BB.item_name, BB.quantity, BB.short_name from 

            (select A.*,A.id as saleid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

                B.cgst_amt, B.sgst_amt, B.igst_amt, B.tax_amt, B.total_amt, 

                C.depot_name, D.distributor_name, D.sell_out, D.type_id, D.location_id,D.area_id,D.zone_id,

                D.city as distributor_city, D.class, D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, 

                E.distributor_type, F.sales_rep_name, G.location, H.area ,K.zone,

                (Select sales_rep_name from sales_rep_master where id=J.sales_rep_id1) as salesrepname,

                (Select sales_rep_name from sales_rep_master where id=J.sales_rep_id2) as salesrepname1

            from distributor_out A 

                left join distributor_out_items B on(A.id=B.distributor_out_id) 

                left join depot_master C on(A.depot_id=C.id) 

                left join distributor_master D on(A.distributor_id=D.id) 

                left join distributor_type_master E on(D.type_id=E.id) 

                left join location_master G on(D.location_id=G.id) 

                left join zone_master K on(D.zone_id=K.id) 

                left join area_master H on(D.area_id=H.id)
				
				left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id ) 
				
				left join sales_rep_master F on(J.reporting_manager_id=F.id) 

            where ".$ddateofprocess." and (A.status='Approved')) AA 

            left join 

            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name from product_master 

                where status='Approved' 

            union all 

            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name 

            from box_master m left join box_product p on m.id=p.box_id 

            where m.status='Approved' group by m.id) BB 

            on (AA.item_id=BB.id and AA.type=BB.type) 

            where AA.class!='sample' or AA.class is null) CC 
            
            ".$cond."
            
            order by invoice_date,invoice_no";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;

}



function get_distributor_sale_sku_details($from_date, $to_date) {

    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',

                                MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek, 

                BB.item_name, BB.quantity, BB.short_name from 

            (select A.*,A.id as ssid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

                D.distributor_name, D.sell_out, D.type_id, D.location_id as locationid, D.area_id,D.zone_id as zoneid,

                D.city as distributor_city, D.class, D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, 

                E.distributor_type, G.location, O.store_name as m_distributor_name, 

                l.location as m_distributor_location,

                 
                F.sales_rep_name,K.zone,I.area,
                (Select sales_rep_name from sales_rep_master where id=J.sales_rep_id1) as salesrepname,
                (Select sales_rep_name from sales_rep_master where id=J.sales_rep_id2) as salesrepname1,
                M.store_id as storeid,O.store_name, Q.distributor_type as d_type,P.zone as d_zone,S.sales_rep_name as reporting_manager,
                (Select sales_rep_name from sales_rep_master where id=R.sales_rep_id1) as sales1,
                (Select sales_rep_name from sales_rep_master where id=R.sales_rep_id2) as sales2

                from distributor_sale A 

                left join distributor_sale_items B on(A.id=B.distributor_sale_id) 

                left join distributor_master D on(A.distributor_id=D.id) 

                left join distributor_type_master E on(D.type_id=E.id) 
                
                
                left join location_master G on(D.location_id=G.id) 

                left join area_master I on(D.area_id=I.id) 
                left join zone_master K on(D.zone_id=K.id) 
                    
                left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id)
                left join sales_rep_master F on( J.reporting_manager_id=F.id)
                        
                left join store_master M on(A.to_distributor_id = M.id) 
                left join relationship_master O on(M.store_id=O.id) 
                left join zone_master P on(M.zone_id=P.id) 
                left join distributor_type_master Q on(M.type_id=Q.id) 
                left join location_master l on(M.location_id=l.id)              
                left join sr_mapping R on(M.store_id=R.area_id1 and M.type_id=R.type_id and M.zone_id=R.zone_id and M.location_id=R.location_id)
                left join sales_rep_master S on( R.reporting_manager_id=S.id)
            where (A.status='Approved' )  and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date') AA 

            left join 

            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name from product_master 

                where status='Approved' 

            union all 

            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name 

            from box_master m left join box_product p on m.id=p.box_id 

            where m.status='Approved' group by m.id) BB 

            on (AA.item_id=BB.id and AA.type=BB.type) ";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;

}



function generate_sale_invoice_sku_report($sales,$ssallocation,$salesreturn,$sample,$credit_debit='',$status_type='',$date_of_processing='',$date_of_accounting='',$flag='') {
    if($status_type==''){

        if($this->input->post('from_date')!="")
            $from_date = formatdate($this->input->post('from_date'));
        else
            $from_date = '';


        if($this->input->post('to_date')!="")
          $to_date = formatdate($this->input->post('to_date'));
        else
          $to_date = '';
    } else {
        $from_date = '2017-01-01';
        $to_date = date("Y-m-d");
    }

    $row=11;
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Sale_Invoice_Sku.xls';
    $this->load->library('excel');
    $objPHPExcel = PHPExcel_IOFactory::load($file);

    $tax_per=0;
    $cstamt=0;
    $round_off_amt=0;
    $include="";
	$rounding_amt=0;
  

    $objPHPExcel->getActiveSheet()->setCellValue('B4', $from_date);
    $objPHPExcel->getActiveSheet()->setCellValue('E4', $to_date);

    ini_set('memory_limit', '2000M');
    ini_set('max_execution_time', 0);

    if($sales!="") {
        $include=$include.'Sales, ';

        $data = $this->get_distributor_out_sku_details($from_date, $to_date, $status_type, $date_of_processing, $date_of_accounting);

        if(count($data)>0) {
            for($i=0; $i<count($data); $i++) {
                $dop=date("d-m-Y", strtotime($data[$i]->date_of_processing));
                $mod_on=date("d-m-Y", strtotime($data[$i]->invoice_date));
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $mod_on);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "SALES");
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->invoice_no);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->qty);
                $quantity=$data[$i]->quantity;

                $barquantity=0;
                if($data[$i]->quantity==null) {
                    $barquantity=1*$data[$i]->qty;
                } else {
                    $barquantity=$data[$i]->quantity*$data[$i]->qty;
                }

                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $barquantity);
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$i]->rate);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->sell_rate);

                $status = $data[$i]->status;
                if($status=="InActive") {
                    $status='Cancelled';
                }
                if($status=='Cancelled') {
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->item_amount);

                    // $tax=($data[$i]->tax_per/100)*($data[$i]->item_amount);
                    // $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $tax);
                    // $cstamt=$tax+$data[$i]->item_amount;
                    // $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $cstamt);

                    $cstamt=$data[$i]->total_amt;

                    if($data[$i]->tax_amt==null || $data[$i]->tax_amt==''){
                        $tax_amt = 0;
                        $cgst_amt = 0;
                        $sgst_amt = 0;
                        $igst_amt = 0;
                    } else {
                        $tax_amt = $data[$i]->tax_amt;
                        if($data[$i]->igst_amt==null || $data[$i]->igst_amt=='' || $data[$i]->igst_amt==0){
                            $cgst_amt = round($tax_amt/2,2);
                            $sgst_amt = $tax_amt - $cgst_amt;
                            $igst_amt = 0;
                        } else {
                            $cgst_amt = 0;
                            $sgst_amt = 0;
                            $igst_amt = $tax_amt;
                        }
                    }
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $cgst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $sgst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $igst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $tax_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->total_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->depot_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_type);

                    if($data[$i]->shipping_address == 'no'){
                        $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->con_state_code);
                        $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->con_state);
                        $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->con_gst_number);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->dist_state_code);
                        $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state);
                        $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_gst_no);
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->zone);
                    $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->area);
					$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->distributor_city);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->location);
                    $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->sales_rep_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->salesrepname);
                    $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname1);
                    $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->due_date);
                    $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$i]->order_no);
                    $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->order_date);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->remarks);
                $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->saleid);

                // $status = $data[$i]->status;
                // if($status=="InActive") {
                //     $status='Cancelled';
                // }

                $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $status);

                $row=$row+1;
                $bl_insert = false;

                if($i<count($data)-1){
                    if($data[$i]->invoice_no!=$data[$i+1]->invoice_no){
                        $bl_insert = true;
                    }
                } else {
                    $bl_insert = true;
                }

                if($bl_insert == true){
                    // $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
                    // $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
                    // $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
					// $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $mod_on);
                    // $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop);
                    // $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
                    // $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'SALES');
                    // $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->invoice_no);
                    // $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, 'Round Off Amount');
                    // $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, 'Round Off Amount');
                    // $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                    $objPHPExcel->getActiveSheet()->setCellValue('U'.($row-1), $data[$i]->round_off_amount);
				    $rounding_amt=$data[$i]->round_off_amount;
					$cstamt=$rounding_amt+$cstamt;
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.($row-1), $cstamt);

                    // $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->depot_name);
                    // $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->distributor_name);
                    // $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->distributor_type);
                    // $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->zone);
                    // $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->area);
                    // $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_city);
                    // $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->location);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->sales_rep_name);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->salesrepname);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->salesrepname1);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->due_date);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->order_no);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->order_date);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->remarks);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->saleid);
                    // $status = $data[$i]->status;
                    // if($status=="InActive") {
                    // $status='Cancelled';
                    // }
                    // $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $status);
                    // $row=$row+1;
                }

            }

        }

    }



    if($ssallocation!="") {
        $include=$include.'SS Allocation, ';
        $data = $this->get_distributor_sale_sku_details($from_date, $to_date);

        $j = 0;
        $prv_dist_id = '';
        $new_dist_id = '';
        $countt=0;

        for($i=0; $i<count($data); $i++) {
            $new_dist_id = $data[$i]->distributor_id;
            if($prv_dist_id != $new_dist_id){
                $j = $i;
                $prv_dist_id = $new_dist_id;
            }

            $dop3=date("d-m-Y", strtotime($data[$i]->date_of_processing));
            $mod_on1=date("d-m-Y", strtotime($data[$i]->modified_on));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $mod_on1);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop3);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '-'.$data[$i]->qty);

            $quantity=$data[$i]->quantity;
            $barquantity=0;
            if($data[$i]->quantity==null) {
                $barquantity=1*$data[$i]->qty;
            } else {
                $barquantity=$data[$i]->quantity*$data[$i]->qty;    
            }

            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '-'.$barquantity);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->sell_rate);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '-'.$data[$i]->item_amount);

                // $tax=($data[$i]->tax_per/100)*($data[$i]->item_amount);
                // $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $tax);
                // $cstamt=$tax+$data[$i]->item_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '-'.$data[$i]->item_amount);
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->distributor_name);
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_type);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state);
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_gst_no);
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->area);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->salesrepname);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname1);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$i]->ssid);
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->ssid);

            $status = $data[$i]->status;

            // if($status=="InActive") {

            //     $status='Cancelled';

            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $status);
            $row=$row+1;

            $bl_insert = false;
            if($i<count($data)-1){
                if($data[$i]->id!=$data[$i+1]->id){
                    $bl_insert = true;
                    $countt++;
                }
            } else {
                $bl_insert = true;
                $countt++;
            }

            // if($bl_insert == true){

            //     for($k=$j; $k<=$i; $k++){

            //         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

            //         $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

            //         $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

            //         $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $data[$k]->date_of_processing);

            //         $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$k]->dweek);

            //         $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, 'SSALLOCATION');

            //         $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$k]->item_name);

            //         $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$k]->short_name);

            //         $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$k]->type);

            //         $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$k]->qty);

            //         $quantity=$data[$k]->quantity;

            //         $barquantity=0;

            //         if($data[$k]->quantity==null) {

            //             $barquantity=1*$data[$k]->qty;

            //         } else {

            //             $barquantity=$data[$k]->quantity*$data[$k]->qty;    

            //         }

            //         $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $barquantity);

            //         $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$k]->rate);

            //         $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $data[$k]->sell_rate);

            //         $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$k]->sell_out);

            //         $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$k]->item_amount);

            //         // $tax=($data[$k]->tax_per/100)*($data[$k]->item_amount);

            //         // $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $tax);

            //         // $cstamt=$tax+$data[$k]->item_amount;

            //         $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, 0);

            //         $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '');

            //         $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$k]->m_distributor_name);

            //         $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '');

            //         $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$k]->m_distributor_type);

            //         $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$k]->m_distributor_location);

            //         $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '');

            //         $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '');

            //         $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '');

            //         $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '');



            //         $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$k]->remarks);

            //         $row=$row+1;

            //     }

            // }

        }



        // if($bl_insert == true){

        for($k=0; $k<count($data); $k++){
            $dop1=date("d-m-Y", strtotime($data[$k]->date_of_processing));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$k]->dweek);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$k]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$k]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$k]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$k]->qty);

            $quantity=$data[$k]->quantity;
            $barquantity=0;
            if($data[$k]->quantity==null) {
                $barquantity=1*$data[$k]->qty;
            } else {
                $barquantity=$data[$k]->quantity*$data[$k]->qty;
            }

            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $barquantity);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$k]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$k]->sell_rate);

            
            $status = $data[$k]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$k]->item_amount);

                // $tax=($data[$k]->tax_per/100)*($data[$k]->item_amount);
                // $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $tax);
                // $cstamt=$tax+$data[$k]->item_amount;

				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '');
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '');
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$k]->item_amount);
				$objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$k]->store_name);
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$k]->d_type);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$k]->d_zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$k]->store_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$k]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$k]->m_distributor_location);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$k]->reporting_manager);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$k]->sales1);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$k]->sales2);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$k]->ssid);
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$k]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$k]->ssid);

            $status = $data[$k]->status;
            // if($status=="InActive") {
            //     $status='Cancelled';
            // }
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $status);

            $row=$row+1;
        }
        // }
    }



    if($sample!="") {
        $include=$include.'Sample & Product Expired, ';
        $data = $this->get_sample_expired_SKU_details($from_date, $to_date);

        for($i=0; $i<count($data); $i++) {
            $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));
            $mod_on2=date("d-m-Y", strtotime($data[$i]->modified_on));
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, strtoupper($data[$i]->distributor_name));
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->voucher_no);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->qty);
            $quantity=$data[$i]->quantity;

            $barquantity=0;
            if($data[$i]->quantity==null) {
                $barquantity=1*$data[$i]->qty;
            } else {
                $barquantity=$data[$i]->quantity*$data[$i]->qty;
            }

            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $barquantity);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->sell_rate);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->item_amount);
                // $tax=($data[$i]->tax_per/100)*($data[$i]->item_amount);
                // $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $tax);
                // $cstamt=$tax+$data[$i]->item_amount;
                $cstamt = $data[$i]->item_amount;

                if($data[$i]->tax_amt==null || $data[$i]->tax_amt==''){
                    $tax_amt = 0;
                    $cgst_amt = 0;
                    $sgst_amt = 0;
                    $igst_amt = 0;
                } else {
                    $tax_amt = $data[$i]->tax_amt;
                    if($data[$i]->igst_amt==null || $data[$i]->igst_amt=='' || $data[$i]->igst_amt==0){
                        $cgst_amt = round($tax_amt/2,2);
                        $sgst_amt = $tax_amt - $cgst_amt;
                        $igst_amt = 0;
                    } else {
                        $cgst_amt = 0;
                        $sgst_amt = 0;
                        $igst_amt = $tax_amt;
                    }
                }

                $total_amt = $cstamt + $tax_amt;
                
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $cgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $sgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $igst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $tax_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $total_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->depot_name);
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->dname);
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_type);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state);
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_gst_no);
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->area);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->salesrepname);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname1);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->due_date);
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$i]->sample_type);
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->order_date);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->sampleid);

            $status = $data[$i]->status;
            // if($status=="InActive") {
            //     $status='Cancelled';
            // }
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $status);

            $row=$row+1;
        }
    }



    if($salesreturn!="") {
        $include=$include.'Sales Return, ';

        $data = $this->get_distributor_in_sku_details($from_date, $to_date);
        for($i=0; $i<count($data); $i++) {
            $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));
            $mod_on3=date("d-m-Y", strtotime($data[$i]->modified_on));
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $mod_on3);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'SALES RETURN');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->sales_return_no);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '-'.$data[$i]->qty);

            $quantity=$data[$i]->quantity;
            $barquantity=0;
            if($data[$i]->quantity==null) {
                $barquantity=1*$data[$i]->qty;
            } else {
                $barquantity=$data[$i]->quantity*$data[$i]->qty;
            }

            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '-'.$barquantity);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->sell_rate);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '-'.$data[$i]->item_amount);
                // $tax=($data[$i]->cst/100)*($data[$i]->item_amount);
                // $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '-'.$tax);
                // $cstamt=$tax+$data[$i]->item_amount;
                $cstamt=$data[$i]->item_amount;

                if($data[$i]->tax_amt==null || $data[$i]->tax_amt==''){
                    $tax_amt = 0;
                    $cgst_amt = 0;
                    $sgst_amt = 0;
                    $igst_amt = 0;
                } else {
                    $tax_amt = $data[$i]->tax_amt;
                    if($data[$i]->igst_amt==null || $data[$i]->igst_amt=='' || $data[$i]->igst_amt==0){
                        $cgst_amt = round($tax_amt/2,2);
                        $sgst_amt = $tax_amt - $cgst_amt;
                        $igst_amt = 0;
                    } else {
                        $cgst_amt = 0;
                        $sgst_amt = 0;
                        $igst_amt = $tax_amt;
                    }
                }

                $total_amt = $cstamt + $tax_amt;
                $round_off_amount = round($total_amt,0) - $total_amt;
                $total_amt=$round_off_amt+$total_amt;
                
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '-'.$cgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '-'.$sgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '-'.$igst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '-'.$tax_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '-'.$round_off_amount);
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '-'.$total_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->depot_name);
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->distributor_name);
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_type);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state);
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_gst_no);
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->area);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->salesrepname);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname1);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->srid);

            // $status = $data[$i]->status;
            // if($status=="InActive") {
            //     $status='Cancelled';
            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $status);
            $row=$row+1;

            $bl_insert = false;

            if($i<count($data)-1){
                if($data[$i]->srid!=$data[$i+1]->srid){
                    $bl_insert = true;
                }
            } else {
                $bl_insert = true;
            }

            if($bl_insert == true){

                // $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));

                // $mod_on4=date("d-m-Y", strtotime($data[$i]->modified_on));

                // $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

                // $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

                // $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
				// $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $mod_on4);
                // $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop1);

           
                // $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);

                // $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'SALES RETURN');

                // $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->sales_return_no);

                // $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, 'Round Off Amount');

                // $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, 'Round Off Amount');

				$round_off_amt=round($data[$i]->final_amount,0)-$data[$i]->final_amount;
                $objPHPExcel->getActiveSheet()->setCellValue('U'.($row-1), $round_off_amt);
				$cstamt=$round_off_amt+$cstamt;
                $objPHPExcel->getActiveSheet()->setCellValue('V'.($row-1), $cstamt);



                // $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->depot_name);

          

                // $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->distributor_name);

                 // $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->distributor_type);
                // $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->zone);
                // $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->area);
                // $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_city);
               

                // $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->location);

                // $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->sales_rep_name);
                // $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->salesrepname);
                // $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->salesrepname1);

                // $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, '');

                // $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, '');

                // $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, '');

                // $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->remarks);

                // $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->srid);

                // $status = $data[$i]->status;

                // if($status=="InActive") {

                    // $status='Cancelled';

                // }

                // $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $status);

                // $row=$row+1;

            }

        }

    }


	
	if($credit_debit!="") {
        $include=$include.'Credit Debit, ';
        $data = $this->get_credit_debit_sku_details($from_date, $to_date,$date_of_processing, $date_of_accounting);

        if(count($data)>0) {
            for($i=0; $i<count($data); $i++) {
                $dop=date("d-m-Y", strtotime($data[$i]->date_of_transaction));
                $dop1=date("d-m-Y", strtotime($data[$i]->modified_on));
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop1);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, strtoupper($data[$i]->transaction));
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->ref_no);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '');

               // $quantity=$data[$i]->quantity;

                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,'');

                $status = $data[$i]->status;
                if($status=="InActive") {
                    $status='Cancelled';
                }
                if($status=='Cancelled') {
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                } else {
					$cgst=$data[$i]->cgst;
					$sgst=$data[$i]->sgst;
					$igst=$data[$i]->igst;
					$totaltax=$cgst+$sgst+$igst;
                    $amount_without_tax=$data[$i]->amount_without_tax;
                    $amount=$data[$i]->amount;
                    $round_off_amount=$amount-$amount_without_tax-$totaltax;

                    if($amount_without_tax==null || $amount_without_tax=='' || $amount_without_tax=='0'){
                        $round_off_amount=round($amount,0)-$amount;
                        $amount=round($amount,0);
                    }

				    if ($data[$i]->transaction=='Credit Note') {
                        $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '-'.$amount_without_tax);
                        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '-'.$cgst);
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '-'.$sgst);
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '-'.$igst);
                        $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '-'.$totaltax);
                        if($round_off_amount<0){
                            $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $round_off_amount);
                        } else {
                            $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '-'.$round_off_amount);
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '-'.$amount);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $amount_without_tax);
                        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $cgst);
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $sgst);
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $igst);
						$objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $totaltax);
                        $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $round_off_amount);
                        $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $amount);
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_type);
                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->dist_state_code);
                    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state);
                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_gst_no);
                    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->zone);
                    $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->area);
					$objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->distributor_city);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->location);
                    $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->sales_rep_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->salesrepname);
                    $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname1);
                    $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '');
                }

                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->remarks);
                $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, '');

                // $status = $data[$i]->status;
                // if($status=="InActive") {
                //     $status='Cancelled';
                // }

                $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $status);

                $row=$row+1;

                $bl_insert = false;

                // if($i<count($data)-1){

                    // if($data[$i]->ref_no!=$data[$i+1]->ref_no){

                        // $bl_insert = true;

                    // }

                // } else {

                    // $bl_insert = true;

                // }



                // if($bl_insert == true){

                    // $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop);

                    // $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->modified_on);
                    // $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->transaction);

                    // $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->ref_no);

                    // $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '');

                  // $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                    // $objPHPExcel->getActiveSheet()->setCellValue('S'.$row,$data[$i]->amount );

                // $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->distributor_name);

                    // $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->distributor_type);

                    // $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->zone);
                    // $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->area);

					
					// $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_city);
					
                    // $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->location);

                    // $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->sales_rep_name);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->salesrepname);
                    // $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->salesrepname1);

                    // $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, '');

                    // $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->remarks);

                    // $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, '');

                    // $status = $data[$i]->status;

                    // if($status=="InActive") {

                        // $status='Cancelled';

                    // }

                    // $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $status);

                    // $row=$row+1;

                // }

            }

        }

    }
    if($date_of_processing=="")
	 {
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setVisible(false);
       
	 }
	 else if($date_of_accounting=="")
	 {
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false);
       
	 }
     else {
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setVisible(true);
     }
	
	
	

    $row=$row-1;

    $include=substr($include, 0, strlen($include)-2);

    $objPHPExcel->getActiveSheet()->setCellValue('B5', $include);



    $objPHPExcel->getActiveSheet()->getStyle('A10:AO10')->getFont()->setBold(true);


    for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
        if($col!=1){
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
    }


    $objPHPExcel->getActiveSheet()->getStyle('A10'.':AO'.$row)->applyFromArray(array(

        'borders' => array(

            'allborders' => array(

                'style' => PHPExcel_Style_Border::BORDER_THIN

            )

        )

    ));


    $filename='Sale_Invoice_Sku_Report.xls';
    $path  = '/home/eatangcp/public_html/test/assets/uploads/excel_upload/';
    if($flag==0)
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->setPreCalculateFormulas(TRUE); 

        $objWriter->save('php://output');
    }
    else
    {
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->setPreCalculateFormulas(TRUE); 

        $objWriter->save($path.$filename);
    }

    



    $logarray['table_id']=$this->session->userdata('session_id');

    $logarray['module_name']='Reports';

    $logarray['cnt_name']='Reports';

    $logarray['action']='Sale Invoice SKU report generated.';

    $this->user_access_log_model->insertAccessLog($logarray);

    // } else {

    //     echo '<script>alert("No data found");</script>';

    // }

}

function get_credit_debit_sku_details($from_date, $to_date, $date_of_processing, $date_of_accounting) {

    $ddateofprocess = '';

    if($from_date!='' && $to_date!='')
    {
       if( $date_of_processing != '' && $date_of_accounting=='') {
            $ddateofprocess = " and A.date_of_transaction>='$from_date' and A.date_of_transaction<='$to_date' ";
        }
        else {
            $ddateofprocess = " and A.approved_on>='$from_date' and A.approved_on<='$to_date' ";
        } 
    }
    

    $sql = "
	select AA.*, WEEK(date_of_transaction,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_transaction),'-',MONTH(date_of_transaction),'-',1),'%Y-%m-%d'),1)+1 as dweek from 
            (select A.id, A.date_of_transaction, A.distributor_id, A.transaction, A.amount_without_tax, A.amount, A.tax, 
                A.igst, A.cgst, A.sgst, A.status, A.remarks, A.created_by, A.created_on, A.modified_by, A.modified_on, 
                A.approved_by, A.approved_on, A.rejected_by, A.rejected_on, A.ref_id, A.ref_no, A.ref_date,
                D.distributor_name, D.sell_out, D.type_id, D.location_id, D.city as distributor_city, 
                D.class, D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, 
                D.area_id,D.zone_id,K.zone,E.distributor_type, F.sales_rep_name, G.location, H.area ,
                (Select sales_rep_name from sales_rep_master where id=J.sales_rep_id1) as salesrepname,
                (Select sales_rep_name from sales_rep_master where id=J.sales_rep_id2) as salesrepname1

            from credit_debit_note A 

                left join distributor_master D on(A.distributor_id=D.id) 

                left join distributor_type_master E on(D.type_id=E.id) 


                left join location_master G on(D.location_id=G.id) 

                left join area_master H on(D.area_id=H.id) 
                left join zone_master K on(D.zone_id=K.id) 
				
				left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id ) 
				
				left join sales_rep_master F on(J.reporting_manager_id=F.id) 

            where (A.status='Approved' ) ".$ddateofprocess.") AA ";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;

}




function get_sample_expired_SKU_details($from_date, $to_date) {

    // $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek, 

    //             BB.item_name, BB.quantity, BB.short_name from 

    //         (select A.*, A.id as sampleid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

    //             C.depot_name, D.distributor_name, D.sell_out, D.type_id, D.location_id, D.city as distributor_city, D.class, 

    //             D.area_id,D.zone_id,K.zone,E.distributor_type, F.sales_rep_name, G.location, I.distributor_name as dname, H.area ,

    //             L.sales_rep_name as salesrepname,

    //             M.sales_rep_name as salesrepname1

    //         from distributor_out A 

    //             left join distributor_out_items B on(A.id=B.distributor_out_id) 

    //             left join depot_master C on(A.depot_id=C.id) 

    //             left join distributor_master D on(A.distributor_id=D.id) 

    //             left join distributor_master I on(A.sample_distributor_id=I.id) 

    //             left join distributor_type_master E on(D.type_id=E.id) 

             

    //             left join location_master G on(D.location_id=G.id) 

    //             left join area_master H on(D.area_id=H.id) 

    //             left join zone_master K on(D.zone_id=K.id) 
				
				// left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id ) 
				
				// left join sales_rep_master F on(J.reporting_manager_id=F.id) 

    //             left join sales_rep_master L on(J.sales_rep_id1=L.id) 

    //             left join sales_rep_master M on(J.sales_rep_id2=M.id) 

    //         where (A.status='Approved' or A.status='InActive') and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date') AA 

    //         left join 

    //         (select id, 'Bar' as type, product_name as item_name, null as quantity, short_name from product_master 

    //             where status='Approved' 

    //         union all 

    //         select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name 

    //         from box_master m left join box_product p on m.id=p.box_id 

    //         where m.status='Approved' group by m.id) BB 

    //         on (AA.item_id=BB.id and AA.type=BB.type) 

    //         where AA.class='sample' and AA.class is not null";

    // $query=$this->db->query($sql);

    // $result=$query->result();

    // return $result;

    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek, 

                BB.item_name, BB.quantity, BB.short_name from 

            (select A.*, A.id as sampleid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

                B.cgst_amt, B.sgst_amt, B.igst_amt, B.tax_amt, B.total_amt, 

                C.depot_name, D.distributor_name, D.sell_out, D.type_id, D.location_id, D.city as distributor_city, D.class, 

                D.area_id,D.zone_id, D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no,

                K.zone,E.distributor_type, F.sales_rep_name, G.location, I.distributor_name as dname, H.area ,

                L.sales_rep_name as salesrepname,

                M.sales_rep_name as salesrepname1

            from distributor_out A 

                left join distributor_out_items B on(A.id=B.distributor_out_id) 

                left join depot_master C on(A.depot_id=C.id) 

                left join distributor_master D on(A.distributor_id=D.id) 

                left join distributor_master I on(A.sample_distributor_id=I.id) 

                left join distributor_type_master E on(D.type_id=E.id) 

             

                left join location_master G on(D.location_id=G.id) 

                left join area_master H on(D.area_id=H.id) 

                left join zone_master K on(D.zone_id=K.id) 
                
                left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id ) 
                
                left join sales_rep_master F on(J.reporting_manager_id=F.id) 

                left join sales_rep_master L on(J.sales_rep_id1=L.id) 

                left join sales_rep_master M on(J.sales_rep_id2=M.id) 

            where (A.status='Approved') and A.date_of_processing>='$from_date' and 
                    A.date_of_processing<='$to_date' and D.class='sample' and D.class is not null) AA 

            left join 

            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name from product_master 

                where status='Approved' 

            union all 

            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name 

            from box_master m left join box_product p on m.id=p.box_id 

            where m.status='Approved' group by m.id) BB 

            on (AA.item_id=BB.id and AA.type=BB.type) 

            where AA.class='sample' and AA.class is not null";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;

}



function generate_sample_expired_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $data = $this->get_sample_expired_SKU_details($from_date, $to_date);



    if(count($data)>0) {

        $template_path=$this->config->item('template_path');

        $file = $template_path.'Sample_Expired.xls';

        $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $tax_per=0;

        $cstamt=0;

        $round_off_amt=0;

        $row=2;

        for($i=0; $i<count($data); $i++) {

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $data[$i]->date_of_processing);

            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->dweek);

            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->voucher_no);

            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->distributor_name);

            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->sample_type);

            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);

            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);

            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);

            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->qty);

            $quantity=$data[$i]->quantity;

            $barquantity=0;

            if($data[$i]->quantity==null) {

                $barquantity=1*$data[$i]->qty;

            } else {

                $barquantity=$data[$i]->quantity*$data[$i]->qty;    

            }

            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $barquantity);

            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$i]->rate);

            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->sell_rate);

            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->sell_out);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $data[$i]->item_amount);

                $tax=($data[$i]->tax_per/100)*($data[$i]->item_amount);

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $tax);

                $cstamt=$tax+$data[$i]->item_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $cstamt);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->depot_name);

            $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->dname);

            $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->distributor_city);

            $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->distributor_type);

            $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->location);

            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->sales_rep_name);

            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->due_date);

            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->order_no);

            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->order_date);



            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->remarks);

            $row=$row+1;



            // $bl_insert = false;

            // if($i<count($data)-1){

            //     if($data[$i]->invoice_no!=$data[$i+1]->invoice_no){

            //         $bl_insert = true;

            //     }

            // } else {

            //     $bl_insert = true;

            // }



            // if($bl_insert == true){

            //     $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

            //     $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

            //     $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

            //     $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $data[$i]->date_of_processing);

            //     $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->dweek);

            //     $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->voucher_no);

            //     $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'Round Off Amount');

            //     $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

            //     $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $round_off_amt);

            //     $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $data[$i]->depot_name);

            //     $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$i]->distributor_name);

            //     $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->distributor_city);

            //     $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->distributor_type);

            //     $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->location);

            //     $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->sales_rep_name);

            //     $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->due_date);

            //     $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->order_no);

            //     $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->order_date);

            //     $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->remarks);

            //     $row=$row+1;

            // }

        }



        $row=$row-1;



        $objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getFont()->setBold(true);

        

        $objPHPExcel->getActiveSheet()->getStyle('A1'.':AC'.$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));


        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }


        $filename='Sample_&_Expired_Report.xls';

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->setPreCalculateFormulas(TRUE); 

        $objWriter->save('php://output');



        $logarray['table_id']=$this->session->userdata('session_id');

        $logarray['module_name']='Reports';

        $logarray['cnt_name']='Reports';

        $logarray['action']='Sample & Expired report generated.';

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function get_distributor_in_sku_details($from_date, $to_date) {

    // $sql = "select AA.*, WEEK(date_of_processing,2)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),2)+1 as dweek, 

    //             BB.item_name, BB.quantity, BB.short_name from 

    //         (select A.*, A.id as srid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

    //             C.depot_name, D.distributor_name, D.sell_out, D.type_id, D.location_id, D.city as distributor_city, 

    //             E.distributor_type, F.sales_rep_name, G.location, H.area 

    //         from distributor_in A 

    //             left join distributor_in_items B on(A.id=B.distributor_in_id) 

    //             left join depot_master C on(A.depot_id=C.id) 

    //             left join distributor_master D on(A.distributor_id=D.id) 

    //             left join distributor_type_master E on(D.type_id=E.id) 

    //             left join sales_rep_master F on(A.sales_rep_id=F.id) 

    //             left join location_master G on(D.location_id=G.id) 

    //             left join area_master H on(D.area_id=H.id) 

    //         where A.status='Approved' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date') AA 

    //         left join 

    //         (select id, 'Bar' as type, product_name as item_name, null as quantity, short_name from product_master 

    //             where status='Approved' 

    //         union all 

    //         select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name 

    //         from box_master m left join box_product p on m.id=p.box_id 

    //         where m.status='Approved' group by m.id) BB 

    //         on (AA.item_id=BB.id and AA.type=BB.type) 

    //         where AA.distributor_name not like '%sample%' and AA.distributor_name!='Product Expired'";



    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek, 

                BB.item_name, BB.quantity, BB.short_name from 

            (select A.*, A.id as srid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

                B.cgst_amt, B.sgst_amt, B.igst_amt, B.tax_amt, B.total_amt, 

                C.depot_name, D.distributor_name,K.zone, D.sell_out, D.type_id, D.location_id,D.area_id,D.zone_id, 

                D.city as distributor_city, D.class, D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, 

                E.distributor_type, F.sales_rep_name, G.location, H.area, L.sales_rep_name as salesrepname, M.sales_rep_name as salesrepname1 

            from distributor_in A 

                left join distributor_in_items B on(A.id=B.distributor_in_id) 

                left join depot_master C on(A.depot_id=C.id) 

                left join distributor_master D on(A.distributor_id=D.id) 

                left join distributor_type_master E on(D.type_id=E.id) 

             

                left join location_master G on(D.location_id=G.id) 

                left join area_master H on(D.area_id=H.id) 
                left join zone_master K on(D.zone_id=K.id) 
			
				left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id ) 
				
				left join sales_rep_master F on(J.reporting_manager_id=F.id) 

                left join sales_rep_master L on(J.sales_rep_id1=L.id) 

                left join sales_rep_master M on(J.sales_rep_id2=M.id) 

            where (A.status='Approved') and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date') AA 

            left join 

            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name from product_master 

                where status='Approved' 

            union all 

            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name 

            from box_master m left join box_product p on m.id=p.box_id 

            where m.status='Approved' group by m.id) BB 

            on (AA.item_id=BB.id and AA.type=BB.type) 

            where AA.class!='sample' or AA.class is null";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;

}



function generate_sale_return_sku_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $data = $this->get_distributor_in_sku_details($from_date, $to_date);



    if(count($data)>0) {

        $template_path=$this->config->item('template_path');

        $file = $template_path.'Sale_Return_Sku.xls';

        $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $tax_per=0;

        $cstamt=0;

        $round_off_amt=0;

        $row=2;

        for($i=0; $i<count($data); $i++) {

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $data[$i]->date_of_processing);

            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->dweek);

            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '');

            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->item_name);

            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->short_name);

            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->type);

            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->qty);

            $quantity=$data[$i]->quantity;

            $barquantity=0;

            if($data[$i]->quantity==null) {

                $barquantity=1*$data[$i]->qty;

            } else {

                $barquantity=$data[$i]->quantity*$data[$i]->qty;    

            }

            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $barquantity);

            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->rate);

            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $data[$i]->sell_rate);

            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $data[$i]->sell_out);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');

                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->item_amount);

                $tax=($data[$i]->tax_per/100)*($data[$i]->item_amount);

                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $tax);

                $cstamt=$tax+$data[$i]->item_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $cstamt);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $data[$i]->depot_name);

            $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$i]->distributor_name);

            $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->distributor_city);

            $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->distributor_type);

            $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->location);

            $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->sales_rep_name);

            $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '');

            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '');

            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '');



            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->remarks);

            $row=$row+1;



            $bl_insert = false;

            if($i<count($data)-1){

                if($data[$i]->sid!=$data[$i+1]->sid){

                    $bl_insert = true;

                }

            } else {

                $bl_insert = true;

            }



            if($bl_insert == true){

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $data[$i]->date_of_processing);

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $data[$i]->dweek);

                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '');

                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'Round Off Amount');

                $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $round_off_amt);

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $data[$i]->depot_name);

                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$i]->distributor_name);

                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->distributor_city);

                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $data[$i]->distributor_type);

                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $data[$i]->location);

                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->sales_rep_name);

                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '');

                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '');

                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '');

                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->remarks);

                $row=$row+1;

            }

        }



        $row=$row-1;



        $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);

        

        $objPHPExcel->getActiveSheet()->getStyle('A1'.':AA'.$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));


        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }


        $filename='Sale_Return_Sku_Report.xls';

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->setPreCalculateFormulas(TRUE); 

        $objWriter->save('php://output');



        $logarray['table_id']=$this->session->userdata('session_id');

        $logarray['module_name']='Reports';

        $logarray['cnt_name']='Reports';

        $logarray['action']='Sale Return SKU report generated.';

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


        // for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        // }



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

                    (select A.*, B.short_name from 

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

                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'3', $data[$i]->short_name);

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



            $sql = "select C.product_id, C.short_name, D.raw_material_id, sum(D.qty) as total_qty from 

                    (select A.*, B.short_name from 

                    (select * from batch_processing where status = 'Approved' and 

                        date_of_processing>='$from_date' and date_of_processing<='$to_date') A 

                    left join 

                    (select * from product_master) B 

                    on (A.product_id=B.id)) C 

                    left join 

                    (select * from batch_raw_material) D 

                    on (C.id=D.batch_processing_id) 

                    group by C.product_id, C.short_name, D.raw_material_id 

                    order by C.product_id, C.short_name, D.raw_material_id";

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



                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'3', $data[$i]->short_name);

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

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function get_product_stock_details_old($from_date, $to_date) {

    $sql = "select * from 

            (select KK.depot_id, KK.item_id, KK.opening_qty, KK.production_qty, KK.sale_qty, KK.sale_return_qty, KK.type, KK.item_name, KK.unit_weight, LL.state, LL.city, LL.depot_name from 

            (select II.depot_id, II.product_id as item_id, II.opening_qty, II.production_qty, II.sale_qty, II.sale_return_qty, II.type, JJ.short_name as item_name, JJ.grams as unit_weight from 

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

            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 

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

            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 

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



function get_product_stock_details($from_date, $to_date) {

    $sql = "select * from 

            (select SS.depot_id, SS.product_id, SS.opening_qty, SS.production_qty, SS.depot_in_qty, SS.depot_out_qty, SS.sale_qty, SS.sample_qty, SS.expire_qty, SS.sale_return_qty, SS.item_name, SS.unit_weight, TT.state, TT.city, TT.depot_name from 

            (select QQ.depot_id, QQ.product_id, QQ.opening_qty, QQ.production_qty, QQ.depot_in_qty, QQ.depot_out_qty, QQ.sale_qty, QQ.sample_qty, QQ.expire_qty, QQ.sale_return_qty, RR.short_name as item_name, RR.grams as unit_weight from 

            (select OO.depot_id, OO.product_id, OO.opening_qty, OO.production_qty, OO.depot_in_qty, OO.depot_out_qty, OO.sale_qty, OO.sample_qty, OO.expire_qty, PP.sale_return_qty from 

            (select MM.depot_id, MM.product_id, MM.opening_qty, MM.production_qty, MM.depot_in_qty, MM.depot_out_qty, MM.sale_qty, MM.sample_qty, NN.expire_qty from 

            (select KK.depot_id, KK.product_id, KK.opening_qty, KK.production_qty, KK.depot_in_qty, KK.depot_out_qty, KK.sale_qty, LL.sample_qty from 

            (select II.depot_id, II.product_id, II.opening_qty, II.production_qty, II.depot_in_qty, II.depot_out_qty, JJ.sale_qty from 

            (select GG.depot_id, GG.product_id, GG.opening_qty, GG.production_qty, GG.depot_in_qty, HH.depot_out_qty from 

            (select EE.depot_id, EE.product_id, EE.opening_qty, EE.production_qty, FF.depot_in_qty from 

            (select CC.depot_id, CC.product_id, CC.opening_qty, DD.production_qty from 

            (select AA.depot_id, AA.product_id, BB.opening_qty from 

            (select distinct depot_id, product_id from 

            (select depot_id, product_id from batch_processing where status = 'Approved' 

            union all 

            select distinct A.depot_id, B.product_id from 

            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved') A 

            left join 

            (select C.depot_transfer_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id from depot_transfer_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.depot_transfer_id) 

            where B.product_id is not null 

            union all 

            select distinct A.depot_id, B.product_id from 

            (select id, depot_id from distributor_in where status = 'Approved') A 

            left join 

            (select C.distributor_in_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id from distributor_in_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.distributor_in_id) 

            where B.product_id is not null) E) AA 





            Left join 





            (select F.depot_id, F.product_id, ifnull(F.tot_qty_in,0)-ifnull(G.tot_qty_out,0) as opening_qty from 

            (select E.depot_id, E.product_id, sum(E.tot_qty) as tot_qty_in from 

            (select depot_id, product_id, sum(qty_in_bar) as tot_qty from batch_processing where status = 'Approved' and date_of_processing<'$from_date' group by depot_id, product_id 

            union all 

            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 

            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer<'$from_date') A 

            left join 

            (select C.depot_transfer_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from depot_transfer_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.depot_transfer_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id 

            union all 

            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 

            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing<'$from_date') A 

            left join 

            (select C.distributor_in_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from distributor_in_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.distributor_in_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id) E 

            group by E.depot_id, E.product_id) F 



            left join 



            (select E.depot_id, E.product_id, sum(E.tot_qty) as tot_qty_out from 

            (select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 

            (select id, depot_out_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer<'$from_date') A 

            left join 

            (select C.depot_transfer_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from depot_transfer_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.depot_transfer_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id 

            union all 

            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 

            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing<'$from_date') A 

            left join 

            (select C.distributor_out_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from distributor_out_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.distributor_out_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id) E 

            group by E.depot_id, E.product_id) G 

            on (F.depot_id=G.depot_id and F.product_id=G.product_id)) BB 

            on (AA.depot_id=BB.depot_id and AA.product_id=BB.product_id)) CC 





            left join 





            (select depot_id, product_id, sum(qty_in_bar) as production_qty from batch_processing 

            where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date' 

            group by depot_id, product_id) DD 

            on (CC.depot_id=DD.depot_id and CC.product_id=DD.product_id)) EE 





            left join 





            (select A.depot_id, B.product_id, sum(B.qty) as depot_in_qty from 

            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>='$from_date' and date_of_transfer<='$to_date') A 

            left join 

            (select C.depot_transfer_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from depot_transfer_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.depot_transfer_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id) FF 

            on (EE.depot_id=FF.depot_id and EE.product_id=FF.product_id)) GG 





            left join 





            (select A.depot_id, B.product_id, sum(B.qty) as depot_out_qty from 

            (select id, depot_out_id as depot_id from depot_transfer 

            where status = 'Approved' and date_of_transfer>='$from_date' and date_of_transfer<='$to_date') A 

            left join 

            (select C.depot_transfer_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from depot_transfer_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.depot_transfer_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id) HH 

            on (GG.depot_id=HH.depot_id and GG.product_id=HH.product_id)) II 





            left join 





            (select A.depot_id, B.product_id, sum(B.qty) as sale_qty from 

            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date' and distributor_id not in (1, 63, 64, 65, 66, 189)) A 

            left join 

            (select C.distributor_out_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from distributor_out_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.distributor_out_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id) JJ 

            on (II.depot_id=JJ.depot_id and II.product_id=JJ.product_id)) KK 





            left join 





            (select A.depot_id, B.product_id, sum(B.qty) as sample_qty from 

            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date' and distributor_id in (1, 63, 64, 65, 66)) A 

            left join 

            (select C.distributor_out_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from distributor_out_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.distributor_out_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id) LL 

            on (KK.depot_id=LL.depot_id and KK.product_id=LL.product_id)) MM 





            left join 





            (select A.depot_id, B.product_id, sum(B.qty) as expire_qty from 

            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date' and distributor_id = 189) A 

            left join 

            (select C.distributor_out_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from distributor_out_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.distributor_out_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id) NN 

            on (MM.depot_id=NN.depot_id and MM.product_id=NN.product_id)) OO 





            left join 





            (select A.depot_id, B.product_id, sum(B.qty) as sale_return_qty from 

            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 

            left join 

            (select C.distributor_in_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from distributor_in_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.distributor_in_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id) PP 

            on (OO.depot_id=PP.depot_id and OO.product_id=PP.product_id)) QQ 





            left join 





            (select * from product_master) RR 

            on (QQ.product_id=RR.id)) SS 





            left join 





            (select * from depot_master) TT 

            on(SS.depot_id=TT.id)) UU 

            order by UU.depot_name, UU.item_name";



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

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->unit_weight);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->opening_qty);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->production_qty);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->depot_in_qty);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->depot_out_qty);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->sale_qty);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->sample_qty);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->expire_qty);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->sale_return_qty);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, '=+'.$col_name[$col+5].$row.'+'.$col_name[$col+6].$row.'+'.$col_name[$col+7].$row.'-'.$col_name[$col+8].$row.'-'.$col_name[$col+9].$row.'-'.$col_name[$col+10].$row.'-'.$col_name[$col+11].$row.'+'.$col_name[$col+12].$row);

        }



        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+13].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

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

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function generate_distributor_ledger_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');

    

    $sql = "select DATE_FORMAT('$from_date','%d/%m/%Y') as ref_date, 'Opening Balance' as reference, 

                    sum(debit_amount) as debit_amount, sum(credit_amount) as credit_amount from 

            (select DATE_FORMAT(invoice_date,'%d/%m/%Y') as ref_date, 

                case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else invoice_no end as reference, 

                invoice_amount as debit_amount, null as credit_amount, date_of_processing as rdate, remarks as remarks,

                case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else 'Sale' end as type 

                from distributor_out where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing<'$from_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

               sales_return_no as reference, 

                null as debit_amount, final_amount as credit_amount, date_of_processing as rdate, remarks as remarks, 'Sales Return' as type 

                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing<'$from_date' 

            union all 

            select * from 

            (select DATE_FORMAT(A.date_of_deposit,'%d/%m/%Y') as ref_date, A.id as reference, null as debit_amount, 

                B.payment_amount as credit_amount, A.date_of_deposit as rdate, concat(B.invoice_no,' - ',A.remarks) as remarks, 'Payment' as type from 

            (select * from payment_details where status = 'Approved' and 

                date_of_deposit<'$from_date') A 

            left join 

            (select * from payment_details_items where distributor_id = '$distributor_id') B 

            on (A.id=B.payment_id)) C where C.credit_amount is not null 

            union all 

            select DATE_FORMAT(date_of_transaction,'%d/%m/%Y') as ref_date, ref_no as reference, 

                    case when transaction='Debit Note' then amount end as debit_amount, 

                    case when transaction='Credit Note' then amount end as credit_amount, date_of_transaction as rdate, remarks as remarks, transaction as type 

                from credit_debit_note where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_transaction<'$from_date') A";

    $query=$this->db->query($sql);

    $open_bal_data=$query->result();



    $sql = "select ref_date, reference,debit_amount,credit_amount,rdate,remarks,type from 

            (select DATE_FORMAT(invoice_date,'%d/%m/%Y') as ref_date, 

                case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else invoice_no end as reference, 

                invoice_amount as debit_amount, null as credit_amount, date_of_processing as rdate, remarks as remarks,

                 case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else 'Sale' end as type 

                from distributor_out where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing>='$from_date' and date_of_processing<='$to_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

                sales_return_no as reference, 

                null as debit_amount, final_amount as credit_amount, date_of_processing as rdate, remarks as remarks, 'Sales Return' as type 

                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing>='$from_date' and date_of_processing<='$to_date' 

            union all 

            select * from 

            (select DATE_FORMAT(A.date_of_deposit,'%d/%m/%Y') as ref_date, A.id as reference, null as debit_amount, 

                B.payment_amount as credit_amount, A.date_of_deposit as rdate, concat(B.invoice_no,' - ',A.remarks) as remarks, 'Payment' as type from 

            (select * from payment_details where status = 'Approved' and 

                date_of_deposit>='$from_date' and date_of_deposit<='$to_date') A 

            left join 

            (select * from payment_details_items where distributor_id = '$distributor_id') B 

            on (A.id=B.payment_id)) C where C.credit_amount is not null 

            union all 

            select DATE_FORMAT(date_of_transaction,'%d/%m/%Y') as ref_date, ref_no as reference, 

                    case when transaction='Debit Note' then amount end as debit_amount, 

                    case when transaction='Credit Note' then amount end as credit_amount, date_of_transaction as rdate, remarks as remarks, transaction as type 

                from credit_debit_note where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_transaction>='$from_date' and date_of_transaction<='$to_date') A order by A.rdate asc";

    $query=$this->db->query($sql);

    $data=$query->result();



    $sql1 = "select distributor_name from distributor_master where id='$distributor_id'";

    $query1=$this->db->query($sql1);

    $dist_data=$query1->result();

    

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

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $dist_data[0]->distributor_name);

        $row1=$row1+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "From Date:");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $this->input->post('from_date'));

        $row1=$row1+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "To Date:");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row1, $this->input->post('to_date'));



        //------------ setting headers of excel -------------

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Ref Date');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Type');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Reference');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Debit');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Credit');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, 'Running Balance');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, 'Remarks');



        $running_balance=0;

        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $open_bal_data[0]->ref_date);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Opening Balance');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $open_bal_data[0]->reference);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $open_bal_data[0]->debit_amount);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $open_bal_data[0]->credit_amount);

        if($open_bal_data[0]->debit_amount!=null && $open_bal_data[0]->debit_amount!=0) {

            $running_balance= $running_balance+$open_bal_data[0]->debit_amount;

        }

        if($open_bal_data[0]->credit_amount!=null && $open_bal_data[0]->credit_amount!=0) {

            $running_balance= $running_balance-$open_bal_data[0]->credit_amount;

        }

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $running_balance);



        for($i=0; $i<count($data); $i++){

            $row=$row+1;

            

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->ref_date);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->type);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->reference);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->debit_amount);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->credit_amount);

            if($data[$i]->debit_amount!=null && $data[$i]->debit_amount!=0) {

                $running_balance= $running_balance+$data[$i]->debit_amount;

            }

            else {

                $running_balance= $running_balance-$data[$i]->credit_amount;

            }

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $running_balance);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->remarks);

        }



        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, '=sum('.$col_name[$col+3].'2'.':'.$col_name[$col+3].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-1).')');

        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '='.$col_name[$col+3].strval($row-1).'-'.$col_name[$col+4].strval($row-1));

        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row-1).':'.$col_name[$col+2].strval($row-1));

        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row).':'.$col_name[$col+3].strval($row));



        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[$col+6].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('G1:G9999')->getAlignment()->setWrapText(true); 

        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);

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

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function view_distributor_ledger_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');



    // $from_date = '2017-01-01';

    // $to_date = '2017-07-27';

    // $distributor_id = '44';

    

    $sql = "select DATE_FORMAT('$from_date','%d/%m/%Y') as ref_date, 'Opening Balance' as reference, 

                    sum(debit_amount) as debit_amount, sum(credit_amount) as credit_amount,type from 

            (select DATE_FORMAT(invoice_date,'%d/%m/%Y') as ref_date, 

                case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else invoice_no end as reference, 

                invoice_amount as debit_amount, null as credit_amount, date_of_processing as rdate, remarks as remarks, 

                case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else 'Sale' end as type 

                from distributor_out where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing<'$from_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

                sales_return_no as reference, 

                null as debit_amount, final_amount as credit_amount, date_of_processing as rdate, remarks as remarks, 

                'Sales Return' as type 

                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing<'$from_date' 

            union all 

            select * from 

            (select DATE_FORMAT(A.date_of_deposit,'%d/%m/%Y') as ref_date, A.id as reference, null as debit_amount, 

                B.payment_amount as credit_amount, A.date_of_deposit as rdate, concat(B.invoice_no,' - ',A.remarks) as remarks, 'Payment' as type from 

            (select * from payment_details where status = 'Approved' and 

                date_of_deposit<'$from_date') A 

            left join 

            (select * from payment_details_items where distributor_id = '$distributor_id') B 

            on (A.id=B.payment_id)) C where C.credit_amount is not null 

            union all 

            select DATE_FORMAT(date_of_transaction,'%d/%m/%Y') as ref_date, ref_no as reference, 

                    case when transaction='Debit Note' then amount end as debit_amount, 

                    case when transaction='Credit Note' then amount end as credit_amount, date_of_transaction as rdate, remarks as remarks, transaction as type 

                from credit_debit_note where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_transaction<'$from_date') A";

    $query=$this->db->query($sql);

    $open_bal_data=$query->result();



    $sql = "select ref_date, reference,debit_amount,credit_amount,rdate,remarks,type from 

            (select DATE_FORMAT(invoice_date,'%d/%m/%Y') as ref_date, 

                case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else invoice_no end as reference, 

                invoice_amount as debit_amount, null as credit_amount, date_of_processing as rdate , remarks as remarks,

            case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else 'Sale' end as type  

                from distributor_out where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing>='$from_date' and date_of_processing<='$to_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

                sales_return_no as reference, 

                null as debit_amount, final_amount as credit_amount, date_of_processing as rdate , remarks as remarks,

                'Sales Return' as type 

                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing>='$from_date' and date_of_processing<='$to_date' 

            union all 

            select * from 

                (select DATE_FORMAT(A.date_of_deposit,'%d/%m/%Y') as ref_date, A.id as reference, null as debit_amount, 

                B.payment_amount as credit_amount, A.date_of_deposit as rdate, concat(B.invoice_no,' - ',A.remarks) as remarks, 'Payment' as type from 

            (select * from payment_details where status = 'Approved' and 

                date_of_deposit>='$from_date' and date_of_deposit<='$to_date') A 

            left join 

            (select * from payment_details_items where distributor_id = '$distributor_id') B 

            on (A.id=B.payment_id)) C where C.credit_amount is not null 

            union all 

            select DATE_FORMAT(date_of_transaction,'%d/%m/%Y') as ref_date, ref_no as reference, 

                    case when transaction='Debit Note' then amount end as debit_amount, 

                    case when transaction='Credit Note' then amount end as credit_amount, date_of_transaction as rdate, remarks as remarks, transaction as type 

                from credit_debit_note where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_transaction>='$from_date' and date_of_transaction<='$to_date') A order by A.rdate asc";

    $query=$this->db->query($sql);

    $data=$query->result();



    $sql1 = "select distributor_name from distributor_master where id='$distributor_id'";

    $query1=$this->db->query($sql1);

    $dist_data=$query1->result();



    $datatable = "";

    

    if(count($data)>0) {

        $datatable='<div id="printTable" style=""><br/><span style="font-size:20px;margin-left:50px;"><b>Distributor Name:</b> '.$dist_data[0]->distributor_name.'<br/><br/></span><span style="font-size:20px;margin-left:50px;"><b>From Date: </b>'.$this->input->post('from_date').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>To Date: </b>'.$this->input->post('to_date').'</span><br/><br/><br/><br/>
		
		<table border="1" cellpadding="3" style="border-collapse: collapse;margin-left:50px;">

                    <thead>

                    <tr>

                        <th>Ref Date</th>

                        <th>Type</th>

                        <th>Reference</th>

                        <th>Debit</th>

                        <th>Credit</th>

                        <th>Running Balance</th>
                        <th width="200">Remarks</th>

                    </tr>

                    </thead>

                    <tbody>';



        $debit_amount=0;

        $credit_amount=0;

        $running_balance=0;

        $tot_debit_amount=0;

        $tot_credit_amount=0;



        $debit_amount=$open_bal_data[0]->debit_amount;

        $credit_amount=$open_bal_data[0]->credit_amount;

        if($open_bal_data[0]->debit_amount!=null && $open_bal_data[0]->debit_amount!=0) {

            $running_balance= $running_balance+$debit_amount;

        }

        if($open_bal_data[0]->credit_amount!=null && $open_bal_data[0]->credit_amount!=0) {

            $running_balance= $running_balance-$credit_amount;

        }

        $tot_debit_amount = $tot_debit_amount + $debit_amount;

        $tot_credit_amount = $tot_credit_amount + $credit_amount;



        $datatable=$datatable.'<tr>

                                    <td>'.$open_bal_data[0]->ref_date.'</td>

                                    <td>Opening Balance</td>

                                    <td>'.$open_bal_data[0]->reference.'</td>

                                    <td>'.round($debit_amount,2).'</td>

                                    <td>'.round($credit_amount,2).'</td>

                                    <td>'.round($running_balance,2).'</td>
                                    <td></td>

                                </tr>';



        for($i=0; $i<count($data); $i++){

            $debit_amount=$data[$i]->debit_amount;

            $credit_amount=$data[$i]->credit_amount;

            if($data[$i]->debit_amount!=null && $data[$i]->debit_amount!=0) {

                $running_balance= $running_balance+$debit_amount;

            } else {

                $running_balance= $running_balance-$credit_amount;

            }

            $tot_debit_amount = $tot_debit_amount + $debit_amount;

            $tot_credit_amount = $tot_credit_amount + $credit_amount;

            $datatable=$datatable.'<tr>

                                        <td>'.$data[$i]->ref_date.'</td>

                                        <td>'.$data[$i]->type.'</td>

                                        <td>'.$data[$i]->reference.'</td>

                                        <td>'.round($debit_amount,2).'</td>

                                        <td>'.round($credit_amount,2).'</td>

                                        <td>'.round($running_balance,2).'</td>
                                        <td>'.$data[$i]->remarks.'</td>

                                    </tr>';

        }



        $datatable=$datatable.'<tr>

                                    <td></td>

                                    <td></td>

                                    <td></td>

                                    <td>'.round($tot_debit_amount,2).'</td>

                                    <td>'.round($tot_credit_amount,2).'</td>

                                    
                                    <td></td>
                                    <td></td>
                                </tr>';



        $diff_amount = $tot_debit_amount-$tot_credit_amount;

        $datatable=$datatable.'<tr>

                                    <td></td>

                                    <td></td>
                                    <td></td>

                                    <td></td>

                                    <td>'.round($diff_amount,2).'</td>

                                    
                                    <td></td>
                                    <td></td>
                                </tr>';



        $datatable=$datatable."</tbody></table></div>";

    }



    return $datatable;

}



function view_distributor_ledger_report_old() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');

    

    $sql = "select ref_date, reference,debit_amount,credit_amount,rdate from 

            (select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

                case when distributor_in_type='exchanged' then 'Sales Exchanged Out' 

                     when distributor_in_type='expired' then 'Sales Expired Out' 

                     else invoice_no end as reference, 

                final_amount as debit_amount, null as credit_amount ,date_of_processing as rdate

                from distributor_out where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_processing>='$from_date' and date_of_processing<='$to_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

                case when is_exchanged='yes' then 'Sales Exchanged In' 

                     when is_expired='yes' then 'Sales Expired In' 

                     else 'Sales Return' end as reference, 

                null as debit_amount, final_amount as credit_amount ,date_of_processing as rdate

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



    $sql = "select I.*, J.distributor_type, J.sales_rep_name,J.area,J.location,J.zone,J.so1,J.so2 from 

			(select G.*, H.type_id,H.distributor_name from 

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

                ifnull(round(sum(days_61_90),0),0) as days_61_90, 

                ifnull(round(sum(days_91_above),0),0) as days_91_above from 

            (select distributor_id, case when no_of_days<30 then final_amount else 0 end as days_0_30, 

                case when no_of_days>=30 and no_of_days<=45 then final_amount else 0 end as days_30_45, 

                case when no_of_days>=46 and no_of_days<=60 then final_amount else 0 end as days_46_60, 

                case when no_of_days>=61 and no_of_days<=90 then final_amount else 0 end as days_61_90, 

                case when no_of_days>=91 then final_amount else 0 end as days_91_above from 

            (select id, distributor_id, datediff('$date', date_of_processing) as no_of_days, final_amount 

                from distributor_out where status = 'Approved' and date_of_processing<='$date' and distributor_id NOT IN(1,64,65,66,189,237)) A) B 

            group by distributor_id) C 

            left join 

            (select distributor_id, round(sum(paid_amount),0) as paid_amount from 

            (select distributor_id, round(sum(payment_amount),0) as paid_amount from payment_details_items 

                where payment_id in (select distinct id from payment_details where status = 'Approved' and 

                    date_of_deposit<='$date') group by distributor_id 

            union all 

            select distributor_id, round(sum(final_amount),0) as paid_amount from distributor_in 

                where status = 'Approved' and date_of_processing<='$date' group by distributor_id 

            union all 

            select distributor_id, sum(case when transaction = 'Credit Note' then amount else amount*-1 end) paid_amount 

                from credit_debit_note where status = 'Approved' and 

                date_of_transaction<='$date' group by distributor_id) AA group by distributor_id) D 

            on (C.distributor_id = D.distributor_id)) E) F) G 

            left join 

            (select * FROM distributor_master) H 

            on (G.distributor_id = H.id) where G.tot_receivable > 0) I 

			left join 

			(select P.id, P.type_id,P.distributor_name,P.location_id,S.distributor_type,T.sales_rep_name,Q.area,
                    U.location,V.sales_rep_id1,V.sales_rep_id2,W.zone,X.sales_rep_name as so1,
                    Y.sales_rep_name as so2 

			from distributor_master P 

			left join distributor_type_master S on P.type_id=S.id 

			left join sales_rep_master T on P.sales_rep_id=T.id

			left join area_master Q on P.area_id=Q.id

			left join location_master U on P.location_id=U.id

            left join sr_mapping V on (P.type_id=V.type_id and P.zone_id=V.zone_id and P.area_id=V.area_id)

            left join zone_master W on P.zone_id=W.id

            left join sales_rep_master X on V.sales_rep_id1=X.id

            left join sales_rep_master Y on V.sales_rep_id2=Y.id) J 

			on (I.distributor_id = J.id)";

			



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

		

		

		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('A1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Distributor Id");

		

		

		

		

		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('B1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Distributor Name");

		

		

		$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('C1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "0 - 30 Days");

		



		

		$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('D1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "30 - 45 Days");

		

		

		$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('E1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "46 - 60 Days");

		

		$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('F1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "61 - 90 Days");

		

		$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('G1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('G1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "91+");

		

		

		$objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('H1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('H1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Total Receivable");

		

		

		$objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('I1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('I1')->getFont()->setSize(36);

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Distributor Type"); 

		

		

		$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('J1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('J1')->getFont()->setSize(36);

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Sales Representative Name");

        

        $objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle()->getFont('K1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('K1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "SO1");

        

        

        $objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle()->getFont('L1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "SO2");

        

        

        $objPHPExcel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle()->getFont('M1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('M1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Zone");

        

		

		$objPHPExcel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('N1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('N1')->getFont()->setSize(36);

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Area");

		

		

		$objPHPExcel->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$this->excel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);

		$objPHPExcel->getActiveSheet()->getStyle()->getFont('O1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('O1')->getFont()->setSize(36);

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, "Location");

		





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

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->distributor_type);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->sales_rep_name);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->so1);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->so2);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->zone);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->area);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->location);

			

			

        }



        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, '=sum('.$col_name[$col+2].'2'.':'.$col_name[$col+2].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, '=sum('.$col_name[$col+3].'2'.':'.$col_name[$col+3].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, '=sum('.$col_name[$col+5].'2'.':'.$col_name[$col+5].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=sum('.$col_name[$col+6].'2'.':'.$col_name[$col+6].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, '=sum('.$col_name[$col+7].'2'.':'.$col_name[$col+7].strval($row-1).')');

		

        

		

		

		

		

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+14].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN,

					// 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

					

				

                )

            )

        ));



		

		

        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

			

            'startcolor' => array(

                'rgb' => 'D9D9D9',

				

				

            )

        ));

		

		for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
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

    $sql = "select K.*, case when L.no_of_days <= 90 then 'Active' when L.no_of_days <= 180 then 'Inactive' else 'Dormant' end as d_status from 

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

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, "Created On");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, "Modified On");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, "GST Number");





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

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+24].$row, (($data[$i]->created_on!=null && $data[$i]->created_on!='')?date('d-m-Y',strtotime($data[$i]->created_on)):''));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+25].$row, (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d-m-Y',strtotime($data[$i]->modified_on)):''));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+26].$row, $data[$i]->gst_number);

        }



        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+26].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

            )

        ));

        for($col = 0; $col < 28; $col++) {

            $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[$col])->setAutoSize(true);

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

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function generate_sales_return_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    

    $sql = "select K.*, case when K.type = 'Box' then K.box_name else K.short_name end as item_name from 

            (select I.*, J.short_name from 

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

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->sell_rate);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->sell_out);



            $qty = floatval($data[$i]->qty);

            $sell_rate = floatval($data[$i]->sell_rate);

            // $rate = floatval($data[$i]->rate);

            // $sell_out = floatval($data[$i]->sell_out);

            $cst = floatval($data[$i]->cst);



            $amount = $qty * $sell_rate;

            $tax_amount = $amount * $cst / 100;

            $total_amount = $amount + $tax_amount;



            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $amount);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $tax_amount);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $total_amount);

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

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function generate_payment_receivable_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    

    // $sql = "select K.*, case when K.type = 'Box' then K.box_name else K.product_name end as item_name, L.sales_rep_name from 

    //         (select I.*, J.product_name from 

    //         (select G.*, H.box_name from 

    //         (select E.*, F.depot_name from 

    //         (select C.*, D.distributor_name, D.sell_out from 

    //         (select A.*, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate from 

    //         (select * from distributor_out where status = 'Approved' and 

    //             date_of_processing >= '$from_date' and date_of_processing <= '$to_date') A 

    //         left join 

    //         (select * from distributor_out_items) B 

    //         on (A.id = B.distributor_out_id)) C 

    //         left join 

    //         (select * from distributor_master) D 

    //         on (C.distributor_id = D.id)) E 

    //         left join 

    //         (select * from depot_master) F 

    //         on (E.depot_id = F.id)) G 

    //         left join 

    //         (select * from box_master) H 

    //         on (G.item_id = H.id)) I 

    //         left join 

    //         (select * from product_master) J 

    //         on (I.item_id = J.id)) K 

    //         left join 

    //         (select * from sales_rep_master) L 

    //         on (K.sales_rep_id = L.id)

    //         order by K.id";

    $sql = "select DD.distributor_id, DD.distributor_name, DD.total_pending_amount, EE.invoice_date, EE.invoice_no, EE.voucher_no, EE.due_date, EE.invoice_amount, DD.location from 

            (select CC.distributor_id, CC.distributor_name, sum(CC.pending_amount) as total_pending_amount, CC.location from 

            (select AA.*, ifnull(BB.payment_amount,0) as payment_amount, (round(AA.final_amount,0)-ifnull(BB.payment_amount,0)) as pending_amount from 

            (select A.*, B.distributor_name,F.location from distributor_out A left join distributor_master B on(A.distributor_id=B.id) left join location_master F on B.location_id=F.id 

                where A.status = 'Approved' and A.invoice_no is not null and A.invoice_no!='' and (A.date_of_processing >= '$from_date' and A.date_of_processing <= '$to_date')) AA 

            left join 

            (select A.id, B.distributor_id, B.invoice_no, round(B.payment_amount,0) as payment_amount from payment_details A left join payment_details_items B 

                on(A.id=B.payment_id) where A.status = 'Approved') BB 

            on (AA.distributor_id = BB.distributor_id and AA.invoice_no = BB.invoice_no)) CC 

            group by CC.distributor_id, CC.distributor_name) DD 

            left join 

            (select CC.distributor_id, CC.distributor_name, CC.date_of_processing as invoice_date, CC.invoice_no, 

                CC.voucher_no, CC.due_date, sum(CC.pending_amount) as invoice_amount from 

            (select AA.*, ifnull(BB.payment_amount,0) as payment_amount, (round(AA.final_amount,0)-ifnull(BB.payment_amount,0)) as pending_amount from 

            (select A.*, B.distributor_name from distributor_out A left join distributor_master B on(A.distributor_id=B.id) 

                where A.status = 'Approved' and A.invoice_no is not null and A.invoice_no!='' and (A.date_of_processing >= '$from_date' and A.date_of_processing <= '$to_date')) AA 

            left join 

            (select A.id, B.distributor_id, B.invoice_no, round(B.payment_amount,0) as payment_amount 

                from payment_details A left join payment_details_items B 

                on(A.id=B.payment_id) where A.status = 'Approved') BB 

            on (AA.distributor_id = BB.distributor_id and AA.invoice_no = BB.invoice_no)) CC where CC.pending_amount > 0 

            group by CC.distributor_id, CC.distributor_name, CC.date_of_processing, CC.invoice_no, CC.voucher_no, CC.due_date) EE 

            on (DD.distributor_id = EE.distributor_id and DD.distributor_name = EE.distributor_name) 

            order by DD.distributor_id, EE.invoice_date";

            // echo $sql;

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

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Total Pending Amount");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Invoice Date");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Due Date");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Invoice No");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Amount");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Voucher No");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Location");



        for($i=0; $i<count($data); $i++){

            $row=$row+1;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->distributor_id);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->distributor_name);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->total_pending_amount);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->invoice_date);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->due_date);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->invoice_no);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->invoice_amount);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->voucher_no);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->location);

        }



        

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+8].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

            )

        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
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

            (select A.*, B.item_id, B.qty, B.rate, B.tax_per, B.amount as item_amount from 

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

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "GST Rate");

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

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->tax_per);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->item_amount);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->delivery_date);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->amount);

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

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function generate_production_data_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    

    $sql = "select C.*, D.depot_name from 

            (select A.*, B.short_name from 

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

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->short_name);

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

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function get_product_data(){

    $sql = "select * from product_master where status = 'Approved' order by id";

    $query=$this->db->query($sql);

    return $query->result();

}



function get_sales_rep_direct_order_data($sales_rep, $from_date, $to_date){

    $sql = "select CC.*, DD.distributor_name, DD.distributor_status, DD.distributor_type from 

            (select AA.*, BB.id from 

            (select A.date_of_processing, A.distributor_id, A.sales_rep_id, A.remarks, A.modified_on, B.sales_rep_name 

            from sales_rep_orders A left join sales_rep_master B on (A.sales_rep_id = B.id) 

            where (A.status = 'Approved' or A.status = 'Active') and A.date_of_processing >= '$from_date' and A.date_of_processing <= '$to_date' and 

            A.sales_rep_id = '$sales_rep') AA 

            left join 

            (select id, date_of_visit, distributor_id, sales_rep_id from sales_rep_location 

                where status = 'Approved' and date_of_visit >= '$from_date' and date_of_visit <= '$to_date' and sales_rep_id = '$sales_rep') BB on 

            (AA.date_of_processing = BB.date_of_visit and AA.distributor_id = BB.distributor_id and AA.sales_rep_id = BB.sales_rep_id) 

            where BB.id is null) CC 

            left join 

            (select concat('d_',A.id) as distributor_id, A.distributor_name, A.status as distributor_status, B.distributor_type 

                from distributor_master A left join distributor_type_master B on (A.type_id=B.id)) DD 

            on (CC.distributor_id = DD.distributor_id)";

    $query=$this->db->query($sql);

    return $query->result();

}



function get_sales_rep_order_data($from_date, $to_date){

    // $sql = "select C.date_of_processing, C.distributor_id, C.product_id, sum(C.qty) as qty from 

    //         (select A.*, B.product_id, B.qty from 

    //         (select * from sales_rep_orders where (status = 'Approved' or status = 'Active') and 

    //             date_of_processing >= '$from_date' and date_of_processing <= '$to_date') A 

    //         left join 

    //         (select A.sales_rep_order_id, case when A.type = 'Box' then B.product_id else A.item_id end as product_id, 

    //             case when A.type = 'Box' then A.qty*B.qty else A.qty end as qty from sales_rep_order_items A 

    //             left join box_product B on (A.item_id = B.box_id and A.type = 'Box')) B 

    //         on (A.id = B.sales_rep_order_id)) C 

    //         where C.product_id<=6 

    //         group by C.date_of_processing, C.distributor_id, C.product_id 

    //         order by C.date_of_processing, C.distributor_id, C.product_id";



    $sql = "select C.date_of_processing, C.distributor_id, C.product_id, sum(C.qty) as qty from 

            (select A.*, B.product_id, B.qty from 

            (select * from sales_rep_orders where (status = 'Approved' or status = 'Active') and 

                date_of_processing >= '$from_date' and date_of_processing <= '$to_date') A 

            left join 

            (select A.sales_rep_order_id, case when A.type = 'Box' then B.product_id else A.item_id end as product_id, 

                case when A.type = 'Box' then ifnull(A.qty,0)*ifnull(B.qty,0) else A.qty end as qty from sales_rep_order_items A 

                left join box_product B on (A.item_id = B.box_id and A.type = 'Box')) B 

            on (A.id = B.sales_rep_order_id)) C 

            group by C.date_of_processing, C.distributor_id, C.product_id 

            order by C.date_of_processing, C.distributor_id, C.product_id";

    $query=$this->db->query($sql);

    return $query->result();

}



function get_sales_rep_loc_data($sales_rep, $from_date, $to_date){

    $sql = "select A.*, TIME(A.modified_on) as modified_on_time, B.sales_rep_name, B.email_id, 

            abs(timestampdiff(minute,A.modified_on,(select t2.modified_on from sales_rep_location t2 

                where t2.id < A.id order by t2.id desc limit 1))) as diff, C.area, D.orange_bar, D.mint_bar, 

            D.butterscotch_bar, D.chocopeanut_bar, D.bambaiyachaat_bar, D.mangoginger_bar 

            from sales_rep_location A 

            left join sales_rep_master B on A.sales_rep_id = B.id 

            left join sales_rep_area C on (A.date_of_visit=C.date_of_visit and A.sales_rep_id=C.sales_rep_id) 

            left join sales_rep_distributor_opening_stock D on (A.id=D.sales_rep_loc_id) 

            where A.status = 'Approved' and A.date_of_visit >= '$from_date' and A.date_of_visit <= '$to_date' and 

            A.sales_rep_id = '$sales_rep' order by A.modified_on asc";

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

        

		

		



		  

		  // $objPHPExcel->getActiveSheet()->mergeCells('L5:Q5');

		  // $objPHPExcel->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		  // $this->excel->getActiveSheet()->getStyle('L5')->getFont()->setBold(true);

          // $objPHPExcel->getActiveSheet()->getStyle()->getFont('L5')->setSize(12);

          // $this->excel->getActiveSheet()->getStyle('L5')->getFont()->setSize(36);

		  

		  

		   // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Total Sales");

        

				

		 

		

		

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

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "modified_on_time");

		

		

		

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "orange_bar");

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "mint_bar");

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "butterscotch_bar");

	    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, "chocopeanut_bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, "bambaiyachaat_bar"); 

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, "mangoginger_bar"); 

				   

			

		  



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

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->modified_on_time);

			

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->orange_bar);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->mint_bar);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->butterscotch_bar);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->chocopeanut_bar);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, $data[$i]->bambaiyachaat_bar);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->mangoginger_bar);

			

			

			

			

			

        }



        // $row=$row+1;

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-1).')');

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, '=sum('.$col_name[$col+5].'2'.':'.$col_name[$col+5].strval($row-1).')');

        

        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[$col+16].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A6:Q6')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

            )

        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
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

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function generate_promoter_stock_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $promoter_id = $this->input->post('promoter_id');

    

    $sql = "SELECT I.* 

            FROM   (SELECT G.*, 

             Date_format(H.created_on, '%H:%i:%s') AS out_time 

             FROM   (SELECT E.*, 

                 F.orange, 

                 F.mint, 

                 F.butterscotch, 

                 F.chocopeanut, 

                 F.bambaiyachaat, 

                 F.mangoginger, 

                 J.op_orange_bar, 

                 J.cl_orange_bar, 

                 J.op_mint_bar, 

                 J.cl_mint_bar, 

                 J.op_butterscotch_bar, 

                 J.cl_butterscotch_bar, 

                 J.op_chocopeanut_bar, 

                 J.cl_chocopeanut_bar, 

                 J.op_bambaiyachaat_bar, 

                 J.cl_bambaiyachaat_bar, 

                 J.op_mangoginger_bar, 

                 J.cl_mangoginger_bar 

                 FROM   (SELECT C.*, 

                     D.sales_rep_name 

                     FROM   (SELECT A.*, 

                         Date_format(A.created_on, '%H:%i:%s') AS 

                         in_time 

                         , 

                         B.store_name 

                         FROM   (SELECT Date_format(date_of_visit, 

                             '%d/%m/%Y') 

            AS 

            date_of_visit, 

            created_on, 

            distributor_id, 

            sales_rep_id, 

            id, 

            id 

            AS p_id 

            FROM   promoter_location 

            WHERE  status = 'Approved' 

            AND date_of_visit >= '".$from_date."' 

            AND date_of_visit <= '".$to_date."' 

            ) A 

            left join (SELECT * 

              FROM   promoter_stores) B 

            ON ( A.distributor_id = B.id )) C 

            left join (SELECT * 

              FROM   sales_rep_master) D 

            ON ( C.sales_rep_id = D.id )) E 

            left join (SELECT 

               promoter_loc_id, 

               SUM(IF(TYPE = 'opening', orange_bar, -1 

                                                         * 

                   orange_bar)) 

            AS 

            orange 

            , 

            SUM(IF(TYPE = 'opening', 

             mint_bar, -1 * mint_bar)) 

            AS 

            mint, 

            SUM(IF(TYPE = 'opening', butterscotch_bar, -1 

                                       * 

             butterscotch_bar))   AS 

            butterscotch, 

            SUM(IF(TYPE = 'opening', chocopeanut_bar, -1 * 

             chocopeanut_bar 

             ))     AS 

            chocopeanut 

            , 

            SUM(IF(TYPE = 'opening', bambaiyachaat_bar, -1 

                                       * 

             bambaiyachaat_bar)) AS 

            bambaiyachaat, 

            SUM(IF(TYPE = 'opening', mangoginger_bar, -1 * 

             mangoginger_bar 

             ))     AS 

            mangoginger 

            FROM   promoter_stock 

            GROUP  BY promoter_loc_id) F 

            ON ( E.p_id = F.promoter_loc_id ) 

            left join (SELECT e.promoter_loc_id, 

               SUM(e.op_orange_bar)        AS 

               op_orange_bar, 

               SUM(e.cl_orange_bar)        AS 

               cl_orange_bar, 

               SUM(e.op_mint_bar)          AS 

               op_mint_bar, 

               SUM(e.cl_mint_bar)          AS 

               cl_mint_bar, 

               SUM(e.op_butterscotch_bar)  AS 

               op_butterscotch_bar, 

               SUM(e.cl_butterscotch_bar)  AS 

               cl_butterscotch_bar, 

               SUM(e.op_chocopeanut_bar)   AS 

               op_chocopeanut_bar, 

               SUM(e.cl_chocopeanut_bar)   AS 

               cl_chocopeanut_bar, 

               SUM(e.op_bambaiyachaat_bar) AS 

               op_bambaiyachaat_bar, 

               SUM(e.cl_bambaiyachaat_bar) AS 

               cl_bambaiyachaat_bar, 

               SUM(e.op_mangoginger_bar)   AS 

               op_mangoginger_bar, 

               SUM(e.cl_mangoginger_bar)   AS 

               cl_mangoginger_bar 

               FROM   (SELECT promoter_loc_id, 

                   SUM(IF(TYPE = 'opening', 

                       orange_bar, 0 

                       )) 

            AS 

            op_orange_bar 

            , 

            SUM(IF(TYPE = 'closing', 

               orange_bar, 0 

               )) 

            AS cl_orange_bar, 

            SUM(IF(TYPE = 'opening', 

               mint_bar, 0)) 

            AS 

            op_mint_bar, 

            SUM(IF(TYPE = 'closing', 

               mint_bar, 0)) 

            AS 

            cl_mint_bar, 

            SUM(IF(TYPE = 'opening', 

               butterscotch_bar, 0)) 

            AS 

            op_butterscotch_bar, 

            SUM(IF(TYPE = 'closing', 

               butterscotch_bar, 0)) 

            AS 

            cl_butterscotch_bar, 

            SUM(IF(TYPE = 'opening', 

               chocopeanut_bar, 0)) 

            AS 

            op_chocopeanut_bar, 

            SUM(IF(TYPE = 'closing', 

               chocopeanut_bar, 0)) 

            AS 

            cl_chocopeanut_bar, 

            SUM(IF(TYPE = 'opening', 

               bambaiyachaat_bar, 0) 

            ) AS 

            op_bambaiyachaat_bar, 

            SUM(IF(TYPE = 'closing', 

               bambaiyachaat_bar, 0) 

            ) AS 

            cl_bambaiyachaat_bar, 

            SUM(IF(TYPE = 'opening', 

               mangoginger_bar, 0)) 

            AS 

            op_mangoginger_bar, 

            SUM(IF(TYPE = 'closing', 

               mangoginger_bar, 0)) 

            AS 

            cl_mangoginger_bar 

            FROM   promoter_stock 

            GROUP  BY TYPE, 

            promoter_loc_id) e 

            GROUP  BY e.promoter_loc_id) J 

            ON ( F.promoter_loc_id = J.promoter_loc_id )) G 

            left join (SELECT * 

              FROM   promoter_checkout) H 

            ON ( G.p_id = H.promoter_location_id )) I 

            ORDER  BY I.id ";



    $query=$this->db->query($sql);

    $data=$query->result();



    if(count($data)>0) {

        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);



        $col_name[]=array();

        for($i=0; $i<=25; $i++) {

            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);

        }



        $row=1;

        $col=0;

    		//------------ setting headers of excel -------------



        $objPHPExcel->getActiveSheet()->mergeCells('F1:K1');

        $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle()->getFont('F1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(36);



        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, " Total Sales");



        $objPHPExcel->getActiveSheet()->mergeCells('L1:Q1');

        $objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle()->getFont('F1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('L1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Opening Stock");



        $objPHPExcel->getActiveSheet()->mergeCells('R1:W1');

        $objPHPExcel->getActiveSheet()->getStyle('R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $this->excel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle()->getFont('F1')->setSize(12);

        $this->excel->getActiveSheet()->getStyle('R1')->getFont()->setSize(36);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, "Closing Stock");



        $row=2;

        $col=0;



            //------------ setting headers of excel -------------

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Date of Visit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Promoter Name");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Store Name");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "In Time");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Out Time");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Orange Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Butterscotch Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Mint Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Choco Peanut Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Bambaiya Chaat Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Mango Ginger Bar");



    		//new code start

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Opening Orange Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Opening Mint Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Opening Butterscotch Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, "Opening Choco Peanut Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, "Opening Bambaiya Chaat Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, "Opening Mango Ginger Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, "Closing Orange Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, "Closing Mint Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, "Closing Butterscotch Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, "Closing Choco Peanut Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, "Closing Bambaiya Chaat Bar");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, "Closing Mango Ginger Bar");

    		//new code end

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, "Total");





        for($i=0; $i<count($data); $i++){

            $row=$row+1;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->date_of_visit);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->sales_rep_name);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->store_name);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->in_time);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->out_time);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->orange);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->butterscotch);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->mint);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->chocopeanut);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->bambaiyachaat);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->mangoginger);



    			//new code start

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->op_orange_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->op_mint_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->op_butterscotch_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->op_chocopeanut_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, $data[$i]->op_bambaiyachaat_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->op_mangoginger_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, $data[$i]->cl_orange_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, $data[$i]->cl_mint_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->cl_butterscotch_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+20].$row, $data[$i]->cl_chocopeanut_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+21].$row, $data[$i]->cl_bambaiyachaat_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+22].$row, $data[$i]->cl_mangoginger_bar);

    			//new code end



                // $qty = floatval($data[$i]->qty);

                // $sell_rate = floatval($data[$i]->sell_rate);

                // // $rate = floatval($data[$i]->rate);

                // // $sell_out = floatval($data[$i]->sell_out);

                // $cst = floatval($data[$i]->cst);



                // $amount = $qty * $sell_rate;

                // $tax_amount = $amount * $cst / 100;

            $total_amount = $data[$i]->butterscotch + $data[$i]->mint + $data[$i]->orange + $data[$i]->chocopeanut +$data[$i]->bambaiyachaat + $data[$i]->mangoginger;



            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+23].$row, $total_amount);

        }



            //$row=$row+1;





        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+23].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                    )

                )

            ));



        $objPHPExcel->getActiveSheet()->getStyle('A1:X1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

                )

            ));


        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }



        $filename='Promoter_Stock_Report.xls';

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');



        $logarray['table_id']=$this->session->userdata('session_id');

        $logarray['module_name']='Reports';

        $logarray['cnt_name']='Reports';

        $logarray['action']='Promoter Stock report generated.';

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }

}



function generate_promoter_stock_report_cron($from_date,$to_date) {

    // $from_date = formatdate($this->input->post('from_date'));

    // $to_date = formatdate($this->input->post('to_date'));

    // $promoter_id = $this->input->post('promoter_id');

    

    $sql = "select I.* from 

            (select G.*, DATE_FORMAT(H.created_on,'%H:%i:%s') as out_time from 

            (select E.*, F.orange, F.mint, F.butterscotch, F.chocopeanut, F.bambaiyachaat, F.mangoginger from 

            (select C.*, D.sales_rep_name from 

            (select A.*, DATE_FORMAT(A.created_on,'%H:%i:%s') as in_time, B.store_name from 

            (select DATE_FORMAT(date_of_visit,'%d/%m/%Y') as date_of_visit, created_on, distributor_id, sales_rep_id, id, id as p_id from promoter_location 

                where status = 'Approved' and date_of_visit >= '$from_date' and date_of_visit <= '$to_date') A 

            left join 

            (select * from promoter_stores) B 

            on (A.distributor_id = B.id)) C 

            left join 

            (select * from sales_rep_master) D 

            on (C.sales_rep_id = D.id)) E 

            left join 

            (select promoter_loc_id, SUM(IF(type='opening', orange_bar, -1*orange_bar)) AS orange, 

                SUM(IF(type='opening', mint_bar, -1*mint_bar)) AS mint, 

                SUM(IF(type='opening', butterscotch_bar, -1*butterscotch_bar)) AS butterscotch, 

                SUM(IF(type='opening', chocopeanut_bar, -1*chocopeanut_bar)) AS chocopeanut, 

                SUM(IF(type='opening', bambaiyachaat_bar, -1*bambaiyachaat_bar)) AS bambaiyachaat, 

                SUM(IF(type='opening', mangoginger_bar, -1*mangoginger_bar)) AS mangoginger from promoter_stock group by promoter_loc_id) F 

            on (E.p_id = F.promoter_loc_id)) G 

            left join 

            (select * from promoter_checkout) H 

            on (G.p_id = H.promoter_location_id)) I 

            order by I.id";

    $query=$this->db->query($sql);

    return $query->result();

    // echo $query;

}



public function getOpeningBal($acc_id, $from_date){

    $status = "approved";



    $sql = "select acc_id, sum(case when type='Debit' then amount*-1 else amount end) as opening_bal from account_ledger_entries 

            where acc_id = '$acc_id' and status = '$status' and is_active = '1' and date(ref_date) < date('$from_date') 

            group by acc_id";

    $query=$this->db->query($sql);

    return $query->result_array();

}



public function getLedger($acc_id, $from_date, $to_date){

    $status = "approved";

    

    $sql = "select * from 

            (select A.id, A.ref_id, A.sub_ref_id, A.ref_type, A.entry_type, A.invoice_no, A.vendor_id, A.acc_id, A.ledger_name, 

                A.ledger_code, case when B.cp_acc_id = '$acc_id' then case when A.type='Debit' then 'Credit' else 'Debit' end else A.type end as type, 

                A.amount, A.status, A.created_by, A.modified_by, A.created_on, A.modified_on, 

                A.is_paid, A.payment_ref, A.voucher_id, A.ledger_type, 

                A.narration, A.ref_date, B.cp_acc_id, B.cp_ledger_name, B.cp_ledger_code from 

            (select * from account_ledger_entries where status = '$status' and is_active = '1' and 

                date(ref_date) >= date('$from_date') and date(ref_date) <= date('$to_date') and 

                ref_type in ('Distributor_Sales', 'Distributor_Sales_Return') and ledger_type != 'Main Entry') A 

            left join 

            (select distinct voucher_id as cp_voucher_id, acc_id as cp_acc_id, ledger_name as cp_ledger_name, 

                ledger_code as cp_ledger_code from account_ledger_entries where status = '$status' and is_active = '1' and 

                date(ref_date) >= date('$from_date') and date(ref_date) <= date('$to_date') and 

                ref_type in ('Distributor_Sales', 'Distributor_Sales_Return') and ledger_type = 'Main Entry') B 

            on (A.voucher_id = B.cp_voucher_id) 

            union all 

            select A.id, A.ref_id, A.sub_ref_id, A.ref_type, A.entry_type, A.invoice_no, A.vendor_id, A.acc_id, A.ledger_name, 

                A.ledger_code, case when A.type='Debit' then 'Credit' else 'Debit' end as type, A.amount, A.status, 

                A.created_by, A.modified_by, A.created_on, A.modified_on, 

                A.is_paid, A.payment_ref, A.voucher_id, A.ledger_type, 

                A.narration, A.ref_date, B.acc_id as cp_acc_id, B.ledger_name as cp_ledger_name, 

                B.ledger_code as cp_ledger_code from 

            (select * from account_ledger_entries where status = '$status' and is_active = '1' and 

                date(ref_date) >= date('$from_date') and date(ref_date) <= date('$to_date') and 

                ref_type = 'journal_voucher' and acc_id!='$acc_id') A 

            left join 

            (select * from account_ledger_entries where status = '$status' and is_active = '1' and 

                date(ref_date) >= date('$from_date') and date(ref_date) <= date('$to_date') and 

                ref_type = 'journal_voucher' and acc_id='$acc_id') B 

            on(A.ref_id=B.ref_id) 

            union all 

            select A.id, A.ref_id, A.sub_ref_id, A.ref_type, A.entry_type, A.invoice_no, A.vendor_id, A.acc_id, A.ledger_name, 

                A.ledger_code, case when B.cp_acc_id = '$acc_id' then case when A.type='Debit' then 'Credit' else 'Debit' end else A.type end as type, 

                A.amount, A.status, A.created_by, A.modified_by, A.created_on, A.modified_on, 

                A.is_paid, A.payment_ref, A.voucher_id, A.ledger_type, 

                A.narration, A.ref_date, B.cp_acc_id, B.cp_ledger_name, B.cp_ledger_code from 

            (select * from account_ledger_entries where status = '$status' and is_active = '1' and 

                date(ref_date) >= date('$from_date') and date(ref_date) <= date('$to_date') and 

                ref_type = 'payment_receipt' and ledger_type = 'Main Entry') A 

            left join 

            (select distinct voucher_id as cp_voucher_id, acc_id as cp_acc_id, ledger_name as cp_ledger_name, 

                ledger_code as cp_ledger_code from account_ledger_entries where status = '$status' and is_active = '1' and 

                date(ref_date) >= date('$from_date') and date(ref_date) <= date('$to_date') and 

                ref_type = 'payment_receipt' and ledger_type = 'Sub Entry') B 

            on (A.voucher_id = B.cp_voucher_id)) AA 

            where AA.acc_id = '$acc_id' or AA.cp_acc_id = '$acc_id' 

            order by AA.ref_date, AA.id";

    $query=$this->db->query($sql);

    return $query->result_array();

}



function generate_ledger_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $ledger_id = $this->input->post('ledger_id');



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

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Date");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Ledger Code");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Ledger Name");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Ref 1");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Ref 2");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Debit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Credit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Balance");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");



        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Start Date");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Opening Balance");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Ledger Name");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Ref 1");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Ref 2");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Debit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, format_money($opening_bal,2));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $opening_bal_type);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");



        $row = $row + 1;



        $balance = $opening_bal;



        $debit_amt = 0;

        $credit_amt = 0;

        $cur_total = 0;



        for($i=0; $i<count($data); $i++){

            $ledger_code = '';

            $ledger_name = '';



            if($data[$i]['type']=='Debit'){

                $entry_type = 'Dr';

                $debit_amt = floatval($data[$i]['amount']);

                $balance = round($balance - $debit_amt,2);

                $credit_amt = '';

                $cur_total = round($cur_total - $debit_amt,2);

            } else {

                $entry_type = 'Cr';

                $credit_amt = floatval($data[$i]['amount']);

                $balance = round($balance + $credit_amt,2);

                $debit_amt = '';

                $cur_total = round($cur_total + $credit_amt,2);

            }

            if($balance<0){

                $balance_type = 'Dr';

                $balance_val = $balance * -1;

            } else {

                $balance_type = 'Cr';

                $balance_val = $balance;

            }

            if(isset($data[$i]['cp_acc_id'])){

                if($data[$i]['cp_acc_id']!=$ledger_id){

                    $ledger_code = $data[$i]['cp_ledger_code'];

                    $ledger_name = $data[$i]['cp_ledger_name'];

                }

            }

            if($ledger_code == ''){

                $ledger_code = $data[$i]['ledger_code'];

                $ledger_name = $data[$i]['ledger_name'];

            }



            $row=$row+1;



            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, ($i+1));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]['voucher_id']);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, (($data[$i]['ref_date']!=null && $data[$i]['ref_date']!="")?date("d/m/Y",strtotime($data[$i]['ref_date'])):""));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $ledger_code);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $ledger_name);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]['ref_id']);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]['invoice_no']);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, format_money($debit_amt,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, format_money($credit_amt,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, format_money($balance_val,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $balance_type);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]['payment_ref']);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]['narration']);

        }



        if($balance<0){

            $balance_type = 'Dr';

            $balance_val = $balance * -1;

        } else {

            $balance_type = 'Cr';

            $balance_val = $balance;

        }



        if($cur_total<0){

            $cur_total_type = 'Dr';

            $cur_total_val = $cur_total * -1;

        } else {

            $cur_total_type = 'Cr';

            $cur_total_val = $cur_total;

        }



        $row = $row + 1;

        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "End Date");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Closing Balance");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Ledger Name");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Ref 1");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Ref 2");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Debit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, format_money($balance_val,2));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $balance_type);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");



        $row = $row + 1;

        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "End Date");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Closing Balance");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Ledger Name");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Ref 1");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Opening Balance");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, (($opening_bal_type == "Dr")?format_money($opening_bal,2):"0.00"));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, (($opening_bal_type == "Cr")?format_money($opening_bal,2):"0.00"));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $opening_bal_type);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");



        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "End Date");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Closing Balance");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Ledger Name");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Ref 1");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Current Total");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, (($cur_total < 0)?format_money($cur_total_val,2):"0.00"));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, (($cur_total >= 0)?format_money($cur_total_val,2):"0.00"));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $cur_total_type);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");



        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "End Date");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Closing Balance");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Ledger Name");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Ref 1");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Closing Balance");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, (($balance < 0)?format_money($balance_val,2):"0.00"));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, (($balance >= 0)?format_money($balance_val,2):"0.00"));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $balance_type);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");



        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+12].$row)->applyFromArray(array(

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



        $filename='Ledger_Report.xls';

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');



        $logarray['table_id']=$this->session->userdata('session_id');

        $logarray['module_name']='Reports';

        $logarray['cnt_name']='Reports';

        $logarray['action']='Ledger report generated.';

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        // echo '<script>alert("No data found");</script>';

    }

}



public function getTrialBalance($from_date, $to_date){

    $status = "approved";

    

    $sql = "select C.id as account_id, C.ledger_name as code, C.ledger_name as legal_name, null as category_1, 

                null as category_2, null as category_3, C.acc_category, C.bus_category, C.opening_bal, D.* from 

            (select A.*, A.ledger_type as acc_category, B.group_name as bus_category from 

            (select * from account_ledger_master where status = '$status') A 

            left join 

            (select * from account_group_master where status = '$status') B 

            on (A.id = B.acc_id)) C 

            left join 

            (select acc_id, sum(case when type='Debit' then amount else 0 end) as debit_amt, 

                    sum(case when type='Credit' then amount else 0 end) as credit_amt 

            from account_ledger_entries where status = '$status' and 

                date(ref_date) >= date('$from_date') and date(ref_date) <= date('$to_date')

            group by acc_id) D 

            on (C.id = D.acc_id) 

            order by C.id";

    $query=$this->db->query($sql);

    return $query->result_array();

}



function generate_trailbalance_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));



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



    $data = $this->getTrialBalance($from_date, $to_date);

    $opening_bal = 0;

    $tot_amount = 0;

    $closing_bal = 0;

    $debit_amt = 0;

    $credit_amt = 0;

    $cur_total = 0;

    $acc_code = '';

    $prev_acc_code = '';

    $tbody = '';

    $tbody2 = '';

    $tot_deb_ope_bal = 0;

    $tot_crd_ope_bal = 0;

    $tot_deb_tran = 0;

    $tot_crd_tran = 0;

    $tot_deb_clo_bal = 0;

    $tot_crd_clo_bal = 0;

    $sr_no = 0;



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

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Particulars");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Accounts Level 1 Category");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Account Name");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Opening Balance");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Transaction");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Closing Balance");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Business Category");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Accounts Level 1");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Accounts Level 2");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Accounts Level 3");



        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Start Date");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Opening Balance");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Ledger Name");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Ref 1");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Debit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Credit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Debit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Credit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Debit");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Credit");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Accounts Level 3");



        for($i=0; $i<count($data); $i++){

            $acc_code = $data[$i]['code'];



            // if($acc_code!=$prev_acc_code){

            //     $prev_acc_code = $acc_code;

            //     $opening_bal = floatval($data[$i]['opening_bal']);

            //     $closing_bal = $opening_bal;

            // }



            // if($data[$i]['type']=='Debit'){

            //     $debit_amt = floatval($data[$i]['amount']);

            //     $closing_bal = $opening_bal - $debit_amt;

            //     $credit_amt = '';

            // } else {

            //     $credit_amt = floatval($data[$i]['amount']);

            //     $closing_bal = $closing_bal + $credit_amt;

            //     $debit_amt = '';

            // }



            $opening_bal = floatval($data[$i]['opening_bal']);

            $debit_amt = floatval($data[$i]['debit_amt']);

            $credit_amt = floatval($data[$i]['credit_amt']);

            $closing_bal = $opening_bal - $debit_amt + $credit_amt;



            if($debit_amt!=0 || $credit_amt!=0){

                if($debit_amt==0){

                    $debit_amt_val = '';

                } else {

                    $debit_amt_val = $mycomponent->format_money($debit_amt,2);

                }

                if($credit_amt==0){

                    $credit_amt_val = '';

                } else {

                    $credit_amt_val = $mycomponent->format_money($credit_amt,2);

                }



                $row=$row+1;



                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, ($sr_no+1));

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]['legal_name']);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]['category_1']);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]['code']);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, (($opening_bal<0)?($opening_bal*-1):""));

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, (($opening_bal>=0)?$opening_bal:""));

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $debit_amt_val);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $credit_amt_val);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, (($closing_bal<0)?($closing_bal*-1):""));

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, (($closing_bal>=0)?$closing_bal:""));

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]['bus_category']);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]['category_1']);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]['category_2']);

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]['category_3']);



              $sr_no = $sr_no + 1;

            }



            if($opening_bal<0){

                $tot_deb_ope_bal = $tot_deb_ope_bal + $opening_bal;

            } else {

                $tot_crd_ope_bal = $tot_crd_ope_bal + $opening_bal;

            }

            if($closing_bal<0){

                $tot_deb_clo_bal = $tot_deb_clo_bal + $closing_bal;

            } else {

                $tot_crd_clo_bal = $tot_crd_clo_bal + $closing_bal;

            }

            $tot_deb_tran = $tot_deb_tran + $debit_amt;

            $tot_crd_tran = $tot_crd_tran + $credit_amt;



            // $opening_bal = $closing_bal;

        }



        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "End Date");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Grant Total");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, ($tot_deb_ope_bal*-1));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $tot_crd_ope_bal);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $tot_deb_tran);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $tot_crd_tran);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, ($tot_deb_clo_bal*-1));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $tot_crd_clo_bal);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Narration");



        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "End Date");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Closing Balance");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Ledger Name");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Ref 1");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Opening Balance");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, (($opening_bal_type == "Dr")?format_money($opening_bal,2):"0.00"));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, (($opening_bal_type == "Cr")?format_money($opening_bal,2):"0.00"));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $opening_bal_type);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");



        $row = $row + 1;



        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sr No");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Ref ID (Voucher No)");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "End Date");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Grant Total");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, ($tot_deb_clo_bal*-1));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $tot_crd_clo_bal);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Current Total");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, (($cur_total < 0)?format_money($cur_total_val,2):"0.00"));

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, (($cur_total >= 0)?format_money($cur_total_val,2):"0.00"));

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $cur_total_type);

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "DB/CR");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Knock Off Ref");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Narration");

        // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Narration");



        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+13].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

            )

        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }



        $filename='TrailBalance_Report.xls';

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');



        $logarray['table_id']=$this->session->userdata('session_id');

        $logarray['module_name']='Reports';

        $logarray['cnt_name']='Reports';

        $logarray['action']='Trail balance report generated.';

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        // echo '<script>alert("No data found");</script>';

    }

}



}

?>