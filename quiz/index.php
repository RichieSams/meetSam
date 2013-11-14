<?php
// TODO: Add logic to store the session ID in a cookie just in case the user's browser crashes or they accidentally close the window
session_start();
?>

<html>
<head>
    <title> Astronomy Quiz </title>
    <script type ="text/javascript" src = "validate.js"></script>
</head>
<body>

<?php

// TODO: Perhaps split some of this logic into separate php files?

if(isset($_POST["loggedIn"])){
    if (!checkLogin()) {
        echo "<h1>Incorrect Username or Password</h1>";
        createLoginForm();
        return;
    }

    if (isset($_SESSION["questionNumber"])) {
        // Check if user has time left
        if (time() - $_SESSION["startTime"] > 900) {
            echo "<h3>You are out of time</h3>";

            // Write results to file
            $file = fopen("results.txt", "a");
            fwrite($file, $_SESSION["userName"] . ":" . $_SESSION['results'] . "\n");
            fclose($file);
            return;
        }

        gradeQuestion($_SESSION["questionNumber"]);
        getQuestion(++$_SESSION["questionNumber"]);
    } else {
        startQuiz();
    }
} else {
    createLoginForm();
}


function createLoginForm(){
    echo '<h1>Log In</h1>
          <form action="' . $_SERVER['PHP_SELF'] . '" method="POST" onsubmit="return validate();">
              <div class="userName">
                  <label> Name:
                      <input type="text" name="name" maxlength="30" />
                  </label>
              </div>
              <div class="password">
                  <label> Password:
                      <input type="password" name="pass" maxlength="30" />
                  </label>
                  <br/><br/>
              </div>
              <input type="submit" value="Submit" name="loggedIn" />
              <input type="reset" value="Reset" />
          </form>';
}


function checkLogin() {
    $name = $_POST["name"];
    $pass = $_POST["pass"];

    $file = fopen("passwd.txt", "r");
    while(!feof($file)) {
        $line = trim(fgets($file));
        $lineElements = explode(':', $line);

        if ($name == $lineElements[0] && $pass == $lineElements[1]) {
            fclose($file);
            $_SESSION["userName"] = $name;
            return true;
        }
    }

    fclose($file);
    return false;
}


function startQuiz() {
    // Find out if the user has already started the test
    $file = fopen("started.txt", "r");
    while(!feof($file)) {
        $line = trim(fgets($file));
        $lineElements = explode(':', $line);

        if ($_SESSION["userName"] == $lineElements[0]) {
            echo "<h3>You have already taken the test</h3>";
            fclose($file);
            return;
        }
    }
    fclose($file);

    // Start the user
    fopen("started.txt", "a");
    fwrite($file, $_SESSION["userName"] . "\n");
    fclose($file);

    $_SESSION["results"] = 0;
    $_SESSION["startTime"] = time();
    $_SESSION["questionNumber"] = 1;

    echo '<p>Thank you for logging in for your quiz. You will have six question on basic Astronomy that you must answer in 15 min. You may only take the quiz once. Good luck!</p>';
    getQuestion($_SESSION["questionNumber"]);
}

function gradeQuestion($questionNumber) {

}

function getQuestion($questionNumber){
    $question = array( '<form></form>',
                       '<form></form>');



    return $question[$questionNumber];
}

?>

</body>
</html>