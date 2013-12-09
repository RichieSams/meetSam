var map;
var directionsDisplay;
var centerDefault = '2315 Speedway, Austin, TX  78712-1528';

google.maps.event.addDomListener(window, 'load', initialize);

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

function setMapCenterFromAddress(address) {
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            setMapCenterFromLocation(results[0].geometry.location);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function setMapCenterFromLatLng(latLng) {
    geocoder.geocode({'latLng': latLng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            setMapCenterFromLocation(results[0].geometry.location);
        } else {
            alert("Geocoder failed due to: " + status);
        }
    });
}

function setMapCenterFromLocation(location) {
    map.setCenter(location);
}

//Get directions using google API
function getDirections(address)
{
    alert("Getting directions for "+address);
    document.getElementById("directions-panel").innerHTML="";
    calcRoute(address, centerDefault);
}

