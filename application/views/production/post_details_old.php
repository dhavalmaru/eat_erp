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
                width: 16%;
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
          
                <div class="page-content-wrap"  style="margin-top: 61px;">
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
                                                    <p>Batch <br> Master</p>
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
                                             
                                                    
                                                    <div class="panel-body  panel-group accordion">
                                                                                           
                                                      <div class="panel panel-primary" id="production_date">
															<a href="#section1">  
                                                                                     <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Production Date Confirmation
                                                                                                        </h4>
                                                                                     </div>  
															</a>                     
                                                                            <div class="panel-body  panel-body-open" id="section1">
                                                                                            <div class="table-responsive">
																								<table id="" class="table datatable table-bordered">
																									<thead>
																										<tr>
																											<th>Scheduled / Not Scheduled </th>
																											<th>Scheduled</th>
																										   
																										   
																										</tr>
																									</thead>
																									<tbody>
																									<tr>
																											<td>Date Of Request For Production</td>
																											<td>01-11-2018</td>
																										   
																										   
																									</tr>
																										<tr>
																											<td>Date Of Request For Production</td>
																											<td>01-11-2018</td>
																										   
																										   
																									</tr>
																										<tr>
																											<td>Date Confirmed by Serjena</td>
																											<td>01-11-2018</td>
																										   
																										   
																									</tr>
																									</tbody>
																								</table>
																							</div>
                                                                                                 
                                                                            </div>
                                                            </div>
															<div class="panel panel-primary" id="">			
																			<a href="#section2">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Raw Material Purchased
                                                                                                        </h4>
                                                                                                    </div>  
																			</a>                     
                                                                            <div class="panel-body" id="section2">
                                                                                            <div class="table-responsive">
																								<table id="" class="table datatable table-bordered">
																									<thead>
																										<tr>
																											<th>Sr No </th>
																											<th>Raw Material Purchased</th>
																											<th>Kg</th>
																											<th>Date Receiving by Serjena </th>
																											<th>In Time or Late </th>
																										   
																										   
																										</tr>
																									</thead>
																									<tbody>
																									<tr>
																											<td>1</td>
																											<td>Dates</td>
																											<td>1000</td>
																											
																											<td>01-11-2018</td>
																											<td>In Time</td>
																										   
																										   
																									</tr>
																										<tr>
																										
																											<td>2</td>
																											<td>Pumpkin Seeds</td>
																											<td>1000</td>
																											
																											<td>01-11-2018</td>
																											<td>In Time</td>
																						
																										</tr>
																																																																	<tr>
																										
																											<td>3</td>
																											<td>Cranberry</td>
																											<td>1000</td>
																											
																											<td>01-11-2018</td>
																											<td>In Time</td>
																						
																										</tr>
																										<tr>
																										
																											<td>4</td>
																											<td>Butterscotch Nuts</td>
																											<td>1000</td>
																											
																											<td>01-11-2018</td>
																											<td>In Time</td>
																						
																										</tr>
																										<tr>
																										
																											<td>5</td>
																											<td>Dark Chocolate Cream</td>
																											<td>1000</td>
																											
																											<td>01-11-2018</td>
																											<td>In Time</td>
																						
																										</tr>
																										<tr>
																										
																											<td>6</td>
																											<td>Dark Chocolate Chips</td>
																											<td>1000</td>
																											
																											<td>01-11-2018</td>
																											<td>In Time</td>
																						
																										</tr>
																									
																									</tbody>
																								</table>
																							</div>
                                                                                                 
                                                                            </div>	
                                                            </div>	
															<div class="panel panel-primary" id="">

																			<a href="#section3">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Batch Wise Production Plan
                                                                                                        </h4>
                                                                                                    </div>  
																			</a>                     
                                                                            <div class="panel-body" id="section3">
                                                                                            <div class="table-responsive">
																								<table id="" class="table datatable table-bordered">
																									<thead>
																										<tr>
																											<th>Date Of Sending </th>
																											<th>01-11-2018 (In Time)</th>
																											
																										   
																										   
																										</tr>
																										<tr>
																											<th>SKU </th>
																											<th>No Of Batch</th>
																											
																										   
																										   
																										</tr>
																									</thead>
																									<tbody>
																									<tr>
																											
																											<th>Butterscotch</th>
																											<td>10</td>
											
																									</tr>
																										<tr>
																											<th>Orange</th>
																											<td>10</td>
																						
																										</tr>
																										
																										<tr>
																											<th>Mango</th>
																											<td>10</td>
																						
																										</tr>
																										<tr>
																											<th>Peanut And Choco</th>
																											<td>10</td>
																						
																										</tr>
																										
																										<tr>
																											<th>Berry Blast</th>
																											<td>10</td>
																						
																										</tr>
																										<tr>
																											<th>Bambaiya Chaat</th>
																											<td>10</td>
																						
																										</tr>
																										<tr>
																											<th>Chyavanprash</th>
																											<td>10</td>
																						
																										</tr>
																										<tr>
																											<th>Total</th>
																											<td>70</td>
																						
																										</tr>																																					
																									
																									</tbody>
																								</table>
																							</div>
                                                                                                 
                                                                            </div>
											<div class="panel panel-primary" id="">

																					<a href="#section4">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Raw Material Checking
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
												<div class="panel-body" id="section4">
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
                                                                    <tbody id="doc_upload1">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row1 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;     vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row1 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc1" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
														</div>
                                                            
																					
												</div>
											</div>
										<div class="panel panel-primary" id="">

																					<a href="#section5">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Sorting
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
												<div class="panel-body" id="section5">
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
                                                                    <tbody id="doc_upload2">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row2 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;     vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row2 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc2" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
																					
												</div>
												</div>
                                                    

												<div class="panel panel-primary" id="">

																					<a href="#section6">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Production Processing
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
												<div class="panel-body" id="section6">
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
                                                                    <tbody id="doc_upload3">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row3 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;     vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row3 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc3" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
																					
												</div>
												</div>
												
												<div class="panel panel-primary" id="">

																					<a href="#section7">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Quality Control
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
												<div class="panel-body" id="section7">
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
                                                                    <tbody id="doc_upload4">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row4 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;     vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row4 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc4" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
																					
												</div>
												</div>

												<div class="panel panel-primary" id="">

																					<a href="#section8">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Packaging
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
												<div class="panel-body" id="section8">
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
                                                                    <tbody id="doc_upload5">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                           <td style="text-align:center;vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row5 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row5 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc5" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
																					
												</div>
												</div>
												
												<div class="panel panel-primary" id="">

																					<a href="#section9">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    QC Report Of Serjena
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
												<div class="panel-body" id="section9">
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
                                                                    <tbody id="doc_upload6">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row6 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row6 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc6" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
																					
												</div>
												</div>

												<div class="panel panel-primary" id="">			
																			<a href="#section10">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Production Report
                                                                                                        </h4>
                                                                                                    </div>  
																			</a>                     
                                                                            <div class="panel-body" id="section10">
                                                                                            <div class="table-responsive">
																								<table id="" class="table datatable table-bordered">
																									<thead>
																										<tr>
																											<th>Perticulars </th>
																											<th align="left">Ref</th>
																											<th align="center">Orange</th>
																											<th align="center">Butterscotch</th>
																											<th align="center">Berry Blast </th>
																											<th align="center">Mango</th>
																											<th align="center">Chyawanprash</th>
																											<th align="center">Bambaiya Chaat</th>
																											<th align="center">Choco Peanut Butter</th>
																											<th>Total</th>
																										   
																										   
																										</tr>
																									</thead>
																									<tbody>
																									<tr>
																											<td>No.Of Batches</td>
																											<td></td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											
																										   
																										   
																									</tr>
																										<tr>
																										
																											<td>Per Batch</td>
																											<td></td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																																																																	<tr>
																										
																											<td></td>
																											<td></td>
																											<td></td>
																											
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																						
																										</tr>
																										<tr>
																										
																											<td>Total Batch Produced</td>
																											<td></td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<td>Anticipated Water Loss</td>
																											<td></td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<td>Anticipated Wastage</td>
																											<td></td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																											<tr>
																										
																											<td>Anticipated Output</td>
																											<td>KG</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<td>Anticipated Gramage</td>
																											<td></td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										
																										<tr>
																										
																											<td>Anticipated Output</td>
																											<td>Bar</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<td></td>
																											<td></td>
																											<td></td>
																											
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																						
																										</tr>
																										<tr>
																										
																											<td>Actual Bars</td>
																										<td>Bar</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																										</tr>
																										<tr>
																										
																											<td>Actual grams per Bar</td>
																											<td></td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<td>Difference in Bars</td>
																											<td>Bar</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<td>Wastage in KG</td>
																											<td>KG</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<td>Total Wastage in KG</td>
																											<td>KG</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																										</tr>
																										<tr>
																										
																											<td>Actual % Wastage/ Output</td>
																											<td></td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										
																										<tr>
																										
																											<td></td>
																											<td></td>
																											<td></td>
																											
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																						
																										</tr>
																										<tr>
																										
																											<th>Packaging</th>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																											<td></td>
																						
																										</tr>
																										
																										<tr>
																										
																											<th>Pack of 20 </th>
																											<td>20</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																											<tr>
																										
																											<th>Pack of 15 </th>
																											<td>15</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<th>Pack of 6 </th>
																											<td>6</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<th>Single</th>
																											<td>1</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																										</tr>
																											<tr>
																										
																											<th>Testing bars @ Serjena</th>
																											<td>1</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																										</tr>
																										<tr>
																										
																											<td>Difference</td>
																											<td>1</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										
																											<tr>
																										
																											<td></td>
																											<td></td>
																											<td></td>
																											
																											<td></td>
																											<td></td>
																						
																										</tr>
																										<tr>
																										
																											<td>Gate Pass In by EAT</td>
																											<td>1</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																										<tr>
																										
																											<td>Difference</td>
																											<td>1</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																											<td align="right">10.00</td>
																						
																										</tr>
																									</tbody>
																								</table>
																							</div>
                                                                                                 
                                                                            </div>	
                                                            </div>	

												<div class="panel panel-primary" id="">

																					<a href="#section11">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    ERP Updating
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
													<div class="panel-body" id="section11">
													  
														      <div class="table-responsive">
																<table id="" class="table datatable table-bordered">
																	<thead>
																	
																		<tr>
																		<th colspan="9" style="text-align: center;font-size:24px">ANNEXURE I</th>
																		</tr>
																		<tr>
																		<th colspan="6" style="text-align: center;font-size:20px">ERP Updating </th>
																		<th colspan="3" style="text-align: center;">  <img src="<?php echo base_url().'/assets/invoice/'; ?>logo.png" style="width:160px;position: relative;" /></th>
																		</tr>
																		<tr>
																		<th style="text-align: center;">SKU </th>
																		<th style="text-align: center;">Batch Number</th>
																		<th style="text-align: center;">Pack Of 20</th>
																		<th style="text-align: center;">Pack Of 6</th>
																		<th style="text-align: center;">Variety</th>
																		<th style="text-align: center;">Bar transfer to Warehouse</th>
																		<th style="text-align: center;">Bars at Serjena</th>
																		<th style="text-align: center;">Bars transfer Office</th>
																		<th style="text-align: center;"> Total Bar in Production</th>
																   
																		</tr>
																	</thead>																	
																	<tr>	
																		<td align="center">Orange</td>
																		<td align="center">14567</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																	</tr>	
																	<tr>	
																		<td align="center">Butterscotch</td>
																		<td align="center">14567</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																	</tr>	
																	<tr>	
																		<td align="center">Berry Blast </td>
																		<td align="center">14567</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																	</tr>
																	<tr>	
																		<td align="center">Mango </td>
																		<td align="center">14567</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																	</tr>	
																	<tr>	
																		<td align="center">Chyawanprash </td>
																		<td align="center">14567</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																	</tr>	
																	<tr>	
																		<td align="center">Bambaiya Chaat</td>
																		<td align="center">14567</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																	</tr>	
																	<tr>	
																		<td align="center">Choco Peanut Butter</td>	
																		<td align="center">14567</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																		<td align="center">49</td>
																	</tr>																	
																																										
																
																	<tbody>
																																																										
																									
																	</tbody>
																</table>
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
                                                                    <tbody id="doc_upload7">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row7 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;     vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row7 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc7" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
																					
												</div>
												</div>
												<div class="panel panel-primary" id="">

																					<a href="#section12">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Physical Raw Material Test
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
												<div class="panel-body" id="section12">
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
                                                                    <tbody id="doc_upload8">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row8 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row8 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc8" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
																					
												</div>
												</div>	
												
												
												<div class="panel panel-primary" id="">

																					<a href="#section13">  
                                                                                                    <div class="panel-heading">
                                                                                                        <h4 class="panel-title">
                                                                                                            <span class="fa fa-check-square-o"> </span>    Recon of Raw Material with ERP
                                                                                                        </h4>
                                                                                                    </div>  
																					</a>                     
													<div class="panel-body" id="section13">
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
                                                                    <tbody id="doc_upload9">
                                                                    <?php $i=0; if(isset($batch_doc)) {
                                                                            for($i=0; $i<count($batch_doc); $i++) { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" id="title" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
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
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row9 delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="batch_doc_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="text" class="form-control title" name="title[]" placeholder="title" value=""/>
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                                                <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small  batch_doc" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                                            </td>
                                                                            <td style="text-align:center;vertical-align: middle;">
                                                                                <a id="batch_doc_<?php echo $i; ?>_row_delete" class="delete_row9 delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_doc9" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            
																					
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