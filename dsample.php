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

// Delete sample
if (checkIfAuthor($_GET['id'])) { // Admin or author
    $id = (int)$_GET['id'];

    unlink(getPathSample($id));
    unlink(getRelativePathSample($id));

    if ($stmt = $con->prepare('UPDATE posts SET filename_sample = ? WHERE posts . id = ?')) {
        $null_str = "";
        $stmt->bind_param('si', $null_str, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo 'error';
    }

    $stmt->close();
}

header('Location: /post.php?id=' . (int)$_GET['id']);
?>