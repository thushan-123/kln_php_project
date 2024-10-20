<?php

    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors",1);

    include_once  '../../Function/function.php';
    include_once  '../../Connection/connection.php';

    // admin protection page

    if (!isset($_SESSION['admin']['islogin']) || $_SESSION['admin']['islogin'] != true){

        header("Location: ../admin.php");
    }

    if(isset($_POST['submit'])){
        $user_id = $_POST['user_id'];
        $loyalty_id = uniqid();
        
        $add_q = "INSERT INTO  loyalty_users (user_id, loyalty_id) VALUES ('$user_id', '$loyalty_id')";

        if(mysqli_query($connection,$add_q)){
            header("Location: ./add_customer.php");
        }
    }

    echo "<h3>Add Loyalty Customer</h3>

          <a href='remove.php'>Remove Loyalty Customers</a>
    
            <table border='1'>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th></th>
                </tr>";

    $query = "SELECT  * FROM users WHERE user_id NOT IN (SELECT  user_id FROM loyalty_users)";
    $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($result)){
        $user_id =  $row['user_id'];
        $user_name =  $row['user_name'];
        $email =  $row['email'];
        $mobile =  $row['mobile'];
        

        echo " <tr> 
                    <td>$user_id</td>
                    <td>$user_name</td>
                    <td>$email</td>
                    <td>$mobile</td>
                    <td>
                        <form action='' method='post'>
                        <input type='hidden' name='user_id' value='$user_id'>
                        <button type='submit' name='submit'> Add</button>
                        </form>
                    </td>
               </tr>";
    }

    echo "</table>"

?>