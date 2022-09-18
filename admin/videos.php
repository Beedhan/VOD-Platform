<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/admin/admin.php");

$sql = "SELECT * FROM video";
$result = mysqli_query($con, $sql);
// print_r($result);

echo "<link href='./assets/videos.css' rel=stylesheet />";
include('../layouts/navbar.php');
?>

<body>
    <div class="main">
        <?php
        include('sidebar.php');
        ?>
        <div class="videos">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($video = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="video_container">
                        <div>
                            <h1 style="font-size: larger;"><?= htmlspecialchars($video['title']) ?></h1>
                            <p style="font-size: medium;"><?= htmlspecialchars($video['description']) ?></p>
                        </div>
                        <div>
                            <a href=<?php echo "./video/delete.php?id=" . $video['name'] ?> class="deleteBtn">Delete</a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>