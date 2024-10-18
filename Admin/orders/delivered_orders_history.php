<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include_once "../../Connection/connection.php";
    include_once "../../Function/function.php";

    if(!isset($_SESSION['admin']['islogin']) || $_SESSION['admin']['islogin'] ==false){
        header("Location: ../admin.php");
    }

    echo "<div id='conatiner'>
            <h3>Accepted Delivered Orders</h3>";

            $query = "SELECT * FROM orders  WHERE isAccept_suplier=true  AND isDelivered=true ORDER BY delivered_date DESC";

            $result = mysqli_query($connection,$query);

            echo "<table border='1'>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Flower ID</th>
                        <th>Flower Name</th>
                        <th>Suplier ID</th>
                        <th>Suplier Name</th>
                        <th>Quantity</th>
                        <th>Item Price</th>
                        <th>Sale Price</th>
                        <th>Total Price</th>
                        <th>Delivered Date</th>
                        
                    </tr>";

                    if(mysqli_num_rows($result)>0){
                        while($row = mysqli_fetch_assoc($result)){
                            $order_id = $row['order_id'];
                            $order_date = $row['order_date'];
                            $flower_id = $row['flower_id'];
                            $quantity = (int)$row ['quantity'];
                            $suplier_id = $row['suplier_id'];
                            $item_price = (float)$row['purchase_price'];
                            $flower_sale_price = $row['order_sale_price'];
                            $delivered_date = $row['delivered_date'];
                            $total_price = (float) ($quantity *  $item_price);

                            $retrieve_flower = "SELECT * FROM  flowers WHERE flower_id = '$flower_id' LIMIT 1";
                            $retrieve_flower_result = mysqli_query($connection,$retrieve_flower);

                            $retrieve_suplier = "SELECT * FROM   supliers WHERE suplier_id = '$suplier_id' LIMIT 1";
                            $retrieve_suplier_result = mysqli_query($connection,$retrieve_suplier);

                            $flower_data= mysqli_fetch_assoc($retrieve_flower_result);
                            $flower_name = $flower_data['flower_name'];
                           
                            $suplier_name = mysqli_fetch_assoc($retrieve_suplier_result)['suplier_username'];

                            echo "<tr>
                                    <td>$order_id</td>
                                    <td>$order_date</td>
                                    <td>$flower_id</td>
                                    <td>$flower_name</td>
                                    <td>$suplier_id</td>
                                    <td>$suplier_name</td>
                                    <td>$quantity</td>
                                    <td>$item_price</td>
                                    
                                    <td>$flower_sale_price</td>
                                    <td>$total_price</td>
                                    <td>$delivered_date</td>
                                        
                                    
                                </tr>";
                        }
                    }


    echo "</table>
    </div>";


?>