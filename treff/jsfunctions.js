var map;
var geocoder = new google.maps.Geocoder();
var centerDefault = '2315 Speedway, Austin, TX  78712-1528';

//Get directions using google API
function getDirects(address)
{
    alert("getting directions for "+address);
    document.getElementById("directions").innerHTML="The directions to the Treff will be placed here.";
    codeAddress(address);
}

//-----Start Google Maps API ------>

function initialize() {
    var mapOptions = {
    center: new google.maps.LatLng(-34.397, 150.644),
    zoom: 17
    };
    map = new google.maps.Map(document.getElementById("map-canvas"),
                              mapOptions);
}

google.maps.event.addDomListener(window, 'load', initialize);

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

//-----End Google Maps API ------>
