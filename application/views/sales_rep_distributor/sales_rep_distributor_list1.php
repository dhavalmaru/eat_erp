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
</head>
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


.distributor_name:before { content: "Distributor Name: "; }
.address::before { content: "Address: "; }
.city::before { content: "City: "; }
.area::before { content: "Area: "; }
.vat_no::before { content: "Vat No: "; }
.contact_person::before { content: "Contact Person: "; }
.contact_no::before { content: "Contact No: "; }
.status::before { content: "Status: "; }
.margin::before { content: "Margin: "; }
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
.block-do-action li {
    width: 70%!important;
    
}

.block-do-action  {
    width: 100%;
    
}

.block-do-action  A {
    position: absolute;
    right: 10px;
    width:30%!important;
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
<body>								
	<!-- START PAGE CONTAINER -->
	<div class="page-container page-navigation-top">            
		<!-- PAGE CONTENT -->
		<?php $this->load->view('templates/menus');?>
		<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">

			<div class="heading-h3" style="display:none!important;"> 
				<div class="heading-h3-heading mobile-head"  style="display:none;">	 <a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Distributor List  </div>						 
				<div class="heading-h3-heading mobile-head"  style="display:none;">
					<div class="pull-right btn-margin">	
						<?php $this->load->view('templates/download');?>	
					</div>	
					<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
						<a class="btn btn-success  " href="<?php echo base_url() . 'index.php/sales_rep_distributor/add'; ?>">
							<span class="fa fa-plus"></span> Add Distributor
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
								<div class="panel-body" style="margin-top:140px;">
							
								<h3> Retailer List</h3><hr>
								<?php for ($i=0; $i < count($data); $i++) { ?>
									<div class=" col-md-4 block-col block-col-2">
										<ul class="block-do-action">
								
											<li class="address"><?php echo $data[$i]->address; ?></li>
											
									
											<li class="city"><?php echo $data[$i]->city; ?></li>
											<li class="area"><?php echo $data[$i]->area; ?>	<a><?php echo $data[$i]->distributor_name; ?></a></li>
											<li class="vat_no"><?php echo $data[$i]->vat_no; ?></li>
											<li class="contact_person"><?php echo $data[$i]->contact_person; ?></li>
											<li class="contact_no"><?php echo $data[$i]->contact_no; ?></li>
											<li class="status"><?php echo $data[$i]->status; ?></li>
											<li class="margin"><?php echo $data[$i]->margin; ?></li>
										
											<li class="user_name"><a class="btn btn-success  " href="<?php echo base_url().'index.php/sales_rep_distributor/edit/'.$data[$i]->id; ?>">
													<span class="fa fa-eye"></span> View 
												</a><?php echo $data[$i]->user_name; ?> </li>
											
											<li class="creation"><?php echo (($data[$i]->modified_on!=null && $data[$i]->modified_on!='')?date('d/m/Y',strtotime($data[$i]->modified_on)):''); ?> </li>
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
				<a href="<?php echo base_url() . 'index.php/sales_rep_distributor/add'; ?>"><button class="feedback" ><i class="fa fa-plus"></i></button></a>
				</div>			
		<!-- END PAGE CONTENT -->
	</div>
	<!-- END PAGE CONTAINER -->

	<?php $this->load->view('templates/footer');?>

	<!-- END SCRIPTS -->      
</body>
</html>