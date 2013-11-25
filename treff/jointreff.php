<?php
    include 'functions.php';
    htmlspecialchars($_GET["id"]) . '!';
?>

<?php include 'header.php'; ?>

<div class="main_body">
	<div class="infoJoin">
		<h1><?php
                if(isset($_GET["id"]))
                {
                    echo 'Joining ' . htmlspecialchars($_GET["id"]) . '!';

                }
            ?>
            </h1>
	</div>
    <div class="jointreff">
         <form action="" method="post">
            <table>
                <tr>
                    <td>First Name:</td>
                    <td><input type="text" name="email"></td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td><input type="text" name="lname"></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input type="text" name="strtaddress"></td>
                </tr>
                <tr>
                    <td>City:</td>
                    <td><input type="text" name="city"></td>
                </tr>
            </table>
        </form>
    </div>
</div> <!-- End of main_body -->

<?php include 'footer.php'; ?>