<?php
if (!isset($_SESSION)) {
    // session has not been started already
    session_start();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>polls.com</title>
    <link rel='stylesheet' href="styles/index.css">
    <link rel='stylesheet' href="styles/globalStyles.css">
    <script src="scripts/globalScript.js"></script>

</head>

<?php
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
}
?>

<body class="preload">
    <?php require('header.php') ?>

    <div class="container">
        <main>
            <div class="mainTitleContainer">
                <h1 class="mainTitle">Welcome to <span>POLLKA</span> </h1>
                <h2 class="mainTitleCaption">Create, Share, and Contribute to polls!</h2>
                <div class="startContainer">
                    <a href="allPolls.php">
                        <button class="start">Click here to start your adventure</button>
                    </a>
                </div>
            </div>
        </main>


        <div class="section2Container">
            <h2>Why POLLKA?</h2>
            <div class="section2">
                <div class="section2box">Free</div>
                <div class="section2box">Easy to use</div>
                <div class="section2box">Open source</div>
            </div>
        </div>
    </div>
    <footer>

        <a href='aboutus.php'>CONTACT US</a>
        <hr>
        <a href='readme.MD'>WALKTHROUGH</a>
        <hr>
        <a href='aboutus.php'>ABOUT US</a>

    </footer>

</body>

</html>