<?php
// includeS
include "dbconnect.php";
include "captcha_check.php";
include "config.php";

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}
if(!$new_registration_account){
	exit;
}

if (isset($_POST['h-captcha-response']) || empty($captcha_api_secret_key) || empty($captcha_api_public_key)) {
	if (checkCaptcha($_POST['h-captcha-response']) || empty($captcha_api_secret_key) || empty($captcha_api_public_key)) {
		// We need to check if the account with that username exists.
		if ($stmt = $con->prepare('SELECT id FROM bots WHERE username = ? UNION SELECT id FROM accounts WHERE username = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
			$stmt->bind_param('ss', $_POST['username'], $_POST['username']);
			$stmt->execute();
			$stmt->store_result();
			// Store the result so we can check if the account exists in the database.
			if ($stmt->num_rows > 0) {
				// Username already exists
				//echo 'Username exists, please choose another!';
				header('Location: signup.php?err=0');
				exit;
			} else {
				if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
					//exit('Username is not valid!');
					header('Location: signup.php?err=2');
					exit;
				}

				if (strlen($_POST['password']) > 64 || strlen($_POST['password']) < 8) {
					//exit('Password must be between 8 and 64 characters long!');
					header('Location: signup.php?err=3');
					exit;
				}

				// Username doesnt exists, insert new account
				if ($stmt = $con->prepare('INSERT INTO accounts (username, password, account_status) VALUES (?, ?, ?)')) {
					// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

					// status normal user
					$status_normal_user = 0;

					$stmt->bind_param('ssi', $_POST['username'], $password, $status_normal_user); // 0 = normal user
					$stmt->execute();
					//echo 'You have successfully registered, you can now login!';
					header('Location: signin.php?err=0');
					$stmt->close();
					exit;
				} else {
					// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
					echo 'Could not prepare statement!2';
				}
			}
		} else {
			// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
			echo 'Could not prepare statement!1';
		}
		$con->close();
	} else {
		echo '<script>alert("Error captcha");window.history.back();</script>';
	}
} else {
	echo '<script>alert("Error captcha");window.history.back();</script>';
}
?>