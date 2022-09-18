<?php
include("functions.php");
include("config.php");


$email = $_GET['email'];
$token = $_GET['token'];
$checktoken = "SELECT * FROM reset_password where email='$email' AND token='$token'";
$result = mysqli_query($con, $checktoken);
if (mysqli_num_rows($result) == 0) {
    echo "Token or email does not match";
    return;
}
if (isset($_POST['submit'])) {
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        $hashedPwd = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password='$hashedPwd' where email='$email'";
        if (mysqli_query($con, $sql)) {
            $deletetoken = "DELETE from reset_password where email='$email' AND token='$token'";
            mysqli_query($con, $deletetoken);
            $success_message = "Reset Successful";
        } else {
            echo mysqli_error($con);
        }
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
            <h1>Reset Password</h1>
        </div>
        <div class="right">
            <form method="POST">
                <?php
                if (isset($success_message)) {
                    echo "<p class='success_msg'>$success_message</p>";
                }
                ?>
                <label for="">Password</label>
                <input type="password" label="Password" placeholder="Input your password" class="user" required name="password" />
                <button type="submit" id="submit" name="submit">Reset</button>
            </form>
            <a href="./login.php" style="color: #607bda;margin-bottom:20px;">Login</a>
            <a href="./register.php" style="color: #607bda">Register</a>
        </div>
    </div>
</body>

</html>