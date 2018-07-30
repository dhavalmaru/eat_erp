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
	@media only screen and  (min-width:645px)  and (max-width:718px) { 
		.heading-h3-heading:first-child {     width: 44%!important;}
		.heading-h3-heading:last-child {     width: 56%!important;}		
		.heading-h3-heading .btn-margin{ margin-bottom:0px!important; }
	}
	@media only screen and  (min-width:709px)  and (max-width:718px) { 			 
		.heading-h3-heading .btn-margin{   }
	}
	</style>	
			<style>
.item-job-list {
    font-family: 'Cabin';
    padding: 10px;
    border: solid 1px silver;
}


.block-pid::before {
    content:"PID: ";
}


.block-application::before {
    content:"App: ";
}

.block-type::before {
    content:"Type: ";
}


.block-status::before {
    content:"Status: ";
}


.block-organization::before {
    content: "Org: ";
}

.block-do-action {
        list-style-type: none;
        margin-left: 0px;
        padding-left:0px;
}

.block-do-action li::before {
        color: gray;
}

.date::before { content:"Date: "; }
.distributor_name::before { content: "Distributor Name: "; }
.area::before { content: "Area: "; }
.amount::before { content: "Amount: "; }
.status::before { content: "Status: "; }
.contact_person::before { content: "Contact Person: "; }
.contact_no::before { content: "Contact No: "; }
.user_name::before { content: "Created By: "; }
.creation::before { content: "Creation Date: "; }


.block-hdr::before {
    color: gray;
}


.block-hdr {
    color: black;

}



.block-last-execution::before {
    content: "Last....: ";
}


.block-next-execution::before {
    content: "Next....: ";
}


.block-recurring::before {
    content: "Interval: ";
}

.block-toolbar li {
    min-width: 150px;
    margin-top: 5px;
}


.block-col::before {
   border: 1px solid #888;
    display: block;    
    padding: 2px;
    
}





.block-col {
    margin-bottom:20px;
    padding: 20px;
}

.block-hdr {
    margin-top: 10px;
}



.block-toolbar {
    margin-top: 10px;
}

.block-hdr A {
    position: absolute;
    right: 10px;
}

.block-do-action  {
    width: 100%;
    
}

.block-do-action  A {
    position: absolute;
    right: 10px;
} 

		
.feedback{
  width: 60px;
  height: 60px;
  text-align: center;
  padding: 5px 0;
  font-size: 20px;
  line-height: 2.00;
  border-radius: 30px;
  background-color : #31B0D5;
      border: none;
  color: white;
}
#mybutton {
  position: fixed;
  bottom: 10px;
  right: 10px;
}
	</style>
</head>
<body>
	
	<!-- START PAGE CONTAINER -->
	<div class="page-container page-navigation-top">            
		<!-- PAGE CONTENT -->
		<?php $this->load->view('templates/menus');?>
		<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
			<div class="heading-h3" style="display:none!important"> 
				<div class="heading-h3-heading mobile-head">	 <a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Order List  </div>						 
				<div class="heading-h3-heading mobile-head">
					<div class="pull-right btn-margin">	
						<?php $this->load->view('templates/download');?>	
					</div>	
					<div class="pull-right btn-margin" style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
						<a class="btn btn-success " href="<?php echo base_url() . 'index.php/sales_rep_order/add'; ?>">
							<span class="fa fa-plus"></span> Add Order Entry
						</a>
					</div>
				</div>	      
			</div>	
			<div class="page-content-wrap">                
				<div class="row">
					<div class="page-width">	
						<div class="col-md-12">
						
							<div class="panel panel-default">
								<div class="panel-body" style="margin-top:140px;">
							
								<h3> Order List</h3><hr>
								<?php for ($i=0; $i < count($data); $i++) { ?>
									<div class=" col-md-4 block-col block-col-2">
										<ul class="block-do-action">
								
											<li class="date"><?php echo (($data[$i]->date_of_processing!=null && $data[$i]->date_of_processing!='')?date('d/m/Y',strtotime($data[$i]->date_of_processing)):''); ?><a><?php echo $data[$i]->distributor_name; ?></a>	</li>
											
											
										
											<li class="area" style="display: none;"><?php echo $data[$i]->area; ?></li>
											<li class="amount"><?php echo format_money($data[$i]->amount,2); ?></li>
											<li class="status"><?php echo (($data[$i]->delivery_status=='' || $data[$i]->delivery_status==null)?'Distributor Pending Order':$data[$i]->delivery_status); ?></li>
											<li class="contact_person" style="display: none;"><?php echo $data[$i]->contact_person; ?></li>
											<li class="contact_no" style="display: none;"><?php echo $data[$i]->contact_no; ?></li>
										
										
											<li class="user_name" style="display: none;"><a class="btn btn-success  " href="<?php echo base_url().'index.php/sales_rep_order/edit/'.$data[$i]->id; ?>">
													<span class="fa fa-eye"></span> View 
												</a><?php echo $data[$i]->user_name; ?> </li>
											
											<li class="creation"><?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('l,d M Y',strtotime($data[$i]->modified_on)):''); ?> </li>
										</ul>	
									</div>
								<?php } ?>
							
								</div>
								<!-- END DEFAULT DATATABLE -->
							</div>
							
						
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT WRAPPER -->
			
		</div>  
				<div id="mybutton">
				<a href="<?php echo base_url() . 'index.php/sales_rep_order/add'; ?>"><button class="feedback" ><i class="fa fa-plus"></i></button></a>
				</div>			
		<!-- END PAGE CONTENT -->
	</div>
	<!-- END PAGE CONTAINER -->

	<?php $this->load->view('templates/footer');?>

	<!-- END SCRIPTS -->      
</body>
</html>