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
        <!-- START PAGE CONTAINER -->
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/AccountLedger'; ?>" > Ledger List </a>  &nbsp; &#10095; &nbsp; Ledger Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">							
                            <form id="form_ledger_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) {if($data[0]->id !== false) echo base_url(). 'index.php/AccountLedger/update/' . $data[0]->id; else echo base_url(). 'index.php/AccountLedger/save';} else echo base_url().'index.php/AccountLedger/save'; ?>">
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							     	<div class="panel-body">
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Ledger Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control" name="ledger_name" id="ledger_name" placeholder="Ledger Name" value="<?php if(isset($data)) echo $data[0]->ledger_name;?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"  >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Group</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="fk_group_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($group_acc)) { for ($k=0; $k < count($group_acc) ; $k++) { ?>
                                                            <option value="<?php echo $group_acc[$k]->id; ?>" <?php if (isset($data)) { if($group_acc[$k]->id==$data[0]->fk_group_id) { echo 'selected'; } } ?>><?php echo $group_acc[$k]->group_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
										</div>
									</div>

                                    <div class="form-group" style="">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div>
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Ledger Type <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select class="form-control" name="ledger_type">
                                                        <option value="">Select</option>
                                                        <option value="Purchase Vendor" <?php if(isset($data)) {if ($data[0]->ledger_type=='Purchase Vendor') echo 'selected';}?>>Purchase Vendor</option>
                                                        <option value="Sales Distributor" <?php if(isset($data)) {if ($data[0]->ledger_type=='Sales Distributor') echo 'selected';}?>>Sales Distributor</option>
                                                        <option value="Goods Purchase" <?php if(isset($data)) {if ($data[0]->ledger_type=='Goods Purchase') echo 'selected';}?>>Goods Purchase</option>
                                                        <option value="Goods Sales" <?php if(isset($data)) {if ($data[0]->ledger_type=='Goods Sales') echo 'selected';}?>>Goods Sales</option>
                                                        <option value="Tax" <?php if(isset($data)) {if ($data[0]->ledger_type=='Tax') echo 'selected';}?>>Tax</option>
                                                        <option value="Bank" <?php if(isset($data)) {if ($data[0]->ledger_type=='Bank') echo 'selected';}?>>Bank</option>
                                                        <option value="Employee" <?php if(isset($data)) {if ($data[0]->ledger_type=='Employee') echo 'selected';}?>>Employee</option>
                                                        <option value="Expenses" <?php if(isset($data)) {if ($data[0]->ledger_type=='Expenses') echo 'selected';}?>>Expenses</option>
                                                        <option value="Others" <?php if(isset($data)) {if ($data[0]->ledger_type=='Others') echo 'selected';}?>>Others</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group"  >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Opening Balance <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="opening_balance" id="opening_balance" placeholder="Opening Balance" value="<?php if(isset($data)) echo $data[0]->opening_balance;?>"/>
                                            </div>
                                            <div class="col-md-1 col-sm-1 col-xs-12">
                                                <select name="trans_type" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Credit" <?php if (isset($data)) { if($data[0]->trans_type=='Credit') { echo 'selected'; } } ?>>Credit</option>
                                                    <option value="Debit" <?php if (isset($data)) { if($data[0]->trans_type=='Debit') { echo 'selected'; } } ?>>Debit</option>
                                                </select>
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
                                </div>
									</div>
									<br clear="all"/>
									</div>
								</div>
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/AccountLedger" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
        
    <!-- END SCRIPTS -->      
    </body>
</html>