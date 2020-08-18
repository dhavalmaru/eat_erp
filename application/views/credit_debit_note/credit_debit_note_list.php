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
		</style>	
    </head>
    <body>								
       	<!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			<?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
            	<div class="heading-h3"> 
                   	<div class="heading-h3-heading mobile-head">
                   		<a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Credit Debit Note List  
                   	</div>
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
							<a class="btn btn-success " href="<?php echo base_url() . 'index.php/credit_debit_note/add'; ?>">
								<span class="fa fa-plus"></span> Add Credit Debit Note Entry 
							</a>
						</div>
			     	</div>
            	</div>

                <div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<!--<li class="all">
    								<a  href="<?php //echo base_url(); ?>index.php/credit_debit_note/checkstatus/All">
    									<span class="ng-binding">All</span>
    									<span id="approved">  (<?php //echo $all; ?>)  </span>
    								</a>
    							</li>-->

    							<li class="approved" >
    								<a  href="<?php echo base_url(); ?>index.php/credit_debit_note/checkstatus/Approved">
    									<span class="ng-binding">Approved</span>
    									<span id="approved"> (<?php echo $approved; ?>)</span>
    								</a>
    							</li>

    							<li class="pending">
    								<a  href="<?php echo base_url(); ?>index.php/credit_debit_note/checkstatus/Pending">
    									<span class="ng-binding">Pending</span>
    									<span id="approved"> (<?php echo $pending; ?>) </span>
    								</a>
    							</li>

                                <li class="rejected">
                                    <a  href="<?php echo base_url(); ?>index.php/credit_debit_note/checkstatus/Rejected">
                                        <span class="ng-binding">Rejected</span>
                                        <span id="approved"> (<?php echo $rejected; ?>) </span>
                                    </a>
                                </li>

                                <li class="inactive">
                                    <a  href="<?php echo base_url(); ?>index.php/credit_debit_note/checkstatus/InActive">
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
								<table id="customers10" class="table datatable table-bordered"  >
									<thead>
										<tr>
										    <th width="58" style="text-align:center;"> Sr. No.</th>
											<th width="90">Date Of Transaction</th>
											<th width="58" style="text-align:center;"> Edit </th>
											<th width="80">View Credit Debit Note</th>
											<th width="200">Invoice No.</th>
											<th width="300">Distributor Name</th>
											<th width="90">Transaction</th>
											<th width="50">Amount (In Rs) </th>
											<!--<th width="100">Creation Date</th>-->
											<th width="300">Remarks</th>
											<!--<th width="110">Status</th>-->
										</tr>
									</thead>
									<tbody>
									<?php 
										if(isset($data)) {
											for ($i=0; $i < count($data); $i++) { 
									?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td>
                                                <span style="display:none;">
                                                    <?php echo (($data[$i]->date_of_transaction!=null && $data[$i]->date_of_transaction!='')?date('Ymd',strtotime($data[$i]->date_of_transaction)):''); ?>
                                                </span>
                                              <?php echo (($data[$i]->date_of_transaction!=null && $data[$i]->date_of_transaction!='')?date('d/m/Y',strtotime($data[$i]->date_of_transaction)):''); ?>
                                            </td>
											<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/credit_debit_note/edit/'.$data[$i]->id; ?>"><i class="fa fa-edit"></i></a></td>
											<td style="font-size:20px;text-align:center; vertical-align: middle;">
												<?php if($data[$i]->ref_no!=null && $data[$i]->ref_no!=''){ ?>
													<a href="<?php echo base_url().'index.php/credit_debit_note/view_credit_debit_note/'.$data[$i]->id; ?>" target="_blank"> 
					                                    <span class="fa fa-file-pdf-o" style="font-size:20px;text-align:center"></span>
					                                </a>
												<?php } ?>
											</td>
											<td><?php echo $data[$i]->ref_no; ?></td>
											<td><?php echo $data[$i]->distributor_name; ?></td>
											<td><?php echo $data[$i]->transaction; ?></td>
											<td><?php echo format_money($data[$i]->amount,2); ?></td>
											<!--<td>
												<span style="display:none;">
                                                    <?php//echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('Ymd',strtotime($data[$i]->modified_on)):''); ?>
                                                </span>
												<?php// echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>-->
											<td><?php echo $data[$i]->remarks; ?></td>
											<!--<td><?php //echo $data[$i]->status; ?></td>-->
										
										</tr>
									<?php 
											}
										} 
									?>
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
	    	$(document).ready(function() {
	    		var BASE_URL="<?php echo base_url()?>";
	    		var url = window.location.href;

	    		if(url.includes('All')){
	                $('.all').attr('class','active');
	            }
	            else if(url.includes('InActive')){
	                $('.inactive').attr('class','active');
	            }
	            else if(url.includes('Approved')){
	                $('.approved').attr('class','active');
	            }
	            else if(url.includes('Pending')){
	                $('.pending').attr('class','active');
	            }
	            else  if(url.includes('Rejected')){
	                $('.rejected').attr('class','active');
	            } 
	            else {
	                $('.approved').attr('class','active');
	            }

	            var status = '<?php echo $status; ?>';
	            var len = 10;
	            var columnDefs = [];

                columnDefs = [    
                                {
                                    "targets": [0],
                                    "searchable": false
                                },       
                                {
                                    "targets": [2],
                                    "searchable": false
                                }, 
								// { "width": "10%", "targets": 8 },
								{ className: "dt-body-center", targets: [ 0,2 ] }
                            ];

	            $('#customers10').DataTable({
	                // "pageLength" : 10,
	                "bProcessing": true,
	                "searchDelay": 3000,
	                "serverSide": true,
	                "columnDefs": columnDefs,
	                "iDisplayLength": len,
	                aLengthMenu: [
	                                [10,25, 50, 100, 200, -1],
	                                [10,25, 50, 100, 200, "All"]
	                            ],
	                "ajax":{
	                        url : BASE_URL+'index.php/Credit_debit_note/get_data/'+status,
	                        type: "post",
	                        async: false,
	                        data: function(data) {       
	                            data.status = status;
	                        },
	                        "dataSrc": function ( json ) {
	                            return json.data;
	                        },
	                        // error: function() {
	                        //     $(table+"_processing").css("display","none");
	                        // }
	                    }
	            });
	            
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