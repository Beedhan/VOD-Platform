<?php
include("../session.php");
include('../config.php');
$userId = $_SESSION['user'];

$sql = "SELECT * FROM video where owner_id=$userId";
$result = mysqli_query($con, $sql);
// print_r($result);

echo "<link href='../assets/css/videos.css' rel=stylesheet />";
include('../layouts/navbar.php');
?>

<body>
    <h1>Your videos</h1>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($video = mysqli_fetch_assoc($result)) {
    ?>
            <div class="video_container">
                <div>
                    <h1><?= $video['title'] ?></h1>
                    <p style="font-size: larger;"><?= $video['description'] ?></p>
                </div>
                <div>
                    <button>Edit</button>
                    <button>Delete</button>
                </div>
            </div>
    <?php
        }
    }
    ?>
</body>