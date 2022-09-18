<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/Exception.php';
require 'vendor/PHPMailer.php';
require 'vendor/SMTP.php';

session_start();
if (isset($_SESSION['user'])) {
    header("Location:index.php");
}
include("functions.php");
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    if (empty($email)) {
        echo "<script>alert('Field cannot be empty')</script>";
    }
    $sql = "Select * from users WHERE email='$email'";
    $data = mysqli_query($con, $sql);
    $results = mysqli_fetch_assoc($data);
    if (!$results) {
        $error_user = "No user with associated email found";
    }
    $token = user_token();
    $checkTokenExists = "Select * from reset_password WHERE email='$email'";
    $existsResult = mysqli_query($con, $checkTokenExists);
    if (mysqli_num_rows($existsResult) > 0) {
        $deletetoken = "DELETE from reset_password where email='$email'";
        mysqli_query($con, $deletetoken);
    }
    $insertToken = "INSERT into reset_password(email,token) VALUES('$email','$token') ";
    if (mysqli_query($con, $insertToken)) {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '3f70d88fd487a2';
        $phpmailer->Password = 'cf8ae0a5fbdd88';
        $phpmailer->setFrom('no-reply@onlystudy.com', 'noreply');
        $phpmailer->addAddress($email, $email);
        $phpmailer->isHTML(true);                                  //Set email format to HTML
        $phpmailer->Subject = 'Here is the subject';
        $phpmailer->Body    = '<a href="http://localhost/vod/reset.php?email=' . $email . '&token=' . $token . '">Reset</a>';
        $phpmailer->send();
        $success_msg = "Check your email for reset link";
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
            <h1>Forgot Password</h1>
            <form action="" method="POST">
                <?php
                if (isset($success_msg)) {
                    echo "<p class='success_msg'>$success_msg</p>";
                }
                ?>
                <label for="">Email</label>
                <input type="email" label="Email" placeholder="Input your email address" class="user" required name="email" />
                <?php
                if (isset($error_pwd)) {
                    echo "<p class='error_msg'>$error_pwd</p>";
                }
                ?>
                <input type="submit" value="Forget Password" class="user loginButton" />
            </form>
            <a href="./login.php" style="color: #607bda;margin-bottom:20px;">Login</a>
            <a href="./register.php" style="color: #607bda">Register</a>
        </div>
    </div>
</body>

</html>