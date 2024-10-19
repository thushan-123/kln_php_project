<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../Connection/connection.php";
    include_once "../Function/function.php";

    echo "<link rel='stylesheet' href='../style/flowers.css?v=". time()."'>";

    if(isset($_POST['add_cart'])){
        if(!isset($_SESSION['user']['islogin']) ||  $_SESSION['user']['islogin'] == false){
            header("Location:  ../login.php");
        }else{
            $user_id = $_SESSION['user']['user_id'];
            $flower_id =  $_POST['flower_id'];
            $quantity =  $_POST['quantity'];

            $check_query = "SELECT * FROM shopping_cart WHERE  user_id = '$user_id' AND flower_id = '$flower_id'";
            $check_result = mysqli_query($connection, $check_query);

            if(mysqli_num_rows($check_result)>0){
                $query = "UPDATE shopping_cart SET quantity = quantity + '$quantity' WHERE user_id ='$user_id' AND  flower_id = '$flower_id'";
            }else{
                $query = "INSERT INTO shopping_cart(user_id,flower_id,quantity) VALUES ('$user_id','$flower_id','$quantity')";
            }

            if(mysqli_query($connection,$query)){
                header("Location: ../index.php");
            }
        }
    }

    if (isset($_POST['add_comment'])){
        if(!isset($_SESSION['user']['islogin']) ||  $_SESSION['user']['islogin'] == false){
            header("Location:  ../login.php");
        }else{
            $user_id = $_SESSION['user']['user_id'];
            $flower_id =  $_POST['flower_id'];
            $comment =  $_POST['comment'];

            $insert_comment = "INSERT  INTO comments(user_id,flower_id,comment) VALUES ('$user_id','$flower_id','$comment')";
            if(mysqli_query($connection,$insert_comment)){
                header("Location: ./flowers.php?flower_id=$flower_id");
            }
        }
    }


    if(isset($_GET['flower_id'])){
        $flower_id = user_input($_GET['flower_id']);

        $query = "SELECT f.flower_id, f.flower_name, f.quantity, f.sale_price, f.description, fi.dir_path, 
                  fd.today_dicount, fd.loyalty_discount, fd.price_off, fd.today_discount_end, 
                  fd.loyalty_discount_end, fd.price_off_end 
                  FROM flowers AS f
                  INNER JOIN flower_images AS fi ON f.flower_id = fi.flower_id
                  INNER JOIN flower_discounts AS fd ON f.flower_id = fd.flower_id
                  WHERE f.flower_id = '$flower_id'";

        $result = mysqli_query($connection,$query);
        $row = mysqli_fetch_assoc($result);

        $flower_id = $row['flower_id'];
        $flower_name = $row['flower_name'];
        $sale_price = $row['sale_price'];
        $quantity = $row['quantity'];
        $description = $row['description'];
        $dir_path = $row['dir_path'];

        $today_discount =  $row['today_dicount'];
        $loyalty_discount =  $row['loyalty_discount'];
        $price_off = $row['price_off'];
        $today_discount_end = $row['today_discount_end'];
        $loyalty_discount_end = $row['loyalty_discount_end'];
        $price_off_end = $row['price_off_end'];

        echo "
            <div class='container'>
                <div class='image-container'>
                    <img src='../$dir_path' alt='$flower_name'>
                </div>
                <div class='flower-details'>
                    <h2>$flower_name</h2>
                    <p class='description'>$description</p>
                    <p class='price'>Price: RS. $sale_price</p>
                    <p class='quantity'>Available Quantity: $quantity</p>";

                    if (isset($today_discount) && date('Y-m-d') < $today_discount_end) {
                        echo "<p class='discount'>Today's Discount: $today_discount%</p>";
                    }
                    if (isset($loyalty_discount) && date('Y-m-d') < $loyalty_discount_end) {
                        echo "<p class='loyalty-discount'>Loyalty Discount: $loyalty_discount%</p>";
                    }
                    if (isset($price_off) && date('Y-m-d') < $price_off_end) {
                        echo "<p class='price-off'>Price Off: $price_off%</p>";
                    }

                    if($quantity >0){
                        echo "
                            <div class='button-container'>
                                <form action='flowers.php'  method='post'>
                                <input type='hidden' name='flower_id' value='$flower_id'>
                                <lable>Quantity :  </lable>
                                <input type='number' id='quantity' name='quantity' min='1' max='$quantity' value='1' step='1' required><br><br>
                                <button  type='submit'  name='add_cart' class='add-to-cart'>Add to Cart</button>
                                <button class='buy-now'>Buy Now</button>
                                </form>
                            </div>";
                    }else{
                        echo "<p style='color: red; font-weight: bold;'>Out of Stock</p>";
                    }

                    

                    echo "
                </div>
            </div>";


            echo "<div class='comment'>
                    <form action='' method='post'>
                        <input type='hidden' name='flower_id' value='$flower_id'>
                        <textarea name='comment' placeholder='Write your comment here...' required></textarea>
                        <button type='submit' name='add_comment' class='add-comment'>Add Comment</button>
                    </form>
            ";

            // show comments
            $query = "SELECT * FROM comments WHERE flower_id = '$flower_id'";
            $result = mysqli_query($connection, $query);

            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $user_id = $row['user_id'];
                    $comment = $row['comment'];

                    $user_data = "SELECT * FROM users WHERE user_id='$user_id'";
                    $user_result = mysqli_query($connection, $user_data);
                    $user_name = mysqli_fetch_assoc($user_result)['user_name'];

                    echo "
                        <h3>$user_name</h3> <br>
                        <p>$comment</p>
                    ";
                }
            }


            echo "</div>";
    }



?>