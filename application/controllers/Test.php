<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Test extends CI_Controller{

    public function __construct(){
        parent::__construct();
       
    }

    public function testabc()
    {
        $result = $this->db->query("SELECT * FROM `distributor_master` Where id= '1319' ORDER By id desc")->result();
        echo strlen($result[0]->distributor_name);
        echo strlen(ltrim($result[0]->distributor_name));
        echo "distributor_name".$result[0]->distributor_name;
    }
}