<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_rep_route_plan_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function get_access(){
    $role_id=$this->session->userdata('role_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sales_Rep_Route_Plan' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
    return $query->result();
}

function get_route_plan(){
    $from_date=formatdate($this->input->post('from_date'));
    $to_date=formatdate($this->input->post('to_date'));
    $sales_rep_id=$this->input->post('sales_rep_id');

    $sql = "select B.id, A.sales_rep_id, A.modified_on, A.area, A.latitude as area_lat, A.longitude as area_long, 
                    B.distributor_name, B.latitude as dist_lat, B.longitude as dist_long, A.date_of_visit from 
            (select * from sales_rep_area where status = 'Approved' and sales_rep_id = '$sales_rep_id' and 
                        date(date_of_visit) >= date '$from_date' and date(date_of_visit) <= date '$to_date') A 
            left join 
            (select * from sales_rep_location where status = 'Approved' and sales_rep_id = '$sales_rep_id' and 
                        date(modified_on) >= date '$from_date' and date(modified_on) <= date '$to_date') B 
            on (A.date_of_visit = B.date_of_visit and A.sales_rep_id = B.sales_rep_id) 
            where B.id is not null 
            order by B.id";
    $query=$this->db->query($sql);
    return $query->result();
}

}
?>