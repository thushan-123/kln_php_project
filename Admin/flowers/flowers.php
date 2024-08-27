<?php

session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);

include_once __DIR__ . '/../Function/function.php';
include_once __DIR__ . '/../Connection/connection.php';

if (!isset($_SESSION['admin']['islogin']) || $_SESSION['admin']['islogin'] != true || $_SESSION['admin']['token'] != $_COOKIE['token']){

    header('Location: ../admin.php');
}

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

        if (cookie_checker_admin()){
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