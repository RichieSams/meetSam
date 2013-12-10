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

$result = $connection->query("SELECT m.name
                              FROM MeetingUsers AS mu
                              INNER JOIN Meetings AS m
                              ON m.meetingId = mu.meetingId
                              WHERE mu.idHash='$idHash'");

$treffName = $result->fetch_assoc()['name'];
$result->free();

$email = isset($_POST['email']) ? $_POST['email'] : "";

echo '
<div class="main_body">
    <form id="joinForm" action="process_treff.php" method="POST" onsubmit="return validateJoin();">
        <div class="information">
            <h1>Join "' . $treffName . '"</h1>
            <input type="hidden" name="idHash" value="'. $idHash . '" />
            <table>
                <tr>
                    <td><input type="text" name="email" maxlength="50" value="' . $email . '"placeholder="Email Address"/></td>
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
        </div>
        <div class="createTreff">
            <input class="createButton" type="submit" value="Join Treff!" name="join" />
        </div>
    </form>
</div>';

include 'footer.php';