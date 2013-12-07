<?php
    include_once 'functions.php';
	session_start();
    $eInfo = $_GET;
    
    if(isset($eInfo["meetingId"]) && checkId(clean($eInfo["meetingId"])) && checkEmail(clean($eInfo["userId"]),clean($eInfo["meetingId"])))
    {
		$email = clean($eInfo["userId"]);
        $treffId = clean($eInfo["meetingId"]);
        $treffName = getName(clean($eInfo["meetingId"]))["name"];
		
		/*$connect = connectMysql();
		$user = $connect->query("SELECT * FROM Users WHERE email='" . $email . "'");
		$row = $result->fetch_assoc();
        
		$street = $row["street"];
		$city = $row["city"];
		$state = $row["state"];
		$zip = $row["zip"];
		$anon = $row["anonymous"];*/

		$street = "";
		$city = "";
		$state = "";
		$zip = "";
		$anon = true;
    }
    else
    {
        $email = "";
        $treffId = "";
        $treffName = " a Treff. How Exciting";
		$street = "";
		$city = "";
		$state = "";
		$zip = "";
		$anon = true;
    }

    createHeader(array("style.css"), array());

?>

<div class="main_body">
	<div class="infoJoin">
		<h1><?php
                 echo 'Joining '.$treffName.'!';
            ?>
        </h1>
	</div> <!--// End of infoJoin -->
    <div class="jointreff">
		 <div class="joinInfo">
         <form action="treff.php" method="post">
            <table>
                <tr>
                    <td><input type="text" name="name" maxlength="50" placeholder="Email Address" value="<?php echo $email?>"/></td>
                </tr>
                <tr>
                    <td><input type="text" name="meetingId" placeholder="Meeting Id" value="<?php echo $treffId?>"/></td>
                </tr>
                <tr>
                    <td><input type="text" name="street" maxlength="50" size="37" placeholder="Street Address" value="<?php echo $street?>"/></td>
                </tr>
				<tr>
                    <td>
						<input type="text" name="city" maxlength="50" placeholder="City" value="<?php echo $city?>"/>
						<input type="text" name="state" maxlength="2" size="3" placeholder="State" value="<?php echo $state?>"/>
						<input type="text" name="zip" maxlength="5" size="5" placeholder="Zip" value="<?php echo $zip?>"/>
				    </td>
                </tr>
				</table>
			</div>
            
        <div class="joinlogin">
            <div class="register">
				<table>
					<tr>
					  <td><button class="joinButton" type="submit" value="Submit" onclick="return validate();">Submit</button></td>
					</tr>
				</form>
                <form action="login.php" method="POST">
					<?php
						if ($anon) {
					echo
					'<tr>
						<td>
						<input class="joinButton" type="submit" value="Login/Register" />
						<input type="hidden" name="redirectUrl" value="jointreff.php" />
						</td>
					</tr>
					</form>';
						}
					?>
				
				</table>
            </div>
        </div>
    </div><!--// End of jointreff -->
</div> <!--// End of main_body -->

<?php include 'footer.php'; ?>