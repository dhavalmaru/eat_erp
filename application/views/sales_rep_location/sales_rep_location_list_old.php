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

.item-block-date-id::before { content:"Date: "; }
.item-block-distributor-id::before { content: "  "; }
.item-block-type-id::before { content: "Distributor Type: "; }
.item-block-status-id::before { content: "Status: "; }
.item-block-creation-id::before { content: "Follow Up Date: "; }


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
</head>
<body>
	<!-- START PAGE CONTAINER -->
	<div class="page-container page-navigation-top">            
		<!-- PAGE CONTENT -->
		<?php $this->load->view('templates/menus');?>
		<div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
			<div class="heading-h3"style="display:none!important;"> 
				<div class="heading-h3-heading mobile-head"style="display:none!important;"> <a href="<?php echo base_url().'index.php/dashboard_sales_rep'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Visit List  </div>						 
				<div class="heading-h3-heading mobile-head"style="display:none!important;">
					<div class="pull-right btn-margin">	
						<?php $this->load->view('templates/download');?>	
					</div>	
					<div class="pull-right btn-margin"  style="<?php if($access[0]->r_insert=='0') echo 'display: none;';?>">
						<a class="btn btn-success  " href="<?php echo base_url() . 'index.php/sales_rep_location/add'; ?>">
							<span class="fa fa-plus"></span> Add Visit
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
							
								<h3>Visit List</h3><hr>
								<?php for ($i=0; $i < count($data); $i++) { ?>
									<div class=" col-md-4 block-col block-col-2">
										<ul class="block-do-action">
										
								
										
										
											
											<li class="item-block-date-id"> <?php echo (($data[$i]->date_of_visit!=null && $data[$i]->date_of_visit!='')?date('d/m/Y',strtotime($data[$i]->date_of_visit)):''); ?><a><?php echo $data[$i]->distributor_name; ?> </a></li>
											<li class="item-block-type-id"><?php echo $data[$i]->distributor_type; ?> </li>
											<li class="item-block-status-id"><a class="btn btn-success  " href="<?php echo base_url().'index.php/sales_rep_location/edit/'.$data[$i]->id; ?>">
													<span class="fa fa-eye"></span> View 
												</a><?php echo $data[$i]->distributor_status; ?></li>
											<li class="item-block-creation-id"><?php echo (($data[$i]->followup_date!=null && $data[$i]->followup_date!='')?date('d/m/Y',strtotime($data[$i]->followup_date)):''); ?> </li>
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
				<a href="<?php echo base_url() . 'index.php/sales_rep_location/add'; ?>"><button class="feedback" ><i class="fa fa-plus"></i></button></a>
				</div>		
		<!-- END PAGE CONTENT -->
	</div>
	<!-- END PAGE CONTAINER -->

	<?php $this->load->view('templates/footer');?>

	<!-- END SCRIPTS -->      
</body>
</html>