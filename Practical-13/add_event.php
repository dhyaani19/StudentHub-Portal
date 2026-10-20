
<?php
header("Content-Type: application/json");

require "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only POST requests are allowed."
    ]);
    exit;
}

$name = trim($_POST["event_name"] ?? "");
$date = trim($_POST["event_date"] ?? "");
$venue = trim($_POST["venue"] ?? "");

if ($name === "" || $date === "" || $venue === "") {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required."
    ]);
    exit;
}

$parsedDate = DateTime::createFromFormat("!Y-m-d", $date);

if (!$parsedDate || $parsedDate->format("Y-m-d") !== $date) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Please enter a valid event date."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO events (event_name, event_date, venue) VALUES (?, ?, ?)"
);

$stmt->bind_param("sss", $name, $date, $venue);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Event added successfully!"
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to add event."
    ]);
}

$stmt->close();
$conn->close();
?>
