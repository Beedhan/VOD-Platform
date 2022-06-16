<?php
include("session.php");
include("functions.php");
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // print_r($_FILES);
    $file_name = $_FILES['video']['name'];
    $file_type = $_FILES['video']['type'];
    $file_temp = $_FILES['video']['tmp_name'];
    $file_destination = "upload/" . $file_name;
    if (move_uploaded_file($file_temp, $file_destination)) {
        $success = "Video uploaded successfully";
    } else {
        $error_msg = "Please select a video to upload";
    }
}
?>
<?php
$title = "Uploads";
echo "<link rel='stylesheet' href='assets/css/upload.css'>";
include('layouts/navbar.php');
?>
<form method="POST" enctype="multipart/form-data" class="uploadForm" id="uploadForm">
    <input type="text" name="title" id="" placeholder="Title" class="textInput">
    <textarea class="textInput" placeholder="Description"></textarea>
    <label for="video-upload" class="upload-label" id="upload-label">Select video</label>
    <input id="video-upload" type="file" name="video" accept="video/mp4,video/*" style="visibility: hidden;" />
    <button type="submit" id="submit">Upload</button>
    <?php
    if (isset($error_msg)) {
        echo "<p class='error_msg'>$error_msg</p>";
    }
    ?>
    <?php
    if (isset($success)) {
        echo "<p class='success_msg'>$success</p>";
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