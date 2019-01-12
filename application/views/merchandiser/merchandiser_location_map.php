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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/font/material-design-icons/Material-Design-Icons.woff" rel="stylesheet">

<style>
#map_wrapper {
    
}

#map_canvas {
    width: 100%;
    height: 100%;
    position: absolute!important;
}
</style>
<body>		

<div class="navbar">
		 <?php $this->load->view('templates/header2');?>
		</div>

		<?php $this->load->view('templates/menu2');?>	
		<div class="contact app-pages app-section" style="margin:50 auto">
				<div id="map_wrapper">

						<div id="map_canvas" class="mapping"></div>
				</div>
        </div>
        </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

 <script type="text/javascript">
// var locations = [
//   ['AVADH Sweets,Snacks&Dryfruits', 'Monarch Nagar S.B Road J.B Nagar Andheri East Mumbai, IN', 'Location 1 URL'],
//   ['BON BON Super Market', 'Greenland Apts J.B Nagar Andheri East Mumbai, IN', 'Location 1 URL'],
//   ['Jems Dry Fruits, Chocolates & Food Stuff', 'Chapel Avenue Bandra West Mumbai, IN', 'Location 1 URL'],
//   ['Lucky NX', 'Green Land Apartments J.B Nagar Andheri East, IN', 'Location 1 URL'],
//   ['AA Brothers', 'Dr Baba Saheb Ambedkar Rd, Central Railway Colony, Mahavir Nagar, Parsee Colony, Dadar East Mumbai, IN', 'Location 1 URL'],
//   ['Aayushi super shoppy', 'Tilak Nagar, Chembur west Mumbai, IN', 'Location 1 URL'],
//   ['Akhil medical & general stores', 'Sector 17 Vashi Navi Mumbai, IN', 'Location 1 URL'],
//   ['Alfa', 'Irla Society Road Vile Parle West Mumbai, IN', 'Location 1 URL'],
// ];
<?php
//echo [$data][0][latitude];
//echo [$data][0][longitude];

?>
var locations = [];


	
function initMap() {
	var lati='-25.363';
	var longi='131.044';
	var address;
	$.ajax({
		url: "<?php echo base_url() . 'index.php/Merchandiser_location/get_store_locations' ?>",
		data: {id:<?=$this->uri->segment(3)?>},
		
		type: "POST",
		dataType: 'json',
		global: false,
		async: false,
		success: function (data) {
		  console.log(data);
		  console.log(data.latitude);
		  lati = parseFloat(data.latitude);
		  longi = parseFloat(data.longitude);
		  address = parseFloat(data.google_address);
		},
		error: function () {
		}
	});

	var uluru = {lat: lati, lng: longi};
         var map = new google.maps.Map(document.getElementById('map_canvas'), {
          zoom: 11,
          center: uluru
        }); 
        var marker = new google.maps.Marker({
          position: uluru,
          map: map,
		   address: address,
        });
       
	
      }
</script>
    <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsgOOC1sMElGnhJq4wDvR2jnqgcCCamw&callback=initMap">
    </script>
	
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/fakeLoader.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/loading.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/slick.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/owl.carousel.min.js"></script>
	<script src="<?php echo base_url(); ?>sales_rep/js/custom.js"></script>
	
	 
	
	<!-- END SCRIPTS -->      
</body>
</html>