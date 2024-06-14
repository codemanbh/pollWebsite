<?php
if (!isset($_SESSION)) {
    // session has not been started already
    session_start();
}
// Only admin is allowed to access this page
if (!isset($_SESSION['utype']) || $_SESSION['utype'] != "admin") {
    die("You are not authorized to access this page");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Funtions</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <?php require('header.php'); //header code ?>

   
    <h3 class="adminHeading">Promotion to admin</h3>
    <div class="form-container adminForm">
        <div id="result" class="result">

        </div>

        <form class="adminform" id="form1" method="GET" name="form1">
            <label for="email1" style="color:#3557a7; font-size:1.3rem;" >Enter the user's Email: </label>
            <input type="text" id="email1" name="email" style="margin-bottom: 50px;margin-top:20px;">
            <input type="button" onclick="promote()" value="Promote user to admin" class="form-btn">
        </form>
    </div>
<?php

?>

    <script>
            function promote() {
    var email = document.getElementById("email1").value;

    // Sending AJAX request to server
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.status === 200) {
            document.getElementById("result").innerHTML = this.responseText;
        } else {
            alert('An error occurred while trying to promote user.');
        }
    }
    xhttp.open("GET", "admin_action.php?email=" + email);
    xhttp.send();
}

    </script>
</body>
</html>
