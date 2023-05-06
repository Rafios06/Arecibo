<?php
include "connected.php";
include_once "getters.php";
include "setters.php";

if (!isAdmin()) {
    header('Location: activities.php');
    exit;
}

if (!empty($_GET['id'])) {
    resetBotApiKey($_GET['id']);
}

header('Location: list_bots.php');
?>
