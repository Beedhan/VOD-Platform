<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$session_user = $_SESSION['user'];
$content = mysqli_real_escape_string($con, $_POST['content']);
$time = mysqli_real_escape_string($con, $_POST['time']);
$video_id = mysqli_real_escape_string($con, $_POST['video_id']);
$sql = "INSERT INTO notes( timestamp,note,owner_id,video_id) VALUES('$time', '$content','$session_user','$video_id')";
$fetch_times = "SELECT * FROM notes where owner_id='$session_user' AND video_id='$video_id'";

if (mysqli_query($con, $sql)) {
    $result = mysqli_query($con, $fetch_times);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);
    $response = array(
        'status' => true,
        'message' => 'Success',
        'data' => $data
    );
    echo json_encode($response);
}
