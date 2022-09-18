<?php
include("../session.php");
include('../config.php');
$userId = $_SESSION['user'];

$user = "SELECT * FROM users where id=$userId";
$result = mysqli_query($con, $user);
if (mysqli_num_rows($result) > 0) {
    while ($user = mysqli_fetch_assoc($result)) {
        $username = $user['username'];
        $email = $user['email'];
        $profile = $user['profile'];
    }
}

echo "<link href='../assets/css/videos.css' rel=stylesheet />";
$title = "Profile";
include('../layouts/navbar.php');
?>

<body>
    <div class="main">
        <?php
        include('sidebar.php');
        ?>
        <div class="videos p-5 bg-blue-500 w-1/3 text-white rounded mx-auto">
            <?php
            if (isset($profile)) {
            ?>
                <img class="inline-block h-16 w-16 rounded-full ring-2 ring-white" src="./../<?= $profile ?>" />
            <?php
            }
            ?>
            <h1 class="text-2xl mb-3 ">Username: <?= $username ?></h1>
            <h1 class="text-2xl mb-3 ">Email: <?= $email ?></h1>
            <a href="<?= "./profile/edit.php" ?>" class="bg-green-500 px-4 py-3 text-white rounded block text-center">Edit</a>
        </div>

    </div>
</body>