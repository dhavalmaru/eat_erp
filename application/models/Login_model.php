<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    //get the username & password from tbl_usrs
    function get_user($usr, $pwd)
    {  
        //This is in the PHP file and sends a Javascript alert to the client
        //$message = "wrong answer";
        //echo "<script type='text/javascript'>alert('$message . md5($pwd) ');</script>";

        $sql = "select * from mst_user where user_id = '" . $usr . "' and password = '" . $pwd . "' and is_approved = 1 LIMIT 1";
        $query = $this->db->query($sql);
        //return $query->num_rows();
        return $query;
    }
}?>