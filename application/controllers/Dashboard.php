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
        $this->load->model('task_model');
		// $this->load->library('session');
    }

    //index function
    public function index(){
        $role_id=$this->session->userdata('role_id');
        
        if($role_id==10){
            redirect(base_url().'index.php/Dashboard/production');
        } else {
            $result=$this->dashboard_model->get_access();
            // echo json_encode($result);
            // $data = [];

            if(count($result)>0) {
                $data['total_sale']=$this->dashboard_model->get_total_sale();
                $data['total_dist']=$this->dashboard_model->get_total_distributor();
                $data['total_stock']=$this->dashboard_model->get_total_stock();
                $data['total_receivable']=$this->dashboard_model->get_total_receivable();

                // echo json_encode($data);

                load_view('dashboard/dashboard_new', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        }
    }

    public function dashboardscreen(){
        $role_id=$this->session->userdata('role_id');

        if($role_id==10){
            redirect(base_url().'index.php/Dashboard/production');
        } else {
            load_view_without_data('dashboard/dashboard_screen');
        }
    }
	
    public function production(){
        $curusr=$this->session->userdata('session_id');
        $data['pre_production']=$this->dashboard_model->get_notifications('Pre Production');
        $data['post_production']=$this->dashboard_model->get_notifications('Post Production');
        $data['po_count']=$this->dashboard_model->get_po_count();
        $data['tasklist']=$this->task_model->getTaskList($curusr, 'pending', 'dashboard');
        load_view('dashboard/production', $data);
    }

    public function stock_entry(){
        load_view_without_data('dashboard/stock_entry1');
    }

    public function stock_entry1(){
        load_view_without_data('dashboard/stock_entry');
    }

    // public function stock(){
    //     $data['raw_material_details']=$this->dashboard_model->get_raw_material_stock();
    //     // $data['product_details']=$this->dashboard_model->get_product_stock();
    //     // $data['box_details']=$this->dashboard_model->get_box_stock();

    //     $data['product_details']=$this->dashboard_model->get_total_product_stock();
        
    //     $data['product_details_for_distributor']=$this->dashboard_model->get_product_stock_for_distributor();
    //     $data['box_details_for_distributor']=$this->dashboard_model->get_box_stock_for_distributor();

    //     load_view('dashboard/dashboard', $data);
    // }

    public function stock(){
        // $data['raw_material_details']=$this->dashboard_model->get_raw_material_stock();
        $data['product_details1']=$this->dashboard_model->get_product_stock();
        $data['box_details']=$this->dashboard_model->get_box_stock();

        // $data['product_details']=$this->dashboard_model->get_total_product_stock();

        $stock_details = $this->dashboard_model->get_total_product_stock();

        $j=0;
        $k=0;
        $l=0;
        $bl_found = false;
        $depot_id = '';
        $product_id = '';
        $prv_depot_id = '';
        $prv_product_id = '';
        $depot = array();
        $product = array();
        $depot_name = array();
        $product_name = array();
        $product_details = array();
        for($i=0;$i<count($stock_details);$i++){
            $depot_id = $stock_details[$i]->depot_id;
            if($depot_id!=$prv_depot_id){
                $depot[$j] = $depot_id;
                $depot_name[$j] = $stock_details[$i]->depot_name;
                $prv_depot_id = $depot_id;
                $j = $j + 1;
            }

            $product_id = $stock_details[$i]->product_id;
            $bl_found = false;
            for($l=0;$l<count($product);$l++){
                if($product[$l]==$product_id){
                    $bl_found = true;
                }
            }
            if($bl_found == false){
                $product[$k] = $product_id;
                $product_name[$k] = $stock_details[$i]->short_name;
                $k = $k + 1;
            }
            // if($product_id!=$prv_product_id){
            //     $product[$k] = $product_id;
            //     $product_name[$k] = $stock_details[$i]->short_name;
            //     $prv_product_id = $product_id;
            //     $k = $k + 1;
            // }
        }

        for($i=0;$i<count($depot);$i++){
            for($j=0;$j<count($product);$j++){
                $product_details[$depot[$i]][$product[$j]] = 0;
            }
        }

        for($i=0;$i<count($stock_details);$i++){
            $product_details[$stock_details[$i]->depot_id][$stock_details[$i]->product_id] = $stock_details[$i]->total_bars;
        }

        $data['depot']=$depot;
        $data['product']=$product;
        $data['depot_name']=$depot_name;
        $data['product_name']=$product_name;
        $data['product_details']=$product_details;
      


        // $stock_details=$this->dashboard_model->get_product_stock_for_distributor();
        // $j=0;
        // $k=0;
        // $l=0;
        // $bl_found = false;
        // $distributor_id = '';
        // $product_id = '';
        // $prv_distributor_id = '';
        // $prv_product_id = '';
        // $distributor = array();
        // $product = array();
        // $distributor_name = array();
        // $product_name = array();
        // $product_details = array();
        // for($i=0;$i<count($stock_details);$i++){
        //     $distributor_id = $stock_details[$i]->distributor_id;
        //     if($distributor_id!=$prv_distributor_id){
        //         $distributor[$j] = $distributor_id;
        //         $distributor_name[$j] = $stock_details[$i]->distributor_name;
        //         $prv_distributor_id = $distributor_id;
        //         $j = $j + 1;
        //     }

        //     $product_id = $stock_details[$i]->product_id;
        //     $bl_found = false;
        //     for($l=0;$l<count($product);$l++){
        //         if($product[$l]==$product_id){
        //             $bl_found = true;
        //         }
        //     }
        //     if($bl_found == false){
        //         $product[$k] = $product_id;
        //         $product_name[$k] = $stock_details[$i]->short_name;
        //         $k = $k + 1;
        //     }
        //     // if($product_id!=$prv_product_id){
        //     //     $product[$k] = $product_id;
        //     //     $product_name[$k] = $stock_details[$i]->short_name;
        //     //     $prv_product_id = $product_id;
        //     //     $k = $k + 1;
        //     // }
        // }

        // for($i=0;$i<count($distributor);$i++){
        //     for($j=0;$j<count($product);$j++){
        //         $product_details[$distributor[$i]][$product[$j]] = 0;
        //     }
        // }

        // for($i=0;$i<count($stock_details);$i++){
        //     $product_details[$stock_details[$i]->distributor_id][$stock_details[$i]->product_id] = $stock_details[$i]->bal_qty;
        // }

        // $data['ss_distributor']=$distributor;
        // $data['ss_product']=$product;
        // $data['ss_distributor_name']=$distributor_name;
        // $data['ss_product_name']=$product_name;
        // $data['ss_product_details']=$product_details;



        // $stock_details=$this->dashboard_model->get_box_stock_for_distributor();
        // $j=0;
        // $k=0;
        // $l=0;
        // $bl_found = false;
        // $distributor_id = '';
        // $box_id = '';
        // $prv_distributor_id = '';
        // $prv_box_id = '';
        // $distributor = array();
        // $product = array();
        // $distributor_name = array();
        // $product_name = array();
        // $product_details = array();
        // for($i=0;$i<count($stock_details);$i++){
        //     $distributor_id = $stock_details[$i]->distributor_id;
        //     if($distributor_id!=$prv_distributor_id){
        //         $distributor[$j] = $distributor_id;
        //         $distributor_name[$j] = $stock_details[$i]->distributor_name;
        //         $prv_distributor_id = $distributor_id;
        //         $j = $j + 1;
        //     }

        //     // $box_id = $stock_details[$i]->box_id;
        //     // $bl_found = false;
        //     // for($l=0;$l<count($product);$l++){
        //     //     if($product[$l]==$box_id){
        //     //         $bl_found = true;
        //     //     }
        //     // }
        //     $short_name = $stock_details[$i]->short_name;
        //     $bl_found = false;
        //     for($l=0;$l<count($product);$l++){
        //         if($product[$l]==$short_name){
        //             $bl_found = true;
        //         }
        //     }
        //     if($bl_found == false){
        //         $product[$k] = $short_name;
        //         $product_name[$k] = $stock_details[$i]->short_name;
        //         $k = $k + 1;
        //     }
        //     // if($box_id!=$prv_box_id){
        //     //     $product[$k] = $box_id;
        //     //     $product_name[$k] = $stock_details[$i]->short_name;
        //     //     $prv_box_id = $box_id;
        //     //     $k = $k + 1;
        //     // }
        // }

        // for($i=0;$i<count($distributor);$i++){
        //     for($j=0;$j<count($product);$j++){
        //         $product_details[$distributor[$i]][$product[$j]] = 0;
        //     }
        // }

        // for($i=0;$i<count($stock_details);$i++){
        //     $product_details[$stock_details[$i]->distributor_id][$stock_details[$i]->short_name] = $stock_details[$i]->bal_qty;
        // }

        // $data['ss_box_distributor']=$distributor;
        // $data['ss_box']=$product;
        // $data['ss_box_distributor_name']=$distributor_name;
        // $data['ss_box_name']=$product_name;
        // $data['ss_box_details']=$product_details;

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