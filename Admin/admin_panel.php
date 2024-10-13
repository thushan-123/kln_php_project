<?php

global $connection;
session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);

include_once __DIR__ . '/../Function/function.php';
include_once __DIR__ . '/../Connection/connection.php';

echo "<pre>";
var_dump($_SESSION);
var_dump($_COOKIE);
echo "</pre>";


// admin protection page
if (!isset($_SESSION['admin']['islogin']) || $_SESSION['admin']['islogin'] != true ){

    // Redirect to login page unauthorized access
    header('Location: admin.php');
    
} 


?>