<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Log extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->database();
    }

    //index function
    public function index(){
        $sql = "select AA.*, BB.cnt_name, BB.ref_id, BB.ref_name from 

                (select A.*, B.email_id from 
                (select * from user_access_log) A 
                left join 
                (select * from user_master) B 
                on (A.user_id = B.id)) AA 

                left join 

                (select 'User Details' as module_name, 'User' as cnt_name, id as ref_id, concat(ifnull(first_name,''), ' ', ifnull(last_name,'')) as ref_name from user_master 
                union all 
                select 'User Role Details' as module_name, 'User_Roles' as cnt_name, id as ref_id, role_name as ref_name from user_role_master 
                union all 
                select 'Vendor' as module_name, 'Vendor' as cnt_name, id as ref_id, vendor_name as ref_name from vendor_master 
                union all 
                select 'Distributor' as module_name, 'Distributor' as cnt_name, id as ref_id, distributor_name as ref_name from distributor_master 
                union all 
                select 'Sales_Rep' as module_name, 'Sales_Rep' as cnt_name, id as ref_id, sales_rep_name as ref_name from sales_rep_master 
                union all 
                select 'Raw_Material' as module_name, 'Raw_Material' as cnt_name, id as ref_id, rm_name as ref_name from raw_material_master 
                union all 
                select 'Product' as module_name, 'Product' as cnt_name, id as ref_id, product_name as ref_name from product_master 
                union all 
                select 'Depot' as module_name, 'Depot' as cnt_name, id as ref_id, depot_name as ref_name from depot_master 
                union all 
                select 'City' as module_name, 'City' as cnt_name, id as ref_id, city_name as ref_name from city_master 
                union all 
                select A.module_name, A.cnt_name, A.ref_id, B.depot_name as ref_name from 
                (select 'Raw_Material_In' as module_name, 'Raw_Material_In' as cnt_name, id as ref_id, depot_id from raw_material_in) A 
                left join 
                (select * from depot_master) B 
                on (A.depot_id=B.id) 
                union all 
                select 'Batch_Processing' as module_name, 'Batch_Processing' as cnt_name, id as ref_id, batch_id_as_per_fssai as ref_name from batch_processing 
                union all 
                select A.module_name, A.cnt_name, A.ref_id, B.depot_name as ref_name from 
                (select 'Transfer' as module_name, 'Transfer' as cnt_name, id as ref_id, depot_out_id from depot_transfer) A 
                left join 
                (select * from depot_master) B 
                on (A.depot_out_id=B.id) 
                union all 
                select A.module_name, A.cnt_name, A.ref_id, B.distributor_name as ref_name from 
                (select 'Distributor_Out' as module_name, 'Distributor_Out' as cnt_name, id as ref_id, distributor_id from distributor_out) A 
                left join 
                (select * from distributor_master) B 
                on (A.distributor_id=B.id) 
                union all 
                select A.module_name, A.cnt_name, A.ref_id, B.distributor_name as ref_name from 
                (select 'Distributor_In' as module_name, 'Distributor_In' as cnt_name, id as ref_id, distributor_id from distributor_in) A 
                left join 
                (select * from distributor_master) B 
                on (A.distributor_id=B.id)) BB 

                on (AA.module_name = BB.module_name and AA.controller_name = BB.cnt_name and AA.table_id = BB.ref_id) order by AA.date desc";

        $query=$this->db->query($sql);
        $result=$query->result();
        $data['log']=$result;

        $query=$this->db->query("SELECT * FROM user_role_options");
        $result=$query->result();
        if(count($result)>0) {
            $result[0]->r_export=1;
            $data['access']=$result;
        }
        
        load_view('log/log_master', $data);
    }
}
?>