<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

if (!isset($_POST["student_id"]) || !ctype_digit($_POST["student_id"])) {
    header("Location: index.php?message=Invalid student ID");
    exit;
}

$id = (int) $_POST["student_id"];

$stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    header("Location: index.php?message=Student deleted successfully");
    exit;
}

header("Location: index.php?message=Student not found or could not be deleted");
exit;
?>
