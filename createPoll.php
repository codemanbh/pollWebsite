<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create poll</title>
    <link rel="stylesheet" href="styles/poll-styles.css">
    <link rel="stylesheet" href="styles/createPoll.css">

    <link rel='stylesheet' href="styles/globalStyles.css">
    <script src="scripts/globalScript.js"></script>
</head>

<?php
session_start();

if (!isset($_SESSION['uid'])) {
    header('location: login.php?error=createPollLogin');
}

$errorMsg = "";
try {
    require('connection.php');
    if (isset($_POST['question'])) {

        $uid = $_SESSION['uid'];
        $q = $_POST['question'];
        $dueDate = $_POST['dueDate'];
        date_default_timezone_set("Asia/Bahrain");
        $date = date("Y-m-d H:i:s");

        // validation
        $isFormValid = true;

        $patternQuestion = '/^\S{3,}/';
        $isFormValid = preg_match($patternQuestion, $q);

        // select * from vote, options where vote.qid = 5;
        if ($isFormValid) {

            foreach ($_POST['options'] as $o) {
                $patternOption = '/\S/';
                $isValidOption = preg_match($patternOption, $o);
                if (!$isValidOption) {
                    $isFormValid = false;
                    break;
                }
            }
        }


        if ($isFormValid) {
            if ($dueDate < $date)
                $sql = "INSERT INTO questions (qid, uid, question, qstatus,reported,dueDate) VALUES (null , $uid , '$q', 'Active',0,null)";
            else
                $sql = "INSERT INTO questions (qid, uid, question, qstatus,reported,dueDate) VALUES (null , $uid , '$q', 'Active',0,'$dueDate')";
            $result = $db->exec($sql);

            $qid = $db->lastInsertId();

            foreach ($_POST['options'] as $o) {
                $sql = "INSERT INTO options VALUES (null , $qid , '$o')";
                $result = $db->exec($sql);
            }
            header("location:poll.php?pid=$qid");
        } else {
            $errorMsg = "You must fill all options";
        }
    }
} catch (PDOException $E) {
    echo "Error occured!";
    die($E->getMessage());
}


?>


<body class="preload">

    <?php
    include("header.php");
    ?>
    <div class="container create">

        <h1>Create poll</h1>
        <span class="error"> <?= $errorMsg ?> </span>
        <form method="POST" onsubmit="return validateForm()">
            <label for="question">Question</label><br>
            <textarea id="question" cols="50" name="question"></textarea><br>
            <div id="optionsContainer">
                <div id="o1Container">
                    <label class="opLabel" for="o1">Option 1</label>
                    <input type="text" id="o1" name="options[]">
                    <button type="button" class='btn' onclick="deleteOption(1)">Delete</button>
                    <br>
                </div>

                <div id="o2Container">
                    <label for="o2" class="opLabel">Option 2</label>
                    <input type="text" id="o2" name="options[]" required>
                    <button type="button" class='btn' onclick="deleteOption(2)">Delete</button>
                    <br>
                </div>
                <span class="newOption"></span>
            </div>
            <label>dueDate (optional)</label><input type="datetime-local" name="dueDate"><br>
            <button type="button" class='opt_btn createp' onclick="addNewOption()">add new option +</button>
            <button class='opt_btn createp' type="submit">Submit</button>


        </form>

    </div>
    <script src="scripts/createPoll.js"></script>
</body>

</html>