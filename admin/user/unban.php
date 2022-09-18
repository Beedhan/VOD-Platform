<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/admin/admin.php");

$user_id = $_GET['id'];
$ban_user = "UPDATE users SET status=1 WHERE id=$user_id";
if (mysqli_query($con, $ban_user)) {
    header("Location:/vod/admin/users.php");
} else {
    header('Location:/vod/404.php');
}
