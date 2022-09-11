<?php
define('CSS_PATH', 'assets/css/'); //define CSS path
?>
<head>
    <link rel="stylesheet" href="/vod/assets/css/nav.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?php
    echo "<script src='https://cdn.tailwindcss.com'></script>";
    if(!isset($_GET['video'])){
        echo "<link rel='stylesheet' href='/vod/assets/css/global.css'>";
    }
    ?>
    <?php if (isset($title)) {
        echo "<title>$title  </title>";
    } else {
        echo "<title>Title  </title>";
    } ?>

</head>