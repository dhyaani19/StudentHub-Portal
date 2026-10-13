<?php
require_once "db.php";

$name = "Dhyani";
$email = "25dce032@charusat.edu.in";
$user_id = "25DCE032";
$password = "Dhyani1234";
$semester = 3;

$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$check = $conn->prepare(
    "SELECT student_id FROM students WHERE user_id = ?"
);
$check->bind_param("s", $user_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {

    $stmt = $conn->prepare(
        "UPDATE students
         SET password = ?, role = 'student'
         WHERE user_id = ?"
    );

    $stmt->bind_param("ss", $hashed_password, $user_id);

} else {

    $stmt = $conn->prepare(
        "INSERT INTO students
         (name, email, user_id, password, semester, role)
         VALUES (?, ?, ?, ?, ?, 'student')"
    );

    $stmt->bind_param(
        "ssssi",
        $name,
        $email,
        $user_id,
        $hashed_password,
        $semester
    );
}

if ($stmt->execute()) {
    echo "Test account is ready!<br>";
    echo "Enrollment Number: 25DCE032<br>";
    echo "Password: Dhyani1234<br>";
    echo "Password hash stored successfully.";
} else {
    echo "Database error: " . $stmt->error;
}
?>
