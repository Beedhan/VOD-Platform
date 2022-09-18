<?php
include($_SERVER['DOCUMENT_ROOT'] . "/vod/config.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/session.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vod/functions.php");

$userId = $_SESSION['user'];
if (checkadmin($con, $userId) == false) {
    header("Location:/vod/");
}
