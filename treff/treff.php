<?php

session_start();

$id = $_GET['idHash'];
include_once 'functions.php';

createHeader(array("style.css"), array(getGoogleMapsJSFilePath(), 'google_map_functions.js', 'treff_map.js'));

$connection = connectMySql();

$result = $connection->query("SELECT meetingId, userId FROM MeetingUsers WHERE idHash='$id'");

$row = $result->fetch_assoc();
$meetingId = $row['meetingId'];
$userId = $row['userId'];
$result->free();

$result = $connection->query("SELECT midpointLat, midpointLng
                              FROM Meetings
                              WHERE meetingId=$meetingId");

$row = $result->fetch_assoc();
$midpointLat = $row['midpointLat'];
$midpointLng = $row['midpointLng'];
$result->free();

echo '
<script type="text/javascript">
    var latLng = new google.maps.LatLng(' . $midpointLat . ', ' . $midpointLng .');
    setMapCenterFromLatLng(latLng)
</script>';


echo '
<div class="main_body">
    <div class="infoTreff">
        <div class="status">
            <h1>Status:</h1>
            <table>
                <tr>
                    <th>User</th>
                    <th>Status</th>
                    <th>Reminder</th>
                </tr>';

$result = $connection->query("SELECT Users.email, (MeetingUsers.startingLat IS NOT NULL AND MeetingUsers.startingLng IS NOT NULL) AS hasConfirmed
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
        </div>
        <button type="button" onclick="getDirections(' . getAddress('id') .');"><h1>Get Directions</h1></button>

        <div id="directions-panel">Click on buttons above for more info.
        </div>
	</div>
    <div id="map-canvas"></div>
</div>';

$connection->close();

include 'footer.php';