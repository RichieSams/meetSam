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
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzzYC0JTMf2UPapIJXkNbv9NEobpCBfPQ&sensor=true&libraries=places">
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
var lastStepS, lastStepE;

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

var numberofSteps = 0;
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
                                totStepd += stepsArray[0].distance.value;
                                ++numberofSteps;
                                var inRange = checkRange(totStepd);
                            
                                if(inRange == "low")
                                {
                                    lastStepS = stepsArray[0].start_location;
                                    lastStepE = stepsArray[0].end_location;
                            
                                    //Drop first step in steps by reversing the array first
                                    stepsArray.reverse().pop();
                                    stepsArray.reverse()
                                    //End Drop first step in steps
                            
                                    if(stepsArray != "")
                                    {
                                        routeDistance(stepsArray);
                                    }
                                }
                                else if (inRange == "good")
                                {
                                    lastStep = stepsArray[0].end_location;
                                    alert(lastStep);
                                }
                                else if (inRange == "high")
                                {
                                    addMarker(lastStepE.toString());
                                    getPlace(lastStepE);
                                    alert("Error");
                                }
                            }
                            else
                            {
                                alert('Route Distance was not found because ' + status);
                            }
                            //alert(response.routes[0].legs[0].steps[0].distance.value);
                            });
}

//Get places around a LatLng
var typePlace = "cafe";
var infowindow;
function getPlace(location)
{
    var request = {
        location: location,
        radius: 500,
        types: [typePlace]
    };
    infowindow = new google.maps.InfoWindow();
    var service = new google.maps.places.PlacesService(map);
    
    service.nearbySearch(request, call);
}

function call(results, status) {
    if (status == google.maps.places.PlacesServiceStatus.OK) {
        createMarker(results[0]);
    }
}

function createMarker(place) {
    var placeLoc = place.geometry.location;
    var marker = new google.maps.Marker({
                                        map: map,
                                        position: place.geometry.location
                                        });
    
    google.maps.event.addListener(marker, 'click', function() {
                                  infowindow.setContent(place.name);
                                  infowindow.open(map, this);
                                  });
}

//Get arch distance petween two points via lat and lon.
function distance (latLng1, latLng2)
{
    var lat1 = latLng1.lat();
    var lat2 = latLng2.lat();
    var R = 6371009; // metres
    var dLat = (lat2-lat1).toRad();
    var dLon = (lon2-lon1).toRad();
    var lat1 = lat1.toRad();
    var lat2 = lat2.toRad();
    
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;
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
