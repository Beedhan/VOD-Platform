<?php
include("config.php");
include("functions.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Field cannot be empty')</script>";
    }
    $sql = "INSERT INTO users(username,email,password) VALUES('$username','$email','$password')";
    $error_user = checkUser($con, $username);
    $error_email = checkEmail($con, $email);
    if (mysqli_query($con, $sql) && $error_user == null && $error_email == null) {
        $success_message = "Registration Successful";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="./assets/css/styleLogin.css" />
    <link rel="stylesheet" href="./assets/css/global.css" />
    
</head>

<body>
    <div class="container">
        <div class="left">
            <div>
                <h1>Learn anything </h1>
            </div>
        </div>
        <div class="right">
            <h1>Register</h1>
            <form action="" method="POST">
                <?php if (isset($success_message)) echo "<p class='success_msg'><img src='./assets/animations/tick.svg' class='anim_icon'/> $success_message</p> " ?>
                <label for="">Username</label>
                <input type="text" label="Username" placeholder="Username" class="user" required name="username" />
            <?php if (isset($error_user)) echo "<span class='error_msg'><img src='./assets/animations/error.svg' class='anim_icon'/> $error_user</span> " ?>
                <label for="">Email</label>
                <input type="email" label="Email" placeholder="Email address" class="user" required name="email" />
                <?php if (isset($error_email)) echo "<p class='error_msg'><img src='./assets/animations/error.svg' class='anim_icon'/>$error_email</p> " ?>
                <label for="">Password</label>
                <input type="password" label="Password" placeholder="Password" class="user" required required name="password" />
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
            <a href="./login.php" style="color: #607bda">Register</a>
        </div>
    </div>
</body>
</html>