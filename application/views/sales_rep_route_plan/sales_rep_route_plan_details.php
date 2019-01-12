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
        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sales_rep_route_plan'; ?>" > Route Plan List </a>  &nbsp; &#10095; &nbsp; Route Plan Details</div>

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
          
                    <form id="form_sales_rep_route_plan_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep_route_plan/save/' . $data[0]->id; else echo base_url().'index.php/sales_rep_route_plan/save'; ?>">
                        <div class="box-shadow-inside">
                        <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="latitude" id="latitude" value="<?php if(isset($data)) echo $data[0]->latitude;?>"/>
                                            <input type="hidden" class="form-control" name="longitude" id="longitude" value="<?php if(isset($data)) echo $data[0]->longitude;?>"/>
                                            <input type="text" class="form-control" name="area" id="area" placeholder="Area" value="<?php if(isset($data)) echo $data[0]->area;?>"/>
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
                                            <input type="text" class="form-control" name="distributor_name" id="distributor_name" placeholder="Distributor Name" value="<?php if(isset($data)) echo $data[0]->distributor_name;?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select class="form-control" name="distributor_status">
                                                <option value="">Select</option>
                                                <option value="Not Interested" <?php if(isset($data)) {if ($data[0]->distributor_status=='Not Interested') echo 'selected';}?>>Not Interested</option>
                                                <option value="Follow Up" <?php if(isset($data)) {if ($data[0]->distributor_status=='Follow Up') echo 'selected';}?>>Follow Up</option>
                                                <option value="Place Order" <?php if(isset($data)) {if ($data[0]->distributor_status=='Place Order') echo 'selected';}?>>Place Order</option>
                                                <option value="Closed" <?php if(isset($data)) {if ($data[0]->distributor_status=='Closed') echo 'selected';}?>>Closed</option>
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
                            </div>
                            </div>
                            <br clear="all"/>
                        </div>
                        </div>
                        <div class="panel-footer">
                            <a href="<?php echo base_url(); ?>index.php/sales_rep_route_plan" class="submitLink" type="reset" id="reset">Cancel</a>
                            <button class="submitLink pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
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
        <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&sensor=false&extension=.js"></script> -->
        <script>
            // $('#form_sales_rep_route_plan_details').submit(function() {
            //     if (!$("#form_sales_rep_route_plan_details").valid()) {
            //         return false;
            //     } else {
            //         return true;
            //     }
            // });
            // $('document').ready(function(){
            //         console.log("Hiii");
            //     navigator.geolocation.getCurrentPosition(function(location) {
            //         console.log("Hiii");
            //         $("#latitude").val(location.coords.latitude);
            //         $("#longitude").val(location.coords.longitude);
            //         console.log(location.coords.latitude);
            //     });
            // });
        </script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw"></script>
        <script>
            $('#form_sales_rep_route_plan_details').submit(function() {
                if (!$("#form_sales_rep_route_plan_details").valid()) {
                    return false;
                } else {
                    return true;
                }
            });
            $('document').ready(function(){
                navigator.geolocation.getCurrentPosition(function(location) {
                    $("#latitude").val(location.coords.latitude);
                    $("#longitude").val(location.coords.longitude);
                });
            });
        </script>

        <script>
            // $('document').ready(function(){
            //     var apiGeolocationSuccess = function(position) {
            //         // alert("API geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);

            //         $("#latitude").val(position.coords.latitude);
            //         $("#longitude").val(position.coords.longitude);
            //         // console.log(position.location.latitude);
            //     };

            //     var tryAPIGeolocation = function() {
            //         // var jsonData = '{"considerIp": "false"}';

            //         jQuery.post( "https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyByt1eiZ0LzM3tPth_2qUs4Iw0afa0WySE", function(success) {
            //             apiGeolocationSuccess({coords: {latitude: success.location.lat, longitude: success.location.lng}});
            //             // console.log(success.location.lat);
            //         })

            //         // $.ajax({
            //         //     url: 'https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyByt1eiZ0LzM3tPth_2qUs4Iw0afa0WySE',
            //         //     data: jsonData,
            //         //     type: "POST",
            //         //     dataType: 'json',
            //         //     global: false,
            //         //     async: false,
            //         //     success: function (success) {
            //         //         apiGeolocationSuccess({coords: {latitude: success.location.lat, longitude: success.location.lng}});
            //         //         console.log(success.location.lat);
            //         //     },
            //         //     error: function (xhr, ajaxOptions, thrownError) {
            //         //         alert(xhr.status);
            //         //         alert(thrownError);
            //         //     }
            //         // });

                    

            //       .fail(function(err) {
            //         // alert("API Geolocation error! \n\n"+err);
            //         console.log("API Geolocation error! \n\n"+err);
            //       });


            //         // $ curl -d @your_filename.json -H "Content-Type: application/json" -i "https://www.googleapis.com/geolocation/v1/geolocate?key=YOUR_API_KEY"
            //     };

            //     var browserGeolocationSuccess = function(position) {
            //         // alert("Browser geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);

            //         $("#latitude").val(position.coords.latitude);
            //         $("#longitude").val(position.coords.longitude);
            //     };

            //     var browserGeolocationFail = function(error) {
            //       switch (error.code) {
            //         case error.TIMEOUT:
            //             // alert("Browser geolocation error !\n\nTimeout.");
            //             console.log("Browser geolocation error !\n\nTimeout.");
            //           break;
            //         case error.PERMISSION_DENIED:
            //           if(error.message.indexOf("Only secure origins are allowed") == 0) {
            //             tryAPIGeolocation();
            //           }
            //           break;
            //         case error.POSITION_UNAVAILABLE:
            //             // alert("Browser geolocation error !\n\nPosition unavailable.");
            //             console.log("Browser geolocation error !\n\nPosition unavailable.");
            //           break;
            //       }
            //     };

            //     var tryGeolocation = function() {
            //         if (navigator.geolocation) {
            //             navigator.geolocation.getCurrentPosition(
            //                 browserGeolocationSuccess,
            //                 browserGeolocationFail,
            //                 {maximumAge: 50000, timeout: 20000, enableHighAccuracy: true});
            //         }
            //     };

            //     tryGeolocation();
            // });
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>