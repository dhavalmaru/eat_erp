<?php 
if(! defined ('BASEPATH') ){exit('No direct script access allowed');}

class Eat_Attendence extends CI_controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->database();
        $this->load->model('Attendence_model','attendence');
    }

    public function index(){
        $year = date("Y");
        $month = date("m");
        $this->checkstatus($status='',$year,$month);
    }

    public function upload(){
        $employee = $this->attendence->get_employee_code();
        $data['employee'] = $employee;
        load_view('emp_attendence/upload_emp_attendence', $data);
    }

    public function upload_excel(){
        $path=FCPATH.'assets/uploads/attendence_upload/';
        $config = array(
            'upload_path' => $path,
            'allowed_types' => "xlsx",
            'overwrite' => TRUE,
            'max_size' => "2048000", 
            'max_height' => "768",
            'max_width' => "1024"
        );
        $new_name = time().'_'.str_replace(' ', "_", $_FILES["upload"]['name']);
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('upload')) { 
            $this->upload->display_errors();
        } else {
            $imageDetailArray = $this->upload->data();
        }

          $file = $path.$new_name;
          $this->load->library('excel');
          $objPHPExcel = PHPExcel_IOFactory::load($file);
          $objPHPExcel->setActiveSheetIndex(0);
          $highestrow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
          $now=date('Y-m-d H:i:s');
          $curusr=$this->session->userdata('session_id');
          $batch_array = array();
          $employee_array = array();
          $unique_employee_array = array();

          $this->insert_sales_attendence();

          for($i=4;$i<=$highestrow;$i++)
          { 
                // echo "eneterd";
                // echo "<br/><br/>";
                $emp_no = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
                $emp_name = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
                $job_title = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
                $department = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
                $location = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
                $date = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
                $first_in = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue();
                $last_out = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getValue();
                $emp_status = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getValue();
                $effective_hour = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getValue();
                $gross_hour = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getValue();

                $date = \PHPExcel_Style_NumberFormat::toFormattedString($date, 'YYYY-MM-DD');

                $combination = $emp_no.'&&'.$date;
                $unique_comb = $emp_no.'&&'.date("m",strtotime($date)).'&&'.date("Y",strtotime($date));
                    
                if($emp_no!="")
                {

                  if(array_search($unique_comb, array_column($unique_employee_array, 'employee_comb')) !== false)
                    {
                      $a = 'Value is in array';
                    }
                    else
                    {
                       $unique_employee_array[]=array("employee_comb"=>$unique_comb);
                    }

                  if(array_search($combination, array_column($employee_array, 'employee_comb')) !== false)
                    {
                        $a = 'Value is in array';
                    }
                    else
                    {
                          $employee_array[]=array("employee_comb"=>$combination);
                          if($first_in=='NA')
                              $first_in = 0;

                          if($last_out=='NA')
                              $last_out=0;

                          $where = array("emp_no"=>$emp_no,'date'=>$date);

                          $result = $this->db->select("*")->where($where)->get("employee_attendence")->result();
                                                   

                          $data = array(  'emp_no' =>$emp_no,
                                          'emp_name' => $emp_name,
                                          'job_title' => $job_title,
                                          'department' =>$department,
                                          'location' => $location,
                                          'date' => $date,
                                          'first_in' => $first_in,
                                          'last_out'=>$last_out,
                                          'emp_status'=>$emp_status,
                                          'effective_hour'=>$effective_hour,
                                          'gross_hour'=>$gross_hour,
                                          'modified_by' => $curusr,
                                          'modified_on' => $now,
                                          'created_by' => $curusr,
                                          'created_on' => $now,
                                       );
                          $batch_array[] =$data;

                          if(count($result)>0)
                          {
                               if($result[0]->is_sales==1)
                               {
                                 $data = array('emp_name' => $emp_name,
                                                'job_title' =>$job_title,
                                                'department' =>$department,
                                                'location' => $location,
                                                'date' => $date
                                           );
                                 $this->db->where($where)->update('employee_attendence',$data);
                                 $this->db->last_query();
                               }
                               else
                               {
                                    $data = array('emp_no' =>$emp_no,
                                                  'emp_name' => $emp_name,
                                                  'job_title' => $job_title,
                                                  'department' =>$department,
                                                  'location' => $location,
                                                  'date' => $date,
                                                  'first_in' => $first_in,
                                                  'last_out'=>$last_out,
                                                  'adjusted_in_time' => $first_in,
                                                  'adjusted_out_time'=>$last_out,
                                                  'emp_status'=>$emp_status,
                                                  'effective_hour'=>$effective_hour,
                                                  'gross_hour'=>$gross_hour,
                                                  'modified_by' => $curusr,
                                                  'modified_on' => $now,
                                               );
                                    $this->db->where($where)->update('employee_attendence',$data);
                                    // echo $this->db->last_query();
                                    // echo "<br/><br/>";
                                }
                          } else {
                             $data = array(  'emp_no' =>$emp_no,
                                          'emp_name' => $emp_name,
                                          'job_title' => $job_title,
                                          'department' =>$department,
                                          'location' => $location,
                                          'date' => $date,
                                          'first_in' => $first_in,
                                          'last_out'=>$last_out,
                                          'adjusted_in_time' => $first_in,
                                          'adjusted_out_time'=>$last_out,
                                          'emp_status'=>$emp_status,
                                          'effective_hour'=>$effective_hour,
                                          'gross_hour'=>$gross_hour,
                                          'modified_by' => $curusr,
                                          'modified_on' => $now,
                                          'created_by' => $curusr,
                                          'created_on' => $now,
                                       );
                            $this->db->insert('employee_attendence',$data);
                            // echo $this->db->last_query();
                            // echo "<br/><br/>";
                          }
                    }
                }
          }

          /*echo "<pre>";
          print_r($unique_employee_array);
          echo "</pre>";*/
          /* for ($j=0; $j <count($unique_employee_array) ; $j++) 
          { 
            echo "<br>".$unique_employee_array[$j]['employee_comb']."<br>";
            $explode = explode("&&",$unique_employee_array[$j]['employee_comb']);
            $emp_no = $explode[0];
            $month = $explode[1];
            $year = $explode[2];

             $result = $this->attendence->get_employee_attendence($emp_no,$year,$month);
              $tbody = '<!DOCTYPE html>
              <html>
              <head>
              <style>
              #customers {
                  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                  border-collapse: collapse;
                  width: 100%;
              }

              #customers td, #customers th {
                  border: 1px solid #ddd;
                  padding: 8px;
              }

              #customers tr:nth-child(even){background-color: #f2f2f2;}

              #customers tr:hover {background-color: #ddd;}

              #customers th {
                  padding-top: 12px;
                  padding-bottom: 12px;
                  text-align: left;
                  background-color: #000;
                  color: white;
              }
              </style>
              </head>
              <body>

              <table id="customers">
               <tr> <th>Date</th>
                <th>Punch In</th>
                <th>Punch Out</th>
                <th>Effective Time</th>
                <th>Late Marks</th>
                <th>Adjusted Time</th></tr>'
               ;
    
            if(count($result)>0)
            {
              $i=0;
              $total_days=0;
              foreach ($result as $emp) {
                  $total_days= $total_days+$emp->adjusted_time;
              }
              $tbody .= '<tr>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>Total Days</td>
                              <td>'.$total_days.'</td>
                          ';
              foreach ($result as $emp) {
                  $tbody .= '<tr>
                              <td>'.date('Y-m-d',strtotime($emp->date)).'</td>
                              <td>'.$emp->first_in.'</td>
                              <td>'.$emp->last_out.'</td>
                              <td>'.$emp->effective_time.'</td>
                              <td>'.$emp->Late_marks.'</td>
                              <td>'.$emp->adjusted_time.'</td>
                          ';
              }

              $tbody .='</table>
                    </body>
                    </html>';

              $from_email = 'cs@eatanytime.co.in';
              $from_email_sender = 'Wholesome Habits Pvt Ltd';
              $to_email = $result[0]->email_id;
              $bcc = 'vaibhav.desai@eatanytime.in, rishit.sanghvi@eatanytime.in, swapnil.darekar@otbconsulting.co.in';
              $subject = 'Attendence For Month - '.date('F Y ',strtotime($result[0]->date));


              if($to_email!='')
              {
                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $tbody);
                if ($mailSent==1) {
                      echo "done";
                } else {
                     echo "mail_fail";
                }
              }
              
            }
          }*/

          /* $this->db->insert_batch('employee_attendence',$batch_array);*/
          redirect(base_url().'index.php/Eat_Attendence');
    }

    public function insert_sales_attendence(){
        $now=date('Y-m-d H:i:s');
        $month = (intval(date("m"))-1);
        $sql = "Select U.first_name,U.emp_code ,A.*,S.sr_type,S.zone from 
                (SELECT * from sales_attendence Where MONTH(check_in_time)=$month Order By sales_rep_id,check_in_time ASC)A
                Left Join user_master U On A.sales_rep_id=U.sales_rep_id
                Left Join sales_rep_master S On A.sales_rep_id=S.id";
        $result = $this->db->query($sql)->result();

        for($i=0;$i<count($result);$i++){
            $now=date('Y-m-d H:i:s');
            $curusr=$this->session->userdata('session_id');
            $emp_name = $result[$i]->first_name;
            $emp_no = $result[$i]->emp_code;
            $job_title = $result[$i]->sr_type;
            $department = 'Sales';
            $location = $result[$i]->zone;
            $check_in_time = $result[$i]->check_in_time;
            $date = date('Y-m-d',strtotime($check_in_time));
            $first_in = date('H:i',strtotime($check_in_time));
            if($check_in_time!=null) $last_out=0;
            $emp_status = $result[$i]->working_status;
            
            $where = array("emp_no"=>$emp_no,'date'=>$date);
            $result1 = $this->db->select("*")->where($where)->get("employee_attendence")->result();
            $this->db->last_query();

            if(count($result1)==0){
                $data = array('emp_no' =>$emp_no,
                      'emp_name' => $emp_name,
                      'job_title' => $job_title,
                      'department' =>$department,
                      'location' => $location,
                      'date' => $date,
                      'first_in' => $first_in,
                      'last_out'=>$last_out,
                      'adjusted_in_time' => $first_in,
                      'adjusted_out_time'=>$last_out,
                      'emp_status'=>$emp_status,
                      'modified_by' => $curusr,
                      'modified_on' => $now,
                      'created_by' => $curusr,
                      'created_on' => $now,
                      'is_sales'=>1
                    );

                $this->db->insert('employee_attendence',$data);
                $this->db->last_query();
            }
        }
    }

    public function synchronise(){
        $emp_code= $this->input->post('emp_code');
        $month= $this->input->post('month');

        $sql = "Select U.first_name,U.emp_code ,A.*,S.sr_type,S.zone from 
        (SELECT * from sales_attendence Where MONTH(check_in_time)=$month Order By sales_rep_id,check_in_time ASC)A
        Left Join user_master U On A.sales_rep_id=U.sales_rep_id
        Left Join sales_rep_master S On A.sales_rep_id=S.id
        Where U.emp_code='$emp_code' ";

        $result = $this->db->query($sql)->result();

        for($i=0;$i<count($result);$i++){
            $now=date('Y-m-d H:i:s');
            $last_out = null;
            $curusr=$this->session->userdata('session_id');
            $emp_name = $result[$i]->first_name;
            $emp_no = $result[$i]->emp_code;
            $job_title = $result[$i]->sr_type;
            $department = 'Sales';
            $location = $result[$i]->zone;
            $check_in_time = $result[$i]->check_in_time;
            $date = date('Y-m-d',strtotime($check_in_time));
            $first_in = date('H:m',strtotime($check_in_time));
            $check_out_time = $result[$i]->check_out_time;
            if($check_out_time!=null)
              $last_out = date('H:m',strtotime($check_out_time));
            $emp_status = $result[$i]->working_status;
            
            /*$where = array("emp_no"=>$emp_no,'date'=>$date);
            $result1 = $this->db->select("*")->where($where)->get("employee_attendence")->result();
            $this->db->last_query();*/
            $where = array("emp_no"=>$emp_no,'date'=>$date);
            $data = array('emp_no' =>$emp_no,
                          'date' => $date,
                          'first_in' => $first_in,
                          'last_out'=>$last_out,
                          'emp_status'=>$emp_status,
                          'adjusted_in_time' => $first_in,
                          'adjusted_out_time'=>$last_out,
                          'modified_by' => $curusr,
                          'modified_on' => $now,
                          'is_sales'=>1,
                          'status'=>NULL
                    );
            $this->db->where($where)->update('employee_attendence',$data);
            $this->db->last_query();
        }

        redirect(base_url().'index.php/Eat_Attendence/');
    }
    
    public function get_employee_attendence($emp_no,$year,$month)
    {
      $result = $this->attendence->get_employee_attendence($emp_no,$year,$month);
      $tbody = '';
      
      if(count($result)>0)
      {
        $i=1;
        $system_total_days = 0;
        foreach ($result as $emp) {
                  $system_total_days= $system_total_days+$emp->adjusted_time;
              }

        $employee_total_days = 0;
        foreach ($result as $emp) {
                  $employee_total_days = $employee_total_days+$emp->employee_adjusted_time;
              }
        foreach ($result as $emp) {
            $readonly = '';
            if($emp->emp_status=='Holiday' || $emp->emp_status=='WeeklyOff' )
                $readonly='readonly';

              // || $emp->status=='approved'

            /*if($this->session->userdata("user_name")!='rishit.sanghvi@eatanytime.in')
              {
                if($emp->status=='approved')
                    $readonly='readonly';
              }*/
            
            $color = '';
            if($emp->emp_status!='Holiday' && $emp->emp_status!='WeeklyOff'&& $emp->emp_status!='Absent')
            {
              if(($emp->first_in!=$emp->adjusted_in_time||$emp->last_out!=$emp->adjusted_out_time) && ($emp->status=='pending'))
              {
                 $color = 'background-color:#f3e8d5';
              }
              else if(($emp->status=='rejected'))
              {
                $color = 'background-color:#f3e0d5';
              }
              else if(($emp->first_in!=$emp->adjusted_in_time||$emp->last_out!=$emp->adjusted_out_time) && ($emp->status=='approved'))
              {
                $color = 'background-color:#ccddff';
              }

            }
            
            $tbody .= '<tr id="adjust_log_'.($i).'" style="'.$color.'" >';
                      if($this->session->userdata("user_name")=='rishit.sanghvi@eatanytime.in')
                      {
                        $tbody .='<td ><input type="checkbox" name="emp_check[]"  id="emp_check_id_'.$i.'" class="attendence_check"><input type="hidden" name="checkboxval[]" id="emp_check_'.$i.'" value="0"></td>';
                      }   
                      $tbody .='
                      <td>
                      
                      <input type="hidden" name="status[]" value="'.$emp->status.'">'.date('d-m-Y',strtotime($emp->date)).'</td> 
                        <td ><input type="hidden" name="prev_adjusted_in_time[]" value="'.$emp->adjusted_in_time.'">
                        <input type="hidden" name="prev_adjusted_out_time[]" value="'.$emp->adjusted_out_time.'">
                        <input type="hidden" name="emp_id[]" value="'.$emp->emp_id.'">
                        <input type="hidden" name="date[]" value="'.date('Y-m-d',strtotime($emp->date)).'">'.$emp->first_in.'</td>
                        <td>'.$emp->last_out.'</td>
                        <td id="emp_status_'.($i).'">'.$emp->emp_status.'</td>
                        <td>'.$emp->effective_time.'</td>
                        <td>'.$emp->Late_marks.'</td>
                        <td>'.$emp->adjusted_time.'</td>
                        <td><input type="time" name="adjusted_in_time[]" id="adjusted_in_time_'.($i).'" value="'.trim($emp->adjusted_in_time).'" class="form-control adjusted_time" '.$readonly.' onchange="check_time(this)"></td>
                        <td><input type="time" name="adjusted_out_time[]" id="adjusted_out_time_'.($i).'" value="'.trim($emp->adjusted_out_time).'" class="form-control adjusted_time" '.$readonly.' onchange="check_time(this)"></td>
                        <td><textarea  name="remark[]" id="remark_'.($i).'" value="'.trim($emp->remark).'" class="form-control" >'.trim($emp->remark).'</textarea></td>
                        <td id="adjusted_late_marks_'.($i).'">'.$emp->adjusted_late_marks.'</td>
                        <td id="adjusted_time_'.($i).'">'.$emp->employee_adjusted_time.'</td>   
                        <td id="adjusted_effective_time_'.($i).'" >'.$emp->adjusted_effective_time.'</td>
                        <td>'.$emp->status.'</td>                                 
                       </tr>
                    ';
                /*<td><input name="adjusted_in_time[]" id="adjusted_late_mark_'.($i++).'" value="'.trim($emp->adjusted_time).'" readonly></td> */
                /*<td><input type="button" value="Approve" id="approve_'.($i++).'></td>
                              <td><input type="button" value="Approve" id="approve_'.($i++).'></td>*/
                /*
                <td><input name="adjusted_in_time[]" id="adjusted_in_time_'.($i++).' value=""></td>
                  <td><input name="adjusted_out_time[]" id="adjusted_out_time_'.($i++).' value=""></td>
                  <td><input name="adjusted_in_time[]" id="adjusted_late_mark_'.($i++).' value=""></td>                        
                  <td></td>*/
              $i++;
        }
        $data['emp_name']=$result[0]->emp_name;
        $data['emp_department']=$result[0]->department;
      }

      $data['detailed_attendence']=$tbody;
      $data['system_total']=$system_total_days;
      $data['employee_total']=$employee_total_days;
      load_view('emp_attendence/employee_detailed_attendence',$data); 
    }

    public function get_employee_list_email($emp_no,$year,$month)
    {
        $result = $this->attendence->get_employee_attendence($emp_no,$year,$month);
        
        $tbody = '<!DOCTYPE html>
                  <html>
                  <head>
                  <style>
                  #customers {
                      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                      border-collapse: collapse;
                      width: 100%;
                  }

                  #customers td, #customers th {
                      border: 1px solid #ddd;
                      padding: 8px;
                  }

                  #customers tr:nth-child(even){background-color: #f2f2f2;}

                  #customers tr:hover {background-color: #ddd;}

                  #customers th {
                      padding-top: 12px;
                      padding-bottom: 12px;
                      text-align: left;
                      background-color: #000;
                      color: white;
                  }
                  </style>
                  </head>
                  <body>

                  <table id="customers">';
                  $total_days=0;
                  foreach ($result as $emp) {
                          $total_days = ($total_days+$emp->adjusted_time);
                      }
                      
                  $tbody .= '<tr>
                                  <td>&nbsp</td>
                                  <td>&nbsp</td>
                                  <td>&nbsp</td>
                                  <td>&nbsp</td>
                                  <td><b>Total Days</b></td>
                                  <td><b>'.$total_days.'</b></td>
                              </tr>
                              ';

                  $tbody .= '<tr> <th>Date</th>
                            <th>Punch In</th>
                            <th>Punch Out</th>
                            <th>Effective Time</th>
                            <th>Late Marks</th>
                            <th>Adjusted Time</th></tr>'
                           ;
        
        if(count($result)>0)
        {
          $i=0;        
          foreach ($result as $emp) {
              $tbody .= '<tr>
                          <td>'.date('Y-m-d',strtotime($emp->date)).'</td>
                          <td>'.$emp->first_in.'</td>
                          <td>'.$emp->last_out.'</td>
                          <td>'.$emp->effective_time.'</td>
                          <td>'.$emp->Late_marks.'</td>
                          <td>'.$emp->adjusted_time.'</td>
                      ';
          }
        }

          $tbody .='</table>
                    </body>
                    </html>';

          $from_email = 'cs@eatanytime.in';
          $from_email_sender = 'Wholesome Habits Pvt Ltd';
          $to_email = $emp->email_id;
          $bcc = 'vaibhav.desai@eatanytime.in, rishit.sanghvi@eatanytime.in, swapnil.darekar@otbconsulting.co.in';
          $subject = 'Attendence For Month-'.date('F Y ',strtotime($emp->date));


          $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
          if ($mailSent==1) {
              echo "<script>alert('Mail sent.');</script>";
          } else {
              echo "<script>alert('Mail sending failed.');</script>";
          }

        load_view('emp_attendence/emp_list'); 
    }

    public function checkstatus($status='',$year='',$month=''){
        $data['data']=$this->attendence->get_summary($status,$year,$month);
        $employee = $this->attendence->get_employee_code();
        $data['employee'] = $employee;

        $count_data=$this->attendence->get_summary($status,$year,$month);

        $approved=0;
        $pending=0;
        $pending_for_approval=0;
        $rejected=0;

        if (count($count_data)>0){
            for($i=0;$i<count($count_data);$i++){
                if (strtoupper(trim($count_data[$i]->status))=="Pending")
                    $pending=$pending+1;
                else if (strtoupper(trim($count_data[$i]->status))=="Pending For Approval")
                    $pending_for_approval=$pending_for_approval+1;
                else if (strtoupper(trim($count_data[$i]->status))=="Approved")
                    $approved=$approved+1;
                else if (strtoupper(trim($count_data[$i]->status))=="Rejected")
                    $rejected=$rejected+1;
            }
        }

        $data['approved']=$approved;
        $data['pending']=$pending;
        $data['pending_for_approval']=$pending_for_approval;
        $data['rejected']=$rejected;
        $data['status']=$status;
        $data['all']=count($count_data);

        load_view('emp_attendence/emp_list', $data);
        /*$result=$this->attendence->get_access();
        if(count($result)>0) {
            $data['access']=$result;
            $data['data']=$this->attendence->attendence_list($status,$year,$month);

            $employee = $this->attendence->get_employee_code();
            $data['employee'] = $employee;

            $count_data=$this->attendence->attendence_list($status,$year,$month);

            $approved=0;
            $pending=0;
            $pending_for_approval=0;
            $rejected=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    if (strtoupper(trim($count_data[$i]->status))=="Pending")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="Pending For Approval")
                        $pending_for_approval=$pending_for_approval+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="Approved")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]->status))=="Rejected")
                        $rejected=$rejected+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['pending_for_approval']=$pending_for_approval;
            $data['rejected']=$rejected;
            $data['status']=$status;
            $data['all']=count($count_data);

            load_view('emp_attendence/emp_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }*/
    }

    public function get_data_ajax()
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $status = $this->input->post("status");
        $year =   $this->input->post("year");
        $month =  $this->input->post("month");

        // $status = 'pending_for_approval';
        // $year = '2019';
        // $month = '04';

        $data=$this->attendence->get_summary($status,$year,$month);
        $records = array();
        for ($i=0; $i < count($data); $i++) { 
            if($data[$i]->is_sales==1){
                $emp_data = '<input type="checkbox" id="check_'.$i.'" class="check icheckbox" name="check_val[]"  data-empcode="'.$data[$i]->emp_no.'"  data-month="'.$data[$i]->month_no.'" />';
            } else {
                $emp_data = '';
            }

              $records[] =  array(
                      $i+1,                       
                      ''.$data[$i]->emp_no.'',
                      '<a href="'.base_url().'index.php/Eat_Attendence/get_employee_attendence/'.$data[$i]->emp_no.'/'.$data[$i]->year.'/'.$data[$i]->month_no.'"><i class="fa fa-edit"></i></a>',
                      ''.$data[$i]->emp_name.'',
                      ''.date('F', mktime(0, 0, 0, $data[$i]->month_no, 10)).' '.$data[$i]->year.'',
                      ''.$data[$i]->total_days.'',
                      ''.$data[$i]->no_of_holiday.'',
                      ''.$data[$i]->weekly_off.'',
                      ''.$data[$i]->no_of_leave.'',
                      ''.$emp_data.''
                      /*
                       '<a href="'.base_url().'index.php/Eat_Attendence/send_mail/'.$data[$i]->emp_no.'/'.$data[$i]->year.'/'.$data[$i]->month_no.'">Resend Mail</a>',*/
                  );
        }

        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => count($data),
                        "recordsFiltered" => count($data),
                        "data" => $records
                    );
        echo json_encode($output); 
    }

    public function send_bulk_mail($year,$month)
    {

       $result1 = $this->db->query("SELECT DISTINCT(emp_no) from employee_attendence Where MONTH(date)='$month' and YEAR(date)='$year'")->result();

       $this->db->last_query();

       if(count($result1)>0)
       {

        for ($j=0; $j <count($result1) ; $j++) { 
            
            $result = $this->attendence->get_employee_attendence($result1[$j]->emp_no,$year,$month);
            $this->db->last_query();    

                $tbody = '<!DOCTYPE html>
                <html>
                <head>
                <style>
                #customers {
                    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                }

                #customers td, #customers th {
                    border: 1px solid #ddd;
                    padding: 8px;
                }

                #customers tr:nth-child(even){background-color: #f2f2f2;}

                #customers tr:hover {background-color: #ddd;}

                #customers th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    text-align: left;
                    background-color: #000;
                    color: white;
                }
                </style>
                </head>
                <body>

                <table id="customers">
                 <tr> <th>Date</th>
                  <th>Punch In</th>
                  <th>Punch Out</th>
                  <th>Effective Time</th>
                  <th>Late Marks</th>
                  <th>Adjusted Time</th></tr>'
                 ;
      
          if(count($result)>0)
          {
            $i=0;
            $total_days=0;
            foreach ($result as $emp) {
                $total_days= $total_days+$emp->adjusted_time;
            }
            $tbody .= '<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>Total Days</td>
                            <td>'.$total_days.'</td>
                        </tr>';
            foreach ($result as $emp) {
                $tbody .= '<tr>
                            <td>'.date('Y-m-d',strtotime($emp->date)).'</td>
                            <td>'.$emp->first_in.'</td>
                            <td>'.$emp->last_out.'</td>
                            <td>'.$emp->effective_time.'</td>
                            <td>'.$emp->Late_marks.'</td>
                            <td>'.$emp->adjusted_time.'</td>
                          </tr>';
            }

            $tbody .='</table>
                  </body>
                  </html>';

            $from_email = 'contact@eatanytime.co.in';
            $from_email_sender = 'Wholesome Habits Pvt Ltd';
      			if($result[0]->email_id2!='' || $result[0]->email_id2!=null) {
      				$to_email = $result[0]->email_id2;
      			}
      			else {
      				$to_email = $result[0]->email_id;
      			}

            $emp_name = $result[0]->emp_name;
            /*$bcc = 'vaibhav.desai@eatanytime.in, rishit.sanghvi@eatanytime.in, swapnil.darekar@otbconsulting.co.in';*/
            $subject = $emp_name.' Attendence For Month - '.date('F Y ',strtotime($result[0]->date));

            /*$cc='sangeeta.yadav@pecanreams.com';  */
            if($to_email!='')
            {
              $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $tbody );
              if ($mailSent==1) {
                     "done";
              } else {
                    "mail_fail".$mailSent;
              }
            }
          }
        }
       
       }

       echo "success";
    }

    public function download_excel($status='')
    {
       $year =  date("Y");
       $month = (intval(date("m"))-1);

       if($month==0)
       {
        $year = date("Y",strtotime("-1 year"));
        $month = 12;
       }

       if($status=='approved')
       {
          $result1 = $this->attendence->attendence_list($status,$year,$month);
       }
       else
       {
          $result1 = $this->db->query("SELECT DISTINCT(emp_no) from employee_attendence Where MONTH(date)='$month' and YEAR(date)='$year'")->result();
       }
       

       $this->db->last_query();

       if(count($result1)>0)
       {

          $template_path=$this->config->item('template_path');
          $file = $template_path.'Employee_Attendence.xls';
          $this->load->library('excel');
          $objPHPExcel = PHPExcel_IOFactory::load($file);
         /* $objPHPExcel->getActiveSheet()->setTitle('Attendence Regularization');*/
          $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Employee Number');
          $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Employee Name');
          $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Date');
          $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'First In');
          $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Last Out');
          $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Status');
          $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Effective Time');
          $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Late Marks');
          $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Late Counts');
          $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Adjusted Counts');
          $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Attendence Counts');
          $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Remarks');

          $row=2;

          for ($j=0; $j <count($result1) ; $j++) { 
              
            $result = $this->attendence->get_employee_attendence($result1[$j]->emp_no,$year,$month);

            if(count($result)>0)
            {

              $total_days=0;
              foreach ($result as $emp) {
                  $total_days= $total_days+$emp->employee_adjusted_time;
              }

              $tempval = $row;

              /*$objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $total_days);*/

              
              
              foreach ($result as $emp) {
               
                  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $emp->emp_no);
                  $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $emp->emp_name);
                  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $emp->date);
                 
                  $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $emp->emp_status);

                  if($status=='approved')
                  {
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $emp->adjusted_in_time);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $emp->adjusted_out_time);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $emp->adjusted_effective_time);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $emp->adjusted_late_marks);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $emp->adjusted_late_marks_count);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $emp->employee_adjusted_time);
                  }
                  else
                  {
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $emp->first_in);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $emp->last_out);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $emp->effective_time);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $emp->Late_marks);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $emp->Late_marks_count);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $emp->adjusted_time);
                  }

                  $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $emp->remark);
                  $row = $row+1;


              }

              $objPHPExcel->getActiveSheet()->setCellValue('K'.$tempval, '=SUMIF(B'.$tempval.':B'.($row-1).',B'.$tempval.',J'.$tempval.':J'.($row-1).')');

            }
          }

          for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
              $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
          }


          $dateObj   = DateTime::createFromFormat('!m', $month);
          $monthName = $dateObj->format('F');

          $filename='Employee_Attendence_'.$year.'_'.$monthName.'.xls';

          header('Content-Type: application/vnd.ms-excel');

          header('Content-Disposition: attachment;filename="'.$filename.'"');

          header('Cache-Control: max-age=0');

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

          $objWriter->save('php://output');

       }
       else
       {
         echo "<script>alert('Data Not Found')</script>";
       }
    }

    public function send_approved_mail()
    {
       $year =  date("Y");
       $month = (intval(date("m"))-1);

       if($month==0)
       {
        $year = date("Y",strtotime("-1 year"));
        $month = 12;
       }

 
       $result1 = $this->attendence->attendence_list('approved',$year,$month);

       $this->db->last_query();

       if(count($result1)>0)
       {
          for ($j=0; $j <count($result1) ; $j++) { 

            $this->send_mail($result1[$j]->emp_no,$year,$month);
          }

       }
       else
       {
         echo "<script>alert('Data Not Found')</script>";
       }
    }

    public function send_mail($emp_no,$year,$month,$status='')
    {
      $result = $this->attendence->get_employee_attendence($emp_no,$year,$month);
        
       $tbody = '<!DOCTYPE html>
              <html>
              <head>
              <style>
              #customers {
                  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                  border-collapse: collapse;
                  width: 100%;
              }

              #customers td, #customers th {
                  border: 1px solid #ddd;
                  padding: 8px;
              }

              #customers tr:nth-child(even){background-color: #f2f2f2;}

              #customers tr:hover {background-color: #ddd;}

              #customers th {
                  padding-top: 12px;
                  padding-bottom: 12px;
                  text-align: left;
                  background-color: #000;
                  color: white;
              }
              </style>
              </head>
              <body>

              <table id="customers">
               <tr> <th>Date</th>
                <th>Punch In</th>
                <th>Punch Out</th>
                <th>Effective Time</th>
                <th>Late Marks</th>
                <th>Adjusted Time</th></tr>'
               ;
    
        if(count($result)>0)
        {
          $i=0;
          $total_days=0;
          foreach ($result as $emp) {
              $total_days= $total_days+$emp->employee_adjusted_time;
          }
          $tbody .= '<tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>Total Days</td>
                          <td>'.$total_days.'</td>
                      ';
          foreach ($result as $emp) {

              $tbody .= '<tr>
                          <td>'.date('Y-m-d',strtotime($emp->date)).'</td>
                          <td>'.$emp->adjusted_in_time.'</td>
                          <td>'.$emp->adjusted_out_time.'</td>
                          <td>'.$emp->adjusted_effective_time.'</td>
                          <td>'.$emp->adjusted_late_marks.'</td>
                          <td>'.$emp->employee_adjusted_time.'</td>
                      ';
          }

          $tbody .='</table>
                </body>
                </html>';

          $from_email = 'cs@eatanytime.co.in';
          $from_email_sender = 'Wholesome Habits Pvt Ltd';

          if($result[0]->email_id2!="" || $result[0]->email_id2!=NULL)
          {
            $to_email2 = $result[0]->email_id2;
          }

          $to_email = $result[0]->email_id;
           
          
          $emp_name = $result[0]->emp_name;
          /*$bcc = 'vaibhav.desai@eatanytime.in, rishit.sanghvi@eatanytime.in, swapnil.darekar@otbconsulting.co.in';*/         

          if($status!='' &&  $status=='approved')
          {
            $subject = $emp_name.' Attendence For Month - '.date('F Y ',strtotime($result[0]->date)).' - Approved';
          }
          else
          {
            $subject = $emp_name.' Attendence For Month - '.date('F Y ',strtotime($result[0]->date));
          }


          /*$cc='sangeeta.yadav@pecanreams.com';  */
          if($to_email!='')
          {
            $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $tbody );
            if ($mailSent==1) {
                   "done";
            } else {
                  "mail_fail".$mailSent;
            }
          }

          if($to_email2!='')
          {
            $mailSent=send_email_new($from_email,  $from_email_sender, $to_email2, $subject, $tbody );
            if ($mailSent==1) {
                   "done";
            } else {
                  "mail_fail".$mailSent;
            }
          }
        
      }
    }

    public function save_emp_record($emp_no,$year,$month)
    {
      $emp_id = $this->input->post("emp_id");
      $adjusted_in_time = $this->input->post("adjusted_in_time");
      $adjusted_out_time = $this->input->post("adjusted_out_time");
      $prev_adjusted_in_time = $this->input->post("prev_adjusted_in_time");
      $prev_adjusted_out_time = $this->input->post("prev_adjusted_out_time");
      
      $remark = $this->input->post("remark");
      $emp_approval_status = $this->input->post("status");
      $emp_check = $this->input->post('checkboxval');  
      $date =$this->input->post("date");
     

      for ($i=0; $i <count($emp_id); $i++) { 

          $emp_id_e = $emp_id[$i];
          $adjusted_in_time_ex = $adjusted_in_time[$i];
          $adjusted_out_time_e = $adjusted_out_time[$i];
          $a_date = $date[$i];
          
          if($this->input->post('btn_reject')!=null)
          {
            /* if checkbox is clicked and clicked on reject status is change to reject */
            if($emp_check[$i]==1)
            {
              $status_approval = "rejected";
            }
            else
            {
              $status_approval = $emp_approval_status[$i];
            }
            
            $insert_array = array("status"=>$status_approval);
          }else if($this->input->post('btn_approve')!=null)
          {
            /*if checkbox is clicked and clicked on approved status is change to approved */

            if($emp_check[$i]==1)
            {
              $status_approval = "approved";
            }
            else
            {
              $status_approval = $emp_approval_status[$i];
            }
            
            /*if change in time difference then only insert in array */

            if(($adjusted_in_time_ex!=0 && $adjusted_in_time_ex!='') || ($adjusted_out_time_e!='' && $adjusted_out_time_e!='') )
            {
              $insert_array = array("adjusted_in_time"=>$adjusted_in_time_ex,"adjusted_out_time"=>$adjusted_out_time_e,"remark"=>$remark[$i],"status"=>$status_approval,'emp_status'=>'Present');
            }
            else
            {
              $insert_array = array("adjusted_in_time"=>$adjusted_in_time_ex,"adjusted_out_time"=>$adjusted_out_time_e,"remark"=>$remark[$i],"status"=>$status_approval);
            }
          }
          else
          {
            if($adjusted_in_time_ex!=0 || $adjusted_in_time_ex!='')
             {
               $adjusted_in_time_ex = date('H:i', strtotime($adjusted_in_time_ex));
             }
              
            if($adjusted_out_time_e!=0 || $adjusted_out_time_e!='')
            {
              $adjusted_out_time_e = date('H:i', strtotime($adjusted_out_time_e));

            }

            /*if previous time is not same as current time change status nand time is not equal to 0 then change the emp_status as present */

            if($prev_adjusted_in_time[$i]!=$adjusted_in_time_ex || $prev_adjusted_out_time[$i]!=$adjusted_out_time_e)
            {
              $status_approval = "pending";
            }
            else
            {
              $status_approval = $emp_approval_status[$i];
            }

            if(($adjusted_in_time_ex!=0 && $adjusted_in_time_ex!='') || ($adjusted_out_time_e!='' && $adjusted_out_time_e!='') )
            {
              $insert_array = array("adjusted_in_time"=>$adjusted_in_time_ex,"adjusted_out_time"=>$adjusted_out_time_e,"remark"=>$remark[$i],"status"=>$status_approval,'emp_status'=>'Present');
            }
            else
            {
              $insert_array = array("adjusted_in_time"=>$adjusted_in_time_ex,"adjusted_out_time"=>$adjusted_out_time_e,"remark"=>$remark[$i],"status"=>$status_approval);
            }
          }

          /*if previous time is not same as current time change status nand time is not equal to 0 then change the emp_status as present */

          if($this->session->userdata("user_name")=='rishit.sanghvi@eatanytime.in' || $this->session->userdata("user_name")=='swapnil.darekar@eatanytime.in')
          {
            $where = array("emp_id"=>$emp_id[$i],'date'=>$a_date);
            $this->db->where($where)->update("employee_attendence",$insert_array);
          }
          else
          {
             $where = array("emp_id"=>$emp_id[$i],'date'=>$a_date);
             $this->db->where($where)->update("employee_attendence",$insert_array);
          }
          
      }

       if($this->input->post('btn_approve')!=null)
        {
          $sql = "SELECT sum(Case When `status`='rejected' OR  `status`='pending' THEN 1 else 0 end) as `count` from employee_attendence Where emp_no='$emp_no' and MONTH(date)=$month and YEAR(date)='$year'";
          $result = $this->db->query($sql)->result();

          $result[0]->count;
          if($result[0]->count==0)
          {
            $this->send_mail($emp_no,$year,$month,'approved');
          }
        }

      redirect(base_url().'index.php/Eat_Attendence/get_employee_attendence/'.$emp_no.'/'.$year.'/'.$month);
    }

    public function get_total_count()
    {
      $status = $this->input->post("status");
      $year =   $this->input->post("year");
      $month =  $this->input->post("month");
      
      $count_data=$this->attendence->get_summary($status,$year,$month);

      $approved=0;
      $pending=0;
      $pending_for_approval=0;
      $rejected=0;

      if (count($count_data)>0){

          for($i=0;$i<count($count_data);$i++){
              if (trim($count_data[$i]->status)=="Pending")
                  $pending=$pending+1;
              else if (trim($count_data[$i]->status)=="Pending For Approval")
                  $pending_for_approval=$pending_for_approval+1;
              else if (trim($count_data[$i]->status)=="Approved")
                  $approved=$approved+1;
              else if (trim($count_data[$i]->status)=="Rejected")
                  $rejected=$rejected+1;
          }
      }

      $data['approved']=$approved;
      $data['pending']=$pending;
      $data['pending_for_approval']=$pending_for_approval;
      $data['rejected']=$rejected;

      echo json_encode($data);
    }

    public function test_mail($value='')
    {
         $from_email = 'contact@eatanytime.co.in';
         $from_email_sender = 'Wholesome Habits Pvt Ltd';
         $to_email = "prasad.bhisale@pecanreams.com";
         /* $bcc = 'vaibhav.desai@eatanytime.in, rishit.sanghvi@eatanytime.in, swapnil.darekar@otbconsulting.co.in';*/
         $subject = 'Attendence For Month';

         $message = '<!DOCTYPE html>
                <html>
                <head>
                <style>
                #customers {
                    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                }

                #customers td, #customers th {
                    border: 1px solid #ddd;
                    padding: 8px;
                }

                #customers tr:nth-child(even){background-color: #f2f2f2;}

                #customers tr:hover {background-color: #ddd;}

                #customers th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    text-align: left;
                    background-color: #000;
                    color: white;
                }
                </style>
                </head>
                <body>

                <table id="customers">
                 <tr> <th>Date</th>
                  <th>Punch In</th>
                  <th>Punch Out</th>
                  <th>Effective Time</th>
                  <th>Late Marks</th>
                  <th>Adjusted Time</th></tr>
                  </table>
                </body>
                </html>';

          /*$this->load->library('email');
          $this->email->from($from_email, 'Eat Any Time');
          //$this->email->to('avadhutp2711@gmail.com');
          $this->email->to($from_email_sender);
          
          $this->email->subject('Email Test');
          $this->email->message($tbody);
          $this->email->set_mailtype("html");
          //echo $this->email->send();

          if($this->email->send())
            echo "mail sent";
          else{
             echo $this->email->print_debugger();

            echo "mail Not sent";
          }*/
            
          $mailSent=send_email_new($from_email,  $from_email_sender, $to_email, $subject, $message );
          if ($mailSent==1) {
                 "done";
          } else {
                "mail_fail".$mailSent;
          }
          

          // try {
          //     $CI =& get_instance();

          //     $from_email = 'hr@eatanytime.in';

          //     //configure email settings
          //     $config['protocol'] = 'smtp';
          //     // $config['smtp_host'] = 'smtp.rediffmailpro.com'; //smtp host name
          //     $config['smtp_host'] = 'ssl://smtp.gmail.com'; //smtp host name
          //     $config['smtp_port'] = '465'; //smtp port number
          //     $config['smtp_user'] = $from_email;
          //     $config['smtp_pass'] = 'team@123'; //$from_email password
          //     $config['mailtype'] = 'html';
          //     $config['charset'] = 'iso-8859-1';
          //     $config['wordwrap'] = TRUE;
          //     $config['newline'] = "\r\n"; //use double quotes
          //     $CI->email->initialize($config);

          //     //send mail
          //     $CI->email->from($from_email, $from_email_sender);
          //     $CI->email->to($to_email);
          //     // $CI->email->bcc($bcc);
          //     // if($cc!='')
          //     // $CI->email->cc($cc);
          //     $CI->email->subject($subject);
          //     $CI->email->message($message);
          //     // if($attachment!='')
          //     //     $CI->email->attach($attachment);
          //     $CI->email->set_mailtype("html");
          //     $result = $CI->email->send();
          //     echo $CI->email->print_debugger();
          //     $CI->email->clear(TRUE);

          //     if ($result==1) {
          //         echo "Mail Send";
          //     } else {
          //         echo "Mail NOT Send";
          //     }

          // } catch (Exception $ex) {
              
          // }

    }

    public function download_excel_summery($status='')
    {
       $year =  date("Y");
       $month = (intval(date("m"))-1);
       if($month==0)
       {
        $year = date("Y",strtotime("-1 year"));
        $month = 12;
       }

       $result1=$this->attendence->get_summary($status,$year,$month);
       $this->db->last_query();

       if(count($result1)>0)
       {

          $template_path=$this->config->item('template_path');
          $file = $template_path.'Employee_Attendence_summay.xls';
          $this->load->library('excel');
          $objPHPExcel = PHPExcel_IOFactory::load($file);
         /* $objPHPExcel->getActiveSheet()->setTitle('Attendence Regularization');*/
          $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Employee code');
          $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Employee Name');
          $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Total Count');
          $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Total Holiday');
          $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Total WeeklyOff');
          $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Total Leaves');
       

          $row=2;

           foreach ($result1 as $emp) {
               
                  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $emp->emp_no);
                  $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $emp->emp_name);
                  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $emp->total_days);
                  $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $emp->no_of_holiday);
                  $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $emp->weekly_off);
                  $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $emp->no_of_leave);
                  $row=$row+1;
          }
          

          for ($col = 0; $col <= PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestDataColumn()); $col++) {
              $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
          }


          $dateObj   = DateTime::createFromFormat('!m', $month);
          $monthName = $dateObj->format('F');

          $filename='Employee_Attendence_summary_'.$year.'_'.$monthName.'.xls';

          header('Content-Type: application/vnd.ms-excel');

          header('Content-Disposition: attachment;filename="'.$filename.'"');

          header('Cache-Control: max-age=0');

          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

          $objWriter->save('php://output');
       }
       else
       {
         echo "<script>alert('Data Not Found')</script>";
       }
    }

}

?>