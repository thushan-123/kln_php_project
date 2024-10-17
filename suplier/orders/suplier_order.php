<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../../Connection/connection.php";
    include_once "../../Function/function.php";

    if(!isset($_SESSION['suplier']['islogin']) ||  $_SESSION['suplier']['islogin'] == false){
        header("location: ../login_suplier.php");
    }

    $suplier_id = $_SESSION['suplier']['suplier_id'];
    $suplier_name = $_SESSION['suplier']['suplier_username'];

    if(isset($_POST['accept_admin_order_request'])){

        $order_id = (int) $_POST['order_id'];
        $update_query = "UPDATE orders SET isAccept_suplier=true ,accept_suplier_date = CURRENT_DATE WHERE order_id = '$order_id' ";

        if (mysqli_query($connection,$update_query)){
            header("Location: ./suplier_order.php");

        }else{
            logger("ERROR",  "Error update order status to accept order_id: $order_id");
        }
    }

    $query = "SELECT * FROM orders WHERE  suplier_id = '$suplier_id' AND isAccept_suplier=false";
    $result = mysqli_query($connection, $query);

    echo "<div>
            <h3>Order Requests</h3>
            
            <table border='1'>
                <tr>
                    <th>Flower Name</th>
                    <th>Request Quantity</th>
                    <th>Admin Requested Date</th>
                    <th></th>
                </tr>";

                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
                        $order_id = $row['order_id'];
                        $flower_id = $row['flower_id'];
                        $quantity = $row['quantity'];
                        $requested_date = $row['order_date'];

                        $retrieve_flower = "SELECT flower_name FROM flowers";
                        $retrieve_flower_result = mysqli_query($connection, $retrieve_flower);
                        $flower_name =  mysqli_fetch_assoc($retrieve_flower_result)['flower_name'];

                        echo "<tr>
                                <td>$flower_name</td>
                                <td>$quantity</td>
                                <td>$requested_date</td>
                                <td>
                                    <form action='suplier_order.php' method='post'>
                                        <input type='hidden' name='order_id' value='$order_id'>
                                        <button type='submit' name='accept_admin_order_request'>Accept Order</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                }


    echo "</table>
    </div>";


?>