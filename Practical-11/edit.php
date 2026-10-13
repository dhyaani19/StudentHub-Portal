<?php
require_once "db.php";

if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    header("Location: index.php?message=Invalid student ID");
    exit;
}

$id = (int) $_GET["id"];

$stmt = $conn->prepare("SELECT student_id, name, email, user_id, semester FROM students WHERE student_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: index.php?message=Student not found");
    exit;
}

$student = $result->fetch_assoc();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $user_id = trim($_POST["user_id"] ?? "");
    $semester = trim($_POST["semester"] ?? "");

    if ($name === "" || $email === "" || $user_id === "" || $semester === "") {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Enter a valid email address.";
    } elseif (!ctype_digit($semester) || (int)$semester < 1 || (int)$semester > 8) {
        $error = "Semester must be between 1 and 8.";
    } else {
        $check = $conn->prepare(
            "SELECT student_id FROM students
             WHERE (email = ? OR user_id = ?) AND student_id != ?"
        );
        $check->bind_param("ssi", $email, $user_id, $id);
        $check->execute();
        $duplicate = $check->get_result();

        if ($duplicate->num_rows > 0) {
            $error = "Email or enrollment number already exists.";
        } else {
            $semesterNumber = (int)$semester;

            $update = $conn->prepare(
                "UPDATE students
                 SET name = ?, email = ?, user_id = ?, semester = ?
                 WHERE student_id = ?"
            );
            $update->bind_param(
                "sssii",
                $name,
                $email,
                $user_id,
                $semesterNumber,
                $id
            );

            if ($update->execute()) {
                header("Location: index.php?message=Student updated successfully");
                exit;
            } else {
                $error = "Unable to update student.";
            }
        }
    }

    $student["name"] = $name;
    $student["email"] = $email;
    $student["user_id"] = $user_id;
    $student["semester"] = $semester;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>

        <?php if ($error !== ""): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Name</label>
            <input type="text" name="name"
                   value="<?php echo htmlspecialchars($student["name"]); ?>"
                   required>

            <label>Email</label>
            <input type="email" name="email"
                   value="<?php echo htmlspecialchars($student["email"]); ?>"
                   required>

            <label>Enrollment Number</label>
            <input type="text" name="user_id"
                   value="<?php echo htmlspecialchars($student["user_id"]); ?>"
                   required>

            <label>Semester</label>
            <input type="number" name="semester" min="1" max="8"
                   value="<?php echo htmlspecialchars((string)$student["semester"]); ?>"
                   required>

            <button type="submit">Update Student</button>
            <a href="index.php">Cancel</a>
        </form>
    </div>
</body>
</html>
