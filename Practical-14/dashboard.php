
<?php
require "auth.php";
requireAdmin();
require "db.php";

$studentResult = $conn->query("SELECT COUNT(*) AS total FROM students");
$studentCount = $studentResult->fetch_assoc()["total"];

$eventResult = $conn->query("SELECT COUNT(*) AS total FROM events");
$eventCount = $eventResult->fetch_assoc()["total"];

$userResult = $conn->query("SELECT COUNT(*) AS total FROM users");
$userCount = $userResult->fetch_assoc()["total"];

$registrationResult = $conn->query(
    "SELECT registrations.id, users.name, events.event_name,
            registrations.registered_at
     FROM registrations
     JOIN users ON registrations.user_id = users.id
     JOIN events ON registrations.event_id = events.id
     ORDER BY registrations.registered_at DESC
     LIMIT 5"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Practical 14</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div>
            Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>
            |
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <main class="dashboard-container">
        <h2>Dashboard Overview</h2>
        <p class="subtitle">Here is your system summary.</p>

        <section class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?= $userCount ?></p>
            </div>

            <div class="stat-card">
                <h3>Total Students</h3>
                <p><?= $studentCount ?></p>
            </div>

            <div class="stat-card">
                <h3>Total Events</h3>
                <p><?= $eventCount ?></p>
            </div>
        </section>

        <section class="dashboard-section">
            <h2>Latest Registrations</h2>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Event</th>
                            <th>Registered At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($registrationResult->num_rows > 0): ?>
                            <?php while ($registration = $registrationResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($registration["name"]) ?></td>
                                    <td><?= htmlspecialchars($registration["event_name"]) ?></td>
                                    <td><?= htmlspecialchars($registration["registered_at"]) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No registrations found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

     

<section class="dashboard-section">
    <h2>Quick Menu</h2>

    <?php if (($_SESSION["role"] ?? "") === "admin"): ?>
        <p>Administrator Options</p>
        <ul>
            <li><a href="dashboard.php">Dashboard Overview</a></li>
            <li><a href="audit_logs.php">View Audit Logs</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
        </ul>
    <?php else: ?>
        <p>Student Options</p>
        <ul>
            <li><a href="dashboard.php">My Dashboard</a></li>
        </ul>
    <?php endif; ?>
</section>


    </main>

</body>
</html>
