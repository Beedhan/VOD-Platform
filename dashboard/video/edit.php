<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/functions.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$userId = $_SESSION['user'];
$video_id = $_GET['id'];
$videosql = "SELECT * FROM video where video.name='$video_id' and owner_id=$userId";
$video = mysqli_query($con, $videosql);

if (mysqli_num_rows($video) > 0) {
    while ($row = mysqli_fetch_assoc($video)) {
        $video_title = $row['title'];
        $video_description = $row['description'];
        $video_category = $row['category'];
    }
}

if (isset($_POST['submit'])) {
    if (isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['category'])) {
        $video_title = mysqli_real_escape_string($con, $_POST['title']);
        $video_description = mysqli_real_escape_string($con, $_POST['desc']);
        $video_category = mysqli_real_escape_string($con, $_POST['category']);
        $session_user = $_SESSION['user'];
        $sql = "UPDATE video SET title='$video_title',description='$video_description',category='$video_category' where video.name='$video_id' and owner_id=$userId";
        if (mysqli_query($con, $sql)) {
            $success = "Video edited successfully";
        } else {
            echo mysqli_error($con);
        }
    } else {
        $error_msg = "Please fill up form completely";
    }
}

?>
<?php
$title = "Uploads";
echo "<link rel='stylesheet' href='assets/css/upload.css'>";
include('../../layouts/navbar.php');
?>

<head>
    <link rel="stylesheet" href="../../assets/css/upload.css" />
</head>

<body>
    <h1 class="text-center text-3xl p-5 text-white font-bold mb-3" style="background-color: #607bda;">Edit Video</h1>
    <form method="POST" enctype="multipart/form-data" class="uploadForm" id="uploadForm">
        <input type="text" name="title" id="" placeholder="Title" class="textInput" required value="<?= htmlspecialchars($video_title) ?>">
        <textarea class="textInput" placeholder="Description" name="desc" required><?= htmlspecialchars($video_description) ?></textarea>
        <label for="lang" class="catTitle">Category :</label>
        <select name="category" id="category" style="background-color: #607bda;" class=" p-3 text-white rounded my-2" required>
            <option value="">--Choose Category--</option>
            <option value="Educational" <?php if ($video_category == "Educational") echo "selected='selected'" ?>>Educational</option>
            <option value="Language" <?php if ($video_category == "Language") echo "selected='selected'" ?>>Language</option>
            <option value="Finance" <?php if ($video_category == "Finance") echo "selected='selected'" ?>>Finance & Accounting</option>
            <option value="Animation" <?php if ($video_category == "Animation") echo "selected='selected'" ?>>Animation & Design</option>
            <option value="Cooking" <?php if ($video_category == "Cooking")  echo "selected='selected'" ?>>Cooking</option>
            <option value="News" <?php if ($video_category == "News") echo "selected='selected'" ?>>News</option>
            <option value="History" <?php if ($video_category == "History") echo "selected='selected'" ?>>History</option>
            <option value="Technology" <?php if ($video_category == "Technology") echo "selected='selected'" ?>>Technology</option>
            <option value="Game Development" <?php if ($video_category == "Game Development") echo "selected='selected'" ?>>Game Development</option>
            <option value="Programming" <?php if ($video_category == "Programming") echo "selected='selected'" ?>>Programming</option>

        </select>
        <button type="submit" id="submit" name="submit">Update</button>
        <?php
        if (isset($error_msg)) {
            echo "<p class='error_msg'>$error_msg</p>";
        }
        ?>
        <?php
        if (isset($success)) {
            echo "<p class='success_msg'>$success</p>";
            header("Location:/vod/dashboard/videos.php");
        }
        ?>

    </form>
    <script>
        const fileSelect = document.querySelector("#video-upload");
        const uploadLabel = document.querySelector("#upload-label");
        fileSelect.addEventListener('change', (e) => {
            uploadLabel.textContent = e.target.files[0].name;
        });
    </script>
</body>