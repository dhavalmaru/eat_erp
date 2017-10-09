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
            <link rel="stylesheet" type="text/css"   href="<?php echo base_url(); ?>css/dashboard.css"/>
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
        .heading-h2 { background:#eee; line-height: 25px; padding:12px 22px;   text-transform: uppercase; font-weight: 600; display: block;  margin-top: 61px; border-bottom:1px solid #d7d7d7; font-size:14px;  }
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
        .radio-style { background: #fff; display: block; width:100%; position: relative; padding: 10px; top:-20px;  text-align: :center;}
        </style>
        <style type="text/css">
        
            .funkyradio label {
    /*min-width: 400px;*/
    width: 100%;
   margin-bottom: 0!important;
    margin-bottom: 0!important
    font-weight: normal;
    font-size: 13px;
   
    line-height: 30px!important;
   
    /* padding: 4px 10px; */
    background-color: rgba(255,255,255,0.5)!important;
    line-height: 20px;
    
    border: 1px solid #c4ced1!important;
   
    -moz-border-radius: 0px;
    box-shadow: 0px 1px 1px rgba(0,0,0,0.05);
    -webkit-border-radius: 0px;
    border-radius:3px;
    -webkit-transition: all 200ms ease;
    -moz-transition: all 200ms ease;
    -ms-transition: all 200ms ease;
    -o-transition: all 200ms ease;
    transition: all 200ms ease

}
.funkyradio label:hover{ background: #fff!important;
      color: #5cb85c;
    border: 1px solid #5cb85c!important;
    box-shadow: 0rem 0.0625rem 0.125rem rgba(0,0,0,0.15);
}
.funkyradio-success { float: left; width:140px; margin-right: 15px; }
.funkyradio-success:nth-child(3) { float: left; width:140px;  }

.funkyradio input[type="radio"]:empty, .funkyradio input[type="checkbox"]:empty {
    display: none;
}
.funkyradio input[type="radio"]:empty ~ label, .funkyradio input[type="checkbox"]:empty ~ label {
    position: relative;
    line-height: 2.5em;
    text-indent: 3.25em;
    margin-top: 0em;  
    cursor: pointer;
    -webkit-user-select: none;     
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.funkyradio input[type="radio"]:empty ~ label:before, .funkyradio input[type="checkbox"]:empty ~ label:before {
    position: absolute;
    display: block;
    top: 0;
    bottom: 0;
    left: 0;
    content:'';
    width: 2.5em;
    background: #ddd;
  border-radius: 2px 0 0 2px; 
}
.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before, .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #C2C2C2;
}
.funkyradio input[type="radio"]:hover:not(:checked) ~ label, .funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
    color: #888;
}
.funkyradio input[type="radio"]:checked ~ label:before, .funkyradio input[type="checkbox"]:checked ~ label:before {
    content:'\2714';
    text-indent: .9em;
    color: #333;
    background-color: #ccc;
}
.funkyradio input[type="radio"]:checked ~ label, .funkyradio input[type="checkbox"]:checked ~ label {
    color: #5cb85c; 
    border: 1px solid #5cb85c!important;  background: #fff!important;
}
.funkyradio input[type="radio"]:focus ~ label:before, .funkyradio input[type="checkbox"]:focus ~ label:before {
    box-shadow: 0 0 0 3px #999;
}
.funkyradio-default input[type="radio"]:checked ~ label:before, .funkyradio-default input[type="checkbox"]:checked ~ label:before {
    color: #333;
    background-color: #ccc;
}
.funkyradio-primary input[type="radio"]:checked ~ label:before, .funkyradio-primary input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #337ab7;
}
.funkyradio-success input[type="radio"]:checked ~ label:before, .funkyradio-success input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #5cb85c;
}
.funkyradio-danger input[type="radio"]:checked ~ label:before, .funkyradio-danger input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #d9534f;
}
.funkyradio-warning input[type="radio"]:checked ~ label:before, .funkyradio-warning input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #f0ad4e;
}
.funkyradio-info input[type="radio"]:checked ~ label:before, .funkyradio-info input[type="checkbox"]:checked ~ label:before {
    color: #fff;
    background-color: #5bc0de;
}
.container1 { position:relative; width: 100%;  top:-42px;   right:0; clear: both; overflow: hidden;} 
.main-container { margin-top:-10px;  }

@media only screen and  (min-width:280px)  and (max-width:379px) {  
     .container1 { position:relative; width: 100%;   top:10px!important;   right:0; clear: both; overflow: hidden;} 
     .container1 .pull-right{ float: none!important;   max-width:281px; margin: auto;}  
     .main-container { margin-top: 30px; }
     
     .funkyradio label { font-size: 11px; }
     .funkyradio-success {  float: left;   width:80px;   margin:0 5px;  }
     .funkyradio-success:nth-child(3) {   float: left;   width: 90px;}
     .funkyradio input[type="radio"]:empty ~ label, .funkyradio input[type="checkbox"]:empty ~ label {
    position: relative;
    line-height: 2.5em;
    text-indent: 2.75em; }
      .dashboard-heading { width: 100%;   position: absolute;  margin: 0; left: 0; }
      .dashboard-heading .row{ margin: 0;}
    .main_container .mrggn-top{ margin-top: 130px; }
  .dashboard-heading {    padding: 12px 16px 7px!important;} 
       .dashboard-heading .pull-right{ float: none!important; max-width:361px;   }  
.dashboard-heading .pull-right .col-xs-6 { width: 100%; }
.dashboard-heading .btn .fa, .dashboard-heading .btn .glyphicon {
    font-size: 14px;
    width: 30px;
    background: #ddd;
    position: absolute;
    left: 11px;
    height: 30px;
    line-height: 30px;
    border-radius: 3px 0 0px 3px;
}
.dashboard-heading .btn {
    font-weight: 100!important;
    width: 100%;
}

    }


 @media only screen and  (min-width:380px)  and (max-width:481px) {  
     .container1 { position:relative; width: 100%;  top:10px!important;   right:0; clear: both; overflow: hidden;}   
      .container1 .pull-right{ float: none!important; max-width:361px; margin: auto; } 
       .dashboard-heading {    padding: 12px 16px 7px!important;} 
       .dashboard-heading .pull-right{ float: none!important; max-width:361px;   }  

     .main-container { margin-top: 30px; }
     .funkyradio-success {  float: left;   width: 110px;    margin-right:10px;}
     .funkyradio-success:nth-child(3) {   float: left;   width: 110px;}
      .dashboard-heading { width: 100%;   position: absolute;  margin: 0; left: 0; }
      .dashboard-heading .row{ margin: 0;}
    .main_container .mrggn-top{ margin-top: 130px; }
    }

   @media only screen and  (min-width:482px)  and (max-width:599px) {  
     .container1 { position:relative; width: 100%;  top:10px!important;   right:0; clear: both; overflow: hidden;} 
      .container1 .pull-right{ float: none!important; max-width:483px; margin: auto; }   
      .dashboard-heading .pull-right{ float: none!important; max-width:450px; margin: auto!important; }  
     .main-container { margin-top: 30px; }
       .dashboard-heading { width: 100%;   position: absolute;  margin: 0; left: 0; }
      .dashboard-heading .row{ margin: 0;}
       .main_container .mrggn-top{ margin-top: 90px; }
       .div-size{width: 50%;}
      .widget .widget-item-left .fa, .widget .widget-item-right .fa, .widget .widget-item-left .glyphicon, .widget .widget-item-right .glyphicon {   font-size:30px;}
      .widget.widget-item-icon .widget-item-left, .widget.widget-item-icon .widget-item-right {
    width: 70px;    padding: 20px 0px;    text-align: center;}
    .widget.widget-item-icon .widget-data {    padding-left:100px!important;}
    .widget .widget-title { font-size: 16px; }
    .widget-int span{ font-size: 20px; }
    }



      @media only screen and  (min-width:600px)  and (max-width:1024px) {  
     .container1 { position:relative; width: 100%;  top:10px!important;   right:0; clear: both; overflow: hidden;}  
      .container1 .pull-right{ float: none!important; max-width:480px; margin: auto!important; }   
      .dashboard-heading .pull-right{ float: none!important; max-width:400px; margin: auto!important; }   
     .main-container { margin-top: 30px; }
       .dashboard-heading { width: 100%;   position: absolute;  margin: 0; left: 0; }
      .dashboard-heading .row{ margin: 0;}
    .main_container .mrggn-top{ margin-top: 85px; }
    }

     @media only screen and  (min-width:600px)  and (max-width:767px) {  
        .div-size{width: 50%;}
    }
     @media only screen and  (min-width:992px)  and (max-width:1024px) { 
        .widget.widget-item-icon .widget-item-left, .widget.widget-item-icon .widget-item-right { width:60px; }
        .widget .widget-item-left .fa, .widget .widget-item-right .fa, .widget .widget-item-left .glyphicon, .widget .widget-item-right .glyphicon { font-size:28px; }
        .widget.widget-item-icon .widget-data {    padding-left:80px!important;}
        .widget-title { font-size:16px!important; }
        .widget-int { font-size: 20px!important; }
       }

        </style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
               <div class="heading-h2">   Dashboard    </div>
                 <div class="container1">
                       <div class=" pull-right">
                            <div class="funkyradio">
                            <div class="funkyradio-success  ">
                                <input type="radio" name="period"  id="weekly" value="weekly" />
                                <label for="weekly">Weekly</label>
                            </div>
                        
                            <div class="funkyradio-success  ">
                                <input type="radio" name="period" id="monthly" value="monthly"  />
                                <label for="monthly">Monthly</label>
                            </div> 

                             <div class="funkyradio-success  ">
                                <input type="radio" name="period" id="all" value="all" />
                                <label for="all">All</label>
                            </div> 
                        </div>
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

                                                           
                                    <div class="radio-style" style="display: none;">
                                
                                    <div class=" ">
                                            <input type="radio" name="period" id="weekly" value="weekly" /> &nbsp;&nbsp; Weekly &nbsp;&nbsp; 
                                            <input type="radio" name="period" id="monthly" value="monthly" /> &nbsp;&nbsp; Monthly &nbsp;&nbsp; 
                                            <input type="radio" name="period" id="all" value="all" /> &nbsp;&nbsp; All
                                    </div>
                                    
                                    </div>
                                   
                                

                        <div class="row mobile-bg">
                            <div class=" col-md-3 col-sm-6 col-xs-12 div-size">
                                <div class="widget widget-blue  widget-item-icon widget-carousel animated flipInY">
                                    <div class="owl-carousel  " id="owl-example">  
                                        <div>    
                                            <div class="widget-item-left">
                                                <span class="fa fa-exchange  "></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total Sale</div>
                                                <div class="widget-subtitle">(In Amount)</div>
                                                <div class="widget-int"> &#8377; <span data-toggle="counter" id="total_amount"><?php if(isset($total_sale[0]->total_amount)) echo format_money(($total_sale[0]->total_amount),0) . ' Lacs';?></span></div>
                                            </div>   
                                        </div>
                                        <div>  
                                            <div class="widget-item-left">
                                                <span class="fa fa-exchange"></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total Sale</div>
                                                <div class="widget-subtitle">(In Bar)</div>
                                                <div class="widget-int"> <span data-toggle="counter" id="total_bar"><?php if(isset($total_sale[0]->total_bar)) echo format_money($total_sale[0]->total_bar,0);?></span></div>
                                            </div>  
                                        </div>

                                        <div>  
                                            <div class="widget-item-left">
                                                <span class="fa fa-exchange"></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total Sale</div>
                                                <div class="widget-subtitle">(In Box)</div>
                                                <div class="widget-int">   <span data-toggle="counter" id="total_box"><?php if(isset($total_sale[0]->total_box)) echo format_money($total_sale[0]->total_box,0);?></span></div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-md-3 col-sm-6 col-xs-12 div-size">
                                <div class="widget widget-info  widget-item-icon widget-carousel animated flipInY">
                                    <div class="owl-carousel  " id="owl-example">
                                        <div>
                                            <div class="widget-item-left">
                                                <span class="fa fa-retweet  "></span>
                                            </div>
                                            <div class="widget-data">
                                                <div class="widget-title">Total  <br> Distributors</div>

                                                <div class="widget-int"> <span data-toggle="counter" id="tot_dist"><?php if(isset($total_dist[0]->tot_dist)) echo format_money($total_dist[0]->tot_dist,0);?></span></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="widget-item-left">
                                                <span class="fa fa-retweet  "></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total  <br> General Trade </div>
                                                <div class="widget-int"> <span data-toggle="counter" id="tot_g_trade"><?php if(isset($total_dist[0]->tot_g_trade)) echo format_money($total_dist[0]->tot_g_trade,0);?></span></div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="widget-item-left">
                                                <span class="fa fa-retweet"></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total  <br> Modern Trade</div>
                                                <div class="widget-int">   <span data-toggle="counter" id="tot_m_trade"><?php if(isset($total_dist[0]->tot_m_trade)) echo format_money($total_dist[0]->tot_m_trade,0);?></span></div>
                                            </div> 
                                        </div>
                                        <div>
                                            <div class="widget-item-left">
                                                <span class="fa fa-retweet"></span>
                                            </div>                             
                                            <div class="widget-data">
                                                <div class="widget-title">Total  <br>  E Commerce</div>
                                                <div class="widget-int">   <span data-toggle="counter" id="tot_e_com"><?php if(isset($total_dist[0]->tot_e_com)) echo format_money($total_dist[0]->tot_e_com,0);?></span></div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-md-3 col-sm-6 col-xs-12 div-size">
                                <div class="widget widget-red  widget-item-icon  animated flipInY">
                                    <div class="widget-item-left">
                                        <span class="fa fa-inr  "></span>
                                    </div>                             
                                    <div class="widget-data">
                                        <div class="widget-title">Total <br> Receivable</div>
                                        <div class="widget-int" style="font-size: 25px;">  &#8377;  <span data-toggle="counter"><?php if(isset($total_receivable[0]->total_receivable)) echo format_money($total_receivable[0]->total_receivable,0);?></span></div>
                                    </div>                             
                                </div>
                            </div>

                            <div class=" col-md-3 col-sm-6 col-xs-12 div-size">
                                <div class="widget widget-yellow  widget-item-icon  animated flipInY">
                                    <div class="widget-item-left">
                                        <span class="fa fa-inr  "></span>
                                    </div>                             
                                    <div class="widget-data">
                                        <div class="widget-title">Target <br> </div>
                                        <div class="widget-int" style="font-size: 25px;">  &#8377;  <span data-toggle="counter"><?php if(isset($target[0]->target)) echo format_money($target[0]->target,0);?></span></div>
                                    </div>                             
                                </div>
                            </div>
                        </div>

                        <div class="heading-h2 row dashboard-heading"  >
                            <div class="row  ">
                                <div class="pull-right "> 
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <a class="btn btn-md btn-padding" href="<?php echo base_url(); ?>index.php/sales_rep_area/add">
                                            <span class="fa fa-plus"></span> Enter Today Area
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <a class="btn btn-md btn-padding" href="<?php echo base_url(); ?>index.php/sales_rep_location/add">
                                            <span class="fa fa-plus"></span> Enter Today Location
                                        </a>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="row  margin-top mrggn-top">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="  pull-left">
                                                <h2>Actual vs Target Sale </h2> 
                                            </div> 
                                            <div class="filter">
                                                <div id="reportrange" class="pull-right" style=" ">
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
                                    <input type="hidden" class="form-control datepicker" name="from_date" id="from_date" value="<?php echo date('d/m/Y')?>">
                                    <input type="hidden" class="form-control datepicker" name="to_date" id="to_date" value="<?php echo date('d/m/Y')?>">
                                    <input type="hidden" class="form-control" name="sales_rep_id" id="sales_rep_id" value="<?php if(isset($sales_rep_id)) echo $sales_rep_id;?>"/>

                                    <div class="table-responsive">
                                        <table class="table datatable table-bordered" style="background-color: white;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center; width:100px;">Sr. No.</th>
                                                    <th>Date</th>
                                                    <th>Area</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Distance</th>
                                                    <th>Duration</th>
                                                </tr>
                                            </thead>
                                            <tbody id="route_details">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row  margin-top">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="  pull-left">
                                                <h2>Payment Follow Ups </h2> 
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content" >
                                            <div class="table-responsive">
                                                <table id="customers2" class="table datatable table-bordered" >
                                                    <thead>
                                                        <tr>
                                                            <th width="75" style="text-align:center;">Sr. No.</th>
                                                            <th>Distributor Name</th>
                                                            <th>Area</th>
                                                            <th>30-45 Days</th>
                                                            <th>46-60 Days</th>
                                                            <th>61-90 Days</th>
                                                            <th>Above 90 Days</th>
                                                            <th>tot_receivable</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i=0; $i < count($payment_receivable); $i++) { ?>
                                                        <tr>
                                                            <td style="text-align:center;"><?php echo $i+1; ?></td>
                                                            <td><?php echo $payment_receivable[$i]->distributor_name; ?></td>
                                                            <td><?php echo $payment_receivable[$i]->area; ?></td>
                                                            <td><?php echo $payment_receivable[$i]->days_30_45; ?></td>
                                                            <td><?php echo $payment_receivable[$i]->days_46_60; ?></td>
                                                            <td><?php echo $payment_receivable[$i]->days_61_90; ?></td>
                                                            <td><?php echo $payment_receivable[$i]->days_91_above; ?></td>
                                                            <td><?php echo $payment_receivable[$i]->tot_receivable; ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row  margin-top" style="display:none;">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <div class="  pull-left">
                                            <h2>Today Route </h2> 
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" >
                                        <div id="map_wrapper">
                                            <div id="map_canvas" class="mapping" style="width:100%; height:375px"></div>
                                            <!-- <div id="directionsPanel" style="float:right;width:30%;height 100%"></div> -->
                                        </div>>
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

        function actual_vs_target_sale(from_date, to_date){
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

            $.ajax({
                url: "<?php echo base_url() . 'index.php/Dashboard_sales_rep/get_month_wise_sale' ?>",
                data: 'from_date=' + from_date + '&to_date=' + to_date,
                cache: false,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    if(typeof data.json_data !== 'undefined') {
                        var json_data = data.json_data;
                        var item_name = data.item_name;

                        if(json_data.length>0) {
                            d1=json_data[0];

                            for (var i = 1; i<json_data.length; i++) {
                                var obj = {};

                                var clr_graph = Math.floor(Math.random()*(255-1+1)+1);
                                var clr_graph2 = Math.floor(Math.random()*(255-1+1)+1);
                                var clr_graph3 = 154;
                                var clr_graph4 = 1;

                                obj = {
                                            label: item_name[i],
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
        }

        $('input[type=radio][name=period]').change(function() {
            get_sale_details();
        });

        function get_sale_details(){
            var d1 = [];
            var d2 = [];

            var from_date = new Date();
            var to_date = new Date();

            if($('input[type=radio][name=period]:checked').val()=="weekly"){
                from_date.setDate(from_date.getDate() - parseInt(7));
            } else if($('input[type=radio][name=period]:checked').val()=="monthly"){
                from_date.setDate(from_date.getDate() - parseInt(30));
            } else {
                from_date = new Date("2016-01-01");
            }

            Date.prototype.yyyymmdd = function() {
                var yyyy = this.getFullYear().toString();
                var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
                var dd  = this.getDate().toString();
                return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); // padding
            };
            
            from_date = from_date.yyyymmdd();
            to_date = to_date.yyyymmdd();

            $.ajax({
                url: "<?php echo base_url() . 'index.php/Dashboard_sales_rep/get_sale_details' ?>",
                data: 'from_date=' + from_date + '&to_date=' + to_date,
                cache: false,
                type: "POST",
                dataType: 'json',
                global: false,
                async: false,
                success: function (data) {
                    if(typeof data.total_sale !== 'undefined') {
                        var total_sale = data.total_sale;

                        if(typeof total_sale['total_amount'] !== 'undefined') {
                            $("#total_amount").html(format_money(total_sale['total_amount'],0));
                            $("#total_bar").html(format_money(total_sale['total_bar'],0));
                            $("#total_box").html(format_money(total_sale['total_box'],0));
                        }
                    }

                    if(typeof data.total_dist !== 'undefined') {
                        var total_dist = data.total_dist;
                        if(typeof total_dist['tot_dist'] !== 'undefined') {
                            $("#tot_dist").html(format_money(total_dist['tot_dist'],0));
                            $("#tot_g_trade").html(format_money(total_dist['tot_g_trade'],0));
                            $("#tot_m_trade").html(format_money(total_dist['tot_m_trade'],0));
                            $("#tot_e_com").html(format_money(total_dist['tot_e_com'],0));
                        }
                    }
                },
                error: function () {
                }
            });
        }

        $(function () {
            var from_date = new Date();
            var to_date = new Date();
            
            // from_date.setMonth(from_date.getMonth() - 4);
            from_date.setDate(1);
            actual_vs_target_sale(from_date, to_date);
            $("#weekly").attr('checked', true);
            get_sale_details();
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

                actual_vs_target_sale(start, end);
            };

            $('#reportrange span').html(moment(start_date).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange').daterangepicker(optionSet1, cb);
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
    <script>
    // function myMap() {
    //     Date.prototype.yyyymmdd = function() {
    //         var yyyy = this.getFullYear().toString();
    //         var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
    //         var dd  = this.getDate().toString();
    //         return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); // padding
    //     };

    //     var from_date = new Date();
    //     var to_date = new Date();

    //     from_date.setDate(1);
    //     from_date = from_date.yyyymmdd();
    //     to_date = to_date.yyyymmdd();

    //     var markers = [];

    //     $.ajax({
    //         url: "<?php echo base_url() . 'index.php/Dashboard_sales_rep/get_rout_plan_details' ?>",
    //         data: 'from_date=' + from_date + '&to_date=' + to_date,
    //         cache: false,
    //         type: "POST",
    //         dataType: 'json',
    //         global: false,
    //         async: false,
    //         success: function (data) {
    //             if(typeof data.json_data !== 'undefined') {
    //                 var json_data = data.json_data;

    //                 if(typeof json_data['distributor_name'] !== 'undefined') {
    //                     var distributor_name=json_data['distributor_name'];
    //                     var area=json_data['area'];
    //                     var latitude=json_data['latitude'];
    //                     var longitude=json_data['longitude'];

    //                     if(distributor_name.length>0) {
    //                         for (var i = 0; i<distributor_name.length; i++) {
    //                             var lat = latitude[i];
    //                             var lng = longitude[i];
    //                             var lbl = distributor_name[i] + ' (' + area[i] + ')';

    //                             var mark = {lat:lat, lng:lng, lbl:lbl};

    //                             markers.push(mark);
    //                         }
    //                     }
    //                 }
    //             }
    //         },
    //         error: function () {
    //         }
    //     });


    //     var mapCanvas = document.getElementById("map");
    //     var mapOptions = {
    //         center: new google.maps.LatLng(19.141043, 72.832350),
    //         zoom: 5
    //     }
    //     var map = new google.maps.Map(mapCanvas, mapOptions);

    //     var createMarker = function (info){
    //         var marker = new google.maps.Marker({
    //             map: map,
    //             position: new google.maps.LatLng(info.lat, info.lng),
    //             label: info.lbl
    //         });
    //         marker.setMap(map);
    //     }
    //     for (i = 0; i < markers.length; i++){
    //         createMarker(markers[i]);
    //     }

    //     // var myPosition = new google.maps.LatLng(19.141043, 72.832350);
    //     // var marker = new google.maps.Marker({position:myPosition});
    //     // marker.setMap(map);
    // }
    </script>

    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&sensor=false">
        </script>
    <script type="text/javascript">
        var BASE_URL="<?php echo base_url()?>";
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/route.js"></script>

    </body>
</html>