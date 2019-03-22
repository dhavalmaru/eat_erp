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
      <style>
	  .panel span
	  {
		  margin-bottom:0px!important;
	  }
	  h5
	  {
		  padding-left: 5px!important;
	  }
	  .select2-container
	  {
		  width:100%!important;
		  display:block!important;
	  }
      
      </style>
   <body>
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/zone'; ?>" > Stock List </a>  &nbsp; &#10095; &nbsp; Stock Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                           <?php
                              $visit_detail = '';
                              if($this->session->userdata('visit_detail')!=null)
                              {
                                 $visit_detail = $this->session->userdata('visit_detail');
                              
                                 /*echo "<pre>";
                                      print_r($data);
                                   echo "</pre>";*/
                              }
                              
                              ?>
                      
                        <?php 
                           if(isset($data[0]->id))
                              $id = $data[0]->id;
                           else
                              $id = '';
                           ?>
                       
						
					
                        <form id="form_sales_rep_location_details" role="form"   class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/Sales_rep_store_plan/save_stock/'; else echo base_url().'index.php/Sales_rep_store_plan/save_stock'; ?>" >
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
                                    <input type="text" class="datepicker form-control"  name="date_of_visit" id="date_of_visit" value="  <?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                    <input type="hidden"  name="sales_rep_loc_id" id="sales_rep_loc_id" value="<?php if(isset($data[0]->sales_rep_loc_id)) echo $data[0]->sales_rep_loc_id;?>"/>
                                    <input type="hidden"  name="distributor_status" id="distributor_status" value="<?php if(isset($data[0]->distributor_status)) echo $data[0]->distributor_status;?>"/>
                                    <input type="hidden"  name="merchandiser_stock_id" id="merchandiser_stock_id" value="<?php if(isset($data[0]->merchandiser_stock_id)) echo $data[0]->merchandiser_stock_id;?>"/>

                                    <input type="hidden"  name="follow_type" id="follow_type" value="<?php if(isset($follow_type)) echo $follow_type;?>"/>
                                    
                                    <?php /*if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y');*/ ?>
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
                                      <!-- <option value="New" <?php 
                                          /*if(isset($data)) {if ($data[0]->distributor_type=='New') echo 'selected
                                          if($visit_detail!='')
                                          {
                                             if ($visit_detail['distributor_types']=='New') echo 'selected';
                                          ';}*/
                                          ?>>New</option>-->
                                       <?php }
                                          ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
						   
						    <div class="salesrep">
                             <div class="form-group " >
                                <div class="col-md-12 col-xs-12">
                               
                                      <label class="col-md-2  ">Sales Representative <span class="asterisk_sign">*</span></label>

                                   <div class="col-md-4 col-sm-4 col-xs-12" >
                                       <select class="form-control select2" name="salesrep_id" id="salesrep_id">
                                           <?php if(isset($salesrep)){
                                               foreach($salesrep as $row){
                                                     echo '<option value="'.$row->id.'" >'.$row->sales_rep_name.'</option>';                                                          
                                               }
                                            } 
                                         ?>
                                      </select>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="merchendiser" style="display: none">
                             <div class="form-group zone" >
                                <div class="col-md-12 col-xs-12">
                                      <label class="col-md-2  ">Merchendiser <span class="asterisk_sign">*</span></label>
                                   <div class="col-md-4 col-sm-4 col-xs-12" >
                                       <select class="form-control select2" name="merchendizer_id" id="merchendizer_id">
                                           <?php if(isset($merchandizer)){
                                               foreach($merchandizer as $row){
                                                   echo '<option value="'.$row->id.'" >'.$row->sales_rep_name.'</option>';                                                         
                                               }
                                             } 
                                         ?>
                                        </select>
                                   </div>
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
                                    <input type="text" class="form-control" name="distributor_name" id="distributor_name" style="<?php 
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


                           <div class="" id="stock_entry"  >
                              
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
                                     
									   
									   
									   

													<div class="panel panel-primary" id="">
															<a href="#section2">  
                                                                                     <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Cookies
																											
                                                                                                        </h4>
																										
                                                                                     </div>  
															</a>                     
                                                                           
								 
								 
								 
											<div class="panel-body " id="section2">
                                   
                                    
                                          <div class="app-title">
                                             <h5>Available Quantities</h5>
                                          </div>
                                         
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
                                                                           
								 
								 
								 
											<div class="panel-body" id="section3">
                                   
                                    <div class="app-title">
                                    <h5>Available Quantities</h5>
                                    </div>
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
                              




								<div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan/add_stock" class="btn btn-danger"  type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="">Save</button>
                                </div>
                              <!-- Modal -->

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
      <div id="confirm_content" style="display:none">
         <div class="logout-containerr">
            <button type="button" class="close" data-confirmmodal-but="close">×</button>
            <div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Route Sequence? </div>
            <div class="confirmModal_content">
               <p>Are You want this route permenant??</p>
            </div>
            <div class="confirmModal_footer">
               <!-- <a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a> -->
               <button type="button" class="btn " data-confirmmodal-but="ok">Yes</button>
               <button type="button" class="btn " data-confirmmodal-but="cancel">No</button>
            </div>
         </div>
      </div>
      <div id="confirm_content2" style="display:none">
         <div class="logout-containerr">
            <button type="button" class="close" data-confirmmodal-but="close">×</button>
            <div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Place Order? </div>
            <div class="confirmModal_content">
               <p>Do you want to place order?</p>
            </div>
            <div class="confirmModal_footer">
               <!-- <a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a> -->
               <button type="button" class="btn " data-confirmmodal-but="ok">Yes</button>
               <button type="button" class="btn " data-confirmmodal-but="close">No</button>
            </div>
         </div>
      </div>
      <?php $this->load->view('templates/footer');?>
      <script type="text/javascript">
         var BASE_URL="<?php echo base_url()?>";
      </script>
      <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
      <!-- <script src="<?php echo base_url(); ?>sales_rep/js/loading.js"></script> -->
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
         // document.getElementById("Saver").disabled = false;
         // document.getElementById("followup_anc").style.display = "block";
         // document.getElementById("pl_ord").disabled = false;
         
         }, function(error) {
         clearTimeout(location_timeout);
         geolocFail();
         });
         
         }
         else {
         geolocFail();
         //document.getElementById("Saver").disabled = true;
         //document.getElementById("followup_anc").disabled = true;
         //document.getElementById("pl_ord").style.display = "none";
         
         
         }
         
             // get_closing_stock();
             distributor_type_change();
         });
         
         function geolocFail() {
         alert("Please switch on GPS!!!");
         // document.getElementById("Saver").disabled = true;
         // document.getElementById("followup_anc").disabled = true;
         // document.getElementById("pl_ord").disabled = true;
         }
         
         $('#distributor_type').change(function(){
             distributor_type_change();
         });
         
         $('#distributor_id').change(function(){
             $('#distributor_name').val($('#distributor_id option:selected').text());

             var distributor_id = $('#distributor_id').val();
               if(distributor_id.indexOf('_')!=false){
                  distributor_id = distributor_id.substr(distributor_id.indexOf('_')+1);
               }
               // console.log(distributor_id);

             $.ajax({
                     url:'<?=base_url()?>index.php/Sales_rep_location/get_distributor_details',
                     method: 'post',
                     data: {distributor_id: distributor_id},
                     dataType: 'json',
                     async: false,
                     success: function(response){
                        // console.log(response);
                        if(response.length>0){
                           $('#zone_id').val(response[0].zone_id);
                           get_area();
                           $('#area_id').val(response[0].area_id);
                           get_location();
                           $('#location_id').val(response[0].location_id);
                        }
                        
                     }
             });
         });
         
         function distributor_type_change() {
         
             if($('#distributor_type').val()=="Old"){
                 $('#distributor_id').show();
                $('.distributor_field').show();
                 $('#distributor_name').hide();
                 $('.ava_qty').show();
                 $('.disstatus').hide();
                  $('#stock_entry').show();
         
                 /*$('.old_dist_details').hide();*/
             } else {
                 $('#distributor_id').hide();
                 $('.distributor_field').hide();
                 $('#distributor_name').show();
                 $('.ava_qty').hide();
                 $('.disstatus').hide();
                 $('#stock_entry').hide();
                 /*$('.old_dist_details').show();*/
             }
         }
         
         $('#btn_save').click(function(){
             $('#myModal').modal('toggle');
             blFlag = true;
         });
         
         var get_area = function(){
             var zone_id = $('#zone_id').val();
         
             $.ajax({
                     url:'<?=base_url()?>index.php/Sales_rep_location/get_area',
                     method: 'post',
                     data: {zone_id: zone_id},
                     dataType: 'html',
                     async: false,
                     success: function(response){
                         $('#area_id').html(response);
                     }
             });
         
             get_location();
         }
         
         var get_location = function(){
             var zone_id = $('#zone_id').val();
             var area_id = $('#area_id').val();
             var location_id = $('#location_id').val();
             $.ajax({
                     url:'<?=base_url()?>index.php/Sales_rep_location/get_locations',
                     method: 'post',
                     data: {zone_id: zone_id, area_id: area_id},
                     dataType: 'html',
                     async: false,
                     success: function(response){
                         $('#location_id').html(response);
                         $('#location_id').val(location_id);
                     }
             });
         }
         
         var get_closing_stock = function(){
             var distributor_id = $('#distributor_id').val();
             var date_of_visit = $('#date_of_visit').val();
             
             $.ajax({
                 url:BASE_URL+'index.php/Sales_rep_location/get_closing_stock',
                 method:"post",
                 data:{distributor_id:distributor_id, date_of_visit:date_of_visit},
                 dataType:"json",
                 async:false,
                 success: function(data){
                     if(data.result==1){
                         // $('#orange_bar_closing').val(data.orange_bar);
                         // $('#mint_bar_closing').val(data.mint_bar);
                         // $('#butterscotch_bar_closing').val(data.butterscotch_bar);
                         // $('#chocopeanut_bar_closing').val(data.chocopeanut_bar);
                         // $('#bambaiyachaat_bar_closing').val(data.bambaiyachaat_bar);
                         // $('#mangoginger_bar_closing').val(data.mangoginger_bar);
         
                         $('#zone_id').html(data.zone);
                         $('#area_id').html(data.area);
                         $('#location_id').html(data.location);
                     } else {
                         // $('#orange_bar_closing').val('');
                         // $('#mint_bar_closing').val('');
                         // $('#butterscotch_bar_closing').val('');
                         // $('#chocopeanut_bar_closing').val('');
                         // $('#bambaiyachaat_bar_closing').val('');
                         // $('#mangoginger_bar_closing').val('');
         
                         $('#zone_id').html('');
                         $('#area_id').html('');
                         $('#location_id').html('');
                     }
                 },
                 error: function (response) {
                     var r = jQuery.parseJSON(response.responseText);
                     alert("Message: " + r.Message);
                     alert("StackTrace: " + r.StackTrace);
                     alert("ExceptionType: " + r.ExceptionType);
                 }
             });
         }
      </script>
      
      <script>
         $(document).ready(function(){
            $('.modal').modal();
         });
      </script>
      <script>
         $("#pl_ord").on('click',function(){
                      if (!$("#form_sales_rep_location_details").valid()) {
                         return false;
                      }
                      else
                      {
                 var dist_type = $('#distributor_type').val(); 
                 var sequence_count = $('#sequence_count').val();
               
               
         
                 if(sequence_count=="")
                 {
                  sequence_count = 1;
                 }
                 var sequence = $('#sequence').val();
                  
                 if($(this).attr('id')!='Saver')
                  {
                     $('#confirm_content2').confirmModal({
                                topOffset: 0,
                                onOkBut: function() {$("#loading").show();$('#place_order').val("Yes"); $('#ispermenant').val('Yes');$('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                                onCancelBut: function() {$("#loading").show();$('#place_order').val("No"); $('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                                onLoad: function() {$('#place_order').val("No"); },
                                onClose: function() {$('#place_order').val("No"); }
                              });   
                  }
                  else
                  {
                        $('#confirm_content2').confirmModal({
                                topOffset: 0,
                                onOkBut: function() {$("#loading").show();$('#place_order').val("Yes"); $('#ispermenant').val('Yes');$('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                                onCancelBut: function() {$("#loading").show();$('#place_order').val("No"); $('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                                onLoad: function() {$('#place_order').val("No"); },
                                onClose: function() {$('#place_order').val("No"); }
                              });
                  }
               
                
               /*if(($('#mid').val()=="" && dist_type=='Old') && sequence_count!=sequence )
               {
                  if($('#store_id').val()!='')
                  {
                     $('#confirm_content').confirmModal({
                                topOffset: 0,
                                onOkBut: function() {
                                 $("#loading").show();
                                 if($('#store_id').val()=='')
                                 {
                                    $('#place_order').val("Yes"); $('#ispermenant').val('Yes');$('#srld').val("Place Order");
                                 }
                                 else
                                 {
                                    $('#ispermenant').val('Yes');
                                 }
                                 $("#form_sales_rep_location_details").submit();
                                },
                                onCancelBut: function() {
                                $("#loading").show();
                                $('#place_order').val("No");
                                $('#ispermenant').val('No');
                                $("#form_sales_rep_location_details").submit();},   
                                onLoad: function() {},
                                onClose: function() {}
                              });
                              return false;
                  }
                  else
                  {
                     $('#confirm_content2').confirmModal({
                                topOffset: 0,
                                onOkBut: function() {$("#loading").show();$('#place_order').val("Yes"); $('#ispermenant').val('Yes');$('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                                onCancelBut: function() {$("#loading").show();$('#place_order').val("No"); $('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                                onLoad: function() {$('#place_order').val("No"); },
                                onClose: function() {$('#place_order').val("No"); }
                              });
                  }
               }
               else
               {
                  if($(this).attr('id')!='Saver')
                  {
                     $('#confirm_content2').confirmModal({
                                topOffset: 0,
                                onOkBut: function() {$("#loading").show();$('#place_order').val("Yes"); $('#ispermenant').val('Yes');$('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                                onCancelBut: function() {$("#loading").show();$('#place_order').val("No"); $('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                                onLoad: function() {$('#place_order').val("No"); },
                                onClose: function() {$('#place_order').val("No"); }
                              });   
                  }
                  
               }*/
                      }
                  });
         
         // $('#channel_type').change(function(){
         //               getselectdiv($(this));
         //       });
         
         
         $(document).ready(function(){
            get_store();
            /*get_zone();*/
            if($('#channel_type').val()=="MT"){              
               get_mt_location();
			    $('.merchendiser').show();
              $('.salesrep').hide();
            } else {
               get_location();
					$('.merchendiser').hide();
					$('.salesrep').show();
            }


            getselectdiv(document.getElementById('channel_type'));
         });
         
         // $(document).ready(function () {
         //     $("#channel_type").click();
         // });
         
         var segment_uri = '<?=$this->uri->segment(3)?>';

         function getselectdiv(elem) 
         {
             // var value = elem.value;
             /*get_zone();*/
             if(segment_uri=='')
             {
               get_zone();
             }

             var value = $("#channel_type").val();
             if($('#distributor_type').val()=="Old"){
                  $('stock_entry').show();
             } 
             else
             {
               $('stock_entry').hide();
             }
         
            if(value=='GT')
            {
               $('#pl_ord').val('Place Order');
               if($('#id').val()!='')
                 {
                     $('#channel_type_div').hide();
                     $('#dist_type').hide();
                     $('.zone').hide();
                     $('.area').hide();
                     $('.location').hide();
                     $('.retailer_div').hide();
         
                     var channel_text = $('#channel_type option:selected').text();
                     var type_text = $('#distributor_type option:selected').text();
                     var zone_text = $('#zone_id option:selected').text();
                     var location_text = $('#location_id option:selected').text();
                     var area_text = $('#area_id option:selected').text();
                     var retailer_text = $('#distributor_id option:selected').text();
                        
                     $('#dist_old').show();
                     $(".channel_text").html(channel_text);
                     $(".type_text").html(type_text);
                     $(".zone_text").html(zone_text);
                     $(".location_text").html(location_text);
                     $(".area_text").html(area_text);
                     $(".retailer_text").html(retailer_text);
                     $('#relation_text').hide();
					 $('.merchendiser').hide();
						$('.salesrep').show();
                  
                 }
                else
                {
                     $('.location').show();
                     $('.zone').show();
                     $('.area').show();
                     $('#retailer_div').show();
                     $('#dist_type').show();
                     $('.relation_store').hide();
                     //$('#distributor_type').hide();
						$('.merchendiser').hide();
						$('.salesrep').show();
                     
                }
         
                	
            }
            else
            {
               $('#pl_ord').val('Purchase Order');
               if($('#id').val()!='')
                 {
                     $('#channel_type_div').hide();
                     $('#dist_type').hide();
                     $('.zone').hide();
                     $('.area').hide();
                     $('.location').hide();
                     $('.retailer_div').hide();
         
                     var channel_text = $('#channel_type option:selected').text();
                     var type_text = $('#distributor_type option:selected').text();
                     var zone_text = $('#zone_id option:selected').text();
                     var location_text = $('#location_id option:selected').text();
                     var area_text = $('#area_id option:selected').text();
                     var retailer_text = $('#distributor_id option:selected').text();
                     var relation_text = $('#reation_id option:selected').text();
                        
                     $('#dist_old').show();
                     $(".channel_text").html(channel_text);
                     $(".type_text").html(type_text);
                     $(".zone_text").html(zone_text);
                     $(".location_text").html(location_text);
                     $(".area_text").html(area_text);
                     $(".retailer_text").html(retailer_text);
                     $(".relation_text").html(relation_text);
                     $('#area_text').hide();
                     $('#retailer_text').hide();
					  $('.merchendiser').show();
					$('.salesrep').hide();
                  
                  }
                  else
                  {
                     
                     $('.relation_store').show();
                     $('#retailer_div').hide();
                     $('.location').show();
                     $('.zone').show();
                     $('#dist_type').hide();
                     /*$('#distributor_type').find('option[value="Old"]').attr("selected",true);*/
                     $('.area').hide();
                     $('#stock_entry').show();
					  $('.merchendiser').show();
						$('.salesrep').hide();
                  }
				 
            } 
			
		
			
            }
			
			
			
			
        
         
         $('#zone_id').change(function(){
                        get_store();
                  });
         
                  function get_store() {
                       var zone_id = $('#zone_id').val();
                        $.ajax({
                          url:'<?=base_url()?>index.php/distributor_sale/get_store',
                          method: 'post',
                          data: {zone_id: zone_id},
                          dataType: 'json',
                          async: false,
                          success: function(response){
                   
                            $('#reation_id').find('option').not(':first').remove();
                            var option = '';
                            $.each(response,function(index,data){
                               if($('#store_id').val()==data['store_id'])
                               {
                                    option+='<option value="'+data['store_id']+'"  selected>'+data['store_name']+'</option>';
                               }
                               else
                               {
                                 option+='<option value="'+data['store_id']+'">'+data['store_name']+'</option>';
                               }
                               
                               
                            });
         
                            $('#reation_id').append(option);
                            //$('#store_id').append();
                          }
                       });
                  }
         
         
         function get_mt_location() {
             var store_id = $('#reation_id').val();
             var location_id = $('#location_id').val();
             console.log(store_id);
              var zone_id = $('#zone_id').val();
               $.ajax({
                 url:'<?=base_url()?>index.php/distributor_sale/get_location_data',
                 method: 'post',
                 data: {store_id: store_id,zone_id:zone_id},
                 dataType: 'json',
                 async:false,
                 success: function(response){
                  console.log(response);

                   $('#location_id').find('option').not(':first').remove();
                   $.each(response,function(index,data){
                      $('#location_id').append('<option value="'+data['location_id']+'">'+data['location']+'</option>');
                   });
                     $('#location_id').val(location_id);
                 }
              });
         }

         function get_zone() {
               /*alert("hii");*/
               var channel_type = $('#channel_type').val();
               var type = '';
               if(channel_type=='GT')
               {
                  type = 'GT';
               }
               else
               {
                  type = 'MT';
               }

               $.ajax({
                 url:'<?=base_url()?>index.php/Sales_rep_store_plan/get_zone',
                 method: 'post',
                 data: {type:type},
                 dataType: 'json',
                 async:false,
                 success: function(response){
                  console.log(response);
                   $('#zone_id').find('option').not(':first').remove();
                   $.each(response,function(index,data){
                      $('#zone_id').append('<option value="'+data['zone_id']+'">'+data['zone']+'</option>');
                   });
                 }
              });
         }
         
      </script>
      <script type="text/javascript">
         function set_radio_button(val,elem)
         { 
           $('#type_id_'+val).val(elem.value);
         }
         
         function qty_change(elem) {
           var id = elem.id;
           var explode = id.split('_');
           var index = explode[1];
           var type = $('#type_id_'+index).val();
         }
      </script>
   </body>
</html>