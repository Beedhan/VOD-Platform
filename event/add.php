<?php
include("../session.php");
include("../functions.php");
include('../config.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['date']) && isset($_FILES['event'])) {
        $event_title = mysqli_real_escape_string($con, $_POST['title']);
        $event_description = mysqli_real_escape_string($con, $_POST['desc']);
        $event_date = mysqli_real_escape_string($con, $_POST['date']);
        $event_name = video_id();
        $image_format = explode('.', $_FILES['event']['name']);
        $event_type = $_FILES['event']['type'];
        $image_temp = $_FILES['event']['tmp_name'];
        $event_destination = "../images/" . $event_name . "." . $image_format[count($image_format) - 1];
        $session_user = $_SESSION['user'];
        move_uploaded_file($image_temp, $event_destination);
        $stripped_destination = substr($event_destination, 3);
        $sql = "INSERT INTO events(name,title, description,date, event_cover,creator_id) VALUES('$event_name','$event_title','$event_description','$event_date', '$stripped_destination','$session_user')";

        if (mysqli_query($con, $sql)) {
            $success = "Event created successfully";
        }
    } else {
        $error_msg = "Please fill up form completely";
    }
}

?>
<?php
$title = "Add Event";
echo "<link rel='stylesheet' href='assets/css/upload.css'>";
include('../layouts/navbar.php');
?>

<head>
    <link rel="stylesheet" href="../assets/css/upload.css" />
</head>

<body>
    <h1 class="text-center text-3xl p-5 text-white font-bold mb-3" style="background-color: #607bda;">Create New Event</h1>
    <form method="POST" enctype="multipart/form-data" class="uploadForm" id="uploadForm">
        <input type="text" name="title" id="" placeholder="Title" class="textInput" required>
        <input type="datetime-local" name="date" id="" placeholder="Date" class="textInput" required>
        <textarea class="textInput" placeholder="Description" name="desc" required></textarea>
        <label for="video-upload" class="upload-label" id="upload-label">Select Cover Image</label>
        <input id="video-upload" type="file" name="event" accept="image/*" style="visibility: hidden;" required />
        <button type="submit" id="submit" name="submit">Create Event</button>
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