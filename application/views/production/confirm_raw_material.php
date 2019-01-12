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
                    <form id="form_confirm_raw_material" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/production/confirm_raw_material/' . $data[0]->id; ?>">
                        <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Production Id <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="p_status" id="p_status" value="Raw Material Confirmed"/>
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
                                                <th>Raw Material <span class="asterisk_sign">*</span></th>
                                                <th>Required Qty <span class="asterisk_sign">*</span></th>
                                                <th>Available Qty <span class="asterisk_sign">*</span></th>
                                                <th>Difference Qty <span class="asterisk_sign">*</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="raw_material_details">
                                            <?php 
                                                $bl_confirm=true;
                                                $i=0; 
                                                if(isset($raw_material_items)) {
                                                for($i=0; $i<count($raw_material_items); $i++) { 
                                                    if ($raw_material_items[$i]->difference_qty<0) { $bl_confirm=false; }
                                            ?>
                                                <tr id="raw_material_<?php echo $i; ?>_row">
                                                    <td>
                                                        <input type="hidden" class="form-control raw_material" name="raw_material[]" id="raw_material_<?php echo $i;?>" value="<?php if (isset($raw_material_items)) { echo $raw_material_items[$i]->rm_id; } ?>" />
                                                        <select class="form-control" data-error="#err_item_<?php echo $i;?>" disabled >
                                                            <option value="">Select</option>
                                                            <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                    <option value="<?php echo $raw_material[$k]->id; ?>" <?php if($raw_material[$k]->id==$raw_material_items[$i]->rm_id) { echo 'selected'; } ?>><?php echo $raw_material[$k]->rm_name; ?></option>
                                                            <?php }} ?>
                                                        </select>
                                                        <div id="err_item_<?php echo $i;?>"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control required_qty" name="required_qty[]" id="required_qty_<?php echo $i; ?>" placeholder="Required Qty" value="<?php if (isset($raw_material_items)) { echo $raw_material_items[$i]->required_qty; } ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control available_qty" name="available_qty[]" id="available_qty_<?php echo $i; ?>" placeholder="Available Qty" value="<?php if (isset($raw_material_items)) { echo $raw_material_items[$i]->available_qty; } ?>" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control difference_qty" name="difference_qty[]" id="difference_qty_<?php echo $i; ?>" placeholder="Difference Qty" value="<?php if (isset($raw_material_items)) { echo $raw_material_items[$i]->difference_qty; } ?>" readonly />
                                                    </td>
                                                </tr>
                                            <?php }} ?>
                                        </tbody>
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
                                            <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks; ?></textarea>
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
                            <button class="btn btn-success pull-right" style="<?php if($bl_confirm==false) echo 'display: none;'; else if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Confirm</button>
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
                addMultiInputNamingRules('#form_confirm_raw_material', 'select[name="raw_material[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_confirm_raw_material', 'input[name="required_qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_confirm_raw_material', 'input[name="available_qty[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_confirm_raw_material', 'input[name="difference_qty[]"]', { required: true }, "");
            });
        </script>
    </body>
</html>