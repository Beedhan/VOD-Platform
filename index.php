<?php
include("session.php");
include('config.php');
$title = "Welcome to Student VOD";
include('layouts/navbar.php');


?>

<head>
    <link rel="stylesheet" href="./assets/css/index.css" />
</head>

<body>

<div class="video_container mx-5">
    <?php
    $sql = "SELECT * FROM video";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($video = mysqli_fetch_assoc($result)) {
    ?>
    <a href="watch?video=<?= $video['name']?>">
        <video src="<?= $video['video_location'] ?>"  ></video>
        <div class="flex justify-between align-center px-2 pt-2">
            <h1 class="font-medium"><?=$video['title']?></h1>
            <p><?=$video['views']?> views</p>
        </div>
    </a>
    <?php
        }
    }
    ?>
</div>
</body>

</html>