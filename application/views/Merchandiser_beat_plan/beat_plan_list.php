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
             .alert
             {
              padding:5px;
              border-radius:0px;
             }
             .alert-dismissable .close, .alert-dismissible .close
             {
                  position: relative;
             top: -2px;
             right: 0px;
             color: #fff;
             opacity: 1!important;
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
                   <div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Sales Merchandiser Beat Plan <a class="btn btn-default-danger pull-right "  style="margin-right:8px!important;" href="<?php echo base_url('index.php/Merchandiser_beat_plan/download_csv');?>" ><i class="fa fa-file-pdf-o "></i> Download Sample</a> </div>						 
					  <div class="heading-h3-heading mobile-head">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                       	<!-- <div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success " href="<?php echo base_url() . 'index.php/Merchandiser_beat_plan/add'; ?>">
										<span class="fa fa-plus"></span> Add Sales Merchandiser Beat Plan
									</a>
						
								</div> -->
								 <a class="btn btn-success" data-toggle="modal" href="#myModal">
                                <span class="fa fa-file-excel-o"></span> Add Excel
                            </a> 
							
				     </div>	      
                </div>
                 <div class="container">
                     <?php if($this->session->flashdata('error')){?>
                     <div class="alert alert-danger alert-dismissible fade in">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                     <strong>Error On Line! </strong> 
                     <?php echo rtrim($this->session->flashdata('error'),',');?></div>  
                     <?php } ?>
                 </div>
                 
                      <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">                
                    <div class="row">
					  <div class="page-width">	
                        <div class="col-md-12">
						
						<div class="pull-right btn-margin" style="padding-bottom:20px">	
								<!-- <a class="btn btn-success" href="<?php echo base_url('index.php/Merchandiser_beat_plan/retailer_not_mapped');?>">
									<span class="fa fa-file-excel-o"></span> Retailers
								</a>  -->
								<a class="btn btn-success" href="<?php echo base_url('index.php/Merchandiser_beat_plan/merchandizer_not_mapped');?>">
									<span class="fa fa-file-excel-o"></span> Merchandiser
								</a> 
								
									<a class="btn btn-success" href="<?php echo base_url('index.php/Merchandiser_beat_plan/store_not_mapped');?>">
									<span class="fa fa-file-excel-o"></span> Store
								</a> 
								
								
									<a class="btn btn-success" href="<?php echo base_url('index.php/Merchandiser_beat_plan/zone_not_mapped');?>">
									<span class="fa fa-file-excel-o"></span> Zone
								</a> 
						</div>
							
					      <div class="panel panel-default">		
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered"  >
										<thead>
										<tr>
										    <th width="58" style="text-align:center;"> Sr. No.</th>
											
											<!-- <th width="150"> Retailer Name</th> -->
											<th width="150"> Zone</th>
											<th width="150"> Store </th>
											<th width="150"> Location </th>
											<th width="120"> Merchandiser Name</th>
											<th width="120"> Frequency</th>
											<th width="120"> Sequence</th>
											<th width="110"> Creation Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
											<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<!-- <td><?php echo $data[$i]->distributor_name; ?></td> -->
											<td><?php echo $data[$i]->zone; ?></td>

											
											<td><a href="javascript:void(0)"><?php echo $data[$i]->store_name; ?></a></td>
											<td><?php echo $data[$i]->location; ?></td>
											<td><?php echo $data[$i]->sales_rep_name; ?></td>
											<td><?php echo $data[$i]->frequency; ?></td>
											<td><?php echo $data[$i]->sequence; ?></td>
											
											<td>
												<span style="display:none;">
                                                    <?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('Ymd',strtotime($data[$i]->modified_on)):''); ?>
                                                </span>
												<?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>
										</tr>
										<?php } ?>
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
				
				<div class="modal fade" id="myModal" role="dialog" style="">
					<div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">
                               Add Bulk Entries Of Sales Merchandiser Beat Plan
                            </h4>
                        </div>
                        <form method="POST" action="<?php echo base_url();?>index.php/Merchandiser_beat_plan/upload_file" class="form-horizontal excelform" enctype="multipart/form-data">
                        <div class="modal-body">
						 <div class="form-group">

                                         <label class="col-md-4 col-sm-4 col-xs-12 control-label">Add Excel <span class="asterisk_sign"></span></label>
                                     
                                             <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="upload" id="image" placeholder="image" value=""/>
                         </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <!-- <button id="btn_save" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
                            <input type="submit"  class="btn btn-success pull-right"  value="Save" />
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
                $(document).on('submit','form.excelform',function(){
                    setTimeout(function(){ 
                        document.location.reload();
                    }, 1000);
                });
                /*var filename = '<?= $filename;?>';
                $( document ).ready(function() {
                    if(filename!='')
                        $('#error_file').click();
                });

                $('#error_file').on('click',function(){
                    setTimeout(function(){ window.open("<?=$url?>",'self'); }, 1000);*/
                  
        </script>
		<script>

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
            }
		</script>
    
    <!-- END SCRIPTS -->      
    </body>
</html>