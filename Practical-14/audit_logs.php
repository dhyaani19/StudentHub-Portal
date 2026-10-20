
<?php
require "auth.php";
requireAdmin();
require "db.php";

$result = $conn->query(
    "SELECT audit_logs.id, users.name, audit_logs.action,
            audit_logs.created_at
     FROM audit_logs
     LEFT JOIN users ON audit_logs.user_id = users.id
     ORDER BY audit_logs.created_at DESC
     LIMIT 100"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs | Practical 14</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="dashboard-header">
        <h1>Audit Logs</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>

    <main class="dashboard-container">
        <section class="dashboard-section">
            <h2>Recent System Activities</h2>
            <p class="subtitle">Latest recorded user actions</p>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Date and Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($log = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= (int)$log["id"] ?></td>
                                    <td><?= htmlspecialchars($log["name"] ?? "Deleted User") ?></td>
                                    <td><?= htmlspecialchars($log["action"]) ?></td>
                                    <td><?= htmlspecialchars($log["created_at"]) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No audit logs found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

</body>
</html>
