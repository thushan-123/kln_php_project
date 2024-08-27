<?php 

 // Check for the user input data -> remove spaces , slash , specialchars   
 function user_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// Create a function  check the admin cookie is expired
function cookie_checker_admin(){
    if ($_SESSION['admin']['token'] != $_COOKIE['token']){
        echo "<script> window.alert('Cookie is expire. Please Login here')</script>";
        header("Location: admin.php");
    }else{
        return true;
    }
}

?>