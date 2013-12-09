<?php

include_once 'functions.php';
require 'lib/vendor/autoload.php';
use Mailgun\Mailgun;

createHeader(array("style.css"), array("validate.js"));

if (isset($_POST["forgot"])){
	$email = $_POST["name"];

    $connection = connectMySql();

    $result = $connection->query("SELECT anonymous
                                  FROM Users
                                  WHERE email='$email'");

	if ($result->num_rows > 0 && $result->fetch_assoc()['anonymous'] != "1") {
		confirmation($connection, $email);
	}
	else{
		initiate(true);
	}

    $result->free();
    $connection->close();
} else {
	initiate(false);
}

include 'footer.php';




function initiate($failed){
echo '<div class="main_body">';
if ($failed){
	echo '<h2>Email does not exist in database.</h2>';
}
	
echo'
		<h2>Please insert your email so we can send you your password.</h2>
		<form id ="forgotForm" action="' . $_SERVER['PHP_SELF'] . '" method="POST" onsubmit="return validateForgot();">
            <table>
				<tr>
                  <td><input type="text" name="name" maxlength="50" placeholder="Email Address"/></td>
				  <td><input class="button" type="submit" value="Send Email" name="forgot" /></td>
				</tr>
			</table>
		</form>
	</div>';
}

function confirmation($connection, $email) {
    // Create entry in sql table
	$timeOut = date("Y-m-d H:i:s", time() + 3600);
	$hash = md5($email . time());

	$connection->query("INSERT INTO ForgottenPassword (hash, email, timeOut)
				VALUES ('$hash', '$email', '$timeOut')");

	// Send emails
	$mg = new Mailgun("key-3g4koukbw35jwaa0ldtd32sqjzq-7948");
	$domain = "treffnow.com";

	$mg->sendMessage($domain,
		array('from'    => 'Treff <noreply@treffnow.com>',
			'to'      => $email,
			'subject' => 'Password Recovery',
			'text'    => "To reset your password go to http://treffnow.com/recover.php?idHash=$hash\n\n" .
						"Happy Treffing,\n" .
						"The Treff Team"));
echo '
	<div class="main_body">
		<h2>A password reset email has been sent to you. Check your email.</h2>
	</div>';
}
