<?php session_start(); ?>

<html>
<head>
    <title> Astronomy Quiz </title>
    <script type ="text/javascript" src = "validate.js"></script>
</head>
<body>

<?php

if(isset($_POST["loggedIn"])){
    startQuiz();
} else {
    logIn();
}


#################################################################
function logIn(){
    echo '<h1>Log In</h1>
          <form  id="login" action="' . $_SERVER['PHP_SELF'] . '" method="POST"
          onsubmit="return validate();">

          <div class = "userName">
              <label> Name:
                  <input type="text" name="name" maxlength = "30"/>
              </label>
          </div>
          <div class = "password">
              <label> Password:
                <input type = "password" name = "passwd" value = "" maxlength = "30"/>
              </label><br/><br/>
          </div>
          <input type = "submit" value = "Submit" name = "loggedIn"/>
          <input type = "reset" value = "Reset" />
          </form>';
}


//checks for login information and initiates quiz
function startQuiz() {
    $check = false;
    $passwd = $_POST["passwd"];
    $name = $_POST["name"];

    $hasStarted = 0;

    $fileContents = "";
    $file = fopen("passwd.txt", "r");
    while(!feof($file)) {
        $line = fgets($file);
        $lineElements = explode(':', $line);

        if ($name == $lineElements[0] && $passwd == $lineElements[1]) {
            $hasStarted = trim($lineElements[2]);
            $check = true;
        } else {
            $fileContents .= $line;
        }
    }
    fclose($file);

    if (!$check) {
        echo "<h1>Incorrect Username or Password</h1>";
        logIn();
    } else {
        if ($hasStarted == "0") {
            // Check if the user has any time left
            if (!isset($_SESSION["results"])) {

            }
            if (!isset($_SESSION["startTime"])) {
                $_SESSION["startTime"] = time();
            } elseif (time() - $_SESSION["startTime"] > 900) {
                echo "<h3>You are out of time</h3>";

                return;
            }

            if (!isset($_SESSION["questionNumber"])) {
                $_SESSION["questionNumber"] = 1;
            }

            // Update the passwd file to signal that the user has started the test
            $file = fopen("passwd.txt", "w");
            fwrite($file, $fileContents . "$name:$passwd:1");
            fclose($file);

            changeStart($name);
            echo '<p>Thank you for logging in for your quiz. You will have six question on basic Astronomy that you must answer in 15 min. You may only take the quiz once. Good luck!</p>';
            quiz();
        } else {
            echo "<h3>You have already taken the test</h3>";
        }
    }
}


function getQuestion($questionNumber){

}

#################################################################
// will out put and grade questions
function quiz(){

}

?>

</body>
</html>