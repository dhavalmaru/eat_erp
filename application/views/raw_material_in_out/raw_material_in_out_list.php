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
		  @media only screen and  (min-width:709px)  and (max-width:723px) { 
			.heading-h3-heading:first-child {     width: 44%!important;}
		   	.heading-h3-heading:last-child {     width: 56%!important;}				  
			.heading-h3-heading .btn-margin{ margin-bottom:5px; }
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
                   <div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Raw Material In/Out Entry List  </div>						 
					  <div class="heading-h3-heading mobile-head">
					  <div class="pull-right btn-margin">	
							<div class="btn-group pull-right">
                            <?php if(isset($access)) { if($access[0]->r_export == 1) { ?>
                                <button class="btn btn-danger btn-padding dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> &nbsp;Download</button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" onClick ="$('#customers10').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
                                    <li><a href="#" onClick ="$('#customers10').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
                                </ul>
                            <?php } } ?>
                            </div>
						</div>	
                    	<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success  " href="<?php echo base_url() . 'index.php/Raw_material_in_out/add'; ?>">
										<span class="fa fa-plus"></span> Add Raw Material In/Out Entry
									</a>
								</div>
								
								
				     </div>	      
                   </div>	
                

             	<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						

    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<!--<li class="all">
    								<a  href="<?php //echo base_url(); ?>index.php/Raw_material_in_out/checkstatus/All">
    									<span class="ng-binding">All</span>
    									<span id="approved">  (<?php //echo $all; ?>)  </span>
    								</a>
    							</li>-->

    							<li class="approved" >
    								<a  href="<?php echo base_url(); ?>index.php/Raw_material_in_out/checkstatus/Approved">
    									<span class="ng-binding">Approved</span>
    									<span id="approved"> (<?php echo $approved; ?>)</span>
    								</a>
    							</li>

    							<li class="pending">
    								<a  href="<?php echo base_url(); ?>index.php/Raw_material_in_out/checkstatus/Pending">
    									<span class="ng-binding">Pending</span>
    									<span id="approved"> (<?php echo $pending; ?>) </span>
    								</a>
    							</li>

                                <li class="rejected">
                                    <a  href="<?php echo base_url(); ?>index.php/Raw_material_in_out/checkstatus/Rejected">
                                        <span class="ng-binding">Rejected</span>
                                        <span id="approved"> (<?php echo $rejected; ?>) </span>
                                    </a>
                                </li>

                                <li class="inactive">
                                    <a  href="<?php echo base_url(); ?>index.php/Raw_material_in_out/checkstatus/InActive">
                                        <span class="ng-binding">InActive</span>
                                        <span id="approved"> (<?php echo $inactive; ?>) </span>
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
								<table id="customers10" class="table datatable table-bordered" width="100%" >
									<thead>
										<tr>
										  <th width="65" style="text-align:center;" >Sr. No.</th>
										  <th width="90">Date Of Processing</th>
											<th style="text-align:center;" width="65">Edit</th>
											<th >Depot Name</th>
                                            <th >Type</th>
										 <!--	<th width="110">Creation Date</th>-->
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                            
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
		<script type="text/javascript">
         var BASE_URL="<?php echo base_url()?>";
        </script>
    <!-- END SCRIPTS -->      
        <script type="text/javascript">
        $(document).ready(function() {
            var url = window.location.href;
            if(url.includes('All')){
                $('.all').attr('class','active');
            }
            else  if(url.includes('InActive')){
                $('.inactive').attr('class','active');
            }
            else  if(url.includes('Approved')){
                $('.approved').attr('class','active');
            }
            else  if(url.includes('Pending')){
                // console.log('pending');
                $('.pending').attr('class','active');
            }else  if(url.includes('Rejected')){
                // console.log('pending');
                $('.rejected').attr('class','active');
            }
            else {
                $('.approved').attr('class','active');
            }
            $('.ahrefall').click(function(){
                alert(window.location.href );
            });
        });
    </script>
    <script>
            var table;
            var status = '<?php echo $status; ?>';
            $(document).ready(function() {
                
                var len=10;
						columnDefs = 	[
											{ className: "dt-body-center", targets: [ 0, 1, 2 ] }
										];
                table =  $('#customers10');
                var tableOptions = {
                    'bPaginate': true,
                    'columnDefs': columnDefs,
                    'iDisplayLength': len,
                    aLengthMenu: [
                        [10,25, 50, 100, 200, -1],
                        [10,25, 50, 100, 200, "All"]
                    ],
                    "ajax": {
                        url : BASE_URL+'index.php/Raw_material_in_out/get_data_ajax/'+status,
                        // data: {status: status},
                        type : 'GET'
                    },
                    'bDeferRender': true,
                    'bProcessing': true
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
               });
    </script>
    </body>
</html>