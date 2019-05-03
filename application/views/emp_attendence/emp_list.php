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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>    
        <!-- EOF CSS INCLUDE -->   
        <style>
            .fa-eye  { font-size:21px; color:#333;}
            .fa-file-pdf-o{ color:#e80b0b; font-size:21px;}
            .fa-paper-plane-o{ color:#520fbb; font-size:21px;}
            @media only screen and (min-width:495px) and (max-width:717px) {.btn-bottom { margin-top:5px;}}
        </style>	

        <style>
            .sidenav1 {
               height: 50%;
                width: 0;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: #111;
                overflow-x: hidden;
                transition: 0.5s;
                padding-top: 60px;
                margin-top: 100px;
            }
            .sidenav1 a {
                padding: 8px 8px 8px 32px;
                text-decoration: none;
                font-size: 15px;
                color: #818181;
                display: block;
                transition: 0.3s;
            }
            .sidenav1 a:hover {
                color: #f1f1f1;
            }
            .sidenav1 .closebtn {
                position: absolute;
                top: 0;
                right: 25px;
                font-size: 50px;
                margin-left: 50px;
            }
            @media screen and (max-height: 450px) {
              .sidenav1 {padding-top: 15px;}
              .sidenav1 a {font-size: 18px;}
            }
            </style>
            <style>
            .nav-contacts { margin-top:-5px;}
            .heading-h3 { border:none!important;}
            @media only screen and (min-width:711px) and (max-width:722px) {
                .u-bgColorBreadcrumb {
                    background-color: #eee;
                    padding-bottom: 13px;
                }
            }
            @media only screen and (min-width:813px) and (max-width:822px) {
                .u-bgColorBreadcrumb {
                    background-color: #eee;
                    padding-bottom:50px!important;
                }
            }
            @media only screen and (min-width:999px) {
                .mysidenav {
                    display: none;
                }
            }
            #customers10 {width: 100% !important;}
        </style>    	
    </head>
    <body>								
             <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                   <div class="heading-h3"> 
                   <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; 
                   
                   Employee Attendence </div>	 
					 
					  <div class="heading-h3-heading">
    					  <div class="pull-right btn-margin">	
    						<!-- <?php //$this->load->view('templates/download');?>	 -->
    					  </div>
                          <?php 
                              if($this->session->userdata('user_name')=='rishit.sanghvi@eatanytime.in'){?>  	
                    	<div class="pull-right btn-margin  btn-bottom "  >
							<a class="btn btn-success" data-toggle="modal" href="#myModal">
                                <span class="fa fa-file-excel-o"></span> Add Excel
                            </a>
						</div>

                        <div class="pull-right btn-margin  btn-bottom ">
                        <button id="send_mail" class="btn btn-danger btn-padding"><i class="fa fa-send-o"></i> &nbsp;Send Mail</button>
                            </select>
                        </div>
                          
                        <div class="pull-right btn-margin  btn-bottom " >
                            <a href="<?=base_url().'index.php/Eat_Attendence/download_excel'?>" class="btn btn-danger btn-padding" ><span class="fa fa-download "></span> Download</a>
                        </div>
                        <div class="pull-right btn-margin  btn-bottom "  >
                            <a href="<?=base_url().'index.php/Eat_Attendence/download_excel_summery/approved'?>" class="btn btn-danger btn-padding" ><span class="fa fa-download "></span> Download Summary</a>
                        </div>
						<div class="pull-right btn-margin  btn-bottom "  >
                            <a href="<?=base_url().'index.php/Eat_Attendence/download_excel/approved'?>" class="btn btn-danger btn-padding" ><span class="fa fa-download "></span> Download Approved</a>
							</div>
                        <?php } ?>
                        <div class="pull-right btn-margin  btn-bottom " >
                            <select name="month" class="form-control btn btn-success btn-block btn-padding" id="month">
                                <option value="">Select Month</option>
                                <?php

                                $start_date = new DateTime();
                                $current_date = new DateTime();
                                $start_date->modify("-12 months");
                                $current_date->modify("-1 months");

                                while($start_date<=$current_date) {
                                    if($start_date==$current_date)
                                        $selected=" selected";
                                    else
                                        $selected="";

                                    echo '<option value="'.$start_date->format('Y-m').'" '.$selected.'>'.$start_date->format('Y-F').'</option>';
                                    $start_date->modify('+1 months');
                                }

                                // $current_year = date("Y");
                                // $current_month = date("m");
                                // $current_year = "2018";
                                // $current_month = "12";
                                // for ($m=1; $m<=12; $m++) {
                                //     $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                //     if($m<=($current_month)) {
                                //         // if($m==($current_month-1))
                                //         if($m==($current_month))
                                //             $selected="selected";
                                //         else
                                //             $selected=" ";

                                //         echo '<option value="'.$m.'" '.$selected.'>'.$current_year.'-'.$month.'</option>'; 
                                //     }
                                // }
                                ?>
                            </select>
							 
                        </div>

                       
				</div>	      
                </div>	 
              	<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<!--<li class="all">
    								<a  href="<?php //echo base_url(); ?>index.php/Purchase_order/checkstatus/All">
    									<span class="ng-binding">All</span>
    									<span id="approved">  (<?php //echo $all; ?>)  </span>
    								</a>
    							</li>-->

    							<li class="approved ng-binding" data-attr="Approved">
    								<a  href="javascript:void(0)">
    									<span >Approved</span>
    									<span id="approved"> (<?php echo $approved; ?>)</span>
    								</a>
    							</li>

    							<li class="pending ng-binding" data-attr="Pending">
    								<a  href="javascript:void(0)">
    									<span >Pending</span>
    									<span id="pending"> (<?php echo $pending; ?>) </span>
    								</a>
    							</li>

                                <li class="pending_for_approval ng-binding" data-attr="pending_for_approval">
                                    <a  href="javascript:void(0)">
                                        <span >Pending For Approval</span>
                                        <span id="pending_for_approval"> (<?php echo $pending_for_approval; ?>) </span>
                                    </a>
                                </li>

                                <li class="rejected ng-binding" data-attr="rejected">
                                    <a  href="javascript:void(0)">
                                        <span>Rejected</span>
                                        <span id="rejected"> (<?php echo $rejected; ?>) </span>
                                    </a>
                                </li>
    						</ul>
    						
    					</div>
    				</div>
    			</div>
                 <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row">	
				    	<div class="page-width">					
                          <div class="col-md-12">
						   <div class="panel panel-default">
							  <div class="panel-body">
								<div class="table-responsive">
							       <div class="table-responsive">
                                   <table id="customers10" class="table datatable table-bordered" >
                                    <thead>
                                        <tr>
                                            <th width="65"  style="text-align:center;"  >Sr. No.</th>
                                            <th width="95">Employee Code</th>
											   <th width="65" style="text-align:center; ">Edit</th>
                                            <th width=" ">Employee Name</th>
                                            <th width=" ">Date</th>
                                            <th width=" ">Total Count</th>
                                            <th width=" ">Total Holiday</th>
                                            <th width=" ">Total Weekly Off</th>
                                            <th width=" ">Total Leaves</th>
                                            <!-- <th width="110 ">Creation Date</th>-->
                                            <!-- <th width="100" style="text-align:center;">Send Email</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                </table>
								</div>
							</div>
                           </div>
						</div>
						</div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            

            <div class="modal fade" id="myModal" role="dialog" style="">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                               Upload Excel
                            </h4>
                        </div>
                        <form id="form_area_details" role="form" 
                            class="form-horizontal" method="post" action="<?php echo base_url().'index.php/Eat_Attendence/upload_excel'; ?>" enctype="multipart/form-data">

                        <div class="modal-body">
                         <div class="form-group">

                             <label class="col-md-4 col-sm-4 col-xs-12 control-label">Add Excel <span class="asterisk_sign"></span></label>
                         
                            <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="upload" id="image" placeholder="image" value="" style="left: -235.656px; top: 8px;">
                         </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            
                            <input type="submit"  class="btn btn-success pull-right"  value="Save" />
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
		
    <!-- END SCRIPTS -->      
    <script type="text/javascript">
        var BASE_URL="<?php echo base_url()?>";
    </script>
    <script type="text/javascript">
        $(document).ready(function() { 
            var url = window.location.href;
            if(url.includes('pending_for_approval')){
                $('.pending_for_approval').addClass('ng-binding');
                $('.pending_for_approval').attr('class','active');
            } else  if(url.includes('Approved')){
                $('.approved').addClass('ng-binding');
                $('.approved').addClass('active');
            } else  if(url.includes('Pending')){
                // console.log('pending');
                $('.pending').addClass('ng-binding');
                $('.pending').addClass('active');
            } else  if(url.includes('Rejected')){
                // console.log('pending');
                $('.rejected').addClass('ng-binding');
                $('.rejected').addClass('active');
            } else {
                $('.pending_for_approval').addClass('ng-binding');
                $('.pending_for_approval').addClass('active');
            }
            $('.ahrefall').click(function(){
                alert(window.location.href );
            });
        });
    </script>
    <script>
        var table;
        var status = '<?php echo $status; ?>';
        
        // var d = new Date();
        // var current_year = d.getFullYear();
        // var current_year = "2018";
        $(document).ready(function() {
            $("#send_mail").click(function(){
                $(this).text('Processing...');
                var selected_month = $("#month").val();
                if(selected_month.indexOf("-")!=-1){
                    var current_year = selected_month.substring(0, selected_month.indexOf("-"));
                    selected_month = selected_month.substring(selected_month.indexOf("-")+1);
                    // console.log(current_year);
                    // console.log(selected_month);
                    $.ajax({
                        url : BASE_URL+'index.php/Eat_Attendence/send_bulk_mail/'+current_year+'/'+selected_month,
                        type : 'GET',
                        success:function(data){
                            if(data=='success'){
                                $("#send_mail").html('<i class="fa fa-send-o"></i>   Send Mail');
                            }
                            /*var obj = JSON.parse(data);
                            $('#approved').text('('+obj.approved+')');
                            $('#pending').text('('+obj.pending+')');
                            $('#pending_for_approval').text('('+obj.pending_for_approval+')');
                            $('#rejected').text('('+obj.rejected+')');*/
                        }
                    });
                }
            });

            if(status=='') status='pending_for_approval';

            get_attendence();
            get_count();              

            $( "#month" ).change(function() {
                $('#customers10').DataTable().destroy();
                get_attendence();
                get_count(); 
            });

            $('.ng-binding').click(function(){
                $('.ng-binding').each(function(){
                    if ($(this).hasClass('active')){
                        $(this).removeClass('active');
                    }
                });

                $(this).addClass('ng-binding');
                $(this).addClass('active');

                $('#customers10').DataTable().destroy();

                status = $(this).attr('data-attr');
                get_attendence();
                get_count();     
            });
        });

        function get_attendence(){
            var len=10;
            var selected_month = $("#month").val();
            // console.log(selected_month);
            
            if(selected_month.indexOf("-")!=-1){
                var current_year = selected_month.substring(0, selected_month.indexOf("-"));
                selected_month = selected_month.substring(selected_month.indexOf("-")+1);
                // console.log(current_year);
                // console.log(selected_month);

                table =  $('#customers10');
                var tableOptions = {
                    'bPaginate': true,
                    'iDisplayLength': len,
                    aLengthMenu: [
                        [10,25, 50, 100, 200, -1],
                        [10,25, 50, 100, 200, "All"]
                    ],
                    "ajax": {
                        url : BASE_URL+'index.php/Eat_Attendence/get_data_ajax',
                        data: {status: status,year:current_year,month:selected_month},
                        type : 'POST'
                    },
                    'bDeferRender': true,
                    'bProcessing': true,
                    'paging': false
                };
                table.DataTable(tableOptions);
                
                $("#csv").click(function(){
                    table.DataTable().destroy();
                    tableOptions.bPaginate = false;
                    table.DataTable(tableOptions);
                    table.tableExport({type:'csv',escape:'false'});
                    table.DataTable().destroy();
                    tableOptions.bPaginate = true;
                    table.DataTable(tableOptions);
                });
                $("#xls").click(function(){
                    table.DataTable().destroy();
                    tableOptions.bPaginate = false;
                    table.DataTable(tableOptions);
                    table.tableExport({type:'excel',escape:'false'});
                    table.DataTable().destroy();
                    tableOptions.bPaginate = true;
                    table.DataTable(tableOptions);
                });
                $("#txt").click(function(){
                    table.DataTable().destroy();
                    tableOptions.bPaginate = false;
                    table.DataTable(tableOptions);
                    table.tableExport({type:'txt',escape:'false'});
                    table.DataTable().destroy();
                    tableOptions.bPaginate = true;
                    table.DataTable(tableOptions);
                });
                $("#doc").click(function(){
                    table.DataTable().destroy();
                    tableOptions.bPaginate = false;
                    table.DataTable(tableOptions);
                    table.tableExport({type:'doc',escape:'false'});
                    table.DataTable().destroy();
                    tableOptions.bPaginate = true;
                    table.DataTable(tableOptions);
                });
                $("#powerpoint").click(function(){
                    table.DataTable().destroy();
                    tableOptions.bPaginate = false;
                    table.DataTable(tableOptions);
                    table.tableExport({type:'powerpoint',escape:'false'});
                    table.DataTable().destroy();
                    tableOptions.bPaginate = true;
                    table.DataTable(tableOptions);
                });
                $("#png").click(function(){
                    table.DataTable().destroy();
                    tableOptions.bPaginate = false;
                    table.DataTable(tableOptions);
                    table.tableExport({type:'png',escape:'false'});
                    table.DataTable().destroy();
                    tableOptions.bPaginate = true;
                    table.DataTable(tableOptions);
                });
                $("#pdf").click(function(){
                    table.DataTable().destroy();
                    tableOptions.bPaginate = false;
                    table.DataTable(tableOptions);
                    table.tableExport({type:'pdf',escape:'false'});
                    table.DataTable().destroy();
                    tableOptions.bPaginate = true;
                    table.DataTable(tableOptions);
                });
            }
        }

        function get_count(){
            var selected_month = $("#month").val();

            if(selected_month.indexOf("-")!=-1){
                var current_year = selected_month.substring(0, selected_month.indexOf("-"));
                selected_month = selected_month.substring(selected_month.indexOf("-")+1);
                // console.log(current_year);
                // console.log(selected_month);

                $.ajax({
                    url : BASE_URL+'index.php/Eat_Attendence/get_total_count',
                    data: {status: '',year:current_year,month:selected_month},
                    type : 'POST',
                    success:function(data){
                        var obj = JSON.parse(data);
                        $('#approved').text('('+obj.approved+')');
                        $('#pending').text('('+obj.pending+')');
                        $('#pending_for_approval').text('('+obj.pending_for_approval+')');
                        $('#rejected').text('('+obj.rejected+')');
                    }
                });
            }
        }
    </script>
    </body>
</html>