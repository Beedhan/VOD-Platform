<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$session_user = $_SESSION['user'];
$video_id = $_GET['video_id'];
$fetch_times = "SELECT questions.*,answers.answer FROM questions LEFT JOIN answers ON (questions.answer_id<=>answers.id) where questions.user_id='$session_user' AND questions.video_id='$video_id'";
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
