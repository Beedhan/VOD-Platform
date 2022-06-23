<?php
include('head.php') 
?>

<body>
    <nav class="px-5">
        <h1><a href="/vod">VOD</a></h1>
        <ul>
            <li>
                <a href="upload.php">Upload</a>
            </li>
            <?php
            if(isset($_SESSION['user'])){
            ?>
                <li>
                    <a href="dashboard/videos.php">Dashboard</a>
                </li>
            
           <?php }?>
            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
</body>