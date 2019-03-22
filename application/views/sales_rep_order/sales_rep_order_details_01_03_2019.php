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
         .collapsible-header
         {
         color: #0c2c4e!important;
         }
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
         . {
         position: relative;
         height: 26px;
         width: 120px;
         margin: 20px auto;
         background: rgba(0, 0, 0, 0.25);
         border-radius: 3px;
         -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
         box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
         }
         .-label {
         position: relative;
         z-index: 2;
         float: left;
         width: 58px;
         line-height: 26px;
         font-size: 11px;
         color: rgba(255, 255, 255, 0.35);
         text-align: center;
         text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
         cursor: pointer;
         }
         .-label:active {
         font-weight: bold;
         }
         .-label-off {
         padding-left: 2px;
         }
         .-label-on {
         padding-right: 2px;
         }
         . {
         display: none;
         }
         .:checked + .-label {
         font-weight: bold;
         color: rgba(0, 0, 0, 0.65);
         text-shadow: 0 1px rgba(255, 255, 255, 0.25);
         -webkit-transition: 0.15s ease-out;
         -moz-transition: 0.15s ease-out;
         -ms-transition: 0.15s ease-out;
         -o-transition: 0.15s ease-out;
         transition: 0.15s ease-out;
         -webkit-transition-property: color, text-shadow;
         -moz-transition-property: color, text-shadow;
         -ms-transition-property: color, text-shadow;
         -o-transition-property: color, text-shadow;
         transition-property: color, text-shadow;
         }
         .:checked + .-label-on ~ . {
         left: 60px;
         /* Note: left: 50%; doesn't transition in WebKit */
         }
         . {
         position: absolute;
         z-index: 1;
         top: 2px;
         left: 2px;
         display: block;
         width: 58px;
         height: 22px;
         border-radius: 3px;
         background-color: #65bd63;
         background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #9dd993), color-stop(100%, #65bd63));
         background-image: -webkit-linear-gradient(top, #9dd993, #65bd63);
         background-image: -moz-linear-gradient(top, #9dd993, #65bd63);
         background-image: -ms-linear-gradient(top, #9dd993, #65bd63);
         background-image: -o-linear-gradient(top, #9dd993, #65bd63);
         background-image: linear-gradient(top, #9dd993, #65bd63);
         -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
         box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
         -webkit-transition: left 0.15s ease-out;
         -moz-transition: left 0.15s ease-out;
         -ms-transition: left 0.15s ease-out;
         -o-transition: left 0.15s ease-out;
         transition: left 0.15s ease-out;
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
        /*#stock_entry 
        {
          width:100%!important;
        }*/
      </style>
   <body>
      <!-- START PAGE CONTAINER -->
      <div class="navbar">
         <?php $this->load->view('templates/header2');?>
      </div>
      <?php $this->load->view('templates/menu2');?> 
      <div class="contact app-pages app-section" style="margin:50 auto">
      <div class="container">
         <div id="basic-form" class="section">
            <div class="row">
               <div class="col s12">
                  <div class="card-panel">
                     <div class="row">
                        <?php
                           $visit_detail = '';
                           if($this->session->userdata('visit_detail')!=null)
                           {
                               $visit_detail = $this->session->userdata('visit_detail');
                               
                           }
                           
                           $retailer_detail  = $this->session->userdata('retailer_detail');
                           
                           if($visit_detail!=''){
                              if ($visit_detail['distributor_types']!='' && $visit_detail['distributor_types']=='New')
                              {
                                 $style='display:block';
                                 $style2 = 'display:none';
                              }
                                  
                           };
                           ?> 
                        <!-- START PAGE CONTAINER -->
                        <!-- PAGE CONTENT -->
                        <div class="app-title">
                           <h5>Order Details</h5>
                        </div>
                        <hr>
                        <!-- PAGE CONTENT WRAPPER -->
                        <form id="form_sales_rep_order_details" role="form" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep_location/save/' . $data[0]->id; else echo base_url().'index.php/Sales_rep_store_plan/save_order'; ?>">
                           <div class="row">
                              <div class="col s12">
                                 <div class="input-field col s3">
                                    <label for="dob">Date</label>
                                 </div>
                                 <div class="input-field col s9"   style="top:0.8rem;color:#000!important;">
                                    <input type="hidden" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                    <input type="hidden"  name="date_of_processing" id="date_of_processing" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                    <?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>
                                 </div>
                              </div>
                           </div>
                           

                             <?php 
                                if(isset($distributor_name))
                                  $style = 'display:block';
                                else
                                  $style = 'display:none';
                             ?>
                             <div class="row"  style='<?=$style;?>'>
                                <br>
                                <div class="col s12">
                                   <div class="input-field col s3" >
                                      <label>Retailer <span class="asterisk_sign">*</span></label>
                                   </div>
                                   <div class="input-field col s9">
                                      <?=(isset($distributor_name)?$distributor_name:'')?>
                                   </div>
                                </div>
                             </div>
                             <?php 
                              if(isset($zone))
                                $style = 'display:block';
                              else
                                $style = 'display:none';
                             ?>
                             <div class="row"  style='<?=$style;?>'>
                              <br>
                                <div class="col s12">
                                   <div class="input-field col s3" >
                                      <label>Zone <span class="asterisk_sign">*</span></label>
                                   </div>
                                   <div class="input-field col s9">
                                      <?=(isset($zone)?$zone:'')?>
                                   </div>
                                </div>
                            </div>

                             <?php 
                                if(isset($visit_detail['channel_type']))
                                {
                                  if($visit_detail['channel_type']=='MT')
                                    $style = 'display:block';
                                  else
                                    $style = 'display:none';
                                }
                                else
                                {
                                  $style = 'display:none';
                                }
                             ?>
                             <div class="row"  style='<?=$style;?>'>
                                <div class="col s12">
                                   <div class="input-field col s3" >
                                      <label>Relation <span class="asterisk_sign">*</span></label>
                                   </div>
                                   <div class="input-field col s9">
                                      <?=(isset($store_name)?$store_name:'')?>
                                   </div>
                                </div>
                             </div>


                           <?php 
                            if(isset($area))
                              $style = 'display:block';
                            else
                              $style = 'display:none';
                           ?>
                           <div class="row"  style='<?=$style;?>'>
                              <div class="col s12">
                                 <div class="input-field col s3" >
                                    <label>Area <span class="asterisk_sign">*</span></label>
                                 </div>
                                 <div class="input-field col s9">
                                    <?=(isset($area)?$area:'')?>
                                 </div>
                              </div>
                           </div>

                           <?php 
                            if(isset($location))
                              $style = 'display:block';
                            else
                              $style = 'display:none';
                           ?>
                           <div class="row"  style='<?=$style;?>'>
                             <div class="col s12">
                               <div class="input-field col s3" >
                                  <label>Location <span class="asterisk_sign">*</span></label>
                               </div>
                               <div class="input-field col s9">
                                  <?=(isset($location)?$location:'')?>
                               </div>
                             </div>
                           </div>

                          


                            <input type="hidden" class="form-control" name="id" id="id" value="<?php 
                                     if(isset($id)){
                                       if($id!='') echo $id;
                                     }
                                     ?>"/>
                           <?php 
                              if(isset($distributor_name))
                              {
                                $style = 'display:block';

                              }
                           ?>
                            
                           <div class="row" >
                              <div class="col s12">
                                 <div class="input-field col s3" >
                                    <label>Distributor  <span class="asterisk_sign">*</span></label>
                                 </div>
                                 <div class="input-field col s9">
                                    <select name="distributor_id" id="distributor_id" class="browser-default">
                                       <option value="">Select</option>
                                       <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                       <option value="<?php echo $distributor[$k]->id; ?>" <?php  

                                       if($distributor[$k]->id==$selected_distributor ) { echo 'selected'; } ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                       <?php }} ?>
                                    </select>
                                 </div>
                                 </div>
                              </div>
                              <input type="hidden" class="form-control" name="id" id="id" value="<?php 
                                       if(isset($id)){
                                         if($id!='') echo $id;
                                       }
                                       ?>"/>
                              <input type="hidden" class="form-control" name="place_order" id="place_order" value="No"/>
                           <div class="row" id='stock_entry'>
                                <ul class="collapsible">
                                    <li>
                                       <div class="collapsible-header active" ><i class="material-icons">add</i> <strong>Bars</strong></div>
                                       <div class="collapsible-body">
                                          <div class="">
                                             <div class="app-title">
                                                <h5>Order Quantities</h5>
                                             </div>
                                             <hr>
                                             <div class="row">
                                                <div class="col s12">
                                                   <div class="input-field col s4">
                                                      <label class="">Orange<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s3">
                                                      <input type="number"   value="<?php
                                                         if(isset($order_detail['orange']))
                                                         {
                                                            if($order_detail['orange']!=NULL)
                                                            {
                                                               $ex = explode('_',$order_detail['orange']);
                                                               echo $ex[0];
                                                            }
                                                         } 
                                                         ?>" 
                                                         class="form-control qty" name="orange_bar" placeholder="0" id="type_0" onblur="qty_change(this)"/>
                                                   </div>
                                                   <div class="input-field col s5">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type" value="Bar" id="bar_o" onchange="" onclick="set_radio_button(0,this)" 
                                                            <?php 
                                                               if(isset($ex))
                                                               {
                                                                  if($ex[1]=='Bar')
                                                                     echo 'checked';
                                                               }
															   else
                                                                   echo 'checked';
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
                                                               
                                                               ?>
                                                            >
                                                         <label for="bar_o1" class="">Box</label>
                                                         <span class=""></span>
                                                      </div>
                                                      <input type="hidden" name="type_0" id="type_id_0" class="type" 
                                                         value="<?=(isset($ex)?$ex[1]:'Bar')?>">
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s4">
                                                      <label class="">Butterscotch<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s3">
                                                      <input type="number" value="<?php
                                                         if(isset($order_detail['butterscotch']))
                                                         {
                                                            if($order_detail['butterscotch']!=NULL)
                                                            {
                                                               $ex1 = explode('_',$order_detail['butterscotch']);
                                                               echo $ex1[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="butterscotch_bar" placeholder="0" id="type_1"/>  
                                                   </div>
                                                   <div class="input-field col s5">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type1" value="Bar" id="box_bs" onclick="set_radio_button(1,this)"  checked="">
                                                         <label for="box_bs"  
                                                            <?php 
                                                               if(isset($ex1))
                                                               {
                                                                  if($ex1[1]=='Bar')
                                                                     echo 'checked';
                                                               }
															   else
                                                                   echo 'checked';
                                                               ?>>Bar</label>
                                                         <input type="radio" class="" name="bar_type1" value="Box" id="box_bs1" onclick="set_radio_button(1,this)"
                                                            <?php 
                                                               if(isset($ex1))
                                                               {
                                                                  if($ex1[1]=='Box')
                                                                     echo 'checked';
                                                               }
                                                               ?>>
                                                         <label for="box_bs1" class="">Box</label> 
                                                         <span class=""></span>
                                                      </div>
                                                      <input type="hidden" name="type_1" id="type_id_1" class="type" value="<?=(isset($ex1)?$ex1[1]:'Bar')?>">
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s4">
                                                      <label class="">Choco<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s3">
                                                      <input type="number" value="<?php
                                                         if(isset($order_detail['chocopeanut']))
                                                         {
                                                            if($order_detail['chocopeanut']!=NULL)
                                                            {
                                                               $ex2 = explode('_',$order_detail['chocopeanut']);
                                                               echo $ex2[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="chocopeanut_bar" placeholder="0" id="type_3"/>
                                                   </div>
                                                   <div class="input-field col s5">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type3" value="Bar" id="bar_co" onclick="set_radio_button(3,this)" <?php 
                                                            if(isset($ex2))
                                                            {
                                                               if($ex2[1]=='Bar')
                                                                  echo 'checked';
                                                            }
															 else
                                                               echo 'checked';
                                                            ?>>
                                                         <label for="bar_co" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type3" value="Box" id="box_co3" onclick="set_radio_button(3,this)" <?php 
                                                            if(isset($ex2))
                                                            {
                                                               if($ex2[1]=='Box')
                                                                  echo 'checked';
                                                            }

                                                            ?>>
                                                         <label for="box_co3" class="">Box</label>
                                                         <span class=""></span>
                                                      </div>
                                                      <input type="hidden" name="type_3" id="type_id_3" class="type" value="<?=(isset($ex2)?$ex2[1]:'Bar')?>">
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s4">
                                                      <label class="">Chaat<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s3">
                                                      <input type="number" value="<?php
                                                         if(isset($order_detail['bambaiyachaat']))
                                                         {
                                                            if($order_detail['bambaiyachaat']!=NULL)
                                                            {
                                                               $ex3 = explode('_',$order_detail['bambaiyachaat']);
                                                               echo $ex3[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="bambaiyachaat_bar" placeholder="0" id="type_4"/>
                                                   </div>
                                                   <div class="input-field col s5">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type4" value="Bar" id="bar_ch1" onclick="set_radio_button(4,this)"   <?php if(isset($ex3))
                                                            {
                                                               if($ex3[1]=='Bar')
                                                                  echo 'checked';
                                                            }
															else
                                                               echo 'checked';

                                                            ?>>
                                                         <label for="bar_ch1" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type4" value="Box" id="box_ch1" onclick="set_radio_button(4,this)" <?php if(isset($ex3))
                                                            {
                                                               if($ex3[1]=='Box')
                                                                  echo 'checked';
                                                            }
                                                            
                                                            ?>>
                                                         <label for="box_ch1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_4" id="type_id_4" class="type" value="<?=(isset($ex3)?$ex3[1]:'Bar')?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s4">
                                                      <label class="">Mango<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s3">
                                                      <input type="number" value="<?php
                                                         if(isset($order_detail['mangoginger']))
                                                         {
                                                            if($order_detail['mangoginger']!=NULL)
                                                            {
                                                               $ex4 = explode('_',$order_detail['mangoginger']);
                                                               echo $ex4[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="mangoginger_bar" placeholder="0"
                                                         id="type_5"/>
                                                   </div>
                                                   <div class="input-field col s5">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type5" value="Bar" id="bar_m" onclick="set_radio_button(5,this)" <?php if(isset($ex4))
                                                            {
                                                               if($ex4[1]=='Bar')
                                                                  echo 'checked';
                                                            }
															else
                                                               echo 'checked';
                                                            ?>>
                                                         <label for="bar_m" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type5" value="Box" id="bar_m1" onclick="set_radio_button(5,this)" <?php if(isset($ex4))
                                                            {
                                                               if($ex4[1]=='Box')
                                                                  echo 'checked';
                                                            }
                                                             
                                                            ?>>
                                                         <label for="bar_m1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_5" id="type_id_5" value="<?=(isset($ex4)?$ex4[1]:'Bar')?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s4">
                                                      <label class="">Berry<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s3">
                                                      <input type="number" value="<?php if(isset($order_detail['berry_blast']))
                                                         {
                                                            if($order_detail['berry_blast']!=NULL)
                                                            {
                                                               $ex5 = explode('_',$order_detail['berry_blast']);
                                                               echo $ex5[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="berry_blast_bar" placeholder="0" id="type_6"/>
                                                   </div>
                                                   <div class="input-field col s5">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type6" value="Bar" id="bar_bb" onclick="set_radio_button(6,this)" 
                                                            <?php 
                                                               if(isset($ex5))
                                                                  {
                                                                     if($ex5[1]=='Bar')
                                                                        echo 'checked';
                                                                  }
																  else
                                                                  echo 'checked';
                                                               ?>
                                                            >
                                                         <label for="bar_bb" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type6" value="Box" id="box_bb1" onclick="set_radio_button(6,this)" <?php 
                                                            if(isset($ex5))
                                                               {
                                                                  if($ex5[1]=='Box')
                                                                     echo 'checked';
                                                               }
                                                               
                                                            ?>>
                                                         <label for="box_bb1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_6" id="type_id_6" class="type" value="<?=(isset($ex5)?$ex5[1]:'Bar')?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s4">
                                                      <label class="">Chywanprash<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s3">
                                                      <input type="number" value="<?php
                                                         if(isset($order_detail['chyawanprash']))
                                                         {
                                                            if($order_detail['chyawanprash']!=NULL)
                                                            {
                                                               $ex6 = explode('_',$order_detail['chyawanprash']);
                                                               echo $ex6[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="chyawanprash_bar" placeholder="0"
                                                         id="type_7"/>
                                                   </div>
                                                   <div class="input-field col s5">
                                                      <div class="">
                                                         <input type="radio" class="" name="bar_type7" value="Bar" id="bar_ch" onclick="set_radio_button(7,this)" 
                                                            <?php 
                                                               if(isset($ex6))
                                                                  {
                                                                     if($ex6[1]=='Bar')
                                                                        echo 'checked';
                                                                  }
																else
                                                                  echo 'checked';
                                                               ?>
                                                            >
                                                         <label for="bar_ch" class="">Bar</label>
                                                         <input type="radio" class="" name="bar_type7" value="Box" id="box_ch1" onclick="set_radio_button(7,this)" <?php 
                                                            if(isset($ex6))
                                                               {
                                                                  if($ex6[1]=='Box')
                                                                     echo 'checked';
                                                               }
                                                               
                                                            ?>>
                                                         <label for="box_ch1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_7" id="type_id_7" class="type" value="<?=(isset($ex6)?$ex6[1]:'Bar')?>">
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="col s12">
                                                   <div class="input-field col s4">
                                                      <label class="">Variety Box<span class="asterisk_sign">*</span></label>
                                                   </div>
                                                   <div class="input-field col s3">
												   
												    <input type="number" value="<?php
                                                         if(isset($order_detail['variety_box']))
                                                         {
                                                            if($order_detail['variety_box']!=NULL)
                                                            {
                                                               $ex7 = explode('_',$order_detail['variety_box']);
                                                               echo $ex7[0];
                                                            }
                                                         } 
                                                         ?>" class="form-control qty" name="variety_box" placeholder="0"
                                                         id="type_8"/>
                                                   </div>
                                                                              <div class="input-field col s5">
                                                      <div class="">
                                                         <!-- <input type="radio" class="" name="bar_type8" value="Bar" id="bar_ch" onclick="set_radio_button(7,this)" 
                                                            <?php 
                                                               if(isset($ex7))
                                                                  {
                                                                     if($ex7[1]=='Bar')
                                                                        echo 'checked';
                                                                  }
                                                               
                                                               ?>
                                                            >
                                                         <label for="bar_ch" class="">Bar</label> -->
                                                         <input type="radio" class="" name="bar_type8" value="Box" id="box_ch1" onclick="set_radio_button(7,this)" <?php 
                                                            if(isset($ex7))
                                                               {
                                                                  if($ex7[1]=='Box')
                                                                     echo 'checked';
                                                               }
                                                               else
                                                                  echo 'checked';
                                                            ?>>
                                                         <label for="box_ch1" class="">Box</label>
                                                         <span class=""></span>
                                                         <input type="hidden" name="type_id_8" id="type_id_8" class="type" value="Box">
                                                      </div>
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
                                             <h5>Order Quantities</h5>
                                          </div>
                                          <hr>
                                          <div class="row">
                                             <div class="col s12">
                                                <div class="input-field col s6">
                                                   <label class="">Chocolate <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="input-field col s4">
                                                   <input type="number" value="<?php 
                                                      if(isset($order_detail['chocolate_cookies_box'])) echo $order_detail['chocolate_cookies_box'];
                                                      ?>" class="form-control" name="chocolate_cookies" placeholder="0"/>
                                                </div>
                                             </div>
                                             <div class="col s12">
                                                <div class="input-field col s6">
                                                   <label class=""> Dark Chocolate <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="input-field col s4">
                                                   <input type="number" value="<?php 
                                                      if(isset($order_detail['dark_chocolate_cookies_box'])) echo $order_detail['dark_chocolate_cookies_box'];
                                                      ?>" class="form-control" name="dark_chocolate_cookies" placeholder="0"/>
                                                </div>
                                             </div>
                                             <div class="col s12">
                                                <div class="input-field col s6">
                                                   <label class="">Cranberry <span class="asterisk_sign">*</span></label>
                                                </div>
                                                <div class="input-field col s4">
                                                   <input type="number" value="<?php if(isset($order_detail['cranberry_cookies_box'])) echo $order_detail['cranberry_cookies_box'];?>" class="form-control" name="cranberry_cookies" placeholder="0"/>
                                                </div>
                                             </div>
                                          </div>
                                    </li>
                                    <li>
                                    <div class="collapsible-header "><i class="material-icons">add</i> <strong>TrailMix </strong></div>
                                    <div class="collapsible-body">
                                    <div class="app-title">
                                    <h5>Order Quantities</h5>
                                    </div>
                                    <hr>  
                                    <div class="row">
                                    <div class="col s12">
                                    <div class="input-field col s8">
                                    <label class="">Cranberry & Orange  <span class="asterisk_sign">*</span></label>
                                    </div> 
                                    <div class="input-field col s4">
                                    <input type="number" value="<?php if(isset($order_detail['cranberry_orange_box'])) echo $order_detail['cranberry_orange_box'];?>" class="form-control" name="cranberry_orange_zest" placeholder="0"/>
                                    </div>
                                    </div>
                                    <div class="col s12">
                                    <div class="input-field col s8">
                                    <label class="">Fig & Raisins <span class="asterisk_sign">*</span></label>
                                    </div> 
                                    <div class="input-field col s4">
                                    <input type="number" value="<?php if(isset($order_detail['fig_raisins_box'])) echo $order_detail['fig_raisins_box'];?>" class="form-control" name="fig_raisins" placeholder="0"/>
                                    </div>
                                    </div>
                                    <div class="col s12">
                                    <div class="input-field col s8">
                                    <label class="">Papaya & pineapple<span class="asterisk_sign">*</span></label>
                                    </div> 
                                    <div class="input-field col s4">
                                    <input type="number" value="<?php if(isset($order_detail['papaya_pineapple_box'])) echo $order_detail['papaya_pineapple_box'];?>" class="form-control" name="papaya_pineapple" placeholder="0"/>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </li>
                                 </ul>
                              <div class="row">
                              <div class="col s12">
                              <div class="input-field col s3">
                              <label>Remarks <span class="asterisk_sign"></span></label>
                              </div> 
                              <div class="input-field col s9">
                              <textarea id="textarea1" class="materialize-textarea" class="" name="remarks" id="remarks" value="<?php if(isset($data[0]->remarks)) echo $data[0]->remarks;?>"></textarea>
                              </div> 
                              </div> 
                              </div>             
                              <div class="panel-footer">

                              <a href="javascript:history.back()" class="button shadow btn_color " style="display: inline-block;" type="reset" id="reset">Back</a>
                              <input type="submit" value="Confirm Order" id="Saver" name="srld" class="right button shadow btn_color2 "  style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 22px;font-size:16px;padding: 8px 12px;"/>
                              </div>
                           </div>
                         </form>
                        </div>
                     </div>
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
            </div>
         </div>
      </div>
      <?php $this->load->view('templates/footer2');?>
      <script type="text/javascript">
         var BASE_URL="<?php echo base_url()?>";
      </script>
      <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
      <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
      <script type="text/javascript">
         $(document).ready(function(){
         
             $("#channel_type").attr("disabled", true);
         
         $('select').material_select();
       });
      </script>
      <script>
         $('.datepicker').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 15 // Creates a dropdown of 15 years to control year
          });
            $('select').material_select();
          
      </script>
      <script type="text/javascript">
         function set_radio_button(val,elem)
         { 
            /*alert('entedr');*/
           $('#type_id_'+val).val(elem.value);
           /* alert(elem.value);*/
         }

         function qty_change(elem) {
        
           var id = elem.id;
           var explode = id.split('_');
           var index = explode[1];
           var type = $('#type_id_'+index).val();
           
         }
      </script>
      <!-- END SCRIPTS -->      
   </body>
</html>