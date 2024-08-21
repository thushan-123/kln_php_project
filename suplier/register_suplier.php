<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once __DIR__ . '/../Function/function.php';
include_once __DIR__ . '/../Connection/connection.php';

try {

    // Create an error array
    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Get the user input details
        $username = user_input($_POST['username']);
        $email = user_input($_POST['email']);
        $password = user_input($_POST['password']);
        $mobile = user_input($_POST['mobile']);
       

        // Check for validation
        if (empty($username) || empty($email) || empty($password) || empty($mobile)) {

            $errors[] = 'All fields are required';

        } elseif (!(preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email))) {

            $errors[] = "Email is not valid";

        } elseif (!(ctype_digit($mobile))) {

            $errors[] = "Mobile number is not valid";

        } elseif (strlen($username) < 4 || strlen($password) < 5) {

            $errors[] = "Username or password is too short";
        }

        // Check email or mobile is taken
        try{
            $email = mysqli_real_escape_string($connection,$email);
            $mobile =  mysqli_real_escape_string($connection,$mobile);

            $query = "SELECT * FROM supliers WHERE email='$email' OR mobile='$mobile';";

            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) > 0) {

                $errors[] = "Email or Mobile already exits";
            }
            logger("WARNING", "$email or $mobile is already taken");

        }catch(Exception $e){
            logger("ERROR", $e->getMessage());
        }

        // Check for no errors before inserting data into the database
        if (count($errors) == 0) {

            // Password hash to sha1 algorithm
            $password = sha1($password);


            //  Void for the sql injection
            $username = mysqli_real_escape_string($connection, $username);
            $email = mysqli_real_escape_string($connection, $email);
            $password = mysqli_real_escape_string($connection, $password);
            $mobile = mysqli_real_escape_string($connection, $mobile);
            

            $query = "INSERT INTO supliers (suplier_username, email, password, mobile) VALUES ('$username', '$email', '$password', '$mobile')";

            try {
                // Insert data into the users table
                if (mysqli_query($connection, $query)) {
                    logger("INFO", "register_register : Suplier data inserted successfully");

                    // If the query executes successfully, redirect to the login page
                    header("Location: login_suplier.php?Register=true&Username=$username");
                    exit();
                } else {
                    throw new Exception("Query failed: " . mysqli_error($connection));
                }
            } catch (Exception $e) {
                logger("ERROR", "register.php : " . $e->getMessage());
            }
        }
    }
} catch (Exception $e) {
    logger("ERROR", "register.php: " . $e->getMessage());
}

 $connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="script/register.js"></script>
    <link rel="stylesheet" href="../style/register.css">
</head>
<body>
    <div>
        <h1>Flowers</h1>
    </div>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <?php 
                if (count($errors) > 0) {
                    echo "<div id='error-box'> $errors[0] </div>";
                }
            ?>

            <input type="text" name="username" id="username" placeholder="Username" required/><br><br>

            <input type="email" name="email" id="email" placeholder="Email" required/><br><br>

            <input type="number" name="mobile" id="mobile" placeholder="Mobile" required/><br><br>

            <input type="password" name="password" id="password" placeholder="Password" required/><br><br>

            
            <button id="submit-btn" type="submit">Register</button><br><br>

        </form>
    </div>
</body>
</html>