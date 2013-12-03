<?php
    include_once 'functions.php';
	session_start();
    $eInfo = $_GET;
    
    if(isset($eInfo["meetingId"]) && checkId(clean($eInfo["meetingId"])) && checkEmail(clean($eInfo["userId"]),clean($eInfo["meetingId"])))
    {
        $email = clean($eInfo["userId"]);
        $treffId = clean($eInfo["meetingId"]);
        $treffName = getName(clean($eInfo["meetingId"]));
    }
    else
    {
        $email = "";
        $treffId = "";
        $treffName = " a Treff. How Exciting";
    }

    createHeader(array("style.css"), array());

?>

<div class="main_body">
	<div class="infoJoin">
		<h1><?php
                 echo 'Joining'.$treffName.'!';
            ?>
        </h1>
	</div> <!--// End of infoJoin -->
    <div class="jointreff">
         <form action="treff.php" method="post">
            <table>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" value="<?php echo $email?>"></td>
                </tr>
                <tr>
                    <td>Meeting Id:</td>
                    <td><input type="text" name="meetingId" value="<?php echo $treffId?>"></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input type="text" name="address"></td>
                </tr>
                <tr>
                    <td>Zip:</td>
                    <td><input type="text" name="zip"></td>
                </tr>
                <tr>
                    <td><button type="submit" value="Submit" onclick="return validate();">Submit</button></td>
                    <td><button type="reset" value="Reset">Reset</button></td>
                </tr>
            </table>
        </form>
        <div class="joinlogin">
            <div class="register">
                <form action="login.php" method="POST">
					<input class="joinButton" type="submit" value="Login/Register" />
					<input type="hidden" name="redirectUrl" value="jointreff.php" />
				</form>
            </div>
        </div>
    </div><!--// End of jointreff -->
</div> <!--// End of main_body -->

<?php include 'footer.php'; ?>