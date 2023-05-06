<?php

// includes
include "connected.php"; // loggedin session
include "dbconnect.php";
include_once "getters.php";

if (!isset($_GET['id'])) {
    header('Location: activities.php');
    exit;
}

if (empty($_GET['id'])) {
    header('Location: activities.php');
    exit;
}

// Delete signal
if (checkIfAuthor($_GET['id'])) { // Admin or author
    $id = (int)$_GET['id'];
    unlink(getPathSample($id));
    unlink(getPathSpectrogram($id));

    if ($stmt = $con->prepare('DELETE FROM posts WHERE id = ?')) {
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();

        if (file_exists(getRelativePathSample((int)$_GET['id']))) {
            unlink(getRelativePathSample((int)$_GET['id']));
        }
    
        if (file_exists(getRelativePathSpectrogram((int)$_GET['id']))) {
            unlink(getRelativePathSpectrogram((int)$_GET['id']));
        }

        header('Location: activities.php');
        exit;
        $stmt->close();
    } else {
        echo 'Could not prepare statement!';
    }
}

$con->close();
header('Location: activities.php');
?>