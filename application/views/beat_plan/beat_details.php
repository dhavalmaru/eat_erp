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
            .form-control[readonly] {
                color: #245478;
                background-color: white;
            }
        </style>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">
            <!-- PAGE CONTENT -->
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/beat_master'; ?>" > Beat List </a>  &nbsp; &#10095; &nbsp; Beat Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">
                        <div class="box-shadow">
                            <form id="form_beat_master" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/beat_master/update/' . $data[0]->id; else echo base_url().'index.php/beat_master/save'; ?>">
                                <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default">
								<div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Beat ID <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control" name="beat_id" id="beat_id" placeholder="Beat ID" value="<?php if(isset($data)) echo $data[0]->beat_id; else if(isset($beat_id)) echo $beat_id; ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Beat Name <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="beat_name" id="beat_name" placeholder="Beat Name" value="<?php if(isset($data)) echo $data[0]->beat_name; ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12" >
                                                <select name="type_id" id="type_id" class="form-control select2" data-error="#err_type_id" onchange="get_zone();">
                                                    <option value="">Select</option>
                                                    <?php if(isset($type)) { for ($k=0; $k < count($type) ; $k++) { ?>
                                                        <option value="<?php echo $type[$k]->id; ?>" <?php if (isset($data)) { if($type[$k]->id==$data[0]->type_id) { echo 'selected'; } } ?>><?php echo $type[$k]->distributor_type; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_type_id" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="zone_id" id="zone_id" class="form-control select2" data-error="#err_zone_id" onchange="get_area(); get_store();">
                                                    <option value="">Select</option>
                                                    <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                        <option value="<?php echo $zone[$k]->id; ?>" <?php if (isset($data)) { if($zone[$k]->id==$data[0]->zone_id) { echo 'selected'; } } ?>><?php echo $zone[$k]->zone; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_zone_id" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group" style="display: none;">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Area</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="area_id" id="area_id" class="form-control select2" data-error="#err_area_id" onchange="get_location();">
                                                    <option value="">Select</option>
                                                    <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                                        <option value="<?php echo $area[$k]->id; ?>" <?php if (isset($data)) { if($area[$k]->id==$data[0]->area_id) { echo 'selected'; } } ?>><?php echo $area[$k]->area; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_area_id" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Store</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="store_id" id="store_id" class="form-control select2" data-error="#err_store_id" onchange="get_location();">
                                                    <option value="">Select</option>
                                                    <?php if(isset($store)) { for ($k=0; $k < count($store) ; $k++) { ?>
                                                        <option value="<?php echo $store[$k]->id; ?>" <?php if (isset($data)) { if($store[$k]->id==$data[0]->store_id) { echo 'selected'; } } ?>><?php echo $store[$k]->store_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_store_id" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Location <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="location_id[]" id="location_id" class="form-control select2" data-error="#err_location_id" multiple>
                                                    <option value="">Select</option>
                                                    <?php 
                                                        $location_id=array(); 
                                                        if(isset($data)) { 
                                                            if($data[0]->location_id!='' && $data[0]->location_id!=null) 
                                                                $location_id=explode(',', $data[0]->location_id); 
                                                        } 
                                                    ?>
                                                    <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                        <option value="<?php echo $location[$k]->id; ?>" <?php if (count($location_id)>0) { if(in_array($location[$k]->id, $location_id)) { echo 'selected'; } } ?>><?php echo $location[$k]->location; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_location_id" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"  >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-md-6 col-sm-6 col-xs-12 text-center">
                                                <button type="button" class="btn btn-default" onclick="get_retailer();">Get Retailer</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="h-scroll">  
                                    <div class="table-stripped form-group" style="padding:15px;" >
                                        <table class="table table-bordered" style="margin-bottom: 0px; ">
                                            <thead>
                                                <tr>
                                                    <th>Select</th>
                                                    <th width="500">Retailer</th>
                                                    <th>No Of Beats Assigned</th>
                                                    <th style="display: none;">Sequence</th>
                                                </tr>
                                            </thead>
                                            <tbody id="beat_details">
                                                <?php if(isset($beat_details)) { for ($i=0; $i <count($beat_details) ; $i++) { ?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="form-control" id="is_selected_<?=$i?>" value="1" onchange="set_is_selected(this);" <?php if($beat_details[$i]->is_selected==1) echo 'checked'; ?> />
                                                            <input type="hidden" class="form-control" name="is_selected[]" id="is_selected_val_<?=$i?>" value="<?=$beat_details[$i]->is_selected;?>" />
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="form-control" name="distributor_id[]" id="distributor_id_<?=$i?>" value="<?=$beat_details[$i]->id?>" />
                                                            <input type="text" class="form-control" name="distributor_name[]" id="distributor_name_<?=$i?>" value="<?=$beat_details[$i]->distributor_name?>" tabindex="-1" readonly />
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="no_of_beat[]" id="no_of_beat_<?=$i?>" placeholder="No Of Beats Assigned" value="<?php if(isset($beat_details[$i]->no_of_beat)) echo $beat_details[$i]->no_of_beat; ?>" tabindex="-1" readonly />
                                                        </td>
                                                        <td style="display: none;">
                                                            <input type="text" class="form-control" name="sequence[]" id="sequence_<?=$i?>" placeholder="Sequnce" value="<?php if(isset($beat_details[$i]->sequence)) echo $beat_details[$i]->sequence; ?>" onkeypress="return StopNonNumeric(this,event)"/>
                                                        </td>
                                                    </tr>
                                                <?php }} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>

									<div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
											<div>
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
                                <div class="panel-footer">
                                    <a href="<?php echo base_url(); ?>index.php/beat_master" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
                                </div>
								<br clear="all"/>
								</div>
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
        <script type='text/javascript'>
            var get_zone = function() {
                $.ajax({
                    url:BASE_URL+'index.php/beat_master/get_zone',
                    method: 'post',
                    data: {type_id: $('#type_id').val()},
                    dataType: 'json',
                    async: false,
                    success: function(response){
                        $('#zone_id').find('option').not(':first').remove();

                        $.each(response,function(index,data){
                            $('#zone_id').append('<option value="'+data['id']+'">'+data['zone']+'</option>');
                        });
                    }
                });

                get_location();
            }

            var get_area = function() {
                $.ajax({
                    url:BASE_URL+'index.php/beat_master/get_area',
                    method: 'post',
                    data: {type_id: $('#type_id').val(), zone_id: $('#zone_id').val()},
                    dataType: 'json',
                    async: false,
                    success: function(response){
                        $('#area_id').find('option').not(':first').remove();

                        $.each(response,function(index,data){
                            $('#area_id').append('<option value="'+data['id']+'">'+data['area']+'</option>');
                        });
                    }
                });

                get_location();
            }

            var get_store = function() {
                $.ajax({
                    url:BASE_URL+'index.php/beat_master/get_store',
                    method: 'post',
                    data: {type_id: $('#type_id').val(), zone_id: $('#zone_id').val()},
                    dataType: 'json',
                    async: false,
                    success: function(response){
                        $('#store_id').find('option').not(':first').remove();

                        $.each(response,function(index,data){
                            $('#store_id').append('<option value="'+data['id']+'">'+data['store_name']+'</option>');
                        });
                    }
                });

                get_location();
            }

            var get_location = function() {
                $.ajax({
                    url:BASE_URL+'index.php/beat_master/get_location',
                    method: 'post',
                    data: {type_id: $('#type_id').val(), zone_id: $('#zone_id').val(), area_id: $('#area_id').val()},
                    dataType: 'json',
                    async: false,
                    success: function(response){
                        $('#location_id').find('option').not(':first').remove();

                        $.each(response,function(index,data){
                            $('#location_id').append('<option value="'+data['id']+'">'+data['location']+'</option>');
                        });
                    }
                });

                get_retailer();
            }

            var get_retailer = function() {
                var location_id = $('#location_id').val();
                if(location_id==null){
                    $('#beat_details').find('tr').remove();
                    $('#form_beat_master').valid();
                } else {
                    $.ajax({
                        url:BASE_URL+'index.php/beat_master/get_retailer',
                        method: 'post',
                        data: {id: $('#id').val(), type_id: $('#type_id').val(), zone_id: $('#zone_id').val(), area_id: $('#area_id').val(), location_id: $('#location_id').val()},
                        dataType: 'json',
                        async: false,
                        success: function(response){
                            $('#beat_details').find('tr').remove();

                            // console.log($('#type_id').val());
                            // console.log($('#zone_id').val());
                            // console.log($('#area_id').val());
                            // console.log($('#location_id').val());

                            var tr = '';
                            var cnt = 0;

                            $.each(response,function(index,data){
                                tr = '<tr>'+
                                        '<td>'+
                                            '<input type="checkbox" class="form-control" id="is_selected_'+cnt+'" value="1" onchange="set_is_selected(this);" '+((data['is_selected']=="1")?"checked":"")+' />'+
                                            '<input type="hidden" class="form-control" name="is_selected[]" id="is_selected_val_'+cnt+'" value="'+data['is_selected']+'" />'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="hidden" class="form-control" name="distributor_id[]" id="distributor_id_'+cnt+'" value="'+data['id']+'" />'+
                                            '<input type="text" class="form-control" name="distributor_name[]" id="distributor_name_'+cnt+'" value="'+data['distributor_name']+'" tabindex="-1" readonly />'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" class="form-control" name="no_of_beat[]" id="no_of_beat_'+cnt+'" placeholder="No Of Beats Assigned" value="'+data['no_of_beat']+'" tabindex="-1" readonly />'+
                                        '</td>'+
                                        '<td style="display: none;">'+
                                            '<input type="text" class="form-control" name="sequence[]" id="sequence_'+cnt+'" placeholder="Sequnce" value="'+data['sequence']+'" onkeypress="return StopNonNumeric(this,event)" />'+
                                        '</td>'+
                                    '</tr>';
                                $('#beat_details').append(tr);

                                cnt = cnt + 1;
                            });
                        }
                    });
                }
            }

            var set_is_selected = function(elem) {
                var id = elem.id;
                var index = id.substring(id.lastIndexOf('_')+1);
                var no_of_beat = parseInt($('#no_of_beat_'+index).val());
                if(isNaN(no_of_beat)) no_of_beat = 0;

                if(elem.checked==true){
                    $('#is_selected_val_'+index).val('1');
                    $('#no_of_beat_'+index).val(no_of_beat+1);
                } else {
                    $('#is_selected_val_'+index).val('0');
                    $('#no_of_beat_'+index).val(no_of_beat-1);
                }
            }
        </script>
    </body>
</html>