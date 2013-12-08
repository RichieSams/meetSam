<?php

session_start();

include_once 'functions.php';

if (isset($_POST["loggedIn"])) {
    if (!checkLogin()) {
        echo '<script type="text/javascript">alert("Incorrect Username or Password"); </script>';
        include 'login.php';
        exit;
    }
} else if (isset($_POST["register"])) {
    addUser();
} else if (isset($_POST["anonymous"])) {
    addAnonymousUser();
}

// Redirect
header("Location: " . $_POST["redirectUrl"]);




function checkLogin() {
    $email = $_POST["name"];
    $pass = $_POST["pass"];
    unset($_POST["pass"]);

    $connect = connectMySql();

    $result = $connect->query("SELECT userId, password FROM Users WHERE email = '$email'");

    $row = $result->fetch_assoc();
    $result->free();

    $success = (crypt($pass, $row['password']) == $row['password']);

    if ($success) {
        $_SESSION["userId"] = $row['userId'];
    }

    return $success;
}

function addUser() {
    $email= $_POST["name"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $pass1 = crypt($_POST["pass1"]);
    unset($_POST["pass1"]);

    $connect = connectMySql();

    // Add user to table
	if ( inDb("Users", "email", $email) && getFromDb("Users", "email", $email, "anonymous") == 1) {
		$connect->query("UPDATE Users SET street = '$street', city = '$city', 
						state = '$state', zip = '$zip', password = '$pass1', anonymous = 0
						WHERE email = '$email'");
		$_SESSION["userId"] = getFromDb("Users", "email", $email, "userId");
	}
	
	else{
		$connect->query("INSERT INTO Users (email, password, street, city, state, zip)
						VALUES ('$email', '$pass1', '$street', '$city', '$state', '$zip')");

		$_SESSION["userId"] = $connect->insert_id;
	}

    mysqli_close($connect);
}

function addAnonymousUser() {
    $connect = connectMySql();

    $connect->query("INSERT INTO Users (anonymous) VALUES(TRUE);");

    $_SESSION["userId"] = $connect->insert_id;

    mysqli_close($connect);
}