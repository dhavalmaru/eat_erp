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
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/logout/popModal.css">
        <!-- EOF CSS INCLUDE -->     
		
		<style>			 
			th{text-align:center;}
			.center{text-align:center;}
            input[readonly] {background-color: white !important; 
                            color: #0b385f !important; 
                            cursor: not-allowed !important;}
							
			 @media screen and (max-width:806px) {   
			   .h-scroll { overflow-x:scroll;} .h-scroll .table-stripped{ width:805px!important;}
			  }
		</style>
		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
        <!-- PAGE CONTENT -->
        <?php $this->load->view('templates/menus');?>
        <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
            <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a>&nbsp; &#10095; &nbsp; End of Month Sales Details</div>
            
            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">
            
            <div class="panel-body" style="background-color: #fff;">
             <form id="form_freez" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url(). 'index.php/Freezed/add'?>">
                <div class="row">
                	<div><br></div>
                	<div class="col-md-12 col-sm-12 col-xs-12">
                    	<div class="col-md-4 col-sm-4 col-xs-4"></div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Select Year <span class="asterisk_sign">*</span></label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <select name="freezed_year" class="form-control" id="freezed_year" onchange="get_data(this)" 
                                >
                                <option value="">Select</option>
                                <?php 
                                	
                                	$date = date("Y");

                                	if(trim($freezed_year)==$date)
                            			{	
                            				$select = 'selected';
                            			}
                            			else
                            			{	
                            				$select = '';
                            			}

                                	echo '<option value="'.$date.'" '.$select.' selected>'.$date.'</option>';
                                	for ($i=1; $i <=5 ; $i++) { 
                                		$year = date("Y",strtotime("-$i year"));
                                		if(isset($freezed_year))
                                		{
                                			if(trim($freezed_year)==$year)
                                			{	
                                				$select = 'selected';
                                			}
                                			else
                                			{	
                                				$select = '';
                                			}
                                		}
                                		
                                		echo '<option value="'.$year.'">'.$year.'</option>';
                                		}	
                                ?>
                                </select>
                            </div>
                            <input type="hidden" name="month" id="month" value="">
                        </div>
            		</div>
                </div>
            	<div><br></div>	
                <div class="col-md-3 col-sm-3 col-xs-3"></div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                	<div class="table-responsive">
    				<table id="" class="table datatable table-bordered"  >
    					<thead id="head">
    						<tr>
    						    <th width="58" style="text-align:center;"> Sr. No.</th>
    							<th width="150">Freeze Month</th>
    	                        <th width="120">Freezed Date</th>
    	                        <th width="90">Action</th>
    					</thead>
    					<tbody id="tbody" style="background-color: #fff;">
    						
    					</tbody>
    				</table>
    			</div>		
                </div>
            </form>
		    </div>
            <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->

        </div>
        <!-- END PAGE CONTAINER -->
        </div>

        <div id="confirm_content2" style="display:none">
            <div class="logout-containerr">
                <button type="button" class="close" data-confirmmodal-but="close">×</button>
                <div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Freez Month </div>
                <div class="confirmModal_content">
                    <p>Are You Sure You Want To Freeze This Month</p>
                </div>
                <div class="confirmModal_footer">
                    <!-- <a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a> -->
                    <button type="button" class="btn " data-confirmmodal-but="ok">Yes</button>
                    <button type="button" class="btn " data-confirmmodal-but="cancel">No</button>
                </div>
            </div>
        </div>
        <!-- Modal -->
   


        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    	<script type="text/javascript">
			var Base_url = '<?=base_url();?>';
			$(document).ready(function()
			{
				get_data();
				/*$('#copy').on('click',function(){					
					var r = confirm("Do you want ot change the sequence permenant??");
					if (r == true) {
						var  mer = $('#merchendizer_route_plan').html();
						$('#admin_route_plan').html('');
						$('#admin_route_plan').html(mer);
						 var ispermenant = "Yes";
						$('#ispermenant').val(ispermenant);
					} else {
						
					}
				});*/
				const monthNames = ["January", "February", "March", "April", "May", "June",
									  "July", "August", "September", "October", "November", "December"
									];

				var d = new Date();
				var current_month = monthNames[d.getMonth()];
				var current_year = d.getFullYear();
				$('#freezed_year').on('change',function(){	

					$.ajax({
                        url:'<?=base_url()?>index.php/freezed/get_freez_month',
                        method: 'post',
                        data: {year:$(this).val()},
                        dataType: 'html',
                        async: false,
                        success: function(response){
                            $('#tbody').empty().append(response);
                        }
               		 });
					/*var length = $('#month > option').length;
					var month = document.getElementById('month');
					if($(this).val()=='2018')
					{
						var getid;
						for (var i = 0; i < length; i++) {
							months = month[i];

							if(months.value==current_month)
							{
							   getid = i;
							   $("#month option[value='"+months.value+"']").hide();
							}
							if(getid<i)
							{
								$("#month option[value='"+months.value+"']").hide();
							}
						}
					}
					else
					{
						for (var i = 0; i < length; i++) {
							months = month[i];
 							$("#month option[value='"+months.value+"']").show();
						}
					}*/
					/*location.href=Base_url+'index.php/Sales_rep/change_admin_sequence/'+$(this).val();*/
			    });

			    $('body').on('click', '.freezed', function() {
				      var month = $(this).attr('data-attr');
				      $('#month').val(month);
					 $('#confirm_content2').confirmModal({
	                    topOffset: 0,
	                    onOkBut: function() { 
	                    $('#form_freez').submit();},
	                    onCancelBut: function() {},
	                    onLoad: function() {},
	                    onClose: function() {}
	                });
				});
			 });

			function get_data() {
				var frezval = $('#freezed_year').val();
				if(frezval!="")
				{
					$.ajax({
                        url:'<?=base_url()?>index.php/freezed/get_freez_month',
                        method: 'post',
                        data: {year:frezval},
                        dataType: 'html',
                        async: false,
                        success: function(response){
                            $('#tbody').empty().append(response);
                        }
               		 });
				}
				
			}
		</script>
    <!-- END SCRIPTS -->      
    </body>
</html>