//-----Start Google Maps API ------>
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var geocoder = new google.maps.Geocoder();
var centerDefault = '2315 Speedway, Austin, TX  78712-1528';

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

google.maps.event.addDomListener(window, 'load', initialize);

//-----End Google Maps API ------>
