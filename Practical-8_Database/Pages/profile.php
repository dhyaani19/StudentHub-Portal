<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $enrollment = $_POST['enrollment'];
    $email = $_POST['email'];

    try {

        $check = $pdo->prepare(
            "SELECT student_id FROM students WHERE enrollment_no = ?"
        );

        $check->execute([$enrollment]);

        if ($check->fetch()) {

            $sql = "UPDATE students
                    SET name = ?, email = ?, course = ?, semester = ?
                    WHERE enrollment_no = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $name,
                $email,
                'B.Tech CE',
                3,
                $enrollment
            ]);

            $message = "Profile updated successfully!";

        } else {

            $sql = "INSERT INTO students
                    (enrollment_no, name, email, course, semester)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $enrollment,
                $name,
                $email,
                'B.Tech CE',
                3
            ]);

            $message = "New profile saved successfully!";
        }

    } catch (PDOException $e) {

        $message = "Database Error: " . $e->getMessage();

    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile - Student Hub Portal</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<header>
    <h1>Student Hub Portal</h1>
</header>

<nav>
    <a href="../index.html">Home</a>
    <a href="profile.php">Profile</a>
</nav>

<div class="container">

    <h2>Student Profile</h2>

    <?php
    if ($message != "") {
        echo "<p>$message</p>";
    }
    ?>

    <form method="POST">

        <label>Name:</label>
        <input type="text" name="name" required>

        <br><br>

        <label>Enrollment No:</label>
        <input type="text" name="enrollment" required>

        <br><br>

        <label>Email:</label>
        <input type="email" name="email" required>

        <br><br>

        <button type="submit">Save Profile</button>

    </form>

</div>

</body>
</html>