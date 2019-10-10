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
		/*.fa-eye  { font-size:21px; color:#333;}
            .fa-file-pdf-o{ color:#e80b0b; font-size:21px;}
            .fa-paper-plane-o{ color:#520fbb; font-size:21px;}
				  @media only screen and  (min-width:645px)  and (max-width:718px) { 
				.heading-h3-heading:first-child {     width: 44%!important;}
		   	.heading-h3-heading:last-child {     width: 56%!important;}		
			.heading-h3-heading .btn-margin{ margin-bottom:0px!important; }
		   }
		  @media only screen and  (min-width:709px)  and (max-width:718px) { 			 
			.heading-h3-heading .btn-margin{   }
		   }*/
		</style>
		<style>
		.nav-contacts { margin-top:-5px;}
		.heading-h3 { border:none!important;}
		@media only screen and (min-width:711px) and (max-width:722px) {.u-bgColorBreadcrumb {
		    background-color: #eee;
		    padding-bottom: 13px;
		}}
		@media only screen and (min-width:813px) and (max-width:822px) {.u-bgColorBreadcrumb {
		    background-color: #eee;
		    padding-bottom:50px!important;
		}}
		#customers10
		{
			width:100%!important;
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
            <?php if($status=='pending_for_approval') { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/sample_out/authorise'; ?>" target="_blank">
            <?php } else if($status=='pending_for_delivery') { ?>
                <!-- <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php //echo base_url().'index.php/sample_out/set_delivery_status'; ?>"> -->
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/sample_out/get_batch_details'; ?>" target="_blank">
            <?php } else if($status=='gp_issued') { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/sample_out/set_delivery_status2'; ?>">
            <?php } else { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="">
            <?php } ?>
    		<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">

    			<div class="heading-h3"> 
    				<div class="heading-h3-heading mobile-head"> <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Sample List  </div>						 
    				<div class="heading-h3-heading mobile-head">
                        <div class="pull-right btn-margin"> 
                            <?php $this->load->view('templates/download'); ?>
                            <!-- <a class="btn btn-danger btn-padding dropdown-toggle" href="<?php //echo base_url().'index.php/export/generate_distributor_out_sku_details/'.$status; ?>"><i class="fa fa-download"></i> &nbsp;Download</a> -->
                        </div>
                        <div class="pull-right btn-margin" style="margin-left: 5px; <?php if(($access[0]->r_edit=='1' && ($status=='pending_for_delivery' || $status=='gp_issued')) || ($access[0]->r_approvals=='1' && $status=='pending_for_approval')) echo ''; else echo 'display: none;';?>">
                            <!-- <a class="btn btn-success btn-block btn-padding" data-toggle="modal" href="#myModal">
                                <span class="fa fa-shopping-cart"></span> <?php //if($status=='pending_for_delivery') echo 'Select Delivery Person'; else if($status=='gp_issued') echo 'Select Delivery Status'; else if($status=='pending_for_approval') echo 'Authorise Records'; ?>
                            </a> -->

                            <?php if($status=='pending_for_delivery') { ?>
                                <button class="btn btn-success" type="submit">
                                    <span class="fa fa-shopping-cart"></span> Select Delivery Person
                                </button>
                            <?php } else if($status=='gp_issued') { ?>
                                <button class="btn btn-success btn-block btn-padding" type="button" onClick="get_batch_details();">
                                    <span class="fa fa-shopping-cart"></span> Select Delivery Status
                                </button>
                            <?php } else if($status=='pending_for_approval') { ?>
                                <!-- <button class="btn btn-success btn-block btn-padding" type="button" onClick="get_batch_details();">
                                    <span class="fa fa-shopping-cart"></span> Authorise Records
                                </button> -->
                            <?php } ?>
                        </div>
                        <div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
                            <a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/sample_out/add">
                                <span class="fa fa-plus"></span> Add Sample Entry
                            </a>
                        </div>
    					<!-- <div class="pull-right btn-margin" style="<?php //if($access[0]->r_insert=='0') echo 'display: none;';?>">
    						<a class="btn btn-success " href="<?php //echo base_url() . 'index.php/distributor_out/add'; ?>">
    							<span class="fa fa-plus"></span> Add Distributor Out Entry
    						</a>
    					</div> -->
    				</div>	      
    			</div>

    			<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						

    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<!--<li class="all">
    								<a  href="<?php //echo base_url(); ?>index.php/distributor_out/checkstatus/All">
    									<span class="ng-binding">All</span>
    									<span id="approved">  (<?php //echo $all; ?>)  </span>
    								</a>
    							</li>-->

    							<li class="approved" >
    								<a  href="<?php echo base_url(); ?>index.php/sample_out/checkstatus/Approved">
    									<span class="ng-binding">Approved</span>
    									<span id="approved"> (<?php echo $active; ?>)</span>
    								</a>
    							</li>

    							
    							<li class="pending">
    								<a  href="<?php echo base_url(); ?>index.php/sample_out/checkstatus/pending">
    									<span class="ng-binding">Pending</span>
    									<span id="approved"> (<?php echo $pending; ?>) </span>
    								</a>
    							</li>

                                <li class="pending_for_approval">
                                    <a  href="<?php echo base_url(); ?>index.php/sample_out/checkstatus/pending_for_approval">
                                        <span class="ng-binding">Approval Pending</span>
                                        <span id="approved"> (<?php echo $pending_for_approval; ?>) </span>
                                    </a>
                                </li>

                                <li class="delivery">
                                    <a  href="<?php echo base_url(); ?>index.php/sample_out/checkstatus/pending_for_delivery">
                                        <span class="ng-binding">Delivery Pending</span>
                                        <span id="approved"> (<?php echo $pending_for_delivery; ?>) </span>
                                    </a>
                                </li>

                                <li class="gp_issued">
                                    <a  href="<?php echo base_url(); ?>index.php/sample_out/checkstatus/gp_issued">
                                        <span class="ng-binding">GP Issued</span>
                                        <span id="approved"> (<?php echo $gp_issued; ?>) </span>
                                    </a>
                                </li>

                                <li class="delivered_not_complete">
                                    <a  href="<?php echo base_url(); ?>index.php/sample_out/checkstatus/delivered_not_complete">
                                        <span class="ng-binding">InComplete</span>
                                        <span id="approved"> (<?php echo $delivered_not_complete; ?>) </span>
                                    </a>
                                </li>
                                <li class="inactive">
                                    <a  href="<?php echo base_url(); ?>index.php/sample_out/checkstatus/InActive">
                                        <span class="ng-binding">InActive</span>
                                        <span id="approved"> (<?php echo $inactive; ?>) </span>
                                    </a>
                                </li>

    						</ul>
    						
    					</div>
    				</div>
    			</div>

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
                                                        <th width="50" align="center" style="<?php if($status!='pending_for_delivery' && $status!='gp_issued' ) echo 'display: none;'; ?>">Select</th> 
                                                        <th width="50" style="text-align:center; "align="center">Sr. No.</th>
    													<th width="100">Date Of processing</th>
    													<th width="50" style="text-align:center; ">Edit</th>
														<th width="50" style="text-align:center; <?php if($status=='pending_for_delivery') echo 'display: none;'; ?>">View Voucher</th>
    													<th width="150">Voucher No</th>
    													
    													<th width="120">Distributor Name</th>
                                                        <th width="140">Location</th>
    										
    													<th width="120" >Amount (In Rs)</th>
    									
												
                                                        <th width="110" >Delivery Status</th>
                                              
                                                        <!-- <th width="105" style="text-align:center; display:none;">View GP</th>
    													<th width="50" style="display:none;">Resend Invoice</th> -->
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

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                                <?php if($access[0]->r_approvals=='1' && $status=='pending_for_approval'){
                                    echo 'Authorise Details';
                                } else if($access[0]->r_edit=='1' && $status=='pending_for_delivery'){ 
                                    echo 'Select Delivery Person';
                                } else if($access[0]->r_edit=='1' && $status=='gp_issued'){ 
                                    echo 'Select Delivery Status';
                                } ?>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <?php if($access[0]->r_approvals=='1' && $status=='pending_for_approval'){ ?>
                                <label class="control-label">Authorisation <span class="asterisk_sign">*</span></label>
                                <br/>
                                <div class="">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Approved">Approve</option>
                                        <option value="Rejected">Reject</option>
                                    </select>
                                </div>
                            <?php } else if($access[0]->r_edit=='1' && $status=='pending_for_delivery'){ ?>
                                <label class="control-label">Delivery Person <span class="asterisk_sign">*</span></label>
                                <br/>
                                <div class="">
                                    <select name="sales_rep_id" id="sales_rep_id" class="form-control">
                                        <option value="">Select</option>
                                        <?php if(isset($sales_rep)) { for ($k=0; $k < count($sales_rep) ; $k++) { ?>
                                                <option value="<?php echo $sales_rep[$k]->id; ?>"><?php echo $sales_rep[$k]->sales_rep_name; ?></option>
                                        <?php }} ?>
                                    </select>
                                    <input type="hidden" name="delivery_status" id="delivery_status" value="GP Issued" />
                                </div>

                                <br/>
                                <label class="control-label">Status <span class="asterisk_sign">*</span></label>
                                <br/>
                                <div class="">
                                    <select name="status" id="status" class="form-control">
                                        <option value="Approved">Active</option>
                                        <option value="InActive">InActive</option>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if($access[0]->r_edit=='1' && $status=='gp_issued'){ ?>
                                <label class="control-label">Delivery Status <span class="asterisk_sign">*</span></label>
                                <br/>
                                <div class="">
                                    <select name="delivery_status" id="delivery_status" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Delivered Not Complete">Delivered</option>
                                        <option value="Pending">Return To HO</option>
                                    </select>
                                </div>

                                <br/>
                                <label class="control-label">Status <span class="asterisk_sign">*</span></label>
                                <br/>
                                <div class="">
                                    <select name="status" id="status" class="form-control">
                                        <option value="Approved">Active</option>
                                        <option value="InActive">InActive</option>
                                    </select>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button id="btn_save" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
    	</div>
    	<!-- END PAGE CONTAINER -->

    	<?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    	<script>
        	$(document).ready(function() {
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
                else if(url.includes('pending_for_approval')){
                    // console.log('pending_for_approval');
                    $('.pending_for_approval').attr('class','active');
                }
                else if(url.includes('delivery')){
                    // console.log('delivery');
                    $('.delivery').attr('class','active');
                }
                else if(url.includes('pending')){
                    // console.log('pending');
                    $('.pending').attr('class','active');
                }
                else if(url.includes('gp_issued')){
                    $('.gp_issued').attr('class','active');
                }
        		else if(url.includes('delivered_not_complete')){
                    // console.log('pending_for_delivery');
        			$('.delivered_not_complete').attr('class','active');
        		} 
                else {
                    $('.delivery').attr('class','active');
                }
        		$('.ahrefall').click(function(){
        			alert(window.location.href );
                });
        	});

            // var blFlag = false;
            // $('#myModal').on('hidden.bs.modal', function () {
            //     if(blFlag==true){
            //         location.reload();
            //         blFlag = false;
            //     }
            // });

            $('#btn_save').click(function(){
                if (!$("#form_distributor_out_list").valid()) {
                    return false;
                } else {
                    // $('#myModal').modal('toggle');
                    // blFlag = true;
                }
            });

            var set_checkbox = function(elem){
                var v = elem.checked?elem.value:'false';
                var id = elem.id;
                $('#input_'+id).val(v);
            };

            var get_batch_details = function() {
                $('#myModal').modal('show');

                // console.log('true');

                // $.ajax({
                //     url:BASE_URL+'index.php/Distributor_out/get_batch_details',
                //     method:"post",
                //     data:$('#form_distributor_out_list').serialize(),
                //     dataType:"html",
                //     async:false,
                //     success: function(data){
                //         $('#batch_details').html(data);

                //         addMultiInputNamingRules('#form_distributor_out_list', 'input[name="batch_no[]"]', { required: true }, "");
                //     },
                //     error: function (response) {
                //         var r = jQuery.parseJSON(response.responseText);
                //         alert("Message: " + r.Message);
                //         alert("StackTrace: " + r.StackTrace);
                //         alert("ExceptionType: " + r.ExceptionType);
                //     }
                // });
            }

            var set_batch = function(elem){
                var id = elem.id;
                var index = id.substr(id.lastIndexOf('_')+1);

                // console.log(index);

                var batch_no = $('#batch_no_'+index).val();
                var item_type = $('#item_type_'+index).val();
                var item_id = $('#item_id_'+index).val();

                var counter = $('.batch_no').length;

                // console.log(batch_no);
                // console.log(counter);

                var check_item_type = '';
                var check_item_id = '';

                for(var i=0; i<counter; i++){
                    if(i!=index){
                        check_item_type = $('#item_type_'+i).val();
                        check_item_id = $('#item_id_'+i).val();

                        if(check_item_type==item_type && check_item_id==item_id){
                            $('#batch_no_'+i).val(batch_no);
                        }
                    }
                }
            }
    	</script>
        <script>
            var table;
            var status = '<?php echo $status; ?>';
            $(document).ready(function() {
                var len=10;
                if(status =='gp_issued') {
                    columnDefs = [        
                                    {
                                        "targets": [0],
                                        "visible": true,
                                        "searchable": true
                                    },
								
                                      { "width": "10%", "targets": 8 },
									    { className: "dt-body-center", targets: [ 3,4 ] }
                                ];
                } else if(status!='pending_for_delivery') {
                    columnDefs = [        
                                    {
                                        "targets": [0],
                                        "visible": false,
                                        "searchable": false
                                    },
								
                                      { "width": "10%", "targets": 8 },
									    { className: "dt-body-center", targets: [ 3,4 ] }
                                ];
                } else {
				    columnDefs = [        
                                {
                                    "targets": [0],
                                    "visible": true,
                                    "searchable": true
                                },
									{
                                    "targets": [4],
                                    "visible": false,
                                    "searchable": false
                                },
                                  { "width": "10%", "targets": 8 },
								    { className: "dt-body-center", targets: [ 3,4 ] }
                            ];
				}

                table =  $('#customers10');
                var tableOptions = {
                    "columnDefs": columnDefs,
                    'bPaginate': true,
                    'iDisplayLength': len,
                    aLengthMenu: [
                        [10,25, 50, 100, 200, -1],
                        [10,25, 50, 100, 200, "All"]
                    ],
                    "ajax": {
                        url : BASE_URL+'index.php/Sample_out/get_data/'+status,
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
    	<!-- END SCRIPTS -->      
    </body>
</html>