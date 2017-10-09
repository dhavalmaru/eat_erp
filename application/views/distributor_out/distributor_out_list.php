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
        #customers10 {width: 100% !important;}
		</style>	
    </head>
    <body>
        
    	<!-- START PAGE CONTAINER -->
    	<div class="page-container page-navigation-top">            
    		<!-- PAGE CONTENT -->
    		<?php $this->load->view('templates/menus');?>
            <?php if($status=='pending_for_approval') { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_out/authorise'; ?>" target="_blank">
            <?php } else if($status=='pending_for_delivery') { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_out/set_delivery_status'; ?>" target="_blank">
            <?php } else if($status=='gp_issued') { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_out/set_delivery_status2'; ?>">
            <?php } else { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="">
            <?php } ?>
    		<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">

    			<div class="heading-h3"> 
    				<div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Sales List  </div>						 
    				<div class="heading-h3-heading mobile-head">
                        <div class="pull-right btn-margin"> 
                            <?php $this->load->view('templates/download');?>    
                        </div>
                        <div class="pull-right btn-margin" style="margin-left: 5px; <?php if(($access[0]->r_edit=='1' && ($status=='pending_for_delivery' || $status=='gp_issued')) || ($access[0]->r_approvals=='1' && $status=='pending_for_approval')) echo ''; else echo 'display: none;';?>">
                            <a class="btn btn-success btn-block btn-padding" data-toggle="modal" href="#myModal">
                                <span class="fa fa-shopping-cart"></span> <?php if($status=='pending_for_delivery') echo 'Select Delivery Person'; else if($status=='gp_issued') echo 'Select Delivery Status'; else if($status=='pending_for_approval') echo 'Authorise Records'; ?>
                            </a>
                        </div>
                        <div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0' || $status=='pending_for_delivery' || $status=='gp_issued' || $status=='delivered_not_complete' || $status=='pending_for_approval') echo 'display: none;';?>">
                            <a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/distributor_out/add">
                                <span class="fa fa-plus"></span> Add Sales Entry
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
    								<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/Approved">
    									<span class="ng-binding">Approved</span>
    									<span id="approved"> (<?php echo $active; ?>)</span>
    								</a>
    							</li>

    							
    							<li class="pending">
    								<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending">
    									<span class="ng-binding">Pending</span>
    									<span id="approved"> (<?php echo $pending; ?>) </span>
    								</a>
    							</li>

                                <li class="pending_for_approval">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending_for_approval">
                                        <span class="ng-binding">Approval Pending</span>
                                        <span id="approved"> (<?php echo $pending_for_approval; ?>) </span>
                                    </a>
                                </li>

                                <li class="delivery">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending_for_delivery">
                                        <span class="ng-binding">Delivery Pending</span>
                                        <span id="approved"> (<?php echo $pending_for_delivery; ?>) </span>
                                    </a>
                                </li>

                                <li class="gp_issued">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/gp_issued">
                                        <span class="ng-binding">GP Issued</span>
                                        <span id="approved"> (<?php echo $gp_issued; ?>) </span>
                                    </a>
                                </li>

                                <li class="delivered_not_complete">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/delivered_not_complete">
                                        <span class="ng-binding">InComplete</span>
                                        <span id="approved"> (<?php echo $delivered_not_complete; ?>) </span>
                                    </a>
                                </li>
                                <li class="inactive">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/InActive">
                                        <span class="ng-binding">Cancelled</span>
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
    										<table id="customers10" class="table datatable table-bordered">
    											<thead>
    												<tr>
                                                        <th width="65" align="center" style="<?php if($status!='pending_for_delivery' && $status!='gp_issued' && $status!='pending_for_approval') echo 'display: none;'; ?>">Select</th>
                                                        <th width="65" align="center">Sr. No.</th>
                                                        <th width="156">Date Of processing</th>
    													<th width="130">Invoice No</th>
    													<th width="140">Depot Name</th>
    													<th width="140">Distributor Name</th>
                                                        <th width="140">Location</th>
    													<th width="220" >Sales Representative Name</th>
    													<th width="120" >Amount (In Rs)</th>
    													<th width="110" >Creation Date</th>
														<th width="110" >Status</th>
                                                        <th width="110" >Delivery Status</th>
                                                        <th width="110" >Delivery Person</th>
    													<th width="105" style="text-align:center;">View Invoice</th>
                                                        <th width="105" style="text-align:center; <?php if($status!='gp_issued') echo 'display: none;'; ?>">View GP</th>
    													<th width="50" style="display:none;">Resend Invoice</th>
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
                                        <!-- <option value="Pending">Active</option> -->
                                        <option value="Approved">Active</option>
                                        <option value="InActive">InActive</option>
                                    </select>
                                </div>
                            <?php } else if($access[0]->r_edit=='1' && $status=='gp_issued'){ ?>
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
                                        <!-- <option value="Pending">Active</option> -->
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
	<script>
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
            else  if(url.includes('pending_for_approval')){
                // console.log('pending_for_approval');
                $('.pending_for_approval').attr('class','active');
            }
            else  if(url.includes('delivery')){
                // console.log('delivery');
                $('.delivery').attr('class','active');
            }
            else  if(url.includes('pending')){
                // console.log('pending');
                $('.pending').attr('class','active');
            }
            else  if(url.includes('gp_issued')){
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

        var blFlag = false;
        $('#myModal').on('hidden.bs.modal', function () {
            if(blFlag==true){
                location.reload();
                blFlag = false;
            }
        });

        $('#btn_save').click(function(){
            $('#myModal').modal('toggle');
            blFlag = true;
        });

        // $('input[name="check_val[]"]').on('ifChanged', function(event){
        //     var v = $(this).is(':checked')?$(this).val():'false';
        //     var id = $(this).attr('id');
        //     $('#input_'+id).val(v);
        // });

        var set_checkbox = function(elem){
            var v = elem.checked?elem.value:'false';
            var id = elem.id;
            $('#input_'+id).val(v);
        };

        // $('#form_distributor_out_list').on('submit', function(e) {
        //     e.preventDefault();
        //     var formAction = $('#form_distributor_out_list').attr("action");
        //     $.post(formAction, $(this).serialize());
        //     window.open($('#form_distributor_out_list').prop('action'));
        //     return false;
        // });
	</script>
    <script>
        var table;
        $(document).ready(function() {
            // var len=<?php //if($status=='pending_for_delivery' || $status=='gp_issued') echo '-1';else echo '10';?>;

            var status = '<?php echo $status; ?>';
            var len = 10;
            var columnDefs = [];
            if(status == 'pending_for_delivery' || status == 'gp_issued' || status == 'pending_for_approval') {
                len = -1;

                if(status == 'gp_issued') {
                    columnDefs = [        
                                    {
                                        "targets": [15],
                                        "visible": false
                                    }
                                ];
                } else {
                    columnDefs = [        
                                    {
                                        "targets": [14],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [15],
                                        "visible": false
                                    }
                                ];
                }
            } else {
                columnDefs = [     
                                    {
                                        "targets": [0],
                                        "visible": false,
                                        "searchable": false
                                        // "data": null,
                                        // "defaultContent": '<input type="hidden" id="input_check_0" name="check[]" value="false" />'
                                    },
                                    {
                                        "targets": [14],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [15],
                                        "visible": false,
                                        "searchable": false
                                    }
                                ];
            }

            $('#customers10').DataTable({
                // "pageLength" : 10,
                "columnDefs": columnDefs,
                "iDisplayLength": len,
                aLengthMenu: [
                                [10,25, 50, 100, 200, -1],
                                [10,25, 50, 100, 200, "All"]
                            ],
                "ajax": {
                    url : BASE_URL+'index.php/Distributor_out/get_data/'+status,
                    // data: {status: status},
                    type : 'GET'
                },
            });
            
            // $('input[name="check_val[]"]').on('ifChanged', function(event){
            //     var v = $(this).is(':checked')?$(this).val():'false';
            //     var id = $(this).attr('id');

            //     // console.log(v);
            //     console.log(id);

            //     $('#input_'+id).val(v);
            // });

            // table =  $('#customers10');
            // var tableOptions = {
            //     'bPaginate': true,
            //     'iDisplayLength': len,
            //     aLengthMenu: [
            //         [10,25, 50, 100, 200, -1],
            //         [10,25, 50, 100, 200, "All"]
            //     ],
            //     'bDeferRender': true,
            //     'bProcessing': true
            // };
            // table.DataTable(tableOptions);

            // if($(".icheckbox").length > 0){
            //     $(".icheckbox,.iradio").iCheck({checkboxClass: 'icheckbox_minimal-grey',radioClass: 'iradio_minimal-grey'});
            // }

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