<?php
//    Google API key: AIzaSyAjxT5HgGwUQy1E9P6_8vcvo7q_i7Z1mx4
    $goKey = 'AIzaSyDzzYC0JTMf2UPapIJXkNbv9NEobpCBfPQ';
    $id = "placeholder";
    include 'functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

    <script type ="text/javascript" src = "jsfunctions.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" media="all" />

<!--//-----Start Google Maps API ------>
    <script type="text/javascript" src=<?php echo "https://maps.googleapis.com/maps/api/js?key=".$goKey."&sensor=true" ?>>
    </script>

    <script type="text/javascript">
        var map;
        var geocoder = new google.maps.Geocoder();
        var centerAdd = '2315 Speedway, Austin, TX  78712-1528';

        function initialize() {
            var mapOptions = {
            center: new google.maps.LatLng(-34.397, 150.644),
            zoom: 17
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
<!--//-----End Google Maps API ------>

    </head>
<body>
<div class="header">
    <div class="title"><a href="index.php"><img src="treff_medium.png" /></a></div>
    <div class="title_text">Meetings made easy</div>
</div>
<nav class="nav_bar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="description.php">What is Treff?</a></li>
    </ul>
</nav>
<div class="main_body">
    <div class="infoTreff">
        <div class="status">
            <h1>Status:</h1> <?php echo checkStat($id); ?>
        </div>
		<p> Treff is a service for creating meeting points for people.<br /><br />
            Treff will ask for your location and the phone numbers or emails of the people
            you would like to meet up with. Then it will find a meeting point and automatically
            send out personalized directions to everyone.
	    </p>
        <h1>Send Reminder Email</h1>
        <p>	    </p>


	</div>
    <div id="map-canvas"></div>
</div>

<?php include 'footer.php'; ?>