<?php
include "connected.php";
include "setters.php";

resetApiKey($_SESSION['id']);
header('Location: settings.php');
?>