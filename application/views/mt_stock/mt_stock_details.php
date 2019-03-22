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
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/mt_stock'; ?>" > Store List </a>  &nbsp; &#10095; &nbsp; Store Details</div>
                
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
                            <form id="" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/mt_stock/update/' . $data[0]->id; else echo base_url().'index.php/mt_stock/save'; ?>">
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
								
								<div class="panel-body">
								
									 
										<div class="form-group" >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Zone</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="zone_id" id="zone_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($zone)) { for ($k=0; $k < count($zone) ; $k++) { ?>
                                                            <option value="<?php echo $zone[$k]->id; ?>" <?php if (isset($data)) { if($zone[$k]->id==$data[0]->zone_id) { echo 'selected'; } } ?>><?php echo $zone[$k]->zone; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
								
								
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
									
										 <label class="col-md-2 col-sm-2 col-xs-12 control-label"> Relation <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                              <select name="store_id" id="store_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($store_rel)) { for ($k=0; $k < count($store_rel) ; $k++) { ?>
                                                            <option value="<?php echo $store_rel[$k]->id; ?>" <?php if (isset($data)) { if($store_rel[$k]->id==$data[0]->store_id) { echo 'selected'; } } ?>><?php echo $store_rel[$k]->store_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                             
                                            </div>
                                        </div>
                                    </div>
											
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											  <label class="col-md-2 col-sm-2 col-xs-12 control-label">Location</label>
										<div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="location_id" id="location_id" class="form-control select2">
                                                    <option value="">Select</option>
                                                    <?php if(isset($location)) { for ($k=0; $k < count($location) ; $k++) { ?>
                                                            <option value="<?php echo $location[$k]->id; ?>" <?php if (isset($data)) { if($location[$k]->id==$data[0]->location_id) { echo 'selected'; } } ?>><?php echo $location[$k]->location; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                         
                                        </div>
                                    </div>
										
									 <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Google Address</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12">
                                                <input type="text" class="form-control" name="google_address" id="google_address"  onFocus="geolocate()" placeholder="Google Address" value="<?php if(isset($data)) { echo  $data[0]->google_address; } ?>"/>
                                            </div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Latitude</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control latitude" id="latitude" name="st_latitude" placeholder="Latitude" value="<?php if (isset($data)) { echo $data[0]->latitude; } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Longitude</label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control longitude" id="longitude" name="st_longitude" placeholder="Longitude" value="<?php if (isset($data)) { echo $data[0]->longitude; } ?>"/>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="ava_qty1">
                                    <div class="form-group" id="bar_details1">
                                        <?php $i=0; if(isset($stock_details)) { 
                                            for($i=0; $i<count($stock_details); $i++) { 
                                            if($stock_details[$i]->item_id=='3') { 
                                        ?>
                                        <div class="col s12 " style="padding-bottom: 3px;">
                                            <div class="input-field col s4">
                                                Butterscotch Bar
                                                <input type="hidden"  class="butterscotch" name="bar[]" id="butterscotch_<?php echo $i;?>"  value="3" >
                                            </div>
                                            <div class="input-field col s4">
                                                <input type="text" name="qty[]" id="qty_3_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                            </div>
                                            <div class="input-field col s4">
                                                <select name="batch_no[]" id="batch_no_3_<?php echo $i;?>" class="browser-default">
                                                    <option value="">Select</option>
                                                    <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                            <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }}} else { ?>
                                    <div class="col s12" style="padding-bottom: 3px;">
                                        <div class="input-field col s4">
                                             Butterscotch Bar 
                                        </div>
                                        <input type="hidden"  class="butterscotch" name="bar[]" id="butterscotch_<?php echo $i;?>"  value="3" >
                                        <div class="input-field col s4">
                                            <input type="text" name="qty[]" id="qty_3_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                        </div>
                                      
                                        <div class="input-field col s4">
                                            <select name="batch_no[]" id="batch_no_3_<?php echo $i;?>" class="browser-default">
                                                <option value="">Select</option>
                                                <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                        <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                     
                                    </div>
                                    <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-3">+</button></div>
                                </div><hr>

                                <div class="ava_qty">
                                    <div class="row" id="bar_details">
                                        <div class="col s12 ">  <h5>Orange Bar</h5> </div>
                                        <?php $i=0; if(isset($stock_details)) { 
                                                for($i=0; $i<count($stock_details); $i++) {
                                                if($stock_details[$i]->item_id=='1'){
                                                
                                                                                    
                                        ?>
                                        <div class="col s12 " style="padding-bottom: 3px;">
                                    
                                            <div class="input-field col s4">
                                                Orange Bar
                                            <input type="hidden"  class="bar" name="bar[]" id="bar_<?php echo $i;?>"  value="1" >
                                            </div>
                                            
                                            <div class="input-field col s4">
                                                <input type="text" name="qty[]" id="qty_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                            </div>
                                           
                                            <div class="input-field col s4">
                                                <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                    <option value="">Select</option>
                                                    <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                            <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }}} else { 
                                    // for($i=0; $i<count($bar_details); $i++) { 
                                    ?>
                                    <div class="col s12" style="padding-bottom: 3px;">
                                            <div class="input-field col s4">
                                               Orange Bar
                                            </div>
                                            <input type="hidden" name="bar[]" id="bar_<?php echo $i;?>"  value="1" >
                                            <div class="input-field col s4">
                                                <input type="text" name="qty[]" id="qty_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                            </div>
                                          
                                            <div class="input-field col s4">
                                                <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                    <option value="">Select</option>
                                                    <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                            <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                    </div>
                                    <?php } ?>
                     
                                    </div>
                                    <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar">+</button></div>
                                </div><hr>
                                
                                <div class="ava_qty3">
                                    <div class="row" id="bar_details3">
                                    <div class="col s12 ">  <h5>    Choco Peanut Butter Bar </h5> </div>
                                    <?php $i=0; if(isset($stock_details)) { 
                                            for($i=0; $i<count($stock_details); $i++) { 
                                            if($stock_details[$i]->item_id=='12'){
                                    ?>
                                        <div class="col s12 " style="padding-bottom: 3px;">
                                            <div class="input-field col s4">
                                            
                                                 Choco Peanut Butter Bar 
                                        
                                            <input type="hidden"  class="Choco" name="bar[]" id="Choco_<?php echo $i;?>"  value="12" >
                                            </div>
                                               
                                            <div class="input-field col s4">
                                                <input type="text" name="qty[]" id="qty_5_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                            </div>
                                           
                                            <div class="input-field col s4">
                                                <select name="batch_no_5_[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                    <option value="">Select</option>
                                                    <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                            <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }}} else { 
                                       // for($i=0; $i<count($bar_details); $i++) { 
                                    ?>
                                        <div class="col s12" style="padding-bottom: 3px;">
                                            <div class="input-field col s4">
                                                 Choco Peanut Butter Bar 
                                            </div>
                                            <input type="hidden"  class="Choco" name="bar[]" id="Choco_<?php echo $i;?>"  value="12" >
                                            <div class="input-field col s4">
                                                <input type="text" name="qty[]" id="qty_5_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                            </div>
                                          
                                            <div class="input-field col s4">
                                                <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                    <option value="">Select</option>
                                                    <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                            <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                     
                                    </div>
                                    <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-5">+</button></div>
                                </div><hr>
                                
                                <div class="ava_qty6">
                                        <div class="row" id="bar_details6">
                                        <div class="col s12 ">  <h5>    Mango Bar </h5> </div>
                                        <?php $i=0; if(isset($stock_details)) { 
                                            for($i=0; $i<count($stock_details); $i++) { 
                                                if($stock_details[$i]->item_id=='6'){
                                        ?>
                                            <div class="col s12 " style="padding-bottom: 3px;">
                                                <div class="input-field col s4">
                                                
                                                     Mango Bar
                                            
                                                <input type="hidden"  class="mango" name="bar[]" id="Mango_<?php echo $i;?>"  value="6" >
                                                </div>
                                                   
                                                <div class="input-field col s4">
                                                    <input type="text" name="qty[]" id="qty_6_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                                </div>
                                               
                                                <div class="input-field col s4">
                                                    <select name="batch_no_6_[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php }}} else { 
                                           // for($i=0; $i<count($bar_details); $i++) { 
                                        ?>
                                            <div class="col s12" style="padding-bottom: 3px;">
                                                <div class="input-field col s4">
                                                     Mango Bar 
                                                </div>
                                                <input type="hidden"  class="mango" name="bar[]" id="Mango_<?php echo $i;?>"  value="6" >
                                                <div class="input-field col s4">
                                                    <input type="text" name="qty[]" id="qty_6_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                                </div>
                                              
                                                <div class="input-field col s4">
                                                    <select name="batch_no[]" id="batch_no_<?php echo $i;?>" class="browser-default">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>
                         
                                        </div>
                                        <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-6">+</button></div>
                                </div><hr>

                                <div class="ava_qty4">
                                        <div class="row" id="bar_details4">
                                        <div class="col s12 ">  <h5>     Berry Blast Bar  </h5> </div>
                                           <?php $i=0; if(isset($stock_details)) { 
                                                for($i=0; $i<count($stock_details); $i++) {
                                                if($stock_details[$i]->item_id=='9'){
                                        ?>
                                            <div class="col s12 " style="padding-bottom: 3px;">
                                                <div class="input-field col s4">
                                                
                                                     Berry Blast Bar 
                                            
                                                <input type="hidden" class="berry" name="bar[]" id="berry_<?php echo $i;?>"  value="9" >
                                                </div>
                                                
                                                <div class="input-field col s4">
                                                    <input type="text" name="qty[]" id="qty_9_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                                </div>
                                               
                                                <div class="input-field col s4">
                                                    <select name="batch_no[]" id="batch_no_9_<?php echo $i;?>" class="browser-default">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                           <?php }}} else { 
                                           // for($i=0; $i<count($bar_details); $i++) { 
                                        ?>
                                            <div class="col s12" style="padding-bottom: 3px;">
                                                <div class="input-field col s4">
                                                     Berry Blast Bar 
                                                </div>
                                                <input type="hidden" class="berry" name="bar[]" id="berry_<?php echo $i;?>"  value="9" >
                                                <div class="input-field col s4">
                                                     <input type="text" name="qty[]" id="qty_9_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                                </div>
                                              
                                                <div class="input-field col s4">
                                                    <select name="batch_no[]" id="batch_no_9_<?php echo $i;?>" class="browser-default">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>
                         
                                        </div>
                                        <div class="form-group"><button type="button" class=" button shadow btn_color" id="repeat-bar-9">+</button></div>
                                </div><hr>
                                
                                <div class="ava_qty5">
                                        <div class="row" id="bar_detail5">
                                        <div class="col s12 ">  <h5>     Chywanprash Bar  </h5> </div>
                                        <?php $i=0; if(isset($stock_details)) { 
                                                for($i=0; $i<count($stock_details); $i++) { 
                                                if($stock_details[$i]->item_id=='10'){
                                        ?>
                                            <div class="col s12 " style="padding-bottom: 3px;">
                                                <div class="input-field col s4">
                                                
                                                  Chywanprash Bar
                                            
                                                <input type="hidden" class="chywanprash" name="bar[]" id="chywanprash_<?php echo $i;?>"  value="9" >
                                                </div>
                                                
                                                <div class="input-field col s4">
                                                    <input type="text" name="qty[]" id="qty_10_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                                </div>
                                               
                                                <div class="input-field col s4">
                                                    <select name="batch_no[]" id="batch_no_10_<?php echo $i;?>" class="browser-default">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php }}} else { 
                                           // for($i=0; $i<count($bar_details); $i++) { 
                                        ?>
                                            <div class="col s12" style="padding-bottom: 3px;">
                                                <div class="input-field col s4">
                                                  Chywanprash Bar 
                                                </div>
                                                <input type="hidden" class="chywanprash" name="bar[]" id="chywanprash_<?php echo $i;?>"  value="10" >
                                                <div class="input-field col s4">
                                                    <input type="text" name="qty[]" id="qty_10_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                                </div>
                                              
                                                <div class="input-field col s4">
                                                    <select name="batch_no[]" id="batch_no_10_<?php echo $i;?>" class="browser-default">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>
                         
                                        </div>
                                        <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-10">+</button></div>
                                </div><hr>

                                <div class="ava_qty01">
                                      <div class="row" id="bar_details7">
                                        <div class="col s12 ">  <h5>    Variety Box </h5> </div>
                                        <?php $i=0; if(isset($stock_details)) { 
                                            for($i=0; $i<count($stock_details); $i++) {
                                            /*echo '<br>'.$stock_details[$i]->item_id;*/
                                            if($stock_details[$i]->item_id=='17'){
                                            
                                        ?>
                                            <div class="col s12 " style="padding-bottom: 3px;">
                                                <div class="input-field col s4">
                                                
                                                     Variety Box
                                            
                                                <input type="hidden" class="variety" name="bar[]" id="variety_<?php echo $i;?>"  value="99" >
                                                </div>
                                                
                                                <div class="input-field col s4">
                                                    <input type="text" name="qty[]" id="qty_01_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                                </div>
                                               
                                                <div class="input-field col s4">
                                                    <select name="batch_no[]" id="batch_no_9_<?php echo $i;?>" class="browser-default">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php }}} else { 
                                           // for($i=0; $i<count($bar_details); $i++) { 
                                        ?>
                                            <div class="col s12" style="padding-bottom: 3px;">
                                                <div class="input-field col s4">
                                                     Variety Box
                                                </div>
                                                <input type="hidden" class="variety" name="bar[]" id="variety_<?php echo $i;?>"  value="17" >
                                                <div class="input-field col s4">
                                                    <input type="text" name="qty[]" id="qty_01_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                                </div>
                                              
                                                <div class="input-field col s4">
                                                    <select name="batch_no[]" id="batch_no_9_<?php echo $i;?>" class="browser-default">
                                                        <option value="">Select</option>
                                                        <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                                <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>
                         
                                       </div>
                                        <div class="form-group"><button type="button" class=" button shadow btn_color" id="repeat-bar-variety">+</button></div>
                                </div><hr>

                                <div class="ava_qty2">
                                    <div class="row" id="bar_details2">
                                      <div class="col s12 ">    <h5>  Bambaiya Chaat Bar </h5> </div>
                                        <?php $i=0; if(isset($stock_details)) { 
                                                for($i=0; $i<count($stock_details); $i++) { 
                                                if($stock_details[$i]->item_id=='4'){
                                        ?>
                                        <div class="col s12 " style="padding-bottom: 3px;">
                                            <div class="input-field col s4">
                                            
                                                 Bambaiya Chaat Bar 
                                        
                                            <input type="hidden" class="bchaat" name="bar[]" id="bchaat_<?php echo $i;?>"  value="4" >
                                            </div>
                                             
                                            <div class="input-field col s4">
                                                <input type="text" name="qty[]" id="qty_4_<?php echo $i;?>"  value="<?php echo $stock_details[$i]->qty;?>" placeholder="Available Stock" />
                                            </div>
                                           
                                            <div class="input-field col s4">
                                                <select name="batch_no[]" id="batch_no_4_<?php echo $i;?>" class="browser-default">
                                                    <option value="">Select</option>
                                                    <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                            <option value="<?php echo $batch[$k]->id; ?>" <?php if($batch[$k]->id==$stock_details[$i]->batch_no) { echo 'selected'; } ?>><?php echo $batch[$k]->batch_no; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php }}} else { 
                                            //for($i=0; $i<count($bar_details); $i++) { 
                                        ?>
                                        <div class="col s12" style="padding-bottom: 3px;">
                                            <div class="input-field col s4">
                                                   Bambaiya Chaat Bar 
                                            </div>
                                            <input type="hidden" class="bchaat" name="bar[]" id="bchaat_<?php echo $i;?>"  value="4" >
                                            <div class="input-field col s4">
                                                <input type="text" name="qty[]" id="qty_4_<?php echo $i;?>" class="" value="" placeholder="Available Stock" />
                                            </div>
                                          
                                            <div class="input-field col s4">
                                                <select name="batch_no[]" id="batch_no_4_<?php echo $i;?>" class="browser-default">
                                                    <option value="">Select</option>
                                                    <?php if(isset($batch)) { for ($k=0; $k < count($batch) ; $k++) { ?>
                                                            <option value="<?php echo $batch[$k]->id; ?>"><?php echo $batch[$k]->batch_no; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        </div>
                                        <div class="form-group"><button type="button" class="button shadow btn_color" id="repeat-bar-4">+</button></div>
                                </div><hr>
									
									
							
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											
                                            <div style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
                                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">Status <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <select class="form-control" name="status">
                                                        <option value="Approved" <?php if(isset($data)) {if ($data[0]->status=='Approved') echo 'selected';}?>>Active</option>
                                                        <option value="InActive" <?php if(isset($data)) {if ($data[0]->status=='InActive') echo 'selected';}?>>InActive</option>
                                                    </select>
                                                </div>
                                            </div>
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
								<br clear="all"/>
								</div>
								</div>
								
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/mt_stock" class="btn btn-danger" type="reset" id="reset">Cancel</a>
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
				 <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

		  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&libraries=places&callback=initAutocomplete" async defer></script>
		 
<script type='text/javascript'>


 
    // City change
    $('#type_id').change(function(){
      var type_id = $(this).val();
		//console.log(reporting_manager_id);
      // AJAX request
      $.ajax({
        url:'<?=base_url()?>index.php/mt_stock/get_zone',
        method: 'post',
        data: {type_id: type_id},
        dataType: 'json',
        success: function(response){

 
          $('#zone_id').find('option').not(':first').remove();
      

          // Add options
		  // response = $.parseJSON(response);
		  console.log(response);
          $.each(response,function(index,data){
             $('#zone_id').append('<option value="'+data['id']+'">'+data['zone']+'</option>');
        
          });
        }
     });
   });
    </script>
   <script type="text/javascript">
		
           var placeSearch, autocomplete;
           var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name'
           };
        function initAutocomplete() {
                  // Create the autocomplete object, restricting the search to geographical
                  // location types.
                  autocomplete = new google.maps.places.Autocomplete(
                     (document.getElementById('google_address')),
                     {types: ['geocode']});
                   google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    //document.getElementById('google_address').value = place.name;
                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();
                    //alert("This function is working!");
                    //alert(place.name);
                   // alert(place.address_components[0].long_name);

                });
                  // When the user selects an address from the dropdown, populate the address
                  // fields in the form.
                  //autocomplete.addListener('place_changed', fillInAddress);
           }

                
                function geolocate() {
                  if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                      var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                      };
                      var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                      });
                      autocomplete.setBounds(circle.getBounds());
                       
                    });
                    
                  }
                }
				
				
				
	</script>			
		







 

    <!-- END SCRIPTS -->      
    </body>
</html>