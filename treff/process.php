<?php

session_start();

include_once 'functions.php';
require 'lib/vendor/autoload.php';
use Mailgun\Mailgun;

if (!isset($_SESSION['userId']) || $_SESSION['userId'] == 0) {
    header("Location: index.php");
}

$connect = connectMySql();

// Create entry in Meetings Table
$connect->query("INSERT INTO Meetings (name)
                 VALUES ('" . $_POST['treffName'] . "')");

$meetingId = $connect->insert_id;

// Create a userId for the invitee
// But first, check if their email is already registered
$result = $connect->query("SELECT userId FROM Users WHERE email='" . $_POST['treffMateEmail'] . "'");

if ($result->num_rows > 0) {
    $mateUserId = $result->fetch_assoc()['userId'];
} else {
    $connect->query("INSERT INTO Users (email, anonymous) VALUES('" . $_POST['treffMateEmail'] . "', TRUE);");

    $mateUserId = $connect->insert_id;
}

// Create the idHashes
$creatorIdHash = md5($meetingId . $_SESSION['userId']);
$mateIdHash = md5($meetingId . $mateUserId);

// Create entries in MeetingUsers table
$connect->query("INSERT INTO MeetingUsers (idHash, meetingId, userId, startingStreet, startingCity, startingState, startingZip, startingCountry, confirmed)
                 VALUES ('" . $creatorIdHash. "', " . $meetingId . ", " . $_SESSION['userId'] . ", '" . $_POST['street'] . "', '" . $_POST['city'] . "', '" . $_POST['state'] . "', '" . $_POST['zip'] . "', '" . $_POST['country'] . "', 1),
                        ('" . $mateIdHash. "', " . $meetingId . ", " . $mateUserId . ", NULL, NULL, NULL, NULL, NULL, 0)");

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