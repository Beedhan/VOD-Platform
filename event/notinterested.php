<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$event_name = $_GET['id'];
$user_id = $_SESSION['user'];
$sql = "DELETE FROM interested where event_id='$event_name' AND user_id='$user_id'";

if (mysqli_query($con, $sql)) {
    header("Location:/vod/events");
} else {
    echo mysqli_error($con);
}
