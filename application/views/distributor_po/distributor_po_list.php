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
        <link href="<?php echo base_url(); ?>js/jquery-ui-1.11.2/jquery-ui.min.css" rel="stylesheet" type="text/css" />

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
             .m-nav--linetriangle>li a {
                font-size: 12.5px!important;
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
                <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/Approved">
                    <span class="ng-binding">Approved</span>
                    <span id="approved"> (<?php echo $active; ?>)</span>
                </a>
                <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/pending_for_approval">
                    <span class="ng-binding">Approval Pending</span>
                    <span id="approved"> (<?php echo $pending_for_approval; ?>) </span>
                </a>
                <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/pending_for_delivery">
                    <span class="ng-binding">Delivery Pending</span>
                    <span id="approved"> (<?php echo $pending_for_delivery; ?>) </span>
                </a>
                <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/InActive">
                    <span class="ng-binding">Cancelled</span>
                    <span id="approved"> (<?php echo $inactive; ?>) </span>
                </a>                    
            </div>
            <?php if($status=='pending_for_approval') { ?>
                <form id="form_distributor_po_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_po/authorise'; ?>">
            <?php } else if($status=='pending_for_delivery' || $status=='gt_dp') { ?>
                <form id="form_distributor_po_list" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_po/set_delivery_status'; ?>">
            <?php } else { ?>
                <form id="form_distributor_po_list" role="form" class="form-horizontal" method="post" action="">
            <?php } ?>
            
            <div id="main" class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">

                <div class="heading-h3"> 
                    <div class="heading-h3-heading mobile-head">
                        <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Distributor PO List  
                        <input type="hidden" id="form_status" name="form_status" value="<?php if(isset($status)) echo $status; ?>">
                    </div>                       
                    <div class="heading-h3-heading mobile-head">
                        <div class="pull-right btn-margin"> 
                            <?php //$this->load->view('templates/download');?>
                            <a class="btn btn-danger btn-padding dropdown-toggle" href="<?php echo base_url().'index.php/distributor_po/generate_po_delivery_report'; ?>"><i class="fa fa-download"></i> &nbsp;Download</a>
                        </div>
                        <div class="pull-right btn-margin" style="margin-left: 5px; display: none; <?php //if(($access[0]->r_edit=='1' && ($status=='pending_for_delivery' || $status=='gt_dp'))) echo ''; else echo 'display: none;';?>">
                            <button class="btn btn-success btn-block btn-padding" type="button" onClick="get_batch_details();">
                                <span class="fa fa-shopping-cart"></span> Select Delivery Status
                            </button>
                        </div>
                        <div class="pull-right btn-margin" style="<?php //if($access[0]->r_insert=='0' || $status=='pending_for_delivery' || $status=='gt_dp' || $status=='delivered_not_complete') echo 'display: none;';?>">
                            <a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/distributor_po/add">
                                <span class="fa fa-plus"></span> Add Distributor PO Entry
                            </a>
                        </div>
                    </div>
                    <select onchange="dp_status(this.value);" class="mysidenav">
                        <option value="0"><?php if($selectedstatus!=""){echo $selectedstatus;}else{echo 'Select Status';} ?></option>
                        <option value="1">Mismatch (<?php echo $mismatch; ?>)</option>
                        <option value="2">Pending (<?php echo $pending_for_approval; ?>) </option>
                        <option value="3">MT DP (<?php echo $pending_for_delivery; ?>)</option>
                        <option value="4">GT DP (<?php echo $gt_dp; ?>)</option>
                        <option value="5">Delivered Not Conf (<?php echo $pending_merchendiser_delivery; ?>)</option>
                        <option value="6">Completed (<?php echo $delivered; ?>) </option>
                        <option value="7">Approved (<?php echo $active; ?>)</option>
                        <option value="8">Cancelled (<?php echo $inactive; ?>)</option>
                    </select>           
                </div>
                
                <div class="nav-contacts ng-scope" ui-view="@nav">
                    <div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
                        <div class="container u-posRelative u-textRight">
                            <ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
                                <!--<li class="all">
                                    <a  href="<?php //echo base_url(); ?>index.php/distributor_po/checkstatus/All">
                                        <span class="ng-binding">All</span>
                                        <span id="approved">  (<?php //echo $all; ?>)  </span>
                                    </a>
                                </li>-->
                                
                                <li class="mismatch">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/mismatch">
                                        <span class="ng-binding">Mismatch</span>
                                        <span id="mismatch"> (<?php echo $mismatch; ?>) </span>
                                    </a>
                                </li>
                                <li class="pending_for_approval">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/pending_for_approval">
                                        <span class="ng-binding">Pending</span>
                                        <span id="pending_for_approval"> (<?php echo $pending_for_approval; ?>) </span>
                                    </a>
                                </li>
                                <li class="pending_for_delivery">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/pending_for_delivery">
                                        <span class="ng-binding">Delivery Pending</span>
                                        <span id="pending_for_delivery"> (<?php echo $pending_for_delivery; ?>) </span>
                                    </a>
                                </li>
                                <!-- <li class="gt_dp">
                                    <a  href="<?php //echo base_url(); ?>index.php/distributor_po/checkstatus/gt_dp">
                                        <span class="ng-binding">GT DP</span>
                                        <span id="gt_dp"> (<?php //echo $gt_dp; ?>) </span>
                                    </a>
                                </li> -->
                                <li class="pending_merchendiser_delivery">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/pending_merchendiser_delivery">
                                        <span class="ng-binding">Delivered Not Conf</span>
                                        <span id="pending_merchendiser_delivery"> (<?php echo $pending_merchendiser_delivery; ?>) </span>
                                    </a>
                                </li>
                                <li class="delivered">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/delivered">
                                        <span class="ng-binding">Completed</span>
                                        <span id="delivered"> (<?php echo $delivered; ?>) </span>
                                    </a>
                                </li>
                                <li class="approved" >
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/Approved">
                                        <span class="ng-binding">Approved</span>
                                        <span id="approved"> (<?php echo $active; ?>)</span>
                                    </a>
                                </li>
                                <li class="inactive">
                                    <a  href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/InActive">
                                        <span class="ng-binding">Cancelled</span>
                                        <span id="inactive"> (<?php echo $inactive; ?>) </span>
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
                                                        <th width="50" align="center" style="<?php //if($status!='pending_for_delivery' && $status!='gt_dp' && $status!='pending_for_approval') echo 'display: none;'; ?>">Select</th>
                                                        <th width="50" style="text-align:center;">Sr. No.</th>
                                                        <th width="80">Date Of processing</th>
                                                        <th style="text-align:center" width="50">Edit </th>
                                                        <th width="150">Distributor Name</th>
                                                        <th width="140">PO No</th>
                                                        <th width="100">Location</th>
                                                        <th width="50">Relation</th>
                                                        <th width="70">Days To Expiry</th>
                                                        <th width="70">Amount (In Rs)</th>
                                                        <th width="110">Delivery Status</th>
                                                        <th width="110">Mismatch Type</th>
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
            <div class="modal fade" id="myModal" role="dialog" style="<?php if($status=='pending_for_delivery' || $status=='gt_dp') {echo 'padding-top:0px;';} ?>">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="<?php if($access[0]->r_edit=='1' && ($status=='pending_for_delivery' || $status=='gt_dp')) { echo 'width: 500px;'; } ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Select Delivery Status</h4>
                        </div>
                        <div class="modal-body">
                            <label class="control-label">Delivery Status <span class="asterisk_sign">*</span></label>
                            <br/>
                            <div class="">
                                <select name="delivery_status" id="delivery_status" class="form-control" onchange="view_reason();">
                                    <!-- <option value="">Select</option> -->
                                    <!-- <option value="Pending">Delivered Pending Merchandiser Approval</option> -->
                                    <option value="Cancelled" selected>Cancelled</option>
                                </select>
                            </div>
                            <br/>
                            <div style="display: none;" id="Delivered">
                                <label class="control-label">Delivery Date</label>
                                <div class="">
                                    <input type="text" class="form-control datepicker" name="delivery_date" id="delivery_date" placeholder="Delivery Date" value="" />
                                </div>
                                <br/>
                                 <label class="control-label">Dispatch Date</label>
                                <div class="">
                                    <input type="text" class="form-control datepicker" name="dispatch_date" id="dispatch_date" placeholder="Dispatch Date" value="" />
                                </div>
                                <br/>
                                <label class="control-label">Person Name </label>
                                <div class="">
                                   <input type="text" class="form-control" name="person_name" id="person_name" value="" />
                                </div>
                                <label class="control-label">Invoice Number</label>
                                <div class="">
                                    <input type="text" class="form-control" name="invoice_no" id="invoice_no" value="" />
                                </div>
                            </div>
                            <div id="cancellation_div">
                            <label class="control-label">Cancellation Reason <span class="asterisk_sign">*</span></label>
                            <br/>
                            <div class="">
                                <select name="delivery_remarks" id="delivery_remarks" class="form-control">
                                    <option value="">Select</option>
                                    <option>Out of Route</option>
                                    <option>Out of stock</option>
                                    <option>Distributor Missed</option>
                                    <option>Short TAT / Validity </option>
                                    <option>order for online product Bumbaiya chaat</option>
                                    <option>Missed by WHPL</option>
                                    <option>Short quantity</option>
                                    <option>Cancelled by WHPL</option>
                                    <option>Minimum Quantity</option>
                                    <option>We don’t deliver Bambaiy chaat in MT</option>
                                    <option>Variety Pack stock not available with Deepa</option>
                                    <option>whpl plan to deliver but stock not accepted due to Bharat Bundh</option>
                                    <option>Already deliver the stock before, As discussed with swapnil Cancelled</option>
                                    <option>Stock dispacthed but not received by store (Cancelled by store)</option>
                                    <option>Not delivered by Central</option>
                                    <option>Delayed stock delivered by FEDEX.</option>
                                    <option>Stock take at store</option>
                                    <option>No update from distributor</option>
                                </select>
                            </div>
                            <br/>
							<a id="other_reason"> Add Other Reson</a>
							<div id="other_reason_div" style="display">
                                 <label class="control-label">Cancellation Reason</label>
                                <div class="">
                                    <input type="text" class="form-control " name="cancellation_reason" id="cancellation_reason" placeholder="Cancellation Reason" value="" />
                                </div>
                            </div>
							<br/>
                            <div>
                                 <label class="control-label">Cancellation Date</label>
                                <div class="">
                                    <input type="text" class="form-control datepicker" name="cancellation_date" id="cancellation_date" placeholder="Delivery Date" value="" />
                                </div>
                            </div>
                            </div>

                            <label class="control-label">Remarks</label>
                            <br/>
                            <div class="">
                                <textarea name="remarks" id="remarks" class="form-control"></textarea>
                            </div>

                            <label class="control-label" style="display: none;">Status <span class="asterisk_sign">*</span></label>
                            <div class="">
                                <select name="status" id="status" class="form-control" style="display: none;">
                                    <!-- <option value="Pending">Active</option> -->
                                    <option value="Approved">Active</option>
                                    <option value="InActive">InActive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button id="btn_save" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>" >Save</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="modal fade" id="delivery_comments" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="form_distributor_po_comments" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/distributor_po/add_comments'; ?>">
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

            if(url.includes('mismatch')){
                $('.mismatch').attr('class','active');
            } else if(url.includes('pending_for_approval')){
                $('.pending_for_approval').attr('class','active');
            } else if(url.includes('pending_for_delivery')){
                $('.pending_for_delivery').attr('class','active');
            } else if(url.includes('gt_dp')){
                $('.gt_dp').attr('class','active');
            } else if(url.includes('pending_merchendiser_delivery')){
                $('.pending_merchendiser_delivery').attr('class','active');
            } else if(url.includes('delivered')){
                $('.delivered').attr('class','active');
            } else  if(url.includes('Approved')){
                $('.approved').attr('class','active');
            } else  if(url.includes('InActive')){
                $('.inactive').attr('class','active');
            } else {
                $('.pending_for_delivery').attr('class','active');
            }

            $('.ahrefall').click(function(){
                alert(window.location.href );
            });
			
            $('#other_reason_div').hide();

            $("#other_reason").click(function() {
                $('#other_reason_div').show();
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
            // console.log($("#form_distributor_po_list").valid());

            if (!$("#form_distributor_po_list").valid()) {
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

        var get_delivery_comments = function(elem) {
            /*alert("hii");*/
            var id = elem.id;
            /*$('#delivery_comments').modal('show');*/
            $.ajax({
                        url:BASE_URL+'index.php/distributor_po/get_comments',
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

        var get_batch_details = function() {
            $('#myModal').modal('show');

            // console.log('true');

            // $.ajax({
            //     url:BASE_URL+'index.php/distributor_po/get_batch_details',
            //     method:"post",
            //     data:$('#form_distributor_po_list').serialize(),
            //     dataType:"html",
            //     async:false,
            //     success: function(data){
            //         $('#batch_details').html(data);

            //         addMultiInputNamingRules('#form_distributor_po_list', 'input[name="batch_no[]"]', { required: true }, "");
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

        // $('#form_distributor_po_list').on('submit', function(e) {
        //     e.preventDefault();
        //     var formAction = $('#form_distributor_po_list').attr("action");
        //     $.post(formAction, $(this).serialize());
        //     window.open($('#form_distributor_po_list').prop('action'));
        //     return false;
        // });
    </script>
    <script>
        var table;
        $(document).ready(function() {
            // var len=<?php //if($status=='pending_for_delivery' || $status=='gt_dp') echo '-1';else echo '10';?>;
           $(".datepicker").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });     
            var status = '<?php echo $status; ?>';
            var len = 10;
            var columnDefs = [];

            if(status == 'mismatch' || status == 'pending_for_delivery' || status == 'gt_dp' || status == 'pending_for_approval' || status=='pending_merchendiser_delivery') {
                len = -1;

                if(status == 'mismatch') {
                    columnDefs = [
                                    {
                                        "targets": [0],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    { "width": "10%", "targets": 8 },
                                    { className: "dt-body-center", targets: [ 3 ] }
                                ];
                } else if(status == 'pending_for_approval') {
                    columnDefs = [    
                                    {
                                        "targets": [0],
                                        "visible": false,
                                        "searchable": false
                                    },    
                                    {
                                        "targets": [11],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    { "width": "10%", "targets": 8 },
                                    { className: "dt-body-center", targets: [ 3 ] }
                                ];
                } else if(status == 'pending_for_delivery' || status == 'gt_dp') {
                    columnDefs = [
                                    {
                                        "targets": [3],
                                        "visible": true,
                                        "searchable": false
                                    },    
                                    {
                                        "targets": [11],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    { "width": "10%", "targets": 8 },
                                    { className: "dt-body-center", targets: [ 3 ] }
                                ];
                } else if(status == 'pending_merchendiser_delivery') {
                    columnDefs = [
                                    // {
                                        // "targets": [3],
                                        // "visible": false,
                                        // "searchable": false
                                    // },
                                    {
                                        "targets": [0],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [11],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    { "width": "10%", "targets": 9 },
                                    { className: "dt-body-center", targets: [ 3 ] }
                                ];
                } else {
                    columnDefs = [
                                    {
                                        "targets": [11],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    { "width": "10%", "targets": 9 },
                                    { className: "dt-body-center", targets: [ 3 ] }
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
                                    "targets": [8],
                                    "visible": false,
                                    "searchable": false
                                },    
                                {
                                    "targets": [11],
                                    "visible": false,
                                    "searchable": false
                                },
                                { "width": "10%", "targets": 8 },
                                { className: "dt-body-center", targets: [ 3 ] }
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
                    url : BASE_URL+'index.php/distributor_po/get_data/'+status,
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
            if(str=='1') {
                window.location.href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/mismatch";
            } else if(str=='2') {
                window.location.href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/pending_for_approval";
            } else if(str=='3') {
                window.location.href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/pending_for_delivery";
            } else if(str=='4') {
                window.location.href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/gt_dp";
            } else if(str=='5') {
                window.location.href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/pending_merchendiser_delivery";
            } else if(str=='6') {
                window.location.href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/delivered";
            } else if(str=='7') {
                window.location.href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/approved";
            } else if(str=='8') {
                window.location.href="<?php echo base_url(); ?>index.php/distributor_po/checkstatus/InActive";
            } else {
                alert("Please select a status.");
            }
        }

        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function view_reason() {
            if($('#delivery_status').val()=='Cancelled'){
                $('#Delivered').hide();
                $('#cancellation_div').show();
            } else {
                $('#cancellation_div').hide();
                $('#Delivered').show();
            }
        }
    </script>
    <!-- END SCRIPTS -->      
    </body>
</html>