<?php


if (isset($_SESSION['userId']) && $_SESSION['userId'] != 0) {
    header("Location: " . $_POST["redirectUrl"]);
}

include 'functions.php';
createHeader(array("style.css"), array("validate.js"));

echo '
<script src="lib/sha3.js"></script>

<div class="main_body">
	
	<div class="signin">
		<h2>Login</h2>
		<form id ="loginForm" action="loginProcess.php" method="POST" onsubmit="return validateLogin();">
            <div class="userName">
                  <input type="text" name="name" maxlength="50" placeholder="Email Address"/>
            </div>

            <div class="password">
                  <input type="password" name="pass" maxlength="32" placeholder="Password"/>
            </div>

            <div class="button1">
              <input class="button" type="submit" value="Login" name="loggedIn" />
            </div>

            <input type="hidden" name="redirectUrl" value="'. $_POST["redirectUrl"] .'" />
        </form>
	</div>

	<div class="or">
		<h1>OR</h1>
	</div>

	<div class="registration">
		<h2>Register</h2>
		<form id = "registrationForm" action="loginProcess.php"
				method="POST" onsubmit="return validateRegistration();">

            <div class="regUserName">
                  <input type="text" name="name" maxlength="50" placeholder="Email Address"/>
            </div>

            <div class="street">
                  <input type="text" name="street" maxlength="50" size="37" placeholder="Street Adress"/>
            </div>

            <div class="city">
                  <input type="text" name="city" maxlength="50" placeholder="City"/>
            </div>

            <div class="state">
                  <input type="text" name="state" maxlength="2" size="3" placeholder="State"/>
            </div>

            <div class="zip">
                  <input type="text" name="zip" maxlength="5" size="5" placeholder="Zip"/>
            </div>

            <div class="regPassword1">
                  <input type="password" name="pass1" maxlength="32" placeholder="Password"/>
            </div>

            <div class="requirements">
                *6-32 characters with at least one number
            </div>

            <div class="regPassword2">
                  <input type="password" name="pass2" maxlength="32" placeholder="Confirm Password"/>
            </div>

            <div class="button2">
              <input class="button" type="submit" value="Register" name="register" />
            </div>

            <input type="hidden" name="redirectUrl" value="'. $_POST["redirectUrl"] .'" />

        </form>
	</div>
</div>'; // End of main body


include 'footer.php';