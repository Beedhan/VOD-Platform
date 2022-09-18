<?php
include('head.php');
?>

<body>
    <nav class="px-5">
        <h1><a class="font-semibold" href="/vod">OnlyStudy</a></h1>
        <ul>
            <li>
                <a href="<?= '/vod/events'; ?>">Events</a>
            </li>
            <li>
                <a href="<?= "/vod/upload.php"; ?>">Upload</a>
            </li>
            <?php
            if (isset($_SESSION['user'])) {
            ?>
                <li>
                    <a href="<?= "/vod/dashboard/videos.php" ?>">Dashboard</a>
                </li>

            <?php } ?>
            <li>
                <a href="<?= "/vod/logout.php" ?>">Logout</a>
            </li>
        </ul>
    </nav>
</body>