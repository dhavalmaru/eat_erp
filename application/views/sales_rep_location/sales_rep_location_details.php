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
            .submitLink 
            {
                background-color: transparent;
                text-decoration: none;
                border: none;
                color: #428bca;
                cursor: pointer;
                font-size:16px!important;
            }
            .btn_color
            {
                background-color:#7A8491!important;
                color:#fff!important;
            }
            input::-webkit-input-placeholder
            { 
                font-size:0.8rem!important;
                color: #000!important;
            }
            .input-field.col label {
                left: .75rem!important;
                font-size: 12px!important;
                font-weight: 900!important;
                color: #000;
            }
            input:not([type]), input[type=text], input[type=password], input[type=email], input[type=url], input[type=time], input[type=date], input[type=datetime], input[type=datetime-local], input[type=tel], input[type=number], input[type=search], textarea.materialize-textarea
            {
                color: #000!important;
                font-size:13px!important;
            }
            select
            {
                color: #000!important;
            }
            label.error {
                margin-top: 37px;
                color: red !important;
                transform: translateY(0%) !important; 
            }
            .input-field label:not(.error).active {
                margin-top: 37px;
            }
            .row
            {
                margin-bottom:10px!important
            }
            textarea.materialize-textarea
            {
                border: 1px solid #f2f2f2;
            }
            input[type=number]
            {
                margin:0px;
                height: 2.5rem;
                text-align:center!important;
            }
            textarea.materialize-textarea
            {
                padding:0;
                height:70px!important;
            }
            .panel-footer
            {
                padding-top:20px;
            }
            .app-pages 
            {
                margin-top: 25px;
            }
            [type="radio"]:not(:checked)+label, [type="radio"]:checked+label
            {
                padding-left: 22px!important;
            }
            .collapsible-header
            {
                border-top: 3px solid #0c2c4e!important;
                color:#0c2c4e!important;
            }
            #stock_entry 
            {
                width:100%!important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered
            {
                color:#888;
                line-height:2.8rem;
            }
            .select2-container--default .select2-selection--single
            {
                height:3rem;
                border:1px solid #f2f2f2!important;
            }
            .select2-container
            {
                display:inline-block;
                z-index:0;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow
            {
                line-height:2.8rem!important;

            }
            .check_diff{
                display: none;
            }
            .select2-container--open
            {
                z-index:9999;
            }
        </style>
    </head>
    <body>
      <div id="loading" style="display: none"></div>
      <!-- START PAGE CONTAINER -->
      <div class="navbar">
         <?php $this->load->view('templates/header2');?>
      </div>
      <?php $this->load->view('templates/menu2');?>   
      <!-- START PAGE CONTAINER -->
      <!-- PAGE CONTENT -->
      <!-- PAGE CONTENT WRAPPER -->
      <div class="contact app-pages app-section">
      <div class="container">
         <div id="basic-form" class="section">
            <div class="row">
               <div class="col s12">
                  <div class="card-panel">
                     <div class="row">
                        <div class="app-title">
                           <h5> Visit Details</h5>
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
                        </div>
                        <?php 
                           if(isset($data[0]->id))
                              $id = $data[0]->id;
                           else
                              $id = '';
                           ?>
                        <hr>
                        <form id="form_sales_rep_location_details" role="form"  method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/Sales_rep_store_plan/save/'; else echo base_url().'index.php/Sales_rep_store_plan/save'; ?>" >
                           <div class="row"  >
                              <div class="col s12">
                                 <div class="input-field col s3">
                                    <label for="dob">Date</label>
                                 </div>
                                 <div class="input-field col s9"   style="top:0.8rem;color:#000!important;">
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
                                    <input type="hidden"  name="date_of_visit" id="date_of_visit" value="<?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                    <input type="hidden"  name="sales_rep_loc_id" id="sales_rep_loc_id" value="<?php if(isset($data[0]->sales_rep_loc_id)) echo $data[0]->sales_rep_loc_id;?>"/>
                                    <input type="hidden"  name="distributor_status" id="distributor_status" value="<?php if(isset($data[0]->distributor_status)) echo $data[0]->distributor_status;?>"/>
                                    <input type="hidden"  name="merchandiser_stock_id" id="merchandiser_stock_id" value="<?php if(isset($data[0]->merchandiser_stock_id)) echo $data[0]->merchandiser_stock_id;?>"/>

                                    <input type="hidden"  name="follow_type" id="follow_type" value="<?php if(isset($follow_type)) echo $follow_type;?>"/>
                                    
                                    <?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>
                                 </div>
                              </div>
                           </div>
                           <div class="row" id="channel_type_div">
                              <div class="col s12">
                                 <div class="input-field col s3">
                                    <label>Channel<span class="asterisk_sign">*</span></label>
                                 </div>
                                 <div class="input-field col s9">
                                    <select class="browser-default" name="channel_type" id="channel_type" onchange="getselectdiv(this)">
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
                           <div class="row" id="dist_type">
                              <div class="col s12">
                                 <div class="input-field col s3">
                                    <label>Type<span class="asterisk_sign">*</span></label>
                                 </div>
                                 <div class="input-field col s9">
                                    <select class="browser-default" name="distributor_type" id="distributor_type">
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

                           <div class="zone" style="display:none">
                              <div class="row zone" >
                                 <div class="col s12">
                                    <div class="input-field col s3">
                                       <label class="old_dist_details">Zone <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9">
                                       <select name="zone_id" id="zone_id" class="browser-default select2" onchange="get_area();">
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
                              <div class="row " >
                                 <div class="col s12">
                                    <div class="input-field col s3">
                                       <label class="">Relation<span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9">
                                       <select name="reation_id" id="reation_id" class="browser-default select2" onchange="get_mt_location();">
                                          <option value="">Select</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="area" style="display:none">
                              <div class="row old_dist_details " >
                                 <div class="col s12">
                                    <div class="input-field col s3">
                                       <label class="old_dist_details">Area<span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9">
                                       <select name="area_id" id="area_id"  class="browser-default select2"  onchange="get_location();">
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
                              <div class="row old_dist_details location">
                                 <div class="col s12">
                                    <div class="input-field col s3">
                                       <label class="old_dist_details">Location <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9">
                                       <select name="location_id" id="location_id" class="browser-default select2" onchange="get_retailer();">
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
                                                   if($location[$k]->id==$data[0]->location_id) { echo 'selected'; }
                                                  }
                                                   
                                             
                                             };
                                             
                                             ?>><?php echo $location[$k]->location; ?></option>
                                          <?php }} ?>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                     <div class="row retailer_div" id="retailer_div">
                              <div class="col s12">
                                 <div class="input-field col s3">
                                    <label id="s_type">Retailer <span class="asterisk_sign">*</span></label>
                                 </div>
                                 <div class="input-field col s9">
                                    <!--store_id is a Retailer id-->
                                    <span class="distributor_field" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo ''; else echo 'display: none;';} ?>">
                                       <select name="distributor_id" id="distributor_id" class="browser-default select2" style="<?php if(isset($data[0]->distributor_type)) {if($data[0]->distributor_type=='Old') echo ''; else echo 'display: none;';} ?>">
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
                                          
                                          else if($visit_detail!=''){
                                          if ($visit_detail['distributor_name']!='')echo $visit_detail['distributor_name'];
                                          }; 
                                          
                                          
                                          ?>"  <?=(isset($data[0]->distributor_status)?'readonly':'')?>/>
                                 </div>
                              </div>
                           </div>
                           <div id="dist_old" style="display: none">
                              <div class="row">
                                 <div class="col s12" >
                                    <br>
                                    <div class="input-field col s3" >
                                       <label>Channel <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9 channel_text" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col s12" >
                                    <br>
                                    <div class="input-field col s3" >
                                       <label>Type <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9 type_text" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row" id="retailer_text">
                                 <div class="col s12" >
                                    <br>
                                    <div class="input-field col s3" >
                                       <label>Retailer <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9 retailer_text" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col s12" >
                                    <br>
                                    <div class="input-field col s3" >
                                       <label>Zone <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9 zone_text" >
                                    </div>
                                 </div>
                              </div>
                              <div class="row" id="area_text">
                                 <div class="col s12" >
                                    <br>
                                    <div class="input-field col s3" >
                                       <label>Area <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9 area_text">
                                    </div>
                                 </div>
                              </div>
                              <div class="row" id="relation_text">
                                 <div class="col s12" >
                                    <br>
                                    <div class="input-field col s3" >
                                       <label>Relation <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9 relation_text">
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col s12" >
                                    <br>
                                    <div class="input-field col s3" >
                                       <label>Location <span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s9 location_text">
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
                                 <ul class="collapsible">
								                    <li>
                                       <div class="collapsible-header active" ><i class="material-icons">add</i> <strong>Bars</strong></div>
                                       <div class="collapsible-body">
                                          <div class="">
                                             <div class="app-title">
                                                <h5>Available Quantities</h5>
                                             </div>
                                             <hr>
                                           
											
                                              <div class="row">
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Orange<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s4">
                                                      <input type="number"   value="<?php if(isset($stock_detail['orange_bar']))
                                                         {
                                                            $exs =  explode('_',$stock_detail['orange_bar']);
                                                            echo $exs[0];
                                                         } 
                                                         ?>" 
                                                         class="form-control qty" name="orange_bar" placeholder="0" id="type_0" onblur="qty_change(this)"/>
                                                   </div>
                                                   
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Butterscotch<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['butterscotch_bar']))
                                                         {
                                                           $exs2 = explode("_",$stock_detail['butterscotch_bar']);
                                                           echo $exs2[0];
                                                         } 
                                                         ?>" class="form-control qty" name="butterscotch_bar" placeholder="0" id="type_1"
                                                        
                                                         />  
                                                   </div>
                                                  
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Choco<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['chocopeanut_bar']))
                                                         {
                                                            $exs4 = explode("_",$stock_detail['chocopeanut_bar']);
                                                           echo $exs4[0];
                                                         } 
                                                         ?>" class="form-control qty" name="chocopeanut_bar" placeholder="0" id="type_3"/>
                                                   </div>
                                                  
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Chaat<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['bambaiyachaat_bar']))
                                                         {
                                                            if($stock_detail['bambaiyachaat_bar']!=NULL)
                                                            {
                                                              $exs6 =  explode("_",$stock_detail['bambaiyachaat_bar']);
                                                               echo $exs6[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="bambaiyachaat_bar" placeholder="0" id="type_4"/>
                                                   </div>
                                                    
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Mango<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['mangoginger_bar']))
                                                         {
                                                            if($stock_detail['mangoginger_bar']!=NULL)
                                                            {
                                                               $exs8 = explode("_",$stock_detail['mangoginger_bar']);
                                                                  echo $exs8[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="mangoginger_bar" placeholder="0"
                                                         id="type_5"/>
                                                   </div>
                                                   
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Berry<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php if(isset($stock_detail['berry_blast_bar']))
                                                         {
                                                            if($stock_detail['berry_blast_bar']!=NULL)
                                                            {
                                                               $exs10 = explode("_",$stock_detail['berry_blast_bar']);
                                                              echo $exs10[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="berry_blast_bar" placeholder="0" id="type_6"/>
                                                   </div>
                                                   
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Chywanprash<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['chyawanprash_bar']))
                                                         {
                                                            if($stock_detail['chyawanprash_bar']!=NULL)
                                                            {
                                                               $exs12 =explode("_",$stock_detail['chyawanprash_bar']);
                                                               echo $exs12[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="chyawanprash_bar" placeholder="0"
                                                         id="type_7"/>
                                                   </div>
                                                   
                                                </div>
                                               
                                             </div>
											 
											 
											 
                                          </div>
                                       </div>
                                    </li>
								 
								 
								 
                                    <li>
                                       <div class="collapsible-header active" ><i class="material-icons">add</i> <strong>Box</strong></div>
                                       <div class="collapsible-body">
                                          <div class="">
                                             <div class="app-title">
                                                <h5>Available Quantities</h5>
                                             </div>
                                             <hr>
                                            
											  
                                            
											 <div class="row">
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Orange<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   
                                                   <div class="input-field col s4">
                                                      <div class="">
                                                         <input type="number"   value="<?php if(isset($stock_detail['orange_box']))
                                                            {
                                                               $exs1 =  explode('_',$stock_detail['orange_box']);
                                                               echo $exs1[0]; 
                                                            } 
                                                         ?>" 
                                                         class="form-control qty" name="orange_box" placeholder="0" id="type_0" onblur="qty_change(this)"/>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Butterscotch<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['butterscotch_box']))
                                                         {
                                                            $exs3 =explode("_",$stock_detail['butterscotch_box']);
                                                            echo $exs3[0];
                                                         } 
                                                         ?>" class="form-control qty" name="butterscotch_box" placeholder="0" id="type_1"
                                                        
                                                         />  
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Choco<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['chocopeanut_box']))
                                                         {
                                                            if($stock_detail['chocopeanut_box']!=NULL)
                                                            {
                                                               $exs5 =explode("_",$stock_detail['chocopeanut_box']);
                                                               echo $exs5[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="chocopeanut_box" placeholder="0" id="type_3"/>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Chaat<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   
                                                    <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['bambaiyachaat_box']))
                                                         {
                                                            if($stock_detail['bambaiyachaat_box']!=NULL)
                                                            {
                                                              $exs7 = explode("_",$stock_detail['bambaiyachaat_box']);
                                                             echo $exs7[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="bambaiyachaat_box" placeholder="0" id="type_4"/>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Mango<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['mangoginger_box']))
                                                         {
                                                             if($stock_detail['mangoginger_box']!=NULL)
                                                            {
                                                               $exs9 =explode("_",$stock_detail['mangoginger_box']);
                                                                  echo $exs9[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="mangoginger_box" placeholder="0"
                                                         id="type_5"/>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Berry<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php if(isset($stock_detail['berry_blast_box']))
                                                         {
                                                            if($stock_detail['berry_blast_box']!=NULL)
                                                            {
                                                               $exs11 = explode("_",$stock_detail['berry_blast_box']);
                                                               echo $exs11[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="berry_blast_box" placeholder="0" id="type_6"/>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Chywanprash<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   
                                                   <div class="input-field col s4">
                                                      <input type="number" value="<?php
                                                         if(isset($stock_detail['chyawanprash_box']))
                                                         {
                                                            if($stock_detail['chyawanprash_box']!=NULL)
                                                            {
                                                               $exs13 = explode("_",$stock_detail['chyawanprash_box']);
                                                               echo $exs13[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="chyawanprash_box" placeholder="0"
                                                         id="type_7"/>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s6">
                                                      <label class="">Variety Box<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s4">
                                                   <input type="number" value="<?php
                                                         if(isset($stock_detail['variety_box']))
                                                         {
                                                            if($stock_detail['variety_box']!=NULL)
                                                            {
                                                               $exs7 = explode('_',$stock_detail['variety_box']);
                                                               echo $exs7[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="variety_box" placeholder="0" id="type_8" />
                                                   </div>
                                                  
                                                </div>
                                             </div>
											 
											 
                                          </div>
                                       </div>
                                    </li>
                                    <li>
                                       <div class="collapsible-header"><i class="material-icons">add</i> <strong> Cookies </strong></div>
                                       <div class="collapsible-body">
                                          <div class="app-title">
                                             <h5>Available Quantities</h5>
                                          </div>
                                          <hr>
                                          <div class="row">
                                             <div class="col s12">
                                                <div class="input-field col s6">
                                                   <label class="">Chocolate <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="input-field col s4">
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
                                             <div class="col s12">
                                                <div class="input-field col s6">
                                                   <label class=""> Dark Chocolate <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="input-field col s4">
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
                                             <div class="col s12">
                                                <div class="input-field col s6">
                                                   <label class="">Cranberry <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="input-field col s4">
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
                                    </li>
									

                                    <li>
                                       <div class="collapsible-header "><i class="material-icons">add</i> <strong>TrailMix </strong></div>
                                       <div class="collapsible-body">
                                       <div class="app-title">
                                       <h5>Available Quantities</h5>
                                       </div>
                                       <hr>  
                                       <div class="row">
                                       <div class="col s12">
                                       <div class="input-field col s6">
                                       <label class="">Cranberry & Orange  <span class="asterisk_sign">*</span></label>
                                       </div> 
                                       <div class="input-field col s4">
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
                                       <div class="col s12">
                                       <div class="input-field col s6">
                                       <label class="">Fig & Raisins <span class="asterisk_sign">*</span></label>
                                       </div> 
                                       <div class="input-field col s4">
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
                                       <div class="col s12">
                                       <div class="input-field col s6">
                                       <label class="">Papaya & pineapple<span class="asterisk_sign">*</span></label>
                                       </div> 
                                       <div class="input-field col s4">
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
                                    </li>
                                 </ul>
                                 </div>
                                 <div class="row">
                                    <div class="col s12">
                                       <div class="input-field col s3">
                                          <label>Remarks <span class="asterisk_sign"></span></label>
                                       </div>
                                       <div class="input-field col s9">
                                          <!--store_id is a Retailer id-->
                                          <textarea id="textarea1" class="materialize-textarea" class="" name="remarks" id="remarks" value="
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
                                 <div class="row">
                                    <div class="col s12">
                                       <input type="button" id="pl_ord" value="Place Order" name="srld" class="left button shadow btn_color " style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-left: 22px;font-size:16px;padding:8px 12px" />
                                       <a data-toggle="modal" id="followup_anc" href="#myModal" class=" right  button shadow btn_color" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 22px;font-size: 16px;">Follow Up</a>
									   

                                    </div>
                                 </div>
                                 <br>
                                 <div class="row">
                                    <div class="col s12">
                                       <a href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan/clear_session" class="button left shadow btn_color1 " type="reset" id="reset" style=" float: left;margin-left: 22px;">Cancel</a>
                                       <input type="button" value="Save" id="Saver" name="srld" class="right button shadow btn_color2" style="margin-right: 10%;" />
                                    </div>
                                 </div>
								 
  							                  <!-- <div class="row">
                                    <div class="col s12">
                                       <a data-toggle="modal" id="" href="#myModal1" class=" right  button shadow btn_color" data-keyboard="false" data-backdrop="static">Po Quanty</a>
                                    </div>
                                  </div> -->
                              </div>
                              <!-- Modal -->
                              <div class="modal fade" id="myModal" role="dialog">
                                 <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <button type="button" style="float: right; top: -25px;right: -30px; font-size: 24px;" class="modal-close waves-effect waves-green btn-flat">&times;</button>
                                          <h4 class="modal-title" style="font-size: 18px;">Follow Up Date</h4>
                                       </div>
                                       <div class="modal-body">
                                          <br/>
                                          <div class="">
                                             <input type="text" class="form-control datepicker" name="followup_date" id="followup_date" placeholder="Follow Up Date" value="<?php if(isset($data[0]->followup_date)) echo (($data[0]->followup_date!=null && $data[0]->followup_date!='')?date('d/m/Y',strtotime($data[0]->followup_date)):''); else echo ''; ?>"/>
                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="button shadow btn_color left modal-close" data-dismiss="modal">Close</button>
                                          <input type="submit" id="btn_save" name="srld" class="button btn_color right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>" value="Follow Up"/>
                                       </div>
                                    </div>
                                 </div>
                              </div>
							  
							  

							  
							  
							  
							  
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="confirm_content" style="display:none">
         <div class="logout-containerr">
            <button type="button" class="close" data-confirmmodal-but="close">×</button>
            <div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Permanent Route? </div>
            <div class="confirmModal_content">
               <p>Do You want this in permanent route?</p>
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
               <!-- <a href="<?php //echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a> -->
               <button type="button" class="btn " data-confirmmodal-but="ok">Yes</button>
               <button type="button" class="btn " data-confirmmodal-but="close">No</button>
            </div>
         </div>
      </div>


        <?php $type=strtoupper(trim($this->session->userdata('type'))); ?>

        <div class="modal fade" id="myModal1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close waves-effect waves-green btn-flat" style="float: right; top: -25px;right: -30px; font-size: 24px;<?php if($type=='PROMOTER' || $type=="MERCHANDIZER") echo 'display: none;' ?>">&times;</button>
                        <h4 class="modal-title" style="font-size: 18px;">Purchase Order Quanty </h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_po_qty_details" role="form"  method="post" enctype="multipart/form-data" action="<?php echo base_url().'index.php/Sales_rep_store_plan/save_po_qty'; ?>" >
                        <div class="row">
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field col s4">
                                        <label class="">Po Number<span class="asterisk_sign">*</span></label>
                                    </div>
                                    <div class="input-field col s6">
                                        <!-- <input type="text" value="" class="browser-default qty" name="po_id" placeholder="" id=""/>   -->
                                        <select id="po_id" name="po_id" class="browser-default select2" onchange="get_po_data();"></select>
                                    </div>
                                </div>
                            </div>
                            <ul class="collapsible">
                                <li id="bars_list">
                                    <div class="collapsible-header active" ><i class="material-icons">add</i> <strong>Bars</strong></div>
                                    <div class="collapsible-body" style="display: block; padding-top: 30px; margin-top: 0px; padding-bottom: 30px; margin-bottom: 0px;">
                                        <div class="">
                                            <div class="app-title">
                                                <h5>Available Quantities</h5>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div id="po_orange_bar_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Orange<span class="asterisk_sign">*</span>
                                                            <span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_orange_bar_val"></span>&nbsp;]</span>
                                                        </label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_orange_bar" name="po_orange_bar" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_orange_bar_qty" name="po_orange_bar_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_orange_bar_diff" name="po_orange_bar_diff" value="" />
                                                        <label class=""><span id="po_orange_bar_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_butterscotch_bar_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Butterscotch<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_butterscotch_bar_val"></span>&nbsp;]</span></label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_butterscotch_bar" name="po_butterscotch_bar" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_butterscotch_bar_qty" name="po_butterscotch_bar_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_butterscotch_bar_diff" name="po_butterscotch_bar_diff" value="" />
                                                        <label class=""><span id="po_butterscotch_bar_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_chocopeanut_bar_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Choco<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_chocopeanut_bar_val"></span>&nbsp;]</span></label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_chocopeanut_bar" name="po_chocopeanut_bar" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_chocopeanut_bar_qty" name="po_chocopeanut_bar_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_chocopeanut_bar_diff" name="po_chocopeanut_bar_diff" value="" />
                                                        <label class=""><span id="po_chocopeanut_bar_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_bambaiyachaat_bar_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Chaat<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_bambaiyachaat_bar_val"></span>&nbsp;]</span></label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_bambaiyachaat_bar" name="po_bambaiyachaat_bar" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_bambaiyachaat_bar_qty" name="po_bambaiyachaat_bar_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_bambaiyachaat_bar_diff" name="po_bambaiyachaat_bar_diff" value="" />
                                                        <label class=""><span id="po_bambaiyachaat_bar_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_mangoginger_bar_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Mango<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_mangoginger_bar_val"></span>&nbsp;]</span></label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_mangoginger_bar" name="po_mangoginger_bar" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_mangoginger_bar_qty" name="po_mangoginger_bar_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_mangoginger_bar_diff" name="po_mangoginger_bar_diff" value="" />
                                                        <label class=""><span id="po_mangoginger_bar_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_berry_blast_bar_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Berry<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_berry_blast_bar_val"></span>&nbsp;]</span></label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_berry_blast_bar" name="po_berry_blast_bar" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_berry_blast_bar_qty" name="po_berry_blast_bar_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_berry_blast_bar_diff" name="po_berry_blast_bar_diff" value="" />
                                                        <label class=""><span id="po_berry_blast_bar_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_chyawanprash_bar_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Chywanprash<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_chyawanprash_bar_val"></span>&nbsp;]</span></label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_chyawanprash_bar" name="po_chyawanprash_bar" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_chyawanprash_bar_qty" name="po_chyawanprash_bar_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_chyawanprash_bar_diff" name="po_chyawanprash_bar_diff" value="" />
                                                        <label class=""><span id="po_chyawanprash_bar_diff_val"></span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li id="box_list">
                                    <div class="collapsible-header active" ><i class="material-icons">add</i> <strong>Box</strong></div>
                                    <div class="collapsible-body" style="display: block; padding-top: 30px; margin-top: 0px; padding-bottom: 30px; margin-bottom: 0px;">
                                        <div class="">
                                            <div class="app-title">
                                                <h5>Available Quantities</h5>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div id="po_orange_box_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Orange<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_orange_box_val"></span>&nbsp;]</span></label>
                                                    </div>

                                                    <div class="input-field col s4">
                                                        <div class="">
                                                            <input type="number" class="form-control po_qty" id="po_orange_box" name="po_orange_box" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                        </div>
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_orange_box_qty" name="po_orange_box_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_orange_box_diff" name="po_orange_box_diff" value="" />
                                                        <label class=""><span id="po_orange_box_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_butterscotch_box_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Butterscotch<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_butterscotch_box_val"></span>&nbsp;]</span></label>
                                                    </div>

                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_butterscotch_box" name="po_butterscotch_box" value="" placeholder="0" onchange="get_diff_by_elem(this);" />  
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_butterscotch_box_qty" name="po_butterscotch_box_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_butterscotch_box_diff" name="po_butterscotch_box_diff" value="" />
                                                        <label class=""><span id="po_butterscotch_box_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_chocopeanut_box_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Choco<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_chocopeanut_box_val"></span>&nbsp;]</span></label>
                                                    </div>

                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_chocopeanut_box" name="po_chocopeanut_box" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_chocopeanut_box_qty" name="po_chocopeanut_box_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_chocopeanut_box_diff" name="po_chocopeanut_box_diff" value="" />
                                                        <label class=""><span id="po_chocopeanut_box_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_bambaiyachaat_box_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Chaat<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_bambaiyachaat_box_val"></span>&nbsp;]</span></label>
                                                    </div>

                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_bambaiyachaat_box" name="po_bambaiyachaat_box" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_bambaiyachaat_box_qty" name="po_bambaiyachaat_box_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_bambaiyachaat_box_diff" name="po_bambaiyachaat_box_diff" value="" />
                                                        <label class=""><span id="po_bambaiyachaat_box_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_mangoginger_box_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Mango<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_mangoginger_box_val"></span>&nbsp;]</span></label>
                                                    </div>

                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_mangoginger_box" name="po_mangoginger_box" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_mangoginger_box_qty" name="po_mangoginger_box_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_mangoginger_box_diff" name="po_mangoginger_box_diff" value="" />
                                                        <label class=""><span id="po_mangoginger_box_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_berry_blast_box_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Berry<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_berry_blast_box_val"></span>&nbsp;]</span></label>
                                                    </div>

                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_berry_blast_box" name="po_berry_blast_box" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_berry_blast_box_qty" name="po_berry_blast_box_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_berry_blast_box_diff" name="po_berry_blast_box_diff" value="" />
                                                        <label class=""><span id="po_berry_blast_box_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_chyawanprash_box_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Chywanprash<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_chyawanprash_box_val"></span>&nbsp;]</span></label>
                                                    </div>

                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_chyawanprash_box" name="po_chyawanprash_box" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_chyawanprash_box_qty" name="po_chyawanprash_box_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_chyawanprash_box_diff" name="po_chyawanprash_box_diff" value="" />
                                                        <label class=""><span id="po_chyawanprash_box_diff_val"></span></label>
                                                    </div>
                                                </div>
                                                <div id="po_variety_box_div" class="col s12">
                                                    <div class="input-field col s6">
                                                        <label class="">Variety Box<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_variety_box_val"></span>&nbsp;]</span></label>
                                                    </div>
                                                    <div class="input-field col s4">
                                                        <input type="number" class="form-control po_qty" id="po_variety_box" name="po_variety_box" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                    </div>
                                                    <div class="input-field col s1 check_diff"></div>
                                                    <div class="input-field col s1 check_diff">
                                                        <input type="hidden" id="po_variety_box_qty" name="po_variety_box_qty" value="" />
                                                        <input type="hidden" class="diff_qty" id="po_variety_box_diff" name="po_variety_box_diff" value="" />
                                                        <label class=""><span id="po_variety_box_diff_val"></span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li id="cookies_list">
                                    <div class="collapsible-header" active><i class="material-icons">add</i> <strong> Cookies </strong></div>
                                    <div class="collapsible-body" style="display: block; padding-top: 30px; margin-top: 0px; padding-bottom: 30px; margin-bottom: 0px;">
                                        <div class="app-title">
                                            <h5>Available Quantities</h5>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div id="po_chocolate_cookies_div" class="col s12">
                                                <div class="input-field col s6">
                                                    <label class="">Chocolate <span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_chocolate_cookies_val"></span>&nbsp;]</span></label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <input type="number" class="form-control po_qty" id="po_chocolate_cookies" name="po_chocolate_cookies" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                </div>
                                                <div class="input-field col s1 check_diff"></div>
                                                <div class="input-field col s1 check_diff">
                                                    <input type="hidden" id="po_chocolate_cookies_qty" name="po_chocolate_cookies_qty" value="" />
                                                    <input type="hidden" class="diff_qty" id="po_chocolate_cookies_diff" name="po_chocolate_cookies_diff" value="" />
                                                    <label class=""><span id="po_chocolate_cookies_diff_val"></span></label>
                                                </div>
                                            </div>
                                            <div id="po_dark_chocolate_cookies_div" class="col s12">
                                                <div class="input-field col s6">
                                                    <label class=""> Dark Chocolate <span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_dark_chocolate_cookies_val"></span>&nbsp;]</span></label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <input type="number" class="form-control po_qty" id="po_dark_chocolate_cookies" name="po_dark_chocolate_cookies" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                </div>
                                                <div class="input-field col s1 check_diff"></div>
                                                <div class="input-field col s1 check_diff">
                                                    <input type="hidden" id="po_dark_chocolate_cookies_qty" name="po_dark_chocolate_cookies_qty" value="" />
                                                    <input type="hidden" class="diff_qty" id="po_dark_chocolate_cookies_diff" name="po_dark_chocolate_cookies_diff" value="" />
                                                    <label class=""><span id="po_dark_chocolate_cookies_diff_val"></span></label>
                                                </div>
                                            </div>
                                            <div id="po_cranberry_cookies_div" class="col s12">
                                                <div class="input-field col s6">
                                                    <label class="">Cranberry <span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_cranberry_cookies_val"></span>&nbsp;]</span></label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <input type="number" class="form-control po_qty" id="po_cranberry_cookies" name="po_cranberry_cookies" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                </div>
                                                <div class="input-field col s1 check_diff"></div>
                                                <div class="input-field col s1 check_diff">
                                                    <input type="hidden" id="po_cranberry_cookies_qty" name="po_cranberry_cookies_qty" value="" />
                                                    <input type="hidden" class="diff_qty" id="po_cranberry_cookies_diff" name="po_cranberry_cookies_diff" value="" />
                                                    <label class=""><span id="po_cranberry_cookies_diff_val"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li id="trailmix_list">
                                    <div class="collapsible-header "><i class="material-icons">add</i> <strong>TrailMix </strong></div>
                                    <div class="collapsible-body" style="display: block; padding-top: 30px; margin-top: 0px; padding-bottom: 30px; margin-bottom: 0px;">
                                        <div class="app-title">
                                            <h5>Available Quantities</h5>
                                        </div>
                                        <hr>  
                                        <div class="row">
                                            <div id="po_cranberry_orange_zest_div" class="col s12">
                                                <div class="input-field col s6">
                                                    <label class="">Cranberry & Orange  <span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_cranberry_orange_zest_val"></span>&nbsp;]</span></label>
                                                </div> 
                                                <div class="input-field col s4">
                                                    <input type="number" class="form-control po_qty" id="po_cranberry_orange_zest" name="po_cranberry_orange_zest" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                </div>
                                                <div class="input-field col s1 check_diff"></div>
                                                <div class="input-field col s1 check_diff">
                                                    <input type="hidden" id="po_cranberry_orange_zest_qty" name="po_cranberry_orange_zest_qty" value="" />
                                                    <input type="hidden" class="diff_qty" id="po_cranberry_orange_zest_diff" name="po_cranberry_orange_zest_diff" value="" />
                                                    <label class=""><span id="po_cranberry_orange_zest_diff_val"></span></label>
                                                </div>
                                            </div>
                                            <div id="po_fig_raisins_div" class="col s12">
                                                <div class="input-field col s6">
                                                    <label class="">Fig & Raisins <span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_fig_raisins_val"></span>&nbsp;]</span></label>
                                                </div> 
                                                <div class="input-field col s4">
                                                    <input type="number" class="form-control po_qty" id="po_fig_raisins" name="po_fig_raisins" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                </div>
                                                <div class="input-field col s1 check_diff"></div>
                                                <div class="input-field col s1 check_diff">
                                                    <input type="hidden" class="diff_qty" id="po_fig_raisins_qty" name="po_fig_raisins_qty" value="" />
                                                    <input type="hidden" id="po_fig_raisins_diff" name="po_fig_raisins_diff" value="" />
                                                    <label class=""><span id="po_fig_raisins_diff_val"></span></label>
                                                </div>
                                            </div>
                                            <div id="po_papaya_pineapple_div" class="col s12">
                                                <div class="input-field col s6">
                                                    <label class="">Papaya & pineapple<span class="asterisk_sign">*</span><span class="check_diff">&nbsp;&nbsp;[&nbsp;<span id="po_papaya_pineapple_val"></span>&nbsp;]</span></label>
                                                </div> 
                                                <div class="input-field col s4">
                                                    <input type="number" class="form-control po_qty" id="po_papaya_pineapple" name="po_papaya_pineapple" value="" placeholder="0" onchange="get_diff_by_elem(this);" />
                                                </div>
                                                <div class="input-field col s1 check_diff"></div>
                                                <div class="input-field col s1 check_diff">
                                                    <input type="hidden" id="po_papaya_pineapple_qty" name="po_papaya_pineapple_qty" value="" />
                                                    <input type="hidden" class="diff_qty" id="po_papaya_pineapple_diff" name="po_papaya_pineapple_diff" value="" />
                                                    <label class=""><span id="po_papaya_pineapple_diff_val"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button shadow btn_color left modal-close" data-dismiss="modal" style="<?php if($type=='PROMOTER' || $type=="MERCHANDIZER") echo 'display: none;' ?>">Close</button>
                        <button type="button" class="button shadow btn_color right" onclick="save_po_qty();">Save</button>
                        <button type="button" class="button shadow btn_color right" onclick="check_diff();" style="margin-right: 5px;">Check Qty</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="confirm_content3" style="display:none">
            <div class="logout-containerr">
                <button type="button" class="close" data-confirmmodal-but="close">×</button>
                <input type="hidden" id="modal_result" name="modal_result" value="No" />
                <div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Do you want to save? </div>
                <div class="confirmModal_content">
                    <p>There is difference in quantity, Do you want to save?</p>
                </div>
                <div class="confirmModal_footer">
                    <button type="button" class="btn " data-confirmmodal-but="ok">Yes</button>
                    <button type="button" class="btn " data-confirmmodal-but="cancel">No</button>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">There is difference in quantity, Do you want to save? </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="modal-btn-si">Yes</button>
                        <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert" role="alert" id="result"></div>

        <?php $this->load->view('templates/footer2');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script src="<?php echo base_url(); ?>css/select2/js/select2.full.min.js"></script> 

        <!-- <script src="<?php //echo base_url(); ?>sales_rep/js/loading.js"></script> -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw"></script>
        <script>
            $('document').ready(function(){
                if(navigator.geolocation) {
                    var location_timeout = setTimeout("geolocFail()", 500000);

                    navigator.geolocation.getCurrentPosition(function(location) {
                        clearTimeout(location_timeout);

                        $("#latitude").val(location.coords.latitude);
                        $("#longitude").val(location.coords.longitude);

                        // console.log('latitude'+location.coords.latitude);
                        // console.log('longitude'+location.coords.longitude);
                        // document.getElementById("Saver").disabled = false;
                        // document.getElementById("followup_anc").style.display = "block";
                        // document.getElementById("pl_ord").disabled = false;
                    }, function(error) {
                        clearTimeout(location_timeout);
                        geolocFail();
                    });
                } else {
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
             
            /*  $('#distributor_id').change(function(){
                $('#distributor_name').val($('#distributor_id option:selected').text());

                var distributor_id = $('#distributor_id').val();
                  if(distributor_id.indexOf('_')!=false){
                     distributor_id = distributor_id.substr(distributor_id.indexOf('_')+1);
                  }
                 //console.log(distributor_id);

                $.ajax({
                        url:'<?php // echo base_url(); ?>index.php/Sales_rep_location/get_distributor_details',
                        method: 'post',
                        data: {distributor_id: distributor_id},
                        dataType: 'json',
                        async: false,
                        success: function(response){
                          //console.log(response);
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
            */
             
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
                
                //get_retailer();
            }
            
            var get_retailer = function(){
                var zone_id = $('#zone_id').val();
                var area_id = $('#area_id').val();
                var location_id = $('#location_id').val();
                var distributor_id = $('#distributor_id').val();
                var dist_type = $("#distributor_type").val();
                // alert(dist_type);
                $.ajax({
                    url:'<?=base_url()?>index.php/Sales_rep_location/get_retailer',
                    method: 'post',
                    data: {zone_id: zone_id, area_id: area_id ,location_id:location_id,dist_type:dist_type,distributor_id:distributor_id},
                    dataType: 'html',
                    async: false,
                    success: function(response){
                        $('#distributor_id').html(response);
                        $('#distributor_id').val(distributor_id);
                    }
                });

                check_po();
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
            $('.datepicker').pickadate({
                format:'dd/mm/yyyy',
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 15 ,// Creates a dropdown of 15 years to control year
                container:'body'
            });
            // $('select').formSelect();
        </script>
        <script>
            $(document).ready(function(){
                $('.modal').modal();
                $('.select2').select2({width: "100%"});
            });
        </script>

        <script>
            $('#Saver').on('click', function(){
                if ($("#form_sales_rep_location_details").valid()) {
                    // console.log('confirm modal');

                    var dist_type = $('#distributor_type').val();

                    if($('#mid').val()=="" && $('#channel_type').val()=="GT" && dist_type=='New'){
                        $('#confirm_content').confirmModal({
                            topOffset: 0,
                            onOkBut: function() {
                               $("#loading").show();
                               $('#ispermenant').val('Yes');
                               $("#form_sales_rep_location_details").submit();
                            },
                            onCancelBut: function() {
                               $("#loading").show();
                               $('#place_order').val("No");
                               $('#ispermenant').val('No');
                               $("#form_sales_rep_location_details").submit();
                            },   
                            onLoad: function() {},
                            onClose: function() {}
                        });
                        return false;
                    } else {
                        $("#form_sales_rep_location_details").submit();
                    }
                }
            });
        </script>

        <script>
            $("#pl_ord").on('click',function(){
                if (!$("#form_sales_rep_location_details").valid()) {
                    return false;
                } else {
                    var dist_type = $('#distributor_type').val(); 
                    var sequence_count = $('#sequence_count').val();

                    if(sequence_count=="") {
                        sequence_count = 1;
                    }
                    var sequence = $('#sequence').val();

                    if($(this).attr('id')!='Saver') {
                        $('#confirm_content2').confirmModal({
                            topOffset: 0,
                            onOkBut: function() {$("#loading").show();$('#place_order').val("Yes"); $('#ispermenant').val('Yes');$('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                            onCancelBut: function() {$("#loading").show();$('#place_order').val("No"); $('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
                            onLoad: function() {$('#place_order').val("No"); },
                            onClose: function() {$('#place_order').val("No"); }
                        });   
                    } else {
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
                } else {
                    get_location();
                }
                $('.collapsible').collapsible();

                getselectdiv(document.getElementById('channel_type'));
            });
         
             // $(document).ready(function () {
             //     $("#channel_type").click();
             // });
             
            var segment_uri = '<?=$this->uri->segment(3)?>';

            function getselectdiv(elem) {
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
                            if($('#store_id').val()==data['store_id']){
                                option+='<option value="'+data['store_id']+'"  selected>'+data['store_name']+'</option>';
                            } else {
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
                var id = $('#id').val();
                // console.log(store_id);
                var zone_id = $('#zone_id').val();
                $.ajax({
                    url:'<?=base_url()?>index.php/Sales_rep_location/get_location_data',
                    method: 'post',
                    data: {store_id: store_id,zone_id:zone_id,id:id},
                    dataType: 'json',
                    async:false,
                    success: function(response){
                        // console.log(response);

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
                if(channel_type=='GT') {
                    type = 'GT';
                } else {
                    type = 'MT';
                }

                $.ajax({
                    url:'<?=base_url()?>index.php/Sales_rep_store_plan/get_zone',
                    method: 'post',
                    data: {type:type},
                    dataType: 'json',
                    async:false,
                    success: function(response){
                    // console.log(response);
                    $('#zone_id').find('option').not(':first').remove();
                    $.each(response,function(index,data){
                        $('#zone_id').append('<option value="'+data['zone_id']+'">'+data['zone']+'</option>');
                    });
                    }
                });
            }
        </script>
        <script type="text/javascript">
            function set_radio_button(val,elem) { 
                $('#type_id_'+val).val(elem.value);
            }

            function qty_change(elem) {
                var id = elem.id;
                var explode = id.split('_');
                var index = explode[1];
                var type = $('#type_id_'+index).val();
            }
        </script>

        <script type="text/javascript">
            $('document').ready(function(){
                // $('#channel_type').val('MT');
                // distributor_type_change();
                // $('#zone_id').val('16');
                // $('#reation_id').val('2');
                // $('#location_id').val('352');
                
                //initialize all modals
                $('#myModal1').modal({
                    dismissible: true, backdrop: 'static', keyboard: false
                });

                check_po()
            });

            var check_po = function() {
                // console.log('check po');

                var channel_type = $('#channel_type').val();
                var zone_id = $('#zone_id').val();
                var store_id = $('#reation_id').val();
                var location_id = $('#location_id').val();
                var po_id = $('#po_id').val();

                // console.log(zone_id);
                // console.log(store_id);
                // console.log(location_id);
                // console.log(po_id);

                if(channel_type=='MT' && zone_id!='' && reation_id!='' && location_id!=''){
                    $.ajax({
                        url:'<?=base_url()?>index.php/Sales_rep_location/get_po_nos',
                        method: 'post',
                        data: {zone_id: zone_id, store_id: store_id, location_id: location_id},
                        dataType: 'json',
                        async:false,
                        success: function(response){
                            $('#po_id').find('option').remove();
                            $.each(response,function(index,data){
                                $('#po_id').append('<option value="'+data['id']+'">'+data['po_number']+'</option>');
                            });

                            if(po_id!='' && po_id!=null){
                                // console.log('po_id '+po_id);
                                $('#po_id').val(po_id);
                            } else {
                                // console.log('po_id len '+$('#po_id option').length);
                                if($('#po_id option').length>0){
                                    $("#po_id").val($("#po_id option:first").val()).trigger('change');
                                }
                            }

                            po_id = $('#po_id').val();
                            if(po_id!='' && po_id!=null){
                                get_po_data();

                                // $("#myModal1").modal('toggle');
                                // $('#myModal1').modal('open');

                                // $('#myModal1').modal({backdrop: 'static', keyboard: false});

                                if(!$('#myModal1').is(':visible')){
                                    $('#myModal1').modal('open');
                                }

                                // $('#myModall').modal({
                                //     backdrop: 'static',
                                //     keyboard: true, 
                                //     show: true
                                // }); 
                            }
                        }
                    });
                }
            }

            var get_po_data = function() {
                var channel_type = $('#channel_type').val();
                var zone_id = $('#zone_id').val();
                var store_id = $('#reation_id').val();
                var location_id = $('#location_id').val();
                var po_id = $('#po_id').val();

                // console.log(zone_id);
                // console.log(store_id);
                // console.log(location_id);
                // console.log(po_id);

                $.ajax({
                    url:'<?=base_url()?>index.php/Sales_rep_location/get_po_data',
                    method: 'post',
                    data: {zone_id: zone_id, store_id: store_id, location_id: location_id, po_id: po_id},
                    dataType: 'json',
                    async:false,
                    success: function(response){
                        // console.log(response);

                        $.each(response,function(index,data){
                            $('#po_orange_bar_qty').val(data['orange_bar_qty']);
                            $('#po_orange_bar_val').html(data['orange_bar_qty']);
                            if(parseInt(data['orange_bar_qty'])==0) $('#po_orange_bar_div').hide();
                            else $('#po_orange_bar_div').show();
                            $('#po_butterscotch_bar_qty').val(data['butterscotch_bar_qty']);
                            $('#po_butterscotch_bar_val').html(data['butterscotch_bar_qty']);
                            if(parseInt(data['butterscotch_bar_qty'])==0) $('#po_butterscotch_bar_div').hide();
                            else $('#po_butterscotch_bar_div').show();
                            $('#po_chocopeanut_bar_qty').val(data['chocopeanut_bar_qty']);
                            $('#po_chocopeanut_bar_val').html(data['chocopeanut_bar_qty']);
                            if(parseInt(data['chocopeanut_bar_qty'])==0) $('#po_chocopeanut_bar_div').hide();
                            else $('#po_chocopeanut_bar_div').show();
                            $('#po_bambaiyachaat_bar_qty').val(data['bambaiyachaat_bar_qty']);
                            $('#po_bambaiyachaat_bar_val').html(data['bambaiyachaat_bar_qty']);
                            if(parseInt(data['bambaiyachaat_bar_qty'])==0) $('#po_bambaiyachaat_bar_div').hide();
                            else $('#po_bambaiyachaat_bar_div').show();
                            $('#po_mangoginger_bar_qty').val(data['mangoginger_bar_qty']);
                            $('#po_mangoginger_bar_val').html(data['mangoginger_bar_qty']);
                            if(parseInt(data['mangoginger_bar_qty'])==0) $('#po_mangoginger_bar_div').hide();
                            else $('#po_mangoginger_bar_div').show();
                            $('#po_berry_blast_bar_qty').val(data['berry_blast_bar_qty']);
                            $('#po_berry_blast_bar_val').html(data['berry_blast_bar_qty']);
                            if(parseInt(data['berry_blast_bar_qty'])==0) $('#po_berry_blast_bar_div').hide();
                            else $('#po_berry_blast_bar_div').show();
                            $('#po_chyawanprash_bar_qty').val(data['chyawanprash_bar_qty']);
                            $('#po_chyawanprash_bar_val').html(data['chyawanprash_bar_qty']);
                            if(parseInt(data['chyawanprash_bar_qty'])==0) $('#po_chyawanprash_bar_div').hide();
                            else $('#po_chyawanprash_bar_div').show();

                            $('#po_orange_box_qty').val(data['orange_box_qty']);
                            $('#po_orange_box_val').html(data['orange_box_qty']);
                            if(parseInt(data['orange_box_qty'])==0) $('#po_orange_box_div').hide();
                            else $('#po_orange_box_div').show();
                            $('#po_butterscotch_box_qty').val(data['butterscotch_box_qty']);
                            $('#po_butterscotch_box_val').html(data['butterscotch_box_qty']);
                            if(parseInt(data['butterscotch_box_qty'])==0) $('#po_butterscotch_box_div').hide();
                            else $('#po_butterscotch_box_div').show();
                            $('#po_chocopeanut_box_qty').val(data['chocopeanut_box_qty']);
                            $('#po_chocopeanut_box_val').html(data['chocopeanut_box_qty']);
                            if(parseInt(data['chocopeanut_box_qty'])==0) $('#po_chocopeanut_box_div').hide();
                            else $('#po_chocopeanut_box_div').show();
                            $('#po_bambaiyachaat_box_qty').val(data['bambaiyachaat_box_qty']);
                            $('#po_bambaiyachaat_box_val').html(data['bambaiyachaat_box_qty']);
                            if(parseInt(data['bambaiyachaat_box_qty'])==0) $('#po_bambaiyachaat_box_div').hide();
                            else $('#po_bambaiyachaat_box_div').show();
                            $('#po_mangoginger_box_qty').val(data['mangoginger_box_qty']);
                            $('#po_mangoginger_box_val').html(data['mangoginger_box_qty']);
                            if(parseInt(data['mangoginger_box_qty'])==0) $('#po_mangoginger_box_div').hide();
                            else $('#po_mangoginger_box_div').show();
                            $('#po_berry_blast_box_qty').val(data['berry_blast_box_qty']);
                            $('#po_berry_blast_box_val').html(data['berry_blast_box_qty']);
                            if(parseInt(data['berry_blast_box_qty'])==0) $('#po_berry_blast_box_div').hide();
                            else $('#po_berry_blast_box_div').show();
                            $('#po_chyawanprash_box_qty').val(data['chyawanprash_box_qty']);
                            $('#po_chyawanprash_box_val').html(data['chyawanprash_box_qty']);
                            if(parseInt(data['chyawanprash_box_qty'])==0) $('#po_chyawanprash_box_div').hide();
                            else $('#po_chyawanprash_box_div').show();
                            $('#po_variety_box_qty').val(data['variety_box_qty']);
                            $('#po_variety_box_val').html(data['variety_box_qty']);
                            if(parseInt(data['variety_box_qty'])==0) $('#po_variety_box_div').hide();
                            else $('#po_variety_box_div').show();

                            $('#po_chocolate_cookies_qty').val(data['chocolate_cookies_qty']);
                            $('#po_chocolate_cookies_val').html(data['chocolate_cookies_qty']);
                            if(parseInt(data['chocolate_cookies_qty'])==0) $('#po_chocolate_cookies_div').hide();
                            else $('#po_chocolate_cookies_div').show();
                            $('#po_dark_chocolate_cookies_qty').val(data['dark_chocolate_cookies_qty']);
                            $('#po_dark_chocolate_cookies_val').html(data['dark_chocolate_cookies_qty']);
                            if(parseInt(data['dark_chocolate_cookies_qty'])==0) $('#po_dark_chocolate_cookies_div').hide();
                            else $('#po_dark_chocolate_cookies_div').show();
                            $('#po_cranberry_cookies_qty').val(data['cranberry_cookies_qty']);
                            $('#po_cranberry_cookies_val').html(data['cranberry_cookies_qty']);
                            if(parseInt(data['cranberry_cookies_qty'])==0) $('#po_cranberry_cookies_div').hide();
                            else $('#po_cranberry_cookies_div').show();

                            $('#po_cranberry_orange_zest_qty').val(data['cranberry_orange_zest_qty']);
                            $('#po_cranberry_orange_zest_val').html(data['cranberry_orange_zest_qty']);
                            if(parseInt(data['cranberry_orange_zest_qty'])==0) $('#po_cranberry_orange_zest_div').hide();
                            else $('#po_cranberry_orange_zest_div').show();
                            $('#po_fig_raisins_qty').val(data['fig_raisins_qty']);
                            $('#po_fig_raisins_val').html(data['fig_raisins_qty']);
                            if(parseInt(data['fig_raisins_qty'])==0) $('#po_fig_raisins_div').hide();
                            else $('#po_fig_raisins_div').show();
                            $('#po_papaya_pineapple_qty').val(data['papaya_pineapple_qty']);
                            $('#po_papaya_pineapple_val').html(data['papaya_pineapple_qty']);
                            if(parseInt(data['papaya_pineapple_qty'])==0) $('#po_papaya_pineapple_div').hide();
                            else $('#po_papaya_pineapple_div').show();

                            if(parseInt(data['orange_bar_qty'])==0 && parseInt(data['butterscotch_bar_qty'])==0 && parseInt(data['chocopeanut_bar_qty'])==0 && parseInt(data['bambaiyachaat_bar_qty'])==0 && parseInt(data['mangoginger_bar_qty'])==0 && parseInt(data['berry_blast_bar_qty'])==0 && parseInt(data['chyawanprash_bar_qty'])==0) $('#bars_list').hide();
                            else $('#bars_list').show();

                            if(parseInt(data['orange_box_qty'])==0 && parseInt(data['butterscotch_box_qty'])==0 && parseInt(data['chocopeanut_box_qty'])==0 && parseInt(data['bambaiyachaat_box_qty'])==0 && parseInt(data['mangoginger_box_qty'])==0 && parseInt(data['berry_blast_box_qty'])==0 && parseInt(data['chyawanprash_box_qty'])==0 && parseInt(data['variety_box_qty'])==0) $('#box_list').hide();
                            else $('#box_list').show();

                            if(parseInt(data['chocolate_cookies_qty'])==0 && parseInt(data['dark_chocolate_cookies_qty'])==0 && parseInt(data['cranberry_cookies_qty'])==0) $('#cookies_list').hide();
                            else $('#cookies_list').show();

                            if(parseInt(data['cranberry_orange_zest_qty'])==0 && parseInt(data['fig_raisins_qty'])==0 && parseInt(data['papaya_pineapple_qty'])==0) $('#trailmix_list').hide();
                            else $('#trailmix_list').show();

                            get_difference();
                        });
                    }
                });
            }

            var get_diff_by_elem = function(elem) {
                var id = elem.id;

                var po_qty = parseInt($('#'+id+'_qty').val());
                var physical_qty = parseInt(elem.value);

                if(isNaN(po_qty) || po_qty=='' || po_qty==null) po_qty = 0;
                if(isNaN(physical_qty) || physical_qty=='' || physical_qty==null) physical_qty = 0;

                var diff_qty = physical_qty - po_qty;

                $('#'+id+'_diff').val(diff_qty);
                $('#'+id+'_diff_val').html(diff_qty);
            }

            var get_difference = function() {
                $('.po_qty').each(function(){
                    get_diff_by_elem(this);;
                });
            }

            var check_diff = function() {
                $('.check_diff').show();
            }

            var modalConfirm = function(callback){
                $("#btn-confirm").on("click", function(){
                    $("#mi-modal").modal('show');
                });

                $("#modal-btn-si").on("click", function(){
                    callback(true);
                    $("#mi-modal").modal('hide');
                });

                $("#modal-btn-no").on("click", function(){
                    callback(false);
                    $("#mi-modal").modal('hide');
                });
            };

            modalConfirm(function(confirm){
                if(confirm){
                    $("#modal_result").val("Yes");

                    save_po_qty();
                } else {
                    $("#modal_result").val("No");
                    
                    check_diff();
                }
            });

            var save_po_qty = function() {
                if($("#modal_result").val()=="No"){
                    var bl_valid = true;

                    $('.diff_qty').each(function(){
                        if($(this).val()!=''){
                            if($(this).val()!=0){
                                bl_valid = false;
                            }
                        }
                    });

                    if(bl_valid==false){
                        // $("#mi-modal").modal('show');
                        confirm_save();
                    } else {
                        $("#modal_result").val("Yes");
                    }
                }
                
                // console.log($("#modal_result").val());

                if($("#modal_result").val()=="Yes"){
                    $.ajax({
                        url:'<?=base_url()?>index.php/Sales_rep_store_plan/save_po_qty',
                        method: 'post',
                        data: $('#form_po_qty_details').serialize(),
                        dataType: 'html',
                        async:false,
                        success: function(response){
                            // console.log(response);

                            check_po();

                            if($('#po_id option').length>0){
                                $("#po_id").focus();
                            } else {
                                // $("#myModal1").modal('toggle');
                                // $("#myModal1").hide();
                                $('#myModal1').modal('close');
                            }
                        }
                    });
                }
            }

            var confirm_save = function() {
                $('#confirm_content3').confirmModal({
                    topOffset: 0,
                    onOkBut: function() {
                        $('#modal_result').val("Yes");
                        save_po_qty();
                    },
                    onCancelBut: function() {
                        $('#modal_result').val("No");
                    },   
                    onLoad: function() {},
                    onClose: function() {}
                });
            }
        </script>
    </body>
</html>