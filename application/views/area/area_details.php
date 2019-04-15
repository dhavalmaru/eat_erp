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
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/area'; ?>" > Area List </a>  &nbsp; &#10095; &nbsp; Area Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="form_area_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/area/update/' . $data[0]->id; else echo base_url().'index.php/area/save'; ?>">
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
								
								<div class="panel-body">
								
								
								    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12" >
                                                <select name="type_id" id="type_id" class="form-control select2" data-error="#err_type_id">
                                                    <option value="">Select</option>
                                                    <?php if(isset($type)) { for ($k=0; $k < count($type) ; $k++) { ?>
                                                            <option value="<?php echo $type[$k]->id; ?>" <?php if (isset($data)) { if($type[$k]->id==$data[0]->type_id) { echo 'selected'; } } ?>><?php echo $type[$k]->distributor_type; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_type_id"></div>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="zone_id" id="zone_id" class="form-control select2" data-error="#err_zone_id">
                                                    <option value="">Select</option>
                                                    <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                            <option value="<?php echo $zone[$k]->id; ?>" <?php if (isset($data)) { if($zone[$k]->id==$data[0]->zone_id) { echo 'selected'; } } ?>><?php echo $zone[$k]->zone; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_zone_id"></div>
                                            </div>
                                        </div>
                                    </div>
									
								
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											 <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control " name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control" name="area" id="area" placeholder="Area" value="<?php if(isset($data)) echo $data[0]->area;?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <div>
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
									<a href="<?php echo base_url(); ?>index.php/area" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type='text/javascript'>


 
    // City change
    $('#type_id').change(function(){
      var type_id = $(this).val();
		//console.log(reporting_manager_id);
      // AJAX request
      $.ajax({
        url:'<?=base_url()?>index.php/area/get_zone',
        method: 'post',
        data: {type_id: type_id},
        dataType: 'json',
        success: function(response){

 
          $('#zone_id').find('option').not(':first').remove();
      

          // Add options
		  // response = $.parseJSON(response);
		  // console.log(response);
          $.each(response,function(index,data){
             $('#zone_id').append('<option value="'+data['id']+'">'+data['zone']+'</option>');
        
          });
        }
     });
   });
   
   
 
   </script>
   
    <!-- END SCRIPTS -->      
    </body>
</html>