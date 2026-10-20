<?php
session_start();
require "db.php";

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $error = "Please enter your username and password.";
    } else {
        $stmt = $conn->prepare(
            "SELECT id, name, username, password, role, status
             FROM users WHERE username = ?"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (
                $user["status"] === "active" &&
                password_verify($password, $user["password"])
            ) {
                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["name"] = $user["name"];
                $_SESSION["role"] = $user["role"];

                $log = $conn->prepare(
                    "INSERT INTO audit_logs (user_id, action)
                     VALUES (?, ?)"
                );
                $action = "Logged in";
                $log->bind_param("is", $user["id"], $action);
                $log->execute();
                $log->close();

                header("Location: dashboard.php");
                exit;
            }
        }

        $error = "Invalid credentials or inactive account.";
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

    <div class="login-card">
        <h1>Welcome Back</h1>
        <p class="subtitle">Sign in to access your dashboard</p>

        <?php if ($error !== ""): ?>
            <p class="error-message">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                required
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button type="submit">Login</button>
        </form>

        <p class="login-note">Admin Dashboard · Practical 14</p>
    </div>

</body>
</html>
