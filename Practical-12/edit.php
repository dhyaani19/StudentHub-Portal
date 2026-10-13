<?php
require_once "db.php";

$error = "";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    header("Location: index.php?message=Invalid event ID");
    exit;
}

$id = (int) $_GET["id"];

$stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: index.php?message=Event not found");
    exit;
}

$event = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $event_name = trim($_POST["event_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $event_date = trim($_POST["event_date"] ?? "");
    $venue = trim($_POST["venue"] ?? "");
    $poster_name = $event["poster"];
    $newPoster = "";

    if ($event_name === "" || $description === "" ||
        $event_date === "" || $venue === "") {
        $error = "Please fill in all event details.";
    } else {
        $dateObject = DateTime::createFromFormat("!Y-m-d", $event_date);

        if (!$dateObject || $dateObject->format("Y-m-d") !== $event_date) {
            $error = "Please select a valid event date.";
        }
    }

    if ($error === "" && isset($_FILES["poster"]) &&
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
                    $newPoster = bin2hex(random_bytes(16))
                               . "." . $allowed[$mime];

                    if (!move_uploaded_file($tmp, $uploadDir . $newPoster)) {
                        $error = "Unable to save the new poster.";
                        $newPoster = "";
                    } else {
                        $poster_name = $newPoster;
                    }
                }
            }
        }
    }

    if ($error === "") {
        $update = $conn->prepare(
            "UPDATE events
             SET event_name = ?, description = ?, event_date = ?,
                 venue = ?, poster = ?
             WHERE event_id = ?"
        );

        $update->bind_param(
            "sssssi",
            $event_name,
            $description,
            $event_date,
            $venue,
            $poster_name,
            $id
        );

        if ($update->execute()) {
            if ($newPoster !== "" && !empty($event["poster"])) {
                $oldPath = __DIR__ . "/uploads/" . basename($event["poster"]);

                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            header("Location: index.php?message=Event updated successfully");
            exit;
        } else {
            if ($newPoster !== "") {
                $newPath = __DIR__ . "/uploads/" . $newPoster;

                if (is_file($newPath)) {
                    unlink($newPath);
                }
            }

            $error = "Unable to update the event.";
        }
    }

    $event["event_name"] = $event_name;
    $event["description"] = $description;
    $event["event_date"] = $event_date;
    $event["venue"] = $venue;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Edit Event</h1>

    <?php if ($error !== ""): ?>
        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Event Name</label>
        <input type="text" name="event_name" maxlength="150"
               value="<?php echo htmlspecialchars($event["event_name"]); ?>"
               required>

        <label>Description</label>
        <textarea name="description" required><?php
            echo htmlspecialchars($event["description"]);
        ?></textarea>

        <label>Event Date</label>
        <input type="date" name="event_date"
               value="<?php echo htmlspecialchars($event["event_date"]); ?>"
               required>

        <label>Venue</label>
        <input type="text" name="venue" maxlength="150"
               value="<?php echo htmlspecialchars($event["venue"]); ?>"
               required>

        <?php if (!empty($event["poster"])): ?>
            <p>Current poster:</p>
            <img
                src="uploads/<?php echo rawurlencode(basename($event["poster"])); ?>"
                alt="Current event poster"
                width="150"
            >
        <?php endif; ?>

        <label>Replace Poster (JPG, PNG, WebP; max 2 MB)</label>
        <input type="file" name="poster"
               accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

        <button type="submit">Update Event</button>
        <a href="index.php">Cancel</a>
    </form>
</div>

</body>
</html>
