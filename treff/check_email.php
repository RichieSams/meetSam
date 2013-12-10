<?php
include_once 'functions.php';

$connection = connectMySql();

/* catch the post data from ajax */

$email = clean($_POST['name']);

$result = $connection->query("SELECT *
                                  FROM Users
                                  WHERE email='$email'");


if($result->num_rows > 0 && $result->fetch_assoc()['anonymous'] != '1') { 
	echo '2';
}
 else { 
	echo '3';
}
?>