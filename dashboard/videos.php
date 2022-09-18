<?php
include("../session.php");
include('../config.php');
$userId = $_SESSION['user'];

$sql = "SELECT * FROM video where owner_id=$userId";
$result = mysqli_query($con, $sql);
//print_r($result);

echo "<link href='../assets/css/videos.css' rel=stylesheet />";
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
                    $video_id = $video['name'];
                    $questionsSql = "SELECT * FROM questions where video_id='$video_id'";
                    $questionsResult = mysqli_query($con, $questionsSql);
            ?>
                    <div class="video_container">
                        <div>
                            <h1 class="text-3xl font-bold"><?= htmlspecialchars($video['title']) ?></h1>
                            <p class="text-md"><?= htmlspecialchars($video['description']) ?></p>
                            <div class="flex mt-3">
                                <p class="text-md mr-3"><?= $video['views'] ?> views</p>
                                <p class="text-md mr-3"><?= mysqli_num_rows($questionsResult) ?> questions</p>
                            </div>
                        </div>
                        <div>
                            <a href=<?php echo "./video/edit.php?id=" . $video['name'] ?> class="bg-blue-500 px-4 py-3 text-white rounded">Edit</a>
                            <a href=<?php echo "./video/delete.php?id=" . $video['name'] ?> class="deleteBtn py-3 px-4">Delete</a>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="flex justify-center flex-col items-center h-screen">
                    <h1 class="text-2xl text-center">No video uploaded</h1>
                    <a href="../upload.php" class="p-3 rounded text-center text-white w-1/4 my-2" style="background-color: #607bda;">Upload Video</a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>