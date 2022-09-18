<?php
include("../session.php");
include('../config.php');
$userId = $_SESSION['user'];

$session_user = $_SESSION['user'];
$fetch_events = "SELECT * FROM events where creator_id='$session_user'";
$result = mysqli_query($con, $fetch_events);

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
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="flex border-2 p-3 my-3 border-indigo-500 rounded ">
                        <div style="width:500px;" class="mr-10">
                            <img style="width:100%;height:200px;object-fit:cover" src="../<?= $row['event_cover'] ?>" alt="">
                        </div>
                        <div class="flex justify-between w-full">
                            <div>
                                <h1 class="text-3xl font-bold mb-3"><?= $row['title'] ?></h1>
                                <p class="text-md"><?= $row['description'] ?></p>
                                <p class="text-md">Date: <?= $row['date'] ?></p>
                            </div>
                            <div>
                                <a href=<?php echo "./event/edit.php?id=" . $row['name'] ?> class="bg-blue-500 px-4 py-3 text-white rounded">Edit</a>
                                <a href=<?php echo "./event/delete.php?id=" . $row['name'] ?> class="deleteBtn">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php

                }
            } else {
                ?>
                <div class="flex justify-center flex-col items-center h-screen">
                    <h1 class="text-2xl text-center">No video uploaded</h1>
                    <a href="/vod/event/add" class="p-3 rounded text-center text-white w-1/4 my-2" style="background-color: #607bda;">Create event</a>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</body>