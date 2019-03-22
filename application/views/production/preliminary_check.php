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
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/production'; ?>" > Production List </a>  &nbsp; &#10095; &nbsp; Production Preliminary Check</div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">           
                    <div class="box-shadow">                            
                    <form id="form_preliminary_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($preliminary_details)) echo base_url(). 'index.php/production/preliminary_check/' . $preliminary_details[0]->id; else echo base_url().'index.php/production/preliminary_check'; ?>">
                        <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                            <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group" >
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Production Id <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($preliminary_details)) echo $preliminary_details[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="production_id" id="production_id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                            <input type="hidden" class="form-control" name="p_status" id="p_status" value="Confirmed"/>
                                            <input type="text" class="form-control" name="p_id" id="p_id" placeholder="Production Id" value="<?php if(isset($data)) echo $data[0]->p_id; else if(isset($p_id)) echo $p_id; ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">From Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="<?php if(isset($data)) echo (($data[0]->confirm_from_date!=null && $data[0]->confirm_from_date!='')?date('d/m/Y',strtotime($data[0]->confirm_from_date)):''); ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">To Date <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="to_date" id ="to_date" placeholder="To Date" value="<?php if(isset($data)) echo (($data[0]->confirm_to_date!=null && $data[0]->confirm_to_date!='')?date('d/m/Y',strtotime($data[0]->confirm_to_date)):''); ?>" readonly />
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
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">To <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="email_to" id="email_to" placeholder="To" value="<?php if(isset($preliminary_details)) echo $preliminary_details[0]->email_to; else if(isset($email_to)) echo $email_to; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Cc <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="email_cc" id="email_cc" placeholder="Cc" value="<?php if(isset($preliminary_details)) echo $preliminary_details[0]->email_cc;?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Bcc <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" class="form-control" name="email_bcc" id="email_bcc" placeholder="Bcc" value="<?php if(isset($preliminary_details)) echo $preliminary_details[0]->email_bcc; else echo 'rishit.sanghvi@eatanytime.in'; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Subject <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <?php 
                                                $confirm_from_date = '';
                                                if(isset($data)) { $confirm_from_date = (($data[0]->confirm_from_date!=null && $data[0]->confirm_from_date!='')?date('d/m/Y',strtotime($data[0]->confirm_from_date)):''); }
                                                $confirm_to_date = '';
                                                if(isset($data)) { $confirm_to_date = (($data[0]->confirm_to_date!=null && $data[0]->confirm_to_date!='')?date('d/m/Y',strtotime($data[0]->confirm_to_date)):''); }
                                                $subject = 'Preliminary Raw Material Confirmation - '.$confirm_from_date.' to '.$confirm_to_date.' - '.((isset($data[0]->p_id))?$data[0]->p_id:'');
                                            ?>
                                            <input type="text" class="form-control" name="email_subject" id="email_subject" placeholder="email_Subject" value="<?php if(isset($preliminary_details)) echo $preliminary_details[0]->email_subject; else echo $subject; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Body <span class="asterisk_sign">*</span></label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <?php 
                                                $login_name = $this->session->userdata('login_name');
                                                $confirm_from_date = '';
                                                if(isset($data)) { $confirm_from_date = (($data[0]->confirm_from_date!=null && $data[0]->confirm_from_date!='')?date('d/m/Y',strtotime($data[0]->confirm_from_date)):''); }
                                                $confirm_to_date = '';
                                                if(isset($data)) { $confirm_to_date = (($data[0]->confirm_to_date!=null && $data[0]->confirm_to_date!='')?date('d/m/Y',strtotime($data[0]->confirm_to_date)):''); }
                                                $body = 'I, '.ucwords(trim($login_name)).', 

Confirm that I have done the preliminary checking of the Raw Material Availability and propose the following shall be required to meet the next productions.
                                                        
Name of the Raw Material (Along with Kgs required):
1.
2.
3.
4.'; 
                                            ?>
                                            <textarea class="form-control" name="email_body" id="email_body" rows="12"><?php if(isset($preliminary_details)) echo $preliminary_details[0]->email_body; else echo $body; ?></textarea>
                                            <!-- <input type="text" class="form-control" name="email_body" id="email_body" placeholder="Body" value="<?php //if(isset($preliminary_details)) echo $preliminary_details[0]->email_body;?>" /> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="<?php if(isset($preliminary_details)) echo 'display: none;'; else echo 'display: none;';?>">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div style="<?php if(isset($preliminary_details)) echo ''; else echo 'display: none;';?>">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="status">
                                                    <option value="Approved" <?php if(isset($preliminary_details)) {if ($preliminary_details[0]->status=='Approved') echo 'selected';}?>>Active</option>
                                                    <option value="InActive" <?php if(isset($preliminary_details)) {if ($preliminary_details[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                        <div class="col-md-10  col-sm-10 col-xs-12">
                                            <textarea class="form-control" name="remarks"><?php if(isset($preliminary_details)) echo $preliminary_details[0]->remarks;?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <br clear="all"/>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a href="<?php echo base_url(); ?>index.php/dashboard" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
            });
        </script>
    </body>
</html>