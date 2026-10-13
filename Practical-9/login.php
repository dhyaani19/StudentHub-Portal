<?php

$conn = new mysqli("localhost", "root", "", "studenthub");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($username)) {
        $message = "Username is required.";
    } elseif (empty($password)) {
        $message = "Password is required.";
    } else {

        $stmt = $conn->prepare(
            "SELECT password FROM users WHERE username = ? OR email = ?"
        );

        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $message = "Login successful!";
            } else {
                $message = "Invalid username or password.";
            }

        } else {
            $message = "Invalid username or password.";
        }
    }
}

?>

<!DOCTYPE html>

<html>

<head>
    <title>Login - Student Hub Portal</title>
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

    <h2>Login</h2>

    <?php
    if ($message != "") {
        echo "<p>$message</p>";
    }
    ?>

    <form method="POST">

        <label>Username or Email:</label>
        <input type="text" name="username" required>

        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>

        <br><br>

        <button type="submit">Login</button>

    </form>

</div>
</div>

</body>

</html>
