<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$userId = $_SESSION['user'];
$question_id = $_GET['id'];
$video_id = $_GET['video_id'];
$delete_questions = "DELETE from questions WHERE video_id='$video_id' AND id='$question_id'";
$delete_answers = "DELETE from answers WHERE id='$question_id'";
$select_video = "SELECT * from video WHERE name='$video_id' AND owner_id='$userId' ";
$select_result = mysqli_query($con, $select_video);

if (mysqli_num_rows($select_result) > 0) {
    if (mysqli_query($con, $delete_questions)) {
        mysqli_query($con, $delete_answers);
        header('Location:/vod/dashboard/questions.php');
    } else {
        echo "Question not found";
    }
} else {
    echo "Oopise <br/>";
    echo "Not the owner of the video";
}
