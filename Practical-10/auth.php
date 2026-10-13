<?php
session_start();

$timeout = 900;

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION["last_activity"]) &&
    (time() - $_SESSION["last_activity"] > $timeout)) {

    $_SESSION = [];
    session_destroy();

    header("Location: index.php?timeout=1");
    exit();
}

$_SESSION["last_activity"] = time();
?>
