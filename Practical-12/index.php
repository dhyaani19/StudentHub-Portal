<?php
require_once "db.php";

$sql = "SELECT * FROM events ORDER BY event_id DESC";
$result = $conn->query($sql);

$message = $_GET["message"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Event Management</h1>

    <?php if ($message !== ""): ?>
        <p class="message">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <a class="button" href="add.php">Add New Event</a>

    <h2>All Events</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Description</th>
                <th>Date (DD/MM/YY)</th>
                <th>Venue</th>
                <th>Poster</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($event = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php echo (int)$event["event_id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($event["event_name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($event["description"]); ?>
                    </td>

                    <td>
                        <?php
                        echo date("d/m/y", strtotime($event["event_date"]));
                        ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($event["venue"]); ?>
                    </td>

                    <td>
                        <?php if (!empty($event["poster"])): ?>
                            <img
                                src="uploads/<?php echo rawurlencode(basename($event["poster"])); ?>"
                                alt="Event poster"
                                width="100"
                            >
                        <?php else: ?>
                            No poster
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="edit.php?id=<?php echo (int)$event["event_id"]; ?>">
                            Edit
                        </a>

                        <form
                            action="delete.php"
                            method="POST"
                            onsubmit="return confirm('Delete this event?');"
                        >
                            <input
                                type="hidden"
                                name="event_id"
                                value="<?php echo (int)$event["event_id"]; ?>"
                            >

                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan="7">No events found. Add your first event.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
