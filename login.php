<?php
include("config.php")
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
            <form action="">
                <label for="">Email</label>
                <input type="email" label="Email" placeholder="Input your email address" class="user" required />
                <label for="">Password</label>
                <input type="password" label="Password" placeholder="Input your password" class="user" required />
                <div class="wrap">
                    <div style="display: flex">
                        <input style="padding: 5px;cursor:pointer" type="checkbox" label="Remember Me" />
                        <label for="">Remember me</label>
                    </div>
                    <div>
                        <a href="">Forgot Password</a>
                    </div>
                </div>
                <input type="button" value="Login" class="user loginButton" />
            </form>
            <a href="./register.php" style="color: #607bda">Register</a>
        </div>
    </div>
</body>

</html>