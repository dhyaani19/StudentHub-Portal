<?php

if (isset($_POST['login'])) {

    $userId = $_POST['userId'];
    $password = $_POST['password'];

    $file = __DIR__ . '/login_data.csv';

    $data = [$userId, $password];

    $handle = fopen($file, 'a');
    fputcsv($handle, $data);
    fclose($handle);

    echo "<p style='color:green; text-align:center;'>Login data saved successfully!</p>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
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
    <a href="profile.html">Profile</a>
    <a href="login.php">Login</a>
</nav>

<div class="container">

    <div class="card">

        <h2>Login</h2>

        <form method="POST" onsubmit="return validateLogin()">

            <label>User ID</label>
            <br>

            <input type="text" id="userId" name="userId"
                   oninput="clearError('userId', 'userError')">

            <p id="userError"></p>

            <label>Password</label>
            <br>

            <input type="password" id="password" name="password"
                   oninput="clearError('password', 'passwordError')">

            <p id="passwordError"></p>

            <button type="submit" name="login">Login</button>

        </form>

    </div>

</div>

<script src="../js/script.js"></script>

</body>

</html>

