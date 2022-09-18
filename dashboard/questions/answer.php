<?php

include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

if (isset($_POST['submit'])) {
    if (isset($_POST['answer']) && isset($_POST['question_id'])) {
        $answer =  mysqli_real_escape_string($con, $_POST['answer']);
        $question_id =  mysqli_real_escape_string($con, $_POST['question_id']);
        $answerQuery = "INSERT into answers(answer,question_id) VALUES('$answer','$question_id')";
        mysqli_query($con, $answerQuery);
        $answer_id = mysqli_insert_id($con);
        $updateQuestionQuery = "UPDATE questions set answer_id=$answer_id where id=$question_id";
        if (mysqli_query($con, $updateQuestionQuery)) {
            header("Location:/vod/dashboard/questions.php");
        } else {
            echo mysqli_error($con);
        }
    }
}
