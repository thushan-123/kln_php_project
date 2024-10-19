<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors',1);

    include_once "../Connection/connection.php";
    include_once "../Function/function.php";

    echo "<link rel='stylesheet' href='../style/payments/payment.css?v=". time()."'>";

    if(!isset($_SESSION['user']['islogin']) ||  $_SESSION['user']['islogin'] == false){
        header("Location: ../index.php");
    }

//    echo "<pre>";
//    print_r($_SESSION);
//    echo "</pre>";

    $user_id = $_SESSION['user']['user_id'];
    $user_name = $_SESSION['user']['user_name'];

    if(isset($_SESSION['payment']) && $_SESSION['payment']['success'] == false){
        $total =  $_SESSION['payment']['total'];

        $address = $_POST['address'];
        $_SESSION['payment']['address'] = $address;


        echo "<form action='paymentGateWay.php' method='post'>
                 <input type='hidden' name='total' value='$total'>
                 <lable> User Name : $user_name </lable><br><br>
                 <lable> Total Price: $total </lable><br><br>
                 <lable> Shipping  Address: $address </lable><br><br>
                 <button type='submit' name='pay'>Pay Online</button>
        
               </form>";
    }

    if(isset($_SESSION['payment']['reference_no'])  && $_SESSION['payment']['success'] == true){

        $address = $_SESSION['payment']['address'];
        $reference_no = $_SESSION['payment']['reference_no'];
        $total = $_SESSION['payment']['total'];

        $querys ="INSERT  INTO payments (reference_no,user_id,amount,date,address) VALUES ('$reference_no','$user_id','$total',CURRENT_DATE,'$address')";
        mysqli_query($connection,$querys);

        foreach($_SESSION['payment']['items'] as $flower_id => $quantity){
            $update_flower_query = "UPDATE flowers SET quantity = quantity - $quantity WHERE flower_id = '$flower_id'";
            mysqli_query($connection, $update_flower_query);

       
            $delete_cart_query = "DELETE FROM shopping_cart WHERE user_id = $user_id AND flower_id = '$flower_id'";
            mysqli_query($connection, $delete_cart_query);

           
            $insert_delivery_query = "INSERT INTO delivery_items (flower_id, user_id, quantity, reference_no) 
                                    VALUES ('$flower_id', '$user_id', '$quantity', '$reference_no')";
            mysqli_query($connection, $insert_delivery_query);
            
        }

        echo "<div class='success_payment'>
                    <h3> Your payment has been successfully done. </h3> <br><br>
                    <lable>  Reference No: $reference_no </lable><br><br>
                    <lable>  Total Price: $total </lable><br><br>
                    <lable>   Shipping Address: $address </lable><br><br>
                    
              </div>";
    }

?>`