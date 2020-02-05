<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sales_rep extends CI_Controller{

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
        $this->load->database();
    }

    //index function
    public function index(){
        // $result=$this->sales_rep_model->get_access();
        // if(count($result)>0) {
        //     $data['access']=$result;
        //     $data['data'] = $this->sales_rep_model->get_data();

        //     load_view('sales_rep/sales_rep_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }
        $this->checkstatus('salesrep');
    }


    public function checkstatus($status=''){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {

            if($status=='salesrep') {
                $status = 'Sales Representative';
            }
            else if ($status=='promoter') {
                $status='Promoter';
            }
            else if ($status=='merchandiser') {
                $status='merchandizer';
            }

            $data['access']=$result;
            $data['data']=$this->sales_rep_model->get_data($status);

            $count_data=$this->sales_rep_model->get_data('Approved');
            $salesrep=0;
            $promoter=0;
            $merchandiser=0;
            $inactive=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->sr_type))=="SALES REPRESENTATIVE")
                        $salesrep=$salesrep+1;
                    else if (strtoupper(trim($count_data[$i]->sr_type))=="PROMOTER")
                        $promoter=$promoter+1;
                    else if (strtoupper(trim($count_data[$i]->sr_type))=="MERCHANDIZER")
                        $merchandiser=$merchandiser+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                }
            }

            $count_data_inactive=$this->sales_rep_model->get_data_inactive();
            if (count($result)>0){
                for($i=0;$i<count($count_data_inactive);$i++){
                    if (strtoupper(trim($count_data_inactive[$i]->status))=="INACTIVE")
                        $inactive=$inactive+1;
                }
            }

            $data['salesrep']=$salesrep;
            $data['promoter']=$promoter;
            $data['merchandiser']=$merchandiser;
            $data['inactive']=$inactive;
            $data['all']=count($count_data);


            load_view('sales_rep/sales_rep_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    public function add(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_insert == 1) {
                $data['access'] = $this->sales_rep_model->get_access();
                $data['zone']=$this->sales_rep_model->get_zone();
				//$data['manager_data'] = $this->sales_rep_model->get_manager_data('','');
                load_view('sales_rep/sales_rep_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($id){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            if($result[0]->r_view == 1 || $result[0]->r_edit == 1) {
                $data['access'] = $this->sales_rep_model->get_access();
                $data['data'] = $this->sales_rep_model->get_data('', $id);
				//$data['manager_data'] = $this->sales_rep_model->get_manager_data('', $id);
                $docs=$this->document_model->edit_view_doc('', $id, 'Sales_Rep');
                $data=array_merge($data, $docs);
                $data['zone']=$this->sales_rep_model->get_zone();
                load_view('sales_rep/sales_rep_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $this->sales_rep_model->save_data();
        redirect(base_url().'index.php/sales_rep');
    }

    public function update($id){
        $this->sales_rep_model->save_data($id);
        redirect(base_url().'index.php/sales_rep');
    }

    public function check_sales_rep_availablity(){
        $result = $this->sales_rep_model->check_sales_rep_availablity();
        echo $result;
    }

    public function sales_rep_route_plan(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            $data['access'] = $result;
            $data['sales_rep1'] = $this->sales_rep_model->get_sales_rep_route('Approved');
            load_view('sales_rep/sales_rep_route_plan', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_route_plan($id, $date){
        // $result=$this->sales_rep_model->get_access();
        // if(count($result)>0) {
        //     $data['access'] = $result;

            $data['sales_rep'] = $this->sales_rep_model->get_data('Approved');
            $data['sales_rep_id'] = $id;
            $data['date'] = $date;
            load_view('sales_rep/sales_rep_date_wise_route_plan', $data);

        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }
    }

    public function email_route_plan(){
        // $this->email_sales_rep_loc();
    }

    public function email_sales_rep_loc(){
        $date = date('Y-m-d');
        // $date = '2019-07-12';
        $from_email = 'cs@eatanytime.in';
        $from_email_sender = 'Eat ERP';
        // $bcc = 'prasad.bhisale@otbconsulting.co.in';
        // $bcc = 'rishit.sanghvi@eatanytime.in, swapnil.darekar@otbconsulting.co.in';
        $subject = 'Route Plan For - ' . $date;
        $links = '';
        $table = '';
        $tr = '';

        $product_data = $this->export_model->get_product_data();
        $product_th = '';
        $product_cnt = count($product_data);
        for($k=0; $k<count($product_data); $k++){
            $product_name = $product_data[$k]->product_name;
            $product_name = str_replace('E.A.T', '', $product_name);
            $product_name = str_replace('Anytime', '', $product_name);
            $product_name = str_replace('  ', '', $product_name);
            $product_name = str_replace(' Bar', '', $product_name);
            $product_th = $product_th . '<th style="text-align:center;">'.$product_name.'</th>';
        }

        $product_data = $this->export_model->get_sales_rep_order_data($date, $date);

        // $data = $this->sales_rep_model->get_sales_rep_details($date);
        $data = $this->sales_rep_model->get_data('Approved');
        for($i=0; $i<count($data); $i++){
            $tr = '';

            $loc_data = $this->export_model->get_sales_rep_loc_data($data[$i]->id, $date, $date);
            if(count($loc_data)>0){
                for($j=0; $j<count($loc_data); $j++){
                    $tr = $tr . '<tr>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->date_of_visit.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->sales_rep_name.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_name.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_type.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_status.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->remarks.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->modified_on.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->modified_on_time.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->diff.' minutes</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->orange_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->mint_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->butterscotch_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->bambaiyachaat_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->chocopeanut_bar.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->mangoginger_bar.'</td>';

                    $product_1_td = '<td style="text-align:center;"></td>';
                    $product_2_td = '<td style="text-align:center;"></td>';
                    $product_3_td = '<td style="text-align:center;"></td>';
                    $product_4_td = '<td style="text-align:center;"></td>';
                    $product_5_td = '<td style="text-align:center;"></td>';
                    $product_6_td = '<td style="text-align:center;"></td>';

                    if($loc_data[$j]->distributor_status == 'Place Order'){
                        for($k=0; $k<count($product_data); $k++){
                            if($product_data[$k]->date_of_processing==$loc_data[$j]->date_of_visit && 
                                $product_data[$k]->distributor_id==$loc_data[$j]->distributor_id){
                                    if($product_data[$k]->product_id == '1'){
                                        $product_1_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '2'){
                                        $product_2_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '3'){
                                        $product_3_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '4'){
                                        $product_4_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '5'){
                                        $product_5_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    } else if($product_data[$k]->product_id == '6'){
                                        $product_6_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                    }
                            }
                        }
                    }
                    
                    $tr = $tr . $product_1_td . $product_2_td . $product_3_td . $product_4_td . $product_5_td . $product_6_td;

                    $tr = $tr . '</tr>';
                }
            }

            $loc_data = $this->export_model->get_sales_rep_direct_order_data($data[$i]->id, $date, $date);
            if(count($loc_data)>0){
                for($j=0; $j<count($loc_data); $j++){
                    $tr = $tr . '<tr>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->date_of_processing.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->sales_rep_name.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_name.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_type.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->distributor_status.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->remarks.'</td>';
                    $tr = $tr . '<td style="text-align:center;">'.$loc_data[$j]->modified_on.'</td>';
                    $tr = $tr . '<td style="text-align:center;"></td>';
                    $tr = $tr . '<td style="text-align:center;"></td>';
                    $tr = $tr . '<td style="text-align:center;"></td>';
                    $tr = $tr . '<td style="text-align:center;"></td>';
                    $tr = $tr . '<td style="text-align:center;"></td>';
                    $tr = $tr . '<td style="text-align:center;"></td>';
                    $tr = $tr . '<td style="text-align:center;"></td>';
                    $tr = $tr . '<td style="text-align:center;"></td>';

                    $product_1_td = '<td style="text-align:center;"></td>';
                    $product_2_td = '<td style="text-align:center;"></td>';
                    $product_3_td = '<td style="text-align:center;"></td>';
                    $product_4_td = '<td style="text-align:center;"></td>';
                    $product_5_td = '<td style="text-align:center;"></td>';
                    $product_6_td = '<td style="text-align:center;"></td>';

                    for($k=0; $k<count($product_data); $k++){
                        if($product_data[$k]->date_of_processing==$loc_data[$j]->date_of_processing && 
                            $product_data[$k]->distributor_id==$loc_data[$j]->distributor_id){
                                if($product_data[$k]->product_id == '1'){
                                    $product_1_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                } else if($product_data[$k]->product_id == '2'){
                                    $product_2_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                } else if($product_data[$k]->product_id == '3'){
                                    $product_3_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                } else if($product_data[$k]->product_id == '4'){
                                    $product_4_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                } else if($product_data[$k]->product_id == '5'){
                                    $product_5_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                } else if($product_data[$k]->product_id == '6'){
                                    $product_6_td = '<td style="text-align:center;">'.$product_data[$k]->qty.'</td>';
                                }
                        }
                    }
                    
                    $tr = $tr . $product_1_td . $product_2_td . $product_3_td . $product_4_td . $product_5_td . $product_6_td;

                    $tr = $tr . '</tr>';
                }
            }

            if($tr != ''){
                $table = '<table border="1" style="border-collapse: collapse;">
                            <tr>
                                <th style="text-align:center;">Date of Visit</th>
                                <th style="text-align:center;">Sales Representative Name</th>
                                <th style="text-align:center;">Distributor Name</th>
                                <th style="text-align:center;">Distributor Type</th>
                                <th style="text-align:center;">Visit Status</th>
                                <th style="text-align:center;">Remarks</th>
                                <th style="text-align:center;">Creation Date</th>
                                <th style="text-align:center;">Time</th>
                                <th style="text-align:center;">Time Difference</th>
                                <th colspan="'.$product_cnt.'">Available Stock</th>
                                <th colspan="'.$product_cnt.'">Ordered Stock</th>
                            </tr>
                            <tr>
                                <th colspan="9">&nbsp;</th>
                                '.$product_th.'
                                '.$product_th.'
                            </tr>
                            '.$tr.'
                        </table>';


                $message = '<html><head></head><body>Hi,<br /><br />
                            Please find below '.$data[$i]->sales_rep_name.' Location For - '.$date.'. <br /><br />'.$table.'<br/>
                            <br />Thanks</body></html>';

                // $to_email = 'prasad.bhisale@otbconsulting.co.in';
                // $bcc = 'prasad.bhisale@otbconsulting.co.in';

                $to_email = $data[$i]->email_id.', rishit.sanghvi@eatanytime.in, swapnil.darekar@eatanytime.in';
                $bcc="dhaval.maru@otbconsulting.co.in, prasad.bhisale@otbconsulting.co.in";

                $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message, $bcc);

                echo $message;
                echo '<br/>';
                echo $mailSent;
                echo '<br/><br/>';
            }
        }
    }

    public function sales_rep_location(){
        $result=$this->sales_rep_model->get_access();
        if(count($result)>0) {
            $data['access'] = $result;
            $data['sales_rep'] = $this->sales_rep_model->get_data_promoter('Approved');
            load_view('sales_rep/sales_rep_location', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function change_admin_sequence($id='')
    {
        $day = date('l');
        $m = date('F');
        $year = date('Y');
        $frequency = '';

        $get_alternate  = $this->get_alternate($day,$m,$year);
        if($get_alternate)
        {
            $frequency = 'Alternate '.$day;
        }
        else
        {
            $frequency = 'Every '.$day;
        }

       
        $result=$this->sales_rep_model->get_access();    
        if(count($result)>0) {
            $data['access']=$result;
           
            $sales_rep = $this->db->query("select * from sales_rep_master where sr_type='Sales Representative' and status='Approved' order by sales_rep_name desc")->result();
            if($id!="")
            {

             $sql ="select G.*,H.date_of_visit,H.id as mid , H.remarks,H.followup_date from (select E.*,F.sales_rep_name from(select C.* from (select A.*,B.distributor_name ,B.distributor_name as store_name ,B.google_address,B.latitude,B.longitude from 
                    (select * ,id as bit_plan_id from  sales_rep_beat_plan Where frequency='$frequency' and sales_rep_id=$id) A 
                    left join 
                    (Select Distinct C.* FROM(
                        Select B.* from (
                            Select concat('d_',A.id) as id , A.distributor_name ,A.google_address,A.latitude,A.longitude,'' as gst_number,'' as margin,'' as doc_document,' ' as document_name FROM
                            (Select * from distributor_master )A
                            LEFT JOIN sr_mapping B ON (A.area_id = B.area_id and A.zone_id = B.zone_id and  A.type_id = B.type_id) 
                            Where A.status='approved' and A.class='normal'
                        ) B
                        Union 
                        (
                            Select concat('s_',A.id) as id , A.distributor_name ,'' as google_address,A.latitude,A.longitude,A.gst_number,A.margin,A.doc_document,A.document_name FROM
                            (Select * from sales_rep_distributors )A
                        )            
                        ) C 
                    ) B 
                    on (A.store_id=B.id COLLATE utf8_unicode_ci))C)E
                     left join 
                    (select * from sales_rep_master where sr_type='Sales Representative' order by sales_rep_name desc ) F 
                    on (E.sales_rep_id=F.id))G
                    left join
                    (select * from sales_rep_location 
                    Where date(date_of_visit)=date(now())) H
                    on(G.store_id=H.distributor_id)
                    order by G.sequence asc,G.modified_on Desc
                    ";
                $detailed_beat_plan = $this->db->query($sql)->result_array();

                $sql ="select G.* from (select E.*,F.sales_rep_name from(select C.* from (select A.*,B.distributor_name ,B.distributor_name as store_name ,B.google_address,B.latitude,B.longitude from 
                    (select * ,id as bit_plan_id from  admin_sales_rep_beat_plan Where frequency='$frequency' and sales_rep_id=$id) A 
                    left join 
                    (Select C.* FROM(
                        Select concat('d_',A.id) as id , A.distributor_name ,A.google_address,A.latitude,A.longitude FROM
                        (Select * from distributor_master  )A
                        LEFT JOIN sr_mapping B ON (A.area_id = B.area_id and A.zone_id = B.zone_id and  A.type_id = B.type_id) 
                        Where A.status='approved' and A.class='normal'
                        ) C GROUP BY id, distributor_name ,google_address,latitude,longitude
                    ) B 
                    on (A.store_id=B.id COLLATE utf8_unicode_ci))C)E
                     left join 
                    (select * from sales_rep_master where sr_type='Sales Representative' order by sales_rep_name desc ) F 
                    on (E.sales_rep_id=F.id))G
                    order by G.sequence asc,G.modified_on Desc
                    ";
                $admin_merchendizer_beat_plan = $this->db->query($sql)->result_array(); 


                $data['beat_plan']=$detailed_beat_plan;
                $data['admin_beat_plan']=$admin_merchendizer_beat_plan;
                $data['sales_rep_id']=$id;        
            }
            else
            {
              $data['beat_plan']=[];
              $data['admin_beat_plan']=[];  
              $data['sales_rep_id']='';
            }
            $data['sales_rep']=$sales_rep; 
            $data['frequency']=$frequency;
          
            load_view('sales_rep/edit_beat_plan', $data);

        }  else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }       
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


    public function save_changesequence()
    {
       $ispermanent = $this->input->post('ispermenant');
       $resultb= $this->sales_rep_model->change_sequence($ispermanent);

       $id = $this->input->post('sales_rep_id');
       $this->change_admin_sequence($id);
    }

    public function sales_rep_not_mapped($status='')
    {
       $result = $this->db->query('Select DISTINCT sales_rep_id from sales_rep_beat_plan')->result();

        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->sales_rep_id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);

      

       if(count($result)>0)
        {
            $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='Sales Representative' and   id NOT IN($sales_rep_id)")->result();
        } else
        {
           $result = $this->db->query("Select * from sales_rep_master Where  status='Approved' and sr_type='Sales Representative'")->result();
        }

       $this->db->last_query();
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->sales_rep_name);
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
      $sqlqueries = "Select A.distributor_name,A.id from 
                        (select * from distributor_master where class='normal') A 
                        left join 
                        (select * from sales_rep_master) B 
                        on (A.sales_rep_id=B.id) GROUP BY  A.distributor_name order by A.distributor_name asc";
    $result = $this->db->query($sqlqueries)->result();                        
        $sales_rep_id = array();
        foreach ($result as $data) {
            $sales_rep_id[]=$data->id;
        }

       $sales_rep_id =  implode(" ,", $sales_rep_id);

       if(count($result)>0)
        {
            $result = $this->db->query("SELECT * from distributor_master Where status='Approved' and   id NOT IN($sales_rep_id)")->result();
        } else
        {
          $result = $this->db->query("SELECT * from distributor_master Where status='Approved'")->result();
           $this->db->last_query(); 
        }

       
       $template_path=$this->config->item('template_path');
       $file = $template_path.'sales_rep.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$dist->distributor_name);
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

    public function zone_not_mapped($status='')
    {
        $result = $this->db->query('Select DISTINCT zone_id from sales_rep_beat_plan')->result();

        $zone_id = array();
        $count=count($result);
        if($count>2)
        {
        foreach ($result as $data) {
            $zone_id[]=$data->zone_id;
                
        }
        
        $zone_id =  implode(",", $zone_id);
        }
        else
        {
        foreach ($result as $data) {
            $zone_id=$data->zone_id;
                
        }
                    
       
        }

      // $zone_id =  implode(" ,", $zone_id);
       if(count($result)>0)
        {
            $result = $this->db->query("select * from zone_master Where status='Approved' and id NOT IN($zone_id)")->result();
        }
        else
        {
            $result = $this->db->query("select * from zone_master Where status='Approved'")->result();
        }

       
       $template_path=$this->config->item('template_path');
       $file = $template_path.'zone.xls';
       $this->load->library('excel');
       $objPHPExcel = PHPExcel_IOFactory::load($file);
       $objPHPExcel->setActiveSheetIndex(0);
       $row = 3;
       foreach($result  as $dist)
        {
           $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$dist->zone);
           $row = $row+1;
        }

        if(count($result)>0)
        {
            $filename='zone.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }
}
?>