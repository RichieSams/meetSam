<?php
//    Google API key: AIzaSyAjxT5HgGwUQy1E9P6_8vcvo7q_i7Z1mx4
    $goKey = 'AIzaSyDzzYC0JTMf2UPapIJXkNbv9NEobpCBfPQ';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

    <link rel="stylesheet" type="text/css" href="style.css" media="all" />


    <script type="text/javascript" src=<?php echo "https://maps.googleapis.com/maps/api/js?key=".$goKey."&sensor=true" ?>>
    </script>

    <script type="text/javascript">
        var map;
        var geocoder = new google.maps.Geocoder();
        var centerAdd = '2315 Speedway, Austin, TX  78712-1528';

        function initialize() {
            var mapOptions = {
            center: new google.maps.LatLng(-34.397, 150.644),
            zoom: 18
            };
            map = new google.maps.Map(document.getElementById("map-canvas"),
                                          mapOptions);
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
        google.maps.event.addDomListener(window, 'load', initialize);
        codeAddress();
    </script>
    </head>
<body>
<div id="map-canvas"/>
</body>
</html>
