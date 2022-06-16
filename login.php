<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location:index.php");
}
include("functions.php");
include("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        echo "<script>alert('Field cannot be empty')</script>";
    }
    $sql = "Select * from users WHERE email='$email'";
    $data = mysqli_query($con, $sql);
    $results = mysqli_fetch_assoc($data);
    if (!$results) {
        $error_user = "No user with associated email found";
    }
    $pwdVerified = password_verify($password, $results['password']);
    // print_r($pwdVerified);
    if ($pwdVerified == false) {
        $error_pwd = "Password is incorrect";
    } else {
        $_SESSION['user'] = $results['id'];
        $_SESSION['username'] = $results['username'];
        header("Location:index.php");
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/styleLogin.css" />
    <link rel="stylesheet" href="./assets/css/global.css" />
</head>

<body>
    <div class="container">
        <div class="left">
            <div>
                <img src="assets/copy.png" alt="" />
                <h1>Learn anything </h1>
                <h1>Anytime </h1>
            </div>
        </div>
        <div class="right">
            <h1>Login</h1>
            <form action="" method="POST">
                <?php
                if (isset($error_user)) {
                    echo "<p class='error_msg'>$error_user</p>";
                }
                ?>
                <label for="">Email</label>
                <input type="email" label="Email" placeholder="Input your email address" class="user" required name="email" />
                <label for="">Password</label>
                <input type="password" label="Password" placeholder="Input your password" class="user" required name="password" />
                <?php
                if (isset($error_pwd)) {
                    echo "<p class='error_msg'>$error_pwd</p>";
                }
                ?>
                <div class="wrap">
                    <div style="display: flex">
                        <input style="padding: 5px;cursor:pointer" type="checkbox" label="Remember Me" />
                        <label for="">Remember me</label>
                    </div>
                    <div>
                        <a href="">Forgot Password</a>
                    </div>
                </div>
                <input type="submit" value="Login" class="user loginButton" />
            </form>
            <a href="./register.php" style="color: #607bda">Register</a>
        </div>
    </div>
</body>

</html>