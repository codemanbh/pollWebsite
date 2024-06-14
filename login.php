<?php
session_start();
$msg = '';

if (isset($_GET['error'])) {
    if ($_GET['error'] == 'createPollLogin') {
        $msg = "you must login to create a poll";
    }
}


if (isset($_POST['sb'])) {
    try {
        require('connection.php');

        $mail = $_POST['uemail'];
        $password = $_POST['upassword'];

        $sql = "SELECT * FROM user WHERE uemail = :mail";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row) {
            if (password_verify($password, $row['upassword'])) {
                $_SESSION['utype'] = $row['utype']; // save user type
                $_SESSION['uid'] = $row['uid']; // Set active user id
                header("location: allPolls.php");
                exit();
            } else {
                $msg =  "Invalid password or Email";
            }
        } else {
            $msg =  "Invalid email";
        }

        $db = null;
    } catch (PDOException $e) {
        die("Error:" . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel='stylesheet' href="styles/globalStyles.css">
    <script src="scripts/globalScript.js"></script>
</head>

<body>
    <?php require('header.php'); // the header code 
    ?>
    <div class="form-container">
        <form action="" method="post">
            <h3>Login</h3>
            <span style='color: red; font-weight: bold;'>
                <?= $msg ?>
            </span>
            <input type="email" name="uemail" required placeholder="Enter your email" value="<?php if (isset($_POST['sb'])) {
                                                                                                    echo $_POST['uemail'];
                                                                                                } ?>">
            <input type="password" name="upassword" required placeholder="Enter your password">
            <input type="submit" name="sb" value="Login Now" class="form-btn">
            <p>Don't have an account? <a href="register.php">Register now</a></p>
        </form>
    </div>

</body>

</html>