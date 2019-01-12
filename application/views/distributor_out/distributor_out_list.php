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
			.dt-body-center
			{
				text-align:center;
			}
		</style>	
    </head>
    <body>
        
    	<!-- START PAGE CONTAINER -->
    	<div  class="page-container page-navigation-top">            
    		<!-- PAGE CONTENT -->
    		<?php $this->load->view('templates/menus');?>
			<div id="mySidenav" class="sidenav1">
				<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
				<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/Approved">
    				<span class="ng-binding">Approved</span>
    				<span id="approved"> (<?php echo $active; ?>)</span>
    			</a>
				<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending">
    				<span class="ng-binding">Pending</span>
    				<span id="approved"> (<?php echo $pending; ?>) </span>
    			</a>
				<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending_for_approval">
                    <span class="ng-binding">Approval Pending</span>
                    <span id="approved"> (<?php echo $pending_for_approval; ?>) </span>
                </a>
				<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending_for_delivery">
                    <span class="ng-binding">Delivery Pending</span>
                    <span id="approved"> (<?php echo $pending_for_delivery; ?>) </span>
                </a>
				<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/gp_issued">
                    <span class="ng-binding">GP Issued</span>
                    <span id="approved"> (<?php echo $gp_issued; ?>) </span>
                </a>
				<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/delivered_not_complete">
                    <span class="ng-binding">InComplete</span>
                    <span id="approved"> (<?php echo $delivered_not_complete; ?>) </span>
                </a>
				<a  href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/InActive">
                    <span class="ng-binding">Cancelled</span>
                    <span id="approved"> (<?php echo $inactive; ?>) </span>
                </a>					
			</div>
            <?php if($status=='pending_for_approval') { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_out/authorise'; ?>">
            <?php } else if($status=='pending_for_delivery') { ?>
                <!-- <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php //echo base_url().'index.php/distributor_out/set_delivery_status'; ?>" target="_blank"> -->
                    <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_out/get_batch_details'; ?>" target="_blank">
            <?php } else if($status=='gp_issued') { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_out/set_delivery_status2'; ?>">
            <?php } else { ?>
                <form id="form_distributor_out_list" role="form" class="form-horizontal" method="post" action="">
            <?php } ?>
			
    		<div id="main" class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">

    			<div class="heading-h3"> 
    				<div class="heading-h3-heading mobile-head">
                        <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Sales List  
                        <input type="hidden" id="form_status" name="form_status" value="<?php if(isset($status)) echo $status; ?>">
                    </div>						 
    				<div class="heading-h3-heading mobile-head">
                        <div class="pull-right btn-margin"> 
                            <?php //$this->load->view('templates/download');?>
                            <a class="btn btn-danger btn-padding dropdown-toggle" href="<?php echo base_url().'index.php/export/generate_distributor_out_sku_details/'.$status; ?>"><i class="fa fa-download"></i> &nbsp;Download</a>
                        </div>
                        <div class="pull-right btn-margin" style="margin-left: 5px; <?php if(($access[0]->r_edit=='1' && ($status=='pending_for_delivery' || $status=='gp_issued'))) echo ''; else echo 'display: none;';?>">
                            <!-- <a class="btn btn-success btn-block btn-padding" data-toggle="modal" href="#myModal">
                                <span class="fa fa-shopping-cart"></span> <?php //if($status=='pending_for_delivery') echo 'Select Delivery Person'; else if($status=='gp_issued') echo 'Select Delivery Status'; else if($status=='pending_for_approval') echo 'Authorise Records'; ?>
                            </a> -->
                            <!-- <button class="btn btn-success btn-block btn-padding" type="button" onClick="get_batch_details();">
                                <span class="fa fa-shopping-cart"></span> <?php //if($status=='pending_for_delivery') echo 'Select Delivery Person'; else if($status=='gp_issued') echo 'Select Delivery Status'; else if($status=='pending_for_approval') echo 'Authorise Records'; ?>
                            </button> -->

                            <?php if($status=='pending_for_delivery') { ?>
                                <!-- <button class="btn btn-success" type="submit">
                                    <span class="fa fa-shopping-cart"></span> Select Delivery Person
                                </button> -->
                            <?php } else if($status=='gp_issued') { ?>
                                <!-- <button class="btn btn-success btn-block btn-padding" type="button" onClick="get_batch_details();">
                                    <span class="fa fa-shopping-cart"></span> Select Delivery Status
                                </button> -->
                            <?php } else if($status=='pending_for_approval') { ?>
                                <button class="btn btn-success btn-block btn-padding" type="button" onClick="get_batch_details();">
                                    <span class="fa fa-shopping-cart"></span> Authorise Records
                                </button>
                            <?php } ?>
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
<!-- <span class="mysidenav" onclick="openNav()" style="text-align:center;">Live Status of Sale</span>	  #2c2c2c-->
					<select onchange="dp_status(this.value);" class="mysidenav">
						<option value="0"><?php if($selectedstatus!=""){echo $selectedstatus;}else{echo 'Select Status';} ?></option>
						<option value="1">Approved (<?php echo $active; ?>)</option>
						<option value="2">Pending (<?php echo $pending; ?>)</option>
						<option value="3">Approval Pending (<?php echo $pending_for_approval; ?>) </option>
						<option value="4">Delivery Pending (<?php echo $pending_for_delivery; ?>)</option>
						<option value="5">GP Issued (<?php echo $gp_issued; ?>)</option>
						<option value="6">InComplete (<?php echo $delivered_not_complete; ?>)</option>
						<option value="7">Cancelled (<?php echo $inactive; ?>)</option>
					</select>			
    			</div>
				
<!-- Use any element to open the sidenav -->


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
                                                        <th width="50" align="center" style="<?php //if($status!='pending_for_delivery' && $status!='gp_issued' && $status!='pending_for_approval') echo 'display: none;'; ?>">Select</th>
                                                        <th width="50" style="text-align:center;">Sr. No.</th>
                                                        <th width="80">Date Of processing</th>
    													<th style="text-align:center" width="50">Edit </th>
														<th width="50" style="text-align:center;">Proof of Delivery</th>
    													<th width="135">Invoice No</th>
                                                        <th width="80">Invoice Date</th>

    													<th width="150">Distributor Name</th>
                                                        <th width="140">PO No</th>
                                                        <th width="140">Location</th>
    											
    													<th width="70" >Amount (In Rs)</th>
                                                        <th width="110" >Delivery Status</th>
                                                     
                                                      
    													
                                                        <th width="50" style="text-align:center; <?php //if($status!='gp_issued') echo 'display: none;'; ?>">View GP</th>
    													<th width="50" style="display:none;">Resend Invoice</th>
    													<th width="50" style=" <?php //if($status!='gp_issued') echo 'display: none;'; ?>">Tracking Id</th>
														
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
            </form>
            <div class="modal fade" id="myModal" role="dialog" style="<?php if($status=='pending_for_delivery') {echo 'padding-top:0px;';} ?>">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="<?php if($access[0]->r_edit=='1' && $status=='pending_for_delivery') { echo 'width: 500px;'; } ?>">
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
                        <form id="form_distributor_out_model" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_out/set_delivery_status2'; ?>" enctype="multipart/form-data" >
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
                                        <?php if(isset($sales_rep1)) { for ($k=0; $k < count($sales_rep1) ; $k++) { ?>
                                                <option value="<?php echo $sales_rep1[$k]->id; ?>"><?php echo $sales_rep1[$k]->sales_rep_name;?></option>
                                        <?php }} ?>
                                    </select>
                                    <input type="hidden" name="delivery_status" id="delivery_status" value="GP Issued" />
                                </div>

                                <label class="control-label" style="display: none;">Status <span class="asterisk_sign">*</span></label>
                                <div class="">
                                    <select name="status" id="status" class="form-control" style="display: none;">
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
                                <label class="control-label">Person Receiving </label>
                                <div class="">
                                   <input type="text" class="form-control" name="person_receving" id="person_receving" value="" />
                                </div>
                                <br/>
                                <label class="control-label">Proof of Delivery</label>
                                <div class="">
                                  <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="upload" id="image" placeholder="image" value="" />
                                </div>
                                <input type="hidden" name="check" id="check">
                                <label class="control-label" style="display: none;">Status <span class="asterisk_sign">*</span></label>
                                <div class="">
                                    <select name="status" id="status" class="form-control" style="display: none;">
                                        <!-- <option value="Pending">Active</option> -->
                                        <option value="Approved">Active</option>
                                        <option value="InActive">InActive</option>
                                    </select>
                                </div>
                            <?php } ?>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                            <input type="submit" class="btn btn-success pull-right"  style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>" value="Save">
                            <!-- <button id="btn_save" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    	</div>
    	<!-- END PAGE CONTAINER -->

        <div class="modal fade" id="delivery_comments" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="form_distributor_po_comments" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_out/add_comments'; ?>">
                         <div class="modal-content" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h4 class="modal-title">Delivery Comments</h4>
                            </div>
                            <div class="modal-body">
                                <br/>
                                <div class="">
                                    <label class="control-label">Comments </label>
                                    <textarea name="delivery_comments" id="delivery_comments" class="form-control"></textarea>
                                    <input type="hidden" id="delivery_comments_id" name="delivery_comments_id" >
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button id="btn_comment_save" class="btn btn-success pull-right"  >Save</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>

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
                $('.approved').attr('class','active');
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


        var get_delivery_comments = function(elem) {
            /*alert("hii");*/
            var id = elem.id;
            /*$('#delivery_comments').modal('show');*/
            $.ajax({
                        url:BASE_URL+'index.php/distributor_out/get_comments',
                        method:"post",
                        data:{id:id},
                        dataType:"json",
                        async:false,
                        success: function(data){
                            $('#delivery_comments_id').val(id);
                            $('textarea#delivery_comments').val(data.comments);
                            $('#delivery_comments').modal('show');

                        },
                        error: function (response) {
                            var r = jQuery.parseJSON(response.responseText);
                            alert("Message: " + r.Message);
                            alert("StackTrace: " + r.StackTrace);
                            alert("ExceptionType: " + r.ExceptionType);
                        }
                    });
        }


        // $('#btn_save').click(function(){
        //     $('#myModal').modal('toggle');
        //     blFlag = true;
        // });
        
        $('#btn_save').click(function(){
            // console.log($("#form_distributor_out_list").valid());

            if (!$("#form_distributor_out_list").valid()) {
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

        var get_batch_details = function(elem) {
            var id = elem.id;
            var distributor_id = elem.getAttribute('data-distributor');
            $('#check').val(distributor_id)
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
                                        "targets": [13],
                                        "visible": false,
                                        "searchable": false
                                    },
									 {
                                        "targets": [14],
                                        "visible": true,
                                        "searchable": true
                                    },
									{ "width": "10%", "targets": 8 },
									{ className: "dt-body-center", targets: [ 3, 4,12,13 ] }
                                ];
                } else if(status == 'pending_for_approval') {
                    columnDefs = [    
                                    {
                                        "targets": [0],
                                        "visible": false,
                                        "searchable": false
                                    },       
                                    {
                                        "targets": [12],
                                        "visible": false,
                                        "searchable": false
                                    }, 
                                    {
                                        "targets": [13],
                                        "visible": false,
                                        "searchable": false
                                    },
									{
                                        "targets": [14],
                                        "visible": false,
                                        "searchable": false
                                    },
									  { "width": "10%", "targets": 8 },
									{ className: "dt-body-center", targets: [ 3,4,12,13 ] }
                                ];
                } else {
                    columnDefs = [      
                                    {
                                        "targets": [12],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [13],
                                        "visible": false,
                                        "searchable": false
                                    },
										{
                                        "targets": [14],
                                        "visible": false,
                                        "searchable": false
                                    },
									  { "width": "10%", "targets": 8 },
									{ className: "dt-body-center", targets: [ 3, 4 ,12,13] }
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
                                        "targets": [12],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [13],
                                        "visible": false,
                                        "searchable": false
                                    },
									{
                                        "targets": [14],
                                        "visible": false,
                                        "searchable": false
                                    },
									  { "width": "10%", "targets": 8 },
									   { className: "dt-body-center", targets: [ 3, 4,12,13 ] }
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
		function dp_status(str)
		{
			if(str=='1')
			{
				window.location.href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/Approved";
			}	
			else if(str=='2')
			{
				window.location.href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending";
			}
			else if(str=='3')
			{
				window.location.href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending_for_approval";
			}
			else if(str=='4')
			{
				window.location.href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/pending_for_delivery";
			}
			else if(str=='5')
			{
				window.location.href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/gp_issued";
			}
			else if(str=='6')
			{
				window.location.href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/delivered_not_complete";
			}
			else if(str=='7')
			{
				window.location.href="<?php echo base_url(); ?>index.php/distributor_out/checkstatus/InActive";
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

        $('#image').change(function () {

            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['pdf','png','jpg','jpeg']) == -1) {
                alert('This is not an allowed file type.');
                    this.value = '';
            }
            else
            {
                /*alert($(this).val().replace(/C:\\fakepath\\/i, ''));*/
                var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                var check = $('#check').val();
                $.ajax({
                            url:BASE_URL+'index.php/Distributor_out/check_file_name',
                            type : 'POST',
                            data:{check:check,filename:filename},
                            dataType:"json",
                            success:function(data){
                                if(data==1)
                                {
                                   $('#image').val(''); 
                                   $('.file-input-name').text('');
                                    alert('Image Already Exsist');
                                }
                               
                            }

                        })
            }
            /*var ext = this.value.match(/\.(.+)$/)[1];
            switch (ext) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'pdf':
                default:
                    alert('This is not an allowed file type.');
                    this.value = '';
            }*/
        });
    </script>
	<!-- END SCRIPTS -->      
    </body>
</html>