<?php
include "connected.php";
include "dbconnect.php";
include_once "getters.php";
include "captcha_check.php";

// check parameter
if (!isset($_POST['id'])) {
    // Could not get the data that should have been sent.
    header('Location: activities.php');
    exit;
}

if (empty($_POST['id'])) {
    // One or more values are empty.
    header('Location: activities.php');
    exit;
}

$pTitleSignal = $_POST['titleSignal'];
$pFrequency = $_POST['frequency'];
$pDate = $_POST['date'];
$pTime = $_POST['time'];
$pLocation = $_POST['location'];
$pDescription = $_POST['description'];
$pId = (int)$_POST['id'];

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($pTitleSignal, $pFrequency, $pDate, $pTime, $pLocation)) {
    // Could not get the data that should have been sent.
    echo '<script>alert("Please complete the form!");window.history.back();</script>';
    exit('Please complete the form!');
}
// Make sure the submitted registration values are not empty.
if (empty($pTitleSignal) || empty($pFrequency) || empty($pDate) || empty($pTime) || empty($pLocation)) {
    // One or more values are empty.
    echo '<script>alert("Please complete the form!");window.history.back();</script>';
    exit('Please complete the form');
}

if (empty($pDescription)) {
    $pDescription = "No description.";
}

// trim inputs
$pTitleSignal = trim($pTitleSignal);
$pFrequency = trim($pFrequency);
$pDate = trim($pDate);
$pTime = trim($pTime);
$pLocation = trim($pLocation);
$pDescription = trim($pDescription);
$pId = trim($pId);

$pDateReception = $pDate . ' ' . $pTime;

// Edit signal
if (isset($_POST['submit'])) {
    if (isset($_POST['h-captcha-response']) || !$captcha_add_signal_enabled) {
        if (checkCaptcha($_POST['h-captcha-response']) || !$captcha_add_signal_enabled) {
            if (checkIfAuthor($_POST['id'])) { // Admin or author
                if ($stmt = $con->prepare('UPDATE posts SET title = ?, frequency = ?, time_reception = ?, signal_location = ?, signal_description = ? WHERE id = ?')) {
                    $stmt->bind_param('sssssi', $pTitleSignal, $pFrequency, $pDateReception, $pLocation, $pDescription, $pId);
                    $stmt->execute();
                    header('Location: activities.php');
                    exit;
                    $stmt->close();
                } else {
                    echo 'Could not prepare statement!';
                }
                $con->close();
            }
        } else {
            echo '<script>alert("Error captcha");window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Error captcha");window.history.back();</script>';
    }
}
