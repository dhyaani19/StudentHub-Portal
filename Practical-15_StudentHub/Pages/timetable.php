<?php if(session_status()!==PHP_SESSION_ACTIVE)session_start();
$pageTitle='Timetable';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">Timetable
</h2>
<div class="card">
    <h2>Weekly Timetable
    </h2>
    <p class="muted">Sample timetable; replace with your official schedule.
    </p>
    <table>
        <tr>
            <th>Day
            </th>
            <th>Time
            </th>
            <th>Subject
            </th>
        </tr>
        <tr>
            <td>Monday
            </td>
            <td>10:00–11:00 AM
            </td>
            <td>Mathematics
            </td>
        </tr>
        <tr>
            <td>Tuesday
            </td>
            <td>10:00–11:00 AM
            </td>
            <td>DSA
            </td>
        </tr>
        <tr>
            <td>Wednesday
            </td>
            <td>10:00–11:00 AM
            </td>
            <td>Web Development
            </td>
        </tr>
        <tr>
            <td>Thursday
            </td>
            <td>10:00–11:00 AM
            </td>
            <td>Java
            </td>
        </tr>
        <tr>
            <td>Friday
            </td>
            <td>10:00–11:00 AM
            </td>
            <td>Computer Networks
            </td>
        </tr>
    </table>
</div>
<?php require __DIR__.'/_footer.php';
?>
