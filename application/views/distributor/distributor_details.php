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
        <style type="text/css">
        input[readonly], input[disabled], select[disabled], textarea[disabled] {
                background-color:transparent!important;
                color: #0b385f !important; 
                cursor: not-allowed !important;
            }
            
        </style>     
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
                <?php $this->load->view('templates/menus');?>
                <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                    <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/distributor'; ?>" > Distributor List </a>  &nbsp; &#10095; &nbsp; Distributor Details</div>
                
                    <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">							
                            <form id="form_distributor_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) {if(strrpos($data[0]->d_id, 'd_') !== false) echo base_url(). 'index.php/distributor/update/' . $data[0]->id; else echo base_url(). 'index.php/distributor/save';} else echo base_url().'index.php/distributor/save'; ?>">
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							     	<div class="panel-body">
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="d_id" id="d_id" value="<?php if(isset($data)) echo $data[0]->d_id;?>"/>
                                                <input type="hidden" class="form-control" name="master_distributor_id" id="master_distributor_id" value="<?php if(isset($data)) echo $data[0]->master_distributor_id;?>"/>
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) {if(strrpos($data[0]->d_id, "d_") !== false) echo $data[0]->id;}?>"/>
                                                <input type="text" class="form-control" name="distributor_name" id="distributor_name" placeholder="Distributor Name" value="<?php if(isset($data)) echo $data[0]->distributor_name;?>"/>
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
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">State Code</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="state_code" id="state_code" placeholder="State Code" value="<?php if(isset($data)) { echo  $data[0]->state_code; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">GST Number</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="gst_number" id="gst_number" placeholder="Gst Number" value="<?php if(isset($data)) { echo  $data[0]->gst_number; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Google Address</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12">
                                                <input type="text" class="form-control" name="google_address" id="google_address"  onFocus="geolocate()" placeholder="Google Address" value="<?php if(isset($data)) { echo  $data[0]->google_address; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Latitude</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control latitude" id="latitude" name="d_latitude" placeholder="Latitude" value="<?php if (isset($data)) { echo $data[0]->latitude; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Longitude</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control longitude" id="longitude" name="d_longitude" placeholder="Longitude" value="<?php if (isset($data)) { echo $data[0]->longitude; } ?>"/>
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
                                    <div class="form-group" style="display:none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tin Number </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="tin_number" placeholder="Tin Number" value="<?php if (isset($data)) { echo $data[0]->tin_number; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Cst Number </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="cst_number" placeholder="Cst Number" value="<?php if (isset($data)) { echo $data[0]->cst_number; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Discount (In %)<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="sell_out" placeholder="Margin On MRP" value="<?php if (isset($data)) { if($data[0]->sell_out!=null && $data[0]->sell_out!='') echo $data[0]->sell_out; else echo '0'; } else echo '0'; ?>"/>
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
                                        </div>
                                    </div>
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
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
                                                <select class="form-control" name="class" id="classes">
                                                    <option value="">Select</option>
                                                    <option value="normal" <?php if(isset($data)) {if ($data[0]->class=='normal') echo 'selected';}?>>Retailer</option>
                                                    <option value="super stockist" <?php if(isset($data)) {if ($data[0]->class=='super stockist') echo 'selected';}?>>Distributor</option>
                                                    <option value="sample" <?php if(isset($data)) {if ($data[0]->class=='sample') echo 'selected';}?>>Sample</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
								
                                    <div class="form-group" id="type_normal">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12" >
                                                <select name="type_id" id="type_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($type)) { for ($k=0; $k < count($type) ; $k++) { ?>
                                                            <option value="<?php echo $type[$k]->id; ?>" <?php if (isset($data)) { if($type[$k]->id==$data[0]->type_id) { echo 'selected'; } } ?>><?php echo $type[$k]->distributor_type; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="zone_id" id="zone_id" class="form-control select2">
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
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="area_id" id="area_id" class="form-control select2">
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
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Location <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="location_id"  id="location_id"class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                            <option value="<?php echo $location[$k]->id; ?>" <?php if (isset($data)) { if($location[$k]->id==$data[0]->location_id) { echo 'selected'; } } ?>><?php echo $location[$k]->location; ?></option>
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
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                           <label class="col-md-2 col-sm-2 col-xs-12 control-label">Tally Name<span class="asterisk_sign"></span></label>
                                           <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="tally_name" placeholder="Tally Name" value="<?php if (isset($data)) { echo $data[0]->tally_name; } ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="h-scroll">  
                                    <div class="table-stripped form-group" style="padding:15px;" >
                                      <table class="table table-bordered" style="margin-bottom: 0px; ">
                                            <thead>
                                                <tr>
                                                    <th>Category<span class="asterisk_sign">*</span></th>
                                                    <th>Invoice Margin (In %)</th>
                                                    <th>Promotional Margin (In %)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="category_details">
                                                <?php

                                                for ($i=0; $i <count($category_detail) ; $i++) {
                                                   // $margin = '' ;
                                                   // if(isset($margin_detail))
                                                   // {
                                                   //  if(count($margin_detail)>0)
                                                   //  {

                                                   //      if($category_detail[$i]->id==$margin_detail[$i]->category_id)
                                                   //      {
                                                   //          $margin = $margin_detail[$i]->margin;
                                                   //      }
                                                   //  }  
                                                   // }
                                                    
                                                ?>
                                                   <tr>
                                                         <td>
                                                            <input type="text" class="form-control" name="category[]" id="category_<?=$i?>" value="<?=$category_detail[$i]->category_name?>" readonly/>
                                                            <input type="hidden" class="form-control" name="category_id[]" id="category_id_<?=$i?>" value="<?=$category_detail[$i]->id?>" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="inv_margin[]" id="inv_margin_<?=$i?>" placeholder="Invoice Margin"  value="<?php if(isset($category_detail[$i]->inv_margin)) echo $category_detail[$i]->inv_margin; ?>" onkeypress="return StopNonNumeric(this,event)"/>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pro_margin[]" id="pro_margin_<?=$i?>" placeholder="Promotional Margin"  value="<?php if(isset($category_detail[$i]->pro_margin)) echo $category_detail[$i]->pro_margin; ?>" onkeypress="return StopNonNumeric(this,event)"/>
                                                        </td>
                                                   </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
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

                                    <div class="h-scroll">  
                                    <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th style="width: 500px">Name <!-- <span class="asterisk_sign">*</span> --></th>
                                                <th style="width: 300px ">Address </th>
                                                <th style="width: 300px ">City </th>
                                                <th style="width: 300px ">Pincode </th>
                                                <th style="width: 300px ">State </th>
                                                <th style="width: 300px ">Country </th>
                                                <th style="width: 300px ">State Code </th>
                                                <th style="width: 300px ">GST Number </th>
                                                <!-- <th style="width: 75px; text-align:center;">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody id="consignee_details">
                                        <?php $i=0; if(isset($distributor_consignee)) {
                                                for($i=0; $i<count($distributor_consignee); $i++) { ?>
                                            <tr id="consignee_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="hidden" class="form-control con_name" name="con_id[]" placeholder="Consignee Name" 
                                                    value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->id; } ?>"/>

                                                    <input type="text" class="form-control con_name" name="con_name[]" id="con_name_<?php echo $i; ?>" placeholder="Consignee Name" value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->con_name; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control con_address" name="con_address[]" id="con_address_<?php echo $i; ?>" placeholder="Consignee Address" value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->con_address; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="con_city_id[]" id="con_city_<?php echo $i; ?>_id" />
                                                    <input type="text" class="form-control con_city autocompleteCity" name="con_city[]" id="con_city_<?php echo $i; ?>" placeholder="Consignee City" value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->con_city; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control con_pincode" name="con_pincode[]" id="con_pincode_<?php echo $i; ?>" placeholder="Consignee Pincode" value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->con_pincode; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="con_state_id[]" id="con_state_<?php echo $i; ?>_id" />
                                                    <input type="text" class="form-control con_state loadstatedropdown" name="con_state[]" id="con_state_<?php echo $i; ?>" placeholder="Consignee State" value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->con_state; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="con_country_id[]" id="con_country_<?php echo $i; ?>_id" />
                                                    <input type="text" class="form-control con_country loadcountrydropdown" name="con_country[]" id="con_country_<?php echo $i; ?>" placeholder="Consignee Country" value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->con_country; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control con_state_code" name="con_state_code[]" id="con_state_code_<?php echo $i; ?>" placeholder="Consignee State Code" value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->con_state_code; } ?>"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control con_gst_number" name="con_gst_number[]" id="con_gst_number_<?php echo $i; ?>" placeholder="Consignee Gst Number" value="<?php if (isset($distributor_consignee)) { echo $distributor_consignee[$i]->con_gst_number; } ?>"/>
                                                </td>
                                                <!-- <td style="text-align:center; vertical-align: middle;">
                                                    <a id="consignee_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o" ></span></a>
                                                </td> -->
                                            </tr>
                                        <?php }} else { ?>
                                            <tr id="consignee_<?php echo $i; ?>_row">
                                                <td>
                                                    <input type="text" class="form-control con_name" name="con_name[]" id="con_name_<?php echo $i; ?>" placeholder="Consignee Name" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control con_address" name="con_address[]" id="con_address_<?php echo $i; ?>" placeholder="Consignee Address" value=""/>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="con_city_id[]" id="con_city_<?php echo $i; ?>_id" />
                                                    <input type="text" class="form-control con_city autocompleteCity" name="con_city[]" id="con_city_<?php echo $i; ?>" placeholder="Consignee City" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control con_pincode" name="con_pincode[]" id="con_pincode_<?php echo $i; ?>" placeholder="Consignee Pincode" value=""/>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="con_state_id[]" id="con_state_<?php echo $i; ?>_id" />
                                                    <input type="text" class="form-control con_state loadstatedropdown" name="con_state[]" id="con_state_<?php echo $i; ?>" placeholder="Consignee State" value=""/>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="con_country_id[]" id="con_country_<?php echo $i; ?>_id" />
                                                    <input type="text" class="form-control con_country loadcountrydropdown" name="con_country[]" id="con_country_<?php echo $i; ?>" placeholder="Consignee Country" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control con_state_code" name="con_state_code[]" id="con_state_code_<?php echo $i; ?>" placeholder="Consignee State Code" value=""/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control con_gst_number" name="con_gst_number[]" id="con_gst_number_<?php echo $i; ?>" placeholder="Consignee Gst Number" value=""/>
                                                </td>
                                                <td style="text-align:center; vertical-align: middle;">
                                                    <a id="consignee_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o" ></span></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9">
                                                    <button type="button" class="btn btn-success" id="repeat-consignee" style=" ">+</button>
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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&libraries=places&callback=initAutocomplete" async defer></script>
		<script type='text/javascript'>


 
    // City change
    $('#type_id').change(function(){
      var type_id = $(this).val();
		//console.log(reporting_manager_id);
      // AJAX request
      $.ajax({
        url:'<?=base_url()?>index.php/distributor/get_zone',
        method: 'post',
        data: {type_id: type_id},
        dataType: 'json',
        success: function(response){

 
          $('#zone_id').find('option').not(':first').remove();
      

          // Add options
		  // response = $.parseJSON(response);
		  console.log(response);
          $.each(response,function(index,data){
             $('#zone_id').append('<option value="'+data['id']+'">'+data['zone']+'</option>');
        
          });
        }
     });
   });
       // City change
    $('#zone_id').change(function(){
      var zone_id = $(this).val();
		//console.log(reporting_manager_id);
      // AJAX request
      $.ajax({
        url:'<?=base_url()?>index.php/distributor/get_area',
        method: 'post',
        data: {zone_id: zone_id},
        dataType: 'json',
        success: function(response){

 
          $('#area_id').find('option').not(':first').remove();
      

          // Add options
		  // response = $.parseJSON(response);
		  console.log(response);
          $.each(response,function(index,data){
             $('#area_id').append('<option value="'+data['id']+'">'+data['area']+'</option>');
        
          });
        }
     });
   });
   
   
 
   </script>	
        <script type="text/javascript">
		
            var placeSearch, autocomplete;
           var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name'
           };
        function initAutocomplete() {
                  // Create the autocomplete object, restricting the search to geographical
                  // location types.
                  autocomplete = new google.maps.places.Autocomplete(
                     (document.getElementById('google_address')),
                     {types: ['geocode']});
                   google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    //document.getElementById('google_address').value = place.name;
                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();
                    //alert("This function is working!");
                    //alert(place.name);
                   // alert(place.address_components[0].long_name);

                });
                  // When the user selects an address from the dropdown, populate the address
                  // fields in the form.
                  //autocomplete.addListener('place_changed', fillInAddress);
           }

                
                function geolocate() {
                  if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                      var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                      };
                      var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                      });
                      autocomplete.setBounds(circle.getBounds());
                       
                    });
                    
                  }
                }
        </script>
		
	<script>
		// $(document).ready(function(){
		// $("#type_sample").hide();
		// $('#classes').on('change', function() {

		// if ( this.value == 'normal')

		// {

			// $("#type_normal").show();
			// $("#type_sample").hide();

		// }
		// else
		// {
			// $("#type_normal").hide();
			// $("#type_sample").show();
		// }
		// });
		// });
	</script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('.delete_row').click(function(event){
                    delete_row($(this));
                });

                $('.con_city').each(function(){
                    var id = $(this).attr('id');
                    var index = id.substr(id.lastIndexOf('_')+1);
                    var item = $("#consignee_"+index+"_row");

                    $('.autocompleteCity', item).autocomplete(autocomp_opt_city);
                    $('.loadstatedropdown', item).autocomplete(autocomp_opt_state);
                    $('.loadcountrydropdown', item).autocomplete(autocomp_opt_country);
                });
                
                addMultiInputNamingRules('#form_distributor_details', 'input[name="contact_person[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_distributor_details', 'input[name="email_id[]"]', { checkemail: true }, "");
                addMultiInputNamingRules('#form_distributor_details', 'input[name="mobile[]"]', { required: true, numbersonly: true, minlength: 10, maxlength: 10 }, "");

                // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_name[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_address[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_city[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_pincode[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_state[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_country[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_state_code[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_gst_number[]"]', { required: true }, "");
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
                                        '</tr>');
                     /*'<td style="text-align:center;     vertical-align: middle;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>'*/
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

            jQuery(function(){
                var counter2 = $('.con_name').length;
                $('#repeat-consignee').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="consignee_'+counter2+'_row">' + 
                                                '<td>' + 
                                                    '<input type="text" class="form-control con_name" name="con_name[]" id="con_name_'+counter2+'" placeholder="Consignee Name" value=""/>' + 
                                                '</td>' + 
                                                '<td>' + 
                                                    '<input type="text" class="form-control con_address" name="con_address[]" id="con_address_'+counter2+'" placeholder="Consignee Address" value=""/>' + 
                                                '</td>' + 
                                                '<td>' + 
                                                    '<input type="hidden" name="con_city_id[]" id="con_city_'+counter2+'_id" />' + 
                                                    '<input type="text" class="form-control con_city autocompleteCity" name="con_city[]" id="con_city_'+counter2+'" placeholder="Consignee City" value=""/>' + 
                                                '</td>' + 
                                                '<td>' + 
                                                    '<input type="text" class="form-control con_pincode" name="con_pincode[]" id="con_pincode_'+counter2+'" placeholder="Consignee Pincode" value=""/>' + 
                                                '</td>' + 
                                                '<td>' + 
                                                    '<input type="hidden" name="con_state_id[]" id="con_state_'+counter2+'_id" />' + 
                                                    '<input type="text" class="form-control con_state loadstatedropdown" name="con_state[]" id="con_state_'+counter2+'" placeholder="Consignee State" value=""/>' + 
                                                '</td>' + 
                                                '<td>' + 
                                                    '<input type="hidden" name="con_country_id[]" id="con_country_'+counter2+'_id" />' + 
                                                    '<input type="text" class="form-control con_country loadcountrydropdown" name="con_country[]" id="con_country_'+counter2+'" placeholder="Consignee Country" value=""/>' + 
                                                '</td>' + 
                                                '<td>' + 
                                                    '<input type="text" class="form-control con_state_code" name="con_state_code[]" id="con_state_code_'+counter2+'" placeholder="Consignee State Code" value=""/>' + 
                                                '</td>' + 
                                                '<td>' + 
                                                    '<input type="text" class="form-control con_gst_number" name="con_gst_number[]" id="con_gst_number_'+counter2+'" placeholder="Consignee Gst Number" value=""/>' + 
                                                '</td>' + 
                                                '<td style="text-align:center; vertical-align: middle;">' + 
                                                    '<a id="consignee_'+counter2+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o" ></span></a>' + 
                                                '</td>' + 
                                            '</tr>');
                    $('#consignee_details').append(newRow);
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    $('.autocompleteCity', newRow).autocomplete(autocomp_opt_city);
                    $('.loadstatedropdown', newRow).autocomplete(autocomp_opt_state);
                    $('.loadcountrydropdown', newRow).autocomplete(autocomp_opt_country);

                    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_name[]"]');
                    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_address[]"]');
                    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_city[]"]');
                    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_pincode[]"]');
                    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_state[]"]');
                    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_country[]"]');
                    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_state_code[]"]');
                    // removeMultiInputNamingRules('#form_distributor_details', 'input[alt="con_gst_number[]"]');

                    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_name[]"]', { required: true }, "");
                    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_address[]"]', { required: true }, "");
                    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_city[]"]', { required: true }, "");
                    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_pincode[]"]', { required: true }, "");
                    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_state[]"]', { required: true }, "");
                    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_country[]"]', { required: true }, "");
                    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_state_code[]"]', { required: true }, "");
                    // addMultiInputNamingRules('#form_distributor_details', 'input[name="con_gst_number[]"]', { required: true }, "");
                    
                    counter2++;
                });
            });
        </script>
    <!-- END SCRIPTS -->    

    </body>
</html>