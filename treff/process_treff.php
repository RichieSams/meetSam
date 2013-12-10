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
$map;
$geocoder;
$bounds = "new google.maps.LatLngBounds()";
$markersArray = [];

//Needed for directions piece
$directionsDisplay;
$directionsService = "new google.maps.DirectionsService()";

//Get place Variables
$typePlace = "cafe";
$infowindow;

//Start and end Point Variables
$origin1 = '303 w 35th, Austin, Tx';
$destinationA = '3201 Guadalupe St, Austin, TX';

//Variables for
$halfDist;
$totStepd = 0;
$firstStep, $lastStepS, $lastStepE, $endPoint, $totPath;

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
                
// Send emails
$mg = new Mailgun("key-3g4koukbw35jwaa0ldtd32sqjzq-7948");
$domain = "treffnow.com";


# Send confirmation email to creator
$mg->sendMessage($domain,
    array('from'    => 'Treff <noreply@treffnow.com>',
          'to'      => $_POST['creatorEmail'],
          'subject' => 'Confirmation for creating the Treff "' . $_POST['treffName'] . '"',
          'text'    => "Thank you for using Treff! We hope your experience was simple and timely.\n\n" .
                       "This is a confirmation email for the Treff you created. Below is a link to the meeting main page.\n" .
                       "http://treffnow.com/treff/$creatorIdHash\n\n" .
                       "Happy Treffing,\n" .
                       "The Treff Team"));

# Send confirmation email to mate
$mg->sendMessage($domain,
    array('from'    => 'Treff <noreply@treffnow.com>',
          'to'      => $_POST['treffMateEmail'],
          'subject' => 'Invitation to Treff "' . $_POST['treffName'] . '"',
          'text'    => "Welcome to Treff, a service for creating meeting points between people!\n\n" .
                       $_POST['creatorEmail'] . " has invited you to their Treff. Below is a link to the meeting main page.\n" .
                       "http://treffnow.com/join/$mateIdHash\n\n" .
                       "Happy Treffing,\n" .
                       "The Treff Team"));


header("Location: treff.php?idHash=$creatorIdHash");





//Find the Driving Distanc Mid point
function getLatlng(location)
{
    
}

//Get Lat Lngs
function getLatlng(location)
{

}


//Get places around a LatLng
function getPlace(location)
{

}

//Get arch distance petween two points via lat and lon.
function archDist(latLng1, latLng2)
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
function checkRange(midDistance)
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



