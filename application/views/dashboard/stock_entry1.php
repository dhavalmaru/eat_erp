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
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->     
		
    </head>
    <body>								
      <!-- START PAGE CONTAINER -->
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/zone'; ?>" > Zone List </a>  &nbsp; &#10095; &nbsp; Zone Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="form_zone_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/zone/update/' . $data[0]->id; else echo base_url().'index.php/zone/save'; ?>">
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
								
								<div class="panel-body">
															
								
									
								
								<div class="form-group">
                           		<div class="col-md-12 col-sm-12 col-xs-12">

								 
								 
								<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date  <span class="asterisk_sign">*</span></label>

                                  
                                


									<div class="col-md-4 col-sm-4 col-xs-12" >
                                    <input type="hidden" class="form-control" name="place_order" id="place_order" value="Yes"/>
                                    <input type="hidden" name="sequence_count" id="sequence_count" value="<?php if(isset($sequence_count)) echo $sequence_count;?>"/>
                                    <input type="hidden" name="id" id="id" value="<?php if(isset($data[0]->id)) echo $data[0]->id;?>"/>
                                    <input type="hidden"  name="latitude" id="latitude" value="<?php if(isset($data[0]->latitude)) echo $data[0]->latitude;?>"/>
                                    <input type="hidden"  name="srld" id="srld" value="">
                                    <input type="hidden"  name="longitude" id="longitude" value="<?php if(isset($data[0]->longitude)) echo $data[0]->longitude;?>"/>
                                    <input type="hidden"  name="ispermenant" id="ispermenant" value=""/>
                                    <input type="hidden"  name="beat_plan_id" id="beat_plan_id" value="<?php if(isset($data[0]->bit_plan_id)) echo $data[0]->bit_plan_id;?>"/> 
                                    <input type="hidden"  name="mid" id="mid" value="<?php if(isset($data[0]->mid)) echo $data[0]->mid;?>"/> 
                                    <input type="hidden"  name="store_id" id="store_id" value="<?php if(isset($data[0]->store_id)) echo $data[0]->store_id;?>"/>
                                    <input type="hidden"  name="frequency" id="frequency" value="<?php if(isset($data[0]->frequency)) echo $data[0]->frequency;?>"/>
                                    <input type="hidden"  name="sequence" id="sequence" value="<?php if(isset($data[0]->sequence)) echo $data[0]->sequence;?>"/>
                                    <input type="hidden"  name="sales_rep_id" id="sales_rep_id" value="<?php if(isset($data[0]->sales_rep_id)) echo $data[0]->sales_rep_id;?>"/>
                                    <input type="hidden"  name="date_of_visit" id="date_of_visit" value="  <?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                    <input type="hidden"  name="sales_rep_loc_id" id="sales_rep_loc_id" value="<?php if(isset($data[0]->sales_rep_loc_id)) echo $data[0]->sales_rep_loc_id;?>"/>
                                    <input type="hidden"  name="distributor_status" id="distributor_status" value="<?php if(isset($data[0]->distributor_status)) echo $data[0]->distributor_status;?>"/>
                                    <input type="hidden"  name="merchandiser_stock_id" id="merchandiser_stock_id" value="<?php if(isset($data[0]->merchandiser_stock_id)) echo $data[0]->merchandiser_stock_id;?>"/>

                                    <input type="hidden"  name="follow_type" id="follow_type" value="<?php if(isset($follow_type)) echo $follow_type;?>"/>
                                    
                                    <?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group" id="channel_type_div">
								<div class="col-md-12 col-sm-12 col-xs-12">
                             
                                    	<label class="col-md-2 col-sm-2 col-xs-12 ">Channel<span class="asterisk_sign">*</span></label>

                                 <div class="col-md-4 col-sm-4 col-xs-12" >
                                    <select  name="channel_type" id="channel_type" onchange="getselectdiv(this)" class="form-control select2">
                                       <?php 
                                          if(isset($channel_type))
                                            {
                                             if ($channel_type=='GT'){
                                                echo '<option value="GT">GT</option>';
                                             }
                                             else if ($channel_type=='MT'){
                                                echo '<option value="MT">MT</option>';
                                             }
                                            }
                                            else{
                                          ?>
                                       <option value="GT" <?php 
                                          if($visit_detail!='')
                                          {
                                             if ($visit_detail['channel_type']=='GT') echo 'selected';
                                          }
                                          
                                          if(isset($channel_type))
                                          {
                                             if ($channel_type=='GT') echo 'selected';
                                          } 
                                          
                                          ?>>GT</option>
                                       <option value="MT"  <?php 
                                          if($visit_detail!='')
                                          {
                                             if ($visit_detail['channel_type']=='MT') echo 'selected';
                                          }
                                          
                                          if(isset($channel_type))
                                          {
                                             if ($channel_type=='MT') echo 'selected';
                                          }
                                          
                                          ?>>MT</option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group" id="dist_type">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                
<label class="col-md-2 col-sm-2 col-xs-12 ">Type
                                    <span class="asterisk_sign">*</span></label>
                               
                            	<div class="col-md-4 col-sm-4 col-xs-12" >
                                    <select class="form-control select2" name="distributor_type" id="distributor_type">
                                       <?php 
                                          if(isset($data[0]->distributor_type))
                                                {
                                                   if($data[0]->distributor_type=='Old')
                                                   {
                                                      echo '<option value="Old">Old</option>';
                                                   }
                                                   else
                                                   {
                                                      echo '<option value="New">New</option>';
                                                   }
                                                }
                                                else
                                                { ?>
                                       <option value="Old" 
                                          <?php 
                                                   /*if(isset($data[0]->distributor_type)) {
                                                      if ($data[0]->distributor_type=='Old') echo 'selected';}*/
                                                    if($visit_detail!='')
                                                    {
                                                      if ($visit_detail['distributor_types']=='Old') echo 'selected';
                                                    }
                                                   ?>>Old</option>
                                       <option value="New" <?php 
                                          /*if(isset($data)) {if ($data[0]->distributor_type=='New') echo 'selected';}*/
                                          if($visit_detail!='')
                                          {
                                             if ($visit_detail['distributor_types']=='New') echo 'selected';
                                          }
                                          ?>>New</option>
                                       <?php }
                                          ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group retailer_div" id="retailer_div">
                              <div class="col-md-12">
                                 
								 
								                                    
                                    <label  class="col-md-2 col-sm-2 col-xs-12 " id="s_type">Retailer <span class="asterisk_sign">*</span></label>
                                 
                                	<div class="col-md-4 col-sm-4 col-xs-12" >
                                    <!--store_id is a Retailer id-->
                                    <span class="distributor_field" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo ''; else echo 'display: none;';} ?>">
                                       <select name="distributor_id" id="distributor_id" class="form-control select2" style="<?php if(isset($data[0]->distributor_type)) {if($data[0]->distributor_type=='Old') echo ''; else echo 'display: none;';} ?>">
                                          <option value="">Select</option>
                                          <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                          <option value="<?php echo $distributor[$k]->id; ?>" <?php 
                                             if(isset($data[0]->store_id) && $data[0]->store_id!='') {
                                                if(isset($data[0]->store_id))
                                                {
                                                  if($distributor[$k]->id==$data[0]->store_id) {echo 'selected';}
                                                }
                                             }
                                             else if($visit_detail!=''){
                                             if ($visit_detail['distributor_id']==$distributor[$k]->id){ echo 'selected' ; }
                                             };
                                             
                                              ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                          <?php }} ?>
                                       </select>
                                    </span>
                                    <input type="text" class="" name="distributor_name" id="distributor_name" style="<?php 
                                       if(isset($data[0]->distributor_name)) {if($data[0]->distributor_type=='Old') echo 'display: none;';} else {echo 'display: none;';} ?>" 
                                       placeholder="Retailer Name" 
                                       value="<?php if(isset($data[0]->distributor_name )){
                                          echo $data[0]->distributor_name;
                                          }
                                          
                                          if($visit_detail!=''){
                                          if ($visit_detail['distributor_name']!='')echo $visit_detail['distributor_name'];
                                          }; 
                                          
                                          
                                          ?>"  <?=(isset($data[0]->distributor_status)?'readonly':'')?>/>
                                 </div>
                              </div>
                           </div>
                           <div class="zone" style="display:none">
                              <div class="form-group zone" >
                                 <div class="col-md-12 col-xs-12">
                                
                                       <label class="col-md-2 old_dist_details ">Zone <span class="asterisk_sign">*</span></label>

                                   	<div class="col-md-4 col-sm-4 col-xs-12" >
                                       <select name="zone_id" id="zone_id" class="form-control select2" onchange="get_area();">
                                          <option value="">Select</option>
                                          <?php
                                             if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                          <option value="<?php echo $zone[$k]->zone_id; ?>" <?php 
                                             if($visit_detail!=''){
                                             
                                             if ($visit_detail['zone_id']==$zone[$k]->zone_id){ echo 'selected' ; }
                                             }
                                             else if (isset($data)) { 
                                             
                                             
                                                if(isset($data[0]->zone_id))
                                                {
                                                  if($zone[$k]->zone_id==$data[0]->zone_id ) { echo 'selected'; } 
                                                }
                                             
                                                };
                                             
                                             ?>><?php echo $zone[$k]->zone; ?></option>
                                          <?php }} ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="relation_store" style="display:none">
                              <div class="form-group " >
                                 <div class="col-md-12 col-xs-12">

                                       <label class="col-md-2">Relation<span class="asterisk_sign">*</span></label>
                                   	<div class="col-md-4 col-sm-4 col-xs-12" >
                                       <select name="reation_id" id="reation_id" class="form-control select2" onchange="get_mt_location();">
                                          <option value="">Select</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="area" style="display:none">
                              <div class="form-group old_dist_details " >
                                 <div class="col-md-12">
                                  
                                 <label class="col-md-2 old_dist_details ">Area<span class="asterisk_sign">*</span></label>
                                   
                                  	<div class="col-md-4 col-sm-4 col-xs-12" >
                                       <select name="area_id" id="area_id"  class="form-control select2"  onchange="get_location();">
                                          <option value="">Select</option>
                                          <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                          <option value="<?php echo $area[$k]->area_id; ?>" <?php 
                                             if($visit_detail!=''){
                                             if ($visit_detail['area_id']==$area[$k]->area_id){ echo 'selected' ; }
                                             }
                                             else  if (isset($data)) { 
                                                   if(isset($data[0]->area_id))
                                                   {
                                                     if($area[$k]->area_id==$data[0]->area_id ) { echo 'selected'; } 
                                                   }
                                                };
                                             
                                             ?>><?php echo $area[$k]->area; ?></option>
                                          <?php }} ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="location" style="display:none">
                              <div class=" form-group old_dist_details location">
                                 <div class="col-md-12 ">

                                       <label class="col-md-2 old_dist_details ">Location <span class="asterisk_sign">*</span></label>
                                    
										<div class="col-md-4 col-sm-4 col-xs-12" >
                                       <select name="location_id" id="location_id" class="form-control select2">
                                          <option value="">Select</option>
                                          <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                          <option value="<?php echo $location[$k]->id; ?>" <?php 
                                             if($visit_detail!=''){
                                             if ($visit_detail['location_id']==$location[$k]->id){ echo 'selected' ; }
                                             }
                                             else if (isset($data)) 
                                                { 
                                                  if(isset($data[0]->location_id))
                                                  {
                                                   if($location[$k]->id==$data[0]->location_id  ) { echo 'selected'; }
                                                  }
                                                   
                                             
                                             };
                                             
                                             ?>><?php echo $location[$k]->location; ?></option>
                                          <?php }} ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div id="dist_old" style="display: none">
                              <div class="form-group">
                                 <div class="col-md-2" >
                                    <br>
                                   
                                       <label class="col-md-2">Channel <span class="asterisk_sign">*</span></label>

                                   
										<div class="col-md-4 col-sm-4 col-xs-12 channel_text" >
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="col-md-12">
                                    <br>
                                  
                                       <label class="col-md-2">Type <span class="asterisk_sign">*</span></label>
                                    
                                    <div class="col-md-4 col-sm-4 col-xs-12 type_text" >
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group" id="retailer_text">
                                 <div class="col-md-12" >
                                    <br>
                                  
                                       <label class="col-md-2">Retailer <span class="asterisk_sign">*</span></label>

                                    <div class="col-md-4 col-sm-4 col-xs-12 retailer_text" >
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="col-md-12" >
                                    <br>

                                       <label class="col-md-2">Zone <span class="asterisk_sign">*</span></label>
                                    
                                    <div class="col-md-4 col-sm-4 col-xs-12 zone_text" >
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group" id="area_text">
								<div class="col-md-12" >
                                    <br>
                                    
                                      <label class="col-md-2">Area <span class="asterisk_sign">*</span></label>
                                   
                                    <div class="col-md-4 col-sm-4 col-xs-12 area_text">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group" id="relation_text">
                                  <div class="col-md-12" >
                                    <br>
                                   
                                       <label class="col-md-2"> Relation <span class="asterisk_sign">*</span></label>
                                   
                                    <div class="col-md-4 col-sm-4 col-xs-12 relation_text">
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="col-md-12" >
                                    <br>
                                  
                                       <label class="col-md-2"> Location <span class="asterisk_sign">*</span></label>
                                    
                                    <div class="col-md-4 col-sm-4 col-xs-12 location_text">
                                    </div>
                                 </div>
                                 <br>
                              </div>
                           </div>
                           <?php
                              /*if(isset($data[0]->id))
                              {
                                 if($data[0]->id!='')
                                    $style='display:block';
                                 else
                                    $style='display:none';
                              }
                              else
                              {
                                 $style='display:none';  
                              }*/
                              ?>


                           <div class="container" id="stock_entry"  >
                              <br>
                              <div class="row">
                                 <div class="panel-body  panel-group accordion">
                                                                                           
                                                      <div class="panel panel-primary" id="">
															<a href="#section1">  
                                                                                     <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Bars
																											
                                                                                                        </h4>
																										
                                                                                     </div>  
															</a>                     
                                                                           
								 
								 
								 
											<div class="panel-body  panel-body-open" id="section1">
                                          <div class="">
                                             <div class="app-title">
                                                <h5>Available Quantities</h5>
                                             </div>
                                             <hr>
                                             <div class="form-group">
                                                <div class="col-md-12">

                                                      <label class="col-md-2">Orange<span class="asterisk_sign">*</span></label>
                                                  
                                                   <div class="col-md-3">
                                                      <input type="number"   value="<?php
                                                         if(isset($stock_detail['orange']))
                                                         {
                                                            if($stock_detail['orange']!=NULL)
                                                            {
                                                               $ex = explode('_',$stock_detail['orange']);
                                                               echo $ex[0];
                                                            }
                                                         } 
                                                         ?>" 
                                                         class="form-control qty" name="orange_bar" placeholder="0" id="type_0" onblur="qty_change(this)"/>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type" value="Bar" id="bar_o" onchange="" onclick="set_radio_button(0,this)" 
                                                            <?php 
                                                               if(isset($ex))
                                                               {
                                                                  if($ex[1]=='Bar')
                                                                     echo 'checked';
                                                               }
                                                               ?>
                                                            >
                                                         <label for="bar_o" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type" value="Box" id="bar_o1" onchange="" onclick="set_radio_button(0,this)"  
                                                            <?php 
                                                               if(isset($ex))
                                                               {
                                                                  if($ex[1]=='Box')
                                                                     echo 'checked';
                                                               }
                                                               else
                                                                   echo 'checked';
                                                               ?>
                                                            >
                                                         <label for="bar_o1" class="">Box</label>
                                                         <span class=""></span>
                                                      </div>
                                                      <input type="hidden" name="type_0" id="type_id_0" class="type" 
                                                         value="<?=(isset($ex)?$ex[1]:'Box')?>">
                                                   </div>
                                                </div>
                                                </div>
											 <div class="form-group">
                                                <div class="col-md-12">
   
												<label class="col-md-2"> Butterscotch<span class="asterisk_sign">*</span></label>
												     <div class="col-md-3">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['butterscotch']))
                                                         {
                                                            if($stock_detail['butterscotch']!=NULL)
                                                            {
                                                               $ex1 = explode('_',$stock_detail['butterscotch']);
                                                               echo $ex1[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="butterscotch_bar" placeholder="0" id="type_1"
                                                        
                                                         />  
														</div>
                                                   <div class="col-md-3">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type1" value="Bar" id="box_bs" onclick="set_radio_button(1,this)" <?php 
                                                               if(isset($ex1))
                                                               {
                                                                  if($ex1[1]=='Bar')
                                                                     echo 'checked';
                                                               }
                                                               ?>>
                                                         <label for="box_bs"  
                                                            >Bar</label>
                                                         <input type="radio" class="" name="bar_type1" value="Box" id="box_bs1" onclick="set_radio_button(1,this)"
                                                            <?php 
                                                               if(isset($ex1))
                                                               {
                                                                  if($ex1[1]=='Box')
                                                                     echo 'checked';
                                                               }
                                                               else
                                                                   echo 'checked';
                                                               ?>>
                                                         <label for="box_bs1" class="">Box</label> 
                                                         <span class=""></span>
                                                      </div>
                                                      <input type="hidden" name="type_1" id="type_id_1" class="type" value="<?=(isset($ex1)?$ex1[1]:'Box')?>">
                                                   </div>
                                                </div>
                                                </div>
												 <div class="form-group">
                                                <div class="col-md-12">
                                                
                                                      <label class="col-md-2">Choco<span class="asterisk_sign">*</span></label>
                                                 
                                                   <div class="col-md-3">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['chocopeanut']))
                                                         {
                                                            if($stock_detail['chocopeanut']!=NULL)
                                                            {
                                                               $ex2 = explode('_',$stock_detail['chocopeanut']);
                                                               echo $ex2[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="chocopeanut_bar" placeholder="0" id="type_3"/>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type3" value="Bar" id="bar_co" onclick="set_radio_button(3,this)" <?php 
                                                            if(isset($ex2))
                                                            {
                                                               if($ex2[1]=='Bar')
                                                                  echo 'checked';
                                                            }
                                                            ?>>
                                                         <label for="bar_co" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type3" value="Box" id="box_co3" onclick="set_radio_button(3,this)" <?php 
                                                            if(isset($ex2))
                                                            {
                                                               if($ex2[1]=='Box')
                                                                  echo 'checked';
                                                            }
                                                            else
                                                               echo 'checked';
                                                            ?>>
                                                         <label for="box_co3" class="">Box</label>
                                                         <span class=""></span>
                                                      </div>
                                                      <input type="hidden" name="type_3" id="type_id_3" class="type" value="<?=(isset($ex2)?$ex2[1]:'Box')?>">
                                                   </div>
                                                </div>
                                                </div>
												 <div class="form-group">
                                                <div class="col-md-12">
                                                   
                                                      <label class="col-md-2">Chaat<span class="asterisk_sign">*</span></label>

                                                   <div class="col-md-3">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['bambaiyachaat']))
                                                         {
                                                            if($stock_detail['bambaiyachaat']!=NULL)
                                                            {
                                                               $ex3 = explode('_',$stock_detail['bambaiyachaat']);
                                                               echo $ex3[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="bambaiyachaat_bar" placeholder="0" id="type_4"/>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type4" value="Bar" id="bar_ch" onclick="set_radio_button(4,this)"   <?php if(isset($ex3))
                                                            {
                                                               if($ex3[1]=='Bar')
                                                                  echo 'checked';
                                                            }
                                                            ?>>
                                                         <label for="bar_ch" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type4" value="Box" id="box_ch1" onclick="set_radio_button(4,this)" <?php if(isset($ex3))
                                                            {
                                                               if($ex3[1]=='Box')
                                                                  echo 'checked';
                                                            }
                                                            else
                                                               echo 'checked';
                                                            ?>>
                                                         <label for="box_ch1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_4" id="type_id_4" class="type" value="<?=(isset($ex3)?$ex3[1]:'Box')?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                </div>
												 <div class="form-group">
                                                <div class="col-md-12">

                                                      <label class="col-md-2">Mango<span class="asterisk_sign">*</span></label>
                                                  
                                                   <div class="col-md-3">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['mangoginger']))
                                                         {
                                                            if($stock_detail['mangoginger']!=NULL)
                                                            {
                                                               $ex4 = explode('_',$stock_detail['mangoginger']);
                                                               echo $ex4[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="mangoginger_bar" placeholder="0"
                                                         id="type_5"/>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type5" value="Bar" id="bar_m" onclick="set_radio_button(5,this)" <?php if(isset($ex4))
                                                            {
                                                               if($ex4[1]=='Bar')
                                                                  echo 'checked';
                                                            }
                                                            ?>>
                                                         <label for="bar_m" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type5" value="Box" id="bar_m1" onclick="set_radio_button(5,this)" <?php if(isset($ex4))
                                                            {
                                                               if($ex4[1]=='Box')
                                                                  echo 'checked';
                                                            }
                                                             else
                                                               echo 'checked';
                                                            ?>>
                                                         <label for="bar_m1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_5" id="type_id_5" value="<?=(isset($ex4)?$ex4[1]:'Box')?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                </div>
												 <div class="form-group">
                                                <div class="col-md-12">

                                                      <label class="col-md-2">Berry<span class="asterisk_sign">*</span></label>
                                                   
                                                   <div class="col-md-3">
                                                      <input type="number" value="<?php if(isset($stock_detail['berry_blast']))
                                                         {
                                                            if($stock_detail['berry_blast']!=NULL)
                                                            {
                                                               $ex5 = explode('_',$stock_detail['berry_blast']);
                                                               echo $ex5[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="berry_blast_bar" placeholder="0" id="type_6"/>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type6" value="Bar" id="bar_bb" onclick="set_radio_button(6,this)" 
                                                            <?php 
                                                               if(isset($ex5))
                                                                  {
                                                                     if($ex5[1]=='Bar')
                                                                        echo 'checked';
                                                                  }
                                                               ?>
                                                            >
                                                         <label for="bar_bb" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type6" value="Box" id="box_bb1" onclick="set_radio_button(6,this)" <?php 
                                                            if(isset($ex5))
                                                               {
                                                                  if($ex5[1]=='Box')
                                                                     echo 'checked';
                                                               }
                                                               else
                                                                  echo 'checked';
                                                            ?>>
                                                         <label for="box_bb1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_6" id="type_id_6" class="type" value="<?=(isset($ex5)?$ex5[1]:'Box')?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                </div>
												 <div class="form-group">
                                                <div class="col-md-12">
                                                 
                                                      <label class="col-md-2">Chywanprash<span class="asterisk_sign">*</span></label>
                                                   
                                                   <div class="col-md-3">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['chyawanprash']))
                                                         {
                                                            if($stock_detail['chyawanprash']!=NULL)
                                                            {
                                                               $ex6 = explode('_',$stock_detail['chyawanprash']);
                                                               echo $ex6[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="chyawanprash_bar" placeholder="0"
                                                         id="type_7"/>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type7" value="Bar" id="bar_chw" onclick="set_radio_button(7,this)" 
                                                            <?php 
                                                               if(isset($ex6))
                                                                  {
                                                                     if($ex6[1]=='Bar')
                                                                        echo 'checked';
                                                                  }
                                                               
                                                               ?>
                                                            >
                                                         <label for="bar_chw" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type7" value="Box" id="box_chw1" onclick="set_radio_button(7,this)" <?php 
                                                            if(isset($ex6))
                                                               {
                                                                  if($ex6[1]=='Box')
                                                                     echo 'checked';
                                                               }
                                                               else
                                                                  echo 'checked';
                                                            ?>>
                                                         <label for="box_chw1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_7" id="type_id_7" class="type" value="<?=(isset($ex6)?$ex6[1]:'Box')?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                </div>
												 <div class="form-group">
                                                <div class="col-md-12">

                                                      <label class="col-md-2">Variety Box<span class="asterisk_sign">*</span></label>
                                                  
                                                   <div class="col-md-3">
                                                      <input type="number" value="<?php if(isset($stock_detail['variety_box']))
                                                         {
                                                            if($stock_detail['variety_box']!=NULL)
                                                            {
                                                               $ex7 = explode('_',$stock_detail['variety_box']);
                                                               echo $ex7[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="variety_box" placeholder="0" id="type_8" />
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type8" value="Box" id="variety_box1" onclick="set_radio_button(7,this)"  checked>
                                                         <label for="box_ch1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_id_8" id="type_id_8" class="type" value="Box">
                                                      </div>
                                                   </div>
                                                  
                                                </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       </div>
									   
									   
									   

													<div class="panel panel-primary" id="">
															<a href="#section2">  
                                                                                     <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Cookies
																											
                                                                                                        </h4>
																										
                                                                                     </div>  
															</a>                     
                                                                           
								 
								 
								 
											<div class="panel-body  panel-body" id="section2">
                                   
                                    
                                          <div class="app-title">
                                             <h5>Available Quantities</h5>
                                          </div>
                                          <hr>
											<div class="form-group">
										  
                                             <div class="col-md-12">
                                                
                                                   <label class="col-md-2">Chocolate <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4">
                                                   <input type="number" value="<?php if(isset($stock_detail['chocolate_cookies_box']))
                                                         {
                                                            if($stock_detail['chocolate_cookies_box']!=NULL)
                                                            {
                                                               $ex6 = explode('_',$stock_detail['chocolate_cookies_box']);
                                                               echo trim($ex6[0]);
                                                            }
                                                         } 
                                                  ?>" class="form-control" name="chocolate_cookies" placeholder="0"/>
                                                </div>
                                             </div>
                                             </div>
											  <div class="form-group">
                                             <div class="col-md-12">
                                             
                                                   <label class="col-md-2"> Dark Chocolate <span class="asterisk_sign">*</span></label>
                                              
                                                <div class="col-md-4">
                                                   <input type="number" value="<?php if(isset($stock_detail['dark_chocolate_cookies_box']))
                                                         {
                                                            if($stock_detail['dark_chocolate_cookies_box']!=NULL)
                                                            {
                                                               $ex10 = explode('_',$stock_detail['dark_chocolate_cookies_box']);
                                                               echo trim($ex10[0]);
                                                            }
                                                         } 
                                                  ?>" class="form-control" name="dark_chocolate_cookies" placeholder="0"/>
                                                </div>
                                             </div>
                                             </div>
											  <div class="form-group">
                                             <div class="col-md-12">
                                                <div class="col-md-2">
                                                   <label class="">Cranberry <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="col-md-4">
                                                   <input type="number" value="<?php  if(isset($stock_detail['cranberry_cookies_box']))
                                                         {
                                                            if($stock_detail['cranberry_cookies_box']!=NULL)
                                                            {
                                                               $ex11 = explode('_',$stock_detail['cranberry_cookies_box']);
                                                               echo trim($ex11[0]);
                                                            }
                                                         } 
                                                  ?>" class="form-control" name="cranberry_cookies" placeholder="0"/>
                                                </div>
                                             </div>
                                             </div>
                                          </div>
                                          </div>
                                    			<div class="panel panel-primary" id="">
															<a href="#section3">  
                                                                                     <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    TrailMix
																											
                                                                                                        </h4>
																										
                                                                                     </div>  
															</a>                     
                                                                           
								 
								 
								 
											<div class="panel-body  panel-body" id="section3">
                                   
                                    <div class="app-title">
                                    <h5>Available Quantities</h5>
                                    </div>
                                    <hr>  
										<div class="form-group">
                                    <div class="col-md-12">
                                  
                                    <label class="col-md-2">Cranberry & Orange  <span class="asterisk_sign">*</span></label>

                                    <div class="col-md-4">
                                    <input type="number" value="<?php  if(isset($stock_detail['cranberry_orange_box']))
                                          {
                                             if($stock_detail['cranberry_orange_box']!=NULL)
                                             {
                                                $ex12 = explode('_',$stock_detail['cranberry_orange_box']);
                                                echo trim($ex12[0]);
                                             }
                                          } 
                                   ?>" class="form-control" name="cranberry_orange_zest" placeholder="0"/>
                                    </div>
                                    </div>
                                    </div>
									 <div class="form-group">
                                    <div class="col-md-12">
                                   
                                    <label class="col-md-2">Fig & Raisins <span class="asterisk_sign">*</span></label>
                                  
                                    <div class="col-md-4">
                                    <input type="number" value="<?php if(isset($stock_detail['fig_raisins_box']))
                                          {
                                             if($stock_detail['fig_raisins_box']!=NULL)
                                             {
                                                $ex13 = explode('_',$stock_detail['fig_raisins_box']);
                                                echo trim($ex13[0]);
                                             }
                                          } 
                                   ?>" class="form-control" name="fig_raisins" placeholder="0"/>
                                    </div>
                                    </div>
                                    </div>
									 <div class="form-group">
                                    <div class="col-md-12">

                                    <label class="col-md-2">Papaya & pineapple<span class="asterisk_sign">*</span></label>

                                    <div class="col-md-4">
                                    <input type="number" value="<?php if(isset($stock_detail['papaya_pineapple_box']))
                                          {
                                             if($stock_detail['papaya_pineapple_box']!=NULL)
                                             {
                                                $ex14 = explode('_',$stock_detail['papaya_pineapple_box']);
                                                echo trim($ex14[0]);
                                             }
                                          } 
                                   ?>" class="form-control" name="papaya_pineapple" placeholder="0"/>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>

                                 
                                 </div>
                                 </div>
								    <div class="form-group">
                                    <div class="col-md-12">
                                       <div class="col-md-2">
                                          <label>Remarks <span class="asterisk_sign"></span></label>
                                       </div>
                                       <div class="col-md-8">
                                          <!--store_id is a Retailer id-->
                                          <textarea id="textarea1" class="form-control" name="remarks" id="remarks" value="
                                          <?php 
                                          if(isset($data[0]->remarks)) echo $data[0]->remarks;
                                             if($visit_detail!='')
                                                {
                                                   if ($visit_detail['remarks']!='')
                                                   { 
                                                      echo $visit_detail['remarks']; 
                                                   }
                                                }
                                             ?>"><?php 
                                                if(isset($data[0]->remarks)) echo $data[0]->remarks;
                                                if($visit_detail!='')
                                                {
                                                   if ($visit_detail['remarks']!='')
                                                   { 
                                                      echo ltrim($visit_detail['remarks']); 
                                                   }
                                                }
                                             ?></textarea>
                                       </div>
                                    </div>
                                 </div>
                                
						
								
                                </div>
								<br clear="all"/>
								</div>
								</div>
								
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/zone" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
							</form>
                    </div>
                    
                   </div>
                <!-- END PAGE CONTENT WRAPPER -->
               </div>            
            <!-- END PAGE CONTENT -->
            </div>
        <!-- END PAGE CONTAINER -->
	   </div>	
</div>	   
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

    <!-- END SCRIPTS -->      
    </body>
</html>