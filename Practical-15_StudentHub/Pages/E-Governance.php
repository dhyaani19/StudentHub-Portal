<?php if(session_status()!==PHP_SESSION_ACTIVE)session_start();
$pageTitle='E-Governance';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">E-Governance
</h2>
<div class="card">
    <h2>Student Services
    </h2>
    <table>
        <tr>
            <th>Service
            </th>
            <th>Purpose
            </th>
            <th>Action
            </th>
        </tr>
        <tr>
            <td>Fee Payment
            </td>
            <td>Review fee-related information
            </td>
            <td>Contact accounts office
            </td>
        </tr>
        <tr>
            <td>Exam Dates
            </td>
            <td>Check exam timetable announcements
            </td>
            <td>Check official portal
            </td>
        </tr>
        <tr>
            <td>Scholarships
            </td>
            <td>Explore financial assistance
            </td>
            <td>Contact student section
            </td>
        </tr>
        <tr>
            <td>Leave Application
            </td>
            <td>Request academic leave
            </td>
            <td>Follow college procedure
            </td>
        </tr>
    </table>
    <p class="muted">This demo does not process payments or submit official forms.
    </p>
</div>
<?php require __DIR__.'/_footer.php';
?>
