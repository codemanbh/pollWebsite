<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['utype']) && $_SESSION['utype'] == "admin") {
    try {
        require('connection.php');

        if (!isset($_GET['email'])) {
            echo("Please specify an email to perform the action.");
            exit();
        }

        $email = $_GET['email'];

        $sql = "SELECT * FROM user WHERE uemail = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            echo("Email not found!");
            exit();
        }

        // Fetch the user data
        $user = $stmt->fetch();
        $uid = $user['uid'];

        if($user['utype'] == "admin"){
            echo("User is already an admin!");
            exit();
        }


        // Promote user
        $sql = "UPDATE user SET utype = 'admin' WHERE uid = :uid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        
        echo "User promoted to admin successfully.";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "You are not authorized to perform this action.";
}
?>
