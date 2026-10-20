<?php if(session_status()!==PHP_SESSION_ACTIVE)session_start();
$pageTitle='Results';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">Results
</h2>
<div class="card">
    <h2>Student Result
    </h2>
    <p class="muted">Sample result data for layout demonstration only; not official academic results.
    </p>
    <p>
        <b>Name:
        </b> Demo Student
    </p>
    <p>
        <b>Enrollment No:
        </b> 25DCE032
    </p>
    <p>
        <b>Semester:
        </b> 3
    </p>
</div>
<div class="card">
    <h3>Marks
    </h3>
    <table>
        <tr>
            <th>Subject
            </th>
            <th>Marks
            </th>
            <th>Grade
            </th>
        </tr>
        <tr>
            <td>Mathematics
            </td>
            <td>88
            </td>
            <td>A
            </td>
        </tr>
        <tr>
            <td>DSA
            </td>
            <td>91
            </td>
            <td>A+
            </td>
        </tr>
        <tr>
            <td>Web Development
            </td>
            <td>84
            </td>
            <td>A
            </td>
        </tr>
        <tr>
            <td>Java
            </td>
            <td>89
            </td>
            <td>A
            </td>
        </tr>
        <tr>
            <td>Environmental Science
            </td>
            <td>93
            </td>
            <td>A+
            </td>
        </tr>
        <tr>
            <th>Total
            </th>
            <th>445 / 500
            </th>
            <th>89%
            </th>
        </tr>
    </table>
    <p>
        <b>SGPA:
        </b> 7.5 (sample)
    </p>
    <p>
        <b>Status:
        </b> Pass (sample)
    </p>
</div>
<?php require __DIR__.'/_footer.php';
?>
