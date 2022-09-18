<?php
include("session.php");
include('config.php');
$search = mysqli_real_escape_string($con, $_GET['value']);
$title = "Results for $search";
include('layouts/navbar.php');
?>

<head>
    <link rel="stylesheet" href="./assets/css/index.css" />
</head>

<body>
    <div class="flex flex-col mx-5 p-5">
        <div class="pt-2 relative mx-auto mb-10 text-gray-600 " style="margin-top: -70px;">
            <form action="./search.php" method="get">
                <input style="width:500px" class="border-2 border-gray-300 bg-white h-12 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="search" name="value" placeholder="Search">
                <a type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                    <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                        <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                </a>
            </form>
        </div>
        <?php
        $sql = "SELECT * FROM video WHERE title LIKE '%$search%' OR category LIKE '%$search%' OR description LIKE '%$search%'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($video = mysqli_fetch_assoc($result)) {
        ?>
                <a href="watch?video=<?= $video['name'] ?>" class="flex mb-5 focus:bg-slate-200 rounded">
                    <video src="<?= $video['video_location'] ?>" style="height:250px;width:400px;object-fit:cover"></video>
                    <div class="flex flex-col  align-center px-3 pt-3">
                        <h1 class="font-bold text-2xl"><?= htmlspecialchars($video['title']) ?></h1>
                        <p><?= htmlspecialchars($video['views']) ?> views</p>
                        <h1 class=""><?= htmlspecialchars($video['description']) ?></h1>
                    </div>
                </a>
        <?php
            }
        }
        ?>
    </div>
</body>