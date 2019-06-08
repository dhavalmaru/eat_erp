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

        $sql="select AA.total_amount, BB.total_bar, BB.total_box from 
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
            (select A.distributor_in_id, case when A.type='Bar' then A.qty else ifnull(A.qty,0)*ifnull(B.qty,0) end as bar_qty, 
                            case when A.type='Box' then A.qty else 0 end as box_qty 
                from distributor_in_items A left join box_product B 
                on (A.type = 'Box' and A.item_id = B.box_id)) B 
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

    function get_total_receivable($sales_rep_id='') {
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

    function get_target($sales_rep_id='') {
        $sql="select * from sales_rep_target where status = 'Approved' and 
                sales_rep_id = '$sales_rep_id' and month = date_format(Now(),'%b-%y')";
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
	
	function get_data_dist($status='', $id=''){
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

        $sales_rep_id=$this->session->userdata('sales_rep_id');
        if($sales_rep_id!=""){
            $cond2=" where sales_rep_id='".$sales_rep_id."'";
        } else {
            $cond2="";
        }

        if($cond2=="") {
            $cond2=" where status != 'Active'";
        } else {
            $cond2=$cond2." and status != 'Active'";
        }

        $sql = "select G.* from 
                (select E.*, concat(ifnull(F.first_name,''),' ',ifnull(F.last_name,'')) as user_name from 
                (
                (select C.id, C.sales_rep_id, C.distributor_name, C.address, C.city, C.pincode, C.state, 
                C.country, C.vat_no, C.contact_person, C.contact_no, C.margin, C.doc_document, C.document_name, 
                D.area, C.status, C.remarks, C.modified_by, C.modified_on, state_code, gst_number from 
                (select concat('d_',A.id) as id, A.sales_rep_id, A.distributor_name, A.address, A.city, A.pincode, A.state, 
                A.country, A.tin_number as vat_no, B.contact_person, B.mobile as contact_no, A.sell_out as margin, 
                null as doc_document, null as document_name, A.area_id, A.status, A.remarks, 
                A.modified_by, A.modified_on, state_code, gst_number from 
                (select * from distributor_master".$cond2.") A 
                left join 
                (select * from distributor_contacts) B 
                on (A.id = B.distributor_id)) C 
                left join 
                (select * from area_master) D 
                on (C.Area_id = D.id))) E 
                left join 
                (select * from user_master) F 
                on (E.modified_by=F.id)) G ".$cond." 
    			order by distributor_name desc limit 10";
    	
    			
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_data_loc($status='', $id=''){
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

        $sales_rep_id=$this->session->userdata('sales_rep_id');
        if($sales_rep_id!=""){
            if($cond=="") {
                $cond=" where sales_rep_id='".$sales_rep_id."'";
            } else {
                $cond=$cond." and sales_rep_id='".$sales_rep_id."'";
            }
        }

        $sql = "select * from sales_rep_location".$cond."  and date_of_visit=date(now())  order by modified_on desc ";
        $query=$this->db->query($sql);
        return $query->result();
    }  

    function get_data_order($status='', $id=''){
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

        $sales_rep_id=$this->session->userdata('sales_rep_id');
        if($sales_rep_id!=""){
            if($cond=="") {
                $cond=" where sales_rep_id='".$sales_rep_id."'";
            } else {
                $cond=$cond." and sales_rep_id='".$sales_rep_id."'";
            }
        }

        $sql = "select E.* from 
                (select C.*, concat(ifnull(D.first_name,''),' ',ifnull(D.last_name,'')) as user_name from 
                (select A.*, B.distributor_name, B.sell_out, B.contact_person, B.contact_no, B.area from 
                (select concat('s_',id) as id, sales_rep_id, date_of_processing, distributor_id, 
                    null as invoice_no, amount, status, remarks, modified_by, modified_on from sales_rep_orders 
                union all 
                select concat('d_',id) as id, sales_rep_id, date_of_processing, concat('d_',distributor_id) as distributor_id, 
                    invoice_no, final_amount as amount, status, remarks, modified_by, modified_on from distributor_out) A
                left join 
                (select concat('s_',id) as id, distributor_name, margin as sell_out, contact_person, contact_no, city as area 
                    from sales_rep_distributors
                union all 
                select concat('d_',E.id) as id, E.distributor_name, E.sell_out, E.contact_person, E.contact_no, E.area from 
                (select C.*, D.area from 
                (select A.*, B.contact_person, B.mobile as contact_no from 
                (select id, distributor_name, sell_out, area_id from distributor_master) A 
                left join 
                (select * from distributor_contacts) B 
                on (A.id = B.distributor_id)) C 
                left join 
                (select * from area_master) D 
                on (C.Area_id = D.id)) E) B 
                on (A.distributor_id = B.id)) C 
                left join 
                (select * from user_master) D 
                on (C.modified_by=D.id)) E ".$cond." 
               and E.date_of_processing=date(now()) order by E.modified_on desc ";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_alternate($day,$m,$year){
        $date1 = date('d-m-Y', strtotime('second '.$day.' of '.$m.' '.$year));
        $date2 = date('d-m-Y', strtotime('fourth '.$day.' of '.$m.' '.$year));

        $todaysdate = date('d-m-Y');
        if($date1==$todaysdate){
            return true;
        } elseif($date2==$todaysdate) {
            return true;
        } else {
           return false;
        }
    }

    function get_visit_details($sales_rep_id='', $curusr=''){
        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }

        $sql="select AA.sales_rep_name, ifnull(sum(AA.unplanned_count),0) as unplanned_count, 
                ifnull(sum(AA.p_call),0) as p_call, ifnull(sum(AA.planned_count),0) as actual_count, 
                ifnull(sum(AA.actual_count),0) as total_count from 
            (select * from 
            (select A.*, (ifnull(T.tem_visit_count,0)+ifnull(F.unplanned_count,0)) as unplanned_count, ifnull(E.p_call,0) as p_call, 
                ifnull(C.planned_count,0) as planned_count, ifnull(case when D.actual_count is null then G.actual_count2 else D.actual_count-(ifnull(T.tem_visit_count,0)+ifnull(F.unplanned_count,0)) end,0) as actual_count from 
            (select distinct id as sales_rep_id, sales_rep_name, '$frequency' as frequency from sales_rep_master 
                where id='$sales_rep_id' and status='Approved') A 
            left join 
            (select count(id) as unplanned_count,sales_rep_id,frequency from 
            (select id,sales_rep_id,frequency from merchandiser_detailed_beat_plan A where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                store_id in (select distinct store_id from merchandiser_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                                date(created_on)=date(now()) and created_by='$curusr') and date(date_of_visit)=date(now()) and is_edit='edit') A group by sales_rep_id,frequency) F 
            on (A.sales_rep_id=F.sales_rep_id) 
            left join 
            (select count(id) as tem_visit_count,sales_rep_id,frequency from merchandiser_detailed_beat_plan 
                where sales_rep_id='$sales_rep_id' and frequency='$frequency'  and 
                store_id not in (select distinct store_id from merchandiser_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency') and 
                                    date(date_of_visit)=date(now()) and is_edit='edit' group by sales_rep_id,frequency) T 
            on (A.sales_rep_id=T.sales_rep_id) 
            left join 
            (select count(id) as p_call,sales_rep_id from sales_rep_orders where sales_rep_id='$sales_rep_id' and date(date_of_processing)=date(now()) and 
                channel_type='MT' group by sales_rep_id) E 
            on (A.sales_rep_id=E.sales_rep_id) 
            left join 
            (select count(*) as planned_count,sales_rep_id from 
            (select store_id,sales_rep_id,date_of_visit from merchandiser_detailed_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                store_id in (select distinct store_id from merchandiser_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                                (date(created_on)<>date(now()) or created_by<>'$curusr')) and date(date_of_visit)=date(now()) and is_edit='edit') B group by sales_rep_id) C 
            on (A.sales_rep_id=C.sales_rep_id) 
            left join 
            (select count(*) as actual_count,sales_rep_id from 
            (select store_id,sales_rep_id,date_of_visit from merchandiser_detailed_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                date(date_of_visit)=date(now())) B group by sales_rep_id) D 
            on (A.sales_rep_id=D.sales_rep_id)
            left join 
            (select count(*) as actual_count2,sales_rep_id from 
            (select store_id,sales_rep_id from merchandiser_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency') B group by sales_rep_id) G 
            on (A.sales_rep_id=G.sales_rep_id)) AA 
            union 
            select * from 
            (select A.*, (ifnull(T.tem_visit_count,0)+ifnull(F.unplanned_count,0)) as unplanned_count, ifnull(E.p_call,0) as p_call, 
                ifnull(C.planned_count,0) as planned_count, ifnull(case when D.actual_count is null then G.actual_count2 else D.actual_count-(ifnull(T.tem_visit_count,0)+ifnull(F.unplanned_count,0)) end,0) as actual_count from 
            (select distinct id as sales_rep_id, sales_rep_name, '$frequency' as frequency from sales_rep_master 
                where id='$sales_rep_id' and status='Approved') A 
            left join 
            (select count(id) as unplanned_count,sales_rep_id,frequency from 
            (select id,sales_rep_id,frequency from sales_rep_detailed_beat_plan A where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                store_id in (select distinct store_id from sales_rep_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                                date(created_on)=date(now()) and created_by='$curusr') and date(date_of_visit)=date(now()) and is_edit='edit') A group by sales_rep_id,frequency) F 
            on (A.sales_rep_id=F.sales_rep_id) 
            left join 
            (select count(id) as tem_visit_count,sales_rep_id,frequency from sales_rep_detailed_beat_plan 
                where sales_rep_id='$sales_rep_id' and frequency='$frequency'  and 
                store_id not in (select distinct store_id from sales_rep_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency') and 
                                    date(date_of_visit)=date(now()) and is_edit='edit' and beat_id is null group by sales_rep_id,frequency) T 
            on (A.sales_rep_id=T.sales_rep_id) 
            left join 
            (select count(id) as p_call,sales_rep_id from sales_rep_orders where sales_rep_id='$sales_rep_id' and date(date_of_processing)=date(now()) and 
                channel_type='GT' group by sales_rep_id) E 
            on (A.sales_rep_id=E.sales_rep_id) 
            left join 
            (select count(*) as planned_count,sales_rep_id from 
            (select store_id,sales_rep_id,date_of_visit from sales_rep_detailed_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                (store_id in (select distinct store_id from sales_rep_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                                (date(created_on)<>date(now()) or created_by<>'$curusr')) or beat_id is not null) and date(date_of_visit)=date(now()) and is_edit='edit') B group by sales_rep_id) C 
            on (A.sales_rep_id=C.sales_rep_id) 
            left join 
            (select count(*) as actual_count,sales_rep_id from 
            (select store_id,sales_rep_id,date_of_visit from sales_rep_detailed_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency' and 
                date(date_of_visit)=date(now())) B group by sales_rep_id) D 
            on (A.sales_rep_id=D.sales_rep_id)
            left join 
            (select count(*) as actual_count2,sales_rep_id from 
            (select store_id,sales_rep_id from sales_rep_beat_plan where sales_rep_id='$sales_rep_id' and frequency='$frequency') B group by sales_rep_id) G 
            on (A.sales_rep_id=G.sales_rep_id)) AA) AA group by AA.sales_rep_name";
        $query=$this->db->query($sql);
        return $query->result();
    }

    function get_order_details($sales_rep_id=''){
        // $sql="select A.id, A.sales_rep_name, ifnull(B.bar_cnt,0) as bar_cnt, ifnull(B.box_cnt,0) as box_cnt, 
        //             ifnull(B.cookies_cnt,0) as cookies_cnt, ifnull(B.trailmix_cnt,0) as trailmix_cnt from 
        //         (select id,sales_rep_name from sales_rep_master where id='$sales_rep_id' and status='Approved') A 
        //         left join 
        //         (select A.sales_rep_id, sum(A.bar_cnt) as bar_cnt, sum(A.box_cnt) as box_cnt, sum(A.cookies_cnt) as cookies_cnt, sum(A.trailmix_cnt) as trailmix_cnt from 
        //         (select A.id, A.sales_rep_id, case when B.type='Bar' then case when B.qty>0 then 1 else 0 end else 0 end as bar_cnt, 
        //             case when B.type='Box' and B.item_id in (1, 3, 9, 8, 12, 29, 31, 32) then case when B.qty>0 then 1 else 0 end else 0 end as box_cnt, 
        //             case when B.type='Box' and B.item_id in (37, 38, 39) then case when B.qty>0 then 1 else 0 end else 0 end as cookies_cnt, 
        //             case when B.type='Box' and B.item_id in (40, 41, 42) then case when B.qty>0 then 1 else 0 end else 0 end as trailmix_cnt 
        //         from sales_rep_orders A left join sales_rep_order_items B on (A.id=B.sales_rep_order_id) where date(date_of_processing)=date(now())) A 
        //         where A.sales_rep_id='$sales_rep_id' group by A.sales_rep_id) B 
        //         on (A.id=B.sales_rep_id)";

        $sql="select A.id, A.sales_rep_name, ifnull(B.bar_cnt,0) as bar_cnt, ifnull(B.box_cnt,0) as box_cnt, 
                    ifnull(B.cookies_cnt,0) as cookies_cnt, ifnull(B.trailmix_cnt,0) as trailmix_cnt from 
                (select id,sales_rep_name from sales_rep_master where id='$sales_rep_id' and status='Approved') A 
                left join 
                (select A.sales_rep_id, sum(A.bar_cnt) as bar_cnt, sum(A.box_cnt) as box_cnt, sum(A.cookies_cnt) as cookies_cnt, sum(A.trailmix_cnt) as trailmix_cnt from 
                (select A.id, A.sales_rep_id, case when B.type='Bar' then case when B.qty>0 then B.qty else 0 end else 0 end as bar_cnt, 
                    case when B.type='Box' and B.item_id in (1, 3, 9, 8, 12, 29, 31, 32) then case when B.qty>0 then B.qty else 0 end else 0 end as box_cnt, 
                    case when B.type='Box' and B.item_id in (37, 38, 39) then case when B.qty>0 then B.qty else 0 end else 0 end as cookies_cnt, 
                    case when B.type='Box' and B.item_id in (40, 41, 42) then case when B.qty>0 then B.qty else 0 end else 0 end as trailmix_cnt 
                from sales_rep_orders A left join sales_rep_order_items B on (A.id=B.sales_rep_order_id) where date(date_of_processing)=date(now())) A 
                where A.sales_rep_id='$sales_rep_id' group by A.sales_rep_id) B 
                on (A.id=B.sales_rep_id)";
        $query=$this->db->query($sql);
        return $query->result();
    }
}
?>