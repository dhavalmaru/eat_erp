<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Freezed_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

public function save_freeze_detail()
{
   $freezed_year = $this->input->post('freezed_year');
   $month = $this->input->post('month');
   $now = date("Y-m-d H:i:s");
   $added_by=$this->session->userdata('session_id');

   $month_date = intval(date('m',strtotime($month)));

   $freez_detail = array("year"=>$freezed_year,
                         "month"=>$month,
                         "added_on"=>$now,
                         "added_by"=>$added_by);
   $this->db->insert('freezed_month_details',$freez_detail);

    //for Sales
    $query = "UPDATE distributor_out SET freezed=1
            Where Case When invoice_no='' OR invoice_no IS NULL  THEN 
            MONTH(date_of_processing)=$month_date and YEAR(date_of_processing)='$freezed_year'
            When invoice_no<>'' THEN 
            MONTH(invoice_date)=$month_date and YEAR(invoice_date)='$freezed_year'
            END";
    $this->db->query($query);

    //for Sales Return
    $query2 = "UPDATE distributor_in SET freezed=1
            Where Case When approved_on IS NOT NULL THEN 
            MONTH(approved_on)=$month_date and YEAR(approved_on)='$freezed_year'
            ELSE
            MONTH(date_of_processing)=$month_date and YEAR(date_of_processing)='$freezed_year'
            END";
    $this->db->query($query2);

    //for Credit/Debit Note
    $query3 = "UPDATE credit_debit_note SET freezed=1
            Where Case When approved_on IS NOT NULL THEN 
            MONTH(approved_on)=$month_date and YEAR(approved_on)='$freezed_year'
            ELSE
            MONTH(date_of_transaction)=$month_date and YEAR(date_of_transaction)='$freezed_year'
            END";
    $this->db->query($query3);          
}

public function get_freezed_month($year)
{
    $result = $this->db->select("*")->where('year',$year)->get('freezed_month_details')->result_array();
    return $result;

}

public function check_freedzed_month()
{
    $date_of_processing = $this->input->post("date");
    $date=formatdate($date_of_processing);
    $year = date('Y',strtotime($date));
    $month = date('F',strtotime($date));
    $where = array("year"=>$year,"month"=>$month);
    $result = $this->db->select("*")->where($where)->get('freezed_month_details')->result_array();
    //echo $this->db->last_query();
    if(count($result)>0)
        return 1;
    else
        return 0;
}


}
?>