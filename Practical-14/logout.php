
<?php
session_start();
require "db.php";

if (isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];

    $stmt = $conn->prepare(
        "INSERT INTO audit_logs (user_id, action) VALUES (?, ?)"
    );

    $action = "Logged out";
    $stmt->bind_param("is", $userId, $action);
    $stmt->execute();
    $stmt->close();
}

$_SESSION = [];
session_destroy();

header("Location: login.php");
exit;
?>
