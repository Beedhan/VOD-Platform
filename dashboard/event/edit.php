<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/functions.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");

$userId = $_SESSION['user'];
$event_id = $_GET['id'];
$eventsql = "SELECT * FROM events where name='$event_id' and creator_id=$userId";
$event = mysqli_query($con, $eventsql);
if (mysqli_num_rows($event) > 0) {
    while ($row = mysqli_fetch_assoc($event)) {
        $event_title = $row['title'];
        $event_description = $row['description'];
        $event_name = $row['name'];
    }
} else {
    echo mysqli_error($con);
    // header('Location:/vod/404.php');
}

if (isset($_POST['submit'])) {
    if (isset($_POST['title']) && isset($_POST['desc'])) {
        $event_title = mysqli_real_escape_string($con, $_POST['title']);
        $event_description = mysqli_real_escape_string($con, $_POST['desc']);
        $session_user = $_SESSION['user'];
        if (isset($_FILES['event']['tmp_name'])) {
            $event_type = $_FILES['event']['type'];
            $image_format = explode('.', $_FILES['event']['name']);
            $image_temp = $_FILES['event']['tmp_name'];
            $event_destination = "../../images/" . $event_name . "." . $image_format[count($image_format) - 1];
            move_uploaded_file($image_temp, $event_destination);
            $stripped_destination = substr($event_destination, 6);

            $sql = "UPDATE events SET title='$event_title',description='$event_description',event_cover='$stripped_destination' where name='$event_id' and creator_id=$userId";
        } else {
            $sql = "UPDATE events SET title='$event_title',description='$event_description' where name='$event_id' and creator_id=$userId";
        }
        if (mysqli_query($con, $sql)) {
            $success = "Event edited successfully";
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
    <h1 class="text-center text-3xl p-5 text-white font-bold mb-3" style="background-color: #607bda;">Edit event</h1>
    <form method="POST" enctype="multipart/form-data" class="uploadForm" id="uploadForm">
        <input type="text" name="title" id="" placeholder="Title" class="textInput" value="<?= htmlspecialchars($event_title) ?>">
        <textarea class="textInput" placeholder="Description" name="desc"><?= htmlspecialchars($event_description) ?></textarea>
        <label for="event-upload" class="upload-label" id="upload-label">Select Cover Image</label>
        <input id="event-upload" type="file" name="event" accept="image/*" style="visibility: hidden;" />
        <button type="submit" id="submit" name="submit">Update</button>
        <?php
        if (isset($error_msg)) {
            echo "<p class='error_msg'>$error_msg</p>";
        }
        ?>
        <?php
        if (isset($success)) {
            echo "<p class='success_msg'>$success</p>";
            header("Location:/vod/dashboard/events.php");
        }
        ?>

    </form>
    <script>
        const fileSelect = document.querySelector("#event-upload");
        const uploadLabel = document.querySelector("#upload-label");
        fileSelect.addEventListener('change', (e) => {
            uploadLabel.textContent = e.target.files[0].name;
        });
    </script>
</body>