<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>EAT ERP</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
          <!-- CSS INCLUDE -->        
           <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>  
         
        <!-- EOF CSS INCLUDE -->   
<style>
.fa-eye  { font-size:21px; color:#333;}
.fa-file-pdf-o{ color:#e80b0b; font-size:21px;}
.fa-paper-plane-o{ color:#520fbb; font-size:21px;}
@media only screen and (min-width:495px) and (max-width:717px) {.btn-bottom { margin-top:5px;}}
input[readonly], input[readonly], select[readonly], textarea[readonly] {
  background-color: white !important; 
  color: #0b385f !important; 
  cursor: not-allowed !important;
}
</style>    

<style>
            .sidenav1 {
               height: 50%;
                width: 0;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: #111;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 60px;
                margin-top: 100px;
            }
            .sidenav1 a {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 15px;
                color: #818181;
                display: block;
                transition: 0.3s;
            }
            .sidenav1 a:hover {
                color: #f1f1f1;
            }
            .sidenav1 .closebtn {
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 50px;
                margin-left: 50px;
            }
            @media screen and (max-height: 450px) {
              .sidenav1 {padding-top: 15px;}
              .sidenav1 a {font-size: 18px;}
            }
            </style>
            <style>
            .nav-contacts { margin-top:-5px;}
            .heading-h3 { border:none!important;}
            @media only screen and (min-width:711px) and (max-width:722px) {
                .u-bgColorBreadcrumb {
                    background-color: #eee;
                    padding-bottom: 13px;
                }
            }
            @media only screen and (min-width:813px) and (max-width:822px) {
                .u-bgColorBreadcrumb {
                    background-color: #eee;
                    padding-bottom:50px!important;
                }
            }
            @media only screen and (min-width:999px) {
                .mysidenav {
                    display: none;
                }
            }
            #customers10 {width: 100% !important;}
        </style>        
    </head>
    <body>                              
             <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
               <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                   <div class="heading-h3"> 
                   <div class="heading-h3-heading">  <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; 
                    <a href="<?php echo base_url().'index.php/Eat_Attendence'; ?>" >  Employee Attendence  </a></div>  
                    <a href="javascript:void(0)" id="employee_name" style="float:right"><?php if(isset($emp_name)) echo $emp_name.' / '.$emp_department; ?></a> 
                      <div class="heading-h3-heading">
                      <div class="pull-right btn-margin">   
                       <!--  <?php //$this->load->view('templates/download');?>   -->  
                      </div>  
                </div>        
                </div> 
                 <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row">   
                        <div class="page-width">                    
                          <div class="col-md-12">
                           <div class="panel panel-default">
                            <div id="add_check">
                              <button  class="btn btn-danger" id="select_all">Select All</button><br><br>
                            </div>
                            <div id="remove_check" style="display: none">
                              <button  class="btn btn-danger" id="remove_all">Uncheck All</button><br><br>
                            </div>

                            <form action="<?= base_url().'index.php/Eat_Attendence/save_emp_record/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5);?>" method="POST" >
                              <div class="panel-body">
                                <div class="table-responsive">
                                   <div class="table-responsive">
                                       <table id="customers10" class="table datatable table-bordered" style="width:100%">
                                            <thead>
                                            
                                              <tr>
                                              <?php if($this->session->userdata("user_name")=='rishit.sanghvi@otbconsulting.co.in')
                                               { ?>
                                              <th style="text-align: center">Action</th>
                                              <?php } ?>
                                                <th colspan="5" style="text-align: center">System Time</th>
                                                <th colspan="2" style="text-align: center" id="total_system">Total - <?=$system_total?></th>
                                                <th colspan="3" style="text-align: center">Employee Entered Time</th>
                                                <th colspan="3" style="text-align: center" id="total_entered">Total - <?=$employee_total?></th>
                                                <th style="text-align: center">System Status</th>
                                              <tr>
                                              <tr>
                                              <?php if($this->session->userdata("user_name")=='rishit.sanghvi@otbconsulting.co.in')
                                               { ?>
                                              <th >Checkbox</th>
                                              <?php } ?>
                                              <th>Date &nbsp;&nbsp;</th>
                                              <th>Punch In</th>
                                              <th>Punch Out</th>
                                              <th>Status</th>
                                              <th>Effective Time</th>
                                              <th>Late Marks</th>
                                              <th>Adjusted Time</th>
                                              <th>Punch In</th>
                                              <th> Punch Out</th>
                                              <th>Remark</th>
                                              <th> Late Mark</th>
                                              <th>Adjusted Time</th>   
                                              <th>Effective Time</th>
                                              <th>Status</th>
                                              <tr>    
                                            </thead>
                                            <tbody>
                                                <?php if(isset($detailed_attendence)){ echo $detailed_attendence;} ?>
                                            </tbody>
                                       </table>
                                </div>
                            </div>
                           </div>
                           <div class="panel-footer">
                              <a href="<?php echo base_url(); ?>index.php/Eat_Attendence" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                             
                              <?php 
                              if($this->session->userdata('user_name')=='rishit.sanghvi@otbconsulting.co.in'){?>  
                              <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve"  />

                              <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" name="btn_reject" value="Reject"  />
                              <?php } else { ?>
                               <input type="submit" name="submit" id="btn_submit" class="btn btn-success pull-right" value="Submit For Approval ">
                              <?php } ?>
                            </div>
                            </form>
                        </div>
                        </div>
                        
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
                        
        <?php $this->load->view('templates/footer');?>
        
    <!-- END SCRIPTS -->
    <script type="text/javascript">
        var BASE_URL="<?php echo base_url()?>";
        $( document ).ready(function() {

            /*if(!$('#btn_submit').is(':visible')){
                  // $("input[type!='hidden']").attr("disabled", true);
                  $('input[type="text"').attr("readonly", true);
                  $('input[type="time"').attr("readonly", true);
                  $('textarea').attr("readonly", true);
              }*/

            $('#select_all').click(function(){
                $('#remove_check').show();
                $('#add_check').hide();
                $('.attendence_check').prop('checked', true);

                $('.attendence_check').each(function(){
                    var attr_id = $(this).attr('id');
                    var explode = attr_id.split("_");
                    var row_id = explode[3];
                    $("#emp_check_"+row_id).val(1);
                });

            });

            $('#remove_all').click(function(){
                $('#add_check').show();
                $('#remove_check').hide();
                $('.attendence_check').prop('checked', false);
                $('.attendence_check').each(function(){
                    var attr_id = $(this).attr('id');
                    var explode = attr_id.split("_");
                    var row_id = explode[3];
                    $("#emp_check_"+row_id).val(0);
                });
            });

            test_time();
            get_hours();
        });

        $('.attendence_check').change(function(){
           var attr_id = $(this).attr('id');
           var explode = attr_id.split("_");
           var row_id = explode[3];

           if($(this).is(":checked"))
           {
             /*alert($("#emp_check_"+row_id).val());*/
             $("#emp_check_"+row_id).val(1);
             /*alert($("#emp_check_"+row_id).val()); */ 

           }
           else
           {
              $("#emp_check_"+row_id).val(0);
              /*alert("uncked");*/
           }
        });

        $('.adjusted_time').on('blur' ,function(){
          var lcount = 0,Late_marks;var total_entered=0;count=1;
          $('.adjusted_time').each(function(){
              var attr_id = $(this).attr('id');
              var explode = attr_id.split("_");
              var row_id = explode[3];
              var in_time = $("#adjusted_in_time_"+row_id).val();
              var out_time = $("#adjusted_out_time_"+row_id).val();
              var employee_adjusted_time;

              var emp_status = $('#emp_status_'+row_id).text();
              var effective_time ;

              switch (emp_status) {
                  case "WeeklyOff":
                  effective_time = "WeeklyOff";
                  break;
                  case "Holiday":
                  effective_time = "Holiday";
                  break;
                  case "Absent":
                  
                  if(in_time!='' && out_time!='')
                  {
                     console.log('enetede3332');

                     var hourDiff = test_time(in_time,out_time);//timeStart-timeEnd; 
                     effective_time = hourDiff;
                     console.log('effective_time'+effective_time);
                  }else
                  {
                      effective_time=0;
                  }
                  break;
                  case "Present":
                    /*dt1 = new Date("October 13, 2014 "+in_time);
                    dt2 = new Date("October 13, 2014 "+out_time);*/
                    console.log('in_time'+in_time);
                    console.log('out_time'+out_time);
                    if(in_time!='' &&  out_time!='')
                    {
                      console.log('eneterd');
                      var hourDiff = test_time(in_time,out_time);//timeStart-timeEnd; 
                      effective_time = hourDiff;
                    }
                    else
                    {
                       effective_time=0
                    }
                    
                  break;
                  default:
                  effective_time = 0;
                  break;
              }

              var currentD = new Date("January 1, 1970 " + in_time);
              var startHappyHourD = new Date("January 1, 1970 ");
              startHappyHourD.setHours(10,01); // 10:00 pm
              var endHappyHourD = new Date("January 1, 1970 ");
              endHappyHourD.setHours(11,00); // 11.00 pm

              if((currentD >= startHappyHourD && currentD < endHappyHourD) && parseInt(effective_time)>=9)
              {
                 if((in_time=='' && out_time!='') || (in_time!='' && out_time==''))
                 {
                    Late_marks = 'H';
                    effective_time = 0;
                 }
                 else
                {
                   Late_marks = 'L';
                }
              }
              else if((currentD > endHappyHourD || (parseInt(effective_time)<9)) && (emp_status!='WeeklyOff' && (emp_status!='Absent' || effective_time<9) && emp_status!='Holiday'))
              {
                  /*if(parseInt(effective_time)==0)
                  {
                     Late_marks = 'N';
                  }
                  else*/ if(parseInt(effective_time)!=0 && (parseInt(effective_time)>=4))
                    {
                      Late_marks = 'H';
                    }
                    else
                    {
                      Late_marks = 'N';
                    }
                 
              }
              else
              {
                 Late_marks = 'N';
              }


              /*if(Late_marks=='L')
              {
                lcount = lcount+1;
              }*/

              if(($(this).attr('name').indexOf("adjusted_in_time[]") > -1) && Late_marks=='L')
              {
                lcount = lcount+1;
              }

              switch (Late_marks) {
                  case ( lcount>3 && parseInt(effective_time)>=10 && 'L'):
                     employee_adjusted_time = 0.66;
                  break;
                  case ((lcount>3 &&  parseInt(effective_time)<10) && 'L'):
                     employee_adjusted_time = 0.50;
                  break;
                  case 'H':
                     employee_adjusted_time = 0.50;
                  break;
                  case ('N'):
                       if(emp_status=='Absent' && effective_time=='')
                       {
                        console.log('enetered'+effective_time);
                         employee_adjusted_time = 0.00;
                       }
                       else
                       {
                         if(parseInt(effective_time)==0)
                         {
                           employee_adjusted_time = 0.00;
                         }
                         else if(parseInt(effective_time)<4 && (emp_status!='WeeklyOff' && emp_status!='Holiday'))
                          {
                            employee_adjusted_time = 0.00;
                          }
                          else if((parseInt(effective_time)>=4 && parseInt(effective_time)<9) && (emp_status!='WeeklyOff' && emp_status!='Holiday'))
                          {
                            employee_adjusted_time =  0.50;
                          }
                          else
                          {
                            employee_adjusted_time = 1.00;
                          }
                       }
                        
                  break;
                  default:
                    employee_adjusted_time = 1.00;
              }
               if(($(this).attr('name').indexOf("adjusted_in_time[]") > -1))
              {
                total_entered = (parseFloat(total_entered)+parseFloat(employee_adjusted_time));
                 /*console.log('employee_adjusted_time  '+count+'  employee_adjusted_time  '+employee_adjusted_time+' total_entered  '+total_entered);
                  count= count+1;*/
              }

              $('#adjusted_late_marks_'+row_id).html(Late_marks);
              $('#adjusted_time_'+row_id).html(employee_adjusted_time);
              $('#adjusted_effective_time_'+row_id).html(effective_time);
          });
          $('#total_entered').html('Total - '+ (Math.round(total_entered * 100) / 100));
        });

        
    </script>
    <script type="text/javascript">
      function diff_hours(dt1, dt2) 
         {
          var diff =(dt2.getTime() - dt1.getTime()) / 1000;
          diff /= (60 * 60);
          return Math.round(diff*100)/100;
          
         }

        function test_time(startTime,endTime) {
            /*var startTime = "10:00";
            var endTime = "19:30";*/

            console.log('startTime'+startTime);
            console.log('startTime'+endTime);

            var startDate = new Date("January 1, 1970 " + startTime);
            var endDate = new Date("January 1, 1970 " + endTime);

            if (startDate >= endDate) { 
             var endDate = new Date("January 2, 1970 " + endTime);
                console.log(endDate);
            }

            var timeDiff = Math.abs(startDate - endDate);
            console.log(timeDiff);   
            var hh = Math.floor(timeDiff / 1000 / 60 / 60);
            if(hh < 10) {
                hh = hh;
            }
            timeDiff -= hh * 1000 * 60 * 60;
            var mm = Math.floor(timeDiff / 1000 / 60);
            if(mm < 10) {
                mm = '0' + mm;
            }
            timeDiff -= mm * 1000 * 60;
            /*var ss = Math.floor(timeDiff / 1000);
            if(ss < 10) {
                ss = '0' + ss;
            }*/

            return hh + ":" + mm;
        }

        function check_time(elem) {
          var attr_id = elem.id ;
          var explode = attr_id.split("_");
          var row_id = explode[3];
          var in_time =  $("#adjusted_in_time_"+row_id).val();
          var out_time = $("#adjusted_out_time_"+row_id).val();
          
          /*alert($("#"+attr_id).val());*/
         /* var startDate = new Date("January 1, 1970 " + in_time);
          var endDate =  new Date("January 1, 1970 " + out_time);*/

          /*if (startDate >= endDate) { 
                alert("Please Enter Correct Time");
                $("#"+attr_id).val('');
            }*/
        }

        function get_hours() {
          /*var currentD = new Date();*/
          var currentD = new Date("January 1, 1970 " + '10:05');
          var startHappyHourD = new Date("January 1, 1970 ");
          startHappyHourD.setHours(10,00); // 10:00 pm
          var endHappyHourD = new Date("January 1, 1970 ");
          endHappyHourD.setHours(11,00); // 11.00 pm

          if(currentD >= startHappyHourD && currentD < endHappyHourD ){
              console.log("yes!");
          }else{
              console.log("no, sorry! between 5.30pm and 6.30pm");
          }
        }
    </script>
    </body>
</html>