<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../Connection/connection.php";
    include_once "../Function/function.php";

    echo "<link rel='stylesheet' href='../style/flowers.css?v=". time()."'>";


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

                    echo "
                    <div class='button-container'>
                        <button class='add-to-cart'>Add to Cart</button>
                        <button class='buy-now'>Buy Now</button>
                    </div>
                </div>
            </div>";
    }



?>