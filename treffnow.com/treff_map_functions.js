var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var geocoder = new google.maps.Geocoder();
var centerpointMarker;
var infowindow = new google.maps.InfoWindow();
;

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

function setMapCenterFromAddress(address, setMarker, locName) {
    locName = typeof locName !== 'undefined' ? locName : "";
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            if (setMarker) {
                centerpointMarker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            }
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

//Get directions using google API
function getDirections(start, end) {
    centerpointMarker.setVisible(false);

    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.DRIVING
    };

    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}
