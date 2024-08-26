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

if (!isset($_SESSION['admin']['islogin']) || $_SESSION['admin']['islogin'] != true || $_SESSION['admin']['token'] != $_COOKIE['token']){

    // Redirect to login page unauthorized access
    header('Location: admin.php');
    
} 

// Create a function  check the admin cookie is expired
function cookie_checker(){
    if ($_SESSION['admin']['token'] != $_COOKIE['token']){
        echo "<script> window.alert('Cookie is expire. Please Login here')</script>";
        header("Location: admin.php");
    }else{
        return true;
    }
}

// verify the suplier sumbit the button
if (isset($_POST['submit_verify'])){
    try{
        $suplier_id = (int) $_POST['suplier_id'];

        $query = "UPDATE supliers SET verify=true WHERE suplier_id=$suplier_id;";

        if (mysqli_query($connection, $query)){

            logger("INFO", "supplier verify successfully");
        }else{

            throw new Exception(mysqli_error($connection));
        }
    }catch(Exception $e){
        logger("ERROR", "supplier submit verify" . $e->getMessage());
    }
}

echo "<div id='supplier-verify'>";

if(cookie_checker()){
    
    // Get the suplier details in db
    try{

        echo "<h4>suplier verify</h4>";

        $query = "SELECT * FROM supliers WHERE verify=false ;";

        $result = mysqli_query($connection, $query);
        logger("INFO", "get the supplier data in db successfully");

        // Create a table
        echo "<table id='table-supplier-verify'>
                <th>Suplier id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Verify</th>
            ";


        while($row = mysqli_fetch_assoc($result)){
            // Display the result
            $suplier_id = $row["suplier_id"];
            $suplier_username = $row["suplier_username"];
            $email = $row["email"];
            $mobile = $row["mobile"];

            echo "<tr><td> $suplier_id </td> <td> $suplier_username </td> <td>$email</td> <td> $mobile </td>
                <td> 
                    <form action='admin_panel.php' method='post'>
                        <input type='hidden' value='$suplier_id' name='suplier_id'>
                        <button type='submit' name='submit_verify'>Verify</button>
                    </form>

                </td></tr>";


        }

        echo "</table>";

    }catch(Exception $e){
        logger("ERROR", $e->getMessage());
    }
}

echo "</div>";

if (isset($_POST['delete_category'])){
    try{

        $category_id = (int) $_POST['category_id'];

        $query = "DELETE FROM flowers_category WHERE category_id=$category_id";
        $result = mysqli_query($connection, $query);
        logger("INFO", "$category_id id delete successfully");

    }catch(Exception $e){
        logger('ERROR', $e->getMessage());
    }
}

echo "<div id='flowers_category'>";
    echo "<h4>Flowers Category</h4>";
    echo "<div id='show_category'>";
        // show the all category

        if (cookie_checker()){
            try{

                $query = "SELECT * FROM flowers_category";

                $result = mysqli_query($connection, $query);

                logger("INFO", "get flowers_category data successfully");

                // display the aviable category

                if (mysqli_num_rows($result) > 0){

                    echo "<table id='show_category_table' border='1'>

                            <tr><th>Category</th>
                            <th>Delete</th></tr>       
                    ";
                    while($row = mysqli_fetch_assoc($result)){
                        $category_id = $row["category_id"];
                        $category_name = $row["category_name"];

                        echo "<tr><td>$category_name</td>
                            <td>
                            <form action='' method='post'>
                            <input type='hidden' name='category_id' value='$category_id'>
                            <button type='submit' name='delete_category'>Delete</button>
                            </form>
                            </td>
                            </tr>
                        ";
                    }

                    echo "</table>";

                }else{
                    echo "<h3>NO Categories in table<h3>";
                }
                
            }catch(Exception $e){
                logger("ERROR", $e->getMessage());
            }
        }
    echo "</div>";

    echo "<div id='add_category'>";
    echo "</div>";

echo "</div>";


echo "<div id='upload_flowers'>";

echo "</div>";
?>