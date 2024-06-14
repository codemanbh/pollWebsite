var isLoggedIn;
var pollId;
var isAdmin;
var isOwner;

function vote() {
    if (!isLoggedIn){
        alert("Please log in to vote");
        return;
    }
    var selectedOption;
    var options = document.forms['pollForm']['option'];
    for (var i = 0; i < options.length; i++) {
        if (options[i].checked) {
            selectedOption = options[i];
            break;
        }   
    }
    if (selectedOption) {
        var optionValue = selectedOption.value;
        // Sending AJAX request to server
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if (this.status == 200) {
                document.getElementById('actionResult').innerHTML = this.responseText;
                document.querySelector('.vote_btn').style.display = 'none';//hide vote button
            }
            else {
                alert('An error occurred while trying to vote.');
            }
        }
    xhttp.open("GET", "vote.php?qid=" + pollId + "&oid=" + optionValue);
    xhttp.send();
    }
    else {
    alert('Please select an option before voting.');
    }
}

function deactivatePoll() {
    if (!isAdmin){
        alert("You don't have permission to deactivate this poll");
        return;
    }
    // Sending AJAX request to server
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.responseText == "Poll deactivated") {
            location.reload();
        }
        else {
            alert('An error occurred while trying to deactivate this poll.');
            }
    }
    xhttp.open("GET", "action.php?pid=" + pollId + "&action=deactivate");
    xhttp.send();
}

function endPoll() {
    if (!isOwner){
        alert("You don't have permission to end this poll");
        return;
    }
    // Sending AJAX request to server
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.status == 200)
        {
            document.getElementById('actionResult').innerHTML = this.responseText;
            document.getElementById('end_btn').style.display = 'none';//hide end button
        }
        else {
            alert('An error occurred while trying to end this poll.');
            }
    }
    xhttp.open("GET", "action.php?pid=" + pollId + "&action=end");
    xhttp.send();
}

function activatePoll() {
    if (!isAdmin){
        alert("You don't have permission to activate this poll");
        return;
    }
    // Sending AJAX request to server
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.responseText == "Poll activated") {
            location.reload();
        }
        else {
            alert('An error occurred while trying to activate this poll.');
            }
    }
    xhttp.open("GET", "action.php?pid=" + pollId + "&action=activate");
    xhttp.send();
}

function reportPoll() {
    // Sending AJAX request to server
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.responseText == "Poll reported") {
            document.getElementById('actionResult').innerHTML = this.responseText;
            document.getElementById('report_btn').style.display = 'none';//hide report button
            
        }
        else {
            alert('An error occurred while trying to report this poll.');
            }
    }
    xhttp.open("GET", "action.php?pid=" + pollId + "&action=report");
    xhttp.send();
    }
