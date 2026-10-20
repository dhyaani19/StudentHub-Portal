<?php
require_once __DIR__.'/auth.php';
if(!empty($_SESSION['user_id'])) {
header('Location: dashboard.php');
exit;
}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
$user_id=trim($_POST['user_id']??'');
$password=$_POST['password']??'';
if($user_id===''||$password==='') {
$error='Enter your enrollment number and password.';
}
else {
$stmt=$conn->prepare("SELECT student_id,name,user_id,password,role FROM students WHERE user_id=? LIMIT 1");
$stmt->bind_param('s',$user_id);
$stmt->execute();
$user=$stmt->get_result()->fetch_assoc();
if($user && password_verify($password,$user['password'])) {
session_regenerate_id(true);
$_SESSION['student_id']=(int)$user['student_id'];
$_SESSION['user_id']=$user['user_id'];
$_SESSION['name']=$user['name'];
$_SESSION['role']=$user['role'];
$_SESSION['last_activity']=time();
if(!empty($_POST['remember'])) {
$selector=bin2hex(random_bytes(12));
$validator=bin2hex(random_bytes(32));
$hash=hash('sha256',$validator);
$expiry=date('Y-m-d H:i:s',time()+60*60*24*30);
$stmt=$conn->prepare("INSERT INTO remember_tokens(student_id,selector,validator_hash,expires_at) VALUES(?,?,?,?)");
$stmt->bind_param('isss',$_SESSION['student_id'],$selector,$hash,$expiry);
$stmt->execute();
setcookie('studenthub_remember',$selector.':'.$validator,['expires'=>time()+60*60*24*30,'path'=>'/','secure'=>!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off','httponly'=>true,'samesite'=>'Lax']);
}
header('Location: '.($user['role']==='admin'?'admin.php':'dashboard.php'));
exit;
}
else {
$error='Invalid enrollment number or password.';
}

}

}
$pageTitle='Login';
require __DIR__.'/_header.php';
?>
<div class="narrow">
    <div class="card">
        <h2>Student Login
        </h2><?php if(isset($_GET['timeout'])):?>
        <div class="message error">Your session expired. Please log in again.
        </div><?php endif;
?><?php if($error):?>
        <div class="message error"><?=e($error)?>
        </div><?php endif;
?>
        <form method="post" action="login.php">
            <label for="user_id">Enrollment Number
            </label>
            <input id="user_id" name="user_id" type="text" placeholder="e.g. 25DCE032" autocomplete="username" required>
            <label for="password">Password
            </label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            <div class="inline">
                <input id="remember" type="checkbox" name="remember" value="1">
                <label for="remember">Remember me for 30 days on this device
                </label>
            </div>
            <button class="full" type="submit">Login
            </button>
        </form>
        <p class="muted">Session timeout: 15 minutes of inactivity.
        </p>
        <div class="links">
            <a href="register.php">New student? Register
            </a>
            <a href="../index.php">Back home
            </a>
        </div>
    </div>
</div><?php require __DIR__.'/_footer.php';
?>
