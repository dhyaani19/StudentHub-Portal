<?php if(session_status()!==PHP_SESSION_ACTIVE)session_start();
$pageTitle='Extracurricular Activities';
require __DIR__.'/_header.php';
?>
<h2 class="page-title">Extracurricular Activities
</h2>
<div class="grid">
    <div class="card">
        <h3>Sports Club
        </h3>
        <p>Cricket, football, basketball and fitness activities.
        </p>
    </div>
    <div class="card">
        <h3>Music Club
        </h3>
        <p>Singing and instrumental music.
        </p>
    </div>
    <div class="card">
        <h3>Dance Club
        </h3>
        <p>Traditional and western dance.
        </p>
    </div>
    <div class="card">
        <h3>Coding Club
        </h3>
        <p>Coding contests, peer learning and workshops.
        </p>
    </div>
    <div class="card">
        <h3>Photography Club
        </h3>
        <p>Photography and editing workshops.
        </p>
    </div>
</div>
<div class="card">
    <h3>Participation
    </h3>
    <p>Contact the relevant college club to check registration and event schedules.
    </p>
</div>
<?php require __DIR__.'/_footer.php';
?>
