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
        </style>
    </head>
    <body>

        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        <div class="heading-h2"><a href="<?php echo base_url().'index.php/merchandiser_location'; ?>" > Merchandiser Location List </a>  &nbsp; &#10095; &nbsp; Merchandiser Location Details</div>

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
                    <div class="box-shadow">
                    <form id="form_sales_rep_location_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/merchandiser_location/save/' . $data[0]->mid; else echo base_url().'index.php/merchandiser_location/save'; ?>">
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
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="distributor_id" id="distributor_id" class="form-control" >
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) if ($data[0]->dist_id==$distributor[$k]->id) echo 'selected'; ?>><?php echo $distributor[$k]->store_name; ?></option>
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
                                <div class="form-group" id="bar_details">
                                <?php $i=0; if(isset($stock_details)) { 
                                        for($i=0; $i<count($stock_details); $i++) { 
                                ?>
                                    <div class="col-md-4 col-sm-4 col-xs-12" style="padding-bottom: 3px;">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select name="bar[]" id="bar_<?php echo $i;?>" class="form-control bar">
                                                <option value="">Select</option>
                                                <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                        <option value="<?php echo $bar[$k]->id; ?>" <?php if($bar[$k]->id==$stock_details[$i]->item_id) { echo 'selected'; } ?>><?php echo $bar[$k]->short_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <input type="text" name="qty[]" id="qty_<?php echo $i;?>" class="form-control" value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                        </div>
                                        <!-- <div class="col-md-2 col-sm-2 col-xs-2">
                                            <select name="month[]" id="month_<?php //echo $i;?>" class="form-control">
                                                <option value="">Month</option>
                                                <?php //for ($k=1; $k <= 12 ; $k++) { ?>
                                                        <option value="<?php //echo $k; ?>" <?php //if($k==$stock_details[$i]->month) echo 'selected'; ?>><?php //echo $k; ?></option>
                                                <?php //} ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <select name="year[]" id="year_<?php //echo $i;?>" class="form-control">
                                                <option value="">Year</option>
                                                <?php //for ($k=intval(date("Y")); $k > 2016 ; $k--) { ?>
                                                        <option value="<?php //echo $k; ?>" <?php //if($k==$stock_details[$i]->year) echo 'selected'; ?>><?php //echo $k; ?></option>
                                                <?php //} ?>
                                            </select>
                                        </div> -->
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }} else { 
                                    for($i=0; $i<count($bar_details); $i++) { 
                                ?>
                                    <div class="col-md-4 col-sm-4 col-xs-12" style="padding-bottom: 3px;">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select name="bar[]" id="bar_<?php echo $i;?>" class="form-control bar">
                                                <option value="">Select</option>
                                                <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                        <option value="<?php echo $bar[$k]->id; ?>" <?php if($bar[$k]->id==$bar_details[$i]->id) { echo 'selected'; } ?>><?php echo $bar[$k]->short_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <input type="text" name="qty[]" id="qty_<?php echo $i;?>" class="form-control" value="" placeholder="Available Stock" />
                                        </div>
                                        <!-- <div class="col-md-2 col-sm-2 col-xs-2">
                                            <select name="month[]" id="month_<?php //echo $i;?>" class="form-control">
                                                <option value="">Month</option>
                                                <?php //for ($k=1; $k <= 12 ; $k++) { ?>
                                                        <option value="<?php //echo $k; ?>"><?php //echo $k; ?></option>
                                                <?php //} ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <select name="year[]" id="year_<?php //echo $i;?>" class="form-control">
                                                <option value="">Year</option>
                                                <?php //for ($k=intval(date("Y")); $k > 2016 ; $k--) { ?>
                                                        <option value="<?php //echo $k; ?>"><?php //echo $k; ?></option>
                                                <?php //} ?>
                                            </select>
                                        </div> -->
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php }} ?>
                                <!-- <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Butterscotch Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php //if(isset($data)) echo $data[0]->butterscotch_bar;?>" class="form-control" name="butterscotch_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Chocolate Peanut Butter Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php //if(isset($data)) echo $data[0]->chocopeanut_bar;?>" class="form-control" name="chocopeanut_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bambaiya Chaat Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php //if(isset($data)) echo $data[0]->bambaiyachaat_bar;?>" class="form-control" name="bambaiyachaat_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mango Ginger Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php //if(isset($data)) echo $data[0]->mangoginger_bar;?>" class="form-control" name="mangoginger_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Berry Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php //if(isset($data)) echo $data[0]->berry_bar;?>" class="form-control" name="berry_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Chywanprash Bar </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" value="<?php //if(isset($data)) echo $data[0]->chywanprash_bar;?>" class="form-control" name="chywanprash_bar" placeholder="Available Stock" />
                                        </div>
                                    </div>
                                </div> -->
                                </div>
                                <div class="form-group"><button type="button" class="btn btn-success" id="repeat-bar">+</button></div>
                                </div>
                            </div>
                            </div>
                            <br clear="all"/>
                        </div>
                        </div>
                        <div class="panel-footer">
                            <a href="<?php echo base_url(); ?>index.php/merchandiser_location" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                            <input type="submit" value="Save" id="Saver" name="srld" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>"/>
                           
                        
                            
                        </div>



                        <!-- Modal -->
                        


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
                    var newRow = jQuery('<div class="col-md-4 col-sm-4 col-xs-12" id="bar_'+counter+'_row" style="padding-bottom: 3px;">' + 
                                            '<div class="col-md-4 col-sm-4 col-xs-4">' + 
                                                '<select name="bar[]" id="bar_'+counter+'" class="form-control bar">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->short_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                            '</div>' + 
                                            '<div class="col-md-4 col-sm-4 col-xs-4">' + 
                                                '<input type="text" name="qty[]" id="qty_'+counter+'" class="form-control" value="" placeholder="Available Stock" />' + 
                                            '</div>' + 
                                            '<!-- <div class="col-md-2 col-sm-2 col-xs-2">' + 
                                                '<select name="month[]" id="month_'+counter+'" class="form-control">' + 
                                                    '<option value="">Select Month</option>' + 
                                                    '<?php //for ($k=1; $k <= 12 ; $k++) { ?>' + 
                                                            '<option value="<?php //echo $k; ?>"><?php //echo $k; ?></option>' + 
                                                    '<?php //} ?>' + 
                                                '</select>' + 
                                            '</div>' + 
                                            '<div class="col-md-2 col-sm-2 col-xs-2">' + 
                                                '<select name="year[]" id="year_'+counter+'" class="form-control">' + 
                                                    '<option value="">Select Year</option>' + 
                                                    '<?php //for ($k=intval(date("Y")); $k > 2016 ; $k--) { ?>' + 
                                                            '<option value="<?php //echo $k; ?>"><?php //echo $k; ?></option>' + 
                                                    '<?php //} ?>' + 
                                                '</select>' + 
                                            '</div> -->' + 
                                            '<div class="col-md-3 col-sm-3 col-xs-4">' + 
                                                '<select name="batch_no[]" id="batch_no_'+counter+'" class="form-control">' + 
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

             
        </script>
    </body>
</html>