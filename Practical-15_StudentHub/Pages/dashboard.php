<?php require_once __DIR__.'/auth.php';
require_login();
if($_SESSION['role']==='admin') {
header('Location: admin.php');
exit;
}
$stmt=$conn->prepare("SELECT enrollment_no,name,email,course,semester,created_at FROM students WHERE student_id=?");
$stmt->bind_param('i',$_SESSION['student_id']);
$stmt->execute();
$student=$stmt->get_result()->fetch_assoc();
$pageTitle='Dashboard';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">Student Dashboard
</h2>
<section class="hero">
    <h2>Welcome, <?=e($student['name']??$_SESSION['name'])?>!
    </h2>
    <p>You are securely logged in to Student Hub.
    </p>
</section>
<div class="grid">
    <div class="card">
        <h3>My Enrollment
        </h3>
        <p class="stat"><?=e($student['enrollment_no']??$_SESSION['user_id'])?>
        </p>
        <p class="muted">Enrollment number
        </p>
    </div>
    <div class="card">
        <h3>My Course
        </h3>
        <p class="stat"><?=e($student['course']??'B.Tech CE')?>
        </p>
        <p>Semester <?=e($student['semester']??3)?>
        </p>
    </div>
    <div class="card">
        <h3>Account
        </h3>
        <p><?=e($student['email']??'')?>
        </p>
        <a href="profile.php">Manage profile →
        </a>
    </div>
</div>
<div class="card">
    <h3>Quick Links
    </h3>
    <div class="links">
        <a href="syllabus.php">Syllabus
        </a>
        <a href="attendance.php">Attendance
        </a>
        <a href="timetable.php">Timetable
        </a>
        <a href="result.php">Results
        </a>
        <a href="events.php">Events
        </a>
    </div>
</div><?php require __DIR__.'/_footer.php';
?>
