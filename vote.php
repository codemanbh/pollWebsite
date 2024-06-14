<?php
if(!isset($_SESSION)){
    // session has not been started already
    session_start();
}
try{
    require('connection.php');
    $qid = $_GET['qid'];
    $oid = $_GET['oid'];

    if (!isset($_SESSION['uid'])) {
        throw new Exception("Please log in to vote.");
    }
    $uid = $_SESSION['uid'];

    // Checking if the user has already voted
    $VotedSql = "SELECT * FROM vote WHERE uid = :uid AND qid = :qid";
    $stmt = $db->prepare($VotedSql);
    $stmt->bindParam(':uid', $uid);
    $stmt->bindParam(':qid', $qid);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        throw new Exception("You have already voted on this poll.");
    }

    // Checking if the poll has ended
    $ActiveSql = "SELECT * FROM questions WHERE qid = :qid AND qstatus = 'Active'";
    $stmt = $db->prepare($ActiveSql);
    $stmt->bindParam(':qid', $qid);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        throw new Exception("Poll has ended.");
    }

    // Checking if the selected option is valid
    $ValiditySql = "SELECT * FROM options WHERE oid = :oid AND qid = :qid";
    $stmt = $db->prepare($ValiditySql);
    $stmt->bindParam(':oid', $oid);
    $stmt->bindParam(':qid', $qid);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        throw new Exception("Invalid option selected."); // Error: option is not valid
    }

    $voteSql = "INSERT INTO vote (uid, qid, oid) VALUES (:uid, :qid, :oid)";
    $voteStmt = $db->prepare($voteSql);
    $voteStmt->bindParam(':uid', $uid);
    $voteStmt->bindParam(':qid', $qid);
    $voteStmt->bindParam(':oid', $oid);
    $voteStmt->execute();

    echo "Vote recorded successfully";
}
catch(PDOException $E) {
    die ("Error occurred: " . $E->getMessage());
}
?>