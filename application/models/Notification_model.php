<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Notification_model Extends CI_Model{
    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
    }

    function get_access(){
        $role_id=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase_Order' AND role_id='$role_id' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1 OR r_export = 1)");
        return $query->result();
    }

    function add_notification($notification_id, $notification, $notification_date, $notification_type, $user_type, $user_id, $reference_id){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        if($user_id==''){
            $user_id="null";
        } else {
            $user_id="'".$user_id."'";
        }

        $sql = "insert into notifications (notification_id, notification, notification_date, notification_type, user_type, user_id, 
                reference_id, status, created_by, created_on, modified_by, modified_on) values 
                ('".$notification_id."', '".$notification."', '".$notification_date."', '".$notification_type."', 
                '".$user_type."', ".$user_id.", '".$reference_id."', 'Approved', '".$curusr."', '".$now."', 
                '".$curusr."', '".$now."')";
        $this->db->query($sql);
    }

    function delete_notification($notification_id, $reference_id){
        $now=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $sql = "delete from notifications where notification_id='".$notification_id."' and reference_id='".$reference_id."'";
        $this->db->query($sql);
    }
}
?>