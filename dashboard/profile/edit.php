<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/functions.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

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
if (isset($_POST['submit'])) {
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $existingUser = "SELECT * FROM users where username='$username' and id!=$userId";
        $existingResult = mysqli_query($con, $existingUser);
        if (mysqli_num_rows($existingResult) == 0) {
            if (isset($_FILES['profile']['tmp_name'])) {
                $profile_type = $_FILES['profile']['type'];
                $image_format = explode('.', $_FILES['profile']['name']);
                $image_temp = $_FILES['profile']['tmp_name'];
                $profile_destination = "../../profile/" . $username . "." . $image_format[count($image_format) - 1];
                move_uploaded_file($image_temp, $profile_destination);
                $stripped_destination = substr($profile_destination, 6);
                $sql = "UPDATE users SET username='$username',profile='$stripped_destination' where id=$userId";
            } else {
                $sql = "UPDATE users SET username='$username' where id=$userId";
            }
            if (mysqli_query($con, $sql)) {
                $success = "Details edited successfully";
            } else {
                echo mysqli_error($con);
            }
        } else {
            echo "Username already exists";
        }
    } else {
        $error_msg = "Error";
    }
}
echo "<link href='../../assets/css/videos.css' rel=stylesheet />";
$title = "Profile";
include('../../layouts/navbar.php');
?>

<body>
    <div class="main">

        <?php
        include('../sidebar.php');
        ?>
        <div class="videos p-5 bg-blue-500 w-1/2 text-white rounded mx-auto">

            <?php
            if (isset($success)) {
                echo "<p class='text-2xl text-green-500 bg-white p-3 text-center'>$success</p>";
            }
            ?>
            <h1 class="text-center text-3xl p-5 text-white font-bold mb-3">Edit Username</h1>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="username" id="" placeholder="Username" class="textInput" value="<?= htmlspecialchars($username) ?>">
                <label for="profile-upload" class="upload-label text-white border-white" id="upload-label">Select Profile Image</label>
                <input id="profile-upload" type="file" name="profile" accept="image/*" style="visibility: hidden;" />
                <button type="submit" style="background-color:red !important" id="submit" name="submit">Edit Profile</button>
            </form>
        </div>
    </div>
</body>

<script>
    const fileSelect = document.querySelector("#profile-upload");
    const uploadLabel = document.querySelector("#upload-label");
    fileSelect.addEventListener('change', (e) => {
        console.log('chnage')
        uploadLabel.textContent = e.target.files[0].name;
    });
</script>