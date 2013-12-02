<?php
session_start();

if (isset($_SESSION['userId']) && $_SESSION['userId'] != 0) {
    header("Location: create2.php");
}

include 'functions.php';
createHeader(array("style.css"), array());

echo '
<div class="main_body">
	
	<div class="info">
		<h1>At Treff you have freedom.</h1>
		<p>
            Would you like to Treff with or without an account?<br /><br />
            At Treff you do not need an account. You are able to create an account to personalize 
			your experience to save your default locations and your username so that you
			can create, find, and join a Treff with more ease and speed.
	    </p>
	</div>

	<div class="login">
        <form action="login.php" method="POST">
            <input class="button" type="submit" value="Login/Register" />
            <input type="hidden" name="redirectUrl" value="create2.php" />
        </form>
        <form action="loginProcess.php" method="POST">
            <input class="button" type="submit" value="Register Later" name="anonymous" />
            <input type="hidden" name="redirectUrl" value="create2.php" />
        </form>
	</div>
</div> <!-- End of main_body -->';

include 'footer.php';
