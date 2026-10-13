<?php
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $user_id = trim($_POST["user_id"] ?? "");
    $semester = $_POST["semester"] ?? "";

    if ($name === "" || $email === "" || $user_id === "" ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !ctype_digit($semester) ||
        (int)$semester < 1 || (int)$semester > 8) {

        $error = "Please enter valid student details.";

    } else {

        $check = $conn->prepare(
            "SELECT student_id FROM students
             WHERE email = ? OR user_id = ?"
        );

        $check->bind_param("ss", $email, $user_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $error = "Email or enrollment number already exists.";

        } else {

            $password = password_hash(
                bin2hex(random_bytes(16)),
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO students
                 (name, email, user_id, password, semester)
                 VALUES (?, ?, ?, ?, ?)"
            );

            $semester = (int)$semester;

            $stmt->bind_param(
                "ssssi",
                $name,
                $email,
                $user_id,
                $password,
                $semester
            );

            if ($stmt->execute()) {
                header("Location: index.php?message=" .
                    urlencode("Student added successfully."));
                exit();
            } else {
                $error = "Failed to add student. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <h1>Add Student</h1>

    <?php if ($error !== "") { ?>
        <p class="message"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="POST" action="add.php">

        <label for="name">Student Name</label><br>
        <input type="text" id="name" name="name"
               value="<?php echo htmlspecialchars($_POST["name"] ?? ""); ?>"
               required><br><br>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email"
               value="<?php echo htmlspecialchars($_POST["email"] ?? ""); ?>"
               required><br><br>

        <label for="user_id">Enrollment Number</label><br>
        <input type="text" id="user_id" name="user_id"
               value="<?php echo htmlspecialchars($_POST["user_id"] ?? ""); ?>"
               required><br><br>

        <label for="semester">Semester</label><br>
        <select id="semester" name="semester" required>
            <option value="">Select Semester</option>

            <?php for ($i = 1; $i <= 8; $i++) { ?>
                <option value="<?php echo $i; ?>"
                    <?php echo (($_POST["semester"] ?? "") == (string)$i)
                        ? "selected" : ""; ?>>
                    Semester <?php echo $i; ?>
                </option>
            <?php } ?>
        </select><br><br>

        <button type="submit">Save Student</button>
        <a href="index.php" class="btn secondary">Cancel</a>

    </form>

</div>

</body>
</html>
