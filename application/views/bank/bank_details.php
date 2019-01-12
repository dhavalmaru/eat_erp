<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Portfolio Management</title>            
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
		.panel-group .panel+.panel { margin-top:0;}
		</style>
    </head>
    <body>								
           <!-- START PAGE CONTAINER -->
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Bank'; ?>" > Bank List </a>  &nbsp; &#10095; &nbsp; Bank Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">	
							
                            <form id="form_bank" role="form" class="form-horizontal" method="post" action="<?php if(isset($data)) { echo base_url().'index.php/bank/update/'.$data[0]->id; } else {echo base_url().'index.php/bank/save'; }?>">
                                <div class="box-shadow-inside">
								
                                <div class="col-md-12 custom-padding" style="padding:0;" >
								 <div id="form_errors" style="display:none; color:#E04B4A;" class="error"></div>
                                 <div class="panel panel-default">
							     	<div class="panel-body">
                               
								 
										<div class="form-group"  >
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Name <span class="asterisk_sign">*</span></label>
												 <div class="col-md-4 col-sm-4 col-xs-12">
														<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="<?php if(isset($data)) {echo $data[0]->b_name; } ?>" />
													</div>
											</div>
										</div>
										<div class="form-group"  >
											<div class="col-md-12 col-sm-12 col-xs-12">
												      <label class="col-md-2 col-sm-2 col-xs-12 control-label">Reg Address</label>
												     <div class="col-md-4 col-sm-4 col-xs-12">
														<input type="text" class="form-control" name="registered_address" placeholder="Registered Address" value="<?php if(isset($data)) {echo $data[0]->registered_address; } ?>" />
													</div>
											</div>
										</div>
										
									 
										<div class="form-group"  >
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">Reg Phone</label>
											    <div class="col-md-4 col-sm-4 col-xs-12">
														<input type="text" class="form-control" name="registered_phone" placeholder="Registered Phone" value="<?php if(isset($data)) {echo $data[0]->registered_phone; } ?>" />
													</div>
											</div>
										</div>
										<div class="form-group"  >
											<div class="col-md-12 col-sm-12 col-xs-12">		
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Reg Email</label>
													   <div class="col-md-4 col-sm-4 col-xs-12">
														<input type="text" class="form-control" name="registered_email" placeholder="Registered Email" value="<?php if(isset($data)) {echo $data[0]->registered_email; } ?>" />
													</div>
											 
											</div>
										</div>
									
									<div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                      <div class="col-md-12 col-sm-12 col-xs-12">
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
									
									<div class="panel-body panel-group">
                                    <div class="panel  panel-primary" id="panel-bank-details">
									 
											<div class="panel-heading">
		                                       	<h4 class="panel-title">
		                                           <span class="fa fa-check-square-o"> </span>  Bank Details
		                                        </h4>
		                                    </div>   
	                                   

										<div class="panel-body panel-body-open text1"  style="width:100%; ">
                                            <div class="form-group" >
											  <div class="col-md-12 col-sm-12 col-xs-12">
													   <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Branch <span class="asterisk_sign">*</span></label>
													   <div class="col-md-4 col-sm-4 col-xs-12">
															<input type="text" class="form-control" name="bank_branch" placeholder="Bank Branch" value="<?php if(isset($data)) {echo $data[0]->b_branch; } ?>" />
														</div>
												 
												</div>
											</div>

											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
												 <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Address <span class="asterisk_sign">*</span></label>
														<div class="col-md-4 col-sm-4 col-xs-12">  
															<input type="text" class="form-control" name="bank_address" placeholder="Bank Address" value="<?php if(isset($data)) {echo $data[0]->b_address; } ?>" />
														</div>										  
												</div>										  
											</div>	
											<div class="form-group"  >
												<div class="col-md-12 col-sm-12 col-xs-12">											
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Landmark</label>
														<div class="col-md-4 col-sm-4 col-xs-12">     
															<input type="text" class="form-control" name="bank_landmark" placeholder="Bank Landmark" value="<?php if(isset($data)) {echo $data[0]->b_landmark; } ?>" />
														</div>
												</div>
											</div>
											 

											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank City</label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="hidden" name="bank_city_id" id="bank_add_city_id" />
                                                    		<input type="text" class="form-control autocompleteCity" name="bank_city" id ="bank_add_city" placeholder="Bank City" value="<?php if(isset($data)) { echo  $data[0]->b_city; } ?>"/>
														</div>
												</div>
											</div>
											<div class="form-group"  >
												<div class="col-md-12 col-sm-12 col-xs-12">
												
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Pincode</label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
                                                    		<input type="text" class="form-control" name="bank_pincode" id ="bank_add_pincode" placeholder="Bank Pincode" value="<?php if(isset($data)) { echo  $data[0]->b_pincode; } ?>"/>
														</div>
												</div>
											</div>
										

											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank State</label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="hidden" name="bank_state_id" id="bank_add_state_id" />
                                                    		<input type="text" class="form-control loadstatedropdown" name="bank_state" id ="bank_add_state" placeholder="Bank State" value="<?php if(isset($data)) { echo  $data[0]->b_state; } ?>"/>
														</div>
												</div>
											</div>
											<div class="form-group"  >
												<div class="col-md-12 col-sm-12 col-xs-12">
												 
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Country</label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
                                                    		<input type="hidden" name="bank_country_id" id="bank_add_country_id" />
                                                    		<input type="text" class="form-control loadcountrydropdown" name="bank_country" id ="bank_add_country" placeholder="Bank Country" value="<?php if(isset($data)) { echo  $data[0]->b_country; } ?>"/>
														</div>
												</div>
												 
											</div>

											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
												 <label class="col-md-2 col-sm-2 col-xs-12 control-label">Account Type <span class="asterisk_sign">*</span></label>
													<div class="col-md-4 col-sm-4 col-xs-12"> 
													  <select class="form-control" name="account_type">
															<option value="">Select</option>
															<option value="Savings" <?php if(isset($data)) { if($data[0]->b_accounttype == 'Savings') echo 'selected'; } ?>>Savings</option>
															<option value="Current" <?php if(isset($data)) { if($data[0]->b_accounttype == 'Current') echo 'selected'; } ?>>Current</option>
															<option value="Overdraft" <?php if(isset($data)) { if($data[0]->b_accounttype == 'Overdraft') echo 'selected'; } ?>>Overdraft</option>
														</select>
														</div>
												</div>
											</div>
											<div class="form-group"  >
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Account No. <span class="asterisk_sign">*</span></label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="text" class="form-control" name="account_no" placeholder="Account No" value="<?php if(isset($data)) {echo $data[0]->b_accountnumber; } ?>" />
														</div>
												</div>
												 
											</div>

											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">IFSC Code <span class="asterisk_sign">*</span></label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="text" class="form-control" name="ifsc" placeholder="IFSC Code" value="<?php if(isset($data)) {echo $data[0]->b_ifsc; } ?>" />
														</div>
												</div>
											</div>
											<div class="form-group"  >
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Customer ID <span class="asterisk_sign">*</span></label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="text" class="form-control" name="customer_id" placeholder="Customer ID" value="<?php if(isset($data)) {echo $data[0]->b_customerid; } ?>" />
														</div>
												</div>												 
											</div>
										
									     	<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
														<label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Phone Number</label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="text" class="form-control" name="phone_no" placeholder="Bank Phone no" value="<?php if(isset($data)) {echo $data[0]->b_phone_number; } ?>" />
														</div>
												</div>
											</div>
											<div class="form-group"  >
												<div class="col-md-12 col-sm-12 col-xs-12">
														<label class="col-md-2 col-sm-2 col-xs-12 control-label">Relationship Manager</label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="text" id="relation_manager" name="relation_manager" class="form-control auto_client" value="<?php if(isset($data)) {echo $data[0]->b_relationshipmanager; } ?>" placeholder="Relationship Manager" />
														</div>
											
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Opening Balance (In Rs) <span class="asterisk_sign">*</span></label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="text" class="form-control format_number" name="opening_balance" placeholder="Opening Balance" value="<?php if(isset($data)) {echo format_money($data[0]->b_openingbalance,2); } ?>" />
														</div>
												</div>
											</div>
											<div class="form-group"  >
												<div class="col-md-12 col-sm-12 col-xs-12">
												
													<label class="col-md-2 col-sm-2 col-xs-12 control-label">Balance Ref Date <span class="asterisk_sign">*</span></label>
														<div class="col-md-4 col-sm-4 col-xs-12"> 
															<input type="text" class="form-control datepicker1" name="b_bal_ref_date" id="payment_date" placeholder="Balance Ref Date" value="<?php if (isset($data)) {if($data[0]->b_bal_ref_date!='') echo date("d/m/Y",strtotime($data[0]->b_bal_ref_date));}?>" placeholder=""/>
														</div>
												
												</div>
											</div>

							 
										</div>
									</div>
										
									<div class="panel panel-primary" id="panel-authorised_signatory">
									 
											<div class="panel-heading">
		                                        <h4 class="panel-title">
		                                        <span class="fa fa-check-square-o"> </span>    Authorised Signatory
		                                        </h4>
		                                    </div>  
		                            

                                		<div class="panel-body"  >
										
										<div class="h-scroll">	
                                       <div class="table-bordered" style="margin:15px;" >
											<div class="banksign">
												<?php $j=0;
												if(isset($bank_sign)) {
													for ($j=0; $j < count($bank_sign) ; $j++) { 
												?>

												<div class="form-group" style="border-top:0;" id="repeat-bank-sign_<?php echo $j+1; ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
													<div class="col-md-1 col-sm-1 text-center"  >
														<label class="col-md-12 control-label"><?php echo $j+1 ?> <span class="asterisk_sign">*</span></label>
													</div>
													<div class="col-md-4 col-sm-4">
                                                        <input type="text" id="auth_name_<?php echo $j+1; ?>" name="auth_name[]" class="form-control auto_client auth_name" value="<?php if(isset($bank_sign[$j]->ath_name)){ echo $bank_sign[$j]->ath_name; } else { echo ''; }?>" placeholder="Name" />
                                                    </div>
													<div class="col-md-4 col-sm-4">
														<input type="text"  class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="<?php if(isset($bank_sign)) { echo $bank_sign[$j]->ath_purpose;  } ?>" />
													</div>
			                                        <div class="col-md-3 col-sm-3">
														<select class="form-control" name="auth_type[]" id="auth_type_<?php echo $j+1; ?>">
															<option value="">Select</option>
									                        <option <?php if(isset($bank_sign)) { if($bank_sign[$j]->ath_type=='Sole') echo 'selected';  } ?>>Sole</option>
									                        <option <?php if(isset($bank_sign)) { if($bank_sign[$j]->ath_type=='Joint') echo 'selected';  } ?>>Joint</option>
								                    	</select>
													</div>
												</div>
												<?php  }} else { ?>
												<div class="form-group" style="border-top:0;" id="repeat-bank-sign_<?php echo $j+1; ?>" style="border-top: 1px dotted #ddd;">
													<div class="col-md-1 col-sm-1 text-center" >
														<label class="col-md-12 control-label">1 <span class="asterisk_sign">*</span></label>
													</div>
													<div class="col-md-4 col-sm-4">
                                                        <input type="text" id="auth_name_<?php echo $j+1; ?>" name="auth_name[]" class="form-control auto_client auth_name" value="" placeholder="Name" />
                                                    </div>
													<div class="col-md-4 col-sm-4">
														<input type="text"  class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="" />
													</div>
			                                        <div class="col-md-3 col-sm-3">
													<select class="form-control" name="auth_type[]" id="auth_type_<?php echo $j+1; ?>">
															<option value="">Select</option>
									                        <option>Sole</option>
									                        <option >Joint</option>
								                    	</select>
													</div>
												</div>
												<?php } ?>
											</div>
											 
												<div class="btn-margin" style="display:flex;">
												 
															<div class="col-md-12">  
																<button class="btn btn-success repeat-bank-sign"  name="addhufbtn">+</button>
                                            					<button type="button" class="btn btn-success reverse-bank-sign" style="margin-left: 10px;">-</button>
														 
															</div>
													 
												</div>
										</div>
										</div>
										</div>
									</div>
								 	<div class="panel panel-primary" id="nominee-section" style="display:block;">
                                      
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Remark </h4>
                                            </div>
                                                          
                                        <div class="panel-body" >
                                            <div class="form-group" style="    display: inline-flex;     width: 100%;" >
                                                <div class="col-md-12 col-sm-12 col-xs-12  " style="    padding-left:10px;">
                                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <textarea  class="form-control" id="remarks" name="remarks" rows="2" ><?php if(isset($data)){ echo $data[0]->remarks;}?></textarea>
                                                        <!-- <label style="margin-top: 5px;">Remark </label> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

									</div>
								</div>
                         	</div>
								<br clear="all"/>
							 </div>
						
                    </div>
								<div class="panel-footer  ">
								 
									<a href="<?php echo base_url(); ?>index.php/bank" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
								 
                            </form>
					
                    
                    </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
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
		 	jQuery(function(){
			 	var counter = <?php if(isset($bank_sign)) { echo count($bank_sign); } else { echo 1; } ?>;
			    $('.repeat-bank-sign').click(function(event){
			        event.preventDefault();
			        counter++;
			        var newRow = jQuery('<div class="form-group" id="repeat-bank-sign_'+counter+'" style="'+((counter==1)?'border-top: 1px dotted #ddd;':'')+'"><div class="col-md-1 col-sm-1 text-center"  ><label class="col-md-12 control-label">'+counter+' <span class="asterisk_sign">*</span></label></div><div class="col-md-4 col-sm-4"><input type="text" id="auth_name_'+counter+'" name="auth_name[]" class="form-control auth_name" placeholder="Name" /></div><div class="col-md-4 col-sm-4"><input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" /></div><div class="col-md-3 col-sm-3"><select class="form-control" name="auth_type[]" id="auth_type_'+counter+'"><option value="">Select</option><option>Sole</option><option>Joint</option></select></div></div>');
			        $('.banksign').append(newRow);
			    });
				$('.reverse-bank-sign').click(function(event){
					if(counter!=1){
		                var id="#repeat-bank-sign_"+(counter).toString();
		                if($(id).length>0){
		                    $(id).remove();
		                    counter--;
		                }
					}
	            });
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				addMultiInputNamingRules('#form_bank', 'input[name="auth_name[]"]', { required: true }, "");
    			addMultiInputNamingRules('#form_bank', 'select[name="auth_type[]"]', { required: true }, "");
			});
		</script>
		<script type="text/javascript">
            $(function() {
              $(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',
        changeYear: true });
            });
        </script>
	</body>
</html>