<?php
session_start();
include_once 'functions.php';
createHeader(array("style.css"), array("https://maps.googleapis.com/maps/api/js?key=".$goKey."&sensor=true","jsfunctions.js", "validate.js"));


$connect = connectMySql();

$result = $connect->query("SELECT * FROM Users WHERE userId=" . $_SESSION["userId"]);

$row = $result->fetch_assoc();

echo '
<div class="main_body">
	<div class="information">
		<h1>Make a Treff</h1>
		<form id="treffForm" action="process.php" method="POST" onsubmit="return validateTreff();">
			<table>
				<tr>
					<td><input type="text" name="creatorEmail" maxlength="50" value="'. $row["email"] .'" placeholder="Email Address"/></td>
				</tr>
				<tr>
					<td><input type="text" name="treffMateEmail" maxlength="50" placeholder="Treff Mate\'s Email"/></td>
				</tr>
				<tr>
					<td><input type="text" name="street" maxlength="50" size="37" value="'. $row["street"] .'" placeholder="Street Address"/></td>
				</tr>
				<tr>
					<td>
					<input type="text" name="city" maxlength="50" value="'. $row["city"] .'" placeholder="City"/>
					<input type="text" name="state" maxlength="2" size="3" value="'. $row["state"] .'" placeholder="State"/>
					<input type="text" name="zip" maxlength="5" size="5" value="'. $row["zip"] .'" placeholder="Zip"/>
					</td>
				</tr>
				<tr>
					<td><input type="text" name="treffName" maxlength="50" placeholder="Treff Name"/></td>
				</tr>
			</table>
			
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
