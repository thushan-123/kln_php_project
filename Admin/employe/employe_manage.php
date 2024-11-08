<?php

    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors',1);

    include_once "../../Connection/connection.php";
    include_once "../../Function/function.php";

    if (!isset($_SESSION['admin']['islogin']) && $_SESSION['admin']['islogin'] != true){
        header("Location: ../adminLogin.php");
    }

    // get the employe details
    $query = "SELECT * FROM employe";
    $result = mysqli_query($connection, $query);

    $errors = [];

    // create a new employe
    if(isset($_POST['create_employe'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];


        // form validation
        if(empty($name) || empty($email) || empty($password) || empty($re_password)){
            $errors[] = "all fields are required";
        }
        if($password != $re_password){
            $errors[] = "passwords are not equal";
        }

        $name = mysqli_real_escape_string($connection,$name);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        if(count($errors) == 0){
            $employe_id = uniqid();
            $password = sha1($password);
            $sql = "INSERT INTO employe (employe_id, employe_name, email, password, created) VALUES ('$employe_id','$name','$email','$password', CURRENT_DATE)";

            if(mysqli_query($connection,$sql)){
                header("Location: ./employe_manage.php");
            }

            
        }
    }

    if(isset($_POST['change_employe_status'])){
        $employe_id = mysqli_real_escape_string($connection, $_POST['employe_id']);
        $status = (int) $_POST['change_employe_status'];

        $status = !$status ? 1 : 0;
       
        $query = "UPDATE employe SET active = '$status' WHERE employe_id = '$employe_id'";
        if(mysqli_query($connection, $query)){
            header("Location: ./employe_manage.php");
            
        }

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h2>Create a employe</h2>
        <form action="employe_manage.php" method="post">
            <span></span>
            <input type="text" name="name" placeholder="Enter Name" required><br><br>
            <input type="email" name="email" placeholder="Enter Email" required><br><br>
            <input type="password" name="password" id="" placeholder="Enter Password" required><br><br>
            <input type="password" name="re_password" id="" placeholder="Re Enter Password" required><br><br>
            <button type="submit" name="create_employe">Create</button>
        </form>
    </div>

    <div>
        <h2>Employe Details</h2>
        <table border="1">
            <tr>
                <th>Employe Id</th>
                <th>Employe Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>created Date</th>
                <th></th>
            </tr>
            
            <?php if(mysqli_num_rows($result) > 0):
                while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <th><?php echo $row['employe_id'] ?></th>
                        <th><?php echo $row['employe_name'] ?></th>
                        <th><?php echo $row['email'] ?></th>
                        <th><?php echo $row['active'] ?></th>
                        <th><?php echo $row['created'] ?></th>
                        <th>
                            <form action="employe_manage.php" method="post">
                                <input type="hidden" name="employe_id" value="<?php echo $row['employe_id'] ?>">
                                <button type="submit" name="change_employe_status" value="<?php echo $row['active'] ?>">
                                    <?php if($row['active'] == 1){
                                        echo "Deactive";
                                    }else{
                                        echo "Active";
                                    }
                                         ?>
                                </button>
                            </form>
                        </th>
                    </tr>
            <?php endwhile;
                endif; ?>

                
        </table>
    </div>
</body>
</html>