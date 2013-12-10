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


$result = $connect->query("SELECT startingStreet, startingCity, startingState, startingZip, startingCountry
                           FROM MeetingUsers
                           WHERE meetingId=$meetingId");

$addresses = array();
$index = 0;
while ($row = $result->fetch_assoc()) {
    $addresses[$index] = $row['startingStreet'] . ", " . $row['startingCity'] . ", " . $row['startingState'] . " " . $row['startingZip'] . ", " . $row['startingCountry'];
    $index++;
}

$result = curl_get("http://maps.googleapis.com/maps/api/directions/json", array("origin"=>$addresses[0], "destination"=>$addresses[1], "sensor"=>"false"));
$json = json_decode($result, true);

$polyline = $json['routes'][0]['overview_polyline']['points'];
$points = decodePolyLine($polyline);

foreach ($points as $point) {
    echo $point->lat . ", " . $point->lng . '<br />';
}


//// Send emails
//$mg = new Mailgun("key-3g4koukbw35jwaa0ldtd32sqjzq-7948");
//$domain = "treffnow.com";
//
//
//# Send confirmation email to creator
//$mg->sendMessage($domain,
//    array('from'    => 'Treff <noreply@treffnow.com>',
//          'to'      => $_POST['creatorEmail'],
//          'subject' => 'Confirmation for creating the Treff "' . $_POST['treffName'] . '"',
//          'text'    => "Thank you for using Treff! We hope your experience was simple and timely.\n\n" .
//                       "This is a confirmation email for the Treff you created. Below is a link to the meeting main page.\n" .
//                       "http://treffnow.com/treff/$creatorIdHash\n\n" .
//                       "Happy Treffing,\n" .
//                       "The Treff Team"));
//
//# Send confirmation email to mate
//$mg->sendMessage($domain,
//    array('from'    => 'Treff <noreply@treffnow.com>',
//          'to'      => $_POST['treffMateEmail'],
//          'subject' => 'Invitation to Treff "' . $_POST['treffName'] . '"',
//          'text'    => "Welcome to Treff, a service for creating meeting points between people!\n\n" .
//                       $_POST['creatorEmail'] . " has invited you to their Treff. Below is a link to the meeting main page.\n" .
//                       "http://treffnow.com/join/$mateIdHash\n\n" .
//                       "Happy Treffing,\n" .
//                       "The Treff Team"));
//
//
//header("Location: treff.php?idHash=$creatorIdHash");
