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
			@media only screen and  (min-width:645px)  and (max-width:718px) { 
				.heading-h3-heading:first-child {     width: 44%!important;}
		   		.heading-h3-heading:last-child {     width: 56%!important;}		
				.heading-h3-heading .btn-margin{ margin-bottom:0px!important; }
		   	}
		  	@media only screen and  (min-width:709px)  and (max-width:718px) { 			 
				.heading-h3-heading .btn-margin{   }
		   	}
			.dt-body-center
			{
				text-align:center;
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
                   <div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Distributor In List  </div>						 
					  <div class="heading-h3-heading mobile-head">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                       	<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success " href="<?php echo base_url() . 'index.php/distributor_in/add';?>">
										<span class="fa fa-plus"></span> Add Sales Return Entry
									</a>
								</div>
				     </div>	      
                </div>	
                
    			<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						

    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<!--<li class="all">
    								<a  href="<?php //echo base_url(); ?>index.php/distributor_in/checkstatus/All">
    									<span class="ng-binding">All</span>
    									<span id="approved">  (<?php //echo $all; ?>)  </span>
    								</a>
    							</li>-->

    							<li class="approved" >
    								<a  href="<?php echo base_url(); ?>index.php/distributor_in/checkstatus/Approved">
    									<span class="ng-binding">Approved</span>
    									<span id="approved"> (<?php echo $approved; ?>)</span>
    								</a>
    							</li>

    							<li class="pending">
    								<a  href="<?php echo base_url(); ?>index.php/distributor_in/checkstatus/Pending">
    									<span class="ng-binding">Pending</span>
    									<span id="approved"> (<?php echo $pending; ?>) </span>
    								</a>
    							</li>

                                <li class="rejected">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_in/checkstatus/Rejected">
                                        <span class="ng-binding">Rejected</span>
                                        <span id="approved"> (<?php echo $rejected; ?>) </span>
                                    </a>
                                </li>

                                <li class="inactive">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_in/checkstatus/InActive">
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
											<th width="58" style="text-align:center;">Sr. No.</th>
										
											<th width="150" >Date Of processing</th>
											<th width="58" style="text-align:center;">Edit</th>
											<th width="105" class="hide_col">View Receipt</th>
											<th width="250">Sales Return No</th>
											<th width="250">Order No</th>
									
											<th width="250"  >Distributor Name</th>
								
											<th width="120" >Amount (In Rs)</th>
										
											<th width="100" style=" <?php //if($status!='gp_issued') echo 'display: none;'; ?>">Credit Debit Note</th>
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
		<script>
			var url = window.location.href;
	    	$(document).ready(function() {
	    		hide_url(url);
	    	});

	    	function hide_url(url) {
	    		if(url.includes('All')){
	                $('.all').attr('class','active');
	                $('.hide_col').show();
	            } else if(url.includes('InActive')){
	                $('.inactive').attr('class','active');
	                $('.hide_col').hide();
	            } else if(url.includes('Approved')){
	                $('.approved').attr('class','active');
	                $('.hide_col').show();
	            } else if(url.includes('Pending')){
	                $('.pending').attr('class','active');
	                $('.hide_col').hide();
	            } else  if(url.includes('Rejected')){
	                $('.rejected').attr('class','active');
	                $('.hide_col').hide();
	            } else {
	                $('.approved').attr('class','active');
	                $('.hide_col').show();
	            }
	    	}
		</script>
		<script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
		<script>
	        var table;
	        var status = '<?php echo $status; ?>';
	        var len = 10;

	        if(url.includes('All')){
	                $('.all').attr('class','active');
	               	columnDefs = [        
                                    {
                                        "targets": [3],
                                        "visible": true
                                    },
									 { className: "dt-body-center", targets: [ 0, 2, 3 ] }
                                ];
	            } else if(url.includes('InActive')){
	                columnDefs = [        
                                   
									{
                                        "targets": [3],
                                        "visible": false
                                       
                                    },
									 { className: "dt-body-center", targets: [ 0, 2, 3 ] }
                                ];
	            } else if(url.includes('Approved')){
	               columnDefs = [        
                                    {
                                        "targets": [3],
                                        "visible": true
                                    },
									  { className: "dt-body-center", targets: [ 0, 2, 3 ] }
									 
                                ];
	            } else if(url.includes('Pending')){
	                 columnDefs = [        
                                    
									{
                                        "targets": [3],
                                        "visible": false
                                       
                                    },
									 { className: "dt-body-center", targets: [ 0, 2, 3 ] }
                                ];
	            } else  if(url.includes('Rejected')){
	                 columnDefs = [        
                                    
									{
                                        "targets": [3],
                                        "visible": false
                                       
                                    },
									 { className: "dt-body-center", targets: [ 0, 2, 3 ] }
                                ];
	            } else {
	                $('.approved').attr('class','active');
	                columnDefs = [        
                                    {
                                        "targets": [3],
                                        "visible": true
                                    },
									 { className: "dt-body-center", targets: [ 0, 2, 3 ] }
                                ];
	            }
	    	$(document).ready(function() {
            
	            table =  $('#customers10');
	            var tableOptions = {
	                'bPaginate': true,
	                "columnDefs": columnDefs,
	                'iDisplayLength': len,
	                aLengthMenu: [
	                    [10,25, 50, 100, 200, -1],
	                    [10,25, 50, 100, 200, "All"]
	                ],
	                 "ajax": {
	                    url : BASE_URL+'index.php/Distributor_in/get_data/'+status,
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
    <!-- END SCRIPTS -->      
    </body>
</html>