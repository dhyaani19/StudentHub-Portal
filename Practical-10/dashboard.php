<?php
require_once "auth.php";

if ($_SESSION["role"] !== "student") {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
 <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container dashboard">
    <h2>Student Hub Dashboard</h2>

    <p>Hello, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</p>

    <p>You are logged in as a student.</p>

    <p>Enrollment Number:
        <?php echo htmlspecialchars($_SESSION["user_id"]); ?>
    </p>

    <a href="logout.php" class="btn">Logout</a>
</div>
</body>
</html>
