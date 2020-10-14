<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Freezed extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_rep_model');
        $this->load->model('document_model');
        $this->load->model('export_model');
        $this->load->model('Freezed_model','freezed_model');
        $this->load->database();
    }

    //index function
    public function index(){
        if($this->session->userdata('role_id')==1)
        {
            load_view_without_data('freezed/freezed_details');
        }
        else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function add()
    {
        if($this->session->userdata('role_id')==1)
        {
             $this->freezed_model->save_freeze_detail();
             //redirect(base_url().'index.php/freezed');
             $freezed_year = $this->input->post('freezed_year');
             $data['freezed_year']=$freezed_year;
             load_view('freezed/freezed_details', $data);
        }
        else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function check_freedzed_month()
    {
        $result = $this->freezed_model->check_freedzed_month();
        echo $result;
        

    }

    public function get_freez_month()
    {
        $year = trim($this->input->post('year'));
        echo $current_month = date('F');
        $result = $this->freezed_model->get_freezed_month($year);
        $table = ' ';
        $flag=0;
        for ($m=1; $m<=12; $m++) {
            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
            $key =  array_search($month, array_column($result, 'month'));
           
            if(array_search($month, array_column($result, 'month'))!== False) {
                $rowmont =  $result[$key]['month'];
                $added_on =  $result[$key]['added_on'];
                $button = '';
                $button2 = '<a href="'.base_url('index.php/export/generate_sales_summary_report/'.$m.'/'.$year).'"><span class="fa fa-download"></span></a>';
            }
            else
            {
                $button = "<input type='button' class='btn btn-success freezed' value='Freeze' data-attr='$month' >";
                $added_on = '';
                $button2 = '';
            }

            if($year==date('Y') && $current_month==$month)
            {
                $flag = 1;
            }

            if($flag==0)
            {
                if($added_on!="") $added_on = date("d-m-Y H:i:s",strtotime($added_on));

                $table.= "<tr>
                            <td style='text-align:center;vertical-align: middle;'>".$m."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$month."</td>  
                            <td style='text-align:center;vertical-align: middle;'>".$added_on."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$button."</td>
                            <td style='text-align:center;vertical-align: middle;'>".$button2."</td>
                        </tr>";
            }
       
         }

        echo $table;
        
    }

    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

}
?>