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
                #form_batch_processing_details * {
                    visibility: visible;
                }
                #form_batch_processing_details {
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
         <!-- START PAGE CONTAINER -->
         <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/batch_processing'; ?>" > Batch Processing List </a>  &nbsp; &#10095; &nbsp; Batch Processing Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                   
                <!-- PAGE CONTENT WRAPPER -->
                  <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">	
                            <form id="form_batch_processing_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/batch_processing/update/' . $data[0]->id; else echo base_url().'index.php/batch_processing/save'; ?>" enctype="multipart/form-data" >
                               <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							     	<div class="panel-body">
										<div class="form-group" >
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">Batch No <span class="asterisk_sign">*</span></label>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<select name="batch_no_id" id="batch_no_id" class="form-control select2" onChange="set_batch_no();">
														<option value="">Select</option>
                                                    <?php if(isset($batch_no)) { for ($k=0; $k < count($batch_no) ; $k++) { ?>
                                                            <option value="<?php echo $batch_no[$k]->id; ?>" <?php if(isset($data)) { if($batch_no[$k]->id==$data[0]->batch_no_id) { echo 'selected'; } } ?>><?php echo $batch_no[$k]->batch_no; ?></option>
                                                    <?php }} ?>
													</select>
                                                <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo  $data[0]->depot_id; } ?>"/>
                                                <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo  $data[0]->depot_name; } ?>"/> -->
												</div>
											</div>
										</div>
										<div class="form-group" style="display: none;">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label" style="display: none;">Batch Id <span class="asterisk_sign">*</span></label>
												<div class="col-md-4 col-sm-4 col-xs-12" style="display: none;">
													<input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
													<input type="hidden" class="form-control" name="module" id="module" value="<?php if(isset($module)) echo $module;?>"/>
                                                    <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
													<input type="text" class="form-control" name="batch_id_as_per_fssai" id="batch_id_as_per_fssai" placeholder="Batch Id" value="<?php if(isset($data)) { echo  $data[0]->batch_id_as_per_fssai; } ?>"/>
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
										<div class="form-group"  >
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Processing <span class="asterisk_sign">*</span></label>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date Of Processing" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<select name="depot_id" id="depot_id" class="form-control select2">
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
										<div class="form-group">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label class="col-md-2 col-sm-2 col-xs-12 control-label">No.of Batches <span class="asterisk_sign">*</span></label>
												<div class="col-md-4 col-sm-4 col-xs-12">
													<input type="text" class="form-control" name="no_of_batch" id="no_of_batch" placeholder="No.of Batches" value="<?php if (isset($data)) { echo $data[0]->no_of_batch; } ?>"/>
												</div>
											</div>
										</div>
									
									    <div class="form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Product <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select name="product_id" id="product_id" class="form-control select2">
                                                        <option value="">Select</option>
                                                        <?php if(isset($product)) { for ($k=0; $k < count($product); $k++) { ?>
                                                                <option value="<?php echo $product[$k]->id; ?>" <?php if(isset($data)) { if($product[$k]->id==$data[0]->product_id) { echo 'selected'; } } ?>><?php echo $product[$k]->product_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <!-- <input type="hidden" name="product_id" id="product_id" value="<?php //if(isset($data)) { echo  $data[0]->product_id; } ?>"/>
                                                    <input type="text" class="form-control load_product" name="product" id="product" placeholder="Type To Select Product...." value="<?php //if(isset($data)) { echo  $data[0]->product_name; } ?>"/> -->
                                                </div>
                                            </div>
                                        </div>
						
									
									
                                    <div class="h-scroll">	
                                        <div class="table-stripped form-group" style="padding:15px;">
                                            <table class="table table-bordered" style="margin-bottom: 0px; ">
                                            <thead>
                                                <tr>
                                                    <th  >Raw Material</th>
                                                    <th width="200">Qty (In Kg)</th>
                                                    <th width="75" style="display:none;">Action</th>
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
                                                        <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($raw_material_stock)) { echo $raw_material_stock[$i]->qty; } ?>"/>
                                                    </td>
                                                   <td style="text-align:center;  display:none;   vertical-align: middle;">
                                                        <a id="raw_material_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
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
                                                        <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value=""/>
                                                    </td>
                                                    <td style="text-align:center;  display:none;   vertical-align: middle;">
                                                        <a id="raw_material_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" style="display:none;">
                                                        <button type="button" class="btn btn-success" id="repeat-raw_material" style=" ">+</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            </table>
                                        </div>
    								</div>

                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total (In Kg) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_kg" id="total_kg" placeholder="Total Kg" value="<?php if (isset($data)) { echo $data[0]->total_kg; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Anticipated Wastage (In %) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="anticipated_wastage" id="anticipated_wastage" placeholder="Anticipated Wastage" value="<?php if (isset($data)) { echo $data[0]->anticipated_wastage; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Anticipated Water Loss (In %) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="anticipated_water_loss" id="anticipated_water_loss" placeholder="Anticipated Water Loss" value="<?php if (isset($data)) { echo $data[0]->anticipated_water_loss; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Anticipated Output (In Kg) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="anticipated_output_in_kg" id="anticipated_output_in_kg" placeholder="Anticipated Output" value="<?php if (isset($data)) { echo $data[0]->anticipated_output_in_kg; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Anticipated Grams <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="anticipated_grams" id="anticipated_grams" placeholder="Anticipated Grams" value="<?php if (isset($data)) { echo $data[0]->anticipated_grams; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Anticipated Output (In Bars) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="anticipated_output_in_bars" id="anticipated_output_in_bars" placeholder="Anticipated Output" value="<?php if (isset($data)) { echo $data[0]->anticipated_output_in_bars; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Qty In Bar <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="qty_in_bar" id="qty_in_bar" placeholder="Qty In Bar" value="<?php if (isset($data)) { echo $data[0]->qty_in_bar; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Actual Grams In Bar <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="avg_grams" id="avg_grams" placeholder="Actual Grams In Bar" value="<?php if (isset($data)) { echo $data[0]->avg_grams; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Difference In Bars <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="difference_in_bars" id="difference_in_bars" placeholder="Difference In Bars" value="<?php if (isset($data)) { echo $data[0]->difference_in_bars; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Actual Wastage (In Kg)<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="actual_wastage" id="actual_wastage" placeholder="Actual Wastage" value="<?php if (isset($data)) { echo $data[0]->actual_wastage; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Actual Water Loss (In Kg)<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="actual_water_loss" id="actual_water_loss" placeholder="Actual Water Loss" value="<?php if (isset($data)) { echo $data[0]->actual_water_loss; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Wastage (In Kg)<span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="total_wastage" id="total_wastage" placeholder="Total Wastage" value="<?php if (isset($data)) { echo $data[0]->total_wastage; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Actual % wastage/ Output <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="actual_wastage_percent" id="actual_wastage_percent" placeholder="Actual Wastage Percent" value="<?php if (isset($data)) { echo $data[0]->actual_wastage_percent; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Output (In Kg) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="output_kg" id="output_kg" placeholder="Output Kg" value="<?php if (isset($data)) { echo $data[0]->output_kg; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Wastage (In %) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="wastage_percent" id="wastage_percent" placeholder="Wastage Percent" value="<?php if (isset($data)) { echo $data[0]->wastage_percent; } ?>"/>
                                            </div>
                                        </div>
									</div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Wastage Variance (In %) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control format_number" name="wastage_variance" id="wastage_variance" placeholder="Wastage Variance" value="<?php if (isset($data)) { echo $data[0]->wastage_variance; } ?>"/>
                                            </div>
                                            <!-- <div style="<?php //if(isset($data)) echo ''; else echo 'display: none;';?>">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select class="form-control" name="status">
                                                        <option value="Approved" <?php //if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Active</option>
                                                        <option value="InActive" <?php //if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                    </select>
                                                </div>
                                            </div> -->
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
									
                                	<div class="h-scroll" style="display: none;">	
                                        <div class="table-stripped form-group" style="padding:15px;">
                                            <table class="table table-bordered" style="margin-bottom: 0px; ">
                                            <thead>
                                                <tr>
                                                    <th>Document Title</th>
                                                    <th>Upload Files</th>
                                                  
                                                 
                                                    <th width="75">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bar_image_details">
                                            <?php $i=0; if(isset($batch_images)) {
                                                    for($i=0; $i<count($batch_images); $i++) { ?>
                                                <tr id="bar_image_<?php echo $i; ?>_row">
    												<td>
                                                        <input type="text" class="form-control title" name="title[]" id="title_<?php echo $i; ?>" placeholder="title"value="<?php if (isset($batch_images)) { echo $batch_images[$i]->title; } ?>">
                                                    </td>
                                                    <td>
                                                        <div class="col-md-9 col-sm-9 col-xs-9">
                                                            <input type="hidden" class="form-control" name="receivable_doc[]" value="<?php if(isset($batch_images)) {echo $batch_images[$i]->receivable_doc;} ?>" />
                                                            <input type="hidden" class="form-control" name="image_path[]" value="<?php if(isset($batch_images)) {echo $batch_images[$i]->image;} ?>" />
        												    <input type="file" class="fileinput btn btn-info btn-small bar_image" name="image_<?php echo $i; ?>" id="image_<?php echo $i; ?>" placeholder="image"/>
                                                        </div>
                                                        <?php if(isset($batch_images)) {if($batch_images[$i]->image!= '') { ?>
                                                        <div class="col-md- col-sm-3 col-xs-3">
        												    <a target="_blank" id="batch_doc_file_download<?php echo $i; ?>" href="<?php echo base_url().$batch_images[$i]->image; ?>"><span class="fa download fa-download" ></span></a>
                                                        </div>
        												<?php }} ?>
    												</td>
                                                   <td style="text-align:center;  vertical-align: middle;">
                                                        <a id="bar_image_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                    </td>
                                                </tr>
                                            <?php }} else { ?>
                                                <tr id="bar_image_<?php echo $i; ?>_row">
                                                    <td>
                                                        <input type="text" class="form-control title" name="title[]" id="title_<?php echo $i; ?>" placeholder="title" value=""/>
                                                    </td>
                                                    <td>
    												    <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                        <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                        <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="image_<?php echo $i; ?>" id="image_<?php echo $i; ?>" placeholder="image" value=""/>
                                                    </td>
                                                    <td style="text-align:center;     vertical-align: middle;">
                                                        <a id="bar_image_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">
                                                        <button type="button" class="btn btn-success" id="repeat-bar_image" style=" ">+</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            </table>
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
                                            $action = base_url().'index.php/batch_processing';
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
                
                addMultiInputNamingRules('#form_batch_processing_details', 'select[name="raw_material_id[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_batch_processing_details', 'input[name="qty[]"]', { required: true }, "");
            });
            
            function set_batch_no(){
                $("#batch_id_as_per_fssai").val($("#batch_no_id option:selected").text());
            }

            function get_wastage(){
                var qty = 0;
				
                var total_qty = 0;
                $('.qty').each(function(){
                    qty = parseFloat(get_number($(this).val(),2));
                    if (isNaN(qty)) qty=0;
                    total_qty = total_qty + qty;
                });

                var product_id = $("#product_id").val();
                var qty_in_bar = parseFloat(get_number($("#qty_in_bar").val(),2));
                var actual_wastage = parseFloat(get_number($("#actual_wastage").val(),2));
                var actual_water_loss = parseFloat(get_number($("#actual_water_loss").val(),2));
                var grams_in_bar = 0;
                var anticipated_wastage = 0;
                var anticipated_water_loss = 0;

                $.ajax({
                    url:BASE_URL+'index.php/Product/get_data',
                    method:"post",
                    data:{id:product_id},
                    dataType:"json",
                    async:false,
                    success: function(data){
                        if(data.result==1){
                            grams_in_bar = parseFloat(data.avg_grams);
                            anticipated_wastage = parseFloat(data.anticipated_wastage);
                            anticipated_water_loss = parseFloat(data.anticipated_water_loss);
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });

                if (isNaN(qty_in_bar)) qty_in_bar=0;
                if (isNaN(actual_wastage)) actual_wastage=0;
                if (isNaN(actual_water_loss)) actual_water_loss=0;
                if (isNaN(grams_in_bar)) grams_in_bar=0;
                if (isNaN(anticipated_wastage)) anticipated_wastage=0;
                if (isNaN(anticipated_water_loss)) anticipated_water_loss=0;
                if (isNaN(total_qty)) total_qty=0;

                var anticipated_output_in_kg = total_qty - ((total_qty*(anticipated_wastage+anticipated_water_loss))/100);
                if (isNaN(anticipated_output_in_kg)) anticipated_output_in_kg=0;
                var anticipated_output_in_bars = 0;
                if(grams_in_bar!=0){
                    anticipated_output_in_bars = (anticipated_output_in_kg*1000)/grams_in_bar;
                }
                if (isNaN(anticipated_output_in_bars)) anticipated_output_in_bars=0;
                
                $("#anticipated_wastage").val(Math.round(anticipated_wastage*100)/100);
                $("#anticipated_water_loss").val(Math.round(anticipated_water_loss*100)/100);
                $("#anticipated_grams").val(Math.round(grams_in_bar*100)/100);
                $("#anticipated_output_in_kg").val(Math.round(anticipated_output_in_kg*100)/100);
                $("#anticipated_output_in_bars").val(Math.round(anticipated_output_in_bars*100)/100);

                var avg_grams = 0;
                if(qty_in_bar!=0){
                    avg_grams = (anticipated_output_in_kg*1000)/qty_in_bar;
                }
                var difference_in_bars = anticipated_output_in_bars - qty_in_bar;
                var total_wastage_in_kg = ((difference_in_bars*grams_in_bar)/1000)+actual_wastage+actual_water_loss;
                var actual_wastage_percent = 0;
                if(total_qty!=0){
                    actual_wastage_percent = total_wastage_in_kg/total_qty;
                }

                // var actual_wastage = total_qty-((qty_in_bar*grams_in_bar)/1000);
                var wastage_percent = 0;
                if(total_qty!=0){
                    wastage_percent = (actual_wastage/total_qty)*100;
                }
                var wastage_variance = wastage_percent-anticipated_wastage;

                $('#total_kg').val(Math.round(total_qty*100)/100);
                $('#avg_grams').val(Math.round(avg_grams*100)/100);
                $('#difference_in_bars').val(Math.round(difference_in_bars*100)/100);
                $("#actual_wastage").val(Math.round(actual_wastage*100)/100);
                $("#actual_water_loss").val(Math.round(actual_water_loss*100)/100);
                $("#total_wastage").val(Math.round(total_wastage_in_kg*100)/100);
                $("#actual_wastage_percent").val(Math.round(actual_wastage_percent*100)/100);
                $("#wastage_percent").val(Math.round(wastage_percent*100)/100);
                $("#wastage_variance").val(Math.round(wastage_variance*100)/100);
            }
			
            // function get_no_of_batch(){
    			
    			// var no_of_batch = $("#no_of_batch").val();
    			// console.log(no_of_batch);
    			 // var product_id = $("#product_id").val();
    			  // $.ajax({
                // url:BASE_URL+'index.php/batch_processing/get_data',
                // method:"post",
                // data:{no_of_batch:no_of_batch},
                // dataType:"json",
                // async:false,
                // success: function(data){
                   
                        // no_of_batch = data.no_of_batch;
                      
                   
                // },
                // error: function (response) {
                    // var r = jQuery.parseJSON(response.responseText);
                    // alert("Message: " + r.Message);
                    // alert("StackTrace: " + r.StackTrace);
                    // alert("ExceptionType: " + r.ExceptionType);
                // }
                // });
            // }
			
            $('#product_id').on('change', function() {
                // alert( this.value ); // or $(this).val()
                get_raw_material();
                get_wastage();
            });
			 $("#no_of_batch").blur(function(){
                get_raw_material();
                get_wastage();
            });
				
            function get_raw_material(){
				  // get_no_of_batch();
				  
                var product_id = $('#product_id').val();
				// console.log(product_id);
				var no_of_batch = $("#no_of_batch").val();
					// var qty_per_batch = parseFloat(get_number($("#qty_per_batch").val(),2));
				//var qty_per_batch=no_of_batch*qty_per_batch;
                
                $.ajax({
                    url:BASE_URL+'index.php/batch_processing/get_batch_raw_material1',
                    method:"post",
                    data:{id:product_id,no_of_batch:no_of_batch},
                    dataType:"json",
                    async:false,
                    success: function(data){
						// console.log(data.length);
                        if(data.length>0){
							
                            // $("#raw_material_details > tbody").html("");
                            // $("tbody", "#raw_material_details").remove();
                            $("#raw_material_details").empty();
							// console.log('jsonData '+data);
							
                            var counter = $('.raw_material').length;
					
        					var newRow='';
        					for (var i = 0; i < data.length; i++) {
        						 var parsejson = data[i];
        						 parsejson.qty_per_batch= no_of_batch * parsejson.qty_per_batch
        						 // console.log(parsejson.rm_name);
        						newRow += '<tr id="raw_material_'+counter+'_row">'+
                                                    '<td>'+
                                                        '<select name="raw_material_id[]" class="form-control raw_material select2" id="raw_material_'+counter+'">'+
                                                            '<option value="'+parsejson.rm_id+'">'+parsejson.rm_name+'</option>'+
                                                        '</select>'+
                                                    '</td>'+
                                                    '<td>'+
                                                         '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="' +parsejson.qty_per_batch + '" onchange="get_amount(this)" />' + 
                                                    '</td>'+
                                                    '<td style="text-align:center; display:none; vertical-align: middle;">'+
                                                        '<a id="raw_material_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                                    '</td>'+
                                                '</tr>';
        										
        										   counter++;
        					}
        					// console.log(newRow);
					
        				    $('#raw_material_details').append(newRow);
        				    $('.select2').select2();

                            $('.format_number').keyup(function(){
                                format_number(this);
                            });
                            // $(".qty").blur(function(){
                                // get_amount($(this));
                            // });
                            // $(".rate").blur(function(){
                                // get_amount($(this));
                            // });
                            $('.delete_row').click(function(event){
                                delete_row($(this));
                                get_wastage();
                            });
                        }
                    },
                    error: function (response) {
                        var r = jQuery.parseJSON(response.responseText);
                        alert("Message: " + r.Message);
                        alert("StackTrace: " + r.StackTrace);
                        alert("ExceptionType: " + r.ExceptionType);
                    }
                });
            }
				
            // jQuery(function(){
                // var counter = $('.raw_material').length;
                // $('#repeat-raw_material').click(function(event){
                    // event.preventDefault();
                    // var newRow = jQuery('<tr id="raw_material_'+counter+'_row">'+
                                            // '<td>'+
                                                // '<select name="raw_material_id[]" class="form-control raw_material" id="raw_material_'+counter+'">'+
                                                    // '<option value="">Select</option>'+
                                                    // '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>'+
                                                            // '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>'+
                                                    // '<?php }} ?>'+
                                                // '</select>'+
                                            // '</td>'+
                                            // '<td>'+
                                                // '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value=""/>'+
                                            // '</td>'+
                                            // '<td style="text-align:center;  vertical-align: middle;">'+
                                                // '<a id="raw_material_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                            // '</td>'+
                                        // '</tr>');
                    // $('#raw_material_details').append(newRow);
                    // $('.format_number').keyup(function(){
                        // format_number(this);
                    // });
                    // $(".qty").blur(function(){
                        // get_wastage();
                    // });
                    // $('.delete_row').click(function(event){
                        // delete_row($(this));
                        // get_wastage();
                    // });
                    // counter++;
                // });
            // });
			
            jQuery(function(){
                var counter = $('.title').length;
				
                $('#repeat-bar_image').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="bar_image_'+counter+'_row">'+
                                          '<td>'+
                                                '<input type="title" class="form-control title" name="title[]" id="title_'+counter+'" placeholder="title" value=""/>'+
                                            '</td>'+
                                            '<td>'+
											 '<input type="hidden" class="form-control receivable_doc" name="receivable_doc[]" value="receivable_doc_'+counter+'" />'+
                                                '<input type="file" class="fileinput btn btn-info btn-small bar_image" name="image_'+counter+'" id="image_'+counter+'" placeholder="image" value=""/>'+
                                            '</td>'+
                                            '<td style="text-align:center;  vertical-align: middle;">'+
                                                '<a id="bar_image_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                            '</td>'+
                                        '</tr>');
                    $('#bar_image_details').append(newRow);
                  
                 
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                      
                    });
                    counter++;
                });
            });
			
			
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>