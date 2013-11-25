<?php include 'header.php'; ?>

<div class="main_body">

<?php
if(isset($_POST["loggedIn"])){
	if (!checkLogin()) {
        echo "<h1>Incorrect Username or Password</h1>";
        include 'login.php';
        return;
    }
}

elseif(isset($_POST["register"])){
	addUser();
}

else{
	displayTreff();
}

function checkLogin(){
	$email = $_POST["name"];
	$pass = $_POST["pass"];

	$host = "z.cs.utexas.edu";
	$user = "db_prod-treff";
	$pwd = "6%43z_fDs6fr4";
	$dbs = "dbotreff";
	$port = "3306";

	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

	if (empty($connect)){
		die("mysqli_connect failed: " . mysqli_connect_error());
	}

	$result = mysqli_query($connect, "SELECT password FROM Users WHERE email = '$email'");

	$row = $result-> fetch_row();
	$result->free();
	if($row[0] == $pass){
		displayTreff($email);
		return true;
	}
	return false;

	mysqli_close($connect);
}

function addUser(){
	$email= $_POST["regUserName"];
	$street = $_POST["street"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$zip = $_POST["zip"];
	$pass1 = $_POST["pass1"];

	// Connect to the MySQL database
	$host = "z.cs.utexas.edu";
	$user = "smf2256";
	$pwd = "1+H05NosBT";
	$dbs = "cs329e_sam";
	$port = "3306";

	$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

	if (empty($connect))
	{
		die("mysqli_connect failed: " . mysqli_connect_error());
	}

	// Add user to table
	mysqli_query($connect, "INSERT INTO Users (email, password, street, city, 
							state, zip) VALUES ('$email', '$pass1', '$street', '$city', '$state', '$zip')");
	mysqli_close($connect);

	displayTreff($email);
}

function displayTreff($email = ''){

	$user = '';
	$street = '';
	$city = '';
	$state = '';
	$zip = '';


	if($email != ''){

		$host = "z.cs.utexas.edu";
		$user = "smf2256";
		$pwd = "1+H05NosBT";
		$dbs = "cs329e_sam";
		$port = "3306";

		$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

		if (empty($connect)){
			die("mysqli_connect failed: " . mysqli_connect_error());
		}

		$result = mysqli_query($connect, "SELECT * FROM Users WHERE email = '$email'");

		$row = $result-> fetch_row();
		session_start();
		$_SESSION["userId"] = $row[0];
		$user = $row[1];
		$street = $row[3];
		$city = $row[4];
		$state = $row[5];
		$zip = $row[6];
		$result->free();
		mysqli_close($connect);
	}
		echo  "<div class=\"information\">
			      <h1>Make a Treff</h1>
			      <form id = \"treffForm\" action=\"process.php\" 
					method=\"POST\" onsubmit=\"return validateTreff();\">

				  <div class=\"userName\">
                      <input type=\"text\" name=\"userName\" maxlength=\"50\" value=\"$user\" 
					   placeholder=\"Email Address\"/>
				  </div>
				  
				  <div class=\"treffMate\">
                      <input type=\"text\" name=\"treffMate\" maxlength=\"50\" 
					   placeholder=\"Treff Mate's Email\"/>
				  </div>

				  <div class=\"street\">
                      <input type=\"text\" name=\"street\" maxlength=\"50\" size=\"37\" value=\"$street\"
					   placeholder=\"Street Adress\"/>
				  </div>

				  <div class=\"city\">
                      <input type=\"text\" name=\"city\" maxlength=\"50\" value=\"$city\"
					   placeholder=\"City\"/>
				  </div>

				  <div class=\"state\">
                      <input type=\"text\" name=\"state\" maxlength=\"2\" size=\"3\" value=\"$state\"
					   placeholder=\"State\"/>
				  </div>

				  <div class=\"zip\">
                      <input type=\"text\" name=\"zip\" maxlength=\"5\" size=\"5\" value=\"$zip\"
					   placeholder=\"Zip\"/>
				  </div>
			
				  <div class=\"treffName\">
                      <input type=\"text\" name=\"treff\" maxlength=\"100\" placeholder=\"Treff Title\"/>
				  </div>
			</div>
				  <div class=\"createTreff\">
                      <input class=\"createButton\" type=\"submit\" value=\"Create Treff!\" name=\"create\" />
				  </div>";

}

?>

<?php include 'footer.php'; ?>