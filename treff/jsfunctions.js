//Get directions using google API
function getDirects(address)
{
    alert("getting directions for "+address);
    document.getElementById("directions").innerHTML="The directions to the Treff will be placed here.";
}


function codeAddress() {
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