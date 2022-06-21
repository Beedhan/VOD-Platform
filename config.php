<?php
$host = "localhost";
$user= "root";
$db= "vod";
$con = mysqli_connect($host, $user, "", $db,  3306);
    if (!$con) {
        die("Connection failed");
    }
