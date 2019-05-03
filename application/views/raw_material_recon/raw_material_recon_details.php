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
            @media print {
                body * {
                    visibility: hidden;
                }
                #form_raw_material_recon_details * {
                    visibility: visible;
                }
                #form_raw_material_recon_details {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
                .print_hide {
                    display: none;
                }
            }
            .download {
                font-size: 21px;
                color: #5cb85c;
            }
            input[readonly] {
                color: #475c7c !important;
            }
		</style>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			<?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/raw_material_recon'; ?>" > Raw Material Recon List </a>  &nbsp; &#10095; &nbsp; Raw Material Recon Details</div>
                   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                        <div class="box-shadow">	
                            <form id="form_raw_material_recon_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/raw_material_recon/update/' . $data[0]->id; else echo base_url().'index.php/raw_material_recon/save'; ?>" enctype="multipart/form-data" >
                                <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default">
							     	<div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Processing <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                    <input type="hidden" class="form-control" name="module" id="module" value="<?php if(isset($module)) echo $module;?>"/>
                                                    <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
                                                    <input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date Of Processing" onchange="get_stock();" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else if(isset($p_data)) echo (($p_data[0]->confirm_to_date!=null && $p_data[0]->confirm_to_date!='')?date('d/m/Y',strtotime($p_data[0]->confirm_to_date)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group" style="display: none;">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Production <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select name="production_id" id="production_id" class="form-control select2">
                                                        <option value="">Select</option>
                                                        <?php 
                                                            $production_id = '';
                                                            if(isset($data)) $production_id = $data[0]->production_id;
                                                            if($production_id==''){
                                                                if(isset($p_id)) $production_id = $p_id;
                                                            }

                                                            if(isset($production)) { for ($k=0; $k < count($production) ; $k++) { 
                                                        ?>
                                                            <option value="<?php echo $production[$k]->id; ?>" <?php if(isset($production_id)) { if($production[$k]->id==$production_id) echo 'selected'; } ?> ><?php echo $production[$k]->p_id; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<select name="depot_id" id="depot_id" class="form-control select2" onChange="get_stock();">
														<option value="">Select</option>
                                                    <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                            <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } else if(isset($p_data)) { if($depot[$k]->id==$p_data[0]->manufacturer_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                    <?php }} ?>
													</select>
                                                <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo  $data[0]->depot_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo  $data[0]->depot_name; } ?>"/> -->
												</div>
											</div>
										</div>

                                        <div class="h-scroll">	
                                            <div class="table-stripped form-group" style="padding:15px;">
                                                <table class="table table-bordered" style="margin-bottom: 0px;">
                                                <thead>
                                                    <tr>
                                                        <th>Raw Material</th>
                                                        <th width="200">System Qty (In Kg)</th>
                                                        <th width="200">Physical Qty (In Kg)</th>
                                                        <th width="200">Difference (In Kg)</th>
                                                        <th width="100" style="display: none;">Select</th>
                                                        <th width="100" style="display: none;">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="raw_material_details">
                                                <?php $i=0; if(isset($raw_material_stock)) {
                                                        for($i=0; $i<count($raw_material_stock); $i++) { ?>
                                                    <tr id="raw_material_<?php echo $i; ?>_row">
                                                        <td>
                                                            <select name="raw_material_id[]" class="form-control raw_material select2" id="raw_material_<?php echo $i;?>">
                                                                <option value="">Select</option>
                                                                <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                        <option value="<?php echo $raw_material[$k]->id; ?>" <?php if($raw_material[$k]->id==$raw_material_stock[$i]->raw_material_id) { echo 'selected'; } ?>><?php echo $raw_material[$k]->rm_name; ?></option>
                                                                <?php }} ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control system_qty" name="system_qty[]" id="system_qty_<?php echo $i; ?>" placeholder="System Qty" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->system_qty; } ?>" readonly />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control physical_qty" name="physical_qty[]" id="physical_qty_<?php echo $i; ?>" placeholder="Physical Qty" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->physical_qty; } ?>" onchange="get_difference(this);" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control difference_qty" name="difference_qty[]" id="difference_qty_<?php echo $i; ?>" placeholder="Difference Qty" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->difference_qty; } ?>" readonly />
                                                        </td>
                                                        <td class="text-center" style="display: none;">
                                                            <input type="checkbox" class="check_qty" id="check_qty_<?php echo $i; ?>" onchange="set_check_qty_val(this);" />
                                                            <input type="hidden" class="form-control" name="check_qty[]" id="check_qty_val_<?php echo $i; ?>" placeholder="Check Qty" value="0">
                                                        </td>
                                                        <td style="display: none;">
                                                            <input type="text" class="form-control item_status" name="item_status[]" id="item_status_<?php echo $i; ?>" placeholder="Status" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->item_status; } ?>"/>
                                                        </td>
                                                    </tr>
                                                <?php }} else { ?>
                                                    <tr id="raw_material_<?php echo $i; ?>_row">
                                                        <td>
                                                            <select name="raw_material_id[]" class="form-control raw_material select2" id="raw_material_<?php echo $i;?>">
                                                                <option value="">Select</option>
                                                                <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                        <option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>
                                                                <?php }} ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control system_qty" name="system_qty[]" id="system_qty_<?php echo $i; ?>" placeholder="System Qty" value="" readonly />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control physical_qty" name="physical_qty[]" id="physical_qty_<?php echo $i; ?>" placeholder="Physical Qty" value="" onchange="get_difference(this);" />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control difference_qty" name="difference_qty[]" id="difference_qty_<?php echo $i; ?>" placeholder="Difference Qty" value="" readonly />
                                                        </td>
                                                        <td class="text-center" style="display: none;">
                                                            <input type="checkbox" class="check_qty" id="check_qty_<?php echo $i; ?>" onchange="set_check_qty_val(this);" />
                                                            <input type="hidden" class="form-control" name="check_qty[]" id="check_qty_val_<?php echo $i; ?>" placeholder="Check Qty" value="0">
                                                        </td>
                                                        <td style="display: none;">
                                                            <input type="text" class="form-control item_status" name="item_status[]" id="item_status_<?php echo $i; ?>" placeholder="Status" value=""/>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                                <!-- <tfoot>
                                                    <tr>
                                                        <td colspan="5" style="display:none;">
                                                            <button type="button" class="btn btn-success" id="repeat-raw_material" style=" ">+</button>
                                                        </td>
                                                    </tr>
                                                </tfoot> -->
                                                </table>
                                            </div>
        								</div>

    									<div class="form-group" style="display: none;">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                       <select class="form-control" name="status">
                                                            <option value="Pending" <?php if(isset($data)) {if ($data[0]->status=='Pending') echo 'selected';}?>>Pending</option>
                                                            <option value="Deleted" <?php if(isset($data)) {if ($data[0]->status=='Deleted') echo 'selected';}?>>Deleted</option>
                                                            <option value="Rejected" <?php if(isset($data)) {if ($data[0]->status=='Rejected') echo 'selected';}?>>Rejected</option>
                                                            <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Approved</option>
                                                            <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                                <div class="col-md-10 col-sm-10 col-xs-12 ">
                                                    <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								</div>
								<br clear="all"/>
								</div>
								</div>
                                <?php $curusr=$this->session->userdata('session_id'); ?>
                                <?php 
                                        if(isset($data[0]->status))
                                        {
                                         if(isset($access)) {
                                            if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive'))
                                                {
                                                  if(isset($data[0]->status))
                                                    {
                                                         if($data[0]->status=='Deleted'){
                                                            echo '<label class="col-xs-12 control-label" style="color:#cc2127!important">Note : If clicked on approve button this entry will be deleted permanently </label>';

                                                         }    
                                                    }     
                                                }
                                            }   
                                        }
                                ?>
                                <div class="panel-footer">
                                    <?php 
                                        $action = '';
                                        if(isset($module)) { if($module=='production') $action = base_url().'index.php/production/post_details/'.$production_id; }
                                        if($action==''){
                                            $action = base_url().'index.php/raw_material_recon';
                                        }
                                    ?>
                                    <a href="<?php echo $action; ?>" class="btn btn-danger btn-sm pull-right" type="reset" id="reset">Cancel</a>
                                    <?php $curusr=$this->session->userdata('session_id'); ?>
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit For Approval" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_edit=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || $data[0]->status=='InActive')) echo ''; else echo 'display: none;';} else if($access[0]->r_insert=='1') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_delete" name="btn_delete" value="Delete" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_delete=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved') && $data[0]->status!='InActive') echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" name="btn_reject" value="Reject" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
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
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                if($('#id').val()=='') {
                    get_stock();
                }

                $(".qty").blur(function(){
                    get_wastage();
                });
                $("#product_id").change(function(){
                    get_wastage();
                });
                $("#qty_in_bar").blur(function(){
                    get_wastage();
                });
                $("#actual_wastage").blur(function(){
                    get_wastage();
                });
                $("#output_kg").blur(function(){
                    get_wastage();
                });
				 $("#no_of_batch").blur(function(){
                    get_wastage();
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                
                addMultiInputNamingRules('#form_raw_material_recon_details', 'select[name="raw_material_id[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_raw_material_recon_details', 'input[name="physical_qty[]"]', { required: true }, "");
            });
            
            var get_stock = function() {
                $.ajax({
                    url:BASE_URL+'index.php/raw_material_recon/get_depot_stock',
                    method:"post",
                    data:{date_of_processing: $('#date_of_processing').val(), depot_id: $('#depot_id').val()},
                    dataType:"html",
                    async:false,
                    success: function(data){
                        $('#raw_material_details').html(data);
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });
            }

            var get_difference = function(elem) {
                var id = elem.id;
                var index = id.substr(id.lastIndexOf('_')+1);
                var system_qty = parseFloat(get_number($("#system_qty_"+index).val(),2));
                var physical_qty = parseFloat(get_number($("#physical_qty_"+index).val(),2));
                var difference_qty = Math.round((physical_qty - system_qty)*100)/100;

                $("#difference_qty_"+index).val(difference_qty);
            }

            var set_check_qty_val = function(elem) {
                var id = elem.id;
                var index = id.substr(id.lastIndexOf('_')+1);

                if($('#check_qty_'+index).is(':checked')){
                    $('#check_qty_val_'+index).val(1);
                } else {
                    $('#check_qty_val_'+index).val(0);
                }
            }
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>