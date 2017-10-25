<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard extends CI_Controller
{
    public function __construct(){
        parent::__construct();
      
        $this->load->helper('common_functions');
        $this->load->model('dashboard_model');
		
    }

    //index function
    public function index(){
        $result=$this->dashboard_model->get_access();
        if(count($result)>0) {
            $data['total_sale']=$this->dashboard_model->get_total_sale();
            $data['total_dist']=$this->dashboard_model->get_total_distributor();
            $data['total_stock']=$this->dashboard_model->get_total_stock();
            $data['total_receivable']=$this->dashboard_model->get_total_receivable();

            load_view('dashboard/dashboard_new', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function stock(){
        $data['raw_material_details']=$this->dashboard_model->get_raw_material_stock();
        $data['product_details']=$this->dashboard_model->get_product_stock();
        $data['box_details']=$this->dashboard_model->get_box_stock();
        $data['product_details_for_distributor']=$this->dashboard_model->get_product_stock_for_distributor();
        $data['box_details_for_distributor']=$this->dashboard_model->get_box_stock_for_distributor();

        load_view('dashboard/dashboard', $data);
    }

    public function get_sales_trend_in_rs() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        
        $data = $this->dashboard_model->get_sales_trend_in_rs($from_date, $to_date);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $json_data[$i][0]=$data[$i]->date_of_processing;
            $json_data[$i][1]=$data[$i]->total_amount;
        }
        
        echo json_encode($json_data);
    }

    public function get_avg_day_sale_in_rs() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        
        $data = $this->dashboard_model->get_avg_day_sale_in_rs($from_date, $to_date);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $json_data[$i][0]=$data[$i]->date_of_processing;
            $json_data[$i][1]=$data[$i]->total_amount;
        }
        
        echo json_encode($json_data);
    }

    public function get_avg_total_sale_in_rs() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        
        $data = $this->dashboard_model->get_avg_total_sale_in_rs($from_date, $to_date);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $json_data[$i][0]=$data[$i]->date_of_processing;
            $json_data[$i][1]=$data[$i]->total_amount;
        }
        
        echo json_encode($json_data);
    }

    public function get_sales_trend() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        $type = html_escape($this->input->post('type'));
        
        $data = $this->dashboard_model->get_sales_trend($from_date, $to_date, $type);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $json_data[$i][0]=$data[$i]->date_of_processing;
            $json_data[$i][1]=$data[$i]->total_qty;
        }
        
        echo json_encode($json_data);
    }

    public function get_avg_day_sale() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        $type = html_escape($this->input->post('type'));
        
        $data = $this->dashboard_model->get_avg_day_sale($from_date, $to_date, $type);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $json_data[$i][0]=$data[$i]->date_of_processing;
            $json_data[$i][1]=$data[$i]->total_qty;
        }
        
        echo json_encode($json_data);
    }

    public function get_avg_total_sale() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        $type = html_escape($this->input->post('type'));
        
        $data = $this->dashboard_model->get_avg_total_sale($from_date, $to_date, $type);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $json_data[$i][0]=$data[$i]->date_of_processing;
            $json_data[$i][1]=$data[$i]->total_qty;
        }
        
        echo json_encode($json_data);
    }

    public function get_product_wise_sale_in_bar() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        
        $data = $this->dashboard_model->get_product_wise_sale_in_bar($from_date, $to_date);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $product_name=str_replace('E.A.T ', '', $data[$i]->product_name);
            $product_name=str_replace('Anytime ', '', $product_name);
            $json_data[$i][0]=$product_name;
            $json_data[$i][1]=$data[$i]->total_qty;
        }
        
        echo json_encode($json_data);
    }

    public function get_product_wise_sale_in_box() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        
        $data = $this->dashboard_model->get_product_wise_sale_in_box($from_date, $to_date);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $box_name=str_replace('E.A.T ', '', $data[$i]->box_name);
            $box_name=str_replace('Anytime ', '', $box_name);
            $json_data[$i][0]=$box_name;
            $json_data[$i][1]=$data[$i]->total_qty;
        }
        
        echo json_encode($json_data);
    }

    public function get_month_wise_sale_in_box() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));

        // $from_date = '2016-07-15';
        // $to_date = '2016-11-18';

        $json_data = array();
        $box_name = array();

        $data = $this->dashboard_model->get_months($from_date, $to_date);
        for ($i=0;$i<count($data);$i++) {
            $json_data[0][$i]=$data[$i]->month_name;
            $box_name[0]='';
        }

        $i=0;
        $prev_item_id=0;
        $item_id=0;
        $data = $this->dashboard_model->get_month_wise_sale_in_box($from_date, $to_date);
        for ($j=0;$j<count($data);$j++) {
            $item_id=$data[$j]->item_id;

            if($item_id!=''){
                if($item_id!=$prev_item_id){
                    $i=$i+1;
                    $prev_item_id=$item_id;
                    for($a=0; $a<count($json_data[0]); $a++){
                        $json_data[$i][$a]=0;
                        $box_name[$i]='';
                    }
                }

                for($a=0; $a<count($json_data[0]); $a++){
                    if($json_data[0][$a]==$data[$j]->month_name){
                        if(isset($data[$j]->total_qty)){
                            $product_name=str_replace('E.A.T ', '', $data[$j]->box_name);
                            $product_name=str_replace('Anytime ', '', $product_name);
                            $json_data[$i][$a]=$data[$j]->total_qty;
                            $box_name[$i]=$product_name;
                        } else {
                            $json_data[$i][$a]=0;
                            $box_name[$i]='';
                        }
                    }
                }
            }
        }
        
        $result['json_data']=$json_data;
        $result['box_name']=$box_name;
        echo json_encode($result);
    }

    public function get_month_wise_sale_in_bar() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));

        // $from_date = '2016-11-29';
        // $to_date = '2016-12-28';
        
        $json_data = array();
        $bar_name = array();

        $data = $this->dashboard_model->get_months($from_date, $to_date);
        for ($i=0;$i<count($data);$i++) {
            $json_data[0][$i]=$data[$i]->month_name;
            $bar_name[0]='';
        }

        $i=0;
        $prev_item_id=0;
        $item_id=0;
        $data = $this->dashboard_model->get_month_wise_sale_in_bar($from_date, $to_date);
        
        for ($j=0;$j<count($data);$j++) {
            $item_id=$data[$j]->item_id;

            if($item_id!=''){
                if($item_id=='' || $item_id!=$prev_item_id){
                    $i=$i+1;
                    $prev_item_id=$item_id;
                    for($a=0; $a<count($json_data[0]); $a++){
                        $json_data[$i][$a]=0;
                        $bar_name[$i]='';
                    }
                }

                for($a=0; $a<count($json_data[0]); $a++){
                    if($json_data[0][$a]==$data[$j]->month_name){
                        if(isset($data[$j]->total_qty)){
                            $product_name=str_replace('E.A.T ', '', $data[$j]->product_name);
                            $product_name=str_replace('Anytime ', '', $product_name);
                            $json_data[$i][$a]=$data[$j]->total_qty;
                            $bar_name[$i]=$product_name;
                        } else {
                            $json_data[$i][$a]=0;
                            $bar_name[$i]='';
                        }
                    }
                }
            }
        }
        
        $result['json_data']=$json_data;
        $result['bar_name']=$bar_name;
        echo json_encode($result);
    }
    
    public function get_sm_wise_sale_in_bar() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        
        $data = $this->dashboard_model->get_sm_wise_sale_in_bar($from_date, $to_date);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $json_data[$i][0]=$data[$i]->sales_rep_name;
            $json_data[$i][1]=$data[$i]->total_qty;
        }
        
        echo json_encode($json_data);
    }

    public function get_gt_month_wise_sale_in_bar() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));

        // $from_date = '2016-11-29';
        // $to_date = '2017-01-05';
        
        $json_data = array();
        $distributor_name = array();

        $data = $this->dashboard_model->get_months($from_date, $to_date);
        for ($i=0;$i<count($data);$i++) {
            $json_data[0][$i]=$data[$i]->month_name;
            $distributor_name[0]='';
        }

        $i=0;
        $prev_item_id=0;
        $item_id=0;
        $data = $this->dashboard_model->get_gt_month_wise_sale_in_bar($from_date, $to_date);
        for ($j=0;$j<count($data);$j++) {
            $item_id=$data[$j]->distributor_id;
            
            if($item_id!='' && $item_id!='0'){
                if($item_id=='' || $item_id!=$prev_item_id){
                    $i=$i+1;
                    $prev_item_id=$item_id;
                    for($a=0; $a<count($json_data[0]); $a++){
                        $json_data[$i][$a]=0;
                        $distributor_name[$i]='';
                    }
                }

                for($a=0; $a<count($json_data[0]); $a++){
                    if($json_data[0][$a]==$data[$j]->month_name){
                        if(isset($data[$j]->total_qty)){
                            $json_data[$i][$a]=$data[$j]->total_qty;
                            $distributor_name[$i]=$data[$j]->distributor_name;
                        } else {
                            $json_data[$i][$a]=0;
                            $distributor_name[$i]='';
                        }
                    }
                }
            }
        }

        $result['json_data']=$json_data;
        $result['distributor_name']=$distributor_name;
        echo json_encode($result);
    }
    
    public function get_category_wise_sale_in_bar() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));
        
        // $from_date = '2016-07-15';
        // $to_date = '2016-11-15';
        
        $data = $this->dashboard_model->get_category_wise_sale_in_bar($from_date, $to_date);
        
        $json_data = array();
        
        for ($i=0;$i<count($data);$i++) {
            $json_data[$i][0]=$data[$i]->distributor_type;
            $json_data[$i][1]=$data[$i]->total_qty;
        }
        
        echo json_encode($json_data);
    }

    public function get_category_month_wise_sale_in_bar() {
        $from_date = html_escape($this->input->post('from_date'));
        $to_date = html_escape($this->input->post('to_date'));

        // $from_date = '2016-11-29';
        // $to_date = '2017-01-05';
        
        $json_data = array();

        $data = $this->dashboard_model->get_months($from_date, $to_date);
        for ($i=0;$i<count($data);$i++) {
            $json_data[0][$i]=$data[$i]->month_name;
            $type[0]='';
        }

        $i=0;
        $prev_item_id=0;
        $item_id=0;
        $data = $this->dashboard_model->get_category_month_wise_sale_in_bar($from_date, $to_date);
        for ($j=0;$j<count($data);$j++) {
            $item_id=$data[$j]->type_id;
            
            if($item_id!='' && $item_id!='0'){
                if($item_id=='' || $item_id!=$prev_item_id){
                    $i=$i+1;
                    $prev_item_id=$item_id;
                    for($a=0; $a<count($json_data[0]); $a++){
                        $json_data[$i][$a]=0;
                        $type[$i]='';
                    }
                }

                for($a=0; $a<count($json_data[0]); $a++){
                    if($json_data[0][$a]==$data[$j]->month_name){
                        if(isset($data[$j]->total_qty)){
                            $json_data[$i][$a]=$data[$j]->total_qty;
                            $type[$i]=$data[$j]->distributor_type;
                        } else {
                            $json_data[$i][$a]=0;
                            $type[$i]='';
                        }
                    }
                }
            }
        }

        $result['json_data']=$json_data;
        $result['type']=$type;
        echo json_encode($result);
    }
    
}
?>