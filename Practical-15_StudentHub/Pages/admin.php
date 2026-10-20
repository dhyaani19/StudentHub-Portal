<?php require_once __DIR__.'/auth.php';
require_login();
if(($_SESSION['role']??'')!=='admin') {
header('Location: dashboard.php');
exit;
}
$result=$conn->query("SELECT enrollment_no,name,email,course,semester,created_at FROM students ORDER BY created_at DESC");
$pageTitle='Admin';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">Administrator Dashboard
</h2>
<div class="card">
    <h3>Welcome, <?=e($_SESSION['name'])?>
    </h3>
    <p>Admin access is enabled. Student list is shown below.
    </p>
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>Enrollment
                    </th>
                    <th>Name
                    </th>
                    <th>Email
                    </th>
                    <th>Course
                    </th>
                    <th>Semester
                    </th>
                </tr>
            </thead>
            <tbody><?php while($s=$result->fetch_assoc()):?>
                <tr>
                    <td><?=e($s['enrollment_no'])?>
                    </td>
                    <td><?=e($s['name'])?>
                    </td>
                    <td><?=e($s['email'])?>
                    </td>
                    <td><?=e($s['course'])?>
                    </td>
                    <td><?=e($s['semester'])?>
                    </td>
                </tr><?php endwhile;
?>
            </tbody>
        </table>
    </div>
</div><?php require __DIR__.'/_footer.php';
?>
