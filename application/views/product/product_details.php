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
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2">
				   <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Product'; ?>" > Product List </a>  &nbsp; &#10095; &nbsp; Product Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">
                
                    <div class="row main-wrapper">
					<div class="main-container">           
                         <div class="box-shadow"> 
							
                            <form id="form_product_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/Product/update/' . $data[0]->id; else echo base_url().'index.php/product/save'; ?>">	
							<div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">							
								
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Product Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?php if(isset($data)) echo $data[0]->product_name;?>"/>
                                            </div>
                                             <label class="col-md-2 col-sm-2 col-xs-12 control-label">Barcode</label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="barcode" placeholder="Barcode" value="<?php if(isset($data)) echo $data[0]->barcode;?>"/>
                                            </div>
										</div>
									</div>
                                    <div class="form-group" >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">HSN Code <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="hsn_code" id="hsn_code" placeholder="HSN Code" value="<?php if(isset($data)) { echo  $data[0]->hsn_code; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">HSN Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="hsn_name" id="hsn_name" placeholder="HSN Name" value="<?php if(isset($data)) { echo $data[0]->hsn_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Disclosed Grams <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="grams" placeholder="Disclosed Grams" value="<?php if (isset($data)) { echo $data[0]->grams; } ?>"/>
                                            </div>
                                             <label class="col-md-2 col-sm-2 col-xs-12 control-label">Avg Grams In Bar <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="avg_grams" placeholder="Avg Grams In Bar" value="<?php if (isset($data)) { echo $data[0]->avg_grams; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Rate (In Rs) <span class="asterisk_sign">*</span></label>
                                              <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="rate" placeholder="Rate" value="<?php if (isset($data)) { echo $data[0]->rate; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Anticipated Wastage (In %)<span class="asterisk_sign">*</span></label>
                                              <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="anticipated_wastage" placeholder="Anticipated Wastage" value="<?php if (isset($data)) { echo $data[0]->anticipated_wastage; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Cost (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="cost" placeholder="Cost" value="<?php if (isset($data)) { echo $data[0]->cost; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Short Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                               <input type="text" class="form-control" name="short_name" placeholder="Short Name" value="<?php if (isset($data)) { echo $data[0]->short_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
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
									<a href="<?php echo base_url(); ?>index.php/product" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
							</form>
							
						</div>
						</div>
						
					 </div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
           
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

    <!-- END SCRIPTS -->      
    </body>
</html>