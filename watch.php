<?php
include("session.php");
include('config.php');

if($_GET['video']){
    $video_id = $_GET['video'];
    $sql = "SELECT * FROM video LEFT JOIN users ON video.owner_id=users.id where video.name='$video_id'";
    $result = mysqli_query($con, $sql);
    $video_detail = mysqli_fetch_assoc($result);
    // print_r($video_detail);
}else{
    header("Location:404.php");
}

$title = $video_detail['title'];
echo '<link href="https://vjs.zencdn.net/7.19.2/video-js.css" rel="stylesheet" />';
echo '<link href="assets/css/videojs.css" rel="stylesheet" />';
echo '<link href="assets/css/watch.css" rel="stylesheet" />';
include('layouts/navbar.php');
?>
<body>
<div class="watch_container">
    <video
    id="my-video"
    class="video-js"
    controls
    preload="auto"
    width="900"
    height="420"
    data-setup="{}"
  >
    <source src="<?=$video_detail['video_location'] ?>" />
    <p class="vjs-no-js">
      To view this video please enable JavaScript, and consider upgrading to a
      web browser that
      <a href="https://videojs.com/html5-video-support/" target="_blank"
        >supports HTML5 video</a
      >
    </p>
  </video>
  <h1 class="watch_title"><?= $video_detail['title']?></h1>
  <div class="views_time_container">
      <p class="watch_title">
        <?=
        $video_detail['views']
       ?> views</p>
      <p class="watch_title">
        <?php
        $date = date_create(explode(' ',$video_detail['created_at'])[0]);
       echo date_format($date,'M d,Y');
       ?></p>
  </div>
  <h2 class="watch_uploader"><?= $video_detail['username']?></h2>
</div>
    <script src="https://vjs.zencdn.net/7.19.2/video.min.js"></script>
</body>