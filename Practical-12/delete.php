<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

if (!isset($_POST["event_id"]) || !ctype_digit($_POST["event_id"])) {
    header("Location: index.php?message=Invalid event ID");
    exit;
}

$id = (int) $_POST["event_id"];

$stmt = $conn->prepare("SELECT poster FROM events WHERE event_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: index.php?message=Event not found");
    exit;
}

$event = $result->fetch_assoc();

$delete = $conn->prepare("DELETE FROM events WHERE event_id = ?");
$delete->bind_param("i", $id);

if ($delete->execute() && $delete->affected_rows > 0) {
    if (!empty($event["poster"])) {
        $posterPath = __DIR__ . "/uploads/" . basename($event["poster"]);

        if (is_file($posterPath)) {
            unlink($posterPath);
        }
    }

    header("Location: index.php?message=Event deleted successfully");
    exit;
}

header("Location: index.php?message=Unable to delete event");
exit;
?>
