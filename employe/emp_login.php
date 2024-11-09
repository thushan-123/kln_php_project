<?php

    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors",1);

    include_once "../Connection/connection.php";
    include_once "../Function/function.php";

    $errors = [];

    if(isset($_POST['submit'])){
        $email = user_input($_POST['email']);
        $email = mysqli_real_escape_string($connection,$email);

        $password = mysqli_real_escape_string($connection, $_POST['password']);

        if(empty($email) || empty($password)){
            $errors[] = "Please fill in all fields";
        }

        $hash_pwd = sha1($password);

        $query = "SELECT * FROM employe WHERE email = '$email' AND password = '$hash_pwd' AND active=true LIMIT 1";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result)>0){
            $data = mysqli_fetch_assoc($result);

            $_SESSION['employe']['employe_id'] = $data['employe_id'];
            $_SESSION['employe']['employe_name'] = $data['employe_name'];
            $_SESSION['employe']['email'] = $data['email'];
            $_SESSION['employe']['islogin'] = true;
            header("Location: ./emp_dashboard.php");
        }else{
            $errors[] = "Login Fail";
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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <span>
                <?php
                    if(count($errors) > 0){
                        foreach($errors as $error){
                            echo $error . "<br>";
                        }
                    }
                ?>
            </span>
            <input type="email" name="email" id="" placeholder="email"><br><br>
            <input type="password" name="password" id="" placeholder="password"><br><br>
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
    
</body>
</html>