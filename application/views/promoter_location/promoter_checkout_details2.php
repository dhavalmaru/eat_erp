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
                    <form id="form_sales_rep_location_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/promoter_checkout_location/save/' . $data[0]->id; else echo base_url().'index.php/promoter_checkout_location/save'; ?>">
                        <div class="box-shadow-inside">
                        <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="promoter_loc_id" id="promoter_loc_id" value="<?php if(isset($id)) echo $id;?>"/>
                                            <input type="hidden" class="form-control" name="latitude" id="latitude" value="<?php if(isset($data)) echo $data[0]->latitude;?>"/>
                                            <input type="hidden" class="form-control" name="longitude" id="longitude" value="<?php if(isset($data)) echo $data[0]->longitude;?>"/>
                                            <input type="text" class="form-control" name="date_of_visit" id="date_of_visit" placeholder="Date Of Visit" value="<?php if(isset($data)) echo (($data[0]->date_of_visit!=null && $data[0]->date_of_visit!='')?date('d/m/Y',strtotime($data[0]->date_of_visit)):date('d/m/Y')); else echo date('d/m/Y'); ?>" readonly="true" style="color: #245478; background-color: white;"/>
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
                                            <span><?php if(isset($dist_name)) { echo $dist_name[0]->store_name; } ?></span>
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
                                            <input type="number" value="" class="form-control" name="orange_bar_opening" placeholder="Opening Stock"></textarea>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1)) echo $data1[0]->orange_bar;?>" class="form-control" name="orange_bar" placeholder="Closing Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Mint Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="" class="form-control" name="mint_bar_opening" placeholder="Opening Stock"></textarea>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1)) echo $data1[0]->mint_bar;?>" class="form-control" name="mint_bar" placeholder="Closing Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Butterscotch Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="" class="form-control" name="butterscotch_bar_opening" placeholder="Opening Stock"></textarea>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1)) echo $data1[0]->butterscotch_bar;?>" class="form-control" name="butterscotch_bar" placeholder="Closing Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Chocolate Peanut Butter Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1)) echo $data1[0]->chocopeanut_bar;?>" class="form-control" name="chocopeanut_bar_opening" placeholder="Opening Stock"></textarea>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1)) echo $data1[0]->chocopeanut_bar;?>" class="form-control" name="chocopeanut_bar" placeholder="Closing Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Bambaiya Chaat Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="" class="form-control" name="bambaiyachaat_bar_opening" placeholder="Opening Stock"></textarea>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1)) echo $data1[0]->bambaiyachaat_bar;?>" class="form-control" name="bambaiyachaat_bar" placeholder="Closing Stock"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">EAT Anytime Mango Ginger Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="" class="form-control" name="mangoginger_bar_opening" placeholder="Opening Stock"></textarea>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="number" value="<?php if(isset($data1)) echo $data1[0]->mangoginger_bar;?>" class="form-control" name="mangoginger_bar" placeholder="Closing Stock"></textarea>
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
                            <a href="<?php echo base_url(); ?>index.php/Dashboard_promoter" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                            
                            <input type="submit" value="Save" name="srld" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>margin-right: 15px;"/>
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