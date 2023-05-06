<?php
include "config.php";
include_once "getters.php";
include "dbconnect.php";

$pAPI_KEY = $_POST['apiKey'];
$pPostID = (int)$_POST['id'];
$pReport = $_POST['report'];
$pFile = $_FILES['file'];

if (!$companion_automatic_report) {
    echo json_encode(array('error' => -2)); // companion_automatic_report FALSE
    exit();
}

// param POST api_key
if (!isset($pAPI_KEY)) {
    echo json_encode(array('error' => -1)); // Wrong bots API_KEY
    exit();
}

if (empty($pAPI_KEY)) {
    echo json_encode(array('error' => -1)); // Wrong bots API_KEY
    exit();
}

if (!checkBotApiKey($pAPI_KEY)) {
    echo json_encode(array('error' => -1)); // Wrong bots API_KEY
    exit;
}

// Mode Get Sample
if ($pFile['size'] < 5) {
    $postid = getPostIDWithoutAutoReport();

    if ((int)$postid === -1) {
        echo json_encode(array('error' => -6)); // No sample
    } else {
        echo json_encode(array('path' => getRelativePathSample($postid), 'id' => $postid));
    }
} else { // Mode Send Report
    if (empty($pFile)) {
        echo json_encode(array('error' => -5)); // Bad request POST
        exit;
    }
    if (empty($pReport)) {
        echo json_encode(array('error' => -5)); // Bad request POST
        exit;
    }
    if (empty($pPostID)) {
        echo json_encode(array('error' => -5)); // Bad request POST
        exit;
    }

    $uploadfile_spectrogram = getPathSpectrogram($pPostID);
    if (move_uploaded_file($pFile['tmp_name'], $uploadfile_spectrogram)) {
        // Generate report text
        if ($stmt = $con->prepare('UPDATE posts SET report_result = ? WHERE posts . id = ?')) {
            $stmt->bind_param('si', htmlentities($pReport, ENT_QUOTES, 'UTF-8'), $pPostID);
            $stmt->execute();
            $stmt->close();
        } else {
            echo json_encode(array('error' => -4)); // SQL error
            exit;
        }
        $stmt->close();
        echo json_encode(array('error' => 0)); // Success

        if (!$keep_sample_after_automatic_report) {
            unlink(getPathSample($pPostID));
            unlink(getRelativePathSample($pPostID));

            if ($stmt = $con->prepare('UPDATE posts SET filename_sample = ? WHERE posts . id = ?')) {
                $null_str = "";
                $stmt->bind_param('si', $null_str, $pPostID);
                $stmt->execute();
                $stmt->close();
            } else {
                echo 'error';
            }

            $stmt->close();
        }
    }
}
