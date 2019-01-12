<!DOCTYPE html>
<html lang="en">
    <head>
        <title>EAT ERP</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
    </head>
    <body>
        <div class="page-container page-navigation-top">            
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Depot'; ?>" > Depot List </a>  &nbsp; &#10095; &nbsp; Depot Details</div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
    				<div class="main-container">           
                    <div class="box-shadow"> 							
                    <form id="form_depot_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/depot/update/' . $data[0]->id; else echo base_url().'index.php/depot/save'; ?>">
                        <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
    					    <div class="panel-body">
    							<div class="form-group" >
    								<div class="col-md-12 col-sm-12 col-xs-12">
    									<label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="text" class="form-control" name="depot_name" id="depot_name" placeholder="Depot Name" value="<?php if(isset($data)) echo $data[0]->depot_name;?>"/>
                                        </div>
                                    </div>
                                </div>
    							<div class="form-group">
    								<div class="col-md-12 col-sm-12 col-xs-12">
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
                                    </div>
                                </div>
    							<div class="form-group">
    								<div class="col-md-12 col-sm-12 col-xs-12">
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
                                            <input type="hidden" name="state_code" id="state_code" value="<?php if(isset($data)) { echo  $data[0]->state_code; } ?>" />
                                            <input type="text" class="form-control loadstatedropdown" name="state" id="state" placeholder="State" value="<?php if(isset($data)) { echo  $data[0]->state; } ?>"/>
                                        </div>
                                    </div>
                                </div>
        						<div class="form-group">
        							<div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Country</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" name="country_id" id="country_id">
                                            <input type="text" class="form-control loadcountrydropdown" name="country" id="country" placeholder="Country" value="<?php if(isset($data)) { echo  $data[0]->country; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Email Id</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="d_email_id" placeholder="Email Id" value="<?php if (isset($data)) { echo $data[0]->email_id; } ?>"/>
                                        </div>
                                    </div>
                                </div>
        						<div class="form-group">
        							<div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Mobile <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="d_mobile" placeholder="Mobile" value="<?php if (isset($data)) { echo $data[0]->mobile; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select class="form-control" name="type">
                                                <option value="">Select</option>
                                                <option value="Depot" <?php if(isset($data)) {if ($data[0]->type=='Depot') echo 'selected';}?>>Depot</option>
                                                <option value="Manufacturer" <?php if(isset($data)) {if ($data[0]->type=='Manufacturer') echo 'selected';}?>>Manufacturer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">GST No </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="gst_no" placeholder="GST No" value="<?php if (isset($data)) { echo $data[0]->gst_no; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">FSSAI No </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="fssai_no" placeholder="FSSAI No" value="<?php if (isset($data)) { echo $data[0]->fssai_no; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Account No </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="bank_acc_no" placeholder="Bank Account No" value="<?php if (isset($data)) { echo $data[0]->bank_acc_no; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bank Name </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="bank_name" placeholder="Bank Name" value="<?php if (isset($data)) { echo $data[0]->bank_name; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">IFSC code </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="ifsc_code" placeholder="IFSC code" value="<?php if (isset($data)) { echo $data[0]->ifsc_code; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-scroll"> 
                                    <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 500px">Contact Person <span class="asterisk_sign">*</span></th>
                                                <th style="width: 210px">Email Id</th>
                                                <th style="width: 210px">Mobile <span class="asterisk_sign">*</span></th>
                                                <th style="text-align:center; width:70px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($depot_contacts)) {
                                                for($i=0; $i<count($depot_contacts); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="text" class="form-control contact_person" name="contact_person[]" id="contact_person_<?php echo $i; ?>" placeholder="Contact Person" value="<?php if (isset($depot_contacts)) { echo $depot_contacts[$i]->contact_person; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control email_id" name="email_id[]" id="email_id_<?php echo $i; ?>" placeholder="Email Id" value="<?php if (isset($depot_contacts)) { echo $depot_contacts[$i]->email_id; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control mobile" name="mobile[]" id="mobile_<?php echo $i; ?>" placeholder="Mobile" value="<?php if (isset($depot_contacts)) { echo $depot_contacts[$i]->mobile; } ?>"/>
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
                                        <div class="col-md-10  col-sm-10 col-xs-12">
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
    						<a href="<?php echo base_url(); ?>index.php/depot" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                            <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                        </div>
    				</form>
    				</div>
    				</div>
    				</div>
                </div>
            </div>
        </div>
						
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
                
                addMultiInputNamingRules('#form_depot_details', 'input[name="contact_person[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_depot_details', 'input[name="email_id[]"]', { checkemail: true }, "");
                addMultiInputNamingRules('#form_depot_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");
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
                                            ' <td style="text-align:center;     vertical-align: middle;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    
                    removeMultiInputNamingRules('#form_depot_details', 'input[alt="contact_person[]"]');
                    removeMultiInputNamingRules('#form_depot_details', 'input[alt="email_id[]"]');
                    removeMultiInputNamingRules('#form_depot_details', 'input[alt="mobile[]"]');

                    addMultiInputNamingRules('#form_depot_details', 'input[name="contact_person[]"]', { required: true }, "");
                    addMultiInputNamingRules('#form_depot_details', 'input[name="email_id[]"]', { checkemail: true }, "");
                    addMultiInputNamingRules('#form_depot_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");
                    
                    counter++;
                });
            });
        </script>
    </body>
</html>