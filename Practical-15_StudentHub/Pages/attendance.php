<?php if(session_status()!==PHP_SESSION_ACTIVE)session_start();
$pageTitle='Attendance';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">Attendance
</h2>
<div class="card">
    <h2>Attendance Overview
    </h2>
    <p class="muted">Illustrative sample data — not connected to official attendance records.
    </p>
    <div class="grid">
        <div>
            <p class="muted">Overall attendance
            </p>
            <p class="stat">77.59%
            </p>
        </div>
        <div>
            <p class="muted">Subjects shown
            </p>
            <p class="stat">4
            </p>
        </div>
    </div>
</div>
<div class="card">
    <h3>Subject-wise Attendance
    </h3>
    <table>
        <tr>
            <th>Subject
            </th>
            <th>Total Classes
            </th>
            <th>Present
            </th>
            <th>Attendance
            </th>
        </tr>
        <tr>
            <td>Mathematics
            </td>
            <td>20
            </td>
            <td>15
            </td>
            <td>75%
            </td>
        </tr>
        <tr>
            <td>DSA
            </td>
            <td>15
            </td>
            <td>12
            </td>
            <td>80%
            </td>
        </tr>
        <tr>
            <td>Java
            </td>
            <td>10
            </td>
            <td>7
            </td>
            <td>70%
            </td>
        </tr>
        <tr>
            <td>Web Development
            </td>
            <td>13
            </td>
            <td>11
            </td>
            <td>84.62%
            </td>
        </tr>
    </table>
</div>
<?php require __DIR__.'/_footer.php';
?>
