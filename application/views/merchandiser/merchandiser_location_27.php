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
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/logout/popModal.css">
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
		h5
		{
			font-size: 0.8rem!important;
			color: #000;
			font-weight: bold;
		}
        .download 
		{
                font-size: 21px;
                color: #5cb85c;
        }
		.delete_row>span
			{
				margin-top:30px!important;
			}
			
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

		
         <!-- START PAGE CONTAINER -->
       
            <!-- PAGE CONTENT -->
			 
            <div class="app-title">
				<h5>Order Details</h5>
			</div>
			
                  <hr>
           
                    <form id="form_sales_rep_location_details" role="form" class="" method="post" enctype="multipart/form-data" action="<?php if (isset($data[0]->mid)) echo base_url(). 'index.php/merchandiser_location/save/' . $data[0]->mid; else echo base_url().'index.php/merchandiser_location/save'; ?>">
					
						<div class="row"  >
                            
                                            <?php
                                                /*echo "<pre>";
                                                print_r($stock_details);
                                                echo "</pre>";*/
                                            ?>
                                    <div class="col s12">
                                       <div class="input-field col s3">
											<label for="dob">Date</label>

										</div> 
											<div class="input-field col s9"   style="top:0.8rem;color:#000!important;">
												<input type="hidden" name="id" id="id" value="<?php if(isset($data[0]->mid)) echo $data[0]->mid;?>"/>
												<input type="hidden"  name="latitude" id="latitude" value="<?php if(isset($data[0]->latitude)) echo $data[0]->latitude;?>"/>
												<input type="hidden"  name="longitude" id="longitude" value="<?php if(isset($data[0]->longitude)) echo $data[0]->longitude;?>"/>
												<input type="hidden"  name="ispermenant" id="ispermenant" value=""/>
												<input type="hidden"  name="seq" id="seq" value="<?php if(isset($data[0]->seq)) echo $data[0]->seq;?>"/>
												<input type="hidden"  name="sequence" id="sequence" value="<?php if(isset($distributor[0]->sequence)) echo $distributor[0]->sequence;?>"/>
                                               <input type="hidden"  name="merchendiser_beat_plan_id" id="merchendiser_beat_plan_id" value="<?php if(isset($distributor[0]->bit_plan_id)) echo $distributor[0]->bit_plan_id;?>"/> 
                                                <input type="hidden"  name="frequency" id="frequency" value="<?php if(isset($distributor[0]->frequency)) echo $distributor[0]->frequency;?>"/>
                                                <input type="hidden"  name="change_sequence" id="change_sequence" value=""/>
                                                <input type="hidden" name="sequence_count" id="sequence_count" value="<?php if(isset($sequence_count)) echo $sequence_count;?>"/>

												<input type="hidden"  name="sales_rep_id" id="sales_rep_id" value="<?php if(isset($distributor[0]->sales_rep_id)) echo $distributor[0]->sales_rep_id;?>"/>
													
												<input type="hidden"  name="seq_id" id="seq_id" value="<?php if(isset($distributor[0]->id)) echo $distributor[0]->id;?>"/>


                                                <input type="hidden"  name="location_id" id="location_id" value="<?php if(isset($distributor[0]->location_id)) echo $distributor[0]->location_id;?>"/>
													
												<input type="hidden" id="latitude1" value="<?php if(isset($distributor[0]->latitude)) echo $distributor[0]->latitude;?>"/>
												<input type="hidden"  id="longitude1" value="<?php if(isset($distributor[0]->longitude)) echo $distributor[0]->longitude;?>"/>

												
												<input type="hidden"  name="date_of_visit" id="date_of_visit" value="<?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
											   <?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>
										  
										  
												
											</div>
                                    </div>
							</div>
						
    						<div class="row" >
    							<div class="col s12">
    							
                                   <div class="input-field col s3">
    								<label>Store Name<span class="asterisk_sign">*</span></label>
    								</div> 
    								<div class="input-field col s9">
    							
                                        <select name="distributor_id" class="browser-default" id="distributor_id">
                                         
                                            <option value="<?php if(isset($distributor)) echo $distributor[0]->store_id;?>"><?php if(isset($distributor)) echo $distributor[0]->store_name; ?></option>
                                        </select>
    									 
    									  
    								</div> 
                                       
                                        
                                </div>
    						</div>
									
								
								
                            <div class="row">
									<div class="col s12">
										<div class="input-field col s3">
											<label>Remarks <span class="asterisk_sign"></span></label>
										</div> 
									<div class="input-field col s9">
                                     <!--store_id is a Retailer id-->
										
										 <textarea id="textarea1" class="materialize-textarea" class="" name="remarks" id="remarks" value="<?php if(isset($data[0]->remarks)) echo $data[0]->remarks;?>"></textarea>
                                           
											
									</div> 
									</div> 
								</div> 
                             

                               <div class="ava_qty">
                                <div class="row" id="bar_details">
								    <div class="col s12 ">	<h5>Orange Bar</h5> </div>
                                <?php $i=0; if(isset($stock_details)) { 
                                        for($i=0; $i<count($stock_details); $i++) {
										if($stock_details[$i]->item_id=='1'){
																			
                                ?>
                                    <div class="col s12 " style="padding-bottom: 3px;">
								
                                        <div class="input-field col s4">
											Orange Bar
                                        <input type="hidden"  class="bar" name="bar[]" id="bar_<?php echo $i;?>"  value="1" >
                                        </div>
										
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                        </div>
                                       
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }}} else { 
                                    // for($i=0; $i<count($bar_details); $i++) { 
                                ?>
                                    <div class="col s12" style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
                                           Orange Bar
                                        </div>
										<input type="hidden" name="bar[]" id="bar_<?php echo $i;?>"  value="1" >
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                        </div>
                                      
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                 
                                </div>
                                <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar">+</button></div>
                                </div><hr>
								
								
								<div class="ava_qty1">
                                <div class="row" id="bar_details1">
								  <div class="col s12 "><h5>Butterscotch Bar</h5> </div>
                                <?php $i=0; if(isset($stock_details)) { 
                                        for($i=0; $i<count($stock_details); $i++) { 
										if($stock_details[$i]->item_id=='3'){
                                ?>
                                    <div class="col s12 " style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
										
                                             Butterscotch Bar 
                                    
                                        <input type="hidden"  class="butterscotch" name="bar[]" id="butterscotch_<?php echo $i;?>"  value="3" >
                                        </div>
										  
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_3_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                        </div>
                                       
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_3_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }}} else { 
                                   // for($i=0; $i<count($bar_details); $i++) { 
                                ?>
                                    <div class="col s12" style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
                                             Butterscotch Bar 
                                        </div>
										<input type="hidden"  class="butterscotch" name="bar[]" id="butterscotch_<?php echo $i;?>"  value="3" >
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_3_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                        </div>
                                      
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_3_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                 
                                </div>
                                <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-3">+</button></div>
                                </div><hr>
								
								
								
								  <div class="ava_qty2">
                                <div class="row" id="bar_details2">
								  <div class="col s12 ">	<h5>  Bambaiya Chaat Bar </h5> </div>
                                <?php $i=0; if(isset($stock_details)) { 
                                        for($i=0; $i<count($stock_details); $i++) { 
										if($stock_details[$i]->item_id=='4'){
                                ?>
                                    <div class="col s12 " style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
										
                                             Bambaiya Chaat Bar 
                                    
                                        <input type="hidden" class="bchaat" name="bar[]" id="bchaat_<?php echo $i;?>"  value="4" >
                                        </div>
										 
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_4_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                        </div>
                                       
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_4_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }}} else { 
                                    //for($i=0; $i<count($bar_details); $i++) { 
                                ?>
                                    <div class="col s12" style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
                                               Bambaiya Chaat Bar 
                                        </div>
										<input type="hidden" class="bchaat" name="bar[]" id="bchaat_<?php echo $i;?>"  value="4" >
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_4_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                        </div>
                                      
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_4_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                 
                                </div>
                                <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-4">+</button></div>
                                </div><hr>
								
								
								
								  <div class="ava_qty3">
                                <div class="row" id="bar_details3">
								<div class="col s12 ">	<h5>    Choco Peanut Butter Bar </h5> </div>
                                <?php $i=0; if(isset($stock_details)) { 
                                        for($i=0; $i<count($stock_details); $i++) { 
										if($stock_details[$i]->item_id=='5'){
                                ?>
                                    <div class="col s12 " style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
										
                                             Choco Peanut Butter Bar 
                                    
                                        <input type="hidden"  class="Choco" name="bar[]" id="Choco_<?php echo $i;?>"  value="5" >
                                        </div>
										   
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_5_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                        </div>
                                       
                                        <div class="input-field col s4">
                                            <select name="batch_no_5_[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }}} else { 
                                   // for($i=0; $i<count($bar_details); $i++) { 
                                ?>
                                    <div class="col s12" style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
                                             Choco Peanut Butter Bar 
                                        </div>
										<input type="hidden"  class="Choco" name="bar[]" id="Choco_<?php echo $i;?>"  value="12" >
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_5_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                        </div>
                                      
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                 
                                </div>
                                <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-5">+</button></div>
                                </div><hr>
								
								
								
								
								  <div class="ava_qty4">
                                <div class="row" id="bar_details4">
								<div class="col s12 ">	<h5>     Berry Blast Bar  </h5> </div>
                                   <?php $i=0; if(isset($stock_details)) { 
                                        for($i=0; $i<count($stock_details); $i++) {
										if($stock_details[$i]->item_id=='9'){
                                ?>
                                    <div class="col s12 " style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
										
                                             Berry Blast Bar 
                                    
                                        <input type="hidden" class="berry" name="bar[]" id="berry_<?php echo $i;?>"  value="9" >
                                        </div>
										
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_9_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                        </div>
                                       
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_9_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
								   <?php }}} else { 
                                   // for($i=0; $i<count($bar_details); $i++) { 
                                ?>
                                    <div class="col s12" style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
                                             Berry Blast Bar 
                                        </div>
										<input type="hidden" class="berry" name="bar[]" id="berry_<?php echo $i;?>"  value="10" >
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_9_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                        </div>
                                      
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_9_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                 
                                </div>
                                <div class="form-group"><button type="button" class=" button shadow btn_color" id="repeat-bar-9">+</button></div>
                                </div><hr>
								
								
								
								
								
								<div class="ava_qty5">
                                <div class="row" id="bar_detail5">
								<div class="col s12 ">	<h5>     Chywanprash Bar  </h5> </div>
                                <?php $i=0; if(isset($stock_details)) { 
                                        for($i=0; $i<count($stock_details); $i++) { 
										if($stock_details[$i]->item_id=='10'){
                                ?>
                                    <div class="col s12 " style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
										
                                          Chywanprash Bar
                                    
                                        <input type="hidden" class="chywanprash" name="bar[]" id="chywanprash_<?php echo $i;?>"  value="9" >
                                        </div>
										
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_10_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                        </div>
                                       
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_10_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }}} else { 
                                   // for($i=0; $i<count($bar_details); $i++) { 
                                ?>
                                    <div class="col s12" style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
                                          Chywanprash Bar 
                                        </div>
										<input type="hidden" class="chywanprash" name="bar[]" id="chywanprash_<?php echo $i;?>"  value="10" >
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_10_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                        </div>
                                      
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_10_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                 
                                </div>
                                <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-10">+</button></div>
                                </div><hr>
								
								
								
	
								<div class="row	">
								 <div class="col s12" style="padding-bottom: 3px;">
                                	<div class="h-scroll">	
                                        <div class="table-stripped form-group" style="padding:15px;">
                                            <table class="table table-bordered" style="margin-bottom: 0px; ">
                                            <thead>
                                                <tr>
                                                    <th>Document Title</th>
                                                    <th>Upload Files</th>
                                                  
                                                 
                                                    <th width="75">Action</th>
                                                </tr>
                                            </thead> 
                                            <tbody id="bar_image_details">
                                            <?php $i=0; if(isset($batch_images)) {
                                                    for($i=0; $i<count($batch_images); $i++) { ?>
                                                <tr id="bar_image_<?php echo $i; ?>_row">
    												<td>
                                                        <input type="text" class="form-control title" name="title[]" id="title_<?php echo $i; ?>" placeholder="title"value="<?php if (isset($batch_images)) { echo $batch_images[$i]->title; } ?>">
                                                    </td>
                                                    <td>
                                                        <div class="col s9">
														 <div class="file-field input-field">
                                                            <input type="hidden" class="form-control" name="receivable_doc[]" value="<?php if(isset($batch_images)) {echo $batch_images[$i]->receivable_doc;} ?>" />
                                                            <input type="hidden" class="form-control" name="image_path[]" value="<?php if(isset($batch_images)) {echo $batch_images[$i]->image;} ?>" />
															 <div class="btn btn-small">
															<span>File</span>

        												    <input type="file" accept="image/*;capture=camera" class="fileinput btn btn-info btn-small bar_image" name="image_<?php echo $i; ?>" id="image_<?php echo $i; ?>" />
                                                        </div>
                                                        </div>
                                                        </div>
                                                        <?php if(isset($batch_images)) {if($batch_images[$i]->image!= '') { ?>
                                                        <div class="col s3">
        												    <a target="_blank" id="batch_doc_file_download<?php echo $i; ?>" href="<?php echo base_url().$batch_images[$i]->image; ?>"><span class="fa download fa-download" ></span></a>
                                                        </div>
        												<?php }} ?>
    												</td>
                                                   <td style="text-align:center;  vertical-align: middle;">
                                                        <a id="bar_image_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                    </td>
                                                </tr>
                                            <?php }} else { ?>
                                                <tr id="bar_image_<?php echo $i; ?>_row">
                                                    <td>
                                                        <input type="text" class="form-control title" name="title[]" id="title_<?php echo $i; ?>" placeholder="title" value=""/>
                                                    </td>
                                                    <td>
    												    <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                        <input type="hidden" class="form-control" name="image_path[]" value="" />
														 <div class="file-field input-field">
														 <div class="btn">
															<span>File</span>
                                                        <input type="file" class="fileinput button shadow btn_color btn-small  bar_image" name="image_<?php echo $i; ?>" id="image_<?php echo $i; ?>" placeholder="image" value=""/>
														</div>
														</div>
                                                    </td>
                                                    <td style="text-align:center;     vertical-align: middle;">
                                                        <a id="bar_image_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">
                                                        <button type="button" class="button shadow btn_color" id="repeat-bar_image" style=" ">+</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            </table>
                                        </div>
    								</div>
    								</div>
    								</div>
									
                            
                        <div class="panel-footer">
                            <a href="<?php echo base_url(); ?>index.php/merchandiser_location" class="button shadow btn_color1" type="reset" id="reset">Cancel</a>
                            <input type="submit" value="Save" id="Saver"  onclick="myFunction()" name="srld" class="right button shadow btn_color2" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>"/>
                           
                        
                            
                        </div>



                        <!-- Modal -->
                        


                    </form>
                     </div>
        </div>
        </div>
        </div>
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
        <?php $this->load->view('templates/footer2');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&libraries=geometry"></script>
        <script>
            $('document').ready(function(){
                if(navigator.geolocation) {
                    var location_timeout = setTimeout("geolocFail()", 500000);
                        
                    navigator.geolocation.getCurrentPosition(function(location) {
                        clearTimeout(location_timeout);
                        
                        $("#latitude").val(location.coords.latitude);
                        $("#longitude").val(location.coords.longitude);
                    
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
            });
            
            function geolocFail() {
                alert("Please switch on GPS!!!");
                // document.getElementById("Saver").disabled = true;
                // document.getElementById("followup_anc").style.display = "none";
                // document.getElementById("pl_ord").disabled = true;
            }

            $('#distributor_id').change(function(){
                $('#distributor_name').val($('#distributor_id option:selected').text());
            });

             jQuery(function(){
                var counter = $('.bar').length;
                
                $('#repeat-bar').click(function(event){
                    event.preventDefault();
                    //$('#box_details').remove(newRow1);
                    var newRow = jQuery('<div class="col s12" id="bar_'+counter+'_row" style="padding-bottom: 3px;">' + 
                                            '<div class="input-field col s4">' + 
											'Orange Bar'+
											
                                                    '<input type="hidden" name="bar[]" id="bar_'+counter+'"  value="1" >'+
                                            '</div>' + 
                                            '<div class="input-field col s4">' + 
                                                '<input type="text" name="qty[]" id="qty_'+counter+'" class="form-control" value="" placeholder="Available Stock" />' + 
                                            '</div>' + 
                                         
                                            '<div class= "input-field col s3">' + 
                                                '<select name="batch_no[]" id="batch_no_'+counter+'" class="browser-default">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php for ($k=0; $k < count($batch) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>' + 
                                                    '<?php } ?>' + 
                                                '</select>' + 
                                            '</div>' + 
                                            '<a id="bar_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                        '</div>');
                    $('#bar_details').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    counter++;
                });
            });
			
			
			   jQuery(function(){
                var counter = $('.butterscotch').length;
                
                $('#repeat-bar-3').click(function(event){
                    event.preventDefault();
                    //$('#box_details').remove(newRow1);
                    var newRow = jQuery('<div class="col s12" id="butterscotch_'+counter+'_row" style="padding-bottom: 3px;">' + 
                                            '<div class="input-field col s4">' + 'Butterscotch Bar'+
                                                    '<input type="hidden" name="bar[]" id="butterscotch_'+counter+'"  value="3" >'+
                                            '</div>' + 
                                            '<div class="input-field col s4">' + 
                                                '<input type="text" name="qty[]" id="qty_3_'+counter+'"  value="" placeholder="Available Stock" />' + 
                                            '</div>' + 
                                         
                                            '<div class= "input-field col s3">' + 
                                                '<select name="batch_no[]" id="batch_no_3_'+counter+'" class="browser-default">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php for ($k=0; $k < count($batch) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>' + 
                                                    '<?php } ?>' + 
                                                '</select>' + 
                                            '</div>' + 
                                            '<a id="butterscotch_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                        '</div>');
                    $('#bar_details1').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    counter++;
                });
            });
			
			
			
			   jQuery(function(){
                var counter = $('.bchaat').length;
                
                $('#repeat-bar-4').click(function(event){
                    event.preventDefault();
                    //$('#box_details').remove(newRow1);
                    var newRow = jQuery('<div class="col s12" id="bchaat_'+counter+'_row" style="padding-bottom: 3px;">' + 
                                            '<div class="input-field col s4">' +' Bambaiya Chaat Bar '+
                                                    '<input type="hidden" name="bar[]" id="bchaat_'+counter+'"  value="4" >'+
                                            '</div>' + 
                                            '<div class="input-field col s4">' + 
                                                '<input type="text" name="qty[]" id="qty_4_'+counter+'"  value="" placeholder="Available Stock" />' + 
                                            '</div>' + 
                                         
                                            '<div class= "input-field col s3">' + 
                                                '<select name="batch_no[]" id="batch_no_4_'+counter+'" class="browser-default">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php for ($k=0; $k < count($batch) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>' + 
                                                    '<?php } ?>' + 
                                                '</select>' + 
                                            '</div>' + 
                                            '<a id="bchaat_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                        '</div>');
                    $('#bar_details2').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    counter++;
                });
            });
			
			
			
			
			   jQuery(function(){
                var counter = $('.Choco').length;
                
                $('#repeat-bar-5').click(function(event){
                    event.preventDefault();
                    //$('#box_details').remove(newRow1);
                    var newRow = jQuery('<div class="col s12" id="Choco_'+counter+'_row" style="padding-bottom: 3px;">' + 
                                            '<div class="input-field col s4">' +' Choco Peanut Butter Bar '+
                                                    '<input type="hidden" name="bar[]" id="Choco_'+counter+'"  value="5" >'+
                                            '</div>' + 
                                            '<div class="input-field col s4">' + 
                                                '<input type="text" name="qty[]" id="qty_5_'+counter+'"  value="" placeholder="Available Stock" />' + 
                                            '</div>' + 
                                         
                                            '<div class= "input-field col s3">' + 
                                                '<select name="batch_no[]" id="batch_no_5_'+counter+'" class="browser-default">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php for ($k=0; $k < count($batch) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>' + 
                                                    '<?php } ?>' + 
                                                '</select>' + 
                                            '</div>' + 
                                            '<a id="Choco_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                        '</div>');
                    $('#bar_details3').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    counter++;
                });
            });
			
			
			
			
			   jQuery(function(){
                var counter = $('.berry').length;
                
                $('#repeat-bar-9').click(function(event){
                    event.preventDefault();
                    //$('#box_details').remove(newRow1);
                    var newRow = jQuery('<div class="col s12" id="berry_'+counter+'_row" style="padding-bottom: 3px;">' + 
                                            '<div class="input-field col s4">' +' Berry Blast Bar '+
                                                    '<input type="hidden" name="bar[]" id="berry_'+counter+'"  value="9" >'+
                                            '</div>' + 
                                            '<div class="input-field col s4">' + 
                                                '<input type="text" name="qty[]" id="qty_9_'+counter+'"  value="" placeholder="Available Stock" />' + 
                                            '</div>' + 
                                         
                                            '<div class= "input-field col s3">' + 
                                                '<select name="batch_no[]" id="batch_no_9_'+counter+'" class="browser-default">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php for ($k=0; $k < count($batch) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>' + 
                                                    '<?php } ?>' + 
                                                '</select>' + 
                                            '</div>' + 
                                            '<a id="berry_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                        '</div>');
                    $('#bar_details4').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    counter++;
                });
            });
			
			
			
			
			
			   jQuery(function(){
                var counter = $('.chywanprash').length;
                
                $('#repeat-bar-10').click(function(event){
                    event.preventDefault();
                    //$('#box_details').remove(newRow1);
                    var newRow = jQuery('<div class="col s12" id="chywanprash_'+counter+'_row" style="padding-bottom: 3px;">' + 
                                            '<div class="input-field col s4">'  +' Chywanprash_ Bar'+ 
                                                    '<input type="hidden" name="bar[]" id="chywanprash_'+counter+'"  value="10" >'+
                                            '</div>' + 
                                            '<div class="input-field col s4">' + 
                                                '<input type="text" name="qty[]" id="qty_10_'+counter+'"  value="" placeholder="Available Stock" />' + 
                                            '</div>' + 
                                         
                                            '<div class= "input-field col s3">' + 
                                                '<select name="batch_no[]" id="batch_no_10_'+counter+'" class="browser-default">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php for ($k=0; $k < count($batch) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>' + 
                                                    '<?php } ?>' + 
                                                '</select>' + 
                                            '</div>' + 
                                            '<a id="chywanprash_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                        '</div>');
                    $('#bar_detail5').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    counter++;
                });
            });
			
			
			
			
			
			
			
		 jQuery(function(){
                var counter = $('.title').length;
				
                $('#repeat-bar_image').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="bar_image_'+counter+'_row">'+
                                          '<td class=" input-field">'+
                                                '<input type="title" class="input-field title" name="title[]" id="title_'+counter+'" placeholder="title" value=""/>'+
                                            '</td>'+
                                            '<td>'+
											 '<input type="hidden" class="form-control receivable_doc" name="receivable_doc[]" value="receivable_doc_'+counter+'" />'+
												' <div class="file-field input-field">'+
												'<div class="btn">'+
												'<span>File</span>'+
                                                '<input type="file" class="fileinput btn btn-info btn-small bar_image" name="image_'+counter+'" id="image_'+counter+'" placeholder="image" value=""/>'+
												'<div class="file-path-wrapper">'+
												'<input class="file-path validate" type="text">'+
												'</div></div></div>'+
                                            '</td>'+
                                            '<td style="text-align:center;  vertical-align: middle;">'+
                                                '<a id="bar_image_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                            '</td>'+
                                        '</tr>');
                    $('#bar_image_details').append(newRow);
                  
                 
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                      
                    });
                    counter++;
                });
            });
   // $('document').ready(function(){
				
			
                       
	
			// var	lat2=$("#latitude1").val();
	
			// var	lon2=$("#longitude1").val();
	
			// navigator.geolocation.getCurrentPosition(
            // function(position) {
                // var latLngA = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                // var latLngB = new google.maps.LatLng(lat2,lon2);
                // var distance = google.maps.geometry.spherical.computeDistanceBetween(latLngA, latLngB);
          
				// if(distance > 50)
				// {
					// alert('Form Will be Open within 50 meter diametre');
					// window.location.href = ""+BASE_URL+"index.php/merchandiser_location/";
				
				// }
				// else
				// {
						
				// }
            // }, function(error) {
                        // clearTimeout(location_timeout);
                        // geolocFail();
                    // });
   // });
             
        </script>
        <script>
		
        </script>
		
		<script>
		$(document).ready(function(){
			/*$.ajax({
				type:'Post',
				url:BASE_URL+'index.php/merchandiser_location/save_seq',
				data:{id:$('#seq_id').val(),sales_rep_id:$('#sales_rep_id').val(),isedit:$('#id').val()},
				success:function(data){

				}
			});
			
			$.ajax({
				type:'Post',
				url:BASE_URL+'index.php/merchandiser_location/check_seq',
				data:{id:$('#seq_id').val() , sales_rep_id:$('#sales_rep_id').val()},
				success:function(data){
					//alert(data);
					
					if($('#sequence').val()!=data)
					{
						$('#change_sequence').val(data)
					}

				}
			});*/
		});
		</script>
		
		
<script>
    $("#Saver").on('click',function(){
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
           
            if($('#id').val()=="" && sequence_count!=sequence )
            {
               $('#confirm_content').confirmModal({
                    topOffset: 0,
                    onOkBut: function() {$("#loading").show();$('#ispermenant').val('Yes');$("#form_sales_rep_location_details").submit();},
                    onCancelBut: function() {
                    $('#ispermenant').val('No');
                    $("#loading").show();
                    $("#form_sales_rep_location_details").submit();},   
                    onLoad: function() {},
                    onClose: function() {}
                });
                return false;
            }
        }
    });
	function myFunction() 
	{
		/*if($('#id').val()=="")
		{
			var ispermenant;
			var r = confirm("Are You want this route permenant??");
			if (r == true) {
				ispermenant = "Yes";
			} else {
				ispermenant = "No";
			}
			$('#ispermenant').val(ispermenant);
		}*/
    }
</script>

</body>
</html>