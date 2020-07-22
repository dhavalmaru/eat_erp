<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_return_upload_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_In' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
        return $query->result();
    }

    function get_data($status='', $id=''){
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

        $sql = "select * from sales_return_upload_files".$cond." order by modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }
}
?>