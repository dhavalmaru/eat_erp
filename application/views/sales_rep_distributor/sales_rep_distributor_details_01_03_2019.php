<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Eat-ERP</title>
	<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1  maximum-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="HandheldFriendly" content="True">
	
	<link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.png">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/font-awesome.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/fakeLoader.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/slick.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/slick-theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/owl.transitions.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>sales_rep/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/logout/popModal.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/font/material-design-icons/Material-Design-Icons.woff" rel="stylesheet">
	
	<style>
		.submitLink 
		{
			  background-color: transparent;
			  text-decoration: none;
			  border: none;
			  color: #428bca;
			  cursor: pointer;
			  font-size:16px!important;
		}

        .input-field label {
            color: #000;
            font-size:0.8rem!important;
        }

        label.error {
            margin-top: 37px;
            color: red !important;
            transform: translateY(0%) !important; 
            font-size:0.8rem!important;
        }

        input::-webkit-input-placeholder
        { 
            font-size:0.8rem!important;
            color: #000!important;
        }

        input:not([type]), input[type=text], input[type=password], input[type=email], input[type=url], input[type=time], input[type=date], input[type=datetime], input[type=datetime-local], input[type=tel], input[type=number], input[type=search], textarea.materialize-textarea
        {
            color: #000;
            font-size:0.8rem!important;
        }

        th{
            font-size:0.8rem!important;
            color: #000;
        }
        

        select
        {
            color: #000!important;
            font-size:0.8rem!important;
        }

        .control-label{
            color: #000!important;
        }

	</style>

<body class="home">		
    
     <div id="loading" style="display: none"></div>						
	<!-- START PAGE CONTAINER -->
	
		<div class="navbar">
		 <?php $this->load->view('templates/header2');?>
		</div>

		<?php $this->load->view('templates/menu2');?>	


        <!-- START PAGE CONTAINER -->
               
        <!-- PAGE CONTENT -->
 
       
        <!-- PAGE CONTENT WRAPPER -->
 	<div class="contact app-pages app-section">
		<div class="container">
			
			<div id="basic-form" class="section">
              <div class="row">
                <div class="col s12">
				<div class="card-panel">
              
				<div class="row">
      
				
				
					<div class="app-title">
					<h5>Retailer Details</h5>
					</div>
			         
                     <?php 
                         if(isset($id) || isset($data[0]->id))
                         {
                            $id = $id;
                         }
                         else
                         {
                            $id = '';
                         }

                    ?>            

                  <?php
                              $visit_detail = '';
                              if($this->session->userdata('visit_detail')!=null)
                              {
                                 $visit_detail = $this->session->userdata('visit_detail');
                              
                                 /*echo "<pre>";
                                      print_r($data);
                                   echo "</pre>";*/
                              }
                  ?>
					<hr>
                  
                    <form id="form_sales_rep_distributor_details" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if ($id!='') echo base_url(). 'index.php/sales_rep_distributor/save/' . $id; else echo base_url().'index.php/Sales_rep_store_plan/save_sales_rep_retailer'; ?>">
                      
                               	<div class="row ">
									<!-- <div class="col s12">
										<div class="input-field col s3">
											<label>Distributor <span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">
                                            
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php if($id!='') echo $id;?>"/>
                                            <input type="hidden" class="form-control" name="place_order" id="place_order" value="No"/>
                                            <select name="distributor_id" id="distributor_id" class="browser-default">
                                                <option value="">Select</option>
                                                
                                           </select>
										      
                                        </div>
                                    </div> -->

									<div class="col s12">
										<div class="input-field col s3">
											<label>Retailer Name <span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">

											<input type="text"  name="distributor_name" id="distributor_name" placeholder="Retailer Name" value="<?php if(isset($data)) echo $data[0]->distributor_name; else if(isset($distributor_name)) echo $distributor_name;
                                            else if($visit_detail!=''){
                                                if ($visit_detail['distributor_name']!='')echo $visit_detail['distributor_name'];
                                            };
                                            ?>" readonly/>
											 
											 
                                        </div>
                                     </div>
									<div class="col s12">
										<div class="input-field col s3">
											<label>GST Number <span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">
											<input type="text"  name="gst_number" id="gst_number" placeholder="GST Number" value="<?php if(isset($data)) echo $data[0]->gst_number; else if(isset($gst_number)) echo $gst_number;?>"/>
                                        </div>
                                        
                                    </div>
                                
									<!-- <div class="col s12">
										<div class="input-field col s3">
											<label>Zone <span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">
                                     
                                     
                                             <select name="zone_id" id="zone_id" class="browser-default" onchange="get_area();">
                                                <option value="">Select</option>
                                                <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                        <option value="<?php echo $zone[$k]->zone_id; ?>" <?php 
                                                        if($visit_detail!=''){
                                                                    if ($visit_detail['zone_id']==$zone[$k]->zone_id){ echo 'selected' ; }
                                                                }
                                                        else if(isset($data)) {
                                                            if($zone[$k]->zone_id==$data[0]->zone_id) {echo 'selected';}} else if(isset($zone_id)) {if($zone[$k]->zone_id==$zone_id) {echo 'selected';}};
                                                         ?>><?php echo $zone[$k]->zone; ?></option>
                                                <?php }} ?>
                                            </select>
										</div>
										</div>
								 
									<div class="col s12">
										<div class="input-field col s3">
											<label>Area <span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">
											
											<select name="area_id" id="area_id" class="browser-default" onchange="get_location();">
                                                <option value="">Select</option>
                                                <?php if(isset($area)) { for ($k=0; $k < count($area) ; $k++) { ?>
                                                        <option value="<?php echo $area[$k]->area_id; ?>" <?php  
                                                        if($visit_detail!=''){
                                                                    if ($visit_detail['zone_id']==$zone[$k]->zone_id){ echo 'selected' ; }
                                                                }
                                                        else if(isset($data)) {if($area[$k]->area_id==$data[0]->area_id) {echo 'selected';}} else if(isset($area_id)) {if($area[$k]->area_id==$area_id) {echo 'selected';}};
                                                        ?>><?php echo $area[$k]->area; ?></option>
                                                <?php }} ?>
                                            </select>
											 
											
										</div> 
									</div> 
								 
									<div class="col s12">
										<div class="input-field col s3">
											<label>Location <span class="asterisk_sign">*</span></label>
										</div> 
										<div class="input-field col s9">
                                     
                                     
                                            <select name="location_id" id="location_id" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                        <option value="<?php echo $location[$k]->id; ?>" <?php  
                                                        if($visit_detail!=''){
                                                            if ($visit_detail['location_id']==$location[$k]->id){ echo 'selected' ; }
                                                         }
                                                        else if(isset($data)) {if($location[$k]->id==$data[0]->location_id) {echo 'selected';}} else if(isset($location_id)) {if($location[$k]->id==$location_id) {echo 'selected';}};
                                                        ?>><?php echo $location[$k]->location; ?></option>
                                                <?php }} ?>
                                            </select>
											
										</div>
									</div> -->

                                    <?php 
                                if(isset($distributor_name))
                                  $style = 'display:block';
                                else
                                  $style = 'display:none';
                             ?>
                             <div class="row"  style='<?=$style;?>'>
                                <br>
                                <div class="col s12">
                                   <div class="input-field col s3" >
                                      <label>Retailer <span class="asterisk_sign">*</span></label>
                                   </div>
                                   <div class="input-field col s9">
                                      <?=(isset($distributor_name)?$distributor_name:'')?>
                                   </div>
                                </div>
                             </div>
                             <?php 
                              if(isset($zone))
                                $style = 'display:block';
                              else
                                $style = 'display:none';
                             ?>
                            <div class="col s12" style='<?=$style;?>'>
                                <br>
                                   <div class="input-field col s3" >
                                      <label>Zone <span class="asterisk_sign">*</span></label>
                                   </div>
                                   <div class="input-field col s9">
                                      <?=(isset($zone)?$zone:'')?>
                                   </div>
                            </div>

                             <?php 
                                if(isset($visit_detail['channel_type']))
                                {
                                  if($visit_detail['channel_type']=='MT')
                                    $style = 'display:block';
                                  else
                                    $style = 'display:none';
                                }
                                else
                                {
                                  $style = 'display:none';
                                }
                             ?>
                             <div class="col s12" style='<?=$style;?>'>
                                <br>
                                   <div class="input-field col s3" >
                                      <label>Relation <span class="asterisk_sign">*</span></label>
                                   </div>
                                   <div class="input-field col s9">
                                      <?=(isset($store_name)?$store_name:'')?>
                                   </div>
                            </div>    

                           <?php 
                            if(isset($area))
                              $style = 'display:block';
                            else
                              $style = 'display:none';
                           ?>
                           <div class="col s12" style='<?=$style;?>'>
                            <br>
                                 <div class="input-field col s3" >
                                    <label>Area <span class="asterisk_sign">*</span></label>
                                 </div>
                                 <div class="input-field col s9">
                                    <?=(isset($area)?$area:'')?>
                                 </div>
                            </div>


                           <?php 
                            if(isset($location))
                              $style = 'display:block';
                            else
                              $style = 'display:none';
                           ?>
                            <div class="col s12" style='<?=$style;?>'>
                                <br>
                               <div class="input-field col s3" >
                                  <label>Location <span class="asterisk_sign">*</span></label>
                               </div>
                               <div class="input-field col s9">
                                  <?=(isset($location)?$location:'')?>
                               </div>
                             </div>
								 
							<div class="col s12">
                                <br>
								<div class="input-field col s3">
									<label>Margin On MRP (In %) <span class="asterisk_sign">*</span></label>
								</div> 
								<div class="input-field col s9">
								<div class="input-field col s12 ">
								
									<input type="text" class="form-control" name="margin" placeholder="Margin" value="<?php if(isset($data)) echo $data[0]->margin;?>"/>
									
								</div> 
							   </div> 
							</div> 
								
                             
							<div class="row ">
								<div class="col s12">
								<input type="hidden" class="form-control" name="doc_document" value="<?php if(isset($data)) echo $data[0]->doc_document; ?>" />
                                <input type="hidden" class="form-control" name="document_name" value="<?php if(isset($data)) echo $data[0]->document_name; ?>" />
								<div class="file-field input-field">
									<div class="btn">
									<span>Take Photo</span>
									 <input type="file" accept="image/*;capture=camera" class="fileinput btn btn-info btn-small doc_file" name="doc_file" id="doc_file" data-error="#doc_file_error"/>
                                     <div id="doc_file_error"></div>
									<input type="file">
									</div>
									<div class="file-path-wrapper">
									<input class="file-path validate" type="text">
									</div>
								</div>
								<div class="col-sm-3 download-width" >
                                        <?php if(isset($data)) { if($data[0]->doc_document!= '') { ?><a target="_blank" id="doc_file_download" href="<?php if(isset($data)) echo base_url().$data[0]->doc_document; ?>"><span class="fa download fa-download" ></span></a></a><?php }} ?>
                                </div>
								</div>
							 
								<div class="col s12">
									<div class="input-field col s12">
										<label for="remarks" style="color: #000;">Remarks</label>
									  <textarea name="remarks" class="materialize-textarea"  ><?php if(isset($data)) echo $data[0]->remarks;?></textarea>
										
										
									</div>
								</div>
							</div>
                            </div>                          
							<div class="panel-footer">
                            <a href="javascript:history.back()" class="button shadow btn_color" type="reset" id="reset">Back</a>

                            <input type="submit" value="Next" id="Next" name="srld" class="right button shadow btn_color">
                            <!-- <a href="#" id="btn_save" class="right button shadow btn_color" style="<?php if($id!='') {if($access[0]->r_edit=='0') echo 'display: none;'; else if(substr($id,0,1)=="d") echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</a> -->
                            <!-- <button id="btn_save" class="btn pull-right" style="<?php //if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button> -->
							</div>
                         
                        
                    </form>
                   
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT WRAPPER -->

        </div>            
        <!-- END PAGE CONTENT -->	
        </div>
        </div>
    
       
        <!-- END PAGE CONTAINER -->


        <div id="confirm_content2" style="display:none">
            <div class="logout-containerr">
                <button type="button" class="close" data-confirmmodal-but="close">×</button>
                <div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Place Order? </div>
                <div class="confirmModal_content">
                    <p>Do you want to place order?</p>
                </div>
                <div class="confirmModal_footer">
                    <!-- <a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a> -->
                    <button type="button" class="btn " data-confirmmodal-but="ok">Yes</button>
                    <button type="button" class="btn " data-confirmmodal-but="cancel">No</button>
                </div>
            </div>
        </div>


        <?php $this->load->view('templates/footer2');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <!-- <script src="<?php echo base_url(); ?>sales_rep/js/loading.js"></script> -->
        <script>
            $("#btn_save").click(function(){
                /*if (!$("#form_sales_rep_distributor_details").valid()) {
                    return false;
                } else {
                    $('#confirm_content2').confirmModal({
                        topOffset: 0,
                        onOkBut: function() {$("#loading").show();$('#place_order').val("Yes"); $("#form_sales_rep_distributor_details").submit();},
                        onCancelBut: function() {$("#loading").show();$('#place_order').val("No"); $("#form_sales_rep_distributor_details").submit();},
                        onLoad: function() {$('#place_order').val("No"); return true;},
                        onClose: function() {$('#place_order').val("No"); return true;}
                    });
                }*/
            });
            var get_area = function(){
                var zone_id = $('#zone_id').val();

                $.ajax({
                        url:'<?=base_url()?>index.php/Sales_rep_location/get_area',
                        method: 'post',
                        data: {zone_id: zone_id},
                        dataType: 'html',
                        async: false,
                        success: function(response){
                            $('#area_id').html(response);
                        }
                });

                get_location();
            }


            var get_location = function(){
                var zone_id = $('#zone_id').val();
                var area_id = $('#area_id').val();
                $.ajax({
                        url:'<?=base_url()?>index.php/Sales_rep_location/get_locations',
                        method: 'post',
                        data: {zone_id: zone_id, area_id: area_id},
                        dataType: 'html',
                        async: false,
                        success: function(response){
                            $('#location_id').html(response);
                        }
                });
            }
        </script>
		
		<script>
			$('.datepicker').pickadate({
			selectMonths: true, // Creates a dropdown to control month
			selectYears: 15 // Creates a dropdown of 15 years to control year
			});
          $('select').material_select();


          $(document).ready(function(){
            $("#zone_id").attr("disabled", true);
            $("#area_id").attr("disabled", true);
            $("#location_id").attr("disabled", true);
          });
          
        </script>
        <!-- END SCRIPTS -->      
    </body>
</html>