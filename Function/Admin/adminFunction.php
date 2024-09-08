<?php

error_reporting(E_ALL);
ini_set("display_errors",1);

include_once '../../Connection/connection.php';
include_once '../../Logger/logger.php';

global $connection;
function get_flowers_categories(){
    global $connection;
   try{
        $query = "SELECT * FROM flowers_category";
        $result = mysqli_query($connection,$query);
        logger("INFO", "get flowers category successfully");

        if (mysqli_num_rows($result) > 0){
            return $result;
        }else{
            return null;
        }
   }catch(Exception $e){
        logger('ERROR', 'get_flowers_categories function ' . $e->getMessage());   
        return null; 
   }
}

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';  // Directory to save uploaded files
        $filename = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $filename;

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "The image has been uploaded successfully.";
        } else {
            echo "Sorry, there was an error uploading your image.";
        }
    } else {
        echo "No image uploaded or there was an error with the upload.";
    }
}
?>