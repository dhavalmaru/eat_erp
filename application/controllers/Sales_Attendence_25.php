<?php 
if(! defined ('BASEPATH') ){exit('No direct script access allowed');}

class Sales_Attendence extends CI_controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->database();
        $this->load->model('Attendence_model','attendence');
        $this->load->model('Sales_Attendence_model');
        /*$result = $this->Sales_Attendence_model->get_todays_attendence();

        if(count($result)==0)
        {
            redirect(base_url().'index.php/Sales_Attendence');
        }*/

    }

    public function index()
    {
      $data['userdata'] = $this->session->all_userdata();
      $attendence = $this->Sales_Attendence_model->get_todays_attendence();
      
      
      // $attendence = $this->Sales_Attendence_model->get_todays_attendence();

      // echo json_encode($attendence[0]->working_status);

      /*load_view('sales_rep_beat_plan/beat_plan_list', $userdata);*/

      $bl_redirect = false;
      $bl_check_out = false;
      if(isset($attendence)){
        if(count($attendence)>0){
          $data['attendence'] = $attendence;
          if(strtoupper(trim($attendence[0]->check_out))=="1"){
            $bl_check_out = true;
          }
          if(strtoupper(trim($attendence[0]->working_status))=="PRESENT"){
            $bl_redirect = true;
          }
        }
      }

      if($bl_check_out == true){
        // echo 'dashboard/dashboard_first_screen';
        load_view('dashboard/dashboard_first_screen', $data);
      } else if($bl_redirect == true){
        redirect(base_url().'index.php/Dashboard_sales_rep');
      } else {
        load_view('dashboard/dashboard_first_screen', $data);
      }
      
      
    }

    public function save()
    {
      $latitude = $this->input->post('latitude');
      $longitude = $this->input->post('longitude');
      $absent_remark = $this->input->post('absent_remark');
      $casual_reason = $this->input->post('casual_reason');
      $applied_in_keka = $this->input->post('applied_on_keka');
      $now=date('Y-m-d H:i:s');
      $now1=date('Y-m-d');
      $working_status = $this->input->post('working_status');
      $sales_rep_id=$this->session->userdata('session_id');


      
      if($casual_reason!='')
      {
          $applied_in_keka = 'Casual';
          $working_status = 'Absent';
      }

      $where_array= array('date(check_in_time)'=>$now1,
                          'sales_rep_id'=>$sales_rep_id);

      $result = $this->db->select("sales_rep_id,id")->where($where_array)->get('sales_attendence')->result();

      if(count($result)>0)
      {
        $sales_attendence = array(
            "sales_rep_id"=>$sales_rep_id,
            "causual_remark"=>$casual_reason,
            "working_status"=>$working_status,
            "latitude"=>$latitude,
            "longitude"=>$longitude,
            "applied_in_keka"=>$applied_in_keka, 
            "check_out"=>'0'
          );
        $this->db->where('id', $result[0]->id);
        $this->db->update('sales_attendence', $sales_attendence);
         /*echo '<script>
         alert("Attendence Already Updated");
         window.open("'.base_url().'index.php/Sales_Attendence", "_parent")</script>';*/
      }
      else
      {
         $sales_attendence = array(
            "sales_rep_id"=>$sales_rep_id,
            "causual_remark"=>$casual_reason,
            "check_in_time"=>$now,
            "working_status"=>$working_status,
            "latitude"=>$latitude,
            "longitude"=>$longitude,
            "applied_in_keka"=>$applied_in_keka, 
            "check_out"=>'0'
          );
        $this->db->insert('sales_attendence',$sales_attendence);
        $id=$this->db->insert_id(); 
      }

       $this->session->set_userdata('check_in_time',$now);
      
      

      if($casual_reason!='')
      {
         redirect(base_url().'index.php/Sales_Attendence');
      }
      else
      {
        echo 'updated';
      }

     /*if($working_status=='Present')
      {
        redirect(base_url().'index.php/Dashboard_sales_rep');
      }
      else
      {
        redirect(base_url().'index.php/Sales_Attendence');
      }*/
    }

    public function checkout()
    {
      $now=date('Y-m-d H:i:s');
      $now1=date('Y-m-d');
      $sales_rep_id=$this->session->userdata('session_id');
      $where_array= array('date(check_in_time)'=>$now1,
                          'sales_rep_id'=>$sales_rep_id);

      $result = $this->db->select("sales_rep_id,id")->where($where_array)->get('sales_attendence')->result();

      $sales_attendence = array('check_out_time'=>$now, 'check_out'=>'1');

      if(count($result)>0)
      {
         $this->db->where('id', $result[0]->id);
         $this->db->update('sales_attendence', $sales_attendence);
         $this->session->set_userdata('check_out_time',$now);
         redirect(base_url().'index.php/Sales_Attendence');
      }
      else
        redirect(base_url().'index.php/Dashboard_sales_rep');
    }
	
	public function get_sales_attendance(){
	
		$tbody ='';
		$from_email = 'cs@eatanytime.co.in';
        $from_email_sender = 'Wholesome Habits Pvt Ltd';
       
		//$to_email = "rishit.sanghvi@eatanytime.in";
	$to_email = "ashwini.patil@pecanreams.com";
     $bcc = "sangeeta.yadav@pecanreams.com";
	//	$bcc = "ashwini.patil@pecanreams.com, sangeeta.yadav@pecanreams.com, dhaval.maru@pecanreams.com, swapnil.darekar@eatanytime.in, vinay.pal@eatanytime.in ";
	
        $subject = 'Daily Performance Report For Sales Representative-'.date("d F Y",strtotime("now"));

         $tbody ='<!DOCTYPE html">
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					 


					  <style type="text/css">
					  body {margin: 0; padding: 20px; min-width: 100%!important;font-family "Arial,Helvetica,sans-serif";}
					  img {height: auto;}
					  .content { max-width: 600px;}
					  .header {padding:  20px;}
					  .innerpadding {padding: 30px 30px 30px 30px;}
					  /*.innerpadding1 {padding: 0px 30px 30px 30px;}*/
					  
					  .innerpadding1 tbody td
					  {
						  border:1px solid #ddd!important;
					  }
					  
					  .borderbottom {border-bottom: 1px solid #f2eeed;}
					  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
					  .h1, .h2, .bodycopy {color: #fff; font-family: sans-serif;}
					  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
					  .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
					  .bodycopy {font-size: 16px; line-height: 22px;}
					  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
					  .button a {color: #ffffff; text-decoration: none;}
					  .footer {padding: 20px 30px 15px 30px;}
					  .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
					  .footercopy a {color: #ffffff; text-decoration: underline;}

					  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
					  body[yahoo] .hide {display: none!important;}
					  body[yahoo] .buttonwrapper {background-color: transparent!important;}
					  body[yahoo] .button {padding: 0px!important;}
					  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
					  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
					  }

					  /*@media only screen and (min-device-width: 601px) {
						.content {width: 600px !important;}
						.col425 {width: 425px!important;}
						.col380 {width: 380px!important;}
						}*/
						table, th, td {
					   
						border-collapse: collapse;
					}
					th, td {
						  padding: 3px;
						text-align: left;
						
					}
					.total
						{
							color: #333333;
							font-size: 28px;
							font-family: Arial,Helvetica,sans-serif;
						}
						.used
						{
							color: #666666;
							font-size: 20px;
							font-family: Arial,Helvetica,sans-serif;
						}
						.team_head
						{
							font-size:36px;
							font-weight:normal;
							color:#fff;
							font-family: "Arial,Helvetica,sans-serif";
						}
						.date
						{
							font-size:16px;
							color:#fff;
						}
						.upper_table td
						{
							border:1px solid #ddd;
							text-align:center;
								 padding: 10px;
							
						}
						.body_table tbody 
						{
							border:1px solid #ddd;
							background-color: #fdfbfb;
							color: #656d78;
						}
					  </style>
					</head>

					<body yahoo bgcolor="" style="margin-top:20px;"margin-bottom:20px;">
					<table width="100%" bgcolor="" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
					<tr>
		
    
			<td class="innerpadding1 " style="">
           <table  class="body_table" style="border-collapse: collapse;width:100%;border:1px solid #ddd!important;">
			<thead>
				<tr style=" background-color:yellow ;border-bottom: 1px solid #ddd;font-weight: bold;">
		
				  <th width="350" style="border-right: 1px solid #ddd;padding: 4px;text-align:left;width:350px">REGION</th>
				  <th style="border-right: 1px solid #ddd;padding: 4px;text-align: left;">NO. EMP PRESENT</th>
				  <th style="border-right: 1px solid #ddd;padding: 4px;text-align: left;width:120px">	
NO. EMP ABSENT</th>
				  <th style="border-right: 1px solid #ddd;padding: 4px;text-align: left;">TOTAL</th>
				  <th style="border-right: 1px solid #ddd;padding: 4px;text-align: left;">ON TIME</th>
				  <th style="border-right: 1px solid #ddd;padding: 4px;text-align: left;">LATECOMERS</th>
				
			
				  
				  
				</tr>
			</thead>
			<tbody style="border:1px solid #ddd;
							background-color: #fdfbfb;
							color: #656d78;">';
							
							if(count($data)>=0) {
					for($i=0; $i<count($data); $i++)
					{
						$tbody.= ' 	<tr>
							<td style="border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">'.$data[$i]->zone.'</td>
							<td style="border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">'.$data[$i]->present_emp.'</td>
							<td style="border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">'.$data[$i]->absent_emp.'</td>
							<td style="border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">'.$data[$i]->total_emp.'</td>
							<td style="border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">'.$data[$i]->on_time.'</td>
							<td style="border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">'.$data[$i]->late_mark_count.'</td>
							</tr>
							
							
          '; 
					}
							}					
			
            $tbody.=   '</tbody>
          </table>
        </td>
	  </tr>
	  
	  <br>
	  <br>
	  <tr>
		
    
			<td class="innerpadding1 " style="">
           <table  class="body_table" style="border-collapse: collapse;width:100%">
			<thead>
				<tr style=" background-color:yellow ;border-bottom: 1px solid #ddd;font-weight: bold;">
		
				  <th width="350" style="border-right: 1px solid #ddd;padding: 4px;text-align:left;width:350px">NAME OF ABSENT EMP</th>
				  <th style="border-right: 1px solid #ddd;padding: 4px;text-align: left;">REGION</th>
				  <th style="border-right: 1px solid #ddd;padding: 4px;text-align: left;width:120px">	
						REMARKS</th>
				  <th style="border-right: 1px solid #ddd;padding: 4px;text-align: left;">REASON</th>
				
				
			
				  
				  
				</tr>
			</thead>
			<tbody style="border:1px solid #ddd;
							background-color: #fdfbfb;
							color: #656d78;">
							<tr>
							<td style="border-right: 1px solid #ddd;">MUKESH YADAV</td>
							<td style="border-right: 1px solid #ddd;">MUMBAI</td>
							<td style="border-right: 1px solid #ddd;">Absent /Not informed</td>
							<td style="border-right: 1px solid #ddd;">Absent /Not informed</td>
							
							</tr>
							
							
							

							
								
          '; 
				
			
            $tbody.=   '</tbody>
          </table>
        </td>
	  </tr>
   
   
    </table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</table>

<!--analytics-->

</body>
</html>' ;

 // echo $tbody;
            
          echo 'mailsent'.$mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $tbody);
          if ($mailSent==1) {
              echo "Send";
          } else {
              echo "NOT Send".$mailSent;
          }

        // load_view('invoice/emailer', $data);
    }
}

?>