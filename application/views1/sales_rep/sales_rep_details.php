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
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sales_rep'; ?>" > Sales Representative  List </a>  &nbsp; &#10095; &nbsp; Sales Representative Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                    <div class="page-content-wrap">
                      <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">	
							
                            <form id="form_sales_rep_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep/update/' . $data[0]->id; else echo base_url().'index.php/sales_rep/save'; ?>">
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">								
								   <div class="panel-body">
									  <div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control" name="sales_rep_name" id="sales_rep_name" placeholder="Sales Representative Name" value="<?php if(isset($data)) echo $data[0]->sales_rep_name;?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Pan No <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="pan_no" id="pan_no" placeholder="Pan No" value="<?php if(isset($data)) echo $data[0]->pan_no;?>"/>
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Email Id</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="email_id" placeholder="Email Id" value="<?php if (isset($data)) { echo $data[0]->email_id; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mobile <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="mobile" placeholder="Mobile" value="<?php if (isset($data)) { echo $data[0]->mobile; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Kyc Done</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12 lineheight">
                                                <input type="radio" name="kyc_done" class="icheckbox" value="1" id="kyc_yes" data-error="#err_kyc" <?php if (isset($data)) { if($data[0]->kyc_done=='1') echo 'checked'; } ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="kyc_done" class="icheckbox" value="0" id="kyc_no" data-error="#err_kyc" <?php if (isset($data)) { if($data[0]->kyc_done=='0') echo 'checked'; } ?>/>&nbsp;&nbsp;No
                                                <div id="err_kyc"></div>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Territory</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="teritory" placeholder="Teritory" value="<?php if (isset($data)) { echo $data[0]->teritory; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Target PM (In Rs) </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="target_pm" placeholder="Target PM" value="<?php if (isset($data)) { echo format_money($data[0]->target_pm,2); } ?>"/>
                                            </div>
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
                                    <div>
                                        <?php $this->load->view('templates/document');?>
                                        
                                        <div class=" btn-margin">
                                            <button type="button" class="btn btn-success" id="repeat-documents" style=" ">+</button>
                                            <!-- <button type="button" class="btn btn-success" id="reverse-documents" style="margin-left: 10px;">-</button> -->
                                        </div>
                                    </div> 
                                </div>
                                  </div>
								<br clear="all"/> 
								 </div>
								 </div>
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/sales_rep" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>

    <!-- END SCRIPTS -->      
    </body>
</html>