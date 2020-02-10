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
            input[type=radio], input[type=checkbox] { margin: 8px 0px 0px;      vertical-align: text-bottom;}
            th{text-align:center;}
            .center{text-align:center;}
            input[readonly], input[disabled], select[disabled], textarea[disabled] {
                background-color: white !important; 
                color: #0b385f !important; 
                cursor: not-allowed !important;
            }
            @media screen and (max-width:800px) {   
                .h-scroll { overflow-x:scroll;} .h-scroll .table-stripped{ width:806px!important;}
            }
            .batch_no_details tbody tr td {
                padding: 1px;
            }
        </style>
    </head>
    <body>                              
         <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <?php $this->load->view('templates/menus');?>
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sample_out'; ?>" >Sample List </a>  &nbsp; &#10095; &nbsp; Sample Details</div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">
                    <div class="box-shadow">
                        <form id="form_distributor_out_sku_details" role="form" class="form-horizontal" method="post" action="<?php echo base_url().'index.php/sample_out/set_sku_batch'; ?>">
                            <div class="box-shadow-inside">
                                <div class="col-md-12 custom-padding" style="padding:0;" >
                                <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group" >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="col-md-2 col-sm-2 col-xs-12 control-label">Delivery Person <span class="asterisk_sign">*</span> </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select name="sales_rep_id" id="sales_rep_id" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if(isset($sales_rep1)) { for ($k=0; $k < count($sales_rep1) ; $k++) { ?>
                                                            <option value="<?php echo $sales_rep1[$k]->id; ?>"><?php echo $sales_rep1[$k]->sales_rep_name;?></option>
                                                    <?php }} ?>
                                                </select>
                                                <input type="hidden" name="delivery_status" id="delivery_status" value="GP Issued" />
                                                <input type="hidden" name="distributor_out_id" id="distributor_out_id" value="<?php echo $distributor_out_id; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="control-label" style="display: none;">Status <span class="asterisk_sign">*</span></label>
                                            <div class="">
                                                <select name="status" id="status" class="form-control" style="display: none;">
                                                    <!-- <option value="Pending">Active</option> -->
                                                    <option value="Approved">Active</option>
                                                    <option value="InActive">InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-stripped form-group" style="padding:15px;">

                                            <?php //dump($batch_details); ?>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="65" align="center">Sr. No.</th>
                                                        <th width="156" style="display:none;">Date Of processing</th>
                                                        <th width="140" style="display:none;">Depot Name</th>
                                                        <th width="200">Distributor Name</th>
                                                        <th width="140">Location</th>
                                                        <th width="220" style="display:none;">Sales Representative Name</th>
                                                        <th width="200">Item Name</th>
                                                        <th width="120">Qty</th>
                                                        <th width="120" style="display:none;">Rate (In Rs)</th>
                                                        <th width="120" style="display:none;">Sell Rate (In Rs)</th>
                                                        <th width="120" style="display:none;">Amount (In Rs)</th>
                                                        <th width="110" style="display:none;">Creation Date</th>
                                                        <th style="width: 200px">Batch</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $voucher_no = '';
                                                        $previous_voucher_no = '';
                                                        $j=1;
                                                        for($i=0;$i<count($data);$i++) {
                                                            $voucher_no = $data[$i]->voucher_no;

                                                            if($voucher_no!=$previous_voucher_no){ 
                                                                echo '<tr class="batch_no">
                                                                        <td colspan="13" style="font-size: larger;">
                                                                            Voucher - '.$data[$i]->voucher_no.'
                                                                        </td>
                                                                    </tr>';
                                                    
                                                                $previous_voucher_no = $data[$i]->voucher_no;
                                                                $j=1;
                                                            }
                                                    ?>
                                                        <tr class="batch_no">
                                                            <td>
                                                                <input type="hidden" id="sales_id_<?php echo $i; ?>" name="sales_id[]" value="<?php echo $data[$i]->id; ?>" />
                                                                <input type="hidden" id="sales_ref_id_<?php echo $i; ?>" name="sales_ref_id[]" value="<?php echo $data[$i]->ref_id; ?>" />
                                                                <input type="hidden" id="sales_item_id_<?php echo $i; ?>" name="sales_item_id[]" value="<?php echo $data[$i]->sales_item_id; ?>" />
                                                                <input type="hidden" id="item_type_<?php echo $i; ?>" value="<?php echo $data[$i]->type; ?>" />
                                                                <input type="hidden" id="item_id_<?php echo $i; ?>" value="<?php echo $data[$i]->item_id; ?>" />
                                                                <input type="hidden" id="item_qty_<?php echo $i; ?>" class="item_qty" value="<?php echo $data[$i]->qty; ?>" />
                                                                <input type="hidden" id="item_depot_<?php echo $i; ?>" value="<?php echo $data[$i]->depot_id; ?>" />
                                                                <?php echo ($j++); ?>
                                                            </td>
                                                            <td style="display:none;">
                                                                <?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?>
                                                            </td>
                                                            <td style="display:none;">
                                                                <?php echo $data[$i]->depot_name; ?>
                                                            </td>
                                                            <!-- <td>
                                                                <?php //echo ((strtoupper(trim($data[$i]->distributor_name))=='DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='AMAZON DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='NYKAA DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($data[$i]->distributor_name))=='1MG TECHNOLOGIES PRIVATE LIMITED' || strtoupper(trim($data[$i]->distributor_name))=='PAYTM DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='UNFACTORY DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='EMBRACE DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='NEULIFE DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='FLIPKART DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='GOQII DIRECT')? $data[$i]->distributor_name . '-' . $data[$i]->client_name : $data[$i]->distributor_name); ?>
                                                            </td> -->
                                                            <td>
                                                                <?php echo ((strtoupper(trim($data[$i]->class))=='DIRECT')? $data[$i]->distributor_name . '-' . $data[$i]->client_name : $data[$i]->distributor_name); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data[$i]->location; ?>
                                                            </td>
                                                            <td style="display:none;">
                                                                <?php echo $data[$i]->sales_rep_name; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo (($data[$i]->type=='Bar')?str_replace(",", "", $data[$i]->product_name):str_replace(",", "", $data[$i]->box_name)); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $data[$i]->qty; ?>
                                                            </td>
                                                            <td style="display:none;">
                                                                <?php echo $data[$i]->rate; ?>
                                                            </td>
                                                            <td style="display:none;">
                                                                <?php echo round($data[$i]->sell_rate,2); ?>
                                                            </td>
                                                            <td style="display:none;">
                                                                <?php echo round($data[$i]->item_amt,2); ?>
                                                            </td>
                                                            <td style="display:none;">
                                                                <?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?>
                                                            </td>
                                                            <td class="batch_no_class">
                                                                <table class="batch_no_details">
                                                                    <tbody id="batch_no_<?php echo $i; ?>">
                                                                        <tr id="batch_no_<?php echo $i; ?>_0_row">
                                                                            <td><input type="text" id="batch_no_qty_<?php echo $i; ?>_0" class="form-control batch_no_qty" name="batch_no_qty_<?php echo $i; ?>[]" placeholder="Qty" /></td>
                                                                            <td>
                                                                                <select id="batch_no_no_<?php echo $i; ?>_0" class="form-control batch_no_no" name="batch_no_no_<?php echo $i; ?>[]" style="width: 100px;">
                                                                                    <option value="">Select</option>
                                                                                    <?php for($k=0;$k<count($batch_details);$k++){ ?>
                                                                                        <option value="<?php echo $batch_details[$k]->id; ?>"><?php echo $batch_details[$k]->batch_no; ?></option>';
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-default pull-left" id="btn_batch_no_no_<?php echo $i; ?>_0" style="width: 75px;" onClick="set_batch(this);">Copy</button>
                                                                            </td>
                                                                            <td style="text-align:center; vertical-align: middle;">
                                                                                <!-- <a id="batch_no_<?php //echo $i; ?>_0_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"  ></span></a> -->
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td style="padding-left: 1px;"><button type="button" class="btn btn-success" id="repeat_batch_no_<?php echo $i; ?>" onClick="repeat_batch(this);">+</button></td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                                <!-- <div style="display: flex;">
                                                                    <input type="text" name="qty[]" style="width: 75px;">&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <select name="batch_no[]" class="form-control" style="width: 100px;">
                                                                        <option value="">Select</option>
                                                                        <?php //for($k=0;$k<count($batch_details);$k++){ ?>
                                                                            <option value="<?php //echo $batch_details[$k]->id; ?>"><?php //echo $batch_details[$k]->batch_no; ?></option>';
                                                                        <?php //} ?>
                                                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <button type="button" class="btn btn-default pull-left" id="button_'.$k.'" style="width: 75px;" onClick="set_batch(this);">Copy</button>
                                                                </div> -->
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <a href="<?php echo base_url(); ?>index.php/sample_out" class="btn btn-danger pull-right" type="reset" id="reset">Cancel</a>
                                    <button type="submit" id="btn_save" class="btn btn-success pull-right" style="margin-right: 5px;">Save</button>
                                </div>
                                </div>
                                </div>
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
        <script>
            $(document).ready(function(){
                // addMultiInputNamingRules('#form_distributor_out_sku_details', '.batch_no_qty', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_out_sku_details', '.batch_no_no', { required: true }, "");

                // addMultiInputNamingRules('#form_distributor_out_sku_details', 'input[name="batch_no_qty_0[]"]', { required: true }, "");
                // addMultiInputNamingRules('#form_distributor_out_sku_details', 'input[name="batch_no_no_0[]"]', { required: true }, "");
            });

            var set_batch = function(elem){
                var id = elem.id;
                
                // console.log(id);

                var batch_no_id = id.substr(id.indexOf('_')+1);
                var sub_str = id.substr(1, id.lastIndexOf('_')-1);
                var index = sub_str.substr(sub_str.lastIndexOf('_')+1);

                // console.log(index);

                var batch_no = $('#'+batch_no_id).val();
                var item_type = $('#item_type_'+index).val();
                var item_id = $('#item_id_'+index).val();

                var counter = $('.batch_no_no').length;

                // console.log(batch_no);
                // console.log(counter);

                var check_item_type = '';
                var check_item_id = '';

                for(var i=0; i<counter; i++){
                    if(i!=index){
                        check_item_type = $('#item_type_'+i).val();
                        check_item_id = $('#item_id_'+i).val();

                        if(check_item_type==item_type && check_item_id==item_id){
                            var counter2 = $('#batch_no_no_'+index+' tr').length;
                            for(var j=0; j<counter; j++){
                                $('#batch_no_no_'+i+'_'+j).val(batch_no);
                            }
                        }
                    }
                }
            }

            var repeat_batch = function(elem){
                var id = elem.id;
                var index = id.substr(id.lastIndexOf('_')+1);
                var counter = $('#batch_no_'+index+' tr').length;

                var newRow = jQuery('<tr id="batch_no_'+index+'_'+counter+'_row">' + 
                                        '<td><input type="text" id="batch_no_qty_'+index+'_'+counter+'" class="form-control batch_no_qty" name="batch_no_qty_'+index+'[]" placeholder="Qty" /></td>' + 
                                        '<td>' + 
                                            '<select id="batch_no_no_'+index+'_'+counter+'" class="form-control batch_no_no" name="batch_no_no_'+index+'[]" style="width: 100px;">' + 
                                                '<option value="">Select</option>' + 
                                                '<?php for($k=0;$k<count($batch_details);$k++){ ?>' + 
                                                '<option value="<?php echo $batch_details[$k]->id; ?>"><?php echo $batch_details[$k]->batch_no; ?></option>' + 
                                                '<?php } ?>' + 
                                            '</select>' + 
                                        '</td>' + 
                                        '<td>' + 
                                            '<button type="button" class="btn btn-default pull-left" id="btn_batch_no_no_'+index+'_'+counter+'" style="width: 75px;" onClick="set_batch(this);">Copy</button>' + 
                                        '</td>' + 
                                        '<td style="text-align:center; vertical-align: middle;">' + 
                                            '<a id="batch_no_'+index+'_'+counter+'_row_delete" class="delete_row" href="#"><span class="fa trash fa-trash-o"></span></a>' + 
                                        '</td>' + 
                                    '</tr>');
                $('#batch_no_'+index).append(newRow);
                $('.delete_row').click(function(event){
                    delete_row($(this));
                });
            }
        </script>
    </body>
</html>