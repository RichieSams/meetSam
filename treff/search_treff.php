<?php

session_start();

include_once 'functions.php';
createHeader(array("style.css"), array("validate.js"));

?>

<div class="main_body">
    <div class="jointreff">
        <form id="joinForm" action="process_treff.php" method="POST" onsubmit="return validateJoin();">
            <div class="joinInfo">
                <table>
                    <tr>
                        <td><input type="text" name="name" maxlength="50" placeholder="Email Address" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="meetingId" placeholder="Meeting Id" /></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="street" maxlength="50" size="37" placeholder="Street Address" /></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="city" maxlength="50" placeholder="City" />
                            <input type="text" name="state" maxlength="2" size="3" placeholder="State" />
                            <input type="text" name="zip" maxlength="5" size="5" placeholder="Zip" />
                        </td>
                    </tr>
                </table>
            </div>

            <div class="joinlogin">
                <input class="joinButton" type="submit" value="Submit"/>
            </div>
        </form>
    </div><!--// End of jointreff -->
</div> <!--// End of main_body -->

<?php include 'footer.php'; ?>