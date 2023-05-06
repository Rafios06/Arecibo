<?php
include "captcha_check.php";

function add_signal($pTitleSignal, $pFrequency, $pDate, $pTime, $pLocation, $pDescription, $pSampleFile)
{
	// includes
	include "config.php";
	include "connected.php"; // loggedin session
	include "dbconnect.php";

	if (!isset($pTitleSignal, $pFrequency, $pDate, $pTime, $pLocation)) {
		echo '<script>alert("Please complete the form!");window.history.back();</script>';
		exit('Please complete the form!');
	}
	if (empty($pTitleSignal) || empty($pFrequency) || empty($pDate) || empty($pTime) || empty($pLocation)) {
		echo '<script>alert("Please complete the form!");window.history.back();</script>';
		exit('Please complete the form');
	}

	if(empty($pDescription)){
		$pDescription = "No description.";
	}

	// trim inputs
	$pTitleSignal = trim($pTitleSignal);
	$pFrequency = trim($pFrequency);
	$pDate = trim($pDate);
	$pTime = trim($pTime);
	$pLocation = trim($pLocation);
	$pDescription = trim($pDescription);

	$pDateReception = $pDate . ' ' . $pTime;

	// Add sample file
	if (isset($pSampleFile) && !empty($pSampleFile) && $pSampleFile['size'] > 5 && $pSampleFile['size'] <= $max_sample_size && $enable_uploads){

		// Generate random filename
		$uploadname_sample = bin2hex(random_bytes(32));
		$uploadname_spectrogram = 'sptgrm_' . $uploadname_sample;

		// Generate path
		$uploadfile_sample = $uploaddir_samples . $uploadname_sample;

		move_uploaded_file($pSampleFile['tmp_name'], $uploadfile_sample);
	} else {
		$uploadname_sample = '';
		$uploadname_spectrogram = '';
	}

	// Add signal
	if ($stmt = $con->prepare('INSERT INTO posts (id_author, title, frequency, time_reception, signal_location, signal_description, filename_spectrogram, filename_sample) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
		$stmt->bind_param('isssssss', $_SESSION['id'], $pTitleSignal, $pFrequency, $pDateReception, $pLocation, $pDescription, $uploadname_spectrogram, $uploadname_sample);
		$stmt->execute();
		$stmt->close();
		header('Location: activities.php');
		exit;
	} else {
		echo 'Could not prepare statement!';
	}
	$con->close();
}

if(isset($_POST['submit'])){
	if (isset($_POST['h-captcha-response']) || !$captcha_add_signal_enabled) {
		if (checkCaptcha($_POST['h-captcha-response']) || !$captcha_add_signal_enabled) {
			add_signal($_POST['titleSignal'], $_POST['frequency'], $_POST['date'], $_POST['time'], $_POST['location'], $_POST['description'], $_FILES['samplefile']);
		} else {
			echo '<script>alert("Error captcha");window.history.back();</script>';
		}
	} else {
		echo '<script>alert("Error captcha");window.history.back();</script>';
	}
}

?>