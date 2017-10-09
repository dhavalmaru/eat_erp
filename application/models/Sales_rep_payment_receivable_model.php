<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_payment_receivable_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep_Payment_Receivables' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_data(){
    $sales_rep_id=$this->session->userdata('sales_rep_id');
    $date = date('Y-m-d');

    $sql = "select I.*, J.area from 
            (select G.*, H.distributor_name, area_id from 
            (select F.distributor_id, F.days_30_45, F.days_46_60, F.days_61_90, F.days_91_above, 
                (F.days_30_45+F.days_46_60+F.days_61_90+F.days_91_above) as tot_receivable from 
            (select E.distributor_id, case when (E.days_30_45-E.paid_amount)>0 then 
                (E.days_30_45-E.paid_amount) else 0 end as days_30_45, 
            case when (E.days_30_45-E.paid_amount)>0 then E.days_46_60 else case when 
                (E.days_46_60-(E.paid_amount-E.days_30_45))>0 then 
                (E.days_46_60-(E.paid_amount-E.days_30_45)) else 0 end end as days_46_60, 
            case when (E.days_46_60-(E.paid_amount-E.days_30_45))>0 then 
            E.days_61_90 else case when (E.days_61_90-(E.paid_amount-E.days_30_45-E.days_46_60))>0 then 
            (E.days_61_90-(E.paid_amount-E.days_30_45-E.days_46_60)) else 0 end end as days_61_90, 
            case when (E.days_61_90-(E.paid_amount-E.days_30_45-E.days_46_60))>0 then E.days_91_above else case 
                when (E.days_91_above-(E.paid_amount-E.days_30_45-E.days_46_60-E.days_61_90))>0 
                then (E.days_91_above-(E.paid_amount-E.days_30_45-E.days_46_60-E.days_61_90)) else 0 end end as days_91_above from 
            (select C.distributor_id, C.days_30_45, C.days_46_60, C.days_61_90, C.days_91_above, 
                ifnull(D.paid_amount,0) as paid_amount from 
            (select distributor_id, ifnull(round(sum(days_30_45),0),0) as days_30_45, 
                ifnull(round(sum(days_46_60),0),0) as days_46_60, 
            ifnull(round(sum(days_61_90),0),0) as days_61_90, ifnull(round(sum(days_91_above),0),0) as days_91_above from 
            (select distributor_id, case when no_of_days>=30 and no_of_days<=45 then final_amount else 0 end as days_30_45, 
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
            (select * from distributor_master where sales_rep_id = '$sales_rep_id') H 
            on (G.distributor_id = H.id) where H.distributor_name is not null and G.tot_receivable > 0) I 
            left join 
            (select * from area_master) J 
            on (I.area_id = J.id) 
            order by I.tot_receivable desc";
    $query=$this->db->query($sql);
    return $query->result();
}

// function save_data($id=''){
//     $now=date('Y-m-d H:i:s');
//     $curusr=$this->session->userdata('session_id');
    
//     $data = array(
//         'sales_rep_id' => $curusr,
//         'area' => $this->input->post('area'),
//         'distributor_name' => $this->input->post('distributor_name'),
//         'status' => $this->input->post('status'),
//         'remarks' => $this->input->post('remarks'),
//         'modified_by' => $curusr,
//         'modified_on' => $now
//     );

//     if($id==''){
//         $data['created_by']=$curusr;
//         $data['created_on']=$now;

//         $this->db->insert('sales_rep_payment_receivable',$data);
//         $id=$this->db->insert_id();
//         $action='Sales Rep Payment Receivable Created.';
//     } else {
//         $this->db->where('id', $id);
//         $this->db->update('sales_rep_payment_receivable',$data);
//         $action='Sales Rep Payment Receivable Modified.';
//     }

//     $logarray['table_id']=$id;
//     $logarray['module_name']='Sales_Rep_Payment_Receivable';
//     $logarray['cnt_name']='Sales_Rep_Payment_Receivable';
//     $logarray['action']=$action;
//     $this->user_access_log_model->insertAccessLog($logarray);
// }

}
?>