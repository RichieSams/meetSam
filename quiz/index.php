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
        startQuiz();
        }
    else{
        logIn();
        }
#################################################################
    function logIn(){

      $script = $_SERVER['PHP_SELF'];
       
        print <<<LOGIN
         
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
    
    //Maybe COMPLETE NOt TESTED
    function changeStart($name){
        $fileName = "./passwd.txt";
        $newFileName = "./passCp.txt";
        copy($fileName, $newFileName);
        $file = fopen($fileName, "w");
        $newFile = fopen($newFileName, "r");
        while(! feof($newFile))
          {
            $curText = fgets($file);
            $break1 = strpos($curText, ":");
            $curName = substr($curText,0,$break1);
            if($curName == $name)
              {
                $break2 = strpos($curText, ":", $break1+1);
                $break3 = strpos($curText, ":", $break2+1);
                $nameAndPass = substr($curText,0,$break2+1);
                fwrite($file, "$nameAndPass1");
              }
            else
              {
                fwrite($file, $curText);
              }
            }
        
#################################################################
//checks for login information and initiates quiz
    function startQuiz()
      {
        $check = FALSE;
        $passwd = $_POST["passwd"];
        $name = $_POST["name"];
        $file = fopen("./passwd.txt", "r");
        while(! feof($file) AND $check == FALSE)
        {
          $curText = fgets($file);
          $break1 = strpos($curText, ":");
          $break2 = strpos($curText, ":", $break1+1);
          $curName = substr($curText,0,$break1);
          $curPasswd = substr($curText,$break1 + 1, $break2 - $break1 - 1);
          
          if ($name == $curName AND $passwd == $curPasswd)
            {
            $check = TRUE;
            break;
            }
        }
        
        if ($check == FALSE)
        {
            echo "<h1>Incorrect Username or Password</h1>";
            logIn();
        }
        
        else
        {
            $curStart = substr($curText,$break2 + 1);
            if($curStart ==0)
            {
              session_start();
              $_SESSION["question"] = 1;
              $_SESSION["results"] = 0;
              setcookie ("quizTimer", session_id(), time()+60*15);
              changeStart($name);
              echo "<p>Thank you for logging in for your quiz.
                     You will have six question on basic Astronomy questions
                     that you must answer in 15 min. You may only take the quiz once.
                     Good luck!</p>";
              quiz();
            }
            elseif( isset ($_CCOKIE["quizTimer"]))
            {
             //don't quite know what to do here
            }
            
            else
            {
                Echo "<h3> You have run out of time </h3>";
            }
        }
      fclose($file);  
    }
 #################################################################
// will out put and grade questions
    function quiz(){
    
    
    }

echo "</body></html>";
?>