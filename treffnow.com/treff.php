<?php

session_start();

$id = $_GET['idHash'];
include_once 'functions.php';

createHeader(array("style.css"), array(getGoogleMapsJSFilePath(), 'treff_map_functions.js'));

$connection = connectMySql();
//var_dump("SELECT meetingId, userId, startingStreet, startingCity, startingState, startingZip, startingCountry FROM MeetingUsers WHERE idHash='$id'");
$result = $connection->query("SELECT meetingId, userId, startingStreet, startingCity, startingState, startingZip, startingCountry FROM MeetingUsers WHERE idHash='$id'");

$row = $result->fetch_assoc();
$meetingId = $row['meetingId'];
$userId = $row['userId'];
$startingAddress = $row['startingStreet'] . ", " . $row['startingCity'] . ", " . $row['startingState'] . " " . $row['startingZip'] . ", " . $row['startingCountry'];
$result->free();

$result = $connection->query("SELECT midpointStreet, midpointCity, midpointState, midpointZip, midpointCountry, midpointName, status
                              FROM Meetings
                              WHERE meetingId=$meetingId");

$row = $result->fetch_assoc();
$midpointAddress = $row['midpointStreet'] . ", " . $row['midpointCity'] . ", " . $row['midpointState'] . " " . $row['midpointZip'] . ", " . $row['midpointCountry'];
$locName = $row['midpointName'];
$status = $row['status'];
$result->free();

if ($status == 'Ready') {
    echo '
    <script type="text/javascript">
        setMapCenterFromAddress(\'' . $midpointAddress . '\', true, \'' . addslashes($locName) . '\');
    </script>';
} else {
    echo '
    <script type="text/javascript">
        setMapCenterFromAddress(\'2315 Speedway, Austin, TX 78712-1512, United States\', false);
    </script>';
}


echo '
<div class="main_body">
    <div class="infoTreff">
        <div class="status">
            <h1>Status: ' . $status . '</h1>
            <table>
                <tr>
                    <th>User</th>
                    <th>Status</th>
                    <th>Reminder</th>
                </tr>';

$result = $connection->query("SELECT Users.email, (MeetingUsers.startingStreet IS NOT NULL AND MeetingUsers.startingCity IS NOT NULL AND MeetingUsers.startingState IS NOT NULL AND MeetingUsers.startingZip IS NOT NULL AND MeetingUsers.startingCountry IS NOT NULL) AS hasConfirmed
                              FROM MeetingUsers
                              INNER JOIN Users
                              ON Users.userId = MeetingUsers.userId
                              WHERE MeetingUsers.meetingID=$meetingId");

while($row = $result->fetch_assoc()) {
    echo '<tr>
              <td>' . $row['email'] . '</td>
              <td>' . ($row['hasConfirmed'] == '1' ? 'Confirmed' : 'Not Confirmed') . '</td>';

    if ($row['hasConfirmed'] == '0') {
        echo '<td><button type="button" onclick="sendReminderEmail(' .$row['email'] . ');">Send Reminder Email</button>';
    } else {
        echo '<td></td>';
    }

    echo '</tr>';
}

$result->free();

echo '      </table>
        </div>';

if ($status == 'Ready') {
    echo '
        <button type="button" onclick="getDirections(\'' . $startingAddress . '\', \'' . $midpointAddress . '\');"><h1>Get Directions</h1></button>
        <div id="directions-panel"></div>';
}

echo '
	</div>
    <div id="map-canvas"></div>
</div>';

$connection->close();

include 'footer.php';