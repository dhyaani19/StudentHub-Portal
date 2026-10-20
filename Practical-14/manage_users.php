
<?php
require "auth.php";
requireAdmin();
require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = (int)($_POST["user_id"] ?? 0);
    $newStatus = $_POST["status"] ?? "";

    if ($userId === (int)$_SESSION["user_id"]) {
        $message = "You cannot change your own account status.";
    } elseif (in_array($newStatus, ["active", "inactive"], true)) {
        $stmt = $conn->prepare(
            "UPDATE users SET status = ? WHERE id = ?"
        );
        $stmt->bind_param("si", $newStatus, $userId);
        $stmt->execute();

        if ($stmt->affected_rows >= 0) {
            $log = $conn->prepare(
                "INSERT INTO audit_logs (user_id, action)
                 VALUES (?, ?)"
            );

            $action = "Changed user ID " . $userId .
                      " status to " . $newStatus;

            $adminId = (int)$_SESSION["user_id"];
            $log->bind_param("is", $adminId, $action);
            $log->execute();
            $log->close();

            $message = "User status updated.";
        }

        $stmt->close();
    } else {
        $message = "Invalid status.";
    }
}

$result = $conn->query(
    "SELECT id, name, username, role, status
     FROM users ORDER BY id"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Practical 14</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="dashboard-header">
        <h1>Manage Users</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>

    <main class="dashboard-container">
        <section class="dashboard-section">
            <h2>User Management</h2>

            <?php if ($message !== ""): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($user["name"]) ?></td>
                                <td><?= htmlspecialchars($user["username"]) ?></td>
                                <td><?= htmlspecialchars($user["role"]) ?></td>
                                <td><?= htmlspecialchars($user["status"]) ?></td>
                                <td>
                                    <?php if ((int)$user["id"] !== (int)$_SESSION["user_id"]): ?>
                                        <form method="POST">
                                            <input type="hidden" name="user_id"
                                                   value="<?= (int)$user["id"] ?>">
                                            <input type="hidden" name="status"
                                                   value="<?= $user["status"] === "active" ? "inactive" : "active" ?>">
                                            <button type="submit">
                                                <?= $user["status"] === "active" ? "Deactivate" : "Activate" ?>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        Current account
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
