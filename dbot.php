<?php
include "connected.php";
include "dbconnect.php";
include_once "getters.php";
include "setters.php";

if (!isAdmin()) {
    header('Location: activities.php');
    exit;
}

if (!empty($_GET['id'])) {
    if ($stmt = $con->prepare('DELETE FROM bots WHERE id = ?')) {
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
        $stmt->close();
    } else {
        echo 'Could not prepare statement!';
    }
    $con->close();
}

header('Location: list_bots.php');
?>