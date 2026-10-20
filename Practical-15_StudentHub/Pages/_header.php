<?php
$pageTitle = $pageTitle ?? 'Student Hub';
$activePage = basename($_SERVER['PHP_SELF'] ?? '');
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=htmlspecialchars($pageTitle)?> | Student Hub
        </title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <header>
            <h1>Student Hub Portal
            </h1>
            <p>Your academic life, in one place
            </p>
        </header>
        <nav>
            <a href="../index.php">Home
            </a>
            <a href="syllabus.php">Syllabus
            </a>
            <a href="Extracurricular.php">Activities
            </a>
            <a href="E-Governance.php">E-Governance
            </a>
            <a href="attendance.php">Attendance
            </a>
            <a href="timetable.php">Timetable
            </a>
            <a href="events.php">Events
            </a>
            <a href="result.php">Results
            </a>
<?php if(isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Profile
            </a>
            <a href="dashboard.php">Dashboard
            </a><?php if(($_SESSION['role']??'')==='admin'): ?>
            <a href="admin.php">Admin
            </a><?php endif;
?>
            <a href="logout.php">Logout
            </a><?php else: ?>
            <a href="login.php">Login
            </a>
            <a href="register.php">Register
            </a><?php endif;
?>
        </nav>
        <main class="container">
