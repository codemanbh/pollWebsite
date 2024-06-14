<?php
if (!isset($_SESSION)) {
    // session has not been started already
    session_start();
}
try {
    require('connection.php');

    if (!isset($_GET['pid'])) {
        die("Error 404: Poll not Found!");
    }
    $pid = $_GET['pid'];

    $sqlPoll = "SELECT * FROM questions WHERE qid = :pid";  //Getting the poll's question
    $stmtPoll = $db->prepare($sqlPoll);
    $stmtPoll->bindParam(':pid', $pid);
    $stmtPoll->execute();

    // Checking if the poll exists in our database
    if ($stmtPoll->rowCount() == 0) {
        die("Error 404: Poll not Found!");
    }

    $poll = $stmtPoll->fetch(PDO::FETCH_ASSOC);


    //Getting the poll's options
    $sqlOptions = "SELECT * FROM options WHERE qid = :pid";
    $stmtOptions = $db->prepare($sqlOptions);
    $stmtOptions->bindParam(':pid', $pid);
    $stmtOptions->execute();


    // Getting the username of the poll's owner
    $sqlUname = "SELECT u.uname 
                FROM user u INNER JOIN questions q ON u.uid = q.uid
                WHERE q.qid = :pid";
    $stmtUname = $db->prepare($sqlUname);
    $stmtUname->bindParam(':pid', $pid);
    $stmtUname->execute();
    if ($stmtUname->rowCount() == 1) {
        $unamearray = $stmtUname->fetch();
        $uname = $unamearray[0];
    } else {
        $uname = ("Unavailable");
    }

    $sqlVote = "SELECT uid FROM vote WHERE qid = :pid"; // Getting user ids of the voters
    $stmtVote = $db->prepare($sqlVote);
    $stmtVote->bindParam(':pid', $pid);
    $stmtVote->execute();

    $voters = $stmtVote->fetchAll(PDO::FETCH_COLUMN);

    //Checking if the poll is ended
    $pollEnded = ($poll['qstatus'] == 'Ended') ? true : false;

    //Checking if the poll is deactivated
    $pollDeactivated = ($poll['qstatus'] == 'Deactivated') ? true : false;

    $reported = ($poll['reported'] > 0) ? true : false;

    // Checking if the current user is the owner of the poll
    $is_owner = (isset($_SESSION['uid']) && $_SESSION['uid'] == $poll['uid']) ? true : false;

    $voted = false;
    if (isset($_SESSION['uid']) && in_array($_SESSION['uid'], $voters)) {
        $voted = true;
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $poll['question']; ?></title>
        <link rel='stylesheet' href="styles/poll-styles.css">
        <link rel='stylesheet' href="styles/globalStyles.css">
        <script src="scripts/globalScript.js"></script>
    </head>

    <body class='preload'>
        <?php require('header.php'); // the header code 
        ?>

        <div class='container options'>
            <h2 class='question'><?php echo $poll['question']; ?></h2>



            <div class="result_section" id="result">
                <!-- Display the poll results -->

                <?php


                if ($pollEnded) {
                    include('connection.php');
                    // echo "GG";
                    $qid = $_GET['pid'];

                    $sql = "SELECT COUNT(DISTINCT vote.vid) as 'numOfVotes', options.option as 'optionTitle'
                    FROM questions
                    JOIN options ON options.qid = questions.qid
                    LEFT JOIN vote ON vote.qid = options.qid AND vote.oid = options.oid
                    WHERE questions.qid = $qid
                    GROUP BY options.oid;";

                    $res = $db->query($sql);
                    $total = 0;

                    foreach ($res as $row) {
                        $total += $row['numOfVotes'];
                    }
                    $res = $db->query($sql);



                    foreach ($res as $row) {
                        $precent = 0;
                        if ($total != 0) {
                            $precent = ($row['numOfVotes'] / $total) * 100;
                            $precent = round($precent, 1);
                        }
                        echo "
                        <div class='poll-option'>
                            <Label>{$row['optionTitle']}</Label>
                        <input type='range' disabled value='{$precent}' min='0' max='100'>
                        <span>{$precent}% - {$row['numOfVotes']} votes</span>
                         </div>
                    ";
                    }
                }

                ?>
            </div>



            <?php
            if ($stmtOptions->rowCount() > 0) {
                $hasOptions = true;
                echo "<form name='pollForm' id='pollForm'>";
                if (!$pollEnded) {
                    foreach ($stmtOptions as $option) {
                        echo "<div class='poll-option'>";
                        echo "<input type='radio' name='option' id='{$option['oid']} radio_opt' value='{$option['oid']}'>";
                        echo "<label for='{$option['oid']}'>{$option['option']}</label>";
                        echo "</div>";
                    }
                }
            } else {
                $hasOptions = false;
            }
            ?>
            </form>

            <div class="opt_btns">
                <?php


                if (!$hasOptions) {
                    echo "<h3 style='color:red;'>Poll has no available options.</h3>";
                }

                echo "<h3 id='actionResult' style='color:green;'></h3>"; //to display the result of the actions

                //Displaying Creaters name
                if ($is_owner) {
                    echo "<h3 style='color:green;'>This poll was created by you, $uname.</h3>";
                } else {
                    echo "<h3 style='color:green;'>This poll was created by: $uname</h3>";
                }

                //Displaying the vote status
                if ($voted && !$pollEnded && !$pollDeactivated) {
                    echo "<h3 style='color:green;'>You have already voted.</h3>";
                }
                //Displaying the poll status - ended
                if ($pollEnded && !$pollDeactivated) {
                    echo "<h3 style='color:red;'>Poll has ended.</h3>";
                }
                //for admin - displaying the times poll is reported
                if (($is_owner || (isset($_SESSION['utype']) && $_SESSION['utype'] == "admin")) && $reported) {
                    echo "<h3 style='color:red;'>This poll has been reported by {$poll['reported']} users.</h3>";
                }
                //Displaying the poll status - deactivated
                if ($pollDeactivated) {
                    echo "<h3 style='color:black;'>Poll has been deactivated.</h3>";
                }


                if ($hasOptions && !$voted && !$pollEnded && !$pollDeactivated) {
                    echo "<button class='opt_btn vote_btn' onclick='vote()'>Vote</button>";
                }
                if ($is_owner && !$pollEnded && !$pollDeactivated) {
                    echo "<button class='opt_btn end_btn' id='end_btn' onclick='endPoll()'>End Poll</button>";
                }
                if (isset($_SESSION['utype']) && $_SESSION['utype'] == "admin" && !$pollDeactivated) {
                    echo "<button class='opt_btn deactivate_btn' onclick='deactivatePoll()'>Deactivate Poll</button>";
                }
                if (isset($_SESSION['utype']) && $_SESSION['utype'] == "admin" && $pollDeactivated) {
                    echo "<button class='opt_btn activate_btn' onclick='activatePoll()'>Activate Poll</button>";
                }
                if (!$pollDeactivated && !(isset($_SESSION['reported']) && $_SESSION['reported'] = true)) {
                    echo "<button class='opt_btn report_btn' id='report_btn' onclick='reportPoll()'>Report Poll</button>";
                }


                ?>
            </div>





        </div>


        <script>
            isLoggedIn = <?php echo isset($_SESSION['uid']) ? 'true' : 'false'; ?>;
            isAdmin = <?php echo isset($_SESSION['utype']) && $_SESSION['utype'] == "admin" ? 'true' : 'false'; ?>;
            pollId = <?php echo $pid; ?>;
            isOwner = <?php echo $is_owner ? 'true' : 'false'; ?>;
        </script>
        <script src="scripts/poll.js"></script>


    </body>

    </html>
<?php } catch (PDOException $E) {
    die("Error occured!");
    //die ($E->getMessage());
}
?>