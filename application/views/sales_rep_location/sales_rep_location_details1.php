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
        </style>
    </head>
    <body>

        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sales_rep_location'; ?>" > Location List </a>  &nbsp; &#10095; &nbsp; Location Details</div>

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
                    <div class="box-shadow">
                    <form id="form_sales_rep_location_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep_location/save/' . $data[0]->id; else echo base_url().'index.php/sales_rep_location/save'; ?>">
                        <div class="box-shadow-inside">
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
                                            <input type="text" class="form-control" name="date_of_visit" id="date_of_visit" placeholder="Date Of Visit" value="<?php if(isset($data)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>" readonly="true" style="color: #245478; background-color: white;"/>
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
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="distributor_id" id="distributor_id" class="form-control" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo ''; else  echo 'display: none;';} ?>">
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) {if($distributor[$k]->id==$data[0]->distributor_id) {echo 'selected';}} else if(isset($distributor_id)) {if($distributor[$k]->id==$distributor_id) {echo 'selected';}} ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                            <input type="text" class="form-control" name="distributor_name" id="distributor_name" style="<?php if(isset($data)) {if($data[0]->distributor_type=='Old') echo 'display: none;';} else {echo 'display: none;';} ?>" placeholder="Distributor Name" value="<?php if(isset($data)) echo $data[0]->distributor_name;?>"/>
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
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Orange Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php if(isset($data1)) echo $data1[0]->orange_bar;?>" class="form-control" name="orange_bar" placeholder="Available Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Mint Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php if(isset($data1)) echo $data1[0]->mint_bar;?>" class="form-control" name="mint_bar" placeholder="Available Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Butterscotch Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php if(isset($data1)) echo $data1[0]->butterscotch_bar;?>" class="form-control" name="butterscotch_bar" placeholder="Available Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Chocolate Peanut Butter Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php if(isset($data1)) echo $data1[0]->chocopeanut_bar;?>" class="form-control" name="chocopeanut_bar" placeholder="Available Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Bambaiya Chaat Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php if(isset($data1)) echo $data1[0]->bambaiyachaat_bar;?>" class="form-control" name="bambaiyachaat_bar" placeholder="Available Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Mango Ginger Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php if(isset($data1)) echo $data1[0]->mangoginger_bar;?>" class="form-control" name="mangoginger_bar" placeholder="Available Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            <br clear="all"/>
                        </div>
                        </div>
                        <div class="panel-footer">
                            <a href="<?php echo base_url(); ?>index.php/sales_rep_location" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                            <a data-toggle="modal" href="#myModal" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Follow Up</a>
                            <input type="submit" value="Place Order" name="srld" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 15px;"/>
                            <input type="submit" value="Save" name="srld" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 15px;"/>
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
                                    <input type="text" class="form-control datepicker" name="followup_date" id="followup_date" placeholder="Follow Up Date" value="<?php if(isset($data)) echo (($data[0]->followup_date!=null && $data[0]->followup_date!='')?date('d/m/Y',strtotime($data[0]->followup_date)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <input type="submit" id="btn_save" name="srld" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>" value="Follow Up"/>
                        </div>
                    </div>
                </div>
            </div>


                    </form>
                    </div>
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
					var location_timeout = setTimeout("geolocFail()", 15000);
						
					navigator.geolocation.getCurrentPosition(function(location) {
						clearTimeout(location_timeout);
						
						$("#latitude").val(location.coords.latitude);
						$("#longitude").val(location.coords.longitude);
					}, function(error) {
						clearTimeout(location_timeout);
						geolocFail();
					});
				}
				else {
					geolocFail();
				}
            });
			
			function geolocFail() {
				alert("Error");
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
                } else {
                    $('#distributor_id').hide();
                    $('#distributor_name').show();
                    $('.ava_qty').hide();
                    $('.disstatus').hide();
                }
            }

            $('#btn_save').click(function(){
                $('#myModal').modal('toggle');
                blFlag = true;
            });
        </script>

        
        <!-- END SCRIPTS -->      
    </body>
</html>