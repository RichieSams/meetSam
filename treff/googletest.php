<?php
//    Google API key: AIzaSyAjxT5HgGwUQy1E9P6_8vcvo7q_i7Z1mx4
    $goKey = AIzaSyAjxT5HgGwUQy1E9P6_8vcvo7q_i7Z1mx4;
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
html { height: 100% }
body { height: 100%; margin: 0; padding: 0 }
#map-canvas { height: 100% }
</style>
<script type="text/javascript"
src="https://maps.googleapis.com/maps/api/js?key=<?php echo $goKey ?>&sensor=SET_TO_TRUE_OR_FALSE">
</script>
<script type="text/javascript">
function initialize() {
    var mapOptions = {
    center: new google.maps.LatLng(-34.397, 150.644),
    zoom: 8
    };
    var map = new google.maps.Map(document.getElementById("map-canvas"),
                                  mapOptions);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body>
<div id="map-canvas"/>
</body>
</html>
