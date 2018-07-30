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

        <style>
            #map {
                height: 100%;
            }
			input:read-only { 
                background-color: white!important;
                color: #0aab4b!important;
            }
		.form-group
			{
				border-bottom:none!important;
				background-color:white;
			}
		.panel {
		   box-shadow: none;
		   border:none!important; 
		   border-top: none!important; 
		  
		}.submitLink {
		  background-color: transparent;
		  text-decoration: none;
		  border: none;
		  color: #428bca;
		  cursor: pointer;
		}
		.panel-footer
		{
			background-color:#fff!important;
		}
		.heading-h2
		{
			display:none!important;
		}
		
        </style>
    </head>
    <body>

        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sales_rep_location'; ?>" > Visit List </a>  &nbsp; &#10095; &nbsp; Visit Details</div>

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
                    
                    <form id="form_sales_rep_location_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep_location/save/' . $data[0]->id; else echo base_url().'index.php/sales_rep_location/save'; ?>">
                        <div class="box-shadow-inside" style="margin-top: 120px;">
                        <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="latitude" id="latitude" value="<?php if(isset($data)) echo $data[0]->latitude;?>"/>
                                            <input type="hidden" class="form-control" name="longitude" id="longitude" value="<?php if(isset($data)) echo $data[0]->longitude;?>"/>
                                            <input type="text" class="form-control" name="date_of_visit" id="date_of_visit" placeholder="Date Of Visit" value="<?php if(isset($data)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>" readonly="true" style="color: #245478; background-color: white;background: url(<?php echo base_url(); ?>img/calendar-hover.png) 99% 50% no-repeat;"/>
                                        </div>
                                        <div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="distributor_type" id="distributor_type">
                                                    <option value="Old" <?php if(isset($data)) {if ($data[0]->distributor_type=='Old') echo 'selected';}?>>Old</option>
                                                    <option value="New" <?php if(isset($data)) {if ($data[0]->distributor_type=='New') echo 'selected';}?>>New</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="display: none;">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="status">
                                                    <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Active</option>
                                                    <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Retailer Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="distributor_id" id="distributor_id" class="form-control" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo ''; else  echo 'display: none;';} ?>">
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) {if($distributor[$k]->id==$data[0]->distributor_id) {echo 'selected';}} else if(isset($distributor_id)) {if($distributor[$k]->id==$distributor_id) {echo 'selected';}} ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                            <input type="text" class="form-control" name="distributor_name" id="distributor_name" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo 'display: none;';} else {echo 'display: none;';} ?>" placeholder="Retailer Name" value="<?php if(isset($data)) echo $data[0]->distributor_name;?>"/>
                                        </div>

                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label disstatus" style="display:none;">Status <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12 disstatus" style="display:none;">
                                            <select class="form-control disstatus" >
                                                <option value="">Select</option>
                                                <option value="Not Interested" <?php if(isset($data)) {if ($data[0]->distributor_status=='Not Interested') echo 'selected';}?>>Not Interested</option>
                                                <option value="Follow Up" <?php if(isset($data)) {if ($data[0]->distributor_status=='Follow Up') echo 'selected';}?>>Follow Up</option>
                                                <option value="Place Order" <?php if(isset($data)) {if ($data[0]->distributor_status=='Place Order') echo 'selected';}?>>Place Order</option>
                                            </select>
                                        </div>

                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label old_dist_details">Zone</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12 old_dist_details">
                                            <select name="zone_id" id="zone_id" class="form-control" onchange="get_area();">
                                                <option value="">Select</option>
                                                <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                        <option value="<?php echo $zone[$k]->zone_id; ?>" <?php if (isset($data)) { if($zone[$k]->zone_id==$data[0]->zone_id) { echo 'selected'; } } ?>><?php echo $zone[$k]->zone; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group old_dist_details">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="area_id" id="area_id" class="form-control" onchange="get_location();">
                                                <option value="">Select</option>
                                                <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                                        <option value="<?php echo $area[$k]->area_id; ?>" <?php if (isset($data)) { if($area[$k]->area_id==$data[0]->area_id) { echo 'selected'; } } ?>><?php echo $area[$k]->area; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Location</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="location_id" id="location_id" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                        <option value="<?php echo $location[$k]->id; ?>" <?php if (isset($data)) { if($location[$k]->id==$data[0]->location_id) { echo 'selected'; } } ?>><?php echo $location[$k]->location; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="ava_qty">

                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Orange Bar Closing Stock </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" id="orange_bar_closing" value="" placeholder="Closing Stock" readonly />
                                        </div> -->
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Orange </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1[0]->orange_bar)) echo $data1[0]->orange_bar;?>" class="form-control" name="orange_bar" placeholder="Available Stock"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mint Bar Closing Stock </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" id="mint_bar_closing" value="" placeholder="Closing Stock" readonly />
                                        </div> -->
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mint Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1[0]->mint_bar)) echo $data1[0]->mint_bar;?>" class="form-control" name="mint_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Butterscotch Bar Closing Stock </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" id="butterscotch_bar_closing" value="" placeholder="Closing Stock" readonly />
                                        </div> -->
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Butterscotch </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1[0]->butterscotch_bar)) echo $data1[0]->butterscotch_bar;?>" class="form-control" name="butterscotch_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Chocolate Peanut Butter Bar Closing Stock </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" id="chocopeanut_bar_closing" value="" placeholder="Closing Stock" readonly />
                                        </div> -->
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Choco Peanut Butter </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1[0]->chocopeanut_bar)) echo $data1[0]->chocopeanut_bar;?>" class="form-control" name="chocopeanut_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bambaiya Chaat Bar Closing Stock </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" id="bambaiyachaat_bar_closing" value="" placeholder="Closing Stock" readonly />
                                        </div> -->
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bambaiya Chaat </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1[0]->bambaiyachaat_bar)) echo $data1[0]->bambaiyachaat_bar;?>" class="form-control" name="bambaiyachaat_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mango Ginger Bar Closing Stock </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" id="mangoginger_bar_closing" value="" placeholder="Closing Stock" readonly />
                                        </div> -->
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mango </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1[0]->mangoginger_bar)) echo $data1[0]->mangoginger_bar;?>" class="form-control" name="mangoginger_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mango Ginger Bar Closing Stock </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" id="mangoginger_bar_closing" value="" placeholder="Closing Stock" readonly />
                                        </div> -->
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Berry Blast </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1[0]->berry_blast_bar)) echo $data1[0]->berry_blast_bar;?>" class="form-control" name="berry_blast_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mango Ginger Bar Closing Stock </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" id="mangoginger_bar_closing" value="" placeholder="Closing Stock" readonly />
                                        </div> -->
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Chywanprash </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1[0]->chyawanprash_bar)) echo $data1[0]->chyawanprash_bar;?>" class="form-control" name="chyawanprash_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
								<div class="panel-footer">
							<a href="<?php echo base_url(); ?>index.php/sales_rep_location" class="submitLink" type="reset" id="reset">Cancel</a>
                            <input type="submit" value="Save" id="Saver" name="srld" class=" pull-right submitLink"  style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>"/>
                            <a data-toggle="modal" id="followup_anc" href="#myModal" class=" pull-right submitLink" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 2px;line-height: 32px;">Follow Up</a>
						 <input type="submit" id="pl_ord" value="Place Order" name="srld" class="pull-right submitLink" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 2px;"/>
                            </div>
                            </div>
                            <br clear="all"/>
                        </div>
                        </div>
               

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Follow Up Date</h4>
                                    </div>
                                    <div class="modal-body">
                                            <label class="control-label">Follow Up Date<span class="asterisk_sign">*</span></label>
                                            <br/>
                                            <div class="">
                                                <input type="text" class="form-control datepicker" name="followup_date" id="followup_date" placeholder="Follow Up Date" value="<?php if(isset($data)) echo (($data[0]->followup_date!=null && $data[0]->followup_date!='')?date('d/m/Y',strtotime($data[0]->followup_date)):''); else echo ''; ?>"/>
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="submitLink pull-left" data-dismiss="modal">Close</button>
                                        <input type="submit" id="btn_save" name="srld" class="submitLink pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>" value="Follow Up"/>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                   
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->

        </div>            
        <!-- END PAGE CONTENT -->	
        </div>
        <!-- END PAGE CONTAINER -->

        <?php $this->load->view('templates/footer');?>
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
                    $('#distributor_name').hide();
                    $('.ava_qty').show();
                    $('.disstatus').hide();
                    $('.old_dist_details').hide();
                } else {
                    $('#distributor_id').hide();
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
    </body>
</html>