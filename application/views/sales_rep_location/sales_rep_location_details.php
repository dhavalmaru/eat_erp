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
	</style>

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
							</div>
							<?php 
								
								if(isset($data[0]->id))
									$id = $data[0]->id;
								else
									$id = '';
							?>
						<hr>

                    <form id="form_sales_rep_location_details" role="form"  method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/Sales_rep_store_plan/save/'.$id; else echo base_url().'index.php/Sales_rep_store_plan/save'; ?>" onsubmit="return myFunction()" >
                     
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
												
												<input type="hidden"  name="date_of_visit" id="date_of_visit" value="  <?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
											   <?php if(isset($data[0]->date_of_visit)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>
										  
												
											</div>
                                    </div>
                                </div>
										
								 <div class="row">
                                    <div class="col s12">
									
										<div class="input-field col s3">
											<label>Type<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">
                                                <select class="browser-default" name="distributor_type" id="distributor_type">
                                                    <option value="Old" <?php if(isset($data[0]->distributor_type)) {if ($data[0]->distributor_type=='Old') echo 'selected';}?>>Old</option>
                                                    <option value="New" <?php if(isset($data)) {if ($data[0]->distributor_type=='New') echo 'selected';}?>>New</option>
                                                </select>
                                           
											
										</div>
                                    </div>
                                   
                                    
                                </div>
								
								<div class="row">
									<div class="col s12">
										<div class="input-field col s3">
											<label>Retailer Name <span class="asterisk_sign">*</span></label>
										</div> 
									<div class="input-field col s9">
                                     <!--store_id is a Retailer id-->
										<span class="distributor_field" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo ''; else echo 'display: none;';} ?>">
                                            <select name="distributor_id" id="distributor_id" class="browser-default" style="<?php if(isset($data[0]->distributor_type)) {if($data[0]->distributor_type=='Old') echo ''; else echo 'display: none;';} ?>">
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) {
                                                        	if(isset($data[0]->store_id))
                                                        	{
                                                        	  if($distributor[$k]->id==$data[0]->store_id) {echo 'selected';}
                                                        	}
                                                        	 ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                <?php }}} ?>
                                            </select>
										</span>
                                            <input type="text" class="" name="distributor_name" id="distributor_name" style="<?php if(isset($data[0]->distributor_name)) {if($data[0]->distributor_type=='Old') echo 'display: none;';} else {echo 'display: none;';} ?>" placeholder="Retailer Name" value="<?php if(isset($data[0]->distributor_name )) echo $data[0]->distributor_name;?>"/>
											
									</div> 
									</div> 
								</div> 
									
								<div class="row old_dist_details">
									<div class="col s12">
                              
										<div class="input-field col s3">
											<label class="old_dist_details">Zone<span class="asterisk_sign">*</span></label>
										</div> 
										
									<div class="input-field col s9">
												<select name="zone_id" id="zone_id" class="browser-default" onchange="get_area();">
                                                <option value="">Select</option>
                                                <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                        <option value="<?php echo $zone[$k]->zone_id; ?>" <?php if (isset($data)) { 
                                                        	if(isset($data[0]->zone_id))
                                                        	{
                                                        	  if($zone[$k]->zone_id==$data[0]->zone_id && $data[0]->mid!='') { echo 'selected'; } 
                                                        	}

                                                        	} ?>><?php echo $zone[$k]->zone; ?></option>
                                                <?php }} ?>
												</select>
										
										</div> 
									</div> 
								</div> 
								
                                <div class="row old_dist_details">
									<div class="col s12">
                              
										
										<div class="input-field col s3">
											<label class="old_dist_details">Area<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9"> 
											<select name="area_id" id="area_id"  class="browser-default"  onchange="get_location();">
                                                <option value="">Select</option>
                                                <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                                        <option value="<?php echo $area[$k]->area_id; ?>" <?php if (isset($data)) { 
                                                        	if(isset($data[0]->area_id))
                                                        	{
                                                        	  if($area[$k]->area_id==$data[0]->area_id && $data[0]->mid!='') { echo 'selected'; } 
                                                        	}
                                                        	

                                                    		} ?>><?php echo $area[$k]->area; ?></option>
                                                <?php }} ?>
											</select>
											
										</div> 
									</div> 
								</div> 
										
								<div class="row old_dist_details">
									<div class="col s12">
										<div class="input-field col s3">
											<label class="old_dist_details">Location<span class="asterisk_sign">*</span></label>
										</div> 
									
										<div class="input-field col s9">
										
											<select name="location_id" id="location_id" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                        <option value="<?php echo $location[$k]->id; ?>" <?php if (isset($data)) 
                                                        { 
                                                          if(isset($data[0]->location_id))
                                                          {
                                                          	if($location[$k]->id==$data[0]->location_id  && $data[0]->mid!='') { echo 'selected'; }
                                                          }
                                                           

                                                    	} ?>><?php echo $location[$k]->location; ?></option>
                                                <?php }} ?>
                                            </select>
										
										</div> 
									</div> 
								</div> 

                               
                           		     
								<!-- <div class="row old_dist_details">
									<div class="col s12">
										<div class="input-field col s3">
											<label>GST Number <span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">
											<input type="text"  name="gst_number" id="gst_number" placeholder="GST Number" value="<?php if(isset($data[0]->gst_number)) echo $data[0]->gst_number; else if(isset($gst_number)) echo $gst_number;?>"/>
	                                    </div>
	                                    
                                	</div>
								</div>

								<div class="row old_dist_details">
									<div class="col s12">
												<div class="input-field col s3">
													<label>Margin On MRP (In %) <span class="asterisk_sign">*</span></label>
												</div> 
												<div class="input-field col s9">
													<div class="input-field col s12 ">
													
														<input type="text" class="form-control" name="margin" placeholder="Margin" value="<?php if(isset($data[0]->margin)) echo $data[0]->margin;?>"/>
														
													</div> 
												</div>
										</div>
								</div>

								<div class="row old_dist_details">
									
									<div class="col s12">
									<input type="hidden" class="form-control" name="doc_document" value="<?php if(isset($data[0]->doc_document)) echo $data[0]->doc_document; ?>" />
                                    <input type="hidden" class="form-control" name="document_name" value="<?php if(isset( $data[0]->document_name)) echo $data[0]->document_name; ?>" />
									<div class="file-field input-field">
										<div class="btn">
										<span>Take Photo</span>
										 <input type="file" accept="image/*;capture=camera" class="fileinput btn btn-info btn-small doc_file" name="doc_file" id="doc_file" data-error="#doc_file_error"/>
                                         <div id="doc_file_error"></div>
										<input type="file">
										</div>
										<div class="file-path-wrapper">
										<input class="file-path validate" type="text">
										</div>
									</div>
									<div class="col-sm-3 download-width" >
                                            <?php if(isset($data[0]->doc_document)) { if($data[0]->doc_document!= '') { ?><a target="_blank" id="doc_file_download" href="<?php if(isset($data)) echo base_url().$data[0]->doc_document; ?>"><span class="fa download fa-download" ></span></a></a><?php }} ?>
                                    </div>
									</div>
								</div> -->
								
                              	
								
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

                                	<div class="app-title">
							<h5>Available Quantities</h5>
							</div>
			
						<hr>	
								<div class="row">
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Orange<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s3">
											<input type="number" value="<?php if(isset($data1[0]->orange_bar)) echo $data1[0]->orange_bar; ?>" class="form-control" name="orange_bar" placeholder="0"/>
											
											 
										</div>
								
									</div>
									
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Butterscotch<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s3">
											<input type="number" value="<?php if(isset($data1[0]->butterscotch_bar)) echo $data1[0]->butterscotch_bar;?>" class="form-control" name="butterscotch_bar" placeholder="0" />
											
											 
										</div>
									</div>
								 
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Choco<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s3">
											<input type="number" value="<?php if(isset($data1[0]->chocopeanut_bar)) echo $data1[0]->chocopeanut_bar;?>" class="form-control" name="chocopeanut_bar" placeholder="0"/>
											
											
										</div>
									</div>

									<div class="col s12">
									
										<div class="input-field col s4">
											<label class="">Chaat<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s3">
											<input type="number" value="<?php if(isset($data1[0]->bambaiyachaat_bar)) echo $data1[0]->bambaiyachaat_bar;?>" class="form-control" name="bambaiyachaat_bar" placeholder="0" />
											
										</div>
									</div>
								 
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Mango<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s3">
											<input type="number" value="<?php if(isset($data1[0]->mangoginger_bar)) echo $data1[0]->mangoginger_bar;?>" class="form-control" name="mangoginger_bar" placeholder="0"/>
											
											
										</div>
									</div>

									<div class="col s12">
									
										<div class="input-field col s4">
											<label class="">Berry<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s3">
											<input type="number" value="<?php if(isset($data1[0]->berry_blast_bar)) echo $data1[0]->berry_blast_bar;?>" class="form-control" name="berry_blast_bar" placeholder="0" />
											
										</div>
									</div>
								 
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Chywanprash<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s3">
											<input type="number" value="<?php if(isset($data1[0]->chyawanprash_bar)) echo $data1[0]->chyawanprash_bar;?>" class="form-control" name="chyawanprash_bar" placeholder="0"/>
											
											 
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
							</div><br>
							<div class="row">
								<div class="col s12">
							<a href="<?php echo base_url(); ?>index.php/Sales_rep_store_plan" class="button left shadow btn_color1 " type="reset" id="reset" style=" float: left;margin-left: 22px;">Cancel</a>
                            <input type="submit" value="Save" id="Saver" name="srld" class="right button shadow btn_color2 "  style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 22px;font-size:16px;padding: 8px 12px;"/>
							</div>
							
                            </div>
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
                    <button type="button" class="btn " data-confirmmodal-but="cancel">No</button>
                </div>
            </div>
        </div>
           
        <?php $this->load->view('templates/footer2');?>
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
            });

            function distributor_type_change() {
                if($('#distributor_type').val()=="Old"){
                    $('#distributor_id').show();
					 $('.distributor_field').show();
                    $('#distributor_name').hide();
                    $('.ava_qty').show();
                    $('.disstatus').hide();
                    $('.old_dist_details').hide();
                } else {
                    $('#distributor_id').hide();
                    $('.distributor_field').hide();
                    $('#distributor_name').show();
                    $('.ava_qty').hide();
                    $('.disstatus').hide();
                    $('.old_dist_details').show();
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
                $.ajax({
                        url:'<?=base_url()?>index.php/Sales_rep_location/get_locations',
                        method: 'post',
                        data: {zone_id: zone_id, area_id: area_id},
                        dataType: 'html',
                        async: false,
                        success: function(response){
                            $('#location_id').html(response);
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
			$('.datepicker').pickadate({
			format:'dd/mm/yyyy',
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15 ,// Creates a dropdown of 15 years to control year
			container:'body'
			});
          $('select').formSelect();
		  
		  
		  
        </script>
        <script>
		

		  $(document).ready(function(){
			$('.modal').modal();
		  });
        </script>

		<script>
			$("#pl_ord,#Saver").on('click',function(){
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

					
			       
					if(($('#mid').val()=="" && dist_type=='Old') && sequence_count!=sequence )
					{
						/*var ispermenant;
						var r = confirm("Are You want this route permenant??");
						if (r == true) {
							ispermenant = "Yes";
						} else {
							ispermenant = "No";
						}
						$('#ispermenant').val(ispermenant);
						$("#loading").show();
			  			$("#form_sales_rep_location_details").submit();*/
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
						
					}
                }
            });
			function myFunction() 
			{/*
				alert("entered");
		        var dist_type = $('#distributor_type').val(); 
		        alert(dist_type);
				if($('#mid').val()=="" && dist_type=='Old')
				{
					var ispermenant;
					var r = confirm("Are You want this route permenant??");
					if (r == true) {
						ispermenant = "Yes";
					} else {
						ispermenant = "No";
					}
					$('#ispermenant').val(ispermenant);

		  			return true;
				}
				else
				{
					$('#confirm_content2').confirmModal({
                        topOffset: 0,
                        onOkBut: function() {$('#place_order').val("Yes"); $('#ispermenant').val('Yes');return true;},
                        onCancelBut: function() {$('#place_order').val("No");return true;},
                        onLoad: function() {$('#place_order').val("No"); return true;},
                        onClose: function() {$('#place_order').val("No"); return true;}
                    });
				}*/
		    }
	
		
			// $("#pl_ord,#Saver").on('click',function(){


                // if (!$("#form_sales_rep_location_details").valid()) {
                	 // return false;
                // }
                // else
                // {
			        // var dist_type = $('#distributor_type').val(); 
			        // var sequence_count = $('#sequence_count').val();

			        // if(sequence_count=="")
			        // {
			        	// sequence_count = 1;
			        // }
			        // var sequence = $('#sequence').val();

			       
					// if(($('#mid').val()=="" && dist_type=='Old') && sequence_count!=sequence )
					// {
						// var ispermenant;
						// var r = confirm("Are You want this route permenant??");
						// if (r == true) {
							// ispermenant = "Yes";
						// } else {
							// ispermenant = "No";
						// }
						// $('#ispermenant').val(ispermenant);
						// $("#loading").show();
			  			// $("#form_sales_rep_location_details").submit();
					// }
					// else
					// {
						// if($(this).attr('id')!='Saver')
						// {
							// $('#confirm_content2').confirmModal({
		                        // topOffset: 0,
		                        // onOkBut: function() {$("#loading").show();$('#place_order').val("Yes"); $('#ispermenant').val('Yes');$('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
		                        // onCancelBut: function() {$("#loading").show();$('#place_order').val("No"); $('#srld').val("Place Order");$("#form_sales_rep_location_details").submit();},
		                        // onLoad: function() {$('#place_order').val("No"); },
		                        // onClose: function() {$('#place_order').val("No"); }
                    		// });	
						// }
						
					// }
                // }
            // });
			
		</script>


    </body>
</html>