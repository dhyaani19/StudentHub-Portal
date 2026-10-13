<?php
require_once "auth.php";

if ($_SESSION["role"] !== "admin") {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Student Hub Admin Dashboard</h2>

<p>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</p>

<p>You have administrator access.</p>

<a href="logout.php">Logout</a>

</body>
</html>
