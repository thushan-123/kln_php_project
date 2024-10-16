<?php
    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors",1);

    include_once "../../Connection/connection.php";
    include_once "../../Function/function.php";

    // session protection
    if(!isset($_SESSION['admin']['isLogin']) || $_SESSION['admin']['isLogin'] != true){
        header("Location ../admin.php");
    }

    if(isset($_GET['flower_id'])){

        $flower_id = user_input($_GET['flower_id']);

        $query = "SELECT flowers.flower_id,flower_name,quantity,sale_price,description,dir_path FROM flowers INNER JOIN flower_images 
                  ON flowers.flower_id=flower_images.flower_id WHERE flower_id='$flower_id' LIMIT 1";

        $result_set = mysqli_query($connection,$query);

        if(mysqli_num_rows($result_set)>0){
            
            $data = mysqli_fetch_assoc($result_set);
            $flower_id = $data['flower_id'];
            $flower_name = $data['flower_name'];
            $quantity = (int) $data['quantity'];
            $sale_price = $data['sale_price'];
            $description = $data['description'];
            $dir_path = $data['dir_path'];

            echo "<div id='flower_image'>
                     <img src='../../$dir_path' alt='no image found' width='300px' height='300px'/> 
                   </div>";

            echo "<div>
                        <form action='flower_info.php'  method='post'>

                            <lable>Flower Name :</lable><br/>
                            <input type='text' name='flower_name' value='$flower_name' placeholder='Flower Name' required/><br/>

                            <lable>Quantity : </lable><br/>
                            <input type='number' name='quantity' value='$quantity' placeholder='Quantity' required/><br/>

                            <lable>Sale Price : </lable>
                            <input type='text' name='sale_price' value='$sale_price' placeholder='Sale Price' required/><br/>
                        </form>
                  <div>";

            

        }

    }

?>