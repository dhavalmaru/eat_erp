<html>
<head>
<style>
#map_wrapper {
    
}

#map_canvas {
    width: 100%;
    height: 100%;
}
</style>
</head>
<body>
<div id="map_wrapper">

    <div id="map_canvas" class="mapping"></div>
</div>
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
 
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
		url: "<?php echo base_url() . 'index.php/store/get_store_locations' ?>",
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
	
  </body>

</html>