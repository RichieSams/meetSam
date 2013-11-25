<?php
    //Please enter MySQL connection HERE.
    
    
    //Check if Treff ID is found in db
    function checkId($id)
    {
        $table = "meetings";
        $column = "meetingId";
        if(inDb($table, $column, $id) == false || count($id) > 9)
        {
            echo errorPage();
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
        
    }
?>