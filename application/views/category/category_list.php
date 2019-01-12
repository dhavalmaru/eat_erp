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
         @media only screen and  (min-width:495px)  and (max-width:524px) { 
	     .heading-h3-heading:first-child {     width: 46%!important;}
	     .heading-h3-heading:last-child {     width: 54%!important;}
	     .heading-h3-heading .btn-margin{ }
	     }
	     .delete .trash {
		    color: #cc2127;
		 }
		 .fa {
		    font-size: 20px;
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
               <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Category Details List  </div>
               <div class="heading-h3-heading">
                  <div class="pull-right btn-margin">	
                     <?php $this->load->view('templates/download');?>	
                  </div>
                  <div class="pull-right btn-margin">
                     <div class="c">
                        <?php  //if(isset($access)) { if($access[0]->r_insert == 1) {  ?>
                        <a class="btn btn-success" data-toggle="modal" href="#myModal"> Add Category
                        </a>  
                        <?php // }}  ?>
                     </div>
                  </div>
               </div>
            </div>
            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">

               <div class="row">
                  <div class="page-width">
                  	<div class="col-md-2">&nbsp;</div>
                     <div class="col-md-8">
                        <div class="panel panel-default">
                           <div class="panel-body">
                              <div class="table-responsive">
                                 <table id="customers2" class="table datatable table-bordered"  >
                                    <thead>
                                       <tr>
                                          <th width="65" style="text-align:center;" >Sr. No.</th>
                                          <th >Category </th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php 
                                          if(isset($category_detail)){
                                           for($i=0; $i < count($category_detail); $i++) { ?>
                                       <tr id="trow_<?php echo $i;?>">
                                          <td style="text-align:center;"><?php if(isset($category_detail)){ echo ($i+1) ;} else {echo '1';} ?></td>
                                          <td>
                                             <?php echo $category_detail[$i]->category_name; ?>
                                          </td>
                                          <td><a href="#" class="edithis" data-attr="<?=$category_detail[$i]->id?>"><i class="fa fa-edit"></i></a>
                                          	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <a href="#" class="delete" data-attr="<?=$category_detail[$i]->id?>"><i class="fa trash fa-trash-o"></i></a>
                                          </td>
                                       </tr>
                                       <?php } 
                                          }?>
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
      </div>
      <div class="modal fade" id="myModal" role="dialog" style="">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">
                           Add/Update Category
                        </h4>
                    </div>
                    <form method="POST" action="<?php echo base_url();?>index.php/Category/add" class="form-horizontal excelform" enctype="multipart/form-data" id="category_master">
                    <div class="modal-body">
                    	<div class="row form-group">
                    		<div class="col-md-3">
                    			<label class="control-label">Category Name <span class="asterisk_sign"></span></label>
                    		</div>
                    		<div class="col-md-6">
                    			<input type="text" class="form-control" placeholder="Category Name" name="category_name" id="category_name" />
                    			<input type="hidden" class="form-control"  name="category_id" id="category_id" />
                    		</div>
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
      <!-- END PAGE CONTAINER -->
      <?php $this->load->view('templates/footer');?>
      <!-- END SCRIPTS -->  
      <script type="text/javascript">
         var BASE_URL="<?php echo base_url()?>";
      </script>
      <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>    
      <script type="text/javascript">
      	$(document).ready(function() {
      	  $('.edithis').on('click' ,function(){
      	  	var cat_id = $(this).attr('data-attr');
      	  	$.ajax({
      	  		url:BASE_URL+'index.php/Category/get_category_by_id/'+cat_id,
      	  		type:"GET",
      	  		async: false,
      	  		success:function(data){
      	  			/*alert('eneterd');*/
      	  			var obj = JSON.parse(data);
      	  			$('#category_name').val(obj.category_name);
      	  			$('#category_id').val(obj.id);
      	  			$('#myModal').modal('show');
      	  		}
      	  	})
      	  });

      	  $('.delete').on('click' ,function(){
      	  	var cat_id = $(this).attr('data-attr');
      	  	if (confirm("Are you sure you want to delete this category")) {
			       $.ajax({
	      	  		url:BASE_URL+'index.php/Category/delete_record/'+cat_id,
	      	  		type:"GET",
	      	  		async: false,
	      	  		success:function(data){
	      	  			alert('Record Deleted Succesfully');
	      	  			location.reload();
	      	  		}
	      	  	});
		    } 
      	  	
      	  });

		});

      </script>
   </body>
</html>