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
            th{ text-align: center; }
            .center{ text-align: center; }
            @media print {
                body * {
                    visibility: hidden;
                }
                #form_tentative_stock_details * {
                    visibility: visible;
                }
                #form_tentative_stock_details {
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
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/batch_processing'; ?>" > Tentative Stock List </a>  &nbsp; &#10095; &nbsp; Tentative Stock Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                        <div class="box-shadow">	
                            <form id="form_tentative_stock_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/batch_processing/update_tentative/' . $data[0]->id; else echo base_url().'index.php/batch_processing/save_tentative'; ?>" enctype="multipart/form-data" >
                                <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;">
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
                                                    <input type="hidden" class="form-control" name="old_depot_id" id="old_depot_id" value="<?php if(isset($data)) echo $data[0]->depot_id;?>"/>
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
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Product <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="hidden" class="form-control" name="old_product_id" id="old_product_id" value="<?php if(isset($data)) echo $data[0]->product_id;?>"/>
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
                                        <div class="form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Qty In Bar <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <input type="text" class="form-control format_number" name="qty_in_bar" id="qty_in_bar" placeholder="Qty In Bar" value="<?php if (isset($data)) { echo $data[0]->qty_in_bar; } ?>"/>
                                                </div>
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

								</div>
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
                                </div>
                                </div>
							</form>
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
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
            });
            
            function set_batch_no(){
                $("#batch_id_as_per_fssai").val($("#batch_no_id option:selected").text());
            }
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>