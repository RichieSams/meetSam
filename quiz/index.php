<?php
// TODO: Add logic to store the session ID in a cookie just in case the user's browser crashes or they accidentally close the window
    date_default_timezone_set('America/Chicago');
    session_start();
?>

<html>
<head>
    <title> Astronomy Quiz </title>
    <link rel="stylesheet" type="text/css" href="style.css" media="all" />
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

        getQuestion($_SESSION["questionNumber"]);
    } else {
        startQuiz();
    }
}
elseif(!isset($_SESSION["ID"]))
{
    createLoginForm();
}
elseif(isset($_COOKIE['PHPSESSID']))
{
    if (time() - $_SESSION["startTime"] > 900) {
        echo "<h3>You are out of time</h3>";

        // Write results to file
        $file = fopen("results.txt", "a");
        fwrite($file, $_SESSION["userName"] . ":" . $_SESSION['questionsRight'] . "\n");
        fclose($file);
        return;
    }

    gradeQuestion($_SESSION["questionNumber"]);

    if ($_SESSION["questionNumber"] == 7) {
        echo '<p>Thank you! The Quiz is over! You got ' . $_SESSION["questionsRight"] . ' questions correct.</p>';

        // Write results to file
        $file = fopen("results.txt", "a");
        fwrite($file, $_SESSION["userName"] . ":" . $_SESSION['questionsRight'] . "\n");
        fclose($file);

        session_destroy();
    } else {
        echo getQuestion($_SESSION["questionNumber"]);
    }
}
else
{
    echo "Oops Oh No There is An Issue!";
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
              <div class="buttons">
                  <input type="submit" value="Submit" name="loggedIn" />
                  <input type="reset" value="Reset" />
              </div>
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
            $_SESSION["ID"] = $_COOKIE['PHPSESSID'];
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
            return;
        }
    }
    fclose($file);

    // Start the user
    $file = fopen("started.txt", "a");
    fwrite($file, $_SESSION["userName"] . "\n");
    fclose($file);

    $_SESSION["results"] = 0;
    $_SESSION["startTime"] = time();
    $_SESSION["questionNumber"] = 1;
    $_SESSION["questionsRight"] = 0;

    echo '<p>Thank you for logging in for your quiz. You will have six questions on basic Astronomy that you must answer in 15 min. You may only take the quiz once. Good luck!</p>';
    echo getQuestion($_SESSION["questionNumber"]);
}

function gradeQuestion($questionNumber) {
    $answerKey = array("circle"=>"False","solar"=>"True","star"=>"2","longest"=>"4","collection"=>"galaxy","hubble"=>"age");
    $formNames = array("1"=>"circle","2"=>"solar","3"=>"star","4"=>"longest","5"=>"collection","6"=>"hubble");
    $fieldName = $formNames[$questionNumber];

    if (!isset($_POST[$fieldName]) || !isset($answerKey[$fieldName]))
        return;

    //Comparison if statements for the actual grading. splint in to all questions before last and last question as else.
    if($_POST[$fieldName] == $answerKey[$fieldName]) {
        $_SESSION["questionsRight"]++;
    }

    $_SESSION["questionNumber"]++;
}

function getQuestion($questionNumber){
    
    //Array of the test unique to the questions
    $questionText = array('>According to Kepler the orbit of the earth is a circle with the sun at the center.</td>
                          <td><input type="radio" name="circle" value="True">True</td>
                          <td><input type="radio" name="circle" value="False">False</td>
                          </tr>
                          <tr></tr>',
                          '>Ancient astronomers did consider the heliocentric model of the solar system but rejected it because they could not detect parallax.</td>
                          <td><input type="radio" name="solar" value="True">True</td>
                          <td><input type="radio" name="solar" value="False">False</td>
                          </tr>
                          <tr></tr>',
                          '>The total amount of energy that a star emits is directly related to its </td>
                          <td><input type="radio" name="star" value="1">Surface gravity and magnetic field</td>
                          <td><input type="radio" name="star" value="2">Radius and temperature</td>
                          <td><input type="radio" name="star" value="3">Pressure and volume </td>
                          <td><input type="radio" name="star" value="4">Location and velocity </td>
                          </tr>
                          <tr></tr>',
                          '>Stars that live the longest have </td>
                          <td><input type="radio" name="longest" value="1">High mass</td>
                          <td><input type="radio" name="longest" value="2">High temperature</td>
                          <td><input type="radio" name="longest" value="3">Lots of hydrogen</td>
                          <td><input type="radio" name="longest" value="4">Small mass </td>
                          </tr>
                          <tr></tr>',
                          '>A collection of a hundred billion stars, gas, and dust is called a </td>
                          <td><input type="text" name="collection">.</td>
                          </tr>
                          <tr></tr>',
                          '>The inverse of the Hubble\'s constant is a measure of the </td>
                          <td><input type="text" name="hubble">of the universe.</td>
                          </tr>
                          <tr></tr>');
      
    // Full HTML of the question with referance to the array for the question number.
                          $questionHTML = '<form name="quizQ" action="" target="_self" method="post"><table><tr><td width="auto"'.$questionText[$questionNumber-1].'<td><button type="submit" value="Submit" onclick="gradeQuestion($questionNumber);">Submit</button></td><td><button type="reset" value="Reset">Clear</button></td></tr></table></form>';
                          
    return $questionHTML;
}

?>

</body>
</html>