<?php include 'functions.php'; ?>
<?php include 'header.php'; ?>


<div class="main_body">

<?php

$connect = connectMySql();

var_dump($_SESSION["userId"]);
$result = $connect->query("SELECT * FROM Users WHERE userId=" . $_SESSION["userId"]);

$row = $result->fetch_assoc();

echo '<div class="information">
          <h1>Make a Treff</h1>
          <form id="treffForm" action="process.php" method="POST" onsubmit="return validateTreff();">

              <div class="userName">
                  <input type="text" name="userName" maxlength="50" value="'. $row["userId"] .'" placeholder="Email Address"/>
              </div>

              <div class="treffMate">
                  <input type="text" name="treffMate" maxlength="50" placeholder="Treff Mate\'s Email"/>
              </div>

              <div class="street">
                  <input type="text" name="street" maxlength="50" size="37" value="'. $row["street"] .'" placeholder="Street Adress"/>
              </div>

              <div class="city">
                  <input type="text" name="city" maxlength="50" value="'. $row["city"] .'" placeholder="City"/>
              </div>

              <div class="state">
                  <input type="text" name="state" maxlength="2" size="3" value="'. $row["state"] .'" placeholder="State"/>
              </div>

              <div class="zip">
                  <input type="text" name="zip" maxlength="5" size="5" value="'. $row["zip"] .'" placeholder="Zip"/>
              </div>

              <div class="treffName">
                  <input type="text" name="treff" maxlength="100" placeholder="Treff Title"/>
              </div>
          </form>
      </div>
      <div class="createTreff">
          <input class="createButton" type="submit" value="Create Treff!" name="create" />
      </div>';

$result->free();
$connect->close();


echo '</div>'; // End of main_body

include 'footer.php'; ?>