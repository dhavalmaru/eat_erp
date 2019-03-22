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
         .tabs .tab
         {
         line-height: 20px;
         }
         .tabs .tab a:hover, .tabs .tab a.active
         {
         color: #ffffff!important;
         }
         .tabs a 
         {
         color: #ffffff!important;
         }
         .tabs .indicator
         {
         background-color:#ffffff!important; 
         }
         .tabs
         {
         height:auto!important;
         background-color: #1861b1;
         }
         .beat_plan h4
         {
         font-size:12px!important;	
         display: inline;	
         }
         .app-pages {
         margin-top: 100px;
         }
         .tabs .tab {
         padding: 0px!important;
         }
         .wishlist .entry .s-title
         {
         padding-top:0px;
         padding-bottom:0px;
         }
         .row
         {
         margin-bottom: 7px;
         margin-top: 7px;
         }
         .button
         {
         font-size:10px;
         }
         .visits{margin-top:15px;!important}
         .date
         {
         font-size:12px!important;
         margin-top: 0px;
         }
      </style>
   <body>
      <!-- START PAGE CONTAINER -->
      <div id="loading"></div>
      <div class="navbar">
         <?php $this->load->view('templates/header2');?>
         <ul class="tabs">
            <?php 
            	$explode =  explode(" ",$checkstatus);
              	$checkstatus  = $explode[1];
                $mon = date('d', strtotime('Monday this week'));
                $tue = date('d', strtotime('Tuesday this week'));
                $wed = date('d', strtotime('Wednesday this week'));
                $thu = date('d', strtotime('Thursday this week'));
                $fri = date('d', strtotime('Friday this week'));
                $sat = date('d', strtotime('Saturday this week'));
               
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
      </div>
      <?php $this->load->view('templates/menu2');?>
      <div class="wishlist app-section app-pages" style="<?php if(count($gt_followup)==0) echo "margin-top:50px;"; else echo "";  ?>">
         <div class="container" style="<?php if(count($gt_followup)==0) echo "display:none;"; else echo "display:block;";  ?>">
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
         </div>
      </div>
      <div class="wishlist app-section app-pages <?php if(count($gt_followup)==0) echo ""; else echo "visits";  ?>" style="<?php if(count($data)==0) echo "margin-top:25px;"; else echo "";  ?>">
         <div class="container">
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
                           <h4><?php //echo $data[$i]->sequence;?><?php echo $i+1; ?></h4>
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
                              	$url =  base_url().'index.php/Sales_rep_store_plan/add/'.$data[$i]->bit_plan_id.'/'.$checkstatus.'/GT';
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
                           <a href="<?php echo base_url().'index.php/Sales_rep_store_plan/edit/'.$data[$i]->bit_plan_id.'/'.$checkstatus.'/GT';?>" class="button shadow orange  lighten-1">Edit</a>
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
         </div>
      </div>
      <div class="wishlist app-section app-pages visits">
         <div class="container" style="<?php if(count($mt_followup)==0) echo "display:none;"; else echo "display:block;";  ?>">
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
                           <h5><?php echo $mt_followup[$i]->relation.' - ( '.$mt_followup[$i]->location.' )'; ?></h5>
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
         </div>
      </div>
      <div class="wishlist app-section app-pages visits">
         <div class="container" style="<?php if(count($merchendizer)==0) echo "display:none;"; else echo "display:block;";  ?>">
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
                              	$url = base_url().'index.php/Sales_rep_store_plan/add/'.$data[$i]->bit_plan_id.'/'.$checkstatus.'/MT';
                              ?>
                           <a href="<?=($checkstatus==$current_day)?$url:'javascript:void(0)'?>" class="button shadow orange  lighten-1" <>Check In</a>
                           <?php
                              }
                              
                              	else
                              {
                              	
                                 if($data[$i]->bit_plan_id!=0)
                                    {
                                       
                                       $url = base_url().'index.php/Sales_rep_store_plan/edit/'.$data[$i]->bit_plan_id.'/'.$checkstatus.'/MT';
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
      <!-- PAGE CONTENT WRAPPER -->
      <div class="fixed-action-btn click-to-toggle" style="bottom: 45px; right: 24px;">
         <a class="btn-floating  pink waves-effect waves-light" href="<?php echo base_url() . 'index.php/Sales_rep_store_plan/add'; ?>">
         <i class="large material-icons">add</i>
         </a>
      </div>
      <!-- END PAGE CONTENT -->
      </div>
      <!-- END PAGE CONTAINER -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/fakeLoader.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/loading.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/slick.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/owl.carousel.min.js"></script>
      <script src="<?php echo base_url(); ?>sales_rep/js/custom.js"></script>
      <script>
         $('ul.tab').tabs({
         	swipeable: true,
         	responsiveThreshold: Infinity,
         	});
      </script>
      <!-- END SCRIPTS -->      
   </body>
</html>