<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * File Name: group_list.php
 */

    function load_view($view, $data) {
    	$CI =& get_instance();
        
        $user_data['Masters'] = 0;
        $user_data['Transactions'] = 0;
        $user_data['Transfer'] = 0;
        $user_data['Settings'] = 0;

        $user_data['Vendors'] = 0;
        $user_data['Depot'] = 0;
        $user_data['Raw_Material'] = 0;
        $user_data['Tax'] = 0;
        $user_data['Product'] = 0;
        $user_data['Box'] = 0;
        $user_data['Sales_Rep'] = 0;
        $user_data['Distributor'] = 0;
        $user_data['City_Master'] = 0;
        $user_data['Bank_Master'] = 0;
        $user_data['Area'] = 0;
        $user_data['Distributor_Type'] = 0;
        $user_data['Zone'] = 0;
        $user_data['Location'] = 0;
        $user_data['Sr_Mapping'] = 0;
        $user_data['Ingredient_Master'] = 0;
        $user_data['Store_Master'] = 0;
        $user_data['Relationship_Master'] = 0;
        $user_data['Batch_Master'] = 0;
        $user_data['Vendor_Type'] = 0;
        $user_data['Distributor_Sale_In'] = 0;

        $user_data['Purchase_Order'] = 0;
        $user_data['Raw_Material_In'] = 0;
        $user_data['Batch_Processing'] = 0;
        $user_data['Distributor_Out'] = 0;
        $user_data['Distributor_In'] = 0;
        $user_data['Distributor_Sale'] = 0;
        $user_data['Payment'] = 0;
        $user_data['Credit_Debit_Note'] = 0;

        $user_data['Depot_Transfer'] = 0;
        $user_data['Distributor_Transfer'] = 0;
        $user_data['Bar_To_Box'] = 0;
        $user_data['Box_To_Bar'] = 0;

        $user_data['User'] = 0;
        $user_data['User_Roles'] = 0;

        $user_data['Sales_Rep_Target'] = 0;

        $user_data['Reports'] = 0;

        $user_data['Sales_Rep_Route_Plan'] = 0;
        $user_data['Sales_Rep_Distributors'] = 0;
        $user_data['Sales_Rep_Orders'] = 0;
        $user_data['Sales_Rep_Payment_Receivables'] = 0;

        $user_data['Sales_Rep_Area'] = 0;
        $user_data['Sales_Rep_Location'] = 0;

        $user_data['accounting'] = 0;
        $user_data['accgroup'] = 0;
        $user_data['accledger'] = 0;


        $user_data['Log'] = 0;

        $roleid = $CI->session->userdata('role_id');
        $query=$CI->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            for ($i=0; $i<count($result); $i++) {
                $user_data[$result[$i]->section] = $result[$i]->r_view;
            }
        }

        if ($user_data['Vendors']==0 && $user_data['Depot']==0 && $user_data['Raw_Material']==0 && 
            $user_data['Tax']==0 && $user_data['Product']==0 && $user_data['Box']==0 && 
            $user_data['Sales_Rep']==0 && $user_data['Distributor']==0 && $user_data['City_Master']==0 && 
            $user_data['Bank_Master']==0 && $user_data['Area']==0 && $user_data['Distributor_Type']==0 && 
            $user_data['Zone']==0&& $user_data['Location']==0 && $user_data['Ingredient_Master']==0 && $user_data['Store_Master']==0&& $user_data['Relationship_Master']==0&& $user_data['Sr_Mapping']==0&& $user_data['Vendor_Type']==0) {
            $user_data['Masters'] = 0;
        } else {
            $user_data['Masters'] = 1;
        }

        if ($user_data['Raw_Material_In']==0 && $user_data['Batch_Processing']==0 && 
            $user_data['Distributor_Out']==0 && $user_data['Distributor_In']==0 && 
            $user_data['Purchase_Order']==0 && $user_data['Distributor_Sale']==0 && 
            $user_data['Payment']==0 && $user_data['Credit_Debit_Note']==0 && $user_data['Batch_Master']==0&& $user_data['Distributor_Sale_In']==0 ) {
            $user_data['Transactions'] = 0;
        } else {
            $user_data['Transactions'] = 1;
        }

        if ($user_data['Depot_Transfer']==0 && $user_data['Distributor_Transfer']==0 && 
            $user_data['Bar_To_Box']==0 && $user_data['Box_To_Bar']==0) {
            $user_data['Transfer'] = 0;
        } else {
            $user_data['Transfer'] = 1;
        }

        if ($user_data['accgroup']==0 && $user_data['accledger']==0) {
            $user_data['accounting'] = 0;
        } else {
            $user_data['accounting'] = 1;
        }

        if ($user_data['User']==0 && $user_data['User_Roles']==0) {
            $user_data['Settings'] = 0;
        } else {
            $user_data['Settings'] = 1;
        }

        if ($user_data['Sales_Rep_Target']==0) {
            $user_data['Sales_Rep_Target'] = 0;
        } else {
            $user_data['Sales_Rep_Target'] = 1;
        }

        if ($user_data['Reports']==0) {
            $user_data['Reports'] = 0;
        } else {
            $user_data['Reports'] = 1;
        }

        if ($user_data['Sales_Rep_Route_Plan']==0) {
            $user_data['Sales_Rep_Route_Plan'] = 0;
        } else {
            $user_data['Sales_Rep_Route_Plan'] = 1;
        }
        if ($user_data['Sales_Rep_Distributors']==0) {
            $user_data['Sales_Rep_Distributors'] = 0;
        } else {
            $user_data['Sales_Rep_Distributors'] = 1;
        }
        if ($user_data['Sales_Rep_Orders']==0) {
            $user_data['Sales_Rep_Orders'] = 0;
        } else {
            $user_data['Sales_Rep_Orders'] = 1;
        }
        if ($user_data['Sales_Rep_Payment_Receivables']==0) {
            $user_data['Sales_Rep_Payment_Receivables'] = 0;
        } else {
            $user_data['Sales_Rep_Payment_Receivables'] = 1;
        }
        if ($user_data['Sales_Rep_Area']==0) {
            $user_data['Sales_Rep_Area'] = 0;
        } else {
            $user_data['Sales_Rep_Area'] = 1;
        }
        if ($user_data['Sales_Rep_Location']==0) {
            $user_data['Sales_Rep_Location'] = 0;
        } else {
            $user_data['Sales_Rep_Location'] = 1;
        }


        if ($user_data['Log']==0) {
            $user_data['Log'] = 0;
        } else {
            $user_data['Log'] = 1;
        }

        $user_data['userdata'] = $CI->session->all_userdata();

        $sales_rep_id=$CI->session->userdata('sales_rep_id');
        $now1=date('Y-m-d');
        $where = array("date(check_in_time)"=>$now1,
                   "sales_rep_id"=>$sales_rep_id);
        $result2 = $CI->db->select("sales_rep_id, working_status, id, check_in_time, check_out_time, check_out")
                    ->where($where)->get('sales_attendence')->result();
        $user_data['attendancedata'] = $result2;

    	$data = $data + $user_data;

    	$CI->load->view($view, $data);
    }

    function load_view_without_data($view) {
        $CI =& get_instance();
        
        $user_data['Masters'] = 0;
        $user_data['Transactions'] = 0;
        $user_data['Transfer'] = 0;
        $user_data['Settings'] = 0;

        $user_data['Vendors'] = 0;
        $user_data['Depot'] = 0;
        $user_data['Raw_Material'] = 0;
        $user_data['Tax'] = 0;
        $user_data['Product'] = 0;
        $user_data['Box'] = 0;
        $user_data['Sales_Rep'] = 0;
        $user_data['Distributor'] = 0;
        $user_data['City_Master'] = 0;
        $user_data['Bank_Master'] = 0;
        $user_data['Area'] = 0;
        $user_data['Distributor_Type'] = 0;
        $user_data['Zone'] = 0;

		
		$user_data['Location'] = 0;
        $user_data['Sr_Mapping'] = 0;
        $user_data['Ingredient_Master'] = 0;
        $user_data['Store_Master'] = 0;
        $user_data['Relationship_Master'] = 0;
        $user_data['Batch_Master'] = 0;
        $user_data['Vendor_Type'] = 0;
        $user_data['Distributor_Sale_In'] = 0;
		
        $user_data['Purchase_Order'] = 0;
        $user_data['Raw_Material_In'] = 0;
        $user_data['Batch_Processing'] = 0;
        $user_data['Distributor_Out'] = 0;
        $user_data['Distributor_In'] = 0;
        $user_data['Distributor_Sale'] = 0;
        $user_data['Payment'] = 0;
        $user_data['Credit_Debit_Note'] = 0;

        $user_data['Depot_Transfer'] = 0;
        $user_data['Distributor_Transfer'] = 0;
        $user_data['Bar_To_Box'] = 0;
        $user_data['Box_To_Bar'] = 0;

        $user_data['User'] = 0;
        $user_data['User_Roles'] = 0;

        $user_data['Sales_Rep_Target'] = 0;

        $user_data['Reports'] = 0;

        $user_data['Sales_Rep_Route_Plan'] = 0;
        $user_data['Sales_Rep_Distributors'] = 0;
        $user_data['Sales_Rep_Orders'] = 0;
        $user_data['Sales_Rep_Payment_Receivables'] = 0;

        $user_data['Sales_Rep_Area'] = 0;
        $user_data['Sales_Rep_Location'] = 0;

        $user_data['Log'] = 0;

        $user_data['accounting'] = 0;
        $user_data['accgroup'] = 0;
        $user_data['accledger'] = 0;

        $roleid = $CI->session->userdata('role_id');
        $query=$CI->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            for ($i=0; $i<count($result); $i++) {
                $user_data[$result[$i]->section] = $result[$i]->r_view;
            }
        }

        if ($user_data['Vendors']==0 && $user_data['Depot']==0 && $user_data['Raw_Material']==0 && 
            $user_data['Tax']==0 && $user_data['Product']==0 && $user_data['Box']==0 && 
            $user_data['Sales_Rep']==0 && $user_data['Distributor']==0 && $user_data['City_Master']==0 && 
            $user_data['Bank_Master']==0 && $user_data['Area']==0 && $user_data['Distributor_Type']==0 && 
            $user_data['Zone']==0 && $user_data['Location']==0 && $user_data['Ingredient_Master']==0 && $user_data['Store_Master']==0&& $user_data['Relationship_Master']==0&& $user_data['Sr_Mapping']==0&& $user_data['Vendor_Type']==0)
			{
            $user_data['Masters'] = 0;
			} else {
            $user_data['Masters'] = 1;
        }

        if ($user_data['Raw_Material_In']==0 && $user_data['Batch_Processing']==0 && 
            $user_data['Distributor_Out']==0 && $user_data['Distributor_In']==0 && 
            $user_data['Purchase_Order']==0 && $user_data['Distributor_Sale']==0 && 
            $user_data['Payment']==0 && $user_data['Credit_Debit_Note']==0 && $user_data['Batch_Master']==0&& $user_data['Distributor_Sale_In']==0 ){
            $user_data['Transactions'] = 0;
        } else {
            $user_data['Transactions'] = 1;
        }

        if ($user_data['Depot_Transfer']==0 && $user_data['Distributor_Transfer']==0 && 
            $user_data['Bar_To_Box']==0 && $user_data['Box_To_Bar']==0) {
            $user_data['Transfer'] = 0;
        } else {
            $user_data['Transfer'] = 1;
        }

        if ($user_data['accgroup']==0 && $user_data['accledger']==0) {
            $user_data['accounting'] = 0;
        } else {
            $user_data['accounting'] = 1;
        }

        if ($user_data['User']==0 && $user_data['User_Roles']==0) {
            $user_data['Settings'] = 0;
        } else {
            $user_data['Settings'] = 1;
        }

        if ($user_data['Sales_Rep_Target']==0) {
            $user_data['Sales_Rep_Target'] = 0;
        } else {
            $user_data['Sales_Rep_Target'] = 1;
        }

        if ($user_data['Reports']==0) {
            $user_data['Reports'] = 0;
        } else {
            $user_data['Reports'] = 1;
        }

        if ($user_data['Sales_Rep_Route_Plan']==0) {
            $user_data['Sales_Rep_Route_Plan'] = 0;
        } else {
            $user_data['Sales_Rep_Route_Plan'] = 1;
        }
        if ($user_data['Sales_Rep_Distributors']==0) {
            $user_data['Sales_Rep_Distributors'] = 0;
        } else {
            $user_data['Sales_Rep_Distributors'] = 1;
        }
        if ($user_data['Sales_Rep_Orders']==0) {
            $user_data['Sales_Rep_Orders'] = 0;
        } else {
            $user_data['Sales_Rep_Orders'] = 1;
        }
        if ($user_data['Sales_Rep_Payment_Receivables']==0) {
            $user_data['Sales_Rep_Payment_Receivables'] = 0;
        } else {
            $user_data['Sales_Rep_Payment_Receivables'] = 1;
        }
        if ($user_data['Sales_Rep_Area']==0) {
            $user_data['Sales_Rep_Area'] = 0;
        } else {
            $user_data['Sales_Rep_Area'] = 1;
        }
        if ($user_data['Sales_Rep_Location']==0) {
            $user_data['Sales_Rep_Location'] = 0;
        } else {
            $user_data['Sales_Rep_Location'] = 1;
        }


        if ($user_data['Log']==0) {
            $user_data['Log'] = 0;
        } else {
            $user_data['Log'] = 1;
        }

        $user_data['userdata'] = $CI->session->all_userdata();

        $sales_rep_id=$CI->session->userdata('sales_rep_id');
        $now1=date('Y-m-d');
        $where = array("date(check_in_time)"=>$now1,
                   "sales_rep_id"=>$sales_rep_id);
        $result2 = $CI->db->select("sales_rep_id, working_status, id, check_in_time, check_out_time, check_out")
                    ->where($where)->get('sales_attendence')->result();
        $user_data['attendancedata'] = $result2;

        $data = $user_data;

        $CI->load->view($view, $data);
    }

    function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function FormatDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        $returnDate = null;
        if ($d && $d->format($format) == $date) {
            // $returnDate = DateTime::createFromFormat($format, $date)->format('Y-m-d');
            $dateInput = explode('/',$date);
            $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
        }

        return $returnDate;
    }

    function send_email($from_email, $from_email_sender, $to_email, $subject, $message, $bcc='swapnil.darekar@otbconsulting.co.in') {
        try {
            $CI =& get_instance();

            //configure email settings
            $config['protocol'] = 'smtp';
            // $config['smtp_host'] = 'smtp.rediffmailpro.com'; //smtp host name
            $config['smtp_host'] = 'mail.eatanytime.in'; //smtp host name
            $config['smtp_port'] = '25'; //smtp port number
            $config['smtp_user'] = $from_email;
            $config['smtp_pass'] = 'Cs@12345#'; //$from_email password
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            $CI->email->initialize($config);

            //send mail
            $CI->email->from($from_email, $from_email_sender);
            $CI->email->to($to_email);
            $CI->email->bcc($bcc);
            $CI->email->subject($subject);
            $CI->email->message($message);
            $CI->email->set_mailtype("html");
            return $CI->email->send();

        } catch (Exception $ex) {
            
        }
    }

    function send_email_new($from_email, $from_email_sender, $to_email, $subject, $message, $bcc='swapnil.darekar@otbconsulting.co.in',$cc='',$attachment='') {
        try {
            $CI =& get_instance();

            $from_email = 'info@eatanytime.co.in';

            //configure email settings
            $config['protocol'] = 'smtp';
            // $config['smtp_host'] = 'smtp.rediffmailpro.com'; //smtp host name
            $config['smtp_host'] = 'mail.eatanytime.co.in'; //smtp host name
            $config['smtp_port'] = '587'; //smtp port number
            $config['smtp_user'] = $from_email;
            $config['smtp_pass'] = 'Customer@12345'; //$from_email password
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            $CI->email->initialize($config);

            //send mail
            $CI->email->from($from_email, $from_email_sender);
            $CI->email->to($to_email);
            $CI->email->bcc($bcc);
            if($cc!='')
            $CI->email->cc($cc);
            $CI->email->subject($subject);
            $CI->email->message($message);
            if($attachment!='')
                $CI->email->attach($attachment);
            $CI->email->set_mailtype("html");
            $result = $CI->email->send();
            echo $CI->email->print_debugger();
            $CI->email->clear(TRUE);

            return $result;

        } catch (Exception $ex) {
            
        }
    }

    function format_money($number, $decimal=2){
        if(!isset($number)) $number=0;

        $negative=false;
        if(strpos($number, '-')!==false){
            $negative=true;
            $number = str_replace('-', '', $number);
        }

        $number = floatval(str_replace(',', '', $number));
        $number = round($number, $decimal);

        $decimal="";
        
        if(strpos($number, '.')!==false){
            $decimal = substr($number, strpos($number, '.'));
            $number = substr($number, 0, strpos($number, '.'));
        }
        
        // echo $decimal . '<br/>';
        // echo $number . '<br/>';

        $len = strlen($number);
        $m = '';
        $number = strrev($number);
        for($i=0;$i<$len;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
                $m .=',';
            }
            $m .=$number[$i];
        }

        $number = strrev($m);
        $number = $number . $decimal;

        if($negative==true){
            $number = '-' . $number;
        }

        return $number;
    }

    function format_number($number, $decimal=2){
        if(!isset($number)) $number=0;
        $number = floatval(str_replace(',', '', $number));
        $number = round($number, $decimal);
        return $number;
    }

    function convert_to_feet($num, $unit){
        $num = format_number($num, 2);
        if($unit=='Sq m'){
            $num = $num * 10.7639;
        } else if($unit=='Sq yard'){
            $num = $num * 9;
        }

        return $num;
    }

    function get_address($address, $landmark, $city, $pincode, $state, $country) {
        if(isset($address)) {
            $address = $address . ', ';
        }
        if(isset($landmark)) {
            $address = $address . $landmark . ', ';
        }
        if(isset($city)) {
            $address = $address . $city . ' ';
        }
        if(isset($pincode)) {
            $address = $address . $pincode . ' ';
        }
        if(isset($state)) {
            $address = $address . $state . ', ';
        }
        if(isset($country)) {
            $address = $address . $country . ',';
        }

        $address = str_replace(', , , , ,', ',', $address);
        $address = str_replace(', , , ,', ',', $address);
        $address = str_replace(', , ,', ',', $address);
        $address = str_replace(', ,', ',', $address);

        if(strpos($address, ',')!==false){
            $address = substr($address, 0, strlen($address)-1);
        }

        return $address;
    }

    function convert_number_to_words($number) {
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => ' ', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
        '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
        '60' => 'Sixty', '70' => 'Seventy',
        '80' => 'Eighty', '90' => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
         $divider = ($i == 2) ? 10 : 100;
         $number = floor($no % $divider);
         $no = floor($no / $divider);
         $i += ($divider == 10) ? 1 : 2;
         if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
         } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? (" and " . $words[$point / 10] . " " .  $words[$point = $point % 10]) : '';

        if($points==""){
            $result = $result . "Rupees ";
        } else {
            $result = $result . "Rupees " . $points . " Paise";
        }
        return $result;
    }

    function calculateFiscalYearForDate($inputDate){
        $year=substr($inputDate, 0, strpos($inputDate, "-"));
        $month=substr($inputDate, strpos($inputDate, "-")+1, strrpos($inputDate, "-")-1);

        $year=intval($year);
        $month=intval($month);

        if($month<4){
            $fyStart=$year-1;
            $fyEnd=$year;
        } else {
            $fyStart=$year;
            $fyEnd=$year+1;
        }

        $fyStart=substr(strval($fyStart),2);
        $fyEnd=substr(strval($fyEnd),2);

        $financial_year=$fyStart.'-'.$fyEnd;

        return $financial_year;
    }

?>