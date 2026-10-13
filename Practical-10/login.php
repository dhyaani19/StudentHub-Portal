<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

$user_id = trim($_POST["user_id"] ?? "");
$password = $_POST["password"] ?? "";

$stmt = $conn->prepare(
    "SELECT student_id, name, user_id, password, role
     FROM students
     WHERE user_id = ?"
);

$stmt->bind_param("s", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["student_id"] = $user["student_id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["last_activity"] = time();

        if (isset($_POST["remember"])) {
            $_SESSION["remember_requested"] = true;
        }

        if ($user["role"] === "admin") {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    }
}

echo "Invalid enrollment number or password.";
echo '<br><a href="index.php">Try Again</a>';
?>
