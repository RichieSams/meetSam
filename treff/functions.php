<?php
    //----------Global Varieables------------->
    
//    Google API key: AIzaSyAjxT5HgGwUQy1E9P6_8vcvo7q_i7Z1mx4
$goKey = 'AIzaSyDzzYC0JTMf2UPapIJXkNbv9NEobpCBfPQ';
    
    //------End Global Varieables------------->

function createHeader($cssFiles, $javascriptFiles) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Treff</title>
        <link rel="icon" href="favicon.ico" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />';

    foreach ($cssFiles as $file) {
        echo '<link rel="stylesheet" type="text/css" href="' . $file . '" media="all" />';
    }

    foreach ($javascriptFiles as $file) {
        echo '<script type ="text/javascript" src = "' . $file . '"></script>';
    }

    echo '
    </head>
    <body>
    <div class="header">
        <div class="title"><a href="index.php"><img src="images/treff_medium.png" /></a></div>
        <div class="title_text">Meetings made easy</div>
    </div>
    <nav class="nav_bar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="description.php">What is Treff?</a></li>
        </ul>
    </nav>';
}

//Please enter MySQL connection HERE.
function connectMySql(){
    $host = "216.224.181.106";
    $user = "db_prod-treff";
    $pwd = "6%43z_fDs6fr4";
    $dbs = "dbotreff";
    $port = "3306";

    $connect = new mysqli($host, $user, $pwd, $dbs, $port);

    // Check connection
    if (mysqli_connect_errno())
    {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    return $connect;
}

//Check if Treff ID is found in db
function checkId($id)
{
    $table = "meetings";
    $column = "meetingId";
    if(inDb($table, $column, $id) == false || count($id) > 9)
    {
        echo errorPage();
    }
    else
    {
        return true;
    }
}

//Check if Email is attached to treff.
function checkEmail($email, $id)
{
    $table = "meetings";
    $column = "meetingId";
    if(inDb($table, $column, $email) == false)
    {
        echo errorPage();
    }
    else
    {
        return true;
    }
}

//Sanatize request
function clean($value)
{
    return htmlspecialchars($value);
}

//Send to error page
function errorPage()
{
    $toError = 'http://treffnow.com/'."error.php";

    return header('Location:'.$toError,TRUE);
}

//Find the info in db
function inDb($table, $column, $value)
{
    return true;
}

//Check the status of the Treff
function checkStat($id)
{
    return '<h2>Active</h2>';
}

//Get the name of the Treff
function getName($id)
{
    return 'Craig\'s list meeting';
}

//Get the Address for $user
function getAddress($userId)
{
    return '\'306 E 30th St, Austin, TX 78705\'';
}
