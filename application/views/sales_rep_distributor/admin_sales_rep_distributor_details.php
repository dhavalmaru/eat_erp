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
		
    </head>
    <body>		
<?php 
                         if(isset($id) || isset($data[0]->id))
                         {
                            $id = $id;
                         }
                         else
                         {
                            $id = '';
                         }
                    ?>	
      <!-- START PAGE CONTAINER -->
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/location'; ?>" > Location List </a>  &nbsp; &#10095; &nbsp; Location Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="admin_form_sales_rep_distributor_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if ($id!='') echo base_url(). 'index.php/sales_rep_distributor/admin_save/' . $id; else echo base_url().'index.php/sales_rep_distributor/admin_save'; ?>">
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
								
								<div class="panel-body">
								
								<div class="form-group" id="type_normal">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="zone_id" id="zone_id" class="form-control select2" onchange="get_area();">
                                                   <option value="">Select</option>
                                                <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                        <option value="<?php echo $zone[$k]->zone_id; ?>" <?php if(isset($data)) {if($zone[$k]->zone_id==$data[0]->zone_id) {echo 'selected';}} else if(isset($zone_id)) {if($zone[$k]->zone_id==$zone_id) {echo 'selected';}} ?>><?php echo $zone[$k]->zone; ?></option>
                                                <?php }} ?>
                                               </select>
                                            </div>
                                        </div>
                                 </div>
								
								
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
										
										   <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="area_id" id="area_id" class="form-control select2" onchange="get_location();">
                                                     <option value="">Select</option>
                                                <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                                        <option value="<?php echo $area[$k]->area_id; ?>" <?php if(isset($data)) {if($area[$k]->area_id==$data[0]->area_id) {echo 'selected';}} else if(isset($area_id)) {if($area[$k]->area_id==$area_id) {echo 'selected';}} ?>><?php echo $area[$k]->area; ?></option>
                                                <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											 <label class="col-md-2 col-sm-2 col-xs-12 control-label">Location <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                 <select name="location_id" id="location_id" class="browser-default select2">
											       <option value="">Select</option>
                                                <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                        <option value="<?php echo $location[$k]->id; ?>" <?php if(isset($data)) {if($location[$k]->id==$data[0]->location_id) {echo 'selected';}} else if(isset($location_id)) {if($location[$k]->id==$location_id) {echo 'selected';}} ?>><?php echo $location[$k]->location; ?></option>
                                                <?php }} ?>
                                       </select>
                                            </div>
                                         
                                        </div>
                                    </div>
									
									
									<div class="form-group"  >
									<div class="col-md-12 col-sm-12 col-xs-12">
										<input type="hidden" class="form-control " name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
									 <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor</label>
                                       <div class="col-md-4 col-sm-4 col-xs-12">
											<input type="text" class="form-control" name="distributor_name" id="distributor_name" style="" 
											placeholder="Retailer Name" 
											value="<?php if(isset($data[0]->distributor_name )){
                                          echo $data[0]->distributor_name; }  ?>"  />
										</div>
									</div>
								</div>
									
									<div class="form-group">
                                      
										<div class="col-md-12 col-sm-12 col-xs-12">
										 <label class="col-md-2 col-sm-2 col-xs-12 control-label">GST Number <span class="asterisk_sign">*</span></label>

										
										 <div class="col-md-4 col-sm-4 col-xs-12">
											<input type="text" class="form-control" name="gst_number" id="gst_number" placeholder="GST Number" value="<?php if(isset($data)) echo $data[0]->gst_number; else if(isset($gst_number)) echo $gst_number;?>"/>
                                        </div>
                                        
                                    </div> 
                                    </div> 
                                    
                                    
									<div class="form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
										
										 <label class="col-md-2 col-sm-2 col-xs-12 control-label">Margin On MRP (In %) <span class="asterisk_sign">*</span> </label>
											
										
										 <div class="col-md-4 col-sm-4 col-xs-12">								
										
											<input type="text" class="form-control" name="margin" placeholder="Margin" value="<?php if(isset($data)) echo $data[0]->margin;?>"/>
											
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
									<a href="<?php echo base_url(); ?>index.php/location" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if($id!='') {if($access[0]->r_edit=='0') echo 'display: none;'; else if(substr($id,0,1)=="d") echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type='text/javascript'>


 
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
							 $('#location_id').val(location_id);
                        }
                });
            }
   
   
 
   </script>
    <!-- END SCRIPTS -->      
    </body>
</html>