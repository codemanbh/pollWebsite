<?php
if (!isset($_SESSION)) {
    // session has not been started already
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View all polls</title>
    <link rel='stylesheet' href="styles/poll-styles.css">
    <link rel='stylesheet' href="styles/globalStyles.css">
    <script src="scripts/globalScript.js"></script>
</head>

<body class="preload">
    <?php require('header.php');    //header code
    ?>
    <h2 class="available">Available polls</h2>

    <div class="container">
        <?php
        try {
            require('connection.php');
            date_default_timezone_set("Asia/Bahrain");
            $date = date("Y-m-d H:i:s");
            $db->exec("UPDATE questions SET qstatus='Ended' where qstatus='Active' and dueDate IS NOT NULL and dueDate<'$date'");
            //Checking if there are polls available
            if (isset($_SESSION['utype']) && $_SESSION['utype'] == "admin") { //for admin
                $sql = "SELECT * FROM questions";
            } else {  // for normal user and guest
                $sql = "SELECT * FROM questions where qstatus='Active' or qstatus='Ended'";
            }

            $result = $db->query($sql);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch()) {
                    if ($row['qstatus'] == "Active") {
                        echo "<div class='poll'>";
                    } elseif ($row['qstatus'] == "Ended") {
                        echo "<div class='poll ended'>";
                    } else {
                        echo "<div class='poll deactivated'>";
                    }
                    echo "<p class='question'>{$row['question']}</p>";
                    echo "<div class='button-container'>";

                    if (($row['qstatus'] == "Active")) { //poll is active
                        echo "<div class='button status'>Active</div>";
                        echo "<a class='button' href='Poll.php?pid={$row['qid']}'>View Poll</a>";
                    } elseif (($row['qstatus'] == "Ended")) { //poll has ended
                        echo "<div class='button status'>Ended</div>";
                        echo "<a class='button' href='Poll.php?pid={$row['qid']}'>Results</a>";
                    } else {
                        echo "<div class='button status'>Deactivated</div>";
                        echo "<a class='button' href='Poll.php?pid={$row['qid']}'>View Poll</a>";
                    }

                    echo "</div></div>";
                }
            } else {
                echo "<h2 class='no-polls'>No available polls!</h2>";
                echo "<h2 class='no-polls'>Try creating a new poll :)</h2>";
            }

            $db = null;
        } catch (PDOException $E) {
            //die ("Error occured!");
            die($E->getMessage());
        }
        ?>
</body>

</html>