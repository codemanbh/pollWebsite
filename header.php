<?php
if (!isset($_SESSION)) {
    // session has not been started already
    session_start();
}
?>

<head>
    <link rel="stylesheet" href="styles/header.css">
</head>

<header>
    <a class="logo" href="index.php"><img src="img/equaliser.png" alt="LOGO">
        <h1>POLLKA</h1>
    </a>

    <nav>
        <a href="index.php">HOME</a>

        <div class="navbuttons">
            <a href="#">MENU&#9662</a>
            <div class="dropdown-box">
                <a href="allPolls.php">
                    <div class="navbutton">View polls</div>
                </a>
                <a href="createPoll.php">
                    <div class="navbutton">Create poll</div>
                </a>

                <?php
                if(isset($_SESSION['utype']) && $_SESSION['utype']=='admin'){ ?>
                <a href="admin.php">
                    <div class="navbutton">Edit users</div>
                </a>
                <?php } ?>
            </div>
        </div>
        <?php
        if (!isset($_SESSION['uid'])) {
            echo "<a href='login.php'>SIGN IN</a>";
        } else {
                echo "<a href='index.php?logout=true'>SIGN OUT</a>";
        }

        ?>
    </nav>
</header>