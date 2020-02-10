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
.fa-eye  { font-size:21px; color:#333;}
.fa-file-pdf-o{ color:#e80b0b; font-size:21px;}
.fa-paper-plane-o{ color:#520fbb; font-size:21px;}
@media only screen and (min-width:495px) and (max-width:717px) {.btn-bottom { margin-top:5px;}}
</style>		
    </head>
    <body>								
             <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
			   <?php $this->load->view('templates/menus');?>
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                   <div class="heading-h3"> 
                   <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Product Expired List  </div>	 
					 
					  <div class="heading-h3-heading">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                    	<div class="pull-right btn-margin  btn-bottom "  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<!-- <a class="btn btn-success btn-block btn-padding" href="<?php //echo base_url() . 'index.php/purchase_order/add'; ?>">
										<span class="fa fa-plus"></span> Add Product Expired Entry
									</a> -->
									
									
								</div>
								
								
				</div>	      
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
                                                <th width="65" align="center" style="<?php if($status!='pending_for_delivery' && $status!='gp_issued' && $status!='pending_for_approval') echo 'display: none;'; ?>">Select</th>
                                                <th width="65" align="center">Sr. No.</th>
                                                <th width="156">Date Of processing</th>
                                                
												<th width="105" style="text-align:center; <?php if($status=='pending_for_delivery') echo 'display: none;'; ?>">View Invoice</th>
												<th width="130">Invoice No</th>
												<th width="130">Voucher No</th>
												<th width="140">Depot Name</th>
												<th width="140">Distributor Name</th>
                                                <th width="140">Location</th>
												<th width="220" >Sales Representative Name</th>
												<th width="120" >Amount (In Rs)</th>
												<th width="110" >Creation Date</th>
												<th width="110" >Status</th>
											
                                                <th width="105" style="text-align:center; <?php if($status!='gp_issued') echo 'display: none;'; ?>">View GP</th>
												<th width="50" style="display:none;">Resend Invoice</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0; $i < count($data); $i++) { ?>
											<tr>
												<td style="text-align:center; <?php if($status!='pending_for_delivery' && $status!='gp_issued' && $status!='pending_for_approval') echo 'display: none;'; ?>">
                                                    <input type="checkbox" id="check_<?php echo $i; ?>" class="check icheckbox" name="check_val[]" value="<?php echo $data[$i]->id; ?>" />
                                                    <input type="hidden" id="input_check_<?php echo $i; ?>" name="check[]" value="false" />
                                                </td>
                                                <td  style="text-align:center;"><?php echo $i+1; ?></td>
												<td>
                                                    <span style="display:none;">
                                                        <?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('Ymd',strtotime($data[$i]->date_of_processing)):''); ?>
                                                    </span>
                                                    <?php if($status=='pending_for_delivery' || $status=='gp_issued' || $status=='pending_for_approval') { ?>
                                                        <?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?>
                                                    <?php } else { ?>
                                                      <?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?>
                                                    <?php } ?>
                                                </td>
										
                                                <td style="text-align:center; vertical-align: middle; <?php if($status=='pending_for_delivery') echo 'display: none;'; ?>"><?php //if (($data[$i]->invoice_no!=null && $data[$i]->invoice_no!='') || ($data[$i]->voucher_no!=null && $data[$i]->voucher_no!='')) { ?><a href="<?php if(strtotime($data[$i]->date_of_processing)<strtotime('2017-07-01')) echo base_url().'index.php/distributor_out/view_tax_invoice_old/'.$data[$i]->id; else echo base_url().'index.php/distributor_out/view_tax_invoice/'.$data[$i]->id; ?>" target="_blank">  <span class="fa fa-file-pdf-o"></span></a><?php //} ?></td>
												<td>
                                                    <span style="display:none;">
                                                        <?php if(isset($data[$i]->invoice_no)) echo str_pad(substr($data[$i]->invoice_no, strrpos($data[$i]->invoice_no, "/")+1),10,"0",STR_PAD_LEFT); ?>
                                                    </span>
                                                    <?php echo $data[$i]->invoice_no; ?>
                                                </td>
                                                <td>
                                                    <span style="display:none;">
                                                        <?php if(isset($data[$i]->voucher_no)) echo str_pad(substr($data[$i]->voucher_no, strrpos($data[$i]->voucher_no, "/")+1),10,"0",STR_PAD_LEFT); ?>
                                                    </span>
                                                    <?php echo $data[$i]->voucher_no; ?>
                                                </td>
												<td><?php echo $data[$i]->depot_name; ?></td>
												<!-- <td><?php //echo ((strtoupper(trim($data[$i]->distributor_name))=='DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='AMAZON DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='EAT ANYTIME DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='SHOPCLUES DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='NYKAA DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='HEALTHIFYME WELLNESS PRIVATE LIMITED' || strtoupper(trim($data[$i]->distributor_name))=='1MG TECHNOLOGIES PRIVATE LIMITED' || strtoupper(trim($data[$i]->distributor_name))=='PAYTM DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='UNFACTORY DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='EMBRACE DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='NEULIFE DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='FLIPKART DIRECT' || strtoupper(trim($data[$i]->distributor_name))=='GOQII DIRECT')? $data[$i]->distributor_name . '-' . $data[$i]->client_name : $data[$i]->distributor_name); ?></td> -->
                                                <td><?php echo ((strtoupper(trim($data[$i]->class))=='DIRECT')? $data[$i]->distributor_name . '-' . $data[$i]->client_name : $data[$i]->distributor_name); ?></td>
                                                <td><?php echo $data[$i]->location; ?></td>
												<td><?php echo $data[$i]->sales_rep_name; ?></td>
												<td><?php echo format_money($data[$i]->final_amount,2); ?></td>
												<td><?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>
												<td><?php echo $data[$i]->status; ?></td>
                                                <!-- <td style="text-align:center; vertical-align: middle; <?php //if($status=='pending_for_delivery') echo 'display: none;'; ?>"><?php //if (($data[$i]->invoice_no!=null && $data[$i]->invoice_no!='') || ($data[$i]->voucher_no!=null && $data[$i]->voucher_no!='')) { ?><a href="<?php //if(strtotime($data[$i]->date_of_processing)<strtotime('2017-07-01')) echo base_url().'index.php/distributor_out/view_tax_invoice_old/'.$data[$i]->id; else echo base_url().'index.php/distributor_out/view_tax_invoice/'.$data[$i]->id; ?>" target="_blank">  <span class="fa fa-file-pdf-o"></span></a><?php //} ?></td> -->
                                                
                                                <td style="text-align:center; vertical-align: middle; <?php if($status!='gp_issued') echo 'display: none;'; ?>"><a href="<?php if(strtotime($data[$i]->date_of_processing)<strtotime('2017-07-01')) echo base_url().'index.php/distributor_out/view_gate_pass_old/'.$data[$i]->id; else echo base_url().'index.php/distributor_out/view_gate_pass/'.$data[$i]->id; ?>" target="_blank">  <span class="fa fa-file-pdf-o"></span></a></td>
												<td style="text-align:center; vertical-align: middle; display:none;"><a href="<?php //echo base_url().'index.php/distributor_out/view_payment_details/'.$data[$i]->id; ?>#"><span class="fa fa-eye">Resend Invoice</span></a></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
                           </div>
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
		
    <!-- END SCRIPTS -->      
    </body>
</html>