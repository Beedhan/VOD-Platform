<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$userId = $_SESSION['user'];
$event_id = $_GET['id'];
$delete_event = "DELETE from events WHERE name='$event_id' AND creator_id='$userId' ";
if (mysqli_query($con, $delete_event)) {
    $delete_interested = "DELETE from interested WHERE event_id='$event_id'";
    mysqli_query($con, $delete_video);
    mysqli_query($con, $delete_interested);
    header('Location:/vod/dashboard/events.php');
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/vod/images/ " . $event_id)) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/vod/images/ " . $video_id);
    } else {
        echo $_SERVER['DOCUMENT_ROOT'] . "/vod/images/ " . $video_id . ".mp4";
    }
} else {
    header('Location:/vod/404.php');
}
