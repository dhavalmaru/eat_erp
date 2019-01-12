<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Category extends CI_Controller{

	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('category_master_model','category');
        
        $this->load->database();
    }

    public function index()
    {
    	$this->checkstatus();
    }

    public function add()
    {
    	$this->category->insertUpdateRecord();
    	redirect(base_url().'index.php/category');	
    }

    public function checkstatus($category_id='')
    {
    	$data['category_detail']=$this->category->getCategoryDetails($category_id);
    	load_view('category/category_list',$data);
				
    }

    public function get_category_by_id($category_id='')
    {
    	$result = $this->category->getCategoryDetails($category_id);
    	if(count($result)>0)
    		echo json_encode($result[0]);
    	else
    		echo 0;
    }

    public function delete_record($category_id='')
    {
      $result = $this->category->delete_record($category_id);
      echo 'success'; 
    }

}

?>