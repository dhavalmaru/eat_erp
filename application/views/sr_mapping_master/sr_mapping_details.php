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
		#document_details { padding:0;}
		.lineheight { line-height:30px}
		@media only screen and (max-width:767px) { .btn-margin {    padding:15px 15px!important; }}
		
		@media only screen and (min-width: 767px) and (max-width: 1020px)  {
        .col-md-2 .col-md-3 {   }
	}	</style>
	 
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
           <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sr_mapping'; ?>" > Sr Mapping List </a>  &nbsp; &#10095; &nbsp; Sales Mapping Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                    <div class="page-content-wrap">
                      <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">	
							
                            <form id="form_sr_mapping" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/sr_mapping/update/' . $data[0]->id; else echo base_url().'index.php/sr_mapping/save'; ?>">
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">								
								   <div class="panel-body">
									   <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
									  <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 control-label">Class <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="class" id="classes">
                                                    <option value="">Select</option>
                                                    <option value="normal" <?php if(isset($data)) {if ($data[0]->class=='normal') echo 'selected';}?>>Normal</option>
                                                    <option value="super stockist" <?php if(isset($data)) {if ($data[0]->class=='super stockist') echo 'selected';}?>>Super stockist</option>
                                                    <option value="sample" <?php if(isset($data)) {if ($data[0]->class=='sample') echo 'selected';}?>>Sample</option>
                                                </select>
                                            </div>
                                           
										   
								
                                          
                                        </div>
                                    </div>
									
										  <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                    
										   
								
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12" >
                                                <select name="type_id" id="type_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($type)) { for ($k=0; $k < count($type) ; $k++) { ?>
                                                            <option value="<?php echo $type[$k]->id; ?>" <?php if (isset($data)) { if($type[$k]->id==$data[0]->type_id) { echo 'selected'; } } ?>><?php echo $type[$k]->distributor_type; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
									
                                    <div class="form-group" id="type_normal">
                                          <div class="col-md-12 col-sm-12 col-xs-12">
											
									
											
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="zone_id" id="zone_id"class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                            <option value="<?php echo $zone[$k]->id; ?>" <?php if (isset($data)) { if($zone[$k]->id==$data[0]->zone_id) { echo 'selected'; } } ?>><?php echo $zone[$k]->zone; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									<?php $blflag = false; if (isset($data)) {if(($data[0]->type_id=='7') || ($data[0]->type_id=='4')){
										$blflag = true;
									}} ?>
									
									
									<div class="form-group" id="type_ecom_mt" style="<?php if($blflag!=true) { echo 'display:none;'; } ?>">
                                         <div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Relation</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="area_id1" id="area_id1" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($store)) { for ($k=0; $k < count($store) ; $k++) { ?>
                                                            <option value="<?php echo $store[$k]->store_id; ?>" <?php if (isset($data)) { if($store[$k]->store_id==$data[0]->area_id1) { echo 'selected'; } } ?>><?php echo $store[$k]->store_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="form-group" id="type_gen" style="<?php if($blflag==true) { echo 'display:none;'; } ?>">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Area</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="area_id" id="area_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                                            <option value="<?php echo $area[$k]->id; ?>" <?php if (isset($data)) { if($area[$k]->id==$data[0]->area_id) { echo 'selected'; } } ?>><?php echo $area[$k]->area; ?></option>
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
                                                    <?php 
															//echo 'count'.count($location_normal);
															print_r($location);
															
													if(isset($location) && count($location)<0) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                            <option value="<?php echo $location[$k]->location_id; ?>" <?php if (isset($data)) { if($location[$k]->location_id==$data[0]->location_id) { echo 'selected'; } } ?>><?php echo $location[$k]->location; ?></option>
                                                    <?php }}
													
													else if(isset($location_normal)) { 
													
													for ($j=0; $j < count($location_normal) ; $j++) { 
													?>
                                                            <option value="<?php echo $location_normal[$j]->id; ?>" 
															<?php
																	
															if (isset($data)) { 
															if($location_normal[$j]->id==$data[0]->location_id) { echo 'selected'; } } ?>><?php echo $location_normal[$j]->location; ?></option>
                                                    <?php }}
													
													?>
                                                </select>
                                            </div>
											
										
											
                                        </div>
                                    </div>
									
									
									
									
									
									 <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                           
                                      			
											 <label class="col-md-2 col-sm-2 col-xs-12 control-label">Reporting Manager</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                              
												
												
												<select name="reporting_manager_id" id="reporting_manager_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
                                                            <option value="<?php echo $sales_rep[$k]->id; ?>" <?php if (isset($data)) { if($sales_rep[$k]->id==$data[0]->reporting_manager_id) { echo 'selected'; } } ?>><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
                                                    <?php }} ?>
                                                </select>
												
                                            </div>
											
                                        </div>
                                    </div>
									
									
									
									
									<div class="form-group" id="type_sample">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                           
                                           
											
											   <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative 1</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="sales_rep_id1" id="sales_rep_id1" class="form-control">
                                                    <option value="">Select</option>
                                                     <?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
                                                            <option value="<?php echo $sales_rep[$k]->id; ?>" <?php if (isset($data)) { if($sales_rep[$k]->id==$data[0]->sales_rep_id1) { echo 'selected'; } } ?>><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
											
											
											
										
											
											
                                        </div>
                                    </div>
                                 
								 	
								<div class="form-group" id="type_sample">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                           
                                           	
											   <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative 2</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="sales_rep_id2" id="sales_rep_id2" class="form-control">
                                                    <option value="">Select</option>
                                                     <?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
                                                            <option value="<?php echo $sales_rep[$k]->id; ?>" <?php if (isset($data)) { if($sales_rep[$k]->id==$data[0]->sales_rep_id2) { echo 'selected'; } } ?>><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
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
                                   
                       

								<br clear="all"/> 
								 </div>
								 </div>
								 </div>
								 </div>
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/sr_mapping" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
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
		
		<script type='text/javascript'>


 
    /*City change
    $('#reporting_manager_id').change(function(){
      var reporting_manager_id = $(this).val();
		//console.log(reporting_manager_id);
      // AJAX request
      $.ajax({
        url:'<?=base_url()?>index.php/sr_mapping/get_sr_name',
        method: 'post',
        data: {reporting_manager_id: reporting_manager_id},
        dataType: 'json',
        success: function(response){

          // Remove options 
          // $('#sel_user').find('option').not(':first').remove();
          $('#sales_rep_id1').find('option').not(':first').remove();
          $('#sales_rep_id2').find('option').not(':first').remove();

          // Add options
		  // response = $.parseJSON(response);
		  console.log(response);
          $.each(response,function(index,data){
             $('#sales_rep_id1').append('<option value="'+data['id']+'">'+data['sales_rep_name']+'</option>');
             $('#sales_rep_id2').append('<option value="'+data['id']+'">'+data['sales_rep_name']+'</option>');
          });
        }
     });
   });*/
   
   
 
   </script>
   
   
   <script type='text/javascript'>


 
    // City change
    $('#type_id').change(function(){
      var type_id = $(this).val();
		//console.log(reporting_manager_id);
      // AJAX request
      $.ajax({
        url:'<?=base_url()?>index.php/sr_mapping/get_zone',
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
       // City change
    $('#zone_id').change(function(){
		
    var zone_id = $('#zone_id').val();
		//console.log(reporting_manager_id);
      // AJAX request
	   var type_id = $('#type_id').val();
	
	  if(( type_id == '7') || (type_id == '4'))
	  {
		 
		  $.ajax({
        url:'<?=base_url()?>index.php/sr_mapping/get_store',
        method: 'post',
        data: {type_id: type_id, zone_id: zone_id},
        dataType: 'json',
        success: function(response){

 
          $('#area_id1').find('option').not(':first').remove();
      

          // Add options
          // response = $.parseJSON(response);
          // console.log(response);
          $.each(response,function(index,data){
             $('#area_id1').append('<option value="'+data['store_id']+'">'+data['store_name']+'</option>');
        
          });
        }
     });
	  }
	  else
	  {
		    
		$.ajax({
        url:'<?=base_url()?>index.php/sr_mapping/get_area',
        method: 'post',
        data: {type_id: type_id, zone_id: zone_id},
        dataType: 'json',
        success: function(response){

 
          $('#area_id').find('option').not(':first').remove();
      

          // Add options
		  // response = $.parseJSON(response);
		  // console.log(response);
          $.each(response,function(index,data){
             $('#area_id').append('<option value="'+data['id']+'">'+data['area']+'</option>');
        
          });
        }
     });
	 
		  
	  }
 
	   
	 
	 
	 
   });
   
   
   
   
 
   
     $('#area_id1').change(function(){
      var area_id1 = $('#area_id1').val();
      var zone_id = $('#zone_id').val();
		//console.log(reporting_manager_id);
      // AJAX request
      $.ajax({
        url:'<?=base_url()?>index.php/sr_mapping/get_location',
        method: 'post',
        data: {area_id1: area_id1,zone_id:zone_id},
        dataType: 'json',
        success: function(response){

 
          $('#location_id').find('option').not(':first').remove();
      

          // Add options
		  // response = $.parseJSON(response);
		  // console.log(response);
          $.each(response,function(index,data){
             $('#location_id').append('<option value="'+data['location_id']+'">'+data['location']+'</option>');
        
          });
        }
     });
   });
    
 
   </script>
   
   
   	<script>

		//$("#type_ecom_mt").hide();
		$('#type_id').on('change', function() {
			if(( this.value == '7') || ( this.value == '4'))
	

		{

			$("#type_ecom_mt").show();
			$("#type_gen").hide();

		}
		else
		{
			$("#type_ecom_mt").hide();
			$("#type_gen").show();
		}
		});
		
	</script>
   
   
   
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>

    <!-- END SCRIPTS -->      
    </body>
</html>