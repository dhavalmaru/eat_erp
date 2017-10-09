<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Autocomplete extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('common_functions');
        $this->load->model('autocomplete_model');
    }

    //index function
    public function index(){

    }
    
    function loadcity(){
        $term = "t";
                
        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        $response=$this->autocomplete_model->getCityList($term);
        echo json_encode($response);
    }

    function getStateCountryByCity(){
        $city_id=$this->input->post('state_id');
        $response=$this->autocomplete_model->getStateCountryByCity($city_id);
        echo json_encode($response);
    }

    function loadcountry(){
        $text='t';
        $text=html_escape($this->input->get('term'));
        $response=$this->autocomplete_model->loadcountry($text);
        echo json_encode($response);
    }

    function loadState(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->autocomplete_model->loadState($text);
        echo json_encode($response);
    }

    function load_vendor(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->autocomplete_model->load_vendor($text);
        echo json_encode($response);
    }

    function load_distributor(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->autocomplete_model->load_distributor($text);
        echo json_encode($response);
    }

    function load_sales_rep(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->autocomplete_model->load_sales_rep($text);
        echo json_encode($response);
    }

    function load_raw_material(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->autocomplete_model->load_raw_material($text);
        echo json_encode($response);
    }

    function load_product(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->autocomplete_model->load_product($text);
        echo json_encode($response);
    }

    function load_depot(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->autocomplete_model->load_depot($text);
        echo json_encode($response);
    }

    function load_batch(){
        $text='t';
        $text=html_escape( $this->input->get('term'));
        $response=$this->autocomplete_model->load_batch($text);
        echo json_encode($response);
    }

}
?>