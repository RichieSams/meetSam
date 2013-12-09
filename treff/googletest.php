<?php
//    Google API key: AIzaSyAjxT5HgGwUQy1E9P6_8vcvo7q_i7Z1mx4
    $goKey = "AIzaSyDzzYC0JTMf2UPapIJXkNbv9NEobpCBfPQ";
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<script type="text/javascript"
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzzYC0JTMf2UPapIJXkNbv9NEobpCBfPQ&sensor=true">
</script>
<script type="text/javascript">
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var geocoder = new google.maps.Geocoder();
var centerDefault = '510 W 32nd St, Austin, TX';
var secAddress = '303 W 35th St, Austin, TX';

//Get directions using google API
function getDirects(address)
{
    alert("Getting directions for "+address);
    document.getElementById("directions-panel").innerHTML="";
    calcRoute(address,centerDefault);
}

function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var mapOptions = {
    center: new google.maps.LatLng(-34.397, 150.644),
    zoom: 17
    };
    map = new google.maps.Map(document.getElementById("map-canvas"),
                              mapOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('directions-panel'));
}


//Goggle API for geocoding.
function codeAddress(centerAdd) {
    geocoder.geocode( { 'address': centerAdd}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK)
                     {
                     map.setCenter(results[0].geometry.location);
                     var marker = new google.maps.Marker({
                                                         map: map,
                                                         position: results[0].geometry.location
                                                         });
                     }
                     else
                     {
                     alert('Geocode was not successful for the following reason: ' + status);
                     }
                     });
}

function getLatlng(address, callbackFunction) {
    geocoder.geocode( { 'address': address}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                     var location = results[0].geometry.location;
                     callbackFunction(location.lat(), location.lng());
                     } else {
                     alert('Geocode was not successful for the following reason: ' + status);
                     }
                     });
}

//Goggle API for geocoding.
function calcRoute(start,end) {
    var request = {
    origin:start,
    destination:end,
    travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
                            if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                            }
                            });
}

codeAddress(centerDefault);
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
<div class="main_body">
    <div class="infoTreff">
        <div class="status">
            <h1>Status:</h1>
        </div>
		<p> All atendees have submited a confirmation.
	    </p>
        <button type="button" onclick="getDirects(secAddress);"><h1>Get Directions</h1></button>

        <button type="button" onclick="alert('Email Sent');"><h1>Send Reminder Email</h1></button>
        <div id="directions-panel">Click on buttons above for more info.
        </div>


	</div>
    <div id="map-canvas"></div>
</div>

</body>
</html>
