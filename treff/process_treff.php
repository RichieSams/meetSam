<?php

session_start();

include_once 'functions.php';
require 'lib/vendor/autoload.php';
use Mailgun\Mailgun;

if (isset($_POST)) {
    $formData = $_POST;
} else {
    // Redirect
    errorPage();
}

////////// Global Varialbles //////////////

//    Google API key: AIzaSyAjxT5HgGwUQy1E9P6_8vcvo7q_i7Z1mx4
    $goKey = "AIzaSyDzzYC0JTMf2UPapIJXkNbv9NEobpCBfPQ";

//Get place Variables
$typePlace = "cafe";
$radius = 50;
$midStreet;
$midCity;
$midState;
$midName;

//Variables for calculating
$halfDist;
$totStepd = 0;
$startPoint; $lastStepS; $lastStepE; $endPoint; $totPath;

$emails = array();
$idHashes = array();
$addresses = array();


////////// Global Varialbles /////////////


$connect = connectMySql();

$result = $connect->query("SELECT userId, meetingId FROM MeetingUsers WHERE idHash='" . $formData['idHash'] . "'");

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    $mateUserId = $row['userId'];
    $meetingId = $row['meetingId'];

    $result->free();
} else {
    // Redirect
    errorPage();
}

// Update entries in MeetingUsers table
$result = $connect->query("UPDATE MeetingUsers
                           SET startingStreet = '" . $formData['street'] . "',
                               startingCity = '" . $formData['city'] . "',
                               startingState = '" . $formData['state']  . "',
                               startingZip = '" . $formData['zip'] . "',
                               startingCountry = '" . $formData['country'] . "',
                               confirmed = 1
                           WHERE idHash = '" . $formData['idHash'] . "'");

if($result) {
    // Update status of Meetings
    $connect->query("UPDATE Meetings
                     SET status = 'Processing',
                     WHERE idHash = '" . $meetingId . "'");
} else {
    // Redirect
    errorPage();
}

$result = $connect->query("SELECT u.email, mu.idHash, mu.startingStreet, mu.startingCity, mu.startingState, mu.startingZip, mu.startingCountry
                           FROM MeetingUsers AS mu
                           INNER JOIN Users AS u
                           ON mu.userId = u.userId
                           WHERE meetingId=$meetingId");

$index = 0;
while ($row = $result->fetch_assoc()) {
    $emails[$index] = $row['email'];
    $idHashes[$index] = $row['idHash'];
    $addresses[$index] = $row['startingStreet'] . ", " . $row['startingCity'] . ", " . $row['startingState'] . " " . $row['startingZip'] . ", " . $row['startingCountry'];
    $index++;
}


$result->free();

$result = curl_get("http://maps.googleapis.com/maps/api/directions/json", array("origin"=>$addresses[0], "destination"=>$addresses[1], "sensor"=>"false"));

$json = json_decode($result, true);

$polyline = $json['routes'][0]['overview_polyline']['points'];
$points = decodePolyLine($polyline);

$startPoint = new LatLng($json['routes'][0]['legs'][0]['start_location']['lat'],$json['routes'][0]['legs'][0]['start_location']['lng']);
$endPoint = new LatLng($json['routes'][0]['legs'][0]['end_location']['lat'], $json['routes'][0]['legs'][0]['end_location']['lng']);

$totalDistance = $json['routes'][0]['legs'][0]['distance']['value'];


//Get the start and end address for specific meeting for 
function getTreff ($addresses, $totalDistance, $points)
{
    //Creat Half of the driving distance
    $halfDist = $totalDistance/2;
    
    $i = 0;
    while(checkRange($totStepd) == "low")
    {
        $totStepd += archDist($points[$i], $points[$i+1]);
        $lastStepS = $points[$i];
        $lastStepE = $points[$i+1];
        $i++;
    }
    
    if(checkRange($totStepd) == "good")
    {
        $midpoint = getPlace($lastStepE);
        goTable();
    }
    elseif(checkRange($totStepd) == "high")
    {
        calcMidpoint();
        goTable();
    }
    
}


//Final Put in to Table
function goTable()
{
    $result = $connect->query("UPDATE Meetings
                           SET midpointStreet = '" . $midStreet . "',
                               midpointCity = '" . $midCity . "',
                              midpointState = '" . $midState . "',
                              midpointCountry = '" . $midCountry . "',
                              midpointName = '" . $midName . "',
                              midpointLat = '" . $midpoint->lat . "',
                              midpointLng = '" . $midpoint->lng . "',
                           WHERE meetingId = '" .  $meetingId ");
    
    if($result)
    {
        // Update status of Meetings
        $connect->query("UPDATE Meetings
                         SET status = 'Ready',
                         WHERE idHash = '" . $meetingId . "'");
        header('Location: http://treffnow.com/treff.php?idHash='.formData['idHash'], TRUE);
    }
    else
    {
        errorPage();
    }
}


//Get places around a LatLng
function getPlace($location)
{
    $locationString = $location->lat.",".$location->lng;
    $place = curl_get("http://maps.googleapis.com/maps/api/place/nearbysearch/json","location"=>$locationString, "radius"=>$radius, "types"=>$typePlace, "sensor"=>"false","key"=>$goKey));
    if($place->status = "OK")
    {
        $placeArray = explode($place->formatted_address);
        $midStreet = $placeArray[0];
        $midCity = $placeArray[count($placeArray)-1];
        $midCountry = $placeArray[count($placeArray)];
        $midName = $place->name;
        return $place->location;
    }
    elseif($place->status = "ZERO_RESULTS")
    {
        $radius += 50;
        getPlace($location);
    }
    else
    {
        errorPage();
    }
}

//Calculate the mid point if out side of range
function calcMidpoint()
{
    $a = cartesian($endpoint);
    $b = cartesian($lastStepS);
    $c = cartesian($lastStepE);
    
    $midpointLat = 1/3*(a->lat+b->lat+c->lat);
    $midpointLng = 1/3*(a->lng+b->lng+c->lng);

    $midpoint = new LatLng($midpointLat, $midpointLng)

    getPlace($midpoint)
}

//Get the cartesianconversion
function cartesian($latLng)
{
    $R = 6371009;
    $x = $R*sin(90-$latLng->lat)*cas($latLng->lng);
    $y = $R*sin(90-$latLng->lat)*sin($latLng->lng);
    
    $ll = new LatLng($x,$y);
    
    return $ll;
}

//Get arch distance petween two points via lat and lon.
function archDist($latLng1, $latLng2)
{

    //Get the relation of two points
    $lat1 = deg2rad(latLng1->lat);
    $lon1 = deg2rad(latLng1->lng);
    $lat2 = deg2rad(latLng2->lat);
    $lon2 = deg2rad(latLng2->lng);
    $R = 6371009; // metres
    $dLat = (lat2-lat1);
    $dLon = (lon2-lon1);
    
    $a = sin(dLat/2) * sin(dLat/2) + sin(dLon/2) * sin(dLon/2) * cos(lat1) * cos(lat2);
    $c = 2 * atan2(sqrt(a), sqrt(1-a));
    $d = R * c;
    
    return $d;
    
    //Get the mid point as the crow flies
    $Bx = cos(lat2) * cos(dLon);
    $By = cos(lat2) * sin(dLon);
    $lat3 = atan2(sin(lat1)+sin(lat2),
                          sqrt( (cos(lat1)+Bx)*(cos(lat1)+Bx) + By*By ) );
    $lon3 = lon1 + atan2(By, cos(lat1) + Bx);
    
    //Convert back to dgrees
    lat3 = rad2deg(lat3);
    lon3 = rad2deg(lon3);
    
    //Create and return Goggle latlng object
    $middlePoint = "new google.maps.LatLng(lat3, lon3)";

    //return middlePoint;
}

//Check mid point to see if within range.
function checkRange($midDistance)
{
    $percentCalc = midDistance/halfDist;
    if(percentCalc <= 1.5)
    {
        if(percentCalc >= .95)
        {
            //alert("good"+percentCalc);
            return "good";
        }
        else
        {
            //alert("low"+percentCalc);
            return "low";
        }
    }
    else
    {
        //alert("high"+percentCalc);
        return "high";
    }
}


// Get the meeting name
$result = $connect->query("SELECT name
                           FROM Meetings
                           WHERE meetingId=$$meetingId");

$meetingName = $result->fetch_assoc()['name'];
$result->free();

// Send emails
$mg = new Mailgun("key-3g4koukbw35jwaa0ldtd32sqjzq-7948");
$domain = "treffnow.com";

for ($i = 0; $i < count($emails); $i++) {
    $mg->sendMessage($domain,
        array('from'    => 'Treff <noreply@treffnow.com>',
            'to'      => $emails[$i],
            'subject' => 'Your Treff "' . $meetingName . '" is Ready',
            'text'    => "Thank you for using Treff! We hope your experience was simple and timely.\n\n" .
                         "This is a notification that everyone in your Treff has confirmed and the meeting point has been determined. Below is a link to the meeting main page.\n" .
                         "http://treffnow.com/treff/" . $idHashes[$i] . "\n\n" .
                         "Happy Treffing,\n" .
                         "The Treff Team"));
}


//header("Location: treff.php?idHash=$creatorIdHash");
