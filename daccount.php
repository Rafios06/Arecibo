<?php

// includes
include "connected.php";
include "dbconnect.php";
include_once "getters.php";

if (!isset($_POST['confirmw'])) {
    header('Location: signout.php');
    exit;
}

if (empty($_POST['confirmw'])) {
    header('Location: signout.php');
    exit;
}

// Delete signal
if ($stmt = $con->prepare('DELETE FROM accounts WHERE id = ?')) {
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    header('Location: signout.php');
    exit;
    $stmt->close();
} else {
    echo 'Could not prepare statement!';
}
$con->close();

header('Location: signout.php');
