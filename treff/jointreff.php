<?php
    include 'functions.php';
    $eInfo = $_GET;
    
    if(checkId(clean($eInfo["id"])) && checkEmail(clean($eInfo["email"]),clean($eInfo["id"])))
    {
        $email = clean($eInfo["email"]);
        $treffId = clean($eInfo["id"]);
    }
?>

<?php include 'header.php'; ?>

<div class="main_body">
	<div class="infoJoin">
		<h1><?php
                 echo 'Joining ' . getName(clean($eInfo["id"])) . '!';
            ?>
            </h1>
	</div> <!--// End of infoJoin -->
    <div class="jointreff">
         <form action="" method="post">
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
                    <td><button type="submit" value="" name="" onclick="return validator();">Submit</button></td>
                    <td><button type="reset" value="Reset">Reset</button></td>
                </tr>
            </table>
        </form>
    </div><!--// End of jointreff -->
</div> <!--// End of main_body -->

<?php include 'footer.php'; ?>