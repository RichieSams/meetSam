<?php
include_once 'functions.php';
require 'lib/vendor/autoload.php';
use Mailgun\Mailgun;

createHeader(array("style.css"), array("validate.js"));

if (isset($_POST["forgot"])){
	$email = $_POST["name"];
	if ( inDb("Users", "email", $email) && getAnonEmail($email) != 1) {
		confirmation($email);
	}
	else{
		Echo '<h2>Email does not exist in database.</h2>';
		initiate();
	}
}

else{
	initiate();
}

function initiate(){
echo '
	<div class="main_body">
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

$pass = getPassword("email", $email);

// Send emails
$mg = new Mailgun("key-3g4koukbw35jwaa0ldtd32sqjzq-7948");
$domain = "treffnow.com";


# Send confirmation email to creator
$mg->sendMessage($domain,
    array('from'    => 'Treff <noreply@treffnow.com>',
          'to'      => $email,
          'subject' => 'Password Recovery',
          'text'    => "Your password is $pass." .
                       "Happy Treffing,\n" .
                       "The Treff Team"));
echo '
	<div class="main_body">
		<h2>Your password has been sent to you.</h2>
	</div>';
}

include 'footer.php';