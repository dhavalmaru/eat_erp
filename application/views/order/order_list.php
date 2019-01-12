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
    	<div  class="page-container page-navigation-top">            
    		<!-- PAGE CONTENT -->
    		<?php $this->load->view('templates/menus');?>
			<div id="mySidenav" class="sidenav1">
				<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
				<a  href="<?php echo base_url(); ?>index.php/order/checkstatus/pending">
    				<span class="ng-binding">Pending</span>
    				<span id="pending"> (<?php echo $pending; ?>) </span>
    			</a>
				<a  href="<?php echo base_url(); ?>index.php/order/checkstatus/delivered">
                    <span class="ng-binding">Delivered</span>
                    <span id="delivered"> (<?php echo $delivered; ?>) </span>
                </a>
				<a  href="<?php echo base_url(); ?>index.php/order/checkstatus/cancelled">
                    <span class="ng-binding">Cancelled</span>
                    <span id="cancelled"> (<?php echo $cancelled; ?>) </span>
                </a>					
			</div>
            <?php if($status=='pending') { ?>
                <form id="form_order_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/order/set_delivery_status'; ?>">
            <?php } else { ?>
                <form id="form_order_list" role="form" class="form-horizontal" method="post" action="">
            <?php } ?>
			
    		<div id="main" class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">

    			<div class="heading-h3"> 
    				<div class="heading-h3-heading mobile-head">
                        <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Order List  
                        <input type="hidden" id="form_status" name="form_status" value="<?php if(isset($status)) echo $status; ?>">
                    </div>						 
    				<div class="heading-h3-heading mobile-head">
                        <div class="pull-right btn-margin"> 
                            <?php $this->load->view('templates/download');?>
                            <!-- <a class="btn btn-danger btn-padding dropdown-toggle" href="<?php //echo base_url().'index.php/export/generate_order_sku_details/'.$status; ?>"><i class="fa fa-download"></i> &nbsp;Download</a> -->
                        </div>
                        <div class="pull-right btn-margin" style="margin-left: 5px; <?php if(($access[0]->r_edit=='1' && ($status=='pending'))) echo ''; else echo 'display: none;';?>">
                            <!-- <a class="btn btn-success btn-block btn-padding" data-toggle="modal" href="#myModal">
                                <span class="fa fa-shopping-cart"></span> <?php //if($status=='pending_for_delivery') echo 'Select Delivery Person'; else if($status=='gp_issued') echo 'Select Delivery Status'; else if($status=='pending_for_approval') echo 'Authorise Records'; ?>
                            </a> -->
                            <!-- <button class="btn btn-success btn-block btn-padding" type="button" onClick="get_batch_details();">
                                <span class="fa fa-shopping-cart"></span> <?php //if($status=='pending_for_delivery') echo 'Select Delivery Person'; else if($status=='gp_issued') echo 'Select Delivery Status'; else if($status=='pending_for_approval') echo 'Authorise Records'; ?>
                            </button> -->

                            <?php if($status=='pending') { ?>
                                <a class="btn btn-success btn-block btn-padding" data-toggle="modal" href="#myModal">
                                    <span class="fa fa-shopping-cart"></span> Select Delivery Status
                                </a>
                                <!-- <button class="btn btn-success btn-block btn-padding" type="button" onClick="get_batch_details();">
                                    <span class="fa fa-shopping-cart"></span> Select Delivery Status
                                </button> -->
                            <?php } ?>
                        </div>
                        <!-- <div class="pull-right btn-margin" style="<?php //if($access[0]->r_insert=='0' || $status=='pending_for_delivery' || $status=='gp_issued' || $status=='delivered_not_complete' || $status=='pending_for_approval') echo 'display: none;';?>">
                            <a class="btn btn-success btn-block btn-padding" href="<?php //echo base_url(); ?>index.php/order/add">
                                <span class="fa fa-plus"></span> Add Order Entry
                            </a>
                        </div> -->
    					<!-- <div class="pull-right btn-margin" style="<?php //if($access[0]->r_insert=='0') echo 'display: none;';?>">
    						<a class="btn btn-success " href="<?php //echo base_url() . 'index.php/order/add'; ?>">
    							<span class="fa fa-plus"></span> Add Distributor Out Entry
    						</a>
    					</div> -->
    				</div>	
<!-- <span class="mysidenav" onclick="openNav()" style="text-align:center;">Live Status of Sale</span>	  #2c2c2c-->
					<select onchange="dp_status(this.value);" class="mysidenav">
						<option value="0"><?php if($selectedstatus!=""){echo $selectedstatus;}else{echo 'Select Status';} ?></option>
						<option value="1">Pending (<?php echo $pending; ?>)</option>
						<option value="2">Delivered (<?php echo $delivered; ?>)</option>
						<option value="3">Cancelled (<?php echo $cancelled; ?>)</option>
					</select>			
    			</div>
				
<!-- Use any element to open the sidenav -->


    			<div class="nav-contacts ng-scope" ui-view="@nav">
				


    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						

    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<!--<li class="all">
    								<a  href="<?php //echo base_url(); ?>index.php/order/checkstatus/All">
    									<span class="ng-binding">All</span>
    									<span id="delivered">  (<?php //echo $all; ?>)  </span>
    								</a>
    							</li>-->

    							<li class="pending">
    								<a  href="<?php echo base_url(); ?>index.php/order/checkstatus/pending">
    									<span class="ng-binding">Pending</span>
    									<span id="pending"> (<?php echo $pending; ?>) </span>
    								</a>
    							</li>

                                <li class="delivered">
                                    <a  href="<?php echo base_url(); ?>index.php/order/checkstatus/delivered">
                                        <span class="ng-binding">Delivered</span>
                                        <span id="delivered"> (<?php echo $delivered; ?>) </span>
                                    </a>
                                </li>

                                <li class="cancelled">
                                    <a  href="<?php echo base_url(); ?>index.php/order/checkstatus/cancelled">
                                        <span class="ng-binding">Cancelled</span>
                                        <span id="cancelled"> (<?php echo $cancelled; ?>) </span>
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
                                                        <th width="65" align="center" style="<?php if($status!='pending') echo 'display: none;'; ?>">Select</th>
                                                        <th width="65" align="center">Sr. No.</th>
                                                        <th width="65">Edit</th>
                                                        <th width="156">Date Of processing</th>
    													<th width="130">Order Number</th>
    													<th width="140">Retailer Name</th>
                                                        <th width="140">Location</th>
    													<th width="220" >Sales Representative Name</th>
    													<th width="120" >Amount (In Rs)</th>
    													<th width="110" >Creation Date</th>
                                                        <th width="110" style="<?php if($status=='pending') echo 'display: none;'; ?>">Delivery Status</th>
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
            <div class="modal fade" id="myModal" role="dialog" style="<?php //if($status=='pending_for_delivery') {echo 'padding-top:0px;';} ?>">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="<?php //if($access[0]->r_edit=='1' && $status=='pending_for_delivery') { echo 'width: 500px;'; } ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Select Delivery Status</h4>
                        </div>
                        <div class="modal-body">
                            <label class="control-label">Delivery Status <span class="asterisk_sign">*</span></label>
                            <br/>
                            <div class="">
                                <select name="delivery_status" id="delivery_status" class="form-control">
                                    <!-- <option value="Pending">Active</option> -->
                                    <option value="Delivered">Delivered</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
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
            else  if(url.includes('cancelled')){
                $('.cancelled').attr('class','active');
            }
            else  if(url.includes('pending')){
                // console.log('pending');
                $('.pending').attr('class','active');
            }
            else  if(url.includes('delivered')){
                $('.delivered').attr('class','active');
            }
            else {
                $('.pending').attr('class','active');
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

        // $('#btn_save').click(function(){
        //     $('#myModal').modal('toggle');
        //     blFlag = true;
        // });
        
        $('#btn_save').click(function(){
            // console.log($("#form_order_list").valid());

            if (!$("#form_order_list").valid()) {
                return false;
            } else {
                $('#myModal').modal('toggle');
                blFlag = true;
            }
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

        var get_batch_details = function() {
            $('#myModal').modal('show');

            // console.log('true');

            // $.ajax({
            //     url:BASE_URL+'index.php/order/get_batch_details',
            //     method:"post",
            //     data:$('#form_order_list').serialize(),
            //     dataType:"html",
            //     async:false,
            //     success: function(data){
            //         $('#batch_details').html(data);

            //         addMultiInputNamingRules('#form_order_list', 'input[name="batch_no[]"]', { required: true }, "");
            //     },
            //     error: function (response) {
            //         var r = jQuery.parseJSON(response.responseText);
            //         alert("Message: " + r.Message);
            //         alert("StackTrace: " + r.StackTrace);
            //         alert("ExceptionType: " + r.ExceptionType);
            //     }
            // });
        }

	</script>
    <script>
        var table;
        $(document).ready(function() {
            // var len=<?php //if($status=='pending_for_delivery' || $status=='gp_issued') echo '-1';else echo '10';?>;

            var status = '<?php echo $status; ?>';
            var len = 10;
            var columnDefs = [];

            if(status == 'pending') {
                len = -1;

                columnDefs = [
                                {
                                    "targets": [10],
                                    "visible": false,
                                    "searchable": false
                                }
                            ];
            } else {
                columnDefs = [     
                                {
                                    "targets": [0],
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
                    url : BASE_URL+'index.php/order/get_data/'+status,
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
		function dp_status(str) {
			if(str=='1')
			{
				window.location.href="<?php echo base_url(); ?>index.php/order/checkstatus/pending";
			}
			else if(str=='2')
			{
				window.location.href="<?php echo base_url(); ?>index.php/order/checkstatus/delivered";
			}
			else if(str=='3')
			{
				window.location.href="<?php echo base_url(); ?>index.php/order/checkstatus/cancelled";
			}
			else
			{
				alert("Please select a status.");
			}
		}
		function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
	<!-- END SCRIPTS -->      
    </body>
</html>