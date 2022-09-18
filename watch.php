<?php
include("session.php");
include('config.php');

if ($_GET['video']) {
  $video_id = $_GET['video'];
  $session_user = $_SESSION['user'];
  $increaseViewQuery = "UPDATE video set views=views+1 where video.name='$video_id'";
  $addViews = mysqli_query($con, $increaseViewQuery);
  $sql = "SELECT * FROM video LEFT JOIN users ON video.owner_id=users.id where video.name='$video_id'";
  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) == 0) {
    header("Location:404.php");
  }
  $video_detail = mysqli_fetch_assoc($result);
  $suggestionsQuery = "SELECT * FROM video LEFT JOIN users ON video.owner_id=users.id  limit 10";
  $suggestions = mysqli_query($con, $suggestionsQuery);


  $fetch_times = "SELECT * FROM notes where owner_id='$session_user' AND video_id='$video_id'";
  $time_marks = mysqli_query($con, $fetch_times);

  $owner_id = $video_detail['owner_id'];
  $sql = "SELECT profile FROM users where id='$owner_id'";
  $result = mysqli_query($con, $sql);
  $owner_detail = mysqli_fetch_assoc($result);
} else {
  header("Location:404.php");
}
$title = $video_detail['title'];
echo '<link href="https://vjs.zencdn.net/7.19.2/video-js.css" rel="stylesheet" />';
echo '<link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet" />';
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

  <div class="flex flex-col">
    <div class="pt-2 relative mx-auto text-gray-600 " style="margin-top: -50px;">
      <form action="./search.php" method="get">
        <input style="width:500px" class="border-2 border-gray-300 bg-white h-12 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="search" name="value" placeholder="Search">
        <a type="submit" class="absolute right-0 top-0 mt-5 mr-4">
          <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
          </svg>
        </a>
      </form>
    </div>
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
        <h1 class="watch_title font-medium text-3xl"><?= htmlspecialchars($video_detail['title']) ?></h1>
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
        <!-- Add notes -->
        <div class="p-2 border-2 my-2">
          <p class="currentNote inline-block"></p>
          <button class=" bg-red-500 px-3 py-2 my-2	block text-white text-sm rounded-md font-semibold mb-2 hover:bg-indigo-600 deleteNoteButton mr-10">Delete Note</button>
        </div>
        <hr>
        <!-- Uploader details -->
        <div class="flex items-center my-5">
          <img class="inline-block h-16 w-16 rounded-full ring-2 ring-white" src="./<?= $owner_detail['profile'] ?>" />
          <h2 class="watch_uploader font-medium text-2xl"><?= htmlspecialchars($video_detail['username']) ?></h2>
        </div>
        <p class="text-l my-3"><?= htmlspecialchars($video_detail['description']) ?></p>
        <hr>
        <!-- Add question -->
        <div class="flex flex-col">
          <input type="text" class="questionField pbg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Ask Question" />
          <button class="questionSubmit bg-indigo-400 px-3 py-2 mt-2 text-white text-sm rounded-md font-semibold mb-2 hover:bg-indigo-600">Submit</button>
        </div>
        <!-- Questions -->
        <div class="flex flex-col questions-container">

        </div>
        <!-- End of main page -->
      </div>

      <!-- Suggestion sidebar -->
      <div class="suggestion-container">
        <p class=" font-semibold text-xl mt-4">Suggestions</p>
        <?php
        while ($suggestion = mysqli_fetch_assoc($suggestions)) {
          if ($suggestion['name'] == $video_id) {
            continue;
          }
        ?>
          <a href="watch?video=<?= htmlspecialchars($suggestion['name']) ?>" class="flex my-2">
            <video src="<?= $suggestion['video_location'] ?>" width="150"></video>
            <div class="ml-3">
              <h2 class="font-semibold text-xl"><?= htmlspecialchars($suggestion['title']) ?></h2>
              <p><?= htmlspecialchars($suggestion['username']) ?></p>
              <p><?= $suggestion['views'] ?> views</p>
            </div>
          </a>
        <?php
        }
        ?>

      </div>
    </div>
  </div>
  <script src="./assets/js/jquery.min.js"></script>
  <script src="https://vjs.zencdn.net/7.19.2/video.min.js"></script>
  <script src="./assets/js/videojs-markers.min.js"></script>
  <script defer>
    const fetchFirst = (myPlayer, reset = false) => {
      console.log(myPlayer);
      const currentNote = document.querySelector('.currentNote');
      const deleteNoteBtn = document.querySelector('.deleteNoteButton');
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
              text: mark.note,
              id: mark.id
            });
            currentNote.textContent = `${marks.length} notes`
          });
          if (!reset) {
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
                deleteNoteBtn.setAttribute('data-id', marker.id);

              },
              onMarkerReached: function(marker) {
                currentNote.textContent = marker.text
                deleteNoteBtn.setAttribute('data-id', marker.id);
              },
              markers: marks
            });
          } else {
            myPlayer.markers.reset([...marks]);
          }
        });
    }
  </script>
  <script defer>
    const fetchMyQuestions = (myPlayer) => {
      const questionContainer = document.querySelector('.questions-container');
      const currentNote = document.querySelector('.currentNote');
      var url = `http://localhost/vod/api/fetchMyQuestions?video_id=${location.search.split("=")[1]}`;
      fetch(url, {
          method: 'GET',
        })
        .then(function(response) {
          console.log(response)
          return response.json();
        })
        .then(function(body) {
          console.log(body);
          body.data.map(question => {
            const newQuestion = document.createElement('div');
            newQuestion.className = 'question p-3 flex flex-col relative';
            newQuestion.innerHTML = ` 
            <div class="flex">
            <p class="font-bold mr-3">${question.questioner_name}</p>
            <p class="">${question.question}</p>
          </div>
            <div class="flex">
            <p class="font-bold mr-3">Reply:</p>
            <p class="">${question.answer?question.answer:"No reply yet"}</p>
          </div>
          `
            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = "Delete";
            deleteBtn.className = "bg-red-500 absolute right-10 p-2 rounded";
            deleteBtn.addEventListener('click', () => {
              var url = 'http://localhost/vod/api/deleteQuestion';
              var formData = new FormData();
              formData.append('question_id', question.id);
              fetch(url, {
                  method: 'POST',
                  body: formData
                })
                .then(function(response) {
                  console.log(response)
                  return response.json();
                })
                .then(function(body) {
                  newQuestion.remove();
                });
            })
            newQuestion.append(deleteBtn);
            questionContainer.prepend(newQuestion)
          });
        });
    }
  </script>
  <script defer>
    const fetchOthersQuestions = (myPlayer) => {
      const questionContainer = document.querySelector('.questions-container');
      const currentNote = document.querySelector('.currentNote');
      var url = `http://localhost/vod/api/fetchOthersQuestions?video_id=${location.search.split("=")[1]}`;
      fetch(url, {
          method: 'GET',
        })
        .then(function(response) {
          console.log(response)
          return response.json();
        })
        .then(function(body) {
          console.log(body, 'others');
          body.data.map(question => {
            const newQuestion = document.createElement('div');
            newQuestion.className = 'question p-3 flex relative';
            newQuestion.innerHTML = ` 
          <p class="font-bold mr-3">${question.questioner_name}</p>
          <div>
            <p class="font-bold">${question.question}</p>
            <p>No answer yet</p>
          </div>
          `
            questionContainer.prepend(newQuestion)
          });
        });
    }
  </script>
  <script>

  </script>
  <script>
    const myPlayer = videojs('player');
    myPlayer.play();
    const addBtn = document.querySelector('.addNoteButton');
    const noteAdd = document.querySelector('.noteSubmit');
    const noteContent = document.querySelector('.noteContent');
    const noteContainer = document.querySelector('.noteContainer');
    const questionContainer = document.querySelector('.questions-container');
    const deleteNoteBtn = document.querySelector('.deleteNoteButton');
    const questionAdd = document.querySelector('.questionSubmit');
    const questionField = document.querySelector('.questionField');
    const video_id = location.search.split("=")[1];

    fetchFirst(myPlayer);
    fetchOthersQuestions();
    fetchMyQuestions();
    noteAdd.addEventListener('click', () => {
      const content = noteContent.value;
      var url = 'http://localhost/vod/api/addnote';
      var formData = new FormData();
      formData.append('content', content);
      formData.append('time', myPlayer.currentTime());
      formData.append('video_id', video_id);

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
              text: mark.note
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
    questionAdd.addEventListener('click', () => {
      const content = questionField.value;
      if (content == "") {
        return Toastify({
          text: "Question field cannot be empty",
          className: "error",
          style: {
            background: "red",
          }
        }).showToast();
      }
      var url = 'http://localhost/vod/api/addquestion';
      var formData = new FormData();
      formData.append('question', content);
      formData.append('video_id', video_id);
      fetch(url, {
          method: 'POST',
          body: formData
        })
        .then(function(response) {
          console.log(response)
          return response.json();
        })
        .then(function(body) {
          console.log(body, 'qsn')
          const newQuestion = document.createElement('div');
          newQuestion.className = 'question p-3 flex';
          newQuestion.innerHTML = ` 
          <p class="font-bold mr-3">${body.username}</p>
          <div>
            <p class="font-bold">${content}</p>
            <p>No answer yet</p>
          </div>
          `
          questionContainer.prepend(newQuestion)
          questionField.value = "";
          Toastify({
            text: "Question Added",
            className: "info",
            style: {
              background: "linear-gradient(to right, #607bda, #89a0f3)",
            }
          }).showToast();
        });
    })

    deleteNoteBtn.addEventListener('click', (e) => {
      var url = 'http://localhost/vod/api/deletemynote';
      var formData = new FormData();
      formData.append('note_id', deleteNoteBtn.getAttribute('data-id'));
      fetch(url, {
          method: 'POST',
          body: formData
        })
        .then(function(response) {
          console.log(response)
          return response.json();
        })
        .then(function(body) {
          console.log(body, 'qsn')
          fetchFirst(myPlayer, true);
          Toastify({
            text: "Note deleted",
            className: "info",
            style: {
              background: "linear-gradient(to right, #607bda, #89a0f3)",
            }
          }).showToast();
        });
    })
  </script>
</body>
<?php
include('layouts/footer.php');
?>