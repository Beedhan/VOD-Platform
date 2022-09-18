<?php
include("session.php");
include("functions.php");
include('config.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['category']) && isset($_FILES['video'])) {
        $video_title = mysqli_real_escape_string($con, $_POST['title']);
        $video_description = mysqli_real_escape_string($con, $_POST['desc']);
        $video_category = mysqli_real_escape_string($con, $_POST['category']);
        $video_name = video_id();
        $video_format = explode('.', $_FILES['video']['name']);
        $video_type = $_FILES['video']['type'];
        $video_temp = $_FILES['video']['tmp_name'];
        $video_destination = "upload/" . $video_name . "." . $video_format[count($video_format) - 1];
        $session_user = $_SESSION['user'];
        move_uploaded_file($video_temp, $video_destination);
        $sql = "INSERT INTO video( name,title, description,category, video_location,owner_id) VALUES('$video_name', '$video_title','$video_description','$video_category', '$video_destination','$session_user')";

        if (mysqli_query($con, $sql)) {
            $success = "Video uploaded successfully";
        }
    } else {
        $error_msg = "Please fill up form completely";
    }
}

?>
<?php
$title = "Uploads";
echo "<link rel='stylesheet' href='assets/css/upload.css'>";
include('layouts/navbar.php');
?>

<head>
    <link rel="stylesheet" href="./assets/css/upload.css" />
</head>

<body>
    <h1 class="text-center text-3xl p-5 text-white font-bold mb-3" style="background-color: #607bda;">Upload New Video</h1>
    <form method="POST" enctype="multipart/form-data" class="uploadForm" id="uploadForm">
        <input type="text" name="title" id="" placeholder="Title" class="textInput" required>
        <textarea class="textInput" placeholder="Description" name="desc" required></textarea>
        <label for="lang" class="catTitle">Category :</label>

        <select name="category" id="category" required>
            <option value="">--Choose Category--</option>
            <option value="Educational">Educational</option>
            <option value="Language">Language</option>
            <option value="Finance">Finance & Accounting</option>
            <option value="Animation">Animation & Design</option>
            <option value="Cooking">Cooking</option>
            <option value="News">News</option>
            <option value="History">History</option>
            <option value="Technology">Technology</option>
            <option value="Game Development">Game Development</option>
            <option value="Programming">Programming</option>
        </select>
        <label for="video-upload" class="upload-label" id="upload-label">Select video</label>
        <input id="video-upload" type="file" name="video" accept="video/mp4,video/*" style="visibility: hidden;" required />
        <button type="submit" id="submit" name="submit">Upload</button>
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