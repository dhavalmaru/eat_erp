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
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/logout/popModal.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>css/select2/css/select2.min.css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/font/material-design-icons/Material-Design-Icons.woff" rel="stylesheet">
      <style>
	  
	  
         [type="checkbox"]:not(:checked), [type="checkbox"]:checked
         {
         position:relative;
         }
         .checkmark {
         position: absolute;

         margin-bottom: 10px;
         height: 25px;
         width: 25px;
         background-color: #eee;
         border: 2px solid #2196F3;
         }



         /* When the checkbox is checked, add a blue background */
         input:checked ~ .checkmark {
         background-color: #2196F3;
         }

         /* Create the checkmark/indicator (hidden when not checked) */
         .checkmark:after {
         content: "";
         position: absolute;
         display: none;
         }

         /* Show the checkmark when checked */
         input:checked ~ .checkmark:after {
         display: block;
         }

         /* Style the checkmark/indicator */
         .checkmark:after {
         left: 8px;
         top: 3px;
         width: 7px;
         height: 12px;
         border: solid white;
         border: solid white;
         border-width: 0 3px 3px 0;
         -webkit-transform: rotate(45deg);
         -ms-transform: rotate(45deg);
         transform: rotate(45deg);
         }
         .tabs
         {
         background-color: #1861b1!important;
         border-top:1px solid #fff;
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
         .tabs .tab a {
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
         #swipe-2 .tabs .tab
         {
         padding:4px 0px!important;
         }
         [type="checkbox"]+label:before, [type="checkbox"]:not(.filled-in)+label:after
         {
         width: 22px!important;
         height: 22px!important;
         }
         [type="checkbox"]:checked+label:before {
         top: 0px;
         left: 0px;
         width: 11px;
         height: 20px;
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
         <ul id="tabs-swipe-demo" class="tabs">
            <li class="tab col s3"><a class="active" href="#swipe-1"><i class="material-icons">home</i></a></li>
            <li class="tab col s3"><a href="#swipe-2"><i class="material-icons">place</i></a></li>
            <li class="tab col s3"><a href="#swipe-4"><i class="material-icons">shopping_cart</i></a></li>
         </ul>
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
         <div id="swipe-1" class="col s12 ">
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
                  <div class="row" style="margin-top:15px">
                     <div class="col s12">
                        <div class="entry" style="text-align:center">
                          
                           <div class="col s4" style="text-align: left;">
                              <label style="text-align: left; font-size: small; color: #343434;">Retailer</label>
                           </div>
                           <div class="col s8" style="text-align: left;">
                              <input type="hidden" name="reporting_manager_id" id="reporting_manager_id" value="<?php if(isset($reporting_manager_id)) { if($reporting_manager_id!='') echo $reporting_manager_id; } else if(isset($visit_detail['reporting_manager_id'])) echo $visit_detail['reporting_manager_id']; ?>" />
                              <input type="hidden" name="distributor_id_og" id="distributor_id_og" value="<?php if(isset($distributor_id)) { if($distributor_id!='') echo $distributor_id; } else if(isset($visit_detail['distributor_id'])) echo $visit_detail['distributor_id']; ?>" />
                              <select name="distributor_id" id="distributor_id" class="browser-default select2" onchange="get_beat_plan();" style="display: none;">
                                 <option value="">Select</option>
                                 <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                 <option value="<?php echo $distributor[$k]->id; ?>" 
                                    <?php 
                                       if(isset($distributor_id)) {
                                          if($distributor_id!='') {
                                             if($distributor[$k]->id==$distributor_id) { echo 'selected'; }
                                          }
                                       } else if(isset($visit_detail['distributor_id'])) {
                                          if($visit_detail['distributor_id']==$distributor[$k]->id) { echo 'selected'; }
                                       }
                                    ?>><?php echo $distributor[$k]->distributor_name; ?>
                                 </option>
                                 <?php }} ?>
                              </select>
                              <label id="lbl_distributor_name" style="text-align: left; font-size: small; color: #343434;"></label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row" style="margin-top:15px">
                     <div class="col s12">
                        <div class="entry" style="text-align:center">
                          
                           <div class="col s4" style="text-align: left;">
                              <label style="text-align: left; font-size: small; color: #343434;">Route Plan</label>
                           </div>
                           <div class="col s8" style="text-align: left;">
                              <input type="hidden" name="beat_id_og" id="beat_id_og" value="<?php if(isset($beat_id)) { if($beat_id!='') echo $beat_id; } else if(isset($visit_detail['beat_id'])) echo $visit_detail['beat_id']; ?>" />
                              <select name="beat_id" id="beat_id" class="browser-default select2" style="display: none;">
                                 <option value="">Select</option>
                                 <?php if(isset($beat)) { for ($k=0; $k < count($beat) ; $k++) { ?>
                                 <option value="<?php echo $beat[$k]->id; ?>" 
                                    <?php 
                                       if(isset($beat_id)) {
                                          if($beat_id!='') {
                                             if($beat[$k]->id==$beat_id) { echo 'selected'; }
                                          }
                                       } else if(isset($visit_detail['beat_id'])) {
                                          if($visit_detail['beat_id']==$beat[$k]->id) { echo 'selected'; }
                                       }
                                    ?>><?php echo $beat[$k]->beat_id.' - '.$beat[$k]->beat_name; ?>
                                 </option>
                                 <?php }} ?>
                              </select>
                              <label id="lbl_beat_name" style="text-align: left; font-size: small; color: #343434;"></label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row" style="margin-top:15px">
                     <div class="col s12">
                        <div class="entry" style="text-align:center">
                           <button type="button" id="btn_change_plan" class="button btn_color left" onclick="change_plan();">Change</button>
                           <label id="lbl_beat_status" class="button btn-color-2" style="<?php if($beat_status=='Approved') echo 'display: none;'; ?>"><?php echo $beat_status; ?></label>
                           <a class="button btn_color right"  style="display:none;" id="get_route_plan" href="<?php echo base_url() . 'index.php/Sales_rep_store_plan'; ?>" style="<?php if($beat_status!='Approved') echo 'display: none;'; ?>">
                              Get Route Plan
                           </a>
                           <a id="approve_route_plan" href="#" class="button btn_color right" style="margin-top: 5px; margin-left: 10px;" onclick="get_pending_beat_plan();">
                              Approve Route Plan
                           </a>
                        </div>
                        <button type="button" class="button btn_color right" id="set_route_plan" onclick="set_route_plan();" style="display: none;">Set Route Plan</button>
                           
                     </div>
                  </div>
                  </div>
                  <div class="row" style="margin-top:30px">
                     <div class="col s12">
                        <div class="entry" style="text-align:center">
                           <a href="<?php echo base_url() . 'index.php/Sales_rep_store_plan'; ?>">
                              <i class="fa fa-map-marker color-1"></i>
                              <h5>Todays Route Plan</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col s6">
                        <div class="entry">
                           <a  data-toggle="modal" id="" href="#myModal">
                              <i class="fa fa-group color-3"></i>
                              <h5>Check Out</h5>
                           </a>
                        </div>
                     </div>
                     <div class="col s6">
                        <div class="entry">
                           <a href="<?php echo base_url() . 'index.php/Sales_rep_order'; ?>">
                              <i class="fa fa-shopping-cart color-4"></i>
                              <h5>Todays Order</h5>
                           </a>
                        </div>
                     </div>
                  </div>
                  
               </div>
            </div>
         </div>
         <div id="swipe-2" class="col s12">
            <div class="wishlist app-section">
               <div class="container">
                  <ul class="tabs">
                     <?php 
                        $explode =  explode(" ",$checkstatus);
                        $checkstatus  = $explode[1];
                        $mon = date('d',strtotime('this Monday'));
                        $tue = date('d',strtotime('this Tuesday'));
                        $wed = date('d',strtotime('this Wednesday'));
                        $thu = date('d',strtotime('this Thursday'));
                        $fri = date('d',strtotime('this Friday'));
                        $sat = date('d',strtotime('this Saturday'));
                     ?>
                     <li class="tab">
                        <a class="<?php if($checkstatus=='Monday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan/checkstatus/Monday/<?=$mon?>" target="_self">
                           Mon
                           <p class="date">(<?=$mon?>)</p>
                        </a>
                     </li>
                     <li class="tab">
                        <a class="<?php if($checkstatus=='Tuesday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan/checkstatus/Tuesday/<?=$tue?>" target="_self">
                           Tues 
                           <p class="date">(<?=$tue?>)</p>
                        </a>
                     </li>
                     <li class="tab">
                        <a class="<?php if($checkstatus=='Wednesday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan/checkstatus/Wednesday/<?=$wed?>" target="_self">
                           Wed 
                           <p class="date">(<?=$wed?>)</p>
                        </a>
                     </li>
                     <li class="tab">
                        <a class="<?php if($checkstatus=='Thursday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan/checkstatus/Thursday/<?=$thu?>" target="_self">
                           Thur 
                           <p class="date">(<?=$thu?>)</p>
                        </a>
                     </li>
                     <li class="tab">
                        <a class="<?php if($checkstatus=='Friday') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan/checkstatus/Friday/<?=$fri?>" target="_self">
                           Fri 
                           <p class="date">(<?=$fri?>)</p>
                        </a>
                     </li>
                     <li class="tab">
                        <a class="<?php if($checkstatus=='Saturday') echo 'active'; ?>"  href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan/checkstatus/Saturday/<?=$sat?>" target="_self">
                           Sat
                           <p class="date">(<?=$sat?>)</p>
                        </a>
                     </li>
                  </ul>
                  <?php $counter=0;?>
                   <div class="entry shadow">
               <div class="app-title">
                  <h4>GT Follow Ups</h4>
               </div>
               <?php $counter=0;?>
               <?php    
                  for ($i=0; $i <count($gt_followup); $i++)
                   {
                         
                     ?>
               <div class="col s12">
                  <div class="wishlist-title s-title beat_plan">
                     <div class="row">
                        <div class="col s1">
                           <h4><?php echo ($i+1)?></h4>
                        </div>
                        <div class="col s2">
                           <a href="<?php echo base_url().'index.php/Sales_rep_store_plan/locations/'; ?> "class=""><i class="fa fa-map-marker"></i></a>
                        </div>
                        <div class="col s5">
                           <h5><?php echo $gt_followup[$i]->distributor_name; ?></h5>
                        </div>
                         <?php
                              if($checkstatus==$current_day){
                           ?>
                        <div class="col s4">
                           <?php
                              $url =  base_url().'index.php/Sales_rep_store_plan/add/'.$gt_followup[$i]->id.'/'.$checkstatus.'/GT/gt_followup';
                              ?>
                          
                           <a href="<?=($checkstatus==$current_day)?$url:'javascript:void(0)'?>" class="button shadow orange  lighten-1">
                           <?= ($gt_followup[$i]->is_visited!=NULL?'Edit':'Check In') ?>
                           </a>
                        </div>

                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php 
                  }?>
            </div>
                  <br>
                     <div class="entry shadow">
               <div class="app-title">
                  <h4>GT Visits For The Day</h4>
               </div>
               <?php $counter=0;?>
               <?php    
                  for ($i=0; $i <count($data); $i++)
                   {
                         
                     ?>
               <div class="col s12">
                  <div class="wishlist-title s-title beat_plan">
                     <div class="row">
                        <div class="col s1">
                           <h4><?php echo $data[$i]->sequence;?></h4>
                        </div>
                        <div class="col s2">
                           <a href="<?php echo base_url().'index.php/Sales_rep_store_plan/locations/'; ?> "class=""><i class="fa fa-map-marker"></i></a>
                        </div>
                        <div class="col s5">
                           <h5><?php echo $data[$i]->distributor_name; ?></h5>
                        </div>
                        <?php
                              if($checkstatus==$current_day){
                        ?>
                        <div class="col s4">
                           <?php 
                              $date= $data[$i]->date_of_visit;
                              if($date==null){
                                 $url =  base_url().'index.php/Sales_rep_store_plan/add/'.$data[$i]->bit_id.'/'.$checkstatus.'/GT';
                              ?>
                           <a href="<?=($checkstatus==$current_day)?$url:'javascript:void(0)'?>" class="button shadow orange  lighten-1">Check In</a>
                           <?php
                              }
                              
                                 else
                              {
                                 
                              ?>
                           <?php 
                              if($data[$i]->bit_plan_id!=0)
                              { ?>
                           <a href="<?php echo base_url().'index.php/Sales_rep_store_plan/edit/'.$data[$i]->bit_id.'/'.$checkstatus.'/GT';?>" class="button shadow orange  lighten-1">Edit</a>
                           <?php }
                              else 
                              {?>
                           <a href="<?php echo base_url().'index.php/Sales_rep_store_plan/edit/'.$data[$i]->mid.'/'.$checkstatus.'/GT/false/temp';?>" class="button shadow orange  lighten-1">Edit</a>
                           <?php }
                              ?>
                           <?php
                              }?>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php 
                  }?>
            </div>
                  <br>
                  <div class="entry shadow">
               <div class="app-title">
                  <h4>MT Follow Ups</h4>
               </div>
               <?php $counter=0;?>
               <?php    
                  for ($i=0; $i <count($mt_followup); $i++)
                   {
                      
                  ?>
               <div class="col s12">
                  <div class="wishlist-title s-title beat_plan">
                     <div class="row">
                        <div class="col s1">
                           <h4><?php echo ($i+1)?></h4>
                        </div>
                        <div class="col s2">
                           <a href="<?php echo base_url().'index.php/Sales_rep_store_plan/locations/'; ?> "class=""><i class="fa fa-map-marker"></i></a>
                        </div>
                        <div class="col s5">
                           <h5><?php echo $mt_followup[$i]->relation; ?></h5>
                        </div>
                        <?php
                              if($checkstatus==$current_day){
                        ?>
                        <div class="col s4">
                           <?php 
                              $url =  base_url().'index.php/Sales_rep_store_plan/add/'.$mt_followup[$i]->merchandiser_stock_id.'/'.$checkstatus.'/MT/mt_followup';
                              
                              ?>
                           <a href="<?=($checkstatus==$current_day)?$url:'javascript:void(0)'?>" class="button shadow orange  lighten-1"><?= ($mt_followup[$i]->is_visited!=NULL?'Edit':'Check In') ?></a>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php 
                  }?>
            </div>
                  <br>
                   <div class="entry shadow">
               <div class="app-title">
                  <h4>MT Visits For The Day</h4>
               </div>
               <?php $counter=0;?>
               <?php 
                  $data = $merchendizer;
                  for ($i=0; $i <count($data); $i++)
                   {
                         
                     ?>
               <div class="col s12">
                  <div class="wishlist-title s-title beat_plan">
                     <div class="row">
                        <div class="col s1">
                           <h4><?php echo $data[$i]->sequence;?></h4>
                        </div>
                        <div class="col s2">
                           <a href="<?php echo base_url().'index.php/merchandiser_location/locations/'.$data[$i]->id; ?> "class=""><i class="fa fa-map-marker"></i></a>
                        </div>
                        <div class="col s5">
                           <h5><?php echo $data[$i]->store_name.' - ( '.$data[$i]->location.' )'; ?></h5>
                        </div>
                        <?php
                              if($checkstatus==$current_day){
                        ?>
                        <div class="col s4">
                           <?php 
                              $dist= $data[$i]->dist_id;
                              $date= $data[$i]->date_of_visit;
                              
                              if($dist==null && $date==null){
                                 $url = base_url().'index.php/Sales_rep_store_plan/add/'.$data[$i]->bit_id.'/'.$checkstatus.'/MT';
                              ?>
                           <a href="<?=($checkstatus==$current_day)?$url:'javascript:void(0)'?>" class="button shadow orange  lighten-1" <>Check In</a>
                           <?php
                              }
                              
                                 else
                              {
                                 
                                 if($data[$i]->bit_plan_id!=0)
                                    {
                                       
                                       $url = base_url().'index.php/Sales_rep_store_plan/edit/'.$data[$i]->bit_id.'/'.$checkstatus.'/MT';
                                    }
                                    else
                                    {
                                       $url = base_url().'index.php/Sales_rep_store_plan/edit/'.$data[$i]->mid.'/'.$checkstatus.'/MT/false/temp';
                                    }

                              ?>
                           <a href="<?=$url;?>" class="button shadow orange  lighten-1">Edit</a>
                           <?php
                              }?>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php 
                  }?>
            </div>
               </div>
            </div>
             <div class="fixed-action-btn click-to-toggle" style="top: 450px; right: 24px;">
               <a class="btn-floating  pink waves-effect waves-light" href="<?php echo base_url() . 'index.php/Sales_rep_store_plan/add'; ?>">
               <i class="large material-icons">add</i>
               </a>
            </div>
         </div>
         <div id="swipe-4" class="col s12 ">
            <div class="wishlist app-section">
               <div class="container">
                  <div class="entry shadow">
                     <div class="app-title">
                        <h4>Order List</h4>
                     </div>
                     <ul class="tabs tab" id="order_tabs">
                        <li class="tab"><a class="active" href="#order_1">Todays Order</a></li>
                        <li class="tab"><a href="#order_2">Pending </a></li>
                     </ul>
                     <div id="order_1" class="col s12 active">
                        <?php 
                           $date = date('Y-m-d');
                           
                           
                           for ($i=0; $i <count($orders); $i++){
                           	  /*if($data2[$i]->date_of_processing == date('Y-m-d')){*/
                           ?>
                         <div class="wishlist-title s-title">
			                           <div class="row">
			                              <div class="col s1">
			                                 <td style="text-align:center;"><?php echo $i+1; ?></td>
			                              </div>
			                              <div class="col s5">
			                                 <h5><?php echo $orders[$i]->distributor_name; ?> ( <?php echo $orders[$i]->location; ?>)</h5>
			                              </div>
										  
										   <div class="col s3">
			                                 <h5><?php echo $orders[$i]->distributor; ?> </h5>
			                              </div>
			                              <div class="col s2" style="text-align: right;">
			                                 <button  class="button shadow btn_color order_id_pending" data-attr="<?php echo $orders[$i]->order_id; ?>">View</button>

			                              </div>
			                           </div>
			                        </div>
                        <?php 
                           }
                          /* }*/
                           ?>
                     </div>
                     <div id="order_2" class="col s12 ">
                        <?php 
                           $sr_no = 1;
                           for ($j=0; $j <count($pendingsorder); $j++){
                           /*if(strtoupper(trim($data2[$i]->delivery_status))!='DELIVERED'){*/
                           ?>
                        		 <div class="wishlist-title s-title">
			                           <div class="row">
			                              <div class="col s1">
			                                 <td style="text-align:center;"><?php echo $j+1; ?></td>
			                              </div>
			                              <div class="col s5">
			                                 <h5><?php echo $pendingsorder[$j]->distributor_name; ?> ( <?php echo $pendingsorder[$j]->location; ?>)</h5>
			                              </div>
										  
										   <div class="col s3">
			                                 <h5><?php echo $pendingsorder[$j]->distributor; ?> </h5>
			                              </div>
			                              <div class="col s2" style="text-align: right;">
			                                 <button    data-toggle="modal"  class="button shadow btn_color order_id_pending" data-attr="<?php echo $pendingsorder[$j]->order_id; ?>">View</button>
			                              </div>
			                           </div>
			                        </div>
                        <?php 
                           }
                        /*   }*/
                           ?>
                     </div>
                  </div>
               </div>
            </div>
			 <!-- <div class="fixed-action-btn click-to-toggle" style="top: 450px; right: 24px;">
               <a class="btn-floating  pink waves-effect waves-light" href="<?php //echo base_url() . 'index.php/Sales_rep_order/add'; ?>">
               <i class="large material-icons">add</i>
               </a>
            </div> -->
         </div>
      </main>
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close waves-effect waves-green btn-flat">&times;</button>
                  <h4 class="modal-title" style="font-size: 18px;">Check  Out? </h4>
               </div>
               <div class="modal-body">
                  <p>Do you want to checkout?</p>
               </div>
               <div class="modal-footer">
               	<form action="<?=base_url('index.php/Sales_Attendence/checkout')?>" method="POST" >
               	  <button type="button" style="background:#d43f3a!important"class="button shadow btn_color left modal-close" data-dismiss="modal">NO</button>
               	  <input type="hidden" name="checkout" value="Yes">
                  <button type="submit" style="background:#4cae4c!important" class="button shadow btn_color right" data-dismiss="modal">Yes</button>
               	</form>
               
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" id="myModal2" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close waves-effect waves-green btn-flat">&times;</button>
                  <h4 class="modal-title" style="font-size: 18px;">Change route? </h4>
               </div>
               <div class="modal-body">
                  <p>Do you want to change route?</p>
               </div>
               <div class="modal-footer">
                  <button type="button" style="background:#d43f3a!important"class="button shadow btn_color left modal-close" data-dismiss="modal">NO</button>
                  <button type="button" style="background:#4cae4c!important" class="button shadow btn_color right" data-dismiss="modal" onclick="set_beat_plan();">Yes</button>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" id="myModal3" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="<?=base_url('index.php/Dashboard_sales_rep/approve_beat_plan')?>" method="POST">
               <div class="modal-header">
                  <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close waves-effect waves-green btn-flat">&times;</button>
                  <h4 class="modal-title" style="font-size: 18px;">Approve Route Plan? </h4>
                  <input type="hidden" id="pending_beat_plan_cnt" name="pending_beat_plan_cnt" value="<?php echo count($pending_beat_plan); ?>" />
               </div>
               <div class="modal-body">
                  <table>
                     <thead>
					   <?php for($i=0; $i<count($pending_beat_plan); $i++) { ?>
					    
                        <tr>
                         
                           <td colspan="2"><b>Sales Representative</b> :- <?php echo $pending_beat_plan[$i]->sales_rep_name; ?></td>
                        </tr>
						 <tr>
						 <td><b>Old Distributor Beat Plan </b> </td>
						 <td><b>New Distributor Beat Plan</b></td>
						 </tr>
						 <tr>
						  <td><?php echo $pending_beat_plan[$i]->distributor_name1; ?> - <?php echo $pending_beat_plan[$i]->beat_name1; ?></td>
						  <td><?php echo $pending_beat_plan[$i]->distributor_name2; ?> - <?php echo $pending_beat_plan[$i]->beat_name2; ?></td>
						 </tr>
						 <tr>
							 <td colspan="2" style="text-align:center;">

								<label class="container">
								<input type="checkbox" name="pending_id[]" id="<?php echo $pending_beat_plan[$i]->id; ?>" value="<?php echo $pending_beat_plan[$i]->id; ?>" style="" >
									<span class="checkmark"></span>
								</label>
						    </td>
						
						 </tr>
						 
						 
						
						  <?php } ?>
                  
					 

                  </table>
               </div>
               <div class="modal-footer">
                  <br/>
                  <button type="button" style="background:#d43f3a!important;" class="button shadow btn_color left modal-close" data-dismiss="modal">Close</button>
                  <!-- <button type="submit" style="background:#4cae4c!important" class="button shadow btn_color right">Approve</button>
                  <button type="submit" style="background:#4cae4c!important" class="button shadow btn_color right">Reject</button> -->
                  <input type="submit" style="background:#4cae4c!important;" class="button shadow btn_color right" id="btn_approve" name="btn_approve" value="Approve" />
                  <input type="submit" style="background:#d43f3a!important; margin-right:10px;" class="button shadow btn_color right" id="btn_reject" name="btn_reject" value="Reject" />
               </div>
               </form>
            </div>
         </div>
      </div>

	   <div class="modal fade" id="myModal_order" role="dialog" style="top:120px!important;">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close11 waves-effect waves-green btn-flat">&times;</button>
                  <h4 class="modal-title" style="font-size: 18px;font-weight:bold"> Order Details</h4>
               </div>
               <div class="modal-body">
                  <br/>
                  <div class="" id="resultdiv">
                    
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="button shadow btn_color right modal-close11" data-dismiss="modal">Close</button>

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

      <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/validationengine/languages/jquery.validationEngine-en.js'></script>
      <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/validationengine/jquery.validationEngine.js'></script>
      <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/jquery-validation/jquery.validate.js'></script>
      
      <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>js/actions.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>

      <script type="text/javascript" src="<?php echo base_url().'js/jquery.cookie.js';?>"></script>

      <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
      <script src="<?php echo base_url(); ?>css/select2/js/select2.full.min.js"></script> 
      <script type="text/javascript">
         var BASE_URL="<?php echo base_url()?>";

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
      <script type="text/javascript">
         $(document).ready(function(){
            $("#order_tabs .tab a.active").css("border-bottom", "2px solid #6FA7E4");
            $("#order_tabs .tab").click(function(){
               $("#order_tabs .tab a.active").css("border-bottom", "none");
               $("#order_tabs .tab a").css("border-bottom", "none");
            });
         });

         $(document).ready(function(){
            $('.modal').modal();
            $('.modal-close11').click(function(){
               $('#myModal_order').hide();
            });

            $('.order_id_pending').click(function(){
               var order_id = $(this).attr('data-attr');

               $.ajax({
                  type: "POST",
                  url:'<?=base_url()?>index.php/Sales_rep_order/get_order_list_view',
                  data: {order_id:order_id},
                  dataType: 'html',
                  async: false,
                  success: function(response){
                     $('#resultdiv').html(response);
                     $('#myModal_order').show();
                  }
               });
            });

            $('.modal').modal({
               dismissible: true
            });

            $('#lbl_distributor_name').html($("#distributor_id option:selected").text());
            $('#lbl_beat_name').html($("#beat_id option:selected").text());

            var pending_beat_plan_cnt = $('#pending_beat_plan_cnt').val();
            if(pending_beat_plan_cnt=='') pending_beat_plan_cnt=0;
            if(isNaN(pending_beat_plan_cnt)) pending_beat_plan_cnt=0;

            console.log(pending_beat_plan_cnt);
            if(pending_beat_plan_cnt>0){
               get_pending_beat_plan();
            } else {
               $('#approve_route_plan').hide();
            }
         });

         var get_pending_beat_plan = function() {
            $('#myModal3').modal('open');
         }

         var get_beat_plan = function() {
            $.ajax({
               url:BASE_URL+'index.php/dashboard_sales_rep/get_beat_plan',
               method: 'post',
               data: {distributor_id: $('#distributor_id').val(), type_id: ''},
               dataType: 'json',
               async: false,
               success: function(response){
                  var beat_id_val = $('#beat_id').val();
                  $('#beat_id').find('option').not(':first').remove();

                  $.each(response,function(index,data){
                     $('#beat_id').append('<option value="'+data['id']+'" '+((data['id']==beat_id_val)?'selected':'')+'>'+data['beat_id']+' - '+data['beat_name']+'</option>');
                  });
              }
            });
         }

         var set_route_plan = function() {
            if($('#beat_id').val()!=$('#beat_id_og').val() || $('#lbl_beat_status').val()!='Approved'){
               $('#myModal2').modal('open');
            } else {
               window.location.href = BASE_URL+'index.php/Sales_rep_store_plan';
            }
         }

         var set_beat_plan = function() {
            $.ajax({
               url:BASE_URL+'index.php/dashboard_sales_rep/set_beat_plan',
               method: 'post',
               data: {reporting_manager_id: $('#reporting_manager_id').val(), distributor_id_og: $('#distributor_id_og').val(), beat_id_og: $('#beat_id_og').val(), distributor_id: $('#distributor_id').val(), beat_id: $('#beat_id').val()},
               dataType: 'json',
               async: false,
               success: function(response){
                  // console.log(response);
                  if(response=='1'){
                     window.location.href = BASE_URL+'index.php/Dashboard_sales_rep';
                  }
               }
            });
         }

         var change_plan = function() {
            $('#lbl_distributor_name').hide();
            $('#distributor_id').show();
            $('#lbl_beat_name').hide();
            $('#beat_id').show();
            $('#set_route_plan').show();
            $('#get_route_plan').hide();
            $('#lbl_beat_status').hide();
            $('#btn_change_plan').hide();
         }
      </script>
   </body>
</html>