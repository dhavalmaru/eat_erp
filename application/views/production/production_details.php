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
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/production'; ?>" > Production List </a>  &nbsp; &#10095; &nbsp; Request For Production</div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">           
                    <div class="box-shadow">                            
                    <form id="form_production_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/production/update/' . $data[0]->id; else echo base_url().'index.php/production/save'; ?>">
                        <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Production Id <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="p_status" id="p_status" value="<?php if(isset($data)) echo $data[0]->p_status; else echo 'Requested'; ?>"/>
                                            <input type="text" class="form-control" name="p_id" id="p_id" placeholder="Production Id" value="<?php if(isset($data)) echo $data[0]->p_id; else if(isset($p_id)) echo $p_id; ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">From Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control datepicker" name="from_date" id="from_date" placeholder="From Date" value="<?php if(isset($data)) echo (($data[0]->from_date!=null && $data[0]->from_date!='')?date('d/m/Y',strtotime($data[0]->from_date)):'');?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">To Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control datepicker" name="to_date" id ="to_date" placeholder="To Date" value="<?php if(isset($data)) echo (($data[0]->to_date!=null && $data[0]->to_date!='')?date('d/m/Y',strtotime($data[0]->to_date)):''); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Manufacturer Name <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <select name="manufacturer_id" id="manufacturer_id" class="form-control select2">
                                                <option value="">Select</option>
                                                <?php if(isset($depot)) { for ($k=0; $k<count($depot); $k++) { ?>
                                                    <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->manufacturer_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
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
                                            <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->request_remarks;?></textarea>
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
                            <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
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
            });
        </script>
    </body>
</html>