<?php

session_start();

echo "<pre>";
var_dump($_SESSION);
var_dump($_COOKIE);
echo "</pre>";

if (!isset($_SESSION['admin']['islogin']) ){

    // Redirect to login page unauthorized access
    //header('Location: admin.php');
    echo "hello";
} 



?>