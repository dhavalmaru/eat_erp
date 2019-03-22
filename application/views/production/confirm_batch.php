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
        <style>
            .form-control[disabled], .form-control[readonly] {
                color: #245478;
            }
        </style>
    </head>
    <body>
        <div class="page-container page-navigation-top">            
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/production'; ?>" > Production List </a>  &nbsp; &#10095; &nbsp; Confirm Production</div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">           
                    <div class="box-shadow">                            
                    <form id="form_confirm_batch" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/production/confirm_batch/' . $data[0]->id; ?>">
                        <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Production Id <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="p_status" id="p_status" value="Batch Confirmed"/>
                                            <input type="hidden" class="form-control" name="batch_rivision" id="batch_rivision" value="<?php if(isset($data)) { if($data[0]->p_status=='Batch Confirmed') { echo intval($data[0]->batch_rivision)+1; } else echo '0'; } else echo '0'; ?>"/>
                                            <input type="text" class="form-control" name="p_id" id="p_id" placeholder="Production Id" value="<?php if(isset($data)) echo $data[0]->p_id; else if(isset($p_id)) echo $p_id; ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Confirm From Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="confirm_from_date" id="confirm_from_date" placeholder="Confirm From Date" value="<?php if(isset($data)) echo (($data[0]->confirm_from_date!=null && $data[0]->confirm_from_date!='')?date('d/m/Y',strtotime($data[0]->confirm_from_date)):'');?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Confirm To Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="confirm_to_date" id ="confirm_to_date" placeholder="Confirm To Date" value="<?php if(isset($data)) echo (($data[0]->confirm_to_date!=null && $data[0]->confirm_to_date!='')?date('d/m/Y',strtotime($data[0]->confirm_to_date)):''); ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Manufacturer Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="manufacturer_name" id="manufacturer_name" placeholder="Manufacturer Name" value="<?php if(isset($data)) echo $data[0]->manufacturer_name; ?>" readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="h-scroll">  
                                    <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th>SKU Name <span class="asterisk_sign">*</span></th>
                                                <th>No Of Batches <span class="asterisk_sign">*</span></th>
                                                <th>No Of Bars <span class="asterisk_sign">*</span></th>
                                                <th class="table_action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="batch_details">
                                            <?php $i=0; if(isset($batch_items)) {
                                                for($i=0; $i<count($batch_items); $i++) { ?>
                                                <tr id="batch_<?php echo $i; ?>_row">
                                                    <td>
                                                        <select name="bar[]" class="form-control bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" onchange="get_bar_qty(this);">
                                                            <option value="">Select</option>
                                                            <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                    <option value="<?php echo $bar[$k]->id; ?>" <?php if($bar[$k]->id==$batch_items[$i]->bar_id) { echo 'selected'; } ?>><?php echo $bar[$k]->product_name; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <div id="err_item_<?php echo $i;?>"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($batch_items)) { echo $batch_items[$i]->qty; } ?>" onchange="get_bar_qty(this);" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control bar_qty" name="bar_qty[]" id="bar_qty_<?php echo $i; ?>" placeholder="Bar Qty" value="<?php if (isset($batch_items)) { echo $batch_items[$i]->bar_qty; } ?>" readonly />
                                                    </td>
                                                     <td class="table_action" style="text-align:center; vertical-align: middle;">
                                                        <?php 
                                                            $style = '';
                                                            if(isset($data[0]->freezed)){
                                                                if($data[0]->freezed==1){
                                                                    $style =  'display: none;';
                                                                }
                                                            } else {
                                                                $style =  'display: block;';
                                                            }
                                                        ?>

                                                        <a id="batch_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  style="<?=$style?>"></span></a>
                                                    </td>
                                                </tr>
                                            <?php }} else { ?>
                                                <tr id="batch_<?php echo $i; ?>_row">
                                                    <td>
                                                        <select name="bar[]" class="form-control bar" id="bar_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>" onchange="get_bar_qty(this);">
                                                            <option value="">Select</option>
                                                            <?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>
                                                                    <option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <div id="err_item_<?php echo $i;?>"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="" onchange="get_bar_qty(this);" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control bar_qty" name="bar_qty[]" id="bar_qty_<?php echo $i; ?>" placeholder="Bar Qty" value="" readonly />
                                                    </td>
                                                    <td class="table_action" style="text-align:center; vertical-align: middle;">
                                                        <?php 
                                                            $style = '';
                                                            if(isset($data[0]->freezed)) {
                                                                if($data[0]->freezed==1) {
                                                                    $style =  'display: none;';
                                                                }
                                                            } else {
                                                                $style =  'display: block;';
                                                            }
                                                        ?>

                                                        <a id="batch_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o" style="<?=$style?>"></span></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="12">
                                                    <button type="button" class="btn btn-success" id="repeat-batch">+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="form-group" style="<?php if(isset($data)) echo 'display: none;'; else echo 'display: none;';?>">
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
                                            <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->confirm_batch_remarks;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <br clear="all"/>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a href="<?php echo base_url(); ?>index.php/production" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                            <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Confirm</button>
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

                addMultiInputNamingRules('#form_confirm_batch', 'select[name="bar[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_confirm_batch', 'input[name="qty[]"]', { required: true }, "");
            });
            jQuery(function(){
                var counter = $('.bar').length;
                
                $('#repeat-batch').click(function(event){
                    event.preventDefault();
                    //$('#batch_details').remove(newRow1);
                    var newRow = jQuery('<tr id="batch_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<select name="bar[]" class="form-control bar" id="bar_'+counter+'" data-error="#err_item_'+counter+'" onchange="get_bar_qty(this);">' + 
                                                    '<option value="">Select</option>' + 
                                                    '<?php if(isset($bar)) { for ($k=0; $k < count($bar) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $bar[$k]->id; ?>"><?php echo $bar[$k]->product_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_item_'+counter+'"></div>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="" onchange="get_bar_qty(this);" />' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control bar_qty" name="bar_qty[]" id="bar_qty_'+counter+'" placeholder="Bar Qty" value="" readonly />' + 
                                            '</td>' + 
                                            '<td style="text-align:center;">' + 
                                                '<a id="batch_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#batch_details').append(newRow);
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    counter++;
                });
            });
            var get_bar_qty = function(elem){
                var elem_id = elem.id;
                var index = elem_id.substring(elem_id.lastIndexOf('_')+1);
                // console.log(index);

                $.ajax({
                    url:BASE_URL+'index.php/production/get_total_bar_qty',
                    method: 'post',
                    data: {product_id: $('#bar_'+index).val()},
                    dataType: 'json',
                    async: false,
                    success: function(response){
                        var bar_qty = parseInt(response.bar_qty);
                        var qty = parseInt($('#qty_'+index).val());
                        // console.log(bar_qty);
                        // console.log(qty);
                        if(isNaN(bar_qty) || isNaN(qty)){
                            $('#bar_qty_'+index).val(0);
                        } else {
                            $('#bar_qty_'+index).val(bar_qty*qty);
                        }
                    }
                });
            }
        </script>
    </body>
</html>