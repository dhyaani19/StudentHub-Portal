<?php
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_name = trim($_POST["event_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $event_date = trim($_POST["event_date"] ?? "");
    $venue = trim($_POST["venue"] ?? "");
    $poster_name = "";

    if ($event_name === "" || $description === "" ||
        $event_date === "" || $venue === "") {
        $error = "Please fill in all event details.";
    } elseif (
        !DateTime::createFromFormat("!Y-m-d", $event_date) ||
        DateTime::createFromFormat("!Y-m-d", $event_date)->format("Y-m-d") !== $event_date
    ) {
        $error = "Please select a valid event date.";
    } else {
        if (isset($_FILES["poster"]) &&
            $_FILES["poster"]["error"] !== UPLOAD_ERR_NO_FILE) {

            if ($_FILES["poster"]["error"] !== UPLOAD_ERR_OK) {
                $error = "Poster upload failed.";
            } elseif ($_FILES["poster"]["size"] > 2 * 1024 * 1024) {
                $error = "Poster size must not exceed 2 MB.";
            } else {
                $tmp = $_FILES["poster"]["tmp_name"];
                $imageInfo = getimagesize($tmp);
                $mime = $imageInfo["mime"] ?? "";

                $allowed = [
                    "image/jpeg" => "jpg",
                    "image/png" => "png",
                    "image/webp" => "webp"
                ];

                if ($imageInfo === false || !isset($allowed[$mime])) {
                    $error = "Only JPG, PNG, and WebP images are allowed.";
                } else {
                    $uploadDir = __DIR__ . "/uploads/";

                    if (!is_dir($uploadDir) &&
                        !mkdir($uploadDir, 0755, true)) {
                        $error = "Unable to create uploads folder.";
                    } else {
                        $poster_name = bin2hex(random_bytes(16))
                                     . "." . $allowed[$mime];

                        if (!move_uploaded_file(
                            $tmp,
                            $uploadDir . $poster_name
                        )) {
                            $error = "Unable to save the poster.";
                        }
                    }
                }
            }
        }

        if ($error === "") {
            $stmt = $conn->prepare(
                "INSERT INTO events
                (event_name, description, event_date, venue, poster)
                VALUES (?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "sssss",
                $event_name,
                $description,
                $event_date,
                $venue,
                $poster_name
            );

            if ($stmt->execute()) {
                header("Location: index.php?message=Event added successfully");
                exit;
            } else {
                if ($poster_name !== "" &&
                    is_file(__DIR__ . "/uploads/" . $poster_name)) {
                    unlink(__DIR__ . "/uploads/" . $poster_name);
                }

                $error = "Unable to add the event.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Add New Event</h1>

    <?php if ($error !== ""): ?>
        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Event Name</label>
        <input type="text" name="event_name" maxlength="150"
               value="<?php echo htmlspecialchars($_POST["event_name"] ?? ""); ?>"
               required>

        <label>Description</label>
        <textarea name="description" required><?php
            echo htmlspecialchars($_POST["description"] ?? "");
        ?></textarea>

        <label>Event Date</label>
        <input type="date" name="event_date"
               value="<?php echo htmlspecialchars($_POST["event_date"] ?? ""); ?>"
               required>

        <label>Venue</label>
        <input type="text" name="venue" maxlength="150"
               value="<?php echo htmlspecialchars($_POST["venue"] ?? ""); ?>"
               required>

        <label>Event Poster (JPG, PNG, WebP; max 2 MB)</label>
        <input type="file" name="poster"
               accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

        <button type="submit">Save Event</button>
        <a href="index.php">Cancel</a>
    </form>
</div>

</body>
</html>
