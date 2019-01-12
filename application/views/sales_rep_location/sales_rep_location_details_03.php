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
			
			 background-color:#6FA7E4!important;
			color:!important;
		}
		input::-webkit-input-placeholder
		{ 
			font-size:0.8rem!important;
			color: #000!important;
		}
		
		.input-field.col label {
			left: .75rem!important;
			font-size: 0.8rem!important;
			font-weight: 900!important;
			color: #000;
		}
		
		input:not([type]), input[type=text], input[type=password], input[type=email], input[type=url], input[type=time], input[type=date], input[type=datetime], input[type=datetime-local], input[type=tel], input[type=number], input[type=search], textarea.materialize-textarea
		{
			color: #000!important;
			height:1.5rem!important;
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
	</style>

<body>								
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
			
						<hr>
                  
                    
                    <form id="form_sales_rep_location_details" role="form"  method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep_location/save/' . $data[0]->id; else echo base_url().'index.php/sales_rep_location/save'; ?>">
                     
                                <div class="row">
                                    <div class="col s12">
                                       <div class="input-field col s3">
											<label for="dob">Date</label>
										</div> 
											<div class="input-field col s9"   style="top:0.8rem;color:#000!important;">
												<input type="hidden" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
												<input type="hidden"  name="latitude" id="latitude" value="<?php if(isset($data)) echo $data[0]->latitude;?>"/>
												<input type="hidden"  name="longitude" id="longitude" value="<?php if(isset($data)) echo $data[0]->longitude;?>"/>
												
												<input type="hidden"  name="date_of_visit" id="date_of_visit" value="  <?php if(isset($data)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('Y-m-d',strtotime($data[0]->date_of_visit)):date('Y-m-d')); else echo date('Y-m-d'); ?>"/>
											   <?php if(isset($data)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>
										  
												
											</div>
                                    </div>
                          
										
								 
                                    <div class="col s12">
									
										<div class="input-field col s3">
											<label>Type<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">
                                                <select class="browser-default" name="distributor_type" id="distributor_type">
                                                    <option value="Old" <?php if(isset($data)) {if ($data[0]->distributor_type=='Old') echo 'selected';}?>>Old</option>
                                                    <option value="New" <?php if(isset($data)) {if ($data[0]->distributor_type=='New') echo 'selected';}?>>New</option>
                                                </select>
                                           
											
										</div>
                                    </div>
                                   
                                    
                              
									<div class="col s12">
										<div class="input-field col s3">
											<label>Retailer Name <span class="asterisk_sign">*</span></label>
										</div> 
									<div class="input-field col s9">
                                     
										<span class="distributor_field" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo ''; else echo 'display: none;';} ?>">
                                            <select name="distributor_id" id="distributor_id" class="browser-default" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo ''; else echo 'display: none;';} ?>">
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) {if($distributor[$k]->id==$data[0]->distributor_id) {echo 'selected';}} else if(isset($distributor_id)) {if($distributor[$k]->id==$distributor_id) {echo 'selected';}} ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                <?php }} ?>
                                            </select>
										</span>
                                            <input type="text" class="" name="distributor_name" id="distributor_name" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo 'display: none;';} else {echo 'display: none;';} ?>" placeholder="Retailer Name" value="<?php if(isset($data)) echo $data[0]->distributor_name;?>"/>
											
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
                                                        <option value="<?php echo $zone[$k]->zone_id; ?>" <?php if (isset($data)) { if($zone[$k]->zone_id==$data[0]->zone_id) { echo 'selected'; } } ?>><?php echo $zone[$k]->zone; ?></option>
                                                <?php }} ?>
												</select>
										
										</div> 
									</div> 
								
									<div class="col s12">
                              
										
										<div class="input-field col s3">
											<label class="old_dist_details">Area<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9"> 
											<select name="area_id" id="area_id"  class="browser-default"  onchange="get_location();">
                                                <option value="">Select</option>
                                                <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                                        <option value="<?php echo $area[$k]->area_id; ?>" <?php if (isset($data)) { if($area[$k]->area_id==$data[0]->area_id) { echo 'selected'; } } ?>><?php echo $area[$k]->area; ?></option>
                                                <?php }} ?>
											</select>
											
										</div> 
									</div> 
								
									<div class="col s12">
										<div class="input-field col s3">
											<label class="old_dist_details">Location<span class="asterisk_sign">*</span></label>
										</div> 
									
										<div class="input-field col s9">
										
											<select name="location_id" id="location_id" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                        <option value="<?php echo $location[$k]->id; ?>" <?php if (isset($data)) { if($location[$k]->id==$data[0]->location_id) { echo 'selected'; } } ?>><?php echo $location[$k]->location; ?></option>
                                                <?php }} ?>
                                            </select>
										
										</div> 
									</div> 
								</div> 
                                       
                           
                              	<div class="row">
									<div class="col s12">
										<div class="input-field col s12">
											<label for="remarks" style="color: #000;">Remarks</label>
										  <textarea name="remarks" class="materialize-textarea"  ><?php if(isset($data)) echo $data[0]->remarks;?></textarea>						
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
										<div class="input-field col s8">
											<input type="number" value="<?php if(isset($data1[0]->orange_bar)) echo $data1[0]->orange_bar; ?>" class="form-control" name="orange_bar" placeholder="0"/>
											
											 
										</div>
								
									</div>
									
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Butterscotch<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s8">
											<input type="number" value="<?php if(isset($data1[0]->butterscotch_bar)) echo $data1[0]->butterscotch_bar;?>" class="form-control" name="butterscotch_bar" placeholder="0" />
											
											 
										</div>
									</div>
								 
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Choco<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s8">
											<input type="number" value="<?php if(isset($data1[0]->chocopeanut_bar)) echo $data1[0]->chocopeanut_bar;?>" class="form-control" name="chocopeanut_bar" placeholder="0"/>
											
											
										</div>
									</div>

									<div class="col s12">
									
										<div class="input-field col s4">
											<label class="">Chaat<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s8">
											<input type="number" value="<?php if(isset($data1[0]->bambaiyachaat_bar)) echo $data1[0]->bambaiyachaat_bar;?>" class="form-control" name="bambaiyachaat_bar" placeholder="0" />
											
										</div>
									</div>
								 
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Mango<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s8">
											<input type="number" value="<?php if(isset($data1[0]->mangoginger_bar)) echo $data1[0]->mangoginger_bar;?>" class="form-control" name="mangoginger_bar" placeholder="0"/>
											
											
										</div>
									</div>

									<div class="col s12">
									
										<div class="input-field col s4">
											<label class="">Berry<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s8">
											<input type="number" value="<?php if(isset($data1[0]->berry_blast_bar )) echo $data1[0]->berry_blast_bar ;?>" class="form-control" name="berry_blast_bar " placeholder="0" />
											
										</div>
									</div>
								 
									<div class="col s12">
										<div class="input-field col s4">
											<label class="">Chywanprash<span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s8">
											<input type="number" value="<?php if(isset($data1[0]->chyawanprash_bar)) echo $data1[0]->chyawanprash_bar;?>" class="form-control" name="chyawanprash_bar" placeholder="0"/>
											
											 
										</div>
								
									
									
										
									</div>
								</div>

                              
                             
                            </div>
                         
							<div class="panel-footer">
							<a href="<?php echo base_url(); ?>index.php/sales_rep_location" class="button shadow btn_color " type="reset" id="reset" style="    float: left;padding: 4px 12px;">Cancel</a>
                            <input type="submit" value="Save" id="Saver" name="srld" class="right button shadow btn_color "  style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-left: 2px;"/>
                            <a data-toggle="modal" id="followup_anc" href="#myModal" class=" right  button shadow btn_color" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>padding: 3px 12px;">Follow Up</a>
							<input type="submit" id="pl_ord" value="Place Order" name="srld" class="right button shadow btn_color " style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 2px;"/>
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
                                                <input type="text" class="form-control datepicker" name="followup_date" id="followup_date" placeholder="Follow Up Date" value="<?php if(isset($data)) echo (($data[0]->followup_date!=null && $data[0]->followup_date!='')?date('d/m/Y',strtotime($data[0]->followup_date)):''); else echo ''; ?>"/>
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
   
      

        <?php $this->load->view('templates/footer2');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw"></script>
        <script>
            $('document').ready(function(){
				if(navigator.geolocation) {
					var location_timeout = setTimeout("geolocFail()", 500000);
						
					navigator.geolocation.getCurrentPosition(function(location) {
						clearTimeout(location_timeout);
						
						$("#latitude").val(location.coords.latitude);
						$("#longitude").val(location.coords.longitude);
					
						document.getElementById("Saver").disabled = false;
						document.getElementById("followup_anc").style.display = "block";
						document.getElementById("pl_ord").disabled = false;
					
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
				document.getElementById("Saver").disabled = true;
					document.getElementById("followup_anc").style.display = "none";
					document.getElementById("pl_ord").disabled = true;
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
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15 ,// Creates a dropdown of 15 years to control year
			container:'body'
			});
       //   $('select').formSelect();
		  
		  
		  
        </script>
        <script>
	

		  $(document).ready(function(){
			$('.modal').modal();
		  });
        </script>
    </body>
</html>