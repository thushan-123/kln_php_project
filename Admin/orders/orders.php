<?php

session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

if(! isset($_SESSION["admin"]["isLogin"]) || $_SESSION["admin"]["isLogin"] != true || $_SESSION["admin"]["token"] != $_COOKIE["token"]) {
    header("Location: ../admin.php");
}




?>