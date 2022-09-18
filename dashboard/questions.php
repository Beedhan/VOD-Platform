<?php
include("../session.php");
include('../config.php');
$userId = $_SESSION['user'];

$videos = "SELECT * FROM video where owner_id=$userId";
$result = mysqli_query($con, $videos);
$questionsResultArray = array();
if (mysqli_num_rows($result) > 0) {
    while ($video = mysqli_fetch_assoc($result)) {
        $video_id = $video['name'];
        $questionsSql = "SELECT * FROM questions where video_id='$video_id'";
        $question_answer = "SELECT questions.*,answers.answer  FROM questions LEFT  JOIN answers ON (questions.answer_id<=>answers.id) where questions.video_id='$video_id'";
        $questionsResult = mysqli_query($con, $question_answer);
        if (mysqli_num_rows($questionsResult) > 0) {
            while ($questions = mysqli_fetch_assoc($questionsResult)) {
                array_push($questionsResultArray, $questions);
            }
        }
    }
}

echo "<link href='../assets/css/videos.css' rel=stylesheet />";
$title = "Questions";
include('../layouts/navbar.php');
?>

<body>
    <div class="main">
        <?php
        include('sidebar.php');
        ?>
        <div class="videos">
            <?php
            for ($i = 0; $i < count($questionsResultArray); $i++) {

            ?>
                <div class="bg-zinc-700 p-3 text-white my-3">
                    <div class="flex mb-3">
                        <p class="font-bold mr-2">Question:</p>
                        <h1><?= htmlspecialchars($questionsResultArray[$i]['question']) ?></h1>
                        <a href="<?php echo "./questions/delete.php?id=" . $questionsResultArray[$i]['id'] . "&video_id=" . $questionsResultArray[$i]['video_id'] ?>" class="deleteBtn ml-auto">Remove</a>
                    </div>
                    <?php
                    if (!isset($questionsResultArray[$i]['answer_id'])) {
                    ?>
                        <form method="post" action="./questions/answer.php">
                            <input type="text" name="answer" required class="questionField pbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Reply   " />
                            <input type="text" name="question_id" class="hidden " hidden value="<?= $questionsResultArray[$i]['id'] ?>" />
                            <button type="submit" name="submit">Submit</button>
                        </form>
                    <?php
                    } else {
                    ?>
                        <div class="flex mb-3">
                            <p class="font-bold mr-2">Answer: </p>
                            <h1><?= $questionsResultArray[$i]['answer'] ?></h1>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php

            }
            ?>
        </div>
    </div>
</body>