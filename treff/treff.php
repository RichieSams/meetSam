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
    <link rel="icon" href="favicon.ico" />


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

        google.maps.event.addDomListener(window, 'load', initialize);
        codeAddress();
    </script>
<!--//-----End Google Maps API ------>

    </head>
<body>
<div class="header">
    <div class="title"><a href="index.php"><img src="images/treff_medium.png" /></a></div>
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
		<p> All atendees have subited a confirmation. 
	    </p>
        <button type="button" onclick="getDirects(<?php echo getAddress() ?>);"><h1>Get Directions</h1></button>

        <button type="button" onclick="alert('Email Sent');"><h1>Send Reminder Email</h1></button>
        <p style="directions">	    </p>


	</div>
    <div id="map-canvas"></div>
</div>

<?php include 'footer.php'; ?>