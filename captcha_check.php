<?php
function checkCaptcha($response)
{
    include "config.php";

    if(!isset($response) || empty($response)){
        return false;
    }

    $data = array(
        'secret' => $captcha_api_secret_key,
        'response' => $response
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $responseData = json_decode($response);
    if ($responseData->success) {
        // success
        return true;
    } else {
        // error
        return false;
    }
}
?>