<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$session_user = $_SESSION['user'];
$session_username = $_SESSION['username'];
$question = mysqli_real_escape_string($con, $_POST['question']);
$video_id = mysqli_real_escape_string($con, $_POST['video_id']);
$sql = "INSERT INTO questions(question,user_id,video_id,questioner_name) VALUES('$question','$session_user','$video_id','$session_username')";

if (mysqli_query($con, $sql)) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    $response = array(
        'status' => true,
        'message' => 'Success',
        'username' => $session_username,
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
