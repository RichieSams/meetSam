<?php
    include_once 'functions.php';
    $eInfo = $_GET;
    
    if(isset($eInfo["id"]) && checkId(clean($eInfo["id"])) && checkEmail(clean($eInfo["email"]),clean($eInfo["id"])))
    {
        $email = clean($eInfo["email"]);
        $treffId = clean($eInfo["id"]);
        $treffName = getName(clean($eInfo["id"]));
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
                <a href="login.php">Login or Register</a>
            </div>
        </div>
    </div><!--// End of jointreff -->
</div> <!--// End of main_body -->

<?php include 'footer.php'; ?>