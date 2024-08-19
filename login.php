<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/Function/function.php';
require __DIR__ . '/Connection/connection.php';

try{
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        

            // Get the user input detail
            $email = user_input($_POST['email']);
            $password = user_input($_POST['password']);

            // Void sql injection
            $email = mysqli_real_escape_string($connection, $email);
            $password = mysqli_real_escape_string($connection, $password);


            // Check the database valied user
            try{
                $password = sha1($password);
                $query = "SELECT * From users WHERE email='$email' AND password='$password' LIMIT 1 ;";

                $query = mysqli_query($connection, $query);

                logger("INFO", "retrieve data from users table successfully");

                if (mysqli_num_rows($query) == 1){
                    $data = mysqli_fetch_assoc($query);
                    
                    // Genarate unique token
                    $token = bin2hex(random_bytes(16));
                    // Data is added to the session
                    $_SESSION['user_id'] = $data['user_id'];
                    $_SESSION['user_name'] = $data['user_name'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['mobile'] = $data['mobile'];
                    $_SESSION['token'] = $token;

                    $username = $data['user_name'];

                    // set the cookie with authantication token
                    setcookie('token',$token, time()+ 3600, "/");

                    // Login successfully redirect to the index.php page
                    logger("INFO", "User : $username login successfull. redirect to the index page.");
                    header("Location: index.php");
                    exit();

                }else{
                    echo "<script>window.alert('Invalied Username or Password')</script>";
                }
            }catch(Exception $e){
                logger("ERROR", $e->getMessage());
            }
        
    }
}catch(Exception $e){
    logger("ERROR", $e->getMessage());
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div>
        <h1>Flowers</h1>
    </div>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <?php 
                if ($_SERVER['REQUEST_METHOD']== 'GET'){
                    if ($_GET['UserRegister'] == true){
                        $Username = $_GET['Username'];
                        echo "<div class='welcome-box'><b> Hello $Username Please Login </b></div>";
                    }
                }
            ?>
            <input type="email" name="email" id="email"  placeholder="Email" required/><br><br>

            <input type="password" name="password" id="password"  placeholder="Password" required/><br><br>

            <button id="submit-btn" type="submit">Login</button><br><br>

            <a href="register.php" id="link">Create a new account</a>
        </form>
    </div>
    
</body>
</html>

