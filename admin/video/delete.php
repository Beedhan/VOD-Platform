<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/admin/admin.php");


$video_id = $_GET['id'];
$delete_video = "DELETE from video WHERE name='$video_id'";
if (mysqli_query($con, $delete_video)) {
    $delete_notes = "DELETE from notes WHERE video_id='$video_id'";
    $delete_questions = "DELETE from questions WHERE video_id='$video_id'";
    mysqli_query($con, $delete_notes);
    mysqli_query($con, $delete_questions);
    header('Location:/vod/admin/videos.php');
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/vod/upload/ " . $video_id . ".mp4")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/vod/upload/ " . $video_id . ".mp4");
    } else {
        echo $_SERVER['DOCUMENT_ROOT'] . "/vod/upload/ " . $video_id . ".mp4";
    }
} else {
    header('Location:/vod/404.php');
}
