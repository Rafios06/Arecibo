<?php
include "connected.php";
include "dbconnect.php";
include_once "getters.php";

if (!isAdmin()) {
    header('Location: activities.php');
    exit;
}

$botname = $_POST['botname'];

if (!isset($botname)) {
    header('Location: activities.php');
    exit;
}

if (empty($botname)) {
    header('Location: activities.php');
    exit;
}

if ($stmt = $con->prepare('SELECT id FROM bots WHERE username = ? UNION SELECT id FROM accounts WHERE username = ?')) {
    $stmt->bind_param('ss',$botname, $botname);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header('Location: create_bot.php?err=0');
        exit;
    } else {
        if (preg_match('/^[a-zA-Z0-9]+$/', $botname) == 0) {
            header('Location: create_bot.php?err=2');
            exit;
        }

        // Username doesnt exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO bots (username, api_key) VALUES (?, ?)')) {

            // Generate API Key
            $key = bin2hex(random_bytes(32));

            $stmt->bind_param('ss', $botname, $key);
            $stmt->execute();
            header('Location: list_bots.php');
            $stmt->close();
            exit;
        } else {
            echo 'Could not prepare statement!';
        }
    }
} else {
    echo 'Could not prepare statement!';
}
$con->close();
?>