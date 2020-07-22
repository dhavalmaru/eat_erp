<?php 

if (! defined('BASEPATH')) { exit('No Direct Script Access is allowed'); }

class Export_model Extends CI_Model{

function __Construct(){

	parent :: __construct();

    $this->load->helper('common_functions');
    $this->load->library('excel');
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
    $sql = "select * from 
            (select C.*, WEEK(C.invoice_date,1)-WEEK(STR_TO_DATE(concat(YEAR(C.invoice_date),'-',MONTH(C.invoice_date),'-',1),'%Y-%m-%d'),1)+1 as dweek, 
                    D.depot_name, D.state as Depot_state, D.state_code as depot_state_code, 
                    F.distributor_name, F.sell_out, F.type_id, F.zone_id,F.location_id, 
                    F.city as distributor_city, F.area_id, F.class, F.state as dist_state, 
                    F.state_code as dist_state_code, F.gst_number as dist_gst_no, F.prefix, 
                    L.distributor_type, H.sales_rep_name, K.location, M.area, O.zone as dist_zone 
            from distributor_out C 
            left join depot_master D on (C.depot_id=D.id) 
            left join distributor_master F on (C.distributor_id=F.id) 
            left join distributor_type_master L on (F.type_id=L.id) 
            left join sales_rep_master H on (C.sales_rep_id=H.id) 
            left join location_master K on (F.location_id=K.id) 
            left join area_master M on (F.area_id=M.id) 
            left join zone_master O on (F.zone_id=O.id) 
            where (C.status='Approved' or C.status='InActive') and 
                C.invoice_date>='$from_date' and C.invoice_date<='$to_date' and 
                (C.distributor_id!='1' and C.distributor_id!='189') and 
                (F.class!='sample' or F.class is null) 
            order by C.invoice_date desc) A 
            left join 
            (
            select distributor_out_id, tax_percentage, sum(cgst_amt) as cgst_amt, sum(sgst_amt) as sgst_amt, sum(igst_amt) as igst_amt, sum(total_amt)-(sum(cgst_amt)+sum(sgst_amt)+sum(igst_amt)) as amt_exc_tax, sum(total_amt) as total_amt from distributor_out_items group by distributor_out_id, tax_percentage
            ) B on (A.id=B.distributor_out_id)";

    $query=$this->db->query($sql);
    $result=$query->result();
    $this->db->last_query();
    return $result;
}

function get_sample_expired_details($from_date, $to_date, $date_of_processing, $date_of_accounting) {
    $ddateofprocess="";

    // if( $date_of_processing != '' && $date_of_accounting=='') {
    //     $ddateofprocess = "A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' ";
    // } else {
    //     $ddateofprocess = "date(A.approved_on)>='$from_date' and date(A.approved_on)<='$to_date' ";
    // }

    $ddateofprocess = " date(A.invoice_date)>='$from_date' and date(A.invoice_date)<='$to_date' ";


    $sql = "select * from 
            (select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek from 

            (select A.*, A.id as sampleid, C.depot_name, C.state as depot_state, 

                C.state_code as depot_state_code, D.distributor_name, D.sell_out, D.type_id,

                D.zone_id, D.area_id, D.location_id, D.city as distributor_city, D.class, 

                E.distributor_type, F.sales_rep_name, G.location, I.distributor_name as dname, H.area, 

                D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, 

                J.zone as dist_zone, D.prefix 

                from distributor_out A 

                left join depot_master C on(A.depot_id=C.id) 

                left join distributor_master D on(A.distributor_id=D.id) 

                left join distributor_master I on(A.sample_distributor_id=I.id) 

                left join distributor_type_master E on(D.type_id=E.id) 
                
                left join sales_rep_master F on(A.sales_rep_id=F.id)

                left join location_master G on(D.location_id=G.id) 

                left join area_master H on(D.area_id=H.id) 
                
                left join zone_master J on(D.zone_id=J.id) 
                
            where (A.status='Approved' ) and ".$ddateofprocess." ) AA 

            where AA.class='sample' and AA.class is not null ) A
            Left Join
            (
            SELECT sum(sgst_amt) as sgst_amt,sum(igst_amt) as igst_amt ,sum(cgst_amt) as cgst_amt,tax_percentage ,sum(total_amt)-(sum(sgst_amt)+sum(cgst_amt)+sum(igst_amt)) as amt_exc_tax,sum(total_amt) as total_amt,distributor_out_id
            from distributor_out_items  GROUP BY distributor_out_id,tax_percentage
            ) B on (A.id=B.distributor_out_id)";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;
}

function get_distributor_in_details($from_date, $to_date) {
    $sql = "Select A.*, B.sgst_amt, B.igst_amt, B.cgst_amt, B.tax_percentage, B.amt_exc_tax, 
        B.total_amt, B.distributor_in_id, C.state, C.state_code from 
        (select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek from 

        (select A.*,A.id as srid, A.cst as tax_per, C.depot_name, C.state as depot_state, 
            C.state_code as depot_state_code, D.distributor_name, D.sell_out, D.type_id, 
            D.location_id, D.city as distributor_city, D.class, D.state as dist_state, 
            D.state_code as dist_state_code, D.gst_number as dist_gst_no, D.prefix, 
            I.zone as dist_zone, E.distributor_type, F.sales_rep_name, G.location, H.area 

        from distributor_in A 

            left join depot_master C on(A.depot_id=C.id) 

            left join distributor_master D on(A.distributor_id=D.id) 

            left join distributor_type_master E on(D.type_id=E.id) 

            left join location_master G on(D.location_id=G.id) 

            left join area_master H on(D.area_id=H.id) 

            left join zone_master I on(D.zone_id=I.id) 
            
            left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id ) 
            
            left join sales_rep_master F on(A.sales_rep_id=F.id AND J.reporting_manager_id=F.id) 

        where (A.status='Approved') and date(A.sales_return_date)>='$from_date' and 
            date(A.sales_return_date)<='$to_date') AA ) A
        Left Join
        (
        SELECT sum(sgst_amt) as sgst_amt, sum(igst_amt) as igst_amt, sum(cgst_amt) as cgst_amt, tax_percentage, sum(total_amt)-(sum(sgst_amt)+sum(cgst_amt)+sum(igst_amt)) as amt_exc_tax, sum(total_amt) as total_amt, distributor_in_id
        from distributor_in_items  GROUP BY distributor_in_id,tax_percentage
        ) B on (A.id=B.distributor_in_id) 
        left join 
        (select order_no, min(state) as state, min(state_code) as state_code from distributor_out where status='Approved' and order_no is not null and order_no!='' and state is not null and state!='' and state_code is not null and state_code!='' group by order_no) C on (A.order_no=C.order_no)";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;
}

function generate_sale_invoice_report($invoicelevel, $invoicelevelsalesreturn, $invoicelevelsample, $date_of_processing, $date_of_accounting, $flag) {

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
            $pr_dist_id='';
            $pr_inv_no='';
            $pr_system_id='';

            for($i=0; $i<count($data); $i++) {
                $dist_id=$data[$i]->distributor_out_id;
                $inv_no=$data[$i]->invoice_no;
                $system_id=$data[$i]->id;

                if($i==0){
                    $pr_dist_id=$dist_id;
                    $pr_inv_no=$inv_no;
                    $pr_system_id=$system_id;
                }

                if($dist_id!=$pr_dist_id || $inv_no!=$pr_inv_no || $system_id!=$pr_system_id){
                    $row=$row+1;
                    $pr_dist_id=$dist_id;
                    $pr_inv_no=$inv_no;
                    $pr_system_id=$system_id;
                }

                // $dop=date("d-m-Y", strtotime($data[$i]->date_of_processing));
                $dop=date("d-m-Y", strtotime($data[$i]->invoice_date));
                $mod_on=date("d-m-Y", strtotime($data[$i]->invoice_date));

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $mod_on);

                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);

                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "SALES");

                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->invoice_no);

                $status = $data[$i]->status;

                if($status=="InActive") {

                    $status='Cancelled';

                }

                if($status=='Cancelled') {

                    
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '0');

                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '0');

                    // $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '0');

                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '0');


                } else {

                    $tax_per = $data[$i]->tax_percentage;
                    if($tax_per=='5')
                    {
                       $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->amt_exc_tax);
                    }
                    else if($tax_per=='12')
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->amt_exc_tax);
                    }
                    else if($tax_per=='18')
                    {
                       $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->amt_exc_tax);
                    }

                    /*$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->amount);*/

                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '=(I'.$row.'+J'.$row.'+K'.$row.')');

                    if($data[$i]->cgst_amt!=0)
                    {
                        $tax_percentage = $data[$i]->tax_percentage/2;
                        if($tax_percentage=='2.5')
                        {
                            
                            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '=ROUND(I'.$row.'*2.5%,2)');
                            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '=ROUND(I'.$row.'*2.5%,2)');
                        }
                        if($tax_percentage=='6'){
                            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '=ROUND(J'.$row.'*6%,2)');
                             $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '=ROUND(J'.$row.'*6%,2)');
                        }
                        if($tax_percentage=='9'){
                            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, '=ROUND(K'.$row.'*9%,2)');
                            $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '=ROUND(K'.$row.'*9%,2)');
                        }
                    }
                    else
                    {
                        $tax_percentage = $data[$i]->tax_percentage;
                        if($tax_percentage=='5')
                        { 
                          $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '=ROUND(I'.$row.'*5%,2)');
                        }
                        if($tax_percentage=='12'){
                            $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '=ROUND(J'.$row.'*12%,2)');
                        }
                        if($tax_percentage=='18'){
                            $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '=ROUND(K'.$row.'*18%,2)');
                        }
                        /*$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->igst_amt);*/
                    }

                    /*$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->amount);*/

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
                    
                    if($cgst_amt!=0)
                    {
                       $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '=M'.$row.'+N'.$row.'+O'.$row); 
                    }
                    else
                    {
                       $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $cgst_amt);
                    }

                    if($sgst_amt!=0)
                    {
                       $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '=Q'.$row.'+R'.$row.'+S'.$row); 
                    }
                    else
                    {
                      $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $sgst_amt);
                    }
                   

                    if($igst_amt!=0)
                    {
                         $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '=U'.$row.'+V'.$row.'+W'.$row);
                    }
                    else
                    {
                        $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $igst_amt);
                    }

                    /*L9+P9+T9+X9+Z9-AA9*/

                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '=P'.$row.'+T'.$row.'+X'.$row);


                    $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;
                    /*$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $round_off_amt);*/
                    /*$round_off_amt = -($round_off_amt);*/

                    /*'=L9+P9+T9+X9+Z9-AA9'*/
                    /*$round_off_amt = $round_off_amt*-1;*/
                    /*$round_off_amt = 0;*/
                    $round_off_amt=round($round_off_amt,4);
                    $invoice_amount = $objPHPExcel->getActiveSheet()->getCell('L'.$row)->getCalculatedValue();
                    $cgst_amt =  $objPHPExcel->getActiveSheet()->getCell('P'.$row)->getCalculatedValue();
                    $sgst_amt = $objPHPExcel->getActiveSheet()->getCell('T'.$row)->getCalculatedValue();
                    $igst_amt = $objPHPExcel->getActiveSheet()->getCell('X'.$row)->getCalculatedValue();
                    $invoice_total_amt = $objPHPExcel->getActiveSheet()->getCell('AA'.$row)->getCalculatedValue();
                    $round_off_amt = $round_off_amt*-1;
                    $formula = '';
                
                    if(intval($invoice_total_amt)>=0)
                        $formula.='AA'.$row;
                    else
                        $formula.=$invoice_total_amt;

                    $formula .= '-(';

                    if(intval($invoice_amount)>=0)
                        $formula.='+L'.$row;
                    else
                        $formula.=$invoice_amount;

                    if(intval($cgst_amt)>=0)
                        $formula.='+P'.$row;
                    else
                        $formula.=$cgst_amt;

                    if(intval($sgst_amt)>=0)
                        $formula.='+T'.$row;
                    else
                        $formula.=$sgst_amt;

                    if(intval($igst_amt)>=0)
                        $formula.='+X'.$row;
                    else
                        $formula.=$igst_amt;

                    $formula .= ')';

                    /*echo '<br>'.$formula;*/

                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row,'=ROUND('.$formula.',2)');

                    /*$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, '=L'.$row.'+P'.$row.'+T'.$row.'+X'.$row.'+'.($round_off_amt*-1).'-AA'.$row);*/

                    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, round($data[$i]->final_amount));

                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->depot_name);


                    // if($data[$i]->distributor_id=='214' && intval($igst_amt)!=0) {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, 'AMAZON DIRECT - OMS');
                    // } else if($data[$i]->distributor_id=='1319' && intval($igst_amt)!=0) {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, 'PAYTM DIRECT - OMS');
                    // } else {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->distributor_name);
                    // }
                    
                    // $distributor_name = $data[$i]->distributor_name;
                    // if(strtoupper(trim($distributor_name))=='DIRECT' || strtoupper(trim($distributor_name))=='AMAZON DIRECT' || strtoupper(trim($distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($distributor_name))=='NYKAA DIRECT' || strtoupper(trim($distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($distributor_name))=='1MG TECHNOLOGIES PRIVATE LIMITED' || strtoupper(trim($distributor_name))=='PAYTM DIRECT' || strtoupper(trim($distributor_name))=='UNFACTORY DIRECT' || strtoupper(trim($distributor_name))=='EMBRACE DIRECT' || strtoupper(trim($distributor_name))=='NEULIFE DIRECT' || strtoupper(trim($distributor_name))=='FLIPKART DIRECT' || strtoupper(trim($distributor_name))=='GOQII DIRECT') {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->state_code);
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->state);
                    // } else {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->dist_state_code);
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->dist_state);
                    // }

                    if(strtoupper(trim($data[$i]->class))=='DIRECT') {
                        if($data[$i]->state_code==$data[$i]->depot_state_code) {
                            $distributor_name = $data[$i]->prefix.' Direct-Local';
                        } else {
                            $distributor_name = $data[$i]->prefix.' OOS-'.$data[$i]->state_code.'_'.$data[$i]->state;
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $distributor_name);
                        $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->state_code);
                        $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->state);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->distributor_name);
                        $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->dist_state_code);
                        $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->dist_state);
                    }
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->distributor_type);

                    $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->dist_gst_no);

                    $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->dist_zone);

                    $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->area);

                    $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->distributor_city);

                    $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$i]->location);

                    $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->sales_rep_name);

                    $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->due_date);

                    $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->order_no);

                    $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->order_date);

                }

                $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $data[$i]->remarks);

                $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $data[$i]->id);

                $objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $status);

                $objPHPExcel->getActiveSheet()->setCellValue('AS'.$row, $data[$i]->mobile_no);

            }

        }
    }


    if($invoicelevelsample!="") {

        $include=$include.'Sample & Product Expired, ';

        $data = $this->get_sample_expired_details($from_date, $to_date, $date_of_processing, $date_of_accounting);

        // echo $invoicelevelsample;
        // echo '<br>';
        // echo count($data);
        // echo '<br>';

        $pr_dist_id='';
        $pr_inv_no='';
        $pr_system_id='';

        for($i=0; $i<count($data); $i++) {
            $dist_id=$data[$i]->distributor_out_id;
            $inv_no=$data[$i]->voucher_no;
            $system_id=$data[$i]->id;

            if($i==0){
                $pr_dist_id=$dist_id;
                $pr_inv_no=$inv_no;
                $pr_system_id=$system_id;
            }

            if($dist_id!=$pr_dist_id || $inv_no!=$pr_inv_no || $system_id!=$pr_system_id){
                $row=$row+1;
                $pr_dist_id=$dist_id;
                $pr_inv_no=$inv_no;
                $pr_system_id=$system_id;
            }

            // $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));
            // $mod_on=date("d-m-Y", strtotime($data[$i]->approved_on));

            $dop1=date("d-m-Y", strtotime($data[$i]->invoice_date));
            $mod_on=date("d-m-Y", strtotime($data[$i]->invoice_date));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop1);

            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $mod_on);

            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);

            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "Sample & Product Expired");

            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->voucher_no);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
               $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '0');
            } else {

                /*$tax_per = $data[$i]->tax_percentage;*/
                $tax_per = $data[$i]->tax_percentage;
                if($tax_per=='5')
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->amt_exc_tax);
                }
                else if($tax_per=='12')
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->amt_exc_tax);
                }
                else if($tax_per=='18')
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->amt_exc_tax);
                }

                /*$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->amount);*/

                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '=(I'.$row.'+J'.$row.'+K'.$row.')');

                if($data[$i]->cgst_amt!=0)
                {
                    $tax_percentage = $data[$i]->tax_percentage/2;
                    if($tax_percentage=='2.5')
                    {
                        
                        $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '=ROUND(I'.$row.'*2.5%,2)');
                        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '=ROUND(I'.$row.'*2.5%,2)');
                    }
                    if($tax_percentage=='6'){
                        $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '=ROUND(J'.$row.'*6%,2)');
                         $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '=ROUND(J'.$row.'*6%,2)');
                    }
                    if($tax_percentage=='9'){
                        $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, '=ROUND(K'.$row.'*9%,2)');
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '=ROUND(K'.$row.'*9%,2)');
                    }
                }
                else
                {
                    $tax_percentage = $data[$i]->tax_percentage;
                    if($tax_percentage=='5')
                    { 
                      $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '=ROUND(I'.$row.'*5%,2)');
                    }
                    if($tax_percentage=='12'){
                        $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '=ROUND(J'.$row.'*12%,2)');
                    }
                    if($tax_percentage=='18'){
                        $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '=ROUND(K'.$row.'*18%,2)');
                    }
                    /*$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->igst_amt);*/
                }

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
                

                if($cgst_amt!=0)
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '=M'.$row.'+N'.$row.'+O'.$row); 
                }
                else
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $cgst_amt);
                }

                if($sgst_amt!=0)
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '=Q'.$row.'+R'.$row.'+S'.$row); 
                }
                else
                {
                  $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $sgst_amt);
                }
               

                if($igst_amt!=0)
                {
                     $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '=U'.$row.'+V'.$row.'+W'.$row);
                }
                else
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $igst_amt);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '=P'.$row.'+T'.$row.'+X'.$row);

                $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;

                /*'=L9+P9+T9+X9+Z9-AA9'*/
                $round_off_amt=round($round_off_amt,4);
                $invoice_amount = $objPHPExcel->getActiveSheet()->getCell('L'.$row)->getCalculatedValue();
                $cgst_amt =  $objPHPExcel->getActiveSheet()->getCell('P'.$row)->getCalculatedValue();
                $sgst_amt = $objPHPExcel->getActiveSheet()->getCell('T'.$row)->getCalculatedValue();
                $igst_amt = $objPHPExcel->getActiveSheet()->getCell('X'.$row)->getCalculatedValue();
                $invoice_total_amt = $objPHPExcel->getActiveSheet()->getCell('AA'.$row)->getCalculatedValue();
                $round_off_amt = $round_off_amt*-1;

                $formula = '';
                
                if(intval($invoice_total_amt)>=0)
                    $formula.='AA'.$row;
                else
                    $formula.=$invoice_total_amt;

                $formula .= '-(';

                if(intval($invoice_amount)>=0)
                    $formula.='+L'.$row;
                else
                    $formula.=$invoice_amount;

                if(intval($cgst_amt)>=0)
                    $formula.='+P'.$row;
                else
                    $formula.=$cgst_amt;

                if(intval($sgst_amt)>=0)
                    $formula.='+T'.$row;
                else
                    $formula.=$sgst_amt;

                if(intval($igst_amt)>=0)
                    $formula.='+X'.$row;
                else
                    $formula.=$igst_amt;

                $formula .= ')';
                /*if($round_off_amt>0)
                    $formula.='+'.$round_off_amt;
                else
                    $formula.=$round_off_amt;*/
                

                /*echo '<br>'.$formula;*/

                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row,'=ROUND('.$formula.',2)');

                /*$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $round_off_amt);*/

                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, round($data[$i]->final_amount));

                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->depot_name);

                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->distributor_name);

                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->distributor_type);

                /*$objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $data[$i]->dist_state);*/

                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->dist_state);

                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->dist_gst_no);

                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->dist_zone);

                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->area);

                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->distributor_city);

                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$i]->location);

                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->sales_rep_name);

                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->due_date);

                $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->order_no);

                $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->order_date);
            }

             $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $data[$i]->remarks);

             $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $data[$i]->sampleid);

            // $status = $data[$i]->status;

            // if($status=="InActive") {

            //     $status='Cancelled';

            // }

        }
    }

    if($invoicelevelsalesreturn!="") {

        $include=$include.'Sales Return, ';
        $data = $this->get_distributor_in_details($from_date, $to_date);    

        // echo $invoicelevelsalesreturn;
        // echo '<br>';
        // echo count($data);
        // echo '<br>';

        $pr_dist_id='';
        $pr_inv_no='';
        $pr_system_id='';

        for($i=0; $i<count($data); $i++) {

            $dist_id=$data[$i]->distributor_in_id;
            $inv_no=$data[$i]->sales_return_no;
            $system_id=$data[$i]->id;

            if($i==0){
                $pr_dist_id=$dist_id;
                $pr_inv_no=$inv_no;
                $pr_system_id=$system_id;
            }

            if($dist_id!=$pr_dist_id || $inv_no!=$pr_inv_no || $system_id!=$pr_system_id){
                $row=$row+1;
                $pr_dist_id=$dist_id;
                $pr_inv_no=$inv_no;
                $pr_system_id=$system_id;
            }

            // $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));
            // $mod_on=date("d-m-Y", strtotime($data[$i]->approved_on));

            $dop1=date("d-m-Y", strtotime($data[$i]->sales_return_date));
            $mod_on=date("d-m-Y", strtotime($data[$i]->sales_return_date));


            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $mod_on);

            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);

            if($data[$i]->distributor_type=="sample")
            {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'SAMPLE');
            }
            else
            {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'SALES RETURN');
            }

            // $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'SALES RETURN');

            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->sales_return_no);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '0');

            } else {
                $tax_per = $data[$i]->tax_percentage;
                if($tax_per=='5')
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->amt_exc_tax);
                }
                else if($tax_per=='12')
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->amt_exc_tax);
                }
                else if($tax_per=='18')
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->amt_exc_tax);
                }

                /*$objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->amount);*/

                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '=(I'.$row.'+J'.$row.'+K'.$row.')');

                if($data[$i]->cgst_amt!=0)
                {
                    $tax_percentage = $data[$i]->tax_percentage/2;
                    if($tax_percentage=='2.5')
                    {
                        
                        $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '=ROUND(I'.$row.'*2.5%,2)');
                        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '=ROUND(I'.$row.'*2.5%,2)');
                    }
                    if($tax_percentage=='6'){
                        $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '=ROUND(J'.$row.'*6%,2)');
                         $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '=ROUND(J'.$row.'*6%,2)');
                    }
                    if($tax_percentage=='9'){
                        $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, '=ROUND(K'.$row.'*9%,2)');
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '=ROUND(K'.$row.'*9%,2)');
                    }
                }
                else
                {
                    $tax_percentage = $data[$i]->tax_percentage;
                    if($tax_percentage=='5')
                    { 
                      $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '=ROUND(I'.$row.'*5%,2)');
                    }
                    if($tax_percentage=='12'){
                        $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '=ROUND(J'.$row.'*12%,2)');
                    }
                    if($tax_percentage=='18'){
                        $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '=ROUND(K'.$row.'*18%,2)');
                    }
                    /*$objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->igst_amt);*/
                }


                // $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->amount);

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
                
                if($cgst_amt!=0)
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, '=M'.$row.'+N'.$row.'+O'.$row); 
                }
                else
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $cgst_amt);
                }

                if($sgst_amt!=0)
                {
                   $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '=Q'.$row.'+R'.$row.'+S'.$row); 
                }
                else
                {
                  $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $sgst_amt);
                }
               

                if($igst_amt!=0)
                {
                     $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '=U'.$row.'+V'.$row.'+W'.$row);
                }
                else
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $igst_amt);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, '=P'.$row.'+T'.$row.'+X'.$row);

                $round_off_amt=round($data[$i]->final_amount)-$data[$i]->final_amount;
                /*$round_off_amt = -$round_off_amt;*/

                /*'=L9+P9+T9+X9+Z9-AA9'*/
                $round_off_amt=round($round_off_amt,4);
                $invoice_amount = $objPHPExcel->getActiveSheet()->getCell('L'.$row)->getCalculatedValue();
                $cgst_amt =  $objPHPExcel->getActiveSheet()->getCell('P'.$row)->getCalculatedValue();
                $sgst_amt = $objPHPExcel->getActiveSheet()->getCell('T'.$row)->getCalculatedValue();
                $igst_amt = $objPHPExcel->getActiveSheet()->getCell('X'.$row)->getCalculatedValue();
                $invoice_total_amt = $objPHPExcel->getActiveSheet()->getCell('AA'.$row)->getCalculatedValue();
                $round_off_amt = $round_off_amt*-1;
                $formula = '';
                if(intval($invoice_total_amt)>=0)
                        $formula.='AA'.$row;
                else
                    $formula.=$invoice_total_amt;

                $formula .= '-(';

                if(intval($invoice_amount)>=0)
                    $formula.='+L'.$row;
                else
                    $formula.=$invoice_amount;

                if(intval($cgst_amt)>=0)
                    $formula.='+P'.$row;
                else
                    $formula.=$cgst_amt;

                if(intval($sgst_amt)>=0)
                    $formula.='+T'.$row;
                else
                    $formula.=$sgst_amt;

                if(intval($igst_amt)>=0)
                    $formula.='+X'.$row;
                else
                    $formula.=$igst_amt;

                $formula .= ')';

                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row,'=ROUND('.$formula.',2)');

                /*$objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $round_off_amt);*/

                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, round($data[$i]->final_amount));

                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->depot_name);

                // $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->distributor_name);

                // if($data[$i]->distributor_id=='214' && intval($igst_amt)!=0) {
                //     $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, 'AMAZON DIRECT - OMS');
                // } else if($data[$i]->distributor_id=='1319' && intval($igst_amt)!=0) {
                //     $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, 'PAYTM DIRECT - OMS');
                // } else {
                //     $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->distributor_name);
                // }
                
                // if($data[$i]->order_no=='' || $data[$i]->order_no==null){
                //     $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->dist_state_code);

                //     $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->dist_state);
                // } else {
                //     $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->state_code);

                //     $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->state);
                // }
                
                if(strtoupper(trim($data[$i]->class))=='DIRECT') {
                    if($data[$i]->state_code==$data[$i]->depot_state_code) {
                        $distributor_name = $data[$i]->prefix.' Direct-Local';
                    } else {
                        $distributor_name = $data[$i]->prefix.' OOS-'.$data[$i]->state_code.'_'.$data[$i]->state;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->state_code);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->state);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->dist_state_code);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->dist_state);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->distributor_type);

                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->dist_gst_no);

                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->dist_zone);

                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->area);

                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->distributor_city);

                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$i]->location);

                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->sales_rep_name);

               $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '');

               $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->order_no);

               $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $data[$i]->remarks);

            $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $data[$i]->srid);

            // $status = $data[$i]->status;

            // if($status=="InActive") {

            //     $status='Cancelled';

            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AR'.$row, $status);
            
        }
    }

    // $row=$row-1;

    // $include=substr($include, 0, strlen($include)-2);

    // $objPHPExcel->getActiveSheet()->setCellValue('B5', $include);



    $objPHPExcel->getActiveSheet()->getStyle('A8:AS8')->getFont()->setBold(true);

    

    $objPHPExcel->getActiveSheet()->getStyle('A8'.':AS'.$row)->applyFromArray(array(

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
    // $path  = 'C:/xampp/htdocs/eat_erp/assets/uploads/excel_upload/';
    // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/excel_upload/';
    // $path  = '/var/www/html/eat_erp/assets/uploads/excel_upload/';
    // $path  = '/home/eatangcp/public_html/test/assets/uploads/excel_upload/';

    $path = $this->config->item('upload_path').'excel_upload/';

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
    $cond2 = '';

    if ($status=="Approved"){
        $cond=" where status='Approved' and (distributor_id!='1' and distributor_id!='189')";
        $cond2=" and A.status='Approved' and (A.distributor_id!='1' and A.distributor_id!='189')";
    } else if ($status=="pending"){
        $cond=" where ((status='Pending' and (delivery_status is null or delivery_status = '')) or status='Rejected') and (distributor_id!='1' and distributor_id!='189')";
        $cond2=" and ((A.status='Pending' and (A.delivery_status is null or A.delivery_status = ''))) and (A.distributor_id!='1' and A.distributor_id!='189')";
    } else if ($status=="pending_for_approval"){
        $cond=" where ((status='Pending' and (delivery_status='Pending' or delivery_status='GP Issued' or delivery_status='Delivered Not Complete' or delivery_status='Delivered')) or status='Deleted') and (distributor_id!='1' and distributor_id!='189')";
        $cond2=" and ((A.status='Pending' and (A.delivery_status='Pending' or A.delivery_status='GP Issued' or A.delivery_status='Delivered Not Complete' or A.delivery_status='Delivered')) or A.status='Deleted') and (A.distributor_id!='1' and A.distributor_id!='189')";
    } else if ($status=="pending_for_delivery"){
        $cond=" where status='Approved' and delivery_status='Pending' and (distributor_id!='1' and distributor_id!='189')";
        $cond2=" and A.status='Approved' and A.delivery_status='Pending' and (A.distributor_id!='1' and A.distributor_id!='189')";
    } else if ($status=="gp_issued"){
        $cond=" where status='Approved' and delivery_status='GP Issued' and (distributor_id!='1' and distributor_id!='189')";
        $cond2=" and A.status='Approved' and A.delivery_status='GP Issued' and (A.distributor_id!='1' and A.distributor_id!='189')";
        // $cond2 =  " and (A.status='Approved')";
    } else if ($status=="delivered_not_complete"){
        $cond=" where status='Approved' and delivery_status='Delivered Not Complete' and 
                        (distributor_id!='1' and distributor_id!='189')";
        $cond2=" and A.status='Approved' and A.delivery_status='Delivered Not Complete' and 
                        (A.distributor_id!='1' and A.distributor_id!='189')";
        // $cond2 =  " and (A.status='Approved')";
    } else if ($status!="") {
        $cond=" where status='".$status."' and (distributor_id!='1' and distributor_id!='189')";
        $cond2=" and A.status='".$status."' and (A.distributor_id!='1' and A.distributor_id!='189')";
        // $cond2 =  " and (A.status='".$status."')";
    } else {
        $cond="";
    }

    $ddateofprocess="";

    // if( $date_of_processing != '' && $date_of_accounting=='') {
    //     $ddateofprocess = "A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' ";
    // } else {
    //     $ddateofprocess = "A.invoice_date>='$from_date' and A.invoice_date<='$to_date' ";
    // }

    $ddateofprocess = " date(A.invoice_date)>='2019-04-01' and date(A.invoice_date)>='$from_date' and date(A.invoice_date)<='$to_date' ";


    
    // if($status=='')
    // {
    //     $cond2 =  " and (A.status='Approved') ";
    // }
    
    $sql = "select * from 

            (select AA.*, WEEK(invoice_date,1)-WEEK(STR_TO_DATE(concat(YEAR(invoice_date),'-',MONTH(invoice_date),'-',1),'%Y-%m-%d'),1)+1 as dweek, 

                BB.item_name, BB.quantity, BB.short_name, CC.category_name from 

            (select A.*,A.id as saleid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

                B.cgst_amt, B.sgst_amt, B.igst_amt, B.tax_amt, B.total_amt, 

                C.depot_name, C.state as depot_state, C.state_code as depot_state_code, 

                D.distributor_name, D.sell_out, D.type_id, D.location_id,D.area_id,D.zone_id,

                D.city as distributor_city, D.class, D.state as dist_state, 

                D.state_code as dist_state_code, D.gst_number as dist_gst_no, D.prefix, 

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

            where ".$ddateofprocess." ".$cond2.") AA 

            left join 

            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name, category_id from product_master 

                where status='Approved' 

            union all 

            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name, m.category_id 

            from box_master m left join box_product p on m.id=p.box_id 

            where m.status='Approved' group by m.id) BB 

            on (AA.item_id=BB.id and AA.type=BB.type) 
            
            left join 
            
            category_master CC on (BB.category_id=CC.id) 

            where AA.class!='sample' or AA.class is null) DD 
            
            ".$cond."
            
            order by invoice_date,invoice_no";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;
}

function get_distributor_sale_sku_details($from_date, $to_date) {
    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek, BB.item_name, BB.quantity, BB.short_name, CC.category_name from 
            (select A.*, A.id as ssid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 
                D.distributor_name, D.sell_out, D.type_id, D.location_id as locationid, D.area_id, D.zone_id as zoneid, 
                D.city as distributor_city, D.class, D.state as dist_state, D.state_code as dist_state_code, 
                D.gst_number as dist_gst_no, E.distributor_type, G.location, O.store_name as m_distributor_name, 
                l.location as m_distributor_location, F.sales_rep_name, K.zone, I.area, M.store_id as storeid, 
                O.store_name, Q.distributor_type as d_type,P.zone as d_zone,S.sales_rep_name as reporting_manager, 
                T.sales_rep_name as salesrepname, T.sales_rep_name as sales1, 
                U.sales_rep_name as salesrepname1, U.sales_rep_name as sales2 
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
                left join sales_rep_master S on(R.reporting_manager_id=S.id) 
                left join sales_rep_master T on(R.sales_rep_id1=T.id) 
                left join sales_rep_master U on(R.sales_rep_id2=T.id) 
            where A.status='Approved' and A.date_of_processing>='2019-04-01' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date') AA 

            left join 

            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name, category_id from product_master where status='Approved' 
            union all 
            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name, m.category_id 
            from box_master m left join box_product p on m.id=p.box_id 
            where m.status='Approved' group by m.id) BB 
            on (AA.item_id=BB.id and AA.type=BB.type) 
            left join 
            category_master CC on (BB.category_id=CC.id)";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function get_distributor_sale_sku_details_positive($from_date, $to_date) {
    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek, BB.item_name, BB.quantity, BB.short_name, CC.category_name from 
            (select A.*, A.id as ssid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 
                D.distributor_name, D.sell_out, D.type_id, D.location_id as locationid, D.area_id,D.zone_id as zoneid, 
                D.city as distributor_city, D.class, D.state as dist_state, D.state_code as dist_state_code, 
                D.gst_number as dist_gst_no, E.distributor_type, G.location, O.store_name as m_distributor_name, 
                l.location as m_distributor_location, F.sales_rep_name, K.zone, I.area, M.store_id as storeid, 
                O.store_name, Q.distributor_type as d_type, P.zone as d_zone, S.sales_rep_name as reporting_manager, 
                T.sales_rep_name as salesrepname, T.sales_rep_name as sales1, 
                U.sales_rep_name as salesrepname1, U.sales_rep_name as sales2 
                from distributor_sale A 
                left join distributor_sale_items B on(A.id=B.distributor_sale_id) 
                left join distributor_master D on(A.distributor_id=D.id) 
                left join distributor_type_master E on(D.type_id=E.id) 
                left join location_master G on(D.location_id=G.id) 
                left join area_master I on(D.area_id=I.id) 
                left join zone_master K on(D.zone_id=K.id) 
                left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id) 
                left join sales_rep_master F on( J.reporting_manager_id=F.id) 
                left join relationship_master O on(A.store_id=O.id) 
                left join store_master M on(O.id=M.store_id and M.type_id='7' and A.zone_id=M.zone_id and A.location_id=M.location_id) 
                left join zone_master P on(A.zone_id=P.id) 
                left join distributor_type_master Q on(O.type_id=Q.id) 
                left join location_master l on(A.location_id=l.id) 
                left join sr_mapping R on(M.store_id=R.area_id1 and M.type_id=R.type_id and M.zone_id=R.zone_id and M.location_id=R.location_id) 
                left join sales_rep_master S on( R.reporting_manager_id=S.id) 
                left join sales_rep_master T on(R.sales_rep_id1=T.id) 
                left join sales_rep_master U on(R.sales_rep_id2=T.id) 
            where A.status='Approved' and A.date_of_processing>='2019-04-01' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date') AA 
            left join 
            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name, category_id from product_master where status='Approved' 
            union all 
            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name, m.category_id 
            from box_master m left join box_product p on m.id=p.box_id 
            where m.status='Approved' group by m.id) BB 
            on (AA.item_id=BB.id and AA.type=BB.type) 
            left join 
            category_master CC on (BB.category_id=CC.id)";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function get_distributor_transfer_sku_details($from_date, $to_date) {
    $sql = "select * from 
            (select AA.*, WEEK(date_of_transfer,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_transfer),'-',MONTH(date_of_transfer),'-',1),'%Y-%m-%d'),1)+1 as dweek, 
                BB.item_name, BB.quantity, BB.short_name, CC.category_name from 
            (select A.*, A.id as transferid, B.type, B.item_id, B.qty, null as sell_rate, null as grams, 
                null as rate, null as amount, null as item_amount, null as cgst_amt, null as sgst_amt, 
                null as igst_amt, null as tax_amt, null as total_amt, D.distributor_name, D.sell_out, D.type_id, 
                D.location_id, D.area_id, D.zone_id, D.city as distributor_city, D.class, D.state as dist_state, 
                D.state_code as dist_state_code, D.gst_number as dist_gst_no, E.distributor_type, F.sales_rep_name, 
                G.location, H.area, K.zone, L.sales_rep_name as salesrepname, M.sales_rep_name as salesrepname1 
            from distributor_transfer A 
                left join distributor_transfer_items B on(A.id=B.distributor_transfer_id) 
                left join distributor_master D on(A.distributor_out_id=D.id) 
                left join distributor_type_master E on(D.type_id=E.id) 
                left join location_master G on(D.location_id=G.id) 
                left join zone_master K on(D.zone_id=K.id) 
                left join area_master H on(D.area_id=H.id) 
                left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id) 
                left join sales_rep_master F on(J.reporting_manager_id=F.id) 
                left join sales_rep_master L on(J.sales_rep_id1=L.id) 
                left join sales_rep_master M on(J.sales_rep_id2=M.id) 
            where A.status='Approved' and A.date_of_transfer>='2019-04-01' and A.date_of_transfer>='$from_date' and A.date_of_transfer<='$to_date') AA 
            left join 
            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name, category_id from product_master 
                where status='Approved' 
            union all 
            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name, m.category_id 
            from box_master m left join box_product p on m.id=p.box_id 
            where m.status='Approved' group by m.id) BB 
            on (AA.item_id=BB.id and AA.type=BB.type) 
            left join 
            category_master CC on (BB.category_id=CC.id) 
            where AA.class!='sample' or AA.class is null) DD 
            order by date_of_transfer";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function get_distributor_transfer_sku_details_positive($from_date, $to_date) {
    $sql = "select * from 
            (select AA.*, WEEK(date_of_transfer,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_transfer),'-',MONTH(date_of_transfer),'-',1),'%Y-%m-%d'),1)+1 as dweek, 
                BB.item_name, BB.quantity, BB.short_name, CC.category_name from 
            (select A.*, A.id as transferid, B.type, B.item_id, B.qty, null as sell_rate, null as grams, 
                null as rate, null as amount, null as item_amount, null as cgst_amt, null as sgst_amt, 
                null as igst_amt, null as tax_amt, null as total_amt, 
                D.distributor_name, D.sell_out, D.type_id, D.location_id, D.area_id, D.zone_id, 
                D.city as distributor_city, D.class, D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, 
                E.distributor_type, F.sales_rep_name, G.location, H.area, K.zone, L.sales_rep_name as salesrepname, M.sales_rep_name as salesrepname1 
            from distributor_transfer A 
                left join distributor_transfer_items B on(A.id=B.distributor_transfer_id) 
                left join distributor_master D on(A.distributor_in_id=D.id) 
                left join distributor_type_master E on(D.type_id=E.id) 
                left join location_master G on(D.location_id=G.id) 
                left join zone_master K on(D.zone_id=K.id) 
                left join area_master H on(D.area_id=H.id) 
                left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id) 
                left join sales_rep_master F on(J.reporting_manager_id=F.id) 
                left join sales_rep_master L on(J.sales_rep_id1=L.id) 
                left join sales_rep_master M on(J.sales_rep_id2=M.id) 
            where A.status='Approved' and A.date_of_transfer>='2019-04-01' and A.date_of_transfer>='$from_date' and A.date_of_transfer<='$to_date') AA 
            left join 
            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name, category_id from product_master 
                where status='Approved' 
            union all 
            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name, m.category_id 
            from box_master m left join box_product p on m.id=p.box_id 
            where m.status='Approved' group by m.id) BB 
            on (AA.item_id=BB.id and AA.type=BB.type) 
            left join 
            category_master CC on (BB.category_id=CC.id) 
            where AA.class!='sample' or AA.class is null) CC 
            order by date_of_transfer";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function generate_sale_invoice_sku_report($sales,$ssallocation,$salesreturn,$sample,$credit_debit='',$status_type='',$date_of_processing='',$date_of_accounting='',$flag='',$dist_transfer='') {
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
    // $row=58971;
    $template_path=$this->config->item('template_path');
	// $date = date('Y-m-d H:i:s');
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

    // ini_set('memory_limit', '2000M');
    // ini_set('max_execution_time', 0);

    if($sales!="") {
        $include=$include.'Sales, ';

        $data = $this->get_distributor_out_sku_details($from_date, $to_date, 'Approved', $date_of_processing, $date_of_accounting);

        if(count($data)>0) {
            for($i=0; $i<count($data); $i++) {
                // $dop=date("d-m-Y", strtotime($data[$i]->date_of_processing));
                $dop=date("d-m-Y", strtotime($data[$i]->invoice_date));
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
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->category_name);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $data[$i]->qty);
                $quantity=$data[$i]->quantity;
				$distributor_name=$data[$i]->distributor_name;
                $barquantity=0;
                if($data[$i]->quantity==null) {
                    $barquantity=1*$data[$i]->qty;
                } else {
                    $barquantity=$data[$i]->quantity*$data[$i]->qty;
                }

                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $barquantity);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->rate);
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->sell_rate);

                $status = $data[$i]->status;
                if($status=="InActive") {
                    $status='Cancelled';
                }
                if($status=='Cancelled') {
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $data[$i]->item_amount);

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
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $cgst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $sgst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $igst_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $tax_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$i]->total_amt);
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->depot_name);

                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->distributor_type);

                    // if($data[$i]->distributor_id=='214' && $igst_amt!=0) {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, 'AMAZON DIRECT - OMS');
                    // } else if($data[$i]->distributor_id=='1319' && $igst_amt!=0) {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, 'PAYTM DIRECT - OMS');
                    // } else {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_name);
                    // }

                    // if(strtoupper(trim($distributor_name))=='DIRECT' || strtoupper(trim($distributor_name))=='AMAZON DIRECT' || strtoupper(trim($distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($distributor_name))=='NYKAA DIRECT' || strtoupper(trim($distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($distributor_name))=='1MG TECHNOLOGIES PRIVATE LIMITED' || strtoupper(trim($distributor_name))=='PAYTM DIRECT' || strtoupper(trim($distributor_name))=='UNFACTORY DIRECT' || strtoupper(trim($distributor_name))=='EMBRACE DIRECT' || strtoupper(trim($distributor_name))=='NEULIFE DIRECT' || strtoupper(trim($distributor_name))=='FLIPKART DIRECT' || strtoupper(trim($distributor_name))=='GOQII DIRECT')
                    // {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->state_code);
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->state);
                    // }
                    // else
                    // {
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                    //     $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                    // }
                    // $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);

                    if(strtoupper(trim($data[$i]->class))=='DIRECT') {
                        if($data[$i]->state_code==$data[$i]->depot_state_code) {
                            $distributor_name = $data[$i]->prefix.' Direct-Local';
                        } else {
                            $distributor_name = $data[$i]->prefix.' OOS-'.$data[$i]->state_code.'_'.$data[$i]->state;
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $distributor_name);
                        $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->state_code);
                        $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->state);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_name);
                        $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                        $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);
                    }

                    if($data[$i]->shipping_address == 'no'){
                        $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->con_state_code);
                        $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->con_state);
                        $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->con_gst_number);
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->zone);
                    $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->area);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->distributor_city);
                    $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->location);
                    $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->sales_rep_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname);
                    $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->salesrepname1);
                    $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$i]->due_date);
                    $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->order_no);
                    $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->order_date);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->remarks);
                $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->saleid);

                // $status = $data[$i]->status;
                // if($status=="InActive") {
                //     $status='Cancelled';
                // }

                $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $status);

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

                    $objPHPExcel->getActiveSheet()->setCellValue('V'.($row-1), $data[$i]->round_off_amount);
                    $rounding_amt=$data[$i]->round_off_amount;
                    $cstamt=$rounding_amt+$cstamt;
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.($row-1), $cstamt);

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
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop3);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $mod_on1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->category_name);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, floatval($data[$i]->qty)*-1);

            $quantity=$data[$i]->quantity;
            $barquantity=0;
            if($data[$i]->quantity==null) {
                $barquantity=1*$data[$i]->qty;
            } else {
                $barquantity=$data[$i]->quantity*$data[$i]->qty;    
            }

            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, floatval($barquantity)*-1);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->sell_rate);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, floatval($data[$i]->item_amount)*-1);

                // $tax=($data[$i]->tax_per/100)*($data[$i]->item_amount);
                // $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $tax);
                // $cstamt=$tax+$data[$i]->item_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, floatval($data[$i]->item_amount)*-1);
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_name);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->distributor_type);
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->area);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->salesrepname1);
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->ssid);
                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->ssid);

            $status = $data[$i]->status;

            // if($status=="InActive") {

            //     $status='Cancelled';

            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $status);

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
        $data = $this->get_distributor_sale_sku_details_positive($from_date, $to_date);
        for($k=0; $k<count($data); $k++){
            $dop1=date("d-m-Y", strtotime($data[$k]->date_of_processing));
            $mod_on1=date("d-m-Y", strtotime($data[$k]->modified_on));
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $mod_on1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$k]->dweek);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$k]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$k]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$k]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$k]->category_name);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $data[$k]->qty);

            $quantity=$data[$k]->quantity;
            $barquantity=0;
            if($data[$k]->quantity==null) {
                $barquantity=1*$data[$k]->qty;
            } else {
                $barquantity=$data[$k]->quantity*$data[$k]->qty;
            }

            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $barquantity);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$k]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$k]->sell_rate);

            
            $status = $data[$k]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $data[$k]->item_amount);

                // $tax=($data[$k]->tax_per/100)*($data[$k]->item_amount);
                // $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $tax);
                // $cstamt=$tax+$data[$k]->item_amount;

				$objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $data[$k]->item_amount);
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$k]->store_name);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$k]->d_type);
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$k]->d_zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$k]->store_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$k]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$k]->m_distributor_location);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$k]->reporting_manager);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$k]->sales1);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$k]->sales2);
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$k]->ssid);
                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$k]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$k]->ssid);

            $status = $data[$k]->status;
            // if($status=="InActive") {
            //     $status='Cancelled';
            // }
            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $status);

            $row=$row+1;
        }
        // }
    }

    if($dist_transfer!="") {
        $include=$include.'Distributor Transfer, ';
        $data = $this->get_distributor_transfer_sku_details($from_date, $to_date);
        
        $j = 0;
        $prv_dist_id = '';
        $new_dist_id = '';
        $countt=0;

        for($i=0; $i<count($data); $i++) {
            $new_dist_id = $data[$i]->distributor_out_id;
            if($prv_dist_id != $new_dist_id){
                $j = $i;
                $prv_dist_id = $new_dist_id;
            }

            $dop3=date("d-m-Y", strtotime($data[$i]->date_of_transfer));
            $mod_on1=date("d-m-Y", strtotime($data[$i]->modified_on));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop3);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $mod_on1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, "TRANSFER");
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->category_name);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, floatval($data[$i]->qty)*-1);

            $quantity=$data[$i]->quantity;
            $barquantity=0;
            if($data[$i]->quantity==null) {
                $barquantity=1*$data[$i]->qty;
            } else {
                $barquantity=$data[$i]->quantity*$data[$i]->qty;    
            }

            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, floatval($barquantity)*-1);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->sell_rate);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, floatval($data[$i]->item_amount)*-1);

                // $tax=($data[$i]->tax_per/100)*($data[$i]->item_amount);
                // $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $tax);
                // $cstamt=$tax+$data[$i]->item_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, floatval($data[$i]->item_amount)*-1);
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_name);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->distributor_type);
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->area);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->salesrepname1);
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->transferid);
                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->transferid);

            $status = $data[$i]->status;

            // if($status=="InActive") {

            //     $status='Cancelled';

            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $status);

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
        }


        $data = $this->get_distributor_transfer_sku_details_positive($from_date, $to_date);
        for($i=0; $i<count($data); $i++) {
            $new_dist_id = $data[$i]->distributor_out_id;
            if($prv_dist_id != $new_dist_id){
                $j = $i;
                $prv_dist_id = $new_dist_id;
            }

            $dop3=date("d-m-Y", strtotime($data[$i]->date_of_transfer));
            $mod_on1=date("d-m-Y", strtotime($data[$i]->modified_on));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop3);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $mod_on1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, "SSALLOCATION");
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, "TRANSFER");
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->category_name);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, floatval($data[$i]->qty));

            $quantity=$data[$i]->quantity;
            $barquantity=0;
            if($data[$i]->quantity==null) {
                $barquantity=1*$data[$i]->qty;
            } else {
                $barquantity=$data[$i]->quantity*$data[$i]->qty;    
            }

            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, floatval($barquantity));
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->sell_rate);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, floatval($data[$i]->item_amount));

                // $tax=($data[$i]->tax_per/100)*($data[$i]->item_amount);
                // $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $tax);
                // $cstamt=$tax+$data[$i]->item_amount;

                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, floatval($data[$i]->item_amount));
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_name);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->distributor_type);
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->area);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->salesrepname1);
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->transferid);
                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->transferid);

            $status = $data[$i]->status;

            // if($status=="InActive") {

            //     $status='Cancelled';

            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $status);
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
        }
    }

    if($sample!="") {
        $include=$include.'Sample & Product Expired, ';
        $data = $this->get_sample_expired_SKU_details($from_date, $to_date,$date_of_processing, $date_of_accounting);

        for($i=0; $i<count($data); $i++) {
            // $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));
            // $mod_on2=date("d-m-Y", strtotime($data[$i]->approved_on));

            $dop1=date("d-m-Y", strtotime($data[$i]->invoice_date));
            $mod_on2=date("d-m-Y", strtotime($data[$i]->invoice_date));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $mod_on2);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
            
            if(strtoupper(trim($data[$i]->dname))=='PRODUCT EXPIRED') {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'PRODUCT EXPIRED');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, strtoupper($data[$i]->distributor_name));
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->voucher_no);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->category_name);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $data[$i]->qty);
            $quantity=$data[$i]->quantity;

            $barquantity=0;
            if($data[$i]->quantity==null) {
                $barquantity=1*$data[$i]->qty;
            } else {
                $barquantity=$data[$i]->quantity*$data[$i]->qty;
            }

            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, $barquantity);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->sell_rate);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $data[$i]->item_amount);
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
                
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $cgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $sgst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $igst_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $tax_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $total_amt);
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->depot_name);
                $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->dname);
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->distributor_type);
                $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);
                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->area);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->salesrepname1);
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, $data[$i]->due_date);
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->sample_type);
                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, $data[$i]->order_date);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->remarks);

            if($data[$i]->distributor_id=='1') {
                $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->sampleid);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->distributor_in_id);
            }
            

            $status = $data[$i]->status;
            // if($status=="InActive") {
            //     $status='Cancelled';
            // }
            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $status);

            $row=$row+1;
        }
    }

    if($salesreturn!="") {
        $include=$include.'Sales Return, ';

        $data = $this->get_distributor_in_sku_details($from_date, $to_date);
        for($i=0; $i<count($data); $i++) {
            // $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));
            // $mod_on3=date("d-m-Y", strtotime($data[$i]->modified_on));

            $dop1=date("d-m-Y", strtotime($data[$i]->date_of_processing));
            $mod_on3=date("d-m-Y", strtotime($data[$i]->date_of_processing));

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '=TEXT(D'.$row.',"mmmm")');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '=CONCATENATE("Q"&ROUNDUP(MONTH(D'.$row.')/3,0))');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, '=YEAR(D'.$row.')');
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $mod_on3);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop1);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
			if($data[$i]->distributor_type=="Sample")
			{
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'SAMPLE');
			}
			else
			{
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, 'SALES RETURN');
			}
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->sales_return_no);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $data[$i]->short_name);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $data[$i]->category_name);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, floatval($data[$i]->qty)*-1);

            $quantity=$data[$i]->quantity;
            $barquantity=0;
            if($data[$i]->quantity==null) {
                $barquantity=1*$data[$i]->qty;
            } else {
                $barquantity=$data[$i]->quantity*$data[$i]->qty;
            }

            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, floatval($barquantity)*-1);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, $data[$i]->rate);
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $data[$i]->sell_rate);

            $status = $data[$i]->status;
            if($status=="InActive") {
                $status='Cancelled';
            }
            if($status=='Cancelled') {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, floatval($data[$i]->item_amount)*-1);
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
                
                $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, floatval($cgst_amt)*-1);
                $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, floatval($sgst_amt)*-1);
                $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, floatval($igst_amt)*-1);
                $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, floatval($tax_amt)*-1);
                if($round_off_amount<0){
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $round_off_amount);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, floatval($round_off_amount)*-1);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, floatval($total_amt)*-1);
                $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->depot_name);
                // $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, $data[$i]->distributor_name);
            
                $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->distributor_type);

                // if($data[$i]->distributor_id=='214' && $igst_amt!=0) {
                //     $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, 'AMAZON DIRECT - OMS');
                // } else if($data[$i]->distributor_id=='1319' && $igst_amt!=0) {
                //     $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, 'PAYTM DIRECT - OMS');
                // } else {
                //     $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_name);
                // }
                
                // $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                // $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                // $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);


                if(strtoupper(trim($data[$i]->class))=='DIRECT') {
                    if($data[$i]->state_code==$data[$i]->depot_state_code) {
                        $distributor_name = $data[$i]->prefix.' Direct-Local';
                    } else {
                        $distributor_name = $data[$i]->prefix.' OOS-'.$data[$i]->state_code.'_'.$data[$i]->state;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->state_code);
                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->state);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);
                }

                $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->zone);
                $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->area);
                $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->distributor_city);
                $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->location);
                $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->sales_rep_name);
                $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->salesrepname1);
                $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, $data[$i]->order_no);
                $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '');
            }

            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->remarks);
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, $data[$i]->srid);

            // $status = $data[$i]->status;
            // if($status=="InActive") {
            //     $status='Cancelled';
            // }

            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $status);

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
				$total_amt=$round_off_amt+$cstamt+$tax_amt;
                $round_off_amount = round($total_amt,0) - $total_amt;
                $total_amt=$round_off_amt+$total_amt;
                if($round_off_amount<0){
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.($row-1), $round_off_amount);
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.($row-1), floatval($round_off_amount)*-1);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('W'.($row-1), floatval($total_amt)*-1);



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
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dop);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dop1);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $data[$i]->dweek);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, strtoupper($data[$i]->transaction));
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $data[$i]->ref_no);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, '');

                // $quantity=$data[$i]->quantity;

                $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$row, '');
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,'');

                $status = $data[$i]->status;
                if($status=="InActive") {
                    $status='Cancelled';
                }
                if($status=='Cancelled') {
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, '0');
                    $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, '0');
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

				    if ($data[$i]->transaction=='Credit Note' || $data[$i]->transaction=='Expense Voucher') {
                        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, floatval($amount_without_tax)*-1);
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, floatval($cgst)*-1);
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, floatval($sgst)*-1);
                        $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, floatval($igst)*-1);
                        $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, floatval($totaltax)*-1);
                        if($round_off_amount<0){
                            $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $round_off_amount);
                        } else {
                            $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, floatval($round_off_amount)*-1);
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, floatval($amount)*-1);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $amount_without_tax);
                        $objPHPExcel->getActiveSheet()->setCellValue('R'.$row, $cgst);
                        $objPHPExcel->getActiveSheet()->setCellValue('S'.$row, $sgst);
                        $objPHPExcel->getActiveSheet()->setCellValue('T'.$row, $igst);
                        $objPHPExcel->getActiveSheet()->setCellValue('U'.$row, $totaltax);
                        $objPHPExcel->getActiveSheet()->setCellValue('V'.$row, $round_off_amount);
                        $objPHPExcel->getActiveSheet()->setCellValue('W'.$row, $amount);
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$row, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$row, $data[$i]->distributor_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('Z'.$row, $data[$i]->distributor_type);
                    $objPHPExcel->getActiveSheet()->setCellValue('AA'.$row, $data[$i]->dist_state_code);
                    $objPHPExcel->getActiveSheet()->setCellValue('AB'.$row, $data[$i]->dist_state);
                    $objPHPExcel->getActiveSheet()->setCellValue('AC'.$row, $data[$i]->dist_gst_no);
                    $objPHPExcel->getActiveSheet()->setCellValue('AD'.$row, $data[$i]->zone);
                    $objPHPExcel->getActiveSheet()->setCellValue('AE'.$row, $data[$i]->area);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF'.$row, $data[$i]->distributor_city);
                    $objPHPExcel->getActiveSheet()->setCellValue('AG'.$row, $data[$i]->location);
                    $objPHPExcel->getActiveSheet()->setCellValue('AH'.$row, $data[$i]->sales_rep_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('AI'.$row, $data[$i]->salesrepname);
                    $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$row, $data[$i]->salesrepname1);
                    $objPHPExcel->getActiveSheet()->setCellValue('AK'.$row, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('AL'.$row, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('AM'.$row, '');
                }

                $objPHPExcel->getActiveSheet()->setCellValue('AN'.$row, $data[$i]->remarks);
                $objPHPExcel->getActiveSheet()->setCellValue('AO'.$row, '');

                // $status = $data[$i]->status;
                // if($status=="InActive") {
                //     $status='Cancelled';
                // }

                $objPHPExcel->getActiveSheet()->setCellValue('AP'.$row, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$row, $data[$i]->category);

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

    if($date_of_processing=="") {
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setVisible(false);
    } else if($date_of_accounting=="") {
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false);
    } else {
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setVisible(true);
    }
	
    $row=$row-1;

    $include=substr($include, 0, strlen($include)-2);

    $objPHPExcel->getActiveSheet()->setCellValue('B5', $include);



    $objPHPExcel->getActiveSheet()->getStyle('A10:AQ10')->getFont()->setBold(true);


    for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
        if($col!=1){
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
    }


    $objPHPExcel->getActiveSheet()->getStyle('A10'.':AQ'.$row)->applyFromArray(array(

        'borders' => array(

            'allborders' => array(

                'style' => PHPExcel_Style_Border::BORDER_THIN

            )

        )

    ));
		$date1 = date('d-m-Y_H-i-A');
        $filename='Sale_Invoice_Sku_Report_'.$date1.'.xls';


    // $path  = 'C:/wamp64/www/eat_erp_test/assets/uploads/excel_upload/';
    // $path  = '/home/eatangcp/public_html/test/assets/uploads/excel_upload/';
    // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/excel_upload/';
    // $path  = '/var/www/html/eat_erp/assets/uploads/excel_upload/';
    $path = $this->config->item('upload_path').'excel_upload/';

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

    if($from_date!='' && $to_date!='') {
        // if( $date_of_processing != '' && $date_of_accounting=='') {
        //     $ddateofprocess = " and A.date_of_transaction>='$from_date' and A.date_of_transaction<='$to_date' ";
        // } else {
        //     $ddateofprocess = " and A.approved_on>='$from_date' and A.approved_on<='$to_date' ";
        // }

        $ddateofprocess = " and date(A.date_of_transaction)>='2019-04-01' and date(A.date_of_transaction)>='$from_date' and date(A.date_of_transaction)<='$to_date' ";
    }
    

    $sql = "select AA.*, WEEK(date_of_transaction,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_transaction),'-',MONTH(date_of_transaction),'-',1),'%Y-%m-%d'),1)+1 as dweek from 
            (select A.id, A.date_of_transaction, A.distributor_id, A.transaction, A.amount_without_tax, A.amount, A.tax, 
                A.igst, A.cgst, A.sgst, A.status, A.remarks, A.created_by, A.created_on, A.modified_by, A.modified_on, 
                A.approved_by, A.approved_on, A.rejected_by, A.rejected_on, A.ref_id, A.ref_no, A.ref_date, B.category, 
                D.distributor_name, D.sell_out, D.type_id, D.location_id, D.city as distributor_city, 
                D.class, D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, 
                D.area_id,D.zone_id,K.zone,E.distributor_type, F.sales_rep_name, G.location, H.area, 
                (Select sales_rep_name from sales_rep_master where id=J.sales_rep_id1) as salesrepname, 
                (Select sales_rep_name from sales_rep_master where id=J.sales_rep_id2) as salesrepname1 
            from credit_debit_note A 
                left join exp_cat_master B on(A.exp_category_id=B.id) 
                left join distributor_master D on(A.distributor_id=D.id) 
                left join distributor_type_master E on(D.type_id=E.id) 
                left join location_master G on(D.location_id=G.id) 
                left join area_master H on(D.area_id=H.id) 
                left join zone_master K on(D.zone_id=K.id) 
				left join sr_mapping J on(D.area_id=J.area_id and D.type_id=J.type_id and D.zone_id=J.zone_id) 
				left join sales_rep_master F on(J.reporting_manager_id=F.id) 
            where (A.status='Approved' ) ".$ddateofprocess.") AA ";

    $query=$this->db->query($sql);

    $result=$query->result();

    return $result;
}

function get_sample_expired_SKU_details($from_date, $to_date,$date_of_processing, $date_of_accounting) {

    $ddateofprocess="";

    // if($date_of_processing != '' && $date_of_accounting=='') {
    //     $ddateofprocess = "A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' ";
    // } else {
    //     $ddateofprocess = "date(A.approved_on)>='$from_date' and date(A.approved_on)<='$to_date' ";
    // }

    $ddateofprocess = " date(A.invoice_date)>='2019-04-01' and date(A.invoice_date)>='$from_date' and date(A.invoice_date)<='$to_date' ";

    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek, 

                BB.item_name, BB.quantity, BB.short_name, CC.category_name from 

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

            where (A.status='Approved') and ".$ddateofprocess." and (A.distributor_id='1' or A.distributor_id='189')) AA 

            left join 

            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name, category_id 

            from product_master where status='Approved' 

            union all 

            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name, m.category_id 

            from box_master m left join box_product p on m.id=p.box_id 

            where m.status='Approved' group by m.id) BB 

            on (AA.item_id=BB.id and AA.type=BB.type) 
            
            left join 
            
            category_master CC on (BB.category_id=CC.id)";

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
    $sql = "select AA.*, WEEK(date_of_processing,1)-WEEK(STR_TO_DATE(concat(YEAR(date_of_processing),'-',MONTH(date_of_processing),'-',1),'%Y-%m-%d'),1)+1 as dweek, 

                BB.item_name, BB.quantity, BB.short_name, CC.state, CC.state_code, DD.category_name  from 

            (select A.*, A.id as srid, B.type, B.item_id, B.qty, B.sell_rate, B.grams, B.rate, B.amount as item_amount, 

                B.cgst_amt, B.sgst_amt, B.igst_amt, B.tax_amt, B.total_amt, 

                C.depot_name, C.state as depot_state, C.state_code as depot_state_code, 

                D.distributor_name, K.zone, D.sell_out, D.type_id, D.location_id, D.area_id, D.zone_id, 

                D.city as distributor_city, D.class, D.state as dist_state, D.state_code as dist_state_code, D.gst_number as dist_gst_no, D.prefix, 

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

            where (A.status='Approved') and date(A.date_of_processing)>='2019-04-01' and date(A.date_of_processing)>='$from_date' and date(A.date_of_processing)<='$to_date') AA 

            left join 

            (select id, 'Bar' as type, short_name as item_name, null as quantity, short_name, category_id from product_master 

                where status='Approved' 

            union all 

            select m.id, 'Box' as type, m.box_name as item_name, sum(p.qty) as quantity, m.short_name, m.category_id 

            from box_master m left join box_product p on m.id=p.box_id 

            where m.status='Approved' group by m.id) BB 

            on (AA.item_id=BB.id and AA.type=BB.type) 

            left join 

            (select order_no, min(state) as state, min(state_code) as state_code from distributor_out where status='Approved' and order_no is not null and order_no!='' and state is not null and state!='' and state_code is not null and state_code!='' group by order_no) CC on (AA.order_no=CC.order_no) 

            left join 

            category_master DD on (BB.category_id=DD.id)";

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

            date_of_receipt>='$from_date' and date_of_receipt<='$to_date' and date_of_receipt > '2018-10-22' 

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
		$row1= 1;
		 $col=0;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Raw Material Stock");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;

        $objPHPExcel->getActiveSheet()->insertNewColumnBefore('B', $total_col);

		$col=1;
		$row= 5;

        for($j=0; $j<$total_col; $j++){

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Stock In 1');

            if(isset($data[$j]->date_of_receipt) && $data[$j]->date_of_receipt!=''){

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row+1), $data[$j]->date_of_receipt);

            } else {

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row+2), 'no date');

            }

            $col=$col+1;

        }



        $sql = "select C.rm_id, C.rm_name, D.* from 
                (select id as rm_id, rm_name from raw_material_master where status = 'Approved') C 
                left join 
                (select A.*, B.raw_material_id, B.qty, B.rate, B.amount from 
                (select * from raw_material_in where status='Approved' and 
                    date_of_receipt>='$from_date' and date_of_receipt<='$to_date' and 
                    date_of_receipt > '2018-10-22') A 
                left join 
                (select * from raw_material_stock) B 
                on (A.id=B.raw_material_in_id)) D 
                on (C.rm_id = D.raw_material_id) 
                order by C.rm_id, D.date_of_receipt";

        $query=$this->db->query($sql);

        $data=$query->result();

        if(count($data)>0) {

            $raw_material_id=0;

            $prev_raw_material_id=0;

            $row=7;



            for($i=0;$i<count($data);$i++){

                $raw_material_id=$data[$i]->rm_id;



                if($raw_material_id<>$prev_raw_material_id){

                    $prev_raw_material_id=$raw_material_id;
                    $qty=array();

                    $row=$row+1;

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data[$i]->rm_name);

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$total_col].$row, $data[$i]->rm_id);

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[1+$total_col].$row, '=sum('.$col_name[1].$row.':'.$col_name[1+$total_col-1].$row.')');

                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$total_col].$row, '='.$col_name[1+$total_col].$row.'-'.$col_name[2+$total_col].$row);

                }

                

                $col=1;

                $date_of_receipt=$data[$i]->date_of_receipt;

                for($j=0; $j<=$total_col; $j++){

                    $excel_date=$objPHPExcel->getActiveSheet()->getCell($col_name[$col].'6')->getValue();



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

            where batch_processing_id in (select distinct id from batch_processing where status='Approved' and 

                    date_of_processing>='$from_date' and date_of_processing<='$to_date' and date_of_processing > '2018-10-22') 

            group by raw_material_id";

        $query=$this->db->query($sql);

        $data=$query->result();

        if(count($data)>0) {

            for($i=0;$i<count($data);$i++){

                $raw_material_id=$data[$i]->raw_material_id;

                for($j=7;$j<=$row;$j++){

                    $excel_raw_material_id=$objPHPExcel->getActiveSheet()->getCell($col_name[4+$total_col].$j)->getValue();



                    if($excel_raw_material_id==$raw_material_id){

                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[2+$total_col].$j, round($data[$i]->total_qty,2));

                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$total_col].$j, '');

                        break;

                    }

                }

            }

        }



        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[3+$total_col].'2')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A5'.':'.$col_name[3+$total_col].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[3+$total_col].'6')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

            )

        ));
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');		

        // for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        // }


		$date1 = date('d-m-Y_H-i-A');
        $filename='Raw_Material_Stock_'.$date1.'.xls';

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



      
        $row1=1;
		 $col=0;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Raw Material Stock Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;


		$row=5;
		$col=1;
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

        $objPHPExcel->getActiveSheet()->getStyle($col_name[$start_col].'5:'.$col_name[$end_col].strval($total_row+9))->applyFromArray(array(

            'borders' => array(

                'outline' => array(

                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM

                )

            )

        ));

        // foreach(range('B',$col_name[$end_col]) as $columnID) {

        //     $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);

        // }

		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

		$date1 = date('d-m-Y_H-i-A');
        $filename='Production_Report_'.$date1.'.xls';
  

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

function get_product_stock_details_old2($from_date, $to_date) {

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

            (select depot_id, product_id from batch_processing where status = 'Approved' and date_of_processing>'2018-09-21' 

            union all 

            select distinct A.depot_id, B.product_id from 

            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>'2018-09-21') A 

            left join 

            (select C.depot_transfer_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id from depot_transfer_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.depot_transfer_id) 

            where B.product_id is not null 

            union all 

            select distinct A.depot_id, B.product_id from 

            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing>'2018-09-21') A 

            left join 

            (select C.distributor_in_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id from distributor_in_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.distributor_in_id) 

            where B.product_id is not null) E) AA 





            Left join 





            (select F.depot_id, F.product_id, ifnull(F.tot_qty_in,0)-ifnull(G.tot_qty_out,0) as opening_qty from 

            (select E.depot_id, E.product_id, sum(E.tot_qty) as tot_qty_in from 

            (select depot_id, product_id, sum(qty_in_bar) as tot_qty from batch_processing where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing<'$from_date' group by depot_id, product_id 

            union all 

            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 

            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>'2018-09-21' and date_of_transfer<'$from_date') A 

            left join 

            (select C.depot_transfer_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from depot_transfer_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.depot_transfer_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id 

            union all 

            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 

            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing<'$from_date') A 

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

            (select id, depot_out_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>'2018-09-21' and date_of_transfer<'$from_date') A 

            left join 

            (select C.depot_transfer_id, case when C.type='Bar' then C.item_id else D.product_id end as product_id, 

            case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 

            from depot_transfer_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)) B 

            on (A.id=B.depot_transfer_id) 

            where B.product_id is not null 

            group by A.depot_id, B.product_id 

            union all 

            select A.depot_id, B.product_id, sum(B.qty) as tot_qty from 

            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing<'$from_date') A 

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

            where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing>='$from_date' and date_of_processing<='$to_date' 

            group by depot_id, product_id) DD 

            on (CC.depot_id=DD.depot_id and CC.product_id=DD.product_id)) EE 





            left join 





            (select A.depot_id, B.product_id, sum(B.qty) as depot_in_qty from 

            (select id, depot_in_id as depot_id from depot_transfer where status = 'Approved' and date_of_transfer>'2018-09-21' and date_of_transfer>='$from_date' and date_of_transfer<='$to_date') A 

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

            where status = 'Approved' and date_of_transfer>'2018-09-21' and date_of_transfer>='$from_date' and date_of_transfer<='$to_date') A 

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

            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing>='$from_date' and date_of_processing<='$to_date' and distributor_id not in (1, 63, 64, 65, 66, 189)) A 

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

            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing>='$from_date' and date_of_processing<='$to_date' and distributor_id in (1, 63, 64, 65, 66)) A 

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

            (select id, depot_id from distributor_out where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing>='$from_date' and date_of_processing<='$to_date' and distributor_id = 189) A 

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

            (select id, depot_id from distributor_in where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing>='$from_date' and date_of_processing<='$to_date') A 

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

function get_product_stock_details($from_date, $to_date) {
    $sql = "select A.state, A.city, A.depot_name, A.type, A.item_name, A.unit_weight, 
                sum(A.opening_qty) as opening_qty, sum(A.production_qty) as production_qty, 
                sum(A.depot_in_qty) as depot_in_qty, sum(A.depot_out_qty) as depot_out_qty, 
                sum(A.sale_qty) as sale_qty, sum(A.sample_qty) as sample_qty, 
                sum(A.expire_qty) as expire_qty, sum(A.sale_return_qty) as sale_return_qty, 
                sum(A.convert_out_qty) as convert_out_qty, sum(A.convert_in_qty) as convert_in_qty, 
                sum(A.del_pending_qty) as del_pending_qty from 
            (select YY.*, ZZ.del_pending_qty from 
            (select WW.*, XX.state, XX.city, XX.depot_name from 
            (select UU.*, VV.item_name, VV.grams as unit_weight from 
            (select SS.*, TT.convert_in_qty from 
            (select QQ.*, RR.convert_out_qty from 
            (select OO.*, PP.sale_return_qty from 
            (select MM.*, NN.expire_qty from 
            (select KK.*, LL.sample_qty from 
            (select II.*, JJ.sale_qty from 
            (select GG.*, HH.depot_out_qty from 
            (select EE.*, FF.depot_in_qty from 
            (select CC.*, DD.production_qty from 
            (select AA.depot_id, AA.type, AA.product_id, BB.opening_qty from 

            (select distinct E.depot_id, E.type, E.product_id from 
            (select distinct depot_id, 'Bar' as type, product_id from batch_processing where status = 'Approved' and date_of_processing>'2018-09-21' and product_id is not null 
            union all 
            select distinct C.depot_id, C.type, C.product_id from 
            (select A.id, A.depot_in_id as depot_id, B.type, B.item_id as product_id from depot_transfer A left join depot_transfer_items B on (A.id=B.depot_transfer_id) where A.status = 'Approved' and A.date_of_transfer>'2018-09-21' and B.item_id is not null) C 
            union all 
            select distinct C.depot_id, C.type, C.product_id from 
            (select A.id, A.depot_id, B.type, B.item_id as product_id from distributor_out A left join distributor_out_items B on (A.id=B.distributor_out_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and B.item_id is not null) C 
            union all 
            select distinct C.depot_id, C.type, C.product_id from 
            (select A.id, A.depot_id, B.type, B.item_id as product_id from distributor_in A left join distributor_in_items B on (A.id=B.distributor_in_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and B.item_id is not null) C 
            union all 
            select distinct C.depot_id, C.type, C.product_id from 
            (select A.id, A.depot_id, 'Box' as type, B.box_id as product_id from bar_to_box A left join bar_to_box_qty B on (A.id=B.bar_to_box_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and B.box_id is not null) C 
            union all 
            select distinct C.depot_id, C.type, C.product_id from 
            (select A.id, A.depot_id, 'Bar' as type, C.product_id from box_to_bar A left join box_to_bar_qty B on (A.id=B.box_to_bar_id) left join box_product C on (B.box_id=C.box_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and B.box_id is not null and C.product_id is not null) C) E) AA 

            Left join 

            (select F.depot_id, F.type, F.product_id, ifnull(F.tot_qty_in,0)-ifnull(G.tot_qty_out,0) as opening_qty from 
            (select E.depot_id, E.type, E.product_id, sum(E.tot_qty) as tot_qty_in from 
            (select depot_id, 'Bar' as type, product_id, sum(qty_in_bar) as tot_qty from batch_processing where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing<'$from_date' and product_id is not null group by depot_id, product_id 
            union all 
            select C.depot_id, C.type, C.product_id, sum(C.qty) as tot_qty from 
            (select A.id, A.depot_in_id as depot_id, B.type, B.item_id as product_id, B.qty from depot_transfer A left join depot_transfer_items B on (A.id=B.depot_transfer_id) where A.status = 'Approved' and A.date_of_transfer>'2018-09-21' and A.date_of_transfer<'$from_date' and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select C.depot_id, C.type, C.product_id, sum(C.qty) as tot_qty from 
            (select A.id, A.depot_id as depot_id, B.type, B.item_id as product_id, B.qty from distributor_in A left join distributor_in_items B on (A.id=B.distributor_in_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing<'$from_date' and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select C.depot_id, C.type, C.product_id, sum(C.qty) as tot_qty from 
            (select A.id, A.depot_id, 'Box' as type, B.box_id as product_id, B.qty from bar_to_box A left join bar_to_box_qty B on (A.id=B.bar_to_box_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing<'$from_date' and B.box_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select distinct C.depot_id, C.type, C.product_id, sum(C.tot_qty) as tot_qty from 
            (select A.id, A.depot_id, 'Bar' as type, C.product_id, (B.qty*C.qty) as tot_qty from box_to_bar A left join box_to_bar_qty B on (A.id=B.box_to_bar_id) left join box_product C on (B.box_id=C.box_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing<'$from_date' and B.box_id is not null and C.product_id is not null) C 
            group by C.depot_id, C.type, C.product_id) E 
            group by E.depot_id, E.type, E.product_id) F 
            left join 
            (select E.depot_id, E.type, E.product_id, sum(E.tot_qty) as tot_qty_out from 
            (select C.depot_id, C.type, C.product_id, sum(C.qty) as tot_qty from 
            (select A.id, A.depot_out_id as depot_id, B.type, B.item_id as product_id, B.qty from depot_transfer A left join depot_transfer_items B on (A.id=B.depot_transfer_id) where A.status = 'Approved' and A.date_of_transfer>'2018-09-21' and A.date_of_transfer<'$from_date' and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select C.depot_id, C.type, C.product_id, sum(C.qty) as tot_qty from 
            (select A.id, A.depot_id as depot_id, B.type, B.item_id as product_id, B.qty from distributor_out A left join distributor_out_items B on (A.id=B.distributor_out_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.invoice_date<'$from_date' and A.distributor_id not in (1, 63, 64, 65, 66, 189) and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select C.depot_id, C.type, C.product_id, sum(C.qty) as tot_qty from 
            (select A.id, A.depot_id as depot_id, B.type, B.item_id as product_id, B.qty from distributor_out A left join distributor_out_items B on (A.id=B.distributor_out_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing<'$from_date' and A.distributor_id in (1, 63, 64, 65, 66, 189) and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select C.depot_id, C.type, C.product_id, sum(C.qty) as tot_qty from 
            (select A.id, A.depot_id, 'Box' as type, B.box_id as product_id, B.qty from box_to_bar A left join box_to_bar_qty B on (A.id=B.box_to_bar_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing<'$from_date' and B.box_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select distinct C.depot_id, C.type, C.product_id, sum(C.tot_qty) as tot_qty from 
            (select A.id, A.depot_id, 'Bar' as type, C.product_id, (B.qty*C.qty) as tot_qty from bar_to_box A left join bar_to_box_qty B on (A.id=B.bar_to_box_id) left join box_product C on (B.box_id=C.box_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing<'$from_date' and B.box_id is not null and C.product_id is not null) C 
            group by C.depot_id, C.type, C.product_id) E 
            group by E.depot_id, E.type, E.product_id) G 
            on (F.depot_id=G.depot_id and F.type=G.type and F.product_id=G.product_id)) BB 
            on (AA.depot_id=BB.depot_id and AA.type=BB.type and AA.product_id=BB.product_id)) CC 

            left join 

            (select depot_id, 'Bar' as type, product_id, sum(qty_in_bar) as production_qty from batch_processing 
            where status = 'Approved' and date_of_processing>'2018-09-21' and date_of_processing>='$from_date' and date_of_processing<='$to_date' and product_id is not null 
            group by depot_id, product_id) DD 
            on (CC.depot_id=DD.depot_id and CC.type=DD.type and CC.product_id=DD.product_id)) EE 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as depot_in_qty from 
            (select A.id, A.depot_in_id as depot_id, B.type, B.item_id as product_id, B.qty from depot_transfer A left join depot_transfer_items B on (A.id=B.depot_transfer_id) where A.status = 'Approved' and A.date_of_transfer>'2018-09-21' and A.date_of_transfer>='$from_date' and A.date_of_transfer<='$to_date' and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id) FF 
            on (EE.depot_id=FF.depot_id and EE.type=FF.type and EE.product_id=FF.product_id)) GG 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as depot_out_qty from 
            (select A.id, A.depot_out_id as depot_id, B.type, B.item_id as product_id, B.qty from depot_transfer A left join depot_transfer_items B on (A.id=B.depot_transfer_id) where A.status = 'Approved' and A.date_of_transfer>'2018-09-21' and A.date_of_transfer>='$from_date' and A.date_of_transfer<='$to_date' and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id) HH 
            on (GG.depot_id=HH.depot_id and GG.type=HH.type and GG.product_id=HH.product_id)) II 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as sale_qty from 
            (select A.id, A.depot_id as depot_id, B.type, B.item_id as product_id, B.qty from distributor_out A left join distributor_out_items B on (A.id=B.distributor_out_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and distributor_id not in (1, 63, 64, 65, 66, 189) and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id) JJ 
            on (II.depot_id=JJ.depot_id and II.type=JJ.type and II.product_id=JJ.product_id)) KK 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as sample_qty from 
            (select A.id, A.depot_id as depot_id, B.type, B.item_id as product_id, B.qty from distributor_out A left join distributor_out_items B on (A.id=B.distributor_out_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' and distributor_id in (1, 63, 64, 65, 66) and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id) LL 
            on (KK.depot_id=LL.depot_id and KK.type=LL.type and KK.product_id=LL.product_id)) MM 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as expire_qty from 
            (select A.id, A.depot_id as depot_id, B.type, B.item_id as product_id, B.qty from distributor_out A left join distributor_out_items B on (A.id=B.distributor_out_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' and distributor_id = 189 and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id) NN 
            on (MM.depot_id=NN.depot_id and MM.type=NN.type and MM.product_id=NN.product_id)) OO 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as sale_return_qty from 
            (select A.id, A.depot_id as depot_id, B.type, B.item_id as product_id, B.qty from distributor_in A left join distributor_in_items B on (A.id=B.distributor_in_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id) PP 
            on (OO.depot_id=PP.depot_id and OO.type=PP.type and OO.product_id=PP.product_id)) QQ 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as convert_out_qty from 
            (select A.id, A.depot_id, 'Box' as type, B.box_id as product_id, B.qty from box_to_bar A left join box_to_bar_qty B on (A.id=B.box_to_bar_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' and B.box_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select distinct C.depot_id, C.type, C.product_id, sum(C.tot_qty) as convert_out_qty from 
            (select A.id, A.depot_id, 'Bar' as type, C.product_id, (B.qty*C.qty) as tot_qty from bar_to_box A left join bar_to_box_qty B on (A.id=B.bar_to_box_id) left join box_product C on (B.box_id=C.box_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' and B.box_id is not null and C.product_id is not null) C 
            group by C.depot_id, C.type, C.product_id) RR 
            on (QQ.depot_id=RR.depot_id and QQ.type=RR.type and QQ.product_id=RR.product_id)) SS 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as convert_in_qty from 
            (select A.id, A.depot_id, 'Box' as type, B.box_id as product_id, B.qty from bar_to_box A left join bar_to_box_qty B on (A.id=B.bar_to_box_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' and B.box_id is not null) C 
            group by C.depot_id, C.type, C.product_id 
            union all 
            select distinct C.depot_id, C.type, C.product_id, sum(C.tot_qty) as convert_in_qty from 
            (select A.id, A.depot_id, 'Bar' as type, C.product_id, (B.qty*C.qty) as tot_qty from box_to_bar A left join box_to_bar_qty B on (A.id=B.box_to_bar_id) left join box_product C on (B.box_id=C.box_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing>='$from_date' and A.date_of_processing<='$to_date' and B.box_id is not null and C.product_id is not null) C 
            group by C.depot_id, C.type, C.product_id) TT 
            on (SS.depot_id=TT.depot_id and SS.type=TT.type and SS.product_id=TT.product_id)) UU 

            left join 

            (select id, 'Bar' as type, short_name as item_name, grams from product_master 
            union all 
            select id, 'Box' as type, short_name as item_name, grams from box_master) VV 
            on (UU.type=VV.type and UU.product_id=VV.id)) WW 

            left join 

            (select * from depot_master) XX 
            on(WW.depot_id=XX.id)) YY 

            left join 

            (select C.depot_id, C.type, C.product_id, sum(C.qty) as del_pending_qty from 
            (select A.id, A.depot_id as depot_id, B.type, B.item_id as product_id, B.qty from distributor_out A left join distributor_out_items B on (A.id=B.distributor_out_id) where A.status = 'Approved' and A.date_of_processing>'2018-09-21' and A.date_of_processing>='$from_date' and date_of_processing<='$to_date' and delivery_status = 'Pending' and B.item_id is not null) C 
            group by C.depot_id, C.type, C.product_id) ZZ 
            on (YY.depot_id=ZZ.depot_id and YY.type=ZZ.type and YY.product_id=ZZ.product_id)) A 

            group by A.state, A.city, A.depot_name, A.type, A.item_name, A.unit_weight 

            order by A.depot_name, A.type, A.item_name";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function generate_product_stock_report($action='') {
    $from_date = '2001-01-01';
    $to_date = date('Y-m-d');

    if($this->input->post('from_date')!='') {
        $from_date = formatdate($this->input->post('from_date'));
    }
    if($this->input->post('from_date')!='') {
        $to_date = formatdate($this->input->post('to_date'));
    }
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

      	$row1=1;
        $row=5;

        $col=0;

        $tr = '<tr style="font-weight: bold;"><td>State</td><td>City</td><td>Depot Name</td><td>Type</td><td>Product</td><td>Unit Weight</td><td>Opening Qty</td><td>Production Qty</td><td>Depot In Qty</td><td>Depot Out Qty</td><td>Sale Qty</td><td>Sample Qty</td><td>Expire Qty</td><td>Sale Return Qty</td><td>Convert Out Qty</td><td>Convert In Qty</td><td>Closing Balance</td><td>Pending Qty</td><td>Physical Qty</td></tr>';

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Product Stock Report");
	  	$row1=$row1+1;
		
        $from_date1=date("d-M-y", strtotime($from_date));

        $to_date1=date("d-M-y", strtotime($to_date));
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;

        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->state);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->city);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->depot_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->item_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, round($data[$i]->unit_weight,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, round($data[$i]->opening_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, round($data[$i]->production_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, round($data[$i]->depot_in_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, round($data[$i]->depot_out_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, round($data[$i]->sale_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, round($data[$i]->sample_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, round($data[$i]->expire_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, round($data[$i]->sale_return_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, round($data[$i]->convert_out_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, round($data[$i]->convert_in_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, '=+'.$col_name[$col+6].$row.'+'.$col_name[$col+7].$row.'+'.$col_name[$col+8].$row.'-'.$col_name[$col+9].$row.'-'.$col_name[$col+10].$row.'-'.$col_name[$col+11].$row.'-'.$col_name[$col+12].$row.'+'.$col_name[$col+13].$row.'-'.$col_name[$col+14].$row.'+'.$col_name[$col+15].$row);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, $data[$i]->del_pending_qty);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, '=+'.$col_name[$col+16].$row.'+'.$col_name[$col+17].$row);

            $tr = $tr . '<tr>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+1].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+2].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+3].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+4].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+5].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+6].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+7].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+8].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+9].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+10].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+11].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+12].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+13].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+14].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+15].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+16].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+17].$row)->getCalculatedValue().'</td>
                            <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col+18].$row)->getCalculatedValue().'</td>
                        </tr>';
        }

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+18].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

        $date1 = date('d-m-Y_H-i-A');
        $filename='Product_Stock_Report_'.$date1.'.xlsx';
        
        if($action=="save") {
            // $path  = '/home/eatangcp/public_html/test/assets/uploads/mt_stock_reports/';
            // $upload_path = '/home/eatangcp/public_html/test/assets/uploads/mt_stock_reports';

            // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = '/home/eatangcp/public_html/eat_erp/assets/uploads/mt_stock_reports';

            // $path  = '/var/www/html/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = '/var/www/html/eat_erp/assets/uploads/mt_stock_reports';

            // $path  = 'C:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = 'C:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports';

            // $path  = 'E:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = 'E:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports';


            $path = $this->config->item('upload_path').'Product_stock_reports/';
            $upload_path = $this->config->item('upload_path').'Product_stock_reports';

            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $reportpath = $path.$filename;

            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment;filename="'.$filename.'"');
            // header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
            $objWriter->save($reportpath);

            // echo $reportpath;
            // echo '<br/><br/>';

            $return_arr = array('reportpath'=>$reportpath, 'tr'=> $tr);

            // return $reportpath;
            return $return_arr;
        } else {
            header('Content-Type: application/openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']='Product Stock report generated.';
            $this->user_access_log_model->insertAccessLog($logarray);

            exit;
        }

    } else {
        echo '<script>alert("No data found");</script>';
    }
}

public function send_product_stock_report() {
    $date = date('Y-m-d');
    // $date = '2019-07-16';

    $reportpath = '';
    $tr = '';
    
    $return_arr = $this->generate_product_stock_report('save');

    if(isset($return_arr['reportpath'])){
        $reportpath = $return_arr['reportpath'];
    }
    if(isset($return_arr['tr'])){
        $tr = $return_arr['tr'];
    }

    if($reportpath!=''){
        $report_date = date('d-m-Y', strtotime($date));

        $message = '<html>
                    <head>
                        <style>
                            td { padding: 5px; width: 100px; }
                        </style>
                    </head>
                    <body>
                        <h3>Wholesome Habits Private Limited</h3>
                        <h4>Product Stock Report</h4>
                        <p>Reporting Date - '.$report_date.'</p>
                        <p>PFA</p>
                        <br/><br/>

                        <table class="body_table" border="1px" style="border-collapse: collapse;">
                        <tbody>
                        '.$tr.'
                        </tbody>
                        </table>

                        <br/><br/>
                        Regards,
                        <br/><br/>
                        CS
                    </body>
                    </html>';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'EAT MIS';
        $subject = 'Product_stock_report_'.$report_date;


        /*$to_email = "dhaval.maru@otbconsulting.co.in";
        $cc="prasad.bhisale@otbconsulting.co.in";
        $bcc="prasad.bhisale@otbconsulting.co.in";*/
        
        // $to_email = "prasad.bhisale@otbconsulting.co.in";
        // $cc = 'prasad.bhisale@otbconsulting.co.in';
        // $bcc = 'prasad.bhisale@otbconsulting.co.in';

        // if($zone_email_array[$x]!=''){
        //     $to_email = "operations@eatanytime.in,priti.tripathi@eatanytime.in,".$zone_email_array[$x];
        // } else {
        //     $to_email = "operations@eatanytime.in,priti.tripathi@eatanytime.in";
        // }

        $to_email = "operations@eatanytime.in, priti.tripathi@eatanytime.in, vaibhav.desai@eatanytime.in, dinesh.parkhi@eatanytime.in";
        $cc = 'rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in, dhaval.maru@otbconsulting.co.in';
        $bcc = 'prasad.bhisale@otbconsulting.co.in';

        sleep(15);

        echo $attachment = $reportpath;
        echo '<br/><br/>';
        echo $message;
        echo '<br/><br/>';

        $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);

        echo $mailSent;
        echo '<br/><br/>';

        if($mailSent==1){
            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']='Product Stock report sent.';
            $this->user_access_log_model->insertAccessLog($logarray);
        }
    }
}

function generate_distributor_ledger_report($remark_visibility='') {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');
    $remark_visibility = $this->input->post('remark_visibility');

    

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

                invoice_date<'$from_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

               sales_return_no as reference, 

                null as debit_amount, final_amount as credit_amount, date_of_processing as rdate, remarks as remarks, 'Sales Return' as type 

                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 

                sales_return_date<'$from_date' 

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

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, date_of_transaction as rdate, remarks as remarks, transaction as type 

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

                invoice_date>='$from_date' and invoice_date<='$to_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

                sales_return_no as reference, 

                null as debit_amount, final_amount as credit_amount, date_of_processing as rdate, remarks as remarks, 'Sales Return' as type 

                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 

                sales_return_date>='$from_date' and sales_return_date<='$to_date' 

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

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, date_of_transaction as rdate, remarks as remarks, transaction as type 

                from credit_debit_note where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_transaction>='$from_date' and date_of_transaction<='$to_date') A order by A.rdate asc";

    $query=$this->db->query($sql);

    $data=$query->result();



    $sql1 = "select distributor_name from distributor_master where id='$distributor_id'";

    $query1=$this->db->query($sql1);

    $dist_data=$query1->result();

    

    if(count($data)>0) {

        $template_path=$this->config->item('template_path');

        $file = $template_path.'Distributor_Ledger_Report.xls';

        $this->load->library('excel');

        $objPHPExcel = PHPExcel_IOFactory::load($file);


	



        $col_name[]=array();

        for($i=0; $i<=20; $i++) {

            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);

        }



        $row1=1;



        $row=11;

        $col=0;



    
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited - FINAL");

     

        $row1=$row1+1;
		

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "B-505, Veena Sur, Mahavir Nagar,");
			$row1=$row1+1;
	 $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Kandivali West,");
			$row1=$row1+1;
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Mumbai");
		  	$row1=$row1+1;
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "VAT NO. 27351176608V/C");
		  	$row1=$row1+1;
			 $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $dist_data[0]->distributor_name);
		  	$row1=$row1+1;
			
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Ledger Account");
		  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
		
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;
		  

		


        /*------------ setting headers of excel -------------

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Ref Date');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Type');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Reference');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Debit');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Credit');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, 'Running Balance');
		
		
			if($remark_visibility="With Remark")
			{
				  	$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, 'Remarks');
					$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(true);
			}
			else if($remark_visibility ="Without Remark")
			{		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);
				
			}*/

        $running_balance=0;

        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $open_bal_data[0]->ref_date);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Opening Balance');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $open_bal_data[0]->reference);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, round($open_bal_data[0]->debit_amount,2));

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, round($open_bal_data[0]->credit_amount,2));

        if($open_bal_data[0]->debit_amount!=null && $open_bal_data[0]->debit_amount!=0) {

            $running_balance= $running_balance+$open_bal_data[0]->debit_amount;

        }

        if($open_bal_data[0]->credit_amount!=null && $open_bal_data[0]->credit_amount!=0) {

            $running_balance= $running_balance-$open_bal_data[0]->credit_amount;

        }

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, round($running_balance,2));



        for($i=0; $i<count($data); $i++){

            $row=$row+1;

            

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->ref_date);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->type);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->reference);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, round($data[$i]->debit_amount,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, round($data[$i]->credit_amount,2));

            if($data[$i]->debit_amount!=null && $data[$i]->debit_amount!=0) {

                $running_balance= $running_balance+$data[$i]->debit_amount;

            }

            else {

                $running_balance= $running_balance-$data[$i]->credit_amount;

            }

				$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, round($running_balance,2));
		
		
				$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->remarks);
				
		

			}



        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, '=sum('.$col_name[$col+3].'2'.':'.$col_name[$col+3].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-1).')');

        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '='.$col_name[$col+3].strval($row-1).'-'.$col_name[$col+4].strval($row-1));

        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row-1).':'.$col_name[$col+2].strval($row-1));
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Closing Balance');
		    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row).':'.$col_name[$col+3].strval($row));
       

			

        $objPHPExcel->getActiveSheet()->getStyle('C11:'.$col_name[$col+11].$row)->getFont()->setBold(true);

         $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 // $objPHPExcel->getActiveSheet()->getStyle( 'G')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			
        for ($col = 0; $col <= 6; $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
		$objPHPExcel->getActiveSheet()->getStyle('D12:D1000')->getNumberFormat()->setFormatCode('0.00');	
		$objPHPExcel->getActiveSheet()->getStyle('E12:E1000')->getNumberFormat()->setFormatCode('0.00');	
		$objPHPExcel->getActiveSheet()->getStyle('F12:F1000')->getNumberFormat()->setFormatCode('0.00');	
        $objPHPExcel->getActiveSheet()->getStyle('G1:G9999')->getAlignment()->setWrapText(true); 
		if($remark_visibility=="Without Remark")
			{  
					
				$objPHPExcel->getActiveSheet()->removeColumn('G');	
			}

        // $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);

			$date1 = date('d-m-Y_H-i-A');
        $filename='Distributor_Ledger_Report_'.$date1.'.xls';
        

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

function view_distributor_ledger_report($remark_visibility='') {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');
	$remark_visibility = $this->input->post('remark_visibility');
	

    // $from_date = '2017-01-01';

    // $to_date = '2017-07-27';

    // $distributor_id = '44';

    

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

                invoice_date<'$from_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

                sales_return_no as reference, 

                null as debit_amount, final_amount as credit_amount, date_of_processing as rdate, remarks as remarks, 

                'Sales Return' as type 

                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 

                sales_return_date<'$from_date' 

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

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, date_of_transaction as rdate, remarks as remarks, transaction as type 

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

                invoice_date>='$from_date' and invoice_date<='$to_date' 

            union all 

            select DATE_FORMAT(date_of_processing,'%d/%m/%Y') as ref_date, 

                sales_return_no as reference, 

                null as debit_amount, final_amount as credit_amount, date_of_processing as rdate , remarks as remarks,

                'Sales Return' as type 

                from distributor_in where status = 'Approved' and distributor_id = '$distributor_id' and 

                sales_return_date>='$from_date' and sales_return_date<='$to_date' 

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

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, date_of_transaction as rdate, remarks as remarks, transaction as type 

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

                        <th>Running Balance</th>';
                      if($remark_visibility=='With Remark') 
					  { 
						 $datatable.= '<th class="remark" width="200">Remarks</th>';
					  }

                  $datatable.= '  </tr>

                    </thead>

                    <tbody>';



        $debit_amount=0;

        $credit_amount=0;

        $running_balance=0;

        $tot_debit_amount=0;

        $tot_credit_amount=0;


        if(count($open_bal_data)>0){
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

                                        <td>'.format_money($debit_amount,2).'</td>

                                        <td>'.format_money($credit_amount,2).'</td>

                                        <td>'.format_money($running_balance,2).'</td>';
                                       
                                                if($remark_visibility=='With Remark') 
                                                  { 
                                                     $datatable.= ' <td></td>';
                                                  }
                                            

                                   $datatable.= ' </tr>';
        }
        



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

                                        <td>'.format_money($debit_amount,2).'</td>

                                        <td>'.format_money($credit_amount,2).'</td>

                                        <td>'.format_money(round($running_balance,2),2).'</td>';
											if($remark_visibility=='With Remark') 
											  { 
												 $datatable.= ' <td>'.$data[$i]->remarks.'</td>';
											  }
                                      

                                   $datatable.= ' </tr>';

        }



        $datatable=$datatable.'<tr>

                                    <td></td>

                                    <td></td>

                                    <td></td>

                                    <td>'.format_money($tot_debit_amount,2).'</td>

                                    <td>'.format_money($tot_credit_amount,2).'</td>

                                    
                                    <td></td>';
                                  if($remark_visibility=='With Remark') 
											  { 
												 $datatable.= ' <td></td>';
											  }
                                $datatable.= ' </tr>';



        $diff_amount = $tot_debit_amount-$tot_credit_amount;

        $datatable=$datatable.'<tr>

                                    <td></td>

                                    <td></td>
                                    <td></td>

                                    <td></td>

                                    <td>'.format_money(round($diff_amount,2),2).'</td>

                                    
                                    <td></td>';
                                                                    if($remark_visibility=='With Remark') 
											  { 
												 $datatable.= ' <td></td>';
											  }
                                $datatable.= ' </tr>';



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

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount,date_of_transaction as rdate 

                from credit_debit_note where status = 'Approved' and distributor_id = '$distributor_id' and 

                date_of_transaction>='$from_date' and date_of_transaction<='$to_date') A order by A.rdate asc";

    $query=$this->db->query($sql);

    $data=$query->result();



    return $data;
}

function generate_agingwise_report() {

    $date = formatdate($this->input->post('date'));

   //  $sql = "select I.*, J.distributor_type, J.sales_rep_name,J.area,J.location,J.zone,J.so1,J.so2 from 

			// (select G.*, H.type_id,H.distributor_name from 

   //          (select F.distributor_id, round(F.days_0_30,0) as days_0_30, round(F.days_30_45,0) as days_30_45, 

   //              round(F.days_46_60,0) as days_46_60, round(F.days_61_90,0) as days_61_90, round(F.days_91_above,0) as days_91_above, 

   //              round((F.days_0_30+F.days_30_45+F.days_46_60+F.days_61_90+F.days_91_above),0) as tot_receivable from 

   //          (select E.distributor_id, case when (E.days_91_above-E.paid_amount)>0 then 

   //              (E.days_91_above-E.paid_amount) else 0 end as days_91_above, 

   //          case when (E.days_91_above-E.paid_amount)>0 then E.days_61_90 else case when 

   //              (E.days_61_90-(E.paid_amount-E.days_91_above))>0 then 

   //              (E.days_61_90-(E.paid_amount-E.days_91_above)) else 0 end end as days_61_90, 

   //          case when (E.days_61_90-(E.paid_amount-E.days_91_above))>0 then 

   //              E.days_46_60 else case when (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90))>0 then 

   //              (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90)) else 0 end end as days_46_60, 

   //          case when (E.days_46_60-(E.paid_amount-E.days_91_above-E.days_61_90))>0 then E.days_30_45 else case 

   //              when (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60))>0 

   //              then (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60)) else 0 end end as days_30_45, 

   //          case when (E.days_30_45-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60))>0 then E.days_0_30 else case 

   //              when (E.days_0_30-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60-E.days_30_45))>0 

   //              then (E.days_0_30-(E.paid_amount-E.days_91_above-E.days_61_90-E.days_46_60-E.days_30_45)) else 0 end end as days_0_30 from 

   //          (select C.distributor_id, C.days_0_30, C.days_30_45, C.days_46_60, C.days_61_90, C.days_91_above, 

   //              ifnull(D.paid_amount,0) as paid_amount from 

   //          (select distributor_id, ifnull(round(sum(days_0_30),0),2) as days_0_30, 

   //              ifnull(round(sum(days_30_45),0),2) as days_30_45, 

   //              ifnull(round(sum(days_46_60),0),2) as days_46_60, 

   //              ifnull(round(sum(days_61_90),0),2) as days_61_90, 

   //              ifnull(round(sum(days_91_above),2),0) as days_91_above from 

   //          (select distributor_id, case when no_of_days<30 then invoice_amount else 0 end as days_0_30, 

   //              case when no_of_days>=30 and no_of_days<=45 then invoice_amount else 0 end as days_30_45, 

   //              case when no_of_days>=46 and no_of_days<=60 then invoice_amount else 0 end as days_46_60, 

   //              case when no_of_days>=61 and no_of_days<=90 then invoice_amount else 0 end as days_61_90, 

   //              case when no_of_days>=91 then invoice_amount else 0 end as days_91_above from 

   //          (select id, distributor_id, datediff('$date', date_of_processing) as no_of_days, invoice_amount 

   //              from distributor_out where status = 'Approved' and invoice_date<='$date' and distributor_id NOT IN(1,64,65,66,189,237)) A) B 

   //          group by distributor_id) C 

   //          left join 

   //          (select distributor_id, round(sum(paid_amount),2) as paid_amount from 

   //          (select distributor_id, sum(payment_amount) as paid_amount from payment_details_items 

   //              where payment_id in (select distinct id from payment_details where status = 'Approved' and 

   //                  date_of_deposit<='$date') group by distributor_id 

   //          union all 

   //          select distributor_id, sum(final_amount) as paid_amount from distributor_in 

   //              where status = 'Approved' and sales_return_date<='$date' group by distributor_id 

   //          union all 

   //          select distributor_id, sum(case when (transaction = 'Credit Note' or transaction='Expense Voucher') then amount else amount*-1 end) paid_amount 

   //              from credit_debit_note where status = 'Approved' and 

   //              date_of_transaction<='$date' group by distributor_id) AA group by distributor_id) D 

   //          on (C.distributor_id = D.distributor_id)) E) F) G 

   //          left join 

   //          (select * FROM distributor_master) H 

   //          on (G.distributor_id = H.id) where G.tot_receivable <> 0) I 

			// left join 

			// (select P.id, P.type_id,P.distributor_name,P.location_id,S.distributor_type,T.sales_rep_name,Q.area,
   //                  U.location,V.sales_rep_id1,V.sales_rep_id2,W.zone,X.sales_rep_name as so1,
   //                  Y.sales_rep_name as so2 

			// from distributor_master P 

			// left join distributor_type_master S on P.type_id=S.id 

			// left join sales_rep_master T on P.sales_rep_id=T.id

			// left join area_master Q on P.area_id=Q.id

			// left join location_master U on P.location_id=U.id

   //          left join sr_mapping V on (P.type_id=V.type_id and P.zone_id=V.zone_id and P.area_id=V.area_id)

   //          left join zone_master W on P.zone_id=W.id

   //          left join sales_rep_master X on V.sales_rep_id1=X.id

   //          left join sales_rep_master Y on V.sales_rep_id2=Y.id) J 

			// on (I.distributor_id = J.id)";


	$sql = "select I.*, J.distributor_type, J.sales_rep_name,J.area,J.location,J.zone,J.so1,J.so2 from 
            (select G.*, H.type_id,H.distributor_name from 
            (select F.distributor_id, round(F.days_0_30,0) as days_0_30, round(F.days_30_45,0) as days_30_45, 
                round(F.days_46_60,0) as days_46_60, round(F.days_61_90,0) as days_61_90, round(F.days_91_above,0) as days_91_above, 
                round((F.days_0_30+F.days_30_45+F.days_46_60+F.days_61_90+F.days_91_above),0) as tot_receivable from 
            (select C.distributor_id, C.days_0_30, C.days_30_45, C.days_46_60, C.days_61_90, C.days_91_above from 
            (select distributor_id, ifnull(round(sum(days_0_30),0),2) as days_0_30, 
                ifnull(round(sum(days_30_45),0),2) as days_30_45, 
                ifnull(round(sum(days_46_60),0),2) as days_46_60, 
                ifnull(round(sum(days_61_90),0),2) as days_61_90, 
                ifnull(round(sum(days_91_above),2),0) as days_91_above from 
            (select distributor_id, case when no_of_days<30 then invoice_amount else 0 end as days_0_30, 
                case when no_of_days>=30 and no_of_days<=45 then invoice_amount else 0 end as days_30_45, 
                case when no_of_days>=46 and no_of_days<=60 then invoice_amount else 0 end as days_46_60, 
                case when no_of_days>=61 and no_of_days<=90 then invoice_amount else 0 end as days_61_90, 
                case when no_of_days>=91 then invoice_amount else 0 end as days_91_above from 
            (select distributor_id, datediff('$date', date_of_processing) as no_of_days, invoice_amount 
                from distributor_out where status = 'Approved' and invoice_date<='$date' and distributor_id NOT IN(1,64,65,66,189,237) 
            union all 
            select B.distributor_id, datediff('$date', A.date_of_deposit) as no_of_days, (B.payment_amount*-1) as invoice_amount 
                from payment_details A left join payment_details_items B on (A.id=B.payment_id) 
                where A.status = 'Approved' and A.date_of_deposit<='$date' and B.distributor_id NOT IN(1,64,65,66,189,237) 
            union all 
            select distributor_id, datediff('$date', sales_return_date) as no_of_days, (final_amount*-1) as invoice_amount 
                from distributor_in where status = 'Approved' and sales_return_date<='$date' and distributor_id NOT IN(1,64,65,66,189,237) 
            union all 
            select distributor_id, datediff('$date', date_of_transaction) as no_of_days, case when (transaction = 'Credit Note' or transaction='Expense Voucher') then amount*-1 else amount end as invoice_amount 
                from credit_debit_note where status = 'Approved' and 
                date_of_transaction<='$date' and distributor_id NOT IN(1,64,65,66,189,237)) A) B 
            group by distributor_id) C) F) G 
            left join 
            (select * FROM distributor_master) H 
            on (G.distributor_id = H.id) where G.tot_receivable <> 0) I 
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



		

		

		

		

      $row1=1;
        $row=5;

        $col=0;

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Aging wise Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($date));
			
			// $to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1) ;

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
    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+2].$row)->getNumberFormat()->setFormatCode('0.00');	
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->days_0_30);
			
    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+3].$row)->getNumberFormat()->setFormatCode('0.00');	
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->days_30_45);
			
    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+4].$row)->getNumberFormat()->setFormatCode('0.00');	
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->days_46_60);
			
    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+5].$row)->getNumberFormat()->setFormatCode('0.00');	
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->days_61_90);
			
    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+6].$row)->getNumberFormat()->setFormatCode('0.00');	
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->days_91_above);
    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+7].$row)->getNumberFormat()->setFormatCode('0.00');	
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

		

        

		

		

		

		

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+14].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN,

					// 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

					

				

                )

            )

        ));



		

		

        $objPHPExcel->getActiveSheet()->getStyle('A5:O5')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

			

            'startcolor' => array(

                'rgb' => 'D9D9D9',

				

				

            )

        ));

		

		for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');


		$date1 = date('d-m-Y_H-i-A');
        $filename='Agingwise_Report_'.$date1.'.xls';

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


		$row1=1;
        $row=5;

        $col=0;

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Distributor Wise Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;
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

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, format_money($data[$i]->sell_out,2));

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



        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+26].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A5:AA1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'hex' => '245478'

            )

        ));
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

        for($col = 0; $col < 6; $col++) {

            $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[$col])->setAutoSize(true);

        }


		$date1 = date('d-m-Y_H-i-A');
        $filename='Distributorwise_Report_'.$date1.'.xls';
       

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

                sales_return_date >= '$from_date' and sales_return_date <= '$to_date') A 

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

    $sql = "select DD.distributor_id, DD.distributor_name, DD.total_pending_amount, EE.invoice_date, EE.invoice_no, EE.voucher_no, EE.due_date, EE.invoice_amount, DD.location from 

            (select CC.distributor_id, CC.distributor_name, sum(CC.pending_amount) as total_pending_amount, CC.location from 

            (select AA.*, ifnull(BB.payment_amount,0) as payment_amount, (round(AA.final_amount,0)-ifnull(BB.payment_amount,0)) as pending_amount from 

            (select A.*, B.distributor_name,F.location from distributor_out A left join distributor_master B on(A.distributor_id=B.id) left join location_master F on B.location_id=F.id 

                where A.status = 'Approved' and A.invoice_no is not null and A.invoice_no!='' and (A.invoice_date >= '$from_date' and A.invoice_date <= '$to_date')) AA 

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

                where A.status = 'Approved' and A.invoice_no is not null and A.invoice_no!='' and (A.invoice_date >= '$from_date' and A.invoice_date <= '$to_date')) AA 

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


      	$row1=1;
        $row=5;

        $col=0;

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Product Stock Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;



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

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, round($data[$i]->total_pending_amount,2));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+2].$row)->getNumberFormat()->setFormatCode('0.00');

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->invoice_date);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->due_date);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->invoice_no);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, round($data[$i]->invoice_amount,2));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+6].$row)->getNumberFormat()->setFormatCode('0.00');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->voucher_no);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->location);

        }



        

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+8].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A5:I1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

            )

        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

       
		$date1 = date('d-m-Y_H-i-A');
        $filename='Payment_Receivable_Report_'.$date1.'.xls';

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



        
        $row1=1;



        $row=5;

        $col=0;

	$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Purchase Order Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;


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

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, format_money($data[$i]->qty,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, format_money($data[$i]->rate,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, format_money($data[$i]->tax_per,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, format_money($data[$i]->item_amount,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->delivery_date);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, format_money($data[$i]->amount,2));

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->shipping_method);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->shipping_term);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->remarks);

        }



        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=sum('.$col_name[$col+6].'2'.':'.$col_name[$col+6].strval($row-1).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, '=sum('.$col_name[$col+8].'2'.':'.$col_name[$col+8].strval($row-1).')');

        

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+11].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A5:L5')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

            )

        ));

        for($col = 'A'; $col <= 'L'; $col++) {

            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

        }

			$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

 
		$date1 = date('d-m-Y_H-i-A');
        $filename='Purchase_Order_Report_'.$date1.'.xls';
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

	
		$row1=1;
        $row=5;

        $col=0;


		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Production Data Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;
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

        

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+10].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A5:K1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

            )

        ));


        for($col = 'A'; $col <= 'K'; $col++) {

            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

        }

		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

       
		$date1 = date('d-m-Y_H-i-A');
        $filename='Production_Data_Report_'.$date1.'.xls';
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

    

    $sql = "select d.date_of_processing as ref_date, d.invoice_no as reference, d.final_amount as debit_amount, null as credit_amount, m.distributor_name, d.remarks 

                from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.invoice_date>='$from_date' and d.invoice_date<='$to_date' 

            union all 

            select d.date_of_processing as ref_date, null as reference, null as debit_amount, d.final_amount as credit_amount, m.distributor_name, d.remarks 

                from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.sales_return_date>='$from_date' and d.sales_return_date<='$to_date' 

            union all 

            select * from 

            (select A.date_of_deposit as ref_date, B.invoice_no as reference, null as debit_amount, B.payment_amount as credit_amount, E.distributor_name, A.remarks from 

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

                    case when (d.transaction='Debit Note' or d.transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (d.transaction='Credit Note' or d.transaction='Expense Voucher') then amount end as credit_amount , m.distributor_name, d.remarks

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
		
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, 'Remarks');



        for($i=0; $i<count($data); $i++){

            $row=$row+1;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->ref_date);

			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->distributor_name);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->reference);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->debit_amount);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->credit_amount);
			
			$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->remarks);

        }



        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, '=sum('.$col_name[$col+3].'2'.':'.$col_name[$col+3].strval($row-2).')');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '=sum('.$col_name[$col+4].'2'.':'.$col_name[$col+4].strval($row-2).')');

        $row=$row+1;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, '='.$col_name[$col+3].strval($row-2).'-'.$col_name[$col+4].strval($row-2));

        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row-2).':'.$col_name[$col+2].strval($row-2));

        $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].strval($row).':'.$col_name[$col+3].strval($row));



        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+5].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));

        for($col = 'A'; $col !== 'F'; $col++) {

            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);

            if($col == 'J'){

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



        $row1=1;
        $row=5;

        $col=0;

				$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Promoter Stock Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;
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



        $row=6;

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





        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+23].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                    )

                )

            ));



        $objPHPExcel->getActiveSheet()->getStyle('A5:X1')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'rgb' => 'D9D9D9'

                )

            ));


        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

   
		$date1 = date('d-m-Y_H-i-A');
        $filename='Promoter_Stock_Report_'.$date1.'.xls';
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
    $result = $this->getOpeningBal($ledger_id, $from_date);
    if(count($result)>0){
        $opening_bal = floatval($result[0]['opening_bal']);
    }

    $data = $this->getLedger($ledger_id, $from_date, $to_date);

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
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, (($data[$i]['ref_date']!=null && $data[$i]['ref_date']!="")?date("d-m-Y",strtotime($data[$i]['ref_date'])):""));
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

function generate_distributor_balance_ledger_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');

    

    $sql = "select sum(debit_amount) as debit_amount,sum(credit_amount) as credit_amount,distributor_name from 

            (select 
                invoice_amount as debit_amount, null as credit_amount, m.distributor_name

                from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.invoice_date<'$from_date' 

            union all 

            select 

                null as debit_amount, final_amount as credit_amount, m.distributor_name

                from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.sales_return_date<'$from_date'

            union all 

            select * from 

            (select null as debit_amount, 

                B.payment_amount as credit_amount,E.distributor_name from 

            (select * from payment_details where status = 'Approved' and date_of_deposit<'$from_date') A 

            left join 

            (select * from payment_details_items ) B 

            on (A.id=B.payment_id)
            
            left join

            (select * from distributor_master) E

            on (E.id=B.distributor_id)) C where C.credit_amount is not null 

            union all 

            select  

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, m.distributor_name 

                from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' and 

                d.date_of_transaction<'$from_date') A group by distributor_name";

    $query=$this->db->query($sql);

    $open_bal_data=$query->result();



    $sql = "select sum(debit_amount) as debit_amount,sum(credit_amount) as credit_amount,distributor_name from 

            (select 
                invoice_amount as debit_amount, null as credit_amount, m.distributor_name

                from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.invoice_date>='$from_date' and d.invoice_date<='$to_date' 

            union all 

            select 

                null as debit_amount, final_amount as credit_amount, m.distributor_name

                from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.sales_return_date>='$from_date' and d.sales_return_date<='$to_date' 

            union all 

            select * from 

            (select null as debit_amount, 

                B.payment_amount as credit_amount,E.distributor_name from 

            (select * from payment_details where status = 'Approved' and 

                date_of_deposit>='$from_date' and date_of_deposit<='$to_date') A 

            left join 

            (select * from payment_details_items ) B 

            on (A.id=B.payment_id)
            
            left join

            (select * from distributor_master) E

            on (E.id=B.distributor_id)) C where C.credit_amount is not null 

            union all 

            select  

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, m.distributor_name 

                from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' and 

                d.date_of_transaction>='$from_date' and d.date_of_transaction<='$to_date') A group by distributor_name
                
                ";

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



        $row1=1;



        $row=6;

        $col=0;



        
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Ledger Balance Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;



        //------------ setting headers of excel -------------

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Distributor Name');

        
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Opening Balance');


        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Debit');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Credit');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Closing Balance');



        $running_balance=0;

        $row=$row+1;

        

        $openbal_debit=0;
        $openbal_credit=0;
        $openbal=0;

        for($i=0; $i<count($data); $i++){

             if(count($open_bal_data)>0) {
                for($j=0; $j<count($open_bal_data); $j++){
                    if($data[$i]->distributor_name==$open_bal_data[$j]->distributor_name) {
                        // $openbal_debit = strval($open_bal_data[$j]->debit_amount);
                        // $openbal_credit = strval($open_bal_data[$j]->credit_amount);
                            $openbal =strval($open_bal_data[$j]->debit_amount)-strval($open_bal_data[$j]->credit_amount);
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, round($openbal,2));
                        }
                        
                    }
                }
                else {
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '0');
                }

             


            //$row=$row+1;
            
            

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data[$i]->distributor_name);

            

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, round($data[$i]->debit_amount,2));

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, round($data[$i]->credit_amount,2));

            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getNumberFormat()->setFormatCode('0');

            $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getNumberFormat()->setFormatCode('0');

            $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode('0');


            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,  '=ROUND('.'B'.strval($row).'+'.'C'.strval($row).'-'.'D'.strval($row).',2)');

            $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('0');

             $row=$row+1;

        }



        //$row=$row+1;

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }



        $objPHPExcel->getActiveSheet()->getStyle('A6:'.'E'.($row-1))->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));

        
       	$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');
       

        $filename='Ledger_Balance_Report.xls';

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');



        

    } else {

        echo '<script>alert("No data found");</script>';

    }
}

function upload_distributor_balance_ledger_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');
    $includes = 'No';

    if($this->input->post('includes_zero'))
    {
        $includes = 'Yes';
    }
    

    $sql = "select sum(debit_amount) as debit_amount,sum(credit_amount) as credit_amount,distributor_name from 

            (select 
                invoice_amount as debit_amount, null as credit_amount, m.distributor_name

                from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.invoice_date<'$from_date' 

            union all 

            select 

                null as debit_amount, final_amount as credit_amount, m.distributor_name

                from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.sales_return_date<'$from_date'

            union all 

            select * from 

            (select null as debit_amount, 

                B.payment_amount as credit_amount,E.distributor_name from 

            (select * from payment_details where status = 'Approved' and 

                date_of_deposit<'$from_date') A 

            left join 

            (select * from payment_details_items ) B 

            on (A.id=B.payment_id)
            
            left join

            (select * from distributor_master) E

            on (B.distributor_id=E.id)) C where C.credit_amount is not null 

            union all 

            select  

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, m.distributor_name 

                from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' and 

                d.date_of_transaction<'$from_date') A group by distributor_name";

    $query=$this->db->query($sql);

    $open_bal_data=$query->result();



     $sql = "Select A.*,B.r_tally_name,B.r_closing_bal from 
                (select sum(debit_amount) as debit_amount,sum(credit_amount) as credit_amount,distributor_name,tally_name from 

                            (select 
                                invoice_amount as debit_amount, null as credit_amount, m.distributor_name,m.tally_name

                                from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' 

                                and d.invoice_date>='$from_date' and d.invoice_date<='$to_date'

                            union all 

                            select 

                                null as debit_amount, final_amount as credit_amount, m.distributor_name,m.tally_name

                                from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' 
                                            and d.sales_return_date>='$from_date' and d.sales_return_date<='$to_date'

                            union all 

                            select * from 

                            (select null as debit_amount, 

                                B.payment_amount as credit_amount,E.distributor_name,E.tally_name from 

                            (select * from payment_details where status = 'Approved' 
                                        and date_of_deposit>='$from_date' and date_of_deposit<='$to_date') A 

                            left join 

                            (select * from payment_details_items ) B 

                            on (A.id=B.payment_id)
                            
                            left join

                            (select * from distributor_master) E

                            on (B.distributor_id=E.id)) C where C.credit_amount is not null 

                            union all 

                            select  

                                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, m.distributor_name ,m.tally_name

                                from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' 
                and d.date_of_transaction>='$from_date' and d.date_of_transaction<='$to_date') A group by distributor_name,tally_name)A
                left Join
                (SELECT Distinct A.tally_name as r_tally_name, A.closing_bal as r_closing_bal, A.distributer_id from tally_report A
                Where  date(added_on)=(SELECT date(max(added_on)) from telly_report_upload)) B
                on (A.tally_name=B.r_tally_name)

                ";
                /*
                    Select A.tally_name as r_tally_name, A.closing_bal as r_closing_bal, A.distributer_id from tally_report A 
                Where A.tally_report_id=(SELECT tally_report_id from tally_report 
                Where distributer_id=A.distributer_id and 
                date(added_on)=(SELECT date(max(added_on)) from tally_report))
                */

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



        $row1=1;



        $row=6;

        $col=0;



        

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Ledger Balance Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;



        //------------ setting headers of excel -------------

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Distributor Name');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Tally Name');
        
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Opening Balance');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Debit');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Credit');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, 'Closing Balance');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, 'Tally Name');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, 'Closing Balance');

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, 'Difference');


        $running_balance=0;

        $row=$row+1;

        $openbal_debit=0;
        $openbal_credit=0;
        $openbal=0;

        for($i=0; $i<count($data); $i++){

             if(count($open_bal_data)>0) {
                for($j=0; $j<count($open_bal_data); $j++){
                    if($data[$i]->distributor_name==$open_bal_data[$j]->distributor_name) {
                        // $openbal_debit = strval($open_bal_data[$j]->debit_amount);
                        // $openbal_credit = strval($open_bal_data[$j]->credit_amount);
                            $openbal =strval($open_bal_data[$j]->debit_amount)-strval($open_bal_data[$j]->credit_amount);
                            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, round($openbal,2));
                        }
                        
                    }
                }
                else {
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '0');
                }

             


            //$row=$row+1;
             $objPHPExcel->getActiveSheet()->getStyle('C'.$row)->getNumberFormat()->setFormatCode('0'); 

            if($includes=='No' && (($data[$i]->r_closing_bal!=0 || (($openbal+$data[$i]->debit_amount)-$data[$i]->credit_amount)!=0)))
            {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data[$i]->distributor_name);

                 $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data[$i]->tally_name);

                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, round($data[$i]->debit_amount,2));

                $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode('0'); 

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, round($data[$i]->credit_amount,2));

                $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('0'); 


                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,  '='.'C'.strval($row).'+'.'D'.strval($row).'-'.'E'.strval($row));

                $objPHPExcel->getActiveSheet()->getStyle('F'.$row)->getNumberFormat()->setFormatCode('0'); 

                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->r_tally_name);

                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, round($data[$i]->r_closing_bal,2));

                $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getNumberFormat()->setFormatCode('0');

                if($data[$i]->r_closing_bal!='' || $data[$i]->r_closing_bal!=null)
                {
                  $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,  '='.'F'.strval($row).'-'.'H'.strval($row));
                  $objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getNumberFormat()->setFormatCode('0');

                }
                
                $row=$row+1;
            }
            else if($includes=='Yes')
            {

                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $data[$i]->distributor_name);

                 $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $data[$i]->tally_name);

                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, round($data[$i]->debit_amount,2));
                $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode('0');

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, round($data[$i]->credit_amount,2));

                $objPHPExcel->getActiveSheet()->getStyle('E'.$row)->getNumberFormat()->setFormatCode('0');

                $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,  '='.'C'.strval($row).'+'.'D'.strval($row).'-'.'E'.strval($row));

                $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $data[$i]->r_tally_name);

                $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, round($data[$i]->r_closing_bal,2));

                $objPHPExcel->getActiveSheet()->getStyle('H'.$row)->getNumberFormat()->setFormatCode('0');

                if($data[$i]->r_closing_bal!='' || $data[$i]->r_closing_bal!=null)
                {
                  $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,  '='.'F'.strval($row).'-'.'H'.strval($row));

                  $objPHPExcel->getActiveSheet()->getStyle('I'.$row)->getNumberFormat()->setFormatCode('0');

                }
                
                $row=$row+1;
            }
        }

        //$row=$row+1;

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A7:'.'I'.$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));

        $objPHPExcel->getActiveSheet()->getStyle('A6:'.'I'.($row-1))->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));

		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');
       
	
	

        $filename='Ledger_Balance_Report.xls';

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');



        

    } else {

        echo '<script>alert("No data found");</script>';

    }
}

function view_generate_distributor_balance_ledger_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');

    $includes_twenty = $this->input->post('includes_twenty');
    $includes_zero = $this->input->post('includes_zero');

    $sql = "select sum(debit_amount) as debit_amount,sum(credit_amount) as credit_amount,distributor_name from 

            (select 
                invoice_amount as debit_amount, null as credit_amount, m.distributor_name

                from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.invoice_date<'$from_date' 

            union all 

            select 

                null as debit_amount, final_amount as credit_amount, m.distributor_name

                from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.sales_return_date<'$from_date'

            union all 

            select * from 

            (select null as debit_amount, 

                B.payment_amount as credit_amount,E.distributor_name from 

            (select * from payment_details where status = 'Approved' and 

                date_of_deposit<'$from_date') A 

            left join 

            (select * from payment_details_items ) B 

            on (A.id=B.payment_id)
            
            left join

            (select * from distributor_master) E

            on (E.id=B.distributor_id)) C where C.credit_amount is not null 

            union all 

            select  

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, m.distributor_name 

                from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' and 

                d.date_of_transaction<'$from_date') A group by distributor_name";

    $query=$this->db->query($sql);

    $open_bal_data=$query->result();



    $sql = "select sum(debit_amount) as debit_amount,sum(credit_amount) as credit_amount,distributor_name from 

            (select 
                invoice_amount as debit_amount, null as credit_amount, m.distributor_name

                from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.invoice_date>='$from_date' and d.invoice_date<='$to_date' 

            union all 

            select 

                null as debit_amount, final_amount as credit_amount, m.distributor_name

                from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                d.sales_return_date>='$from_date' and d.sales_return_date<='$to_date' 

            union all 

            select * from 

            (select null as debit_amount, 

                B.payment_amount as credit_amount,E.distributor_name from 

            (select * from payment_details where status = 'Approved' and 

                date_of_deposit>='$from_date' and date_of_deposit<='$to_date') A 

            left join 

            (select * from payment_details_items ) B 

            on (A.id=B.payment_id)
            
            left join

            (select * from distributor_master) E

            on (E.id=B.distributor_id)) C where C.credit_amount is not null 

            union all 

            select  

                    case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                    case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, m.distributor_name 

                from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' and 

                d.date_of_transaction>='$from_date' and d.date_of_transaction<='$to_date') A group by distributor_name
                
                ";

    $query=$this->db->query($sql);

    $data=$query->result();



   

    

    if(count($data)>0) {

        $datatable='<div id="printTable" style=""><br/>
         
        <span style="font-size:20px;margin-left:50px;"><b>From Date: </b>'.$this->input->post('from_date').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>To Date: </b>'.$this->input->post('to_date').'
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="download" class="btn btn-danger" value="Download Report" />
        </span><br/><br/><br/><br/>
        <div class="table-responsive">
        <table border="1" cellpadding="3" style="border-collapse: collapse;margin-left:50px;">
            <thead>
                <tr>
                    <th>SR No</th>
                    <th>Distributor Name</th>
                    <th>Opening Balance</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Closing Balance</th>
                </tr>
            </thead>
            <tbody>';

        $running_balance=0;


        $openbal_debit=0;
        $openbal_credit=0;
        $openbal=0;
        $j=0;
        for($i=0; $i<count($data); $i++){

            

            if(count($open_bal_data)>0) {
                for($j=0; $j<count($open_bal_data); $j++){
                    if($data[$i]->distributor_name==$open_bal_data[$j]->distributor_name) {
                        // $openbal_debit = strval($open_bal_data[$j]->debit_amount);
                        // $openbal_credit = strval($open_bal_data[$j]->credit_amount);
                            $openbal =strval($open_bal_data[$j]->debit_amount)-strval($open_bal_data[$j]->credit_amount);
                            /*$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $openbal);*/                            
                        }
                    }
                $openbal = $openbal;
            }
            else{  
              $openbal = 0;
            }

            $closing_amount = (($openbal+$data[$i]->debit_amount)-$data[$i]->credit_amount);
            $closing_amount2 = round((($openbal+$data[$i]->debit_amount)-$data[$i]->credit_amount),2);

            if($includes_twenty=='' && $includes_zero=='')
            {
                if($closing_amount2!=0)
                {
                    $datatable=$datatable.'<tr>';
                    $datatable=$datatable. "<td>".($j+1)."</td>";
                    $datatable=$datatable. "<td>".$data[$i]->distributor_name."</td>";
                    $datatable=$datatable. "<td class='something'> 0</td>";
                    $datatable=$datatable. "<td class='something'>".$data[$i]->debit_amount."</td>";
                    $datatable=$datatable. "<td class='something'>".$data[$i]->credit_amount."</td>";
                    $datatable=$datatable. "<td class='something'>".round((($openbal+$data[$i]->debit_amount)-$data[$i]->credit_amount),2)."</td>";
                    $datatable=$datatable. "<tr>";  
                    $j = $j+1;
                } 
            }
            else if($includes_twenty!='' && $includes_zero=='')
            {
                if($closing_amount<20 && $closing_amount2!=0)
                {
                    $datatable=$datatable.'<tr>';
                    $datatable=$datatable. "<td>".($j+1)."</td>";
                    $datatable=$datatable. "<td>".$data[$i]->distributor_name."</td>";
                    $datatable=$datatable. "<td class='something'> 0</td>";
                    $datatable=$datatable. "<td class='something'>".$data[$i]->debit_amount."</td>";
                    $datatable=$datatable. "<td class='something'>".$data[$i]->credit_amount."</td>";
                    $datatable=$datatable. "<td class='something'>".round((($openbal+$data[$i]->debit_amount)-$data[$i]->credit_amount),2)."</td>";
                    $datatable=$datatable. "<tr>";  
                    $j = $j+1;
                } 
            }
            else if($includes_twenty=='' && $includes_zero!='')
            {
                 $datatable=$datatable.'<tr>';
                    $datatable=$datatable. "<td>".($j+1)."</td>";
                    $datatable=$datatable. "<td>".$data[$i]->distributor_name."</td>";
                    $datatable=$datatable. "<td class='something'> 0</td>";
                    $datatable=$datatable. "<td class='something'>".$data[$i]->debit_amount."</td>";
                    $datatable=$datatable. "<td class='something'>".$data[$i]->credit_amount."</td>";
                    $datatable=$datatable. "<td class='something'>".round((($openbal+$data[$i]->debit_amount)-$data[$i]->credit_amount),2)."</td>";
                    $datatable=$datatable. "<tr>";  
                    $j = $j+1;
            }
            else if($includes_twenty!='' && $includes_zero!='')
            {
              if($closing_amount<20)
                {
                    $datatable=$datatable.'<tr>';
                    $datatable=$datatable. "<td>".($j+1)."</td>";
                    $datatable=$datatable. "<td>".$data[$i]->distributor_name."</td>";
                    $datatable=$datatable. "<td class='something'> 0</td>";
                    $datatable=$datatable. "<td class='something'>".$data[$i]->debit_amount."</td>";
                    $datatable=$datatable. "<td class='something'>".$data[$i]->credit_amount."</td>";
                    $datatable=$datatable. "<td class='something'>".round((($openbal+$data[$i]->debit_amount)-$data[$i]->credit_amount),2)."</td>";
                    $datatable=$datatable. "<tr>";  
                    $j = $j+1;
                }  
            }

            
            
        }

         $datatable=$datatable."</tbody></table></div></div>";

         return $datatable;
    } else {

        echo '<script>alert("No data found");</script>';

    }
}

public function get_ledger_details() {
    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');

    $sql = "Select * , Case When closingbalance<0 Then 'Debit Note' Else 'Credit Note' end as transaction_type  from (
        SELECT A.*,
        IFNULL(ROUND(((Case When B.openingbalance IS NULL then 0 else B.openingbalance end ) +A.debit_amount)-A.credit_amount,2),0)  as closingbalance
         from (
        SELECT Ifnull(Sum(debit_amount), 0)  AS debit_amount, 
               Ifnull(Sum(credit_amount), 0) AS credit_amount, 
               distributor_name,dist_id 
        FROM   (SELECT invoice_amount AS debit_amount, 
                       NULL           AS credit_amount, 
                       m.distributor_name ,m.id as dist_id
                FROM   distributor_out d 
                       LEFT JOIN distributor_master m 
                              ON d.distributor_id = m.id 
                WHERE  d.status = 'Approved' 
                       AND d.invoice_date >= '$from_date' 
                       AND d.invoice_date <= '$to_date' 
                UNION ALL 
                SELECT NULL         AS debit_amount, 
                       final_amount AS credit_amount, 
                       m.distributor_name ,m.id as dist_id
                FROM   distributor_in d 
                       LEFT JOIN distributor_master m 
                              ON d.distributor_id = m.id 
                WHERE  d.status = 'Approved' 
                       AND d.sales_return_date >= '$from_date' 
                       AND d.sales_return_date <= '$to_date' 
                UNION ALL 
                SELECT * 
                FROM   (SELECT NULL             AS debit_amount, 
                               B.payment_amount AS credit_amount, 
                               E.distributor_name ,E.id as dist_id
                        FROM   (SELECT * 
                                FROM   payment_details 
                                WHERE  status = 'Approved' 
                                       AND date_of_deposit >= '$from_date' 
                                       AND date_of_deposit <= '$to_date') A 
                               LEFT JOIN (SELECT * 
                                          FROM   payment_details_items) B 
                                      ON ( A.id = B.payment_id ) 
                               LEFT JOIN (SELECT * 
                                          FROM   distributor_master) E 
                                      ON ( E.id = B.distributor_id )) C 
                WHERE  C.credit_amount IS NOT NULL 
                UNION ALL 
                SELECT CASE 
                         WHEN (TRANSACTION = 'Debit Note' or transaction='Expense Voucher Reversal') THEN amount 
                       END AS debit_amount, 
                       CASE 
                         WHEN (TRANSACTION = 'Credit Note' or transaction='Expense Voucher') THEN amount 
                       END AS credit_amount, 
                       m.distributor_name ,m.id as dist_id
                FROM   credit_debit_note d, 
                       distributor_master m 
                WHERE  d.distributor_id = m.id 
                       AND d.status = 'Approved' 
                       AND d.date_of_transaction >= '$from_date' 
                       AND d.date_of_transaction <= '$to_date') A 
        GROUP  BY distributor_name 
        ) A

        Left join
        (
        SELECT  CASE WHEN A.distributor_name IS NULL THEN 0 else  IFNULL((A.debit_amount-A.credit_amount),0) end  as openingbalance  ,A.distributor_name from (select sum(debit_amount) as debit_amount,sum(credit_amount) as credit_amount,distributor_name,dist_id from 

                    (select 
                        invoice_amount as debit_amount, null as credit_amount, m.distributor_name,m.id as dist_id

                        from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                        d.invoice_date<'$from_date' 

                    union all 

                    select 

                        null as debit_amount, final_amount as credit_amount, m.distributor_name,m.id as dist_id

                        from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                        d.sales_return_date<'$from_date'

                    union all 

                    select * from 

                    (select null as debit_amount, 

                        B.payment_amount as credit_amount,E.distributor_name,E.id as dist_id from 

                    (select * from payment_details where status = 'Approved' and 

                        date_of_deposit<'$from_date') A 

                    left join 

                    (select * from payment_details_items ) B 

                    on (A.id=B.payment_id)
                    
                    left join

                    (select * from distributor_master) E

                    on (E.id=B.distributor_id)) C where C.credit_amount is not null 

                    union all 

                    select  

                            case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                            case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, m.distributor_name ,m.id as dist_id

                        from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' and 

                        d.date_of_transaction<'$from_date') A group by distributor_name)A
        ) B On A.distributor_name=B.distributor_name ) A
        Where (closingbalance  BETWEEN -5 and 5) and closingbalance!=0";
    $query=$this->db->query($sql);
    return $query->result_array();
}

public function save_credit_debit($data) {
    $this->db->insert_batch('credit_debit_note',$data);
    $action = 'Credit_debit_note Entry Created.';
    $logarray['table_id']=$this->session->userdata('session_id');;
    $logarray['module_name']='Credit_debit_note';
    $logarray['cnt_name']='Credit_debit_note';
    $logarray['action']=$action;
    $this->user_access_log_model->insertAccessLog($logarray);
}

public function get_adjustment_bal() {
    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));

    $distributor_id = $this->input->post('distributor_id');

    $sql = "Select sum(closingbalance) as adjusmentbal from (
            SELECT A.*,
            IFNULL(ROUND(((Case When B.openingbalance IS NULL then 0 else B.openingbalance end ) +A.debit_amount)-A.credit_amount,2),0)  as closingbalance
             from (
            SELECT Ifnull(Sum(debit_amount), 0)  AS debit_amount, 
                   Ifnull(Sum(credit_amount), 0) AS credit_amount, 
                   distributor_name 
            FROM   (SELECT invoice_amount AS debit_amount, 
                           NULL           AS credit_amount, 
                           m.distributor_name 
                    FROM   distributor_out d 
                           LEFT JOIN distributor_master m 
                                  ON d.distributor_id = m.id 
                    WHERE  d.status = 'Approved' 
                           AND d.invoice_date >= '$from_date' 
                           AND d.invoice_date <= '$to_date' 
                    UNION ALL 
                    SELECT NULL         AS debit_amount, 
                           final_amount AS credit_amount, 
                           m.distributor_name 
                    FROM   distributor_in d 
                           LEFT JOIN distributor_master m 
                                  ON d.distributor_id = m.id 
                    WHERE  d.status = 'Approved' 
                           AND d.sales_return_date >= '$from_date' 
                           AND d.sales_return_date <= '$to_date' 
                    UNION ALL 
                    SELECT * 
                    FROM   (SELECT NULL             AS debit_amount, 
                                   B.payment_amount AS credit_amount, 
                                   E.distributor_name 
                            FROM   (SELECT * 
                                    FROM   payment_details 
                                    WHERE  status = 'Approved' 
                                           AND date_of_deposit >= '$from_date' 
                                           AND date_of_deposit <= '$to_date') A 
                                   LEFT JOIN (SELECT * 
                                              FROM   payment_details_items) B 
                                          ON ( A.id = B.payment_id ) 
                                   LEFT JOIN (SELECT * 
                                              FROM   distributor_master) E 
                                          ON ( E.id = B.distributor_id )) C 
                    WHERE  C.credit_amount IS NOT NULL 
                    UNION ALL 
                    SELECT CASE 
                             WHEN (TRANSACTION = 'Debit Note' or transaction='Expense Voucher Reversal') THEN amount 
                           END AS debit_amount, 
                           CASE 
                             WHEN (TRANSACTION = 'Credit Note' or transaction='Expense Voucher') THEN amount 
                           END AS credit_amount, 
                           m.distributor_name 
                    FROM   credit_debit_note d, 
                           distributor_master m 
                    WHERE  d.distributor_id = m.id 
                           AND d.status = 'Approved' 
                           AND d.date_of_transaction >= '$from_date' 
                           AND d.date_of_transaction <= '$to_date') A 
            GROUP  BY distributor_name 
            ) A

            Left join
            (
            SELECT  CASE WHEN A.distributor_name IS NULL THEN 0 else  IFNULL((A.debit_amount-A.credit_amount),0) end  as openingbalance  ,A.distributor_name from (select sum(debit_amount) as debit_amount,sum(credit_amount) as credit_amount,distributor_name from 

                        (select 
                            invoice_amount as debit_amount, null as credit_amount, m.distributor_name

                            from distributor_out d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                            d.invoice_date<'$from_date' 

                        union all 

                        select 

                            null as debit_amount, final_amount as credit_amount, m.distributor_name

                            from distributor_in d left join distributor_master m on d.distributor_id=m.id where d.status = 'Approved' and 

                            d.sales_return_date<'$from_date'

                        union all 

                        select * from 

                        (select null as debit_amount, 

                            B.payment_amount as credit_amount,E.distributor_name from 

                        (select * from payment_details where status = 'Approved' and 

                            date_of_deposit<'$from_date') A 

                        left join 

                        (select * from payment_details_items ) B 

                        on (A.id=B.payment_id)
                        
                        left join

                        (select * from distributor_master) E

                        on (E.id=B.distributor_id)) C where C.credit_amount is not null 

                        union all 

                        select  

                                case when (transaction='Debit Note' or transaction='Expense Voucher Reversal') then amount end as debit_amount, 

                                case when (transaction='Credit Note' or transaction='Expense Voucher') then amount end as credit_amount, m.distributor_name 

                            from credit_debit_note d,distributor_master m where d.distributor_id=m.id and d.status = 'Approved' and 

                            d.date_of_transaction<'$from_date') A group by distributor_name)A
            ) B On A.distributor_name=B.distributor_name ) A
            Where closingbalance  BETWEEN -5 and 5";
    $query=$this->db->query($sql);
    return $query->result();
}

public function sales_rep_route_plan() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $sales_rep_id = $this->input->post('salesrep_id');
    ////utf8mb4_unicode_ci
    $startdate = date('Y-m-d', strtotime($from_date));
    $enddate = date('Y-m-d', strtotime($to_date));

    $date_from = strtotime($startdate);
    $date_to  = strtotime($enddate);
    $batch_array = [];

    for ($i=$date_from; $i<=$date_to; $i+=86400) 
    {  
        $e_day =  date('l', $i); 
        $e_week =  date('W', $i);  

        if ($e_week % 2 == 0) {
            $day = 'Alternate '.$e_day;
        }
        else
        {
            $day = 'Every '.$e_day;
        }

        if(!in_array($day,$batch_array))
        {
            if (strpos($day, 'Sunday') !== false) {
                
            }
            else
            {
                $batch_array[]=$day;
            }
        }
    }
    
    $tendays = date('Y-m-d', strtotime("-10 days"));
    $twentydays  = date('Y-m-d', strtotime('-10 day', strtotime($tendays)));
    $thirtydays =date('Y-m-d', strtotime('-10 day', strtotime($twentydays)));

    $infrequency = "'" . implode ( "', '", $batch_array ) . "'";
    $cond = '';
    if($sales_rep_id!='ALL')
    {
        $cond = " AND  A.sales_rep_id='$sales_rep_id'";
    }else
    {
        $cond = " AND  A.sales_rep_id NOT IN(2)";
    }

    $sql = "Select A.*,IFNULL(B.current_stock,0) as current_stock ,IFNULL(C.totalnooforders,0) as totalnooforders,IFNULL(D.betweennooforders,0) as betweennooforders ,G.sales_rep_name  from (
            Select A.*,B.date_of_visit as last_visit,DATEDIFF(CURRENT_DATE(),B.date_of_visit) as days_diff,IFNULL(C.od_units,0) as total_ods_unit
            from (
            SELECT DISTINCT A.*,B.distributor_name 
            from (SELECT store_id,frequency,sales_rep_id from sales_rep_beat_plan WHERE frequency IN($infrequency) ) A
            Left JOIN
            (Select Distinct C.* FROM(
                    Select B.* from (
                            Select concat('d_',A.id) as id , A.distributor_name   FROM
                            (Select * from distributor_master )A
                            LEFT JOIN sr_mapping B ON (A.area_id = B.area_id and A.zone_id = B.zone_id and  A.type_id = B.type_id) 
                            Where A.status='approved' and A.class in ('normal', 'direct') 
                    ) B
                    Union 
                    (
                            Select concat('s_',A.id) as id , A.distributor_name  FROM
                            (Select * from sales_rep_distributors  Where status='Approved')A
                    )            
            ) C ) B On (A.store_id=B.id COLLATE utf8_unicode_ci) 
            WHERE distributor_name is NOT NULL ) A 
            LEFT JOIN
            (SELECT DISTINCT store_id,sales_rep_id,max(date(date_of_visit)) as date_of_visit  from  sales_rep_detailed_beat_plan  Where is_edit='edit'
            GROUP BY store_id,sales_rep_id 
            ORDER BY date(date_of_visit) ) B
            on (A.store_id=B.store_id and A.sales_rep_id=B.sales_rep_id)
            left JOIN
            (select sum(B.qty)as od_units,sales_rep_id,distributor_id,
            CASE WHEN ((FLOOR((DayOfMonth(date(created_on))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(created_on))-1)/7)+1 )=3 OR (FLOOR((DayOfMonth(date(created_on))-1)/7)+1 )=5) 
            THEN  CONCAT('Every ',DAYNAME(date(created_on))) ELSE CONCAT('Alternate ',DAYNAME(date(created_on))) end as dayname 
            from (select * from sales_rep_orders Where date(created_on)>='$from_date' and date(created_on)<='$to_date')A 
            left join (
                    select C.sales_rep_order_id, case when C.type='Bar' then C.qty else C.qty*D.qty end as qty 
                from sales_rep_order_items C left join box_product D on (C.type = 'Box' and C.item_id = D.box_id)

            ) B on(A.id=B.sales_rep_order_id)
            GROUP BY sales_rep_id,distributor_id) C on (A.sales_rep_id=C.sales_rep_id and A.store_id=C.distributor_id and (A.frequency=C.dayname COLLATE utf8_unicode_ci))
            ) A
            Left JOIN
            (SELECT DISTINCT IFNULL(B.current_stock,0) as current_stock,sales_rep_id,distributor_id 
            from (SELECT id as sales_rep_loc_id,sales_rep_id,distributor_id,max(date(date_of_visit)) as last_visit from sales_rep_location
            WHERE distributor_id IS NOT NULL OR distributor_id<>''
            GROUP BY sales_rep_id,distributor_id ) A
            LEFT JOIN
            (SELECT  IFNULL(sum(orange_bar+mint_bar+butterscotch_bar+chocopeanut_bar+bambaiyachaat_bar+mangoginger_bar+berry_blast_bar+chyawanprash_bar),0) as current_stock ,
            sales_rep_loc_id from sales_rep_distributor_opening_stock GROUP BY sales_rep_loc_id) B 
            on A.sales_rep_loc_id=B.sales_rep_loc_id  Where distributor_id <>'') B
            on (A.sales_rep_id=B.sales_rep_id and A.store_id=B.distributor_id) 
            LEFT JOIN
            (select sales_rep_id,distributor_id,count(id) as totalnooforders from sales_rep_orders GROUP BY sales_rep_id,distributor_id) C
            on(A.sales_rep_id=C.sales_rep_id and A.store_id=C.distributor_id)
            LEFT JOIN
            (select sales_rep_id,distributor_id,count(id) as betweennooforders from sales_rep_orders 
                Where date(created_on)>='$from_date' and date(created_on)<='$to_date' GROUP BY sales_rep_id,distributor_id) D
            on(A.sales_rep_id=D.sales_rep_id and A.store_id=D.distributor_id)
            JOIN
            (SELECT sales_rep_name,id from sales_rep_master Where status='Approved') G
            On A.sales_rep_id=G.id
            Where  A.sales_rep_id is NOT NULL
            ".$cond."
            ORDER BY sales_rep_id,frequency,distributor_name DESC ";
    $result = $this->db->query($sql)->result();
    return  $result;
}

public function sales_rep_route_plan_summary() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $sales_rep_id = $this->input->post('salesrep_id');
    ////utf8mb4_unicode_ci
    $startdate = date('Y-m-d', strtotime($from_date));
    $enddate = date('Y-m-d', strtotime($to_date));

    $date_from = strtotime($startdate);
    $date_to  = strtotime($enddate);
    $batch_array = [];

    for ($i=$date_from; $i<=$date_to; $i+=86400) 
    {  
        $e_day =  date('l', $i); 
        $e_week =  date('W', $i);  

        if ($e_week % 2 == 0) {
            $day = 'Alternate '.$e_day;
        }
        else
        {
            $day = 'Every '.$e_day;
        }

        if(!in_array($day,$batch_array))
        {
            if (strpos($day, 'Sunday') !== false) {
                
            }
            else
            {
                $batch_array[]=$day;
            }
        }
    }
    
    $tendays = date('Y-m-d', strtotime("-10 days"));
    $twentydays  = date('Y-m-d', strtotime('-10 day', strtotime($tendays)));
    $thirtydays =date('Y-m-d', strtotime('-10 day', strtotime($twentydays)));

    $infrequency = "'" . implode ( "', '", $batch_array ) . "'";
    $cond = '';
    if($sales_rep_id!='ALL')
    {
        $cond = " Where A.sales_rep_id='$sales_rep_id'";
    }
    else
    {
        $cond = " Where  A.sales_rep_id NOT IN(2)";
    }

    $sql = "Select * from (Select A.*,B.visited_store,E.planned_store,F.betweenten,
            F.betweentwenty,F.betweenthirty,G.sales_rep_name
            from (SELECT sales_rep_id,count(store_id) as total_store from  sales_rep_beat_plan WHERE 
            sales_rep_id IN (SELECT  Distinct id  from sales_rep_master Where sr_type='Sales Representative' and `status`='Approved'
            ) GROUP BY sales_rep_id ) A
            JOIN
            (SELECT sales_rep_name,id from sales_rep_master Where status='Approved') G
            On A.sales_rep_id=G.id
            left JOIN
            (Select sales_rep_id,count(store_id) as visited_store from sales_rep_detailed_beat_plan Where 
            is_edit='edit' and date(date_of_visit) BETWEEN '$from_date' and '$to_date' GROUP BY sales_rep_id) B
            ON A.sales_rep_id=B.sales_rep_id
            left JOIN
            (SELECT sales_rep_id,count(store_id) as planned_store from sales_rep_beat_plan 
            Where frequency IN ($infrequency) GROUP BY sales_rep_id
            ) E on A.sales_rep_id=E.sales_rep_id
            left JOIN
            (Select sum(betweenten) as betweenten ,sum(betweentwenty) as betweentwenty ,sum(betweenthirty) as betweenthirty,sales_rep_id 
            from (Select B.store_id,B.sales_rep_id, DATEDIFF(CURRENT_DATE(),last_visit) as last_visit, 
            Case When DATEDIFF(CURRENT_DATE(),last_visit) BETWEEN 1 and 10 Then 1 else 0 end as betweenten,
            Case When DATEDIFF(CURRENT_DATE(),last_visit) BETWEEN 10 and 20 Then 1 else 0 end as betweentwenty, 
            Case When DATEDIFF(CURRENT_DATE(),last_visit) >=20 Then 1 else 0 end as betweenthirty 
            from (SELECT DISTINCT store_id,sales_rep_id from sales_rep_beat_plan )A 
            JOIN (SELECT DISTINCT store_id,sales_rep_id,max(date(date_of_visit)) as last_visit 
            from sales_rep_detailed_beat_plan Where is_edit='edit' GROUP BY store_id,sales_rep_id) B 
            On (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id) ORDER By sales_rep_id ) A GROUP By sales_rep_id) F
            On A.sales_rep_id=F.sales_rep_id ) A ".$cond;

    $result = $this->db->query($sql)->result();
    return  $result;
}

public function merchendizer_rep_route_plan() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $sales_rep_id = $this->input->post('merchendizer_id');
    ////utf8mb4_unicode_ci
    $startdate = date('Y-m-d', strtotime($from_date));
    $enddate = date('Y-m-d', strtotime($to_date));

    $date_from = strtotime($startdate);
    $date_to  = strtotime($enddate);
    $batch_array = [];

    for ($i=$date_from; $i<=$date_to; $i+=86400) 
    {  
        $e_day =  date('l', $i); 
        $e_week =  date('W', $i);  

        if ($e_week % 2 == 0) {
            $day = 'Alternate '.$e_day;
        }
        else
        {
            $day = 'Every '.$e_day;
        }

        if(!in_array($day,$batch_array))
        {
            if (strpos($day, 'Sunday') !== false) {
                
            }
            else
            {
                $batch_array[]=$day;
            }
        }
    }
    
    $tendays = date('Y-m-d', strtotime("-10 days"));
    $twentydays  = date('Y-m-d', strtotime('-10 day', strtotime($tendays)));
    $thirtydays =date('Y-m-d', strtotime('-10 day', strtotime($twentydays)));

    $infrequency = "'" . implode ( "', '", $batch_array ) . "'";
    $cond = '';
    if($sales_rep_id!='ALL')
    {
        $cond = " Where  A.sales_rep_id='$sales_rep_id'";
    }


    $sql = "SELECT A.*,B.date_of_visit as last_visit,DATEDIFF(CURRENT_DATE(),B.date_of_visit) as days_diff,IFNULL(C.current_stock,0) as current_stock  from (select Distinct E.*,B.location,F.sales_rep_name         from (Select A.*,B.store_name from 
         (Select store_id,frequency,sales_rep_id,location_id from  merchandiser_beat_plan Where frequency IN($infrequency))  A 
        left join 
        (SELECT * FROM relationship_master where type_id ='4' or type_id='7') B 
        on (A.store_id=B.id))E
        left join 
        (select * from sales_rep_master where sr_type='Merchandizer' order by sales_rep_name desc ) F 
        on (E.sales_rep_id=F.id)
        left join
        (select * from location_master) B 
        on (E.location_id=B.id))A
        left JOIN
        (SELECT DISTINCT store_id,sales_rep_id,max(date(date_of_visit)) as date_of_visit from merchandiser_detailed_beat_plan Where  is_edit='edit' GROUP BY store_id,sales_rep_id ORDER BY date(date_of_visit) 
        )B 
        on (A.store_id=B.store_id and A.sales_rep_id=B.sales_rep_id)
        Left JOIN
        (Select * from (Select sum(qty) as current_stock,dist_id,m_id,location_id from (Select B.*,A.m_id,A.dist_id,A.location_id from (SELECT id,dist_id,m_id,max(date(date_of_visit)) as last_visit ,location_id from merchandiser_stock WHERE dist_id IS NOT NULL OR dist_id<>''
            GROUP BY dist_id,m_id,location_id)A
        left join 
        (SELECT * from merchandiser_stock_details )B ON
        A.id=B.merchandiser_stock_id )B Group By  dist_id,m_id,location_id )A Order By m_id )C
        on (A.store_id=C.dist_id and A.sales_rep_id=C.m_id and A.location_id=C.location_id)
        ".$cond."
        ORDER By A.sales_rep_id,A.frequency ";
    $result = $this->db->query($sql)->result();
    return  $result;
}

public function merchendizer_rep_route_plan_summary() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $sales_rep_id = $this->input->post('merchendizer_id');
    ////utf8mb4_unicode_ci
    $startdate = date('Y-m-d', strtotime($from_date));
    $enddate = date('Y-m-d', strtotime($to_date));

    $date_from = strtotime($startdate);
    $date_to  = strtotime($enddate);
    $batch_array = [];

    for ($i=$date_from; $i<=$date_to; $i+=86400) 
    {  
        $e_day =  date('l', $i); 
        $e_week =  date('W', $i);  

        if ($e_week % 2 == 0) {
            $day = 'Alternate '.$e_day;
        }
        else
        {
            $day = 'Every '.$e_day;
        }

        if(!in_array($day,$batch_array))
        {
            if (strpos($day, 'Sunday') !== false) {
                
            }
            else
            {
                $batch_array[]=$day;
            }
        }
    }
    
    $tendays = date('Y-m-d', strtotime("-10 days"));
    $twentydays  = date('Y-m-d', strtotime('-10 day', strtotime($tendays)));
    $thirtydays =date('Y-m-d', strtotime('-10 day', strtotime($twentydays)));

    $infrequency = "'" . implode ( "', '", $batch_array ) . "'";
    $cond = '';
    if($sales_rep_id!='ALL')
    {
        $cond = " Where A.sales_rep_id='$sales_rep_id'";
    }
    else
    {
        $cond = " Where  A.sales_rep_id NOT IN(2)";
    }

    $sql = "Select A.*,IFNULL(B.visited_store,0) as visited_store,IFNULL(E.planned_store,0) as planned_store,IFNULL(F.betweenten,0) as betweenten,IFNULL(F.betweentwenty,0) as betweentwenty,IFNULL(F.betweenthirty ,0) as betweenthirty ,G.sales_rep_name from (SELECT sales_rep_id,count(store_id) as total_store from  merchandiser_beat_plan 
            WHERE sales_rep_id IN (SELECT  Distinct id  from sales_rep_master Where sr_type='Merchandizer' and `status`='Approved') GROUP BY sales_rep_id )A
            JOIN
            (SELECT sales_rep_name,id from sales_rep_master Where status='Approved') G
            On A.sales_rep_id=G.id
            left JOIN
            (Select sales_rep_id,count(store_id) as visited_store from merchandiser_detailed_beat_plan Where 
            is_edit='edit' and date(date_of_visit) BETWEEN '$from_date' and '$to_date' GROUP BY sales_rep_id) B
            ON A.sales_rep_id=B.sales_rep_id
            left JOIN
            (SELECT sales_rep_id,count(store_id) as planned_store from merchandiser_beat_plan  
             Where frequency IN('Every Thursday') GROUP BY sales_rep_id) E on A.sales_rep_id=E.sales_rep_id
            Left join
            (Select sum(betweenten) as betweenten ,sum(betweentwenty) as betweentwenty ,sum(betweenthirty) as betweenthirty,sales_rep_id 
            from (Select B.store_id,B.sales_rep_id, DATEDIFF(CURRENT_DATE(),last_visit) as last_visit, 
            Case When DATEDIFF(CURRENT_DATE(),last_visit) BETWEEN 1 and 10 Then 1 else 0 end as betweenten,
            Case When DATEDIFF(CURRENT_DATE(),last_visit) BETWEEN 10 and 20 Then 1 else 0 end as betweentwenty, 
            Case When DATEDIFF(CURRENT_DATE(),last_visit) >=20 Then 1 else 0 end as betweenthirty 
            from (SELECT DISTINCT store_id,sales_rep_id from merchandiser_beat_plan )A 
            JOIN (SELECT DISTINCT store_id,sales_rep_id,max(date(date_of_visit)) as last_visit 
            from merchandiser_detailed_beat_plan Where is_edit='edit' GROUP BY store_id,sales_rep_id) B 
            On (A.sales_rep_id=B.sales_rep_id and A.store_id=B.store_id) ORDER By sales_rep_id ) A GROUP By sales_rep_id )F
            On A.sales_rep_id=F.sales_rep_id ".$cond;

    $result = $this->db->query($sql)->result();
    return  $result;
}

function generate_loader_screen_report() {

    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));


    $sql = "SELECT * FROM loading_screen_log ";

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


		$row1=1;
        $row=5;

        $col=0;

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, " Screen Load Time Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;
        //------------ setting headers of excel -------------

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Id");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Load Time");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Url");

      




        for($i=0; $i<count($data); $i++){

            $row=$row+1;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->id);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->loadtime .' sec');

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->url);

            

        }








        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+2].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A5:B5')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'hex' => '245478'

            )

        ));
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

        for($col = 0; $col < 6; $col++) {

            $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[$col])->setAutoSize(true);

        }


		$date1 = date('d-m-Y_H-i-A');
        $filename='screen_loader_time_report'.$date1.'.xls';
       

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');



        $logarray['table_id']=$this->session->userdata('session_id');

        $logarray['module_name']='Reports';

        $logarray['cnt_name']='Reports';

        $logarray['action']='Screen load time report generated.';

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }
}

public function get_upload_telly_report($id='') {
    $cond = '';
    if($id!='')
    {
        $cond = ' AND telly_report_upload_id='.$id;
    }

    $sql = "Select * from telly_report_upload Where file_name IS NOT NULL ".$cond. " Order By telly_report_upload_id desc";
    $result = $this->db->query($sql)->result();
    return  $result;
}

public function get_raw_material_stock_report() {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $depot_id = $this->input->post('depot_id');
    $data = $this->raw_material_stock_report($from_date, $to_date , $depot_id);
    if(count($data)>0) {
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Raw_Material_Stock_IN_OUT.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $col_name[]=array();
        for($i=0; $i<=20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $row1=2;
        $row=5;

        $col=0;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
        $row1=$row1+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Raw Material Stock Report");
        $row1=$row1+1;
        
        $from_date1=date("d-M-y", strtotime($from_date));
        $to_date1=date("d-M-y", strtotime($to_date));
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;
        for($i=0; $i<count($data); $i++){
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->state);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->city);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->depot_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->rm_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, round($data[$i]->opening_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, round($data[$i]->depot_in_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, round($data[$i]->rm_in_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, round($data[$i]->rm_stock_in_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, round($data[$i]->depot_out_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, round($data[$i]->batch_process_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, round($data[$i]->rm_stock_out_qty,2));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, '=+'.$col_name[$col+4].$row.'+'.$col_name[$col+5].$row.'+'.$col_name[$col+6].$row.'+'.$col_name[$col+7].$row.'-'.$col_name[$col+8].$row.'-'.$col_name[$col+9].$row.'-'.$col_name[$col+10].$row);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+11].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

        $date1 = date('d-m-Y_H-i-A');
        $filename='Raw_Material_Stock_Report_'.$date1.'.xls';
       
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

    }      
}

public function raw_material_stock_report($from_date,$to_date ,$depot_id) {
        if($depot_id=='ALL') {
            $cond = '';
            $cond2 = '';
            $cond3 = '';
            $cond4 = '';
        } else {
            $cond = " where depot_id='$depot_id'";
            $cond2 = " and depot_id='$depot_id'";
            $cond3 = " and depot_in_id='$depot_id'";
            $cond4 = " and depot_out_id='$depot_id'";
        }

        $sql = "select * from 
            (select A.depot_id,A.depot_name,A.state,A.city,A.raw_material_id,A.rm_name,A.tot_qty as opening_qty,
                B.rm_in_qty,C.rm_stock_in_qty,D.depot_in_qty,
                E.batch_process_qty,F.rm_stock_out_qty,G.depot_out_qty from 
            (select H.*, I.rm_name from
            (select F.*, G.depot_name, G.state, G.city from 
            (select E.depot_id, E.raw_material_id, sum(tot_qty) as tot_qty from 
            (select C.depot_id, C.raw_material_id, ifnull(C.qty_in,0)-ifnull(D.qty_out,0) as tot_qty from 
            (select AA.depot_id, AA.raw_material_id, sum(AA.qty) as qty_in from 
            (select B.id as depot_id, A.id as raw_material_id, 0 as qty 
                from raw_material_master A left join depot_master B on(1=1) 
            union all 
            select A.depot_id, B.raw_material_id, B.qty from 
            (select * from raw_material_in where status = 'Approved' and date_of_receipt > '2018-10-22' and date_of_receipt<'$from_date') A 
            inner join 
            (select * from raw_material_stock) B 
            on (A.id = B.raw_material_in_id) 
            union all
            select A.depot_id, B.raw_material_id, B.qty from 
            (select * from raw_material_in_out where status = 'Approved' and date_of_processing > '2018-10-22' and date_of_processing<'$from_date') A 
            inner join 
            (select * from raw_material_in_out_items Where type='Stock IN') B 
            on (A.id = B.raw_material_in_out_id)
            union all 
            select A.depot_in_id as depot_id, B.item_id as raw_material_id, B.qty from 
            (select * from depot_transfer where status = 'Approved' and date_of_transfer > '2018-10-22' and date_of_transfer<'$from_date') A 
            inner join 
            (select * from depot_transfer_items where type = 'Raw Material') B 
            on (A.id = B.depot_transfer_id)) AA group by AA.depot_id, AA.raw_material_id) C 
            left join 
            (select BB.depot_id, BB.raw_material_id, sum(BB.qty) as qty_out from 
            (select A.depot_id, B.raw_material_id, B.qty from 
            (select * from batch_processing where status = 'Approved' and date_of_processing > '2018-10-22' and date_of_processing<'$from_date') A 
            inner join 
            (select * from batch_raw_material) B 
            on (A.id = B.batch_processing_id) 
            union all
            select A.depot_id, B.raw_material_id, B.qty from 
            (select * from raw_material_in_out where status = 'Approved' and date_of_processing > '2018-10-22' and date_of_processing<'$from_date') A 
            inner join 
            (select * from raw_material_in_out_items Where type='Stock Out') B 
            on (A.id = B.raw_material_in_out_id)
            union all 
            select A.depot_out_id as depot_id, B.item_id as raw_material_id, B.qty from 
            (select * from depot_transfer where status = 'Approved' and date_of_transfer > '2018-10-22' and date_of_transfer<'$from_date') A 
            inner join 
            (select * from depot_transfer_items where type = 'Raw Material') B 
            on (A.id = B.depot_transfer_id)) BB group by BB.depot_id, BB.raw_material_id) D 
            on (C.depot_id=D.depot_id and C.raw_material_id=D.raw_material_id)) E 
            group by E.depot_id, E.raw_material_id) F 
            left join 
            (select * from depot_master) G 
            on (F.depot_id=G.id)) H 
            left join 
            (select * from raw_material_master) I 
            on (H.raw_material_id=I.id) 
            ".$cond."
            ) A 
            left join 
            (select A.depot_id, B.raw_material_id, sum(B.qty) as rm_in_qty from 
            (select * from raw_material_in where status = 'Approved' and date_of_receipt > '2018-10-22' and 
                (date_of_receipt>='$from_date' and date_of_receipt<='$to_date')".$cond2.") A 
            inner join 
            (select * from raw_material_stock) B 
            on (A.id = B.raw_material_in_id) group by A.depot_id, B.raw_material_id) B 
            on (A.depot_id=B.depot_id and A.raw_material_id=B.raw_material_id)
            left join 
            (select A.depot_id, B.raw_material_id, sum(B.qty) as rm_stock_in_qty from 
            (select * from raw_material_in_out where status = 'Approved' and date_of_processing > '2018-10-22' and 
                (date_of_processing>='$from_date' and date_of_processing<='$to_date')".$cond2.") A 
            inner join 
            (select * from raw_material_in_out_items Where type='Stock IN') B 
            on (A.id = B.raw_material_in_out_id) group by A.depot_id, B.raw_material_id) C 
            on (A.depot_id=C.depot_id and A.raw_material_id=C.raw_material_id) 
            left join 
            (select A.depot_in_id as depot_id, B.item_id as raw_material_id, sum(B.qty) as depot_in_qty from 
            (select * from depot_transfer where status = 'Approved' and date_of_transfer > '2018-10-22' and 
                (date_of_transfer>='$from_date' and date_of_transfer<='$to_date') and depot_in_id is not null".$cond3.") A 
            inner join 
            (select * from depot_transfer_items where type = 'Raw Material') B 
            on (A.id = B.depot_transfer_id) group by A.depot_in_id, B.item_id) D 
            on (A.depot_id=D.depot_id and A.raw_material_id=D.raw_material_id) 
            left join 
            (select A.depot_id, B.raw_material_id, sum(B.qty) as batch_process_qty from 
            (select * from batch_processing where status = 'Approved' and date_of_processing > '2018-10-22' and 
                (date_of_processing>='$from_date' and date_of_processing<='$to_date')".$cond2.") A 
            inner join 
            (select * from batch_raw_material) B 
            on (A.id = B.batch_processing_id) group by A.depot_id, B.raw_material_id) E 
            on (A.depot_id=E.depot_id and A.raw_material_id=E.raw_material_id) 
            left join 
            (select A.depot_id, B.raw_material_id, sum(B.qty) as rm_stock_out_qty from 
            (select * from raw_material_in_out where status = 'Approved' and date_of_processing > '2018-10-22' and 
                (date_of_processing>='$from_date' and date_of_processing<='$to_date')".$cond2.") A 
            inner join 
            (select * from raw_material_in_out_items Where type='Stock Out') B 
            on (A.id = B.raw_material_in_out_id) group by A.depot_id, B.raw_material_id) F 
            on (A.depot_id=F.depot_id and A.raw_material_id=F.raw_material_id) 
            left join 
            (select A.depot_out_id as depot_id, B.item_id as raw_material_id, sum(B.qty) as depot_out_qty from 
            (select * from depot_transfer where status = 'Approved' and date_of_transfer > '2018-10-22' and 
                (date_of_transfer>='$from_date' and date_of_transfer<='$to_date') and depot_out_id is not null ".$cond4.") A 
            inner join 
            (select * from depot_transfer_items where type = 'Raw Material') B 
            on (A.id = B.depot_transfer_id) group by A.depot_out_id, B.item_id) G 
            on (A.depot_id=G.depot_id and A.raw_material_id=G.raw_material_id)) A 
            where A.rm_in_qty<>0 or A.rm_stock_in_qty<>0 or A.depot_in_qty<>0 or 
                A.batch_process_qty<>0 or A.rm_stock_out_qty<>0 or A.depot_out_qty<>0 
            order by A.depot_name, A.rm_name";
    $result = $this->db->query($sql)->result();
    return  $result;
}

public function generate_distributor_transfer_report(){
    
    
    $from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));


    $sql = "SELECT A.id,A.date_of_transfer,B.distributor_name as dist_out_name,C.distributor_name as dist_in_name ,D.product_name,D.type,D.qty
            FROM 
            (Select * from `distributor_transfer`  Where  date_of_transfer>'2018-09-21' AND date_of_transfer >= '$from_date'  AND date_of_transfer <= '$to_date')A
            Left JOIN
            distributor_master B ON A.`distributor_out_id`=B.id
            Left JOIN
            distributor_master C ON A.`distributor_in_id`=C.id
            Left JOIN
            (SELECT product_name,B.id,A.type,A.distributor_transfer_id,qty from 
            (Select * from distributor_transfer_items Where type='Bar')A
            Left JOIN
            (Select * from  product_master ) B On A.item_id=B.id
            UNION
            SELECT box_name as product_name,B.id,A.type,A.distributor_transfer_id,qty from 
            (Select * from distributor_transfer_items Where type='Box')A
            Left JOIN
            (Select * from  box_master ) B On A.item_id=B.id ) D On A.id=D.distributor_transfer_id ";

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


        $row1=1;
        $row=5;

        $col=0;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
        $row1=$row1+1;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, " Distributor Transfer Report");
        $row1=$row1+1;
        
            $from_date1=date("d-M-y", strtotime($from_date));
            
            $to_date1=date("d-M-y", strtotime($to_date));
          $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;
        //------------ setting headers of excel -------------



        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Date Of Transfer");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Distributor Out Name");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Distributor IN Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Product Name");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Type");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Quantity");

      




        for($i=0; $i<count($data); $i++){

            $row=$row+1;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->date_of_transfer);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->dist_out_name);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->dist_in_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->product_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->qty);

            

        }


        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+5].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A5:F5')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'hex' => '245478'

            )

        ));
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

        for($col = 0; $col < 6; $col++) {

            $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[$col])->setAutoSize(true);

        }


        $date1 = date('d-m-Y_H-i-A');
        $filename='distributor_transfer_report'.$date1.'.xls';
       

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');



        $logarray['table_id']=$this->session->userdata('session_id');

        $logarray['module_name']='Reports';

        $logarray['cnt_name']='Reports';

        $logarray['action']='Distributor Transfer report generated.';

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }
}

public function generate_gt_stock_report(){
	
	
	$from_date = formatdate($this->input->post('from_date'));

    $to_date = formatdate($this->input->post('to_date'));


		$sql = "select K.*, L.rt_distributor_name from (select I.*,J.sales_rep_name from 
        (SELECT G.*,H.location from (select E.*, F.area from(select C.*,D.zone from 
        (select A.id,A.zone_id,A.area_id,A.distributor_id,A.distributor_name,A.location_id,A.sales_rep_id,A.date_of_visit,B.orange_bar,B.butterscotch_bar,B.chocopeanut_bar,B.bambaiyachaat_bar,B.mangoginger_bar,B.berry_blast_bar,B.chyawanprash_bar,B.chocolate_cookies_box,B.cranberry_orange_box,B.dark_chocolate_cookies_box,B.fig_raisins_box,papaya_pineapple_box,B.variety_box,B.mint_box,butterscotch_box,B.chocopeanut_box,B.bambaiyachaat_box,B.berry_blast_box,B.mangoginger_box,B.cranberry_cookies_box,B.orange_box,B.chyawanprash_box from 
        (SELECT * FROM sales_rep_location WHERE date(date_of_visit)>= '$from_date'  AND date(date_of_visit)<= '$to_date' ) A
		left join
		(SELECT * FROM sales_rep_distributor_opening_stock) B 
		on(A.id=B.sales_rep_loc_id)) C
		left join 
		(select * FROM zone_master) D 
		on(C.zone_id=D.id)) E
		left join 
		(select * FROM area_master) F
		on(E.area_id=F.id)) G 
		left JOIN
		(SELECT * from location_master) H 
		on(G.location_id=H.id))I
		left join
		(select * from sales_rep_master)J
		on(I.sales_rep_id=J.id))K
		left join
		( Select concat('d_',A.id) as r_id , A.distributor_name as rt_distributor_name,A.area_id,A.zone_id,A.location_id FROM
			(Select * from distributor_master )A
			 Union 
			
			 Select concat('s_',A.id) as r_id , A.distributor_name as rt_distributor_name ,A.area_id,A.zone_id,A.location_id FROM
			(Select * from sales_rep_distributors )A
											
		)L 
		on(K.distributor_id=L.r_id)";

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


		$row1=1;
        $row=5;

        $col=0;

		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, "Wholesome Habits Private Limited ");
		$row1=$row1+1;
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, " GT Stock Report");
	  	$row1=$row1+1;
		
			$from_date1=date("d-M-y", strtotime($from_date));
			
			$to_date1=date("d-M-y", strtotime($to_date));
		  $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row1, $from_date1.' to '. $to_date1) ;
        //------------ setting headers of excel -------------



        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Date Of Visit");
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Sales Representative Name");

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Retailer");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Zone");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Area");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Location");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Orange");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Butterscotch");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, "Bambaiya Chat");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, "Mango Ginger");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, "Choco Peanut");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, "Berry Blast");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, "Chyawanprash");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, "Variety Box");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, "Chocolate Cookies");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, "Dark Chocolate Cookies");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, "Cranberry Cookies");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, "Fig And Raisins TrailMix");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, "Cranberry & Orange TrailMix ");
		$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, "Papapya & Pineapple TrailMix");

      




        for($i=0; $i<count($data); $i++){

            $row=$row+1;
			
			 $orange=($data[$i]->orange_box)*6 +($data[$i]->orange_bar);
			 $butterscotch=($data[$i]->butterscotch_box)*6 +($data[$i]->butterscotch_bar);
			 $choco=($data[$i]->chocopeanut_box)*6 +($data[$i]->chocopeanut_bar);
			 $bambaiya=($data[$i]->bambaiyachaat_box)*6 +($data[$i]->bambaiyachaat_bar);
			 $berry=($data[$i]->berry_blast_box)*6 +($data[$i]->berry_blast_bar);
			 $mango=($data[$i]->mangoginger_box)*6 +($data[$i]->mangoginger_bar);
			 $chyawanprash=($data[$i]->chyawanprash_box)*6 +($data[$i]->chyawanprash_bar);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $data[$i]->date_of_visit);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->sales_rep_name);

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->rt_distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->zone);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->area);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->location);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $orange);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $butterscotch);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $bambaiya);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $mango);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $choco);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $berry);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $chyawanprash);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->variety_box);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->chocolate_cookies_box);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, $data[$i]->dark_chocolate_cookies_box);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->cranberry_cookies_box);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+17].$row, $data[$i]->fig_raisins_box);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+18].$row, $data[$i]->cranberry_orange_box);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+19].$row, $data[$i]->papaya_pineapple_box);

            

        }


        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[$col+19].$row)->applyFromArray(array(

            'borders' => array(

                'allborders' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN

                )

            )

        ));



        $objPHPExcel->getActiveSheet()->getStyle('A5:T5')->getFill()->applyFromArray(array(

            'type' => PHPExcel_Style_Fill::FILL_SOLID,

            'startcolor' => array(

                'hex' => '245478'

            )

        ));
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold( true );
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setName('Arial');

        for($col = 0; $col < 20; $col++) {

            $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[$col])->setAutoSize(true);

        }


		$date1 = date('d-m-Y_H-i-A');
        $filename='gt_stock_report'.$date1.'.xls';
       

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');

        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');



        $logarray['table_id']=$this->session->userdata('session_id');

        $logarray['module_name']='Reports';

        $logarray['cnt_name']='Reports';

        $logarray['action']='GT stock report generated.';

        $this->user_access_log_model->insertAccessLog($logarray);

    } else {

        echo '<script>alert("No data found");</script>';

    }	
}

public function get_task_cnt(){
    $sql="select E.*, concat(ifnull(F.first_name,''),' ',ifnull(F.last_name,'')) as user_name from 
            (select C.*,D.overdue from 
            (select A.*,B.open_task from 
            (select distinct(user_id) as user_id from user_task_detail) A 
            left join
            (SELECT user_id,count(*) as open_task FROM `user_task_detail` WHERE status='1' and follower='No' and due_date<=date(now()) and task_status<>'completed' GROUP by user_id) B
            on(A.user_id=B.user_id)) C
            left join
            (SELECT user_id,count(*) as overdue FROM `user_task_detail` WHERE status='1' and follower='No' and due_date< date(now()) and task_status<>'completed' GROUP by user_id) D
            on (C.user_id=D.user_id)) E
            LEFT JOIN
            (select * from user_master) F
            on (E.user_id=F.id) where (E.overdue is not null and E.overdue>0) or (E.open_task is not null and E.open_task>0)";
    $query=$this->db->query($sql);
    return $query->result();
}
 
public function get_pre_production_cnt(){
    $sql="select * from 
            (select C.*, D.overdue from 
            (select A.p_id, A.id, B.open from 
            (select * from production_details) A 
            left JOIN
            (SELECT Count(*) as open, reference_id FROM `notifications` WHERE notification_type='Pre Production' and date(now()) between date(notification_date) and (date(notification_date) + INTERVAL 2 DAY) 
            group by reference_id) B
            on (A.id=B.reference_id)) C
            left JOIN
            (SELECT Count(*) as overdue,reference_id FROM `notifications` WHERE notification_type='Pre Production' and  date(now()) >(date(notification_date) + INTERVAL 2 DAY)group by reference_id) D
            on (C.id=D.reference_id)) E where (E.overdue is not null and E.overdue>0) or (E.open is not null and E.open>0)";
    $query=$this->db->query($sql);
    return $query->result();
}
 
public function get_post_production_cnt(){
    $sql="select * from 
            (select C.*,D.overdue from 
            (select A.p_id,A.id, B.open from 
            (SELECT * from production_details) A 
            left JOIN 
            (SELECT Count(*) as open,reference_id FROM `notifications` WHERE notification_type='Post Production' and date(now())  between date(notification_date) and (date(notification_date) + INTERVAL 2 DAY) 
            group by reference_id) B 
            on (A.id=B.reference_id)) C 
            left JOIN 
            (SELECT Count(*) as overdue,reference_id FROM `notifications` WHERE notification_type='Post Production' and  date(now()) >(date(notification_date) + INTERVAL 2 DAY)group by reference_id) D 
            on (C.id=D.reference_id)) E where (E.overdue is not null and E.overdue>0) or (E.open is not null and E.open>0)";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_task_dtl(){
    $sql="select E.* from 
        (select C.task_id, C.subject_detail, C.priority, C.status, C.due_date, min(C.id) as id, 
            group_concat(distinct D.user_name) as user_name from 
        (select task_id, id, user_id, subject_detail, due_date, priority, status from user_task_detail 
            where status='1' and follower='No' and due_date<=date(now()) and task_status<>'completed') C 
        left join 
        (select id, concat(ifnull(first_name,''),' ',ifnull(last_name,'')) as user_name from user_master) D 
        on (C.user_id=D.id) 
        group by C.task_id, C.subject_detail, C.priority, C.status, C.due_date) E 
        order by E.task_id, E.id";
    $query=$this->db->query($sql);
    return $query->result();
}
 
public function get_pre_production_dtl(){
    $sql="select distinct C.*, D.p_id, D.manufacturer_id, D.from_date, D.to_date, D.confirm_from_date, 
                D.confirm_to_date, D.p_status, D.batch_master, D.production_details, D.bar_conversion, 
                D.depot_transfer, D.documents_upload, D.raw_material_recon, D.report_approved, 
                D.report_status, E.depot_name from 
            (select reference_id, notification, date_format(notification_date, '%d-%m-%Y') as notification_date from notifications where notification_type='Pre Production' and date(now()) between date(notification_date) and (date(notification_date) + INTERVAL 2 DAY) 
            union all 
            select reference_id, notification, date_format(notification_date, '%d-%m-%Y') as notification_date from notifications where notification_type='Pre Production' and date(now())>(date(notification_date) + INTERVAL 2 DAY)) C 
            left join 
            (select * from production_details) D on (C.reference_id=D.id) 
            left join 
            (select * from depot_master) E on (D.manufacturer_id=E.id) order by D.p_id";
    $query=$this->db->query($sql);
    return $query->result();
}
 
public function get_post_production_dtl(){
    $sql="select distinct C.*, D.p_id, D.manufacturer_id, D.from_date, D.to_date, D.confirm_from_date, 
                D.confirm_to_date, D.p_status, D.batch_master, D.production_details, D.bar_conversion, 
                D.depot_transfer, D.documents_upload, D.raw_material_recon, D.report_approved, 
                D.report_status, E.depot_name from 
            (select reference_id, notification, date_format(notification_date, '%d-%m-%Y') as notification_date from notifications where notification_type='Post Production' and date(now()) between date(notification_date) and (date(notification_date) + INTERVAL 2 DAY) 
            union all 
            select reference_id, notification, date_format(notification_date, '%d-%m-%Y') as notification_date from notifications where notification_type='Post Production' and date(now())>(date(notification_date) + INTERVAL 2 DAY)) C 
            left join 
            (select * from production_details) D on (C.reference_id=D.id) 
            left join 
            (select * from depot_master) E on (D.manufacturer_id=E.id) order by D.p_id";
    $query=$this->db->query($sql);
    return $query->result();
}

function get_po_count() {
    $sql = "select sum(case when status = 'Pending' then 1 else 0 end) as pending_cnt, 
                    sum(case when status = 'Approved' and po_status <> 'Closed' then 1 else 0 end) as open_cnt, 
                    sum(case when status = 'Approved' and po_status = 'Raw Material In' then 1 else 0 end) as pending_payment_cnt, 
                    sum(case when status = 'Approved' and po_status = 'Advance' then 1 else 0 end) as advance_payment_cnt 
            from purchase_order where status in ('Pending', 'Approved')";
    $query=$this->db->query($sql);
    return $query->result();
}

public function generate_sales_attendence_report(){ 
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));

    $sql="Select  A.sales_rep_name,Case When (check_in_time IS NULL OR working_status='Absent') THEN 'Absent' Else 'Present' end as emp_status,
            Case When CAST(check_in_time As Time)>CAST('10:00:00' As Time) AND CAST(check_in_time As Time)<CAST('11:00:00' As Time )  AND check_in_time IS NOT NULL Then 'L'
            When  check_in_time IS NULL Then 'A' else 'O' end as  emp_time,check_in_time,check_out_time,selected_date,
            Case
            When working_status='Present' AND (((check_in_time!=0 AND check_in_time!='') And (check_out_time!=0 AND check_out_time!='')) ) 
            Then (
            Case When CAST(check_out_time As Time)<CAST(check_in_time As Time ) 
            Then (CAST(ADDTIME(TIMEDIFF(check_out_time,'00:00'),TIMEDIFF('24:00:00',check_in_time)) as Time))  
            Else 
            cast(TIMEDIFF(check_out_time, check_in_time) as time)  end ) 
            else 0  
            end as effective_time,DAYNAME(selected_date) as week_day
            from (        
            Select A.*,F.check_in_time,F.check_out_time,F.working_status,F.sales_rep_id from (
            Select sales_rep_name,id,selected_date from 
            (SELECT * from sales_rep_master Where status='Approved' and sr_type IN ('Merchandizer','Sales Representative','Pramoter') )A
             Left Join
            (select * from 
            (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
             (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
             (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
             (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
             (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
             (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
            where selected_date between '$from_date' and '$to_date' ) B On 1=1 )A
            Left join
            (Select * from sales_attendence Where  date(check_in_time)>='$from_date' and date(check_in_time)<='$to_date') F On (A.id=F.sales_rep_id and date(A.selected_date)=date(F.check_in_time)) 
            ) A
            ORDER By selected_date DESC,emp_status DESC";

    $result = $this->db->query($sql)->result();
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    for($i=0; $i<=7; $i++) {
        $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
    }

    $row = 1;
    $col = 0;
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Wholesome Habits Private Limited ");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
    $row=$row+1;
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Sales Attendence");
    $row=$row+1;
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "From Date");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $from_date);
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "To Date");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $to_date);
    $row=$row+1;
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Lengends ");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "L-Late");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "O-On Time");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "A-Absent");

    /*$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);*/
    $row=$row+2;
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Name");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Status");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Date");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, "Week Day");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, "Check In Time");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, "Check Out Time");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, "Late Marks");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, "Effective Hours");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':H'.$row)->getFont()->setBold(true);
    $row = $row+1;

    foreach($result  as $dist) {
        if($dist->check_in_time!=null)
            $in_time = date("H:i A",strtotime($dist->check_in_time));
        else
            $in_time = '';

        if($dist->check_out_time!=null)
            $out_time = date("H:i A",strtotime($dist->check_out_time));
        else
            $out_time = '';

        /*$dateValue = PHPExcel_Shared_Date::PHPToExcel( 
        DateTime::createFromFormat('d-m-Y', ) 
        );*/
        /*$dateValue = PHPExcel_Style_NumberFormat::toFormattedString(date('d-m-Y',strtotime($dist->selected_date)), 'YYYY-MM-DD');*/

        $dateValue = PHPExcel_Style_NumberFormat::toFormattedString($dist->selected_date,PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD);

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row,$dist->sales_rep_name);
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row,$dist->emp_status);
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row,$dateValue);
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row,$dist->week_day);
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row,$in_time);
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row,$out_time );
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row,$dist->emp_time );
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row,$dist->effective_time );
        $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+2].$row)->getNumberFormat()->setFormatCode('dd/mm/yyyy');

        $row = $row+1;
    }

    for($col = 0; $col <=7; $col++) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[$col])->setAutoSize(true);
    }

    $date1 = date('d-m-Y_H-i-A');
    $filename='Sales_Attendence_Report_'.$date1.'.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
}

public function sales_rep_exception_report(){
    $sql="Select not_mapped, mapped, A.type from 
        (SELECT count(*) as not_mapped ,'Store' as type from 
        (Select A.store_name,Z.zone, L.location from 
        (SELECT F.store_name,D.zone_id,D.store_id,D.location_id from 
         (select * from store_master) D
         left join 
         (select * from relationship_master Where status='Approved' and type_id=7)F
         on (D.store_id=F.id)
         Where store_name is not null ) A
        Left JOIN location_master L On A.location_id=L.id
        Left JOIN zone_master Z On A.zone_id=Z.id
        Left Join (Select Distinct zone_id,store_id,location_id from merchandiser_beat_plan) B 
        ON (A.zone_id=B.zone_id AND A.store_id=B.store_id AND A.location_id=B.location_id)
        Where B.store_id is null and store_name is not null) A ) A
        Left join
        (SELECT count(*) as mapped ,'Store' as type from 
        (Select A.store_name,Z.zone, L.location from 
        (SELECT F.store_name,D.zone_id,D.store_id,D.location_id from 
         (select * from store_master) D
         left join 
         (select * from relationship_master Where status='Approved' and type_id=7)F
         on (D.store_id=F.id)
         Where store_name is not null ) A
        Left JOIN location_master L On A.location_id=L.id
        Left JOIN zone_master Z On A.zone_id=Z.id
        Left Join (Select Distinct zone_id,store_id,location_id from merchandiser_beat_plan) B 
        ON (A.zone_id=B.zone_id AND A.store_id=B.store_id AND A.location_id=B.location_id)
        Where B.store_id is not null and store_name is not null) B ) B On A.type=B.type
        Union All
        Select  not_mapped,mapped,A.type from
        (Select count(A.id) as not_mapped ,'Merchandiser' as type from 
        (select * from sales_rep_master where sr_type='Merchandizer' and status='Approved' order by sales_rep_name desc)A
        Left Join
        (Select Sum(Case When mon=0 OR tue=0 OR wed=0 OR thur=0 OR fri=0 OR sat=0 Then 0 Else 1 end) as fre_count,sales_rep_id
        from
        (
        Select sales_rep_id ,
        Sum(Case When frequency Like '%Mon%' Then 1 Else 0 end) as mon,
        Sum(Case When frequency Like '%Tue%' Then 1 Else 0 end) as tue,
        Sum(Case When frequency Like '%Wed%' Then 1 Else 0 end) as wed,
        Sum(Case When frequency Like '%Thur%' Then 1 Else 0 end) as thur,
        Sum(Case When frequency Like '%Fri%' Then 1 Else 0 end) as fri,
        Sum(Case When frequency Like '%Sat%' Then 1 Else 0 end) as sat 
        from merchandiser_beat_plan   GROUP By sales_rep_id 
        )A GROUP By sales_rep_id) B On A.id=B.sales_rep_id
        Where B.sales_rep_id IS NULL OR fre_count=0) A
        Left Join
        (Select count(A.id) as mapped ,'Merchandiser' as type from 
        (select * from sales_rep_master where sr_type='Merchandizer' and status='Approved' order by sales_rep_name desc)A
        Left Join
        (Select Sum(Case When mon=0 OR tue=0 OR wed=0 OR thur=0 OR fri=0 OR sat=0 Then 0 Else 1 end) as fre_count,sales_rep_id
        from
        (
        Select sales_rep_id ,
        Sum(Case When frequency Like '%Mon%' Then 1 Else 0 end) as mon,
        Sum(Case When frequency Like '%Tue%' Then 1 Else 0 end) as tue,
        Sum(Case When frequency Like '%Wed%' Then 1 Else 0 end) as wed,
        Sum(Case When frequency Like '%Thur%' Then 1 Else 0 end) as thur,
        Sum(Case When frequency Like '%Fri%' Then 1 Else 0 end) as fri,
        Sum(Case When frequency Like '%Sat%' Then 1 Else 0 end) as sat 
        from merchandiser_beat_plan   GROUP By sales_rep_id 
        )A GROUP By sales_rep_id) B On A.id=B.sales_rep_id
        Where B.sales_rep_id IS NOT NULL and fre_count<>0 ) B On A.type=B.type
        Union All
        Select  not_mapped,mapped,A.type from 
        (SELECT count(*) as not_mapped ,'Retailer' as type from  (
        SELECT distributor_name,Z.zone, L.location,A.area from 
        (select *,concat('d_',id) as store_id from distributor_master Where  type_id=3  and class in ('normal', 'direct') and distributor_name<>'') D
        Left JOIN location_master L On D.location_id=L.id
        Left JOIN zone_master Z On D.zone_id=Z.id
        Left JOIN area_master A On D.area_id=A.id
        Left Join (Select Distinct zone_id,store_id,location_id,area_id from sales_rep_beat_plan) B 
        ON (D.zone_id=B.zone_id AND B.store_id=D.store_id COLLATE utf8_unicode_ci AND D.location_id=B.location_id)
        Where B.store_id is null and distributor_name is not null
        ) A ) A
        Left Join
        (
        SELECT count(*) as mapped ,'Retailer' as type from  (
        SELECT distributor_name,Z.zone, L.location,A.area from 
        (select *,concat('d_',id) as store_id from distributor_master Where  type_id=3  and class in ('normal', 'direct') and distributor_name<>'') D
        Left JOIN location_master L On D.location_id=L.id
        Left JOIN zone_master Z On D.zone_id=Z.id
        Left JOIN area_master A On D.area_id=A.id
        Left Join (Select Distinct zone_id,store_id,location_id,area_id from sales_rep_beat_plan) B 
        ON (D.zone_id=B.zone_id AND B.store_id=D.store_id COLLATE utf8_unicode_ci AND D.location_id=B.location_id)
        Where B.store_id is not null and distributor_name is not null
        ) A
        ) B ON A.type=B.type        
        Union All
        Select  not_mapped,mapped,A.type from
        (Select count(A.id) as not_mapped ,'Sales Representative' as type from 
        (select * from sales_rep_master where sr_type='Sales Representative' and status='Approved' order by sales_rep_name desc)A
        Left Join
        (Select Sum(Case When mon=0 OR tue=0 OR wed=0 OR thur=0 OR fri=0 OR sat=0 Then 0 Else 1 end) as fre_count,sales_rep_id
        from
        (
        Select sales_rep_id ,
        Sum(Case When frequency Like '%Mon%' Then 1 Else 0 end) as mon,
        Sum(Case When frequency Like '%Tue%' Then 1 Else 0 end) as tue,
        Sum(Case When frequency Like '%Wed%' Then 1 Else 0 end) as wed,
        Sum(Case When frequency Like '%Thur%' Then 1 Else 0 end) as thur,
        Sum(Case When frequency Like '%Fri%' Then 1 Else 0 end) as fri,
        Sum(Case When frequency Like '%Sat%' Then 1 Else 0 end) as sat 
        from sales_rep_beat_plan   GROUP By sales_rep_id 
        )A GROUP By sales_rep_id) B On A.id=B.sales_rep_id
        Where B.sales_rep_id IS NULL OR fre_count=0) A
        Left Join
        (Select count(A.id) as mapped ,'Sales Representative' as type from 
        (select * from sales_rep_master where sr_type='Sales Representative' and status='Approved' order by sales_rep_name desc)A
        Left Join
        (Select Sum(Case When mon=0 OR tue=0 OR wed=0 OR thur=0 OR fri=0 OR sat=0 Then 0 Else 1 end) as fre_count,sales_rep_id
        from
        (
        Select sales_rep_id ,
        Sum(Case When frequency Like '%Mon%' Then 1 Else 0 end) as mon,
        Sum(Case When frequency Like '%Tue%' Then 1 Else 0 end) as tue,
        Sum(Case When frequency Like '%Wed%' Then 1 Else 0 end) as wed,
        Sum(Case When frequency Like '%Thur%' Then 1 Else 0 end) as thur,
        Sum(Case When frequency Like '%Fri%' Then 1 Else 0 end) as fri,
        Sum(Case When frequency Like '%Sat%' Then 1 Else 0 end) as sat 
        from sales_rep_beat_plan   GROUP By sales_rep_id 
        )A GROUP By sales_rep_id) B On A.id=B.sales_rep_id
        Where B.sales_rep_id IS NOT NULL and fre_count<>0 ) B On A.type=B.type";
    $query = $this->db->query($sql);
    $result = $query->result_array();
    $entry_table = '';

    for ($i=0; $i <count($result) ; $i++) { 
         /*$type = $result[$i]['type'];
         $mapped = $result[$i]['mapped'];
         $not_mapped = $result[$i]['not_mapped'];*/
         $entry_table.="<tr><td >".$result[$i]['type']."</td>";
         $entry_table.="<td style='text-align: center;'>".$result[$i]['mapped']."</td>";
         $entry_table.="<td style='text-align: center;'>".$result[$i]['not_mapped']."</td></tr>";
    }

    $subject = 'Sales Rep Exception Report - '.date("d-m-Y");

    $message = '<html>
                <body>
                    <h3>Wholesome Habits Private Limited</h3>
                    <h4>Sales Rep Exception Reporting</h4>
                    <p>Reporting Date - '.date("d-m-Y").'</p>
                    <table border="1" style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">Type</th>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">Mapped</th>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">UnMapped</th>
                            </tr>
                        </thead>
                        <tbody>'.$entry_table.'</tbody>
                    </table>
                    <br/><br/>
                    Regards,
                    <br/><br/>
                    CS
                </body>
                </html>';

    $message ;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Merchandiser");
    $col_name[]=array();

    /* Left join 
            (Select sales_rep_name,'Merchendiser' as type from sales_rep_master Where status='Approved' and sr_type='Merchandizer' and id NOT IN(Select DISTINCT sales_rep_id from merchandiser_beat_plan) 
           ) B On A.type=B.type*/

    $sql = "Select sales_rep_name ,'Merchandiser' as type,B.* from 
        (select * from sales_rep_master where sr_type='Merchandizer' and status='Approved' order by sales_rep_name desc)A
        Left Join
        (Select 
         Concat((Case When mon=0 Then 'Monday , ' Else '' end),(Case When tue=0 Then 'Tuesday , ' Else '' end)
         ,(Case When wed=0 Then 'Wednesday , ' Else '' end),(Case When thur=0 Then 'Thursday , ' Else '' end)
        ,(Case When fri=0 Then 'Friday , ' Else '' end),(Case When sat=0 Then 'Saturday , ' Else '' end)) as fet_fre,sales_rep_id
        from
        (
        Select sales_rep_id ,
        Sum(Case When frequency Like '%Mon%' Then 1 Else 0 end) as mon,
        Sum(Case When frequency Like '%Tue%' Then 1 Else 0 end) as tue,
        Sum(Case When frequency Like '%Wed%' Then 1 Else 0 end) as wed,
        Sum(Case When frequency Like '%Thur%' Then 1 Else 0 end) as thur,
        Sum(Case When frequency Like '%Fri%' Then 1 Else 0 end) as fri,
        Sum(Case When frequency Like '%Sat%' Then 1 Else 0 end) as sat 
        from merchandiser_beat_plan   GROUP By sales_rep_id 
        )A) B On A.id=B.sales_rep_id
        Where B.sales_rep_id IS NULL OR fet_fre<>''
           ";
    $result2 = $this->db->query($sql)->result();

    $sql = "Select Z.zone, L.location,CONCAT(A.store_name,' (',IFNULL(Z.zone,''),'-',IFNULL(L.location,'') ,')') as store_name from 
        (SELECT F.store_name,D.zone_id,D.store_id,D.location_id from 
         (select * from store_master) D
         left join 
         (select * from relationship_master Where type_id=7)F
         on (D.store_id=F.id)
         Where store_name is not null ) A
        Left JOIN location_master L On A.location_id=L.id
        Left JOIN zone_master Z On A.zone_id=Z.id
        Left Join (Select Distinct zone_id,store_id,location_id from merchandiser_beat_plan) B 
        ON (A.zone_id=B.zone_id AND A.store_id=B.store_id AND A.location_id=B.location_id)
        Where B.store_id is null  and store_name is not null
           ";
    $result = $this->db->query($sql)->result();

    for($i=0; $i<=3; $i++) {
        $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
    }

    $row = 1;
    $col = 0;
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Wholesome Habits Private Limited ");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
    $row=$row+1;
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Store/Merchandizer Not Mapped");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
    $row=$row+2;
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Store Not Mapped");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, "Merchendiser Not Mapped ");
    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, "Days Not Mapped");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getFont()->setBold(true);
    $row = $row+1;

    foreach($result  as $dist)
    {
       $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row,$dist->store_name);
       $row = $row+1;
    }

    $row = 5;
    foreach($result2  as $dist)
    {
       $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row,$dist->sales_rep_name);
       $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row,rtrim($dist->fet_fre,' ,'));
       $row = $row+1;
    }

    for($col = 0; $col < 3; $col++) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[$col])->setAutoSize(true);
    }


    $objPHPExcel->createSheet(1);
    $objPHPExcel->setActiveSheetIndex(1);
    $objPHPExcel->getActiveSheet()->setTitle("Sales Representative");
    $col2_name1 = array();
    $col2 = 0;
    $row=1;
    $sql = "SELECT CONCAT(distributor_name,' (',IFNULL(Z.zone,'') ,'-',IFNULL(L.location,'') ,'-',IFNULL(A.area,'') ,')') as distributor_name ,Z.zone, L.location,A.area from 
        (select *,concat('d_',id) as store_id from distributor_master Where  type_id=3  and class in ('normal', 'direct') and distributor_name<>'') D
        Left JOIN location_master L On D.location_id=L.id
        Left JOIN zone_master Z On D.zone_id=Z.id
        Left JOIN area_master A On D.area_id=A.id
        Left Join (Select Distinct zone_id,store_id,location_id,area_id from sales_rep_beat_plan) B 
        ON (D.zone_id=B.zone_id AND B.store_id=D.store_id COLLATE utf8_unicode_ci AND D.location_id=B.location_id)
        Where B.store_id is null and distributor_name is not null";
    $result2 = $this->db->query($sql)->result();


    $sql = "Select sales_rep_name ,'Sales Representative' as type,B.* from 
        (select * from sales_rep_master where sr_type='Sales Representative' and status='Approved' order by sales_rep_name desc)A
        Left Join
        (Select 
         Concat((Case When mon=0 Then 'Monday , ' Else '' end),(Case When tue=0 Then 'Tuesday , ' Else '' end)
         ,(Case When wed=0 Then 'Wednesday , ' Else '' end),(Case When thur=0 Then 'Thursday , ' Else '' end)
        ,(Case When fri=0 Then 'Friday , ' Else '' end),(Case When sat=0 Then 'Saturday , ' Else '' end)) as fet_fre,sales_rep_id
        from
        (
        Select sales_rep_id ,
        Sum(Case When frequency Like '%Mon%' Then 1 Else 0 end) as mon,
        Sum(Case When frequency Like '%Tue%' Then 1 Else 0 end) as tue,
        Sum(Case When frequency Like '%Wed%' Then 1 Else 0 end) as wed,
        Sum(Case When frequency Like '%Thur%' Then 1 Else 0 end) as thur,
        Sum(Case When frequency Like '%Fri%' Then 1 Else 0 end) as fri,
        Sum(Case When frequency Like '%Sat%' Then 1 Else 0 end) as sat 
        from sales_rep_beat_plan   GROUP By sales_rep_id 
        )A) B On A.id=B.sales_rep_id
        Where B.sales_rep_id IS NULL OR fet_fre<>''";
    $result = $this->db->query($sql)->result();

    for($i=0; $i<=3; $i++) {
      $col2_name1[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
    }

    $objPHPExcel->getActiveSheet()->setCellValue($col2_name1[$col2].$row, "Wholesome Habits Private Limited ");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
    $row=$row+1;
    $objPHPExcel->getActiveSheet()->setCellValue($col2_name1[$col2].$row, "Retailer/Representative Not Mapped");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
    $row=$row+2;
    $objPHPExcel->getActiveSheet()->setCellValue($col2_name1[$col2].$row, "Retailer Not Mapped");
    $objPHPExcel->getActiveSheet()->setCellValue($col2_name1[$col2+1].$row, "Sales Representative Not Mapped ");
    $objPHPExcel->getActiveSheet()->setCellValue($col2_name1[$col2+2].$row, "Days Not Mapped");
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getFont()->setBold(true);

    $row = $row+1;

    foreach($result2  as $dist)
    {
       $objPHPExcel->getActiveSheet()->setCellValue($col2_name1[$col2].$row,$dist->distributor_name);
       $row = $row+1;
    }

    $row = 5;
    foreach($result  as $dist)
    {
       $objPHPExcel->getActiveSheet()->setCellValue($col2_name1[$col2+1].$row,$dist->sales_rep_name);
       $objPHPExcel->getActiveSheet()->setCellValue($col2_name1[$col2+2].$row,rtrim($dist->fet_fre,' ,'));
       $row = $row+1;
    }

    for($col2 = 0; $col2 < 3; $col2++) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($col2_name1[$col2])->setAutoSize(true);
    }

    $date1 = date('d-m-Y_H-i-A');
    $filename='Sales_Exception_Report_'.$date1.'.xls';
    /*$path  = 'C:/xampp/htdocs/eat_erp_server/assets/uploads/exception_reports';*/
    // $path  ='/home/eatangcp/public_html/eat_erp/assets/uploads/exception_reports/';
    // $path  ='/var/www/html/eat_erp/assets/uploads/exception_reports/';

    $path = $this->config->item('upload_path').'exception_reports/';

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($path.$filename);
    $attachment = $path.$filename;
    $to_email = "prasad.bhisale@otbconsulting.co.in";
    $bcc = "dhaval.maru@otbconsulting.co.in";
    $cc = "prasad.bhisale@otbconsulting.co.in";
    $from_email = 'cs@eatanytime.in';
    $from_email_sender = 'Wholesome Habits Pvt Ltd';

    $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);
    if($mailSent==1){
        unlink($attachment);
    }

    /*$filename='merchandiser.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');*/
}

public function gt_store_report($save='',$region=array()){
    $cond='';
    if(count($region)>0){
        if(count($region)==1 && in_array('ALL',$region)) {
            $cond='';
        } else {   
            if(in_array('ALL',$region)) {
                unset($region[0]); 
                $region = "'" . implode ( "', '", $region ) . "'";
                $cond=' Where AA.location IN ('.$region.')';  
            } else {
                $region = "'" . implode ( "', '", $region ) . "'";
                $cond=' Where AA.location IN ('.$region.')'; 
            }
        }  
    }
    
    /*if(!in_array('ALL',$region))
    {   
        $region = "'" . implode ( "', '", $region ) . "'";
        $cond=' Where L.location IN ('.$region.')';
    }*/

    /* if($region!='' && $region!='ALL')
        $cond=' Where L.location="'.$region.'"';*/
   
    $sql = "select AA.*, ifnull(datediff(current_date(), AA.last_date_of_visit),0) as last_date_aging, 
            ifnull(datediff(current_date(), AA.order_date),0) as order_place_aging from 
            (select AA.distributor_name, AA.location, AA.area, AA.d_type, AA.item_id, sum(AA.item_qty) as item_qty, 
                group_concat(distinct AA.sales_rep_name) as sales_rep_name, group_concat(distinct AA.remarks) as remarks, 
                max(AA.order_date) as order_date, max(AA.date_of_visit) as last_date_of_visit, 
                min(AA.orange) as orange, min(AA.butterscotch) as butterscotch, min(AA.chocopeanut) as chocopeanut, 
                min(AA.mangoginger) as mangoginger, min(AA.berry_blast) as berry_blast, min(AA.chyawanprash) as chyawanprash, 
                min(AA.dark_chocolate_cookies) as dark_chocolate_cookies, min(AA.chocolate_cookies) as chocolate_cookies, 
                min(AA.cranberry_cookies) as cranberry_cookies, min(AA.cranberry_orange) as cranberry_orange, 
                min(AA.papaya_pineapple) as papaya_pineapple, min(AA.fig_raisins) as fig_raisins from 
                            
            (select AA.id, AA.distributor_name, AA.area_id, AA.location_id, AA.d_type, BB.date_of_visit, BB.remarks, FF.sales_rep_name, GG.area, HH.location, 
                CC.orange, CC.butterscotch, CC.chocopeanut, CC.mangoginger, CC.berry_blast, CC.chyawanprash, CC.dark_chocolate_cookies, CC.chocolate_cookies, 
                CC.cranberry_cookies, CC.cranberry_orange, CC.papaya_pineapple, CC.fig_raisins, DD.item_id, DD.item_qty, EE.order_date from 

            (select concat('d_',id) as id, distributor_name, area_id, location_id, 1 as d_type from distributor_master where status='approved' and class in ('normal', 'direct') 
            union 
            select concat('s_',id) as id, distributor_name, area_id, location_id, 2 as d_type from sales_rep_distributors) AA 

            left join 

            (select A.distributor_id, A.visit_id, B.date_of_visit, B.sales_rep_id, B.remarks from 
            (select distributor_id, max(id) as visit_id from sales_rep_location group by distributor_id) A 
            left join 
            (select * from sales_rep_location) B on (A.visit_id=B.id)) BB on (AA.id = BB.distributor_id) 

            left join 

            (select sales_rep_loc_id, 
                ((case when orange_bar is not null then orange_bar else 0 end )+(case when orange_box is not null then orange_box*6 else 0 end)) as orange, 
                ((case when butterscotch_bar is not null then butterscotch_bar else 0 end )+(case when butterscotch_box is not null then butterscotch_box*6 else 0 end)) as butterscotch, 
                ((case when chocopeanut_bar is not null then chocopeanut_bar else 0 end)+case when chocopeanut_box is not null then chocopeanut_box*6 else 0 end) as chocopeanut, 
                ((case when bambaiyachaat_bar is not null then bambaiyachaat_bar else 0 end)+case when bambaiyachaat_box is not null then bambaiyachaat_box*6 else 0 end) as bambaiyachaat, 
                ((case when mangoginger_bar is not null then mangoginger_bar else 0 end)+case when mangoginger_box is not null then mangoginger_box*6 else 0 end) as mangoginger, 
                ((case when berry_blast_bar is not null then berry_blast_bar else 0 end)+case when berry_blast_box is not null then berry_blast_box*6 else 0 end) as berry_blast, 
                ((case when chyawanprash_bar is not null then chyawanprash_bar else 0 end)+case when chyawanprash_box is not null then chyawanprash_box*6 else 0 end) as chyawanprash, 
                (case when chocolate_cookies_box is not null then chocolate_cookies_box*4 else 0 end) as chocolate_cookies, 
                (case when cranberry_orange_box is not null then cranberry_orange_box*4  else 0 end) as cranberry_orange, 
                (case when dark_chocolate_cookies_box is not null then dark_chocolate_cookies_box*8 else 0 end) as dark_chocolate_cookies, 
                (case when fig_raisins_box is not null then fig_raisins_box*2 else 0 end) as fig_raisins, 
                (case when papaya_pineapple_box is not null then papaya_pineapple_box*2 Else 0 end) as papaya_pineapple, 
                (case when cranberry_cookies_box is not null then cranberry_cookies_box*4 else 0 end) as cranberry_cookies, 
                variety_box, mint_box 
            from sales_rep_distributor_opening_stock) CC on (BB.visit_id = CC.sales_rep_loc_id) 

            left join 

            (select A.id as order_id, A.visit_id, B.item_id, B.item_qty from 
            (select id, visit_id from sales_rep_orders) A 
            left join 
            (select H.sales_rep_order_id, H.item_id, sum(H.item_qty) as item_qty from 
            (select E.sales_rep_order_id, case when E.type='Bar' then E.qty else (E.qty*F.qty) end  as item_qty, 
                case when E.type='Bar' then E.item_id else F.product_id end  as item_id from 
            (select * from sales_rep_order_items) E 
            left join box_product F on (E.type='Box' and (E.item_id=F.box_id)) 
            left join product_master G on (E.type='Bar' and (E.item_id=G.id))) H 
            group by H.sales_rep_order_id, H.item_id) B 
            on (A.id=B.sales_rep_order_id)) DD on (BB.visit_id = DD.visit_id) 

            left join 

            (select A.distributor_id, A.order_id, B.date_of_processing as order_date from 
            (select distributor_id, max(id) as order_id from sales_rep_orders group by distributor_id) A 
            left join 
            (select * from sales_rep_orders) B on (A.order_id=B.id)) EE on (AA.id = EE.distributor_id) 

            left join 

            (select * from sales_rep_master) FF on (BB.sales_rep_id=FF.id) 

            left join 

            (select * from area_master) GG on (AA.area_id=GG.id) 

            left join 

            (select * from location_master) HH on (AA.location_id=HH.id)) AA ".$cond."

            group by AA.distributor_name, AA.location, AA.area, AA.d_type, AA.item_id) AA 
            
            order by AA.d_type, AA.distributor_name, AA.location, AA.item_id desc";
    $data = $this->db->query($sql)->result();

    // echo json_encode($data);
    
    /*echo $this->db->last_query();
    die();*/

    $template_path=$this->config->item('template_path');
    $file = $template_path.'store_wise_sales.xls';
    $this->load->library('excel');
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $col_name[]=array();

    for($i=0; $i<=47; $i++) {
        $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
    }

    $col = 0;
    $row = 3;
    $distributor_name='';
    $area='';
    $location='';
    $nooforder=0;
    $j=0;    
    for($i=0;$i<count($data);$i++) {
        /* echo $distributor_name."<br>Test".$data[$i]->distributor_name;*/
        if($distributor_name!=$data[$i]->distributor_name || $location!=$data[$i]->location) {
            if($distributor_name!='') $row = $row+1;

            $nooforder=0;
            $distributor_name = $data[$i]->distributor_name;
            $area = $data[$i]->area;
            $location = $data[$i]->location;

            $j = $j+1;

            for ($k=5; $k<=40 ; $k++) { 
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+$k].$row, 0);  
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $j);     
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $data[$i]->distributor_name);  
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $data[$i]->location); 
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $data[$i]->area); 
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $data[$i]->sales_rep_name); 
           
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+42].$row, ($data[$i]->order_place_aging!=''?$data[$i]->order_place_aging:''));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+43].$row, ($data[$i]->last_date_aging!=''?$data[$i]->last_date_aging:''));
            if($data[$i]->last_date_of_visit!=''){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+44].$row, date("d-m-Y",strtotime($data[$i]->last_date_of_visit))); 
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col+44].$row)->getNumberFormat()->setFormatCode('dd/mm/yyyy');
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+45].$row, $data[$i]->remarks);

            if($data[$i]->orange!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+29].$row, $data[$i]->orange);
            if($data[$i]->butterscotch!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+30].$row, $data[$i]->butterscotch);
            if($data[$i]->chocopeanut!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+31].$row, $data[$i]->chocopeanut);
            if($data[$i]->mangoginger!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+32].$row, $data[$i]->mangoginger);
            if($data[$i]->berry_blast!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+33].$row, $data[$i]->berry_blast);
            if($data[$i]->chyawanprash!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+34].$row, $data[$i]->chyawanprash);
            if($data[$i]->dark_chocolate_cookies!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+35].$row, $data[$i]->dark_chocolate_cookies);
            if($data[$i]->chocolate_cookies!=NULL)
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+36].$row, $data[$i]->chocolate_cookies);
            if($data[$i]->cranberry_cookies!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+37].$row, $data[$i]->cranberry_cookies);
            if($data[$i]->cranberry_orange!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+38].$row, $data[$i]->cranberry_orange);
            if($data[$i]->papaya_pineapple!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+39].$row, $data[$i]->papaya_pineapple);
            if($data[$i]->fig_raisins!=NULL)
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+40].$row, $data[$i]->fig_raisins);
        }
        
        if($data[$i]->item_id==1) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==3) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==5) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==6) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==9) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==10) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==38) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==37) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==39) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==42) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+14].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==41) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+15].$row, $data[$i]->item_qty);
        } else if($data[$i]->item_id==40) {
            $nooforder = $nooforder+$data[$i]->item_qty;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+16].$row, $data[$i]->item_qty);
        }

        /*if(!isset($nooforder))
        {
            echo '<br>'.$i;

            die();
        }*/

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+41].$row, $nooforder); 
    }
    
    for($col = 0; $col < 42; $col++) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[$col])->setAutoSize(true);
    }

    $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[45])->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension($col_name[44])->setAutoSize(true);

    /*die();*/
    $date1 = date('d-m-Y_H-i-A');
    $filename='Store_wise_sales_'.$date1.'.xls';
    if($save=='') {
        // $path  ='/home/eatangcp/public_html/eat_erp/assets/uploads/exception_reports/';
        // $path  ='/var/www/html/eat_erp/assets/uploads/exception_reports/';

        $path = $this->config->item('upload_path').'exception_reports/';

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($path.$filename);
        $attachment = $path.$filename;
        $to_email = "prasad.bhisale@otbconsulting.co.in";
        $bcc = "";
        $cc = "";
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'Wholesome Habits Pvt Ltd';
        $subject='GT Store Report';
        // $report_date = '11-07-2019';
        $report_date = date('d-m-Y');
        $message = '<html>
                    <body>
                        <h3>Wholesome Habits Private Limited</h3>
                        <h4>GT Store Report</h4>
                        <p>Reporting Date - '.$report_date.'</p>
                        <p>PFA</p>
                        <br/><br/>
                        Regards,
                        <br/><br/>
                        CS
                    </body>
                    </html>';

        $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);
        if($mailSent==1) {
            unlink($attachment);
        }
    } else {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
    /*header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0'); 
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');*/
}

public function get_gt_location(){
   $result = $this->db->query('Select Distinct location from location_master Where type_id=3')->result();
   return $result;
}

public function test_month(){
    $start = new DateTime('2018-04-25');
    $start->modify('first day of this month');
    $end = new DateTime('2019-06-20');
    $end->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($start, $interval, $end);

    foreach ($period as $dt) {
        echo $dt->format("Y-m") . "<br>\n";
    }
}

function generate_monthly_sales_overview_report() {
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

    // $from_date = '2018-04-01';
    // $to_date = '2019-03-31';

    $mon_period = [];
    $start = new DateTime($from_date);
    $start->modify('first day of this month');
    $end = new DateTime($to_date);
    $end->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($start, $interval, $end);
    $cnt = 0;

    foreach ($period as $dt) {
        $mon = $dt->format("M-y");
        $mon_period[$mon]['month'] = $mon;
        $mon_period[$mon]['target_sales'] = 0;
        $mon_period[$mon]['sold_bars'] = 0;
        $mon_period[$mon]['sales_enery_bars'] = 0;
        $mon_period[$mon]['sales_cookies'] = 0;
        $mon_period[$mon]['sales_trail_mix'] = 0;
        $mon_period[$mon]['sales_return_bars'] = 0;
        $mon_period[$mon]['sales_return_enery_bars'] = 0;
        $mon_period[$mon]['sales_return_cookies'] = 0;
        $mon_period[$mon]['sales_return_trail_mix'] = 0;
        $mon_period[$mon]['sales_incl_tax'] = 0;
        $mon_period[$mon]['sales_return_incl_tax'] = 0;
        $mon_period[$mon]['credit_debit_note'] = 0;
        $mon_period[$mon]['sample_bars'] = 0;
        $mon_period[$mon]['expired_bars'] = 0;
        $mon_period[$mon]['productwise_sales'] = 0;
        $mon_period[$mon]['productwise_sales_return'] = 0;
        $mon_period[$mon]['channelwise_sales'] = 0;
        $mon_period[$mon]['channelwise_sales_return'] = 0;
        $mon_period[$mon]['zonewise_sales'] = 0;
        $cnt++;
    }

    $sql = "select A.particular, A.year_no, A.mon_no, A.mon_name, sum(qty) as tot_qty from 
            (select case when A.distributor_id='1' then 'Sample' when A.distributor_id='189' then 'Expired' else 'Sales' end as particular, 
                DATE_FORMAT(A.invoice_date,'%Y') as year_no, DATE_FORMAT(A.invoice_date,'%y%m') as mon_no, 
                DATE_FORMAT(A.invoice_date,'%b-%y') as mon_name, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as qty 
            from distributor_out A 
            left join distributor_out_items B on (A.id=B.distributor_out_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date') A 
            group by A.particular, A.year_no, A.mon_no, A.mon_name 
            order by A.year_no, A.mon_no";
    $data = $this->db->query($sql)->result_array();
    for($i=0; $i<count($data); $i++) {
        if($data[$i]['particular']=='Sales') {
            $mon_period[$data[$i]['mon_name']]['sold_bars'] = $data[$i]['tot_qty'];
        } else if($data[$i]['particular']=='Sample') {
            $mon_period[$data[$i]['mon_name']]['sample_bars'] = $data[$i]['tot_qty'];
        } else if($data[$i]['particular']=='Expired') {
            $mon_period[$data[$i]['mon_name']]['expired_bars'] = $data[$i]['tot_qty'];
        }
    }

    $sql = "select A.particular, A.year_no, A.mon_no, A.mon_name, A.category_name, sum(qty) as tot_qty from 
            (select D.*, F.category_name from 
            (select case when A.distributor_id='1' then 'Sample' when A.distributor_id='189' then 'Expired' else 'Sales' end as particular, 
                DATE_FORMAT(A.invoice_date,'%Y') as year_no, DATE_FORMAT(A.invoice_date,'%y%m') as mon_no, 
                DATE_FORMAT(A.invoice_date,'%b-%y') as mon_name, 
                case when B.type='Bar' then B.item_id else C.product_id end as item_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as qty 
            from distributor_out A 
            left join distributor_out_items B on (A.id=B.distributor_out_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date') D 
            left join product_master E on (D.item_id=E.id) 
            left join category_master F on (E.category_id=F.id))A 
            group by A.particular, A.year_no, A.mon_no, A.mon_name, A.category_name 
            order by A.year_no, A.mon_no, A.category_name";
    $data = $this->db->query($sql)->result_array();
    for($i=0; $i<count($data); $i++) {
        if($data[$i]['particular']=='Sales') {
            if($data[$i]['category_name']=='Energy Bar') {
                $mon_period[$data[$i]['mon_name']]['sales_enery_bars'] = $data[$i]['tot_qty'];
            } else if($data[$i]['category_name']=='Cookies') {
                $mon_period[$data[$i]['mon_name']]['sales_cookies'] = $data[$i]['tot_qty'];
            } else if($data[$i]['category_name']=='Trail Mix') {
                $mon_period[$data[$i]['mon_name']]['sales_trail_mix'] = $data[$i]['tot_qty'];
            }
        } else if($data[$i]['particular']=='Sample') {
            if($data[$i]['category_name']=='Energy Bar') {
                $mon_period[$data[$i]['mon_name']]['sample_enery_bars'] = $data[$i]['tot_qty'];
            } else if($data[$i]['category_name']=='Cookies') {
                $mon_period[$data[$i]['mon_name']]['sample_cookies'] = $data[$i]['tot_qty'];
            } else if($data[$i]['category_name']=='Trail Mix') {
                $mon_period[$data[$i]['mon_name']]['sample_trail_mix'] = $data[$i]['tot_qty'];
            }
        } else if($data[$i]['particular']=='Expired') {
            if($data[$i]['category_name']=='Energy Bar') {
                $mon_period[$data[$i]['mon_name']]['expired_enery_bars'] = $data[$i]['tot_qty'];
            } else if($data[$i]['category_name']=='Cookies') {
                $mon_period[$data[$i]['mon_name']]['expired_cookies'] = $data[$i]['tot_qty'];
            } else if($data[$i]['category_name']=='Trail Mix') {
                $mon_period[$data[$i]['mon_name']]['expired_trail_mix'] = $data[$i]['tot_qty'];
            }
        }
    }

    $sql = "select A.year_no, A.mon_no, A.mon_name, sum(final_amount) as tot_amount from 
            (select DATE_FORMAT(A.invoice_date,'%Y') as year_no, DATE_FORMAT(A.invoice_date,'%y%m') as mon_no, 
                DATE_FORMAT(A.invoice_date,'%b-%y') as mon_name, (ifnull(A.final_amount,0)+ifnull(A.round_off_amount,0)) as final_amount 
            from distributor_out A 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) A 
            group by A.year_no, A.mon_no, A.mon_name 
            order by A.year_no, A.mon_no";
    $data = $this->db->query($sql)->result_array();
    for($i=0; $i<count($data); $i++) {
        $mon_period[$data[$i]['mon_name']]['sales_incl_tax'] = $data[$i]['tot_amount'];
    }

    $sql = "select A.year_no, A.mon_no, A.mon_name, sum(qty) as tot_qty from 
            (select DATE_FORMAT(A.sales_return_date,'%Y') as year_no, DATE_FORMAT(A.sales_return_date,'%y%m') as mon_no, 
                DATE_FORMAT(A.sales_return_date,'%b-%y') as mon_name, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as qty 
            from distributor_in A 
            left join distributor_in_items B on (A.id=B.distributor_in_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) A 
            group by A.year_no, A.mon_no, A.mon_name 
            order by A.year_no, A.mon_no";
    $data = $this->db->query($sql)->result_array();
    for($i=0; $i<count($data); $i++) {
        $mon_period[$data[$i]['mon_name']]['sales_return_bars'] = $data[$i]['tot_qty']*-1;
    }

    $sql = "select A.year_no, A.mon_no, A.mon_name, A.category_name, sum(qty) as tot_qty from 
            (select D.*, F.category_name from 
            (select DATE_FORMAT(A.sales_return_date,'%Y') as year_no, DATE_FORMAT(A.sales_return_date,'%y%m') as mon_no, 
                DATE_FORMAT(A.sales_return_date,'%b-%y') as mon_name, 
                case when B.type='Bar' then B.item_id else C.product_id end as item_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as qty 
            from distributor_in A 
            left join distributor_in_items B on (A.id=B.distributor_in_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join product_master E on (D.item_id=E.id) 
            left join category_master F on (E.category_id=F.id)) A 
            group by A.year_no, A.mon_no, A.mon_name, A.category_name 
            order by A.year_no, A.mon_no, A.category_name";
    $data = $this->db->query($sql)->result_array();
    for($i=0; $i<count($data); $i++) {
        if($data[$i]['category_name']=='Energy Bar') {
            $mon_period[$data[$i]['mon_name']]['sales_return_enery_bars'] = $data[$i]['tot_qty']*-1;
        } else if($data[$i]['category_name']=='Cookies') {
            $mon_period[$data[$i]['mon_name']]['sales_return_cookies'] = $data[$i]['tot_qty']*-1;
        } else if($data[$i]['category_name']=='Trail Mix') {
            $mon_period[$data[$i]['mon_name']]['sales_return_trail_mix'] = $data[$i]['tot_qty']*-1;
        }
    }

    $sql = "select A.year_no, A.mon_no, A.mon_name, sum(A.final_amount) as tot_amount from 
            (select DATE_FORMAT(A.sales_return_date,'%Y') as year_no, DATE_FORMAT(A.sales_return_date,'%y%m') as mon_no, 
                DATE_FORMAT(A.sales_return_date,'%b-%y') as mon_name, (ifnull(A.final_amount,0)+ifnull(A.round_off_amount,0)) as final_amount 
            from distributor_in A 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) A 
            group by A.year_no, A.mon_no, A.mon_name 
            order by A.year_no, A.mon_no";
    $data = $this->db->query($sql)->result_array();
    for($i=0; $i<count($data); $i++) {
        $mon_period[$data[$i]['mon_name']]['sales_return_incl_tax'] = $data[$i]['tot_amount']*-1;
    }

    $sql = "select A.year_no, A.mon_no, A.mon_name, sum(A.amount) as tot_amount from 
            (select DATE_FORMAT(A.date_of_transaction,'%Y') as year_no, DATE_FORMAT(A.date_of_transaction,'%y%m') as mon_no, 
                DATE_FORMAT(A.date_of_transaction,'%b-%y') as mon_name, 
                case when (A.transaction='Credit Note' or A.transaction='Expense Voucher') then round(A.amount,0) 
                    else (round(A.amount,0)*-1) end as amount 
            from credit_debit_note A 
            where A.status='Approved' and A.date_of_transaction>='$from_date' and A.date_of_transaction<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) A 
            group by A.year_no, A.mon_no, A.mon_name 
            order by A.year_no, A.mon_no";
    $data = $this->db->query($sql)->result_array();
    for($i=0; $i<count($data); $i++) {
        $mon_period[$data[$i]['mon_name']]['credit_debit_note'] = $data[$i]['tot_amount'];
    }

    $sql = "select distinct concat(H.item_type, '-', H.item_name) as item, H.item_type, H.item_name from 
            (select G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name, sum(G.item_qty) as tot_qty from 
            (select D.year_no, D.mon_no, D.mon_name, D.item_type, case when D.item_type='Bar' then E.short_name else F.short_name end as item_name, D.item_qty from 
            (select DATE_FORMAT(A.invoice_date,'%Y') as year_no, DATE_FORMAT(A.invoice_date,'%y%m') as mon_no, DATE_FORMAT(A.invoice_date,'%b-%y') as mon_name, 
                case when B.type='Box' and B.item_id in (4, 13, 14, 32) then 'Box' else 'Bar' end as item_type, 
                case when B.type='Box' and B.item_id in (4, 13, 14, 32) then B.item_id when B.type='Bar' then B.item_id else C.product_id end as item_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_out A 
            left join distributor_out_items B on (A.id=B.distributor_out_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join product_master E on (D.item_type='Bar' and D.item_id=E.id) 
            left join box_master F on (D.item_type='Box' and D.item_id=F.id)) G 
            group by G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name 
            order by G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name) H 
            order by H.item_type, H.item_name";
    $sales_items = $this->db->query($sql)->result_array();

    $sql = "select G.year_no, G.mon_no, G.mon_name, concat(G.item_type, '-', G.item_name) as item, G.item_type, G.item_name, 
            sum(G.item_qty) as tot_qty from 
            (select D.year_no, D.mon_no, D.mon_name, D.item_type, case when D.item_type='Bar' then E.short_name else F.short_name end as item_name, D.item_qty from 
            (select DATE_FORMAT(A.invoice_date,'%Y') as year_no, DATE_FORMAT(A.invoice_date,'%y%m') as mon_no, DATE_FORMAT(A.invoice_date,'%b-%y') as mon_name, 
                case when B.type='Box' and B.item_id in (4, 13, 14, 32) then 'Box' else 'Bar' end as item_type, 
                case when B.type='Box' and B.item_id in (4, 13, 14, 32) then B.item_id when B.type='Bar' then B.item_id else C.product_id end as item_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_out A 
            left join distributor_out_items B on (A.id=B.distributor_out_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join product_master E on (D.item_type='Bar' and D.item_id=E.id) 
            left join box_master F on (D.item_type='Box' and D.item_id=F.id)) G 
            group by G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name 
            order by G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_qty'=>$data[$i]['tot_qty']);
        if($i==count($data)-1) {
            $mon_period[$data[$i]['mon_name']]['productwise_sales']=$arr;
            $arr=[];
        } else if($data[$i]['year_no']!=$data[$i+1]['year_no'] || $data[$i]['mon_no']!=$data[$i+1]['mon_no']) {
            $mon_period[$data[$i]['mon_name']]['productwise_sales']=$arr;
            $arr=[];
        }
    }

    $sql = "select distinct concat(H.item_type, '-', H.item_name) as item, H.item_type, H.item_name from 
            (select G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name, sum(G.item_qty) as tot_qty from 
            (select D.year_no, D.mon_no, D.mon_name, D.item_type, case when D.item_type='Bar' then E.short_name else F.short_name end as item_name, D.item_qty from 
            (select DATE_FORMAT(A.sales_return_date,'%Y') as year_no, DATE_FORMAT(A.sales_return_date,'%y%m') as mon_no, DATE_FORMAT(A.sales_return_date,'%b-%y') as mon_name, 
                case when B.type='Box' and B.item_id in (4, 13, 14, 32) then 'Box' else 'Bar' end as item_type, 
                case when B.type='Box' and B.item_id in (4, 13, 14, 32) then B.item_id when B.type='Bar' then B.item_id else C.product_id end as item_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_in A 
            left join distributor_in_items B on (A.id=B.distributor_in_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join product_master E on (D.item_type='Bar' and D.item_id=E.id) 
            left join box_master F on (D.item_type='Box' and D.item_id=F.id)) G 
            group by G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name 
            order by G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name) H 
            order by H.item_type, H.item_name";
    $sales_return_items = $this->db->query($sql)->result_array();

    $sql = "select G.year_no, G.mon_no, G.mon_name, concat(G.item_type, '-', G.item_name) as item, G.item_type, G.item_name, 
            sum(G.item_qty) as tot_qty from 
            (select D.year_no, D.mon_no, D.mon_name, D.item_type, case when D.item_type='Bar' then E.short_name else F.short_name end as item_name, D.item_qty from 
            (select DATE_FORMAT(A.sales_return_date,'%Y') as year_no, DATE_FORMAT(A.sales_return_date,'%y%m') as mon_no, DATE_FORMAT(A.sales_return_date,'%b-%y') as mon_name, 
                case when B.type='Box' and B.item_id in (4, 13, 14, 32) then 'Box' else 'Bar' end as item_type, 
                case when B.type='Box' and B.item_id in (4, 13, 14, 32) then B.item_id when B.type='Bar' then B.item_id else C.product_id end as item_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_in A 
            left join distributor_in_items B on (A.id=B.distributor_in_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join product_master E on (D.item_type='Bar' and D.item_id=E.id) 
            left join box_master F on (D.item_type='Box' and D.item_id=F.id)) G 
            group by G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name 
            order by G.year_no, G.mon_no, G.mon_name, G.item_type, G.item_name";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_qty'=>$data[$i]['tot_qty']);
        if($i==count($data)-1) {
            $mon_period[$data[$i]['mon_name']]['productwise_sales_return']=$arr;
            $arr=[];
        } else if($data[$i]['year_no']!=$data[$i+1]['year_no'] || $data[$i]['mon_no']!=$data[$i+1]['mon_no']) {
            $mon_period[$data[$i]['mon_name']]['productwise_sales_return']=$arr;
            $arr=[];
        }
    }

    $sql = "select distinct G.distributor_type as item, G.distributor_type as item_name from 
            (select distinct D.distributor_id, E.type_id, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end as distributor_type from 
            (select distinct A.distributor_id from distributor_out A where A.status='Approved' and 
                A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id)) G 
            order by G.distributor_type";
    $channelwise_sales = $this->db->query($sql)->result_array();

    $sql = "select G.year_no, G.mon_no, G.mon_name, G.distributor_type as item, 
            G.distributor_type as item_name, sum(G.item_qty) as tot_qty from 
            (select D.year_no, D.mon_no, D.mon_name, D.distributor_id, D.item_qty, E.type_id, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end as distributor_type from 
            (select DATE_FORMAT(A.invoice_date,'%Y') as year_no, DATE_FORMAT(A.invoice_date,'%y%m') as mon_no, DATE_FORMAT(A.invoice_date,'%b-%y') as mon_name, A.distributor_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_out A 
            left join distributor_out_items B on (A.id=B.distributor_out_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id)) G 
            group by G.year_no, G.mon_no, G.mon_name, G.distributor_type 
            order by G.year_no, G.mon_no, G.mon_name, G.distributor_type";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_qty'=>$data[$i]['tot_qty']);
        if($i==count($data)-1) {
            $mon_period[$data[$i]['mon_name']]['channelwise_sales']=$arr;
            $arr=[];
        } else if($data[$i]['year_no']!=$data[$i+1]['year_no'] || $data[$i]['mon_no']!=$data[$i+1]['mon_no']) {
            $mon_period[$data[$i]['mon_name']]['channelwise_sales']=$arr;
            $arr=[];
        }
    }

    $sql = "select distinct G.distributor_type as item, G.distributor_type as item_name from 
            (select D.distributor_id, E.type_id, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end as distributor_type from 
            (select distinct A.distributor_id from distributor_in A 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id)) G 
            order by G.distributor_type";
    $channelwise_sales_return = $this->db->query($sql)->result_array();

    $sql = "select G.year_no, G.mon_no, G.mon_name, G.distributor_type as item, 
            G.distributor_type as item_name, sum(G.item_qty) as tot_qty from 
            (select D.year_no, D.mon_no, D.mon_name, D.distributor_id, D.item_qty, E.type_id, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end as distributor_type from 
            (select DATE_FORMAT(A.sales_return_date,'%Y') as year_no, DATE_FORMAT(A.sales_return_date,'%y%m') as mon_no, DATE_FORMAT(A.sales_return_date,'%b-%y') as mon_name, A.distributor_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_in A 
            left join distributor_in_items B on (A.id=B.distributor_in_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id)) G 
            group by G.year_no, G.mon_no, G.mon_name, G.distributor_type 
            order by G.year_no, G.mon_no, G.mon_name, G.distributor_type";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_qty'=>$data[$i]['tot_qty']);
        if($i==count($data)-1) {
            $mon_period[$data[$i]['mon_name']]['channelwise_sales_return']=$arr;
            $arr=[];
        } else if($data[$i]['year_no']!=$data[$i+1]['year_no'] || $data[$i]['mon_no']!=$data[$i+1]['mon_no']) {
            $mon_period[$data[$i]['mon_name']]['channelwise_sales_return']=$arr;
            $arr=[];
        }
    }

    $sql = "select distinct C.zone as item, C.zone as item_name from 
            (select distinct distributor_id from distributor_out where status='Approved' and 
                invoice_date>='$from_date' and invoice_date<='$to_date' and 
                (distributor_id!='1' and distributor_id!='189') 
            union all 
            select distinct distributor_id from distributor_in where status='Approved' and 
                sales_return_date>='$from_date' and sales_return_date<='$to_date' and 
                (distributor_id!='1' and distributor_id!='189')) A 
            left join distributor_master B on (A.distributor_id=B.id) 
            left join zone_master C on (B.zone_id=C.id)";
    $zonewise_sales = $this->db->query($sql)->result_array();

    $sql = "select G.year_no, G.mon_no, G.mon_name, G.zone as item, 
            G.zone as item_name, sum(G.item_qty) as tot_qty from 
            (select D.year_no, D.mon_no, D.mon_name, D.distributor_id, D.item_qty, E.zone_id, F.zone from 
            (select DATE_FORMAT(A.invoice_date,'%Y') as year_no, DATE_FORMAT(A.invoice_date,'%y%m') as mon_no, DATE_FORMAT(A.invoice_date,'%b-%y') as mon_name, A.distributor_id, 
                case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_out A 
            left join distributor_out_items B on (A.id=B.distributor_out_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189') 
            union all 
            select DATE_FORMAT(A.sales_return_date,'%Y') as year_no, DATE_FORMAT(A.sales_return_date,'%y%m') as mon_no, DATE_FORMAT(A.sales_return_date,'%b-%y') as mon_name, A.distributor_id, 
                (case when B.type='Bar' then B.qty else B.qty*C.qty end)*-1 as item_qty 
            from distributor_in A 
            left join distributor_in_items B on (A.id=B.distributor_in_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join zone_master F on (E.zone_id=F.id)) G 
            group by G.year_no, G.mon_no, G.mon_name, G.zone 
            order by G.year_no, G.mon_no, G.mon_name, G.zone";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_qty'=>$data[$i]['tot_qty']);
        if($i==count($data)-1) {
            $mon_period[$data[$i]['mon_name']]['zonewise_sales']=$arr;
            $arr=[];
        } else if($data[$i]['year_no']!=$data[$i+1]['year_no'] || $data[$i]['mon_no']!=$data[$i+1]['mon_no']) {
            $mon_period[$data[$i]['mon_name']]['zonewise_sales']=$arr;
            $arr=[];
        }
    }

    if(count($mon_period)>0) {
        // $this->load->library('excel');
        // $objPHPExcel = new PHPExcel();

        $template_path=$this->config->item('template_path');
        $file = $template_path.'Monthly_sales_overview.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $objPHPExcel->setActiveSheetIndex(0);
        $col_name[]=array();
        for($i=0; $i<=$cnt+20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('B7', date('d-m-Y', strtotime($from_date)));
        $objPHPExcel->getActiveSheet()->setCellValue('B8', date('d-m-Y', strtotime($to_date)));

        $row = 46;
        $sales_return_row = 49;
        $channelwise_sales_row = 53;
        $channelwise_sales_return_row = 57;
        $zonewise_sales_row = 61;
        $col=0;
        for($i=0; $i<count($sales_items); $i++) {
            if($i!=0){
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $sales_items[$i]['item_name']);
            $row = $row + 1;
            $sales_return_row = $sales_return_row + 1;
            $channelwise_sales_row = $channelwise_sales_row + 1;
            $channelwise_sales_return_row = $channelwise_sales_return_row + 1;
            $zonewise_sales_row = $zonewise_sales_row + 1;
        }

        $row = $sales_return_row;
        for($i=0; $i<count($sales_return_items); $i++) {
            if($i!=0){
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $sales_return_items[$i]['item_name']);
            $row = $row + 1;
            $channelwise_sales_row = $channelwise_sales_row + 1;
            $channelwise_sales_return_row = $channelwise_sales_return_row + 1;
            $zonewise_sales_row = $zonewise_sales_row + 1;
        }

        $channelwise_sales_row = $channelwise_sales_row - 1;
        $row = $channelwise_sales_row;
        for($i=0; $i<count($channelwise_sales); $i++) {
            if($i!=0){
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $channelwise_sales[$i]['item_name']);
            $row = $row + 1;
            $channelwise_sales_return_row = $channelwise_sales_return_row + 1;
            $zonewise_sales_row = $zonewise_sales_row + 1;
        }

        $channelwise_sales_return_row = $channelwise_sales_return_row - 2;
        $row = $channelwise_sales_return_row;
        for($i=0; $i<count($channelwise_sales_return); $i++) {
            if($i!=0){
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $channelwise_sales_return[$i]['item_name']);
            $row = $row + 1;
            $zonewise_sales_row = $zonewise_sales_row + 1;
        }

        $zonewise_sales_row = $zonewise_sales_row - 3;
        $row = $zonewise_sales_row;
        for($i=0; $i<count($zonewise_sales); $i++) {
            if($i!=0){
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $zonewise_sales[$i]['item_name']);
            $row = $row + 1;
        }


        $row=1;
        $col=1;
        $start_col=1;
        $cnt2=1;
        foreach ($period as $dt) {
            $mon = $dt->format("M-y");
            $mon_no = $dt->format("m");

            if($col!=1){
                $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], 1);
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'14', $mon_period[$mon]['month']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'15', '60000');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'16', $mon_period[$mon]['sold_bars']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'17', $mon_period[$mon]['sales_enery_bars']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'18', $mon_period[$mon]['sales_cookies']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'19', $mon_period[$mon]['sales_trail_mix']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'20', $mon_period[$mon]['sales_return_bars']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'21', $mon_period[$mon]['sales_return_enery_bars']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'22', $mon_period[$mon]['sales_return_cookies']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'23', $mon_period[$mon]['sales_return_trail_mix']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'24', '=sum('.$col_name[$col].'16,'.$col_name[$col].'20)');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'25', '=sum('.$col_name[$col].'17,'.$col_name[$col].'21)');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'26', '=sum('.$col_name[$col].'18,'.$col_name[$col].'22)');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'27', '=sum('.$col_name[$col].'19,'.$col_name[$col].'23)');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'28', '='.$col_name[$col].'24/'.$col_name[$col].'15');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'30', $mon_period[$mon]['sales_incl_tax']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'31', $mon_period[$mon]['sales_return_incl_tax']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'32', $mon_period[$mon]['credit_debit_note']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'33', '=sum('.$col_name[$col].'30:'.$col_name[$col].'32)');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'35', '='.$col_name[$col].'33/'.$col_name[$col].'16');
            if($col==1) {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'36', '0');
            } else {
                if($col==$start_col) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'36', '=('.$col_name[$col].'33-'.$col_name[$col-2].'33)/'.$col_name[$col].'33');
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'36', '=('.$col_name[$col].'33-'.$col_name[$col-1].'33)/'.$col_name[$col].'33');
                }
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'38', $mon_period[$mon]['sample_bars']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'39', '='.$col_name[$col].'38*15');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'40', '='.$col_name[$col].'39/'.$col_name[$col].'33');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'41', $mon_period[$mon]['expired_bars']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'42', '='.$col_name[$col].'41*15');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'43', '='.$col_name[$col].'42/'.$col_name[$col].'33');

            $row2 = 46;
            $arr = $mon_period[$mon]['productwise_sales'];
            for($i=0; $i<count($sales_items); $i++) {
                if(isset($arr[$sales_items[$i]['item']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $arr[$sales_items[$i]['item']]['tot_qty']);
                }
                $row2 = $row2 + 1;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'45', '=sum('.$col_name[$col].'46:'.$col_name[$col].($row2-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].'45-'.$col_name[$col].'16');

            $row2 = $sales_return_row;
            $arr = $mon_period[$mon]['productwise_sales_return'];
            for($i=0; $i<count($sales_return_items); $i++) {
                if(isset($arr[$sales_return_items[$i]['item']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $arr[$sales_return_items[$i]['item']]['tot_qty']*-1);
                }
                $row2 = $row2 + 1;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($sales_return_row-1), '=sum('.$col_name[$col].$sales_return_row.':'.$col_name[$col].($row2-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].($sales_return_row-1).'-'.$col_name[$col].'20');

            $row2 = $channelwise_sales_row;
            $arr = $mon_period[$mon]['channelwise_sales'];
            for($i=0; $i<count($channelwise_sales); $i++) {
                if(isset($arr[$channelwise_sales[$i]['item']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $arr[$channelwise_sales[$i]['item']]['tot_qty']);
                }
                $row2 = $row2 + 1;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_sales_row-1), '=sum('.$col_name[$col].$channelwise_sales_row.':'.$col_name[$col].($row2-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].($channelwise_sales_row-1).'-'.$col_name[$col].'16');

            $row2 = $channelwise_sales_return_row;
            $arr = $mon_period[$mon]['channelwise_sales_return'];
            for($i=0; $i<count($channelwise_sales_return); $i++) {
                if(isset($arr[$channelwise_sales_return[$i]['item']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $arr[$channelwise_sales_return[$i]['item']]['tot_qty']*-1);
                }
                $row2 = $row2 + 1;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_sales_return_row-1), '=sum('.$col_name[$col].$channelwise_sales_return_row.':'.$col_name[$col].($row2-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].($channelwise_sales_return_row-1).'-'.$col_name[$col].'20');

            $row2 = $zonewise_sales_row;
            $arr = $mon_period[$mon]['zonewise_sales'];
            for($i=0; $i<count($zonewise_sales); $i++) {
                if(isset($arr[$zonewise_sales[$i]['item']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $arr[$zonewise_sales[$i]['item']]['tot_qty']);
                }
                $row2 = $row2 + 1;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($zonewise_sales_row-1), '=sum('.$col_name[$col].$zonewise_sales_row.':'.$col_name[$col].($row2-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].($zonewise_sales_row-1).'-'.$col_name[$col].'24');
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->applyFromArray(array(
                'font'  => [
                    'color' => ['rgb' => 'FF0000']
                ]
            ));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getNumberFormat()->setFormatCode("_(* #,##0_);_(* (#,##0);_(* \"-\"??_);_(@_)");


            if($mon_no=='03' || $mon_no=='06' || $mon_no=='09' || $mon_no=='12' || $cnt2==$cnt) {
                $col = $col + 1;
                if($cnt2!=$cnt){
                    $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], 1);
                }

                if($mon_no=='01' || $mon_no=='02' || $mon_no=='03') $quater = "Q4";
                else if($mon_no=='04' || $mon_no=='05' || $mon_no=='06') $quater = "Q1";
                else if($mon_no=='07' || $mon_no=='08' || $mon_no=='09') $quater = "Q2";
                else if($mon_no=='10' || $mon_no=='11' || $mon_no=='12') $quater = "Q3";

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'14', $quater);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'15', '=sum('.$col_name[$start_col].'15:'.$col_name[$col-1].'15)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'16', '=sum('.$col_name[$start_col].'16:'.$col_name[$col-1].'16)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'17', '=sum('.$col_name[$start_col].'17:'.$col_name[$col-1].'17)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'18', '=sum('.$col_name[$start_col].'18:'.$col_name[$col-1].'18)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'19', '=sum('.$col_name[$start_col].'19:'.$col_name[$col-1].'19)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'20', '=sum('.$col_name[$start_col].'20:'.$col_name[$col-1].'20)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'21', '=sum('.$col_name[$start_col].'21:'.$col_name[$col-1].'21)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'22', '=sum('.$col_name[$start_col].'22:'.$col_name[$col-1].'22)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'23', '=sum('.$col_name[$start_col].'23:'.$col_name[$col-1].'23)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'24', '=sum('.$col_name[$start_col].'24:'.$col_name[$col-1].'24)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'25', '=sum('.$col_name[$start_col].'25:'.$col_name[$col-1].'25)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'26', '=sum('.$col_name[$start_col].'26:'.$col_name[$col-1].'26)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'27', '=sum('.$col_name[$start_col].'27:'.$col_name[$col-1].'27)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'28', '=average('.$col_name[$start_col].'28:'.$col_name[$col-1].'28)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'30', '=sum('.$col_name[$start_col].'30:'.$col_name[$col-1].'30)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'31', '=sum('.$col_name[$start_col].'31:'.$col_name[$col-1].'31)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'32', '=sum('.$col_name[$start_col].'32:'.$col_name[$col-1].'32)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'33', '=sum('.$col_name[$start_col].'33:'.$col_name[$col-1].'33)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'35', '=average('.$col_name[$start_col].'35:'.$col_name[$col-1].'35)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'36', '=average('.$col_name[$start_col].'36:'.$col_name[$col-1].'36)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'38', '=sum('.$col_name[$start_col].'38:'.$col_name[$col-1].'38)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'39', '=sum('.$col_name[$start_col].'39:'.$col_name[$col-1].'39)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'40', '=average('.$col_name[$start_col].'40:'.$col_name[$col-1].'40)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'41', '=sum('.$col_name[$start_col].'41:'.$col_name[$col-1].'41)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'42', '=sum('.$col_name[$start_col].'42:'.$col_name[$col-1].'42)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'43', '=average('.$col_name[$start_col].'43:'.$col_name[$col-1].'43)');

                $row2 = 46;
                for($i=0; $i<count($sales_items); $i++) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '=sum('.$col_name[$start_col].$row2.':'.$col_name[$col-1].$row2.')');
                    $row2 = $row2 + 1;
                }
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'45', '=sum('.$col_name[$col].'46:'.$col_name[$col].($row2-1).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].'45-'.$col_name[$col].'16');

                $row2 = $sales_return_row;
                for($i=0; $i<count($sales_return_items); $i++) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '=sum('.$col_name[$start_col].$row2.':'.$col_name[$col-1].$row2.')');
                    $row2 = $row2 + 1;
                }
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($sales_return_row-1), '=sum('.$col_name[$col].$sales_return_row.':'.$col_name[$col].($row2-1).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].($sales_return_row-1).'-'.$col_name[$col].'20');

                $row2 = $channelwise_sales_row;
                for($i=0; $i<count($channelwise_sales); $i++) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '=sum('.$col_name[$start_col].$row2.':'.$col_name[$col-1].$row2.')');
                    $row2 = $row2 + 1;
                }
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_sales_row-1), '=sum('.$col_name[$col].$channelwise_sales_row.':'.$col_name[$col].($row2-1).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].($channelwise_sales_row-1).'-'.$col_name[$col].'16');

                $row2 = $channelwise_sales_return_row;
                for($i=0; $i<count($channelwise_sales_return); $i++) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '=sum('.$col_name[$start_col].$row2.':'.$col_name[$col-1].$row2.')');
                    $row2 = $row2 + 1;
                }
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_sales_return_row-1), '=sum('.$col_name[$col].$channelwise_sales_return_row.':'.$col_name[$col].($row2-1).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].($channelwise_sales_return_row-1).'-'.$col_name[$col].'20');

                $row2 = $zonewise_sales_row;
                for($i=0; $i<count($zonewise_sales); $i++) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '=sum('.$col_name[$start_col].$row2.':'.$col_name[$col-1].$row2.')');
                    $row2 = $row2 + 1;
                }
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($zonewise_sales_row-1), '=sum('.$col_name[$col].$zonewise_sales_row.':'.$col_name[$col].($row2-1).')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '='.$col_name[$col].($zonewise_sales_row-1).'-'.$col_name[$col].'24');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));

                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->applyFromArray(array(
                    'font'  => [
                        'color' => ['rgb' => 'FF0000']
                    ]
                ));
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getNumberFormat()->setFormatCode("_(* #,##0_);_(* (#,##0);_(* \"-\"??_);_(@_)");


                $start_col = $col + 1;
            }

            $col = $col + 1;
            $cnt2 = $cnt2 + 1;
        }

        // $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+12].$row)->applyFromArray(array(
        //     'borders' => array(
        //         'allborders' => array(
        //             'style' => PHPExcel_Style_Border::BORDER_THIN
        //         )
        //     )
        // ));

        // $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->applyFromArray(array(
        //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
        //     'startcolor' => array(
        //         'rgb' => 'D9D9D9'
        //     )
        // ));

        for($col1 = 'A'; $col1 <= $col_name[$col-1]; $col1++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col1)->setAutoSize(true);
        }

        $filename='Monthly_sales_overview_report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Monthly Sales Overview report generated.';
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        // echo '<script>alert("No data found");</script>';
    }
}

function generate_monthly_sales_overview_zonewise_report() {
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

    // $from_date = '2018-04-01';
    // $to_date = '2019-03-31';

    $zone_data = [];
    $zone_list = [];
    $cnt = 0;

    $sql = "select distinct C.zone from 
            (select distinct distributor_id from distributor_out where status='Approved' and 
            invoice_date>='$from_date' and invoice_date<='$to_date' and 
            (distributor_id!='1' and distributor_id!='189') 
            union all 
            select distinct distributor_id from distributor_in where status='Approved' and 
            sales_return_date>='$from_date' and sales_return_date<='$to_date' and 
            (distributor_id!='1' and distributor_id!='189') 
            union all 
            select distinct distributor_id from credit_debit_note where status='Approved' and 
            date_of_transaction>='$from_date' and date_of_transaction<='$to_date' and 
            (distributor_id!='1' and distributor_id!='189')) A 
            left join distributor_master B on (A.distributor_id=B.id) 
            left join zone_master C on (B.zone_id=C.id) 
            order by C.zone";
    $result = $this->db->query($sql)->result_array();
    foreach ($result as $dt) {
        $zone = $dt['zone'];
        $zone_list[$cnt] = $zone;
        $zone_data[$zone]['zone'] = $zone;
        $zone_data[$zone]['channelwise_sales_bars'] = [];
        $zone_data[$zone]['channelwise_sales'] = [];
        $zone_data[$zone]['channelwise_sales_return_bars'] = [];
        $zone_data[$zone]['channelwise_sales_return'] = [];
        $zone_data[$zone]['channelwise_credit_debit'] = [];
        $cnt++;
    }

    $sql = "select distinct (case when B.type_id='13' then 'Modern Trade' when B.type_id='6' then 'Alternate Channel' else C.distributor_type end) as distributor_type from 
            (select distinct distributor_id from distributor_out where status='Approved' and 
            invoice_date>='$from_date' and invoice_date<='$to_date' and 
            (distributor_id!='1' and distributor_id!='189') 
            union all 
            select distinct distributor_id from distributor_in where status='Approved' and 
            sales_return_date>='$from_date' and sales_return_date<='$to_date' and 
            (distributor_id!='1' and distributor_id!='189') 
            union all 
            select distinct distributor_id from credit_debit_note where status='Approved' and 
            date_of_transaction>='$from_date' and date_of_transaction<='$to_date' and 
            (distributor_id!='1' and distributor_id!='189')) A 
            left join distributor_master B on (A.distributor_id=B.id) 
            left join distributor_type_master C on (B.type_id=C.id) 
            order by C.distributor_type";
    $channel_data = $this->db->query($sql)->result_array();

    $sql = "select H.zone, H.distributor_type as item, H.distributor_type as item_name, sum(H.item_qty) as tot_qty from 
            (select D.distributor_id, D.item_qty, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end distributor_type, G.zone from 
            (select A.distributor_id, case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_out A 
            left join distributor_out_items B on (A.id=B.distributor_out_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id) 
            left join zone_master G on (E.zone_id=G.id)) H 
            group by H.zone, H.distributor_type 
            order by H.zone, H.distributor_type";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_qty'=>$data[$i]['tot_qty']);
        if($i==count($data)-1) {
            $zone_data[$data[$i]['zone']]['channelwise_sales_bars']=$arr;
            $arr=[];
        } else if($data[$i]['zone']!=$data[$i+1]['zone'] || $data[$i]['item']!=$data[$i+1]['item']) {
            $zone_data[$data[$i]['zone']]['channelwise_sales_bars']=$arr;
            $arr=[];
        }
    }

    $sql = "select H.zone, H.distributor_type as item, H.distributor_type as item_name, sum(H.final_amount) as tot_amount from 
            (select D.distributor_id, D.final_amount, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end distributor_type, G.zone from 
            (select A.distributor_id, A.final_amount 
            from distributor_out A 
            where A.status='Approved' and A.invoice_date>='$from_date' and A.invoice_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id) 
            left join zone_master G on (E.zone_id=G.id)) H 
            group by H.zone, H.distributor_type 
            order by H.zone, H.distributor_type";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_amount'=>$data[$i]['tot_amount']);
        if($i==count($data)-1) {
            $zone_data[$data[$i]['zone']]['channelwise_sales']=$arr;
            $arr=[];
        } else if($data[$i]['zone']!=$data[$i+1]['zone'] || $data[$i]['item']!=$data[$i+1]['item']) {
            $zone_data[$data[$i]['zone']]['channelwise_sales']=$arr;
            $arr=[];
        }
    }

    $sql = "select H.zone, H.distributor_type as item, H.distributor_type as item_name, sum(H.item_qty)*-1 as tot_qty from 
            (select D.distributor_id, D.item_qty, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end distributor_type, G.zone from 
            (select A.distributor_id, case when B.type='Bar' then B.qty else B.qty*C.qty end as item_qty 
            from distributor_in A 
            left join distributor_in_items B on (A.id=B.distributor_in_id) 
            left join box_product C on (B.type='Box' and B.item_id=C.box_id) 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id) 
            left join zone_master G on (E.zone_id=G.id)) H 
            group by H.zone, H.distributor_type 
            order by H.zone, H.distributor_type";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_qty'=>$data[$i]['tot_qty']);
        if($i==count($data)-1) {
            $zone_data[$data[$i]['zone']]['channelwise_sales_return_bars']=$arr;
            $arr=[];
        } else if($data[$i]['zone']!=$data[$i+1]['zone'] || $data[$i]['item']!=$data[$i+1]['item']) {
            $zone_data[$data[$i]['zone']]['channelwise_sales_return_bars']=$arr;
            $arr=[];
        }
    }

    $sql = "select H.zone, H.distributor_type as item, H.distributor_type as item_name, sum(H.final_amount)*-1 as tot_amount from 
            (select D.distributor_id, D.final_amount, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end distributor_type, G.zone from 
            (select A.distributor_id, A.final_amount 
            from distributor_in A 
            where A.status='Approved' and A.sales_return_date>='$from_date' and A.sales_return_date<='$to_date' and 
                (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id) 
            left join zone_master G on (E.zone_id=G.id)) H 
            group by H.zone, H.distributor_type 
            order by H.zone, H.distributor_type";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_amount'=>$data[$i]['tot_amount']);
        if($i==count($data)-1) {
            $zone_data[$data[$i]['zone']]['channelwise_sales_return']=$arr;
            $arr=[];
        } else if($data[$i]['zone']!=$data[$i+1]['zone'] || $data[$i]['item']!=$data[$i+1]['item']) {
            $zone_data[$data[$i]['zone']]['channelwise_sales_return']=$arr;
            $arr=[];
        }
    }

    $sql = "select H.zone, H.distributor_type as item, H.distributor_type as item_name, sum(H.amount) as tot_amount from 
            (select D.distributor_id, D.amount, case when E.type_id='13' then 'Modern Trade' when E.type_id='6' then 'Alternate Channel' else F.distributor_type end distributor_type, G.zone from 
            (select A.distributor_id, case when (A.transaction='Credit Note' or A.transaction='Expense Voucher') then A.amount 
                    else (A.amount*-1) end as amount 
            from credit_debit_note A 
            where A.status='Approved' and A.date_of_transaction>='$from_date' and A.date_of_transaction<='$to_date' and 
            (A.distributor_id!='1' and A.distributor_id!='189')) D 
            left join distributor_master E on (D.distributor_id=E.id) 
            left join distributor_type_master F on (E.type_id=F.id) 
            left join zone_master G on (E.zone_id=G.id)) H 
            group by H.zone, H.distributor_type 
            order by H.zone, H.distributor_type";
    $data = $this->db->query($sql)->result_array();
    $arr=[];
    for($i=0; $i<count($data); $i++) {
        $arr[$data[$i]['item']] = array('item_name'=>$data[$i]['item_name'], 'tot_amount'=>$data[$i]['tot_amount']);
        if($i==count($data)-1) {
            $zone_data[$data[$i]['zone']]['channelwise_credit_debit']=$arr;
            $arr=[];
        } else if($data[$i]['zone']!=$data[$i+1]['zone'] || $data[$i]['item']!=$data[$i+1]['item']) {
            $zone_data[$data[$i]['zone']]['channelwise_credit_debit']=$arr;
            $arr=[];
        }
    }

    // echo json_encode($channel_data);
    // echo '<br/><br/>';
    // echo json_encode($zone_data);
    // echo '<br/><br/>';
    
    if(count($zone_list)>0) {
        // $this->load->library('excel');
        // $objPHPExcel = new PHPExcel();

        $template_path=$this->config->item('template_path');
        $file = $template_path.'Monthly_sales_overview_zonewise.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $objPHPExcel->setActiveSheetIndex(0);
        $col_name[]=array();
        for($i=0; $i<=$cnt+20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('C1', $from_date.' to '.$to_date);

        $row = 3;
        $channelwise_sales_bars_row = 5;
        $channelwise_sales_return_bars_row = 8;
        $channelwise_total_sales_bars_row = 11;
        $channelwise_sales_row = 14;
        $channelwise_sales_return_row = 17;
        $channelwise_credit_debit_row = 20;
        $channelwise_total_sales_row = 23;
        $col=1;

        $row = $channelwise_sales_bars_row;
        $row2 = $channelwise_sales_return_bars_row;
        $row3 = $channelwise_total_sales_bars_row;
        $row4 = $channelwise_sales_row;
        $row5 = $channelwise_sales_return_row;
        $row6 = $channelwise_credit_debit_row;
        $row7 = $channelwise_total_sales_row;
        for($i=0; $i<count($channel_data); $i++) {
            if($i!=0){
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
                $row2 = $row2 + 1;
                $row3 = $row3 + 1;
                $row4 = $row4 + 1;
                $row5 = $row5 + 1;
                $row6 = $row6 + 1;
                $row7 = $row7 + 1;
                $channelwise_sales_return_bars_row = $channelwise_sales_return_bars_row + 1;
                $channelwise_total_sales_bars_row = $channelwise_total_sales_bars_row + 1;
                $channelwise_sales_row = $channelwise_sales_row + 1;
                $channelwise_sales_return_row = $channelwise_sales_return_row + 1;
                $channelwise_credit_debit_row = $channelwise_credit_debit_row + 1;
                $channelwise_total_sales_row = $channelwise_total_sales_row + 1;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row2, 1);
                $row3 = $row3 + 1;
                $row4 = $row4 + 1;
                $row5 = $row5 + 1;
                $row6 = $row6 + 1;
                $row7 = $row7 + 1;
                $channelwise_total_sales_bars_row = $channelwise_total_sales_bars_row + 1;
                $channelwise_sales_row = $channelwise_sales_row + 1;
                $channelwise_sales_return_row = $channelwise_sales_return_row + 1;
                $channelwise_credit_debit_row = $channelwise_credit_debit_row + 1;
                $channelwise_total_sales_row = $channelwise_total_sales_row + 1;
                
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row3, 1);
                $row4 = $row4 + 1;
                $row5 = $row5 + 1;
                $row6 = $row6 + 1;
                $row7 = $row7 + 1;
                $channelwise_sales_row = $channelwise_sales_row + 1;
                $channelwise_sales_return_row = $channelwise_sales_return_row + 1;
                $channelwise_credit_debit_row = $channelwise_credit_debit_row + 1;
                $channelwise_total_sales_row = $channelwise_total_sales_row + 1;
                
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row4, 1);
                $row5 = $row5 + 1;
                $row6 = $row6 + 1;
                $row7 = $row7 + 1;
                $channelwise_sales_return_row = $channelwise_sales_return_row + 1;
                $channelwise_credit_debit_row = $channelwise_credit_debit_row + 1;
                $channelwise_total_sales_row = $channelwise_total_sales_row + 1;
                
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row5, 1);
                $row6 = $row6 + 1;
                $row7 = $row7 + 1;
                $channelwise_credit_debit_row = $channelwise_credit_debit_row + 1;
                $channelwise_total_sales_row = $channelwise_total_sales_row + 1;
                
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row6, 1);
                $row7 = $row7 + 1;
                $channelwise_total_sales_row = $channelwise_total_sales_row + 1;

                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row7, 1);
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $channel_data[$i]['distributor_type']);
            $row = $row + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $channel_data[$i]['distributor_type']);
            $row2 = $row2 + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row3, $channel_data[$i]['distributor_type']);
            $row3 = $row3 + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row4, $channel_data[$i]['distributor_type']);
            $row4 = $row4 + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row5, $channel_data[$i]['distributor_type']);
            $row5 = $row5 + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row6, $channel_data[$i]['distributor_type']);
            $row6 = $row6 + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row7, $channel_data[$i]['distributor_type']);
            $row7 = $row7 + 1;
        }

        $row=1;
        $col=2;
        $start_col=2;
        $cnt2=1;

        for($j=0; $j<count($zone_list); $j++) {
            $zone = $zone_list[$j];

            if($col!=2){
                $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], 1);
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'3', $zone);

            $row = $channelwise_sales_bars_row;
            $row2 = $channelwise_sales_return_bars_row;
            $row3 = $channelwise_total_sales_bars_row;
            $row4 = $channelwise_sales_row;
            $row5 = $channelwise_sales_return_row;
            $row6 = $channelwise_credit_debit_row;
            $row7 = $channelwise_total_sales_row;

            $arr = $zone_data[$zone]['channelwise_sales_bars'];
            $arr2 = $zone_data[$zone]['channelwise_sales_return_bars'];
            // $arr3 = $zone_data[$zone]['channelwise_sales_bars'];
            $arr4 = $zone_data[$zone]['channelwise_sales'];
            $arr5 = $zone_data[$zone]['channelwise_sales_return'];
            $arr6 = $zone_data[$zone]['channelwise_credit_debit'];
            // $arr7 = $zone_data[$zone]['channelwise_sales_bars'];

            for($i=0; $i<count($channel_data); $i++) {
                if(isset($arr[$channel_data[$i]['distributor_type']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $arr[$channel_data[$i]['distributor_type']]['tot_qty']);
                }
                if(isset($arr2[$channel_data[$i]['distributor_type']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $arr2[$channel_data[$i]['distributor_type']]['tot_qty']);
                }
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row3, '=sum('.$col_name[$col].$row.','.$col_name[$col].$row2.')');

                if(isset($arr4[$channel_data[$i]['distributor_type']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row4, $arr4[$channel_data[$i]['distributor_type']]['tot_amount']);
                }
                if(isset($arr5[$channel_data[$i]['distributor_type']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row5, $arr5[$channel_data[$i]['distributor_type']]['tot_amount']);
                }
                if(isset($arr6[$channel_data[$i]['distributor_type']])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row6, $arr6[$channel_data[$i]['distributor_type']]['tot_amount']);
                }
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row7, '=sum('.$col_name[$col].$row4.','.$col_name[$col].$row5.','.$col_name[$col].$row6.')');

                $row = $row + 1;
                $row2 = $row2 + 1;
                $row3 = $row3 + 1;
                $row4 = $row4 + 1;
                $row5 = $row5 + 1;
                $row6 = $row6 + 1;
                $row7 = $row7 + 1;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_sales_bars_row-1), '=sum('.$col_name[$col].$channelwise_sales_bars_row.':'.$col_name[$col].($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_sales_return_bars_row-1), '=sum('.$col_name[$col].$channelwise_sales_return_bars_row.':'.$col_name[$col].($row2-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_total_sales_bars_row-1), '=sum('.$col_name[$col].$channelwise_total_sales_bars_row.':'.$col_name[$col].($row3-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_sales_row-1), '=sum('.$col_name[$col].$channelwise_sales_row.':'.$col_name[$col].($row4-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_sales_return_row-1), '=sum('.$col_name[$col].$channelwise_sales_return_row.':'.$col_name[$col].($row5-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_credit_debit_row-1), '=sum('.$col_name[$col].$channelwise_credit_debit_row.':'.$col_name[$col].($row6-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($channelwise_total_sales_row-1), '=sum('.$col_name[$col].$channelwise_total_sales_row.':'.$col_name[$col].($row7-1).')');

            $col = $col + 1;
            $cnt2 = $cnt2 + 1;
        }

        $row = $channelwise_sales_bars_row;
        $row2 = $channelwise_sales_return_bars_row;
        $row3 = $channelwise_total_sales_bars_row;
        $row4 = $channelwise_sales_row;
        $row5 = $channelwise_sales_return_row;
        $row6 = $channelwise_credit_debit_row;
        $row7 = $channelwise_total_sales_row;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row-1), '=sum('.$col_name[2].($row-1).':'.$col_name[$col-1].($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row2-1), '=sum('.$col_name[2].($row2-1).':'.$col_name[$col-1].($row2-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row3-1), '=sum('.$col_name[2].($row3-1).':'.$col_name[$col-1].($row3-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row4-1), '=sum('.$col_name[2].($row4-1).':'.$col_name[$col-1].($row4-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row5-1), '=sum('.$col_name[2].($row5-1).':'.$col_name[$col-1].($row5-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row6-1), '=sum('.$col_name[2].($row6-1).':'.$col_name[$col-1].($row6-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].($row7-1), '=sum('.$col_name[2].($row7-1).':'.$col_name[$col-1].($row7-1).')');

        for($i=0; $i<count($channel_data); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=sum('.$col_name[2].$row.':'.$col_name[$col-1].$row.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, '=sum('.$col_name[2].$row2.':'.$col_name[$col-1].$row2.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row3, '=sum('.$col_name[2].$row3.':'.$col_name[$col-1].$row3.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row4, '=sum('.$col_name[2].$row4.':'.$col_name[$col-1].$row4.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row5, '=sum('.$col_name[2].$row5.':'.$col_name[$col-1].$row5.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row6, '=sum('.$col_name[2].$row6.':'.$col_name[$col-1].$row6.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row7, '=sum('.$col_name[2].$row7.':'.$col_name[$col-1].$row7.')');

            $row = $row + 1;
            $row2 = $row2 + 1;
            $row3 = $row3 + 1;
            $row4 = $row4 + 1;
            $row5 = $row5 + 1;
            $row6 = $row6 + 1;
            $row7 = $row7 + 1;
        }

        $objPHPExcel->getActiveSheet()->getStyle('B3:'.$col_name[$col].($row7-1))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        for($col1 = 'A'; $col1 <= $col_name[$col]; $col1++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col1)->setAutoSize(true);
        }

        $filename='Zonewise_monthly_sales_overview_report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Monthly Sales Overview report generated.';
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        // echo '<script>alert("No data found");</script>';
    }
}

public function generate_mt_stock_report() {
    $date = formatdate($this->input->post('date'));
    // $zone_id_array = ['10', '12', '16', '18', '29'];
    // $zone_array = ['Pune', 'Hyderbad', 'Mumbai', 'Banglore', 'Ahmedabad'];

    $zone_id_array = ['16'];
    $zone_array = ['Mumbai'];

    $reportpath = '';
    
    for($x=0; $x<count($zone_id_array); $x++) {
        $r_zone_id = $zone_id_array[$x];
        $this->get_mt_stock_report($date, 'generate', $r_zone_id);
    }
}

public function send_mt_stock_tracker() {
    $date = date('Y-m-d');
    // $date = '2019-07-16';

    // $zone_id_array = ['16'];
    // $zone_array = ['Mumbai'];
    // $zone_email_array = ['Sulochana.yadav@eatanytime.in'];

    $zone_id_array = ['9', '10', '12', '16', '18', '29', '30'];
    $zone_array = ['Chennai', 'Pune', 'Hyderbad', 'Mumbai', 'Banglore', 'Ahmedabad', 'Delhi'];
    // $zone_email_array = ['', 'mohil.telawade@eatanytime.in', 'vijay.spar@gmail.com', 
    //                     'Sulochana.yadav@eatanytime.in, mukesh.yadav@eatanytime.in, sachin.pal@eatanytime.in', 
    //                     'darshan.dhany@eatanytime.in, mahesh.ms@eatanytime.in', 'urvi.bhayani@eatanytime.in', 
    //                     'nitin.kumar@eatanytime.in'];

    $reportpath = '';
    $tr = '';
    
    for($x=0; $x<count($zone_id_array); $x++) {
        $r_zone_id = $zone_id_array[$x];
        $r_zone = $zone_array[$x];
        // $reportpath = $this->get_mt_stock_report($date, 'save', $r_zone_id);
        $return_arr = $this->get_mt_stock_report($date, 'save', $r_zone_id);

        if(isset($return_arr['reportpath'])){
            $reportpath = $return_arr['reportpath'];
        }
        if(isset($return_arr['tr'])){
            $tr = $return_arr['tr'];
        }

        if($reportpath!=''){
            $report_date = date('d-m-Y', strtotime($date));

            $message = '<html>
                        <head>
                            <style>
                                td { padding: 5px; width: 100px; }
                            </style>
                        </head>
                        <body>
                            <h3>Wholesome Habits Private Limited</h3>
                            <h4>MT Stock Tracker - '.$r_zone.'</h4>
                            <p>Reporting Date - '.$report_date.'</p>
                            <p>PFA</p>
                            <br/><br/>

                            <table class="body_table" border="1px" style="border-collapse: collapse;">
                            <tbody>
                            '.$tr.'
                            </tbody>
                            </table>

                            <br/><br/>
                            Regards,
                            <br/><br/>
                            CS
                        </body>
                        </html>';
            $from_email = 'cs@eatanytime.in';
            $from_email_sender = 'EAT MIS';
            $subject = 'MT_Stock_Tracker_'.$r_zone.'_'.$report_date;


            /*$to_email = "dhaval.maru@otbconsulting.co.in";
            $cc="prasad.bhisale@otbconsulting.co.in";
            $bcc="prasad.bhisale@otbconsulting.co.in";*/
            
            // $to_email = "prasad.bhisale@otbconsulting.co.in";
            // $cc = 'prasad.bhisale@otbconsulting.co.in';
            // $bcc = 'prasad.bhisale@otbconsulting.co.in';

            // if($zone_email_array[$x]!=''){
            //     $to_email = "operations@eatanytime.in,priti.tripathi@eatanytime.in,".$zone_email_array[$x];
            // } else {
            //     $to_email = "operations@eatanytime.in,priti.tripathi@eatanytime.in";
            // }

            $to_email = "operations@eatanytime.in, priti.tripathi@eatanytime.in";
            $cc = 'rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in, dhaval.maru@otbconsulting.co.in';
            $bcc = 'prasad.bhisale@otbconsulting.co.in';

            sleep(15);

            echo $attachment = $reportpath;
            echo '<br/><br/>';
            echo $message;
            echo '<br/><br/>';

            $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);

            echo $mailSent;
            echo '<br/><br/>';

            if($mailSent==1){
                $logarray['table_id']=$this->session->userdata('session_id');
                $logarray['module_name']='Reports';
                $logarray['cnt_name']='Reports';
                $logarray['action']='MT Stock report sent.';
                $this->user_access_log_model->insertAccessLog($logarray);
            }
        }
    }
}

public function get_mt_stock_report($date='', $action='save', $r_zone_id='') {
    if($date==''){
        $date = date('Y-m-d');
    }

    $report_date = date('d-m-Y', strtotime($date));
    $reportpath = '';
    $tr = '';

    $sql = "Select distinct H.store_name from 
            (Select  E.*, F.location from 
            (Select  J.*, D.zone from 
            (Select I.*, A.category from
            (select distinct store_id, location_id, zone_id from merchandiser_beat_plan 
            where status='Approved' and zone_id='".$r_zone_id."') I
            left join
            (select * from store_master where status='Approved' and zone_id='".$r_zone_id."') A
            on (I.store_id=A.store_id and I.location_id=A.location_id and I.zone_id=A.zone_id)) J
            left join 
            (select * from zone_master) D 
            on (J.zone_id=D.id)) E 
            left join 
            (select * from location_master) F 
            on (E.location_id=F.id)) G 
            left join 
            (select * from relationship_master) H 
            on (G.store_id=H.id) 
            order by H.store_name";
    $query = $this->db->query($sql);
    $result = $query->result();

    if(count($result)>0){
        $template_path = $this->config->item('template_path');
        $file = $template_path.'MT_Stock_Tracker.xlsx';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $col_name[]=array();
        for($i=0; $i<=200; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        // echo count($result);
        // echo '<br/>';

        // $j = 19;
        // $region = $objPHPExcel->getActiveSheet()->getCell('A'.strval($j))->getValue();
        // echo $region;
        // echo '<br/>';

        // $lst_row = 129;

        $sql = "select * from zone_master where id = '".$r_zone_id."'";
        $result2 = $this->db->query($sql)->result();

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'MT STORE TRACKER - '.strtoupper($result2[0]->zone));
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Date - '.$report_date.' to '.$report_date);

        $row = 6;

        for($i=0; $i<count($result); $i++){
            if($row>8){
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[1].$row, $result[$i]->store_name);
            // $objPHPExcel->getActiveSheet()->setCellValue($col_name[2].$row, '=COUNTIF($B$8:$B$118,B3)');
            $row = $row + 1;
        }

        // $objPHPExcel->getActiveSheet()->getStyle($col_name[1].'2:'.$col_name[2].($row-1))->applyFromArray(array(
        //     'borders' => array(
        //         'allborders' => array(
        //             'style' => PHPExcel_Style_Border::BORDER_THIN
        //         )
        //     )
        // ));

        $excel_sales_rep = array();
        $tot_sales_rep_cnt = 2;
        $start_row = $row + 1;
        $row = $start_row;
        $col = 6;
        $tr = '';

        $sql = "Select distinct G.*, H.store_name from 
                (Select  E.*, F.location from 
                (Select  J.*, D.zone from 
                (Select I.*, A.category from
                (select distinct store_id, location_id, zone_id from merchandiser_beat_plan 
                where status='Approved' and zone_id='".$r_zone_id."') I
                left join
                (select * from store_master where status='Approved' and zone_id='".$r_zone_id."') A
                on (I.store_id=A.store_id and I.location_id=A.location_id and I.zone_id=A.zone_id)) J
                left join 
                (select * from zone_master) D 
                on (J.zone_id=D.id)) E 
                left join 
                (select * from location_master) F 
                on (E.location_id=F.id)) G 
                left join 
                (select * from relationship_master) H 
                on (G.store_id=H.id) 
                order by G.zone, H.store_name, G.location";
        $query = $this->db->query($sql);
        $result = $query->result();

        if(count($result)>0){
            // $td1 = '';
            // $td2 = '';

            $sql = "select distinct A.sales_rep_id, B.sales_rep_name 
                    from merchandiser_beat_plan A 
                    left join sales_rep_master B on (A.sales_rep_id=B.id) 
                    where A.zone_id = '$r_zone_id' and B.sales_rep_name is not null and B.sr_type = 'Merchandizer' 
                    order by B.sales_rep_name";
            $query = $this->db->query($sql);
            $result2 = $query->result();
            if(count($result2)>0){
                $tot_sales_rep_cnt = count($result2);

                for($j=0; $j<count($result2); $j++){
                    $excel_sales_rep[$j] = ucwords(trim($result2[$j]->sales_rep_name));
                    if($j>1){
                        $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col+$j], 1);
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+$j].$row, $excel_sales_rep[$j]);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+$j].($row+1), 'MERCHANDISER '.($j+1));

                    // $td1 = $td1.'<td>'.$excel_sales_rep[$j].'</td>';
                    // $td2 = $td2.'<td>MERCHANDISER '.($j+1).'</td>';
                }
            }

            // if($td1 == '') {
            //     $td1 = '<td></td><td></td>';
            //     $td2 = '<td>MERCHANDISER 1</td><td>MERCHANDISER 2</td>';
            // } else if($tot_sales_rep_cnt==1) {
            //     $td1 = '<td></td>';
            //     $td2 = '<td>MERCHANDISER 2</td>';
            // }

            // $tr = '<tr><td></td><td></td><td></td><td></td>'.$td1.'<td></td><td>'.$report_date.'</td><td></td><td></td>';
            // $tr = $tr.'<tr style="font-weight: bold;"><td>Region</td><td>MT Group</td><td>Location</td><td>STORES</td>'.$td2.'<td>STATUS</td><td>Latest Date</td><td>Username</td><td>Diff</td>';
            $tr = $tr.'<tr style="font-weight: bold;"><td>Sr No</td><td>Region</td><td>MT Group</td><td>Location</td><td>Latest Date</td><td>Username</td><td>Diff</td>';
            $sr_no = 1;

            if($tot_sales_rep_cnt<2){
                $tot_sales_rep_cnt = 2;
            }

            $col = 9 + $tot_sales_rep_cnt;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $report_date);

            $row = $start_row + 2;

            for($i=0; $i<count($result); $i++){
                $zone = ucwords(trim($result[$i]->zone));
                $store = ucwords(trim($result[$i]->store_name));
                $location = ucwords(trim($result[$i]->location));
                $category = $result[$i]->category;

                $zone_id = $result[$i]->zone_id;
                $store_id = $result[$i]->store_id;
                $location_id = $result[$i]->location_id;

                // echo $i;
                // echo '<br/>';
                // echo $zone_id;
                // echo '<br/>';
                // echo $store_id;
                // echo '<br/>';
                // echo $location_id;
                // echo '<br/>';

                $date_of_visit = '';
                $butterscotch_cnt = 0;
                $orange_cnt = 0;
                $chocopeanut_cnt = 0;
                $mango_cnt = 0;
                $bambaiya_cnt = 0;
                $berry_cnt = 0;
                $chyawanprash_cnt = 0;
                $variety_cnt = 0;
                $choco_cnt = 0;
                $dark_choco_cnt = 0;
                $cranb_cnt = 0;
                $t_cranb_cnt = 0;
                $t_fig_cnt = 0;
                $t_papaya_cnt = 0;
                $user_name = '';

                // $date1=date_create($date);
                // $date2=date_create('1900-01-00');
                // $date_diff=date_diff($date1, $date2);
                // $diff = intval($date_diff->format("%a"));

                $diff = '';

                $sql = "select A.*, concat(ifnull(B.first_name,''), ' ',ifnull(B.last_name,'')) as user_name , 
                        DATEDIFF(curdate(),date(A.date_of_visit)) as diff 
                        from merchandiser_stock A left join user_master B on (A.created_by=B.id) 
                        where A.dist_id = '$store_id' and A.location_id = '$location_id' and 
                            date(A.date_of_visit)<=date('".$date."') 
                        order by A.date_of_visit desc";
                $query = $this->db->query($sql);
                $result2 = $query->result();
                if(count($result2)>0){
                    $merchandiser_stock_id = $result2[0]->id;
                    if(isset($result2[0]->date_of_visit)){
                        if($result2[0]->date_of_visit!=null && $result2[0]->date_of_visit!=''){
                            $date_of_visit = date('d-m-Y',strtotime($result2[0]->date_of_visit));
                            $diff = $result2[0]->diff;
                        }
                    }
                    $user_name = ucwords(trim($result2[0]->user_name));

                    // $sql = "select AA.merchandiser_stock_id, AA.item_id, sum(AA.qty) as qty from 
                    //         (select A.merchandiser_stock_id, case when A.type = 'Bar' then A.item_id else B.product_id end as item_id, 
                    //         case when A.type = 'Bar' then A.qty when (B.product_id='16' or B.product_id='17' or B.product_id='18' or 
                    //             B.product_id='19' or B.product_id='20' or B.product_id='21') then A.qty else A.qty*B.qty end as qty 
                    //         from merchandiser_stock_details A left join box_product B on (A.type = 'Box' and A.item_id = B.box_id) 
                    //         where A.merchandiser_stock_id = '$merchandiser_stock_id') AA 
                    //         group by AA.merchandiser_stock_id, AA.item_id";


                    $sql = "select E.merchandiser_stock_id, E.item_id, sum(E.qty) as qty from 
                            (select A.merchandiser_stock_id, A.item_id, A.qty from merchandiser_stock_details A 
                            where A.merchandiser_stock_id = '$merchandiser_stock_id' and (A.type = 'Bar' or (A.type = 'Box' and A.item_id='32')) 
                            union all 
                            select D.* from 
                            (select C.merchandiser_stock_id, C.item_id, sum(C.qty) as qty from 
                            (select A.merchandiser_stock_id, B.product_id as item_id, 
                            case when (B.product_id='16' or B.product_id='17' or B.product_id='18' or 
                                B.product_id='19' or B.product_id='20' or B.product_id='21') then A.qty else A.qty*B.qty end as qty 
                            from merchandiser_stock_details A left join box_product B on (A.type = 'Box' and A.item_id = B.box_id) 
                            where A.merchandiser_stock_id = '$merchandiser_stock_id' and A.type = 'Box' and A.item_id<>'32') C 
                            group by C.merchandiser_stock_id, C.item_id) D) E 
                            group by E.merchandiser_stock_id, E.item_id";

                    $query = $this->db->query($sql);
                    $result2 = $query->result();
                    if(count($result2)>0){
                        for($j=0; $j<count($result2); $j++){
                            if($result2[$j]->item_id=='1'){
                                $orange_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='3'){
                                $butterscotch_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='4'){
                                $bambaiya_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='5'){
                                $chocopeanut_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='6'){
                                $mango_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='9'){
                                $berry_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='10'){
                                $chyawanprash_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='32'){
                                $variety_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='16'){
                                $choco_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='17'){
                                $dark_choco_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='18'){
                                $cranb_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='19'){
                                $t_cranb_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='20'){
                                $t_fig_cnt = $result2[$j]->qty;
                            } else if($result2[$j]->item_id=='21'){
                                $t_papaya_cnt = $result2[$j]->qty;
                            }
                        }
                    }
                }

                // $bl_flag = false;
                // $row = 19;

                // for($j=19; $j<1000; $j++){
                //     $region = $objPHPExcel->getActiveSheet()->getCell('A'.strval($j))->getValue();
                //     $group = $objPHPExcel->getActiveSheet()->getCell('B'.strval($j))->getValue();
                //     $loc = $objPHPExcel->getActiveSheet()->getCell('C'.strval($j))->getValue();

                //     if($region==''){
                //         $row = $j;
                //         $lst_row = $j;
                //         break;
                //     }

                //     if(strtoupper(trim($zone))==strtoupper(trim($region)) && 
                //        strtoupper(trim($store))==strtoupper(trim($group)) && 
                //        strtoupper(trim($location))==strtoupper(trim($loc))){
                //             $bl_flag = true;
                //             $row = $j;
                //             break;
                //     }
                // }

                // if($bl_flag==false){
                //     echo 'Not Found';
                //     echo '<br/>';
                // } else {
                //     echo 'Found';
                //     echo '<br/>';
                // }

                $col = 0;

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $zone);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $store);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $location);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $store."-".$location);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $category);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, '=VLOOKUP(E'.$row.',$E$5:$F$7,2,0)');

                // $td1 = '';
                $sql = "select A.*, B.sales_rep_name from merchandiser_beat_plan A 
                        left join sales_rep_master B on (A.sales_rep_id=B.id) 
                        where A.zone_id = '$zone_id' and A.store_id = '$store_id' and A.location_id = '$location_id' and B.sr_type = 'Merchandizer' 
                        order by A.modified_on desc";
                $query = $this->db->query($sql);
                $result2 = $query->result();
                if(count($result2)>0){
                    // if(strtoupper(trim($sales_rep_name))==strtoupper(trim($excel_sales_rep1))){
                    //     $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $result2[0]->frequency);
                    // } else if(strtoupper(trim($sales_rep_name))==strtoupper(trim($excel_sales_rep2))){
                    //     $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $result2[0]->frequency);
                    // }

                    for($k=0; $k<count($result2); $k++){
                        $sales_rep_name = $result2[$k]->sales_rep_name;

                        for($j=0; $j<count($excel_sales_rep); $j++){
                            if(strtoupper(trim($sales_rep_name))==strtoupper(trim($excel_sales_rep[$j]))){
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6+$j].$row, $result2[0]->frequency);
                                // $td1 = $td1.'<td>'.$result2[0]->frequency.'</td>';
                            }
                        }
                    }
                }

                // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, '=IF(G'.$row.'="",$J$17,$I$17)');
                // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, '=IF(H'.$row.'="",$J$17,$I$17)');
                // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, '=IF((I'.$row.'=$J$17)*(J'.$row.'=$J$17),"NOT UPDATED","UPDATED")');

                $col = 6 + $tot_sales_rep_cnt;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF(COUNTBLANK('.$col_name[$col-$tot_sales_rep_cnt].$row.':'.$col_name[$col-1].$row.')='.$tot_sales_rep_cnt.', "NOT UPDATED", "UPDATED")');

                // $tr = $tr . '<td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col].$row)->getCalculatedValue().'</td>';
                
                $col = $col + 2;
                $style = "";

                if($date_of_visit!='') {
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $date_of_visit);
                    $col = $col + 1;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $user_name);
                    $col = $col + 1;
                    // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+$'.$col_name[$col-1].'$'.$start_row.'-'.$col_name[$col-2].$row);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $diff);
                    $col = $col + 1;
                } else {
                    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row.':'.$col_name[$col+2].$row)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'FFC7CE'
                        )
                    ));
                    $col = $col + 2;
                    // $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+$'.$col_name[$col-1].'$'.$start_row.'-'.$col_name[$col-2].$row);
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $diff);
                    $col = $col + 1;
                }

                if($date_of_visit=='' || $date_of_visit==null) {
                    $style = " background-color: #FFC7CE;";
                }

                // $td1 = '';
                // $no_of_days = $objPHPExcel->getActiveSheet()->getCell($col_name[$col-1].$row)->getCalculatedValue();

                if($diff=='' || $diff>7) {
                    // for($x=$col-1; $x>=0; $x--) { 
                    //     if($x==($col-1)) {
                    //         $td1 = '<td>'.$diff.'</td>'.$td1;
                    //     } else if($x==($col-2) || $x==($col-3)) {
                    //         $td1 = '<td style="'.$style.'">'.$objPHPExcel->getActiveSheet()->getCell($col_name[$x].$row)->getCalculatedValue().'</td>'.$td1;
                    //     } else if($x!=($col-4) && $x!=4 && $x!=5) {
                    //         $td1 = '<td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$x].$row)->getCalculatedValue().'</td>'.$td1;
                    //     }
                    // }
                    // $tr = $tr . '<tr>'.$td1.'</tr>';

                    $tr = $tr . '<tr>
                                    <td>'.$sr_no++.'</td>
                                    <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[0].$row)->getCalculatedValue().'</td>
                                    <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[1].$row)->getCalculatedValue().'</td>
                                    <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[2].$row)->getCalculatedValue().'</td>
                                    <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col-3].$row)->getCalculatedValue().'</td>
                                    <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col-2].$row)->getCalculatedValue().'</td>
                                    <td>'.$objPHPExcel->getActiveSheet()->getCell($col_name[$col-1].$row)->getCalculatedValue().'</td>
                                </tr>';
                }
                
                
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $butterscotch_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $orange_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $chocopeanut_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $mango_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $bambaiya_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $berry_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $chyawanprash_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $variety_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $choco_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $dark_choco_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $cranb_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $t_cranb_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $t_fig_cnt);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $t_papaya_cnt);
                $col = $col + 1;

                // $region = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].$row)->getValue();

                // $objConditionalStyle = new PHPExcel_Style_Conditional();
                // $objConditionalStyle->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                //     ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
                //     ->addCondition('7');
                // $objConditionalStyle->getStyle()->getFont()->getColor()->setRGB('FF0000');

                // $conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row)->getConditionalStyles();
                // array_push($conditionalStyles, $objConditionalStyle);
                // $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row)->setConditionalStyles($conditionalStyles);


                $objConditional = new PHPExcel_Style_Conditional();
                $objConditional->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_EQUAL)
                                ->addCondition('""')
                                ->getStyle()
                                ->applyFromArray(
                                        array(
                                                'font'=>array(
                                                    'color'=>array('argb'=>'FF000000')
                                                ),
                                                'fill'=>array(
                                                    'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                    'startcolor' =>array('argb' => 'FFFFFFFF'),
                                                    'endcolor' =>array('argb' => 'FFFFFFFF')
                                                )
                                            )
                                    );

                $objConditional2 = new PHPExcel_Style_Conditional();
                $objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
                                ->addCondition('7')
                                ->getStyle()
                                ->applyFromArray(
                                        array(
                                                'font'=>array(
                                                    'color'=>array('argb'=>'FF000000')
                                                ),
                                                'fill'=>array(
                                                    'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                    'startcolor' =>array('argb' => 'FFFF0000'),
                                                    'endcolor' =>array('argb' => 'FFFF0000')
                                                )
                                            )
                                    );

                $objConditional3 = new PHPExcel_Style_Conditional();
                $objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHANOREQUAL)
                                ->addCondition('7')
                                ->getStyle()
                                ->applyFromArray(
                                        array(
                                                'font'=>array(
                                                    'color'=>array('argb'=>'FF000000')
                                                ),
                                                'fill'=>array(
                                                    'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                    'startcolor' =>array('argb' => 'FF00B050'),
                                                    'endcolor' =>array('argb' => 'FF00B050')
                                                )
                                            )
                                    );

                $conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle($col_name[$col-15].$row)->getConditionalStyles();
                array_push($conditionalStyles,$objConditional,$objConditional2,$objConditional3);
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col-15].$row)->setConditionalStyles($conditionalStyles);
                

                $objConditional = new PHPExcel_Style_Conditional();
                $objConditional->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
                                ->addCondition('1')
                                ->getStyle()
                                ->applyFromArray(
                                        array(
                                                'font'=>array(
                                                    'color'=>array('argb'=>'FF000000')
                                                ),
                                                'fill'=>array(
                                                    'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                    'startcolor' =>array('argb' => 'FFFF0000'),
                                                    'endcolor' =>array('argb' => 'FFFF0000')
                                                )
                                            )
                                    );

                $objConditional2 = new PHPExcel_Style_Conditional();
                $objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
                                ->addCondition('1')
                                ->getStyle()
                                ->applyFromArray(
                                        array(
                                                'font'=>array(
                                                    'color'=>array('argb'=>'FF000000')
                                                ),
                                                'fill'=>array(
                                                    'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                    'startcolor' =>array('argb' => 'FF00B050'),
                                                    'endcolor' =>array('argb' => 'FF00B050')
                                                )
                                            )
                                    );
                $conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle(($col_name[$col-14].$row).':'.($col_name[$col-1].$row))->getConditionalStyles();
                array_push($conditionalStyles,$objConditional,$objConditional2);
                $objPHPExcel->getActiveSheet()->getStyle(($col_name[$col-14].$row).':'.($col_name[$col-1].$row))->setConditionalStyles($conditionalStyles);


                // echo $date_of_visit;
                // echo '<br/>';

                $col = $col + 19;

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=SUM('.$col_name[$col+1].$row.':'.$col_name[$col+14].$row.')');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=+'.$col_name[$col-16].$row.'-'.$col_name[$col-28].$row);
                $col = $col + 2;

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=SUM('.$col_name[$col+1].$row.':'.$col_name[$col+14].$row.')');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, '=IF('.$col_name[$col-50].$row.'<$F$'.$row.'/2,$F$'.$row.',0)');

                $row = $row + 1;
            }

            $row = $row - 1;
        }

        for($i=6; $i<$start_row-1; $i++){
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[2].$i, '=COUNTIF($B$'.($start_row + 2).':$B$'.$row.',B'.$i.')');
        }
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[2].($start_row-1), '=SUM(C6:C'.($start_row-2).')');

        $col = 6 + $tot_sales_rep_cnt;

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'7', '=COUNTIF('.$col_name[$col].$start_row.':'.$col_name[$col].$row.','.$col_name[$col].'6)');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].'7', '=COUNTIF('.$col_name[$col].$start_row.':'.$col_name[$col].$row.','.$col_name[$col+1].'6)');

        $start_row = $start_row + 2;

        $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':'.$col_name[$col].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $col = $col + 2;
        $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$start_row.':'.$col_name[$col+16].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $col = $col + 19;
        $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$start_row.':'.$col_name[$col+15].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $col = $col + 17;
        $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$start_row.':'.$col_name[$col+14].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $col = $col + 16;
        $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$start_row.':'.$col_name[$col+14].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        
        $filename = 'MT_Stock_Tracker_For_'.$zone.'_'.$report_date.'.xlsx';

        if($action=="save") {
            // $path  = '/home/eatangcp/public_html/test/assets/uploads/mt_stock_reports/';
            // $upload_path = '/home/eatangcp/public_html/test/assets/uploads/mt_stock_reports';

            // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = '/home/eatangcp/public_html/eat_erp/assets/uploads/mt_stock_reports';

            // $path  = '/var/www/html/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = '/var/www/html/eat_erp/assets/uploads/mt_stock_reports';

            // $path  = 'C:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = 'C:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports';

            // $path  = 'E:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = 'E:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports';


            $path = $this->config->item('upload_path').'mt_stock_reports/';
            $upload_path = $this->config->item('upload_path').'mt_stock_reports';

            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $reportpath = $path.$filename;

            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment;filename="'.$filename.'"');
            // header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
            $objWriter->save($reportpath);

            echo $reportpath;
            echo '<br/><br/>';

            $return_arr = array('reportpath'=>$reportpath, 'tr'=> $tr);

            // return $reportpath;
            return $return_arr;
        } else {
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Type: application/openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']='MT Stock Tracker Report Generated.';
            $this->user_access_log_model->insertAccessLog($logarray);

            exit;
        }
    }
}

public function send_mt_stock_tracker_weekly() {
    // $date = '2019-07-11';
    $date = date('Y-m-d');

    // $zone_id_array = ['16'];
    // $zone_array = ['Mumbai'];
    // $zone_email_array = ['Sulochana.yadav@eatanytime.in'];

    // $zone_id_array = ['9', '10', '12', '16', '18', '29', '30'];
    // $zone_array = ['Chennai', 'Pune', 'Hyderbad', 'Mumbai', 'Banglore', 'Ahmedabad', 'Delhi'];
    // $zone_email_array = ['', 'mohil.telawade@eatanytime.in', 'vijay.spar@gmail.com', 
    //                     'Sulochana.yadav@eatanytime.in, mukesh.yadav@eatanytime.in, sachin.pal@eatanytime.in', 
    //                     'darshan.dhany@eatanytime.in, mahesh.ms@eatanytime.in', 'urvi.bhayani@eatanytime.in', 
    //                     'nitin.kumar@eatanytime.in'];

    $reportpath = '';
    $tr = '';
    
    $return_arr = $this->get_mt_stock_report_weekly($date, 'save');
    // $return_arr = $this->get_mt_stock_report_weekly($date);

    if(isset($return_arr['reportpath'])){
        $reportpath = $return_arr['reportpath'];
    }
    if(isset($return_arr['tr'])){
        $tr = $return_arr['tr'];
    }

    if($reportpath!=''){
        $report_date = date('d-m-Y', strtotime($date));

        $message = '<html>
                    <head>
                        <style>
                            td { padding: 5px; width: 100px; }
                        </style>
                    </head>
                    <body>
                        <h3>Wholesome Habits Private Limited</h3>
                        <h4>MT Stock Tracker Weekly</h4>
                        <p>Reporting Date - '.$report_date.'</p>
                        <p>PFA</p>

                        <br/><br/>
                        Regards,
                        <br/><br/>
                        CS
                    </body>
                    </html>';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'EAT MIS';
        $subject = 'MT_Stock_Tracker_Weekly_'.$report_date;


        /*$to_email = "dhaval.maru@otbconsulting.co.in";
        $cc="prasad.bhisale@otbconsulting.co.in";
        $bcc="prasad.bhisale@otbconsulting.co.in";*/
        
        $to_email = 'prasad.bhisale@otbconsulting.co.in';
        $cc = 'prasad.bhisale@otbconsulting.co.in';
        $bcc = 'prasad.bhisale@otbconsulting.co.in';

        // $to_email = "priti.tripathi@eatanytime.in, operations@eatanytime.in, swapnil.darekar@eatanytime.in";
        // $cc = "rishit.sanghvi@eatanytime.in";
        // $bcc = "prasad.bhisale@otbconsulting.co.in, dhaval.maru@otbconsulting.co.in";

        $sql = "select * from report_master where report_name = 'MT Stock Tracker Weekly'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0) {
            $from_email = $result[0]->from_email;
            $from_email_sender = $result[0]->sender_name;
            $to_email = $result[0]->to_email;
            $cc = $result[0]->cc_email;
            $bcc = $result[0]->bcc_email;
        }

        echo $attachment = $reportpath;
        echo '<br/><br/>';
        echo $message;
        echo '<br/><br/>';

        $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);

        echo $mailSent;
        echo '<br/><br/>';

        if($mailSent==1){
            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']='MT Stock report weekly sent.';
            $this->user_access_log_model->insertAccessLog($logarray);
        }
    }
}

public function get_mt_stock_report_weekly($date='', $action='save') {
    if($date==''){
        $date = date('Y-m-d');
    }

    $report_date = date('d-m-Y', strtotime($date));
    $reportpath = '';

    $template_path = $this->config->item('template_path');
    $file = $template_path.'MT_Stock_Tracker_Weekly.xlsx';
    $this->load->library('excel');
    $objPHPExcel = PHPExcel_IOFactory::load($file);

    $col_name[]=array();
    for($i=0; $i<=200; $i++) {
        $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
    }

    $start_row = 27;
    $row = $start_row;
    $col = 6;
    $tr = '';

    $sql = "Select distinct G.*, H.store_name from 
            (Select  E.*, F.location from 
            (Select  J.*, D.zone from 
            (Select I.*, A.category from
            (select distinct store_id, location_id, zone_id from merchandiser_beat_plan where status='Approved') I
            left join
            (select * from store_master where status='Approved') A
            on (I.store_id=A.store_id and I.location_id=A.location_id and I.zone_id=A.zone_id)) J
            left join 
            (select * from zone_master) D 
            on (J.zone_id=D.id)) E 
            left join 
            (select * from location_master) F 
            on (E.location_id=F.id)) G 
            left join 
            (select * from relationship_master) H 
            on (G.store_id=H.id) 
            order by G.zone, H.store_name, G.location";
    $query = $this->db->query($sql);
    $result = $query->result();

    if(count($result)>0){
        for($i=0; $i<count($result); $i++){
            $zone = ucwords(trim($result[$i]->zone));
            $store = ucwords(trim($result[$i]->store_name));
            $location = ucwords(trim($result[$i]->location));

            $zone_id = $result[$i]->zone_id;
            $store_id = $result[$i]->store_id;
            $location_id = $result[$i]->location_id;

            $date_of_visit = '';
            $butterscotch_cnt = 0;
            $orange_cnt = 0;
            $chocopeanut_cnt = 0;
            $mango_cnt = 0;
            $bambaiya_cnt = 0;
            $berry_cnt = 0;
            $chyawanprash_cnt = 0;
            $variety_cnt = 0;
            $choco_cnt = 0;
            $dark_choco_cnt = 0;
            $cranb_cnt = 0;
            $t_cranb_cnt = 0;
            $t_fig_cnt = 0;
            $t_papaya_cnt = 0;
            $user_name = '';

            $diff = '';
            $sql = "select A.*, concat(ifnull(B.first_name,''), ' ',ifnull(B.last_name,'')) as user_name , 
                    DATEDIFF(curdate(),date(A.date_of_visit)) as diff 
                    from merchandiser_stock A left join user_master B on (A.created_by=B.id) 
                    where A.dist_id = '$store_id' and A.location_id = '$location_id' and 
                        date(A.date_of_visit)<=date('".$date."') 
                    order by A.date_of_visit desc";
            $query = $this->db->query($sql);
            $result2 = $query->result();
            if(count($result2)>0){
                $merchandiser_stock_id = $result2[0]->id;
                if(isset($result2[0]->date_of_visit)){
                    if($result2[0]->date_of_visit!=null && $result2[0]->date_of_visit!=''){
                        $date_of_visit = date('d-m-Y',strtotime($result2[0]->date_of_visit));
                        $diff = $result2[0]->diff;
                    }
                }
                $user_name = ucwords(trim($result2[0]->user_name));

                $sql = "select E.merchandiser_stock_id, E.item_id, sum(E.qty) as qty from 
                        (select A.merchandiser_stock_id, A.item_id, A.qty from merchandiser_stock_details A 
                        where A.merchandiser_stock_id = '$merchandiser_stock_id' and (A.type = 'Bar' or (A.type = 'Box' and A.item_id='32')) 
                        union all 
                        select D.* from 
                        (select C.merchandiser_stock_id, C.item_id, sum(C.qty) as qty from 
                        (select A.merchandiser_stock_id, B.product_id as item_id, 
                        case when (B.product_id='16' or B.product_id='17' or B.product_id='18' or 
                            B.product_id='19' or B.product_id='20' or B.product_id='21') then A.qty else A.qty*B.qty end as qty 
                        from merchandiser_stock_details A left join box_product B on (A.type = 'Box' and A.item_id = B.box_id) 
                        where A.merchandiser_stock_id = '$merchandiser_stock_id' and A.type = 'Box' and A.item_id<>'32') C 
                        group by C.merchandiser_stock_id, C.item_id) D) E 
                        group by E.merchandiser_stock_id, E.item_id";

                $query = $this->db->query($sql);
                $result2 = $query->result();
                if(count($result2)>0){
                    for($j=0; $j<count($result2); $j++){
                        if($result2[$j]->item_id=='1'){
                            $orange_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='3'){
                            $butterscotch_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='4'){
                            $bambaiya_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='5'){
                            $chocopeanut_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='6'){
                            $mango_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='9'){
                            $berry_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='10'){
                            $chyawanprash_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='32'){
                            $variety_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='16'){
                            $choco_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='17'){
                            $dark_choco_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='18'){
                            $cranb_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='19'){
                            $t_cranb_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='20'){
                            $t_fig_cnt = $result2[$j]->qty;
                        } else if($result2[$j]->item_id=='21'){
                            $t_papaya_cnt = $result2[$j]->qty;
                        }
                    }
                }
            }

            $col = 0;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $zone);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $store);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $location);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $store."-".$location);

            $col = $col + 4;
            $style = "";

            if($date_of_visit!='') {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $date_of_visit);
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $diff);
                $col = $col + 1;
            } else {
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row.':'.$col_name[$col+1].$row)->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'FFC7CE'
                    )
                ));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, " ");
                $col = $col + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $diff);
                $col = $col + 1;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $butterscotch_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $orange_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $chocopeanut_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $mango_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $bambaiya_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $berry_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $chyawanprash_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $variety_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $choco_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $dark_choco_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $cranb_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $t_cranb_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $t_fig_cnt);
            $col = $col + 1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $t_papaya_cnt);
            $col = $col + 1;

            $objConditional = new PHPExcel_Style_Conditional();
            $objConditional->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                            ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_EQUAL)
                            ->addCondition('""')
                            ->getStyle()
                            ->applyFromArray(
                                    array(
                                            'font'=>array(
                                                'color'=>array('argb'=>'FF000000')
                                            ),
                                            'fill'=>array(
                                                'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                'startcolor' =>array('argb' => 'FFFFC7CE'),
                                                'endcolor' =>array('argb' => 'FFFFC7CE')
                                            )
                                        )
                                );

            $objConditional2 = new PHPExcel_Style_Conditional();
            $objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                            ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
                            ->addCondition('7')
                            ->getStyle()
                            ->applyFromArray(
                                    array(
                                            'font'=>array(
                                                'color'=>array('argb'=>'FF000000')
                                            ),
                                            'fill'=>array(
                                                'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                'startcolor' =>array('argb' => 'FFFF0000'),
                                                'endcolor' =>array('argb' => 'FFFF0000')
                                            )
                                        )
                                );

            $objConditional3 = new PHPExcel_Style_Conditional();
            $objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                            ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHANOREQUAL)
                            ->addCondition('7')
                            ->getStyle()
                            ->applyFromArray(
                                    array(
                                            'font'=>array(
                                                'color'=>array('argb'=>'FF000000')
                                            ),
                                            'fill'=>array(
                                                'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                'startcolor' =>array('argb' => 'FF00B050'),
                                                'endcolor' =>array('argb' => 'FF00B050')
                                            )
                                        )
                                );

            $conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle($col_name[$col-15].$row)->getConditionalStyles();
            array_push($conditionalStyles,$objConditional,$objConditional2,$objConditional3);
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col-15].$row)->setConditionalStyles($conditionalStyles);
            

            $objConditional = new PHPExcel_Style_Conditional();
            $objConditional->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                            ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
                            ->addCondition('1')
                            ->getStyle()
                            ->applyFromArray(
                                    array(
                                            'font'=>array(
                                                'color'=>array('argb'=>'FF000000')
                                            ),
                                            'fill'=>array(
                                                'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                'startcolor' =>array('argb' => 'FFFF0000'),
                                                'endcolor' =>array('argb' => 'FFFF0000')
                                            )
                                        )
                                );

            $objConditional2 = new PHPExcel_Style_Conditional();
            $objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                            ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
                            ->addCondition('1')
                            ->getStyle()
                            ->applyFromArray(
                                    array(
                                            'font'=>array(
                                                'color'=>array('argb'=>'FF000000')
                                            ),
                                            'fill'=>array(
                                                'type' =>PHPExcel_Style_Fill::FILL_SOLID,
                                                'startcolor' =>array('argb' => 'FF00B050'),
                                                'endcolor' =>array('argb' => 'FF00B050')
                                            )
                                        )
                                );
            $conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle(($col_name[$col-14].$row).':'.($col_name[$col-1].$row))->getConditionalStyles();
            array_push($conditionalStyles,$objConditional,$objConditional2);
            $objPHPExcel->getActiveSheet()->getStyle(($col_name[$col-14].$row).':'.($col_name[$col-1].$row))->setConditionalStyles($conditionalStyles);

            $row = $row + 1;
        }

        $row = $row - 1;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':'.$col_name[$col-1].$row)->applyFromArray(array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    ));

    $filename = 'MT_Stock_Tracker_Weekly_'.$report_date.'.xlsx';

    if($action=="save") {
        // $path  = '/home/eatangcp/public_html/test/assets/uploads/mt_stock_reports/';
        // $upload_path = '/home/eatangcp/public_html/test/assets/uploads/mt_stock_reports';

        // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/mt_stock_reports/';
        // $upload_path = '/home/eatangcp/public_html/eat_erp/assets/uploads/mt_stock_reports';

        // $path  = '/var/www/html/eat_erp/assets/uploads/mt_stock_reports/';
        // $upload_path = '/var/www/html/eat_erp/assets/uploads/mt_stock_reports';

        // $path  = 'C:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports/';
        // $upload_path = 'C:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports';

        // $path  = 'E:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports/';
        // $upload_path = 'E:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports';


        $path = $this->config->item('upload_path').'mt_stock_reports/';
        $upload_path = $this->config->item('upload_path').'mt_stock_reports';

        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $reportpath = $path.$filename;

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
        $objWriter->save($reportpath);

        echo $reportpath;
        echo '<br/><br/>';

        $return_arr = array('reportpath'=>$reportpath, 'tr'=> $tr);

        // return $reportpath;
        return $return_arr;
    } else {
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='MT Stock Tracker Report Generated.';
        $this->user_access_log_model->insertAccessLog($logarray);

        exit;
    }
}

public function send_exception_report() {
    $date = date('Y-m-d');
    // $date = '2019-07-16';

    //and (A.ref_id is null or A.ref_id = '')  removed this from sales and Sales Return 
    //and date(A.created_on)<date('".$date."') bcoz ref_id is only assign to previous approved
    //and case When (date(A.created_on)=date('".$date."') AND (A.ref_id is not null or A.ref_id != '') Then (A.ref_id is not null or A.ref_id != '')

    $sql = "select 'Sales' as temp_col, sum(case when date(A.created_on)=date('".$date."') then 1 else 0 end) as entry_done, 
        sum(case when date(A.date_of_processing)<date('".$date."') and (A.status = 'Pending' or A.status = 'Deleted') and (A.delivery_status='Pending' or A.delivery_status='GP Issued' or A.delivery_status='Delivered Not Complete' or A.delivery_status='Delivered') then 1 else 0 end) as pending, 
            sum(
            case 
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')))
                 then 1 
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')))
                 then 0
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)<date('".$date."') ))
                  then 1
            else 0
            END
            ) as prior_pending 
            from distributor_out A 
            where A.date_of_processing is not null and A.distributor_id!='1' and A.distributor_id!='189' 


            union all 

            select 'Payment Received' as temp_col, sum(case when date(A.created_on)=date('".$date."') then 1 else 0 end) as entry_done, 
            sum(case when date(A.date_of_deposit)<date('".$date."') and (A.status = 'Pending' or A.status = 'Deleted') and (A.ref_id is null or A.ref_id = '') then 1 else 0 end) as pending, 
             sum(
                case 
                when date(A.date_of_deposit)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')))
                     then 1 
                when date(A.date_of_deposit)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')))
                     then 0
                when date(A.date_of_deposit)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)<date('".$date."') ))
                      then 1
                else 0
                END
                ) as prior_pending
            from payment_details A where A.date_of_deposit is not null 

            union all

            select 'Sales Return' as temp_col, sum(case when date(A.created_on)=date('".$date."') then 1 else 0 end) as entry_done, 
            sum(case when date(A.date_of_processing)<date('".$date."') and (A.status = 'Pending' or A.status = 'Deleted') then 1 else 0 end) as pending, 
            sum(
            case 
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')))
                 then 1 
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')))
                 then 0
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)<date('".$date."') ))
                  then 1
            else 0
            END
            ) as prior_pending  
            from distributor_in A where A.date_of_processing is not null

            union all 

            select 'Sample' as temp_col, sum(case when date(A.created_on)=date('".$date."') then 1 else 0 end) as entry_done, 
            sum(case when date(A.date_of_processing)<date('".$date."') and (A.status = 'Pending' or A.status = 'Deleted') and (delivery_status='Pending' or delivery_status='GP Issued' or delivery_status='Delivered Not Complete' or delivery_status='Delivered') and (A.ref_id is null or A.ref_id = '') then 1 else 0 end) as pending, 
           sum(
            case 
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')))
                 then 1 
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')))
                 then 0
            when date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)<date('".$date."') ))
                  then 1
            else 0
            END
            ) as prior_pending 
            from distributor_out A 
            where A.date_of_processing is not null and (A.distributor_id='1' or A.distributor_id='189') 

            union all 

            select 'Credit Notes' as temp_col, sum(case when date(A.created_on)=date('".$date."') then 1 else 0 end) as entry_done, 
            sum(case when date(A.date_of_transaction)<date('".$date."') and (A.status = 'Pending' or A.status = 'Deleted') then 1 else 0 end) as pending, 
            sum(
                case 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != ''))) 
                     then 1 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = ''))) 
                     then 0 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)<date('".$date."') )) 
                      then 1 
                else 0
                END
            ) as prior_pending 
            from credit_debit_note A where A.date_of_transaction is not null and transaction = 'Credit Note' 

            union all 

            select 'Debit Notes' as temp_col, sum(case when date(A.created_on)=date('".$date."') then 1 else 0 end) as entry_done, 
            sum(case when date(A.date_of_transaction)<date('".$date."') and (A.status = 'Pending' or A.status = 'Deleted') then 1 else 0 end) as pending, 
            sum(
                case 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')))
                     then 1 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')))
                     then 0
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)<date('".$date."') ))
                      then 1
                else 0
                END
            ) as prior_pending
            from credit_debit_note A where A.date_of_transaction is not null and transaction = 'Debit Note' 

            union all 

            select 'Expense Vouchers' as temp_col, sum(case when date(A.created_on)=date('".$date."') then 1 else 0 end) as entry_done, 
            sum(case when date(A.date_of_transaction)<date('".$date."') and (A.status = 'Pending' or A.status = 'Deleted') then 1 else 0 end) as pending, 
            sum(
                case 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != ''))) 
                     then 1 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = ''))) 
                     then 0 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)<date('".$date."') )) 
                      then 1 
                else 0
                END
            ) as prior_pending 
            from credit_debit_note A where A.date_of_transaction is not null and transaction = 'Expense Voucher' 

            union all 

            select 'Expense Voucher Reversals' as temp_col, sum(case when date(A.created_on)=date('".$date."') then 1 else 0 end) as entry_done, 
            sum(case when date(A.date_of_transaction)<date('".$date."') and (A.status = 'Pending' or A.status = 'Deleted') then 1 else 0 end) as pending, 
            sum(
                case 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')))
                     then 1 
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')))
                     then 0
                when date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (date(A.created_on)<date('".$date."') ))
                      then 1
                else 0
                END
            ) as prior_pending
            from credit_debit_note A where A.date_of_transaction is not null and transaction = 'Expense Voucher Reversal'";

    $query = $this->db->query($sql);
    $result = $query->result();
    $entry_table = '';
    if(count($result)>0) {
        for($i=0; $i<count($result); $i++) {
            $link1 = '';
            $link2 = '';
            if(strtoupper(trim($result[$i]->temp_col))=='SALES') {
                $link1 = base_url().'index.php/distributor_out';
                $link2 = base_url().'index.php/distributor_out/checkstatus/pending_for_approval';
            }
            if(strtoupper(trim($result[$i]->temp_col))=='PAYMENT RECEIVED') {
                $link1 = base_url().'index.php/payment';
                $link2 = base_url().'index.php/payment/checkstatus/Pending';
            }
            if(strtoupper(trim($result[$i]->temp_col))=='SALES RETURN') {
                $link1 = base_url().'index.php/Distributor_in';
                $link2 = base_url().'index.php/Distributor_in/checkstatus/Pending';
            }
            if(strtoupper(trim($result[$i]->temp_col))=='SAMPLE') {
                $link1 = base_url().'index.php/Sample_out';
                $link2 = base_url().'index.php/Sample_out/checkstatus/pending_for_approval';
            }
            if(strtoupper(trim($result[$i]->temp_col))=='CREDIT NOTES' || strtoupper(trim($result[$i]->temp_col))=='DEBIT NOTES' || 
                strtoupper(trim($result[$i]->temp_col))=='EXPENSE VOUCHERS' || strtoupper(trim($result[$i]->temp_col))=='EXPENSE VOUCHER REVERSALS') {
                $link1 = base_url().'index.php/Credit_debit_note';
                $link2 = base_url().'index.php/Credit_debit_note/checkstatus/Pending';
            }
            $entry_table = $entry_table . '<tr>
                                <td>'.$result[$i]->temp_col.'</td>
                                <td style="text-align: center;"><!-- <a href="'.$link1.'" target="_blank"> -->'.$result[$i]->entry_done.'<!-- </a> --></td>
                                <td style="text-align: center; color: #F00;"><!-- <a href="'.$link2.'" target="_blank" style="color: #F00;"> -->'.$result[$i]->pending.'<!-- </a> --></td>
                                <td style="text-align: center; color: #F00;"><!-- <a href="'.$link2.'" target="_blank" style="color: #F00;"> -->'.$result[$i]->prior_pending.'<!-- </a> --></td>
                            </tr>';
        }
    }
    // echo $sql;
    // echo '<br/><br/>';

    $sql = "select 'Sales Delivery' as temp_col, sum(case when A.delivery_status = 'Pending' then 1 else 0 end) as delivery_pending, sum(case when A.delivery_status = 'GP Issued' then 1 else 0 end) as in_transit from distributor_out A where A.status = 'Approved' and A.date_of_processing is not null and A.distributor_id!='1' and A.distributor_id!='189' 

        union all 

        select 'Sample Delivery' as temp_col, sum(case when A.delivery_status = 'Pending' then 1 else 0 end) as delivery_pending, sum(case when A.delivery_status = 'GP Issued' then 1 else 0 end) as in_transit from distributor_out A where A.status = 'Approved' and A.date_of_processing is not null and (A.distributor_id='1' or A.distributor_id='189')";
    $query = $this->db->query($sql);
    $result = $query->result();
    $delivery_table = '';
    if(count($result)>0) {
        for($i=0; $i<count($result); $i++) {
            $link1 = '';
            $link2 = '';
            if(strtoupper(trim($result[$i]->temp_col))=='SALES DELIVERY') {
                $link1 = base_url().'index.php/distributor_out/checkstatus/pending_for_delivery';
                $link2 = base_url().'index.php/distributor_out/checkstatus/gp_issued';
            } else if(strtoupper(trim($result[$i]->temp_col))=='SAMPLE DELIVERY') {
                $link1 = base_url().'index.php/sample_out/checkstatus/pending_for_delivery';
                $link2 = base_url().'index.php/sample_out/checkstatus/gp_issued';
            }
            $delivery_table = $delivery_table . '<tr>
                                <td>'.$result[$i]->temp_col.'</td>
                                <td style="text-align: center; color: #F00;"><!-- <a href="'.$link1.'" target="_blank" style="color: #F00;"> -->'.$result[$i]->delivery_pending.'<!-- </a> --></td>
                                <td style="text-align: center; color: #F00;"><!-- <a href="'.$link2.'" target="_blank" style="color: #F00;"> -->'.$result[$i]->in_transit.'<!-- </a> --></td>
                            </tr>';
        }
    }
    // echo $sql;
    // echo '<br/><br/>';

    $sql = "select Distinct 'Sales' as temp_col, A.id, A.date_of_processing as ref_date, A.invoice_no as ref_no, A.distributor_id, A.invoice_amount as amount, A.modified_by, A.modified_on, B.distributor_name, concat(ifnull(C.first_name,''),' ',ifnull(C.last_name,'')) as modifiedby 
        from distributor_out A left join distributor_master B on (A.distributor_id=B.id) left join user_master C on (A.modified_by=C.id) 
        where A.date_of_processing is not null and A.distributor_id!='1' and A.distributor_id!='189' and date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and 
            (Case When 
            date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')
            Then 1=1
            When date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')
            Then 1=0
            When date(A.created_on)<date('".$date."') 
            Then 1=1
            else
            1=0
            End )
        ) 

        union all 

        select Distinct 'Payment Received' as temp_col, A.id, A.date_of_deposit as ref_date, B.ref_no, B.distributor_id, B.payment_amount as amount, A.modified_by, A.modified_on, C.distributor_name, concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as modifiedby 
        from payment_details A left join payment_details_items B on (A.id=B.payment_id) left join distributor_master C on (B.distributor_id=C.id) left join user_master D on (A.modified_by=D.id) 
        where A.date_of_deposit is not null and date(A.date_of_deposit)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and 
            (Case When 
            date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')
            Then 1=1
            When date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')
            Then 1=0
            When date(A.created_on)<date('".$date."') 
            Then 1=1
            else
            1=0
            End )
        )

        union all 

        select Distinct 'Sales Return' as temp_col, A.id, A.date_of_processing as ref_date, A.sales_return_no as ref_no, A.distributor_id, A.final_amount as amount, A.modified_by, A.modified_on, B.distributor_name, concat(ifnull(C.first_name,''),' ',ifnull(C.last_name,'')) as modifiedby 
        from distributor_in A left join distributor_master B on (A.distributor_id=B.id) left join user_master C on (A.modified_by=C.id) 
        where A.date_of_processing is not null and date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (Case When 
            date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')
            Then 1=1
            When date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')
            Then 1=0
            When date(A.created_on)<date('".$date."') 
            Then 1=1
            else
            1=0
            End ))

        union all 

        select Distinct 'Sample' as temp_col, A.id, A.date_of_processing as ref_date, A.voucher_no as ref_no, A.distributor_id, A.final_amount as amount, A.modified_by, A.modified_on, B.distributor_name, concat(ifnull(C.first_name,''),' ',ifnull(C.last_name,'')) as modifiedby 
        from distributor_out A left join distributor_master B on (A.distributor_id=B.id) left join user_master C on (A.modified_by=C.id) 
        where A.date_of_processing is not null and (A.distributor_id='1' or A.distributor_id='189') and date(A.date_of_processing)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (Case When 
            date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')
            Then 1=1
            When date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')
            Then 1=0
            When date(A.created_on)<date('".$date."') 
            Then 1=1
            else
            1=0
            End )) 

        union all 

        select Distinct 'Credit Notes' as temp_col, A.id, A.date_of_transaction as ref_date, A.ref_no, A.distributor_id, A.amount, A.modified_by, A.modified_on, B.distributor_name, concat(ifnull(C.first_name,''),' ',ifnull(C.last_name,'')) as modifiedby 
        from credit_debit_note A left join distributor_master B on (A.distributor_id=B.id) left join user_master C on (A.modified_by=C.id) 
        where A.date_of_transaction is not null and date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (Case When 
            date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')
            Then 1=1
            When date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')
            Then 1=0
            When date(A.created_on)<date('".$date."') 
            Then 1=1
            else
            1=0
            End )
        ) and transaction = 'Credit Note' 

        union all 

        select Distinct 'Debit Notes' as temp_col, A.id, A.date_of_transaction as ref_date, A.ref_no, A.distributor_id, A.amount, A.modified_by, A.modified_on, B.distributor_name, concat(ifnull(C.first_name,''),' ',ifnull(C.last_name,'')) as modifiedby 
        from credit_debit_note A left join distributor_master B on (A.distributor_id=B.id) left join user_master C on (A.modified_by=C.id) 
        where A.date_of_transaction is not null and date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (Case When 
            date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')
            Then 1=1
            When date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')
            Then 1=0
            When date(A.created_on)<date('".$date."') 
            Then 1=1
            else
            1=0
            End )
        ) and transaction = 'Debit Note' 

        union all 

        select Distinct 'Expense Vouchers' as temp_col, A.id, A.date_of_transaction as ref_date, A.ref_no, A.distributor_id, A.amount, A.modified_by, A.modified_on, B.distributor_name, concat(ifnull(C.first_name,''),' ',ifnull(C.last_name,'')) as modifiedby 
        from credit_debit_note A left join distributor_master B on (A.distributor_id=B.id) left join user_master C on (A.modified_by=C.id) 
        where A.date_of_transaction is not null and date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (Case When 
            date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')
            Then 1=1
            When date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')
            Then 1=0
            When date(A.created_on)<date('".$date."') 
            Then 1=1
            else
            1=0
            End )
        ) and transaction = 'Expense Voucher' 

        union all 

        select Distinct 'Expense Voucher Reversals' as temp_col, A.id, A.date_of_transaction as ref_date, A.ref_no, A.distributor_id, A.amount, A.modified_by, A.modified_on, B.distributor_name, concat(ifnull(C.first_name,''),' ',ifnull(C.last_name,'')) as modifiedby 
        from credit_debit_note A left join distributor_master B on (A.distributor_id=B.id) left join user_master C on (A.modified_by=C.id) 
        where A.date_of_transaction is not null and date(A.date_of_transaction)<date('".$date."') and (A.modified_approved_date is not null and date(A.modified_approved_date)=date('".$date."') and (Case When 
            date(A.created_on)=date('".$date."')  AND (A.ref_id is not null or A.ref_id != '')
            Then 1=1
            When date(A.created_on)=date('".$date."')  AND (A.ref_id is null or A.ref_id = '')
            Then 1=0
            When date(A.created_on)<date('".$date."') 
            Then 1=1
            else
            1=0
            End )
        ) and transaction = 'Expense Voucher Reversal'";

    $query = $this->db->query($sql);
    $result = $query->result();
    $filename = '';
    $path = '';
    if(count($result)>0) {
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
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Exception Reporting - Operations");
        $row=$row+2;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Reporting Date - " . (($date!=null && $date!="")?date("d-m-Y",strtotime($date)):""));

        //------------ setting headers of excel -------------
        $row=$row+2;
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Entry Type');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'System ID');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Ref Date');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Reference');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Distributor');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, 'Amount');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, 'Modified By');
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, 'Modified On');

        for($i=0; $i<count($result); $i++) {

            if($result[$i]->temp_col=='Sample')
            {
                $url = base_url('index.php/sample_out/edit/d_'.$result[$i]->id);
            }
            else if($result[$i]->temp_col=='Sales')
            {
                $url = base_url('index.php/Distributor_out/edit/d_'.$result[$i]->id);
            }
            else if($result[$i]->temp_col=='Payment Received')
            {
                $url = base_url('index.php/payment/edit/'.$result[$i]->id);
            }
            else if($result[$i]->temp_col=='Sales Return')
            {
                $url = base_url('index.php/distributor_in/edit/'.$result[$i]->id);
            }
            else if($result[$i]->temp_col=='Credit Notes' || $result[$i]->temp_col=='Debit Notes' || 
                    $result[$i]->temp_col=='Expense Vouchers' || $result[$i]->temp_col=='Expense Voucher Reversals')
            {
                $url = base_url('index.php/credit_debit_note/edit/'.$result[$i]->id);
            }

            
           
            $row=$row+1;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $result[$i]->temp_col);
            /*$objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row,'=Hyperlink("'.$url.'",'.$result[$i]->id.')');*/
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row,$result[$i]->id);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, (($result[$i]->ref_date!=null && $result[$i]->ref_date!="")?date("d-m-Y",strtotime($result[$i]->ref_date)):""));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $result[$i]->ref_no);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $result[$i]->distributor_name);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $result[$i]->amount);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, $result[$i]->modifiedby);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, (($result[$i]->modified_on!=null && $result[$i]->modified_on!="")?date("d-m-Y",strtotime($result[$i]->modified_on)):""));
        }

        $objPHPExcel->getActiveSheet()->getStyle('A7:H7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A7:'.$col_name[$col+7].$row)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        $filename='Exception_Report.xls';
        //$path  = 'C:\xampp\htdocs\eat_erp_new_30\assets\uploads\exception_reports';
        // $path  = '/home/eatangcp/public_html/test/assets/uploads/exception_reports/';
        // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/exception_reports/';
        // $path  = '/var/www/html/eat_erp/assets/uploads/exception_reports/';

        $path = $this->config->item('upload_path').'exception_reports/';

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save('php://output');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
        $objWriter->save($path.$filename);
    }

    $message = '<html>
                <body>
                    <h3>Wholesome Habits Private Limited</h3>
                    <h4>Exception Reporting - Operations</h4>
                    <p>Reporting Date - '.(($date!=null && $date!="")?date("d-m-Y",strtotime($date)):"").'</p>
                    <table border="1" style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">Type</th>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">Entries Done</th>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">Pending Approval</th>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">Prior Period Modifications</th>
                            </tr>
                        </thead>
                        <tbody>'.$entry_table.'</tbody>
                    </table>
                    <br/><br/>
                    <table border="1" style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">Type</th>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">Delivery Pending</th>
                                <th style="background-color: #44546A; color: #FFF; padding: 10px;">In Transit</th>
                            </tr>
                        </thead>
                        <tbody>'.$delivery_table.'</tbody>
                    </table>
                    <br/><br/>
                    Regards,
                    <br/><br/>
                    CS
                </body>
                </html>';
    $from_email = 'info@eatanytime.in';
    $from_email_sender = 'EAT MIS';
    $subject = 'Exception Report - '.(($date!=null && $date!="")?date("d-m-Y",strtotime($date)):"");

    $to_email = 'prasad.bhisale@otbconsulting.co.in';
    $cc = 'prasad.bhisale@otbconsulting.co.in';
    $bcc = 'prasad.bhisale@otbconsulting.co.in';

    // $to_email = "priti.tripathi@eatanytime.in, operations@eatanytime.in";
    // $cc="rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in";
    // $bcc="dhaval.maru@otbconsulting.co.in, prasad.bhisale@otbconsulting.co.in";

    $sql = "select * from report_master where report_name = 'Exception Report'";
    $query = $this->db->query($sql);
    $result = $query->result();
    if(count($result)>0) {
        $from_email = $result[0]->from_email;
        $from_email_sender = $result[0]->sender_name;
        $to_email = $result[0]->to_email;
        $cc = $result[0]->cc_email;
        $bcc = $result[0]->bcc_email;
    }

    echo $attachment = $path.$filename;
    // $to_email = 'dhaval.maru@otbconsulting.co.in,dhavalbright@gmail.com';
    // $to_email = 'rishit.sanghvi@eatanytime.in,swapnil.darekar@eatanytime.in;dhaval.maru@otbconsulting.co.in';
    $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);

    // $mailSent=1;
    
    echo $message;
    echo '<br/><br/>';
    echo $mailSent;

    if($mailSent==1){
        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Exception report sent.';
        $this->user_access_log_model->insertAccessLog($logarray);
    }
}

public function send_production_exception_report(){
    $tbody ='';
    $from_email = 'cs@eatanytime.in';
    $from_email_sender = 'EAT MIS';
    
    $task = $this->get_task_cnt();
    $pre_production = $this->get_pre_production_cnt();
    $post_production = $this->get_post_production_cnt();
    $po_count = $this->get_po_count();

    $date = date("Y-m-d");
    // $date = '2019-07-16';
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
                    
                    Kindly find the updated Production Exception report As On '.date('d-m-Y',strtotime($date)).'
                    
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

                    if(count($po_count)>0) {
                        $tbody.='<tr>
                            <td class="innerpadding1 " style="">
                            <br>
                            <h3>Purchase Order </h3>
                            <table  class="body_table" style="border-collapse: collapse;width:100%;border:1px solid #000!important;">
                            <thead>
                                <tr style=" background-color:#002060;color:#fff ;border-bottom: 1px solid #000;font-weight: bold;">
                        
                                  <th width="200" style="border-right: 1px solid #000;padding: 0 8px;text-align:left;width:200px">Approval Pending</th>
                                  <th style="border-right: 1px solid #000;padding: 0 8px;text-align: left;width:70px;">Open</th>
                                  <th style="border-right: 1px solid #000;padding: 0 8px;text-align: left;width:70px;">Payment Pending</th>
                                  <th style="border-right: 1px solid #000;padding: 0 8px;text-align: left;width:70px;">Advance</th>
                                </tr>
                            </thead>
                            <tbody style="border:1px solid #000;
                                            background-color: #fff;
                                            color: #000;">
                                <tr>
                                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: center;padding: 0 8px;">'.$po_count[0]->pending_cnt.'</td>
                                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: center;padding: 0 8px;">'.$po_count[0]->open_cnt.'</td>
                                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: center;padding: 0 8px;">'.$po_count[0]->pending_payment_cnt.'</td>
                                    <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: center;padding: 0 8px;">'.$po_count[0]->advance_payment_cnt.'</td>
                                </tr>
                            </tbody>
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
                                <td style="border-right: 1px solid #000;text-align: center;border-bottom: 1px solid #000;padding: 0 8px;">'.$pre_production[$i]->open.'</td>
                                <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: center;padding: 0 8px;">'.$pre_production[$i]->overdue.'</td>
                                
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
                                        <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: center;padding: 0 8px;">'.$post_production[$i]->open.'</td>
                                        <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align: center;padding: 0 8px;">'.$post_production[$i]->overdue.'</td>
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

    $task_dtl = $this->get_task_dtl();
    $pre_production_dtl = $this->get_pre_production_dtl();
    $post_production_dtl = $this->get_post_production_dtl();

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
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, "Reporting Date - " . (($date!=null && $date!="")?date("d-m-Y",strtotime($date)):""));

        if(count($task_dtl)>0){
            $row=$row+3;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Task Details');
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row)->getFont()->setBold(true);

            $row=$row+2;
            $start_row=$row;
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, 'Sr No');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, 'Task Name');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Assigned To');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Priority');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Due Date');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, 'Status');

            $sr_no = 1;
            for($i=0; $i<count($task_dtl); $i++) {
                $row=$row+1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $sr_no++);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $task_dtl[$i]->subject_detail);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $task_dtl[$i]->user_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $task_dtl[$i]->priority);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, date('d-m-Y',strtotime($task_dtl[$i]->due_date)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $task_dtl[$i]->status);
            }

            $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':F'.$start_row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':F'.$row)->applyFromArray(array(
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
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Manufacturer');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Notification');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Status');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, 'Due Date');

            $sr_no = 1;
            for($i=0; $i<count($pre_production_dtl); $i++) {
                $row=$row+1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $sr_no++);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $pre_production_dtl[$i]->p_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $pre_production_dtl[$i]->depot_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $pre_production_dtl[$i]->notification);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $pre_production_dtl[$i]->p_status);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, date('d-m-Y',strtotime($pre_production_dtl[$i]->notification_date)));
            }

            $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':F'.$start_row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':F'.$row)->applyFromArray(array(
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
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, 'Manufacturer');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, 'Notification');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, 'Status');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, 'Due Date');

            $sr_no = 1;
            for($i=0; $i<count($post_production_dtl); $i++) {
                $p_status = '';
                if($post_production_dtl[$i]->batch_master==null || $post_production_dtl[$i]->batch_master=='0') 
                    $p_status = 'Confirm Batch Nos.';
                else if($post_production_dtl[$i]->production_details==null || $post_production_dtl[$i]->production_details=='0') 
                    $p_status = 'Confirm Production Details.';
                else if($post_production_dtl[$i]->bar_conversion==null || $post_production_dtl[$i]->bar_conversion=='0') 
                    $p_status = 'Perform Bar Conversion.';
                else if($post_production_dtl[$i]->depot_transfer==null || $post_production_dtl[$i]->depot_transfer=='0') 
                    $p_status = 'Perform Depot Transfer.';
                else if($post_production_dtl[$i]->documents_upload==null || $post_production_dtl[$i]->documents_upload=='0') 
                    $p_status = 'Perform Documents Upload.';
                else if($post_production_dtl[$i]->raw_material_recon==null || $post_production_dtl[$i]->raw_material_recon=='0') 
                    $p_status = 'Perform Raw Material Recon.';
                else if($post_production_dtl[$i]->report_approved==null || $post_production_dtl[$i]->report_approved=='0') {
                    if($post_production_dtl[$i]->report_status==null || $post_production_dtl[$i]->report_status==''){
                        $p_status = 'Submit Production Report For Approval.';
                    } else if(strtoupper(trim($post_production_dtl[$i]->report_status))=='PENDING'){
                        $p_status = 'Approve Production Report.';
                    } else if(strtoupper(trim($post_production_dtl[$i]->report_status))=='REJECTED'){
                        $p_status = 'Production Report Rejected.';
                    } else {
                        $p_status = 'Approve Report.';
                    }
                }
                else if($post_production_dtl[$i]->report_approved=='1') 
                    $p_status = 'Approved.';
                else $p_status = $post_production_dtl[$i]->p_status;

                $row=$row+1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, $sr_no++);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $post_production_dtl[$i]->p_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $post_production_dtl[$i]->depot_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $post_production_dtl[$i]->notification);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $p_status);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, date('d-m-Y',strtotime($post_production_dtl[$i]->notification_date)));
            }

            $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':F'.$start_row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$start_row.':F'.$row)->applyFromArray(array(
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

        $filename = 'Production_Report_'.date('d-m-Y',strtotime($date)).'.xls';
        // $path = 'C:/wamp64/www/eat_erp/assets/uploads/production_reports/';
        // $upload_path = 'C:/wamp64/www/eat_erp/assets/uploads/production_reports';

        // $path  = '/home/eatangcp/public_html/test/assets/uploads/production_reports/';
        // $upload_path = '/home/eatangcp/public_html/test/assets/uploads/production_reports';

        // $path='/home/eatangcp/public_html/eat_erp/assets/uploads/production_reports/';
        // $upload_path = '/home/eatangcp/public_html/eat_erp/assets/uploads/production_reports';
        
        // $path  = '/var/www/html/eat_erp/assets/uploads/production_reports/';
        // $upload_path = '/var/www/html/eat_erp/assets/uploads/production_reports';

        $path = $this->config->item('upload_path').'production_reports/';
        $upload_path = $this->config->item('upload_path').'production_reports';

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


    if(count($task)>0 || count($pre_production) || count($post_production)) {
        //// $to_email = "dhaval.maru@otbconsulting.co.in";
        //$bcc = "dhaval.maru@otbconsulting.co.in";

        $to_email = "prasad.bhisale@otbconsulting.co.in";
        $cc = "prasad.bhisale@otbconsulting.co.in";
        $bcc = "prasad.bhisale@otbconsulting.co.in";
        
        // $to_email = "dinesh.parkhi@eatanytime.in, vaibhav.desai@eatanytime.in, prachi.sanghvi@eatanytime.in";
        // $cc = "rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in";
        // $bcc = "prasad.bhisale@otbconsulting.co.in, dhaval.maru@otbconsulting.co.in";

        $sql = "select * from report_master where report_name = 'Production Exception Report'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0) {
            $from_email = $result[0]->from_email;
            $from_email_sender = $result[0]->sender_name;
            $to_email = $result[0]->to_email;
            $cc = $result[0]->cc_email;
            $bcc = $result[0]->bcc_email;
        }

        $subject = 'Production Exception Report -'.date("d-m-Y",strtotime($date));

        echo '<br/><br/>mail '.$mailSent=send_email_new($from_email, $from_email_sender, $to_email, $subject, $tbody, $bcc, $cc, $attachment);
        if ($mailSent==1) {
            echo "Send";
        } else {
            echo "NOT Send ".$mailSent;
        }

        if($mailSent==1){
            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']='Production Exception report sent.';
            $this->user_access_log_model->insertAccessLog($logarray);
        }

        // load_view('invoice/emailer', $data); 
    }
}

public function send_beat_analysis_report($report_peroid='') {
    if($report_peroid=='Weekly'){
        // $date = '2019-05-06';
        $date = date('Y-m-d');
        $reportpath = '';

        $from_date = date('Y-m-d', (strtotime('-6 day', strtotime($date))));
        $to_date = date('Y-m-d', (strtotime('-1 day', strtotime($date))));

        echo $from_date;
        echo '<br/><br/>';
        echo $to_date;
        echo '<br/><br/>';

        $reportpath = $this->generate_beat_analysis_report($from_date, $to_date, 'save');
    } else {
        // $date = '2019-05-06';
        $date = date('Y-m-d');
        $reportpath = '';

        echo $date;
        echo '<br/><br/>';

        $reportpath = $this->generate_beat_analysis_report($date, $date, 'save');
    }
    

    if($reportpath!=''){
        $report_date = date('d-m-Y');

        $message = '<html>
                    <body>
                        <h3>Wholesome Habits Pvt Ltd</h3>
                        <h4>Beat Analysis Report</h4>
                        <p>Reporting Date - '.$report_date.'</p>
                        <p>PFA</p>
                        <br/><br/>
                        Regards,
                        <br/><br/>
                        CS
                    </body>
                    </html>';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'EAT MIS';
        $subject = 'Beat Analysis Report - '.$report_date;

        $to_email = 'prasad.bhisale@otbconsulting.co.in';
        $cc = 'prasad.bhisale@otbconsulting.co.in';
        $bcc = 'prasad.bhisale@otbconsulting.co.in';

        // $to_email = "swapnil.darekar@eatanytime.in";
        // $cc = "rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in, operations@eatanytime.in";
        // $bcc = "dhaval.maru@otbconsulting.co.in, prasad.bhisale@otbconsulting.co.in";

        $sql = "select * from report_master where report_name = 'Beat Analysis Report'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0) {
            $from_email = $result[0]->from_email;
            $from_email_sender = $result[0]->sender_name;
            $to_email = $result[0]->to_email;
            $cc = $result[0]->cc_email;
            $bcc = $result[0]->bcc_email;
        }

        echo $attachment = $reportpath;
        echo '<br/><br/>';
        $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);

        // $mailSent=1;
        
        // echo $message;
        // echo '<br/><br/>';
        echo $mailSent;
        echo '<br/><br/>';

        if($mailSent==1){
            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']='Beat Analysis report sent.';
            $this->user_access_log_model->insertAccessLog($logarray);
        }
    }
}

function generate_beat_analysis_report($f_date='', $t_date='', $action='') {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));

    if($from_date==''){
        $from_date=$f_date;
    } else {
        $from_date = formatdate($this->input->post('from_date'));
    }

    if($to_date==''){
        $to_date=$t_date;
    } else {
        $to_date = formatdate($this->input->post('to_date'));
    }

    if($from_date==''){
        $from_date=NULL;
    }
    if($to_date==''){
        $to_date=NULL;
    }

    // $from_date = '2018-04-01';
    // $to_date = '2019-03-31';

    $report_date = date('d-m-Y');

    $zone_data = [];
    $zone_list = [];
    $cnt = 0;

    $sql = "select AA.zone, BB.id, BB.distributor_name, BB.beat_id, BB.beat_name, BB.sales_rep_name, 
            BB.total_stores, BB.total_stores_visited, BB.total_order_qty, BB.total_order_amt, BB.total_new_order, 
            BB.total_repeat_order, BB.total_new_order_amt, BB.total_repeat_order_amt from 
            
            (select distinct zone from zone_master where status='Approved' and type_id='3') AA 

            left join 

            (select G.*, H.total_stores, I.total_stores_visited, J.total_order_qty, J.total_order_amt, J.total_new_order, 
                J.total_repeat_order, J.total_new_order_amt, J.total_repeat_order_amt from 
            (select E.id, E.distributor_name, E.zone, E.beat_id, E.beat_name, group_concat(distinct F.sales_rep_name) as sales_rep_name from 
            (select A.id, A.distributor_name, B.zone, C.beat_id, D.beat_name 
            from distributor_master A 
            left join zone_master B on (A.zone_id=B.id) 
            left join distributor_beat_plans C on (A.id=C.distributor_id and C.status='Approved') 
            left join beat_master D on (C.beat_id=D.id) 
            where A.status = 'Approved' and A.class = 'super stockist') E 
            left join 
            (select A.sales_rep_id, A.dist_id1, A.beat_id1, A.dist_id2, A.beat_id2, B.sales_rep_name 
            from beat_allocations A 
            left join sales_rep_master B on (A.sales_rep_id=B.id) 
            where A.status='Approved') F 
            on ((E.id=F.dist_id1 and E.beat_id=F.beat_id1) or (E.id=F.dist_id2 and E.beat_id=F.beat_id2)) 
            group by E.id, E.distributor_name, E.zone, E.beat_id, E.beat_name) G 
            left join 
            (select beat_id, count(dist_id) as total_stores from beat_details group by Beat_id) H 
            on (G.beat_id=H.beat_id) 
            left join 
            (select C.beat_id, sum(C.visit_cnt) as total_stores_visited from 
            (select A.beat_id, A.dist_id, case when B.id is null then 0 else 1 end as visit_cnt 
            from beat_details A 
            left join sales_rep_location B on (A.dist_id=B.distributor_id) 
            where B.status='Approved' and B.date_of_visit>='$from_date' and B.date_of_visit<='$to_date') C group by C.beat_id) I 
            on (G.beat_id=I.beat_id) 
            left join 
            (select H.beat_id, sum(H.order_qty) as total_order_qty, sum(H.order_amt) as total_order_amt, sum(H.new_order) as total_new_order, 
                sum(H.repeat_order) as total_repeat_order, sum(H.new_order_amt) as total_new_order_amt, sum(H.repeat_order_amt) as total_repeat_order_amt from 
            (select C.beat_id, C.dist_id, G.order_qty, G.order_amt, case when C.min_order_id=G.max_order_id then G.order_qty else 0 end as new_order, 
                case when C.min_order_id=G.max_order_id then 0 else G.order_qty end as repeat_order, 
                case when C.min_order_id=G.max_order_id then G.order_amt else 0 end as new_order_amt, 
                case when C.min_order_id=G.max_order_id then 0 else G.order_amt end as repeat_order_amt from 
            (select A.beat_id, A.dist_id, min(B.id) as min_order_id from beat_details A left join sales_rep_orders B on (A.dist_id=B.distributor_id) group by A.beat_id, A.dist_id) C 
            left join 
            (select F.beat_id, F.dist_id, max(F.order_id) as max_order_id, sum(F.item_qty) as order_qty, sum(F.item_amt) as order_amt from 
            (select A.beat_id, A.dist_id, B.id as order_id, C.type, C.item_id, 
                case when C.type='Bar' then ifnull(C.qty,1) else (ifnull(C.qty,1)*ifnull(D.qty,1)) end as item_qty, 
                case when C.type='Bar' then ifnull(C.qty,1)*ifnull(E.rate,1) else (ifnull(C.qty,1)*ifnull(D.qty,1)*ifnull(E.rate,1)) end as item_amt 
            from beat_details A 
            left join sales_rep_orders B on (A.dist_id=B.distributor_id) 
            left join sales_rep_order_items C on (B.id=C.sales_rep_order_id) 
            left join box_product D on (C.type='Box' and C.item_id=D.box_id) 
            left join product_master E on ((C.type='Bar' and C.item_id=E.id) or (C.type='Box' and D.product_id=E.id))
            where B.date_of_processing>='$from_date' and B.date_of_processing<='$to_date') F group by F.beat_id, F.dist_id) G 
            on(C.beat_id=G.beat_id and C.dist_id=G.dist_id)) H group by H.beat_id) J 
            on (G.beat_id=J.beat_id) 
            where G.beat_id is not null 

            union all 

            select null as id, null as distributor_name, D.zone, null as beat_id, null as beat_name, null as sales_rep_name, 
                count(D.id) as total_stores, null as total_stores_visited, null as total_order_qty, null as total_order_amt, 
                null as total_new_order, null as total_repeat_order, null as total_new_order_amt, null as total_repeat_order_amt from 
            (select distinct A.id, A.distributor_name, B.zone from 
            (select concat('d_', id) as id, distributor_name, zone_id from distributor_master where status = 'Approved' and class in ('normal', 'direct') 
            union all 
            select concat('s_', id) as id, distributor_name, zone_id from sales_rep_distributors where status = 'Approved' or status = 'Active') A 
            left join zone_master B on (A.zone_id=B.id) 
            left join 
            (select distinct A.dist_id from beat_details A 
            left join beat_allocations B on (A.beat_id=B.beat_id1) 
            left join beat_allocations C on (A.beat_id=C.beat_id2) 
            where B.id is not null or C.id is not null) C on (A.id=C.dist_id) 
            where C.dist_id is null) D 
            group by D.zone) BB 

            on (AA.zone=BB.zone) 

            order by AA.zone, BB.distributor_name desc";
    $result = $this->db->query($sql)->result_array();
    if(count($result)>0) {
        // $this->load->library('excel');
        // $objPHPExcel = new PHPExcel();

        $template_path=$this->config->item('template_path');
        $file = $template_path.'Beat_plan_analysis.xlsx';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $objPHPExcel->setActiveSheetIndex(0);
        $col_name[]=array();
        for($i=0; $i<=$cnt+20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A3','Date - '.date('d-m-Y',strtotime($from_date)).' to '.date('d-m-Y',strtotime($to_date)));

        $row = 5;
        $col = 0;
        $start_row = 5;

        $total_stores_dist=0;
        $total_stores_visited_dist=0;
        $total_order_qty_dist=0;
        $total_order_amt_dist=0;
        $total_new_order_dist=0;
        $total_repeat_order_dist=0;
        $total_new_order_amt_dist=0;
        $total_repeat_order_amt_dist=0;

        $total_stores_zone=0;
        $total_stores_visited_zone=0;
        $total_order_qty_zone=0;
        $total_order_amt_zone=0;
        $total_new_order_zone=0;
        $total_repeat_order_zone=0;
        $total_new_order_amt_zone=0;
        $total_repeat_order_amt_zone=0;

        for($i=0; $i<count($result); $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, ucwords(trim($result[$i]['zone'])));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, ucwords(trim($result[$i]['distributor_name'])));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, ucwords(trim($result[$i]['beat_name'])));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, ucwords(trim($result[$i]['sales_rep_name'])));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $result[$i]['total_stores']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $result[$i]['total_stores_visited']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=F'.$row.'/IF(OR(E'.$row.'="",E'.$row.'=0),1,E'.$row.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $result[$i]['total_order_qty']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $result[$i]['total_order_amt']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $result[$i]['total_new_order'].' / '.$result[$i]['total_repeat_order']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $result[$i]['total_new_order_amt'].' / '.$result[$i]['total_repeat_order_amt']);

            $total_stores_dist=$total_stores_dist+intval($result[$i]['total_stores']);
            $total_stores_visited_dist=$total_stores_visited_dist+intval($result[$i]['total_stores_visited']);
            $total_order_qty_dist=$total_order_qty_dist+intval($result[$i]['total_order_qty']);
            $total_order_amt_dist=$total_order_amt_dist+intval($result[$i]['total_order_amt']);
            $total_new_order_dist=$total_new_order_dist+intval($result[$i]['total_new_order']);
            $total_repeat_order_dist=$total_repeat_order_dist+intval($result[$i]['total_repeat_order']);
            $total_new_order_amt_dist=$total_new_order_amt_dist+intval($result[$i]['total_new_order_amt']);
            $total_repeat_order_amt_dist=$total_repeat_order_amt_dist+intval($result[$i]['total_repeat_order_amt']);

            $bl_dist_sub_total = false;
            $bl_zone_sub_total = false;

            if($i==count($result)-1) {
                $bl_dist_sub_total = true;
                $bl_zone_sub_total = true;
            } else if($result[$i]['zone']!=$result[$i+1]['zone']) {
                $bl_dist_sub_total = true;
                $bl_zone_sub_total = true;
            } else if($result[$i]['distributor_name']!=$result[$i+1]['distributor_name']) {
                $bl_dist_sub_total = true;
            }

            if($bl_dist_sub_total==true) {
                $row = $row + 1;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $total_stores_dist);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $total_stores_visited_dist);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=F'.$row.'/IF(OR(E'.$row.'="",E'.$row.'=0),1,E'.$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $total_order_qty_dist);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $total_order_amt_dist);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $total_new_order_dist.' / '.$total_repeat_order_dist);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $total_new_order_amt_dist.' / '.$total_repeat_order_amt_dist);

                $total_stores_zone=$total_stores_zone+$total_stores_dist;
                $total_stores_visited_zone=$total_stores_visited_zone+$total_stores_visited_dist;
                $total_order_qty_zone=$total_order_qty_zone+$total_order_qty_dist;
                $total_order_amt_zone=$total_order_amt_zone+$total_order_amt_dist;
                $total_new_order_zone=$total_new_order_zone+$total_new_order_dist;
                $total_repeat_order_zone=$total_repeat_order_zone+$total_repeat_order_dist;
                $total_new_order_amt_zone=$total_new_order_amt_zone+$total_new_order_amt_dist;
                $total_repeat_order_amt_zone=$total_repeat_order_amt_zone+$total_repeat_order_amt_dist;

                $total_stores_dist=0;
                $total_stores_visited_dist=0;
                $total_order_qty_dist=0;
                $total_order_amt_dist=0;
                $total_new_order_dist=0;
                $total_repeat_order_dist=0;
                $total_new_order_amt_dist=0;
                $total_repeat_order_amt_dist=0;

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':'.$col_name[$col+10].$row)->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => 'DDEBF7'
                    )
                ));
            }

            if($bl_zone_sub_total==true) {
                $row = $row + 2;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $total_stores_zone);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $total_stores_visited_zone);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=F'.$row.'/IF(OR(E'.$row.'="",E'.$row.'=0),1,E'.$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $total_order_qty_zone);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, $total_order_amt_zone);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $total_new_order_zone.' / '.$total_repeat_order_zone);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $total_new_order_amt_zone.' / '.$total_repeat_order_amt_zone);

                $total_stores_zone=0;
                $total_stores_visited_zone=0;
                $total_order_qty_zone=0;
                $total_order_amt_zone=0;
                $total_new_order_zone=0;
                $total_repeat_order_zone=0;
                $total_new_order_amt_zone=0;
                $total_repeat_order_amt_zone=0;

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':'.$col_name[$col+10].$row)->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => '44546A'
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':'.$col_name[$col+10].$row)->getFont()->getColor()->setRGB('FFFFFF');

                $row = $row + 1;
            }

            $row = $row + 1;
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+10].($row-2))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '44546A'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A4:K4')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));

        // for($col1 = 'A'; $col1 <= $col_name[$col]; $col1++) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension($col1)->setAutoSize(true);
        // }

        // $filename='Beat_plan_analysis_report.xls';
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save('php://output');

        $filename = 'Beat_plan_analysis_report_'.$report_date.'.xlsx';

        if($action=="save") {
            // $path  = '/home/eatangcp/public_html/test/assets/uploads/mt_stock_reports/';
            // $upload_path = '/home/eatangcp/public_html/test/assets/uploads/mt_stock_reports';

            // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/beat_plan_analysis/';
            // $upload_path = '/home/eatangcp/public_html/eat_erp/assets/uploads/beat_plan_analysis';

            // $path  = '/var/www/html/eat_erp/assets/uploads/beat_plan_analysis/';
            // $upload_path = '/var/www/html/eat_erp/assets/uploads/beat_plan_analysis';

            // $path  = 'C:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports/';
            // $upload_path = 'C:/wamp64/www/eat_erp/assets/uploads/mt_stock_reports';

            $path = $this->config->item('upload_path').'beat_plan_analysis/';
            $upload_path = $this->config->item('upload_path').'beat_plan_analysis';

            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $reportpath = $path.$filename;

            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment;filename="'.$filename.'"');
            // header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
            $objWriter->save($reportpath);

            echo $reportpath;
            echo '<br/><br/>';

            return $reportpath;
        } else {
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Type: application/openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']='Beat plan analysis report generated.';
            $this->user_access_log_model->insertAccessLog($logarray);

            exit;
        }
    } else {
        // echo '<script>alert("No data found");</script>';
    }
}

public function send_daily_sales_performance_report($report_peroid='') {
    if($report_peroid=='Weekly'){
        $date = date('Y-m-d');
        // $date = '2019-07-16';
        $reportpath = '';

        $from_date = date('Y-m-d', (strtotime('-6 day', strtotime($date))));
        $to_date = date('Y-m-d', (strtotime('-1 day', strtotime($date))));

        echo $from_date;
        echo '<br/><br/>';
        echo $to_date;
        echo '<br/><br/>';

        $reportpath = $this->generate_daily_sales_performance_report($from_date, $to_date, 'save', $report_peroid);
    } else {
        $report_peroid = 'Daily';

        $date = date('Y-m-d');
        // $date = '2019-07-16';
        $reportpath = '';

        echo $date;
        echo '<br/><br/>';

        $reportpath = $this->generate_daily_sales_performance_report($date, $date, 'save', $report_peroid);
    }

    if($reportpath!=''){
        $report_date = date('d-m-Y');
        // $report_date = '16-07-2019';

        $message = '<html>
                    <body>
                        <h3>Wholesome Habits Pvt Ltd</h3>
                        <h4>Sales - '.$report_peroid.' SR Performance Report</h4>
                        <p>Reporting Date - '.$report_date.'</p>
                        <p>PFA</p>
                        <br/><br/>
                        Regards,
                        <br/><br/>
                        CS
                    </body>
                    </html>';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'EAT MIS';
        $subject = 'Sales - '.$report_peroid.' SR Performance Report - '.$report_date;

        $to_email = 'prasad.bhisale@otbconsulting.co.in';
        $cc = 'prasad.bhisale@otbconsulting.co.in';
        $bcc = 'prasad.bhisale@otbconsulting.co.in';

        // $to_email = "ravi.hirode@eatanytime.in, manorama.mishra@eatanytime.in, mahesh.ms@eatanytime.in, yash.doshi@eatanytime.in, darshan.dhany@eatanytime.in, girish.rai@eatanytime.in, nitin.kumar@eatanytime.in, mohil.telawade@eatanytime.in";
        // $cc = "rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in, operations@eatanytime.in";
        // $bcc = "dhaval.maru@otbconsulting.co.in, prasad.bhisale@otbconsulting.co.in";

        $sql = "select * from report_master where report_name = 'Sales Representative Performance Report'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0) {
            $from_email = $result[0]->from_email;
            $from_email_sender = $result[0]->sender_name;
            $to_email = $result[0]->to_email;
            $cc = $result[0]->cc_email;
            $bcc = $result[0]->bcc_email;
        }

        echo $attachment = $reportpath;
        echo '<br/><br/>';
        $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);

        // $mailSent=1;
        
        // echo $message;
        // echo '<br/><br/>';
        echo $mailSent;
        echo '<br/><br/>';

        if($mailSent==1){
            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']=$report_peroid.' Sales Representative Performance report sent.';
            $this->user_access_log_model->insertAccessLog($logarray);
        }
    }
}

function generate_daily_sales_performance_report($f_date='', $t_date='', $action='', $report_peroid='Daily') {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));

    if($from_date==''){
        $from_date=$f_date;
    } else {
        $from_date = formatdate($this->input->post('from_date'));
    }

    if($to_date==''){
        $to_date=$t_date;
    } else {
        $to_date = formatdate($this->input->post('to_date'));
    }

    if($from_date==''){
        $from_date=NULL;
    }
    if($to_date==''){
        $to_date=NULL;
    }

    // $from_date = '2018-04-01';
    // $to_date = '2019-03-31';

    $report_date = date('d-m-Y');
    // $report_date = '16-07-2019';

    $cnt = 0;

    $sql = "select A.id, A.sales_rep_name, A.zone, A.total_sales_rep_cnt, A.present_cnt, 
            sum(A.planned_visit) as tot_planned_visit, sum(A.actual_visit) as tot_actual_visit, 
            sum(A.unplanned_visit) as tot_unplanned_visit, sum(A.total_visit) as total_visit, 
            sum(A.order_cnt) as total_order_cnt, 
            sum(A.total_order_qty) as total_order_units, sum(A.total_order_amt) as total_order_amt, 
            sum(A.total_new_order) as total_new_order_units, sum(A.total_repeat_order) as total_repeat_order_units, 
            sum(A.total_new_order_amt) as total_new_order_amt, sum(A.total_repeat_order_amt) as total_repeat_order_amt from 
            
            (select ZZ.id, ZZ.sales_rep_name, ZZ.zone, AA.date_of_visit, AA.store_id, AA.total_cnt, BB.id as visit_id, CC.total_order_qty, CC.total_order_amt, CC.total_new_order, 
                CC.total_repeat_order, CC.total_new_order_amt, CC.total_repeat_order_amt, 
                case when AA.total_cnt=2 then 0 else 1 end as planned_visit, case when AA.total_cnt!=2 and BB.id is not null then 1 else 0 end as actual_visit, 
                case when AA.total_cnt=2 and BB.id is not null then 1 else 0 end as unplanned_visit, case when BB.id is not null then 1 else 0 end as total_visit, 
                case when CC.visit_id is not null then 1 else 0 end as order_cnt, DD.total_sales_rep_cnt, DD.present_cnt from 

            (select id, sales_rep_name, zone from sales_rep_master where status = 'Approved' and sr_type='Sales Representative') ZZ 

            left join 

            (select F.id, F.sales_rep_name, F.zone, F.date_of_visit, F.store_id, sum(cnt) as total_cnt from 

            (select distinct C.id, C.sales_rep_name, C.zone, C.date_of_visit, C.frequency, case when C.beat_id=0 then D.store_id else E.dist_id end as store_id, 1 as cnt from 

            (select A.id, A.sales_rep_name, A.zone, A.date_of_visit, A.frequency, ifnull(case when A.frequency like 'Every%' then B.beat_id1 else B.beat_id2 end,0) as beat_id from 
            (select A.id, A.sales_rep_name, A.zone, B.date_of_visit, B.frequency from 
            (select id, sales_rep_name, zone, '1' as tempcol from sales_rep_master where status = 'Approved' and sr_type='Sales Representative') A 
            left join 
            (select selected_date as date_of_visit, frequency, '1' as tempcol from 
            (select selected_date, case when ((floor((DayOfMonth(date(selected_date))-1)/7)+1 )=1 OR (floor((DayOfMonth(date(selected_date))-1)/7)+1 )=3 or (floor((DayOfMonth(date(selected_date))-1)/7)+1 )=5) then concat('Every ',DAYNAME(date(selected_date))) when ((floor((DayOfMonth(date(selected_date))-1)/7)+1 )=2 OR (floor((DayOfMonth(date(selected_date))-1)/7)+1 )=4)
            then  concat('Alternate ',DAYNAME(date(selected_date))) end as frequency from 
            (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
            where selected_date between '$from_date' and '$to_date') A 
            where A.frequency not like '%sunday%') B 
            on (A.tempcol=B.tempcol)) A 

            left join 

            (select * from beat_changes where status='Approved' and date_of_visit between '$from_date' and '$to_date') B 
            on (A.id=B.sales_rep_id and A.date_of_visit=B.date_of_visit)) C 

            left join 

            (select sales_rep_id, frequency, 0 as beat_id, store_id from sales_rep_beat_plan where status = 'Approved') D 
            on (C.id=D.sales_rep_id and C.frequency COLLATE utf8_bin =D.frequency and C.beat_id=D.beat_id) 

            left join 

            (select * from beat_details) E 
            on (C.beat_id=E.beat_id) 

            union all 

            select distinct A.sales_rep_id as id, B.sales_rep_name, B.zone, A.date_of_visit, '' as frequency, distributor_id as store_id, 2 as cnt 
            from sales_rep_location A left join sales_rep_master B on (A.sales_rep_id=B.id) 
            where A.status='Approved' and A.date_of_visit between '$from_date' and '$to_date') F 

            group by F.id, F.sales_rep_name, F.zone, F.date_of_visit, F.store_id) AA 
            on (ZZ.id=AA.id) 

            left join 

            (select distinct id, sales_rep_id, date_of_visit, distributor_id from sales_rep_location where status='Approved' and date_of_visit between '$from_date' and '$to_date') BB 
            on (AA.id=BB.sales_rep_id and AA.date_of_visit=BB.date_of_visit and AA.store_id=BB.distributor_id) 

            left join 

            (select H.visit_id, sum(H.order_qty) as total_order_qty, sum(H.order_amt) as total_order_amt, sum(H.new_order) as total_new_order, 
                sum(H.repeat_order) as total_repeat_order, sum(H.new_order_amt) as total_new_order_amt, sum(H.repeat_order_amt) as total_repeat_order_amt from 
            (select G.visit_id, C.distributor_id, G.order_qty, G.order_amt, 
                case when C.min_order_id=G.order_id then G.order_qty else 0 end as new_order, 
                case when C.min_order_id=G.order_id then 0 else G.order_qty end as repeat_order, 
                case when C.min_order_id=G.order_id then G.order_amt else 0 end as new_order_amt, 
                case when C.min_order_id=G.order_id then 0 else G.order_amt end as repeat_order_amt from 
            (select A.distributor_id, min(A.id) as min_order_id from sales_rep_orders A group by A.distributor_id) C 
            left join 
            (select F.visit_id, F.distributor_id, F.order_id, sum(F.item_qty) as order_qty, sum(F.item_amt) as order_amt from 
            (select B.visit_id, B.distributor_id, B.id as order_id, C.type, C.item_id, 
                case when C.type='Bar' then ifnull(C.qty,1) else (ifnull(C.qty,1)*ifnull(D.qty,1)) end as item_qty, 
                case when C.type='Bar' then ifnull(C.qty,1)*ifnull(E.rate,1) else (ifnull(C.qty,1)*ifnull(D.qty,1)*ifnull(E.rate,1)) end as item_amt 
            from sales_rep_orders B 
            left join sales_rep_order_items C on (B.id=C.sales_rep_order_id) 
            left join box_product D on (C.type='Box' and C.item_id=D.box_id) 
            left join product_master E on ((C.type='Bar' and C.item_id=E.id) or (C.type='Box' and D.product_id=E.id))
            where B.date_of_processing between '$from_date' and '$to_date') F group by F.visit_id, F.distributor_id, F.order_id) G 
            on (C.distributor_id=G.distributor_id)) H group by H.visit_id) CC 
            on (BB.id=CC.visit_id) 

            left join 

            (select C.zone, C.total_sales_rep_cnt, round(avg(C.present_cnt)) as present_cnt from 
            (select A.zone, A.total_sales_rep_cnt, B.check_in_date, sum(case when B.sales_rep_id is not null then 1 else 0 end) as present_cnt from 
            (select A.zone, count(A.id) as total_sales_rep_cnt from sales_rep_master A where A.status = 'Approved' and A.sr_type='Sales Representative' group by A.zone) A 
            left join 
            (select distinct A.zone, date(B.check_in_time) as check_in_date, B.sales_rep_id from sales_rep_master A left join sales_attendence B on (A.id=B.sales_rep_id) where A.status = 'Approved' and A.sr_type='Sales Representative' and B.working_status='Present' and date(B.check_in_time)>='$from_date' and date(B.check_in_time)<='$to_date') B 
            on (A.zone=B.zone) 
            group by A.zone, A.total_sales_rep_cnt, B.check_in_date) C 
            group by C.zone, C.total_sales_rep_cnt) DD
            on (AA.zone=DD.zone)

            ) A 
            group by A.id, A.sales_rep_name, A.zone, A.total_sales_rep_cnt, A.present_cnt 
            order by A.zone, A.sales_rep_name";
    $result = $this->db->query($sql)->result_array();

    // echo $sql;
    // echo '<br/><br/>';
    // echo json_encode($result);

    if(count($result)>0) {
        // $this->load->library('excel');
        // $objPHPExcel = new PHPExcel();

        $template_path=$this->config->item('template_path');
        $file = $template_path.'Daily_sales_performance_report.xlsx';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $objPHPExcel->setActiveSheetIndex(0);
        $col_name[]=array();
        for($i=0; $i<=$cnt+20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A2','Sales - '.$report_peroid.' Sales Performance Report');
        $objPHPExcel->getActiveSheet()->setCellValue('A3','Date - '.date('d-m-Y',strtotime($from_date)).' to '.date('d-m-Y',strtotime($to_date)));

        $row = 6;
        $col = 0;
        $row2 = 10;
        $start_row = 11;

        $tot_planned_visit = 0;
        $tot_actual_visit = 0;
        $tot_unplanned_visit = 0;
        $tot_visit = 0;
        $tot_order_cnt = 0;
        $tot_order_units = 0;
        $tot_order_amt = 0;
        $tot_new_order_units = 0;
        $tot_repeat_order_units = 0;
        $tot_new_order_amt = 0;
        $tot_repeat_order_amt = 0;

        $all_tot_order_units = 0;
        $all_tot_order_amt = 0;
        $all_tot_new_order_units = 0;
        $all_tot_repeat_order_units = 0;
        $all_tot_new_order_amt = 0;
        $all_tot_repeat_order_amt = 0;

        for($i=0; $i<count($result); $i++) {
            $tot_planned_visit = $tot_planned_visit + intval($result[$i]['tot_planned_visit']);
            $tot_actual_visit = $tot_actual_visit + intval($result[$i]['tot_actual_visit']);
            $tot_unplanned_visit = $tot_unplanned_visit + intval($result[$i]['tot_unplanned_visit']);
            $tot_visit = $tot_visit + intval($result[$i]['total_visit']);
            $tot_order_cnt = $tot_order_cnt + intval($result[$i]['total_order_cnt']);
            $tot_order_units = $tot_order_units + intval($result[$i]['total_order_units']);
            $tot_order_amt = $tot_order_amt + intval($result[$i]['total_order_amt']);
            $tot_new_order_units = $tot_new_order_units + intval($result[$i]['total_new_order_units']);
            $tot_repeat_order_units = $tot_repeat_order_units + intval($result[$i]['total_repeat_order_units']);
            $tot_new_order_amt = $tot_new_order_amt + intval($result[$i]['total_new_order_amt']);
            $tot_repeat_order_amt = $tot_repeat_order_amt + intval($result[$i]['total_repeat_order_amt']);
            if($tot_order_units==0){
                $tot_new_order_per = 0;
                $tot_repeat_order_per = 0;
            } else {
                $tot_new_order_per = round(($tot_new_order_units/$tot_order_units)*100,0);
                $tot_repeat_order_per = round(($tot_repeat_order_units/$tot_order_units)*100,0);
            }
            
            $total_order_units = $result[$i]['total_order_units'];
            $total_new_order_units = $result[$i]['total_new_order_units'];
            $total_repeat_order_units = $result[$i]['total_repeat_order_units'];
            if($total_order_units==0){
                $total_new_order_per = 0;
                $total_repeat_order_per = 0;
            } else {
                $total_new_order_per = round(($total_new_order_units/$total_order_units)*100,0);
                $total_repeat_order_per = round(($total_repeat_order_units/$total_order_units)*100,0);
            }

            if($i==0) {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, ucwords(trim($result[$i]['zone'])));
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getFont()->setBold(true);
                $row2 = $row2 + 2;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, ucwords(trim($result[$i]['sales_rep_name'])));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row2, $result[$i]['tot_planned_visit']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row2, $result[$i]['tot_actual_visit']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row2, $result[$i]['tot_unplanned_visit']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row2, $result[$i]['total_visit']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row2, '=if(C'.$row2.'=0,0,(C'.$row2.'-D'.$row2.')/C'.$row2.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row2, intval($result[$i]['total_order_cnt']));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row2, '=if(F'.$row2.'=0,0,H'.$row2.'/F'.$row2.')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row2, intval($result[$i]['total_order_units']));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row2, intval($result[$i]['total_order_amt']));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row2, intval($result[$i]['total_new_order_units']).'/'.intval($result[$i]['total_repeat_order_units']));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row2, intval($result[$i]['total_new_order_amt']).'/'.intval($result[$i]['total_repeat_order_amt']));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row2, $total_new_order_per.'%/'.$total_repeat_order_per.'%');
            $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].$row2.':'.$col_name[$col+1].$row2);
            // $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $row2 = $row2 + 1;
            

            if($i!=0 && $i!=count($result)-1) {
                if($result[$i]['zone']!=$result[$i+1]['zone']) {
                    if($row!=6) {
                        $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
                        $row2 = $row2 + 1;
                    }
                }
            }

            $bl_flag = false;
            if($i==count($result)-1){
                $bl_flag = true;
            } else if($result[$i]['zone']!=$result[$i+1]['zone']) {
                $bl_flag = true;
            }

            if($bl_flag == true) {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, ucwords(trim($result[$i]['zone'])));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $result[$i]['present_cnt'].'/'.$result[$i]['total_sales_rep_cnt']);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $tot_planned_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $tot_actual_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $tot_unplanned_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $tot_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=if(C'.$row.'=0,0,(C'.$row.'-D'.$row.')/C'.$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row, $tot_order_cnt);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row, '=if(F'.$row.'=0,0,H'.$row.'/F'.$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row, $tot_order_units);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row, $tot_order_amt);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $tot_new_order_units.'/'.$tot_repeat_order_units);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $tot_new_order_amt.'/'.$tot_repeat_order_amt);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $tot_new_order_per.'%/'.$tot_repeat_order_per.'%');

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, 'Total');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row2, $tot_planned_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row2, $tot_actual_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row2, $tot_unplanned_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row2, $tot_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row2, '=if(C'.$row2.'=0,0,(C'.$row2.'-D'.$row2.')/C'.$row.')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row2, $tot_order_cnt);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row2, '=if(F'.$row2.'=0,0,H'.$row2.'/F'.$row2.')');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row2, $tot_order_units);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row2, $tot_order_amt);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row2, $tot_new_order_units.'/'.$tot_repeat_order_units);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row2, $tot_new_order_amt.'/'.$tot_repeat_order_amt);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row2, $tot_new_order_per.'%/'.$tot_repeat_order_per.'%');

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+13].($row2))->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => 'DDEBF7')
                    )
                );
                $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].$row2.':'.$col_name[$col+1].$row2);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+13].($row2))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($start_row+1).':'.$col_name[$col+13].($row2))->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+13].($row2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);

                if($i!=count($result)-1) {
                    $row2 = $row2 + 2;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $result[$i+1]['zone']);
                    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2.':'.$col_name[$col+1].$row2)
                                                    ->applyFromArray(array(
                                                        'borders' => array(
                                                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THICK),
                                                            'right' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
                                                        )
                                                    ));
                    $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].$row2.':'.$col_name[$col+1].$row2);

                    $row2 = $row2 + 1;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, 'Name');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row2, 'Planned Vists');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row2, 'Acutal Vists');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row2, 'Unplanned Visits');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row2, 'Total Calls');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row2, 'Deviation %');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+7].$row2, 'Productive Calls');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+8].$row2, '% Productivity');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+9].$row2, 'Order Units');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+10].$row2, 'Order Value');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row2, 'New/Repeat');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row2, 'New/Repeat V');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row2, '%');

                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+13].($row2))->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+13].($row2))->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'DDEBF7'
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+13].($row2))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+13].($row2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+13].($row2))->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($row2)->setRowHeight(28.8);

                    $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].$row2.':'.$col_name[$col+1].$row2);

                    $start_row = $row2;
                    $row2 = $row2 + 1;
                }

                $all_tot_order_units = $all_tot_order_units + $tot_order_units;
                $all_tot_order_amt = $all_tot_order_amt + $tot_order_amt;
                $all_tot_new_order_units = $all_tot_new_order_units + $tot_new_order_units;
                $all_tot_repeat_order_units = $all_tot_repeat_order_units + $tot_repeat_order_units;
                $all_tot_new_order_amt = $all_tot_new_order_amt + $tot_new_order_amt;
                $all_tot_repeat_order_amt = $all_tot_repeat_order_amt + $tot_repeat_order_amt;

                $tot_planned_visit = 0;
                $tot_actual_visit = 0;
                $tot_unplanned_visit = 0;
                $tot_visit = 0;
                $tot_order_cnt = 0;
                $tot_order_units = 0;
                $tot_order_amt = 0;
                $tot_new_order_units = 0;
                $tot_repeat_order_units = 0;
                $tot_new_order_amt = 0;
                $tot_repeat_order_amt = 0;

                $row = $row + 1;
            }
        }

        if($all_tot_order_units==0){
            $all_tot_new_order_per = 0;
            $all_tot_repeat_order_per = 0;
        } else {
            $all_tot_new_order_per = round(($all_tot_new_order_units/$all_tot_order_units)*100,0);
            $all_tot_repeat_order_per = round(($all_tot_repeat_order_units/$all_tot_order_units)*100,0);
        }

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+11].$row, $all_tot_new_order_units.'/'.$all_tot_repeat_order_units);
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+12].$row, $all_tot_new_order_amt.'/'.$all_tot_repeat_order_amt);
        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+13].$row, $all_tot_new_order_per.'%/'.$all_tot_repeat_order_per.'%');

        // $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+10].($row-2))->applyFromArray(array(
        //     'borders' => array(
        //         'allborders' => array(
        //             'style' => PHPExcel_Style_Border::BORDER_THIN
        //         )
        //     )
        // ));

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '44546A'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A5:N5')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':N'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.($row+3).':N'.($row+3))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));

        // for($col1 = 'A'; $col1 <= $col_name[$col]; $col1++) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension($col1)->setAutoSize(true);
        // }

        // $filename='Daily_sales_performance_report.xls';
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save('php://output');

        // $logarray['table_id']=$this->session->userdata('session_id');
        // $logarray['module_name']='Reports';
        // $logarray['cnt_name']='Reports';
        // $logarray['action']='Beat plan analysis report generated.';
        // $this->user_access_log_model->insertAccessLog($logarray);

        $filename = $report_peroid.'_sales_performance_report_'.$report_date.'.xlsx';

        if($action=="save") {
            // $path  = '/home/eatangcp/public_html/test/assets/uploads/daily_sales_performance/';
            // $upload_path = '/home/eatangcp/public_html/test/assets/uploads/daily_sales_performance';

            // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/daily_sales_performance/';
            // $upload_path = '/home/eatangcp/public_html/eat_erp/assets/uploads/daily_sales_performance';

            // $path  = '/var/www/html/eat_erp/assets/uploads/daily_sales_performance/';
            // $upload_path = '/var/www/html/eat_erp/assets/uploads/daily_sales_performance';

            // $path  = 'C:/wamp64/www/eat_erp/assets/uploads/daily_sales_performance/';
            // $upload_path = 'C:/wamp64/www/eat_erp/assets/uploads/daily_sales_performance';

            // $path  = 'E:/wamp64/www/eat_erp/assets/uploads/daily_sales_performance/';
            // $upload_path = 'E:/wamp64/www/eat_erp/assets/uploads/daily_sales_performance';

            $path = $this->config->item('upload_path').'daily_sales_performance/';
            $upload_path = $this->config->item('upload_path').'daily_sales_performance';

            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $reportpath = $path.$filename;

            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment;filename="'.$filename.'"');
            // header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
            $objWriter->save($reportpath);

            echo $reportpath;
            echo '<br/><br/>';

            return $reportpath;
        } else {
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Type: application/openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']=$report_peroid.' Sales Performance Report Generated.';
            $this->user_access_log_model->insertAccessLog($logarray);

            exit;
        }
    } else {
        // echo '<script>alert("No data found");</script>';
    }
}

public function send_daily_merchandiser_performance_report($report_peroid='') {
    if($report_peroid=='Weekly'){
        $date = date('Y-m-d');
        // $date = '2019-07-16';
        $reportpath = '';

        $from_date = date('Y-m-d', (strtotime('-6 day', strtotime($date))));
        $to_date = date('Y-m-d', (strtotime('-1 day', strtotime($date))));

        echo $from_date;
        echo '<br/><br/>';
        echo $to_date;
        echo '<br/><br/>';

        $reportpath = $this->generate_daily_merchandiser_performance_report($from_date, $to_date, 'save', $report_peroid);
    } else {
        $report_peroid = 'Daily';

        $date = date('Y-m-d');
        // $date = '2019-07-16';
        $reportpath = '';

        echo $date;
        echo '<br/><br/>';

        $reportpath = $this->generate_daily_merchandiser_performance_report($date, $date, 'save', $report_peroid);
    }

    if($reportpath!=''){
        $report_date = date('d-m-Y');
        // $report_date = '16-07-2019';

        $message = '<html>
                    <body>
                        <h3>Wholesome Habits Pvt Ltd</h3>
                        <h4>Sales - '.$report_peroid.' Merchandiser Performance Report</h4>
                        <p>Reporting Date - '.$report_date.'</p>
                        <p>PFA</p>
                        <br/><br/>
                        Regards,
                        <br/><br/>
                        CS
                    </body>
                    </html>';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'EAT MIS';
        $subject = 'Sales - '.$report_peroid.' Merchandiser Performance Report - '.$report_date;

        $to_email = 'prasad.bhisale@otbconsulting.co.in';
        $cc = 'prasad.bhisale@otbconsulting.co.in';
        $bcc = 'prasad.bhisale@otbconsulting.co.in';

        // $to_email = "mukesh.yadav@eatanytime.in, sulochana.waghmare@eatanytime.in, sachin.pal@eatanytime.in, urvi.bhayani@eatanytime.in";
        // $cc = "rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in, operations@eatanytime.in";
        // $bcc = "dhaval.maru@otbconsulting.co.in, prasad.bhisale@otbconsulting.co.in";

        $sql = "select * from report_master where report_name = 'Merchandiser Performance Report'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0) {
            $from_email = $result[0]->from_email;
            $from_email_sender = $result[0]->sender_name;
            $to_email = $result[0]->to_email;
            $cc = $result[0]->cc_email;
            $bcc = $result[0]->bcc_email;
        }

        echo $attachment = $reportpath;
        echo '<br/><br/>';
        $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc, $cc, $attachment);

        // $mailSent=1;
        
        // echo $message;
        // echo '<br/><br/>';
        echo $mailSent;
        echo '<br/><br/>';

        if($mailSent==1){
            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']=$report_peroid.' Merchandiser Performance report sent.';
            $this->user_access_log_model->insertAccessLog($logarray);
        }
    }
}

function generate_daily_merchandiser_performance_report($f_date='', $t_date='', $action='', $report_peroid='Daily') {
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));

    if($from_date==''){
        $from_date = $f_date;
    } else {
        $from_date = formatdate($this->input->post('from_date'));
    }

    if($to_date==''){
        $to_date = $t_date;
    } else {
        $to_date = formatdate($this->input->post('to_date'));
    }

    if($from_date==''){
        $from_date=NULL;
    }
    if($to_date==''){
        $to_date=NULL;
    }

    // $from_date = '2018-04-01';
    // $to_date = '2019-03-31';

    $report_date = date('d-m-Y');
    // $report_date = '16-07-2019';

    $cnt = 0;

    $sql = "select A.id, A.sales_rep_name, A.zone, A.total_sales_rep_cnt, A.present_cnt, 
            sum(A.planned_visit) as tot_planned_visit, sum(A.actual_visit) as tot_actual_visit, 
            sum(A.unplanned_visit) as tot_unplanned_visit, sum(A.total_visit) as total_visit from 

            (select AA.id, AA.sales_rep_name, AA.zone, BB.date_of_visit, BB.store_id, BB.total_cnt, CC.id as visit_id, DD.total_sales_rep_cnt, DD.present_cnt, 
                case when BB.total_cnt=2 then 0 else 1 end as planned_visit, case when BB.total_cnt!=2 and CC.id is not null then 1 else 0 end as actual_visit, 
                case when BB.total_cnt=2 and CC.id is not null then 1 else 0 end as unplanned_visit, case when CC.id is not null then 1 else 0 end as total_visit from 

            (select id, sales_rep_name, zone from sales_rep_master where status = 'Approved' and sr_type='Merchandizer') AA 

            left join 

            (select F.id, F.sales_rep_name, F.zone, F.date_of_visit, F.store_id, sum(cnt) as total_cnt from 

            (select distinct C.id, C.sales_rep_name, C.zone, C.date_of_visit, C.frequency, case when C.beat_id=0 then D.store_id else E.dist_id end as store_id, 1 as cnt from 

            (select A.id, A.sales_rep_name, A.zone, A.date_of_visit, A.frequency, ifnull(case when A.frequency like 'Every%' then B.beat_id1 else B.beat_id2 end,0) as beat_id from 
            (select A.id, A.sales_rep_name, A.zone, B.date_of_visit, B.frequency from 
            (select id, sales_rep_name, zone, '1' as tempcol from sales_rep_master where status = 'Approved' and sr_type='Merchandizer') A 
            left join 
            (select selected_date as date_of_visit, frequency, '1' as tempcol from 
            (select selected_date, case when ((floor((DayOfMonth(date(selected_date))-1)/7)+1 )=1 OR (floor((DayOfMonth(date(selected_date))-1)/7)+1 )=3 or (floor((DayOfMonth(date(selected_date))-1)/7)+1 )=5) then concat('Every ',DAYNAME(date(selected_date))) when ((floor((DayOfMonth(date(selected_date))-1)/7)+1 )=2 OR (floor((DayOfMonth(date(selected_date))-1)/7)+1 )=4)
            then  concat('Alternate ',DAYNAME(date(selected_date))) end as frequency from 
            (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
            (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
            where selected_date between '$from_date' and '$to_date') A 
            where A.frequency not like '%sunday%') B 
            on (A.tempcol=B.tempcol)) A 

            left join 

            (select * from beat_changes where status='Approved' and date_of_visit between '$from_date' and '$to_date') B 
            on (A.id=B.sales_rep_id and A.date_of_visit=B.date_of_visit)) C 

            left join 

            (select sales_rep_id, frequency, 0 as beat_id, store_id from merchandiser_beat_plan where status = 'Approved') D 
            on (C.id=D.sales_rep_id and C.frequency COLLATE utf8_bin =D.frequency and C.beat_id=D.beat_id) 

            left join 

            (select * from beat_details) E 
            on (C.beat_id=E.beat_id) 

            union all 

            select distinct A.m_id as id, B.sales_rep_name, B.zone, date(A.date_of_visit) as date_of_visit, '' as frequency, dist_id as store_id, 2 as cnt 
            from merchandiser_stock A left join sales_rep_master B on (A.m_id=B.id) 
            where date(A.date_of_visit) between '$from_date' and '$to_date') F 

            group by F.id, F.sales_rep_name, F.zone, F.date_of_visit, F.store_id) BB 
            on (AA.id=BB.id) 

            left join 

            (select distinct id, m_id as sales_rep_id, date(date_of_visit) as date_of_visit, dist_id as distributor_id 
            from merchandiser_stock where date(date_of_visit) between '$from_date' and '$to_date') CC 
            on (BB.id=CC.sales_rep_id and BB.date_of_visit=CC.date_of_visit and BB.store_id=CC.distributor_id) 

            left join 

            (select C.zone, C.total_sales_rep_cnt, round(avg(C.present_cnt)) as present_cnt from 
            (select A.zone, A.total_sales_rep_cnt, B.check_in_date, sum(case when B.sales_rep_id is not null then 1 else 0 end) as present_cnt from 
            (select A.zone, count(A.id) as total_sales_rep_cnt from sales_rep_master A where A.status = 'Approved' and A.sr_type='Merchandizer' group by A.zone) A 
            left join 
            (select distinct A.zone, date(B.check_in_time) as check_in_date, B.sales_rep_id from sales_rep_master A left join sales_attendence B on (A.id=B.sales_rep_id) where A.status = 'Approved' and A.sr_type='Merchandizer' and B.working_status='Present' and date(B.check_in_time)>='$from_date' and date(B.check_in_time)<='$to_date') B 
            on (A.zone=B.zone) 
            group by A.zone, A.total_sales_rep_cnt, B.check_in_date) C 
            group by C.zone, C.total_sales_rep_cnt) DD
            on (BB.zone=DD.zone)

            ) A 
            group by A.id, A.sales_rep_name, A.zone, A.total_sales_rep_cnt, A.present_cnt 
            order by A.zone, A.sales_rep_name";
    $result = $this->db->query($sql)->result_array();

    // echo $sql;
    // echo '<br/><br/>';
    // echo json_encode($result);

    if(count($result)>0) {
        // $this->load->library('excel');
        // $objPHPExcel = new PHPExcel();

        $template_path=$this->config->item('template_path');
        $file = $template_path.'Daily_merchandiser_performance_report.xlsx';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        $objPHPExcel->setActiveSheetIndex(0);
        $col_name[]=array();
        for($i=0; $i<=$cnt+20; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A2','Sales - '.$report_peroid.' Merchandiser Performance Report');
        $objPHPExcel->getActiveSheet()->setCellValue('A3','Date - '.date('d-m-Y',strtotime($from_date)).' to '.date('d-m-Y',strtotime($to_date)));

        $row = 6;
        $col = 0;
        $row2 = 10;
        $start_row = 11;

        $tot_planned_visit = 0;
        $tot_actual_visit = 0;
        $tot_unplanned_visit = 0;
        $tot_visit = 0;

        for($i=0; $i<count($result); $i++) {
            $tot_planned_visit = $tot_planned_visit + intval($result[$i]['tot_planned_visit']);
            $tot_actual_visit = $tot_actual_visit + intval($result[$i]['tot_actual_visit']);
            $tot_unplanned_visit = $tot_unplanned_visit + intval($result[$i]['tot_unplanned_visit']);
            $tot_visit = $tot_visit + intval($result[$i]['total_visit']);
            
            if($i==0) {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, $result[$i]['zone']);
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getFont()->setBold(true);
                $row2 = $row2 + 2;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, ucwords(trim($result[$i]['sales_rep_name'])));
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row2, $result[$i]['tot_planned_visit']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row2, $result[$i]['tot_actual_visit']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row2, $result[$i]['tot_unplanned_visit']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row2, $result[$i]['total_visit']);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row2, '=if(C'.$row2.'=0,0,(C'.$row2.'-D'.$row2.')/C'.$row2.')');
            $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].$row2.':'.$col_name[$col+1].$row2);
            // $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $row2 = $row2 + 1;
            

            if($i!=0 && $i!=count($result)-1) {
                if($result[$i]['zone']!=$result[$i+1]['zone']) {
                    if($row!=6) {
                        $objPHPExcel->getActiveSheet()->insertNewRowBefore($row, 1);
                        $row2 = $row2 + 1;
                    }
                }
            }

            $bl_flag = false;
            if($i==count($result)-1){
                $bl_flag = true;
            } else if($result[$i]['zone']!=$result[$i+1]['zone']) {
                $bl_flag = true;
            }

            if($bl_flag == true) {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row, ucwords(trim($result[$i]['zone'])));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].$row, $result[$i]['present_cnt'].'/'.$result[$i]['total_sales_rep_cnt']);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row, $tot_planned_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row, $tot_actual_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row, $tot_unplanned_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row, $tot_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row, '=if(C'.$row.'=0,0,(C'.$row.'-D'.$row.')/C'.$row.')');

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, 'Total');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row2, $tot_planned_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row2, $tot_actual_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row2, $tot_unplanned_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row2, $tot_visit);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row2, '=if(C'.$row2.'=0,0,(C'.$row2.'-D'.$row.')/C'.$row2.')');

                $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+6].($row2))->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array('rgb' => 'DDEBF7')
                    )
                );
                $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].$row2.':'.$col_name[$col+1].$row2);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+6].($row2))->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('A'.($start_row+1).':'.$col_name[$col+6].($row2))->applyFromArray(array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
                // $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+6].($row2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);

                if($i!=count($result)-1) {
                    $row2 = $row2 + 2;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, ucwords(trim($result[$i+1]['zone'])));
                    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].$row2.':'.$col_name[$col+1].$row2)
                                                    ->applyFromArray(array(
                                                        'borders' => array(
                                                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THICK),
                                                            'right' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
                                                        )
                                                    ));
                    $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].$row2.':'.$col_name[$col+1].$row2);

                    $row2 = $row2 + 1;
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].$row2, 'Name');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+2].$row2, 'Planned Vists');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+3].$row2, 'Acutal Vists');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+4].$row2, 'Unplanned Visits');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+5].$row2, 'Total Calls');
                    $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+6].$row2, 'Deviation %');

                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+6].($row2))->applyFromArray(array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+6].($row2))->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'DDEBF7'
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+6].($row2))->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+6].($row2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row2.':'.$col_name[$col+6].($row2))->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getRowDimension($row2)->setRowHeight(28.8);

                    $objPHPExcel->getActiveSheet()->mergeCells($col_name[$col].$row2.':'.$col_name[$col+1].$row2);

                    $start_row = $row2;
                    $row2 = $row2 + 1;
                }

                $tot_planned_visit = 0;
                $tot_actual_visit = 0;
                $tot_unplanned_visit = 0;
                $tot_visit = 0;
                $tot_order_cnt = 0;
                $tot_order_units = 0;
                $tot_order_amt = 0;
                $tot_new_order_units = 0;
                $tot_repeat_order_units = 0;
                $tot_new_order_amt = 0;
                $tot_repeat_order_amt = 0;

                $row = $row + 1;
            }
        }

        // $objPHPExcel->getActiveSheet()->getStyle('A1:'.$col_name[$col+10].($row-2))->applyFromArray(array(
        //     'borders' => array(
        //         'allborders' => array(
        //             'style' => PHPExcel_Style_Border::BORDER_THIN
        //         )
        //     )
        // ));

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '44546A'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.($row+3).':G'.($row+3))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'DDEBF7'
            )
        ));

        // for($col1 = 'A'; $col1 <= $col_name[$col]; $col1++) {
        //     $objPHPExcel->getActiveSheet()->getColumnDimension($col1)->setAutoSize(true);
        // }

        // $filename='Daily_merchandiser_performance_report.xls';
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // $objWriter->save('php://output');

        // $logarray['table_id']=$this->session->userdata('session_id');
        // $logarray['module_name']='Reports';
        // $logarray['cnt_name']='Reports';
        // $logarray['action']='Beat plan analysis report generated.';
        // $this->user_access_log_model->insertAccessLog($logarray);

        $filename = $report_peroid.'_merchandiser_performance_report_'.$report_date.'.xlsx';

        if($action=="save") {
            // $path  = '/home/eatangcp/public_html/test/assets/uploads/daily_merchandiser_performance/';
            // $upload_path = '/home/eatangcp/public_html/test/assets/uploads/daily_merchandiser_performance';

            // $path  = '/home/eatangcp/public_html/eat_erp/assets/uploads/daily_merchandiser_performance/';
            // $upload_path = '/home/eatangcp/public_html/eat_erp/assets/uploads/daily_merchandiser_performance';

            // $path  = '/var/www/html/eat_erp/assets/uploads/daily_merchandiser_performance/';
            // $upload_path = '/var/www/html/eat_erp/assets/uploads/daily_merchandiser_performance';

            // $path  = 'C:/wamp64/www/eat_erp/assets/uploads/daily_merchandiser_performance/';
            // $upload_path = 'C:/wamp64/www/eat_erp/assets/uploads/daily_merchandiser_performance';

            // $path  = 'E:/wamp64/www/eat_erp/assets/uploads/daily_merchandiser_performance/';
            // $upload_path = 'E:/wamp64/www/eat_erp/assets/uploads/daily_merchandiser_performance';

            $path = $this->config->item('upload_path').'daily_merchandiser_performance/';
            $upload_path = $this->config->item('upload_path').'daily_merchandiser_performance';

            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $reportpath = $path.$filename;

            // header('Content-Type: application/vnd.ms-excel');
            // header('Content-Disposition: attachment;filename="'.$filename.'"');
            // header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
            $objWriter->save($reportpath);

            echo $reportpath;
            echo '<br/><br/>';

            return $reportpath;
        } else {
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Type: application/openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

            $logarray['table_id']=$this->session->userdata('session_id');
            $logarray['module_name']='Reports';
            $logarray['cnt_name']='Reports';
            $logarray['action']=$report_peroid.' Merchandiser Performance Report Generated.';
            $this->user_access_log_model->insertAccessLog($logarray);

            exit;
        }
    } else {
        // echo '<script>alert("No data found");</script>';
    }
}

}
?>