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
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];

//Needed for directions piece
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();

var origin1 = '303 W 35th St, Austin, TX';
var destinationA = '2330 Guadalupe St, Austin, TX';

var halfDist;
var totStepd = 0;
var lastStep;

//Markers red D and Yellow O
var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

function initialize() {
  var opts = {
    center: new google.maps.LatLng(55.53, 9.4),
    zoom: 10
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), opts);
  geocoder = new google.maps.Geocoder();
  
}

//Calculate the distance of two variables set in to arrays.
function calculateDistances(origin, destination) {
  var service = new google.maps.DistanceMatrixService();
  service.getDistanceMatrix(
    {
      origins: [origin],
      destinations: [destination],
      travelMode: google.maps.TravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.METRIC,
      avoidHighways: false,
      avoidTolls: false
    }, callback);
}

//Call back
function callback(response, status)
{
  if (status != google.maps.DistanceMatrixStatus.OK)
  {
    alert('Error was: ' + status);
  }
  else
  {
    var origins = response.originAddresses;
    var destinations = response.destinationAddresses;
    var outputDiv = document.getElementById('directions-panel');
    outputDiv.innerHTML = '';
    deleteOverlays();

    for (var i = 0; i < origins.length; i++)
    {
        var results = response.rows[i].elements;
        addMarker(origins[i], false);
        addMarker(destinations[i], true);
        outputDiv.innerHTML += 'The distance is: ' + results[i].distance.text + '<br>';
    }
      
      directionsDisplay = new google.maps.DirectionsRenderer();
      calcRoute(origin1,destinationA);
      directionsDisplay.setMap(map);
      
      halfDist = results[0].distance.value / 2;
  }
}

//Add markers to map
function addMarker(location, isDestination)
{
  var icon;
  if (isDestination)
  {
    icon = destinationIcon;
  }
  else
  {
    icon = originIcon;
  }
  geocoder.geocode({'address': location}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      bounds.extend(results[0].geometry.location);
      map.fitBounds(bounds);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location,
        icon: icon
      });
      markersArray.push(marker);
    } else {
      alert('Geocode was not successful for the following reason: '
        + status);
    }
  });
}

//Delete markers
function deleteOverlays() {
  for (var i = 0; i < markersArray.length; i++) {
    markersArray[i].setMap(null);
  }
  markersArray = [];
}

//Calculate Route
function calcRoute(start,end) {
    var request = {
    origin:start,
    destination:end,
    travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
                            if (status == google.maps.DirectionsStatus.OK)
                            {
                                var gSteps = response.routes[0].legs[0].steps;
                                directionsDisplay.setDirections(response);
                                routeDistance(gSteps);
                            }
                            //alert(response.routes[0].legs[0].steps[0].distance.value);
                            });
}

var counter = 0;
//Calculate The steps that add up to the mid point.
function routeDistance(stepsArray) {
    var start= stepsArray[0].start_location;
    var end= stepsArray[0].end_location;
    var request = {
    origin:start,
    destination:end,
    travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
                            if (status == google.maps.DirectionsStatus.OK)
                            {
                                alert(stepsArray[0].distance.value);

                                totStepd += stepsArray[0].distance.value;
                            
                                if(checkRange(totStepd) == "low")
                                {
                                    counter++;
            
                                    lastStep = stepsArray[0].start_location;
                                    //Drop first step in steps
                                    stepsArray.reverse().pop();
                                    stepsArray.reverse()
                                    //End Drop first step in steps
                                    alert(stepsArray.reverse().toString());
                            
                                    if(stepsArray != "")
                                    {
                                        routeDistance(stepsArray);
                                    }
                                }
                                else if (checkRange(totStepd) == "good")
                                {
                                    alert(halfDist+" "+totStepd+" "+counter+" "+stepsArray[0].distance.value+" "+ lastStep);
                                }
                                else if (checkRange(totStepd) == "high")
                                {
                                    alert("Error");
                                }
                            }
                            else
                            {
                                alert('Geocode was not successful for the following reason: ' + status);
                            }
                            //alert(response.routes[0].legs[0].steps[0].distance.value);
                            });
}

//Check mid point to see if within range.
function checkRange(midDistance)
{
    var percentCalc = midDistance/halfDist;
    if(percentCalc <= 1.5)
    {
        if(percentCalc >= .95)
        {
            alert("good"+percentCalc);
            return "good";
        }
        else
        {
            alert("low"+percentCalc);
            return "low";
        }
    }
    else
    {
        alert("high"+percentCalc);
        return "high";
    }
}



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
        <button type="button" onclick="calculateDistances(origin1, destinationA);"><h1>Get Distance</h1></button>

        <button type="button" onclick="alert('Email Sent');"><h1>Find Midpoint</h1></button>
        <div id="directions-panel">Click on buttons above for more info.
        </div>


	</div>
    <div id="map-canvas"></div>
</div>

</body>
</html>
