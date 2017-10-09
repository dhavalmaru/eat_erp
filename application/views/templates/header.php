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
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/theme-blue.css'; ?>"/>
        <!-- EOF CSS INCLUDE -->                                      
		
		<style>
			.tile {padding: 0px;
				   min-height: 77px;}
		</style>
		
    </head>
    <body onload="loadFlag();">								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal">
                    <li class="xn-logo">
                        <a href="index.html"><img src="<?php echo base_url().'img/pecan.png';?>" style="height: 32px;margin-top: -5px;" /></a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-home"></span> <span class="xn-text">Properties</span></a>
                        <ul class="animated zoomIn">
                            <li><a href="<?php echo base_url().'index.php/Autocomplete'; ?>"><span class="fa fa-image"></span> Owner</a></li>
                            <li><a href="purchase_list.html"><span class="fa fa-user"></span> Purchase</a></li>
                            <li><a href="sales_list.html"><span class="fa fa-users"></span> Sale</a></li>
                            <li><a href="tenant_list.html"><span class="fa fa-users"></span> Rent</a></li>
                            <li><a href="loan_list.html"><span class="fa fa-users"></span> Loan</a></li>
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-user"></span> <span class="xn-text">Association</span></a>
                        <ul class="animated zoomIn">
                            <li><a href="<?php echo base_url().'index.php/groups'; ?>"><span class="fa fa-group"></span> Group</a></li>
                            <li><a href="<?php echo base_url().'index.php/contacts'; ?>"><span class="fa fa-user"></span> Contact</a></li>
                            <li><a href="<?php echo base_url().'index.php/bank'; ?>"><span class="fa fa-bank"></span> Bank</a></li>
                        </ul>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-pencil-square-o"></span> <span class="xn-text">Task</span></a>                        
                        <ul class="animated zoomIn">
                            <li><a href="task_list.html"><span class="fa fa-heart"></span> All Task</a></li>                            
                            <li><a href="task_list.html"><span class="fa fa-cogs"></span> My Task</a></li>
                            <li><a href="task_list.html"><span class="fa fa-square-o"></span> Create Task</a></li>
                        </ul>
                    </li>                    
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-dashboard"></span> <span class="xn-text">Dashboard</span></a>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Reports</span></a>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-file-text"></span> <span class="xn-text">Documents</span></a>
                    </li>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-gear"></span> <span class="xn-text">Settings</span></a>
                        <ul class="animated zoomIn">
                            <li><a href="#"><span class="fa fa-heart"></span> My Settings</a></li>                            
                            <li><a href="user_list.html"><span class="fa fa-cogs"></span> User</a></li>
                            <li><a href="user_role_list.html"><span class="fa fa-square-o"></span> User Roles</a></li>
                        </ul>
                    </li>
                    <!-- SIGN OUT -->


					<li class="xn-icon-button pull-right">
					   <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li>
                    <li class="xn-icon-button pull-right">
                        <a href="" style="width:100px;"><span class="xn-text"><?php echo $userdata['groupname'];?></span></a>
                    </li>
                    <!-- END SIGN OUT -->                                        
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                