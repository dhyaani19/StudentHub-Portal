
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

$id = filter_var($_POST["id"] ?? null, FILTER_VALIDATE_INT);
$name = trim($_POST["event_name"] ?? "");
$date = trim($_POST["event_date"] ?? "");
$venue = trim($_POST["venue"] ?? "");

if (!$id || $id < 1 || $name === "" || $date === "" || $venue === "") {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Please provide valid event details."
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
    "UPDATE events SET event_name = ?, event_date = ?, venue = ? WHERE id = ?"
);

$stmt->bind_param("sssi", $name, $date, $venue, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Event updated successfully!"
        ]);
    } else {
        $check = $conn->prepare("SELECT id FROM events WHERE id = ?");
        $check->bind_param("i", $id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "No changes were needed."
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "status" => "error",
                "message" => "Event not found."
            ]);
        }

        $check->close();
    }
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update event."
    ]);
}

$stmt->close();
$conn->close();
?>
