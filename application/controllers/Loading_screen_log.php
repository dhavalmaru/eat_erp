<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Loading_screen_log extends CI_Controller
{
    public function __construct(){
        parent::__construct();
      
        $this->load->helper('common_functions');
        // $this->load->model('dashboard_model');
		// $this->load->library('session');
    }

    //index function
    public function index()
	{
		
			$this->load->model('Loading_screen_log_model');
			$this->Loading_screen_log_model->insertQ();  
	
      
    }

  
  
    
}
?>