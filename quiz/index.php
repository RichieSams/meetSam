<?php
print <<<Page
<html>
<head>
<title> Astronomy Quiz </title>
<script type ="text/javascript" src = "./validate.js"></script>
</head>
<body>
Page;
  
    if(isset($_POST["loggedIn"])){
        quiz();
        }
    else{
        logIn();
        }
#################################################################
    function logIn(){

      $script = $_SERVER['PHP_SELF'];
       
        print <<<LOGIN
            <html>
              <head>
                <title> Astronomy Quiz </title>
                <script type ="text/javascript" src = "./validate.js"></script>
              </head>
              
              <body>
                <h1>Log In</h1>        
                  <form  id = "login" action = "$script" method = "POST" 
                  onsubmit = "return validate();">
               
                    <div class = "userName">
                      <label> Name:
                        <input type = "text" name = "name" value = "" maxlength = "30"/>
                      </label>
                    </div>
            
                    <div class = "password">
                      <label> Password:
                        <input type = "password" name = "passwd" value = "" maxlength = "30"/>
                      </label><br/><br/>
                    </div>
            
                    <input type = "submit" value = "Submit" name = "loggedIn"/>
                    <input type = "reset" value = "Reset" />
                </form>
LOGIN;
    }

#################################################################
    //Will change the passwd.txt to having a 1 instead of 0 
    //signifying the quiz being started.
    
    //NOT COMPLETE
    function changeStart(){
        $fileName = "./passwd.txt";
        $newFileName = "./passCp.txt";
        copy($fileName, $newFileName);
        $file = fopen($fileName, "w");
        $newFile = fopen($newFileName, "r");
        while(! feof($newFile)){
            
            }
        
#################################################################
    function quiz(){
        $check = FALSE;
        $passwd = $_POST["passwd"];
        $name = $_POST["name"];
        $file = fopen("./passwd.txt", "r");
        while(! feof($file) AND $check == FALSE){
          $curText = fgets($file);
          $break1 = strpos($curText, ":");
          $break2 = strpos($curText, ":", $break1+1);
          $break3 = strpos($curText, ":", $break2+1);
          $curName = substr($curText,0,$break1);
          $curPasswd = substr($curText,$break1 + 1, $break2 - $break1 - 1);
          
          if ($name == $curName AND $passwd == $curPasswd){
            $check = TRUE;
            break;
          }
    }
        if ($check == FALSE){
            echo "<h1>Incorrect Username or Password</h1>";
            logIn();
        }
        
        else{
            $curNum = substr($curText,$break2 + 1, $break3 - $break2 - 1);
            $curStart = substr($curText,$break3 + 1);
            setcookie ("quizTimer", 1, time()+60*15);
            changeStart();
            echo "<p>Thank you for logging in for your quiz.
                     You will have six question on basic Astronomy questions
                     that you must answer in 15 min. You may only take the quiz once.
                     Good luck!</p>";
            
        }
      fclose($file);  
    }

echo "</body></html>";
?>