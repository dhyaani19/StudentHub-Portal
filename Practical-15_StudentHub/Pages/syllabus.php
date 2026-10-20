<?php if(session_status()!==PHP_SESSION_ACTIVE)session_start();
$pageTitle='Syllabus';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">Syllabus
</h2>
<div class="card">
    <h2>Subjects — Semester 3
    </h2>
    <ul>
        <li>Mathematics
        </li>
        <li>Data Structures and Algorithms
        </li>
        <li>Web Development
        </li>
        <li>Object-Oriented Programming with Java
        </li>
        <li>Environmental Science
        </li>
        <li>Computer Networks
        </li>
    </ul>
</div>
<div class="card">
    <h3>Detailed Syllabus Overview
    </h3>
    <table>
        <tr>
            <th>Subject
            </th>
            <th>Main Topics
            </th>
        </tr>
        <tr>
            <td>Mathematics
            </td>
            <td>Matrix algebra, differential equations
            </td>
        </tr>
        <tr>
            <td>DSA
            </td>
            <td>Arrays, linked lists, stacks, queues, trees, graphs
            </td>
        </tr>
        <tr>
            <td>Web Development
            </td>
            <td>HTML, CSS, JavaScript, PHP, database connectivity
            </td>
        </tr>
        <tr>
            <td>OOP Java
            </td>
            <td>Classes, objects, inheritance, interfaces, exceptions
            </td>
        </tr>
        <tr>
            <td>Computer Networks
            </td>
            <td>OSI model, TCP/IP, addressing, routing basics
            </td>
        </tr>
    </table>
    <p class="muted">Topics are illustrative; use your official syllabus for exam preparation.
    </p>
</div>
<?php require __DIR__.'/_footer.php';
?>
