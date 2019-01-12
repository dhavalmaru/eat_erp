

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

             .modal-body .select2-container{
                display: inherit!important;
                width: 100%!important;
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
                   <div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Super Stockist Sale List 
                        <!-- <a class="btn btn-default-danger pull-right "  style="margin-right:8px!important;" href="<?php echo base_url('index.php/Distributor_sale/download_csv');?>" ><i class="fa fa-file-pdf-o "></i> Download Sample</a> --> 
                        <a class="btn btn-default-danger pull-right" data-toggle="modal" href="#myModal1" style="margin-right:8px!important;">
                        <span class="fa fa-file-excel-o"></span> Download Sample
                        </a>
                   </div>						 
					  <div class="heading-h3-heading mobile-head">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                       	<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success " href="<?php echo base_url() . 'index.php/distributor_sale/add'; ?>">
										<span class="fa fa-plus"></span> Add Super Stockist Sale Entry
									</a>
						
								</div>
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
					      <div class="panel panel-default">		
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered"  >
									<thead>
										<tr>
										    <th width="58" style="text-align:center;"> Sr. No.</th>
										    <th width="58" style="text-align:center;">Edit</th>
								
											<th width="150"> Date Of processing</th>
											<th> Distributor Name</th>
											<th width="120"> Amount (In Rs) </th>
											<th width="110"> Creation Date</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td style="text-align:center;"><?php echo $i+1; ?></td>
											<td style="text-align:center; vertical-align: middle; "><a href="<?php echo base_url().'index.php/distributor_sale/edit/'.$data[$i]->id; ?>"><i class="fa fa-edit"></i></a></td>

											<td>
                                                <span style="display:none;">
                                                    <?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('Ymd',strtotime($data[$i]->date_of_processing)):''); ?>
                                                </span>
                                              <?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?>
                                            </td>
											<td><?php echo $data[$i]->distributor_name; ?></td>
											<td><?php echo format_money($data[$i]->amount,2); ?></td>
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
				<div class="modal fade" id="myModal1" role="dialog" style="">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content" style="">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">
                                   Download Sample 
                                </h4>
                            </div>
                            <form method="POST" action="<?php echo base_url();?>index.php/Distributor_sale/download_csv" class="form-horizontal excelform" enctype="multipart/form-data">
                            <div class="modal-body">
                                <label class="control-label">Select Distributor <span class="asterisk_sign">*</span></label>
                                <br/>
                                <div class="form-group">
                                    <select name="distributor_id" id="distributor_id" class="form-control " >
                                                <option value="">Select</option>
                                                <?php if(isset($distributor)) { for ($k=0; $k < count($distributor) ; $k++) { ?>
                                                       <option value="<?php echo $distributor[$k]->distributor_name; ?>" ><?php echo $distributor[$k]->distributor_name; ?></option>
                                                <?php }} ?>
                                      </select>
                                </div>
                                    <div class="form-group">
                                     <label class="control-label">Select Zone <span class="asterisk_sign"></span></label>
                                         <select name="zone_id[]" id="zone_id" class="form-control select2" multiple="multiple">
                                            <?php if(isset($zone)) { for ($j=0; $j < count($zone) ; $j++) { ?>
                                                           <option value="<?php echo $zone[$j]->id; ?>" ><?php echo $zone[$j]->zone; ?></option>
                                                    <?php }} ?>
                                          </select>
                                    </div>
                                <div class="row"><br></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <!-- <button id="btn_save" class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
                                <input type="submit"  class="btn btn-success pull-right"  value="Download" />
                            </div>
                            </form>
                        </div>
                    </div>
                </div>   
    		     <div class="modal fade" id="myModal" role="dialog" style="">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content" style="">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">
                                   Add Bulk Entries Of Super Stockist
                                </h4>
                            </div>
                            <form method="POST" action="<?php base_url();?>Distributor_sale/upload_file" class="form-horizontal excelform" enctype="multipart/form-data">
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
            var BASE_URL = '<?= base_url()?>';
        </script>
        <script type="text/javascript">
                $(document).on('submit','form.excelform',function(){
                    setTimeout(function(){ 
                        document.location.reload();
                    }, 1000);
                });

                $(document).ready(function(){
                   /* $('#zone_id').multiselect({
                        buttonWidth: '100%'
                    });*/

                    /*$('#distributor_id').on('change',function(){

                        $('#zone_div').show();

                        $.ajax({
                            url:BASE_URL+'index.php/Distributor_sale/get_zone',
                            type : 'POST',
                            data:{dist_name:$(this).val()},
                            dataType:"json",
                            success:function(data){
                                var zone = '';
                                $('#zone_id').empty();
                                if(data.length>0)
                                {
                                  $.each(data, function(idx, obj) {
                                   zone+="<option value='"+obj.zone_id+"'>"+obj.zone+"</option>";
                                    });
                                  $('#zone_id').append(zone);   
                                }
                               
                            }

                        })
                    });*/
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
            // });
		</script>
    
    <!-- END SCRIPTS -->      
    </body>
</html>