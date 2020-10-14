<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Shopify_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Distributor_Out' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
        return $query->result();
    }

    function get_list_data($start=0, $length=0, $search_val=''){
        $curusr = $this->session->userdata('session_id');

        $cond="";
        if($search_val!=''){
            $cond=" where (id like '%".$search_val."%' or DATE_FORMAT(upload_date, '%d/%m/%Y') like '%".$search_val."%' or file_name like '%".$search_val."%' or file_path like '%".$search_val."%' or check_file_name like '%".$search_val."%' or check_file_path like '%".$search_val."%')";
        }

        $data = array();

        $sql = "select count(id) as total_records from shopify_upload_files ".$cond;
        $query=$this->db->query($sql);
        $data['count']=$query->result();

        $limit = "";
        if($start>0 && $length>0) $limit .= " limit ".$start.", ".$length;
        elseif($length>0) $limit .= " limit ".$length;

        $sql = "select * from shopify_upload_files ".$cond." order by modified_on desc".$limit;
        $query=$this->db->query($sql);
        $data['rows']=$query->result();

        return $data;
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

        $sql = "select * from shopify_upload_files".$cond." order by modified_on desc";
        $query=$this->db->query($sql);
        return $query->result();
    }
}
?>