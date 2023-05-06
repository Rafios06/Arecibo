<?php

// include
include_once "dbconnect.php";
include_once "captcha_check.php";
include_once "config.php";

session_start();

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please fill both the username and password fields!');
}

if (isset($_POST['h-captcha-response']) || empty($captcha_api_secret_key) || empty($captcha_api_public_key)) {
    if (checkCaptcha($_POST['h-captcha-response']) || empty($captcha_api_secret_key) || empty($captcha_api_public_key)) {
        if ($stmt = $con->prepare('SELECT id, password, account_status FROM accounts WHERE username = ?')) {
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $password, $account_status);
                $stmt->fetch();
                if (password_verify($_POST['password'], $password)) {
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['id'] = $id;
                    $_SESSION['account_status'] = $account_status;
                    header('Location: activities.php'); // Redirection
                } else {
                    // Incorrect password
                    echo 'Incorrect username and/or password!';
                    header('Location: signin.php?err=1');
                    exit;
                }
            } else {
                // Incorrect username
                echo 'Incorrect username and/or password!';
                header('Location: signin.php?err=1');
                exit;
            }

            $stmt->close();
        }
    } else {
        echo '<script>alert("Error captcha");window.history.back();</script>';
    }
} else {
    echo '<script>alert("Error captcha");window.history.back();</script>';
}
?>