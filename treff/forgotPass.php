<?php
include_once 'functions.php';
require 'lib/vendor/autoload.php';
use Mailgun\Mailgun;

createHeader(array("style.css"), array("validate.js"));

if (isset($_POST["forgot"])){
	$email = $_POST["name"];
	if ( inDb("Users", "email", $email) && getFromDb("Users", "email", $email, "anonymous") != 1) {
		confirmation($email);
	}
	else{
		initiate(true);
	}
}

else{
	initiate(false);
}

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

function confirmation($email){
	$time = date("Y-m-d H:i:s");
	$timeOut = date("Y-m-d H:i:s", time()+3600);
	$hash = md5($email . $time);
	$connect->query("INSERT INTO ForgotPassword (hash, email, timeOut)
				VALUES ('$hash', '$email', '$timeOut')");

	Send emails
	$mg = new Mailgun("key-3g4koukbw35jwaa0ldtd32sqjzq-7948");
	$domain = "treffnow.com";


	# Send confirmation email to creator
	$mg->sendMessage($domain,
		array('from'    => 'Treff <noreply@treffnow.com>',
			'to'      => $email,
			'subject' => 'Password Recovery',
			'text'    => "To reset your password go to http://treffnow.com/treff/$hash\n\n" .
						"Happy Treffing,\n" .
						"The Treff Team"));*/
echo '
	<div class="main_body">
		<h2>Your password has been sent to you. hash:'. $hash .'$time:'.$time.'timeout:'.$timeOut.'</h2>
	</div>';
}

include 'footer.php';