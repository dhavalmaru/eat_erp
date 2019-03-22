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
        <!-- EOF CSS INCLUDE -->     
		<style>
            .download {
                font-size: 21px;
                color: #5cb85c;
            }
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/batch_master'; ?>" > Batch Master List </a>  &nbsp; &#10095; &nbsp; Batch Master Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="form_batch_master_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/batch_master/update/' . $data[0]->id; else echo base_url().'index.php/batch_master/save'; ?>" enctype="multipart/form-data" >
                                <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default">
								
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="hidden" class="form-control" name="module" id="module" value="<?php if(isset($module)) echo $module;?>"/>
                                                <input type="text" class="form-control datepicker" name="date_of_processing" id="date_of_processing" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->date_of_processing!=null && $data[0]->date_of_processing!='')?date('d/m/Y',strtotime($data[0]->date_of_processing)):date('d/m/Y')); else echo date('d/m/Y'); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Production <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="production_id" id="production_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php 
                                                        $production_id = '';
                                                        if(isset($data)) $production_id = $data[0]->production_id;
                                                        if($production_id==''){
                                                            if(isset($p_id)) $production_id = $p_id;
                                                        }

                                                        if(isset($production)) { for ($k=0; $k < count($production) ; $k++) { 
                                                    ?>
                                                        <option value="<?php echo $production[$k]->id; ?>" <?php if(isset($production_id)) { if($production[$k]->id==$production_id) echo 'selected'; } ?> ><?php echo $production[$k]->p_id; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
    								<div class="form-group">
    									<div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Batch No <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="batch_no" id="batch_no" placeholder="Batch No" value="<?php if(isset($data)) echo $data[0]->batch_no;?>"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select class="form-control" name="status">
                                                    <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Active</option>
                                                    <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
									
								   	<div class="h-scroll" style="display: none;">	
                                        <div class="table-stripped form-group" style="padding:15px;">
                                            <table class="table table-bordered" style="margin-bottom: 0px; ">
                                            <thead>
                                                <tr>
                                                    <th>Document Title</th>
                                                    <th>Upload Files</th>
                                                  
                                                 
                                                    <th width="75">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bar_image_details">
                                            <?php $i=0; if(isset($batch_doc)) {
                                                    for($i=0; $i<count($batch_doc); $i++) { ?>
                                                <tr id="bar_image_<?php echo $i; ?>_row">
    												<td>
                                                        <input type="text" class="form-control title" name="title[]" id="title_<?php echo $i; ?>" placeholder="title"value="<?php if (isset($batch_doc)) { echo $batch_doc[$i]->title; } ?>">
                                                    </td>
                                                    <td>
                                                        <div class="col-md-9 col-sm-9 col-xs-9">
                                                            <input type="hidden" class="form-control" name="receivable_doc[]" value="<?php if(isset($batch_doc)) {echo $batch_doc[$i]->receivable_doc;} ?>" />
                                                            <input type="hidden" class="form-control" name="image_path[]" value="<?php if(isset($batch_doc)) {echo $batch_doc[$i]->doc_img;} ?>" />
        												    <input type="file" class="fileinput btn btn-info btn-small bar_image" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image"/>
                                                        </div>
                                                        <?php if(isset($batch_doc)) {if($batch_doc[$i]->doc_img!= '') { ?>
                                                        <div class="col-md- col-sm-3 col-xs-3">
        												    <a target="_blank" id="batch_doc_file_download<?php echo $i; ?>" href="<?php echo base_url().$batch_doc[$i]->doc_img; ?>"><span class="fa download fa-download" ></span></a>
                                                        </div>
        												<?php }} ?>
    												</td>
                                                   <td style="text-align:center;  vertical-align: middle;">
                                                        <a id="bar_image_<?php echo $i; ?>_row_delete" class="delete_row" href="#"> <span class="fa trash fa-trash-o"  ></span></a>
                                                    </td>
                                                </tr>
                                            <?php }} else { ?>
                                                <tr id="bar_image_<?php echo $i; ?>_row">
                                                    <td>
                                                        <input type="text" class="form-control title" name="title[]" id="title_<?php echo $i; ?>" placeholder="title" value=""/>
                                                    </td>
                                                    <td>
    												    <input type="hidden" class="form-control" name="receivable_doc[]" id="receivable_doc_<?php echo $i; ?>" value="" />
                                                        <input type="hidden" class="form-control" name="image_path[]" value="" />
                                                        <input type="file" class="fileinput btn btn-info btn-small  bar_image" name="doc_img_<?php echo $i; ?>" id="doc_img_<?php echo $i; ?>" placeholder="image" value=""/>
                                                    </td>
                                                    <td style="text-align:center;     vertical-align: middle;">
                                                        <a id="bar_image_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">
                                                        <button type="button" class="btn btn-success" id="repeat-bar_image" style=" ">+</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            </table>
                                        </div>
    								</div>
									
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Remarks </label>
                                            <div class="col-md-10 col-sm-10 col-xs-12">
                                                <textarea class="form-control" name="remarks"><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
                                </div>
								</div>
								</div>
								
                                <div class="panel-footer">
                                    <?php 
                                        $action = '';
                                        if(isset($module)) { if($module=='production') $action = base_url().'index.php/production/post_details/'.$production_id; }
                                        if($action==''){
                                            $action = base_url().'index.php/batch_master';
                                        }
                                    ?>
									<a href="<?php echo $action; ?>" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
							</form>
                    </div>
                    
                   </div>
                <!-- END PAGE CONTENT WRAPPER -->
               </div>            
            <!-- END PAGE CONTENT -->
            </div>
        <!-- END PAGE CONTAINER -->
	   </div>	
    </div>	   
    <?php $this->load->view('templates/footer');?>
    <script type="text/javascript">
        var BASE_URL="<?php echo base_url()?>";
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    
    <script>
        jQuery(function(){
            var counter = $('.title').length;
			
            $('#repeat-bar_image').click(function(event){
                event.preventDefault();
                var newRow = jQuery('<tr id="bar_image_'+counter+'_row">'+
                                      '<td>'+
                                            '<input type="title" class="form-control title" name="title[]" id="title_'+counter+'" placeholder="title" value=""/>'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="hidden" class="form-control receivable_doc" name="receivable_doc[]" value="receivable_doc_'+counter+'" />'+
                                            '<a class="file-input-wrapper btn btn-default fileinput btn btn-info btn-small batch_doc">'+
                                                '<span>Browse</span>'+
                                                '<input type="file" class="fileinput btn btn-info btn-small bar_image" name="doc_img_'+counter+'" id="doc_img_'+counter+'" placeholder="image" value="" style="left: -244px; top: -1px;">'+
                                            '</a>'+
                                        '</td>'+
                                        '<td style="text-align:center;  vertical-align: middle;">'+
                                            '<a id="bar_image_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>'+
                                        '</td>'+
                                    '</tr>');
                $('#bar_image_details').append(newRow);
                $('.delete_row').click(function(event){
                    delete_row($(this));
                });
                counter++;
            });
        });
    </script>
    </body>
</html>