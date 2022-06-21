<?php
include("session.php");
$title = "Welcome to Student VOD";
include('layouts/navbar.php');


?>

<head>
    <link rel="stylesheet" href="./assets/css/index.css" />
</head>

<body>
    <?php
    include('config.php');
    $sql = "SELECT * FROM video ORDER BY vid_id DESC ";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($video = mysqli_fetch_assoc($result)) {
            print_r($video);
    ?>
            <video src="uploads/<?= $video['name'] ?>"></video>
    <?php

        }
    } else {
        echo "<h1?>Empty list </h1>";
    }

    ?>
    <p>Home page</p>
    <h2 class="title">Video Content</h2>
    <video controls>
        <source src="<?php echo '/upload' . $name ?>">

    </video>

</body>

</html>