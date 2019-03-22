<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>EAT ERP</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="<?php echo base_url(); ?>img/favicon.png" type="image/x-icon" />
        <!-- END META SECTION -->

        <!-- CSS INCLUDE -->        
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
        <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
 
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
        .main-container {margin:20px 12px; } 
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
        </style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <div class="heading-h3"> 
                    <div class="heading-h3-heading">
                        <a href="<?php echo base_url().'index.php/dashboard'; ?>">  Dashboard  </a>
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
                <div class="page-content-wrapper ">
                <div class="row main-wrapper"> 
                    <div class="main-container">
                    <div class="full-width" style="">
                        <div class="main_container">
                        <!-- page content -->
                        <div class=" " role="main">
                        <!-- START WIDGETS -->                    
                        <div class="row mobile-bg">
                            <div class=" col-md-3 col-sm-6 col-xs-12 div-size">
                                <!-- START WIDGET SLIDER -->
                                <div class="widget widget-blue  widget-item-icon widget-carousel animated flipInY">
                                    <div class="owl-carousel  " id="owl-example">  
                                        <div>    
                                            <div class="widget-item-left">
                                                <span class="fa fa-exchange  "></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total Sale</div>
                                                <div class="widget-subtitle">(In Amount)</div>
                                                <div class="widget-int"> &#8377; <span data-toggle="counter" data-to="<?php if(isset($total_sale[0]->total_amount)) echo format_money($total_sale[0]->total_amount,0);?>" style="font-size: 25px;"><?php if(isset($total_sale[0]->total_amount)) echo format_money(($total_sale[0]->total_amount/100000),2) . ' L';?></span></div>
                                            </div>   
                                        </div>
                                        <div>  
                                            <div class="widget-item-left">
                                                <span class="fa fa-exchange"></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total Sale</div>
                                                <div class="widget-subtitle">(In Bar)</div>
                                                <div class="widget-int"> <span data-toggle="counter" data-to="<?php if(isset($total_sale[0]->total_bar)) echo format_money($total_sale[0]->total_bar,2);?>"><?php if(isset($total_sale[0]->total_bar)) echo format_money($total_sale[0]->total_bar,2);?></span></div>
                                            </div>  
                                        </div>

                                        <div>  
                                            <div class="widget-item-left">
                                                <span class="fa fa-exchange"></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total Sale</div>
                                                <div class="widget-subtitle">(In Box)</div>
                                                <div class="widget-int">   <span data-toggle="counter" data-to="<?php if(isset($total_sale[0]->total_box)) echo format_money($total_sale[0]->total_box,2);?>"><?php if(isset($total_sale[0]->total_box)) echo format_money($total_sale[0]->total_box,2);?></span></div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <!-- END WIDGET SLIDER -->
                            </div>
                            <div class=" col-md-3 col-sm-6 col-xs-12 div-size">
                                <!-- START WIDGET SLIDER -->
                                <div class="widget widget-info  widget-item-icon widget-carousel animated flipInY">
                                    <div class="owl-carousel  " id="owl-example">
                                        <div>
                                            <div class="widget-item-left">
                                                <span class="fa fa-retweet  "></span>
                                            </div>
                                            <div class="widget-data">
                                                <div class="widget-title">Total  <br> Distributors</div>

                                                <div class="widget-int"> <span data-toggle="counter" data-to="<?php if(isset($total_dist[0]->tot_dist)) echo format_money($total_dist[0]->tot_dist,2);?>"><?php if(isset($total_dist[0]->tot_dist)) echo format_money($total_dist[0]->tot_dist,2);?></span></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="widget-item-left">
                                                <span class="fa fa-retweet  "></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total  <br> General Trade </div>
                                                <div class="widget-int"> <span data-toggle="counter" data-to="<?php if(isset($total_dist[0]->tot_g_trade)) echo format_money($total_dist[0]->tot_g_trade,2);?>"><?php if(isset($total_dist[0]->tot_g_trade)) echo format_money($total_dist[0]->tot_g_trade,2);?></span></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="widget-item-left">
                                                <span class="fa fa-retweet"></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total  <br> Modern Trade</div>
                                                <div class="widget-int">   <span data-toggle="counter" data-to="<?php if(isset($total_dist[0]->tot_m_trade)) echo format_money($total_dist[0]->tot_m_trade,2);?>"><?php if(isset($total_dist[0]->tot_m_trade)) echo format_money($total_dist[0]->tot_m_trade,2);?></span></div>
                                            </div> 
                                        </div>
                                        <div>
                                            <div class="widget-item-left">
                                                <span class="fa fa-retweet"></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total  <br>  E Commerce</div>
                                                <div class="widget-int">   <span data-toggle="counter" data-to="<?php if(isset($total_dist[0]->tot_e_com)) echo format_money($total_dist[0]->tot_e_com,2);?>"><?php if(isset($total_dist[0]->tot_e_com)) echo format_money($total_dist[0]->tot_e_com,2);?></span></div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>         
                                <!-- END WIDGET SLIDER -->
                            </div>

                            <a href="<?php echo base_url();?>index.php/Dashboard/stock">
                                <div class="col-md-3 col-sm-6 col-xs-12 div-size">
                                    <!-- START WIDGET SLIDER -->
                                    <div class="widget widget-yellow  widget-item-icon widget-carousel animated flipInY">
                                        <div class="owl-carousel  " id="owl-example">
                                            <div>
                                                <div class="widget-item-left">
                                                    <span class="fa fa-hdd-o  "></span>
                                                </div>                             
                                                <div class="widget-data">
                                                    <div class="widget-title">Total  Bar <br> Stock</div>
                                                    <div class="widget-int">   <span data-toggle="counter" data-to="<?php if(isset($total_stock['tot_bar'])) echo format_money($total_stock['tot_bar'],2);?>"><?php if(isset($total_stock['tot_bar'])) echo format_money($total_stock['tot_bar'],2);?></span></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="widget-item-left">
                                                    <span class="fa fa-hdd-o  "></span>
                                                </div>                             
                                                <div class="widget-data">
                                                    <div class="widget-title">Total   Box <br> Stock</div>
                                                    <div class="widget-int"> <span data-toggle="counter" data-to="<?php if(isset($total_stock['tot_box'])) echo format_money($total_stock['tot_box'],2);?>"><?php if(isset($total_stock['tot_box'])) echo format_money($total_stock['tot_box'],2);?></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>         
                                    <!-- END WIDGET SLIDER -->
                                </div>
                            </a>

                            <div class=" col-md-3 col-sm-6 col-xs-12 div-size">
                                <!-- START WIDGET CLOCK -->
                                <div class="widget widget-red  widget-item-icon  animated flipInY">
                                    <div class="widget-item-left">
                                        <span class="fa fa-inr  "></span>
                                    </div>                             
                                    <div class="widget-data">
                                        <div class="widget-title">Total <br> Receivable</div>
                                        <div class="widget-int" style="font-size: 25px;">  &#8377;  <span data-toggle="counter" data-to="<?php if(isset($total_receivable[0]->total_receivable)) echo format_money($total_receivable[0]->total_receivable,0);?>"><?php if(isset($total_receivable[0]->total_receivable)) echo format_money($total_receivable[0]->total_receivable,0);?></span></div>
                                    </div>                             
                                </div>                        
                                <!-- END WIDGET CLOCK -->
                            </div>
                        </div>
                        <!-- END WIDGETS -->  

                        <div class="">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="  pull-left">
                                                <h2>Sales Trend (In Rs) </h2> 
                                            </div> 
                                            <div class="filter">
                                                <div id="reportrange" class="pull-right " style=" ">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class=" ">
                                                <div class="demo-container" style="height:280px">
                                                    <div id="placeholder31x" class="demo-placeholder"></div>
                                                </div>
                                                <div class="tiles tiles-range">
                                                    <div class="col-md-4 col-sm-4  col-xs-4 tile-space">
                                                        <span>Total Sale</span>
                                                        <h2 id="total_sale_in_rs">  500 </h2>
                                                        <span class="sparkline11 graph" style="height: 160px;">
                                                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4  col-sm-4 col-xs-4 tile-space">
                                                        <span>Avg. Day Sale</span>
                                                        <h2 id="avg_day_sale_in_rs"> 1000</h2>
                                                        <span class="sparkline12 graph" style="height: 160px;">
                                                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4  col-sm-4  col-xs-4 tile-space">
                                                        <span>Avg. Total Sale</span>
                                                        <h2 id="avg_total_sale_in_rs"> 2500 </h2>
                                                        <span class="sparkline13 graph" style="height: 160px;">
                                                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="dropdown dropdown-select drpdwn-bg pull-left">
                                                <input type="hidden" id="dropdownMenu1_text" value="Bar" />
                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                    Sales Trend    (In Bar) 
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu cstm-menu" id="dropdownMenu1" role="menu" aria-labelledby="dropdownMenu1">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"> Sales Trend  (In Bar)   </a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"> Sales Trend  (In Box)  </a></li>

                                                </ul>
                                            </div>

                                            <div class="filter">
                                                <div id="reportrange1" class="pull-right"  >
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class=" ">
                                                <div class="demo-container" style="height:280px">
                                                    <div id="placeholder32x" class="demo-placeholder"></div>
                                                </div>
                                                <div class="tiles tiles-range">
                                                    <div class="col-md-4  col-sm-4  col-xs-4 tile-space">
                                                        <span>Total Sale</span>
                                                        <h2 id="total_sale">  1000 </h2>
                                                        <span class="sparkline21 graph" style="height: 160px;">
                                                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4  col-sm-4  col-xs-4 tile-space">
                                                        <span>Avg. Day Sale</span>
                                                        <h2 id="avg_day_sale"> 2000 </h2>
                                                        <span class="sparkline22 graph" style="height: 160px;">
                                                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4  col-sm-4  col-xs-4 tile-space">
                                                        <span>Avg. Total Sale</span>
                                                        <h2 id="avg_total_sale"> 3000</h2>
                                                        <span class="sparkline23 graph" style="height: 160px;">
                                                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row  margin-top">	
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="dropdown dropdown-select drpdwn-bg pull-left">
                                                <input type="hidden" id="dropdownMenu2_text" value="Bar" />
                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                    Product Wise Sale (In Bar) 
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu cstm-menu" id="dropdownMenu2" role="menu" aria-labelledby="dropdownMenu2">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"> Product Wise Sale (In Bar) </a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"> Product Wise Sale (In Box) </a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"> Month Wise Sale  (In Box) </a></li>
                                                </ul>
                                            </div>
                                            <div class="filter">
                                                <div id="reportrange2" class="pull-right" style=" ">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" >
                                            <canvas id="canvas_bar"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="dropdown dropdown-select drpdwn-bg pull-left">
                                                <input type="hidden" id="dropdownMenu3_text" value="Bar" />
                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                    SM Wise Sale (In Bar)
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu cstm-menu" id="dropdownMenu3" role="menu" aria-labelledby="dropdownMenu3">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);">SM Wise Sale (In Bar)</a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);">Month Wise Sale (In Bar)</a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);">GT & Month Wise Sale</a></li>
                                                </ul>
                                            </div>
                                            <div class="filter">
                                                <div id="reportrange3" class="pull-right" style=" ">
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <canvas id="canvas_bar-1"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row  margin-top">	
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="dropdown dropdown-select drpdwn-bg pull-left">
                                                <input type="hidden" id="dropdownMenu4_text" value="Category" />
                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
                                                    Category Wise Sale	
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu cstm-menu" id="dropdownMenu4" role="menu" aria-labelledby="dropdownMenu4">
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);">  Category Wise Sale</a></li>
                                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);">   Category & Month Wise Sale</a></li>

                                                </ul>
                                            </div>

                                            <div class="filter">
                                                <div id="reportrange4" class="pull-right"  >
                                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <canvas id="canvas_bar-2"></canvas>
                                            <!-- <div id="graph_bar" style="width:100%; height:350px;"></div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <!-- /page content -->
                    </div>
                    </div>
                </div>
                </div>
            </div>
        <!-- END PAGE CONTENT WRAPPER -->
        </div>

        <?php $this->load->view('templates/footer');?>

    <!-- moris js -->
    <script src="<?php echo base_url(); ?>dashboard/js/moris/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>dashboard/js/moris/morris.js"></script>
 
    <script src="<?php echo base_url(); ?>dashboard/js/nicescroll/jquery.nicescroll.min.js"></script>

    <!-- chart  -->
    <script src="<?php echo base_url(); ?>dashboard/js/chartjs/chart.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script> -->


    <!-- bootstrap progress js -->
    <script src="<?php echo base_url(); ?>dashboard/js/progressbar/bootstrap-progressbar.min.js"></script>
    <!-- icheck -->
    <script src="<?php echo base_url(); ?>dashboard/js/icheck/icheck.min.js"></script>
    <!-- daterangepicker -->
  
    <!-- sparkline -->
    <script src="<?php echo base_url(); ?>dashboard/js/sparkline/jquery.sparkline.min.js"></script>

    <script src="<?php echo base_url(); ?>dashboard/js/custom.js"></script>

    <!-- flot js -->
    <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/jquery.flot.orderBars.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/date.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/jquery.flot.spline.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/jquery.flot.stack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/curvedLines.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/flot/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/plugins/owl/owl.carousel.min.js"></script>  
     <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/plugins/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>dashboard/js/plugins/daterangepicker/daterangepicker.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

    <!-- flot -->
    <script type="text/javascript">
        //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
        var chartColours = ['#4aa90a', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];

        //generate random number for charts
        randNum = function () {
            return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
        }

        function toDate(date) {
            var from = date.split("-");
            return new Date(from[0], from[1] - 1, from[2]);
        }
    </script>

    <!-- datepicker -->
    <script type="text/javascript">
        var myPieChart = null;
        var myPieChart1 = null;
        var myPieChart2 = null;

        function set_sales_trend_in_rs(from_date, to_date) {
            var d1 = [];
            var data_len=1;
            
            Date.prototype.yyyymmdd = function() {
                var yyyy = this.getFullYear().toString();
                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = this.getDate().toString();
                return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); // padding
            };
            
            from_date = from_date.yyyymmdd();
            to_date = to_date.yyyymmdd();

            $.ajax({
                url: "<?php echo base_url() . 'index.php/Dashboard/get_sales_trend_in_rs' ?>",
                data: 'from_date=' + from_date + '&to_date=' + to_date,
                cache: false,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    for (var i = 0; i<data.length; i++) {
                        data[i][0] = toDate(data[i][0]).getTime();
                        d1.push([data[i][0], data[i][1]]);
                    }
                },
                error: function () {
                }
            });
            
            var len = d1.length-1;
            var chartMinDate = from_date; //first day
            var chartMaxDate = to_date; //last day

            if(d1.length>0){
                var chartMinDate = d1[0][0]; //first day
                var chartMaxDate = d1[len][0]; //last day
            }
            
            var tickSize = [1, "day"];
            var tformat = "%d/%m/%y";

            //graph options
            var options = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function (label, series) {
                        // just add some space to labes
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: chartColours,
                shadowSize: 0,
                tooltip: true, //activate tooltip
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "time",
                    minTickSize: tickSize,
                    timeformat: tformat,
                    min: chartMinDate,
                    max: chartMaxDate
                }
            };

            var plot = $.plot($("#placeholder31x"), [{
                label: "Sales",
                data: d1,
                lines: {
                    fillColor: "rgba(150, 202, 89, 0.12)"
                }, //#96CA59 rgba(150, 202, 89, 0.42)
                points: {
                    fillColor: "#fff"
                }
            }], options);
            
            d2 = [];
            var total_sale_in_rs=0;
            for (var i = 0; i<d1.length; i++) {
                d2.push(d1[i][1]);
                total_sale_in_rs=total_sale_in_rs+parseFloat(d1[i][1]);
            }
            $(".sparkline11").sparkline(d2, {
                type: 'bar',
                height: '40',
                barWidth: 8,
                colorMap: {
                    '7': '#a1a1a1'
                },
                barSpacing: 2,
                barColor: '#26B99A'
            });
            $("#total_sale_in_rs").html(Math.round(total_sale_in_rs));

            d1 = [];
            var avg_day_sale_in_rs=0;
            data_len=1;
            $.ajax({
                url: "<?php echo base_url() . 'index.php/dashboard/get_avg_day_sale_in_rs' ?>",
                data: 'from_date=' + from_date + '&to_date=' + to_date,
                cache: false,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    data_len = data.length;
                    for (var i = 0; i<data.length; i++) {
                        d1.push(data[i][1]);
                        avg_day_sale_in_rs=avg_day_sale_in_rs+parseFloat(data[i][1]);
                    }
                },
                error: function () {
                }
            });
            $(".sparkline12").sparkline(d1, {
                type: 'line',
                height: '40',
                width: '200',
                lineColor: '#26B99A',
                fillColor: '#ffffff',
                lineWidth: 3,
                spotColor: '#34495E',
                minSpotColor: '#34495E'
            });
            $("#avg_day_sale_in_rs").html(Math.round(avg_day_sale_in_rs/data_len));


            d1 = [];
            var avg_total_sale_in_rs=0;
            data_len=1;
            $.ajax({
                url: "<?php echo base_url() . 'index.php/dashboard/get_avg_total_sale_in_rs' ?>",
                data: 'from_date=' + from_date + '&to_date=' + to_date,
                cache: false,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    data_len = data.length;
                    for (var i = 0; i<data.length; i++) {
                        d1.push(data[i][1]);
                        avg_total_sale_in_rs=avg_total_sale_in_rs+parseFloat(data[i][1]);
                    }
                },
                error: function () {
                }
            });
            $(".sparkline13").sparkline(d1, {
                type: 'bar',
                height: '40',
                barWidth: 8,
                colorMap: {
                    '7': '#a1a1a1'
                },
                barSpacing: 2,
                barColor: '#26B99A'
            });
            $("#avg_total_sale_in_rs").html(Math.round(avg_total_sale_in_rs/data_len));
        }

        function set_sales_trend(from_date, to_date) {
            var d1 = [];
            
            Date.prototype.yyyymmdd = function() {
                var yyyy = this.getFullYear().toString();
                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = this.getDate().toString();
                return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); // padding
            };
            
            from_date = from_date.yyyymmdd();
            to_date = to_date.yyyymmdd();

            var type = $('#dropdownMenu1_text').val();

            $.ajax({
                url: "<?php echo base_url() . 'index.php/Dashboard/get_sales_trend' ?>",
                data: 'from_date=' + from_date + '&to_date=' + to_date + '&type=' + type,
                cache: false,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    for (var i = 0; i<data.length; i++) {
                        data[i][0] = toDate(data[i][0]).getTime();
                        d1.push([data[i][0], data[i][1]]);
                    }
                },
                error: function () {
                }
            });
            
            var len = d1.length-1;
            var chartMinDate = from_date; //first day
            var chartMaxDate = to_date; //last day

            if(d1.length>0){
                var chartMinDate = d1[0][0]; //first day
                var chartMaxDate = d1[len][0]; //last day
            }

            var tickSize = [1, "day"];
            var tformat = "%d/%m/%y";

            //graph options
            var options = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function (label, series) {
                        // just add some space to labes
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: chartColours,
                shadowSize: 0,
                tooltip: true, //activate tooltip
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "time",
                    minTickSize: tickSize,
                    timeformat: tformat,
                    min: chartMinDate,
                    max: chartMaxDate
                }
            };

            var plot = $.plot($("#placeholder32x"), [{
                label: "Sales",
                data: d1,
                lines: {
                    fillColor: "rgba(150, 202, 89, 0.12)"
                }, //#96CA59 rgba(150, 202, 89, 0.42)
                points: {
                    fillColor: "#fff"
                }
            }], options);

            d2 = [];
            var total_sale=0;
            for (var i = 0; i<d1.length; i++) {
                d2.push(d1[i][1]);
                total_sale=total_sale+parseFloat(d1[i][1]);
            }
            $(".sparkline21").sparkline(d2, {
                type: 'bar',
                height: '40',
                barWidth: 8,
                colorMap: {
                    '7': '#a1a1a1'
                },
                barSpacing: 2,
                barColor: '#26B99A'
            });
            $("#total_sale").html(Math.round(total_sale));

            d1 = [];
            var avg_day_sale=0;
            data_len=1;
            $.ajax({
                url: "<?php echo base_url() . 'index.php/dashboard/get_avg_day_sale' ?>",
                data: 'from_date=' + from_date + '&to_date=' + to_date + '&type=' + type,
                cache: false,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    data_len=data.length;
                    for (var i = 0; i<data.length; i++) {
                        d1.push(data[i][1]);
                        avg_day_sale=avg_day_sale+parseFloat(data[i][1]);
                    }
                },
                error: function () {
                }
            });
            $(".sparkline22").sparkline(d1, {
                type: 'line',
                height: '40',
                width: '200',
                lineColor: '#26B99A',
                fillColor: '#ffffff',
                lineWidth: 3,
                spotColor: '#34495E',
                minSpotColor: '#34495E'
            });
            $("#avg_day_sale").html(Math.round(avg_day_sale/data_len));


            d1 = [];
            var avg_total_sale=0;
            data_len=1;
            $.ajax({
                url: "<?php echo base_url() . 'index.php/dashboard/get_avg_total_sale' ?>",
                data: 'from_date=' + from_date + '&to_date=' + to_date + '&type=' + type,
                cache: false,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    data_len=data.length;
                    for (var i = 0; i<data.length; i++) {
                        d1.push(data[i][1]);
                        avg_total_sale=avg_total_sale+parseFloat(data[i][1]);
                    }
                },
                error: function () {
                }
            });
            $(".sparkline23").sparkline(d1, {
                type: 'bar',
                height: '40',
                barWidth: 8,
                colorMap: {
                    '7': '#a1a1a1'
                },
                barSpacing: 2,
                barColor: '#26B99A'
            });
            $("#avg_total_sale").html(Math.round(avg_total_sale/data_len));
        }

        function product_wise_sale(from_date, to_date){
            var d1 = [];
            var d2 = [];
            
            Date.prototype.yyyymmdd = function() {
                var yyyy = this.getFullYear().toString();
                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = this.getDate().toString();
                return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); // padding
            };
            
            from_date = from_date.yyyymmdd();
            to_date = to_date.yyyymmdd();

            var type = $('#dropdownMenu2_text').val();

            if (type=="Month"){
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Dashboard/get_month_wise_sale_in_box' ?>",
                    data: 'from_date=' + from_date + '&to_date=' + to_date,
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(typeof data.json_data !== 'undefined') {
                            var json_data = data.json_data;
                            var box_name = data.box_name;

                            if(json_data.length>0) {
                                d1=json_data[0];

                                for (var i = 1; i<json_data.length; i++) {
                                    var obj = {};

                                    var clr_graph = Math.floor(Math.random()*(255-1+1)+1);
                                    var clr_graph2 = Math.floor(Math.random()*(255-1+1)+1);
                                    var clr_graph3 = 154;
                                    var clr_graph4 = 1;

                                    obj = {
                                                label: box_name[i],
                                                backgroundColor: "rgba("+clr_graph+","+clr_graph2+","+clr_graph3+","+clr_graph4+")",
                                                data: json_data[i]
                                            };

                                    d2.push(obj);
                                }

                                if(myPieChart!=null){
                                    myPieChart.destroy();
                                }
                                
                                var ctx = document.getElementById("canvas_bar").getContext('2d');
                                myPieChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: d1,
                                        datasets: d2
                                    }
                                });
                            }
                        }
                    },
                    error: function () {
                    }
                });
            } else if (type=="Box"){
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Dashboard/get_product_wise_sale_in_box' ?>",
                    data: 'from_date=' + from_date + '&to_date=' + to_date,
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        for (var i = 0; i<data.length; i++) {
                            d1.push(data[i][0]);
                            d2.push(data[i][1]);
                        }
                    },
                    error: function () {
                    }
                });

                if(myPieChart!=null){
                    myPieChart.destroy();
                }
                
                var ctx = document.getElementById("canvas_bar").getContext('2d');
                myPieChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: d1,
                        datasets: [{
                                      label: 'Count',
                                      data: d2,
                                      backgroundColor: "#26B99A"
                                    }]
                    }
                });
            } else {
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Dashboard/get_product_wise_sale_in_bar' ?>",
                    data: 'from_date=' + from_date + '&to_date=' + to_date,
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        for (var i = 0; i<data.length; i++) {
                            d1.push(data[i][0]);
                            d2.push(data[i][1]);
                        }
                    },
                    error: function () {
                    }
                });

                if(myPieChart!=null){
                    myPieChart.destroy();
                }
                
                var ctx = document.getElementById("canvas_bar").getContext('2d');
                myPieChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: d1,
                        datasets: [{
                                      label: 'Count',
                                      data: d2,
                                      backgroundColor: "#26B99A"
                                    }]
                    }
                });
            }
        }

        function sm_wise_sale(from_date, to_date){
            var d1 = [];
            var d2 = [];
            
            Date.prototype.yyyymmdd = function() {
                var yyyy = this.getFullYear().toString();
                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = this.getDate().toString();
                return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); // padding
            };
            
            from_date = from_date.yyyymmdd();
            to_date = to_date.yyyymmdd();

            var type = $('#dropdownMenu3_text').val();

            if (type=="Month"){
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Dashboard/get_month_wise_sale_in_bar' ?>",
                    data: 'from_date=' + from_date + '&to_date=' + to_date,
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(typeof data.json_data !== 'undefined') {
                            var json_data = data.json_data;
                            var bar_name = data.bar_name;

                            if(json_data.length>0) {
                                d1=json_data[0];

                                for (var i = 1; i<json_data.length; i++) {
                                    var obj = {};

                                    var clr_graph = Math.floor(Math.random()*(255-1+1)+1);
                                    var clr_graph2 = Math.floor(Math.random()*(255-1+1)+1);
                                    var clr_graph3 = 154;
                                    var clr_graph4 = 1;

                                    obj = {
                                                label: bar_name[i],
                                                backgroundColor: "rgba("+clr_graph+","+clr_graph2+","+clr_graph3+","+clr_graph4+")",
                                                data: json_data[i]
                                            };

                                    d2.push(obj);
                                }

                                if(myPieChart1!=null){
                                    myPieChart1.destroy();
                                }
                                
                                var ctx = document.getElementById("canvas_bar-1").getContext('2d');
                                myPieChart1 = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: d1,
                                        datasets: d2
                                    }
                                });
                            }
                        }
                    },
                    error: function () {
                    }
                });
            } else if (type=="GT"){
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Dashboard/get_gt_month_wise_sale_in_bar' ?>",
                    data: 'from_date=' + from_date + '&to_date=' + to_date,
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(typeof data.json_data !== 'undefined') {
                            var json_data = data.json_data;
                            var distributor_name = data.distributor_name;

                            if(json_data.length>0) {
                                d1=json_data[0];

                                for (var i = 1; i<json_data.length; i++) {
                                    var obj = {};

                                    var clr_graph = Math.floor(Math.random()*(255-1+1)+1);
                                    var clr_graph2 = Math.floor(Math.random()*(255-1+1)+1);
                                    var clr_graph3 = 154;
                                    var clr_graph4 = 1;

                                    obj = {
                                                label: distributor_name[i],
                                                backgroundColor: "rgba("+clr_graph+","+clr_graph2+","+clr_graph3+","+clr_graph4+")",
                                                data: json_data[i]
                                            };

                                    d2.push(obj);
                                }

                                if(myPieChart1!=null){
                                    myPieChart1.destroy();
                                }
                                
                                var ctx = document.getElementById("canvas_bar-1").getContext('2d');
                                myPieChart1 = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: d1,
                                        datasets: d2
                                    }
                                });
                            }
                        }
                    },
                    error: function () {
                    }
                });
            } else {
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Dashboard/get_sm_wise_sale_in_bar' ?>",
                    data: 'from_date=' + from_date + '&to_date=' + to_date,
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        for (var i = 0; i<data.length; i++) {
                            d1.push(data[i][0]);
                            d2.push(data[i][1]);
                        }
                    },
                    error: function () {
                    }
                });

                if(myPieChart1!=null){
                    myPieChart1.destroy();
                }

                var ctx = document.getElementById("canvas_bar-1").getContext('2d');
                myPieChart1 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: d1,
                        datasets: [{
                                      label: 'Count',
                                      data: d2,
                                      backgroundColor: "#26B99A"
                                    }]
                    }
                });
            }
        }

        function category_wise_sale(from_date, to_date){
            var d1 = [];
            var d2 = [];
            
            Date.prototype.yyyymmdd = function() {
                var yyyy = this.getFullYear().toString();
                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = this.getDate().toString();
                return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); // padding
            };
            
            from_date = from_date.yyyymmdd();
            to_date = to_date.yyyymmdd();

            var type = $('#dropdownMenu4_text').val();

            if (type=="Month"){
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Dashboard/get_category_month_wise_sale_in_bar' ?>",
                    data: 'from_date=' + from_date + '&to_date=' + to_date,
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(typeof data.json_data !== 'undefined') {
                            var json_data = data.json_data;
                            var type = data.type;

                            if(json_data.length>0) {
                                d1=json_data[0];

                                for (var i = 1; i<json_data.length; i++) {
                                    var obj = {};

                                    var clr_graph = Math.floor(Math.random()*(255-1+1)+1);
                                    var clr_graph2 = Math.floor(Math.random()*(255-1+1)+1);
                                    var clr_graph3 = 154;
                                    var clr_graph4 = 1;

                                    obj = {
                                                label: type[i],
                                                backgroundColor: "rgba("+clr_graph+","+clr_graph2+","+clr_graph3+","+clr_graph4+")",
                                                data: json_data[i]
                                            };

                                    d2.push(obj);
                                }

                                if(myPieChart2!=null){
                                    myPieChart2.destroy();
                                }
                                
                                var ctx = document.getElementById("canvas_bar-2").getContext('2d');
                                myPieChart2 = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: d1,
                                        datasets: d2
                                    }
                                });
                            }
                        }
                    },
                    error: function () {
                    }
                });
            } else {
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/Dashboard/get_category_wise_sale_in_bar' ?>",
                    data: 'from_date=' + from_date + '&to_date=' + to_date,
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(typeof data !== 'undefined') {
                            for (var i = 0; i<data.length; i++) {
                                d1.push(data[i][0]);
                                d2.push(data[i][1]);
                            }
                        }
                    },
                    error: function () {
                    }
                });

                if(myPieChart2!=null){
                    myPieChart2.destroy();
                }

                var ctx = document.getElementById("canvas_bar-2").getContext('2d');
                myPieChart2 = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: d1,
                        datasets: [{
                                      label: 'Category',
                                      data: d2,
                                      backgroundColor: "#26B99A"
                                    }]
                    }
                });
            }
        }

        $(function () {
            var from_date = new Date();
            var to_date = new Date();
            
            // from_date.setMonth(from_date.getMonth() - 4);
            from_date.setDate(1);
            set_sales_trend_in_rs(from_date, to_date);
            set_sales_trend(from_date, to_date);
            product_wise_sale(from_date, to_date);
            sm_wise_sale(from_date, to_date);
            category_wise_sale(from_date, to_date);
        });

        $(document).ready(function () {
            var start_date = new Date();
            start_date.setDate(1);

            var optionSet1 = {
                startDate: moment(start_date),
                endDate: moment(),
                minDate: '01/01/2016',
                maxDate: Date.today(),
                dateLimit: {
                    days: 60000
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            };

            var cb = function (start, end, label) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                
                start = Date.parse(start.toString());
                end = Date.parse(end.toString());

                set_sales_trend_in_rs(start, end);
            };
            var cb1 = function () {
                start=$('#reportrange1').data('daterangepicker').startDate._d;
                end=$('#reportrange1').data('daterangepicker').endDate._d;

                start = new Date(start);
                end = new Date(end);

                $('#reportrange1 span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
                
                set_sales_trend(start, end);
            };
            var cb2 = function (start, end, label) {
                start=$('#reportrange2').data('daterangepicker').startDate._d;
                end=$('#reportrange2').data('daterangepicker').endDate._d;

                start = new Date(start);
                end = new Date(end);

                $('#reportrange2 span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
                
                product_wise_sale(start, end);
            };
            var cb3 = function (start, end, label) {
                start=$('#reportrange3').data('daterangepicker').startDate._d;
                end=$('#reportrange3').data('daterangepicker').endDate._d;

                start = new Date(start);
                end = new Date(end);

                $('#reportrange3 span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
                
                sm_wise_sale(start, end);
            };
            var cb4 = function (start, end, label) {
                start=$('#reportrange4').data('daterangepicker').startDate._d;
                end=$('#reportrange4').data('daterangepicker').endDate._d;

                start = new Date(start);
                end = new Date(end);

                $('#reportrange4 span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
                
                category_wise_sale(start, end);
            };

            $('#reportrange span').html(moment(start_date).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange1 span').html(moment(start_date).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange2 span').html(moment(start_date).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange3 span').html(moment(start_date).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange4 span').html(moment(start_date).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange').daterangepicker(optionSet1, cb);
            $('#reportrange1').daterangepicker(optionSet1, cb1);
            $('#reportrange2').daterangepicker(optionSet1, cb2);
            $('#reportrange3').daterangepicker(optionSet1, cb3);
            $('#reportrange4').daterangepicker(optionSet1, cb4);

            $('#dropdownMenu1 li').on('click', function(){
                if($(this).text().trim().toUpperCase()=="SALES TREND  (IN BOX)") {
                    $('#dropdownMenu1_text').val("Box");
                } else {
                    $('#dropdownMenu1_text').val("Bar");
                }
                cb1();
            });
            $('#dropdownMenu2 li').on('click', function(){
                if($(this).text().trim().toUpperCase()=="MONTH WISE SALE  (IN BOX)") {
                    $('#dropdownMenu2_text').val("Month");
                } else if($(this).text().trim().toUpperCase()=="PRODUCT WISE SALE (IN BOX)") {
                    $('#dropdownMenu2_text').val("Box");
                } else {
                    $('#dropdownMenu2_text').val("Bar");
                }
                cb2();
            });
            $('#dropdownMenu3 li').on('click', function(){
                if($(this).text().trim().toUpperCase()=="MONTH WISE SALE (IN BAR)") {
                    $('#dropdownMenu3_text').val("Month");
                } else if($(this).text().trim().toUpperCase()=="GT & MONTH WISE SALE") {
                    $('#dropdownMenu3_text').val("GT");
                } else {
                    $('#dropdownMenu3_text').val("SM");
                }
                cb3();
            });
            $('#dropdownMenu4 li').on('click', function(){
                if($(this).text().trim().toUpperCase()=="CATEGORY & MONTH WISE SALE") {
                    $('#dropdownMenu4_text').val("Month");
                } else {
                    $('#dropdownMenu4_text').val("CATEGORY");
                }
                cb4();
            });
        });

        $('.dropdown-select').on( 'click', '.dropdown-menu li a', function() { 
            var target = $(this).html();

            //Adds active class to selected item
            $(this).parents('.dropdown-menu').find('li').removeClass('active');
            $(this).parent('li').addClass('active');

            //Displays selected text on dropdown-toggle button
            $(this).parents('.dropdown-select').find('.dropdown-toggle').html(target + ' <span class="caret"></span>');
        });
    </script>
    <script>
    $(document).ready(function() {
     /* WIDGETS (DEMO)*/
    //OWL Carousel
       
            
            if($(".owl-carousel").length > 0){
                $(".owl-carousel").owlCarousel({mouseDrag: false, touchDrag: true, slideSpeed: 300, paginationSpeed: 400, singleItem: true, navigation: false,autoPlay: true});
            }
            
         //End OWL Carousel
    /* END WIDGETS */

        
    });
    </script>
    </body>
</html>