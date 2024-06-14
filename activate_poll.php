<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['activate'])) {
    try {
        require('connection.php');

        $qid = $_POST['qid'];

        $sql = "UPDATE questions SET qstatus = 'Active' WHERE qid = :qid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':qid', $qid, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect to the page after activation
        header('Location: admin.php');
        exit();
    } catch (PDOException $E) {
        echo "Error occurred!";
        die($E->getMessage());
    }
}
?>
