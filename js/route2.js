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
}

google.maps.event.addDomListener(window, "load", initialize);

function calcRoute(start, end) {
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
        }
    });
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
    if (status == 'OK') {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;
        var element;
        for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
            for (var j = 0; j < results.length; j++) {
                element = results[j];
                var distance = element.distance.text;
                var duration = element.duration.text;
                var from = origins[i];
                var to = destinations[j];
            }
        }

        if(element!==undefined){
            row = row + '<tr>' + 
                        '<th style="text-align:center; width:100px;">'+ (num+1) +'</th>' + 
                        '<th>'+elements[num]['date_of_visit']+'</th>' + 
                        '<th>'+elements[num]['area']+'</th>' + 
                        '<th>'+elements[num]['start']+'</th>' + 
                        '<th>'+elements[num]['end']+'</th>' + 
                        '<th>'+element.distance.text+'</th>' + 
                        '<th>'+element.duration.text+'</th>' + 
                    '</tr>';

            var distance = element.distance.text;
            var duration = element.duration.text;
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

            if(elements.length==locations.length) {
                if(tot_duration>60){
                    hour = Math.floor(tot_duration/60);
                    minute = tot_duration%60;
                    total_duration = hour + ' hour ' + minute + ' mins';
                } else {
                    total_duration = tot_duration + ' mins';
                }

                var final_row = row + '<tr>' + 
                        '<th style="text-align:left;" colspan="5">Total</th>' + 
                        '<th>'+tot_distance+' km</th>' + 
                        '<th>'+total_duration+'</th>' + 
                    '</tr>';
                $("#route_details").html(final_row);
            }

            num = num + 1;
        }
    }
}

function geocodeAddress(locations, i) {
    var distributor_name = locations[i][6];
    var area = locations[i][3];
    var latitude = locations[i][7];
    var longitude = locations[i][8];

    if(distributor_name!==null) {
        var myCenter = new google.maps.LatLng(latitude,longitude);
        var marker = new google.maps.Marker({position:myCenter});
        marker.setMap(map);
        infoWindow(marker, map, area, distributor_name);
    }
}

function infoWindow(marker, map, title, address) {
    google.maps.event.addListener(marker, 'click', function() {
        var html = "<div><h3>" + title + "</h3><p>" + address + "<br></p></div>";
        iw = new google.maps.InfoWindow({
            content: html,
            maxWidth: 350
        });
        iw.open(map, marker);
    });
}

$("#get_route_plan").click(function(){
    get_route_plan();
});

var get_route_plan = function(){
    $.ajax({
        url: BASE_URL + 'index.php/sales_rep_route_plan/get_route_plan',
        data: 'from_date='+$("#from_date").val()+'&to_date='+$("#to_date").val()+'&sales_rep_id='+$("#sales_rep_id").val(),
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

    for (i = 0; i < locations.length; i++) {
        var id = locations[i]['id'];
        if(id!=null){
            date_of_visit = locations[i]['date_of_visit'];

            elements[i] = new Array();
            elements[i]['date_of_visit'] = date_of_visit;
            elements[i]['area'] = locations[i]['area'];

            if(date_of_visit!=prev_date_of_visit){
                start = new google.maps.LatLng(locations[i]['area_lat'], locations[i]['area_long']);
                prev_date_of_visit = date_of_visit;
                elements[i]['start'] = locations[i]['area'];
            } else {
                start = new google.maps.LatLng(locations[i-1]['dist_lat'], locations[i-1]['dist_long']);
                elements[i]['start'] = locations[i-1]['distributor_name'];
            }
            end = new google.maps.LatLng(locations[i]['dist_lat'], locations[i]['dist_long']);
            elements[i]['end'] = locations[i]['distributor_name'];

            calcRoute(start, end);
            calcDistance(start, end);
            // geocodeAddress(locations, i);
        }
    }
}

// $(document).ready(function(){
//     get_route_plan();
// });