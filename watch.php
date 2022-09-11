<?php
include("session.php");
include('config.php');

if ($_GET['video']) {
  $video_id = $_GET['video'];
  $session_user = $_SESSION['user'];
  $increaseViewQuery = "UPDATE video set views=views+1 where video.name='$video_id'";
  mysqli_query($con, $increaseViewQuery);
  $sql = "SELECT * FROM video LEFT JOIN users ON video.owner_id=users.id where video.name='$video_id'";
  $result = mysqli_query($con, $sql);
  $video_detail = mysqli_fetch_assoc($result);
  $suggestionsQuery = "SELECT * FROM video LEFT JOIN users ON video.owner_id=users.id  limit 10";
  $suggestions = mysqli_query($con, $suggestionsQuery);


  $fetch_times = "SELECT * FROM notes where owner_id='$session_user' AND video_id='$video_id'";
  $time_marks = mysqli_query($con, $fetch_times);
} else {
  header("Location:404.php");
}
$title = $video_detail['title'];
echo '<link href="https://vjs.zencdn.net/7.19.2/video-js.css" rel="stylesheet" />';
echo '<link href="./assets/css/videojs.markers.min.css" rel="stylesheet" />';
echo '<link
href="assets/css/videojs.css"
rel="stylesheet"
/>
';
echo '<link href="assets/css/watch.css" rel="stylesheet" />';

include('layouts/navbar.php');
?>
<style>
  body {
    font-family: 'Inter', sans-serif;
  }
</style>

<body>
  <div class="flex">
    <div class="watch_container">
      <video id="player" class="video-js" controls preload="auto" width="900" height="420" data-setup="{}">
        <source src="<?= $video_detail['video_location'] ?>" />
        <p class="vjs-no-js">
          To view this video please enable JavaScript, and consider upgrading to a
          web browser that
          <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>
      </video>
      <a href="#">#<?= $video_detail['category'] ?></a>
      <h1 class="watch_title font-medium text-3xl"><?= $video_detail['title'] ?></h1>
      <div class="views_time_container justify-between flex w-100 flex-row">
        <div class="flex col-gap-2">
          <p class="watch_title text-lg">
            <?=
            $video_detail['views']
            ?> views</p>
          <p class="watch_title text-lg mx-2">
            <?php
            $date = date_create(explode(' ', $video_detail['created_at'])[0]);
            echo date_format($date, 'M d,Y');
            ?></p>
        </div>
        <div class="relative">
          <button class=" bg-indigo-500 px-3 py-2 text-white text-sm rounded-md font-semibold mb-2 hover:bg-indigo-600 addNoteButton mr-10">Add Note</button>
          <div class="absolute bottom-1 left-24 bg-indigo-500 p-2 hidden noteContainer z-50">
            <textarea name="note" id="" cols="30" rows="10" placeholder="Note in current timestamp" class="noteContent"></textarea>
            <button class="noteSubmit bg-indigo-400 px-3 py-2 mt-2 text-white text-sm rounded-md font-semibold mb-2 hover:bg-indigo-600">Submit</button>
          </div>
        </div>
      </div>
      <div class="p-2 border-2 my-2">
        <p class="currentNote inline-block"></p>
        <button class=" bg-indigo-500 px-3 py-2 my-2	block text-white text-sm rounded-md font-semibold mb-2 hover:bg-indigo-600 addNoteButton mr-10">Delete Note</button>

      </div>
      <hr>
      <div class="flex items-center ">
        <img class="inline-block h-16 w-16 rounded-full ring-2 ring-white" src="assets/images/photoroom.png" />
        <h2 class="watch_uploader font-medium text-2xl"><?= $video_detail['username'] ?></h2>

      </div>
    </div>
    <div class="suggestion-container">
      <p class="text-center font-semibold text-xl mt-4">Suggestions</p>
      <?php
      while ($suggestion = mysqli_fetch_assoc($suggestions)) {
        if ($suggestion['name'] == $video_id) {
          continue;
        }
      ?>
        <a href="watch?video=<?= $suggestion['name'] ?>" class="flex my-2">
          <video src="<?= $suggestion['video_location'] ?>" width="150"></video>
          <div class="ml-3">
            <h2 class="font-semibold text-xl"><?= $suggestion['title'] ?></h2>
            <p><?= $suggestion['username'] ?></p>
            <p><?= $suggestion['views'] ?> views</p>
          </div>
        </a>
      <?php
      }
      ?>

    </div>
  </div>
  <script src="./assets/js/jquery.min.js"></script>
  <script src="https://vjs.zencdn.net/7.19.2/video.min.js"></script>
  <script src="./assets/js/videojs-markers.min.js"></script>
  <script defer>
    const fetchFirst = (myPlayer) => {
      const currentNote = document.querySelector('.currentNote');
      var url = `http://localhost/vod/api/fetchnote?video_id=${location.search.split("=")[1]}`;
      fetch(url, {
          method: 'GET',
        })
        .then(function(response) {
          console.log(response)
          return response.json();
        })
        .then(function(body) {
          console.log(body);
          const marks = [];
          body.data.map(mark => {
            marks.push({
              time: mark.timestamp,
              text: ""
            });
            currentNote.textContent = `${marks.length} notes`
          });
          myPlayer.markers({
            markerStyle: {
              'width': '7px',
              'background-color': 'floralwhite'
            },
            markerTip: {
              display: true,
              text: function(marker) {
                return "";
              },
              time: function(marker) {
                return marker.time;
              }
            },

            onMarkerClick: function(marker) {
              currentNote.textContent = marker.text
            },
            onMarkerReached: function(marker) {
              currentNote.textContent = marker.text
            },
            markers: marks
          });
        });
    }
  </script>
  <script>
    const myPlayer = videojs('player');
    const addBtn = document.querySelector('.addNoteButton');
    const noteAdd = document.querySelector('.noteSubmit');
    const noteContent = document.querySelector('.noteContent');
    const noteContainer = document.querySelector('.noteContainer');

    fetchFirst(myPlayer);
    noteAdd.addEventListener('click', () => {
      const content = noteContent.value;
      var url = 'http://localhost/vod/api/addnote';
      var formData = new FormData();
      formData.append('content', content);
      formData.append('time', myPlayer.currentTime());
      formData.append('video_id', location.search.split("=")[1]);

      fetch(url, {
          method: 'POST',
          body: formData
        })
        .then(function(response) {
          console.log(response)
          return response.json();
        })
        .then(function(body) {
          const marks = [];
          body.data.map(mark => {
            myPlayer.markers.add([{
              time: mark.timestamp,
              text: ""
            }]);
          });
          noteContainer.classList.toggle('hidden');
          console.log(body);
        });
    })
    addBtn.addEventListener('click', () => {
      noteContainer.classList.toggle('hidden');
      if (!noteContainer.classList.contains('hidden')) {
        noteContainer.firstElementChild.setAttribute('placeholder', `Add note in ${Math.round(myPlayer.currentTime())} second`)
      }
    })
  </script>
</body>