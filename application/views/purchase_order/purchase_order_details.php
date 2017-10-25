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
		<script>
		function get_rate(str,str1)
		{
			//alert(str+"  "+str1);
			//raw_material_0
			var cntr=str1.substr(13);
			//alert(cntr);
		var rm_id=str;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               //alert(xmlhttp.responseText);//
				document.getElementById("rate_"+cntr).value = xmlhttp.responseText;
				get_hsn(rm_id,cntr);
            }
        };
        xmlhttp.open("GET","<?php echo base_url().'index.php/Purchase_order/get_rate/'; ?>"+rm_id,true);
        xmlhttp.send();
		
		}
		
		function get_hsn(item_id,counter)
		{
			var str,str1;
			
			str=item_id;
			//alert(str+"  "+str1);
			//raw_material_0
			var cntr=counter;
			//alert(cntr);
		var rm_id=str;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               // alert(xmlhttp.responseText);//
				document.getElementById("hsn_"+cntr).value = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","<?php echo base_url().'index.php/Purchase_order/get_hsn/'; ?>"+rm_id,true);
        xmlhttp.send();
		}
		
		function get_hsn_rate(str,str1)
		{
			
			var valid=document.getElementById("v_state").value;
			if(valid=="")
			{
				alert("Please select vendor first.");
			}
			else if(valid=="state_not_found")
			{
				alert("Please select vendor first.");
			}
			else
			{
				get_rate(str,str1);
				get_hsn(str,str1);
			}
		}
		</script>
		<style>
 
            input[readonly] {background-color: white !important; 
                            color: #0b385f !important; 
                            cursor: not-allowed !important;}
		</style>
		
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/purchase_order'; ?>" > Purchase Order List </a>  &nbsp; &#10095; &nbsp; Purchase Order Details</div>
                
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
					    <div class="main-container">           
                         <div class="box-shadow">
							
                            <form id="form_purchase_order_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($data)) echo base_url(). 'index.php/purchase_order/update/' . $data[0]->id; else echo base_url().'index.php/purchase_order/save'; ?>">
                              <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                 <div class="panel panel-default">
							     	<div class="panel-body">
									<div class="form-group"  >
										<div class="col-md-12 col-sm-12 col-xs-12">
											<label class="col-md-2 col-sm-2 col-xs-12 control-label">Date <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php if(isset($data)) echo $data[0]->id;?>"/>
                                                <input type="text" class="form-control datepicker1" name="order_date" id="order_date" placeholder="Date" value="<?php if(isset($data)) echo (($data[0]->order_date!=null && $data[0]->order_date!='')?date('d/m/Y',strtotime($data[0]->order_date)):''); else echo date('d/m/Y'); ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Vendor <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="vendor_id" id="vendor_id" class="form-control" onchange="get_vendor_state(this.value);">
                                                    <option value="00">Select</option>
                                                    <?php if(isset($vendor)) { for ($k=0; $k < count($vendor) ; $k++) { ?>
                                                            <option value="<?php echo $vendor[$k]->id; ?>" <?php if(isset($data)) { if($vendor[$k]->id==$data[0]->vendor_id) { echo 'selected'; } } ?>><?php echo $vendor[$k]->vendor_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                            
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Depot <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <select name="depot_id" id="depot_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($depot)) { for ($k=0; $k < count($depot) ; $k++) { ?>
                                                            <option value="<?php echo $depot[$k]->id; ?>" <?php if(isset($data)) { if($depot[$k]->id==$data[0]->depot_id) { echo 'selected'; } } ?>><?php echo $depot[$k]->depot_name; ?></option>
                                                    <?php }} ?>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
	                               <div class="h-scroll">	
                                       <div class="table-stripped form-group" style="padding:15px;" >
                                           <table class="table table-bordered" style="margin-bottom: 0px; ">
                                        <thead>
                                            <tr>
                                                <th  width="300" >Item <span class="asterisk_sign">*</span></th>
                                                <th width="180">Qty In Kg <span class="asterisk_sign">*</span></th>
												<th width="180">HSN Code </th>
                                                <th width="180">Rate  <span class="asterisk_sign">*</span></th>
                                                <th width="180">CGST <span class="asterisk_sign">*</span></th>
												<th width="180">SGST  <span class="asterisk_sign">*</span></th>
												<th width="180">IGST  <span class="asterisk_sign">*</span></th>
                                                <th width="180">Amount (In Rs) </th>
                                                <th style="width:60px; text-align:center;"> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody id="box_details">
                                        <?php $i=0; if(isset($purchase_order_items)) {
                                                for($i=0; $i<count($purchase_order_items); $i++) { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="raw_material[]" class="form-control raw_material" id="raw_material_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>"  onchange="get_hsn(this.value,this.id);get_rate(this.value,this.id);">
                                                        <option value="00">Select</option>
                                                        <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <option value="<?php echo $raw_material[$k]->id; ?>" <?php if($raw_material[$k]->id==$purchase_order_items[$i]->item_id) { echo 'selected'; } ?>><?php echo $raw_material[$k]->rm_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->qty; } ?>"onkeyup="start_tot();"/>
                                                </td>
											
												
												 <td>
                                                    <input type="text" class="form-control hsn" name="hsn[]" id="hsn_<?php echo $i; ?>" placeholder="HSN Code" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->hsn; } ?>" onkeyup="start_tot();"/>
                                                </td>
												
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->rate; } ?>"onkeyup="start_tot();"/>
                                                </td>
									
												
												
                                                <td>
                                                    <input type="text" class="form-control cst" name="cgst[]" id="cgst<?php echo $i; ?>" placeholder="CGST" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->cgst; } ?>"onkeyup="start_tot();"/>
                                                </td>
												<td>
                                                    <input type="text" class="form-control sgst" name="sgst[]" id="sgst<?php echo $i; ?>" placeholder="SGST" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->sgst; } ?>"onkeyup="start_tot();"/>
                                                </td>
												<td>
                                                    <input type="text" class="form-control igst" name="igst[]" id="igst<?php echo $i; ?>" placeholder="IGST" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->igst; } ?>"onkeyup="start_tot();"/>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="<?php if (isset($purchase_order_items)) { echo $purchase_order_items[$i]->amount; } ?>"onkeyup="start_tot();" readonly />
                                                </td>
                                                <td style="text-align:center;     vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
                                            </tr>
											
                                        <?php }} else { ?>
                                            <tr id="box_<?php echo $i; ?>_row">
                                                <td>
                                                    <select name="raw_material[]" class="form-control raw_material" id="raw_material_<?php echo $i;?>" data-error="#err_item_<?php echo $i;?>"  onchange="get_hsn(this.value,this.id);get_rate(this.value,this.id);">
													<!--get_hsn(this.value,this.id);-->
                                                        <option value="00">Select</option>
                                                        <?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>
                                                                <option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                    <div id="err_item_<?php echo $i;?>"></div>
                                                </td>
												
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty[]" id="qty_<?php echo $i; ?>" placeholder="Qty" value="" onkeyup="start_tot();"/>
                                                </td>
												
												<!--newly add-->
												<td>
                                                    <input type="text" class="form-control qty" name="hsn[]" id="hsn_<?php echo $i; ?>" placeholder="HSN Code" value="" onkeyup="start_tot();"/>
                                                </td>
												<!--newly add-->
                                                <td>
                                                    <input type="text" class="form-control rate" name="rate[]" id="rate_<?php echo $i; ?>" placeholder="Rate" value="" onkeyup="start_tot();"/>
                                                </td>
												
                                               <td> 
                                                <input type="text" class="form-control sgst" name="sgst[]" id="sgst_<?php echo $i; ?>" placeholder="SGST" value="" onkeyup="start_tot();"/> 
                                            </td>
											<td>
                                                <input type="text" class="form-control cgst" name="cgst[]" id="cgst_<?php echo $i; ?>" placeholder="CGST" value="" onkeyup="start_tot();"/>
                                            </td>
											<td>
                                                <input type="text" class="form-control igst" name="igst[]" id="igst_<?php echo $i; ?>" placeholder="IGST" value="" onkeyup="start_tot();"/>
                                            </td>
                                                <td>
                                                    <input type="text" class="form-control amount" name="amount[]" id="amount_<?php echo $i; ?>" placeholder="Amount" value="" readonly />
                                                </td>
                                                <td style="text-align:center;  vertical-align: middle;">
                                                    <a id="box_<?php echo $i; ?>_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>
                                                </td>
												
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8">
                                                    <button type="button" class="btn btn-success" id="repeat-box" style=" ">+</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        </table>
										<input type="hidden" name="v_state" id="v_state" value=""/>
                                    </div>
									</div>
									
									
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Delivery Date </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="delivery_date" id="delivery_date" placeholder="Delivery Date" value="<?php if(isset($data)) { echo (($data[0]->delivery_date!=null && $data[0]->delivery_date!='')?date('d/m/Y',strtotime($data[0]->delivery_date)):''); } ?>"/>
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Total Amount (In Rs) <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amount" value="<?php if (isset($data)) { echo $data[0]->amount; } ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Shipping Method </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="shipping_method" id="shipping_method" placeholder="Shipping Method" value="<?php if (isset($data)) { echo $data[0]->shipping_method; } ?>" />
                                            </div>
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Shipping Term </label>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <input type="text" class="form-control" name="shipping_term" id="shipping_term" placeholder="Shipping Term" value="<?php if(isset($data)) { echo $data[0]->shipping_term; } ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="<?php if(isset($data)) echo ''; else echo 'display: none;';?>">
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
									<a href="<?php echo base_url(); ?>index.php/purchase_order" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right" style="<?php if(isset($data[0]->id)) {if($access[0]->r_edit=='0') echo 'display: none;';} else if($access[0]->r_insert=='0' && $access[0]->r_edit=='0') echo 'display: none;'; ?>">Save</button>
                                </div>
							</form>
							
						
						</div>
						</div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript">
             function start_tot(){
				 // alert("ggggg");
				 var state=$('#v_state').val();
				
				// if(state=='Maharashtra')
				// {
					//alert(state);
                $(".qty").blur(function(){
					  // alert("ggggg");
                    get_amount($(this));
                });
                $(".rate").blur(function(){
					
                    get_amount($(this));
                });
				if(state=='Maharashtra')
				{
					$(".cgst").blur(function(){
                    get_amount($(this));
					});
					 $(".sgst").blur(function(){
                    get_amount($(this));
                });
				}
				else if(state!='Maharashtra')
				{
					$(".igst").blur(function(){
                    get_amount($(this));
					});
				}
				else
				{
					$(".igst").blur(function(){
                    get_amount($(this));
					});
				}
               
				
                $('.delete_row').click(function(event){
                    delete_row($(this));
                    get_total();
                });
                $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });

                addMultiInputNamingRules('#form_purchase_order_details', 'select[name="raw_material[]"]', { required: true }, "");
                addMultiInputNamingRules('#form_purchase_order_details', 'input[name="qty[]"]', { required: true, number: true }, "");
                addMultiInputNamingRules('#form_purchase_order_details', 'input[name="rate[]"]', { required: true, number: true }, "");
                addMultiInputNamingRules('#form_purchase_order_details', 'input[name="cgst[]"]', { required: true, number: true }, "");
				addMultiInputNamingRules('#form_purchase_order_details', 'input[name="sgst[]"]', { required: true, number: true }, "");
				addMultiInputNamingRules('#form_purchase_order_details', 'input[name="igst[]"]', { required: true, number: true }, "");
				// }
				// // else
				// {
					// // alert(state);
					
				// }
				
            };

            function get_amount(elem){
				 // alert("ggggg");
				var state=$('#v_state').val();
                var id = elem.attr('id');
				var cgst=0.00;
				
				var sgst=0.00;
				var igst=0.00;
				var amount =0.00;
                var index = id.substr(id.lastIndexOf('_')+1);
                var qty = parseFloat(get_number($("#qty_"+index).val(),2));
                var rate = parseFloat(get_number($("#rate_"+index).val(),2));
				if(state=='Maharashtra')
				{
					cgst=parseFloat(get_number($("#cgst_"+index).val(),2));
					sgst=parseFloat(get_number($("#sgst_"+index).val(),2));
					total_tax=sgst+cgst;
					total_tax=total_tax/100;
					amount = ((qty*rate)*total_tax);
					amount = (qty*rate)+amount;
					 // alert(""+amount);
				}
				else
				{
					igst=parseFloat(get_number($("#igst_"+index).val(),2));
					total_tax=igst/100;
					amount = ((qty*rate)*total_tax);
					amount = (qty*rate)+amount;
					// alert(""+amount);
				}
                // amount = (qty*rate)+cst;
                $("#amount_"+index).val(format_money(Math.round(amount*100)/100,2));

                get_total();
            }

            function get_total(){
                var total_amount = 0;
                $('.amount').each(function(){
                    amount = parseFloat(get_number($(this).val(),2));
                    if (isNaN(amount)) amount=0;
                    total_amount = total_amount + amount;
                });

                $("#total_amount").val(format_money(Math.round(total_amount*100)/100,2));
            }

            //function jqfunction(){
                
				
				//alert(state);
				
					//alert(state);
					//alert(state);
					
						$('#repeat-box').click(function(event){
							var state=document.getElementById("v_state").value;
						//alert(state);
						var counter = $('.raw_material').length;
				//alert(counter);
				var cg_state='Maharashtra';
						if(state==cg_state)
				{
                    event.preventDefault();
                    var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<select name="raw_material[]" class="form-control raw_material" id="raw_material_'+counter+'" data-error="#err_item_'+counter+'" style="" onchange="get_hsn(this.value,this.id);get_rate(this.value,this.id);">' + 
                                                    '<option value="00">Select</option>' + 
                                                    '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_item_'+counter+'"></div>' + 
                                            '</td>' + 
											'<td>' + 
                                                '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="" onkeyup="start_tot();"/> ' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control qty" name="hsn[]" id="hsn_'+counter+'" placeholder="HSN Code" value="" onkeyup="start_tot();"/>' + 
                                            '</td>'+ 
                                            
                                            '<td>' + 
                                                '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" onkeyup="start_tot();"/>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control sgst" name="sgst[]" id="sgst_'+counter+'" placeholder="SGST" value="5.00" onkeyup="start_tot();"/>' + 
                                            '</td>' +
											'<td>' + 
                                                '<input type="text" class="form-control cgst" name="cgst[]" id="cgst_'+counter+'" placeholder="CGST" value="5.00" onkeyup="start_tot();"/>' + 
                                            '</td>' + 
											'<td>' + 
											'<input type="text" class="form-control igst" name="igst[]" id="igst_'+counter+'" placeholder="IGST" value="0.00"/ readonly>' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />' + 
                                            '</td>' + 
                                             ' <td style="text-align:center;     vertical-align: middle;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details').append(newRow);
				}
				else if(state.length <= 0)
				{
					alert('Please select vendor first.');
				}
				else if(state=="state_not_found")
				{
					alert('Vendor state not available.');
				}
				else if(state!=cg_state)
				{
					var newRow = jQuery('<tr id="box_'+counter+'_row">' + 
                                            '<td>' + 
                                                '<select name="raw_material[]" class="form-control raw_material" id="raw_material_'+counter+'" data-error="#err_item_'+counter+'" style="" onchange="get_hsn(this.value,this.id);get_rate(this.value,this.id);">' + 
                                                    '<option value="00">Select</option>' + 
                                                    '<?php if(isset($raw_material)) { for ($k=0; $k < count($raw_material) ; $k++) { ?>' + 
                                                            '<option value="<?php echo $raw_material[$k]->id; ?>"><?php echo $raw_material[$k]->rm_name; ?></option>' + 
                                                    '<?php }} ?>' + 
                                                '</select>' + 
                                                '<div id="err_item_'+counter+'"></div>' + 
                                            '</td>' + 
                                           
                                            '<td>' + 
                                                '<input type="text" class="form-control qty" name="qty[]" id="qty_'+counter+'" placeholder="Qty" value="" onkeyup="start_tot();"/>' + 
                                            '</td>' + 
											 '<td>' + 
                                                '<input type="text" class="form-control qty" name="hsn[]" id="hsn_'+counter+'" placeholder="HSN Code" value="" onkeyup="start_tot();"/>' + 
                                            '</td>'+ 
                                            '<td>' + 
                                                '<input type="text" class="form-control rate" name="rate[]" id="rate_'+counter+'" placeholder="Rate" value="" onkeyup="start_tot();"/>' + 
                                            '</td>' + 
                                           
											'<td>' + 
                                                '<input type="text" class="form-control cgst" name="cgst[]" id="cgst_'+counter+'" placeholder="CGST" value="0.00"/ readonly>' + 
                                            '</td>' + 
											 '<td>' + 
                                                '<input type="text" class="form-control sgst" name="sgst[]" id="sgst_'+counter+'" placeholder="SGST" value="0.00"/ readonly>' + 
                                            '</td>' +
											'<td>' + 
											'<input type="text" class="form-control igst" name="igst[]" id="igst_'+counter+'" placeholder="IGST" value="5.00" onkeyup="start_tot();"/ >' + 
                                            '</td>' + 
                                            '<td>' + 
                                                '<input type="text" class="form-control amount" name="amount[]" id="amount_'+counter+'" placeholder="Amount" value="" readonly />' + 
                                            '</td>' + 
                                             ' <td style="text-align:center;     vertical-align: middle;">' + 
                                                '<a id="box_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a>' + 
                                            '</td>' + 
                                        '</tr>');
                    $('#box_details').append(newRow);
				}
				
				else
				{
					
				}
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $(".qty").blur(function(){
                    get_amount($(this));
                    });
                    $(".rate").blur(function(){
                        get_amount($(this));
                    });
                    $(".cst").blur(function(){
                        get_amount($(this));
                    });
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                        get_total();
                    });

                    removeMultiInputNamingRules('#form_purchase_order_details', 'select[alt="raw_material[]"]');
                    removeMultiInputNamingRules('#form_purchase_order_details', 'input[alt="qty[]"]');
                    removeMultiInputNamingRules('#form_purchase_order_details', 'input[alt="rate[]"]');
                    removeMultiInputNamingRules('#form_purchase_order_details', 'input[alt="cst[]"]');

                    addMultiInputNamingRules('#form_purchase_order_details', 'select[name="raw_material[]"]', { required: true }, "");
                    addMultiInputNamingRules('#form_purchase_order_details', 'input[name="qty[]"]', { required: true, number: true }, "");
                    addMultiInputNamingRules('#form_purchase_order_details', 'input[name="rate[]"]', { required: true, number: true }, "");
                    addMultiInputNamingRules('#form_purchase_order_details', 'input[name="cst[]"]', { required: true, number: true }, "");
                    counter++;
                     });
                
				
				
				
			
		 function get_vendor_state(vendor_id)
			{
				var counter = $('.raw_material').length;
				//alert(counter);
				var i=0;
					//alert(vendor_id);
				
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					// alert(xmlhttp.responseText);//
						document.getElementById("v_state").value = xmlhttp.responseText;
						//alert(document.getElementById("v_state").value);
						var state=xmlhttp.responseText;
						if(state=="Maharashtra")
						{
							for(i=0;i<counter;i++)
							{
							document.getElementById("igst_"+i).readOnly = true;
							document.getElementById("igst_"+i).value="0.00";
							document.getElementById("cgst_"+i).value="0.00";
							document.getElementById("sgst_"+i).value="0.00";
							document.getElementById("cgst_"+i).readOnly = false;
							document.getElementById("sgst_"+i).readOnly = false;
							document.getElementById("igst_"+i).value="0.00";
							document.getElementById("cgst_"+i).value="5.00";
							document.getElementById("sgst_"+i).value="5.00";
							
							}
						}
						else
						{
							for(i=0;i<counter;i++)
							{
							document.getElementById("igst_"+i).readOnly = false;
							document.getElementById("cgst_"+i).readOnly = true;
							document.getElementById("sgst_"+i).readOnly = true;
							
							document.getElementById("igst_"+i).value="5.00";
							document.getElementById("cgst_"+i).value="0.00";
							document.getElementById("sgst_"+i).value="0.00";
							
							}
						}
						
					}
				};
				xmlhttp.open("GET","<?php echo base_url().'index.php/Purchase_order/get_vendor_state/'; ?>"+vendor_id,true);
				xmlhttp.send();
						
			}
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>