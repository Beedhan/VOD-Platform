<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$video_id = $_POST['question_id'];
$sql = "DELETE from questions WHERE id='$video_id'";
// $fetch_times = "SELECT * FROM notes where owner_id='$session_user' AND video_id='$video_id'";

if (mysqli_query($con, $sql)) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    $response = array(
        'status' => true,
        'message' => 'Success',
    );
    echo json_encode($response);
} else {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(403);
    $response = array(
        'status' => false,
        'message' => 'Error',
        'data' => $sql
    );
    echo json_encode($response);
}
