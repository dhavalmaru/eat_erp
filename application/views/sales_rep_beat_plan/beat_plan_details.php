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
			th{text-align:center;}
			.center{text-align:center;}
            input[readonly] {background-color: white !important; 
                            color: #0b385f !important; 
                            cursor: not-allowed !important;}
							
			 @media screen and (max-width:806px) {   
			   .h-scroll { overflow-x:scroll;} .h-scroll .table-stripped{ width:805px!important;}
			  }
		</style>
		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
            <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Sales_rep_beat_plan'; ?>" >Super Stockist Sale List </a>  &nbsp; &#10095; &nbsp; Super Stockist Sale Details</div>
            
            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">
                <div class="row main-wrapper">
				    <div class="main-container">           
                     <div class="box-shadow">		
                        <form id="form_sr_beat_plan_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/Sales_rep_beat_plan/update/' . $data[0]->id; else echo base_url().'index.php/Sales_rep_beat_plan/save'; ?>">
                         <div class="box-shadow-inside">
                           <div class="col-md-12 custom-padding" style="padding:0;" >
                             <div class="panel panel-default">								
						     	<div class="panel-body">
							    <div class="form-group" >
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Retailer Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="distributor_id" id="distributor_id" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if(isset($data)) { if($distributor[$k]->id==$data[0]->distributor_id) { echo 'selected'; } } ?>><?php echo $distributor[$k]->store_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                         
                                            <!-- <input type="hidden" name="distributor_id" id="distributor_id" value="<?php //if(isset($data)) { echo $data[0]->distributor_id; } ?>"/>
                                            <input type="text" class="form-control load_distributor" name="distributor" id="distributor" placeholder="Type To Select Distributor...." value="<?php //if(isset($data)) { echo $data[0]->distributor_name; } ?>"/> -->
                                        </div>
									</div>
								</div>
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="sales_rep_id" id="sales_rep_id" class="form-control">
                                                <option value="">Select</option>
                                                <?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
                                                        <option value="<?php echo $sales_rep[$k]->id; ?>" <?php if(isset($data)) { if($sales_rep[$k]->id==$data[0]->sales_rep_id) { echo 'selected'; } } ?>><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Frequency <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
												<select name="frequency" id="frequency" class="form-control">
												
													<option value="">Select</option>
													<option value="Every Monday"  <?php if(isset($data)) {if ($data[0]->frequency=='Every Monday') echo 'selected';}?>>Every Monday</option>
													<option value="Every Tuesday" <?php if(isset($data)) {if ($data[0]->frequency=='Every Tuesday') echo 'selected';}?>>Every Tuesday</option>
													<option value="Every Wednesday" <?php if(isset($data)) {if ($data[0]->frequency=='Every Wednesday') echo 'selected';}?>>Every Wednesday</option>
													<option value="Every Thursday" <?php if(isset($data)) {if ($data[0]->frequency=='Every Thursday') echo 'selected';}?>>Every Thursday</option>
													<option value="Every Friday" <?php if(isset($data)) {if ($data[0]->frequency=='Every Friday') echo 'selected';}?>>Every Friday</option>
													<option value="Every Saturday" <?php if(isset($data)) {if ($data[0]->frequency=='Every Saturday') echo 'selected';}?>>Every Saturday</option>
													<option value="Alternate Monday" <?php if(isset($data)) {if ($data[0]->frequency=='Alternate Monday') echo 'selected';}?>>Alternate Monday</option>
													<option value="Alternate Tuesday" <?php if(isset($data)) {if ($data[0]->frequency=='Alternate Tuesday') echo 'selected';}?>>Alternate Tuesday</option>
													<option value="Alternate Wednesday" <?php if(isset($data)) {if ($data[0]->frequency=='Alternate Wednesday') echo 'selected';}?>>Alternate Wednesday</option>
													<option value="Alternate Thursday" <?php if(isset($data)) {if ($data[0]->frequency=='Alternate Thursday') echo 'selected';}?>>Alternate Thursday</option>
													<option value="Alternate Friday" <?php if(isset($data)) {if ($data[0]->frequency=='Alternate Friday') echo 'selected';}?>>Alternate Friday</option>
													<option value="Alternate Saturday" <?php if(isset($data)) {if ($data[0]->frequency=='Alternate Saturday') echo 'selected';}?>>Alternate Saturday</option>
													
												</select>
											</div>
                                       
                                    </div>
                                </div>
								
								
										<div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sequence<span class="asterisk_sign">*</span></label>
										
												<div class="col-md-4 col-sm-4 col-xs-12">
                                             	
													<input type="text" class="form-control" name="sequence" id="sequence" value="<?php if(isset($data)) echo $data[0]->sequence;?>"/>
												</div>
													

                                        </div>
                                </div>

                            
                             
                             
                               
                            </div>
                            </div>
							<br clear="all"/>
						</div>
						</div>
                            <div class="panel-footer">
								<a href="<?php echo base_url(); ?>index.php/distributor_sale" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
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
        </div>


        <!-- Modal -->
   


        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    
    <!-- END SCRIPTS -->      
    </body>
</html>