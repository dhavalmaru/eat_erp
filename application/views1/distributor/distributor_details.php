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
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/distributor'; ?>" > Distributor List </a>  &nbsp; &#10095; &nbsp; Distributor Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">							
                            <form id="form_distributor_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) {if(strrpos($data[0]->d_id, 'd_') !== false) echo base_url(). 'index.php/distributor/update/' . $data[0]->id; else echo base_url(). 'index.php/distributor/save';} else echo base_url().'index.php/distributor/save'; ?>">
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							     	<div class="panel-body">
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="d_id" id="d_id" value="<?php if(isset($data)) echo $data[0]->d_id;?>"/>
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) {if(strrpos($data[0]->d_id, "d_") !== false) echo $data[0]->id;}?>"/>
                                                <input type="text" class="form-control" name="distributor_name" id="distributor_name" placeholder="Distributor Name" value="<?php if(isset($data)) echo $data[0]->distributor_name;?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Address</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php if(isset($data)) echo $data[0]->address;?>"/>
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">City</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" name="city_id" id="city_id" />
                                                <input type="text" class="form-control autocompleteCity" name="city" id ="city" placeholder="City" value="<?php if(isset($data)) { echo  $data[0]->city; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Pincode</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="pincode" placeholder="Pincode" value="<?php if (isset($data)) { echo $data[0]->pincode; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">State</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" name="state_id" id="state_id" />
                                                <input type="text" class="form-control loadstatedropdown" name="state" id="state" placeholder="State" value="<?php if(isset($data)) { echo  $data[0]->state; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Country</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" name="country_id" id="country_id">
                                                <input type="text" class="form-control loadcountrydropdown" name="country" id="country" placeholder="Country" value="<?php if(isset($data)) { echo  $data[0]->country; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Google Address</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12">
                                                <input type="text" class="form-control" name="google_address" id="google_address" placeholder="Google Address" value="<?php if(isset($data)) { echo  $data[0]->google_address; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Email Id</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="d_email_id" placeholder="Email Id" value="<?php if (isset($data)) { echo $data[0]->email_id; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mobile <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="d_mobile" placeholder="Mobile" value="<?php if (isset($data)) { echo $data[0]->mobile; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tin Number </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">

                                                <input type="text" class="form-control" name="tin_number" placeholder="Tin Number" value="<?php if (isset($data)) { echo $data[0]->tin_number; } ?>"/>
                                            </div>
 
                                           <label class="col-md-2 col-sm-2 col-xs-12 control-label">Cst Number </label>
                                          <div class="col-md-4 col-sm-4 col-xs-12">
 
                                                <input type="text" class="form-control" name="cst_number" placeholder="Cst Number" value="<?php if (isset($data)) { echo $data[0]->cst_number; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="sales_rep_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
                                                            <option value="<?php echo $sales_rep[$k]->id; ?>" <?php if (isset($data)) { if($sales_rep[$k]->id==$data[0]->sales_rep_id) { echo 'selected'; } } ?>><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
 
                                           <label class="col-md-2 col-sm-2 col-xs-12 control-label">Margin On MRP (In %)<span class="asterisk_sign">*</span></label>
                                           <div class="col-md-4 col-sm-4 col-xs-12">
 
                                                <input type="text" class="form-control" name="sell_out" placeholder="Margin On MRP" value="<?php if (isset($data)) { echo $data[0]->sell_out; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-md-12">
                                            <!-- <label class="col-md-2 control-label">Contact Person <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="<?php //if (isset($data)) { echo $data[0]->contact_person; } ?>"/>
                                            </div> -->
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Generate Invoice <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4  col-sm-4 col-xs-12 option-line-height">
                                                <input type="radio" name="send_invoice" class="icheckbox" value="1" id="send_invoice_yes" data-error="#err_send_invoice" <?php if (isset($data)) { if($data[0]->send_invoice=='1') echo 'checked'; } ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="send_invoice" class="icheckbox" value="0" id="send_invoice_no" data-error="#err_send_invoice" <?php if (isset($data)) { if($data[0]->send_invoice=='0') echo 'checked'; } ?>/>&nbsp;&nbsp;No
                                                <div id="err_send_invoice"></div>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Credit Period (In Days) <span class="asterisk_sign">*</span></label>
                                             <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="credit_period" placeholder="Credit Period In Days" value="<?php if (isset($data)) { echo $data[0]->credit_period; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 control-label">Class <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="class">
                                                    <option value="">Select</option>
                                                    <option value="normal" <?php if(isset($data)) {if ($data[0]->class=='normal') echo 'selected';}?>>Normal</option>
                                                    <option value="super stockist" <?php if(isset($data)) {if ($data[0]->class=='super stockist') echo 'selected';}?>>Super stockist</option>
                                                    <option value="sample" <?php if(isset($data)) {if ($data[0]->class=='sample') echo 'selected';}?>>Sample</option>
                                                </select>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="area_id" class="form-control">
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
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="type_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($type)) { for ($k=0; $k < count($type) ; $k++) { ?>
                                                            <option value="<?php echo $type[$k]->id; ?>" <?php if (isset($data)) { if($type[$k]->id==$data[0]->type_id) { echo 'selected'; } } ?>><?php echo $type[$k]->distributor_type; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="zone_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                            <option value="<?php echo $zone[$k]->id; ?>" <?php if (isset($data)) { if($zone[$k]->id==$data[0]->zone_id) { echo 'selected'; } } ?>><?php echo $zone[$k]->zone; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Document</label>
                                            <div class="col-md-2 col-sm-2 col-xs-12" >
                                                <input type="hidden" class="form-control" name="doc_document" value="<?php if(isset($data)) echo $data[0]->doc_document; ?>" />
                                                <input type="hidden" class="form-control" name="document_name" value="<?php if(isset($data)) echo $data[0]->document_name; ?>" />
                                                <!-- <input type="file" class="fileinput btn btn-info btn-small doc_file" name="doc_file" id="doc_file" data-error="#doc_file_error"/> -->
                                                <input type="file" accept="image/*;capture=camera" class="fileinput btn btn-info btn-small doc_file" name="doc_file" id="doc_file" data-error="#doc_file_error"/>
                                                <div id="doc_file_error"></div>
                                            </div>          
                                            <div class="col-md-1 col-sm-1 col-xs-12 download-width" >
                                                <?php if(isset($data)) { if($data[0]->doc_document!= '') { ?><a target="_blank" id="doc_file_download" href="<?php if(isset($data)) echo base_url().$data[0]->doc_document; ?>"><span class="fa download fa-download" ></span></a></a><?php }} ?>
                                            </div>
                                        </div>
                                    </div>

                               			<div class="h-scroll">	
                                       <div class="table-stripped form-group" style="padding:15px;" >
									
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 500px">Contact Person <span class="asterisk_sign">*</span></th>
                                                <th style="width: 300px ">Email Id </th>
                                                <th style="width: 300px ">Mobile <span class="asterisk_sign">*</span></th>
                                                <th style="width: 75px; text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($distributor_contacts)) {
                                                for($i=0; $i<count($distributor_contacts); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="text" class="form-control contact_person" name="contact_person[]" id="contact_person_<?php echo $i; ?>" placeholder="Contact Person" value="<?php if (isset($distributor_contacts)) { echo $distributor_contacts[$i]->contact_person; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control email_id" name="email_id[]" id="email_id_<?php echo $i; ?>" placeholder="Email Id" value="<?php if (isset($distributor_contacts)) { echo $distributor_contacts[$i]->email_id; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control mobile" name="mobile[]" id="mobile_<?php echo $i; ?>" placeholder="Mobile" value="<?php if (isset($distributor_contacts)) { echo $distributor_contacts[$i]->mobile; } ?>"/>
                                                </td>
                                                <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="text" class="form-control contact_person" name="contact_person[]" id="contact_person_<?php echo $i; ?>" placeholder="Contact Person" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control email_id" name="email_id[]" id="email_id_<?php echo $i; ?>" placeholder="Email Id" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control mobile" name="mobile[]" id="mobile_<?php echo $i; ?>" placeholder="Mobile" value=""/>
                                                </td>
                                                <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8">
                                                    <button type="button" class="btn btn-success" id="repeat-box" style=" ">+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
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
									<a href="<?php echo base_url(); ?>index.php/distributor" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
        <script type="text/javascript">
            $(document).ready(function(){
                $('.delete_row').click(function(event){
                    delete_row($(this));
                });
                
                addMultiInputNamingRules('#form_distributor_details', 'input[name="contact_person[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_details', 'input[name="email_id[]"]', { checkemail: true }, "");
                addMultiInputNamingRules('#form_distributor_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");
            });

            jQuery(function(){
                var counter = $('.contact_person').length;
                $('#repeat-box').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control contact_person" name="contact_person[]" id="contact_person_'+counter+'" placeholder="Contact Person" value=""/>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control email_id" name="email_id[]" id="email_id_'+counter+'" placeholder="Email Id" value=""/>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control mobile" name="mobile[]" id="mobile_'+counter+'" placeholder="Mobile" value=""/>' + 
                                            '</td>' + 
                                            '<td style="text-align:center;     vertical-align: middle;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });

                    removeMultiInputNamingRules('#form_distributor_details', 'input[alt="contact_person[]"]');
                    removeMultiInputNamingRules('#form_distributor_details', 'input[alt="email_id[]"]');
                    removeMultiInputNamingRules('#form_distributor_details', 'input[alt="mobile[]"]');

                    addMultiInputNamingRules('#form_distributor_details', 'input[name="contact_person[]"]', { required: true }, "");
                    addMultiInputNamingRules('#form_distributor_details', 'input[name="email_id[]"]', { checkemail: true }, "");
                    addMultiInputNamingRules('#form_distributor_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");
                    
                    counter++;
                });
            });
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>