<head>
    <link rel="stylesheet" href="assets/css/nav.css">
    <link rel="stylesheet" href="assets/css/global.css">
    <?php if (isset($title)) {
        echo "<title>$title  </title>";
    } else {
        echo "<title>Title  </title>";
    } ?>

</head>

<body>
    <nav>
        <h1><a href="index.php">VOD</a></h1>
        <ul>
            <li>
                <a href="upload.php">Upload</a>
            </li>
            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
</body>