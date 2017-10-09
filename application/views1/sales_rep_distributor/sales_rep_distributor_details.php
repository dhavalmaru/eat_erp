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
        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sales_rep_distributor'; ?>" > Distributor List </a>  &nbsp; &#10095; &nbsp; Distributor Details</div>

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
                    <div class="box-shadow">
                    <form id="form_sales_rep_distributor_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if (isset($data)) echo base_url(). 'index.php/sales_rep_distributor/save/' . $data[0]->id; else echo base_url().'index.php/sales_rep_distributor/save'; ?>">
                        <div class="box-shadow-inside">
                        <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="place_order" id="place_order" value="No"/>
                                            <input type="text" class="form-control" name="distributor_name" id="distributor_name" placeholder="Distributor Name" value="<?php if(isset($data)) echo $data[0]->distributor_name; else if(isset($distributor_name)) echo $distributor_name;?>"/>
                                        </div>
                                        <div style="display: none;">
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
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Address</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="address" placeholder="Address" value="<?php if(isset($data)) echo $data[0]->address;?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Vat No</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="vat_no" placeholder="Vat No" value="<?php if (isset($data)) { echo $data[0]->vat_no; } ?>"/>
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
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Contact Person</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="contact_person" placeholder="Contact Person" value="<?php if(isset($data)) echo $data[0]->contact_person;?>"/>
                                        </div>
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Contact No</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="contact_no" placeholder="Contact No" value="<?php if (isset($data)) { echo $data[0]->contact_no; } ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Margin On MRP (In %)*</label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="margin" placeholder="Margin" value="<?php if(isset($data)) echo $data[0]->margin;?>"/>
                                        </div>
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
                            <a href="<?php echo base_url(); ?>index.php/sales_rep_distributor" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                            <a href="#" id="btn_save" class="btn pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;'; else if(substr($data[0]->id,0,1)=="d") echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</a>
                            <!-- <button id="btn_save" class="btn pull-right" style="<?php //if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
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


        <div id="confirm_content2" style="display:none">
            <div class="logout-containerr">
                <button type="button" class="close" data-confirmmodal-but="cancel">×</button>
                <div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Place Order? </div>
                <div class="confirmModal_content">
                    <p>Do you want to place order?</p>
                </div>
                <div class="confirmModal_footer">
                    <!-- <a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a> -->
                    <button type="button" class="btn btn-success " data-confirmmodal-but="ok">Yes</button>
                    <button type="button" class="btn btn-danger " data-confirmmodal-but="cancel">No</button>
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
            $("#btn_save").click(function(){
                if (!$("#form_sales_rep_distributor_details").valid()) {
                    return false;
                } else {
                    $('#confirm_content2').confirmModal({
                        topOffset: 0,
                        onOkBut: function() {$('#place_order').val("Yes"); $("#form_sales_rep_distributor_details").submit();},
                        onCancelBut: function() {$('#place_order').val("No"); $("#form_sales_rep_distributor_details").submit();},
                        onLoad: function() {$('#place_order').val("No"); return true;},
                        onClose: function() {$('#place_order').val("No"); return true;}
                    });
                }
            });
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>