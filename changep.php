<?php
include "connected.php";
include "dbconnect.php";
include_once "getters.php";
include "setters.php";

if (!isset($_POST['cpassword'], $_POST['password'])) {
    header('Location: changepass.php?i=1');
    exit('Please fill fields!');
}

if(checkPassword($_SESSION['id'], $_POST['cpassword'])){
    changePassword($_SESSION['id'], $_POST['password']);
    header('Location: changepass.php?i=0');
} else {
    header('Location: changepass.php?i=1');
    exit('Please fill fields!');
}