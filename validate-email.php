<?php
// validate-email.php

try {
    require("connection.php");

    // Check if the email parameter is set
    if (isset($_POST["email"])) {
        $email = $_POST["email"];

        // Prepare and execute a database query to check if the email exists
        $sql = "SELECT * FROM user WHERE uemail = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);

       
        $availability = ($stmt->rowCount() > 0) ? "not_available" : "available";

        
        echo $availability;
    } else {

        echo "error";
    }
} catch (PDOException $e) {
    echo "error";

}
?>
