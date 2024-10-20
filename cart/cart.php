<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../Connection/connection.php";
    include_once "../Function/function.php";

    echo "<link rel='stylesheet' href='../style/cart.css?v=". time()."'>";

    if(!isset($_SESSION['user']['islogin']) ||  $_SESSION['user']['islogin'] == false){
        header("Location: ../login.php");
    }

    $user_id =  $_SESSION['user']['user_id'];
    $user_name =  $_SESSION['user']['user_name'];

    $total_items = "SELECT  COUNT(*) AS  total_items FROM shopping_cart WHERE user_id = '$user_id'";
    $result_total_items = mysqli_query($connection, $total_items);

    $num_of_items  = mysqli_fetch_assoc($result_total_items)['total_items'];

    echo "Number of Cart Items : " . $num_of_items;

    if(isset($_POST['change_quantity'])){
        $flower_id = $_POST['flower_id'];
        $user_quantity =  $_POST['user_quantity'];

        $update = "UPDATE shopping_cart SET quantity='$user_quantity'  WHERE user_id='$user_id' AND flower_id='$flower_id'";
        if(mysqli_query($connection,$update)){
            header("Location: ./cart.php");
        }
    }

    if(isset($_POST['delete'])){
        $flower_id = $_POST['flower_id'];

        $delete =  "DELETE FROM shopping_cart WHERE user_id='$user_id' AND flower_id='$flower_id'";

        if(mysqli_query($connection,$delete)){
            header("Location: ./cart.php");
        }
    }


    // show the cart items

    $query = "SELECT * FROM shopping_cart WHERE user_id = '$user_id'";
    $result = mysqli_query($connection, $query);

    $total = 0;

    $array = [];

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $flower_id = $row['flower_id'];
            $user_quantity = $row['quantity'];

            $img_query = "SELECT * FROM flower_images WHERE flower_id='$flower_id'";
            $img_result = mysqli_query($connection, $img_query);
            $dir_path = mysqli_fetch_assoc($img_result)['dir_path'];
            

            $flower_query = "SELECT * FROM flowers INNER JOIN flower_discounts ON flowers.flower_id=flower_discounts.flower_id WHERE  flowers.flower_id = '$flower_id'";
            $flower_result = mysqli_query($connection, $flower_query);
            $data =  mysqli_fetch_assoc($flower_result);


            $flower_name = $data['flower_name'];
            $sale_price = $data['sale_price'];
            $max_quantity =  $data['quantity'];

            $today_discount =  $data['today_dicount'];
            $loyalty_discount =  $data['loyalty_discount'];
            $price_off = $data['price_off'];
            $today_discount_end = $data['today_discount_end'];
            $loyalty_discount_end = $data['loyalty_discount_end'];
            $price_off_end = $data['price_off_end'];

            $items_price = (float) $user_quantity * $sale_price;
            
            $discount = 0;

            // array  flower_id => quantity

            $array[$flower_id] = $user_quantity;

            if (isset($today_discount) && date('Y-m-d') < $today_discount_end) {
                $discount = $discount -  ($items_price * $today_discount / 100);
            }
            if (isset($_SESSION['user']['loyalty_id'])){
                if (isset($loyalty_discount) && date('Y-m-d') < $loyalty_discount_end) {
                    $discount = $discount -  ($items_price * $loyalty_discount/ 100);
                }
            }
            if (isset($price_off) && date('Y-m-d') < $price_off_end) {
                $discount = $discount -  ($items_price * $price_off / 100);
            }
            $items_total = $items_price - $discount;
            $total += $items_total;

            echo "<div class='item'>
                    <img src='../$dir_path' alt='flower image' width='100px' height='100px'>
                    <p>$flower_name    Price : $sale_price</p>
                    <lable> Discount Price : $discount</lable>
                    <lable> Items Price :  $items_price</lable>
                    <lable>  Items Total : $items_total</lable>
                    <form  action='cart.php' method='post'>
                        <lable>Quantity: </lable>
                        <input type='number' id='quantity' name='user_quantity' min='1' max='$max_quantity' value='$user_quantity' step='1' required>
                        <input type='hidden' name='flower_id' value='$flower_id'>
                        <button type='submit' name='change_quantity'>Change Quantity</button>
                        <button type='submit' name='delete' > Delete Item</button>
                    </form>

            
                  </div>";

        }
    }
    echo  "<p>Total: $total</p>";
    
    if(isset($num_of_items) && $num_of_items >0){

        $_SESSION['payment'] = [
            'type' => 'shopping_cart',
            'total' => $total,
            'items' => $array,
            'user_id' => $user_id,
            'success' => false
        ];
    
        echo "<div class='buy_now'>
                    <form action='../payments/payment.php' method='get'>
                    <input type='text' name='address'  placeholder='Enter your address' required><br><br>
                    <button type='submit' > Buy Now</button>
                    </form>
        
              </div>";

    }

    
    print_r($array);



?>