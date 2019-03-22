<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Eat-ERP</title>
      <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1  maximum-scale=1">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="HandheldFriendly" content="True">
      <link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.png">
      <link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/font-awesome.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/fakeLoader.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/slick.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/slick-theme.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.carousel.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.theme.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.transitions.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/style.css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/font/material-design-icons/Material-Design-Icons.woff" rel="stylesheet">
      <style>
         .tabs
         {
         background-color: #1861b1!important;
         border-top:1px solid #fff;
         }
         #home
         {
         display:none!important;
         }
         .tabs .tab
         {
         line-height: 20px;
         }
         .name  {
         font-size: 20px;
         width: 60px;
         height: 60px;
         border-radius: 50%;
         line-height: 58px;
         color: #fff;
         margin-bottom: 15px;
         margin-top: 15px;
         align:center;
         }
         .color-n 
         {
         color:#69f0ae green accent-2;
         }
         .carousel .carousel-item {
         width: 100%;
         height: 100%;
         overflow-y:scroll;
         }
         .carousel
         {
         height:1000px!important;
         }
         .row {
         margin-bottom: 7px;
         margin-top: 7px;
         }
         .wishlist .entry .s-title {
         border-top: 1px solid #ddd;
         padding-top: 0px;
         }
         #order_tabs .tab a:hover, #order_tabs .tab a.active
         {
         color: #6FA7E4!important;
         }
         #order_tabs a 
         {
         color: #6FA7E4!important;
         }
         #order_tabs .indicator
         {
         background-color:#6FA7E4!important; 
         }
         #order_tabs
         {
         background-color: transparent!important;
         }
         .tabs .tab a:hover, .tabs .tab a.active
         {
         color: #ffffff!important;
         }
         #location_tab a 
         {
         color: #ffffff!important;
         }
         #location_tab .indicator
         {
         background-color:#ffffff!important; 
         }
         #location_tab .tab
         {
         padding: 0px!important;
         }
         #location_tab .tab a
         {
         padding: 0 8px!important;
         }
         #location_tab .tab a:hover, #location_tab .tab a.active
         {
         color: #fff!important;
         }
         .beat_plan h4
         {
         font-size:12px!important;   
         display: inline;    
         }
         .date
         {
         font-size:8px!important;
         margin-top: 0px;
         }
         .leave_type_content
         {
         box-shadow: 4px 4px 6px;
         background: #fff;
         padding: 12px!important;
         }
      </style>
   </head>
   <body class="home">
      <!-- START PAGE CONTAINER -->
      <div id="loading"></div>
      <!-- end loading -->
      <!-- navbar -->
      <div class="navbar">
         <?php $this->load->view('templates/header2');?>
      </div>
      <!-- end navbar -->
      <!-- panel control left -->
      <?php $this->load->view('templates/menu2');?>
      <form action="<?=base_url().'index.php/Sales_Attendence/save'?>" method="POST" id="sales_attendence">
          <main style="margin-top: 115px;">
             <div class="col s12 ">
                <div class="services">
                   <div class="container">
                      <div class="row">
                         <div class="col s12">
                            <div class="entry" style="text-align:center;">
                               <div class="name green accent-2" style="text-align:center;margin:15px auto;"><?php if(isset($userdata['login_name'])) {echo substr($userdata['login_name'], 0, 1);} if(isset($userdata['last_name'])) {echo substr($userdata['last_name'], 0, 1);} ?></div>
                               <h5><?php if(isset($userdata['login_name'])) {echo $userdata['login_name'];}?></h5>
                            </div>
                         </div>
                      </div>
                      <div id="attendence_front" class="row" style="<?php if(isset($attendence)) { if(strtoupper(trim($attendence[0]->working_status))=='ABSENT') echo 'display: none;'; } ?>">
                         <div class="col s6">
                            <div class="entry">
                               <a class="absent" href="javascript:void(0)">
                                  <i class="fa fa-clock-o  color-3"></i>
                                  <h5>Absent</h5>
                               </a>
                            </div>
                         </div>
                         <div class="col s6">
                            <div class="entry">
                               <a href="javascript:void(0)" class="working">
                                  <i class="fa fa-clock-o  color-4"></i>
                                  <h5>Working</h5>
                               </a>
                            </div>
                         </div>
                      </div>
                      <div class="row" id="status_display" style="margin-top: 50px; <?php if(isset($attendence)) { if(strtoupper(trim($attendence[0]->working_status))=='ABSENT') echo ''; else echo 'display: none;'; } else echo 'display: none;'; ?>">
                         <div class="col s12">
                            <div class="entry" style="text-align:center;">
                               <h5>You are absent today.</h5>
                               <a href="" id="working_status_1" class="" style="color: blue; text-decoration: underline;">
                                  <h5 style="color: blue; margin-top: 10px;">Are you working?</h5>
                               </a>
                            </div>
                         </div>
                      </div>
                      <div class="row leave_type" >
                         <div class="col s6 leave_type_content">
                            <a data-toggle="modal" id="" href="#myModal" style="background:#d43f3a!important" class="button shadow orange btn_color left" >Approved</a>
                            <a data-toggle="modal" id="casual" href="#" class="button shadow btn_color right" >Casual</a>
                            <!-- <a  data-toggle="modal" id="approve" href="#approvedleave"style="display:none" class="button shadow btn_color right" >Test</a> -->
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </main>
          <input type="hidden" name="latitude" id="latitude">
          <input type="hidden" name="longitude" id="longitude">
          <div class="modal fade" id="myModal" role="dialog">
             <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                   <div class="modal-header">
                      <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close waves-effect waves-green btn-flat">&times;</button>
                      <h4 class="modal-title" style="font-size: 18px;font-weight:700">Approved Leave </h4>
                   </div>
                   <div class="modal-body">
                      <p>Have You Applied on Keka ? </p>
                   </div>
                   <div class="modal-footer">
                      <button type="button" style="background:#d43f3a!important" class="button shadow btn_color left  applied" data-dismiss="modal" data-attr="no" >NO</button>
                      <button type="button"  style="background:#4cae4c!important"  class="button shadow btn_color right applied"  data-dismiss="modal"data-attr="yes" >Yes</button>
                   </div>
                </div>
             </div>
          </div>
          <div class="modal fade" id="approvedleave" role="dialog">
             <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                   <div class="modal-header">
                      <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close waves-effect waves-green btn-flat">&times;</button>
                      <h4 class="modal-title" style="font-size: 18px;font-weight:700"> Employee Alert !! </h4>
                   </div>
                   <div class="modal-body">
                      <p>Please Apply On Keka Else Shall Be loss of pay. </p>
                   </div>
                   <div class="modal-footer">
                      <button type="button" id="loss_of_pay" style="background:#4cae4c!important" class="button shadow btn_color right" data-dismiss="modal">Ok</button>
                   </div>
                </div>
             </div>
          </div>
          <div class="modal fade" id="myModal2" role="dialog">
             <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                   <div class="modal-header">
                      <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close waves-effect waves-green btn-flat">&times;</button>
                      <h4 class="modal-title" style="font-size: 18px; font-weight:700">Casual Leave </h4>
                   </div>
                   <div class="modal-body">
                      <div class="row">
                         <div class="col s12">
                            <div class="input-field col s12">
                               <!--store_id is a Retailer id-->
                               <input id="casual_reason" class="materialize-textarea" class="" name="casual_reason" id="remarks" placeholder="Remarks">
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="modal-footer">
                      <button type="submit" style="background:#4cae4c!important" class="button shadow btn_color right  "data-dismiss="modal">Submit</button>
                   </div>
                </div>
             </div>
          </div>
          <div class="modal fade" id="myModal3" role="dialog">
             <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                   <div class="modal-header">
                      <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close waves-effect waves-green btn-flat">&times;</button>
                      <h4 class="modal-title" style="font-size: 18px;font-weight:700"> Employee Alert !! </h4>
                   </div>
                   <div class="modal-body">
                      <p>Your Geo Loacation Shall Be Sent To Your reporting Manager </p>
                   </div>
                   <div class="modal-footer">
                      <button type="button" style="background:#4cae4c!important" class="button shadow btn_color right  modal-close" data-dismiss="modal" id="present">Ok</button>
                   </div>
                </div>
             </div>
          </div>
      </form>
      <!-- moris js -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/fakeLoader.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/loading.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/slick.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/owl.carousel.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/custom.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
      <script>
         $('#tabs-swipe-demo').tabs({
         swipeable: true,
         responsiveThreshold: Infinity,
         });
         
         // $('.owl-carousel').owlCarousel({
             // items:1,
             // margin:10, 
             // full_width: true,
             
         // });
      </script>
      <script>
        var base_url = '<?=base_url()?>';
         $(document).ready(function(){
               $('.modal').modal();
             });
      </script>
      <script>
         $(document).ready(function(){
               $(".leave_type").hide();
           $(".absent").click(function(){
             $(".leave_type").toggle();
           });
         });
         
          $(".applied").click(function(){
              
              if($(this).attr('data-attr')=='no')
              {
				
                 $('#absent_remark').attr("required", "true");

                  $('#approvedleave').modal('open');

                //  $('#myModal').modal('close');

                //  $.ajax({
                //         url:'<?=base_url()?>index.php/Sales_Attendence/save',
                //         method: 'post',
                //         data: 
                //         {
                //         applied_on_keka: 'No',
                //         working_status:'Absent',
                //         casual_reason:'',
                //         latitude:$('#latitude').val(),
                //         longitude:$('#longitude').val(),
                //         applied_in_keka:''
                //         },
                //         async: false,
                //         success: function(response){
                //            console.log('entered');
                //            $(".leave_type").toggle();
                //         }
                // });
              }
              else
              {
				  	 window.location.reload();
                 $.ajax({
                        url:'<?=base_url()?>index.php/Sales_Attendence/save',
                        method: 'post',
                        data: {applied_on_keka: 'Yes',
                        working_status:'Absent',
                        casual_reason:'',
                        latitude:$('#latitude').val(),
                        longitude:$('#longitude').val(),
                        applied_in_keka:''
                       },
                        async: false,
                        success: function(response){
                          console.log('entered');
                          $('#myModal').modal('close');
                          $(".leave_type").toggle();
                        }
                });

              }

             
           });

          $("#loss_of_pay").click(function(){
               $('#myModal').modal('close');
               $('#approvedleave').modal('close');
				window.location.reload();
               $.ajax({
                      url:'<?=base_url()?>index.php/Sales_Attendence/save',
                      method: 'post',
                      data: 
                      {
                      applied_on_keka: 'No',
                      working_status:'Absent',
                      casual_reason:'',
                      latitude:$('#latitude').val(),
                      longitude:$('#longitude').val(),
                      applied_in_keka:''
                      },
                      async: false,
                      success: function(response){
                         console.log('entered');
                         $(".leave_type").toggle();
                      }
              });
          });

          $("#present").click(function(){
              $.ajax({
                        url:'<?=base_url()?>index.php/Sales_Attendence/save',
                        method: 'post',
                        data: {
                            working_status:'Present',
                            casual_reason:'',
                            latitude:$('#latitude').val(),
                            longitude:$('#longitude').val(),
                            applied_in_keka:''
                            },
                        async: false,
                        success: function(response){
                          console.log('entered');
                          window.location.href = base_url+'index.php/Dashboard_sales_rep';
                        }
                });
          });


          $('#casual').click(function(){
              $('#myModal2').modal('open');
              $('#absent_remark').removeAttr("required");
              $('#casual_reason').attr("required", "true");
          });

          $('.working').click(function(){
              $('#myModal3').modal('open');
              $('#absent_remark').removeAttr("required");
              $('#casual_reason').removeAttr("required");
          });
		  

				$('#working_status_1').click(function(e){
					e.preventDefault();
					$("#attendence_front").show();
					$("#status_display").hide();
				});

      </script>

      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw"></script>
        <script>
       $('document').ready(function(){
          if(navigator.geolocation) {
            var location_timeout = setTimeout("geolocFail()", 500000);
              
              navigator.geolocation.getCurrentPosition(function(location) {
              clearTimeout(location_timeout);
              
              $("#latitude").val(location.coords.latitude);
              $("#longitude").val(location.coords.longitude);
              console.log('latitude'+location.coords.latitude);
              console.log('longitude'+location.coords.longitude);
            
            }, function(error) {
              clearTimeout(location_timeout);
              geolocFail();
            });
            
          }
          else {
            geolocFail();
          }
       });
      
      function geolocFail() {
        alert("Please switch on GPS!!!");
      }

    </script>