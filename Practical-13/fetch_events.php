
<?php
header("Content-Type: application/json");

require "db.php";

$sql = "SELECT * FROM events ORDER BY id DESC";
$result = $conn->query($sql);

$events = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "data" => $events
    ]);
} else {
    http_response_code(500);

    echo json_encode([
        "status" => "error",
        "message" => "Failed to fetch events."
    ]);
}

$conn->close();
?>
