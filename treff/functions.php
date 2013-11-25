<?php
    //Check if Treff ID is found in db
    function checkId(id)
    if(findID(id))
    {
        return true;

    }
    else
    {
        return errorPage();
    }
    
    //Send to error page
    function errorPage()
    {
        $toError = 'http://treffnow.com/'."/error.php";
        
        return header('Location:'.$toError,TRUE);
    }
?>