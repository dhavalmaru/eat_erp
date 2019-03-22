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

			#box_details .form-control[disabled], #box_details .form-control[readonly],#bar_details .form-control[disabled], #bar_details .form-control[readonly]
			{
				border:none!important;
				background-color:transparent!important;
				box-shadow:none!important;
			}							
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			<?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/raw_material_in_out'; ?>" > Raw Material Stock IN/OUT List </a>  &nbsp; &#10095; &nbsp; Raw Material Stock IN/OUT Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                <div class="row main-wrapper">
				    <div class="main-container">           
                    <div class="box-shadow">							
                        <form id="form_raw_material_in_out" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/Raw_material_in_out/update/' . $data[0]->id; else echo base_url().'index.php/Raw_material_in_out/save'; ?>">
                            <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
							
						 	<div class="panel-body">
								<div class="form-group"  >
									<div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date Of Processing <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control datepicker1" name="date_of_processing" id="date_of_processing" placeholder="Date Of Processing" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                            <input type="hidden" class="form-control" name="id" id="id" placeholder="Id" value="<?php if (isset($data)) { echo $data[0]->id; } ?>"/>
                                            <input type="hidden" class="form-control" name="ref_id" id="ref_id" value="<?php if(isset($data)) echo $data[0]->ref_id;?>"/>
                                        </div>
                                    </div>
                                </div>

								<div class="form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="depot_id" id="depot_id" class="form-control ">
                                                <option value="">Select</option>
                                                <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                        <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                            <input type="hidden" name="prev_depo" id="prev_depo" value="<?php if(isset($data)) { echo  $data[0]->depot_id; } ?>"/>
                                            <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo  $data[0]->depot_id; } ?>"/>
                                            <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo  $data[0]->depot_name; } ?>"/> -->
                                        </div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Raw Material IN/OUT Type <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="r_type" id="r_type" class="form-control select2">
                                                <option value="" >Select</option>
                                                <option value="Damage" <?php 
                                                if(isset($data)) { 
                                                    if($data[0]->type=='Damage') 
                                                        {
                                                          echo  "selected";
                                                        }
                                                    }
                                                ?>>Damage</option>
                                                <option value="Stock Expiry" <?php 
                                                if(isset($data)) { 
                                                    if($data[0]->type=='Stock Expiry') 
                                                        {
                                                          echo  "selected";
                                                        }
                                                    }
                                                ?>>Stock Expiry</option>
                                                <option value="Adjustment"
                                                <?php 
                                                if(isset($data)) { 
                                                    if($data[0]->type=='Adjustment') 
                                                        {
                                                          echo  "selected";
                                                        }
                                                    }
                                                ?>
                                                >Adjustment</option>
                                                <option value="Other"
                                                <?php 
                                                if(isset($data)) { 
                                                    if($data[0]->type=='Other') 
                                                        {
                                                          echo  "selected";
                                                        }
                                                    }
                                                ?>
                                                >Other</option>
                                            </select>
                                            <!-- <input type="hidden" name="depot_id" id="depot_id" value="<?php //if(isset($data)) { echo  $data[0]->depot_id; } ?>"/>
                                            <input type="text" class="form-control load_depot" name="depot" id="depot" placeholder="Type To Select Depot...." value="<?php //if(isset($data)) { echo  $data[0]->depot_name; } ?>"/> -->
                                        </div>
									</div>
								</div>

                                <div class="table-stripped form-group" style="padding:15px;" >

                                    <?php 
                                        /*echo "<pre>";
                                        print_r($raw_material);
                                        echo "</pre>";*/
                                    ?>
                                    <table class="table table-bordered" style="margin-bottom: 0px; ">
                                    <thead>
                                        <tr>
                                            <th  width="100">Stock IN / OUT </th>
                                            <th width="250">Item</th>
                                            <th width="250">Qty In KG</th>
                                            <th style="text-align:center; width:75px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="box_details">
                                    <?php $i=0; if(isset($raw_material_in_out)) {
                                            for($i=0; $i<count($raw_material_in_out); $i++) { ?>
                                        <tr id="box_<?php echo $i; ?>_row">
                                            <td>
												<select name="type[]" class="form-control type " id="type_<?php echo $i;?>">
                                                    <option value="">Select</option>
                                                    <option value="Stock IN" <?php if(isset($raw_material_in_out)) {if ($raw_material_in_out[$i]->type=='Stock IN') echo 'selected';}?>>Stock IN</option>
                                                    <option value="Stock OUT" <?php if(isset($raw_material_in_out)) {if ($raw_material_in_out[$i]->type=='Stock OUT') echo 'selected';}?>>Stock OUT</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="raw_material[]" class="form-control raw_material select2" id="raw_material_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" readonly>
                                                    <option value="">Select</option>
                                                    <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { 
                                                        ?>

                                                            <option value="<?php echo $raw_material[$k]->id; ?>" <?php if($raw_material[$k]->id==$raw_material_in_out[$i]->raw_material_id) { echo 'selected'; } ?>><?php echo $raw_material[$k]->rm_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_item_<?php echo $i;?>"></div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control format_number qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($raw_material_in_out)) { echo $raw_material_in_out[$i]->qty; } ?>"/>
                                            </td>
                                            <td style="text-align:center;     vertical-align: middle;">
                                                <a id="box_<?php echo $i; ?>_row_delete" class="delete_row_new" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                            </td>
                                        </tr>
                                    <?php }} else { ?>
                                        <tr id="box_<?php echo $i; ?>_row">
                                            <td>
                                                <select name="type[]" class="form-control type " id="type_<?php echo $i;?>">
                                                    <option value="">Select</option>
                                                    <option value="Stock IN" <?php if(isset($data)) {if ($data[0]->status=='Stock In') echo 'selected';}?>>Stock IN</option>
                                                    <option value="Stock OUT" <?php if(isset($data)) {if ($data[0]->status=='Stock Out') echo 'selected';}?>>Stock OUT</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="raw_material[]" class="form-control raw_material select2" id="raw_material_<?php echo $i;?>" readonly>
                                                   <option value="">Select</option> 
                                                    <!-- <option value="">Select</option> -->
                                                    <?php if(isset($raw_material)) { 
                                                        for ($k=0; $k < count($raw_material) ; $k++) { 
                                                        ?>
                                                        <option value="<?php echo $raw_material[$k]->id; ?>" >
                                                                <?php echo $raw_material[$k]->rm_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control format_number qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value=""/>
                                            </td>
                                            <td style="text-align:center;     vertical-align: middle;">
                                                <a id="box_<?php echo $i; ?>_row_delete" class="delete_row_new" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <button type="button" class="btn btn-success" id="repeat-box"  >+</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    </table>
                                </div>

                                <div class="form-group" style="display: none">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="display: none;">
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
                                        <div class="col-md-10 col-sm-10 col-xs-12">
                                            <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                        </div>
                                    </div>
                                </div>
							</div>


                            <div class="panel-footer" >
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
                                                        echo '<label class="col-xs-12 " style="color:#cc2127!important">Note : If clicked on approve button this entry will be deleted permanently </label>';

                                                     }    
                                                }     
                                            }
                                        }   
                                    }
                                ?>
                                <a href="<?php echo base_url(); ?>index.php/Raw_material_in_out" class="btn btn-danger btn-sm pull-right" type="reset" id="reset">Cancel</a>
                                <?php $curusr=$this->session->userdata('session_id'); ?>
                                <div>
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_submit" name="btn_submit" value="Submit For Approval" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_edit=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved' || $data[0]->status=='InActive')) echo ''; else echo 'display: none;';} else if($access[0]->r_insert=='1') echo ''; else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_delete" name="btn_delete" value="Delete" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_delete=='1' && ($data[0]->modified_by==$curusr || $data[0]->status=='Approved') && $data[0]->status!='InActive') echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-success btn-sm" id="btn_approve" name="btn_approve" value="Approve" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                    <input type="submit" class="btn btn-danger btn-sm" id="btn_reject" name="btn_reject" value="Reject" style="<?php if(isset($access)) {if(isset($data)) {if($access[0]->r_approvals=='1' && ($data[0]->modified_by!=$curusr && $data[0]->status!='Approved' && $data[0]->status!='InActive')) echo ''; else echo 'display: none;';} else echo 'display: none;';} else echo 'display: none;'; ?>" />
                                </div>
                            </div>

                            </div>
                            </div>
							<br clear="all"/>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){

                $("#depot_id").change(function () {
                    var check_raw_material_qty = get_raw_material_qty('raw_material_in_out','form_raw_material_in_out','depochange');
                    if(check_raw_material_qty==false)
                    {
                       var previous_val = $("#prev_depo").val();
                        $("#depot_id").val(previous_val);
                    }
                    else
                    {
                         $("#prev_depo").val($(this).val());
                    }
                });
                
                $('.delete_row_new').click(function(event){
                    set_stock_validation('raw_material_in_out','form_raw_material_in_out',$(this));
                });

                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                addMultiInputNamingRules('#form_bar_to_box_details', 'select[name="box[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_bar_to_box_details', 'input[name="qty[]"]', { required: true }, "");
            });

            jQuery(function(){
                var counter = $('.type').length;

                $('#repeat-box').click(function(event){
                    event.preventDefault();
                    var newRow = jQuery('<tr id="box_'+counter+'_row">'+
                                            '<td>'+
                                                '<select name="type[]" class="form-control box " id="type_'+counter+'">'+
                                                    '<option value="">Select</option>'+
                                                            '<option value="Stock IN" <?php if(isset($data)) {if ($data[0]->status=='Stock IN') echo 'selected';}?>>Stock IN</option>'+
															'<option value="Stock OUT" <?php if(isset($data)) {if ($data[0]->status=='Stock OUT') echo 'selected';}?>>Stock OUT</option>'+
                                                '</select>'+
                                            '</td>'+
                                            '<td>'+
                                                    '<select class="form-control raw_material select2" id="raw_material_'+counter+'" name="raw_material[]">'+
                                                        '<option value="">Select</option>'+
                                                        '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>'+
                                                                '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>'+
                                                        '<?php }} ?>'+
                                                    '</select>'+
                                             '</td>'+
                                            '<td>'+
                                                '<input type="text" class="form-control format_number qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value=""/>'+
                                            '</td>'+
                                            
                                            '  <td style="text-align:center;     vertical-align: middle;">'+
                                                '<a id="box_'+counter+'_row_delete" class="delete_row_new" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                            '</td>'+
                                        '</tr>');
                    $('#box_details').append(newRow);
                    $('.select2').select2();
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    
                    $('.delete_row_new').click(function(event){
                        set_stock_validation('raw_material_in_out','form_raw_material_in_out',$(this));
                        
                    });
                    counter++;
                });
            });

            var  set_stock_validation = function(model_name,form_name,elem) {
                var id =  elem.attr('id');
                var myarr = id.split("_");
                var index = myarr[1];
                var validator = $("#"+form_name).validate();
                var valid = true;
                /*alert('status'+$('#status').val());*/
                if($('#id').val()!='')
                {
                    var entered_qty = 0; 
                    var depot_id = $("#prev_depo").val();
                    var ref_id = $("#ref_id").val();
                    var pre_qty = parseInt($('#pre_qty_'+index).val());
                    /*alert(type);*/
                    var module=model_name;
                     var qty = 0
                    var raw_material = $('#raw_material_'+index).val();
                    var url = BASE_URL+'index.php/Stock/check_raw_material_qty_availablity';
                    var data =  'id='+$("#id").val()+'&module='+module+'&depot_id='+depot_id+'&raw_material_id='+raw_material+'&qty='+qty+'&get_stock=1'+'&ref_id='+ref_id;

                    $.ajax({
                        url: url,
                        data: data,
                        type: "POST",
                        dataType: 'html',
                        global: false,
                        async: false,
                        success: function (data) {
                            /*console.log('data '+data);*/
                            current_stock = parseInt(data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });
                    /*console.log('current_stock_box'+current_stock);*/
                    if(current_stock!=undefined)
                    {
                        
                        // var deducted_qty = current_stock-pre_qty;
                        var final_qty = current_stock+entered_qty;
                        console.log('current_stock'+current_stock+'pre qty'+entered_qty);
                        /*console.log(final_qty);*/
                        if(final_qty<0)
                        {
                            var id = 'qty_'+index;
                            var errors = {};
                            var name = $("#"+id).attr('name');
                            errors[name] = 'Stock Will be negative By '+final_qty;
                            validator.showErrors(errors);
                            valid = false;
                        }
                        else
                        {
                            delete_row(elem);
                        }

                        return valid;
                    }

                }
                else
                {
                    delete_row(elem);
                }
            }
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>