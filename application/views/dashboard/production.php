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
        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>

        <!--[if lt IE 9]>
        <script src="dist/html5shiv.js"></script>
        <![endif]-->
        <!-- EOF CSS INCLUDE -->     

        <link href="<?php echo base_url(); ?>dashboard/css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->

        <link href="<?php echo base_url(); ?>dashboard/css/custom.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>dashboard/css/maps/jquery-jvectormap-2.0.1.css" />
        <link href="<?php echo base_url(); ?>dashboard/css/icheck/flat/green.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>dashboard/css/floatexamples.css" rel="stylesheet" /> 

        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>dashboard/css/theme-default.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>dashboard/src/css/index.css"/>

        <!-- EOF CSS INCLUDE -->

        <style>
    		.dropdown-selector-left
    		{
    			padding: 0px 19px!important;
    		}
    		.logout-section a
    		{
    			    padding: 8px 15px!important;
    		}

            .heading-h3 
            {
                background: #eee;
                line-height: 25px;
                padding: 7px 15px;
                text-transform: uppercase;
                font-weight: 600;
                display: inline-block;
                margin-top: 61px;
                width: 100%;
                font-size: 14px;
                border-bottom: 1px solid #ddd;
            }
            .heading-h3-heading:first-child
            {
                    line-height: 32px;
            }
            .heading-h3-heading
            {
                width: 50%;
                float: left;
                /* line-height: 34px; */
                text-transform: capitalize;
            }
            .page-content page-overflow { height:auto!important;}
            .page-container .page-content .page-content-wrap { background:#fff;  margin:0px; width: auto!important; float: none;   }
            .dataTables_filter { border-bottom:0!important; }
            .heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: block;  margin-top: 61px; border-bottom:1px solid #d7d7d7; font-size:14px;  }
            .heading-h2 a{  color: #444;      }
            .header-fixed-style { z-index:9999!important;}  
            /*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
            font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
            border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/

            .nav-contacts {/* float: right; width: 55%;*/ }
            .main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
            /*.main-container {margin:20px 12px; } */
            h2 { font-weight:100!important;  font-size:18px!important; padding:0; margin-top: 20px; }
            .col-md-12 {}
            .full-width-devider {  display:inline-block;padding: 15px 25px; box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px; background:#fff; width:100%;  margin-bottom:15px;   	}
            .dropdown-toggle{
                background: none !important;
                color: #53ad53 !important;
                border-color: #53ad53 !important;
            }
            .dropdown-toggle:hover {
                background: #53ad53 !important;
                color: #fff !important;
            }
            .table-bordered { border:1px solid #ddd!important;}
            .table thead tr th { padding:8px 5px!important; font-weight:600; }
            b, strong {
                font-weight:500;
            }
            .page-overflow { overflow:auto; }
            .panel { margin-bottom:20px; border:none; box-shadow:none;}
            .nav-contacts { /*margin-top:-40px;*/ float:right;}
            /*------------------------------------------*/

            .m-nav>li a,.m-nav--linetriangle>li a{display:inline-block;border-radius:0; padding:0px 20px 6px;margin-right:0;font-family:"Montserrat", "TenantCloud Sans", Avenir, sans-serif;font-weight:400;color:rgba(98,98,98,0.7);font-size:0.875rem;min-width:70px;text-transform:uppercase;border-color:transparent}
            .dataTables_scrollHeadInner {width:auto!important: padding:0!important;}
            .table.dataTable.no-footer {  margin-bottom:5px;}
            /*-----------------------------*/
            @media only screen and (min-width:320px) and (max-width:700px) { .dataTables_scrollBody { overflow-x:hidden!important;}
            }
            .dataTables_scroll {/* overflow-x:scroll!important;*/ width:100%; }
            .fa-search { font-size:22px; text-align:center;      padding:5px 2px; color:#072c48; font-weight:100; }
            @media only screen and (min-width: 680px) and (max-width: 800px){
                .icon { display:none;}

                ul.topnav li { width:20%; text-align:center;  border-right:1px solid #eee; }
                ul.topnav li a {  border-bottom:none!important;     } 
            }
            .x_content
            {
                padding:20px!important;
            }
            .rent
            {
                border-right:2px solid #f6f9fc;
                padding:18px;
                text-align:center;
                color: #0e84dc!important;
                border-color: #f6f9fc !important;	


            }
            .rent i
            {
                color:#41a541 !important;	

            }
            .rent:hover
            {
                background-color: #f6f9fc !important;
            }
            .leases
            {

                border-top: 2px solid #f6f9fc;
                padding:12px;
                text-align:center;
                color: #0e84dc!important;
                border-right:2px solid #f6f9fc;
                border-color: #f6f9fc) !important;



            word-wrap: break-word;
            }
            .leases i
            {
                color:#41a541 !important;	
            }
            .leases:hover
            {
                background-color: #f6f9fc !important;
            }
            .black_header thead tr th 
            {
                background: #333;
                color: #fff;
                border-color:#333;

            }
            .black_header
            {
                /*height: 235px!important;*/
                min-height: 100%!important;

            }
            .actions:hover
            {

                background: #ddd;
                border-radius: 50%;
            }
            .actions
            {
                padding: 10px;
            }
            .actions i
            {font-size:18px!important;}

            .denied
            {
                color:red;
            }
            .processed
            {
                color:green;
            }
            #list td
            {
                padding:15px!important;
                color: #0e84dc!important;
                font-size: 16px!important;
            }

            #list td a
            {
                color: #0e84dc!important;
                text-decoration:underline;
            }
            .subtitle1
            {
                text-align:center!important;
                padding-right:5px!important;
                cursor:pointer;
				padding-top: 10px;
            }
			.widget-title,.widget-int
			{
				text-align:center!important;
			}
			.production_dashboard
			{
				display:block!important;
			}
			.wrapper .x_content
			{
			    min-height: 210px;
			}
            .table>tbody>tr>td
            {
                padding: 4px 8px!important;
                vertical-align: middle!important;
            }
            .dropdown-selector {
                margin-top: -8px!important;
            }
        </style> 
    </head>
    <body>
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        <div class="heading-h3"> 
            <div class="heading-h3-heading">
                <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a>
            </div>
            <div class="heading-h3-heading">
                <?php 
                    $role_id=$this->session->userdata('role_id');
                    if($this->session->userdata('role_id')=='1'){
                ?>
                <div class="dropdown pull-right">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        Select Dashboard
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url()?>index.php/Dashboard"> Sales Dashboard </a></li>
                        <li><a href="<?php echo base_url()?>index.php/Dashboard/production"> Production Dashboard </a></li>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
        
        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap" style="margin-top: 0px;">
            <div class="row main-wrapper">
                <div class="main-container">           
                    <div class="box-shadow">
                        <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default" style="background:none!important">
                                    <div class="panel-body" style="background:none!important">
                                        <div class="row">
										  <div class="col-md-12">
										  
										    <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2> Other Pending Task</h2> 
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" >
                                                        <div class="table-responsive">
                                                            <table id="customers2" class="table datatable table-bordered black_header" >
                                                                <thead>
                                                                    <tr>
                                                                        <th width="55px">Sr. No.</th>
                                                                        <th>Task Name</th>
                                                                        <th>Assign To </th>
                                                                        <th>Priority </th>
																		<th>Due Date</th>
                                                                        <th>Status</th>
                                                                        <th style="text-align:center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    for ($i=0; $i < count($tasklist); $i++) { 
                                                                    ?>
                                                                        <tr>
                                                                           <td><?php echo $i+1; ?></td>
                                                                            <td><?php echo $tasklist[$i]->subject_detail; ?></td>
                                                                            <td><?php echo (($tasklist[$i]->name=='')?'Self':$tasklist[$i]->name); ?></td>
                                                                            <td><?php echo $tasklist[$i]->priority; ?></td>
    																		<td><?php echo date('d/m/Y',strtotime($tasklist[$i]->due_date)); ?></td>
                                                                            <td><?php echo $tasklist[$i]->task_status; ?></td>
                                                                            <td style="text-align:center;width: 180px;"> <a href="<?php echo base_url(); ?>index.php/Task/task_view/<?php echo urlencode($tasklist[$i]->id); ?>" style="color:#4aa90a!important;">Action</a> </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
											<div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2>  Purchase Order</h2> 
                                                        </div> 
                                                        <div class="clearfix"></div>
                                                    </div>
												<div class="x_content" >
													
										
										
												<div class="col-md-2">
													<div class="zoom">
														<a class="zoom-fab zoom-btn-large" id="zoomBtn"><i style="" class="fa fa-plus"></i></a>
                                                        <ul class="zoom-menu">
                                                            <li><a tooltip="Share" class="zoom-fab zoom-btn-sm zoom-btn-person scale-transition scale-out"  href="<?php echo base_url() . 'index.php/Purchase_order/add'; ?>">Raise PO</a></li>
                                                            <li><a class="zoom-fab zoom-btn-sm zoom-btn-doc scale-transition scale-out" href="<?php echo base_url() . 'index.php/Payment/add'; ?>" >Payment</a></li>
                                                            <li><a class="zoom-fab zoom-btn-sm zoom-btn-tangram scale-transition scale-out"  href="<?php echo base_url() . 'index.php/Raw_material_in/add'; ?>" >Raw Material In</a></li>
                                                        </ul>
													
												<div class="zoom-card scale-transition scale-out">
												  <ul class="zoom-card-content">
												  <li>Content</li>
												  
												
												  </ul>
												</div>
 
													</div>
												</div>
													<div class="col-md-3">
                                                        <div class="widget widget-blue  widget-item-icon widget-carousel animated flipInY">
                                                            <div>
                                                                <a href="<?php echo base_url(); ?>index.php/Purchase_order/checkstatus/Pending" style="color: #fafbfc;">
                                                                <div class="widget-data" style="padding-left:0px!important;">
                                                                    <div class="widget-title">Approval Pending</div>
                                                                    <div class="widget-int"><span data-toggle="counter"><?php if(isset($po_count)) echo $po_count[0]->pending_cnt; ?></span></div>
                                                                    <div class="widget-subtitle  subtitle1  ">(View All)</div>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
													</div>
													<div class="col-md-2">
                                                        <div class="widget widget-info  widget-item-icon widget-carousel animated flipInY">
                                                            <div>
                                                                <a href="<?php echo base_url(); ?>index.php/Purchase_order/checkstatus/open" style="color: #fafbfc;">
                                                                <div class="widget-data" style="padding-left:0px!important;">
                                                                    <div class="widget-title">Open</div>
                                                                    <div class="widget-int"> <span data-toggle="counter"><?php if(isset($po_count)) echo $po_count[0]->open_cnt; ?></span></div>
																    <div class="widget-subtitle  subtitle1  ">(View All)</div>
                                                                </div>
                                                                </a>
                                                            </div>
                                                        </div>
													</div>
													
													<div class="col-md-3">
														<div class="widget widget-yellow  widget-item-icon widget-carousel animated flipInY">
															<div>
                                                                <a href="<?php echo base_url(); ?>index.php/Purchase_order/checkstatus/payment_pending" style="color: #fafbfc;">
                                                                <div class="widget-data" style="padding-left:0px!important;">
                                                                    <div class="widget-title">Payment Pending</div>
                                                                    <div class="widget-int"> <span data-toggle="counter"><?php if(isset($po_count)) echo $po_count[0]->pending_payment_cnt; ?></span></div>
                                                                    <div class="widget-subtitle  subtitle1  ">(View All)</div>
                                                                </div>
                                                                </a>
															</div>
														</div>
													</div>

													<div class="col-md-2">
														<div class="widget widget-red  widget-item-icon widget-carousel animated flipInY">
                                                            <div>
                                                                <a href="<?php echo base_url(); ?>index.php/Purchase_order/checkstatus/advance" style="color: #fafbfc;">
                                                                <div class="widget-data" style="padding-left:0px!important;">
                                                                    <div class="widget-title">Advance</div>
                                                                    <div class="widget-int"> <span data-toggle="counter"><?php if(isset($po_count)) echo $po_count[0]->advance_payment_cnt; ?></span></div>
                                                                    <div class="widget-subtitle  subtitle1  ">(View All)</div>
                                                                </div>
                                                                </a>
															</div>
														</div>
													</div>

                                          
												</div>
											</div>
										</div>
										</div>
                                          
										<div class="row">
                                            <div class="col-md-12">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2>  Pre-Producation Task</h2> 
                                                        </div> 
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content">
    													<div class="col-md-2">
                                                            <div class="zoom">
        														<a class="zoom-fab zoom-btn-large" id="zoomBtn1"><i class="fa fa-plus"></i></a>
        														<ul class="zoom-menu " id="zoom-menu1">
                                                                    <li><a class="zoom-fab zoom-btn-sm1 zoom-btn-person scale-transition scale-out1" href="<?php echo base_url() . 'index.php/production/add'; ?>">Raise Production</a></li>
                                                                    <!-- <li><a class="zoom-fab zoom-btn-sm1 zoom-btn-doc scale-transition scale-out1" href="<?php //echo base_url() . 'index.php/Purchase_order/add'; ?>">Email</a></li> -->
                                                                </ul>
    														</div>
    													</div>
														<div class="col-md-10">
                                                        <div class="table-responsive">
                                                            <table id="" class="table datatable table-bordered black_header" >
                                                                <thead>
                                                                    <tr>
																		<th style="width: 60px;">Sr. No.</th>
                                                                        <!-- <th>Date</th> -->
                                                                        <th>Ref Id</th>
                                                                        <th style="width: 200px;">Manufacturer</th>
                                                                        <th>From Date</th>
                                                                        <th>To Date</th>
                                                                        <th style="width: 200px;">Description</th>
                                                                        <th style="width: 200px;">Status</th>
                                                                        <th style="width: 90px; text-align: center;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php for($i=0; $i<count($pre_production); $i++) { ?>
                                                                    <tr>
                                                                        <td><?php echo $i+1; ?></td>
                                                                        <!--<td><?php //echo (($pre_production[$i]->notification_date!=null && $pre_production[$i]->notification_date!='')?date('d/m/Y',strtotime($pre_production[$i]->notification_date)):'');?></td>-->
                                                                        <td><?php echo $pre_production[$i]->p_id; ?></td>
                                                                        <td><?php echo $pre_production[$i]->depot_name; ?></td>
                                                                        <td><?php if($pre_production[$i]->notification_id=='2') echo date('d/m/Y', strtotime($pre_production[$i]->from_date)); else echo date('d/m/Y', strtotime($pre_production[$i]->confirm_from_date)); ?></td>
                                                                        <td><?php if($pre_production[$i]->notification_id=='2') echo date('d/m/Y', strtotime($pre_production[$i]->to_date)); else echo date('d/m/Y', strtotime($pre_production[$i]->confirm_to_date)); ?></td>
                                                                        <td><?php echo $pre_production[$i]->notification; ?></td>
                                                                        <td><?php echo $pre_production[$i]->p_status; ?></td>
                                                                        <td style="text-align:center;"> 
                                                                            <?php 
                                                                                $url = "";
                                                                                if($pre_production[$i]->notification_id=='3') {
                                                                                    $url = base_url(). "index.php/production/edit/preliminary_check/" . $pre_production[$i]->reference_id;
                                                                                } else if(strtoupper(trim($pre_production[$i]->p_status))=='REQUESTED') {
                                                                                    $url = base_url(). "index.php/production/edit/confirmed/" . $pre_production[$i]->reference_id;
                                                                                } else if(strtoupper(trim($pre_production[$i]->p_status))=='CONFIRMED') {
                                                                                    $url = base_url(). "index.php/production/edit/batch_confirmed/" . $pre_production[$i]->reference_id;
                                                                                } else if(strtoupper(trim($pre_production[$i]->p_status))=='BATCH CONFIRMED') {
                                                                                    $url = base_url(). "index.php/production/edit/raw_material_confirmed/" . $pre_production[$i]->reference_id;
                                                                                } else if(strtoupper(trim($pre_production[$i]->p_status))=='RAW MATERIAL CONFIRMED') {
                                                                                    $url = base_url(). "index.php/production/edit/raw_material_confirmed/" . $pre_production[$i]->reference_id;
                                                                                } 
                                                                            ?>
                                                                            <a href="<?php echo $url; ?>" style="color:#4aa90a!important;"><span class="actions">Confirm</span></a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                    <!-- <tr>
                                                                        <td>2018-12-13 11:56</td>
                                                                        <td>Production Report Upload</td>
                                                                        <td class="processed">Processed</td>
                                                                        <td style="text-align:center;width: 180px;"> <span class="actions"><i class="fa fa-paper-plane "></i></span> <span class="actions"><i class="fa fa-trash-o "></span></i> <span class="actions"> <i class="fa fa-pencil "></i></span> <span class="actions"><i class="fa fa-ellipsis-h "></i></span> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2018-12-13 11:56</td>
                                                                        <td >Bar Conversion</td>
                                                                        <td class="denied">Denied</td>
                                                                        <td style="text-align:center;width: 180px;"> <span class="actions"><i class="fa fa-paper-plane "></i></span> <span class="actions"><i class="fa fa-trash-o "></span></i> <span class="actions"> <i class="fa fa-pencil "></i></span> <span class="actions"><i class="fa fa-ellipsis-h "></i></span> </td>
                                                                    </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2>  Post-Producation Task</h2> 
                                                        </div> 
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" >
													
													<div class="col-md-2">
														<div class="zoom">
															<a class="zoom-fab zoom-btn-large" id="zoomBtn2"><i class="fa fa-plus"></i></a>
															<ul class="zoom-menu">
															  <li><a class="zoom-fab zoom-btn-sm2 zoom-btn-person scale-transition scale-out2" ><i style="" class="fa fa-user"></i></a></li>
															  <li><a class="zoom-fab zoom-btn-sm2 zoom-btn-doc scale-transition scale-out2" href="#" ><i class="fa fa-book"></i></a></li>
															  <li><a class="zoom-fab zoom-btn-sm2 zoom-btn-tangram scale-transition scale-out2" ><i class="fa fa-dashboard"></i></a></li>
															 
															</ul>
 
														</div>
													</div>
														<div class="col-md-10">
                                                        <div class="table-responsive">
                                                            <table id="" class="table datatable table-bordered black_header" >
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 60px;">Sr. No.</th>
                                                                        <!-- <th>Date</th> -->
                                                                        <th>Ref Id</th>
                                                                        <th style="width: 200px;">Manufacturer</th>
                                                                        <th>From Date</th>
                                                                        <th>To Date</th>
                                                                        <th style="width: 200px;">Description</th>
                                                                        <th style="width: 200px;">Status</th>
                                                                        <th style="width: 90px; text-align: center;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php for($i=0; $i<count($post_production); $i++) { ?>
                                                                    <tr>
                                                                        <td><?php echo $i+1; ?></td>
                                                                        <!--<td><?php //echo (($post_production[$i]->notification_date!=null && $post_production[$i]->notification_date!='')?date('d/m/Y',strtotime($post_production[$i]->notification_date)):'');?></td>-->
                                                                        <td><?php echo $post_production[$i]->p_id; ?></td>
                                                                        <td><?php echo $post_production[$i]->depot_name; ?></td>
                                                                        <td><?php echo date('d/m/Y', strtotime($post_production[$i]->confirm_from_date)); ?></td>
                                                                        <td><?php echo date('d/m/Y', strtotime($post_production[$i]->confirm_to_date)); ?></td>
                                                                        <td><?php echo $post_production[$i]->notification; ?></td>
                                                                        <td>
                                                                            <?php 
                                                                                if($post_production[$i]->batch_master==null || $post_production[$i]->batch_master=='0') 
                                                                                    echo 'Confirm Batch Nos.';
                                                                                else if($post_production[$i]->production_details==null || $post_production[$i]->production_details=='0') 
                                                                                    echo 'Confirm Production Details.';
                                                                                else if($post_production[$i]->bar_conversion==null || $post_production[$i]->bar_conversion=='0') 
                                                                                    echo 'Perform Bar Conversion.';
                                                                                else if($post_production[$i]->depot_transfer==null || $post_production[$i]->depot_transfer=='0') 
                                                                                    echo 'Perform Depot Transfer.';
                                                                                else if($post_production[$i]->documents_upload==null || $post_production[$i]->documents_upload=='0') 
                                                                                    echo 'Perform Documents Upload.';
                                                                                else if($post_production[$i]->raw_material_recon==null || $post_production[$i]->raw_material_recon=='0') 
                                                                                    echo 'Perform Raw Material Recon.';
                                                                                else if($post_production[$i]->report_approved==null || $post_production[$i]->report_approved=='0') {
                                                                                    if($post_production[$i]->report_status==null || $post_production[$i]->report_status==''){
                                                                                        echo 'Submit Production Report For Approval.';
                                                                                    } else if(strtoupper(trim($post_production[$i]->report_status))=='PENDING'){
                                                                                        echo 'Approve Production Report.';
                                                                                    } else if(strtoupper(trim($post_production[$i]->report_status))=='REJECTED'){
                                                                                        echo 'Production Report Rejected.';
                                                                                    } else {
                                                                                        echo 'Approve Report.';
                                                                                    }
                                                                                }
                                                                                else echo $post_production[$i]->p_status;
                                                                            ?>
                                                                        </td>
                                                                        <td style="text-align:center;"> 
                                                                            <?php 
                                                                                $url = base_url(). "index.php/production/post_details/" . $post_production[$i]->reference_id;
                                                                                // if(strtoupper(trim($post_production[$i]->p_status))=='REQUESTED') {
                                                                                //     $url = base_url(). "index.php/production/edit/confirmed/" . $post_production[$i]->reference_id;
                                                                                // } else if(strtoupper(trim($post_production[$i]->p_status))=='CONFIRMED') {
                                                                                //     $url = base_url(). "index.php/production/edit/batch_confirmed/" . $post_production[$i]->reference_id;
                                                                                // } else if(strtoupper(trim($post_production[$i]->p_status))=='BATCH CONFIRMED') {
                                                                                //     $url = base_url(). "index.php/production/edit/raw_material_confirmed/" . $post_production[$i]->reference_id;
                                                                                // } else if(strtoupper(trim($post_production[$i]->p_status))=='RAW MATERIAL CONFIRMED') {
                                                                                //     $url = base_url(). "index.php/production/edit/raw_material_confirmed/" . $post_production[$i]->reference_id;
                                                                                // } 
                                                                            ?>
                                                                            <a href="<?php echo $url; ?>" style="color:#4aa90a!important"><span class="actions"> Confirm</span></a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                    <!-- <tr>
                                                                        <td>2018-12-13 11:56</td>
                                                                        <td>Production Report Upload</td>
                                                                        <td class="processed">Processed</td>
                                                                        <td style="text-align:center;width: 180px;"> <span class="actions"><i class="fa fa-paper-plane "></i></span> <span class="actions"><i class="fa fa-trash-o "></span></i> <span class="actions"> <i class="fa fa-pencil "></i></span> <span class="actions"><i class="fa fa-ellipsis-h "></i></span> </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2018-12-13 11:56</td>
                                                                        <td >Bar Conversion</td>
                                                                        <td class="denied">Denied</td>
                                                                        <td style="text-align:center;width: 180px;"> <span class="actions"><i class="fa fa-paper-plane "></i></span> <span class="actions"><i class="fa fa-trash-o "></span></i> <span class="actions"> <i class="fa fa-pencil "></i></span> <span class="actions"><i class="fa fa-ellipsis-h "></i></span> </td>
                                                                    </tr> -->
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
                                <br clear="all"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
        </div>            
        <!-- END PAGE CONTENT -->	
        </div>
        <!-- END PAGE CONTAINER -->

 <script src="<?php echo base_url(); ?>dashboard/src/js/index.js" type="text/javascript"></script> 

        <?php $this->load->view('templates/footer');?>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
        <!-- END SCRIPTS -->      
    </body>
</html>