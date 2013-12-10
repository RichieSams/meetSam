<?php

session_start();

include_once 'functions.php';

if (isset($_POST['idHash'])) {
    $idHash = $_POST['idHash'];
} elseif (isset($_GET['idHash'])) {
    $idHash = $_GET['idHash'];
} else {
    errorPage();
}

createHeader(array("style.css"), array("validate.js"));

$connection = connectMySql();

$result = $connection->query("SELECT Meetings.name AS treffName
                              FROM MeetingUsers
                              INNER JOIN Meetings
                              ON Meetings.meetingId = MeetingUsers.meetingId
                              WHERE MeetingUsers.idHash='$idHash'");

$treffName = $result->fetch_assoc()['treffName'];
$result->free();

echo '
<div class="main_body">
    <div class="information">
        <h1>Join "' . $treffName . '"</h1>
        <form id="treffForm" value="process_treff.php" method="POST" onsubmit="return validateJoin();">
            <input type="hidden" name="idHash" value="'. $idHash . '" />
            <table>
                <tr>
                    <td><input type="text" name="email" maxlength="50" placeholder="Email Address"/></td>
                </tr>
                <tr>
                    <td><input type="text" name="street" maxlength="50" size="37" placeholder="Street Address"/></td>
                </tr>
                <tr>
                    <td>
                    <input type="text" name="city" maxlength="50" placeholder="City"/>
                    <input type="text" name="state" maxlength="2" size="3" placeholder="State"/>
                    <input type="text" name="zip" maxlength="5" size="5" placeholder="Zip"/>
                    <input type="hidden" name="country" value="United States" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="createTreff">
        <input class="createButton" type="submit" value="Join Treff!" name="join" />
    </div>
</div>';

include 'footer.php';