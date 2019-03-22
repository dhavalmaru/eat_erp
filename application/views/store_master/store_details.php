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
            .error { margin-top: 15px !important; }
        </style>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/store'; ?>" > Store List </a>  &nbsp; &#10095; &nbsp; Store Details</div>

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
                    <div class="box-shadow">
                        <form id="form_store_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/store/update/' . $data[0]->id; else echo base_url().'index.php/store/save'; ?>">
                            <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="form-group" >
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone</label>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <select name="zone_id" id="zone_id" class="form-control select2" data-error="#err_zone">
                                                            <option value="">Select</option>
                                                            <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                            <option value="<?php echo $zone[$k]->id; ?>" <?php if (isset($data)) { if($zone[$k]->id==$data[0]->zone_id) { echo 'selected'; } } ?>><?php echo $zone[$k]->zone; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <span id="err_zone"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"  >
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label"> Relation <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <select name="store_id" id="store_id" class="form-control select2" data-error="#err_relation">
                                                            <option value="">Select</option>
                                                            <?php if(isset($store_rel)) { for ($k=0; $k < count($store_rel) ; $k++) { ?>
                                                            <option value="<?php echo $store_rel[$k]->id; ?>" <?php if (isset($data)) { if($store_rel[$k]->id==$data[0]->store_id) { echo 'selected'; } } ?>><?php echo $store_rel[$k]->store_name; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <span id="err_relation"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"  >
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Location</label>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <select name="location_id" id="location_id" class="form-control select2" data-error="#err_location">
                                                            <option value="">Select</option>
                                                            <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                            <option value="<?php echo $location[$k]->id; ?>" <?php if (isset($data)) { if($location[$k]->id==$data[0]->location_id) { echo 'selected'; } } ?>><?php echo $location[$k]->location; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <span id="err_location"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Category</label>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <select name="category" id="category" class="form-control select2" data-error="#err_category">
                                                            <option value="">Select</option>
                                                            <option value="A" <?php if (isset($data)) { if($data[0]->category=="A") { echo 'selected'; } } ?>>A</option>
                                                            <option value="B" <?php if (isset($data)) { if($data[0]->category=="B") { echo 'selected'; } } ?>>B</option>
                                                            <option value="C" <?php if (isset($data)) { if($data[0]->category=="C") { echo 'selected'; } } ?>>C</option>
                                                        </select>
                                                        <span id="err_category"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Google Address</label>
                                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                                        <input type="text" class="form-control" name="google_address" id="google_address"  onFocus="geolocate()" placeholder="Google Address" value="<?php if(isset($data)) { echo  $data[0]->google_address; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Latitude</label>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <input type="text" class="form-control latitude" id="latitude" name="st_latitude" placeholder="Latitude" value="<?php if (isset($data)) { echo $data[0]->latitude; } ?>"/>
                                                    </div>
                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Longitude</label>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <input type="text" class="form-control longitude" id="longitude" name="st_longitude" placeholder="Longitude" value="<?php if (isset($data)) { echo $data[0]->longitude; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"  >
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
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
                                <a href="<?php echo base_url(); ?>index.php/store" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
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

        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
        var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&libraries=places&callback=initAutocomplete" async defer></script>

        <script type='text/javascript'>
            // City change
            $('#type_id').change(function(){
                var type_id = $(this).val();
                //console.log(reporting_manager_id);
                // AJAX request
                $.ajax({
                    url:'<?=base_url()?>index.php/store/get_zone',
                    method: 'post',
                    data: {type_id: type_id},
                    dataType: 'json',
                    success: function(response){
                        $('#zone_id').find('option').not(':first').remove();
                        // Add options
                        // response = $.parseJSON(response);
                        console.log(response);
                        $.each(response,function(index,data){
                            $('#zone_id').append('<option value="'+data['id']+'">'+data['zone']+'</option>');
                        });
                    }
                });
            });
        </script>

        <script type="text/javascript">
            var placeSearch, autocomplete;
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
            };

            function initAutocomplete() {
                // Create the autocomplete object, restricting the search to geographical
                // location types.
                autocomplete = new google.maps.places.Autocomplete((document.getElementById('google_address')), {types: ['geocode']});
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    //document.getElementById('google_address').value = place.name;
                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();
                    //alert("This function is working!");
                    //alert(place.name);
                    // alert(place.address_components[0].long_name);

                });
                // When the user selects an address from the dropdown, populate the address
                // fields in the form.
                //autocomplete.addListener('place_changed', fillInAddress);
            }

            function geolocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        var circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        autocomplete.setBounds(circle.getBounds());
                    });
                }
            }
        </script>
    </body>
</html>