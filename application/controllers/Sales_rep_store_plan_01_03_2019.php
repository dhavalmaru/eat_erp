<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep_store_plan extends CI_Controller{

    public function __construct(){
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
      //    $this->load->model('Sr_beat_plan_model');
        
        $this->load->model('box_model');
        $this->load->model('product_model');
        $this->load->database();
    }

    //index function
    // public function (){
        // $result=$this->Sales_location_model->get_access();
        // if(count($result)>0) {
            // $data['access']=$result;
           // $data['data'] = $this->Sales_location_model->get_data();
            // $data['data'] = $this->Sr_beat_plan_model->get_data();

            // load_view('merchandiser/sales_rep_list_view', $data);
        // } else {
            // echo '<script>alert("You donot have access to this page.");</script>';
            // $this->load->view('login/main_page');
        // }
    // }

     public function index(){
       
        $day = date('l');
        /*$m = date('F');
        $year = date('Y');
        $set_days = '';

        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $set_days = 'Alternate '.$day;
        }
        else
        {
            $set_days = 'Every '.$day;
        }*/
        
       

        $this->checkstatus($day);
    }
    
    public function checkstatus($frequency='',$temp_date=''){

        $day = $frequency;
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }

        $result=$this->Sales_location_model->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->Sales_location_model->get_data('Approved','',$frequency);
            $data['merchendizer']=$this->Sales_location_model->get_merchendiser_data('Approved','',$frequency);
            $data['mt_followup']=$this->Sales_location_model->get_mtfollowup('',$temp_date);
            $data['gt_followup']=$this->Sales_location_model->get_gtfollowup('',$temp_date);
            $data['merchendizer_store_plan']=$this->Sales_location_model->get_merchendiser_detail('Approved','',$frequency)    ;
            $data['checkstatus'] = $frequency;
            $data['current_day'] = date('l');
            load_view('sales_rep/sales_rep_list_view', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    public function add($id='',$get_frequency='',$get_channel_type='',$follow_type='', $temp=''){
        $result=$this->sales_rep_location_model->get_access();
        $day =  date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_location_model->get_access();
                $data['distributor'] = $this->sales_rep_distributor_model->get_data2('Approved');

                if($this->session->userdata('temp_stock_details')!=null)
                {
                    if($follow_type!='')
                    {
                        if($follow_type=='gt_followup')
                            {
                                $result=$this->Sales_location_model->get_gtfollowup($id);
                                $data['data'] = $result;
                            }
                        else
                        {
                            $result=$this->Sales_location_model->get_mtfollowup($id);
                                $data['data'] = $result;
                        }
                    }


                    $data['stock_detail']=$this->session->userdata('temp_stock_details');
                }
                else
                {
                   if($follow_type!='')
                    {
                        if($follow_type=='gt_followup')
                        {
                            $result=$this->Sales_location_model->get_gtfollowup($id);
                            $data['data'] = $result;

                            $sales_loc_id = $result[0]->is_edit;
                            if($sales_loc_id!=NULL)
                            {
                                $result = $this->db->query("SELECT id as stock_id ,sales_rep_loc_id,case When orange_bar IS NOT NULL and orange_bar!=0 Then CONCAT(orange_bar,'_Bar') ELSE CONCAT(orange_box,'_Box') end as orange,
                                    case When mint_bar IS NOT NULL and mint_bar!=0 Then CONCAT(mint_box,'_Bar') ELSE CONCAT(mint_bar,'_Box') end as mint,
                                    case When butterscotch_bar IS NOT NULL and butterscotch_bar!=0 Then CONCAT(butterscotch_bar,'_Bar') ELSE CONCAT(butterscotch_box,'_Box') end as butterscotch,
                                    case When chocopeanut_bar IS NOT NULL and chocopeanut_bar!=0 Then CONCAT(chocopeanut_bar,'_Bar') ELSE CONCAT(chocopeanut_box,'_Box') end as chocopeanut,
                                    case When bambaiyachaat_bar IS NOT NULL and bambaiyachaat_bar!=0 Then CONCAT(bambaiyachaat_bar,'_Bar') ELSE CONCAT(bambaiyachaat_box,'_Box') end as bambaiyachaat,
                                    case When mangoginger_bar IS NOT NULL and mangoginger_bar!=0 Then CONCAT(mangoginger_bar,'_Bar') ELSE CONCAT(mangoginger_box,'_Box') end as mangoginger,
                                    case When berry_blast_bar IS NOT NULL and berry_blast_bar!=0 Then CONCAT(berry_blast_bar,'_Bar') ELSE CONCAT(berry_blast_box,'_Box') end as berry_blast,
                                    case When chyawanprash_bar IS NOT NULL and chyawanprash_bar!=0 Then CONCAT(chyawanprash_bar,'_Bar') ELSE CONCAT(chyawanprash_box,'_Box') end as chyawanprash,
                                    chocolate_cookies_box,cranberry_orange_box,dark_chocolate_cookies_box,fig_raisins_box,papaya_pineapple_box,variety_box,cranberry_cookies_box,sales_rep_loc_id from  sales_rep_distributor_opening_stock Where sales_rep_loc_id=$sales_loc_id")->result_array();
                                $this->db->last_query();
                                $data['stock_detail']=$result[0];


                                /*$stock_detail = array();*/
                               /*for($i=0;$i<count($result);$i++)
                               {
                                   $mangoginger_bar = $result[0]['mangoginger_bar'];

                                   if($result[0]['mangoginger_bar']!=0 || $result[0]['mangoginger_bar']!=NUll)
                                   {
                                      $stock_detail['mangoginger_bar']= $result[0]['mangoginger_bar'];
                                   }

                                   $berry_blast_bar = $result[0]['berry_blast_bar'];
                                   $chyawanprash_bar = $result[0]['chyawanprash_bar'];
                                   $chyawanprash_bar = $result[0]['chyawanprash_bar'];
                               }*/
                            }
                        }
                        else
                        {
                            $result=$this->Sales_location_model->get_mtfollowup($id);
                            $data['data'] = $result;
                            $sales_loc_id = $result[0]->merchandiser_stock_id;
                            if($sales_loc_id!=NULL)
                            {
                                $result = $this->db->query("Select A.id as stock_id ,merchandiser_stock_id as visit_id ,
                                Case When type='Box' Then box_name ELSE product_name end as product_name,
                                Case When type='Box' Then CONCAT(qty,'_Bar') ELSE CONCAT(qty,'_Box') end as qty,item_id,type
                                from
                                (SELECT * from merchandiser_stock_details where merchandiser_stock_id=$sales_loc_id) A
                                Left join 
                                (SELECT * from box_master)B on A.item_id=B.id
                                Left join 
                                (SELECT * from product_master)C on A.item_id=C.id")->result_array();
                                $this->db->last_query();

                                $stock_detail = array();
                                if(count($result)>0)
                                {
                                    for ($j=0; $j <count($result) ; $j++) {
                                        if ($result[$j]['item_id']==37) {
                                            $stock_detail['chocolate_cookies_box']=$result[$j]['qty'];
                                        }
                                       if ($result[$j]['item_id']==45) {
                                            $stock_detail['dark_chocolate_cookies_box']=$result[$j]['qty'];
                                        }
                                        if ($result[$j]['item_id']==39) {
                                            $stock_detail['cranberry_cookies_box']=$result[$j]['qty'];
                                        }
                                        if ($result[$j]['item_id']==42) {
                                            $stock_detail['cranberry_orange_box']=$result[$j]['qty'];
                                        }
                                        if ($result[$j]['item_id']==41) {
                                            $stock_detail['fig_raisins_box']=$result[$j]['qty'];
                                        }
                                        if ($result[$j]['item_id']==40) {
                                            $stock_detail['papaya_pineapple_box']=$result[$j]['qty'];
                                        }
                                        
                                        if($result[$j]['item_id']==1 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                        {
                                            $stock_detail['orange']=$result[$j]['qty'];
                                        }

                                        if($result[$j]['item_id']==3 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                        {
                                            $stock_detail['butterscotch']=$result[$j]['qty'];
                                        }

                                      /*  if($result[$j]['item_id']==9 && $result[$j]['type']=='Box')
                                        {
                                            $stock_detail['butterscotch']=$result[$j]['qty'];
                                        }
                                        else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar')
                                        {
                                            $stock_detail['butterscotch']=$result[$j]['qty'];
                                        }*/

                                        if($result[$j]['item_id']==9 && $result[$j]['type']=='Box')
                                                $stock_detail['chocopeanut']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar')
                                                $stock_detail['chocopeanut']=$result[$j]['qty'];

                                         if($result[$j]['item_id']==8 && $result[$j]['type']=='Box')
                                                $stock_detail['bambaiyachaat']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==4 && $result[$j]['type']=='Bar')
                                                $stock_detail['bambaiyachaat']=$result[$j]['qty'];

                                        if($result[$j]['item_id']==12 && $result[$j]['type']=='Box')
                                                $stock_detail['mangoginger']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==6 && $result[$j]['type']=='Bar')
                                                $stock_detail['mangoginger']=$result[$j]['qty'];

                                        if($result[$j]['item_id']==29 && $result[$j]['type']=='Box')
                                                $stock_detail['berry_blast']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==9 && $result[$j]['type']=='Bar')
                                                $stock_detail['berry_blast']=$result[$j]['qty'];

                                        if($result[$j]['item_id']==31 && $result[$j]['type']=='Box')
                                                $stock_detail['chyawanprash']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==10 && $result[$j]['type']=='Bar')
                                                $stock_detail['chyawanprash']=$result[$j]['qty'];

                                         if($result[$j]['item_id']==32 && $result[$j]['type']=='Box')
                                                $stock_detail['variety_box']=$result[$j]['qty'];
                                    }

                                    $data['stock_detail'] = $stock_detail;
                                }

                                /*$stock_detail = array();*/
                                   /*for($i=0;$i<count($result);$i++)
                                   {
                                       $mangoginger_bar = $result[0]['mangoginger_bar'];

                                       if($result[0]['mangoginger_bar']!=0 || $result[0]['mangoginger_bar']!=NUll)
                                       {
                                          $stock_detail['mangoginger_bar']= $result[0]['mangoginger_bar'];
                                       }

                                       $berry_blast_bar = $result[0]['berry_blast_bar'];
                                       $chyawanprash_bar = $result[0]['chyawanprash_bar'];
                                       $chyawanprash_bar = $result[0]['chyawanprash_bar'];
                                   }*/
                            }
                        }
                    }
                    else
                    {
                        echo "id".$id;
                        if($id!='')
                        {

                            if($get_channel_type=='GT')
                            {
                                $data['data']=$this->Sales_location_model->get_data('Approved',$id);           
                            }
                            else
                            {
                                $data['data']=$this->Sales_location_model->get_merchendiser_data('Approved',$id);
                            }
                        } 



                    } 
                }


               $sales_rep_id=$this->session->userdata('sales_rep_id');

               
               /*$sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and is_edit='edit' and frequency='$frequency' and sales_rep_id='$sales_rep_id'";
                $get_maxcount = $this->db->query($sql)->result_array();
                $data['sequence_count'] = $get_maxcount[0]['sequence']+1;*/
                /*$data['store_plan']=$this->Sales_location_model->get_data('Approved',$id,'');*/

                if($get_channel_type==''){
                    $channel_type = 'GT';
                }
                else
                {
                    $channel_type = $get_channel_type;
                }

                $data['zone'] = $this->sales_rep_location_model->get_zone('',$channel_type);
                $data['area'] = $this->sales_rep_location_model->get_area();
                $data['location'] = $this->sales_rep_location_model->get_locations();
                $data['follow_type'] = $follow_type;

                if($get_channel_type!='')
                    $data['channel_type']=$get_channel_type;

                load_view('sales_rep_location/sales_rep_location_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }

        
    }

    public function get_zone()
    {
        $channel_type = $this->input->post('type');
        $result =  $this->sales_rep_location_model->get_zone('',$channel_type);
        if(count($result)>0)
        {
            echo json_encode($result);
        }
        else
            echo 0;
    }

    public function edit($id='',$get_frequency='',$get_channel_type='',$follow_type='' , $temp=''){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $result;

                if($get_channel_type=='GT'){

                    if($temp!='')
                    {
                        $result = $this->sales_rep_location_model->get_data('', $id);
                    }
                    else
                    {
                        $result = $this->Sales_location_model->get_data('Approved',$id,'');
                    }

                    $data['data'] = $result;
                    $sales_rep_loc_id = $result[0]->mid;

                    if($this->session->userdata('temp_stock_details')!=null)
                    {
                        $data['stock_detail']=$this->session->userdata('temp_stock_details');
                    }
                    else
                    {
                        $result = $this->db->query("SELECT id as stock_id ,sales_rep_loc_id,case When orange_bar IS NOT NULL and orange_bar!=0 Then CONCAT(orange_bar,'_Bar') ELSE CONCAT(orange_box,'_Box') end as orange,
                        case When mint_bar IS NOT NULL and mint_bar!=0 Then CONCAT(mint_box,'_Bar') ELSE CONCAT(mint_bar,'_Box') end as mint,
                        case When butterscotch_bar IS NOT NULL and butterscotch_bar!=0 Then CONCAT(butterscotch_bar,'_Bar') ELSE CONCAT(butterscotch_box,'_Box') end as butterscotch,
                        case When chocopeanut_bar IS NOT NULL and chocopeanut_bar!=0 Then CONCAT(chocopeanut_bar,'_Bar') ELSE CONCAT(chocopeanut_box,'_Box') end as chocopeanut,
                        case When bambaiyachaat_bar IS NOT NULL and bambaiyachaat_bar!=0 Then CONCAT(bambaiyachaat_bar,'_Bar') ELSE CONCAT(bambaiyachaat_box,'_Box') end as bambaiyachaat,
                        case When mangoginger_bar IS NOT NULL and mangoginger_bar!=0 Then CONCAT(mangoginger_bar,'_Bar') ELSE CONCAT(mangoginger_box,'_Box') end as mangoginger,
                        case When berry_blast_bar IS NOT NULL and berry_blast_bar!=0 Then CONCAT(berry_blast_bar,'_Bar') ELSE CONCAT(berry_blast_box,'_Box') end as berry_blast,
                        case When chyawanprash_bar IS NOT NULL and chyawanprash_bar!=0 Then CONCAT(chyawanprash_bar,'_Bar') ELSE CONCAT(chyawanprash_box,'_Box') end as chyawanprash,
                        chocolate_cookies_box,cranberry_orange_box,dark_chocolate_cookies_box,fig_raisins_box,papaya_pineapple_box,variety_box,cranberry_cookies_box,sales_rep_loc_id from  sales_rep_distributor_opening_stock Where sales_rep_loc_id=$sales_rep_loc_id")->result_array();
                    $this->db->last_query();
                    $data['stock_detail']=$result[0];
                    }

                    
                }
                else{
                    
                    if($temp!='')
                    {
                        $result=$this->sales_rep_location_model->get_mt_data('',$id,'');
                    }
                    else
                    {
                        $result=$this->Sales_location_model->get_merchendiser_data('Approved',$id,'');
                    }


                    $data['data'] = $result;
                    $merchandiser_stock_id = $result[0]->mid;

                    if($this->session->userdata('temp_stock_details')!=null)
                    {
                        $data['stock_detail']=$this->session->userdata('temp_stock_details');
                    }
                    else
                    {
                        $result = $this->db->query("Select A.id as stock_id ,merchandiser_stock_id as visit_id ,
                        Case When type='Box' Then box_name ELSE product_name end as product_name,
                        Case When type='Box' Then CONCAT(qty,'_Box') ELSE CONCAT(qty,'_Bar') end as qty,item_id,type
                        from
                        (SELECT * from merchandiser_stock_details where merchandiser_stock_id=$merchandiser_stock_id) A
                        Left join 
                        (SELECT * from box_master)B on A.item_id=B.id
                        Left join 
                        (SELECT * from product_master)C on A.item_id=C.id")->result_array();
                        $this->db->last_query();

                        $stock_detail = array();
                        if(count($result)>0)
                        {
                            for ($j=0; $j <count($result) ; $j++) {
                                if ($result[$j]['item_id']==37) {
                                    $stock_detail['chocolate_cookies_box']=$result[$j]['qty'];
                                }
                               if ($result[$j]['item_id']==45) {
                                    $stock_detail['dark_chocolate_cookies_box']=$result[$j]['qty'];
                                }
                                if ($result[$j]['item_id']==39) {
                                    $stock_detail['cranberry_cookies_box']=$result[$j]['qty'];
                                }
                                if ($result[$j]['item_id']==42) {
                                    $stock_detail['cranberry_orange_box']=$result[$j]['qty'];
                                }
                                if ($result[$j]['item_id']==41) {
                                    $stock_detail['fig_raisins_box']=$result[$j]['qty'];
                                }
                                if ($result[$j]['item_id']==40) {
                                    $stock_detail['papaya_pineapple_box']=$result[$j]['qty'];
                                }
                                
                                if($result[$j]['item_id']==1 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                {
                                    $stock_detail['orange']=$result[$j]['qty'];
                                }

                                if($result[$j]['item_id']==3 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                {
                                    $stock_detail['butterscotch']=$result[$j]['qty'];
                                }

                                /*if($result[$j]['item_id']==9 && $result[$j]['type']=='Box')
                                {
                                    $stock_detail['butterscotch']=$result[$j]['qty'];
                                }
                                else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar')
                                {
                                    $stock_detail['butterscotch']=$result[$j]['qty'];
                                }*/

                                if($result[$j]['item_id']==9 && $result[$j]['type']=='Box')
                                        $stock_detail['chocopeanut']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar')
                                        $stock_detail['chocopeanut']=$result[$j]['qty'];

                                 if($result[$j]['item_id']==8 && $result[$j]['type']=='Box')
                                        $stock_detail['bambaiyachaat']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==4 && $result[$j]['type']=='Bar')
                                        $stock_detail['bambaiyachaat']=$result[$j]['qty'];

                                if($result[$j]['item_id']==12 && $result[$j]['type']=='Box')
                                        $stock_detail['mangoginger']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==6 && $result[$j]['type']=='Bar')
                                        $stock_detail['mangoginger']=$result[$j]['qty'];

                                if($result[$j]['item_id']==29 && $result[$j]['type']=='Box')
                                        $stock_detail['berry_blast']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==9 && $result[$j]['type']=='Bar')
                                        $stock_detail['berry_blast']=$result[$j]['qty'];

                                if($result[$j]['item_id']==31 && $result[$j]['type']=='Box')
                                        $stock_detail['chyawanprash']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==10 && $result[$j]['type']=='Bar')
                                        $stock_detail['chyawanprash']=$result[$j]['qty'];

                                 if($result[$j]['item_id']==32 && $result[$j]['type']=='Box')
                                        $stock_detail['variety_box']=$result[$j]['qty'];
                            }

                            $data['stock_detail'] = $stock_detail;
                        }
                    }

                }

                $data['data1'] = $this->sales_rep_location_model->get_data_qty('', $data['data'][0]->mid);
                $data['distributor']=$dist = $this->sales_rep_distributor_model->get_data2();
               $data['zone'] = $this->sales_rep_location_model->get_zone();
               $data['area'] = $this->sales_rep_location_model->get_area();
               $data['location'] = $this->sales_rep_location_model->get_locations();

                /*if(count($data['data'])>0){
                    $zone_id = $data['data'][0]->zone_id;
                    $area_id = $data['data'][0]->area_id;
                }
                
                $data['area'] = $this->sales_rep_location_model->get_area($zone_id);
                $data['location'] = $this->sales_rep_location_model->get_locations($zone_id, $area_id);*/
                if($get_channel_type!='')
                    $data['channel_type']=$get_channel_type;
                load_view('sales_rep_location/sales_rep_location_details', $data);



            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save($id=""){
        /*$id  = $this->input->post('id');

        if($id == ""){
            $this->Sales_location_model->save_data('');
        } 
        else {
            $this->Sales_location_model->save_data($id);
        }*/

        $user_id=$this->session->userdata('sales_rep_id');



        if($this->input->post('srld') == "Place Order") {
            

            if($this->input->post('channel_type')=='GT')
            {
               $this->Sales_location_model->save_session();
            }
            else
            {
               $this->Sales_location_model->save_relation_session();
            }


            $stock_detail = $this->session->userdata('stock_detail');
            /*if($id == ""){
                $this->Sales_location_model->save_data('','Place Order');
            } else {
                $this->Sales_location_model->save_data($id, 'Place Order');
            }*/
        }
        else if($this->input->post('srld') == "Follow Up") {
              $this->save_order('Follow Up');
             //$this->Sales_location_model->save_followup();
        }
        else {
            echo 'entered';

            $this->save_order('Save');
        }    

        if($this->input->post('srld') == "Place Order" || $this->input->post('srld') == "Purchase Order") {
            if($this->input->post('distributor_type')=="Old"){
                $id = $this->input->post('distributor_id');
                redirect(base_url().'index.php/Sales_rep_store_plan/add_order');
            } else {

                if($this->session->userdata('visit_detail')!=null)
                {
                   if($this->input->post('distributor_type')=='New')
                    {
                      redirect(base_url().'index.php/Sales_rep_store_plan/add_sales_rep_distributor');
                    }
                    else
                    {
                       redirect(base_url().'Sales_rep_store_plan/add_order');   
                    }
                   
                }
                else
                {
                  $result=$this->sales_rep_distributor_model->get_access();
                    if(count($result)>0) {
                        if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                            $id = $this->input->post('store_id');
                            if($this->input->post('place_order')=="Yes") {
                                if($id=="")
                                {
                                   
                                    $distributor_name  = $this->input->post('distributor_name');
                                    $result = $this->db->query("Select concat('s_',id) as id from sales_rep_distributors Where distributor_name='$distributor_name' and sales_rep_id='$user_id'")->result_array();
                                    $id = $result[0]['id'];
                                }
                                /*$zone_id = $id;*/
                                $area_id = $this->input->post('area_id');
                                $array = array();
                                $data['id'] = $id;
                                $zone_id = $this->input->post('zone_id');
                                $area_id = $this->input->post('area_id');
                                $distributor_id = substr($id, 2);
                                $get_detail = $this->db->select("distributor_name,gst_number,zone_id,location_id,area_id,margin,remarks,document_name,margin,doc_document,master_distributor_id as distributor_id ")->where('id',$distributor_id)->get('sales_rep_distributors')->result();
                                $data['data'] =$get_detail;
                                $data['zone'] = $this->sales_rep_location_model->get_zone();
                                $data['area'] = $this->sales_rep_location_model->get_area($zone_id);
                                $data['location'] = $this->sales_rep_location_model->get_locations($zone_id, $area_id);
                                $result1=$this->sales_rep_distributor_model->get_access();
                                $data['access'] = $result1;
                                $data['distributor'] = $this->sales_rep_location_model->get_distributors($zone_id, $area_id);
                                $data['distributor_name'] = $this->input->post('distributor_name');
                                $data['zone_id'] = $this->input->post('zone_id');
                                $data['area_id'] = $this->input->post('area_id');
                                $data['location_id'] = $this->input->post('location_id');



                                load_view('sales_rep_distributor/sales_rep_distributor_details',$data);
                                //redirect(base_url().'index.php/sales_rep_distributor/add/'.$id);
                                /*redirect(base_url().'index.php/Sales_rep_order/add_order/'.$id);*/
                            } else {
                                redirect(base_url().'index.php/sales_rep_distributor');
                            }
                        }
                    }  
                }

                 
            }
        }
        else {
            redirect(base_url().'index.php/Sales_rep_store_plan');
        }

        //redirect(base_url().'index.php/Sales_rep_store_plan');
    }
        
    public function get_lat_long(){
        $id=$this->input->post('id');
        $result=$this->Sales_location_model->get_lat_long($id);
        $data['result'] = 0;
        if(count($result)>0) {
            $data['result'] = 1;
            $data['google_address'] = $result[0]->google_address;
            $data['latitude'] = $result[0]->latitude;
            $data['longitude'] = $result[0]->longitude;
           
        }

        echo json_encode($data);
    }

    public function locations($status='')
    {
        $result=$this->Sales_rep_route_plan_model->get_access();
        if(count($result)>0) {
            load_view_without_data('sales_rep_location/sales_rep_location_map');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }

    }

    public function add_sales_rep_distributor(){
        $data['access'] = $this->sales_rep_location_model->get_access();
        $visit_detail = $this->session->userdata('visit_detail');

        $data['distributor'] = $this->sales_rep_location_model->get_distributors($visit_detail['zone_id']);
        if($visit_detail['distributor_id']!='')
        {
            $result  = $this->sales_rep_distributor_model->get_data2('',$visit_detail['distributor_id']);
            $distributor_name =$result[0]->distributor_name;
            $data['distributor_name']=$distributor_name; 
        }
        if($visit_detail['reation_id']!='')
        {
            $result  = $this->sales_rep_location_model->get_store_name($visit_detail['reation_id']);
            $store_name =$result[0]->store_name;
            $data['store_name']=$store_name; 
        }
        if($visit_detail['zone_id']!='')
        {
            $result  = $this->sales_rep_location_model->get_zone($visit_detail['zone_id']);
            $zone=$result[0]->zone; 
            $data['zone']=$zone;
        }
        if($visit_detail['area_id']!='')
        {
            $result  = $this->sales_rep_location_model->get_area('',$visit_detail['area_id']);
            $area=$result[0]->area; 
            $data['area']=$area;
        }
        if($visit_detail['location_id']!='')
        {
            $result  = $this->sales_rep_location_model->get_locations('','',$visit_detail['location_id']);
            $location=$result[0]->location; 
            $data['location']=$location;
        }


        if($visit_detail['distributor_id']!='')
        {
            $visit_detail['distributor_id'];
            $dist_id=explode('s_',$visit_detail['distributor_id']);
            $get_result = $this->db->where('id',$dist_id[1])->select('*')->get('sales_rep_distributors')->result_array();

            if(count($get_result)>0)
            {
               $data['margin']=$get_result[0]['margin']; 
               $data['remarks']=$get_result[0]['remarks']; 
               $data['gst_number']=$get_result[0]['gst_number']; 
            }
        }
        load_view('sales_rep_distributor/sales_rep_distributor_details', $data);
    }

    public function save_sales_rep_retailer($id=''){
        $visit_detail = $this->session->userdata('visit_detail');
        if($visit_detail['channel_type'] == 'MT'){
            $this->Sales_location_model->save_relation_session();    
            /*$id = $this->sales_rep_distributor_model->save_data();
              $id = 's_'.$id;*/
        } else {
            $this->Sales_location_model->save_retailer_session();
        }

        redirect(base_url().'index.php/Sales_rep_store_plan/add_order/');
    }

    public function add_order(){
        $result=$this->sales_rep_location_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $visit_detail = $this->session->userdata('visit_detail');
                $data['access'] = $this->sales_rep_location_model->get_access();
                $visit_detail = $this->session->userdata('visit_detail');


                $data['distributor'] = $this->sales_rep_location_model->get_distributors();

                if($visit_detail['mid']!='' || $visit_detail['sales_rep_loc_id']!='' || $visit_detail['merchandiser_stock_id']!='')
                { 
                    if($visit_detail['mid']!='')
                    {
                        $visit_id=$visit_detail['mid'];
                    }
                    else if($visit_detail['sales_rep_loc_id']!='')
                    {
                         $visit_id=$visit_detail['sales_rep_loc_id'];
                    }
                    else if($visit_detail['merchandiser_stock_id']!='')
                    {
                        $visit_id=$visit_detail['merchandiser_stock_id'];
                    }

                    $get_result = $this->db->where('visit_id',$visit_id)->select('selected_distributor')->get('sales_rep_orders')->result_array();

                    if(count($get_result)>0)
                    {
                       $data['selected_distributor']=$get_result[0]['selected_distributor']; 
                    }
                    else
                    {
                        $data['selected_distributor']=0;
                    }
                }
                else
                {
                    $data['selected_distributor']=0;
                }
                
                if($visit_detail['distributor_name']=='')
                {
                    $result  = $this->sales_rep_distributor_model->get_data2('',$visit_detail['distributor_id']);
					echo 'dist '.$visit_detail['distributor_id'];
                    $distributor_name =$result[0]->distributor_name;
                    $data['distributor_name']=$distributor_name; 
                }
                else
                {
                    $data['distributor_name']=$visit_detail['distributor_name']; 
                }

                if($visit_detail['reation_id']!='')
                {
                    $result  = $this->sales_rep_location_model->get_store_name($visit_detail['reation_id']);
                    $store_name =$result[0]->store_name;
                    $data['store_name']=$store_name; 
                }

                if($visit_detail['zone_id']!='')
                {
                    $result  = $this->sales_rep_location_model->get_zone($visit_detail['zone_id']);
                    $zone=$result[0]->zone; 
                    $data['zone']=$zone;
                }

                if($visit_detail['area_id']!='')
                {
                    $result  = $this->sales_rep_location_model->get_area('',$visit_detail['area_id']);
                    $area=$result[0]->area; 
                    $data['area']=$area;
                }

                if($visit_detail['location_id']!='')
                {
                    $result  = $this->sales_rep_location_model->get_locations('','',$visit_detail['location_id']);
                    $location=$result[0]->location; 
                    $data['location']=$location;
                }


                $mid = '';
                if(count($visit_detail)>0)
                {
                    /*$mid=$visit_detail['mid'];*/
                    /*if(isset($visit_detail['sales_rep_loc_id']))
                        $mid = $visit_detail['sales_rep_loc_id'];
                    else
                        $mid = $visit_detail['mid'];*/

                    if($visit_detail['mid']!='')
                    {
                        $mid=$visit_detail['mid'];
                    }
                    else if($visit_detail['sales_rep_loc_id']!='')
                    {
                         $mid=$visit_detail['sales_rep_loc_id'];
                    }
                    else if($visit_detail['merchandiser_stock_id']!='')
                    {
                        $mid=$visit_detail['merchandiser_stock_id'];
                    }
                }

                if($mid!='')
                {
                    $get_result = $this->db->query("Select * from sales_rep_orders where visit_id='$mid'")->result_array();
                    if(count($get_result)>0)
                    {
                        $order_id = $get_result[0]['id'];
                        $result = $this->db->query("Select A.id as stock_id,
                        Case When type='Box' Then box_name ELSE product_name end as product_name,
                        Case When type='Box' Then CONCAT(qty,'_Box') ELSE CONCAT(qty,'_Bar') end as qty,item_id,type
                        from
                        (SELECT * from sales_rep_order_items where sales_rep_order_id=$order_id) A
                        Left join 
                        (SELECT * from box_master)B on A.item_id=B.id
                        Left join 
                        (SELECT * from product_master)C on A.item_id=C.id")->result_array();
                        $this->db->last_query();
                        
                        $order_detail = array();
                        if(count($result)>0)
                        {
                            for ($j=0; $j <count($result) ; $j++) {
                                if ($result[$j]['item_id']==37) {
                                    $order_detail['chocolate_cookies_box']=$result[$j]['qty'];
                                }
                               if ($result[$j]['item_id']==45) {
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
                                
                                if($result[$j]['item_id']==1 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                {
                                    $order_detail['orange']=$result[$j]['qty'];
                                }

                                /*if($result[$j]['item_id']==3 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                {
                                    $order_detail['butterscotch']=$result[$j]['qty'];
                                }*/

                                if($result[$j]['item_id']==3 && $result[$j]['type']=='Box')
                                {
                                    $order_detail['butterscotch']=$result[$j]['qty'];
                                }
                                else if($result[$j]['item_id']==3 && $result[$j]['type']=='Bar')
                                {
                                    $order_detail['butterscotch']=$result[$j]['qty'];
                                }

                                if($result[$j]['item_id']==9 && $result[$j]['type']=='Box')
                                        $order_detail['chocopeanut']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar')
                                        $order_detail['chocopeanut']=$result[$j]['qty'];

                                 if($result[$j]['item_id']==8 && $result[$j]['type']=='Box')
                                        $order_detail['bambaiyachaat']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==4 && $result[$j]['type']=='Bar')
                                        $order_detail['bambaiyachaat']=$result[$j]['qty'];

                                if($result[$j]['item_id']==12 && $result[$j]['type']=='Box')
                                        $order_detail['mangoginger']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==6 && $result[$j]['type']=='Bar')
                                        $order_detail['mangoginger']=$result[$j]['qty'];

                                if($result[$j]['item_id']==29 && $result[$j]['type']=='Box')
                                        $order_detail['berry_blast']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==9 && $result[$j]['type']=='Bar')
                                        $order_detail['berry_blast']=$result[$j]['qty'];

                                if($result[$j]['item_id']==31 && $result[$j]['type']=='Box')
                                        $order_detail['chyawanprash']=$result[$j]['qty'];
                                else if($result[$j]['item_id']==10 && $result[$j]['type']=='Bar')
                                        $order_detail['chyawanprash']=$result[$j]['qty'];

                                 if($result[$j]['item_id']==32 && $result[$j]['type']=='Box')
                                        $order_detail['variety_box']=$result[$j]['qty'];
                            }

                            $data['order_detail'] = $order_detail;
                        }
                        
                        /*echo "<pre>";
                        print_r($order_detail);
                        echo "</pre>";

                        die();*/
                    }
                }
                

                if($this->session->userdata('temp_stock_details')!=null)
                {
                    $data['stock_detail']=$this->session->userdata('temp_stock_details');
                }

                $data['get_retailers'] = $this->sales_rep_location_model->get_retailers();

                load_view('sales_rep_order/sales_rep_order_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save_order($save='')
    {
         if($save!='')
         {
                $channel_type  = $this->input->post('channel_type');
                $distributor_type  = $this->input->post('distributor_type');
                $distributor_name  = $this->input->post('distributor_name');
                $zone_id  = $this->input->post('zone_id');
                $area_id  = $this->input->post('area_id');
                $location_id  = $this->input->post('location_id');
                $longitude  = $this->input->post('longitude');
                $latitude  = $this->input->post('latitude');
                $remarks  = $this->input->post('remarks');
                $reation_id  = $this->input->post('reation_id');
                $distributor_id  = $this->input->post('distributor_id');
                $mid  = $this->input->post('mid');
                $beat_plan_id  = $this->input->post('beat_plan_id');
                $store_id  = $this->input->post('store_id');
                $distributor_status  = $this->input->post('distributor_status');
                $sales_rep_loc_id  = $this->input->post('sales_rep_loc_id');
                $sequence = $this->input->post('sequence');
                $reation_id  = $this->input->post('reation_id');
                $merchandiser_stock_id  = $this->input->post('merchandiser_stock_id');
                $follow_type  = $this->input->post('follow_type');

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
                $butterscotch_bar = $this->input->post('butterscotch_bar');
                $chocopeanut_bar = $this->input->post('chocopeanut_bar');
                $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
                $mangoginger_bar = $this->input->post('mangoginger_bar');
                $berry_blast_bar = $this->input->post('berry_blast_bar');
                $chyawanprash_bar = $this->input->post('chyawanprash_bar');
                $variety_box = $this->input->post('variety_box');
                $chocolate_cookies = $this->input->post('chocolate_cookies');
                $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
                $cranberry_cookies = $this->input->post('cranberry_cookies');
                $cranberry_orange = $this->input->post('cranberry_orange');
                $fig_raisins = $this->input->post('fig_raisins');
                $papaya_pineapple = $this->input->post('papaya_pineapple');
                $cranberry_orange_zest = $this->input->post('cranberry_orange_zest');
                $batch_array = array();    
                if($channel_type=='GT')
                {
                    if($chocolate_cookies!='')
                    {

                        $batch_array['chocolate_cookies_box']=$chocolate_cookies;
                    }

                    if($dark_chocolate_cookies!='')
                    {
                       $batch_array['dark_chocolate_cookies_box']=$dark_chocolate_cookies;
                    }

                    if($cranberry_cookies!='')
                    {
                        $batch_array['cranberry_cookies_box']=$cranberry_cookies;
                    }

                    if($cranberry_orange_zest!='')
                    {
                        $batch_array['cranberry_orange_box'] = $cranberry_orange_zest;
                    }
                    
                    if($fig_raisins!='')
                    {
                        $batch_array['fig_raisins_box'] = $fig_raisins;
                    }

                    if($papaya_pineapple!='')
                    {
                        $batch_array['papaya_pineapple_box'] = $papaya_pineapple;
                    }

                    if($orange_bar!=null)
                    {
                         $type = $this->input->post('type_0');
                         if($type=='Box')
                         {
                            $batch_array['orange_box'] = $orange_bar;
                         }
                         else
                         {
                            $batch_array['orange_bar'] = $orange_bar;
                         }
                    }

                    if($butterscotch_bar!=null)
                    {
                        $type = $this->input->post('type_1');    
                        if($type=='Box')
                         {
                            $batch_array['butterscotch_box'] = $butterscotch_bar;
                         }
                         else
                         {
                            $batch_array['butterscotch_bar'] = $butterscotch_bar;
                         }
                    }

                    if($chocopeanut_bar!=null)
                    {
                        $type = $this->input->post('type_3');
                        if($type=='Box')
                         {
                            $batch_array['chocopeanut_box'] = $chocopeanut_bar;
                         }
                         else
                         {
                            $batch_array['chocopeanut_bar'] = $chocopeanut_bar;
                         }
                    }

                    if($bambaiyachaat_bar!=null)
                    {
                        $type = $this->input->post('type_4');
                         if($type=='Box')
                         {
                            $batch_array['bambaiyachaat_box'] = $bambaiyachaat_bar;
                         }
                         else
                         {
                            $batch_array['bambaiyachaat_bar'] = $bambaiyachaat_bar;
                         }
                    }

                    if($mangoginger_bar!=null)
                    {
                        $type = $this->input->post('type_5');
                        if($type=='Box')
                         {
                            $batch_array['mangoginger_box'] = $mangoginger_bar;
                         }
                         else
                         {
                            $batch_array['mangoginger_bar'] = $mangoginger_bar;
                         }
                    }

                    if($berry_blast_bar!=null)
                    {
                        $type = $this->input->post('type_6');
                        if($type=='Box')
                         {
                            $batch_array['berry_blast_box'] = $berry_blast_bar;
                         }
                         else
                         {
                            $batch_array['berry_blast_bar'] = $berry_blast_bar;
                         }
                    }

                    if($chyawanprash_bar!=null)
                    {
                        $type = $this->input->post('type_7');
                        if($type=='Box')
                         {
                            $batch_array['chyawanprash_box'] = $chyawanprash_bar;
                         }
                         else
                         {
                            $batch_array['chyawanprash_bar'] = $chyawanprash_bar;
                         }
                    }

                    if($variety_box!=null)
                    {
                        $batch_array['variety_box'] = $variety_box;
                    }  
                    
                    $sales_rep_stock_detail =  $batch_array;  
                }
                else
                {

                        if($chocolate_cookies!='')
                        {
                            $item_id =37;
                            $data = array(
                                            'type'=>'Box',
                                            'item_id'=>$item_id,
                                            'qty'=>$chocolate_cookies
                                            );
                            $batch_array[] = $data;
                        }

                        if($dark_chocolate_cookies!='')
                        {
                            $item_id =45;
                            $data = array(
                                            'type'=>'Box',
                                            'item_id'=>$item_id,
                                            'qty'=>$dark_chocolate_cookies
                                            );
                            $batch_array[] = $data;
                        }

                        if($cranberry_cookies!='')
                        {
                            $item_id = 39;
                            $data = array( 'type'=>'Box',
                                            'item_id'=>$item_id,
                                            'qty'=>$cranberry_cookies
                                            );
                            $batch_array[] = $data;
                        }

                        if($cranberry_orange_zest!='')
                        {
                            $item_id = 42;
                            $data = array(  'type'=>'Box',
                                            'item_id'=>$item_id,
                                            'qty'=>$cranberry_orange_zest
                                            );
                            $batch_array[] = $data;
                        }
                        
                        if($fig_raisins!='')
                        {
                            $item_id = 41;
                            $data = array(
                                            'type'=>'Box',
                                            'item_id'=>$item_id,
                                            'qty'=>$fig_raisins
                                            );
                            $batch_array[] = $data;
                        }

                        if($papaya_pineapple!='')
                        {
                            $item_id = 40;
                            $data = array(
                                            'type'=>'Box',
                                            'item_id'=>$item_id,
                                            'qty'=>$papaya_pineapple
                                            );
                            $batch_array[] = $data;
                        }

                        if($orange_bar!=null)
                        {
                            $type = $this->input->post('type_0');
                            if($type=='Box'){
                                $item_id = 1;
                            }
                            else{
                                 $item_id = 1;
                            }
                                

                            $data = array(
                                            'type'=>$type,
                                            'item_id'=>$item_id,
                                            'qty'=>$orange_bar
                                            );
                            $batch_array[] = $data;
                        }

                        if($butterscotch_bar!=null)
                        {
                            $type = $this->input->post('type_1');
                            if($type=='Box')
                                $item_id = 3;
                            else
                                $item_id = 3;

                            $data = array(
                                            'type'=>$type,
                                            'item_id'=>$item_id,
                                            'qty'=>$butterscotch_bar
                                            );
                            $batch_array[] = $data;
                        }

                        if($chocopeanut_bar!=null)
                        {
                            $type = $this->input->post('type_3');
                            if($type=='Box')
                                $item_id = 9;
                            else
                                $item_id = 5;
                            
                            $data = array(
                                            'type'=>$type,
                                            'item_id'=>$item_id,
                                            'qty'=>$chocopeanut_bar
                                            );
                            $batch_array[] = $data;
                        }

                        if($bambaiyachaat_bar!=null)
                        {
                            $type = $this->input->post('type_4');
                            if($type=='Box')
                                $item_id = 8;
                            else
                                $item_id = 4;
                            
                            $data = array(
                                            'type'=>$type,
                                            'item_id'=>$item_id,
                                            'qty'=>$bambaiyachaat_bar
                                            );
                            $batch_array[] = $data;
                        }

                        if($mangoginger_bar!=null)
                        {
                            $type = $this->input->post('type_5');
                            if($type=='Box')
                                $item_id = 12;
                            else
                                $item_id = 6;
                            
                           $data = array(
                                            'type'=>$type,
                                            'item_id'=>$item_id,
                                            'qty'=>$mangoginger_bar
                                            );
                            $batch_array[] = $data;
                        }

                        if($berry_blast_bar!=null)
                        {
                            $type = $this->input->post('type_6');
                            if($type=='Box')
                                $item_id = 29;
                            else
                                $item_id = 9;
                            
                           $data = array(
                                            'type'=>$type,
                                            'item_id'=>$item_id,
                                            'qty'=>$berry_blast_bar
                                            );

                            $batch_array[] = $data;
                        }

                        if($chyawanprash_bar!=null)
                        {
                            $type = $this->input->post('type_7');
                            if($type=='Box')
                                $item_id = 31;
                            else
                                $item_id = 10;
                            
                           $data = array(
                                            'type'=>$type,
                                            'item_id'=>$item_id,
                                            'qty'=>$chyawanprash_bar
                                            );
                            $batch_array[] = $data;
                        }

                        if($variety_box!=null)
                        {
                            $item_id = 32;
                            
                            $data = array(
                                            'type'=>'Box',
                                            'item_id'=>32,
                                            'qty'=>$variety_box
                                            );
                            $batch_array[] = $data;
                        }  
                        
                        $merchandiser_stock_details =  $batch_array;
                        /*if(count($batch_array)!='')
                         {
                            $this->db->insert_batch('merchandiser_stock_details',$batch_array);
                         }*/  
                }
         }
         else
         {
                $visit_detail = $this->session->userdata('visit_detail');
                $merchandiser_stock_details = $this->session->userdata('merchandiser_stock_details');
                $sales_rep_stock_detail = $this->session->userdata('sales_rep_stock_detail');
         }
         /*
         echo "<pre>";
         print_r($visit_detail);
         echo "</pre>";
         die();*/

        $retailer_detail = $this->session->userdata('retailer_detail');
        $now=date('Y-m-d H:i:s');
        $now1=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');
        $date_of_visit=$this->input->post('date_of_visit');
        $sales_rep_id=$this->session->userdata('sales_rep_id');
        
        /*$merchendiser_beat_plan_id=$this->input->post('beat_plan_id');*/
        $ispermenant  = $this->input->post('ispermenant');
        $place_order  = $this->input->post('place_order');
        $id  = $this->input->post('id');

        /*$sql = "Select CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
                OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
                THEN CONCAT('Every ',DAYNAME(date(now()))) 
                WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2) 
                THEN  CONCAT('Alternate ',DAYNAME(date(now()))) 
                WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4) 
                THEN   CONCAT('Alternate2 ',DAYNAME(date(now()))) end  as frequency";*/
        $sql = "Select CASE WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
            OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=5) 
            THEN CONCAT('Every ',DAYNAME(date(now()))) 
            WHEN ((FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=2 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4)
            THEN  CONCAT('Alternate ',DAYNAME(date(now()))) end  as frequency";
        $result = $this->db->query($sql)->result();

        $frequency = $result[0]->frequency;

        
        $mid = $visit_detail['mid'];
        $merchendiser_beat_plan_id = $beat_plan_id = $visit_detail['beat_plan_id'];
        $visit_id = 0;
        $sequence=$visit_detail['sequence'];
        if($mid!='')
        {
          $visit_id = $mid;
          if($visit_detail['channel_type']=='MT')
          {

               
                $retailer_id = $store_id = $visit_detail['reation_id'];
                /*$data = array(
                            'm_id' => $sales_rep_id,
                            'dist_id' => $store_id,
                            'dist_name' => $visit_detail['distributor_name'],
                            'latitude' => $visit_detail['latitude'],
                            'longitude' => $visit_detail['longitude'],
                            'remarks' => $visit_detail['remarks'],
                            'modified_by' => $curusr,
                            'modified_on' => $now
                        );*/

                if(isset($followup_date))
                {
                    $data = array('followup_date'=>$followup_date);
                    $this->db->where('id', $mid);
                    $this->db->update('merchandiser_stock',$data);
                    $action='Merchandiser Location Modified.';
                }

                $merchandiser_stock_id=$mid;
                $merchandiser_stock_details = $merchandiser_stock_details;
                if(count($merchandiser_stock_details)>0)
                {
                    for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                            $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                         }

                    $this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');

                    $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                }
          }
          else
          { 
                $retailer_id = $visit_detail['store_id'];
                if($visit_detail['distributor_types']=='Old' )
                {
                    $sales_rep_stock_detail['sales_rep_loc_id'] = $mid;
                    $this->db->where('sales_rep_loc_id',$mid)->update('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);
                    $update_details1 = array('followup_date'=>$followup_date);

                    $this->db->where("id",$mid)->update('sales_rep_location',$update_details1); 
                }
                else
                {
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
								
                            );
							if($save=='')
                        $data_dist['status']='Approved';
                    $this->db->where('id', $store_id)->update('sales_rep_distributors',$data_dist);

                    $bit_plan_data = array(
                        "store_id"=>$visit_detail['store_id'],
                        "location_id"=>$visit_detail['location_id'],
                        "zone_id"=> $visit_detail['zone_id'],
                        "area_id"=> $visit_detail['area_id'],
                        'modified_on' => $now,
                        'modified_by' => $curusr,
                    );
                    $result = $this->db->select("*")->where("bit_plan_id",$beat_plan_id)->get('sales_rep_detailed_beat_plan')->result_array();


                   
                    $prev_store_id = $result[0]['store_id'];
                    $prev_frequency = $result[0]['frequency'];
                    $prev_sales_rep_id = $result[0]['sales_rep_id'];

                    $where_array = array("store_id"=>$prev_store_id,
                                         "sales_rep_id"=>$prev_sales_rep_id,
                                         "frequency"=>$prev_frequency,
                                        );
                    $this->db->where($where_array)->update('sales_rep_beat_plan',$bit_plan_data);    

                    $update_details = array("store_id"=>$visit_detail['store_id'],
                                            'modified_on' => $now);
                    $this->db->where("id",$beat_plan_id)->update('sales_rep_detailed_beat_plan',$update_details);

                    $update_details1 = array('zone_id'=>$visit_detail['zone_id'],
                                            'location_id'=>$visit_detail['location_id'],
                                            'area_id'=>$visit_detail['area_id'],
                                            'distributor_name'=>$visit_detail['distributor_name'],
                                            'followup_date'=>$followup_date);

                    $this->db->where("id",$mid)->update('sales_rep_location',$update_details1); 
                }
          }
        }
        else
        {
            if($visit_detail['channel_type']=='MT')
            {
                /*Else is Place Order Part*/
                $retailer_id = $visit_detail['reation_id'];
                if($visit_detail['follow_type']!='')
                {
                    $store_id = $visit_detail['reation_id'];
                    if($save!='')
                        $dist_status = 'Place Order';
                    else
                        $dist_status = 'Not Intrested';

                   /* $data = array(
                                'm_id' => $sales_rep_id,
                                'date_of_visit' => $now1,
                                'dist_id' => $store_id,
                                'dist_name' => $visit_detail['distributor_name'],
                                'distributor_status' => $dist_status,
                                'latitude' => $visit_detail['latitude'],
                                'longitude' => $visit_detail['longitude'],
                                'remarks' => $visit_detail['remarks'],
                                'modified_by' => $curusr,
                                'modified_on' => $now,
                                'zone_id' => $visit_detail['zone_id'],
                                'location_id' => $visit_detail['location_id']
                            );
                        $data['created_by']=$curusr;
                        $data['created_on']=$now;*/

                    $merchandiser_stock_details = $merchandiser_stock_details;

                    $data = array(
                            'is_visited'=>1
                        );

                    $this->db->where('id',$visit_detail['merchandiser_stock_id'])->update('merchandiser_stock',$data);
                        $merchandiser_stock_id=$visit_detail['merchandiser_stock_id'];
                    if(count($merchandiser_stock_details)>0)
                    {
                        for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                                $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                             }

                        $this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');

                        $visit_id = $merchandiser_stock_id;
                        $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                    }

                    /*if($visit_detail['merchandiser_stock_id']=='')
                    {
                        $data['created_by']=$curusr;
                        $data['created_on']=$now;
                        $this->db->insert('merchandiser_stock',$data);
                        $visit_id = $merchandiser_stock_id=$this->db->insert_id();  

                        if(count($merchandiser_stock_details)>0)
                        {
                            for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                                    $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                                 }
                            $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);  
                        }
                        
                    }
                    else
                    {
                        $this->db->where('id',$visit_detail['merchandiser_stock_id'])->update('merchandiser_stock',$data);
                        $merchandiser_stock_id=$visit_detail['merchandiser_stock_id'];
                        if(count($merchandiser_stock_details)>0)
                        {
                            for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                                    $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                                 }

                            $this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');
                            $visit_id = $merchandiser_stock_id;
                            $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                        }
                    } */ 
                }
                else
                {
                  if($visit_detail['beat_plan_id']!='')
                    {  
                        $retailer_id = $visit_detail['reation_id'];



                        if($save=='Follow Up')
                            $dist_status = 'Follow Up';
                        else if($save=='Save')
                            $dist_status = 'Not Intrested';
                        else 
                            $dist_status = 'Place Order';


                        $data = array(
                                'm_id' => $sales_rep_id,
                                'date_of_visit' => $now,
                                'dist_id' => $retailer_id,
                                'latitude' => $visit_detail['latitude'],
                                'longitude' => $visit_detail['longitude'],
                                'remarks' => trim($visit_detail['remarks']),
                                'location_id' => $visit_detail['location_id'],
                                'zone_id' => $visit_detail['zone_id'],
                                'created_by' => $curusr,
                            );
                         if($save=='Follow Up')
                            $data['followup_date']=$followup_date;
                        $this->db->insert('merchandiser_stock',$data);
                        $visit_id = $merchandiser_stock_id=$this->db->insert_id();   

                        if(count($merchandiser_stock_details)>0)
                        {
                            for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                                    $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                                 }

                            $this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');

                            $visit_id = $merchandiser_stock_id;
                            $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                        }

                        /*Add beatplan*/

                        $sql = "Select max(sequence) as sequence from merchandiser_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id=$sales_rep_id and is_edit='edit' and frequency='$frequency'";
                        $get_maxcount = $this->db->query($sql)->result_array();
                        $visited_sequence = $get_maxcount[0]['sequence']+1;


                        $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and date(date_of_visit)=date(now()) and frequency='$frequency'";
                        $detailed_result = $this->db->query($sql)->result_array();

                        if(count($detailed_result)>0)
                        {
                             $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) ";
                             $result = $this->db->query($sql)->result_array();
                             $this->db->last_query();
                             for ($j=0; $j < count($result); $j++) 
                              {  
                                $result[$j]['sequence'];
                                echo '<br>sequence'.$sequence;
                                if($result[$j]['sequence']<$sequence && $result[$j]['is_edit']!='edit')
                                {
                                    $newsequence = $result[$j]['sequence']+1;
                                    $new_id = $result[$j]['id'];
                                     $data = array('sequence'=>$newsequence,
                                                    'modified_on'=>$now);
                                    $this->db->where('id', $new_id);
                                    $this->db->update('merchandiser_detailed_beat_plan',$data);
                                    $this->db->last_query();
                                }
                              }


                             $data = array('sequence'=>$visited_sequence,
                                         'date_of_visit'=> $now,
                                         'modified_on'=>$now,
                                         'is_edit'=>'edit');

                             $where = array('bit_plan_id'=>$merchendiser_beat_plan_id,
                                            'date(date_of_visit)'=>$now1);

                             $this->db->where($where);
                             $this->db->update('merchandiser_detailed_beat_plan',$data);
                             $this->db->last_query();
                        }
                        else
                        {
                           $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                           $result = $this->db->query($sql)->result_array();
                                

                           for ($j=0; $j < count($result); $j++) 
                              { 
                                if($result[$j]['sequence']<$sequence)
                                {
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
                                    $this->db->last_query();
                                }
                                else if($result[$j]['sequence']>$sequence)
                                {
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
                                    $this->db->last_query();
                                }
                               
                              }


                           $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence=$sequence ";

                          
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
                            $this->db->last_query();
                        }

                        $ispermenant  ='Yes';    
                        if($ispermenant=='Yes' || $place_order=='Yes')
                        {
                            
                            $count_spdb_sql = "select count(*) as count from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                            $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();

                            if($result_spdb_count[0]['count']>0)
                            {
                                $count = $result_spdb_count[0]['count'];
                                $sequence_spdb_sql = "select sequence,id from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                                $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                                $sequence_spdb = $sequence_result[0]['sequence'];  

                                $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                            }
                            else
                            {
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
                            

                            $this->db->last_query();
                        }
                    }
                    else
                    {
                        $sql = "Select max(sequence) as sequence from merchandiser_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id=$sales_rep_id and is_edit='edit' and frequency='$frequency'";
                        $get_maxcount = $this->db->query($sql)->result_array();
                        $visited_sequence = $get_maxcount[0]['sequence']+1;

                       $store_id = $visit_detail['reation_id'];

                       if($save!='Follow Up' && $save!='Save' )
                       {
                       

                         if($visit_detail!=null)
                           {
                                /*$data = array(
                                    'store_id' => $visit_detail['reation_id'],
                                    'zone_id' => $visit_detail['zone_id'],
                                    'location_id' => $visit_detail['location_id'],
                                    'latitude' =>  $visit_detail['latitude'],
                                    'longitude' => $visit_detail['longitude'],
                                    'status' => 'Active',
                                    'modified_by' => $curusr,
                                    'modified_on' => $now,
                                );*/

                               /* $this->db->insert('store_master',$data);
                                echo $this->db->last_query();
                                echo 'insertid'.$insertid=$this->db->insert_id();*/
                               


                                /*insertid is the store_id id*/

                                if($save!='Follow Up')
                                {
                                    /*$sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence>=$visited_sequence";
                                        $result = $this->db->query($sql)->result_array();
                                      echo '<br>'.$this->db->last_query();
                                      for ($j=0; $j < count($result); $j++) 
                                      {   
                                        $newsequence = $result[$j]['sequence']+1;
                                        $new_id = $result[$j]['id'];
                                        $data1 = array('sequence'=>$newsequence,
                                                        'modified_on'=>$now);
                                        $this->db->where('id', $new_id);
                                        $this->db->update('merchandiser_beat_plan',$data1);
                                        $this->db->last_query();
                                      }*/

                                    $sql = "Select count(*) as sequence from merchandiser_beat_plan WHERE frequency='$frequency' and sales_rep_id=$sales_rep_id";
                                    $get_maxcount_sales_rep = $this->db->query($sql)->result_array();
                                      echo '<br>'.$this->db->last_query();
                                    if(count($get_maxcount_sales_rep)==0)
                                    {
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
                                    }
                                    else{

                                        if($visited_sequence==1)
                                          {
                                              $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                                              $result = $this->db->query($sql)->result_array();
                                              for ($j=0; $j < count($result); $j++) 
                                                {
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

                                                  echo '<br>'.$this->db->last_query();
                                                 
                                                }

                                          }
                                          else
                                          {
                                              $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>=$visited_sequence";
                                              $result = $this->db->query($sql)->result_array();
                                                $this->db->last_query();
                                                for ($j=0; $j < count($result); $j++) 
                                                {   
                                                  $newsequence = $result[$j]['sequence']+1;
                                                  $new_id = $result[$j]['id'];
                                                   $data1 = array('sequence'=>$newsequence,
                                                                  'modified_on'=>$now);
                                                  $this->db->where('id', $new_id);
                                                  $this->db->update('merchandiser_detailed_beat_plan',$data1);
                                                  $this->db->last_query();
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
                                        $lastinsertid=$this->db->insert_id();
                                    }
                                    
                                   
                                    if($lastinsertid)
                                    {
                                        if (strpos($frequency, 'Every') !== false) {

                                            $explode_frequency = explode(' ',$frequency);
                                            /*$new_frequency = 'Alternate '.$explode_frequency[1];*/
                                            $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                                            $frequency_result = $this->db->query($selectfre)->result();
                                            $frequency_result = $frequency_result[0]->daymonth;
                                            if($frequency_result==2)
                                            {
                                               $new_frequency = 'Alternate '.$explode_frequency[1]; 
                                            }
                                            else
                                            {
                                                /*$new_frequency = 'Alternate2 '.$explode_frequency[1];*/ $new_frequency = 'Alternate '.$explode_frequency[1];
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
                                        
                                       /* if($visited_sequence==1)
                                        {
                                            $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                                            $result = $this->db->query($sql)->result_array();
                                            for ($j=0; $j < count($result); $j++) 
                                              {
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
                                        }
                                        else
                                        {
                                            $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>=$visited_sequence";
                                            $result = $this->db->query($sql)->result_array();
                                              $this->db->last_query();
                                              for ($j=0; $j < count($result); $j++) 
                                              {   
                                                $newsequence = $result[$j]['sequence']+1;
                                                $new_id = $result[$j]['id'];
                                                 $data1 = array('sequence'=>$newsequence,
                                                                'modified_on'=>$now);
                                                $this->db->where('id', $new_id);
                                                $this->db->update('merchandiser_detailed_beat_plan',$data1);
                                                $this->db->last_query();
                                             }
                                        }*/

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
                                    }

                                }
                                
                                if(isset($followup_date))
                                {
                                    $followup_date = $followup_date;
                                }
                                else
                                {
                                    $followup_date = NULL;
                                }

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
                                echo '<br>last_query'.$this->db->last_query();
                                $visit_id = $id=$this->db->insert_id(); 
                               /*Stock is inserted*/
                           }
                       }

                       if($save=='Follow Up')
                       {
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
                                echo '<br>last_query'.$this->db->last_query();
                                $visit_id = $id=$this->db->insert_id();
                       }
                       
                       if($save!='' && $save!='Follow Up')
                       {
                            
                            if($visited_sequence==1)
                            {
                                $sql = "select * from merchandiser_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                                $result = $this->db->query($sql)->result_array();
                                for ($j=0; $j < count($result); $j++) 
                                  {
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
                                    $this->db->last_query();
                                   
                                  }
                            }
                            else
                            {
                                $sql = "select * from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>=$visited_sequence";
                                $result = $this->db->query($sql)->result_array();
                                  $this->db->last_query();
                                  for ($j=0; $j < count($result); $j++) 
                                  {   
                                    $newsequence = $result[$j]['sequence']+1;
                                    $new_id = $result[$j]['id'];
                                     $data1 = array('sequence'=>$newsequence,
                                                    'modified_on'=>$now);
                                    $this->db->where('id', $new_id);
                                    $this->db->update('merchandiser_detailed_beat_plan',$data1);
                                    $this->db->last_query();
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
                            echo '<br>last_query'.$this->db->last_query();
                            $visit_id = $id=$this->db->insert_id(); 
                       }
                       else
                       {
                            $ispermenant  ='Yes';    
                            if($ispermenant=='Yes' || $place_order=='Yes')
                            {
                                
                                $count_spdb_sql = "select count(*) as count from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                                $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();

                                if($result_spdb_count[0]['count']>0)
                                {
                                    $count = $result_spdb_count[0]['count'];
                                    $sequence_spdb_sql = "select sequence,id from merchandiser_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                                    $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                                    $sequence_spdb = $sequence_result[0]['sequence'];  

                                    $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                                }
                                else
                                {
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
                                

                                echo '<br>'.$this->db->last_query();
                            }

                       }


                        $merchandiser_stock_details = $merchandiser_stock_details;
                        if(count($merchandiser_stock_details)>0)
                        {
                            for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                                    $merchandiser_stock_details[$j]['merchandiser_stock_id']=$visit_id;
                                 }

                            /*$this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');*/

                            $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                        }
                    }  
                }
            }
            else
            {
                $sales_rep_stock_detail = $sales_rep_stock_detail;

                if($visit_detail['follow_type']!='')
                {   
                    if($save!='')
                        $dist_status = 'Place Order';
                    else
                        $dist_status = 'Not Intrested';

                    /*$data = array(
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
                        );*/
                    $retailer_id = $visit_detail['store_id'];
                    

                    $data = array(
                            'is_visited'=>1
                        );

                    $this->db->where('id',$visit_detail['sales_rep_loc_id'])->update('sales_rep_location',$data);
                    $visit_id = $sales_rep_loc_id=$visit_detail['sales_rep_loc_id'];  

                    $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                    $this->db->where('sales_rep_loc_id',$visit_detail['sales_rep_loc_id'])->update('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);  

                   /*if($visit_detail['sales_rep_loc_id']=='')
                    {
                         $data['created_by']=$curusr;
                         $data['created_on']=$now;
                        $this->db->insert('sales_rep_location',$data);
                        $visit_id = $sales_rep_loc_id=$this->db->insert_id();


                        $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;
                        $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);    
                    }
                    else
                    {
                        $this->db->where('id',$visit_detail['sales_rep_loc_id'])->update('sales_rep_location',$data);
                        $visit_id = $sales_rep_loc_id=$visit_detail['sales_rep_loc_id'];  

                        $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                        $this->db->where('sales_rep_loc_id',$visit_detail['sales_rep_loc_id'])->update('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);  
                    }*/
                }
                else
                {
                  /*If bitplan d is old and isedit is empty*/

                   if($visit_detail['beat_plan_id']!='')
                    {
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
                        if($save=='Follow Up')
                            $data['followup_date']=$followup_date;

                        $this->db->insert('sales_rep_location',$data);
                        $visit_id = $sales_rep_loc_id=$this->db->insert_id();    

                        $sales_rep_stock_detail = $sales_rep_stock_detail;
                        $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                        $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);

                        /*Add beatplan*/

                        $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id=$sales_rep_id and is_edit='edit' and frequency='$frequency'";
                        $get_maxcount = $this->db->query($sql)->result_array();
                        $visited_sequence = $get_maxcount[0]['sequence']+1;


                        $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and date(date_of_visit)=date(now()) and frequency='$frequency'";
                        $detailed_result = $this->db->query($sql)->result_array();

                        if(count($detailed_result)>0)
                        {
                             $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) ";
                             $result = $this->db->query($sql)->result_array();
                             $this->db->last_query();
                             for ($j=0; $j < count($result); $j++) 
                              {  
                                $result[$j]['sequence'];
                                echo '<br>sequence'.$sequence;
                                if($result[$j]['sequence']<$sequence && $result[$j]['is_edit']!='edit')
                                {
                                    $newsequence = $result[$j]['sequence']+1;
                                    $new_id = $result[$j]['id'];
                                     $data = array('sequence'=>$newsequence,
                                                    'modified_on'=>$now);
                                    $this->db->where('id', $new_id);
                                    $this->db->update('sales_rep_detailed_beat_plan',$data);
                                    $this->db->last_query();
                                }
                              }


                             $data = array('sequence'=>$visited_sequence,
                                         'date_of_visit'=> $now,
                                         'modified_on'=>$now,
                                         'is_edit'=>'edit');

                             $where = array('bit_plan_id'=>$merchendiser_beat_plan_id,
                                            'date(date_of_visit)'=>$now1);

                             $this->db->where($where);
                             $this->db->update('sales_rep_detailed_beat_plan',$data);
                             $this->db->last_query();
                        }
                        else
                        {
                           $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                           $result = $this->db->query($sql)->result_array();
                                

                           for ($j=0; $j < count($result); $j++) 
                              { 
                                if($result[$j]['sequence']<$sequence)
                                {
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
                                    $this->db->last_query();
                                }
                                else if($result[$j]['sequence']>$sequence)
                                {
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
                                    $this->db->last_query();
                                }
                               
                              }


                           $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence=$sequence ";

                          
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
                            $this->db->last_query();
                        }

                        $ispermenant  ='Yes';    
                        if($ispermenant=='Yes' || $place_order=='Yes')
                        {
                            
                            $count_spdb_sql = "select count(*) as count from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                            $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();

                            if($result_spdb_count[0]['count']>0)
                            {
                                $count = $result_spdb_count[0]['count'];
                                $sequence_spdb_sql = "select sequence,id from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                                $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                                $sequence_spdb = $sequence_result[0]['sequence'];  

                                $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                            }
                            else
                            {
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
                            

                            $this->db->last_query();
                        }
                    }
                    else
                    {
                        $sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and sales_rep_id=$sales_rep_id and is_edit='edit' and frequency='$frequency'";
                        $get_maxcount = $this->db->query($sql)->result_array();
                        $visited_sequence = $get_maxcount[0]['sequence']+1;
                        $retailer_id = 0;

                       if($visit_detail!=null)
                           {
							   if($save!='')
                                    $status='InActive';
                                else
                                    $status='Approved';

                                if($visit_detail['distributor_types']=='New')
                                {
                                       $retailer_details = array(
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
                                        'status'=>$status
                                    );

                                    $this->db->insert('sales_rep_distributors',$retailer_details);
                                    $insertid=$this->db->insert_id();

                                    $action='Sales Rep Distributor Created.';
                                    $store_id = $insertid;
                                    $retailer_id = 's_'.$store_id;  
                                }
                                else
                                {   
                                    $retailer_id =  $visit_detail['distributor_id'];
                                }


                                if($save!='Follow Up')
                                {   
                                    if($retailer_id)
                                    { 
                                          

                                        if($save=='')
                                        {
                                                /*$sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence>=$visited_sequence";
                                                    $result = $this->db->query($sql)->result_array();
                                                  $this->db->last_query();
                                                  for ($j=0; $j < count($result); $j++) 
                                                  {   
                                                        $newsequence = $result[$j]['sequence']+1;
                                                        $new_id = $result[$j]['id'];
                                                        $data1 = array('sequence'=>$newsequence,
                                                                        'modified_on'=>$now);
                                                        $this->db->where('id', $new_id);
                                                        $this->db->update('sales_rep_beat_plan',$data1);
                                                  }*/

                                                $sql = "Select count(*) as sequence from sales_rep_beat_plan WHERE frequency='$frequency' and sales_rep_id=$sales_rep_id";

                                                $get_maxcount_sales_rep = $this->db->query($sql)->result_array();
                                                if(count($get_maxcount_sales_rep)==0)
                                                {
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
                                                }
                                                else
                                                {
                                                    if($visited_sequence==1)
                                                    {
                                                        $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                                                        $result = $this->db->query($sql)->result_array();
                                                        for ($j=0; $j < count($result); $j++) 
                                                          {
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
                                                    else
                                                    {
                                                        $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>=$visited_sequence";
                                                        $result = $this->db->query($sql)->result_array();
                                                          $this->db->last_query();
                                                          for ($j=0; $j < count($result); $j++) 
                                                          {   
                                                            $newsequence = $result[$j]['sequence']+1;
                                                            $new_id = $result[$j]['id'];
                                                             $data1 = array('sequence'=>$newsequence,
                                                                            'modified_on'=>$now);
                                                            $this->db->where('id', $new_id);
                                                            $this->db->update('sales_rep_detailed_beat_plan',$data1);
                                                            $this->db->last_query();
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
                                                    $lastinsertid=$this->db->insert_id();
                                                }

                                                if($lastinsertid)
                                                {
                                                    if (strpos($frequency, 'Every') !== false) {

                                                        $explode_frequency = explode(' ',$frequency);
                                                        /*$new_frequency = 'Alternate '.$explode_frequency[1];*/
                                                        $selectfre = "SELECT (FLOOR((DayOfMonth(date(now()))-1)/7)+1 ) as daymonth";
                                                        $frequency_result = $this->db->query($selectfre)->result();
                                                        $frequency_result = $frequency_result[0]->daymonth;
                                                        if($frequency_result==2)
                                                        {
                                                           $new_frequency = 'Alternate '.$explode_frequency[1]; 
                                                        }
                                                        else
                                                        {
                                                            /*$new_frequency = 'Alternate2 '.$explode_frequency[1];*/ $new_frequency = 'Alternate '.$explode_frequency[1];
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
                                                } 
                                        }
                                        /*else
                                        {

                                             $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and sequence>=$visited_sequence";
                                                    $result = $this->db->query($sql)->result_array();
                                                  $this->db->last_query();
                                                  for ($j=0; $j < count($result); $j++) 
                                                  {   
                                                        $newsequence = $result[$j]['sequence']+1;
                                                        $new_id = $result[$j]['id'];
                                                        $data1 = array('sequence'=>$newsequence,
                                                                        'modified_on'=>$now);
                                                        $this->db->where('id', $new_id);
                                                        $this->db->update('sales_rep_detailed_beat_plan',$data1);

                                                  }
                                        }*/
                                    }
                                }
                               

                                if($save!='')
                                    $dist_status = 'Place Order';
                                else
                                    $dist_status = 'Not Intrested';

                                if(isset($followup_date))
                                {
                                    $followup_date = $followup_date;
                                }
                                else
                                {
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
                       /* IF Not Intrested Add in visit table if other entry is updated Update detailed beat plans*/
                       if($save!='' && $save!='Follow Up')
                       {

                            if($visited_sequence==1)
                            {
                                $sql = "select * from sales_rep_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency'";
                                $result = $this->db->query($sql)->result_array();
                                for ($j=0; $j < count($result); $j++) 
                                  {
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
                                    $this->db->last_query();
                                   
                                  }

                            }
                            else
                            {
                                $sql = "select * from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and date(date_of_visit)=date(now()) and sequence>=$visited_sequence";
                                $result = $this->db->query($sql)->result_array();
                                  $this->db->last_query();
                                  for ($j=0; $j < count($result); $j++) 
                                  {   
                                    $newsequence = $result[$j]['sequence']+1;
                                    $new_id = $result[$j]['id'];
                                     $data1 = array('sequence'=>$newsequence,
                                                    'modified_on'=>$now);
                                    $this->db->where('id', $new_id);
                                    $this->db->update('sales_rep_detailed_beat_plan',$data1);
                                    $this->db->last_query();
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
                                         'zone_id' =>     $visit_detail['zone_id'],
                                         'area_id' =>     $visit_detail['area_id'],
                                      );
                            $data2['bit_plan_id']=0;    
                            $data2['is_edit']='edit';
                            $this->db->insert('sales_rep_detailed_beat_plan',$data2);
                            $this->db->last_query();
                            //die();
                       }
                       else
                       {
                            $ispermenant  ='Yes';    
                            if($ispermenant=='Yes' || $place_order=='Yes')
                            {
                                
                                $count_spdb_sql = "select count(*) as count from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0 and date(date_of_visit)=date(now())";
                                $result_spdb_count = $this->db->query($count_spdb_sql)->result_array();

                                if($result_spdb_count[0]['count']>0)
                                {
                                    $count = $result_spdb_count[0]['count'];
                                    $sequence_spdb_sql = "select sequence,id from sales_rep_detailed_beat_plan Where sales_rep_id=$sales_rep_id and frequency='$frequency' and bit_plan_id=0  order by id asc Limit 0,1";
                                    $sequence_result = $this->db->query($sequence_spdb_sql)->result_array();
                                    $sequence_spdb = $sequence_result[0]['sequence'];  

                                    $condition  = "Case When m2.sequence>=$sequence_spdb Then (m2.sequence-$count) Else  m2.sequence end ";
                                }
                                else
                                {
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
                                

                                $this->db->last_query();
                            }
                       }
                    }  
                }
            }
        }
        
        /*
         Place Order
        */

        if($save=='')
        {
            echo "enterd";

            $orange_bar = $this->input->post('orange_bar');
            $butterscotch_bar = $this->input->post('butterscotch_bar');
            $chocopeanut_bar = $this->input->post('chocopeanut_bar');
            $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
            $mangoginger_bar = $this->input->post('mangoginger_bar');
            $berry_blast_bar = $this->input->post('berry_blast_bar');
            $chyawanprash_bar = $this->input->post('chyawanprash_bar');
            $variety_box = $this->input->post('variety_box');
            $chocolate_cookies = $this->input->post('chocolate_cookies');
            $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
            $cranberry_cookies = $this->input->post('cranberry_cookies');
            $cranberry_orange = $this->input->post('cranberry_orange');
            $fig_raisins = $this->input->post('fig_raisins');
            $papaya_pineapple = $this->input->post('papaya_pineapple');
            $cranberry_orange_zest = $this->input->post('cranberry_orange_zest');   
            $batch_array = array();

            /*$retailer_id = $retailer_id;*/
            /*$get_orders = $this->db->query("Select * from sales_rep_orders Where distributor_id='$retailer_id'")->result_array();*/

            $now = date('Y-m-d');
            $sql = "Select * from sales_rep_orders Where distributor_id='$retailer_id' and date(created_on)='$now' and sales_rep_id=$sales_rep_id";
            $get_orders = $this->db->query($sql)->result_array();
            if(count($get_orders)>0)
            {
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
            }
            else
            {
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

            if($id)
            {
                if($chocolate_cookies!='')
                {
                    $item_id =37;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$chocolate_cookies
                                    );
                    $batch_array[] = $data;
                }

                if($dark_chocolate_cookies!='')
                {
                    $item_id =45;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$dark_chocolate_cookies
                                    );
                    $batch_array[] = $data;
                }

                if($cranberry_cookies!='')
                {
                    $item_id = 39;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$cranberry_cookies
                                    );
                    $batch_array[] = $data;
                }

                if($cranberry_orange_zest!='')
                {
                    $item_id = 42;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$cranberry_orange_zest
                                    );
                    $batch_array[] = $data;
                }
                
                if($fig_raisins!='')
                {
                    $item_id = 41;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$fig_raisins
                                    );
                    $batch_array[] = $data;
                }

                if($papaya_pineapple!='')
                {
                    $item_id = 40;
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$papaya_pineapple
                                    );
                    $batch_array[] = $data;
                }

                if($orange_bar!=null)
                {
                    $type = $this->input->post('type_0');
                    if($type=='Box'){
                        $item_id = 1;
                    }
                    else{
                         $item_id = 1;
                    }
                        

                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$orange_bar
                                    );
                    $batch_array[] = $data;
                }

                if($butterscotch_bar!=null)
                {
                    $type = $this->input->post('type_1');
                    if($type=='Box')
                        $item_id = 3;
                    else
                        $item_id = 3;

                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$butterscotch_bar
                                    );
                    $batch_array[] = $data;
                }

                if($chocopeanut_bar!=null)
                {
                    $type = $this->input->post('type_3');
                    if($type=='Box')
                        $item_id = 9;
                    else
                        $item_id = 5;
                    
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$chocopeanut_bar
                                    );
                    $batch_array[] = $data;
                }

                if($bambaiyachaat_bar!=null)
                {
                    $type = $this->input->post('type_4');
                    if($type=='Box')
                        $item_id = 8;
                    else
                        $item_id = 4;
                    
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$bambaiyachaat_bar
                                    );
                    $batch_array[] = $data;
                }

                if($mangoginger_bar!=null)
                {
                    $type = $this->input->post('type_5');
                    if($type=='Box')
                        $item_id = 12;
                    else
                        $item_id = 6;
                    
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$mangoginger_bar
                                    );
                    $batch_array[] = $data;
                }

                if($berry_blast_bar!=null)
                {
                    $type = $this->input->post('type_6');
                    if($type=='Box')
                        $item_id = 29;
                    else
                        $item_id = 9;
                    
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$berry_blast_bar
                                    );

                    $batch_array[] = $data;
                }

                if($chyawanprash_bar!=null)
                {
                    $type = $this->input->post('type_7');
                    if($type=='Box')
                        $item_id = 31;
                    else
                        $item_id = 10;
                    
                   $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$chyawanprash_bar
                                    );
                    $batch_array[] = $data;
                }

                if($variety_box!=null)
                {
                    $item_id = 32;
                    
                    $data = array(
                                    'sales_rep_order_id' => $id,
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$variety_box
                                    );
                    $batch_array[] = $data;
                }  
             
             
             if(count($batch_array)!='')
             {
                $this->db->where('sales_rep_order_id',$id)->delete('sales_rep_order_items');
                $this->db->last_query();
                $this->db->insert_batch('sales_rep_order_items',$batch_array);
             }  
            } 

        }

        $this->session->unset_userdata('visit_detail');
        $this->session->unset_userdata('retailer_detail');
        $this->session->unset_userdata('temp_stock_details');
        $this->session->unset_userdata('merchandiser_stock_details');
        $this->session->unset_userdata('merchandiser_stock_details');
        redirect(base_url().'index.php/Sales_rep_store_plan');
       /*$this->Sales_location_model->save_order('','Place Order');*/
    }
    
    public function test_function()
    {
        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $set_days = '';

        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $set_days = 'Alternate '.$day;
        }
        else
        {
            $set_days = 'Every '.$day;
        }

        echo $set_days;
    }

    public function get_alternate($day,$m,$year)
    {
        
        $date1 = date('d-m-Y', strtotime('second '.$day.' of '.$m.' '.$year));
        $date2 = date('d-m-Y', strtotime('fourth '.$day.' of '.$m.' '.$year));

        $todaysdate = date('d-m-Y');
        if($date1==$todaysdate) 
        {
            return true;
        }
        elseif($date2==$todaysdate)
        {
            return true;
        }
        else
        {
           return false;
        }
    }

    public function sales_rep_not_mapped($status='')
    {
        $result = $this->db->query('Select DISTINCT sales_rep_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='Sales Representative' and   id NOT IN($sales_rep_id)")->result();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='sales_rep_not_mapped.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function merchandizer_not_mapped($status='')
    {
       $result = $this->db->query('Select DISTINCT merchendizer_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='merchandiser' and   id NOT IN($sales_rep_id)")->result();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='sales_rep_not_mapped.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function store_not_mapped($status='')
    {
        $result = $this->db->query('Select DISTINCT store_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("select * from relationship_master  Where status='Approved'")->result();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='sales_rep_not_mapped.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function retailer_not_mapped($status='')
    {
       $result = $this->db->query('Select DISTINCT dist_id from merchandiser_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->dist_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);
       $result = $this->db->query("SELECT * from distributor_master Where status='Approved' and   id NOT IN($sales_rep_id)")->result();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->sales_rep_name);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='sales_rep_not_mapped.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }   
    
    

    public function test_data()
    {
       /*$one_array = array(0=>1,1=>2,2=>3,3=>4,4=>5);
       $two_array = array(0=>1,1=>2,2=>3,3=>4,4=>5);
        echo '$a == $b is ', var_dump($one_array==$two_array); */
    }

    public function clear_session()
    {
        $this->session->unset_userdata('visit_detail');
        $this->session->unset_userdata('retailer_detail');
        $this->session->unset_userdata('temp_stock_details');
        $this->session->unset_userdata('merchandiser_stock_details');
        $this->session->unset_userdata('merchandiser_stock_details');
        /*redirect($_SERVER['HTTP_REFERER']);*/
        redirect(base_url().'index.php/Sales_rep_store_plan');
    }

    public function add_stock($id='',$get_frequency='',$get_channel_type='',$follow_type='', $temp=''){
        $result=$this->sales_rep_location_model->get_access();
        $day =  date('l');
        $m = date('F');
        $year = date('Y');
        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_location_model->get_access();
                $data['distributor'] = $this->sales_rep_distributor_model->get_data2('Approved');

                if($this->session->userdata('temp_stock_details')!=null)
                {
                    if($follow_type!='')
                    {
                        if($follow_type=='gt_followup')
                            {
                                $result=$this->Sales_location_model->get_gtfollowup($id);
                                $data['data'] = $result;
                            }
                        else
                        {
                            $result=$this->Sales_location_model->get_mtfollowup($id);
                                $data['data'] = $result;
                        }
                    }


                    $data['stock_detail']=$this->session->userdata('temp_stock_details');
                }
                else
                {
                   if($follow_type!='')
                    {
                        if($follow_type=='gt_followup')
                        {
                            $result=$this->Sales_location_model->get_gtfollowup($id);
                            $data['data'] = $result;

                            $sales_loc_id = $result[0]->is_edit;
                            if($sales_loc_id!=NULL)
                            {
                                $result = $this->db->query("SELECT id as stock_id ,sales_rep_loc_id,case When orange_bar IS NOT NULL and orange_bar!=0 Then CONCAT(orange_bar,'_Bar') ELSE CONCAT(orange_box,'_Box') end as orange,
                                    case When mint_bar IS NOT NULL and mint_bar!=0 Then CONCAT(mint_box,'_Bar') ELSE CONCAT(mint_bar,'_Box') end as mint,
                                    case When butterscotch_bar IS NOT NULL and butterscotch_bar!=0 Then CONCAT(butterscotch_bar,'_Bar') ELSE CONCAT(butterscotch_box,'_Box') end as butterscotch,
                                    case When chocopeanut_bar IS NOT NULL and chocopeanut_bar!=0 Then CONCAT(chocopeanut_bar,'_Bar') ELSE CONCAT(chocopeanut_box,'_Box') end as chocopeanut,
                                    case When bambaiyachaat_bar IS NOT NULL and bambaiyachaat_bar!=0 Then CONCAT(bambaiyachaat_bar,'_Bar') ELSE CONCAT(bambaiyachaat_box,'_Box') end as bambaiyachaat,
                                    case When mangoginger_bar IS NOT NULL and mangoginger_bar!=0 Then CONCAT(mangoginger_bar,'_Bar') ELSE CONCAT(mangoginger_box,'_Box') end as mangoginger,
                                    case When berry_blast_bar IS NOT NULL and berry_blast_bar!=0 Then CONCAT(berry_blast_bar,'_Bar') ELSE CONCAT(berry_blast_box,'_Box') end as berry_blast,
                                    case When chyawanprash_bar IS NOT NULL and chyawanprash_bar!=0 Then CONCAT(chyawanprash_bar,'_Bar') ELSE CONCAT(chyawanprash_box,'_Box') end as chyawanprash,
                                    chocolate_cookies_box,cranberry_orange_box,dark_chocolate_cookies_box,fig_raisins_box,papaya_pineapple_box,variety_box,cranberry_cookies_box,sales_rep_loc_id from  sales_rep_distributor_opening_stock Where sales_rep_loc_id=$sales_loc_id")->result_array();
                                $this->db->last_query();
                                $data['stock_detail']=$result[0];


                                /*$stock_detail = array();*/
                               /*for($i=0;$i<count($result);$i++)
                               {
                                   $mangoginger_bar = $result[0]['mangoginger_bar'];

                                   if($result[0]['mangoginger_bar']!=0 || $result[0]['mangoginger_bar']!=NUll)
                                   {
                                      $stock_detail['mangoginger_bar']= $result[0]['mangoginger_bar'];
                                   }

                                   $berry_blast_bar = $result[0]['berry_blast_bar'];
                                   $chyawanprash_bar = $result[0]['chyawanprash_bar'];
                                   $chyawanprash_bar = $result[0]['chyawanprash_bar'];
                               }*/
                            }
                        }
                        else
                        {
                            $result=$this->Sales_location_model->get_mtfollowup($id);
                            $data['data'] = $result;
                            $sales_loc_id = $result[0]->merchandiser_stock_id;
                            if($sales_loc_id!=NULL)
                            {
                                $result = $this->db->query("Select A.id as stock_id ,merchandiser_stock_id as visit_id ,
                                Case When type='Box' Then box_name ELSE product_name end as product_name,
                                Case When type='Box' Then CONCAT(qty,'_Bar') ELSE CONCAT(qty,'_Box') end as qty,item_id,type
                                from
                                (SELECT * from merchandiser_stock_details where merchandiser_stock_id=$sales_loc_id) A
                                Left join 
                                (SELECT * from box_master)B on A.item_id=B.id
                                Left join 
                                (SELECT * from product_master)C on A.item_id=C.id")->result_array();
                                $this->db->last_query();

                                $stock_detail = array();
                                if(count($result)>0)
                                {
                                    for ($j=0; $j <count($result) ; $j++) {
                                        if ($result[$j]['item_id']==37) {
                                            $stock_detail['chocolate_cookies_box']=$result[$j]['qty'];
                                        }
                                       if ($result[$j]['item_id']==45) {
                                            $stock_detail['dark_chocolate_cookies_box']=$result[$j]['qty'];
                                        }
                                        if ($result[$j]['item_id']==39) {
                                            $stock_detail['cranberry_cookies_box']=$result[$j]['qty'];
                                        }
                                        if ($result[$j]['item_id']==42) {
                                            $stock_detail['cranberry_orange_box']=$result[$j]['qty'];
                                        }
                                        if ($result[$j]['item_id']==41) {
                                            $stock_detail['fig_raisins_box']=$result[$j]['qty'];
                                        }
                                        if ($result[$j]['item_id']==40) {
                                            $stock_detail['papaya_pineapple_box']=$result[$j]['qty'];
                                        }
                                        
                                        if($result[$j]['item_id']==1 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                        {
                                            $stock_detail['orange']=$result[$j]['qty'];
                                        }

                                        if($result[$j]['item_id']==3 && ($result[$j]['type']=='Bar' || $result[$j]['type']=='Box'))
                                        {
                                            $stock_detail['butterscotch']=$result[$j]['qty'];
                                        }

                                        if($result[$j]['item_id']==9 && $result[$j]['type']=='Box')
                                        {
                                            $stock_detail['butterscotch']=$result[$j]['qty'];
                                        }
                                        else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar')
                                        {
                                            $stock_detail['butterscotch']=$result[$j]['qty'];
                                        }

                                        if($result[$j]['item_id']==9 && $result[$j]['type']=='Box')
                                                $stock_detail['chocopeanut']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==5 && $result[$j]['type']=='Bar')
                                                $stock_detail['chocopeanut']=$result[$j]['qty'];

                                         if($result[$j]['item_id']==8 && $result[$j]['type']=='Box')
                                                $stock_detail['bambaiyachaat']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==4 && $result[$j]['type']=='Bar')
                                                $stock_detail['bambaiyachaat']=$result[$j]['qty'];

                                        if($result[$j]['item_id']==21 && $result[$j]['type']=='Box')
                                                $stock_detail['mangoginger']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==6 && $result[$j]['type']=='Bar')
                                                $stock_detail['mangoginger']=$result[$j]['qty'];

                                        if($result[$j]['item_id']==29 && $result[$j]['type']=='Box')
                                                $stock_detail['berry_blast']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==9 && $result[$j]['type']=='Bar')
                                                $stock_detail['berry_blast']=$result[$j]['qty'];

                                        if($result[$j]['item_id']==31 && $result[$j]['type']=='Box')
                                                $stock_detail['chyawanprash']=$result[$j]['qty'];
                                        else if($result[$j]['item_id']==10 && $result[$j]['type']=='Bar')
                                                $stock_detail['chyawanprash']=$result[$j]['qty'];

                                         if($result[$j]['item_id']==32 && $result[$j]['type']=='Box')
                                                $stock_detail['variety_box']=$result[$j]['qty'];
                                    }

                                    $data['stock_detail'] = $stock_detail;
                                }

                                /*$stock_detail = array();*/
                                   /*for($i=0;$i<count($result);$i++)
                                   {
                                       $mangoginger_bar = $result[0]['mangoginger_bar'];

                                       if($result[0]['mangoginger_bar']!=0 || $result[0]['mangoginger_bar']!=NUll)
                                       {
                                          $stock_detail['mangoginger_bar']= $result[0]['mangoginger_bar'];
                                       }

                                       $berry_blast_bar = $result[0]['berry_blast_bar'];
                                       $chyawanprash_bar = $result[0]['chyawanprash_bar'];
                                       $chyawanprash_bar = $result[0]['chyawanprash_bar'];
                                   }*/
                            }
                        }
                    }
                    else
                    {
                        if($id!='')
                        {

                            if($get_channel_type=='GT')
                            {
                                $data['data']=$this->Sales_location_model->get_data('Approved',$id);           
                            }
                            else
                            {
                                $data['data']=$this->Sales_location_model->get_merchendiser_data('Approved',$id);
                            }
                        } 



                    } 
                }


               $sales_rep_id=$this->session->userdata('sales_rep_id');

               
               /*$sql = "Select max(sequence) as sequence from sales_rep_detailed_beat_plan WHERE date(date_of_visit)=date(now()) and is_edit='edit' and frequency='$frequency' and sales_rep_id='$sales_rep_id'";
                $get_maxcount = $this->db->query($sql)->result_array();
                $data['sequence_count'] = $get_maxcount[0]['sequence']+1;*/
                /*$data['store_plan']=$this->Sales_location_model->get_data('Approved',$id,'');*/

                if($get_channel_type==''){
                    $channel_type = 'GT';
                }
                else
                {
                    $channel_type = $get_channel_type;
                }

                $data['zone'] = $this->sales_rep_location_model->get_zone('',$channel_type);
                $data['area'] = $this->sales_rep_location_model->get_area();
                $data['location'] = $this->sales_rep_location_model->get_locations();
                $data['follow_type'] = $follow_type;
                $data['salesrep'] = $this->sales_rep_model->get_data_salesrep('Approved');
                $promoter = $this->sales_rep_model->get_data_promoter('Approved');
                $merchandizer_re = $this->sales_rep_model->get_data_merchandizer('Approved');
                $merchendizer = array_merge($promoter,$merchandizer_re);
                $data['merchandizer'] = $merchendizer;
                if($get_channel_type!='')
                    $data['channel_type']=$get_channel_type;

                load_view('sales_rep_location/stock_entry', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }

        
    }

public function save_stock(){
        $channel_type  = $this->input->post('channel_type');
        $distributor_type  = $this->input->post('distributor_type');
        $distributor_name  = $this->input->post('distributor_name');
        $zone_id  = $this->input->post('zone_id');
        $area_id  = $this->input->post('area_id');
        $location_id  = $this->input->post('location_id');
        $longitude  = $this->input->post('longitude');
        $latitude  = $this->input->post('latitude');
        $remarks  = $this->input->post('remarks');
        $reation_id  = $this->input->post('reation_id');
        $distributor_id  = $this->input->post('distributor_id');
        $mid  = $this->input->post('mid');
        $beat_plan_id  = $this->input->post('beat_plan_id');
        $distributor_status  = $this->input->post('distributor_status');
        $sales_rep_loc_id  = $this->input->post('sales_rep_loc_id');
        $sequence = $this->input->post('sequence');
        $reation_id  = $this->input->post('reation_id');
        $merchandiser_stock_id  = $this->input->post('merchandiser_stock_id');
        $follow_type  = $this->input->post('follow_type');
        $reation_id  = $this->input->post('reation_id');
        $date_of_visit  = trim($this->input->post('date_of_visit'));
        if($date_of_visit==''){
            $date_of_visit=NULL;
        } else {
           $date_of_visit=formatdate($date_of_visit);
        }
        if($channel_type=='GT')
        {
            $sales_rep_id = $this->input->post('salesrep_id');
        }
        else
        {
            $sales_rep_id = $this->input->post('merchendizer_id');
        }

        $now=date('Y-m-d H:i:s');
        $now1=date('Y-m-d');
        $curusr=$this->session->userdata('session_id');
        $sql = "Select CASE WHEN ((FLOOR((DayOfMonth(date('$date_of_visit'))-1)/7)+1 )=1 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=3 
            OR (FLOOR((DayOfMonth(date('$date_of_visit'))-1)/7)+1 )=5) 
            THEN CONCAT('Every ',DAYNAME(date('$date_of_visit'))) 
            WHEN ((FLOOR((DayOfMonth(date('$date_of_visit'))-1)/7)+1 )=2 OR (FLOOR((DayOfMonth(date(now()))-1)/7)+1 )=4)
            THEN  CONCAT('Alternate ',DAYNAME(date('$date_of_visit'))) end  as frequency";
        $result = $this->db->query($sql)->result();

        $frequency = $result[0]->frequency;


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
            'distributor_status'=>$distributor_status,
            'sales_rep_loc_id'=>$sales_rep_loc_id,
            'sequence'=>$sequence,
            'merchandiser_stock_id'=>$merchandiser_stock_id
        );

        $batch_array = array();
        $orange_bar = $this->input->post('orange_bar');
        $butterscotch_bar = $this->input->post('butterscotch_bar');
        $chocopeanut_bar = $this->input->post('chocopeanut_bar');
        $bambaiyachaat_bar = $this->input->post('bambaiyachaat_bar');
        $mangoginger_bar = $this->input->post('mangoginger_bar');
        $berry_blast_bar = $this->input->post('berry_blast_bar');
        $chyawanprash_bar = $this->input->post('chyawanprash_bar');
        $variety_box = $this->input->post('variety_box');
        $chocolate_cookies = $this->input->post('chocolate_cookies');
        $dark_chocolate_cookies = $this->input->post('dark_chocolate_cookies');
        $cranberry_cookies = $this->input->post('cranberry_cookies');
        $cranberry_orange = $this->input->post('cranberry_orange');
        $fig_raisins = $this->input->post('fig_raisins');
        $papaya_pineapple = $this->input->post('papaya_pineapple');
        $cranberry_orange_zest = $this->input->post('cranberry_orange_zest');
        $batch_array = array();    
        if($channel_type=='GT')
        {
            if($chocolate_cookies!='')
            {

                $batch_array['chocolate_cookies_box']=$chocolate_cookies;
            }

            if($dark_chocolate_cookies!='')
            {
               $batch_array['dark_chocolate_cookies_box']=$dark_chocolate_cookies;
            }

            if($cranberry_cookies!='')
            {
                $batch_array['cranberry_cookies_box']=$cranberry_cookies;
            }

            if($cranberry_orange_zest!='')
            {
                $batch_array['cranberry_orange_box'] = $cranberry_orange_zest;
            }
            
            if($fig_raisins!='')
            {
                $batch_array['fig_raisins_box'] = $fig_raisins;
            }

            if($papaya_pineapple!='')
            {
                $batch_array['papaya_pineapple_box'] = $papaya_pineapple;
            }

            if($orange_bar!=null)
            {
                 $type = $this->input->post('type_0');
                 if($type=='Box')
                 {
                    $batch_array['orange_box'] = $orange_bar;
                 }
                 else
                 {
                    $batch_array['orange_bar'] = $orange_bar;
                 }
            }

            if($butterscotch_bar!=null)
            {
                $type = $this->input->post('type_1');    
                if($type=='Box')
                 {
                    $batch_array['butterscotch_box'] = $butterscotch_bar;
                 }
                 else
                 {
                    $batch_array['butterscotch_bar'] = $butterscotch_bar;
                 }
            }

            if($chocopeanut_bar!=null)
            {
                $type = $this->input->post('type_3');
                if($type=='Box')
                 {
                    $batch_array['chocopeanut_box'] = $chocopeanut_bar;
                 }
                 else
                 {
                    $batch_array['chocopeanut_bar'] = $chocopeanut_bar;
                 }
            }

            if($bambaiyachaat_bar!=null)
            {
                $type = $this->input->post('type_4');
                 if($type=='Box')
                 {
                    $batch_array['bambaiyachaat_box'] = $bambaiyachaat_bar;
                 }
                 else
                 {
                    $batch_array['bambaiyachaat_bar'] = $bambaiyachaat_bar;
                 }
            }

            if($mangoginger_bar!=null)
            {
                $type = $this->input->post('type_5');
                if($type=='Box')
                 {
                    $batch_array['mangoginger_box'] = $mangoginger_bar;
                 }
                 else
                 {
                    $batch_array['mangoginger_bar'] = $mangoginger_bar;
                 }
            }

            if($berry_blast_bar!=null)
            {
                $type = $this->input->post('type_6');
                if($type=='Box')
                 {
                    $batch_array['berry_blast_box'] = $berry_blast_bar;
                 }
                 else
                 {
                    $batch_array['berry_blast_bar'] = $berry_blast_bar;
                 }
            }

            if($chyawanprash_bar!=null)
            {
                $type = $this->input->post('type_7');
                if($type=='Box')
                 {
                    $batch_array['chyawanprash_box'] = $chyawanprash_bar;
                 }
                 else
                 {
                    $batch_array['chyawanprash_bar'] = $chyawanprash_bar;
                 }
            }

            if($variety_box!=null)
            {
                $batch_array['variety_box'] = $variety_box;
            }  
            
            $sales_rep_stock_detail =  $batch_array;  


             $data = array(
                        'sales_rep_id' => $sales_rep_id,
                        'date_of_visit' => $date_of_visit,
                        'distributor_type' => $visit_detail['distributor_types'],
                        'distributor_id' => $visit_detail['distributor_id'],
                        'distributor_name' => $visit_detail['distributor_name'],
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

                $this->db->insert('sales_rep_location',$data);
                $visit_id = $sales_rep_loc_id=$this->db->insert_id();    

                $sales_rep_stock_detail = $sales_rep_stock_detail;
                $sales_rep_stock_detail['sales_rep_loc_id'] = $sales_rep_loc_id;

                $this->db->insert('sales_rep_distributor_opening_stock',$sales_rep_stock_detail);
        }
        else
        {
                if($chocolate_cookies!='')
                {
                    $item_id =37;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$chocolate_cookies
                                    );
                    $batch_array[] = $data;
                }

                if($dark_chocolate_cookies!='')
                {
                    $item_id =45;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$dark_chocolate_cookies
                                    );
                    $batch_array[] = $data;
                }

                if($cranberry_cookies!='')
                {
                    $item_id = 39;
                    $data = array( 'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$cranberry_cookies
                                    );
                    $batch_array[] = $data;
                }

                if($cranberry_orange_zest!='')
                {
                    $item_id = 42;
                    $data = array(  'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$cranberry_orange_zest
                                    );
                    $batch_array[] = $data;
                }
                
                if($fig_raisins!='')
                {
                    $item_id = 41;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$fig_raisins
                                    );
                    $batch_array[] = $data;
                }

                if($papaya_pineapple!='')
                {
                    $item_id = 40;
                    $data = array(
                                    'type'=>'Box',
                                    'item_id'=>$item_id,
                                    'qty'=>$papaya_pineapple
                                    );
                    $batch_array[] = $data;
                }

                if($orange_bar!=null)
                {
                    $type = $this->input->post('type_0');
                    if($type=='Box'){
                        $item_id = 1;
                    }
                    else{
                         $item_id = 1;
                    }
                        

                    $data = array(
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$orange_bar
                                    );
                    $batch_array[] = $data;
                }

                if($butterscotch_bar!=null)
                {
                    $type = $this->input->post('type_1');
                    if($type=='Box')
                        $item_id = 3;
                    else
                        $item_id = 3;

                    $data = array(
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$butterscotch_bar
                                    );
                    $batch_array[] = $data;
                }

                if($chocopeanut_bar!=null)
                {
                    $type = $this->input->post('type_3');
                    if($type=='Box')
                        $item_id = 9;
                    else
                        $item_id = 5;
                    
                    $data = array(
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$chocopeanut_bar
                                    );
                    $batch_array[] = $data;
                }

                if($bambaiyachaat_bar!=null)
                {
                    $type = $this->input->post('type_4');
                    if($type=='Box')
                        $item_id = 8;
                    else
                        $item_id = 4;
                    
                    $data = array(
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$bambaiyachaat_bar
                                    );
                    $batch_array[] = $data;
                }

                if($mangoginger_bar!=null)
                {
                    $type = $this->input->post('type_5');
                    if($type=='Box')
                        $item_id = 12;
                    else
                        $item_id = 6;
                    
                   $data = array(
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$mangoginger_bar
                                    );
                    $batch_array[] = $data;
                }

                if($berry_blast_bar!=null)
                {
                    $type = $this->input->post('type_6');
                    if($type=='Box')
                        $item_id = 29;
                    else
                        $item_id = 9;
                    
                   $data = array(
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$berry_blast_bar
                                    );

                    $batch_array[] = $data;
                }

                if($chyawanprash_bar!=null)
                {
                    $type = $this->input->post('type_7');
                    if($type=='Box')
                        $item_id = 31;
                    else
                        $item_id = 10;
                    
                   $data = array(
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$chyawanprash_bar
                                    );
                    $batch_array[] = $data;
                }

                if($variety_box!=null)
                {
                    $item_id = 32;
                    
                    $data = array(
                                    'type'=>$type,
                                    'item_id'=>$item_id,
                                    'qty'=>$variety_box
                                    );
                    $batch_array[] = $data;
                }
               $merchandiser_stock_details =  $batch_array;
               $retailer_id = $store_id = $visit_detail['reation_id'];
               $data = array(
                    'm_id' => $sales_rep_id,
                    'date_of_visit' => $date_of_visit,
                    'dist_id' => $retailer_id,
                    'latitude' => $visit_detail['latitude'],
                    'longitude' => $visit_detail['longitude'],
                    'remarks' => trim($visit_detail['remarks']),
                    'location_id' => $visit_detail['location_id'],
                    'zone_id' => $visit_detail['zone_id'],
                    'created_by' => $curusr,
                    'created_on' => $now,
                );
                $this->db->insert('merchandiser_stock',$data);
                $this->db->last_query();
                $visit_id = $merchandiser_stock_id=$this->db->insert_id();   

                if(count($merchandiser_stock_details)>0)
                {
                    for ($j=0; $j <count($merchandiser_stock_details) ; $j++) { 
                            $merchandiser_stock_details[$j]['merchandiser_stock_id']=$merchandiser_stock_id;
                         }

                    $this->db->where('merchandiser_stock_id',$merchandiser_stock_id)->delete('merchandiser_stock_details');

                    $visit_id = $merchandiser_stock_id;
                    $this->db->insert_batch('merchandiser_stock_details',$merchandiser_stock_details);    
                }

        }

       redirect(base_url().'index.php/Sales_rep_store_plan/add_stock');
}
     
}
?>