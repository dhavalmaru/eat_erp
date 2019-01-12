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
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<!--[if lt IE 9]>
<script src="dist/html5shiv.js"></script>
<![endif]-->
        <!-- EOF CSS INCLUDE -->                                      
		<style>
	.page-content page-overflow { height:auto!important;}
.page-container .page-content .page-content-wrap { background:#fff;  margin:0px; width: auto!important; float: none;   }
.dataTables_filter { border-bottom:0!important; }
.heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: block;  margin-top: 61px; border-bottom:1px solid #d7d7d7; font-size:14px;  }
.heading-h2 a{  color: #444;      }
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
 .dataTables_scrollHead {  border-right:1px  solid #ddd!important;}
 .dataTables_scrollBody {   border-bottom:1px  solid #ddd!important;  }
.responsive-table-bordered tr th:first-child{ width:45px!important;  text-align:center;} 
.responsive-table-bordered tr th:nth-child(2){ width:222px!important; } 
.responsive-table-bordered tr th:nth-child(3){ width:72px!important; } 
.responsive-table-bordered tr th:nth-child(4){ width:72px!important; } 
.responsive-table-bordered tr th:nth-child(5){ width:75px!important; } 
.responsive-table-bordered tr th:nth-child(6){ width:75px!important; } 
.responsive-table-bordered tr th:nth-child(7){ width:70px!important; } 
.responsive-table-bordered tr th:nth-child(8){ width:90px!important; } 
.responsive-table-bordered tr th:nth-child(9){ width:65px!important; } 
.responsive-table-bordered tr th:nth-child(10){ width:95px!important; } 
.responsive-table-bordered tr th:last-child { width:60px!important;   text-align:center;} 



.responsive-table-bordered tr td:first-child{ width:34.8px!important;} 
.responsive-table-bordered tr td:nth-child(2){ width:211px!important;} 
.responsive-table-bordered tr td:nth-child(3){ width:62px!important;} 
.responsive-table-bordered tr td:nth-child(4){ width:63px!important;} 
.responsive-table-bordered tr td:nth-child(5){ width:65px!important;} 
.responsive-table-bordered tr td:nth-child(6){ width:64px!important;} 
.responsive-table-bordered tr td:nth-child(7){ width:60px!important;} 
.responsive-table-bordered tr td:nth-child(8){ width:80px!important;} 
.responsive-table-bordered tr td:nth-child(9){ width:53px!important;} 
.responsive-table-bordered tr td:nth-child(10){ width:86px!important;} 
.responsive-table-bordered tr td:last-child { width:59px!important;  text-align:center;} 

*--------------*/


/*-----------------------------*/

.responsive-cashflow-table thead tr th:first-child{   text-align:center;     width: 53px!important;} 
.responsive-cashflow-table thead tr th:first-child { width:52px!important;}
.responsive-cashflow-table thead tr th:nth-child(2){ width:215px;} 
.responsive-cashflow-table thead tr th:nth-child(3){ width:70px;} 
.responsive-cashflow-table thead tr th:nth-child(4){ width:70px;} 
.responsive-cashflow-table thead tr th:nth-child(5){ width:155px;} 
.responsive-cashflow-table thead tr th:nth-child(6){ width:76px;} 
.responsive-cashflow-table thead tr th:nth-child(7){ width:85px;} 
.responsive-cashflow-table thead tr th:nth-child(8){ width:70px;} 
.responsive-cashflow-table thead tr th:nth-child(9){ width:90px;} 
 
.responsive-cashflow-table tr th:last-child { width:60px;  text-align:center;} 



.responsive-cashflow-table tr td:nth-child(1){ width:33px;} 
.responsive-cashflow-table tr td:nth-child(2){ width:170px; } 
.responsive-cashflow-table tr td:nth-child(3){ width:52.8px;} 
.responsive-cashflow-table tr td:nth-child(4){ width:53px;} 
.responsive-cashflow-table tr td:nth-child(5){ width:122px;} 
.responsive-cashflow-table tr td:nth-child(6){ width:58.8px;} 
.responsive-cashflow-table tr td:nth-child(7){ width:66px;} 
.responsive-cashflow-table tr td:nth-child(8){ width:54px;} 
.responsive-cashflow-table tr td:nth-child(9){ width:69px;} 
  
.responsive-cashflow-table tr td:last-child { width:49px;  text-align:center;} 

*--------------*/


.dataTables_scroll {/* overflow-x:scroll!important;*/ width:100%; }
.fa-search { font-size:22px; text-align:center;      padding:5px 2px; color:#072c48; font-weight:100; }
@media only screen and (min-width: 680px) and (max-width: 800px){
.icon { display:none;}

ul.topnav li { width:20%; text-align:center;  border-right:1px solid #eee; }
ul.topnav li a {  border-bottom:none!important;     } 
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
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrapper ">
                 
                    <div class="row main-wrapper"> 
                      <div class="main-container">
                        <?php if(isset($raw_material_details)){?>
                         
                         	  <div class="full-width" style="">
							 <div class="full-width-devider" style="">
                            <div class="col-md-12" style="">
                                
                                <!-- START WIDGET MESSAGES -->
                                <h2 style="float:left;    margin-bottom: 0;">Raw Material Stock Details</h2>  <!-- <span style="fmargin-left:20px;margin-top:10px;margin-top: 5px; float: right; text-decoration: underline; font-size: 14px;"><a href="#">View all</a></span> -->      
                                <!-- END WIDGET MESSAGES -->
                                <div class="btn-group pull-right">
                                            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" onClick ="$('#customers2').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                                
                                                <li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                                </ul>
                                        </div>
                                <div class="panel panel-default">
                                    
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable" id="customers2">
                                                <thead>
                                                    <tr>
                                                        <th style="padding:5px;" width="5%">Sr no</th>
                                                        <th style="padding:5px;" width="15%">Depot</th>
                                                        <th style="padding:5px;" width="10%">Raw Material</th>
                                                        <th style="padding:5px;" width="10%">Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(isset($raw_material_details)){
                                                    $i=0;
                                                    foreach($raw_material_details as $row){
                                                        echo ' <tr style="word-break: break-word;">
                                                        <td style="padding:5px;" width="5%"><strong>'.($i+1).'</strong></td>
                                                        <td style="padding:5px;" width="15%"><strong>'.$raw_material_details[$i]->depot_name.'</strong></td>
                                                        <td style="padding:5px;" width="10%"><strong>'.$raw_material_details[$i]->rm_name.'</strong></td>
                                                        <td style="padding:5px;" width="10%"><strong>'.format_money($raw_material_details[$i]->tot_qty,2).'</strong></td>                                                        
                                                        </tr> ';
                                                        $i++;
                                                    }
                                                }?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
							</div>
				        <?php }?>

                        <?php if(isset($product_details)){?>
                            <div class="full-width-devider" style="">
                            <div class="col-md-12">
                                <h2 style="float:left; margin-bottom: 0;">Product Stock Details</h2>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                    </ul>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="customers3">
                                                <thead>
                                                    <tr>
                                                        <th>Depot</th>
                                                    
                                                        <?php
                                                           for($j=0;$j<count($product);$j++){
                                                                echo '<th>'.$product_name[$j].'</th>';
                                                            }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        for($i=0;$i<count($depot);$i++){
                                                            echo '<tr><td>'.$depot_name[$i].'</td>';

                                                            for($j=0;$j<count($product);$j++){
                                                                echo '<td>'.$product_details[$depot[$i]][$product[$j]].'</td>';
                                                            }

                                                            echo '</tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php }?>
                        
                        <?php //if(isset($product_details)){?>
                            <!-- <div class="full-width-devider" style="">
                            <div class="col-md-12">
                                <h2 style="float:left; margin-bottom: 0;">Product Stock Details</h2>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'csv',escape:'false'});"><img src='<?php //echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'excel',escape:'false'});"><img src='<?php //echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                    </ul>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="customers3">
                                                <thead>
                                                    <tr>
                                                        <th style="padding:5px;" width="5%">Sr no</th>
                                                        <th style="padding:5px;" width="15%">Depot</th>
                                                        <th style="padding:5px;" width="10%">Product</th>
                                                        <th style="padding:5px;" width="10%">Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php //if(isset($product_details)){
                                                    // $i=0;
                                                    // foreach($product_details as $row){
                                                    //     echo ' <tr style="word-break: break-word;">
                                                    //     <td style="padding:5px;" width="5%"><strong>'.($i+1).'</strong></td>
                                                    //     <td style="padding:5px;" width="15%"><strong>'.$product_details[$i]->depot_name.'</strong></td>
                                                    //     <td style="padding:5px;" width="15%"><strong>'.$product_details[$i]->product_name.'</strong></td>
                                                    //     <td style="padding:5px;" width="10%"><strong>'.format_money($product_details[$i]->tot_qty,2).'</strong></td>
                                                    //     </tr> ';
                                                    //     $i++;
                                                    // }
                                                //}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div> -->
                        <?php //}?>

                        <?php //if(isset($box_details)){?>
                            <!-- <div class="full-width-devider" style="">
                            <div class="col-md-12">
                                <h2 style="float:left; margin-bottom: 0;">Box Stock Details</h2>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onClick ="$('#customers4').tableExport({type:'csv',escape:'false'});"><img src='<?php //echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                        <li><a href="#" onClick ="$('#customers4').tableExport({type:'excel',escape:'false'});"><img src='<?php //echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                    </ul>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="customers4">
                                                <thead>
                                                    <tr>
                                                        <th style="padding:5px;" width="5%">Sr no</th>
                                                        <th style="padding:5px;" width="15%">Depot</th>
                                                        <th style="padding:5px;" width="10%">Box</th>
                                                        <th style="padding:5px;" width="10%">Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php //if(isset($box_details)){
                                                    // $i=0;
                                                    // foreach($box_details as $row){
                                                    //     echo ' <tr style="word-break: break-word;">
                                                    //     <td style="padding:5px;" width="5%"><strong>'.($i+1).'</strong></td>
                                                    //     <td style="padding:5px;" width="15%"><strong>'.$box_details[$i]->depot_name.'</strong></td>
                                                    //     <td style="padding:5px;" width="15%"><strong>'.$box_details[$i]->box_name.'</strong></td>
                                                    //     <td style="padding:5px;" width="10%"><strong>'.format_money($box_details[$i]->tot_qty,2).'</strong></td>
                                                    //     </tr> ';
                                                    //     $i++;
                                                    // }
                                                //}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div> -->
                        <?php //}?>



                        <?php if(isset($ss_product_details)){?>
                            <div class="full-width-devider" style="">
                            <div class="col-md-12">
                                <h2 style="float:left; margin-bottom: 0;">Super Stockist Product Stock Details</h2>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                    </ul>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="customers3">
                                                <thead>
                                                    <tr>
                                                        <th>Distributor</th>
                                                    
                                                        <?php
                                                           for($j=0;$j<count($ss_product);$j++){
                                                                echo '<th>'.$ss_product_name[$j].'</th>';
                                                            }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        for($i=0;$i<count($ss_distributor);$i++){
                                                            echo '<tr><td>'.$ss_distributor_name[$i].'</td>';

                                                            for($j=0;$j<count($ss_product);$j++){
                                                                echo '<td>'.$ss_product_details[$ss_distributor[$i]][$ss_product[$j]].'</td>';
                                                            }

                                                            echo '</tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php } ?>

                        <?php //if(isset($product_details_for_distributor)){ ?>
                            <!-- <div class="full-width-devider" style="">
                            <div class="col-md-12">
                                <h2 style="float:left;    margin-bottom: 0;">Super Stockist Product Stock Details</h2>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'csv',escape:'false'});"><img src='<?php //echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'excel',escape:'false'});"><img src='<?php //echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                    </ul>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="customers3">
                                                <thead>
                                                    <tr>
                                                        <th style="padding:5px;" width="5%">Sr no</th>
                                                        <th style="padding:5px;" width="15%">Depot</th>
                                                        <th style="padding:5px;" width="10%">Product</th>
                                                        <th style="padding:5px;" width="10%">Quantity</th>
                                                        <th style="padding:5px;" width="10%">Sale Quantity</th>
                                                        <th style="padding:5px;" width="10%">Bal Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php //if(isset($product_details_for_distributor)){
                                                    // $i=0;
                                                    // foreach($product_details_for_distributor as $row){
                                                    //     echo ' <tr style="word-break: break-word;">
                                                    //     <td style="padding:5px;" width="5%"><strong>'.($i+1).'</strong></td>
                                                    //     <td style="padding:5px;" width="15%"><strong>'.$product_details_for_distributor[$i]->distributor_name.'</strong></td>
                                                    //     <td style="padding:5px;" width="15%"><strong>'.$product_details_for_distributor[$i]->short_name.'</strong></td>
                                                    //     <td style="padding:5px;" width="10%"><strong>'.format_money($product_details_for_distributor[$i]->tot_qty,2).'</strong></td>
                                                    //     <td style="padding:5px;" width="10%"><strong>'.format_money($product_details_for_distributor[$i]->sale_qty,2).'</strong></td>
                                                    //     <td style="padding:5px;" width="10%"><strong>'.format_money($product_details_for_distributor[$i]->bal_qty,2).'</strong></td>
                                                    //     </tr> ';
                                                    //     $i++;
                                                    // }
                                                //}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div> -->
                        <?php //} ?>



                        <?php if(isset($ss_box_details)){?>
                            <div class="full-width-devider" style="">
                            <div class="col-md-12">
                                <h2 style="float:left; margin-bottom: 0;">Super Stockist Box Stock Details</h2>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                        <li><a href="#" onClick ="$('#customers3').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                    </ul>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="customers3">
                                                <thead>
                                                    <tr>
                                                        <th>Distributor</th>
                                                    
                                                        <?php
                                                           for($j=0;$j<count($ss_box);$j++){
                                                                echo '<th>'.$ss_box_name[$j].'</th>';
                                                            }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        for($i=0;$i<count($ss_box_distributor);$i++){
                                                            echo '<tr><td>'.$ss_box_distributor_name[$i].'</td>';

                                                            for($j=0;$j<count($ss_box);$j++){
                                                                echo '<td>'.$ss_box_details[$ss_box_distributor[$i]][$ss_box[$j]].'</td>';
                                                            }

                                                            echo '</tr>';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php }?>

                        <?php //if(isset($box_details_for_distributor)){?>
                            <!-- <div class="full-width-devider" style="">
                            <div class="col-md-12">
                                <h2 style="float:left;    margin-bottom: 0;">Super Stockist Box Stock Details</h2>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Export Data</button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onClick ="$('#customers4').tableExport({type:'csv',escape:'false'});"><img src='<?php //echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                        <li><a href="#" onClick ="$('#customers4').tableExport({type:'excel',escape:'false'});"><img src='<?php //echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                    </ul>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="customers4">
                                                <thead>
                                                    <tr>
                                                        <th style="padding:5px;" width="5%">Sr no</th>
                                                        <th style="padding:5px;" width="15%">Depot</th>
                                                        <th style="padding:5px;" width="10%">Box</th>
                                                        <th style="padding:5px;" width="10%">Quantity</th>
                                                        <th style="padding:5px;" width="10%">Sale Quantity</th>
                                                        <th style="padding:5px;" width="10%">Bal Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php //if(isset($box_details_for_distributor)){
                                                    // $i=0;
                                                    // foreach($box_details_for_distributor as $row){
                                                    //     echo ' <tr style="word-break: break-word;">
                                                    //     <td style="padding:5px;" width="5%"><strong>'.($i+1).'</strong></td>
                                                    //     <td style="padding:5px;" width="15%"><strong>'.$box_details_for_distributor[$i]->distributor_name.'</strong></td>
                                                    //     <td style="padding:5px;" width="15%"><strong>'.$box_details_for_distributor[$i]->short_name.'</strong></td>
                                                    //     <td style="padding:5px;" width="10%"><strong>'.format_money($box_details_for_distributor[$i]->tot_qty,2).'</strong></td>
                                                    //     <td style="padding:5px;" width="10%"><strong>'.format_money($box_details_for_distributor[$i]->sale_qty,2).'</strong></td>
                                                    //     <td style="padding:5px;" width="10%"><strong>'.format_money($box_details_for_distributor[$i]->bal_qty,2).'</strong></td>
                                                    //     </tr> ';
                                                    //     $i++;
                                                    // }
                                                //}?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div> -->
                        <?php //} ?>
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