<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/admin/admin.php");

$sql = "SELECT * FROM users where role!='admin'";
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
                while ($user = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="video_container">
                        <div>
                            <h1 style="font-size: larger;"><?= htmlspecialchars($user['username']) ?></h1>
                            <p style="font-size: medium;"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                        <div>
                            <?php
                            if ($user['status'] == 0) {
                            ?>
                                <a href=<?php echo "./user/unban.php?id=" . $user['id'] ?> class="deleteBtn">Unban</a>
                            <?php
                            } else {
                            ?>
                                <a href=<?php echo "./user/ban.php?id=" . $user['id'] ?> class="deleteBtn">Ban</a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>