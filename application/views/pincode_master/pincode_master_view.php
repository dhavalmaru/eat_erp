<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>EAT ERP</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
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
				 <div class="heading-h2 responsive-heading"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/pincode_master'; ?>" > Pincode List </a>  &nbsp; &#10095; &nbsp; Pincode Master Details</div>
                <div class="page-content-wrap">
				    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                       <form id="form_pincode_details" method="post" action="<?php echo base_url()?>index.php/pincode_master/insertUpdateRecord">
                          <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							<div class="panel-body">                                                                        
                                <input type="hidden" name="id" id="id" value="<?php if(isset($pincode_details)){ echo $pincode_details[0]->id; }  ?>">
								
								
									<div class="form-group" style="display:flex; border-top:1px solid #eee;" >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">State Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <select class="form-control state_name select2" name="state_name" id="state_name" required >
												    <option value=''>Select State</option>
                                                    <?php if(isset($state_list)){
                                                        foreach($state_list as $row){
                                                           if(isset($pincode_details)){
                                                            if($row->id == $pincode_details[0]->state_id){
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
                                        </div>
                                    </div>
									<div class="form-group" style="display:flex; border-top:1px solid #eee;" >
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Pincode <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control pincode" id="pincode" name="pincode" placeholder="Pincode" value="<?php if(isset($pincode_details)){ echo $pincode_details[0]->pincode; } ?>" required/>
                                            </div>
										</div>
										
										
                                    </div>
                                    
                      
                                
                              
                            </div>
						</div>
						</div>
						<br clear="all"/>
                    </div>
						   <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/pincode_master"class="btn btn-danger"  >Cancel</a>
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
			
             
               
				   
				         <div class="heading-h2 responsive-heading"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/pincode_master'; ?>" > Pincode List </a>  &nbsp; &#10095; &nbsp; Pincode Master </div>
                       <div class="pull-right btn-top-margin margin-responsive">
					   	 <a href="<?php echo base_url(); ?>index.php/pincode_master" class=""><span class="btn btn-danger  "> Cancel </span>  </a>
                                     <?php
                                 // if(isset($access)) { if($access[0]->r_edit == 1) {  ?>
                                    <a href="<?php echo base_url(); ?>index.php/pincode_master/pincode_edit/<?php echo $pincode_details[0]->id;?>" class=""><span class="btn btn-success "> Edit </span>  </a>
                                <?php ?>
									
                             
                                </div>
				   
				   

				  
                <div class="page-content-wrap">
				    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">		
                <form id="form_pincode_details" method="post" action="<?php echo base_url()?>index.php/Tax_master/insertUpdateRecord">
               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
    						
    					 
    						<div class="panel-body">
							
							
							
    								<div class="form-group"  style="display:flex; border-top:1px solid #eee;" >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Pincode :</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12  input-padding" >
                                              	<?php echo $pincode_details[0]->pincode;?>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">State Name :</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12 input-padding">
                                                <?php echo $pincode_details[0]->state_name;?>
                                            </div>
										</div>
									 
                                    </div>
                            </div>
    					</div>
                        </div>
							<br clear="all"/>
                    </div> 
								 <div class="panel-footer">
								     <a href="<?php echo base_url(); ?>index.php/pincode_master/delete_record/<?php if(isset($pincode_details)){ echo $pincode_details[0]->id; }  ?>" class="btn btn-danger" ><span  > Delete </span>  </a>
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
        
        <!-- END SCRIPTS -->
    </body>
</html>