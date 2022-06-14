<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
</head>

<body>
    <?php
    //?                     host      username   password db_name port 
    $conn = mysqli_connect("localhost", "root", "",    "vod",  3306);
    if (!$conn) {
        die("Connection failed");
    }
    $name = $_REQUEST['name'];
    $password = $_REQUEST['password'];
    $re_password = $_REQUEST['re_password'];

    if ($password != $re_password) {
        echo "<h3>Insert same password</h3>";
        die();
    }
    $sql = "INSERT INTO users(name,password) VALUES('$name,'$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<h3>Data stored</h3>";
    } else {
        echo "<h3>Data store failed</h3>";
    }
    ?>
</body>

</html>