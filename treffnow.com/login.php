<?php


if (isset($_SESSION['userId']) && $_SESSION['userId'] != 0) {
    header("Location: " . $_POST["redirectUrl"]);
}

include_once 'functions.php';
createHeader(array("style.css"), array("http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js#sthash.J5zZTqH1.dpuf", "validate.js"));

echo '
<script src="lib/sha3.js"></script>

<div class="main_body">
	
	<div class="signin">
		<h2>Login</h2>
		<form id ="loginForm" action="loginprocess.php" method="POST" onsubmit="return validateLogin();">
            <table>
				<tr>
                  <td><input type="email" name="name" maxlength="50" placeholder="Email Address"/></td>
				</tr>
				<tr>
                  <td><input type="password" name="pass" maxlength="32" placeholder="Password"/></td>
				</tr>
				<tr>
				  <td><a href="forgotPass.php">Forgot Your Password?</a></td>
				</tr>
			</table>
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
		<form id = "registrationForm" action="loginprocess.php"	method="POST" onsubmit="return validateRegistration();" >

            <table>
				<tr>
					<td><input  class = "valEmail" type="email" name="name" maxlength="50" placeholder="Email Address"  onchange="validateEmailAjax();"/>
					<span class="valEmail"></span></td>
				</tr>
				<tr>
					<td><input type="text" name="street" maxlength="50" size="37" placeholder="Street Adress"/></td>
				</tr>
				<tr>
					<td>
					<input type="text" name="city" maxlength="50" placeholder="City"/>
					<input type="text" name="state" maxlength="2" size="3" placeholder="State"/>
					<input type="text" name="zip" maxlength="5" size="5" placeholder="Zip"/
					</td>
				</tr>
				<tr>
					<td>
						<input class = "valPass" type="password" name="pass1" maxlength="32" placeholder="Password" onchange="validatePassAjax();"/> 
						<span class="valPass"></span>
					</td>
				</tr>
				<tr>
					<td><input type="password" name="pass2" maxlength="32" placeholder="Confirm Password"/></td>
				</tr>
				<tr>
					<td><div class="requirements">*6-32 characters with at least one number(!, _, - Allowed)</div></td>
				</tr>
			</table>

            <div class="button2">
              <input class="button" type="submit" value="Register" name="register" />
            </div>

            <input type="hidden" name="redirectUrl" value="'. $_POST["redirectUrl"] .'" />

        </form>
	</div>
</div>'; // End of main body


include 'footer.php';