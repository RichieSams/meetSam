<?php
session_start();
session_destroy();
setcookie("firstTime", "1", time() - 3600, "/");
header("Location: index.php");
?>