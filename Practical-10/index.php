<?php
session_start();

if (isset($_SESSION["user_id"])) {
    if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
        header("Location: admin.php");
    } else {
        header("Location: dashboard.php");
    }
    exit();
}

$message = "";

if (isset($_GET["timeout"])) {
    $message = "Your session expired. Please log in again.";
} elseif (isset($_GET["logout"])) {
    $message = "You have logged out successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Hub | Login</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <h2>Student Hub Login</h2>

        <p style="text-align: center;">
            Welcome back! Please log in to continue.
        </p>

        <?php if ($message !== "") { ?>
            <p class="message">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php } ?>

        <form action="login.php" method="POST">

            <label for="user_id">Enrollment Number</label>
            <input
                type="text"
                id="user_id"
                name="user_id"
                placeholder="Enter your enrollment number"
                required
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
                autocomplete="current-password"
            >

            <label class="remember">
                <input type="checkbox" name="remember" value="1">
                Remember Me
            </label>

            <button type="submit">Login</button>

        </form>

        <p style="text-align: center; margin-top: 20px;">
            Student Hub · Secure Login System
        </p>
    </div>

</body>
</html>