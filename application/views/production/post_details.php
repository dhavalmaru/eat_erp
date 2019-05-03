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

		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/> 
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
                max-width: 752px;;
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
                width: 13%;
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
            .process-model li.active
            {
                color: #245478
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
            .process-model li.active i  {
                background: #245478!important;
                border-color: #245478!important;
                color:#fff
            }
			.process-model li.visited i  {
                background: #358035;
                border-color: #358035;
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
            textarea {
                z-index: 1!important;
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
                    <div class="">
                    <div class="box-shadow">
					<!-- <div class="panel-body"> -->
                        <section class="design-process-section" id="process-tab">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <input type="hidden" id="production_id" name="production_id" value="<?php if(isset($production_id)) echo $production_id; ?>" />
                                        <?php 
                                            $cls_active = 'report_approved';
                                            if(isset($data)) { 
                                                if($data[0]->batch_master==0 || $data[0]->batch_master==null) $cls_active = 'batch_master';
                                                else if($data[0]->production_details==0 || $data[0]->production_details==null) $cls_active = 'production_details';
                                                else if($data[0]->bar_conversion==0 || $data[0]->bar_conversion==null) $cls_active = 'bar_conversion';
                                                else if($data[0]->depot_transfer==0 || $data[0]->depot_transfer==null) $cls_active = 'depot_transfer';
                                                else if($data[0]->documents_upload==0 || $data[0]->documents_upload==null) $cls_active = 'documents_upload';
                                                else if($data[0]->raw_material_recon==0 || $data[0]->raw_material_recon==null) $cls_active = 'raw_material_recon';
                                            }
                                        ?>
                                        <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
                                            <?php $cls_name=''; if(isset($data)) { if($data[0]->batch_master==1) $cls_name='visited'; } ?>
                                            <li role="presentation" class="<?php echo $cls_name; if($cls_active=='batch_master') echo ' active'; ?>">
                                                <a href="#batch_master" aria-controls="batch_master" role="tab" data-toggle="tab">
                                                    <i class="fa fa-database" aria-hidden="true"></i>
                                                    <p>Batch <br> Master</p>
                                                </a>
                                            </li>
                                            <?php $cls_name=''; if(isset($data)) { if($data[0]->production_details==1) $cls_name='visited'; } ?>
                                            <li role="presentation" class="<?php echo $cls_name; if($cls_active=='production_details') echo ' active'; ?>">
                                                <a href="#discover" aria-controls="discover" role="tab" data-toggle="tab">
                                                    <i class="fa fa-cutlery" aria-hidden="true"></i>
                                                    <p>Production Details</p>
                                                </a>
                                            </li>
                                            <?php $cls_name=''; if(isset($data)) { if($data[0]->bar_conversion==1) $cls_name='visited'; } ?>
                                            <li role="presentation" class="<?php echo $cls_name; if($cls_active=='bar_conversion') echo ' active'; ?>">
                                                <a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab">
                                                    <i class="fa fa-send-o" aria-hidden="true"></i>
                                                    <p>Bar Conversion</p>
                                                </a>
                                            </li>
                                            <?php $cls_name=''; if(isset($data)) { if($data[0]->depot_transfer==1) $cls_name='visited'; } ?>
                                            <li role="presentation" class="<?php echo $cls_name; if($cls_active=='depot_transfer') echo ' active'; ?>">
                                                <a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab">
                                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                                    <p>Depot &nbsp Transfer</p>
                                                </a>
                                            </li>
                                            <?php $cls_name=''; if(isset($data)) { if($data[0]->documents_upload==1) $cls_name='visited'; } ?>
                                            <li role="presentation" class="<?php echo $cls_name; if($cls_active=='documents_upload') echo ' active'; ?>">
                                                <a href="#content" aria-controls="content" role="tab" data-toggle="tab">
                                                    <i class="fa fa-file" aria-hidden="true"></i>
                                                    <p>Documents Upload</p>
                                                </a>
                                            </li>
                                            <?php $cls_name=''; if(isset($data)) { if($data[0]->raw_material_recon==1) $cls_name='visited'; } ?>
                                            <li role="presentation" class="<?php echo $cls_name; if($cls_active=='raw_material_recon') echo ' active'; ?>">
                                                <a href="#rm_recon" aria-controls="rm_recon" role="tab" data-toggle="tab">
                                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                    <p>Raw Material Recon</p>
                                                </a>
                                            </li>
                                            <?php $cls_name=''; if(isset($data)) { if($data[0]->report_approved==1) $cls_name='visited'; } ?>
                                            <li role="presentation" class="<?php echo $cls_name; if($cls_active=='report_approved') echo ' active'; ?>">
                                                <a href="#reporting" aria-controls="reporting" role="tab" data-toggle="tab">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                    <p>Approve Report</p>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane <?php if($cls_active=='batch_master') echo ' active'; ?>" id="batch_master">
                                                <div class="design-process-content">
												<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
													<a class="btn btn-success" href="<?php echo base_url() . 'index.php/batch_master/add/'.((isset($production_id))?$production_id:'0').'/production'; ?>">
														<span class="fa fa-plus"></span> Add Batch No
													</a>
												</div>
												<div class="panel panel-default">
													<div class="panel-body">
														<div class="table-responsive">
														<table id="customers2" class="table datatable table-bordered" >
															<thead>
																<tr>
																	<th width="65" style="text-align:center;">Sr. No.</th>
																	<th width="65" style="text-align:center;">Edit</th>
																	<th>Batch No</th>
																	<th>Date Of Processing</th>
																	<!--<th>Creation Date</th-->
																</tr>
															</thead>
															<tbody>
																<?php for ($i=0; $i < count($batch_master); $i++) { ?>
																<tr>
																	<td style="text-align:center;"><?php echo $i+1; ?></td>
																	<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/batch_master/edit/'.$batch_master[$i]->id.'/production'; ?>"><i class="fa fa-edit"></i></a></td>
																	<td><?php echo $batch_master[$i]->batch_no; ?></td>
																	<td>
																		<span style="display:none;">
																			<?php echo (($batch_master[$i]->date_of_processing!=null && $batch_master[$i]->date_of_processing!='')?date('Ymd',strtotime($batch_master[$i]->date_of_processing)):''); ?>
																		</span>
																		<?php echo(($batch_master[$i]->date_of_processing!=null && $batch_master[$i]->date_of_processing!='')?date('d/m/Y',strtotime($batch_master[$i]->date_of_processing)):''); ?>
																	</td>
																</tr>
																<?php } ?>
															</tbody>
														</table>
														</div>
													</div>
												</div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane <?php if($cls_active=='production_details') echo ' active'; ?>" id="discover">
                                                <div class="design-process-content">
                                                <div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
                                                    <a class="btn btn-success" href="<?php echo base_url() . 'index.php/batch_processing/add/'.((isset($production_id))?$production_id:'0').'/production'; ?>">
                                                        <span class="fa fa-plus"></span> Add Batch Processing Entry
                                                    </a>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                        <table id="customers10" class="table datatable table-bordered" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th width="65" style="text-align:center;" >Sr. No.</th>
                                                                    <th width="90">Date Of processing</th>
                                                                    <th width="65" >Edit</th>
                                                                    <th width="65">View Receipt</th>
                                                                    <th  width="90" >Batch Id As Per Fssai</th>
                                                                    <th  width="145">Depot Name</th>
                                                                    <th width="175" >Product Name</th>
                                                                    <th width="80">Qty In Bar</th>
                                                                    <th width="100">Actual Wastage (In Kg)</th>
                                                                    <th width="65" >Status</th>
                                                                    <!-- <th width="100">Creation Date</th> -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php for ($i=0; $i < count($batch_processing); $i++) { ?>
                                                                <tr>
                                                                    <td style="text-align:center;"><?php echo $i+1; ?></td>
                                                                    <td>
                                                                        <span style="display:none;">
                                                                            <?php echo (($batch_processing[$i]->date_of_processing!=null && $batch_processing[$i]->date_of_processing!='')?date('Ymd',strtotime($batch_processing[$i]->date_of_processing)):''); ?>
                                                                        </span>
                                                                        <?php echo(($batch_processing[$i]->date_of_processing!=null && $batch_processing[$i]->date_of_processing!='')?date('d/m/Y',strtotime($batch_processing[$i]->date_of_processing)):''); ?>
                                                                    </td>
                                                                    <td style="text-align:center; vertical-align: middle; ">
                                                                        <a href="<?php echo base_url().'index.php/batch_processing/edit/'.$batch_processing[$i]->id.'/production'; ?>"><i class="fa fa-edit"></i></a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?php echo base_url().'index.php/batch_processing/view_batch_processing_receipt/'.$batch_processing[$i]->id; ?>" target="_blank"><span class="fa fa-file-pdf-o" style=""></span></a>
                                                                    </td>
                                                                    <td><?php echo $batch_processing[$i]->batch_no; ?></td>
                                                                    <td><?php echo $batch_processing[$i]->depot_name; ?></td>
                                                                    <td><?php echo $batch_processing[$i]->product_name; ?></td>
                                                                    <td><?php echo format_money($batch_processing[$i]->qty_in_bar,2); ?></td>
                                                                    <td><?php echo format_money($batch_processing[$i]->actual_wastage,2); ?></td>
                                                                    <td><?php echo $batch_processing[$i]->status; ?></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane <?php if($cls_active=='bar_conversion') echo ' active'; ?>" id="strategy">
                                                <div class="design-process-content">
											 	<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
                                                    <a class="btn btn-success" href="<?php echo base_url() . 'index.php/bar_to_box/add/'.((isset($production_id))?$production_id:'0').'/production'; ?>">
                                                        <span class="fa fa-plus"></span> Add Bar To Box Entry
                                                    </a>
												</div>
												<div class="panel panel-default">
													<div class="panel-body">
														<div class="table-responsive">
															<div class="table-responsive">
																<table id="customers3" class="table datatable table-bordered"  >
																	<thead>
																		<tr>
																			<th width="65" style="text-align:center;" >Sr. No.</th>
																			<th width="65" style="text-align:center;" >Edit</th>
																			<th width="140">Date Of processing</th>
																			<th  >Depot Name</th>
																			<th width="110">Qty</th>
																			<th width="110">Grams</th>
																			<th width="120">Amount (In Rs)</th>
																			<!--<th width="110">Creation Date</th>-->
																		</tr>
																	</thead>
																	<tbody>
																		<?php for ($i=0; $i < count($bar_to_box); $i++) { ?>
																		<tr>
																			<td style="text-align:center;" ><?php echo $i+1; ?>1</td>
																			<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/bar_to_box/edit/'.$bar_to_box[$i]->id.'/production'; ?>"><i class="fa fa-edit"></i></a></td>
																			<td>
																				<span style="display:none;">
																					<?php echo (($bar_to_box[$i]->date_of_processing!=null && $bar_to_box[$i]->date_of_processing!='')?date('Ymd',strtotime($bar_to_box[$i]->date_of_processing)):''); ?>
																				</span>
																				<?php echo (($bar_to_box[$i]->date_of_processing!=null && $bar_to_box[$i]->date_of_processing!='')?date('d/m/Y',strtotime($bar_to_box[$i]->date_of_processing)):''); ?>
																			</td>
																			<td><?php echo $bar_to_box[$i]->depot_name; ?></td>
																			<td><?php echo format_money($bar_to_box[$i]->qty,2); ?></td>
																			<td><?php echo format_money($bar_to_box[$i]->grams,2); ?></td>
																			<td><?php echo format_money($bar_to_box[$i]->amount,2); ?></td>
																			<!--<td>
																				<span style="display:none;">
																					<?php// echo (($bar_to_box[$i]->modified_on!=null && $bar_to_box[$i]->modified_on!='')?date('Ymd',strtotime($bar_to_box[$i]->modified_on)):''); ?>
																				</span>
																				<?php //echo (($bar_to_box[$i]->modified_on!=null && $bar_to_box[$i]->modified_on!='')?date('d/m/Y',strtotime($bar_to_box[$i]->modified_on)):''); ?></td>-->
																		</tr>
																		<?php } ?>
																	</tbody>
																</table>
															</div>
                                                        </div>
												    </div>
                                                </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane <?php if($cls_active=='depot_transfer') echo ' active'; ?>" id="optimization">
                                                <div class="design-process-content">
												 	<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
														<a class="btn btn-success" href="<?php echo base_url() . 'index.php/depot_transfer/add/'.((isset($production_id))?$production_id:'0').'/production'; ?>">
															<span class="fa fa-plus"></span> Add Depot Transfer Entry
														</a>
													</div>
    												<div class="panel panel-default">
    													<div class="panel-body">
    														<div class="table-responsive">
    															<div class="table-responsive">
                                								<table id="customers4" class="table datatable table-bordered" >
                                									<thead>
                                										<tr>
                                										<th width="65" style="text-align:center;" >Sr. No.</th>
                                										<th width="65" style="text-align:center;" >Edit</th>
                                											<th width="140">Date Of Transfer</th>
                                											<th >Depot Out</th>
                                											<th >Depot In</th>
                                											<th >Chalan No.</th>
                                											<!--<th width="110">Creation Date</th>-->
                                										</tr>
                                									</thead>
                                									<tbody>
                                										<?php for ($i=0; $i < count($depot_transfer); $i++) { ?>
                                										<tr>
                                											<td  style="text-align:center;"><?php echo $i+1; ?></td>
                                											<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/depot_transfer/edit/'.$depot_transfer[$i]->id.'/production'; ?>"><i class="fa fa-edit"></i></a></td>
                                											<td>
                                                                                <span style="display:none;">
                                                                                    <?php echo (($depot_transfer[$i]->date_of_transfer!=null && $depot_transfer[$i]->date_of_transfer!='')?date('Ymd',strtotime($depot_transfer[$i]->date_of_transfer)):''); ?>
                                                                                </span>
                                												<?php echo (($depot_transfer[$i]->date_of_transfer!=null && $depot_transfer[$i]->date_of_transfer!='')?date('d/m/Y',strtotime($depot_transfer[$i]->date_of_transfer)):''); ?>
                                                                            </td>
                                											<td><?php echo $depot_transfer[$i]->depot_out_name; ?></td>
                                											<td><?php echo $depot_transfer[$i]->depot_in_name; ?></td>
                                											<td><?php echo $depot_transfer[$i]->chalan_no; ?></td>
                            									            <!-- <td>
                                												<span style="display:none;">
                                                                                    <?php// echo (($depot_transfer[$i]->modified_on!=null && $depot_transfer[$i]->modified_on!='')?date('Ymd',strtotime($depot_transfer[$i]->modified_on)):''); ?>
                                                                                </span>
                                												<?php //echo (($depot_transfer[$i]->modified_on!=null && $depot_transfer[$i]->modified_on!='')?date('d/m/Y',strtotime($depot_transfer[$i]->modified_on)):''); ?>
                                                                            </td>-->
                                										</tr>
                                										<?php } ?>
                                									</tbody>
                                								</table>
                                								</div>
                                                            </div>
                                                        </div>
												    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane <?php if($cls_active=='documents_upload') echo ' active'; ?>" id="content">
                                                <div class="design-process-content">
                                                    <form id="form_production_doc_details" role="form" class="form-horizontal" method="post" action="<?php echo base_url(). 'index.php/production/upload_documents/'. (isset($production_id)?$production_id:0); ?>" enctype="multipart/form-data">
                                                    <div class="panel-body  panel-group accordion">
                                                        <div class="panel panel-primary" id="">
															<a href="#section4">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> Raw Material Checking
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture A</span>
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
                                                                            <th>Upload File</th>
                                                                            <th width="75">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="raw_material_check">
                                                                    <?php $i=0; 
                                                                        if(isset($raw_material_check_doc)) {
                                                                            for($i=0; $i<count($raw_material_check_doc); $i++) { 
                                                                    ?>
                                                                        <tr id="raw_material_check_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control raw_material_check_doc_type" name="raw_material_check_doc_type[]" value="<?php if (isset($raw_material_check_doc)) { echo $raw_material_check_doc[$i]->doc_type; } ?>" />
                                                                                <input type="text" class="form-control raw_material_check_doc_title" name="raw_material_check_doc_title[]" placeholder="Title" value="<?php if (isset($raw_material_check_doc)) { echo $raw_material_check_doc[$i]->doc_title; } ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="raw_material_check_doc_name[]" value="<?php if(isset($raw_material_check_doc)) {echo $raw_material_check_doc[$i]->doc_name;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="raw_material_check_doc_path[]" value="<?php if(isset($raw_material_check_doc)) {echo $raw_material_check_doc[$i]->doc_path;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small raw_material_check_doc" name="raw_material_check_doc_img_<?php echo $i; ?>" />
                                                                                </div>
                                                                                <?php if(isset($raw_material_check_doc)) {if($raw_material_check_doc[$i]->doc_path!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" href="<?php echo base_url().$raw_material_check_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="raw_material_check_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="raw_material_check_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control raw_material_check_doc_type" name="raw_material_check_doc_type[]" value="raw_material_check" />
                                                                                <input type="text" class="form-control raw_material_check_doc_title" name="raw_material_check_doc_title[]" placeholder="Title" value="" />
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="raw_material_check_doc_name[]" value="" />
                                                                                <input type="hidden" class="form-control" name="raw_material_check_doc_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small raw_material_check_doc" name="raw_material_check_doc_img_<?php echo $i; ?>" />
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="raw_material_check_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_raw_material_check" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                                                            <div class="col-md-10  col-sm-10 col-xs-12">
                                                                                <textarea class="form-control" name="raw_material_check_remarks" cols="10"><?php if(isset($raw_material_check_doc[0]->remarks)) echo $raw_material_check_doc[0]->remarks; else echo 'There was no issue in raw material. All raw materials were in good condition.'; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
												            </div>
                                                        </div>
                                                        <div class="panel panel-primary" id="">
															<a href="#section5">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> Sorting
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture B</span>
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
                                                                            <th>Upload File</th>
                                                                            <th width="75">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="sorting">
                                                                    <?php $i=0; 
                                                                        if(isset($sorting_doc)) {
                                                                            for($i=0; $i<count($sorting_doc); $i++) { 
                                                                    ?>
                                                                        <tr id="sorting_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control sorting_doc_type" name="sorting_doc_type[]" value="<?php if (isset($sorting_doc)) { echo $sorting_doc[$i]->doc_type; } ?>" />
                                                                                <input type="text" class="form-control sorting_doc_title" name="sorting_doc_title[]" placeholder="Title" value="<?php if (isset($sorting_doc)) { echo $sorting_doc[$i]->doc_title; } ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="sorting_doc_name[]" value="<?php if(isset($sorting_doc)) {echo $sorting_doc[$i]->doc_name;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="sorting_doc_path[]" value="<?php if(isset($sorting_doc)) {echo $sorting_doc[$i]->doc_path;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small sorting_doc" name="sorting_doc_img_<?php echo $i; ?>" />
                                                                                </div>
                                                                                <?php if(isset($sorting_doc)) {if($sorting_doc[$i]->doc_path!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" href="<?php echo base_url().$sorting_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="sorting_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="sorting_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control sorting_doc_type" name="sorting_doc_type[]" value="sorting" />
                                                                                <input type="text" class="form-control sorting_doc_title" name="sorting_doc_title[]" placeholder="Title" value="" />
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="sorting_doc_name[]" value="" />
                                                                                <input type="hidden" class="form-control" name="sorting_doc_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small sorting_doc" name="sorting_doc_img_<?php echo $i; ?>" />
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="sorting_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_sorting" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                                                            <div class="col-md-10  col-sm-10 col-xs-12">
                                                                                <textarea class="form-control" name="sorting_remarks" cols="10"><?php if(isset($sorting_doc[0]->remarks)) echo $sorting_doc[0]->remarks; else echo 'No problem in sorting of raw material.'; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
												            </div>
												        </div>
												        <div class="panel panel-primary" id="">
															<a href="#section6">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> Production Processing
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture C</span>
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
                                                                    <tbody id="processing">
                                                                    <?php $i=0; 
                                                                        if(isset($processing_doc)) {
                                                                            for($i=0; $i<count($processing_doc); $i++) { 
                                                                    ?>
                                                                        <tr id="processing_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control processing_doc_type" name="processing_doc_type[]" value="<?php if (isset($processing_doc)) { echo $processing_doc[$i]->doc_type; } ?>" />
                                                                                <input type="text" class="form-control processing_doc_title" name="processing_doc_title[]" placeholder="Title" value="<?php if (isset($processing_doc)) { echo $processing_doc[$i]->doc_title; } ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="processing_doc_name[]" value="<?php if(isset($processing_doc)) {echo $processing_doc[$i]->doc_name;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="processing_doc_path[]" value="<?php if(isset($processing_doc)) {echo $processing_doc[$i]->doc_path;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small processing_doc" name="processing_doc_img_<?php echo $i; ?>" />
                                                                                </div>
                                                                                <?php if(isset($processing_doc)) {if($processing_doc[$i]->doc_path!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" href="<?php echo base_url().$processing_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="processing_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="processing_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control processing_doc_type" name="processing_doc_type[]" value="processing" />
                                                                                <input type="text" class="form-control processing_doc_title" name="processing_doc_title[]" placeholder="Title" value="" />
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="processing_doc_name[]" value="" />
                                                                                <input type="hidden" class="form-control" name="processing_doc_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small processing_doc" name="processing_doc_img_<?php echo $i; ?>" />
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="processing_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_processing" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                                                            <div class="col-md-10  col-sm-10 col-xs-12">
                                                                                <textarea class="form-control" name="processing_remarks" cols="10"><?php if(isset($processing_doc[0]->remarks)) echo $processing_doc[0]->remarks; else echo 'There was no problem during the production process.'; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
												            </div>
												        </div>
												        <div class="panel panel-primary" id="">
															<a href="#section7">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> Quality Control
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture D</span>
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
                                                                    <tbody id="quality_control">
                                                                    <?php $i=0; 
                                                                        if(isset($quality_control_doc)) {
                                                                            for($i=0; $i<count($quality_control_doc); $i++) { 
                                                                    ?>
                                                                        <tr id="quality_control_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control quality_control_doc_type" name="quality_control_doc_type[]" value="<?php if (isset($quality_control_doc)) { echo $quality_control_doc[$i]->doc_type; } ?>" />
                                                                                <input type="text" class="form-control quality_control_doc_title" name="quality_control_doc_title[]" placeholder="Title" value="<?php if (isset($quality_control_doc)) { echo $quality_control_doc[$i]->doc_title; } ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="quality_control_doc_name[]" value="<?php if(isset($quality_control_doc)) {echo $quality_control_doc[$i]->doc_name;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="quality_control_doc_path[]" value="<?php if(isset($quality_control_doc)) {echo $quality_control_doc[$i]->doc_path;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small quality_control_doc" name="quality_control_doc_img_<?php echo $i; ?>" />
                                                                                </div>
                                                                                <?php if(isset($quality_control_doc)) {if($quality_control_doc[$i]->doc_path!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" href="<?php echo base_url().$quality_control_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="quality_control_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="quality_control_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control quality_control_doc_type" name="quality_control_doc_type[]" value="quality_control" />
                                                                                <input type="text" class="form-control quality_control_doc_title" name="quality_control_doc_title[]" placeholder="Title" value="" />
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="quality_control_doc_name[]" value="" />
                                                                                <input type="hidden" class="form-control" name="quality_control_doc_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small quality_control_doc" name="quality_control_doc_img_<?php echo $i; ?>" />
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="quality_control_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_quality_control" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">Weight & Measure Remarks </label>
                                                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                                                <textarea class="form-control" name="quality_control_remarks" cols="10"><?php if(isset($quality_control_doc[0]->remarks)) echo $quality_control_doc[0]->remarks; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">Shaping/Cutting & PVC Tray <br/>Filling Remarks </label>
                                                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                                                <textarea class="form-control" name="quality_control_remarks2" cols="10"><?php if(isset($quality_control_doc[0]->remarks2)) echo $quality_control_doc[0]->remarks2; echo 'There was no problem in shaping/cutting & PVC Tray filling. We reused damaged or break product to mixing.'; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
												            </div>
												        </div>
												        <div class="panel panel-primary" id="">
															<a href="#section8">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> Packaging
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture E</span>
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
                                                                        <tbody id="packaging">
                                                                        <?php $i=0; 
                                                                            if(isset($packaging_doc)) {
                                                                                for($i=0; $i<count($packaging_doc); $i++) { 
                                                                        ?>
                                                                            <tr id="packaging_<?php echo $i; ?>_row">
                                                                                <td>
                                                                                    <input type="hidden" class="form-control packaging_doc_type" name="packaging_doc_type[]" value="<?php if (isset($packaging_doc)) { echo $packaging_doc[$i]->doc_type; } ?>" />
                                                                                    <input type="text" class="form-control packaging_doc_title" name="packaging_doc_title[]" placeholder="Title" value="<?php if (isset($packaging_doc)) { echo $packaging_doc[$i]->doc_title; } ?>" />
                                                                                </td>
                                                                                <td>
                                                                                    <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                        <input type="hidden" class="form-control" name="packaging_doc_name[]" value="<?php if(isset($packaging_doc)) {echo $packaging_doc[$i]->doc_name;} ?>" />
                                                                                        <input type="hidden" class="form-control" name="packaging_doc_path[]" value="<?php if(isset($packaging_doc)) {echo $packaging_doc[$i]->doc_path;} ?>" />
                                                                                        <input type="file" class="fileinput btn btn-info btn-small packaging_doc" name="packaging_doc_img_<?php echo $i; ?>" />
                                                                                    </div>
                                                                                    <?php if(isset($packaging_doc)) {if($packaging_doc[$i]->doc_path!= '') { ?>
                                                                                    <div class="col-md- col-sm-3 col-xs-3">
                                                                                        <a target="_blank" href="<?php echo base_url().$packaging_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                    </div>
                                                                                    <?php }} ?>
                                                                                </td>
                                                                                <td style="text-align:center; vertical-align: middle;">
                                                                                    <a id="packaging_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }} else { ?>
                                                                            <tr id="packaging_<?php echo $i; ?>_row">
                                                                                <td>
                                                                                    <input type="hidden" class="form-control packaging_doc_type" name="packaging_doc_type[]" value="packaging" />
                                                                                    <input type="text" class="form-control packaging_doc_title" name="packaging_doc_title[]" placeholder="Title" value="" />
                                                                                </td>
                                                                                <td>
                                                                                    <input type="hidden" class="form-control" name="packaging_doc_name[]" value="" />
                                                                                    <input type="hidden" class="form-control" name="packaging_doc_path[]" value="" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small packaging_doc" name="packaging_doc_img_<?php echo $i; ?>" />
                                                                                </td>
                                                                                <td style="text-align:center; vertical-align: middle;">
                                                                                    <a id="packaging_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="5">
                                                                                    <button type="button" class="btn btn-success" id="repeat_packaging" style=" ">+</button>
                                                                                </td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">Dummy Sample Test Remarks </label>
                                                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                                                <textarea class="form-control" name="packaging_remarks" cols="10"><?php if(isset($packaging_doc[0]->remarks)) echo $packaging_doc[0]->remarks; else echo 'We packed 40 dummy sample and done water leak test. When we found least leakage,  i.e. 0 out of 40 dummy samples then we proceed for actual product packaging.'; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-md-3 col-sm-3 col-xs-12 control-label">Wrapper Packaging & Double Seal <br/>Packaging Remarks </label>
                                                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                                                <textarea class="form-control" name="packaging_remarks2" cols="10"><?php if(isset($packaging_doc[0]->remarks2)) echo $packaging_doc[0]->remarks2; else echo 'Wrapper packaging done for all SKU. Wrapper packed product collected in corrugated box. After Water Leak test it proceeds for double seal packaging. Punctured products, after double seal packaging, return to wrapper packaging and same process as above.'; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
												            </div>
												        </div>
												        <div class="panel panel-primary" id="">
															<a href="#section9">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> QC Report Of Serjena
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture G</span>
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
                                                                    <tbody id="qc_report">
                                                                    <?php $i=0; 
                                                                        if(isset($qc_report_doc)) {
                                                                            for($i=0; $i<count($qc_report_doc); $i++) { 
                                                                    ?>
                                                                        <tr id="qc_report_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control qc_report_doc_type" name="qc_report_doc_type[]" value="<?php if (isset($qc_report_doc)) { echo $qc_report_doc[$i]->doc_type; } ?>" />
                                                                                <input type="text" class="form-control qc_report_doc_title" name="qc_report_doc_title[]" placeholder="Title" value="<?php if (isset($qc_report_doc)) { echo $qc_report_doc[$i]->doc_title; } ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="qc_report_doc_name[]" value="<?php if(isset($qc_report_doc)) {echo $qc_report_doc[$i]->doc_name;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="qc_report_doc_path[]" value="<?php if(isset($qc_report_doc)) {echo $qc_report_doc[$i]->doc_path;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small qc_report_doc" name="qc_report_doc_img_<?php echo $i; ?>" />
                                                                                </div>
                                                                                <?php if(isset($qc_report_doc)) {if($qc_report_doc[$i]->doc_path!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" href="<?php echo base_url().$qc_report_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="qc_report_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="qc_report_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control qc_report_doc_type" name="qc_report_doc_type[]" value="qc_report" />
                                                                                <input type="text" class="form-control qc_report_doc_title" name="qc_report_doc_title[]" placeholder="Title" value="" />
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="qc_report_doc_name[]" value="" />
                                                                                <input type="hidden" class="form-control" name="qc_report_doc_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small qc_report_doc" name="qc_report_doc_img_<?php echo $i; ?>" />
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="qc_report_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_qc_report" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                                                            <div class="col-md-10  col-sm-10 col-xs-12">
                                                                                <textarea class="form-control" name="qc_report_remarks" cols="10"><?php if(isset($qc_report_doc[0]->remarks)) echo $qc_report_doc[0]->remarks;?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
												            </div>
												        </div>
												        <div class="panel panel-primary" id="">
															<a href="#section11">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> ERP Updating
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture I</span>
                                                                    </h4>
                                                                </div>  
															</a>                     
                                                            <div class="panel-body" id="section11">
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
                                                                    <tbody id="erp_updating">
                                                                    <?php $i=0; 
                                                                        if(isset($erp_updating_doc)) {
                                                                            for($i=0; $i<count($erp_updating_doc); $i++) { 
                                                                    ?>
                                                                        <tr id="erp_updating_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control erp_updating_doc_type" name="erp_updating_doc_type[]" value="<?php if (isset($erp_updating_doc)) { echo $erp_updating_doc[$i]->doc_type; } ?>" />
                                                                                <input type="text" class="form-control erp_updating_doc_title" name="erp_updating_doc_title[]" placeholder="Title" value="<?php if (isset($erp_updating_doc)) { echo $erp_updating_doc[$i]->doc_title; } ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="erp_updating_doc_name[]" value="<?php if(isset($erp_updating_doc)) {echo $erp_updating_doc[$i]->doc_name;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="erp_updating_doc_path[]" value="<?php if(isset($erp_updating_doc)) {echo $erp_updating_doc[$i]->doc_path;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small erp_updating_doc" name="erp_updating_doc_img_<?php echo $i; ?>" />
                                                                                </div>
                                                                                <?php if(isset($erp_updating_doc)) {if($erp_updating_doc[$i]->doc_path!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" href="<?php echo base_url().$erp_updating_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="erp_updating_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="erp_updating_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control erp_updating_doc_type" name="erp_updating_doc_type[]" value="erp_updating" />
                                                                                <input type="text" class="form-control erp_updating_doc_title" name="erp_updating_doc_title[]" placeholder="Title" value="" />
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="erp_updating_doc_name[]" value="" />
                                                                                <input type="hidden" class="form-control" name="erp_updating_doc_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small erp_updating_doc" name="erp_updating_doc_img_<?php echo $i; ?>" />
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="erp_updating_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_erp_updating" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                                                            <div class="col-md-10  col-sm-10 col-xs-12">
                                                                                <textarea class="form-control" name="erp_updating_remarks" cols="10"><?php if(isset($erp_updating_doc[0]->remarks)) echo $erp_updating_doc[0]->remarks;?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
												        </div>
												        <div class="panel panel-primary" id="">
															<a href="#section12">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> Physical Raw Material Test
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture J</span>
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
                                                                    <tbody id="physical_rm">
                                                                    <?php $i=0; 
                                                                        if(isset($physical_rm_doc)) {
                                                                            for($i=0; $i<count($physical_rm_doc); $i++) { 
                                                                    ?>
                                                                        <tr id="physical_rm_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control physical_rm_doc_type" name="physical_rm_doc_type[]" value="<?php if (isset($physical_rm_doc)) { echo $physical_rm_doc[$i]->doc_type; } ?>" />
                                                                                <input type="text" class="form-control physical_rm_doc_title" name="physical_rm_doc_title[]" placeholder="Title" value="<?php if (isset($physical_rm_doc)) { echo $physical_rm_doc[$i]->doc_title; } ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="physical_rm_doc_name[]" value="<?php if(isset($physical_rm_doc)) {echo $physical_rm_doc[$i]->doc_name;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="physical_rm_doc_path[]" value="<?php if(isset($physical_rm_doc)) {echo $physical_rm_doc[$i]->doc_path;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small physical_rm_doc" name="physical_rm_doc_img_<?php echo $i; ?>" />
                                                                                </div>
                                                                                <?php if(isset($physical_rm_doc)) {if($physical_rm_doc[$i]->doc_path!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" href="<?php echo base_url().$physical_rm_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="physical_rm_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="physical_rm_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control physical_rm_doc_type" name="physical_rm_doc_type[]" value="physical_rm" />
                                                                                <input type="text" class="form-control physical_rm_doc_title" name="physical_rm_doc_title[]" placeholder="Title" value="" />
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="physical_rm_doc_name[]" value="" />
                                                                                <input type="hidden" class="form-control" name="physical_rm_doc_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small physical_rm_doc" name="physical_rm_doc_img_<?php echo $i; ?>" />
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="physical_rm_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_physical_rm" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                                                            <div class="col-md-10  col-sm-10 col-xs-12">
                                                                                <textarea class="form-control" name="physical_rm_remarks" cols="10"><?php if(isset($physical_rm_doc[0]->remarks)) echo $physical_rm_doc[0]->remarks;?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </div>
												            </div>
											            </div>
												        <div class="panel panel-primary" id="">
															<a href="#section13">  
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <span class="fa fa-check-square-o"> </span> Recon of Raw Material with ERP
                                                                        <span style="position: absolute; right: 20px; top: 8px;">Annexture K</span>
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
                                                                    <tbody id="recon_of_rm">
                                                                    <?php $i=0; 
                                                                        if(isset($recon_of_rm_doc)) {
                                                                            for($i=0; $i<count($recon_of_rm_doc); $i++) { 
                                                                    ?>
                                                                        <tr id="recon_of_rm_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control recon_of_rm_doc_type" name="recon_of_rm_doc_type[]" value="<?php if (isset($recon_of_rm_doc)) { echo $recon_of_rm_doc[$i]->doc_type; } ?>" />
                                                                                <input type="text" class="form-control recon_of_rm_doc_title" name="recon_of_rm_doc_title[]" placeholder="Title" value="<?php if (isset($recon_of_rm_doc)) { echo $recon_of_rm_doc[$i]->doc_title; } ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                                                    <input type="hidden" class="form-control" name="recon_of_rm_doc_name[]" value="<?php if(isset($recon_of_rm_doc)) {echo $recon_of_rm_doc[$i]->doc_name;} ?>" />
                                                                                    <input type="hidden" class="form-control" name="recon_of_rm_doc_path[]" value="<?php if(isset($recon_of_rm_doc)) {echo $recon_of_rm_doc[$i]->doc_path;} ?>" />
                                                                                    <input type="file" class="fileinput btn btn-info btn-small recon_of_rm_doc" name="recon_of_rm_doc_img_<?php echo $i; ?>" />
                                                                                </div>
                                                                                <?php if(isset($recon_of_rm_doc)) {if($recon_of_rm_doc[$i]->doc_path!= '') { ?>
                                                                                <div class="col-md- col-sm-3 col-xs-3">
                                                                                    <a target="_blank" href="<?php echo base_url().$recon_of_rm_doc[$i]->doc_path; ?>"><span class="fa download fa-download" ></span></a>
                                                                                </div>
                                                                                <?php }} ?>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="recon_of_rm_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php }} else { ?>
                                                                        <tr id="recon_of_rm_<?php echo $i; ?>_row">
                                                                            <td>
                                                                                <input type="hidden" class="form-control recon_of_rm_doc_type" name="recon_of_rm_doc_type[]" value="recon_of_rm" />
                                                                                <input type="text" class="form-control recon_of_rm_doc_title" name="recon_of_rm_doc_title[]" placeholder="Title" value="" />
                                                                            </td>
                                                                            <td>
                                                                                <input type="hidden" class="form-control" name="recon_of_rm_doc_name[]" value="" />
                                                                                <input type="hidden" class="form-control" name="recon_of_rm_doc_path[]" value="" />
                                                                                <input type="file" class="fileinput btn btn-info btn-small recon_of_rm_doc" name="recon_of_rm_doc_img_<?php echo $i; ?>" />
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <a id="recon_of_rm_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <button type="button" class="btn btn-success" id="repeat_recon_of_rm" style=" ">+</button>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                                                            <div class="col-md-10  col-sm-10 col-xs-12">
                                                                                <textarea class="form-control" name="recon_of_rm_remarks" cols="10"><?php if(isset($recon_of_rm_doc[0]->remarks)) echo $recon_of_rm_doc[0]->remarks;?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
												        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <button class="btn btn-success pull-right" style="<?php if(isset($access)) {if($access[0]->r_edit=='0') echo 'display: none;'; else if($access[0]->r_edit=='0') echo 'display: none;';} ?>">Upload</button>
                                                        <br/><br/>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                               
                                            <div role="tabpanel" class="tab-pane <?php if($cls_active=='raw_material_recon') echo ' active'; ?>" id="rm_recon">
                                                <div class="design-process-content">
                                                <div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
                                                    <a class="btn btn-success" href="<?php echo base_url() . 'index.php/raw_material_recon/add/'.((isset($production_id))?$production_id:'0').'/production'; ?>">
                                                        <span class="fa fa-plus"></span> Add Raw Material Recon Entry
                                                    </a>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                        <table id="customers10" class="table datatable table-bordered" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th width="65" style="text-align:center;" >Sr. No.</th>
                                                                    <th width="90">Date Of processing</th>
                                                                    <th width="65">Edit</th>
                                                                    <th width="145">Depot Name</th>
                                                                    <th width="65">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php for ($i=0; $i < count($raw_material_recon); $i++) { ?>
                                                                <tr>
                                                                    <td style="text-align:center;"><?php echo $i+1; ?></td>
                                                                    <td>
                                                                        <span style="display:none;">
                                                                            <?php echo (($raw_material_recon[$i]->date_of_processing!=null && $raw_material_recon[$i]->date_of_processing!='')?date('Ymd',strtotime($raw_material_recon[$i]->date_of_processing)):''); ?>
                                                                        </span>
                                                                        <?php echo(($raw_material_recon[$i]->date_of_processing!=null && $raw_material_recon[$i]->date_of_processing!='')?date('d/m/Y',strtotime($raw_material_recon[$i]->date_of_processing)):''); ?>
                                                                    </td>
                                                                    <td style="text-align:center; vertical-align: middle; ">
                                                                        <a href="<?php echo base_url().'index.php/raw_material_recon/edit/'.$raw_material_recon[$i]->id.'/production'; ?>"><i class="fa fa-edit"></i></a>
                                                                    </td>
                                                                    <td><?php echo $raw_material_recon[$i]->depot_name; ?></td>
                                                                    <td><?php echo $raw_material_recon[$i]->status; ?></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                               
                                            <div role="tabpanel" class="tab-pane <?php if($cls_active=='report_approved') echo ' active'; ?>" id="reporting">
                                                <div class="design-process-content">
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                        <table id="customers10" class="table datatable table-bordered" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th width="65" style="text-align:center;">Sr. No.</th>
                                                                    <th width="65" style="text-align:center;">Edit</th>
                                                                    <th>Production Id</th>
                                                                    <th>Manufacturer Name</th>
                                                                    <th>From Date</th>
                                                                    <th>To Date</th>
                                                                    <th>Production Status</th>
                                                                    <th>Production Report</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php for ($i=0; $i < count($data); $i++) { ?>
                                                                <tr>
                                                                    <td style="text-align:center;"><?php echo $i+1; ?></td>
                                                                    <td style="text-align:center; vertical-align: middle; "><a target="_blank" href="<?php echo base_url().'index.php/production/view_production_report/'.$data[$i]->id.'/Approve'; ?>"><i class="fa fa-edit"></i></a></td>
                                                                    <td><?php echo $data[$i]->p_id; ?></td>
                                                                    <td><?php echo $data[$i]->manufacturer_name; ?></td>
                                                                    <td>
                                                                        <span style="display:none;">
                                                                            <?php echo (($data[$i]->confirm_from_date!=null && $data[$i]->confirm_from_date!='')?date('Ymd',strtotime($data[$i]->confirm_from_date)):''); ?>
                                                                        </span>
                                                                        <?php echo (($data[$i]->confirm_from_date!=null && $data[$i]->confirm_from_date!='')?date('d/m/Y',strtotime($data[$i]->confirm_from_date)):''); ?>
                                                                    </td>
                                                                    <td>
                                                                        <span style="display:none;">
                                                                            <?php echo (($data[$i]->confirm_to_date!=null && $data[$i]->confirm_to_date!='')?date('Ymd',strtotime($data[$i]->confirm_to_date)):''); ?>
                                                                        </span>
                                                                        <?php echo (($data[$i]->confirm_to_date!=null && $data[$i]->confirm_to_date!='')?date('d/m/Y',strtotime($data[$i]->confirm_to_date)):''); ?>
                                                                    </td>
                                                                    <td>
                                                                    <?php 
                                                                        if($data[$i]->batch_master==null || $data[$i]->batch_master=='0') 
                                                                            echo 'Confirm Batch Nos.';
                                                                        else if($data[$i]->production_details==null || $data[$i]->production_details=='0') 
                                                                            echo 'Confirm Production Details.';
                                                                        else if($data[$i]->bar_conversion==null || $data[$i]->bar_conversion=='0') 
                                                                            echo 'Perform Bar Conversion.';
                                                                        else if($data[$i]->depot_transfer==null || $data[$i]->depot_transfer=='0') 
                                                                            echo 'Perform Depot Transfer.';
                                                                        else if($data[$i]->documents_upload==null || $data[$i]->documents_upload=='0') 
                                                                            echo 'Perform Documents Upload.';
                                                                        else if($data[$i]->raw_material_recon==null || $data[$i]->raw_material_recon=='0') 
                                                                            echo 'Perform Raw Material Recon.';
                                                                        else if($data[$i]->report_approved==null || $data[$i]->report_approved=='0') 
                                                                            if($data[$i]->report_status==null || $data[$i]->report_status==''){
                                                                                echo 'Submit Production Report For Approval.';
                                                                            } else if(strtoupper(trim($data[$i]->report_status))=='PENDING'){
                                                                                echo 'Approve Production Report.';
                                                                            } else if(strtoupper(trim($data[$i]->report_status))=='REJECTED'){
                                                                                echo 'Production Report Rejected.';
                                                                            } else {
                                                                                echo 'Approve Report.';
                                                                            }
                                                                        else if($data[$i]->report_approved=='1') 
                                                                            echo 'Approved.';
                                                                        else echo $data[$i]->p_status;
                                                                    ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?php echo base_url().'index.php/production/view_production_report/'.$data[$i]->id; ?>" target="_blank"><span class="fa fa-file-pdf-o" style=""></span></a>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
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