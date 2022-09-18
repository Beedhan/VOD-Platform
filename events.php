<?php
$title = "Events";
include("session.php");
include('config.php');
include('layouts/navbar.php');


$session_user = $_SESSION['user'];
$fetch_events = "SELECT * FROM interested where user_id='$session_user'";
$result = mysqli_query($con, $fetch_events);
$interestedEvents = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $interestedEvents[$row['event_id']] = $row;
    }
}
?>
<div class="hero h-1/3 bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center px-5 justify-between">
    <h1 class="text-5xl text-white font-bold">Events and meetups</h1>
    <a href="./event/add.php" class="text-2xl text-white font-bold bg-purple-500 p-2 rounded">Create Event</a>
</div>
<div class="grid gap-4 grid-cols-3 grid-rows-3 px-10 py-5">
    <?php
    $sql = "SELECT * FROM events";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($event = mysqli_fetch_assoc($result)) {
    ?>
            <div class="flex h-50 flex-col mb-5 cursor-pointer	 items-center" style="width:350px;min-height:200px" onclick="toggleModal('<?= htmlspecialchars($event['name']) ?>')">
                <img class="rounded-xl" style="width:100%;height:200px;object-fit:cover" src="./<?= $event['event_cover'] ?>" alt="">
                <div class="flex mt-2 justify-between bg-white rounded-xl drop-shadow p-2" style="margin-top: -30px;width:95%">
                    <div class="w-11/12">
                        <h1 class="font-bold"><?= htmlspecialchars($event['title']) ?></h1>
                        <p><?= htmlspecialchars($event['date']) ?></p>
                    </div>
                </div>
            </div>
            <div class="absolute overflow-hidden inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 hidden z-50" id=<?= htmlspecialchars($event['name']) ?>>
                <div class="max-w-sm p-6 bg-white divide-y divide-gray-500 w-1/2">
                    <div class="flex justify-between flex-col">
                        <h3 class="text-2xl font-bold"><?= htmlspecialchars($event['title']) ?></h3>
                        <p><?= htmlspecialchars($event['date']) ?></p>
                    </div>
                    <div class="mt-5">
                        <p class="mb-4 text-lg">
                            <?= htmlspecialchars($event['description']) ?>
                        </p>
                        <div>
                            <?php

                            if (!isset($interestedEvents[$event['name']])) {
                            ?>
                                <button class="px-4 py-2 text-white rounded w-full block" style="background-color:  rgb(4 120 87) !important;" onclick="interested('<?= htmlspecialchars($event['name']) ?>')">Interested</button>
                            <?php
                            } else {
                            ?>
                                <button class="px-4 py-2 text-white rounded w-full block" style="background-color:  rgb(4 120 87) !important;" onclick="notinterested('<?= htmlspecialchars($event['name']) ?>')">Not Interested</button>
                            <?php
                            }
                            ?>
                            <button class="px-4 py-2 text-white rounded" style="background-color: rgb(244 63 94)!important;" onclick="toggleModal('<?= htmlspecialchars($event['name']) ?>')">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

</div>
<script>
    function toggleModal(id) {
        const interestedBtn = document.getElementById(id);
        window.scrollTo(0, 0);
        interestedBtn.classList.toggle('hidden');
        if (interestedBtn.classList.contains('hidden')) {
            document.getElementsByTagName("body")[0].style = "overflow:auto";
        } else {
            document.getElementsByTagName("body")[0].style = "overflow:hidden";
        }
    }

    function interested(id) {
        location.href = `/vod/event/interested?id=${id}`
    }

    function notinterested(id) {
        location.href = `/vod/event/notinterested?id=${id}`
    }
</script>