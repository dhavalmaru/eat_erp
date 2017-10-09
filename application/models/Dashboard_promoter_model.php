<?php 
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard_promoter_model extends CI_Model {
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

    function get_checkout_status() {
        $sales_rep_id=$this->session->userdata('sales_rep_id');
        // $query=$this->db->query("select store_name,date_of_visit from promoter_location p,promoter_checkout c,promoter_stores s where p.id=c.promoter_location_id and s.id=p.distributor_id");
        $query=$this->db->query("select date_of_visit from promoter_location where checkout_status='checkin' and sales_rep_id='".$sales_rep_id."'");
        $result = $query->result();
        if(count($result)>0) {
            return "true";
        }
        return "false";
    }
    
    function get_store() {
        $sales_rep_id=$this->session->userdata('sales_rep_id');
        $query=$this->db->query("select s.store_name,p.date_of_visit,p.id from promoter_location p,promoter_stores s where s.id=p.distributor_id and p.sales_rep_id='".$sales_rep_id."' order by date_of_visit desc");
        $result = $query->result();
        return $result;
        
    }

}
?>