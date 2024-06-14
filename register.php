<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["cpassword"];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();


    if (!empty($username) && !empty($email) && !empty($password) && !empty($passwordRepeat)) {

        $usernameReg = '/^[a-zA-Z0-9_]{4,10}$/';
        $emailReg = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $passReg = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%\*\-]{8,24}$/';

        if (!preg_match($usernameReg, $username)) {
            array_push($errors, "Username must be 4-10 characters long and can only contain letters, numbers, and underscores");
        }
        if (!preg_match($emailReg, $email)) {
            array_push($errors, "Email is not valid");
        }
        if (!preg_match($passReg, $password)) {
            array_push($errors, "Password must be 8-24 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.");
        }
        if ($password !== $passwordRepeat) {
            array_push($errors, "Password does not match");
        }
    } else {
        array_push($errors, "All fields are required");
    }


    if (empty($errors)) {
        try {
            require("connection.php");

            $sql = "SELECT * FROM user WHERE uemail = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                echo "<div class='alert alert-danger'>Email already exists in the database.</div>";
            } else {
                $sql = "INSERT INTO user (uname, uemail, upassword, utype) VALUES (?, ?, ?, 'user')";
                $stmt = $db->prepare($sql);
                $stmt->execute([$username, $email, $passwordHash]);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
                $_SESSION['utype'] = 'user'; // Set user type as user
                $_SESSION['uid'] = $row['uid']; // Set active user id
                header("Location: login.php");
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register form</title>
    <link rel='stylesheet' href="styles/globalStyles.css">
    <script src="scripts/globalScript.js"></script>
    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/login.css">

</head>

<body>
    <?php require('header.php'); // the header code 
    ?>
    <div class="form-container">

        <form action="" method="post">
            <h3>Register</h3>
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="error" style="color:red;">' . $error . '</div>';
                }
            }
            ?>

            <input type="text" name="username" placeholder="Enter your username" value="<?php if (isset($_POST["submit"])) {
                                                                                            echo $_POST['username'];
                                                                                        } ?>"><br>
            <input type="text" name="email" id="email" oninput="checkEmailAvailability()" placeholder="Enter your email" value="<?php if (isset($_POST["submit"])) {
                                                                                                                                    echo $_POST['email'];
                                                                                                                                } ?>"><br>
            <input type="text" name="password" placeholder="Enter your password" value="<?php if (isset($_POST["submit"])) {
                                                                                            echo $_POST['password'];
                                                                                        } ?>"><br>
            <input type="text" name="cpassword" placeholder="Confirm your password" value="<?php if (isset($_POST["submit"])) {
                                                                                                echo $_POST['cpassword'];
                                                                                            } ?>"><br>

            <input type="submit" name="submit" value="register now" class="form-btn">
            <p>already have an account? <a href="login.php">Login now</a></p>
        </form>

    </div>

    <script>
        function checkEmailAvailability() {
            // Get the email input value
            var email = document.getElementById('email').value;

            // Perform AJAX request 
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'validate-email.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response from the server
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('availabilityMessage').innerHTML = response.message;
                }
            };
            xhr.send('email=' + email);
        }
    </script>
</body>

</html>