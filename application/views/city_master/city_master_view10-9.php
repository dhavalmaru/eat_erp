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
		
		<style>
		  @media only screen and  (min-width:240px)  and (max-width:441px) { 
					.btn-top-margin {   margin:10px 18px!important;     }	
		   }
		
		  @media only screen and  (min-width:442px)  and (max-width:575px) { 
					.btn-top-margin {   margin-top:-40px!important;     }	
		   }
		</style>
		<style>
			.panel { box-shadow:none; border:1px dotted #e7e7e7; border-top:0px solid #33414e!important;}
			.input-padding { line-height:30px;}
			@media only screen and (max-width:780px) {.input-padding { line-height:15px;}}
			
		</style>
    </head>
    <body>								
     <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                  
                   
                <!-- PAGE CONTENT WRAPPER -->
                <?php
                if($action == 'edit_insert'){?>
				 <div class="heading-h2 responsive-heading"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/city_master'; ?>" > City List </a>  &nbsp; &#10095; &nbsp; City Master Details</div>
                <div class="page-content-wrap">
				    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                       <form id="form_tax" method="post" action="<?php echo base_url()?>index.php/city_master/insertUpdateRecord">
                          <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							<div class="panel-body">                                                                        
                                <input type="hidden" name="city_id" id="city_id" value="<?php if(isset($city_details)){ echo $city_details[0]->city_id; }  ?>">
								
								
									<div class="form-group" style="display:flex; border-top:1px solid #eee;" >
									<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">State Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <select class="form-control state_name" name="state_name" id="state_name" required >
												    <option value=''>Select State</option>
                                                    <?php if(isset($state_list)){
                                                        foreach($state_list as $row){
                                                           if(isset($city_details)){
                                                            if($row->id == $city_details[0]->state_id){
                                                            echo "<option value='".$row->id."' selected='selected'>".$row->state_name."</option>";
                                                                
                                                            }
                                                            else{
                                                            echo "<option value='".$row->id."'>".$row->state_name."</option>";

                                                            }
                                                        }
                                                        else{
                                                            echo "<option value='".$row->id."'>".$row->state_name."</option>";

                                                        }
                                                        }

                                                    }?>
                                                    </select>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">City Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control city_name" name="city_name" placeholder="City Name" value="<?php if(isset($city_details)){ echo $city_details[0]->city_name; } ?>" required/>
                                            </div>
										</div>
										
										
                                     </div>
                                    
                      
                                
                              
                            </div>
						</div>
						</div>
						<br clear="all"/>
                    </div>
						   <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/city_master"class="btn btn-danger"  >Cancel</a>
                                	<input type="submit" class="btn btn-success pull-right" value="Submit" />
                                </div>
								
								
						 
                </form>
                </div>
			   </div>
                   </div>
                  </div>
                <!-- END PAGE CONTENT WRAPPER -->
                <?php } else{?>
				
				      
            <!-- PAGE CONTENT -->
			
             
               
				   
				         <div class="heading-h2 responsive-heading"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/city_master'; ?>" > City List </a>  &nbsp; &#10095; &nbsp; City Master </div>
                       <div class="pull-right btn-top-margin margin-responsive">
					   	 <a href="<?php echo base_url(); ?>index.php/city_master" class=""><span class="btn btn-danger  "> Cancel </span>  </a>
                                     <?php
                                 // if(isset($access)) { if($access[0]->r_edit == 1) {  ?>
                                    <a href="<?php echo base_url(); ?>index.php/city_master/city_edit/<?php echo $city_details[0]->city_id;?>" class=""><span class="btn btn-success "> Edit </span>  </a>
                                <?php ?>
									
                             
                                </div>
				   
				   

				  
                <div class="page-content-wrap">
				    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">		
                <form method="post" action="<?php echo base_url()?>index.php/Tax_master/insertUpdateRecord">
               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
    						
    					 
    						<div class="panel-body">
							
							
							
    								<div class="form-group"  style="display:flex; border-top:1px solid #eee;" >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">City Name :</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12  input-padding" >
                                              	<!-- <input type="text" class="form-control" name="tax_name[]"  placeholder="Tax Name" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_name; } ?>"/> -->
    												<?php echo $city_details[0]->city_name;?>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">State Name :</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12 input-padding"   >
                                                <!-- <input type="text" class="form-control" name="tax_perecnt[]" placeholder="Tax Perecenatge" value="<?php if(!isset($tax_detail)){ echo $tax_detail[0]->tax_percent; } ?>"/> -->
                                                    	<?php echo $city_details[0]->state_name;?>
                                            </div>
										</div>
									 
                                    </div>
                            </div>
    					</div>
                        </div>
							<br clear="all"/>
                    </div> 
								 <div class="panel-footer">
								     <a href="<?php echo base_url(); ?>index.php/city_master/delete_record/<?php if(isset($city_details)){ echo $city_details[0]->city_id; }  ?>" class="btn btn-danger" ><span  > Delete </span>  </a>
                                </div>
                </form>
				</div>
                        </div>
                    </div>
                </div>
           
                <?php } ?>
            </div>
            <!-- END PAGE CONTENT WRAPPER -->     
        </div>
        <!-- END PAGE CONTENT -->

        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script>
            var div_master = "";

            
        </script>
        <!-- END SCRIPTS -->
    </body>
</html>