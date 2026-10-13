<?php

$conn = new mysqli("localhost", "root", "", "studenthub");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($username)) {
        $message = "Username is required.";
    } elseif (empty($email)) {
        $message = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address.";
    } elseif (empty($password)) {
        $message = "Password is required.";
    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {

        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE username = ? OR email = ?"
        );

        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $message = "Username or email already exists.";

        } else {

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users (username, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $username,
                $email,
                $hashed_password
            );

            if ($stmt->execute()) {
                $message = "Registration successful!";
            } else {
                $message = "Registration failed.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>StudentHub Registration</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<header>
    <h1>Student Hub Portal</h1>
</header>

<nav>
    <a href="../index.html">Home</a>
    <a href="syllabus.html">Syllabus</a>
    <a href="Extracurricular.html">Extracurricular</a>
    <a href="E-Governance.html">E-Governance</a>
    <a href="attendance.html">Attendance</a>
    <a href="timetable.html">Time Table</a>
    <a href="events.html">Events</a>
    <a href="result.html">Result</a>
    <a href="profile.php">Profile</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
</nav>

<div class="container">

    <div class="card">

        <h2>Student Registration</h2>

        <?php
        if ($message != "") {
            echo "<p>$message</p>";
        }
        ?>

        <form method="POST">

            <label>Username:</label>
            <input type="text" name="username" required>

            <br><br>

            <label>Email:</label>
            <input type="email" name="email" required>

            <br><br>

            <label>Password:</label>
            <input type="password"
                   name="password"
                   minlength="8"
                   required>

            <br><br>

            <label>Confirm Password:</label>
            <input type="password"
                   name="confirm_password"
                   minlength="8"
                   required>

            <br><br>

            <button type="submit">Register</button>

        </form>

    </div>

</div>

</body>
</html>

