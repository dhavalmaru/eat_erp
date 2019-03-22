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
		<!-- <link rel="stylesheet" type="text/css" id="theme" href="<?php //echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php //echo base_url().'css/custome_vj_css.css'; ?>"/> -->
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->

        <style>	
            .design-process-section .text-align-center {
                line-height: 25px;
                margin-bottom: 12px;
            }
            .design-process-content {
                border: 1px solid #e9e9e9;
                position: relative;
                /*padding: 16px 34% 30px 30px;*/
            }
            .design-process-content img {
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                z-index: 0;
                max-height: 100%;
            }
            .design-process-content h3 {
                margin-bottom: 16px;
            }
            .design-process-content p {
                line-height: 26px;
                margin-bottom: 12px;
            }
            .process-model {
                list-style: none;
                padding: 0;
                position: relative;
                max-width: 640px;;
                margin: 20px auto 26px;
                border: none;
                z-index: 0;
            }
            .process-model li::after {
                background: #e5e5e5 none repeat scroll 0 0;
                bottom: 0;
                content: "";
                display: block;
                height: 4px;
                margin: 0 auto;
                position: absolute;
                right: -30px;
                top: 33px;
                width: 85%;
                z-index: -1;
            }
            .process-model li.visited::after {
                background: #245478;
            }
            .process-model li:last-child::after {
                width: 0;
            }
            .process-model li {
                display: inline-block;
                width: 15%;
                text-align: center;
                float: none;
            }
            .nav-tabs.process-model > li.active > a, .nav-tabs.process-model > li.active > a:hover, .nav-tabs.process-model > li.active > a:focus, .process-model li a:hover, .process-model li a:focus {
                border: none;
                background: transparent;

            }
            .process-model li a {
                padding: 0;
                border: none;
                color: #606060;
            }
            .process-model li.active,
            .process-model li.visited {
                color: #245478;
            }
            .process-model li.active a,
            .process-model li.active a:hover,
            .process-model li.active a:focus,
            .process-model li.visited a,
            .process-model li.visited a:hover,
            .process-model li.visited a:focus {
                color: #245478;
            }
            .process-model li.active p,
            .process-model li.visited p {
                font-weight: 600;
            }
            .process-model li i {
                display: block;
                height: 68px;
                width: 68px;
                text-align: center;
                margin: 0 auto;
                background: #f5f6f7;
                border: 2px solid #e5e5e5;
                line-height: 65px;
                font-size: 30px;
                border-radius: 50%;
            }
            .process-model li.active i, .process-model li.visited i  {
                background: #245478;
                border-color: #245478;
                color:#fff
            }
            .process-model li p {
                font-size: 14px;
                margin-top: 11px;
            }
            .process-model.contact-us-tab li.visited a, .process-model.contact-us-tab li.visited p {
                color: #606060!important;
                font-weight: normal
            }
            .process-model.contact-us-tab li::after  {
                display: none; 
            }
            .process-model.contact-us-tab li.visited i {
                border-color: #e5e5e5; 
            }
            @media screen and (max-width: 560px) {
                .more-icon-preocess.process-model li span {
                    font-size: 23px;
                    height: 50px;
                    line-height: 46px;
                    width: 50px;
                }
                .more-icon-preocess.process-model li::after {
                    top: 24px;
                }
            }
            @media screen and (max-width: 380px) { 
                .process-model.more-icon-preocess li {
                    width: 16%;
                }
                .more-icon-preocess.process-model li span {
                    font-size: 16px;
                    height: 35px;
                    line-height: 32px;
                    width: 35px;
                }
                .more-icon-preocess.process-model li p {
                    font-size: 8px;
                }
                .more-icon-preocess.process-model li::after {
                    top: 18px;
                }
                .process-model.more-icon-preocess {
                    text-align: center;
                }
            }
            .nav-tabs > li > a
            {
                background:none!important;
            }
            table thead tr th
            {
                vertical-align:middle!important;
            }
        </style>		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h3"> 
                    <div class="heading-h3-heading"> <a href="<?php echo base_url().'index.php/dashboard'; ?>" > </a></div>						 
                    <div class="heading-h3-heading">
                        <div class="pull-right btn-margin">
                        </div>
                    </div>	      
                </div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">
                    <div class="box-shadow">
					<!-- <div class="panel-body"> -->
                        <section class="design-process-section" id="process-tab">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <input type="hidden" id="production_id" name="production_id" value="<?php if(isset($production_id)) echo $production_id; ?>" />
                                        <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
                                            <li role="presentation" class="active">
                                                <a href="#batch_master" aria-controls="batch_master" role="tab" data-toggle="tab" onClick="get_tab_details('batch_master');">
                                                    <i class="fa fa-database" aria-hidden="true"></i>
                                                    <p>Batch Master</p>
                                                </a>
                                            </li>
                                            <li role="presentation" class="">
                                                <a href="#discover" aria-controls="discover" role="tab" data-toggle="tab">
                                                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                                                    <p>Production Details</p>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab">
                                                    <i class="fa fa-send-o" aria-hidden="true"></i>
                                                    <p>Bar Conversion</p>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab">
                                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                                    <p>Depot &nbsp Transfer</p>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#content" aria-controls="content" role="tab" data-toggle="tab">
                                                    <i class="fa fa-file" aria-hidden="true"></i>
                                                    <p>Documents Upload</p>
                                                </a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#reporting" aria-controls="reporting" role="tab" data-toggle="tab">
                                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                    <p>Raw Material Recon</p>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="batch_master">
                                                <div class="design-process-content">
                                                    
                                                    <form id="form_batch_master_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/batch_master/update/' . $data[0]->id; else echo base_url().'index.php/batch_master/save'; ?>" enctype="multipart/form-data" >
                                                    <div class="box-shadow-inside">
                                                    <div class="col-md-12 custom-padding" style="padding:0;" >
                                                        <h3 class="semi-bold">Batch Master</h3>
                                                        <div class="panel panel-default">

                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                                        <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                                        <input type="text" class="form-control datepicker" name="date_of_processing" id="date_of_processing" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group"  >
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Batch No <span class="asterisk_sign">*</span></label>
                                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                                        <input type="text" class="form-control" name="batch_no" id="batch_no" placeholder="Batch No" value="<?php if(isset($data)) echo $data[0]->batch_no;?>"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                                        <select class="form-control" name="status">
                                                                            <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Active</option>
                                                                            <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="h-scroll">  
                                                                <div class="table-stripped form-group" style="padding:15px;">
                                                                    <table class="table table-bordered" style="margin-bottom: 0px; ">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Document Title</th>
                                                                            <th>Upload Files</th>
                                                                            <th width="75">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="batch_doc_details">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title_<?php echo $i; ?>" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="receivable_doc[]" value="<?php if(isset($batch_doc)) {echo $batch_doc[$i]->receivable_doc;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="image_path[]" value="<?php if(isset($batch_doc)) {echo $batch_doc[$i]->doc_img;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image"/>
                                                                                </div>
                                                                                <?php if(isset($batch_doc)) {if($batch_doc[$i]->doc_img!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" id="batch_doc_file_download<?php echo $i; ?>" href="<?php echo base_url().$batch_doc[$i]->doc_img; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                           <td style="text-align:center;  vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title_<?php echo $i; ?>" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;     vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_batch_docs" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
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
                                                            <a href="<?php echo base_url(); ?>index.php/batch_master" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                                            <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                                        </div>

                                                        </div>
                                                    </div>
                                                    </div>
                                                    </form>

                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane " id="discover">
                                                <div class="design-process-content">
                                                    <h3 class="semi-bold">Discovery</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat</p>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="strategy">
                                                <div class="design-process-content">
                                                    <h3 class="semi-bold">Strategy</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat</p>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="optimization">
                                                <div class="design-process-content">
                                                    <h3 class="semi-bold">Optimization</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat</p>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="content">
                                                <div class="design-process-content">
                                                    <div class="page-content-wrap">                
                                                        <div class="row main-wrapper">					
                                                            <div class="main-container">           
                                                                <div class="box-shadow">
                                                                    <form id="form_bank" role="form" class="form-horizontal" method="post" action="https://www.pecanreams.com/app/index.php/bank/savebank">
                                                                        <div class="box-shadow-inside">
                                                                            <div class="col-md-12" >
                                                                                <div class="panel panel-default border-none">
                                                                                    <div id="form_errors" style="display:none; color:#E04B4A; padding-left:20px;" class="error"></div>
                                                                                    <div class="panel-heading">
                                                                                        <h3 class="panel-title" style="text-align: center; float: initial;"><strong>Bank Details</strong></h3>
                                                                                    </div>
                                                                                    <div class="panel-body">
                                                                                        <div class="" style="border-top:none; ">
                                                                                            <div class="form-group" style="border:none; ">
                                                                                                <div class="col-md-6 col-sm-4 col-xs-6">
                                                                                                    <div class="">
                                                                                                        <label class="col-md-3 control-label">Owner <span class="asterisk_sign">*</span></label>
                                                                                                        <div class="col-md-9">
                                                                                                            <input type="hidden" id="owner_name_id" name="owner_name" data-error="#owner_error" class="form-control" value="" />
                                                                                                            <input type="text" id="owner_name" name="owner_contact_name" class="form-control auto_non_legal_contact_owner" value="" placeholder="Type to choose owner from database..." />
                                                                                                            <div id="owner_error"></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6  col-sm-4 col-xs-6">
                                                                                                    <div class="">
                                                                                                        <label class="col-md-3 control-label">Reg Address</label>
                                                                                                        <div class="col-md-9">
                                                                                                            <input type="text" class="form-control" name="registered_address" placeholder="Registered Address" value="" />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group" style="border:none; ">
                                                                                                <div class="col-md-6">
                                                                                                    <div class="">
                                                                                                        <label class="col-md-3 control-label">Reg Phone</label>
                                                                                                        <div class="col-md-9">
                                                                                                            <input type="text" class="form-control" name="registered_phone" placeholder="Registered Phone" value="" />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <div class="">
                                                                                                        <label class="col-md-3 control-label">Reg Email</label>
                                                                                                        <div class="col-md-9">
                                                                                                            <input type="text" class="form-control" name="registered_email" placeholder="Registered Email" value="" />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="panel-body panel-group accordion">
                                                                                            <div class="panel  panel-primary" id="panel-bank-details">
                                                                                                <a href="#accOneColOne">   
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>  Bank Details
                                                                                                        </h4>
                                                                                                    </div>   
                                                                                                </a>
                                                                                                <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                                                                                    <div class="form-group" style="border-top:1px solid #ddd; padding-top:10px;">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Bank Name <span class="asterisk_sign">*</span></label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="bank_name" placeholder="Bank Name" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Bank Branch <span class="asterisk_sign">*</span></label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="bank_branch" placeholder="Bank Branch" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Bank Address <span class="asterisk_sign">*</span></label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="bank_address" placeholder="Bank Address" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label" style="padding-left: 0px; padding-right: 5px;">Bank Landmark</label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="bank_landmark" placeholder="Bank Landmark" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Bank City</label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="hidden" name="bank_city_id" id="bank_add_city_id" />
                                                                                                                    <input type="text" class="form-control autocompleteCity" name="bank_city" id ="bank_add_city" placeholder="Bank City" value=""/>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Bank Pincode</label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="bank_pincode" id ="bank_add_pincode" placeholder="Bank Pincode" value=""/>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Bank State</label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="hidden" name="bank_state_id" id="bank_add_state_id" />
                                                                                                                    <input type="text" class="form-control loadstatedropdown" name="bank_state" id ="bank_add_state" placeholder="Bank State" value=""/>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Bank Country</label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="hidden" name="bank_country_id" id="bank_add_country_id" />
                                                                                                                    <input type="text" class="form-control loadcountrydropdown" name="bank_country" id ="bank_add_country" placeholder="Bank Country" value=""/>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Account Type <span class="asterisk_sign">*</span></label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <select class="form-control" name="account_type">
                                                                                                                        <option value="">Select</option>
                                                                                                                        <option value="Savings" >Savings</option>
                                                                                                                        <option value="Current" >Current</option>
                                                                                                                        <option value="Overdraft" >Overdraft</option>
                                                                                                                        <option value="Loan" >Loan</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Account No. <span class="asterisk_sign">*</span></label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="account_no" placeholder="Account No" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">IFSC Code <span class="asterisk_sign">*</span></label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="ifsc" placeholder="IFSC Code" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Customer ID</label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="customer_id" placeholder="Customer ID" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label" >Bank Phone No.</label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control" name="phone_no" placeholder="Bank Phone no" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label"  >Relationship Manager</label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="hidden" id="relation_manager_id" name="relation_manager" class="form-control" value="" />
                                                                                                                    <input type="text" id="relation_manager" name="relation_manager_name" class="form-control auto_client" value="" placeholder="Type to choose contact from database..." />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group">
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Opening Balance <span class="asterisk_sign">*</span></label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control format_number" name="opening_balance" placeholder="Opening Balance" value="" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <div class="">
                                                                                                                <label class="col-md-3 control-label">Balance Ref Date <span class="asterisk_sign">*</span></label>
                                                                                                                <div class="col-md-9">
                                                                                                                    <input type="text" class="form-control datepicker1" name="b_bal_ref_date" id="payment_date" placeholder="Balance Ref Date" value="" placeholder=""/>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-12 btn-margin">
                                                                                                        <a href="#accOneColTwo" >
                                                                                                            <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
                                                                                                        </a> 
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="panel panel-primary" id="panel-authorised_signatory">
                                                                                                <a href="#accOneColTwo">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Authorised Signatory
                                                                                                        </h4>
                                                                                                    </div>  
                                                                                                </a>
                                                                                                <div class="panel-body" id="accOneColTwo">
                                                                                                    <div class="banksign">
                                                                                                        <div class="form-group" id="repeat-bank-sign_1" style="border-top: 1px dotted #ddd;">
                                                                                                            <div class="col-md-1" style="padding-left:0px;">
                                                                                                                <label class="col-md-12 control-label">1 <span class="asterisk_sign">*</span></label>
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                                <input type="hidden" id="auth_name_1_id" name="auth_name[]" data-error="#auth_name_1_error" class="form-control" value="" />
                                                                                                                <input type="text" id="auth_name_1" name="auth_contact_name[]" class="form-control auto_client auth_name" value="" placeholder="Type to choose contact from database..." />
                                                                                                                <div id="auth_name_1_error"></div>
                                                                                                            </div>
                                                                                                            <div class="col-md-4">
                                                                                                                <input type="text"  class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="" />
                                                                                                            </div>
                                                                                                            <div class="col-md-3">
                                                                                                                <select class="form-control" name="auth_type[]" id="auth_type_1">
                                                                                                                    <option value="">Select</option>
                                                                                                                    <option>Sole</option>
                                                                                                                    <option >Joint</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-12  btn-margin">
                                                                                                        <div class="">
                                                                                                            <div class=" ">  
                                                                                                                <button class="btn btn-success repeat-bank-sign" style="margin-left: 0px;" name="addhufbtn">+</button>
                                                                                                                <button type="button" class="btn btn-success reverse-bank-sign" style="margin-left: 10px;">-</button>
                                                                                                                <!-- <button type="button" class="btn btn-info mb-control sch" style="float:right;" data-box="#message-box-info"><span class="fa fa-plus"></span> Add Contact</button> -->
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="panel panel-primary" id="nominee-section" style="display:block;">
                                                                                                <a href="#accOneColfour"> 
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Remark </h4>
                                                                                                    </div>
                                                                                                </a>                                 
                                                                                                <div class="panel-body" id="accOneColfour">
                                                                                                    <div class="remark-container1">
                                                                                                        <div class="form-group" style="background: none;border:none">
                                                                                                            <div class="col-md-12">
                                                                                                                <div class="col-md-12">
                                                                                                                    <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ></textarea>
                                                                                                                    <!-- <label style="margin-top: 5px;">Remark </label> -->
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="panel-footer">
                                                                            <input type="hidden" id="submitVal" value="1" />
                                                                            <a href="https://www.pecanreams.com/app/index.php/bank" class="btn btn-danger" >Cancel</a>
                                                                            <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="Submit" style="margin-right: 10px;" />
                                                                            <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; " />
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="reporting">
                                                <div class="design-process-content">
                                                    <h3>Reporting</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincid unt ut laoreet dolore magna aliquam erat volutpat. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <!-- </div> -->
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

        <script type="text/javascript" src="<?php echo base_url().'js/post_details.js';?>"></script>
		
        <!-- END SCRIPTS -->      
    </body>
</html>