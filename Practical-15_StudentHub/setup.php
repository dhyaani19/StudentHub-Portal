<?php
require_once __DIR__ . '/db.php';
$conn->query("CREATE TABLE IF NOT EXISTS students (
student_id INT AUTO_INCREMENT PRIMARY KEY,
enrollment_no VARCHAR(20) NOT NULL UNIQUE,
name VARCHAR(100) NOT NULL,
email VARCHAR(190) NOT NULL UNIQUE,
course VARCHAR(100) NOT NULL DEFAULT 'B.Tech CE',
semester TINYINT UNSIGNED NOT NULL DEFAULT 3,
user_id VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
role ENUM('student','admin') NOT NULL DEFAULT 'student',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$conn->query("CREATE TABLE IF NOT EXISTS remember_tokens (
id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT NOT NULL,
selector CHAR(24) NOT NULL UNIQUE,
validator_hash CHAR(64) NOT NULL,
expires_at DATETIME NOT NULL,
INDEX(student_id),
CONSTRAINT fk_remember_student FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$enrollment='25DCE032';
$check=$conn->prepare("SELECT student_id FROM students WHERE user_id=?");
$check->bind_param("s",$enrollment);
$check->execute();
$exists=$check->get_result()->fetch_assoc();
if(!$exists) {
$name='Demo Student';
$email='demo.student@example.com';
$course='B.Tech CE';
$semester=3;
$hash=password_hash('Student@123',PASSWORD_DEFAULT);
$stmt=$conn->prepare("INSERT INTO students(enrollment_no,name,email,course,semester,user_id,password,role) VALUES(?,?,?,?,?,?,?,'student')");
$stmt->bind_param("ssssiss",$enrollment,$name,$email,$course,$semester,$enrollment,$hash);
$stmt->execute();
$seed='Demo student account created.';
}
else {
$hash=password_hash('Student@123',PASSWORD_DEFAULT);
$upd=$conn->prepare("UPDATE students SET password=?, role='student' WHERE user_id=?");
$upd->bind_param('ss',$hash,$enrollment);
$upd->execute();
$seed='Demo student account found;
demo password reset to Student@123.';
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Student Hub Setup
        </title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container narrow">
            <div class="card">
                <h2>Student Hub database setup
                </h2>
                <p class="message">Database tables are ready. <?=htmlspecialchars($seed)?>
                </p>
                <p>
                    <b>Demo login
                    </b>
                    <br>Enrollment:
                    <code>25DCE032
                    </code>
                    <br>Password:
                    <code>Student@123
                    </code>
                </p>
                <p class="error message">For local coursework only. Delete or rename setup.php after setup. Change demo credentials before using real data.
                </p>
                <a class="btn" href="pages/login.php">Go to login
                </a>
                <a class="btn" href="index.php">Home
                </a>
            </div>
        </div>
    </body>
</html>
