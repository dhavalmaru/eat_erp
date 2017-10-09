<?php 
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard_sales_rep_model extends CI_Model {
    public function __construct() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        parent::__construct();
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Dashboard_Sales_Rep' AND 
                                role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
        return $query->result();
    }

    function get_total_sale($from_date, $to_date) {
        $sales_rep_id=$this->session->userdata('sales_rep_id');

        $sql="select AA.total_amount, (BB.total_bar+(BB.total_box*6)) as total_bar, BB.total_box from 
            (select A.temp_col, round(ifnull(A.total_amount,0)-ifnull(B.total_amount,0),0) as total_amount from 
            (select '1' as temp_col, sum(final_amount) as total_amount from distributor_out 
                where status = 'Approved' and date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "') and sales_rep_id = '$sales_rep_id' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) A 
            left join 
            (select '1' as temp_col, sum(final_amount) as total_amount from distributor_in 
                where status = 'Approved' and date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "') and sales_rep_id = '$sales_rep_id' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) B 
            on (A.temp_col = B.temp_col)) AA 
            left join 
            (select C.temp_col, ifnull(C.total_bar,0)-ifnull(D.total_bar,0) as total_bar, 
                ifnull(C.total_box,0)-ifnull(D.total_box,0) as total_box from 
            (select '1' as temp_col, sum(B.bar_qty) as total_bar, sum(B.box_qty) as total_box from 
            (select id from distributor_out where status = 'Approved' and date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "') and sales_rep_id = '$sales_rep_id' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) A 
            left join 
            (select distributor_out_id, case when type='Bar' then qty else 0 end as bar_qty, 
            case when type='Box' then qty else 0 end as box_qty from distributor_out_items) B 
            on (A.id=B.distributor_out_id)) C 
            left join 
            (select '1' as temp_col, sum(B.bar_qty) as total_bar, sum(B.box_qty) as total_box from 
            (select id from distributor_in where status = 'Approved' and date(date_of_processing) >= date('" . $from_date . "') and 
                    date(date_of_processing) <= date('" . $to_date . "') and sales_rep_id = '$sales_rep_id' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) A 
            left join 
            (select distributor_in_id, case when type='Bar' then qty else 0 end as bar_qty, 
            case when type='Box' then qty else 0 end as box_qty from distributor_in_items) B 
            on (A.id=B.distributor_in_id)) D 
            on (C.temp_col=D.temp_col)) BB 
            on (AA.temp_col = BB.temp_col)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_total_distributor($from_date, $to_date) {
        $sales_rep_id=$this->session->userdata('sales_rep_id');

        $sql="select (B.tot_g_trade+B.tot_m_trade+B.tot_e_com) as tot_dist, B.tot_g_trade, B.tot_m_trade, B.tot_e_com from 
            (select count(A.id) as tot_dist, sum(A.g_trade) as tot_g_trade, sum(A.m_trade) as tot_m_trade, 
            sum(A.e_com) as tot_e_com from (select id, case when type_id='3' then 1 else 0 end as g_trade, 
            case when type_id='7' then 1 else 0 end as m_trade, 
            case when type_id='4' then 1 else 0 end as e_com 
            from distributor_master where status = 'Approved' and date(created_on) >= date('" . $from_date . "') and 
                    date(created_on) <= date('" . $to_date . "') and sales_rep_id = '$sales_rep_id') A) B";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_total_receivable() {
        $sales_rep_id=$this->session->userdata('sales_rep_id');

        $sql="select ifnull(C.total_amount,0)-ifnull(D.total_amount,0) as total_receivable from 
            (select A.temp_col, round(ifnull(A.total_amount,0)-ifnull(B.total_amount,0),0) as total_amount from 
            (select '1' as temp_col, sum(final_amount) as total_amount from distributor_out 
                where status = 'Approved' and sales_rep_id = '$sales_rep_id' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) A 
            left join 
            (select '1' as temp_col, sum(final_amount) as total_amount from distributor_in 
                where status = 'Approved' and sales_rep_id = '$sales_rep_id' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample')) B 
            on (A.temp_col = B.temp_col)) C 
            left join 
            (select '1' as temp_col, sum(payment_amount) as total_amount from payment_details_items 
                where payment_id in (select distinct id from payment_details where status = 'Approved') and 
                        distributor_id in (select distinct id from distributor_master where status = 'Approved' and 
                        sales_rep_id = '$sales_rep_id' and class <> 'Sample')) D 
            on (C.temp_col=D.temp_col)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_target() {
        $sales_rep_id=$this->session->userdata('sales_rep_id');

        $sql="select * from sales_rep_target where status = 'Approved' and sales_rep_id = '$sales_rep_id' and 
                month = date_format(Now(),'%b-%y')";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_months($from_date, $to_date) {
        $sales_rep_id=$this->session->userdata('sales_rep_id');

        $sql="select distinct B.month_no, B.month_name from 
            (select month(A.date_of_processing) as month_no, A.month_name from 
            (select sales_rep_id, date_of_processing, date_format(date_of_processing,'%b-%y') as month_name from distributor_out 
                where status = 'Approved' and distributor_id not in (select distinct id from distributor_master where class = 'sample') 
            union all 
            select sales_rep_id, STR_TO_DATE(concat('01-',month),'%d-%b-%y') as date_of_processing, month as month_name from sales_rep_target 
                where status = 'Approved') A 
            where A.sales_rep_id = '$sales_rep_id' and date(A.date_of_processing) >= date('" . $from_date . "') and 
                    date(A.date_of_processing) <= date('" . $to_date . "') order by A.date_of_processing) B";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_month_wise_sale($from_date, $to_date) {
        $sales_rep_id=$this->session->userdata('sales_rep_id');

        $sql="select B.item, B.month_no, B.month_name, sum(B.sales) as sales from 
            (select A.item, month(A.date_of_processing) as month_no, A.month_name, A.sales from 
            (select sales_rep_id, 'Actual' as item, date_of_processing, date_format(date_of_processing,'%b-%y') as month_name, 
                final_amount as sales from distributor_out where status = 'Approved' and 
                distributor_id not in (select distinct id from distributor_master where class = 'sample') 
            union all 
            select sales_rep_id, 'Target' as item, STR_TO_DATE(concat('01-',month),'%d-%b-%y') as date_of_processing, 
                month as month_name, target as sales from sales_rep_target where status = 'Approved') A 
            where A.sales_rep_id = '$sales_rep_id' and date(A.date_of_processing) >= date('" . $from_date . "') and 
                    date(A.date_of_processing) <= date('" . $to_date . "')) B 
            group by B.item, B.month_name, B.month_no Order by B.item, B.month_no";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_rout_plan_details($from_date, $to_date) {
        $sales_rep_id=$this->session->userdata('sales_rep_id');

        $sql="select * from sales_rep_route_plan where status = 'Approved' and 
                date(modified_on) >= date '$from_date' and date(modified_on) <= date '$to_date'";
        $query=$this->db->query($sql);
        return $query->result();
    }
    

}
?>