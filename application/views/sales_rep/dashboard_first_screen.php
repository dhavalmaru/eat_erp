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
      <!-- end panel control left -->
      <!-- slider
         <div class="the-slider">
         	<div class="container">
         		<div class="the-slider-entry">
         			<div class="slider-slick">
         				<div class="slider-entry">
         					<img src="img/slider1.jpg" alt="">
         					<div class="overlay"></div>
         					<div class="caption">
         						<div class="container">
         							<h2><a href="">Xtra Modern Design</a></h2>
         							<p>Find your need now and get Discount</p>
         						</div>
         					</div>
         				</div>
         				<div class="slider-entry">
         					<div class="overlay"></div>
         					<img src="img/slider2.jpg" alt="">
         					<div class="caption">
         						<div class="container">
         							<h2>Mobile Design Template</h2>
         							<p>Find your need now and get Discount</p>
         						</div>
         					</div>
         				</div>
         				<div class="slider-entry">
         					<div class="overlay"></div>
         					<img src="img/slider3.jpg" alt="">
         					<div class="caption">
         						<div class="container">
         							<h2>Creative Xtra Design</h2>
         							<p>Find your need now and get Discount</p>
         						</div>
         					</div>
         				</div>
         			</div>
         		</div>
         	</div>
         </div>
         <!-- end slider --
         
         <div class="features">
         	<div class="container">
         		<div class="row">
         			<div class="col s4 f-left">
         				<div class="entry e-left">
         					<i class="fa fa-mobile"></i>
         					<h5>Responsive</h5>
         				</div>
         			</div>
         			<div class="col s4 f-center">
         				<div class="entry e-center">
         					<i class="fa fa-lightbulb-o"></i>
         					<h5>Fresh Idea</h5>
         				</div>
         			</div>
         			<div class="col s4 f-right">
         				<div class="entry e-right">
         					<i class="fa fa-user"></i>
         					<h5>Support</h5>
         				</div>
         			</div>
         		</div>
         	</div>
         </div>
         
         <!-- services 
         
         <div class="services">
         	<div class="container">
         		
         		<div class="row">
         			<div class="col s12">
         				<div class="entry" style="text-align:center;">
         				
         					<div class="name green accent-2" style="text-align:center;margin:15px auto;">as</div>
         					<h5>Android</h5>
         					
         				</div>
         			</div>
         			
         		</div>
         		<div class="row">
         			<div class="col s6">
         				<div class="entry">
         				<i class="fa fa-map-marker color-1"></i>
         					<h5>Locations</h5>
         					
         				</div>
         			</div>
         			<div class="col s6">
         				<div class="entry">
         					<i class="fa fa-globe color-2"></i>
         					<h5>Route Plan</h5>
         					
         				</div>
         			</div>
         		</div>
         		<div class="row">
         			<div class="col s6">
         				<div class="entry">
         					<i class="fa fa-group color-3"></i>
         					<h5>Distributors</h5>
         					
         				</div>
         			</div>
         			<div class="col s6">
         				<div class="entry">
         					<i class="fa fa-shopping-cart color-4"></i>
         					<h5>Orders</h5>
         				
         				</div>
         			</div>
         		</div>
         	</div>
         </div>
         
         <!-- end services -->
      <!-- START WIDGETS 
         <div class="radio-style" style="display: none;">
         
         <div class=" ">
                 <input type="radio" name="period" id="weekly" value="weekly" /> &nbsp;&nbsp; Weekly &nbsp;&nbsp; 
                 <input type="radio" name="period" id="monthly" value="monthly" /> &nbsp;&nbsp; Monthly &nbsp;&nbsp; 
                 <input type="radio" name="period" id="all" value="all" /> &nbsp;&nbsp; All
         </div>
         
         </div>
         -->
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
                  <div class="row">
                     <div class="col s6">
                        <div class="entry">
                           <a class="absent">
                              <i class="fa fa-clock-o  color-3"></i>
                              <h5>Absent</h5>
                           </a>
                        </div>
                     </div>
                     <div class="col s6">
                        <div class="entry">
                           <a href="#myModal3" data-toggle="modal">
                              <i class="fa fa-clock-o  color-4"></i>
                              <h5>Working</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="row leave_type" >
                     <div class="col s6 leave_type_content">
                        <a data-toggle="modal" id="" href="#myModal" style="background:#d43f3a!important"class="button shadow orange btn_color left" >Approved</a>
                        <a  data-toggle="modal" id="" href="#myModal2"style="background:#4cae4c!important" class="button shadow btn_color right" >Casual</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </main>
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
                  <button type="button" style="background:#d43f3a!important"class="button shadow btn_color left modal-close" data-dismiss="modal">NO</button>
                  <button type="button" style="background:#4cae4c!important" class="button shadow btn_color right  "data-dismiss="modal">Yes</button>
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
                           <textarea id="textarea1" class="materialize-textarea" class="" name="remarks" id="remarks" placeholder="Remarks" value="<?php if(isset($data[0]->remarks)) echo $data[0]->remarks;?>" ></textarea>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" style="background:#4cae4c!important" class="button shadow btn_color right  "data-dismiss="modal">Submit</button>
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
                  <p>Your Geo Loacation Send To Your reporting Manager?? </p>
               </div>
               <div class="modal-footer">
                  <button type="button" style="background:#4cae4c!important" class="button shadow btn_color right  modal-close" data-dismiss="modal">Ok</button>
               </div>
            </div>
         </div>
      </div>
      <!-- moris js -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/fakeLoader.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/loading.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/slick.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/owl.carousel.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/custom.js"></script>
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
      </script>