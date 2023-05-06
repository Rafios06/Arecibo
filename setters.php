<?php

function resetApiKey($id_user)
{
    include "dbconnect.php";
    include "connected.php";

    // Generate API Key
    $key = bin2hex(random_bytes(32));

    if ($stmt = $con->prepare('UPDATE accounts SET api_key = ? WHERE accounts . id = ?')) {
        $id_user = (int)$id_user;
        $stmt->bind_param('si', $key, $id_user);
        $stmt->execute();
        $stmt->close();
    } else {
        echo 'error';
    }

    $stmt->close();
    return 'Please reset API Key.';
}

function resetBotApiKey($id_bot)
{
    include "dbconnect.php";
    include "connected.php";

    // Generate API Key
    $key = bin2hex(random_bytes(32));

    if ($stmt = $con->prepare('UPDATE bots SET api_key = ? WHERE bots . id = ?')) {
        $id_bot = (int)$id_bot;
        $stmt->bind_param('si', $key, $id_bot);
        $stmt->execute();
        $stmt->close();
    } else {
        echo 'error';
    }

    $stmt->close();
    return 'No API Key.';
}

function changeUsername($id_user, $new_username)
{
    include "dbconnect.php";
    include "connected.php";

    if ($stmt = $con->prepare('UPDATE accounts SET username = ? WHERE accounts . id = ?')) {
        $id_user = (int)$id_user;
        $stmt->bind_param('si', $new_username, $id_user);
        $stmt->execute();
        $stmt->close();
    } else {
        echo 'error';
    }

    $stmt->close();
}

function changePassword($id_user, $new_password)
{
    include "dbconnect.php";
    include "connected.php";

    $new_password = password_hash($new_password, PASSWORD_DEFAULT);

    if ($stmt = $con->prepare('UPDATE accounts SET password = ? WHERE accounts . id = ?')) {
        $id_user = (int)$id_user;
        $stmt->bind_param('si', $new_password, $id_user);
        $stmt->execute();
        $stmt->close();
    } else {
        echo 'error';
    }

    $stmt->close();
}
