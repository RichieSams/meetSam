<?php

session_start();

include_once 'functions.php';
require 'lib/vendor/autoload.php';
use Mailgun\Mailgun;

if (isset($_POST))
{
    $formData = $_POST;
}
else
{
    // Redirect
    errorPage();
}


$connect = connectMySql();

$meetingId = $connect->insert_id;

// Create a userId for the invitee
// But first, check if their email is already registered
$result = $connect->query("SELECT userId, meetingId FROM MeetingUsers WHERE idHash='" . $formData['idHash'] . "'");

if ($result->num_rows == 1) {
    $mateUserId = $result->fetch_assoc()['userId'];
    $meetingId = $result->fetch_assoc()['meetingId'];
} else {
    // Redirect
    errorPage();
}

// Update entries in MeetingUsers table
$result = $connect->query("UPDATE MeetingUsers
                            SET startingStreet ='" . $formData['street'] . "',
                            startingCity = '" . $formData['city'] . "',
                            startingState = '" . $formData['state']  . "',
                            startingZip = '" . $formData['zip'] . "',
                            startingCountry = '" . $formData['country'] . "',
                            confirmed = 1
                            WHERE idHash = '" . $formData['idHash'] . "'");//"

if($result)
{
    // Update status of Meetings
    $connect->query("UPDATE Meetings
                        SET status = 'Processing',
                        WHERE idHash = '" . $meetingId . "'");
}
else
{
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