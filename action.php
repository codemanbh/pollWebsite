<?php
if (!isset($_SESSION)) {
    // session has not been started already
    session_start();
}
if (isset($_SESSION['utype']) && $_SESSION['utype'] == "admin") {
    $admin = true;
}
(isset($_SESSION['reported']) && $_SESSION['reported'] == true) ? $reported = true : $reported = false;

try {
    require('connection.php');
    if (!isset($_GET['pid'])) {
        throw new Exception("Please specify a poll to perform the action.");
    }
    $pid = $_GET['pid'];
    $sql = "SELECT * FROM questions WHERE qid = :pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $pid);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        throw new Exception("Poll not found!");
    }
    // Deactivate the poll
    if (isset($_GET['action']) && $_GET['action'] == "deactivate" && $admin) {
        $sql = "UPDATE questions SET qstatus = 'Deactivated' WHERE qid = :pid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        echo "Poll deactivated";
    }
    // Activate the poll
    else if (isset($_GET['action']) && $_GET['action'] == "activate" && $admin) {
        $sql = "UPDATE questions SET qstatus = 'Active' WHERE qid = :pid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        echo "Poll activated";
    }
    // End the poll
    else if (isset($_GET['action']) && $_GET['action'] == "end") {
        $sql = "UPDATE questions SET qstatus = 'Ended' WHERE qid = :pid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        echo "Poll ended";
    }
    // Report the poll
    else if (isset($_GET['action']) && $_GET['action'] == "report" && !$reported) {
        $sql = "UPDATE questions SET reported = reported + 1 WHERE qid = :pid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        echo "Poll reported";
        $_SESSION['reported'] = true;
        exit();
    }
    //invalid action
    else {
        throw new Exception("Invalid action!");
    }
} catch (Exception $E) {
    echo $E->getMessage();
}
