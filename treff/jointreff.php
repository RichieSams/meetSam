<?php

session_start();

include_once 'functions.php';
createHeader(array("style.css"), array("validate.js"));

echo '
<div class="main_body">
    <div class="information">
        <h1>Make a Treff</h1>
        <form id="treffForm" value="'. $_SERVER['PHP_SELF'] . '" method="POST" onsubmit="return validateJoin();">
            <input type="hidden" name="idHash" value="' . $_POST['idHash'] . '" />
            <table>
                <tr>
                    <td><input type="text" name="email" maxlength="50" placeholder="Email Address"/></td>
                </tr>
                <tr>
                    <td><input type="text" name="street" maxlength="50" size="37" placeholder="Street Address"/></td>
                </tr>
                <tr>
                    <td>
                    <input type="text" name="city" maxlength="50" placeholder="City"/>
                    <input type="text" name="state" maxlength="2" size="3" placeholder="State"/>
                    <input type="text" name="zip" maxlength="5" size="5" placeholder="Zip"/>
                    <input type="hidden" name="country" value="United States" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="createTreff">
        <input class="createButton" type="submit" value="Join Treff!" name="join" />
    </div>
</div>';

include 'footer.php';