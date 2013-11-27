<?php

session_start();

include 'functions.php';
createHeader(array("style.css"), array("validate.js"));


$connect = connectMySql();

$result = $connect->query("SELECT * FROM Users WHERE userId=" . $_SESSION["userId"]);

$row = $result->fetch_assoc();

echo '
<div class="main_body">
    <form id="treffForm" action="process.php" method="POST" onsubmit="return validateTreff();">
        <div class="information">
            <h1>Make a Treff</h1>

            <div class="userName">
                <input type="text" name="creatorEmail" maxlength="50" value="'. $row["email"] .'" placeholder="Email Address"/>
            </div>

            <div class="treffMate">
                <input type="text" name="treffMateEmail" maxlength="50" placeholder="Treff Mate\'s Email"/>
            </div>

            <div class="street">
                <input type="text" name="street" maxlength="50" size="37" value="'. $row["street"] .'" placeholder="Street Address"/>
            </div>

            <div class="city">
                <input type="text" name="city" maxlength="50" value="'. $row["city"] .'" placeholder="City"/>
            </div>

            <div class="state">
                <input type="text" name="state" maxlength="2" size="3" value="'. $row["state"] .'" placeholder="State"/>
            </div>

            <div class="zip">
                <input type="text" name="zip" maxlength="5" size="5" value="'. $row["zip"] .'" placeholder="Zip"/>
            </div>

            <div class="treffName">
                <input type="text" name="treffName" maxlength="100" placeholder="Treff Title"/>
            </div>
        </div>
        <div class="createTreff">
            <input class="createButton" type="submit" value="Create Treff!" name="create" />
        </div>
        <input type="hidden" name="startingLat" value="0.0" />
        <input type="hidden" name="startingLon" value="0.0" />
    </form>
</div> <!-- End of main_body -->';

$result->free();
$connect->close();

include 'footer.php';
