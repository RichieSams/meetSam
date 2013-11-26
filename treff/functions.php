<?php
    //Please enter MySQL connection HERE.
	function connectMySql(){
		$host = "216.224.181.106";
		$user = "db_prod-treff";
		$pwd = "6%43z_fDs6fr4";
		$dbs = "dbotreff";
		$port = "3306";

		$connect = mysqli_connect ($host, $user, $pwd, $dbs, $port);

		if (empty($connect)){
			die("mysqli_connect failed: " . mysqli_connect_error());
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
?>