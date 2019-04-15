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
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/beat_allocation'; ?>" > Assign List </a>  &nbsp; &#10095; &nbsp; Assign Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">
                        <div class="box-shadow">
                            <form id="form_beat_allocation" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/beat_allocation/update/' . $data[0]->sales_rep_id; else echo base_url().'index.php/beat_allocation/save'; ?>">
                                <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default">
								<div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Type</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12" >
                                                <select name="type_id" id="type_id" class="form-control select2" data-error="#err_type_id" onchange="set_beat_plan_all();">
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
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Sales Representative</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12" >
                                                <select name="sales_rep_id" id="sales_rep_id" class="form-control select2" data-error="#err_sales_rep_id">
                                                    <option value="">Select</option>
                                                    <?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
                                                        <option value="<?php echo $sales_rep[$k]->id; ?>" <?php if (isset($data)) { if($sales_rep[$k]->id==$data[0]->sales_rep_id) { echo 'selected'; } } ?>><?php echo ucwords(trim(strtolower($sales_rep[$k]->sales_rep_name))); ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_sales_rep_id" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php for($i=0; $i<count($allocations); $i++) { ?>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="hidden" class="form-control" name="weekday_id[]" id="weekday_id_<?php echo $i; ?>" value="<?php if(isset($allocations)) echo $allocations[$i]->id;?>" />
                                            <input type="hidden" class="form-control" name="weekday[]" id="weekday_<?php echo $i; ?>" value="<?php if(isset($allocations)) echo $allocations[$i]->weekday;?>" />
                                            <div class="col-md-2 col-sm-2 col-xs-12" style="font-weight: bold;"><?php if(isset($allocations)) echo $allocations[$i]->weekday;?></div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Frequency</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="frequency[]" id="frequency_<?php echo $i; ?>" class="form-control select2" data-error="#err_frequency_<?php echo $i; ?>" onchange="set_frequency(this);">
                                                    <option value="">Select</option>
                                                    <option value="Alternate" <?php if (isset($allocations)) { if($allocations[$i]->frequency=='Alternate') { echo 'selected'; } } ?>>Alternate</option>
                                                    <option value="Every" <?php if (isset($allocations)) { if($allocations[$i]->frequency=='Every') { echo 'selected'; } } ?>>Every</option>
                                                </select>
                                                <div id="err_frequency_<?php echo $i; ?>" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" id="frq1_div_<?php echo $i; ?>">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="dist_id1[]" id="dist_id1_<?php echo $i; ?>" class="form-control select2" data-error="#err_dist_id1_<?php echo $i; ?>" onchange="get_beat_plan(this);">
                                                    <option value="">Select</option>
                                                    <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if (isset($allocations)) { if($distributor[$k]->id==$allocations[$i]->dist_id1) { echo 'selected'; } } ?>><?php echo ucwords(trim(strtolower($distributor[$k]->distributor_name))); ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_dist_id1_<?php echo $i; ?>" style="margin-top: 15px;"></div>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Beat Plan</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="beat_id1[]" id="beat_id1_<?php echo $i; ?>" class="form-control select2" data-error="#err_beat_id1_<?php echo $i; ?>">
                                                    <option value="">Select</option>
                                                    <?php if(isset($beat_plan)) { for ($k=0; $k < count($beat_plan) ; $k++) { ?>
                                                        <option value="<?php echo $beat_plan[$k]->id; ?>" <?php if (isset($allocations)) { if($beat_plan[$k]->id==$allocations[$i]->beat_id1) { echo 'selected'; } } ?>><?php echo $beat_plan[$k]->beat_id.' - '.ucwords(trim(strtolower($beat_plan[$k]->beat_name))); ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_beat_id1_<?php echo $i; ?>" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" id="frq2_div_<?php echo $i; ?>">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Distributor</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="dist_id2[]" id="dist_id2_<?php echo $i; ?>" class="form-control select2" data-error="#err_dist_id2_<?php echo $i; ?>" onchange="get_beat_plan(this);">
                                                    <option value="">Select</option>
                                                    <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                        <option value="<?php echo $distributor[$k]->id; ?>" <?php if (isset($allocations)) { if($distributor[$k]->id==$allocations[$i]->dist_id2) { echo 'selected'; } } ?>><?php echo ucwords(trim(strtolower($distributor[$k]->distributor_name))); ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_dist_id2_<?php echo $i; ?>" style="margin-top: 15px;"></div>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Beat Plan</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="beat_id2[]" id="beat_id2_<?php echo $i; ?>" class="form-control select2" data-error="#err_beat_id2_<?php echo $i; ?>">
                                                    <option value="">Select</option>
                                                    <?php if(isset($beat_plan)) { for ($k=0; $k < count($beat_plan) ; $k++) { ?>
                                                        <option value="<?php echo $beat_plan[$k]->id; ?>" <?php if (isset($allocations)) { if($beat_plan[$k]->id==$allocations[$i]->beat_id2) { echo 'selected'; } } ?>><?php echo $beat_plan[$k]->beat_id.' - '.ucwords(trim(strtolower($beat_plan[$k]->beat_name))); ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <div id="err_beat_id2_<?php echo $i; ?>" style="margin-top: 15px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

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
                                    <a href="<?php echo base_url(); ?>index.php/beat_allocation" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
            $(document).ready(function(){
                set_beat_plan_all();
                
                addMultiInputNamingRules('#form_beat_allocation', 'input[name="weekday_id[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_beat_allocation', 'input[name="weekday[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_beat_allocation', 'select[name="frequency[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_beat_allocation', 'select[name="dist_id1[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_beat_allocation', 'select[name="beat_id1[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_beat_allocation', 'select[name="dist_id2[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_beat_allocation', 'select[name="beat_id2[]"]', { required: true }, "");
            });

            var set_beat_plan_all = function() {
                set_frequency(document.getElementById('frequency_0'));
                set_frequency(document.getElementById('frequency_1'));
                set_frequency(document.getElementById('frequency_2'));
                set_frequency(document.getElementById('frequency_3'));
                set_frequency(document.getElementById('frequency_4'));
                set_frequency(document.getElementById('frequency_5'));

                get_beat_plan(document.getElementById('dist_id1_0'));
                get_beat_plan(document.getElementById('dist_id1_1'));
                get_beat_plan(document.getElementById('dist_id1_2'));
                get_beat_plan(document.getElementById('dist_id1_3'));
                get_beat_plan(document.getElementById('dist_id1_4'));
                get_beat_plan(document.getElementById('dist_id1_5'));

                get_beat_plan(document.getElementById('dist_id2_0'));
                get_beat_plan(document.getElementById('dist_id2_1'));
                get_beat_plan(document.getElementById('dist_id2_2'));
                get_beat_plan(document.getElementById('dist_id2_3'));
                get_beat_plan(document.getElementById('dist_id2_4'));
                get_beat_plan(document.getElementById('dist_id2_5'));
            }

            var set_frequency = function(elem) {
                var id = elem.id;
                var index = id.substring(id.lastIndexOf('_')+1);
                var elm_val = elem.value;

                // console.log(index);
                // console.log(elm_val);
                // console.log('frq2_div_'+index);

                if(elm_val=='Alternate'){
                    $('#frq2_div_'+index).show();
                } else {
                    $('#frq2_div_'+index).hide();
                }
            }

            var get_beat_plan = function(elem) {
                var id = elem.id;
                var index = id.substring(id.lastIndexOf('_')+1);
                var elm_val = elem.value;
                var substr = id.substring(0, id.lastIndexOf('_'));
                var index2 = substr.substring(substr.length-1);

                // console.log(index);
                // console.log(substr);
                // console.log(index2);

                $.ajax({
                    url:BASE_URL+'index.php/beat_allocation/get_beat_plan',
                    method: 'post',
                    data: {distributor_id: elm_val, type_id: $('#type_id').val()},
                    dataType: 'json',
                    async: false,
                    success: function(response){
                        var beat_id_id = 'beat_id'+index2+'_'+index;
                        var beat_id_val = $('#'+beat_id_id).val();
                        $('#'+beat_id_id).find('option').not(':first').remove();

                        $.each(response,function(index,data){
                            $('#'+beat_id_id).append('<option value="'+data['id']+'" '+((data['id']==beat_id_val)?'selected':'')+'>'+data['beat_id']+' - '+data['beat_name']+'</option>');
                        });
                    }
                });
            }
        </script>
    </body>
</html>