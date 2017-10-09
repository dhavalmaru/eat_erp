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
                   <div class="heading-h3-heading">	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Purchase Order List  </div>	 
					 
					  <div class="heading-h3-heading">
					  <div class="pull-right btn-margin">	
								<?php $this->load->view('templates/download');?>	
								</div>	
                    	<div class="pull-right btn-margin  btn-bottom "  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
									<a class="btn btn-success btn-block btn-padding" href="<?php echo base_url() . 'index.php/purchase_order/add'; ?>">
										<span class="fa fa-plus"></span> Add Purchase Order Entry
									</a>
									
									
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
							       <table id="customers2" class="table datatable table-bordered" >
									<thead>
										<tr>
											<th width="65"  style="text-align:center;"  >Sr. No.</th>
											<th width="95">Order Date</th>
											<th width=" ">Vendor Name</th>
											<th width=" ">Depot Name</th>
											<th width="120 ">Amount (In Rs)</th>
											<th width="110 ">Creation Date</th>
											<th width=" 100" style="text-align:center;">View Order</th>
											<th width="130" style="text-align:center;">Payment Details</th>
											<th width="100" style="text-align:center;">Send Email</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($data); $i++) { ?>
										<tr>
											<td  style="text-align:center;"><?php echo $i+1; ?></td>
											<td><a href="<?php echo base_url().'index.php/purchase_order/edit/'.$data[$i]->id; ?>"><?php echo (($data[$i]->order_date!=null && $data[$i]->order_date!='')?date('d/m/Y',strtotime($data[$i]->order_date)):''); ?></a></td>
											<td><?php echo $data[$i]->vendor_name; ?></td>
											<td><?php echo $data[$i]->depot_name; ?></td>
											<td><?php echo format_money($data[$i]->amount,2); ?></td>
											<td><?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?></td>
											<td style="text-align:center;vertical-align: middle;"><?php if ($data[$i]->id!=null) { ?><a href="<?php echo base_url().'index.php/purchase_order/view_purchase_order/'.$data[$i]->id; ?>" target="_blank"> <span class="fa fa-file-pdf-o"></span></a><?php } ?></td>
											<td style="text-align:center; vertical-align: middle;"><a href="<?php echo base_url().'index.php/purchase_order/view_payment_details/'.$data[$i]->id; ?>"><span class="fa fa-eye"  ></span></a></td>
											<td style="text-align:center; vertical-align: middle;"><a href="<?php echo base_url().'index.php/purchase_order/send_email/'.$data[$i]->id; ?>"><span class="fa fa-paper-plane-o"></span></a></td>
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