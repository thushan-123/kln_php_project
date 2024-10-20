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
        
        
        $delete_q = "DELETE FROM loyalty_users WHERE user_id='$user_id'";

        if(mysqli_query($connection,$delete_q)){
            header("Location: ./remove.php");
        }
    }

    echo "<h3>Remove Loyalty Customers</h3>
    
            <table border='1'>
                <tr>
                    <th>Loyalty ID</th>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th></th>
                </tr>";

    $query = "SELECT  users.user_id,loyalty_id,user_name,email,mobile FROM users INNER JOIN  loyalty_users ON users.user_id = loyalty_users.user_id";
    $result = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($result)){
        $user_id =  $row['user_id'];
        $user_name =  $row['user_name'];
        $email =  $row['email'];
        $mobile =  $row['mobile'];
        $loyalty_id =   $row['loyalty_id'];

        echo " <tr> 
                    <td>$loyalty_id</td>
                    <td>$user_id</td>
                    <td>$user_name</td>
                    <td>$email</td>
                    <td>$mobile</td>
                    <td>
                        <form action='' method='post'>
                        <input type='hidden' name='user_id' value='$user_id'>
                        <button type='submit' name='submit'> Delete</button>
                        </form>
                    </td>
               </tr>";
    }

    echo "</table>"

?>