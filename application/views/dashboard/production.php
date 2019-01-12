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
        <!-- EOF CSS INCLUDE -->

        <style>
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
            h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
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
                height: 235px!important;
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
                text-align:right!important;
                padding-right:5px!important;
                cursor:pointer;
            }
        </style> 
    </head>
    <body>
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
        <div class="heading-h2">  Dashboard </div>
        
        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">
            <div class="row main-wrapper">
                <div class="main-container">           
                    <div class="box-shadow">
                        <div class="box-shadow-inside">
                            <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default" style="background:none!important">
                                    <div class="panel-body" style="background:none!important">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2>Quick View  </h2> 
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" >
                                                        <div class="widget widget-blue  widget-item-icon widget-carousel animated flipInY">
                                                            <div>  
                                                                <div class="widget-item-left">
                                                                    <span class="fa fa-life-ring"></span>
                                                                </div>                             
                                                                <div class="widget-data">
                                                                    <div class="widget-title">Support Questions</div>
                                                                    <div class="widget-subtitle">(In Box)</div>
                                                                    <div class="widget-int"><span data-toggle="counter">1229</span></div>
                                                                    <div class="widget-subtitle subtitle1 pull-right">(View All)</div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="widget widget-info  widget-item-icon widget-carousel animated flipInY">
                                                            <div>  
                                                                <div class="widget-item-left">
                                                                    <span class="fa fa-shopping-cart"></span>
                                                                </div>                             
                                                                <div class="widget-data">
                                                                    <div class="widget-title">Total Orders</div>
                                                                    <div class="widget-int"> <span data-toggle="counter">38</span></div>
                                                                    <div class="widget-subtitle  subtitle1 pull-right ">(View All)</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2>  Purchased Order</h2> 
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>   
                                                    <div class="x_content" style="padding: 0 5px 6px!important;" >
                                                        <div class="table-responsive">
                                                            <table id="list" class="table table-bordered" style="margin-bottom: 0px; ">
                                                                <tbody>
                                                                    <tr>
                                                                        <td><a href="">Purchased Order Open</a></td>
                                                                        <td><a href="">8</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><a href="">PO Approval Pending</a></td>
                                                                        <td><a href="">4</td>
                                                                    </tr>
                                                                    <a href=""> <tr>
                                                                        <td> <a href="">Advanced Payment PO</a></td>
                                                                        <td> <a href="">5</a></td>
                                                                    </tr></a>
                                                                    <tr>
                                                                        <td><a href="">Payment Pending</a></td>
                                                                        <td><a href="">6</a></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2>   Quick buttons </h2> 
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" >
                                                        <div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box">
                                                            <div class="row">
                                                                <div class=" col-md-4 rent" style="border-right: 2px solid #f6f9fc;padding: 21px">
                                                                    <a href=""><i style="font-size:24px;" class="fa fa-group "></i><br>
                                                                        RM In <p></p>
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-4 rent" style="border-right: 2px solid #f6f9fc;">
                                                                    <a href=""><i style="font-size:24px;" class="fa fa-home"></i><br>
                                                                        Payment Voucher
                                                                    </a>
                                                                </div>
                                                                <div class=" col-md-4 rent" style="border-right:none;padding:18px">
                                                                    <a href=""><i style="font-size:24px;" class="fa fa-file-text-o "></i><br>
                                                                        Purchase Order
                                                                    </a>
                                                                </div>
                                                                <div class="col-md-4 leases" style="border-right: 2px solid #f6f9fc;padding: 21px">
                                                                    <a href=""><i style="font-size:24px;" class="fa fa-wrench"></i><br>
                                                                        Create PR
                                                                    </a>
                                                                </div>
                                                                <div class=" col-md-4 leases">
                                                                    <a href=""><i style="font-size:24px;" class="fa fa-rupee "></i><br>
                                                                        Raw Material Recon
                                                                    </a>
                                                                </div>
                                                                <div class=" col-md-4 leases" style="border-right:none;">
                                                                    <a href=""><i style="font-size:24px;" class="fa fa-money"></i><br>
                                                                        View Productions
                                                                    </a>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2>  Pre-Producation Task</h2> 
                                                        </div> 
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" >
                                                        <div class="table-responsive">
                                                            <table id="" class="table datatable table-bordered black_header" >
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>Description</th>
                                                                        <th>Status</th>
                                                                        <th style="text-align:center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php for($i=0; $i<count($pre_production); $i++) { ?>
                                                                    <tr>
                                                                        <td><?php echo (($pre_production[$i]->notification_date!=null && $pre_production[$i]->notification_date!='')?date('d/m/Y',strtotime($pre_production[$i]->notification_date)):'');?></td>
                                                                        <td><?php echo $pre_production[$i]->notification; ?></td>
                                                                        <td class="processed"><?php echo $pre_production[$i]->p_status; ?></td>
                                                                        <td style="text-align:center; width: 180px;"> 
                                                                            <?php 
                                                                                $url = "";
                                                                                if(strtoupper(trim($pre_production[$i]->p_status))=='REQUESTED') {
                                                                                    $url = base_url(). "index.php/production/edit/confirmed/" . $pre_production[$i]->reference_id;
                                                                                } else if(strtoupper(trim($pre_production[$i]->p_status))=='CONFIRMED') {
                                                                                    $url = base_url(). "index.php/production/edit/batch_confirmed/" . $pre_production[$i]->reference_id;
                                                                                } else if(strtoupper(trim($pre_production[$i]->p_status))=='BATCH CONFIRMED') {
                                                                                    $url = base_url(). "index.php/production/edit/raw_material_confirmed/" . $pre_production[$i]->reference_id;
                                                                                } else if(strtoupper(trim($pre_production[$i]->p_status))=='RAW MATERIAL CONFIRMED') {
                                                                                    $url = base_url(). "index.php/production/edit/raw_material_confirmed/" . $pre_production[$i]->reference_id;
                                                                                } 
                                                                            ?>
                                                                            <a href="<?php echo $url; ?>"><span class="actions"><i class="fa fa-check"></i></span></a>
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
                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2>  Post-Producation Task</h2> 
                                                        </div> 
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" >
                                                        <div class="table-responsive">
                                                            <table id="" class="table datatable table-bordered black_header" >
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>Description</th>
                                                                        <th>Status</th>
                                                                        <th style="text-align:center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php for($i=0; $i<count($post_production); $i++) { ?>
                                                                    <tr>
                                                                        <td><?php echo (($post_production[$i]->notification_date!=null && $post_production[$i]->notification_date!='')?date('d/m/Y',strtotime($post_production[$i]->notification_date)):'');?></td>
                                                                        <td><?php echo $post_production[$i]->notification; ?></td>
                                                                        <td class="processed"><?php echo $post_production[$i]->p_status; ?></td>
                                                                        <td style="text-align:center; width: 180px;"> 
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
                                                                            <a href="<?php echo $url; ?>"><span class="actions"><i class="fa fa-check"></i></span></a>
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

                                                <div class="x_panel">
                                                    <div class="x_title">
                                                        <div class="  pull-left">
                                                            <h2> Other Pending Task</h2> 
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="x_content" >
                                                        <div class="table-responsive">
                                                            <table id="" class="table datatable table-bordered black_header" >
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>Description</th>
                                                                        <th>Status</th>
                                                                        <th style="text-align:center">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>2018-12-13 11:56</td>
                                                                        <td>Create Producation</td>
                                                                        <td class="processed">Processed</td>
                                                                        <td style="text-align:center;width: 180px;"> <span class="actions"><i class="fa fa-paper-plane "></i></span> <span class="actions"><i class="fa fa-trash-o "></span></i> <span class="actions"> <i class="fa fa-pencil "></i></span> <span class="actions"><i class="fa fa-ellipsis-h "></i></span> </td>
                                                                    </tr>
                                                                    <tr>
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
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2018-12-13 11:56</td>
                                                                        <td>Depot Transfer</td>
                                                                        <td class="denied">Denied</td>
                                                                        <td style="text-align:center;width: 180px;"> <span class="actions"><i class="fa fa-paper-plane "></i></span> <span class="actions"><i class="fa fa-trash-o "></span></i> <span class="actions"> <i class="fa fa-pencil "></i></span> <span class="actions"><i class="fa fa-ellipsis-h "></i></span> </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
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

        <?php $this->load->view('templates/footer');?>
        <!-- END SCRIPTS -->      
    </body>
</html>