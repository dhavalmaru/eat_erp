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
        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sales_rep_distributor'; ?>" > Retailer List </a>  &nbsp; &#10095; &nbsp; Retailer Details</div>

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
                  
                    <form id="form_sales_rep_distributor_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep_distributor/save/' . $data[0]->id; else echo base_url().'index.php/sales_rep_distributor/save'; ?>">
                         <div class="box-shadow-inside" style="margin-top: 120px;">
                        <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="place_order" id="place_order" value="No"/>
                                            <select name="distributor_id" id="distributor_id" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) { if($distributor[$k]->id==$data[0]->distributor_id) { echo 'selected'; } } ?>><?php echo $distributor[$k]->distributor_name; ?></option>
                                                <?php }} ?>
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
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Retailer Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="distributor_name" id="distributor_name" placeholder="Distributor Name" value="<?php if(isset($data)) echo $data[0]->distributor_name; else if(isset($distributor_name)) echo $distributor_name;?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">GST Number</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="gst_number" id="gst_number" placeholder="Gst Number" value="<?php if(isset($data)) { echo  $data[0]->gst_number; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label old_dist_details">Zone</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12 old_dist_details">
                                            <select name="zone_id" id="zone_id" class="form-control" onchange="get_area();">
                                                <option value="">Select</option>
                                                <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                        <option value="<?php echo $zone[$k]->zone_id; ?>" <?php if(isset($data)) {if($zone[$k]->zone_id==$data[0]->zone_id) {echo 'selected';}} else if(isset($zone_id)) {if($zone[$k]->zone_id==$zone_id) {echo 'selected';}} ?>><?php echo $zone[$k]->zone; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="area_id" id="area_id" class="form-control" onchange="get_location();">
                                                <option value="">Select</option>
                                                <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                                        <option value="<?php echo $area[$k]->area_id; ?>" <?php if(isset($data)) {if($area[$k]->area_id==$data[0]->area_id) {echo 'selected';}} else if(isset($area_id)) {if($area[$k]->area_id==$area_id) {echo 'selected';}} ?>><?php echo $area[$k]->area; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Location</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="location_id" id="location_id" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                        <option value="<?php echo $location[$k]->id; ?>" <?php if(isset($data)) {if($location[$k]->id==$data[0]->location_id) {echo 'selected';}} else if(isset($location_id)) {if($location[$k]->id==$location_id) {echo 'selected';}} ?>><?php echo $location[$k]->location; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Margin On MRP (In %)*</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="margin" placeholder="Margin" value="<?php if(isset($data)) echo $data[0]->margin;?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Document</label>
                                        <div class="col-md-2 col-sm-2 col-xs-12" >
                                            <input type="hidden" class="form-control" name="doc_document" value="<?php if(isset($data)) echo $data[0]->doc_document; ?>" />
                                            <input type="hidden" class="form-control" name="document_name" value="<?php if(isset($data)) echo $data[0]->document_name; ?>" />
                                            <!-- <input type="file" class="fileinput btn btn-info btn-small doc_file" name="doc_file" id="doc_file" data-error="#doc_file_error"/> -->
                                            <input type="file" accept="image/*;capture=camera" class="fileinput btn btn-info btn-small doc_file" name="doc_file" id="doc_file" data-error="#doc_file_error"/>
                                            <div id="doc_file_error"></div>
                                        </div>          
                                        <div class="col-md-2 col-sm-2 col-xs-12 download-width" >
                                            <?php if(isset($data)) { if($data[0]->doc_document!= '') { ?><a target="_blank" id="doc_file_download" href="<?php if(isset($data)) echo base_url().$data[0]->doc_document; ?>"><span class="fa download fa-download" ></span></a></a><?php }} ?>
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
							<div class="panel-footer">
                            <a href="<?php echo base_url(); ?>index.php/sales_rep_distributor" class="submitLink" type="reset" id="reset">Cancel</a>
                            <a href="#" id="btn_save" class="submitLink pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;'; else if(substr($data[0]->id,0,1)=="d") echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</a>
                            <!-- <button id="btn_save" class="btn pull-right" style="<?php //if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
                        </div>
                            </div>
                            <br clear="all"/>
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


        <div id="confirm_content2" style="display:none">
            <div class="logout-containerr">
                <button type="button" class="close" data-confirmmodal-but="cancel">×</button>
                <div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Place Order? </div>
                <div class="confirmModal_content">
                    <p>Do you want to place order?</p>
                </div>
                <div class="confirmModal_footer">
                    <!-- <a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a> -->
                    <button type="button" class="submitLink " data-confirmmodal-but="ok">Yes</button>
                    <button type="button" class="submitLink " data-confirmmodal-but="cancel">No</button>
                </div>
            </div>
        </div>


        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script>
            $("#btn_save").click(function(){
                if (!$("#form_sales_rep_distributor_details").valid()) {
                    return false;
                } else {
                    $('#confirm_content2').confirmModal({
                        topOffset: 0,
                        onOkBut: function() {$('#place_order').val("Yes"); $("#form_sales_rep_distributor_details").submit();},
                        onCancelBut: function() {$('#place_order').val("No"); $("#form_sales_rep_distributor_details").submit();},
                        onLoad: function() {$('#place_order').val("No"); return true;},
                        onClose: function() {$('#place_order').val("No"); return true;}
                    });
                }
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
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>