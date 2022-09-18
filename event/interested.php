<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$event_name = $_GET['id'];
$user_id = $_SESSION['user'];
$sql = "INSERT INTO interested(event_id,user_id) VALUES('$event_name','$user_id')";

if (mysqli_query($con, $sql)) {
    header("Location:/vod/events");
} else {
    echo mysqli_error($con);
}
