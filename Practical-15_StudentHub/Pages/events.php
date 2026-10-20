<?php if(session_status()!==PHP_SESSION_ACTIVE)session_start();
$pageTitle='Events';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">College Events
</h2>
<div class="card">
    <label for="search">Search events
    </label>
    <input id="search" type="search" placeholder="Search by event, category, or venue">
    <label for="category">Category
    </label>
    <select id="category">
        <option value="all">All categories
        </option>
        <option>Technical
        </option>
        <option>Cultural
        </option>
        <option>Sports
        </option>
    </select>
</div>
<div id="events" class="grid">
    <div class="card">
        <h3>Coding Contest
        </h3>
        <p>Technical · 20 September
        </p>
        <p>Computer Lab 1
        </p>
    </div>
    <div class="card">
        <h3>Dance Competition
        </h3>
        <p>Cultural · 22 September
        </p>
        <p>Auditorium
        </p>
    </div>
    <div class="card">
        <h3>Football Tournament
        </h3>
        <p>Sports · 25 September
        </p>
        <p>Sports Ground
        </p>
    </div>
    <div class="card">
        <h3>Web Development Workshop
        </h3>
        <p>Technical · 28 September
        </p>
        <p>Computer Lab 2
        </p>
    </div>
</div>
<p class="muted">Sample event listings. Confirm dates and venues with the college.
</p>
<script src="../js/events.js">
</script><?php require __DIR__.'/_footer.php';
?>
