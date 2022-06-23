<?php
define('CSS_PATH', 'assets/css/'); //define CSS path
echo realpath(__DIR__.'/assets/css/nav.css');
?>
<head>
    <link rel="stylesheet" href="/vod/assets/css/nav.css">
    <link rel="stylesheet" href="/vod/assets/css/global.css">
    <?php
    if(!isset($_GET['video'])){
        echo "<script src='https://cdn.tailwindcss.com'></script>";
    }
    ?>
    <?php if (isset($title)) {
        echo "<title>$title  </title>";
    } else {
        echo "<title>Title  </title>";
    } ?>

</head>