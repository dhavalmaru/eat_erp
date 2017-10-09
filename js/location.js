var prev_date_of_visit;
var date_of_visit;
var start;
var end;
var title;
var elements = [];
var locations = [];
var row;
var num;
var tot_distance;
var tot_duration;
var markers = [];
var geocoder;
var map;
var bounds = new google.maps.LatLngBounds();
var directionsService = new google.maps.DirectionsService();
var service = new google.maps.DistanceMatrixService();

function initialize() {
    map = new google.maps.Map(
        document.getElementById("map_canvas"), {
            center: new google.maps.LatLng(23.022505, 72.5713621),
            zoom: 3,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
    geocoder = new google.maps.Geocoder();
    directionsDisplay = new google.maps.DirectionsRenderer({map: map, suppressMarkers: true});
    // map.addEventListener('google-map-ready', function(e) {
    //     alert('Map loaded!');
    // });

    google.maps.event.addListener(map, 'tilesloaded', function() {
        // alert('Map loaded!');
        var url = window.location.href;
        // console.log(url);
        if(url.indexOf('get_location')!=-1) {
            get_location();
        }
    });
}

google.maps.event.addDomListener(window, "load", initialize);

function calcRoute(start, end) {
var my_route;
    var directionsDisplay = new google.maps.DirectionsRenderer();
    var request = {
        origin:start,
        destination:end,
        travelMode: 'DRIVING'
    };
    directionsService.route(request, function(response, status) {
        if (status == 'OK') {
            directionsDisplay.setDirections(response);
            directionsDisplay.setMap(map);
            my_route = response.routes[0];
            for (var i = 0; i < my_route.legs.length; i++) {
                addDraggableDirectionsMarker(my_route.legs[i].start_location, i+1, map, markers, directionsService, directionsDisplay);
            }
            addDraggableDirectionsMarker(my_route.legs[i-1].end_location, i+1, map, markers, directionsService, directionsDisplay);
        
            // addMarker();
            //directionsDisplay.setOptions( { suppressMarkers: true } );
        }
    });
}


function addDraggableDirectionsMarker(position, label, map, markers, directionsService, directionsDisplay){
    var marker = new google.maps.Marker({
        position: position,
        label: "" + label,
        map: map,
        draggable: true
    });
    google.maps.event.addListener(marker, 'click', function(){
        //do whatever you want on marker click
    }); 
    google.maps.event.addListener(marker, 'dragend', function(){
        if(markers.length < 2) return;
        var waypoints = [];
        for(var i = 1; i < markers.length - 1; i++) waypoints.push({location:markers[i].getPosition()});
        directionsService.route({
            origin: markers[0].getPosition(),
            destination: markers[markers.length-1].getPosition(),
            waypoints: waypoints,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                    //uncomment following code if you want the markers you dragged to snap to the route, closest to the point where you dragged the marker
                    /*var my_route = response.routes[0];
            for (var i = 0; i < my_route.legs.length; i++) {
               markers[i].setPosition(my_route.legs[i].start_location);
            }
            markers[i].setPosition(my_route.legs[i-1].end_location);*/
            } else {
                vts.alertDialog( window.localization.error,
                    window.localization.error_direction_calculate + ": " + status,
                    BootstrapDialog.TYPE_DANGER);
            }
        });
    });
    markers.push(marker);
}


function calcDistance(start, end) {
    service.getDistanceMatrix(
    {
        origins: [start],
        destinations: [end],
        travelMode: 'DRIVING'
    }, callback);
}

function callback(response, status) {
    // $("#route_details").html("");
    if (status == 'OK') {
        // alert('hi');
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;
        var element;
        var final_row;
        var distance = '';
        var duration = '';

        for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
            for (var j = 0; j < results.length; j++) {
                element = results[j];
                // console.log(element.status);
                if(element.status=="ZERO_RESULTS"){
                    distance = '0km';
                    duration = '0hour';
                } else {
                    distance = element.distance.text;
                    duration = element.duration.text;
                }
                var from = origins[i];
                var to = destinations[j];
            }
        }
        
        // if(element!==undefined){
            row = row + '<tr>' + 
                        '<th style="text-align:center; width:100px;">'+ (num+1) +'</th>' + 
                        '<th>'+elements[num]['date_of_visit']+'</th>' + 
                        '<th>'+elements[num]['sales_rep_name']+'</th>' + 
                        '<th>'+elements[num]['store_name']+'</th>' + 
                        '<th>'+elements[num]['login_time']+'</th>' + 
                        '<th>'+elements[num]['login_latitude']+'</th>' + 
                        '<th>'+elements[num]['login_longitude']+'</th>' + 
                        '<th>'+elements[num]['logout_time']+'</th>' + 
                        '<th>'+elements[num]['logout_latitude']+'</th>' + 
                        '<th>'+elements[num]['logout_longitude']+'</th>' + 
                    '</tr>';

            // var distance = element.distance.text;
            // var duration = element.duration.text;
            var hour = 0;
            var minute = 0;
            var total_duration = "";

            if(distance.indexOf("km")!==-1){
                distance = distance.substring(0,distance.indexOf("km"));
                distance = parseFloat(distance);
                tot_distance = tot_distance + distance;
            }

            if(duration.indexOf("hour")!==-1){
                hour = duration.substring(0,duration.indexOf("hour"));
                hour = parseFloat(hour);
                tot_duration = tot_duration + (hour*60);
                duration = duration.substring(duration.indexOf("hour")+5);
            }

            if(duration.indexOf("mins")!==-1){
                duration = duration.substring(0,duration.indexOf("mins"));
                duration = parseFloat(duration);
                tot_duration = tot_duration + duration;
            }

            //if(elements.length==locations.length) {
                if(tot_duration>60){
                    hour = Math.floor(tot_duration/60);
                    minute = tot_duration%60;
                    total_duration = hour + ' hour ' + minute + ' mins';
                } else {
                    total_duration = tot_duration + ' mins';
                }

                // final_row = row + '<tr>' + 
                //         '<th style="text-align:left;" colspan="5">Total</th>' + 
                //         '<th>'+tot_distance+' km</th>' + 
                //         '<th>'+total_duration+'</th>' + 
                //         '<th>&nbsp;</th>' + 
                //     '</tr>';
                // alert(total_duration);
            //}
            
            final_row = row;

            //alert(final_row);
            $("#route_details").html(final_row);
            
            num = num + 1;
        // }
    }
}

function geocodeAddress(locations, i) {
    var distributor_name = locations[i][6];
    var area = locations[i][3];
    var latitude = locations[i][7];
    var longitude = locations[i][8];

    if(distributor_name!==null) {
        var myCenter = new google.maps.LatLng(latitude,longitude);
        var marker = new google.maps.Marker({position:myCenter,icon: "http://maps.google.com/mapfiles/marker" + String.fromCharCode(markers.length + 65) + ".png"});
        marker.setMap(map);
        infoWindow(marker, map, area, distributor_name);

    }
}

function infoWindow(marker, map, title, address) {
    // alert(address);
    google.maps.event.addListener(marker, 'click', function() {
        var html = "<div><h3>" + title + "</h3><p>" + address + "<br></p></div>";
        iw = new google.maps.InfoWindow({
            content: html,
            maxWidth: 350
        });
        iw.open(map, marker);
    });
}

$("#get_location").click(function(){
    get_location();
});

var get_location = function(){
    // if($("#sales_rep_id").val()!="") {
        $.ajax({
            url: BASE_URL + 'index.php/sales_rep_location/get_location',
            data: 'from_date='+$("#from_date").val()+'&to_date='+$("#to_date").val(),
            cache: false,
            type: "POST",
            dataType: 'json',
            global: false,
            async: false,
            success: function (data) {
                locations = data;
            },
                error: function () {
            }
        });

        row = "";
        prev_date_of_visit = "";
        date_of_visit = "";
        num = 0;
        tot_distance=0;
        tot_duration=0;

        if(locations!=null){
            for (i = 0; i < locations.length; i++) {
                // alert(locations[i]['id']);
                var id = locations[i]['id'];
                if(id!=null){
                    date_of_visit = locations[i]['date_of_visit'];

                    elements[i] = new Array();
                    elements[i]['date_of_visit'] = date_of_visit;
                    elements[i]['sales_rep_name'] = locations[i]['sales_rep_name'];
                    elements[i]['store_name'] = locations[i]['store_name'];

                    if(date_of_visit!=prev_date_of_visit){
                        start = new google.maps.LatLng(locations[i]['latitude'], locations[i]['longitude']);
                        prev_date_of_visit = date_of_visit;
                        elements[i]['start'] = locations[i]['store_name'];
                        elements[i]['login_time'] = locations[i]['login_time'];
                        elements[i]['login_latitude'] = locations[i]['login_latitude'];
                        elements[i]['login_longitude'] = locations[i]['login_longitude'];
                    } else {
                        start = new google.maps.LatLng(locations[i-1]['latitude'], locations[i-1]['longitude']);
                        elements[i]['start'] = locations[i-1]['store_name'];
                    }
                    end = new google.maps.LatLng(locations[i]['logout_latitude'], locations[i]['logout_longitude']);
                    elements[i]['end'] = locations[i]['store_name'];
                    elements[i]['logout_time'] = locations[i]['logout_time'];
                    elements[i]['logout_latitude'] = locations[i]['logout_latitude'];
                    elements[i]['logout_longitude'] = locations[i]['logout_longitude'];

                    calcRoute(start, end);
                    calcDistance(start, end);
                }
            }
        } else {
            $("#route_details").html('');
            initialize();
        }
        
    // } else {
    //     alert("Select Sales Representative");
    // }
}

// $(document).ready(function(){
//     var url = window.location.href;
//     console.log(url);
//     if(url.indexOf('get_location')!=-1) {
//         get_location();
//     }
// });