<?php
include("session.php");
include("functions.php");
include('config.php');

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // print_r($_FILES);
//     if (isset($_FILES)) {
//         $file_name = $_FILES['video']['name'];
//         $file_type = $_FILES['video']['type'];
//         $file_temp = $_FILES['video']['tmp_name'];
//         $file_destination = "upload/" . $file_name;
//         if (move_uploaded_file($file_temp, $file_destination)) {
//             $sql = "INSERT INTO video(title) VALUES('$file_name)";
//             if (mysqli_query($con, $sql)) {
//                 $success = "Video uploaded successfully";
//             }
//         } else {
//             $error_msg = "Error uploading video <br> Eg:Max size exceeded";
//         }
//     } else {
//         $error_msg = "Please select a video to upload";
//     }
// }

if (isset($_POST['submit'])) {

    $video_title = $_POST['title'];
    $video_description = $_POST['desc'];
    $video_category = $_POST['category'];
    $video_name = $_FILES['video']['name'];
    $video_type = $_FILES['video']['type'];
    $video_temp = $_FILES['video']['tmp_name'];
    $video_destination = "upload/ " . $video_name;

    move_uploaded_file($video_temp, $video_destination);
    $sql = "INSERT INTO video( name,title, description,category, video_location) VALUES('$video_name', '$video_title','$video_description','$video_category', '$video_destination')";

    if (mysqli_query($con, $sql)) {
        $success = "Video uploaded successfully";
    }
} else {
    $error_msg = "Please select the video to upload";
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


    <form method="POST" enctype="multipart/form-data" class="uploadForm" id="uploadForm">
        <input type="text" name="title" id="" placeholder="Title" class="textInput">
        <textarea class="textInput" placeholder="Description" name="desc"></textarea>
        <label for="lang" class="catTitle">Category :</label>

        <select name="category" id="category">
            <option value="">--Choose Cattegory--</option>
            <option value="Educational">Educational</option>
            <option value="Entertainment">Entertainment</option>
            <option value="Cooking">Cooking</option>
            <option value="News">News</option>
            <option value="History">History</option>
            <option value="Technology">Technology</option>

        </select>
        <label for="video-upload" class="upload-label" id="upload-label">Select video</label>
        <input id="video-upload" type="file" name="video" accept="video/mp4,video/*" style="visibility: hidden;" />
        <button type="submit" id="submit" name="submit">Upload</button>
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