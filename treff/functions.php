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
            <li><a href="description.php">What is Treff?</a></li>';
	$getAnon = getAnon();
	if(isset($_SESSION['userId']) && $_SESSION['userId'] != 0 && $getAnon != TRUE){
		echo '<li><form action="logout.php" method="POST">
				  <input class="loginButton" type="submit" value="Log Out"  name="logOut"/>
              </form></li>';
	} else {
		echo '<li><form action="login.php" method="POST">
				  <input class="loginButton" type="submit" value="Login" />
				  <input type="hidden" name="redirectUrl" value="create2.php" />
              </form></li>';
	}
        
	echo '</ul>
    </nav>';
}

//Please enter MySQL connection HERE.
function connectMySql(){
    $host = "192.30.165.140";
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
    $table = "Meetings";
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
function checkEmail($userId, $id)
{
    $table = "MeetingUsers";
    $column = "userId";
    $column2 = "meetingId";
    if(checkTwo($table, $column, $column2, $userId, $id) == false)
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

//Check info $value if in same row as $value2
function checkTwo($table, $column, $column2, $value, $value2)
{
    $connect = connectMySql();
    $result = $connect->query("SELECT * FROM $table where $column ='$value'
                              AND
                              $column2 ='$value2'");
    echo $row;
    if($result)
    {
        return true;
    }
    else
    {
        return false;
    }
    $result->free();
}
    
//Find the info in db
function inDb($table, $column, $value)
{
    $connect = connectMySql();
    $result = $connect->query("SELECT * FROM $table where $column ='$value'");
    echo $row;
    if($result)
    {
        return true;
    }
    else
    {
        return false;
    }
    $result->free();
}

//Check the status of the Treff
function checkStat($id)
{
    return '<h2>Active</h2>';
}

//Get the name of the Treff
function getName($id)
{
    $connect = connectMySql();
    $result = $connect->query("SELECT * FROM Meetings where meetingId='$id'");
    $row = $result->fetch_assoc();

    return $row;
    $result->free();
}

//Get the Address for $user
function getAddress($userId)
{
    return '\'306 E 30th St, Austin, TX 78705\'';
}

function getAnon()
{
	if(isset($_SESSION['userId']) && $_SESSION['userId'] != 0 ){
		
		$connect = connectMySql();
		$result = $connect->query("SELECT * FROM Users where userId='userId'");
		$row = $result->fetch_assoc();
		echo $row["userId"];
		$result->free();
		echo $row["userId"];
		return $row["anonymous"];
	}
	
	return true;    
}
