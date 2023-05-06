<?php
include "dbconnect.php";
include_once "getters.php";

// Sign Up
$new_registration_account = TRUE;

// CAPTCHA
$captcha_api_secret_key = "0x8CFA469a3756fcD871e6f0B2D3a8934507fe053D"; // WARNING API_SECRET_KEY
$captcha_api_public_key = "c186cf61-be65-42a7-9f90-8f845e54a2b9"; // WARNING API_PUBLIC_KEY
$captcha_add_signal_enabled = FALSE;
$captcha_edit_signal_enabled = FALSE;

if(empty($captcha_api_secret_key) || empty($captcha_api_public_key)){
    $captcha_add_signal_enabled = FALSE;
    $captcha_edit_signal_enabled = FALSE;
}

// Upload Samples
$enable_uploads = TRUE;
$keep_sample_after_automatic_report = TRUE;
$uploaddir_path_samples = '/uploads/samples/';
$uploaddir_path_spectrograms = '/uploads/spectrograms/';
$uploaddir_samples = getcwd() . $uploaddir_path_samples;
$uploaddir_spectrograms = getcwd() . $uploaddir_path_spectrograms;
$max_sample_size = 8000000; // in bytes

$post_max_size_bytes = return_bytes(ini_get('post_max_size'));
if($max_sample_size >= $post_max_size_bytes){
    $max_sample_size = $post_max_size_bytes - 1;
}

// Companion - Automatic report
$companion_automatic_report = TRUE;
?>