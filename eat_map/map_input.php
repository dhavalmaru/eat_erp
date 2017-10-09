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
<form action="save_map.php" method="post">
<label>Name of Distributors: </label>
<input type="text" value="" style="width:60%;" name="dist_name"/>
<br><br>
<label>Address of Distributors for Google: </label>
<input type="text" value="" style="width:60%;" name="addr_dist"/>
<br><br>
<input type="submit" value="save"/><br><br>
<a href="map.html">Go to map</a>
<label id="map_data" style="display:none;"></label>
<div id="map_wrapper">
    <div id="map_canvas" class="mapping"></div>
</div>
    
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>


</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyAnbUQIEhRHBicXKRdgwele5zCxu61EUGQ">
 </script> 

 <script type="text/javascript">
$.ajax({
  url: "get_map.php",
  success: function(html){
    $('#map_data').text(html);
	//alert(html);
var locations=[]; 
//alert('hh');
locations = $('#map_data').text();
alert(locations);
// locations = [
  // ['AVADH Sweets,Snacks&Dryfruits', 'Monarch Nagar S.B Road J.B Nagar Andheri East Mumbai, IN', 'Location 1 URL'],
  // ['BON BON Super Market', 'Greenland Apts J.B Nagar Andheri East Mumbai, IN', 'Location 1 URL'],
  // ['Jems Dry Fruits, Chocolates & Food Stuff', 'Chapel Avenue Bandra West Mumbai, IN', 'Location 1 URL'],
  // ['Lucky NX', 'Green Land Apartments J.B Nagar Andheri East, IN', 'Location 1 URL'],
  // ['AA Brothers', 'Dr Baba Saheb Ambedkar Rd, Central Railway Colony, Mahavir Nagar, Parsee Colony, Dadar East Mumbai, IN', 'Location 1 URL'],
  // ['Aayushi super shoppy', 'Tilak Nagar, Chembur west Mumbai, IN', 'Location 1 URL'],
  // ['Akhil medical & general stores', 'Sector 17 Vashi Navi Mumbai, IN', 'Location 1 URL'],
  // ['Alfa', 'Irla Society Road Vile Parle West Mumbai, IN', 'Location 1 URL'],
// ];

var geocoder;
var map;
var bounds = new google.maps.LatLngBounds();

function initialize() {
  map = new google.maps.Map(
    document.getElementById("map_canvas"), {
      center: new google.maps.LatLng(37.4419, -122.1419),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  geocoder = new google.maps.Geocoder();

  for (i = 0; i < locations.length; i++) {


    geocodeAddress(locations, i);
  }
}
google.maps.event.addDomListener(window, "load", initialize);

function geocodeAddress(locations, i) {
  var title = locations[i][0];
  var address = locations[i][1];
  var url = locations[i][2];
  geocoder.geocode({
      'address': locations[i][1]
    },

    function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var marker = new google.maps.Marker({
          icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png',
          map: map,
          position: results[0].geometry.location,
          title: title,
          animation: google.maps.Animation.DROP,
          address: address,
          url: url
        })
        infoWindow(marker, map, title, address, url);
        bounds.extend(marker.getPosition());
        map.fitBounds(bounds);
      } else {
        // alert("geocode of " + address + " failed:" + status);
      }
    });
}

function infoWindow(marker, map, title, address, url) {
  google.maps.event.addListener(marker, 'click', function() {
    var html = "<div><h3>" + title + "</h3><p>" + address + "<br></div><a href='" + url + "'>View location</a></p></div>";
    iw = new google.maps.InfoWindow({
      content: html,
      maxWidth: 350
    });
    iw.open(map, marker);
  });
}

function createMarker(results) {
  var marker = new google.maps.Marker({
    icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png',
    map: map,
    position: results[0].geometry.location,
    title: title,
    animation: google.maps.Animation.DROP,
    address: address,
    url: url
  })
  bounds.extend(marker.getPosition());
  map.fitBounds(bounds);
  infoWindow(marker, map, title, address, url);
  return marker;
}
  }
});
 

</script>
</form>
</body>
</html>