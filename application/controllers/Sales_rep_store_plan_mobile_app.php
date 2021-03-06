<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_store_plan_mobile_app extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('Sales_location_model');
        $this->load->model('Sales_rep_route_plan_model');
        $this->load->model('sales_rep_location_model');
        $this->load->model('sales_rep_distributor_model');    
        $this->load->model('store_model');
        $this->load->model('merchandiser_location_model');
        $this->load->model('sales_rep_model');
        $this->load->model('distributor_sale_model');        
        $this->load->model('box_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    public function checkstatus_api($sales_rep_id="", $frequency="", $temp_date="") {
        // $sales_rep_id = '2';
        // $frequency = 'Friday';
        // $temp_date = '07';

        if($this->input->post('sales_rep_id')){
            $sales_rep_id = urldecode($this->input->post('sales_rep_id'));
        }
        if($this->input->post('frequency')){
            $frequency = urldecode($this->input->post('frequency'));
        }
        if($this->input->post('temp_date')){
            $temp_date = urldecode($this->input->post('temp_date'));
        }

        switch ($frequency) {
            case 'Monday':
                $temp_date = $mon = date('Y-m-d', strtotime('Monday this week'));
                break;
            case 'Tuesday':
                $temp_date = $mon = date('Y-m-d', strtotime('Tuesday this week'));
                break;
            case 'Wednesday':
                $temp_date = $mon = date('Y-m-d', strtotime('Wednesday this week'));
                break;  
            case 'Thursday':
                $temp_date = $mon = date('Y-m-d', strtotime('Thursday this week'));
                break;  
            case 'Friday':
                $temp_date = $mon = date('Y-m-d', strtotime('Friday this week'));
                break;
            case 'Saturday':
                $temp_date = $mon = date('Y-m-d', strtotime('Saturday this week'));
                break;
            case 'Sunday':
                $temp_date = $mon = date('Y-m-d', strtotime('Sunday this week'));
                break; 
            default:
                case $frequency:
                $temp_date = $mon = date('Y-m-d', strtotime($frequency.' this week'));
                break;
        }

        $day = $frequency;
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day, $m, $year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }

        $data['reporting_manager_id']='';
        $data['distributor_id_og']='';
        $data['beat_id_og']='';
        $data['distributor_id']='';
        $data['beat_id']='';
        $data['beat_status']='Approved';
        $data['distributor_name']='';
        $data['beat_name']='';

        if($day==date('l')){
            $data['beat_details'] = $this->Sales_location_model->get_new_beat_details($sales_rep_id);
            if(count($data['beat_details'])>0){
                $data['reporting_manager_id']=$data['beat_details'][0]->reporting_manager_id;

                $beat_status = $data['beat_details'][0]->status;
                if(strtoupper(trim($beat_status))=="PENDING" || strtoupper(trim($beat_status))=="REJECTED"){
                    $data['distributor_id_og']=$data['beat_details'][0]->dist_id1;
                    $data['beat_id_og']=$data['beat_details'][0]->beat_id1;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name1;
                    $data['beat_name']=$data['beat_details'][0]->beat_name1;
                } else {
                    $data['distributor_id_og']=$data['beat_details'][0]->dist_id2;
                    $data['beat_id_og']=$data['beat_details'][0]->beat_id2;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name2;
                    $data['beat_name']=$data['beat_details'][0]->beat_name2;
                }
                
                if(strtoupper(trim($beat_status))=="PENDING"){
                    $data['distributor_id']=$data['beat_details'][0]->dist_id2;
                    $data['beat_id']=$data['beat_details'][0]->beat_id2;
                } else {
                    $data['distributor_id']=$data['beat_details'][0]->dist_id1;
                    $data['beat_id']=$data['beat_details'][0]->beat_id1;
                }
                
                if(strtoupper(trim($beat_status))=="REJECTED"){
                    $data['beat_status']="Approved";
                } else {
                    $data['beat_status']=$data['beat_details'][0]->status;
                }
            }
        }
        
        // echo $data['distributor_name'];
        // echo '<br/>';

        if($data['distributor_id']=="") {
            $data['beat_details'] = $this->Sales_location_model->get_beat_details($day, $sales_rep_id);
            if(count($data['beat_details'])>0){
                $data['reporting_manager_id']=$data['beat_details'][0]->reporting_manager_id;

                if($frequency == 'Alternate '.$day){
                    $data['distributor_id_og']=$data['beat_details'][0]->alternate_dist;
                    $data['beat_id_og']=$data['beat_details'][0]->alternate_beat;
                    $data['distributor_id']=$data['beat_details'][0]->alternate_dist;
                    $data['beat_id']=$data['beat_details'][0]->alternate_beat;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name2;
                    $data['beat_name']=$data['beat_details'][0]->beat_name2;
                } else {
                    $data['distributor_id_og']=$data['beat_details'][0]->every_dist;
                    $data['beat_id_og']=$data['beat_details'][0]->every_beat;
                    $data['distributor_id']=$data['beat_details'][0]->every_dist;
                    $data['beat_id']=$data['beat_details'][0]->every_beat;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name1;
                    $data['beat_name']=$data['beat_details'][0]->beat_name1;
                }
            }
        }

        $data['data']=$this->Sales_location_model->get_data('Approved', '', $frequency, $temp_date, $sales_rep_id);
        $data['merchendizer']=$this->Sales_location_model->get_merchendiser_data('Approved', '', $frequency, $temp_date, $sales_rep_id);
        $data['mt_followup']=$this->Sales_location_model->get_mtfollowup('', $temp_date, $sales_rep_id);
        $data['gt_followup']=$this->Sales_location_model->get_gtfollowup('', $temp_date, $sales_rep_id);
        $data['checkstatus'] = $frequency;
        $data['temp_date'] = $temp_date;
        $data['current_day'] = date('l');

        echo json_encode($data);
    }
    
    public function checkstatus_api2($sales_rep_id="", $frequency="", $temp_date="") {
        // $sales_rep_id = '2';
        // $frequency = 'Monday';
        // $temp_date = '06';

        if($this->input->post('sales_rep_id')){
            $sales_rep_id = urldecode($this->input->post('sales_rep_id'));
        }
        if($this->input->post('frequency')){
            $frequency = urldecode($this->input->post('frequency'));
        }
        if($this->input->post('temp_date')){
            $temp_date = urldecode($this->input->post('temp_date'));
        }

        switch ($frequency) {
            case 'Monday':
                $temp_date = $mon = date('Y-m-d', strtotime('Monday this week'));
                break;
            case 'Tuesday':
                $temp_date = $mon = date('Y-m-d', strtotime('Tuesday this week'));
                break;
            case 'Wednesday':
                $temp_date = $mon = date('Y-m-d', strtotime('Wednesday this week'));
                break;  
            case 'Thursday':
                $temp_date = $mon = date('Y-m-d', strtotime('Thursday this week'));
                break;  
            case 'Friday':
                $temp_date = $mon = date('Y-m-d', strtotime('Friday this week'));
                break;
            case 'Saturday':
                $temp_date = $mon = date('Y-m-d', strtotime('Saturday this week'));
                break; 
            case 'Sunday':
                $temp_date = $mon = date('Y-m-d', strtotime('Sunday this week'));
                break; 
            default:
                case $frequency:
                $temp_date = $mon = date('Y-m-d', strtotime($frequency.' this week'));
                break;
        }

        $day = $frequency;
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day, $m, $year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }

        $data['reporting_manager_id']='';
        $data['distributor_id_og']='';
        $data['beat_id_og']='';
        $data['distributor_id']='';
        $data['beat_id']='';
        $data['beat_status']='Approved';
        $data['distributor_name']='';
        $data['beat_name']='';

        if($day==date('l')){
            $data['beat_details'] = $this->Sales_location_model->get_new_beat_details($sales_rep_id);
            if(count($data['beat_details'])>0){
                $data['reporting_manager_id']=$data['beat_details'][0]->reporting_manager_id;

                $beat_status = $data['beat_details'][0]->status;
                if(strtoupper(trim($beat_status))=="PENDING"){
                    $data['distributor_id_og']=$data['beat_details'][0]->dist_id1;
                    $data['beat_id_og']=$data['beat_details'][0]->beat_id1;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name1;
                    $data['beat_name']=$data['beat_details'][0]->beat_name1;
                } else {
                    $data['distributor_id_og']=$data['beat_details'][0]->dist_id2;
                    $data['beat_id_og']=$data['beat_details'][0]->beat_id2;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name2;
                    $data['beat_name']=$data['beat_details'][0]->beat_name2;
                }
                
                $data['distributor_id']=$data['beat_details'][0]->dist_id2;
                $data['beat_id']=$data['beat_details'][0]->beat_id2;
                $data['beat_status']=$data['beat_details'][0]->status;
            }
        }
        
        // echo $data['distributor_name'];
        // echo '<br/>';

        if($data['distributor_id']=="") {
            $data['beat_details'] = $this->Sales_location_model->get_beat_details($day, $sales_rep_id);
            if(count($data['beat_details'])>0){
                $data['reporting_manager_id']=$data['beat_details'][0]->reporting_manager_id;

                if($frequency == 'Alternate '.$day){
                    $data['distributor_id_og']=$data['beat_details'][0]->alternate_dist;
                    $data['beat_id_og']=$data['beat_details'][0]->alternate_beat;
                    $data['distributor_id']=$data['beat_details'][0]->alternate_dist;
                    $data['beat_id']=$data['beat_details'][0]->alternate_beat;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name2;
                    $data['beat_name']=$data['beat_details'][0]->beat_name2;
                } else {
                    $data['distributor_id_og']=$data['beat_details'][0]->every_dist;
                    $data['beat_id_og']=$data['beat_details'][0]->every_beat;
                    $data['distributor_id']=$data['beat_details'][0]->every_dist;
                    $data['beat_id']=$data['beat_details'][0]->every_beat;
                    $data['distributor_name']=$data['beat_details'][0]->distributor_name1;
                    $data['beat_name']=$data['beat_details'][0]->beat_name1;
                }
            }
        }

        $data['data']=$this->Sales_location_model->get_data('Approved', '', $frequency, $temp_date, $sales_rep_id);
        $data['merchendizer']=$this->Sales_location_model->get_merchendiser_data('Approved', '', $frequency, $temp_date, $sales_rep_id);
        $data['mt_followup']=$this->Sales_location_model->get_mtfollowup('', $temp_date, $sales_rep_id);
        $data['gt_followup']=$this->Sales_location_model->get_gtfollowup('', $temp_date, $sales_rep_id);
        $data['checkstatus'] = $frequency;
        $data['temp_date'] = $temp_date;
        $data['current_day'] = date('l');

        return $data;
    }
    
    public function add_api() {
        $id = '';
        $get_channel_type = '';
        $follow_type = '';
        $sales_rep_id = '';
        $distributor_id = '';
        $beat_id = '';

        if($this->input->post('id')) {
            $id = urldecode($this->input->post('id'));
        }
        if($this->input->post('get_channel_type')) {
            $get_channel_type = urldecode($this->input->post('get_channel_type'));
        }
        if($this->input->post('follow_type')) {
            $follow_type = urldecode($this->input->post('follow_type'));
        }
        if($this->input->post('sales_rep_id')) {
            $sales_rep_id = urldecode($this->input->post('sales_rep_id'));
        }
        if($this->input->post('distributor_id')) {
            $distributor_id = urldecode($this->input->post('distributor_id'));
        }
        if($this->input->post('beat_id')) {
            $beat_id = urldecode($this->input->post('beat_id'));
        }

        // $id = '6424';
        // $get_channel_type = 'GT';
        // $follow_type = '';
        // $sales_rep_id = '40';
        // $distributor_id = '1298';
        // $beat_id = '2';
        
        // $id = '2753';
        // $get_channel_type = 'GT';
        // $follow_type = '';
        // $sales_rep_id = '2';
        // $distributor_id = '1298';
        // $beat_id = '1';

        // $id = '2924';
        // $get_channel_type = 'MT';
        // $follow_type = '';
        // $sales_rep_id = '2';
        // $distributor_id = '1298';
        // $beat_id = '1';

        // $id = '12341';
        // $get_channel_type = 'GT';
        // $follow_type = 'gt_followup';
        // $sales_rep_id = '2';
        // $distributor_id = '1298';
        // $beat_id = '1';

        $day =  date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }



        // $data['distributor'] = $this->sales_rep_distributor_model->get_data2();

        // if($this->session->userdata('temp_stock_details')!=null) {
        //     if($follow_type!='') {
        //         if($follow_type=='gt_followup') {
        //             $result=$this->Sales_location_model->get_gtfollowup($id, '', $sales_rep_id);
        //             $data['data'] = $result;
        //         } else {
        //             $result=$this->Sales_location_model->get_mtfollowup($id, '', $sales_rep_id);
        //             $data['data'] = $result;
        //         }
        //     }

        //     $data['stock_detail']=$this->session->userdata('temp_stock_details');
        // } else {
            if($follow_type!='') {
                if($follow_type=='gt_followup') {
                    $result=$this->Sales_location_model->get_gtfollowup($id, '', $sales_rep_id);
                    $data['data'] = $result;
                    $sales_loc_id = $result[0]->id;
                    if($sales_loc_id!=NULL) {
                        $sql = "select id as stock_id ,sales_rep_loc_id, case when orange_bar is not null and orange_bar!=0 then concat(orange_bar,'_Bar') end as orange_bar,
                                    case When orange_box IS NOT NULL and orange_box!=0 Then concat(orange_box,'_Box') end as orange_box,
                                    case When mint_bar IS NOT NULL and mint_bar!=0 Then concat(mint_bar,'_Bar') end as mint_bar,
                                    case When mint_box IS NOT NULL and mint_box!=0 Then concat(mint_box,'_Box') end as mint_box,
                                    case When butterscotch_bar IS NOT NULL and butterscotch_bar!=0 Then concat(butterscotch_bar,'_Bar') end as butterscotch_bar,
                                    case When butterscotch_box IS NOT NULL and butterscotch_box!=0 Then concat(butterscotch_box,'_Box') ELSE CONCAT(butterscotch_box,'_Box') end as butterscotch_box,
                                    case When chocopeanut_bar IS NOT NULL and chocopeanut_bar!=0 Then concat(chocopeanut_bar,'_Bar') end as chocopeanut_bar,
                                    case When chocopeanut_box IS NOT NULL and chocopeanut_box!=0 Then concat(chocopeanut_box,'_Box') end as chocopeanut_box,
                                    case When bambaiyachaat_bar IS NOT NULL and bambaiyachaat_bar!=0 Then concat(bambaiyachaat_bar,'_Bar') end as bambaiyachaat_bar,
                                    case When bambaiyachaat_box IS NOT NULL and bambaiyachaat_box!=0 Then concat(bambaiyachaat_box,'_Box')  end as bambaiyachaat_box,
                                    case When mangoginger_bar IS NOT NULL and mangoginger_bar!=0 Then concat(mangoginger_bar,'_Bar')  end as mangoginger_bar,
                                    case When mangoginger_box IS NOT NULL and mangoginger_box!=0 Then concat(mangoginger_box,'_Box') end as mangoginger_box,
                                    case When berry_blast_bar IS NOT NULL and berry_blast_bar!=0 Then concat(berry_blast_bar,'_Bar') end as berry_blast_bar,
                                    case When berry_blast_box IS NOT NULL and berry_blast_box!=0 Then concat(berry_blast_box,'_Box')end as berry_blast_box,
                                    case When chyawanprash_bar IS NOT NULL and chyawanprash_bar!=0 Then concat(chyawanprash_bar,'_Bar') end as chyawanprash_bar,
                                    case When chyawanprash_box IS NOT NULL and chyawanprash_box!=0 Then concat(chyawanprash_box,'_Box') end as chyawanprash_box,
                                    chocolate_cookies_box, cranberry_orange_box, dark_chocolate_cookies_box, fig_raisins_box, papaya_pineapple_box, variety_box, 
                                    cranberry_cookies_box, sales_rep_loc_id 
                                from sales_rep_distributor_opening_stock Where sales_rep_loc_id='$sales_loc_id'";
                        $result = $this->db->query($sql)->result_array();
                        $data['stock_detail']=$result[0];

                        $data['data1'] = $this->sales_rep_location_model->get_data_qty('', $sales_loc_id);
                    }
                } else {
                    $result=$this->Sales_location_model->get_mtfollowup($id, '', $sales_rep_id);
                    $data['data'] = $result;
                    $sales_loc_id = $result[0]->merchandiser_stock_id;
                    if($sales_loc_id!=NULL) {
                        $sql = "select A.id as stock_id, merchandiser_stock_id as visit_id, 
                                    Case When type='Box' Then box_name ELSE product_name end as product_name, 
                                    Case When type='Bar' Then CONCAT(qty,'_Bar') ELSE CONCAT(qty,'_Box') end as qty, 
                                    item_id, type, qty as qty1 from 
                                (select * from merchandiser_stock_details where merchandiser_stock_id='$sales_loc_id') A 
                                left join 
                                (select * from box_master) B on (A.item_id=B.id) 
                                left join 
                                (select * from product_master) C on (A.item_id=C.id)";
                        $result = $this->db->query($sql)->result_array();

                        $stock_detail = array();
                        $data1_obj = array();
                        if(count($result)>0) {
                            for ($j=0; $j <count($result) ; $j++) {
                                if ($result[$j]['item_id']==37) {
                                    $stock_detail['chocolate_cookies_box']=$result[$j]['qty'];
                                    $data1_obj['chocolate_cookies_box']=$result[$j]['qty1'];
                                }
                                if ($result[$j]['item_id']==38) {
                                    $stock_detail['dark_chocolate_cookies_box']=$result[$j]['qty'];
                                    $data1_obj['dark_chocolate_cookies_box']=$result[$j]['qty1'];
                                }
                                if ($result[$j]['item_id']==39) {
                                    $stock_detail['cranberry_cookies_box']=$result[$j]['qty'];
                                    $data1_obj['cranberry_cookies_box']=$result[$j]['qty1'];
                                }
                                if ($result[$j]['item_id']==42) {
                                    $stock_detail['cranberry_orange_box']=$result[$j]['qty'];
                                    $data1_obj['cranberry_orange_box']=$result[$j]['qty1'];
                                }
                                if ($result[$j]['item_id']==41) {
                                    $stock_detail['fig_raisins_box']=$result[$j]['qty'];
                                    $data1_obj['fig_raisins_box']=$result[$j]['qty1'];
                                }
                                if ($result[$j]['item_id']==40) {
                                    $stock_detail['papaya_pineapple_box']=$result[$j]['qty'];
                                    $data1_obj['papaya_pineapple_box']=$result[$j]['qty1'];
                                }
                                if($result[$j]['item_id']==1 && $result[$j]['type']=='Bar') {
                                    $stock_detail['orange_bar']=$result[$j]['qty'];
                                    $data1_obj['orange_bar']=$result[$j]['qty1'];
                                }
                                if($result[$j]['item_id']==1 && $result[$j]['type']=='Box') {
                                    $stock_detail['orange_box']=$result[$j]['qty'];
                                    $data1_obj['orange_box']=$result[$j]['qty1'];
                                }
                                if($result[$j]['item_id']==3 && $result[$j]['type']=='Bar') {
                                    $stock_detail['butterscotch_bar']=$result[$j]['qty'];
                                    $data1_obj['butterscotch_bar']=$result[$j]['qty1'];
                                }
                                if($result[$j]['item_id']==3 && $result[$j]['type']=='Box') {
                                    $stock_detail['butterscotch_box']=$result[$j]['qty'];
                                    $data1_obj['butterscotch_box']=$result[$j]['qty1'];
                                }

                                /*if($result[$j]['item_id']==9 && $result[$j]['type']=='Box') {
                                    $stock_detail['butterscotch']=$result[$j]['qty'];
                                } else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar') {
                                    $stock_detail['butterscotch']=$result[$j]['qty'];
                                }*/

                                if($result[$j]['item_id']==9 && $result[$j]['type']=='Box') {
                                    $stock_detail['chocopeanut_box']=$result[$j]['qty'];
                                    $data1_obj['chocopeanut_box']=$result[$j]['qty1'];
                                }
                                
                                if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar') {
                                    $stock_detail['chocopeanut_bar']=$result[$j]['qty'];
                                    $data1_obj['chocopeanut_bar']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==8 && $result[$j]['type']=='Box') {
                                    $stock_detail['bambaiyachaat_box']=$result[$j]['qty'];
                                    $data1_obj['bambaiyachaat_box']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==4 && $result[$j]['type']=='Bar') {
                                    $stock_detail['bambaiyachaat_bar']=$result[$j]['qty'];
                                    $data1_obj['bambaiyachaat_bar']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==12 && $result[$j]['type']=='Box') {
                                    $stock_detail['mangoginger_box']=$result[$j]['qty'];
                                    $data1_obj['mangoginger_box']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==6 && $result[$j]['type']=='Bar') {
                                    $stock_detail['mangoginger_bar']=$result[$j]['qty'];
                                    $data1_obj['mangoginger_bar']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==29 && $result[$j]['type']=='Box') {
                                    $stock_detail['berry_blast_box']=$result[$j]['qty'];
                                    $data1_obj['berry_blast_box']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==9 && $result[$j]['type']=='Bar') {
                                    $stock_detail['berry_blast_bar']=$result[$j]['qty'];
                                    $data1_obj['berry_blast_bar']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==31 && $result[$j]['type']=='Box') {
                                    $stock_detail['chyawanprash_box']=$result[$j]['qty'];
                                    $data1_obj['chyawanprash_box']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==10 && $result[$j]['type']=='Bar') {
                                    $stock_detail['chyawanprash_bar']=$result[$j]['qty'];
                                    $data1_obj['chyawanprash_bar']=$result[$j]['qty1'];
                                }

                                if($result[$j]['item_id']==32 && $result[$j]['type']=='Box') {
                                    $stock_detail['variety_box']=$result[$j]['qty'];
                                    $data1_obj['variety_box']=$result[$j]['qty1'];
                                }
                            }

                            $data['stock_detail'] = $stock_detail;
                            $data['data1'][0] = (object) $data1_obj;
                        }
                    }
                }
            } else {
                if($id!='') {
                    if($get_channel_type=='GT') {
                        $data['data']=$this->Sales_location_model->get_data('Approved', $id, '', '', $sales_rep_id);
                    } else {
                        $data['data']=$this->Sales_location_model->get_merchendiser_data('Approved', $id, '', '', $sales_rep_id);
                    }
                }
            } 
        // }

        // if($get_channel_type=='') {
        //     $channel_type = 'GT';
        // } else {
        //     $channel_type = $get_channel_type;
        // }

        // $data['zone'] = $this->sales_rep_location_model->get_zone('', $channel_type);
        // $data['area'] = $this->sales_rep_location_model->get_area();
        // if($channel_type=='MT') {
        //     $data['location'] = $this->sales_rep_location_model->get_locations('','','',$channel_type);
        // } else {
        //     $data['location'] = $this->sales_rep_location_model->get_locations();
        // }
        // $data['follow_type'] = $follow_type;

        // if($get_channel_type!='') $data['channel_type']=$get_channel_type;

        echo json_encode($data);
    }

    public function get_zone_api() {
        $channel_type='';
        $sales_rep_id='';
        $distributor_id='';
        $beat_id='';

        if($this->input->post('type')){
            $channel_type=urldecode($this->input->post('type'));
        }
        if($this->input->post('sales_rep_id')){
            $sales_rep_id=urldecode($this->input->post('sales_rep_id'));
        }
        if($this->input->post('distributor_id')){
            $distributor_id=urldecode($this->input->post('distributor_id'));
        }
        if($this->input->post('beat_id')){
            $beat_id=urldecode($this->input->post('beat_id'));
        }

        // $channel_type = 'GT';
        // $sales_rep_id = '2';
        // $distributor_id = '1298';
        // $beat_id = '1';

        $result =  $this->sales_rep_location_model->get_zone('', $channel_type);
        echo json_encode($result);
    }

    public function get_area_api() {
        $zone_id='';
        $sales_rep_id='';
        $distributor_id='';
        $beat_id='';

        if($this->input->post('zone_id')){
            $zone_id=urldecode($this->input->post('zone_id'));
        }
        if($this->input->post('sales_rep_id')){
            $sales_rep_id=urldecode($this->input->post('sales_rep_id'));
        }
        if($this->input->post('distributor_id')){
            $distributor_id=urldecode($this->input->post('distributor_id'));
        }
        if($this->input->post('beat_id')){
            $beat_id=urldecode($this->input->post('beat_id'));
        }

        // $zone_id='7';

        $result = $this->sales_rep_location_model->get_area($zone_id);
        echo json_encode($result);
    }

    public function get_store_api(){ 
        $zone_id='';

        if($this->input->post('zone_id')){
            $zone_id=urldecode($this->input->post('zone_id'));
        }

        $data = $this->sales_rep_location_model->get_store($zone_id);
        echo json_encode($data); 
    }

    public function get_locations_api(){ 
        $zone_id='';
        $area_id='';

        if($this->input->post('zone_id')){
            $zone_id=$this->input->post('zone_id');
        }
        if($this->input->post('area_id')){
            $area_id=$this->input->post('area_id');
        }

        $result = $this->sales_rep_location_model->get_locations($zone_id, $area_id);
        echo json_encode($result);
    }
    
    public function get_location_data_api(){ 
        $zone_id='';
        $store_id='';
        $id='';

        if($this->input->post('zone_id')){
            $zone_id=urldecode($this->input->post('zone_id'));
        }
        if($this->input->post('store_id')){
            $store_id=urldecode($this->input->post('store_id'));
        }
        if($this->input->post('id')){
            $id=urldecode($this->input->post('id'));
        }

        $result = $this->sales_rep_location_model->get_location_data($store_id, $zone_id, $id);
        echo json_encode($result);
    }

    public function get_retailer_api(){
        $zone_id='';
        $area_id='';
        $location_id='';
        $dist_type='';

        if($this->input->post('zone_id')){
            $zone_id=$this->input->post('zone_id');
        }
        if($this->input->post('area_id')){
            $area_id=$this->input->post('area_id');
        }
        if($this->input->post('location_id')){
            $location_id=$this->input->post('location_id');
        }
        if($this->input->post('dist_type')){
            $dist_type=$this->input->post('dist_type');
        }

        if($dist_type=='New')
            $result = $this->sales_rep_distributor_model->get_data2('', '', $zone_id, $area_id, $location_id);
        else
            $result = $this->sales_rep_distributor_model->get_data2('Approved', '', $zone_id, $area_id, $location_id);

        echo json_encode($result);
    }

    public function edit_api() {
        $id = '';
        $get_channel_type = '';
        $sales_rep_id = '';
        $distributor_id = '';
        $beat_id = '';
        $temp = '';

        if($this->input->post('id')) {
            $id = urldecode($this->input->post('id'));
        }
        if($this->input->post('get_channel_type')) {
            $get_channel_type = urldecode($this->input->post('get_channel_type'));
        }
        if($this->input->post('sales_rep_id')) {
            $sales_rep_id = urldecode($this->input->post('sales_rep_id'));
        }
        if($this->input->post('distributor_id')) {
            $distributor_id = urldecode($this->input->post('distributor_id'));
        }
        if($this->input->post('beat_id')) {
            $beat_id = urldecode($this->input->post('beat_id'));
        }
        if($this->input->post('temp')) {
            $temp = urldecode($this->input->post('temp'));
        }

        // $data['data1'] = ['id'=>$id, 'get_channel_type'=>$get_channel_type, 'sales_rep_id'=>$sales_rep_id, 'distributor_id'=>$distributor_id, 'beat_id'=>$beat_id, 'temp'=>$temp];

        // $id = '2774';
        // $get_channel_type = 'GT';
        // $sales_rep_id = '2';
        // $distributor_id = '1298';
        // $beat_id = '1';
        // $temp = '';

        // $id = '2750';
        // $get_channel_type = 'GT';
        // $sales_rep_id = '2';
        // $distributor_id = '1298';
        // $beat_id = '1';
        // $temp = '';

        $day =  date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate) {
            $frequency = 'Alternate '.$day;
        } else {
            $frequency = 'Every '.$day;
        }

        if($get_channel_type=='GT') {
            $data['created_on']='';
            $data['created_by']='';
            if($temp!='') {
                $result = $this->sales_rep_location_model->get_data('', $id);
            } else {
                $bit_id = 0;
                $result = $this->Sales_location_model->get_data('Approved', $id, '', '', $sales_rep_id);
                if(count($result)>0) {
                    $bit_id = $result[0]->bit_plan_id;
                }
                
                $get_result = $this->db->query("select created_on,created_by from sales_rep_beat_plan Where id='$bit_id'")->result_array();
                if(count($get_result)>0) {
                    $data['created_on'] = $get_result[0]['created_on'];
                    $data['created_by'] = $get_result[0]['created_by'];
                }
            }

            // echo json_encode($result);
            // echo '<br/><br/>';

            $data['data'] = $result;
            $sales_rep_loc_id = $result[0]->mid;

            // if($this->session->userdata('temp_stock_details')!=null) {
            //     $data['stock_detail']=$this->session->userdata('temp_stock_details');
            // } else {
                $result = $this->db->query("SELECT id as stock_id ,sales_rep_loc_id,
                    case When orange_bar IS NOT NULL and orange_bar!=0 Then CONCAT(orange_bar,'_Bar') else 0 end as orange_bar,
                    case When orange_box IS NOT NULL and orange_box!=0 Then CONCAT(orange_box,'_Box') else 0 end as orange_box,
                    case When mint_bar IS NOT NULL and mint_bar!=0 Then CONCAT(mint_bar,'_Bar') else 0 end as mint_bar,
                    case When mint_box IS NOT NULL and mint_box!=0 Then CONCAT(mint_box,'_Box') else 0 end as mint_box,
                    case When butterscotch_bar IS NOT NULL and butterscotch_bar!=0 Then CONCAT(butterscotch_bar,'_Bar') else 0 end as butterscotch_bar,
                    case When butterscotch_box IS NOT NULL and butterscotch_box!=0 Then CONCAT(butterscotch_box,'_Box') else 0 end as butterscotch_box,
                    case When chocopeanut_bar IS NOT NULL and chocopeanut_bar!=0 Then CONCAT(chocopeanut_bar,'_Bar') else 0 end as chocopeanut_bar,
                    case When chocopeanut_box IS NOT NULL and chocopeanut_box!=0 Then CONCAT(chocopeanut_box,'_Box') else 0 end as chocopeanut_box,
                    case When bambaiyachaat_bar IS NOT NULL and bambaiyachaat_bar!=0 Then CONCAT(bambaiyachaat_bar,'_Bar') else 0 end as bambaiyachaat_bar,
                    case When bambaiyachaat_box IS NOT NULL and bambaiyachaat_box!=0 Then CONCAT(bambaiyachaat_box,'_Box') else 0 end as bambaiyachaat_box,
                    case When mangoginger_bar IS NOT NULL and mangoginger_bar!=0 Then CONCAT(mangoginger_bar,'_Bar') else 0 end as mangoginger_bar,
                    case When mangoginger_box IS NOT NULL and mangoginger_box!=0 Then CONCAT(mangoginger_box,'_Box') else 0 end as mangoginger_box,
                    case When berry_blast_bar IS NOT NULL and berry_blast_bar!=0 Then CONCAT(berry_blast_bar,'_Bar') else 0 end as berry_blast_bar,
                    case When berry_blast_box IS NOT NULL and berry_blast_box!=0 Then CONCAT(berry_blast_box,'_Box') else 0 end as berry_blast_box,
                    case When chyawanprash_bar IS NOT NULL and chyawanprash_bar!=0 Then CONCAT(chyawanprash_bar,'_Bar') else 0 end as chyawanprash_bar, 
                    case When chyawanprash_box IS NOT NULL and chyawanprash_box!=0 Then CONCAT(chyawanprash_box,'_Box') else 0 end as chyawanprash_box, 
                    case When chocolate_cookies_box IS NOT NULL and chocolate_cookies_box!=0 Then chocolate_cookies_box else 0 end as chocolate_cookies_box, 
                    case When cranberry_orange_box IS NOT NULL and cranberry_orange_box!=0 Then cranberry_orange_box else 0 end as cranberry_orange_box, 
                    case When dark_chocolate_cookies_box IS NOT NULL and dark_chocolate_cookies_box!=0 Then dark_chocolate_cookies_box else 0 end as dark_chocolate_cookies_box, 
                    case When fig_raisins_box IS NOT NULL and fig_raisins_box!=0 Then fig_raisins_box else 0 end as fig_raisins_box, 
                    case When papaya_pineapple_box IS NOT NULL and papaya_pineapple_box!=0 Then papaya_pineapple_box else 0 end as papaya_pineapple_box, 
                    case When variety_box IS NOT NULL and variety_box!=0 Then variety_box else 0 end as variety_box, 
                    case When cranberry_cookies_box IS NOT NULL and cranberry_cookies_box!=0 Then cranberry_cookies_box else 0 end as cranberry_cookies_box, sales_rep_loc_id from  sales_rep_distributor_opening_stock 
                    Where sales_rep_loc_id='$sales_rep_loc_id'")->result_array();
                $data['stock_detail']=$result[0];

                $data['data1'] = $this->sales_rep_location_model->get_data_qty('', $data['data'][0]->mid);

                $data['batch_detail'] = $this->sales_rep_location_model->get_batch_qty_details($sales_rep_loc_id, $get_channel_type);
            // }
        } else {
            if($temp!='') {
                $result=$this->sales_rep_location_model->get_mt_data('', $id);
            } else {
                $result=$this->Sales_location_model->get_merchendiser_data('Approved', $id, $frequency, '', $sales_rep_id);
            }

            $data['data'] = $result;
            $merchandiser_stock_id = $result[0]->mid;

            // if($this->session->userdata('temp_stock_details')!=null) {
            //     $data['stock_detail']=$this->session->userdata('temp_stock_details');
            // } else {
                $result = $this->db->query("Select A.id as stock_id ,merchandiser_stock_id as visit_id,
                                Case When type='Box' Then box_name ELSE product_name end as product_name,
                                Case When type='Box' Then CONCAT(ifnull(qty,0),'_Box') ELSE CONCAT(ifnull(qty,0),'_Bar') end as qty,
                                item_id,type,ifnull(qty,0) as qty1 
                                from
                                (SELECT * from merchandiser_stock_details where merchandiser_stock_id='$merchandiser_stock_id') A 
                                Left join 
                                (SELECT * from box_master)B on A.item_id=B.id
                                Left join 
                                (SELECT * from product_master)C on A.item_id=C.id")->result_array();

                $stock_detail = array();
                $data1_obj = array();
                if(count($result)>0) {
                    for ($j=0; $j <count($result) ; $j++) {
                        if ($result[$j]['item_id']==37) {
                            $stock_detail['chocolate_cookies_box']=$result[$j]['qty'];
                            $data1_obj['chocolate_cookies_box']=$result[$j]['qty1'];
                        }
                        if ($result[$j]['item_id']==38) {
                            $stock_detail['dark_chocolate_cookies_box']=$result[$j]['qty'];
                            $data1_obj['dark_chocolate_cookies_box']=$result[$j]['qty1'];
                        }
                        if ($result[$j]['item_id']==39) {
                            $stock_detail['cranberry_cookies_box']=$result[$j]['qty'];
                            $data1_obj['cranberry_cookies_box']=$result[$j]['qty1'];
                        }
                        if ($result[$j]['item_id']==42) {
                            $stock_detail['cranberry_orange_box']=$result[$j]['qty'];
                            $data1_obj['cranberry_orange_box']=$result[$j]['qty1'];
                        }
                        if ($result[$j]['item_id']==41) {
                            $stock_detail['fig_raisins_box']=$result[$j]['qty'];
                            $data1_obj['fig_raisins_box']=$result[$j]['qty1'];
                        }
                        if ($result[$j]['item_id']==40) {
                            $stock_detail['papaya_pineapple_box']=$result[$j]['qty'];
                            $data1_obj['papaya_pineapple_box']=$result[$j]['qty1'];
                        }
                        if($result[$j]['item_id']==1 && $result[$j]['type']=='Bar') {
                            $stock_detail['orange_bar']=$result[$j]['qty'];
                            $data1_obj['orange_bar']=$result[$j]['qty1'];
                        }
                        if($result[$j]['item_id']==1 && $result[$j]['type']=='Box') {
                            $stock_detail['orange_box']=$result[$j]['qty'];
                            $data1_obj['orange_box']=$result[$j]['qty1'];
                        }
                        if($result[$j]['item_id']==3 && $result[$j]['type']=='Bar') {
                            $stock_detail['butterscotch_bar']=$result[$j]['qty'];
                            $data1_obj['butterscotch_bar']=$result[$j]['qty1'];
                        }
                        if($result[$j]['item_id']==3 && $result[$j]['type']=='Box') {
                            $stock_detail['butterscotch_box']=$result[$j]['qty'];
                            $data1_obj['butterscotch_box']=$result[$j]['qty1'];
                        }

                        /*if($result[$j]['item_id']==9 && $result[$j]['type']=='Box') {
                            $stock_detail['butterscotch']=$result[$j]['qty'];
                        } else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar') {
                            $stock_detail['butterscotch']=$result[$j]['qty'];
                        }*/

                        if($result[$j]['item_id']==9 && $result[$j]['type']=='Box') {
                            $stock_detail['chocopeanut_box']=$result[$j]['qty'];
                            $data1_obj['chocopeanut_box']=$result[$j]['qty1'];
                        }
                        
                        if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar') {
                            $stock_detail['chocopeanut_bar']=$result[$j]['qty'];
                            $data1_obj['chocopeanut_bar']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==8 && $result[$j]['type']=='Box') {
                            $stock_detail['bambaiyachaat_box']=$result[$j]['qty'];
                            $data1_obj['bambaiyachaat_box']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==4 && $result[$j]['type']=='Bar') {
                            $stock_detail['bambaiyachaat_bar']=$result[$j]['qty'];
                            $data1_obj['bambaiyachaat_bar']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==12 && $result[$j]['type']=='Box') {
                            $stock_detail['mangoginger_box']=$result[$j]['qty'];
                            $data1_obj['mangoginger_box']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==6 && $result[$j]['type']=='Bar') {
                            $stock_detail['mangoginger_bar']=$result[$j]['qty'];
                            $data1_obj['mangoginger_bar']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==29 && $result[$j]['type']=='Box') {
                            $stock_detail['berry_blast_box']=$result[$j]['qty'];
                            $data1_obj['berry_blast_box']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==9 && $result[$j]['type']=='Bar') {
                            $stock_detail['berry_blast_bar']=$result[$j]['qty'];
                            $data1_obj['berry_blast_bar']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==31 && $result[$j]['type']=='Box') {
                            $stock_detail['chyawanprash_box']=$result[$j]['qty'];
                            $data1_obj['chyawanprash_box']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==10 && $result[$j]['type']=='Bar') {
                            $stock_detail['chyawanprash_bar']=$result[$j]['qty'];
                            $data1_obj['chyawanprash_bar']=$result[$j]['qty1'];
                        }

                        if($result[$j]['item_id']==32 && $result[$j]['type']=='Box') {
                            $stock_detail['variety_box']=$result[$j]['qty'];
                            $data1_obj['variety_box']=$result[$j]['qty1'];
                        }
                    }

                    $data['stock_detail'] = $stock_detail;
                }

                $data['data1'][0] = (object) $data1_obj;

                $data['batch_detail'] = $this->sales_rep_location_model->get_batch_qty_details($merchandiser_stock_id, $get_channel_type);

            // }
        }

        // $data['distributor'] = $this->sales_rep_distributor_model->get_data2();
        // $data['zone'] = $this->sales_rep_location_model->get_zone();
        // $data['area'] = $this->sales_rep_location_model->get_area();
        // if($get_channel_type=='MT') {
        //     $data['location'] = $this->sales_rep_location_model->get_locations('','','',$get_channel_type);
        // } else {
        //     $data['location'] = $this->sales_rep_location_model->get_locations();
        // }

        if($get_channel_type!='') $data['channel_type'] = $get_channel_type;

        echo json_encode($data);
    }

    public function get_po_nos_api(){ 
        $zone_id='';
        $store_id='';
        $location_id='';

        if($this->input->post('zone_id')){
            $zone_id=urldecode($this->input->post('zone_id'));
        }
        if($this->input->post('store_id')){
            $store_id=urldecode($this->input->post('store_id'));
        }
        if($this->input->post('location_id')){
            $location_id=urldecode($this->input->post('location_id'));
        }

        $data = $this->sales_rep_location_model->get_po_nos($zone_id, $store_id, $location_id);
        echo json_encode($data);
    }

    public function get_pending_po_nos_api(){
        $zone_id='';
        $store_id='';
        $location_id='';

        if($this->input->post('zone_id')){
            $zone_id=urldecode($this->input->post('zone_id'));
        }
        if($this->input->post('store_id')){
            $store_id=urldecode($this->input->post('store_id'));
        }
        if($this->input->post('location_id')){
            $location_id=urldecode($this->input->post('location_id'));
        }

        $data = $this->sales_rep_location_model->get_pending_po_nos($zone_id, $store_id, $location_id);
        echo json_encode($data);
    }

    public function get_po_data_api(){ 
        $zone_id='';
        $store_id='';
        $location_id='';
        $po_id='';

        if($this->input->post('zone_id')){
            $zone_id=urldecode($this->input->post('zone_id'));
        }
        if($this->input->post('store_id')){
            $store_id=urldecode($this->input->post('store_id'));
        }
        if($this->input->post('location_id')){
            $location_id=urldecode($this->input->post('location_id'));
        }
        if($this->input->post('po_id')){
            $po_id=urldecode($this->input->post('po_id'));
        }

        $data = $this->sales_rep_location_model->get_po_data($zone_id, $store_id, $location_id, $po_id);
        echo json_encode($data);
    }

    public function save_api($id=""){
        $id = "";
        $user_id = "";
        $srld = "";
        $channel_type = "";
        $distributor_type = "";
        $distributor_id = "";
        $store_id = "";
        $place_order = "";
        $distributor_name = "";
        $zone_id = "";
        $area_id = "";
        $location_id = "";

        if($this->input->post('id')) {
            $id = urldecode($this->input->post('id'));
        }
        if($this->input->post('sales_rep_id')) {
            $user_id = urldecode($this->input->post('sales_rep_id'));
        }
        if($this->input->post('srld')) {
            $srld = urldecode($this->input->post('srld'));
        }
        if($this->input->post('channel_type')) {
            $channel_type = urldecode($this->input->post('channel_type'));
        }
        if($this->input->post('distributor_type')) {
            $distributor_type = urldecode($this->input->post('distributor_type'));
        }
        if($this->input->post('distributor_id')) {
            $distributor_id = urldecode($this->input->post('distributor_id'));
        }
        if($this->input->post('store_id')) {
            $store_id = urldecode($this->input->post('store_id'));
        }
        if($this->input->post('place_order')) {
            $place_order = urldecode($this->input->post('place_order'));
        }
        if($this->input->post('distributor_name')) {
            $distributor_name = urldecode($this->input->post('distributor_name'));
        }
        if($this->input->post('zone_id')) {
            $zone_id = urldecode($this->input->post('zone_id'));
        }
        if($this->input->post('area_id')) {
            $area_id = urldecode($this->input->post('area_id'));
        }
        if($this->input->post('location_id')) {
            $location_id = urldecode($this->input->post('location_id'));
        }

        $bool = 1;

        // if($this->session->userdata('posttimer')=='') {
        //     $this->session->set_userdata('posttimer',time());
        //     $bool = 1;
        // } else {
        //     if ((time() - $this->session->userdata('posttimer'))>5) {
        //         $this->session->set_userdata('posttimer',time());
        //         $bool = 1;
        //     } else {
        //         $bool = 0;
        //     }
        // }

        $data['Monday'] = array();
        $data['Tuesday'] = array();
        $data['Wednesday'] = array();
        $data['Thursday'] = array();
        $data['Friday'] = array();
        $data['Saturday'] = array();
        $data['Sunday'] = array();

        if($bool==1) {
            if($srld == "Place Order") {
                if($channel_type=='GT') {
                    $this->session->unset_userdata('retailer_detail');
                    $this->session->unset_userdata('visit_detail');
                    $this->Sales_location_model->save_session();
                } else {
                    $this->Sales_location_model->save_relation_session();
                }

                $stock_detail = $this->session->userdata('stock_detail');
            } else if($srld == "Follow Up") {
                $data = $this->save_order_api('Follow Up');
            } else {
                $data = $this->save_order_api('Save');
            }    

            // echo json_encode($data);
        } else {
            // redirect(base_url().'index.php/Sales_rep_store_plan');
        }
    }

    public function add_sales_rep_distributor_api(){
        // // $visit_detail = $this->session->userdata('visit_detail');
        // $visit_detail = $this->input->post('visit_detail');

        // $sales_rep_id='';
        // $distributor_id='';
        // $beat_id='';

        // if($this->input->post('sales_rep_id')){
        //     $sales_rep_id=$this->input->post('sales_rep_id');
        // } else if($this->session->userdata('sales_rep_id')){
        //     $sales_rep_id=$this->session->userdata('sales_rep_id');
        // }
        // if($this->input->post('distributor_id')){
        //     $distributor_id=$this->input->post('distributor_id');
        // } else if($this->session->userdata('distributor_id')){
        //     $distributor_id=$this->session->userdata('distributor_id');
        // }
        // if($this->input->post('beat_id')){
        //     $beat_id=$this->input->post('beat_id');
        // } else if($this->session->userdata('beat_id')){
        //     $beat_id=$this->session->userdata('beat_id');
        // }

        // $data['distributor'] = $this->sales_rep_location_model->get_distributors($visit_detail['zone_id']);
        // if($visit_detail['distributor_id']!='') {
        //     $result  = $this->sales_rep_distributor_model->get_data2('', $visit_detail['distributor_id']);
        //     //$distributor_name =$result[0]->distributor_name;
        //     //$data['distributor_name']=$distributor_name; 
        // }
        // if($visit_detail['reation_id']!='') {
        //     $result  = $this->sales_rep_location_model->get_store_name($visit_detail['reation_id']);
        //     $store_name =$result[0]->store_name;
        //     $data['store_name']=$store_name; 
        // }
        // if($visit_detail['zone_id']!='') {
        //     $result  = $this->sales_rep_location_model->get_zone($visit_detail['zone_id']);
        //     $zone=$result[0]->zone; 
        //     $data['zone']=$zone;
        // }
        // if($visit_detail['area_id']!='') {
        //     $result  = $this->sales_rep_location_model->get_area('',$visit_detail['area_id']);
        //     $area=$result[0]->area; 
        //     $data['area']=$area;
        // }
        // if($visit_detail['location_id']!='') {
        //     $result  = $this->sales_rep_location_model->get_locations('','',$visit_detail['location_id']);
        //     $location=$result[0]->location; 
        //     $data['location']=$location;
        // }

        $data['margin']='';
        $data['remarks']='';
        $data['gst_number']='';

        $distributor_id = $this->input->post('distributor_id');

        if($distributor_id!='') {
            $dist_id=explode('s_',$distributor_id);
            $get_result = $this->db->where('id',$dist_id[1])->select('*')->get('sales_rep_distributors')->result_array();

            if(count($get_result)>0) {
               $data['margin']=$get_result[0]['margin']; 
               $data['remarks']=$get_result[0]['remarks']; 
               $data['gst_number']=$get_result[0]['gst_number']; 
            }
        }

        // load_view('sales_rep_distributor/sales_rep_distributor_details', $data);

        echo json_encode($data);
    }

    public function save_sales_rep_retailer_api($id=''){
        // $visit_detail = $this->session->userdata('visit_detail');
        $visit_detail = $this->input->post('visit_detail');

        if($visit_detail['channel_type'] == 'MT'){
            $this->Sales_location_model->save_relation_session();    
            /*$id = $this->sales_rep_distributor_model->save_data();
              $id = 's_'.$id;*/
        } else {
            $this->Sales_location_model->save_retailer_session();
        }

        // redirect(base_url().'index.php/Sales_rep_store_plan/add_order/');

        echo 1;
    }

    public function get_array_api(){
        // $visit_detail = $this->input->post('visit_detail');
        $visit_detail = $this->input->post('merchandiser_stock_details');

        $arr = json_decode($visit_detail, true);
        // echo json_encode($arr);

        // echo $arr['mid'];

        echo $arr[0]['type'];


        // $visit_detail = "Bundle[{mid:1, sid:2}]";

        // $visit = json_encode($visit_detail);
        // echo $visit;
        // echo '<br/><br/>';

        // $bundle = json_decode($visit);
        // echo $bundle;
        // echo '<br/><br/>';

        // $arr = (array) json_decode($visit, true);
        
        // // $bundle = json_decode($visit);
        // echo $arr[0];
        // echo '<br/><br/>';

        // foreach ($arr as $k=>$v){
        //     echo $v;
        //     echo '<br/><br/>';
        // }
        
        

        // echo $visit_detail;
        // echo strpos($visit_detail, 'mid');
        // echo $visit_detail['Bundle']['mid'];
        // echo $visit_detail['Bundle']->mid;
        // echo json_encode($visit_detail['Bundle']);
        // echo '<br/><br/>';
        // echo $visit_detail['bundle']['mid'];
    }

    public function get_order_api(){
        $sales_rep_id='2';

        if($this->input->post('sales_rep_id')){
            $sales_rep_id=urldecode($this->input->post('sales_rep_id'));
        }

        $data['data'] = $this->Sales_location_model->get_todaysorder($sales_rep_id);;
        echo json_encode($data);
    }

    public function get_order_data_api(){
        $order_id='797';

        if($this->input->post('order_id')){
            $order_id=urldecode($this->input->post('order_id'));
        }

        $data = $this->sales_rep_location_model->get_order_data($order_id);
        echo json_encode($data);
    }

    public function add_order_api(){
        // $visit_detail = $this->session->userdata('visit_detail');
        // $visit_detail = $this->input->post('visit_detail');
        // $visit_detail = json_decode($visit_detail, true);

        // $distributor_id = $this->session->userdata('distributor_id')
        // $distributor_id = $this->input->post('distributor_id');

        $mid = $this->input->post('mid');
        $sales_rep_loc_id = $this->input->post('sales_rep_loc_id');
        $merchandiser_stock_id = $this->input->post('merchandiser_stock_id');

        $data = array();
        $data['data1'] = array();
        $data['remarks'] = '';

        // $data['distributor'] = $this->sales_rep_location_model->get_distributors();

        // if($visit_detail['mid']!='' || $visit_detail['sales_rep_loc_id']!='' || $visit_detail['merchandiser_stock_id']!='') { 
        //     if($visit_detail['mid']!='') {
        //         $visit_id=$visit_detail['mid'];
        //     } else if($visit_detail['sales_rep_loc_id']!='') {
        //         $visit_id=$visit_detail['sales_rep_loc_id'];
        //     } else if($visit_detail['merchandiser_stock_id']!='') {
        //         $visit_id=$visit_detail['merchandiser_stock_id'];
        //     }

        //     $get_result = $this->db->where('visit_id',$visit_id)->select('selected_distributor')->get('sales_rep_orders')->result_array();

        //     if(count($get_result)>0) {
        //        $data['selected_distributor']=$get_result[0]['selected_distributor']; 
        //     } else {
        //         $data['selected_distributor']=0;
        //     }
        // } else {
        //     $data['selected_distributor']=0;
        // }

        // if($data['selected_distributor']==0 || $data['selected_distributor']=='') {
        //     if($distributor_id!='') {
        //         $data['selected_distributor']=$distributor_id;
        //     }
        // }

        // if($visit_detail['distributor_name']=='' && $visit_detail['reation_id']=='') {
        //     $result  = $this->sales_rep_distributor_model->get_data2('',$visit_detail['distributor_id']);
        //     $distributor_name =$result[0]->distributor_name;
        //     $data['distributor_name']=$distributor_name; 
        // } else {
        //     $data['distributor_name']=$visit_detail['distributor_name']; 
        // }
        // if($visit_detail['reation_id']!='') {
        //     $result  = $this->distributor_sale_model->get_store($visit_detail['zone_id'],$visit_detail['reation_id']);
        //     $store_name =$result[0]->store_name;
        //     $data['store_name']=$store_name; 
        // }
        // if($visit_detail['zone_id']!='') {
        //     $result  = $this->sales_rep_location_model->get_zone($visit_detail['zone_id']);
        //     $zone=$result[0]->zone; 
        //     $data['zone']=$zone;
        // }
        // if($visit_detail['area_id']!='') {
        //     $result  = $this->sales_rep_location_model->get_area('',$visit_detail['area_id']);
        //     $area=$result[0]->area; 
        //     $data['area']=$area;
        // }
        // if($visit_detail['location_id']!='') {
        //     $result  = $this->sales_rep_location_model->get_locations('','',$visit_detail['location_id']);
        //     $location=$result[0]->location; 
        //     $data['location']=$location;
        // }

        if($mid!='') {
            $mid=$mid;
        } else if($sales_rep_loc_id!='') {
             $mid=$sales_rep_loc_id;
        } else if($merchandiser_stock_id!='') {
            $mid=$merchandiser_stock_id;
        }

        if($mid!='') {
            $get_result = $this->db->query("Select * from sales_rep_orders where visit_id='$mid'")->result_array();
            if(count($get_result)>0) {
                $data['remarks'] = $get_result[0]['remarks'];
                $order_id = $get_result[0]['id'];
                $result = $this->db->query("Select A.id as stock_id,
                                            Case When type='Box' Then box_name ELSE product_name end as product_name,
                                            Case When type='Box' Then CONCAT(qty,'_Box') ELSE CONCAT(qty,'_Bar') end as qty1,qty,item_id,type
                                            from
                                            (SELECT * from sales_rep_order_items where sales_rep_order_id='$order_id') A
                                            Left join 
                                            (SELECT * from box_master)B on A.item_id=B.id
                                            Left join 
                                            (SELECT * from product_master)C on A.item_id=C.id")->result_array();
                
                $order_detail = array();
                if(count($result)>0) {
                    for ($j=0; $j <count($result) ; $j++) {
                        if ($result[$j]['item_id']==37) {
                            $order_detail['chocolate_cookies_box']=$result[$j]['qty'];
                        }
                        if ($result[$j]['item_id']==38) {
                            $order_detail['dark_chocolate_cookies_box']=$result[$j]['qty'];
                        }
                        if ($result[$j]['item_id']==39) {
                            $order_detail['cranberry_cookies_box']=$result[$j]['qty'];
                        }
                        if ($result[$j]['item_id']==42) {
                            $order_detail['cranberry_orange_box']=$result[$j]['qty'];
                        }
                        if ($result[$j]['item_id']==41) {
                            $order_detail['fig_raisins_box']=$result[$j]['qty'];
                        }
                        if ($result[$j]['item_id']==40) {
                            $order_detail['papaya_pineapple_box']=$result[$j]['qty'];
                        }
                        if($result[$j]['item_id']==1 && $result[$j]['type']=='Bar') {
                            $order_detail['orange_bar']=$result[$j]['qty'];
                        }
                        if($result[$j]['item_id']==1 && $result[$j]['type']=='Box') {
                            $order_detail['orange_box']=$result[$j]['qty'];
                        }

                        /*if($result[$j]['item_id']==3 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                        {
                            $order_detail['butterscotch']=$result[$j]['qty'];
                        }*/

                        if($result[$j]['item_id']==3 && $result[$j]['type']=='Box') {
                            $order_detail['butterscotch_box']=$result[$j]['qty'];
                        }
                        if($result[$j]['item_id']==3 && $result[$j]['type']=='Bar') {
                            $order_detail['butterscotch_bar']=$result[$j]['qty'];
                        }
                        if($result[$j]['item_id']==9 && $result[$j]['type']=='Box') {
                            $order_detail['chocopeanut_box']=$result[$j]['qty'];
                        }
                        if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar') {
                            $order_detail['chocopeanut_bar']=$result[$j]['qty'];
						}
                        if($result[$j]['item_id']==8 && $result[$j]['type']=='Box') {
                            $order_detail['bambaiyachaat_box']=$result[$j]['qty'];
						}
						if($result[$j]['item_id']==4 && $result[$j]['type']=='Bar') {
                            $order_detail['bambaiyachaat_bar']=$result[$j]['qty'];
				        }
                        if($result[$j]['item_id']==12 && $result[$j]['type']=='Box') {
                            $order_detail['mangoginger_box']=$result[$j]['qty'];
						}
                        if($result[$j]['item_id']==6 && $result[$j]['type']=='Bar') {
                            $order_detail['mangoginger_bar']=$result[$j]['qty'];
						}
                        if($result[$j]['item_id']==29 && $result[$j]['type']=='Box') {
                            $order_detail['berry_blast_box']=$result[$j]['qty'];
						}
                        if($result[$j]['item_id']==9 && $result[$j]['type']=='Bar') {
                            $order_detail['berry_blast_bar']=$result[$j]['qty'];
						}
                        if($result[$j]['item_id']==31 && $result[$j]['type']=='Box') {
							$order_detail['chyawanprash_box']=$result[$j]['qty'];
						}
                        if($result[$j]['item_id']==10 && $result[$j]['type']=='Bar')
                            $order_detail['chyawanprash_bar']=$result[$j]['qty'];
                        if($result[$j]['item_id']==32 && $result[$j]['type']=='Box')
                            $order_detail['variety_box']=$result[$j]['qty'];
                    }

                    // $data['order_detail'] = $order_detail;
                    $data['data1'][0] = (object) $order_detail;
                }
            }
        }
        
        // $temp_stock_details = $this->session->userdata('temp_stock_details');
        // $temp_stock_details = $this->input->post('temp_stock_details');
        // if($temp_stock_details!=null) {
        //     $data['stock_detail']=$temp_stock_details;
        // }

        // $data['get_retailers'] = $this->sales_rep_location_model->get_retailers();

        // load_view('sales_rep_order/sales_rep_order_details', $data);

        echo json_encode($data);
    }

    public function test(){
        $mid='';
        $visit_detail = array(
                            'channel_type'=>'GT',
                            'distributor_id'=>'s_4130',
                            'zone_id'=>'7',
                            'area_id'=>'5',
                            'location_id'=>'924'
                        );

        $sql = "Select CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
                OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
                THEN CONCAT('Every ',DAYNAME(date(now()))) 
                WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4)
                THEN CONCAT('Alternate ',DAYNAME(date(now()))) end as frequency";
        $result = $this->db->query($sql)->result();

        $frequency = $result[0]->frequency;
        $sales_rep_id = '2';

        if($mid==''){
            if($visit_detail['channel_type']=='MT'){
                $sql="select * from sales";
            } else {
                $sql = "select * from sales_rep_detailed_beat_plan where frequency='$frequency' and 
                        sales_rep_id='$sales_rep_id' and date(date_of_visit)=curdate() and 
                        store_id='".$visit_detail['distributor_id']."' and 
                        zone_id='".$visit_detail['zone_id']."' and 
                        area_id='".$visit_detail['area_id']."' and 
                        location_id='".$visit_detail['location_id']."'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0){
                    $mid = $result[0]->id;
                    $merchendiser_beat_plan_id = $beat_plan_id = $result[0]->bit_plan_id;
                    $sequence = $result[0]->sequence;
                }
            }
        }

        echo json_encode($result);
    }

    public function save_order_api($save=''){
        if($save!='') {
            $channel_type = $this->input->post('channel_type');
            $distributor_type = $this->input->post('distributor_type');
            $distributor_name = $this->input->post('distributor_name');
            $zone_id = $this->input->post('zone_id');
            $area_id = $this->input->post('area_id');
            $location_id = $this->input->post('location_id');
            $longitude = $this->input->post('longitude');
            $latitude = $this->input->post('latitude');
            $remarks = $this->input->post('remarks');
            $reation_id = $this->input->post('reation_id');
            $distributor_id = $this->input->post('distributor_id');
            $mid = $this->input->post('mid');
            $beat_plan_id = $this->input->post('beat_plan_id');
            $store_id = $this->input->post('store_id');
            $distributor_status = $this->input->post('distributor_status');
            $sales_rep_loc_id = $this->input->post('sales_rep_loc_id');
            $sequence = $this->input->post('sequence');
            $merchandiser_stock_id = $this->input->post('merchandiser_stock_id');
            $follow_type = $this->input->post('follow_type');
            $id = $this->input->post('id');

            $followup_date=$this->input->post('followup_date');
            if($followup_date==''){
                $followup_date=NULL;
            } else {
                $followup_date=formatdate($followup_date);
            }

            $visit_detail = array(
                'channel_type'  => $channel_type,
                'distributor_types'=> $distributor_type,
                'distributor_name' => $distributor_name,
                'zone_id' => $zone_id,
                'area_id' => $area_id,
                'location_id' => $location_id,
                'remarks' => trim($remarks),
                'longitude'=>$longitude,
                'latitude'=>$latitude,
                'distributor_id'=>$distributor_id,
                'mid'=>$mid,
                'reation_id'=>$reation_id,
                'beat_plan_id'=>$beat_plan_id,
                'store_id'=>$store_id,
                'distributor_status'=>$distributor_status,
                'sales_rep_loc_id'=>$sales_rep_loc_id,
                'sequence'=>$sequence,
                'merchandiser_stock_id'=>$merchandiser_stock_id,
                'follow_type'=>$follow_type,
                'followup_date'=>$followup_date
            );

            $batch_array = array();
            $orange_bar = $this->input->post('orange_bar');
            $orange_box = $this->input->post('orange_box');
            $butterscotch_bar = $this->input->post('butterscotch_bar');
            $butterscotch_box = $this->input->post('butterscotch_box');
            $chocopeanut_bar = $this->input->post('chocopeanut_bar');
            $chocopeanut_box = $this->input->post('chocopeanut_box');
            $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
            $bambaiyachaat_box = $this->input->post('bambaiyachaat_box');
            $mangoginger_bar = $this->input->post('mangoginger_bar');
            $mangoginger_box = $this->input->post('mangoginger_box');
            $berry_blast_bar = $this->input->post('berry_blast_bar');
            $berry_blast_box = $this->input->post('berry_blast_box');
            $chyawanprash_bar = $this->input->post('chyawanprash_bar');
            $chyawanprash_box = $this->input->post('chyawanprash_box');
            $variety_box = $this->input->post('variety_box');
            $chocolate_cookies = $this->input->post('chocolate_cookies');
            $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
            $cranberry_cookies = $this->input->post('cranberry_cookies');
            $fig_raisins = $this->input->post('fig_raisins');
            $papaya_pineapple = $this->input->post('papaya_pineapple');
            $cranberry_orange_zest = $this->input->post('cranberry_orange_zest');
            $batch_array = array();

            if($channel_type=='GT') {
                if($chocolate_cookies!='') {
                    $batch_array['chocolate_cookies_box']=$chocolate_cookies;
                }
                if($dark_chocolate_cookies!='') {
                   $batch_array['dark_chocolate_cookies_box']=$dark_chocolate_cookies;
                }
                if($cranberry_cookies!='') {
                    $batch_array['cranberry_cookies_box']=$cranberry_cookies;
                }
                if($cranberry_orange_zest!='') {
                    $batch_array['cranberry_orange_box'] = $cranberry_orange_zest;
                }
                if($fig_raisins!='') {
                    $batch_array['fig_raisins_box'] = $fig_raisins;
                }
                if($papaya_pineapple!='') {
                    $batch_array['papaya_pineapple_box'] = $papaya_pineapple;
                }
                if($orange_bar!=null) {
                    $batch_array['orange_bar'] = $orange_bar;
                }
                if($orange_box!=null) {
                    $batch_array['orange_box'] = $orange_box;
                }
                if($butterscotch_bar!=null) {
                    $batch_array['butterscotch_bar'] = $butterscotch_bar;
                }
                if($butterscotch_box!=null) {
                    $batch_array['butterscotch_box'] = $butterscotch_box;
                }
                if($chocopeanut_bar!=null) {
                    $batch_array['chocopeanut_bar'] = $chocopeanut_bar;
                }
                if($chocopeanut_box!=null) {
                   $batch_array['chocopeanut_box'] = $chocopeanut_box;
                }
                if($bambaiyachaat_bar!=null) {
                    $batch_array['bambaiyachaat_bar'] = $bambaiyachaat_bar;
                }
                if($bambaiyachaat_box!=null) {
                    $batch_array['bambaiyachaat_box'] = $bambaiyachaat_box;
                }
                if($mangoginger_bar!=null) {
                   $batch_array['mangoginger_bar'] = $mangoginger_bar;
                }
                if($mangoginger_box!=null) {
                    $batch_array['mangoginger_box'] = $mangoginger_box;
                }
                if($berry_blast_bar!=null) {
                    $batch_array['berry_blast_bar'] = $berry_blast_bar;
                }
                if($berry_blast_box!=null) {
                    $batch_array['berry_blast_box'] = $berry_blast_box;
                }
                if($chyawanprash_bar!=null) {
                   $batch_array['chyawanprash_bar'] = $chyawanprash_bar;
                }
                if($chyawanprash_box!=null) {
                    $batch_array['chyawanprash_box'] = $chyawanprash_box;
                }
                if($variety_box!=null) {
                    $batch_array['variety_box'] = $variety_box;
                }

                $sales_rep_stock_detail =  $batch_array;  
            } else {
                if($chocolate_cookies!='') {
                    $item_id =37;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$chocolate_cookies
                                    );
                    $batch_array[] = $data;
                }
                if($dark_chocolate_cookies!='') {
                    $item_id =38;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$dark_chocolate_cookies
                                    );
                    $batch_array[] = $data;
                }
                if($cranberry_cookies!='') {
                    $item_id = 39;
                    $data = array( 'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$cranberry_cookies
                                    );
                    $batch_array[] = $data;
                }
                if($cranberry_orange_zest!='') {
                    $item_id = 42;
                    $data = array(  'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$cranberry_orange_zest
                                    );
                    $batch_array[] = $data;
                }
                if($fig_raisins!='') {
                    $item_id = 41;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$fig_raisins
                                    );
                    $batch_array[] = $data;
                }
                if($papaya_pineapple!='') {
                    $item_id = 40;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$papaya_pineapple
                                    );
                    $batch_array[] = $data;
                }
                if($orange_bar!=null) {
                    $item_id = 1;
                    $data = array(
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$orange_bar
                                    );
                    $batch_array[] = $data;
                }
                if($orange_box!=null) {
                    $item_id = 1;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$orange_box
                                    );
                    $batch_array[] = $data;
                }
                if($butterscotch_bar!=null) {
                    $item_id = 3;
                    $data = array(
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$butterscotch_bar
                                    );
                    $batch_array[] = $data;
                }
                if($butterscotch_box!=null) {
                    $item_id = 3;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$butterscotch_box
                                    );
                    $batch_array[] = $data;
                }
                if($chocopeanut_bar!=null) {
                    $item_id = 5;
                    $data = array(
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$chocopeanut_bar
                                    );
                    $batch_array[] = $data;
                }
                if($chocopeanut_box!=null) {
                    $item_id = 9;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$chocopeanut_box
                                    );
                    $batch_array[] = $data;
                }
                if($bambaiyachaat_bar!=null) {
                    $item_id = 4;
                    $data = array(
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$bambaiyachaat_bar
                                    );
                    $batch_array[] = $data;
                }
                if($bambaiyachaat_box!=null) {
                    $item_id = 8;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$bambaiyachaat_box
                                    );
                    $batch_array[] = $data;
                }
                if($mangoginger_bar!=null) {
                   $item_id = 6;
                   $data = array(
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$mangoginger_bar
                                    );
                    $batch_array[] = $data;
                }
                if($mangoginger_box!=null) {
                   $item_id = 12;
                   $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$mangoginger_box
                                    );
                    $batch_array[] = $data;
                }
                if($berry_blast_bar!=null) {
                   $item_id = 9;
                   $data = array(
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$berry_blast_bar
                                    );

                    $batch_array[] = $data;
                }
                if($berry_blast_box!=null) {
                   $item_id = 29;
                   $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$berry_blast_box
                                    );

                    $batch_array[] = $data;
                }
                if($chyawanprash_bar!=null) {
                   $item_id = 10;
                   $data = array(
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$chyawanprash_bar
                                    );
                    $batch_array[] = $data;
                }
                if($chyawanprash_box!=null) {
                   $item_id = 31;
                   $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$chyawanprash_box
                                    );
                    $batch_array[] = $data;
                }
                if($variety_box!=null) {
                    $item_id = 32;
                    
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$variety_box
                                    );
                    $batch_array[] = $data;
                }  
                
                $merchandiser_stock_details =  $batch_array; 
            }
        } else {
            $visit_detail = $this->input->post('visit_details');
            $merchandiser_stock_details = $this->input->post('merchandiser_stock_details');
            $sales_rep_stock_detail = $this->input->post('sales_rep_stock_detail');

            $visit_detail = json_decode($visit_detail, true);
            $merchandiser_stock_details = json_decode($merchandiser_stock_details, true);
            $sales_rep_stock_detail = json_decode($sales_rep_stock_detail, true);
        }

        $retailer_detail = $this->input->post('retailer_detail');
        $retailer_detail = json_decode($retailer_detail, true);

        $now=date('Y-m-d H:i:s');
        $now1=date('Y-m-d');
        $curusr=$this->input->post('session_id');
        $date_of_visit=$this->input->post('date_of_visit');
        $sales_rep_id=$this->input->post('sales_rep_id');
        
        $ispermenant = $this->input->post('ispermenant');
        $place_order = $this->input->post('place_order');
        $id = $this->input->post('id');

        $sql = "Select CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
                OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
                THEN CONCAT('Every ',DAYNAME(date(now()))) 
                WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4)
                THEN CONCAT('Alternate ',DAYNAME(date(now()))) end as frequency";
        $result = $this->db->query($sql)->result();

        $frequency = $result[0]->frequency;
        
        $mid = $visit_detail['mid'];
        $merchendiser_beat_plan_id = $beat_plan_id = $visit_detail['beat_plan_id'];
        $visit_id = 0;
        $sequence=$visit_detail['sequence'];

        if($id==''){
            if($visit_detail['channel_type']=='MT'){
                $sql="select * from sales";
            } else {
                $sql = "select * from sales_rep_detailed_beat_plan where frequency='$frequency' and 
                        sales_rep_id='$sales_rep_id' and date(date_of_visit)=curdate() and 
                        store_id='".$visit_detail['distributor_id']."' and 
                        zone_id='".$visit_detail['zone_id']."' and 
                        area_id='".$visit_detail['area_id']."' and 
                        location_id='".$visit_detail['location_id']."'";
                $result = $this->db->query($sql)->result();
                if(count($result)>0){
                    $id = $result[0]->id;
                    $merchendiser_beat_plan_id = $beat_plan_id = $result[0]->bit_plan_id;
                    $sequence = $result[0]->sequence;
                }
            }
        }

        if($mid!='') {
            $visit_id = $mid;

            if($visit_detail['channel_type']=='MT') {
                $visit_store_id = $visit_detail['reation_id'];

                $result = $this->db->select("detailed_bit_plan_id")->where('id',$mid)->get('merchandiser_stock')->result_array();
                $detailed_bit_plan_id = $result[0]['detailed_bit_plan_id'];

                $result = $this->db->select("*")->where('id',$detailed_bit_plan_id)->get('merchandiser_detailed_beat_plan')->result_array();
            } else {
                $visit_store_id = $visit_detail['store_id'];

                $result = $this->db->select("detailed_bit_plan_id")->where('id',$mid)->get('sales_rep_location')->result_array();
                $detailed_bit_plan_id = $result[0]['detailed_bit_plan_id'];

                $result = $this->db->select("*")->where('id',$detailed_bit_plan_id)->get('sales_rep_detailed_beat_plan')->result_array();
            }

            $bit_plan_data = array("store_id"=>$visit_store_id,
                                    "location_id"=>$visit_detail['location_id'],
                                    "zone_id"=> $visit_detail['zone_id'],
                                    "area_id"=> $visit_detail['area_id'],
                                    'modified_on' => $now,
                                    'modified_by' => $curusr);

            $bit_plan_where_cond = array("store_id"=>$visit_store_id,
                                            "location_id"=>$visit_detail['location_id'],
                                            "zone_id"=> $visit_detail['zone_id'],
                                            "area_id"=> $visit_detail['area_id'],
                                            "frequency"=> $frequency,
                                            "sales_rep_id"=> $sales_rep_id,
                                            "date(date_of_visit)"=>$now1);

            if($visit_detail['channel_type']=='MT') {
                $prev_store_id = $result[0]['store_id'];
                $prev_zone_id = $result[0]['zone_id'];
                $prev_location_id = $result[0]['location_id'];
                $prev_frequency = $result[0]['frequency'];
                $prev_sales_rep_id = $result[0]['sales_rep_id'];
                $detailed_sequence= $result[0]['sequence'];
                $bit_plan_id = $result[0]['bit_plan_id'];
                $detailed_id = $result[0]['id'];
               
                $retailer_id = $store_id = $visit_detail['reation_id'];
                $data1 = array();
                             
                if(isset($followup_date)) {
                    $data1['followup_date'] = $followup_date;
                }

                $data1['remarks'] = $visit_detail['remarks'];
                $this->db->where('id', $mid);
                $this->db->update('merchandiser_stock',$data1);

                $action='Merchandiser Location Modified.';        
                $merchandiser_stock_id=$mid;

                if(count($merchandiser_stock_details)>0) {
                    for ($j=0; $j <count($merchandiser_stock_details); $j++) { 
                        $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                    }
                    $this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');
                    $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                }

                $where_array = array("store_id"=>$prev_store_id,
                                        "zone_id"=>$prev_zone_id,
                                        "location_id"=>$prev_location_id,   
                                        "sales_rep_id"=>$prev_sales_rep_id,
                                        "frequency"=>$prev_frequency,
                                        'modified_on' => $now,
                                        'modified_by' => $curusr);
                $this->db->where($where_array)->update('merchandiser_beat_plan',$bit_plan_data);    

                $update_details = array("store_id"=>$visit_store_id, 'modified_on' => $now);
                $this->db->where("id",$beat_plan_id)->update('merchandiser_detailed_beat_plan',$update_details);
          
                $sales_rep_beat_where =  array("store_id"=>$visit_store_id,
                                                "location_id"=>$visit_detail['location_id'],
                                                "zone_id"=> $visit_detail['zone_id'],
                                                "frequency"=> $frequency,
                                                "sales_rep_id"=> $sales_rep_id);
                $get_data_result = $this->db->select("*")->where($sales_rep_beat_where)->get('merchandiser_beat_plan')->result();
 
                if(count($get_data_result)==0) {
                    for ($j=0; $j < count($result); $j++) {
                        $newsequence = $result[$j]['sequence']+1;
                        $new_id = $result[$j]['id'];
                        $data1 = array('sequence'=>$newsequence, 'modified_on'=>$now);
                        $this->db->where('id', $new_id);
                        $this->db->update('merchandiser_beat_plan',$data1);
                    }

                    $after_temp_data1 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$detailed_sequence,
                                               'frequency'=>$frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$visit_store_id,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id'=>$visit_detail['location_id'],
                                               'zone_id' =>$visit_detail['zone_id'],
                                               'created_on'=>$now);
                    $this->db->insert('merchandiser_beat_plan', $after_temp_data1);
                    $lastinsertid=$this->db->insert_id();         

                    if($lastinsertid) {
                        if (strpos($frequency, 'Every') !== false) {
                            $explode_frequency = explode(' ',$frequency);
                            $selectfre = "select (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth ";
                            $frequency_result = $this->db->query($selectfre)->result();

                            $frequency_result = $frequency_result[0]->daymonth;
                            if($frequency_result==2) {
                                $new_frequency = 'Alternate '.$explode_frequency[1]; 
                            } else {
                                $new_frequency = 'Alternate '.$explode_frequency[1];
                            }
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('merchandiser_beat_plan')->result_array();;

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                                       'sequence'=>$max_sequnece,
                                                       'frequency'=>$new_frequency,
                                                       'modified_on'=>$now,
                                                       'store_id'=>$visit_store_id,
                                                       'status'=>'Approved',
                                                       'created_by'=>$curusr,
                                                       'modified_by' => $curusr,
                                                       'location_id'=>$visit_detail['location_id'],
                                                       'zone_id' => $visit_detail['zone_id'],
                                                       'created_on'=>$now);
                            $this->db->insert('merchandiser_beat_plan',$after_temp_data2);
                        }
                        
                        if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {
                            $explode_frequency = explode(' ',$frequency);
                            $new_frequency = 'Every '.$explode_frequency[1];
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('merchandiser_beat_plan')->result_array();

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$visit_store_id,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id'=>$visit_detail['location_id'],
                                               'zone_id' =>$visit_detail['zone_id'],
                                               'created_on'=>$now);
                            $this->db->insert('merchandiser_beat_plan',$after_temp_data2);
                        }

                        if($bit_plan_id==0) {
                            $data1 = array('bit_plan_id'=>$lastinsertid,'modified_on'=>$now);
                            $this->db->where('id', $detailed_id);
                            $this->db->update('merchandiser_detailed_beat_plan',$data1);
                        }
                    }        
                } else {
                    $update_data = array("bit_plan_id"=>$get_data_result[0]->id, 'modified_on' => $now);
                    $this->db->where("id", $detailed_id)->update('merchandiser_detailed_beat_plan', $update_data);
                }
            } else {
                $prev_store_id = $result[0]['store_id'];
                $prev_zone_id = $result[0]['zone_id'];
                $prev_area_id = $result[0]['area_id'];
                $prev_location_id = $result[0]['location_id'];
                $prev_frequency = $result[0]['frequency'];
                $prev_sales_rep_id = $result[0]['sales_rep_id'];
                $detailed_sequence= $result[0]['sequence'];
                $bit_plan_id = $result[0]['bit_plan_id'];
                $detailed_id = $result[0]['id'];
                $retailer_id = $visit_detail['store_id'];

                if($visit_detail['distributor_types']=='Old') {
                    $sales_rep_stock_detail['sales_rep_loc_id'] = $mid;
                    $this->db->where('sales_rep_loc_id',$mid)->delete('sales_rep_distributor_opening_stock');
                    $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);

                    $store_id_d = explode('_',$visit_detail['store_id']);
                    $store_id = $store_id_d[1];
                    $latitude = $visit_detail['latitude'];
                    $longitude = $visit_detail['longitude'];

                    if(isset($latitude) && isset($longitude)){
                        if($latitude!='0' && $latitude!='null' && $latitude!='' && $longitude!='0' && $longitude!='null' && $longitude!=''){
                            if($store_id_d[0]=='d'){
                                $dist_table_name = "distributor_master";
                            } else {
                                $dist_table_name = "sales_rep_distributors";
                            }

                            $sql = "select * from ".$dist_table_name." where id='$store_id'";
                            $dist_res = $this->db->query($sql)->result();
                            if(count($dist_res)>0){
                                $lat = $dist_res[0]->latitude;
                                $long = $dist_res[0]->longitude;
                                if($lat=='0' || $lat=='null' || $lat=='' || $long=='0' || $long=='null' || $long==''){
                                    $data_dist = array(
                                                'modified_by' => $curusr,
                                                'modified_on' => $now,
                                                'latitude' =>    $visit_detail['latitude'],
                                                'longitude' =>   $visit_detail['longitude']
                                            );
                                    $this->db->where('id', $store_id)->update($dist_table_name,$data_dist);
                                }
                            }
                        }
                    }
                } else {
                    $store_id_d = explode('_',$visit_detail['store_id']);
                    $store_id = $store_id_d[1];

                    $data_dist = array(
                                'sales_rep_id' => $sales_rep_id,
                                'distributor_name' => $visit_detail['distributor_name'],
                                'modified_by' => $curusr,
                                'modified_on' => $now,
                                'location_id' => $visit_detail['location_id'],
                                'zone_id' =>     $visit_detail['zone_id'],
                                'area_id' =>     $visit_detail['area_id'],
                                'latitude' =>    $visit_detail['latitude'],
                                'longitude' =>   $visit_detail['longitude'],
                                'gst_number' =>  $retailer_detail['gst_number'],
                                'margin' =>  $retailer_detail['margin'],
                                'remarks' =>  $retailer_detail['retailer_remarks'],
                                'master_distributor_id'=>$retailer_detail['master_distributor_id'],
                                'status'=>'Approved'
                            );
                    $this->db->where('id', $store_id)->update('sales_rep_distributors',$data_dist); 
                }

                if(isset($followup_date)) {
                    $update_details1 = array('followup_date'=>$followup_date);
                    $this->db->where("id",$mid)->update('sales_rep_location',$update_details1);
                }

                $where_array = array("store_id"=>$prev_store_id,
                                        "zone_id"=>$prev_zone_id,
                                        "area_id"=>$prev_area_id,
                                        "location_id"=>$prev_location_id,   
                                        "sales_rep_id"=>$prev_sales_rep_id,
                                        "frequency"=>$prev_frequency,
                                        'modified_on' => $now,
                                        'modified_by' => $curusr);
                $this->db->where($where_array)->update('sales_rep_beat_plan',$bit_plan_data);
                $update_details = array("store_id"=>$visit_store_id, 'modified_on' => $now);
                $this->db->where("id",$beat_plan_id)->update('sales_rep_detailed_beat_plan',$update_details);
                
                if($save=='') $dist_status = 'Place Order'; else $dist_status = 'Not Intrested';

                $update_details1 = array('zone_id'=>$visit_detail['zone_id'],
                                            'location_id'=>$visit_detail['location_id'],
                                            'area_id'=>$visit_detail['area_id'],
                                            'distributor_name'=>$visit_detail['distributor_name'],
                                            'distributor_status'=>$dist_status,
                                            'remarks'=>trim($visit_detail['remarks']));
                $this->db->where("id",$mid)->update('sales_rep_location',$update_details1); 

                $sales_rep_beat_where =  array("store_id"=>$visit_store_id,
                                                "location_id"=>$visit_detail['location_id'],
                                                "zone_id"=> $visit_detail['zone_id'],
                                                "area_id"=> $visit_detail['area_id'],
                                                "frequency"=> $frequency,
                                                "sales_rep_id"=> $sales_rep_id);
                $get_data_result = $this->db->select("*")->where($sales_rep_beat_where)->get('sales_rep_beat_plan')->result();

                if(count($get_data_result)==0) {   
                    for($j=0; $j < count($result); $j++) {
                        $newsequence = $result[$j]['sequence']+1;
                        $new_id = $result[$j]['id'];
                        $data1 = array('sequence'=>$newsequence, 'modified_on'=>$now);
                        $this->db->where('id', $new_id);
                        $this->db->update('sales_rep_beat_plan',$data1);
                    }

                    $after_temp_data1 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$detailed_sequence,
                                               'frequency'=>$frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$visit_store_id,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id'=>$visit_detail['location_id'],
                                               'zone_id' =>$visit_detail['zone_id'],
                                               'area_id' =>$visit_detail['area_id'],
                                               'created_on'=>$now);
                    $this->db->insert('sales_rep_beat_plan',$after_temp_data1);
                    $lastinsertid=$this->db->insert_id();         

                    if($lastinsertid) {   
                        if(strpos($frequency, 'Every') !== false) {
                            $explode_frequency = explode(' ',$frequency);
                            $selectfre = "select (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                            $frequency_result = $this->db->query($selectfre)->result();

                            $frequency_result = $frequency_result[0]->daymonth;
                            if($frequency_result==2) {
                               $new_frequency = 'Alternate '.$explode_frequency[1]; 
                            } else {
                                $new_frequency = 'Alternate '.$explode_frequency[1];
                            }
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();;

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$visit_store_id,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id'=>$visit_detail['location_id'],
                                               'zone_id' => $visit_detail['zone_id'],
                                               'area_id' =>$visit_detail['area_id'],
                                               'created_on'=>$now);
                            $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                        }
                        
                        if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {
                            $explode_frequency = explode(' ',$frequency);
                            $new_frequency = 'Every '.$explode_frequency[1];
                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                               'sequence'=>$max_sequnece,
                                               'frequency'=>$new_frequency,
                                               'modified_on'=>$now,
                                               'store_id'=>$visit_store_id,
                                               'status'=>'Approved',
                                               'created_by'=>$curusr,
                                               'modified_by' => $curusr,
                                               'location_id'=>$visit_detail['location_id'],
                                               'zone_id' =>$visit_detail['zone_id'],
                                               'area_id' =>$visit_detail['area_id'],
                                               'created_on'=>$now);
                            $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                        }

                        if($bit_plan_id==0) {
                            $data1 = array('bit_plan_id'=>$lastinsertid,'modified_on'=>$now);
                            $this->db->where('id', $detailed_id);
                            $this->db->update('sales_rep_detailed_beat_plan',$data1);
                        }
                    }        
                } else {
                    $update_data = array("bit_plan_id"=>$get_data_result[0]->id,'modified_on' => $now);
                    $this->db->where("id",$detailed_id)->update('sales_rep_detailed_beat_plan',$update_data);
                }
            }
        } else {
            if($visit_detail['channel_type']=='MT') {
                $detailed_insert_id=0; 
                $retailer_id = $visit_detail['reation_id'];
                if($visit_detail['follow_type']!='') {
                    $store_id = $visit_detail['reation_id'];
                    if($save=='') $dist_status = 'Not Intrested'; else $dist_status = 'Place Order';

                    $merchandiser_stock_details = $merchandiser_stock_details;

                    $data = array('is_visited'=>1, 'remarks'=>trim($visit_detail['remarks']));

                    $this->db->where('id',$visit_detail['merchandiser_stock_id'])->update('merchandiser_stock',$data);
                    $merchandiser_stock_id=$visit_detail['merchandiser_stock_id'];

                    if(count($merchandiser_stock_details)>0) {
                        for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                            $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                        }

                        $this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');
                        $visit_id = $merchandiser_stock_id;
                        $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                    }
                } else {
                    if($visit_detail['beat_plan_id']!='') {
                        $retailer_id = $visit_detail['reation_id'];

                        if($save=='Follow Up')
                            $dist_status = 'Follow Up';
                        else if($save=='Save')
                            $dist_status = 'Not Intrested';
                        else 
                            $dist_status = 'Place Order';

                        $data = array('m_id' => $sales_rep_id,
                                        'date_of_visit' => $now,
                                        'dist_id' => $retailer_id,
                                        'latitude' => $visit_detail['latitude'],
                                        'longitude' => $visit_detail['longitude'],
                                        'remarks' => trim($visit_detail['remarks']),
                                        'location_id' => $visit_detail['location_id'],
                                        'zone_id' => $visit_detail['zone_id'],
                                        'created_by' => $curusr);

                        if($save=='Follow Up') $data['followup_date']=$followup_date;
                        $this->db->insert('merchandiser_stock',$data);
                        $visit_id = $merchandiser_stock_id=$this->db->insert_id();   

                        if(count($merchandiser_stock_details)>0) {
                            for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                                $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                            }

                            $this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');
                            $visit_id = $merchandiser_stock_id;
                            $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                        }

                        $sql = "Select max(sequence) as sequence from merchandiser_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id='$sales_rep_id' and is_edit='edit' and frequency='$frequency'";
                        $get_maxcount = $this->db->query($sql)->result_array();
                        $visited_sequence = $get_maxcount[0]['sequence']+1;

                        $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and date(date_of_visit)=date(now()) and frequency='$frequency'";
                        $detailed_result = $this->db->query($sql)->result_array();
                        if(count($detailed_result)>0) {
                            $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) ";
                            $result = $this->db->query($sql)->result_array();

                            for ($j=0; $j < count($result); $j++) {
                                if($result[$j]['sequence']<$sequence && $result[$j]['is_edit']!='edit') {
                                    $newsequence = $result[$j]['sequence']+1;
                                    $new_id = $result[$j]['id'];
                                    $data = array('sequence'=>$newsequence, 'modified_on'=>$now);
                                    $this->db->where('id', $new_id);
                                    $this->db->update('merchandiser_detailed_beat_plan',$data);
                                }
                            }

                            $data = array('sequence'=>$visited_sequence,
                                            'date_of_visit'=> $now,
                                            'modified_on'=>$now,
                                            'is_edit'=>'edit');
                            $where = array('bit_plan_id'=>$merchendiser_beat_plan_id,
                                            'date(date_of_visit)'=>$now1);
                            $get_beatplan = $this->db->where($where)->select('id')->get('merchandiser_detailed_beat_plan')->result();
                            $detailed_insert_id = $get_beatplan[0]->id;

                            $this->db->where($where);
                            $this->db->update('merchandiser_detailed_beat_plan',$data);
                        } else {
                            $sql = "select * from merchandiser_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency'";
                            $result = $this->db->query($sql)->result_array();
                            for ($j=0; $j < count($result); $j++) { 
                                if($result[$j]['sequence']<$sequence) {
                                    $new_id = $result[$j]['id'];
                                    $store_id = $result[$j]['store_id'];
                                    $newsequence = $result[$j]['sequence']+1;
                                    $zone_id = $result[$j]['zone_id'];
                                    $area_id = $result[$j]['area_id'];
                                    $location_id = $result[$j]['location_id'];
                                    $data = array('date_of_visit'=> $now,
                                          'sales_rep_id'=>$sales_rep_id,
                                          'sequence'=>$newsequence,
                                          'frequency'=>$frequency,
                                          'modified_on'=>$now,
                                          'bit_plan_id'=>$new_id,
                                          'store_id'=>$store_id,
                                          'zone_id'=>$zone_id,
                                          'location_id'=>$location_id,
                                          'status'=>'Approved');
                                    $this->db->insert('merchandiser_detailed_beat_plan',$data);
                                } else if($result[$j]['sequence']>$sequence) {
                                    $new_id = $result[$j]['id'];
                                    $store_id = $result[$j]['store_id'];
                                    $newsequence = $result[$j]['sequence'];
                                    $zone_id = $result[$j]['zone_id'];
                                    $area_id = $result[$j]['area_id'];
                                    $location_id = $result[$j]['location_id'];
                                    $data = array('date_of_visit'=> $now,
                                          'sales_rep_id'=>$sales_rep_id,
                                          'sequence'=>$newsequence,
                                          'frequency'=>$frequency,
                                          'modified_on'=>$now,
                                          'bit_plan_id'=>$new_id,
                                          'store_id'=>$store_id,
                                          'zone_id'=>$zone_id,
                                          'location_id'=>$location_id,
                                          'status'=>'Approved');
                                    $this->db->insert('merchandiser_detailed_beat_plan',$data);
                                }
                            }

                            $sql = "select * from merchandiser_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and sequence='$sequence'";
                            $result = $this->db->query($sql)->result_array();
                            $data = array('date_of_visit'=> $now,
                                            'sales_rep_id'=>$sales_rep_id,
                                            'sequence'=>$visited_sequence,
                                            'is_edit'=>'edit',
                                            'frequency'=>$frequency,
                                            'modified_on'=>$now,
                                            'bit_plan_id'=>$result[0]['id'],
                                            'store_id'=>$result[0]['store_id'],
                                            'zone_id'=>$result[0]['zone_id'],
                                            'location_id'=>$result[0]['location_id'],
                                            'status'=>'Approved');
                            $this->db->insert('merchandiser_detailed_beat_plan',$data);
                            $detailed_insert_id = $this->db->insert_id();
                        }

                        $ispermenant ='Yes';    
                        if($ispermenant=='Yes' || $place_order=='Yes') {
                            $count_spdb_sql = "select count(*) as count from merchandiser_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                            $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();
                            if($result_spdb_count[0]['count']>0) {
                                $count = $result_spdb_count[0]['count'];
                                $sequence_spdb_sql = "select sequence,id from merchandiser_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                                $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                                $sequence_spdb = $sequence_result[0]['sequence'];  

                                $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                            } else {
                                $condition = "m2.sequence";    
                            }

                            $sql = "UPDATE merchandiser_beat_plan m1
                                    INNER JOIN merchandiser_detailed_beat_plan m2 ON 
                                    m1.id=m2.bit_plan_id
                                    SET m1.sequence=$condition
                                    Where m1.sales_rep_id=$sales_rep_id 
                                    and m1.frequency='$frequency' and bit_plan_id<>0
                                    and date(m2.date_of_visit)=date(now())";
                            $result = $this->db->query($sql);
                        }
                    } else {
                        $sql = "Select max(sequence) as sequence from merchandiser_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id='$sales_rep_id' and is_edit='edit' and frequency='$frequency'";
                        $get_maxcount = $this->db->query($sql)->result_array();
                        $visited_sequence = $get_maxcount[0]['sequence']+1;

                        $store_id = $visit_detail['reation_id'];

                        if($save=='') {
                            if($visit_detail!=null) {
                                if($save!='Follow Up') {
                                    $sql = "Select count(*) as sequence from merchandiser_beat_plan WHERE frequency='$frequency' and sales_rep_id=$sales_rep_id";
                                    $get_maxcount_sales_rep = $this->db->query($sql)->result_array();
                                    
                                    if(count($get_maxcount_sales_rep)==0) {
                                        $visited_sequence_sales_re = $get_maxcount_sales_rep[0]['sequence']+1;
                                        $data1 = array('sales_rep_id'=>$sales_rep_id,
                                                        'sequence'=>$visited_sequence_sales_re,
                                                        'frequency'=>$frequency,
                                                        'modified_on'=>$now,
                                                        'store_id'=>$store_id,
                                                        'status'=>'Approved',
                                                        'created_by'=>$curusr,
                                                        'modified_by' => $curusr,
                                                        'location_id' => $visit_detail['location_id'],
                                                        'zone_id' => $visit_detail['zone_id'],
                                                        'created_on'=>$now);
                                        $this->db->insert('merchandiser_beat_plan',$data1);
                                        $lastinsertid=$this->db->insert_id();
                                    } else {
                                        if($visited_sequence==1) {
                                            $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                                            $result = $this->db->query($sql)->result_array();
                                            for ($j=0; $j < count($result); $j++) {
                                                $new_id = $result[$j]['id'];
                                                $store_id1 = $result[$j]['store_id'];
                                                $location_id = $result[$j]['location_id'];
                                                $zone_id = $result[$j]['zone_id'];
                                                $newsequence = $result[$j]['sequence']+1;
                                                $data22 = array('date_of_visit'=> $now,
                                                                'sales_rep_id'=>$sales_rep_id,
                                                                'sequence'=>$newsequence,
                                                                'frequency'=>$frequency,
                                                                'modified_on'=>$now,
                                                                'bit_plan_id'=>$new_id,
                                                                'store_id'=>$store_id1,
                                                                'zone_id'=>$zone_id,
                                                                'location_id'=>$location_id,
                                                                'status'=>'Approved');
                                                $this->db->insert('merchandiser_detailed_beat_plan',$data22);
                                            }
                                        } else {
                                            $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>='$visited_sequence'";
                                            $result = $this->db->query($sql)->result_array();
                                            for ($j=0; $j < count($result); $j++) {   
                                                $newsequence = $result[$j]['sequence']+1;
                                                $new_id = $result[$j]['id'];
                                                $data1 = array('sequence'=>$newsequence, 'modified_on'=>$now);
                                                $this->db->where('id', $new_id);
                                                $this->db->update('merchandiser_detailed_beat_plan',$data1);
                                            }
                                        }

                                        $data1 = array('sales_rep_id'=>$sales_rep_id,
                                                        'sequence'=>$visited_sequence,
                                                        'frequency'=>$frequency,
                                                        'modified_on'=>$now,
                                                        'store_id'=>$store_id,
                                                        'status'=>'Approved',
                                                        'created_by'=>$curusr,
                                                        'modified_by' => $curusr,
                                                        'location_id' => $visit_detail['location_id'],
                                                        'zone_id' => $visit_detail['zone_id'],
                                                        'created_on'=>$now);
                                        $this->db->insert('merchandiser_beat_plan',$data1);
                                        $lastinsertid = $this->db->insert_id();
                                    }
                                    
                                    if($lastinsertid) {
                                        if (strpos($frequency, 'Every') !== false) {
                                            $explode_frequency = explode(' ',$frequency);
                                            $selectfre = "select (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                                            $frequency_result = $this->db->query($selectfre)->result();
                                            $frequency_result = $frequency_result[0]->daymonth;
                                            if($frequency_result==2) {
                                               $new_frequency = 'Alternate '.$explode_frequency[1]; 
                                            } else {
                                                $new_frequency = 'Alternate '.$explode_frequency[1];
                                            }

                                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('merchandiser_beat_plan')->result_array();

                                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                                            $after_temp_data2 = array(
                                                                    'sales_rep_id'=>$sales_rep_id,
                                                                    'sequence'=>$max_sequnece,
                                                                    'frequency'=>$new_frequency,
                                                                    'modified_on'=>$now,
                                                                    'store_id'=>$store_id,
                                                                    'status'=>'Approved',
                                                                    'created_by'=>$curusr,
                                                                    'modified_by' => $curusr,
                                                                    'location_id' => $visit_detail['location_id'],
                                                                    'zone_id' => $visit_detail['zone_id'],
                                                                    'created_on'=>$now);
                                            $this->db->insert('merchandiser_beat_plan',$after_temp_data2);
                                        }
                                        
                                        if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {
                                            $explode_frequency = explode(' ',$frequency);
                                            $new_frequency = 'Every '.$explode_frequency[1];
                                            $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('merchandiser_beat_plan')->result_array();

                                            $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                                            $after_temp_data2 = array('sales_rep_id'=>$sales_rep_id,
                                                                        'sequence'=>$max_sequnece,
                                                                        'frequency'=>$new_frequency,
                                                                        'modified_on'=>$now,
                                                                        'store_id'=>$store_id,
                                                                        'status'=>'Approved',
                                                                        'created_by'=>$curusr,
                                                                        'modified_by' => $curusr,
                                                                        'location_id' => $visit_detail['location_id'],
                                                                        'zone_id' => $visit_detail['zone_id'],
                                                                        'created_on'=>$now); 
                                            $this->db->insert('merchandiser_beat_plan',$after_temp_data2);
                                        }
                                        
                                        $data2 = array('sales_rep_id'=>$sales_rep_id,
                                                        'sequence'=>$visited_sequence,
                                                        'frequency'=>$frequency,
                                                        'modified_on'=>$now,
                                                        'store_id'=>$store_id,
                                                        'status'=>'Approved',
                                                        'modified_on'=>$now,
                                                        'zone_id'=>$visit_detail['zone_id'],
                                                        'location_id'=>$visit_detail['location_id'],
                                                        'date_of_visit' => $now);
                                        $data2['bit_plan_id']=$lastinsertid;    
                                        $data2['is_edit']='edit';
                                        $this->db->insert('merchandiser_detailed_beat_plan',$data2);
                                        $detailed_insert_id = $this->db->insert_id();
                                    }
                                }
                                
                                if(isset($followup_date)) {
                                    $followup_date = $followup_date;
                                } else {
                                    $followup_date = NULL;
                                }

                                $data = array('m_id' => $sales_rep_id,
                                                'date_of_visit' => $now,
                                                'dist_id' => $store_id,
                                                'latitude' => $visit_detail['latitude'],
                                                'longitude' => $visit_detail['longitude'],
                                                'remarks' => trim($visit_detail['remarks']),
                                                'location_id' => $visit_detail['location_id'],
                                                'zone_id' => $visit_detail['zone_id'],
                                                'created_by' => $curusr,
                                                'followup_date'=>$followup_date);
                                $this->db->insert('merchandiser_stock',$data);
                                $visit_id = $id=$this->db->insert_id();
                            }
                        }

                        if($save=='Follow Up') {
                            $data = array(
                                        'm_id' => $sales_rep_id,
                                        'date_of_visit' => $now,
                                        'dist_id' => $store_id,
                                        'latitude' => $visit_detail['latitude'],
                                        'longitude' => $visit_detail['longitude'],
                                        'remarks' => trim($visit_detail['remarks']),
                                        'location_id' => $visit_detail['location_id'],
                                        'zone_id' => $visit_detail['zone_id'],
                                        'created_by' => $curusr,
                                        'followup_date'=>$followup_date
                                    );
                            $this->db->insert('merchandiser_stock',$data);
                            $visit_id = $id=$this->db->insert_id();
                        }
                       
                        if($save=='Save') {
                            if($visited_sequence==1) {
                                $sql = "select * from merchandiser_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency'";
                                $result = $this->db->query($sql)->result_array();
                                for ($j=0; $j < count($result); $j++) {
                                    $new_id = $result[$j]['id'];
                                    $store_id1 = $result[$j]['store_id'];
                                    $zone_id = $result[$j]['zone_id'];
                                    $location_id = $result[$j]['location_id'];
                                    $newsequence = $result[$j]['sequence']+1;
                                    $data22 = array('date_of_visit'=> $now,
                                                    'sales_rep_id'=>$sales_rep_id,
                                                    'sequence'=>$newsequence,
                                                    'frequency'=>$frequency,
                                                    'modified_on'=>$now,
                                                    'bit_plan_id'=>$new_id,
                                                    'store_id'=>$store_id1,
                                                    'location_id' => $location_id,
                                                    'zone_id' => $zone_id,
                                                    'status'=>'Approved');
                                    $this->db->insert('merchandiser_detailed_beat_plan',$data22);
                                   
                                }
                            } else {
                                $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>='$visited_sequence'";
                                $result = $this->db->query($sql)->result_array();
                                for ($j=0; $j < count($result); $j++) {   
                                    $newsequence = $result[$j]['sequence']+1;
                                    $new_id = $result[$j]['id'];
                                    $data1 = array('sequence'=>$newsequence, 'modified_on'=>$now);
                                    $this->db->where('id', $new_id);
                                    $this->db->update('merchandiser_detailed_beat_plan',$data1);
                                }
                            }

                            $data2 = array('sales_rep_id'=>$sales_rep_id,
                                            'sequence'=>$visited_sequence,
                                            'frequency'=>$frequency,
                                            'modified_on'=>$now,
                                            'store_id'=>$store_id,
                                            'status'=>'Approved',
                                            'modified_on'=>$now,
                                            'zone_id'=>$visit_detail['zone_id'],
                                            'location_id'=>$visit_detail['location_id'],
                                            'date_of_visit' => $now);  

                            $data2['bit_plan_id']=0;    
                            $data2['is_edit']='edit';
                            $this->db->insert('merchandiser_detailed_beat_plan',$data2);
                            $detailed_insert_id = $this->db->insert_id();

                            $data = array(
                                        'm_id' => $sales_rep_id,
                                        'date_of_visit' => $now,
                                        'dist_id' => $store_id,
                                        'latitude' => $visit_detail['latitude'],
                                        'longitude' => $visit_detail['longitude'],
                                        'remarks' => trim($visit_detail['remarks']),
                                        'location_id' => $visit_detail['location_id'],
                                        'zone_id' => $visit_detail['zone_id'],
                                        'created_by' => $curusr,
                            );
                            $this->db->insert('merchandiser_stock',$data);
                            $visit_id = $id=$this->db->insert_id(); 
                        } else {
                            $ispermenant  ='Yes';    
                            if($ispermenant=='Yes' || $place_order=='Yes') {
                                $count_spdb_sql = "select count(*) as count from merchandiser_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                                $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();

                                if($result_spdb_count[0]['count']>0) {
                                    $count = $result_spdb_count[0]['count'];
                                    $sequence_spdb_sql = "select sequence,id from merchandiser_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                                    $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                                    $sequence_spdb = $sequence_result[0]['sequence'];  

                                    $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                                } else {
                                    $condition = "m2.sequence";    
                                }

                                $sql = "UPDATE merchandiser_beat_plan m1
                                        INNER JOIN merchandiser_detailed_beat_plan m2 ON 
                                        m1.id=m2.bit_plan_id
                                        SET m1.sequence=$condition
                                        Where m1.sales_rep_id=$sales_rep_id 
                                        and m1.frequency='$frequency' and bit_plan_id<>0
                                        and date(m2.date_of_visit)=date(now())";
                                $result = $this->db->query($sql);
                            }
                        }

                        $merchandiser_stock_details = $merchandiser_stock_details;
                        if(count($merchandiser_stock_details)>0) {
                            for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                                $merchandiser_stock_details[$j]['merchandiser_stock_id']=$visit_id;
                            }
                            $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                        }
                    }  
                }

                if($detailed_insert_id!=0) {
                    $update_sales_location = array("detailed_bit_plan_id"=>$detailed_insert_id);
                    $this->db->where("id",$visit_id)->update('merchandiser_stock',$update_sales_location); 
                }
            } else {
                if($visit_detail['follow_type']!='') {
                    if($save=='') $dist_status = 'Place Order';
                    else $dist_status = 'Not Intrested';

                    $retailer_id = $visit_detail['store_id'];

                    $data = array('is_visited'=>1, 'remarks'=>trim($visit_detail['remarks']));

                    $this->db->where('id',$visit_detail['sales_rep_loc_id'])->update('sales_rep_location',$data);
                    $visit_id = $sales_rep_loc_id = $visit_detail['sales_rep_loc_id'];  

                    $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                    $this->db->where('sales_rep_loc_id',$visit_detail['sales_rep_loc_id'])->delete('sales_rep_distributor_opening_stock');

                    $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);
                } else {
                    // If bitplan d is old and isedit is empty
                    $detailed_insert_id=0; 

                    if($visit_detail['beat_plan_id']!='') {
                        $retailer_id = $visit_detail['store_id'];
                        if($save=='Follow Up')
                            $dist_status = 'Follow Up';
                        else if($save=='Save')
                            $dist_status = 'Not Intrested';
                        else 
                            $dist_status = 'Place Order';

                        $data = array(
                                'sales_rep_id' => $sales_rep_id,
                                'date_of_visit' => $now1,
                                'distributor_type' => $visit_detail['distributor_types'],
                                'distributor_id' => $visit_detail['store_id'],
                                'distributor_name' => $visit_detail['distributor_name'],
                                'distributor_status' => $dist_status,
                                'latitude' => $visit_detail['latitude'],
                                'longitude' => $visit_detail['longitude'],
                                'status' => 'Approved',
                                'remarks' => $visit_detail['remarks'],
                                'modified_by' => $curusr,
                                'modified_on' => $now,
                                'zone_id' => $visit_detail['zone_id'],
                                'area_id' => $visit_detail['area_id'],
                                'location_id' => $visit_detail['location_id'],
                                'frequency'=>$frequency
                            );
                        $data['created_by']=$curusr;
                        $data['created_on']=$now;
                        if($save=='Follow Up') $data['followup_date']=$followup_date;

                        $this->db->insert('sales_rep_location',$data);
                        $visit_id = $sales_rep_loc_id=$this->db->insert_id();    

                        $sales_rep_stock_detail = $sales_rep_stock_detail;
                        $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                        $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);

                        // Add beatplan
                        $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id='$sales_rep_id' and is_edit='edit' and frequency='$frequency'";
                        $get_maxcount = $this->db->query($sql)->result_array();
                        $visited_sequence = $get_maxcount[0]['sequence']+1;

                        $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and date(date_of_visit)=date(now()) and frequency='$frequency'";
                        $detailed_result = $this->db->query($sql)->result_array();

                        if(count($detailed_result)>0) {
                            $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and date(date_of_visit)=date(now()) ";
                            $result = $this->db->query($sql)->result_array();
                            for ($j=0; $j < count($result); $j++) {
                                if($result[$j]['sequence']<$sequence && $result[$j]['is_edit']!='edit') {
                                    $newsequence = $result[$j]['sequence']+1;
                                    $new_id = $result[$j]['id'];
                                    $data = array('sequence'=>$newsequence, 'modified_on'=>$now);
                                    $this->db->where('id', $new_id);
                                    $this->db->update('sales_rep_detailed_beat_plan',$data);
                                }
                            }


                            $data = array('sequence'=>$visited_sequence,
                                            'date_of_visit'=> $now,
                                            'modified_on'=>$now,
                                            'is_edit'=>'edit');

                            if($visit_detail['beat_plan_id']=='0') {
                                $where = array('id'=>$id,
                                                'bit_plan_id'=>$merchendiser_beat_plan_id,
                                                'date(date_of_visit)'=>$now1);
                            } else {
                                $where = array('bit_plan_id'=>$merchendiser_beat_plan_id,
                                                'date(date_of_visit)'=>$now1);
                            }

                            $this->db->where($where);
                            $this->db->update('sales_rep_detailed_beat_plan',$data);

                            $get_beatplan = $this->db->where($where)->select('id')->get('sales_rep_detailed_beat_plan')->result();
                            $detailed_insert_id = $get_beatplan[0]->id;
                        } else {
                            $sql = "select * from sales_rep_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency'";
                            $result = $this->db->query($sql)->result_array();
                            for ($j=0; $j < count($result); $j++) { 
                                if($result[$j]['sequence']<$sequence) {
                                    $new_id = $result[$j]['id'];
                                    $store_id = $result[$j]['store_id'];
                                    $newsequence = $result[$j]['sequence']+1;
                                    $zone_id = $result[$j]['zone_id'];
                                    $area_id = $result[$j]['area_id'];
                                    $location_id = $result[$j]['location_id'];
                                    $data = array('date_of_visit'=> $now,
                                                    'sales_rep_id'=>$sales_rep_id,
                                                    'sequence'=>$newsequence,
                                                    'frequency'=>$frequency,
                                                    'modified_on'=>$now,
                                                    'bit_plan_id'=>$new_id,
                                                    'store_id'=>$store_id,
                                                    'zone_id'=>$zone_id,
                                                    'area_id'=>$area_id,
                                                    'location_id'=>$location_id,
                                                    'status'=>'Approved');
                                    $this->db->insert('sales_rep_detailed_beat_plan',$data);
                                } else if($result[$j]['sequence']>$sequence) {
                                    $new_id = $result[$j]['id'];
                                    $store_id = $result[$j]['store_id'];
                                    $newsequence = $result[$j]['sequence'];
                                    $zone_id = $result[$j]['zone_id'];
                                    $area_id = $result[$j]['area_id'];
                                    $location_id = $result[$j]['location_id'];
                                    $data = array('date_of_visit'=> $now,
                                          'sales_rep_id'=>$sales_rep_id,
                                          'sequence'=>$newsequence,
                                          'frequency'=>$frequency,
                                          'modified_on'=>$now,
                                          'bit_plan_id'=>$new_id,
                                          'store_id'=>$store_id,
                                          'zone_id'=>$zone_id,
                                          'area_id'=>$area_id,
                                          'location_id'=>$location_id,
                                          'status'=>'Approved');
                                    $this->db->insert('sales_rep_detailed_beat_plan',$data);
                                }
                            }

                            $sql = "select * from sales_rep_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and sequence='$sequence' ";
                            $result = $this->db->query($sql)->result_array();
                            $data = array('date_of_visit'=> $now,
                                          'sales_rep_id'=>$sales_rep_id,
                                          'sequence'=>$visited_sequence,
                                          'is_edit'=>'edit',
                                          'frequency'=>$frequency,
                                          'modified_on'=>$now,
                                          'bit_plan_id'=>$result[0]['id'],
                                          'store_id'=>$result[0]['store_id'],
                                          'zone_id'=>$result[0]['zone_id'],
                                          'area_id'=>$result[0]['area_id'],
                                          'location_id'=>$result[0]['location_id'],
                                          'status'=>'Approved');
                            $this->db->insert('sales_rep_detailed_beat_plan',$data);
                            $detailed_insert_id = $this->db->insert_id();
                        }

                        $ispermenant='Yes';    
                        if($ispermenant=='Yes' || $place_order=='Yes') {
                            $count_spdb_sql = "select count(*) as count from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                            $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();

                            if($result_spdb_count[0]['count']>0) {
                                $count = $result_spdb_count[0]['count'];
                                $sequence_spdb_sql = "select sequence,id from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                                $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                                $sequence_spdb = $sequence_result[0]['sequence'];  

                                $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                            } else {
                                $condition = "m2.sequence";    
                            }

                            $sql = "UPDATE sales_rep_beat_plan m1
                                    INNER JOIN sales_rep_detailed_beat_plan m2 ON 
                                    m1.id=m2.bit_plan_id
                                    SET m1.sequence=$condition
                                    Where m1.sales_rep_id=$sales_rep_id 
                                    and m1.frequency='$frequency' and bit_plan_id<>0
                                    and date(m2.date_of_visit)=date(now())";
                            $result = $this->db->query($sql);
                        }

                        $retailer_id =  $visit_detail['distributor_id'];

                        $store_id_d = explode('_',$visit_detail['distributor_id']);
                        $store_id = $store_id_d[1];
                        $latitude = $visit_detail['latitude'];
                        $longitude = $visit_detail['longitude'];
                        if(isset($latitude) && isset($longitude)){
                            if($latitude!='0' && $latitude!='null' && $latitude!='' && $longitude!='0' && $longitude!='null' && $longitude!=''){
                                if($store_id_d[0]=='d'){
                                    $dist_table_name = "distributor_master";
                                } else {
                                    $dist_table_name = "sales_rep_distributors";
                                }
                                $sql = "select * from ".$dist_table_name." where id='$store_id'";
                                $dist_res = $this->db->query($sql)->result();
                                if(count($dist_res)>0){
                                    $lat = $dist_res[0]->latitude;
                                    $long = $dist_res[0]->longitude;
                                    if($lat=='0' || $lat=='null' || $lat=='' || $long=='0' || $long=='null' || $long!=''){
                                        $data_dist = array(
                                                    'modified_by' => $curusr,
                                                    'modified_on' => $now,
                                                    'latitude' =>    $visit_detail['latitude'],
                                                    'longitude' =>   $visit_detail['longitude']
                                                );
                                        $this->db->where('id', $store_id)->update($dist_table_name,$data_dist);
                                    }
                                }
                            }
                        }
                    } else {
                        $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id='$sales_rep_id' and is_edit='edit' and frequency='$frequency'";
                        $get_maxcount = $this->db->query($sql)->result_array();
                        $visited_sequence = $get_maxcount[0]['sequence']+1;
                        $retailer_id = 0;

                        if($visit_detail!=null) {
                            if($visit_detail['distributor_types']=='New') {
                                $retailer_details = array(
                                    'sales_rep_id' => $sales_rep_id,
                                    'distributor_name' => $visit_detail['distributor_name'],
                                    'modified_by' => $curusr,
                                    'modified_on' => $now,
                                    'location_id' => $visit_detail['location_id'],
                                    'zone_id' =>$visit_detail['zone_id'],
                                    'area_id' =>$visit_detail['area_id'],
                                    'latitude' =>$visit_detail['latitude'],
                                    'longitude' =>$visit_detail['longitude'],
                                    'gst_number' =>$retailer_detail['gst_number'],
                                    'margin' =>  $retailer_detail['margin'],
                                    'remarks' =>  $retailer_detail['retailer_remarks'],
                                    'master_distributor_id'=>$retailer_detail['master_distributor_id'],
                                    'status'=>'Approved'
                                );

                                $this->db->insert('sales_rep_distributors',$retailer_details);
                                $insertid=$this->db->insert_id();

                                $action='Sales Rep Distributor Created.';
                                $store_id = $insertid;
                                $retailer_id = 's_'.$store_id;  
                            } else {   
                                $retailer_id =  $visit_detail['distributor_id'];

                                $store_id_d = explode('_',$visit_detail['distributor_id']);
                                $store_id = $store_id_d[1];
                                $latitude = $visit_detail['latitude'];
                                $longitude = $visit_detail['longitude'];
                                if(isset($latitude) && isset($longitude)){
                                    if($latitude!='0' && $latitude!='null' && $latitude!='' && $longitude!='0' && $longitude!='null' && $longitude!=''){
                                        if($store_id_d[0]=='d'){
                                            $dist_table_name = "distributor_master";
                                        } else {
                                            $dist_table_name = "sales_rep_distributors";
                                        }
                                        $sql = "select * from ".$dist_table_name." where id='$store_id'";
                                        $dist_res = $this->db->query($sql)->result();
                                        if(count($dist_res)>0){
                                            $lat = $dist_res[0]->latitude;
                                            $long = $dist_res[0]->longitude;
                                            if($lat=='0' || $lat=='null' || $lat=='' || $long=='0' || $long=='null' || $long!=''){
                                                $data_dist = array(
                                                            'modified_by' => $curusr,
                                                            'modified_on' => $now,
                                                            'latitude' =>    $visit_detail['latitude'],
                                                            'longitude' =>   $visit_detail['longitude']
                                                        );
                                                $this->db->where('id', $store_id)->update($dist_table_name,$data_dist);
                                            }
                                        }
                                    }
                                }
                            }

                            if($save!='Follow Up') {   
                                if($retailer_id) { 
                                    if($ispermenant=='Yes' || $save=='') {
                                        $sql = "Select count(*) as sequence from sales_rep_beat_plan WHERE frequency='$frequency' and sales_rep_id='$sales_rep_id'";

                                        $get_maxcount_sales_rep = $this->db->query($sql)->result_array();
                                        if(count($get_maxcount_sales_rep)==0) {
                                            $visited_sequence_sales_re = $get_maxcount_sales_rep[0]['sequence']+1;
                                            $data1 = array('sales_rep_id'=>$sales_rep_id,
                                                      'sequence'=>$visited_sequence_sales_re,
                                                      'frequency'=>$frequency,
                                                      'modified_on'=>$now,
                                                      'store_id'=>$retailer_id,
                                                      'status'=>'Approved',
                                                      'created_by'=>$curusr,
                                                      'modified_by' => $curusr,
                                                      'location_id' => $visit_detail['location_id'],
                                                      'zone_id' => $visit_detail['zone_id'],
                                                      'area_id' => $visit_detail['area_id'],
                                                      'created_on'=>$now);
                                            $this->db->insert('sales_rep_beat_plan',$data1);
                                            $lastinsertid=$this->db->insert_id();
                                        } else {
                                            $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and date(date_of_visit)=date(now())";
                                            $result = $this->db->query($sql)->result_array();

                                            if($visited_sequence==1 && count($result)==0) {
                                                $sql = "select * from sales_rep_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency'";
                                                $result = $this->db->query($sql)->result_array();
                                                for ($j=0; $j < count($result); $j++) {
                                                    $new_id = $result[$j]['id'];
                                                    $store_id1 = $result[$j]['store_id'];
                                                    $zone_id = $result[$j]['zone_id'];
                                                    $area_id = $result[$j]['area_id'];
                                                    $location_id = $result[$j]['location_id'];
                                                    $newsequence = $result[$j]['sequence']+1;
                                                    $data22 = array('date_of_visit'=> $now,
                                                          'sales_rep_id'=>$sales_rep_id,
                                                          'sequence'=>$newsequence,
                                                          'frequency'=>$frequency,
                                                          'modified_on'=>$now,
                                                          'bit_plan_id'=>$new_id,
                                                          'store_id'=>$store_id1,
                                                          'location_id' => $location_id,
                                                           'zone_id' => $zone_id,
                                                           'area_id' => $area_id,
                                                          'status'=>'Approved');
                                                    $this->db->insert('sales_rep_detailed_beat_plan',$data22);
                                                }
                                            } else {
                                                $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>='$visited_sequence'";
                                                $result = $this->db->query($sql)->result_array();
                                                for ($j=0; $j < count($result); $j++) {   
                                                    $newsequence = $result[$j]['sequence']+1;
                                                    $new_id = $result[$j]['id'];
                                                    $data1 = array('sequence'=>$newsequence, 'modified_on'=>$now);
                                                    $this->db->where('id', $new_id);
                                                    $this->db->update('sales_rep_detailed_beat_plan',$data1);
                                                }
                                            }

                                            $data1 = array('sales_rep_id'=>$sales_rep_id,
                                                          'sequence'=>$visited_sequence,
                                                          'frequency'=>$frequency,
                                                          'modified_on'=>$now,
                                                          'store_id'=>$retailer_id,
                                                          'status'=>'Approved',
                                                          'created_by'=>$curusr,
                                                          'modified_by' => $curusr,
                                                          'location_id' => $visit_detail['location_id'],
                                                          'zone_id' => $visit_detail['zone_id'],
                                                          'area_id' => $visit_detail['area_id'],
                                                          'created_on'=>$now);
                                            $this->db->insert('sales_rep_beat_plan',$data1);
                                            $detailed_insert_id = $lastinsertid=$this->db->insert_id();
                                        }

                                        if($lastinsertid) {
                                            if (strpos($frequency, 'Every') !== false) {
                                                $explode_frequency = explode(' ',$frequency);
                                                $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                                                $frequency_result = $this->db->query($selectfre)->result();
                                                $frequency_result = $frequency_result[0]->daymonth;
                                                if($frequency_result==2) {
                                                   $new_frequency = 'Alternate '.$explode_frequency[1]; 
                                                } else {
                                                    // $new_frequency = 'Alternate2 '.$explode_frequency[1]; 
                                                    $new_frequency = 'Alternate '.$explode_frequency[1];
                                                }

                                                $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                                                $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                                                $after_temp_data2 = array(
                                                               'sales_rep_id'=>$sales_rep_id,
                                                               'sequence'=>$max_sequnece,
                                                               'frequency'=>$new_frequency,
                                                               'modified_on'=>$now,
                                                               'store_id'=>$retailer_id,
                                                               'status'=>'Approved',
                                                               'created_by'=>$curusr,
                                                               'modified_by' => $curusr,
                                                               'location_id' => $visit_detail['location_id'],
                                                               'zone_id' => $visit_detail['zone_id'],
                                                               'area_id' => $visit_detail['area_id'],
                                                               'created_on'=>$now);
                                                $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                                            }
                                            
                                            if (strpos($frequency, 'Alternate') !== false || strpos($frequency, 'Alternate2') !== false) {
                                                $explode_frequency = explode(' ',$frequency);
                                                $new_frequency = 'Every '.$explode_frequency[1];
                                                $rmax_sequnece = $this->db->select('max(sequence) as sequence')->where('frequency',$new_frequency)->get('sales_rep_beat_plan')->result_array();

                                                $max_sequnece = $rmax_sequnece[0]['sequence']+1;
                                                $after_temp_data2 = array(
                                                               'sales_rep_id'=>$sales_rep_id,
                                                               'sequence'=>$max_sequnece,
                                                               'frequency'=>$new_frequency,
                                                               'modified_on'=>$now,
                                                               'store_id'=>$retailer_id,
                                                               'status'=>'Approved',
                                                               'created_by'=>$curusr,
                                                               'modified_by' => $curusr,
                                                               'location_id' => $visit_detail['location_id'],
                                                               'zone_id' => $visit_detail['zone_id'],
                                                               'area_id' => $visit_detail['area_id'],
                                                               'created_on'=>$now); 
                                                $this->db->insert('sales_rep_beat_plan',$after_temp_data2);
                                            }

                                            $data2 = array('sales_rep_id'=>$sales_rep_id,
                                                      'sequence'=>$visited_sequence,
                                                      'frequency'=>$frequency,
                                                      'modified_on'=>$now,
                                                      'store_id'=>$retailer_id,
                                                      'location_id' => $visit_detail['location_id'],
                                                      'zone_id' => $visit_detail['zone_id'],
                                                      'area_id' => $visit_detail['area_id'],
                                                      'status'=>'Approved',
                                                      'modified_on'=>$now,
                                                      'date_of_visit' => $now);
                                            $data2['bit_plan_id']=$lastinsertid;    
                                            $data2['is_edit']='edit';
                                            $this->db->insert('sales_rep_detailed_beat_plan',$data2);
                                            $detailed_insert_id = $this->db->insert_id();
                                        }

                                        $count_spdb_sql = "select count(*) as count from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                                        $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();

                                        if($result_spdb_count[0]['count']>0) {
                                            $count = $result_spdb_count[0]['count'];
                                            $sequence_spdb_sql = "select sequence,id from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                                            $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                                            $sequence_spdb = $sequence_result[0]['sequence'];  

                                            $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                                        } else {
                                            $condition = "m2.sequence";    
                                        }

                                        $sql = "UPDATE sales_rep_beat_plan m1
                                                INNER JOIN sales_rep_detailed_beat_plan m2 ON 
                                                m1.id=m2.bit_plan_id
                                                SET m1.sequence=$condition
                                                Where m1.sales_rep_id=$sales_rep_id 
                                                and m1.frequency='$frequency' and bit_plan_id<>0
                                                and date(m2.date_of_visit)=date(now())";
                                        $result = $this->db->query($sql);
                                    } else {
                                        $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency' and date(date_of_visit)=date(now())";
                                        $result = $this->db->query($sql)->result_array();

                                        if($visited_sequence==1 && count($result)==0) {
                                            $sql = "select * from sales_rep_beat_plan Where sales_rep_id='$sales_rep_id' and frequency='$frequency'";
                                            $result = $this->db->query($sql)->result_array();
                                            for ($j=0; $j < count($result); $j++) {
                                                $new_id = $result[$j]['id'];
                                                $store_id1 = $result[$j]['store_id'];
                                                $zone_id = $result[$j]['zone_id'];
                                                $area_id = $result[$j]['area_id'];
                                                $location_id = $result[$j]['location_id'];
                                                $newsequence = $result[$j]['sequence']+1;
                                                $data22 = array('date_of_visit'=> $now,
                                                      'sales_rep_id'=>$sales_rep_id,
                                                      'sequence'=>$newsequence,
                                                      'frequency'=>$frequency,
                                                      'modified_on'=>$now,
                                                      'bit_plan_id'=>$new_id,
                                                      'store_id'=>$store_id1,
                                                      'location_id' => $location_id,
                                                       'zone_id' => $zone_id,
                                                       'area_id' => $area_id,
                                                      'status'=>'Approved');
                                                $this->db->insert('sales_rep_detailed_beat_plan',$data22);
                                            }
                                        }

                                        $data2 = array('sales_rep_id'=>$sales_rep_id,
                                                        'sequence'=>$visited_sequence,
                                                        'frequency'=>$frequency,
                                                        'modified_on'=>$now,
                                                        'store_id'=>$retailer_id,
                                                        'status'=>'Approved',
                                                        'modified_on'=>$now,
                                                        'date_of_visit' => $now,
                                                        'location_id' => $visit_detail['location_id'],
                                                        'zone_id' => $visit_detail['zone_id'],
                                                        'area_id' => $visit_detail['area_id']);
                                        $data2['bit_plan_id']=0;    
                                        $data2['is_edit']='edit';
                                        $this->db->insert('sales_rep_detailed_beat_plan',$data2);
                                        $detailed_insert_id = $this->db->insert_id();
                                    }
                                }
                            }
                            
                            if($save=='') $dist_status = 'Place Order';
                            else $dist_status = 'Not Intrested';

                            if(isset($followup_date)) {
                                $followup_date = $followup_date;
                            } else {
                                $followup_date=NULL;
                            }

                            $data = array(
                                'sales_rep_id' => $sales_rep_id,
                                'date_of_visit' => $now1,
                                'distributor_type' => $visit_detail['distributor_types'],
                                'distributor_id' =>$retailer_id,
                                'distributor_name' => $visit_detail['distributor_name'],
                                'distributor_status' => $dist_status,
                                'latitude' => $visit_detail['latitude'],
                                'longitude' => $visit_detail['longitude'],
                                'status' => 'Approved',
                                'remarks' => $visit_detail['remarks'],
                                'modified_by' => $curusr,
                                'modified_on' => $now,
                                'zone_id' => $visit_detail['zone_id'],
                                'area_id' => $visit_detail['area_id'],
                                'location_id' => $visit_detail['location_id'],
                                'frequency'=>$frequency,
                                'followup_date'=>$followup_date,
                                'is_visited'=>0
                            );
                            $data['created_by']=$curusr;
                            $data['created_on']=$now;

                            $this->db->insert('sales_rep_location',$data);
                            $visit_id = $sales_rep_loc_id=$this->db->insert_id();

                            $sales_rep_stock_detail = $sales_rep_stock_detail;
                            $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                            $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);
                        }
                    }

                    if($detailed_insert_id!=0) {
                        $update_sales_location = array("detailed_bit_plan_id"=>$detailed_insert_id);
                        $this->db->where("id",$visit_id)->update('sales_rep_location',$update_sales_location); 
                    }  
                }
            }
        }

        //For Orders
        if($save=='') {
            $orange_bar = $this->input->post('orange_bar');
            $orange_box = $this->input->post('orange_box');
            $butterscotch_bar = $this->input->post('butterscotch_bar');
            $butterscotch_box = $this->input->post('butterscotch_box');
            $chocopeanut_bar = $this->input->post('chocopeanut_bar');
            $chocopeanut_box = $this->input->post('chocopeanut_box');
            $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
            $bambaiyachaat_box = $this->input->post('bambaiyachaat_box');
            $mangoginger_bar = $this->input->post('mangoginger_bar');
            $mangoginger_box = $this->input->post('mangoginger_box');
            $berry_blast_bar = $this->input->post('berry_blast_bar');
            $berry_blast_box = $this->input->post('berry_blast_box');
            $chyawanprash_bar = $this->input->post('chyawanprash_bar');
            $chyawanprash_box = $this->input->post('chyawanprash_box');
            $variety_box = $this->input->post('variety_box');
            $chocolate_cookies = $this->input->post('chocolate_cookies');
            $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
            $cranberry_cookies = $this->input->post('cranberry_cookies');
            $fig_raisins = $this->input->post('fig_raisins');
            $papaya_pineapple = $this->input->post('papaya_pineapple');
            $cranberry_orange_zest = $this->input->post('cranberry_orange_zest');
            $batch_array = array();

            $now = date('Y-m-d');
            $sql = "Select * from sales_rep_orders Where visit_id=".$visit_id;
            $get_orders = $this->db->query($sql)->result_array();
            if(count($get_orders)>0) {
                $data = array(
                    'sales_rep_id' => $sales_rep_id,
                    'date_of_processing' => $now1,
                    'distributor_id'=>$retailer_id,    
                    'selected_distributor' => $this->input->post('distributor_id'),
                    'status' => 'Active',
                    'remarks' => $this->input->post('remarks'),
                    'modified_by' => $curusr,
                    'modified_on' => $now,
                    'channel_type'=>$visit_detail['channel_type']
                );

                $where_array = array('visit_id'=>$visit_id);

                $this->db->where($where_array)->update('sales_rep_orders',$data);
                $id=$get_orders[0]['id'];

                $this->db->where('sales_rep_order_id',$id)->delete('sales_rep_order_items');     
            } else {
                $data = array(
                    'sales_rep_id' => $sales_rep_id,
                    'date_of_processing' => $now1,
                    'distributor_id'=>$retailer_id,    
                    'selected_distributor' => $this->input->post('distributor_id'),
                    'status' => 'Active',
                    'remarks' => $this->input->post('remarks'),
                    'modified_by' => $curusr,
                    'modified_on' => $now,
                    'created_on'=>$now,
                    'created_by'=>$curusr,
                    'channel_type'=>$visit_detail['channel_type'],
                    'visit_id'=>$visit_id
                );

                $this->db->insert('sales_rep_orders',$data);
                $id=$this->db->insert_id();
            }

            if($id) {
                if($chocolate_cookies!='') {
                    $item_id =37;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$chocolate_cookies
                                    );
                    $batch_array[] = $data;
                }
                if($dark_chocolate_cookies!='') {
                    $item_id =38;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$dark_chocolate_cookies
                                    );
                    $batch_array[] = $data;
                }
                if($cranberry_cookies!='') {
                    $item_id = 39;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$cranberry_cookies
                                    );
                    $batch_array[] = $data;
                }
                if($cranberry_orange_zest!='') {
                    $item_id = 42;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$cranberry_orange_zest
                                    );
                    $batch_array[] = $data;
                }
                if($fig_raisins!='') {
                    $item_id = 41;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$fig_raisins
                                    );
                    $batch_array[] = $data;
                }
                if($papaya_pineapple!='') {
                    $item_id = 40;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$papaya_pineapple
                                    );
                    $batch_array[] = $data;
                }
                if($orange_bar!=null) {
                    $item_id = 1;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$orange_bar
                                    );
                    $batch_array[] = $data;
                }
                if($orange_box!=null) {
                    $item_id = 1;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$orange_box
                                    );
                    $batch_array[] = $data;
                }
                if($butterscotch_bar!=null) {
                    $item_id = 3;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$butterscotch_bar
                                    );
                    $batch_array[] = $data;
                }
                if($butterscotch_box!=null) {
                    $item_id = 3;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$butterscotch_box
                                    );
                    $batch_array[] = $data;
                }
                if($chocopeanut_bar!=null) {
                    $item_id = 5;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$chocopeanut_bar
                                    );
                    $batch_array[] = $data;
                }
                if($chocopeanut_box!=null) {
                    $item_id = 9;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$chocopeanut_box
                                    );
                    $batch_array[] = $data;
                }
                if($bambaiyachaat_bar!=null) {
                    $item_id = 4;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$bambaiyachaat_bar
                                    );
                    $batch_array[] = $data;
                }
                if($bambaiyachaat_box!=null) {
                    $item_id = 8;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$bambaiyachaat_box
                                    );
                    $batch_array[] = $data;
                }
                if($mangoginger_bar!=null) {
                    $item_id = 6;
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$mangoginger_bar
                                    );
                    $batch_array[] = $data;
                }
                if($mangoginger_box!=null) {
                   $item_id = 12;
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$mangoginger_box
                                    );
                    $batch_array[] = $data;
                }
                if($berry_blast_bar!=null) {
                   $item_id = 9;
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$berry_blast_bar
                                    );

                    $batch_array[] = $data;
                }
                if($berry_blast_box!=null) {
                   $item_id = 29;
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$berry_blast_box
                                    );

                    $batch_array[] = $data;
                }
                if($chyawanprash_bar!=null) {
                   $item_id = 10;
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Bar',
                                    'item_id'=>$item_id,
                                    'qty'=>$chyawanprash_bar
                                    );
                    $batch_array[] = $data;
                }
                if($chyawanprash_box!=null) {
                   $item_id = 31;
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$chyawanprash_box
                                    );
                    $batch_array[] = $data;
                }
                if($variety_box!=null) {
                    $item_id = 32;
                    
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$variety_box
                                    );
                    $batch_array[] = $data;
                }
                if(count($batch_array)!='') {
                    $this->db->where('sales_rep_order_id',$id)->delete('sales_rep_order_items');
                    $this->db->insert_batch('sales_rep_order_items',$batch_array);
                }  
            }
        }

        if($visit_id!=''){
            $batch_detail = $this->input->post('batch_detail');

            if($batch_detail!=''){
                $batch_detail = json_decode($batch_detail, true);

                $batch_detail_array = array();
                $channel_type = (isset($visit_detail['channel_type'])?$visit_detail['channel_type']:'');

                foreach($batch_detail as $key => $value) {
                    $item_id=0;
                    $item_type='';

                    switch ($key){
                        case 'chocolate_cookies': $item_id=37; $item_type='Box';
                        break;
                        case 'dark_chocolate_cookies': $item_id=38; $item_type='Box';
                        break;
                        case 'cranberry_cookies': $item_id=39; $item_type='Box';
                        break;
                        case 'cranberry_orange_zest': $item_id=42; $item_type='Box';
                        break;
                        case 'fig_raisins': $item_id=41; $item_type='Box';
                        break;
                        case 'papaya_pineapple': $item_id=40; $item_type='Box';
                        break;
                        case 'orange_bar': $item_id=1; $item_type='Bar';
                        break;
                        case 'orange_box': $item_id=1; $item_type='Box';
                        break;
                        case 'butterscotch_bar': $item_id=3; $item_type='Bar';
                        break;
                        case 'butterscotch_box': $item_id=3; $item_type='Box';
                        break;
                        case 'chocopeanut_bar': $item_id=5; $item_type='Bar';
                        break;
                        case 'chocopeanut_box': $item_id=9; $item_type='Box';
                        break;
                        case 'bambaiyachaat_bar': $item_id=4; $item_type='Bar';
                        break;
                        case 'bambaiyachaat_box': $item_id=8; $item_type='Box';
                        break;
                        case 'mangoginger_bar': $item_id=6; $item_type='Bar';
                        break;
                        case 'mangoginger_box': $item_id=12; $item_type='Box';
                        break;
                        case 'berry_blast_bar': $item_id=9; $item_type='Bar';
                        break;
                        case 'berry_blast_box': $item_id=29; $item_type='Box';
                        break;
                        case 'chyawanprash_bar': $item_id=10; $item_type='Bar';
                        break;
                        case 'chyawanprash_box': $item_id=31; $item_type='Box';
                        break;
                        case 'variety_box': $item_id=32; $item_type='Box';
                        break;
                    }

                    if($item_type!=''){
                        $batch_qty = json_decode($value, true);

                        foreach($batch_qty as $key2 => $value2) {
                            $data = array(
                                        'visit_id'=>$visit_id,
                                        'channel_type'=>$channel_type,
                                        'type'=>$item_type,
                                        'item_id'=>$item_id,
                                        'batch_no'=>$key2,
                                        'qty'=>$value2
                                    );
                            $batch_detail_array[] = $data;
                        }
                    }
                }

                if(count($batch_detail_array)>0) {
                    $this->db->where("visit_id='".$visit_id."' and channel_type='".$channel_type."'")->delete('store_batch_details');
                    $this->db->insert_batch('store_batch_details',$batch_detail_array);
                } 
            }
        }
        


        // $this->session->unset_userdata('visit_detail');
        // $this->session->unset_userdata('retailer_detail');
        // $this->session->unset_userdata('temp_stock_details');
        // $this->session->unset_userdata('merchandiser_stock_details');
        // $this->session->unset_userdata('sales_rep_stock_detail');
        // redirect(base_url().'index.php/Sales_rep_store_plan');

        // $data['visit_detail'] = $visit_detail;
        // $data['retailer_detail'] = $retailer_detail;
        // // $data['temp_stock_details'] = $temp_stock_details;
        // $data['merchandiser_stock_details'] = $merchandiser_stock_details;
        // $data['sales_rep_stock_detail'] = $sales_rep_stock_detail;


        $data['Monday'] = array();
        $data['Tuesday'] = array();
        $data['Wednesday'] = array();
        $data['Thursday'] = array();
        $data['Friday'] = array();
        $data['Saturday'] = array();
        $data['Sunday'] = array();
        $frequency = date('l');

        $data[$frequency] = $this->checkstatus_api2($sales_rep_id, $frequency);

        if($save=='Follow Up') {
            if(isset($followup_date)) {
                if($followup_date!=null && $followup_date!="") {
                    $frequency2 = date('l', strtotime($followup_date));
                    if($frequency!=$frequency2) {
                        $data[$frequency2] = $this->checkstatus_api2($sales_rep_id, $frequency2);
                    }
                }
            }
        }

        echo json_encode($data);
    }

    public function get_alternate($day,$m,$year){
        $date1 = date('d-m-Y', strtotime('second '.$day.' of '.$m.' '.$year));
        $date2 = date('d-m-Y', strtotime('fourth '.$day.' of '.$m.' '.$year));

        $todaysdate = date('d-m-Y');
        if($date1==$todaysdate) {
            return true;
        } elseif($date2==$todaysdate) {
            return true;
        } else {
           return false;
        }
    }

    public function clear_session(){
        $this->session->unset_userdata('visit_detail');
        $this->session->unset_userdata('retailer_detail');
        $this->session->unset_userdata('temp_stock_details');
        $this->session->unset_userdata('merchandiser_stock_details');
        $this->session->unset_userdata('merchandiser_stock_details');
        /*redirect($_SERVER['HTTP_REFERER']);*/
        redirect(base_url().'index.php/Sales_rep_store_plan');
    }

    public function save_po_qty_api(){
        $result = $this->sales_rep_location_model->save_po_qty();
        echo $result;
    }

    public function get_batch_details_api(){
        $data = $this->sales_rep_location_model->get_batch_details();
        echo json_encode($data);
    }


}
?>