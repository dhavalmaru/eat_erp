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
               <a class="btn-floating  pink waves-effect waves-light" href="<?php echo base_url() . 'index.php/Sales_rep_order/add'; ?>">
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
        <script type="text/javascript">
        $(document).ready(function(){
			 $("#order_tabs .tab a.active").css("border-bottom", "2px solid #6FA7E4");
			$("#order_tabs .tab").click(function(){
				 $("#order_tabs .tab a.active").css("border-bottom", "none");
				 $("#order_tabs .tab a").css("border-bottom", "none");
				});
          
          });
        </script>
     	 <script>
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

				 });
      </script>