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
				<a href="<?php echo base_url(); ?>index.php/production/checkstatus/requested">
    				<span class="ng-binding">Requested</span>
    				<span id="requested"> (<?php echo $requested; ?>)</span>
    			</a>
				<a href="<?php echo base_url(); ?>index.php/production/checkstatus/confirmed">
    				<span class="ng-binding">Confirmed</span>
    				<span id="confirmed"> (<?php echo $confirmed; ?>) </span>
    			</a>
				<a href="<?php echo base_url(); ?>index.php/production/checkstatus/batch_confirmed">
                    <span class="ng-binding">Batch Confirmed</span>
                    <span id="batch_confirmed"> (<?php echo $batch_confirmed; ?>) </span>
                </a>
				<a href="<?php echo base_url(); ?>index.php/production/checkstatus/raw_material_confirmed">
                    <span class="ng-binding">Completed</span>
                    <span id="raw_material_confirmed"> (<?php echo $raw_material_confirmed; ?>) </span>
                </a>
                <a href="<?php echo base_url(); ?>index.php/production/checkstatus/inactive">
                    <span class="ng-binding">Inactive</span>
                    <span id="inactive"> (<?php echo $inactive; ?>) </span>
                </a>
			</div>
            
    		<div id="main" class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
    			<div class="heading-h3"> 
    				<div class="heading-h3-heading mobile-head">
                        <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Production List  
                        <input type="hidden" id="form_status" name="form_status" value="<?php if(isset($status)) echo $status; ?>">
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
                        <div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0' || $status=='pending_for_delivery' || $status=='gp_issued' || $status=='delivered_not_complete' || $status=='pending_for_approval') echo 'display: none;';?>">
                            <a class="btn btn-success btn-block btn-padding" href="<?php echo base_url(); ?>index.php/production/add">
                                <span class="fa fa-plus"></span> Add Production Entry
                            </a>
                        </div>
    				</div>
					<select onchange="dp_status(this.value);" class="mysidenav">
						<option value="0"><?php if($selectedstatus!=""){echo $selectedstatus;}else{echo 'Select Status';} ?></option>
						<option value="1">Requested (<?php echo $requested; ?>)</option>
						<option value="2">Confirmed (<?php echo $confirmed; ?>)</option>
						<option value="3">Batch Confirmed (<?php echo $batch_confirmed; ?>) </option>
						<option value="4">Completed (<?php echo $raw_material_confirmed; ?>)</option>
                        <option value="5">Inactive (<?php echo $inactive; ?>)</option>
					</select>			
    			</div>
    			<div class="nav-contacts ng-scope" ui-view="@nav">
    				<div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
    					<div class="container u-posRelative u-textRight">
    						<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
    							<li class="requested" >
    								<a  href="<?php echo base_url(); ?>index.php/production/checkstatus/requested">
    									<span class="ng-binding">Requested</span>
    									<span id="requested"> (<?php echo $requested; ?>)</span>
    								</a>
    							</li>
    							<li class="confirmed">
    								<a  href="<?php echo base_url(); ?>index.php/production/checkstatus/confirmed">
    									<span class="ng-binding">Confirmed</span>
    									<span id="confirmed"> (<?php echo $confirmed; ?>) </span>
    								</a>
    							</li>
                                <li class="batch_confirmed">
                                    <a  href="<?php echo base_url(); ?>index.php/production/checkstatus/batch_confirmed">
                                        <span class="ng-binding">Batch Confirmed</span>
                                        <span id="batch_confirmed"> (<?php echo $batch_confirmed; ?>) </span>
                                    </a>
                                </li>
                                <li class="raw_material_confirmed">
                                    <a  href="<?php echo base_url(); ?>index.php/production/checkstatus/raw_material_confirmed">
                                        <span class="ng-binding">Completed</span>
                                        <span id="raw_material_confirmed"> (<?php echo $raw_material_confirmed; ?>) </span>
                                    </a>
                                </li>
                                <li class="inactive">
                                    <a  href="<?php echo base_url(); ?>index.php/production/checkstatus/inactive">
                                        <span class="ng-binding">Inactive</span>
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
                                                        <th>Sr. No.</th>
                                                        <th>Edit</th>
                                                        <th>
                                                        <?php 
                                                        if($status=='requested') echo 'Confirm';
                                                        else if($status=='confirmed') echo 'Confirm Batch';
                                                        else if($status=='batch_confirmed') echo 'Confirm Raw Material';
                                                        else echo 'Confirm';
                                                        ?>
                                                        </th>
                                                        <th>Production Id</th>
                                                        <th>From Date</th>
                                                        <th>To Date</th>
                                                        <th>Manufacturer Name</th>
                                                        <th>Confirm From Date</th>
                                                        <th>Confirm To Date</th>
                                                        <th>Production Status</th>
													</tr>
    											</thead>
    											<tbody>
    											</tbody>
    										</table>
    									</div>
    								</div>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
            </form>
    	</div>

	<?php $this->load->view('templates/footer');?>
    <script type="text/javascript">
        var BASE_URL="<?php echo base_url()?>";
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
	<script>
    	$(document).ready(function() {
    		var url = window.location.href;

    		if(url.includes('requested')){
                $('.requested').attr('class','active');
            } else if(url.includes('batch_confirmed')){
                $('.batch_confirmed').attr('class','active');
            } else if(url.includes('raw_material_confirmed')){
                $('.raw_material_confirmed').attr('class','active');
            } else if(url.includes('confirmed')){
                $('.confirmed').attr('class','active');
            } else if(url.includes('inactive')){
                $('.inactive').attr('class','active');
            } else{
                $('.requested').attr('class','active');
            }
    	});
	</script>
    <script>
        var table;
        $(document).ready(function() {
            var status = '<?php echo $status; ?>';
            var len = 10;
            var columnDefs = [];

            if(status == 'requested' || status == 'confirmed' || status == 'batch_confirmed' || status == 'inactive') {
                len = -1;

                if(status == 'requested') {
                    columnDefs = [        
                                    {
                                        "targets": [7],
                                        "visible": false,
                                        "searchable": false
                                    },
									{
                                        "targets": [8],
                                        "visible": false,
                                        "searchable": false
                                    },
                                    { "width": "10%", "targets": 1 },
                                    { className: "dt-body-center", targets: [ 1, 2 ] }
                                ];
                } else {
                    columnDefs = [        
                                    { "width": "10%", "targets": 1 },
                                    { className: "dt-body-center", targets: [ 1, 2 ] }
                                ];
                }
            } else {
                len = 10;

                columnDefs = [        
                                {
                                    "targets": [2],
                                    "visible": false,
                                    "searchable": false
                                },
                                { "width": "10%", "targets": 1 },
                                { className: "dt-body-center", targets: [ 1, 2 ] }
                            ];
            }

            $('#customers10').DataTable({
                // "pageLength" : 10,
                "columnDefs": columnDefs,
                "iDisplayLength": len,
                aLengthMenu: [
                                [10, 25, 50, 100, 200, -1],
                                [10, 25, 50, 100, 200, "All"]
                            ],
                "ajax": {
                    url : BASE_URL+'index.php/production/get_data/'+status,
                    // data: {status: status},
                    type : 'GET'
                },
            });
            
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
				window.location.href="<?php echo base_url(); ?>index.php/production/checkstatus/requested";
			} else if(str=='2') {
				window.location.href="<?php echo base_url(); ?>index.php/production/checkstatus/confirmed";
			} else if(str=='3') {
				window.location.href="<?php echo base_url(); ?>index.php/production/checkstatus/batch_confirmed";
			} else if(str=='4') {
				window.location.href="<?php echo base_url(); ?>index.php/production/checkstatus/raw_material_confirmed";
			} else if(str=='5') {
                window.location.href="<?php echo base_url(); ?>index.php/production/checkstatus/inactive";
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

        $('#image').change(function () {
            var ext = $(this).val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['pdf','png','jpg','jpeg']) == -1) {
                alert('This is not an allowed file type.');
                this.value = '';
            } else {
                /*alert($(this).val().replace(/C:\\fakepath\\/i, ''));*/
                var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
                var check = $('#check').val();
                $.ajax({
                    url:BASE_URL+'index.php/production/check_file_name',
                    type : 'POST',
                    data:{check:check,filename:filename},
                    dataType:"json",
                    success:function(data){
                        if(data==1){
                           $('#image').val(''); 
                           $('.file-input-name').text('');
                            alert('Image Already Exsist');
                        }
                    }
                });
            }
        });
    </script>
    </body>
</html>