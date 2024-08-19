<?php 

 // Check for the user input data -> remove spaces , slash , specialchars   
 function user_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>