<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
ini_set('session.use_strict_mode','1');
session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off','samesite'=>'Lax','path'=>'/']);
session_start();
}
require_once __DIR__ . '/../db.php';
$timeout=900;
if(isset($_SESSION['user_id'])){
if(isset($_SESSION['last_activity']) && time()-(int)$_SESSION['last_activity']>$timeout){
$_SESSION=[]; if(ini_get('session.use_cookies')){ $p=session_get_cookie_params();setcookie(session_name(),'',time()-42000,$p['path'],$p['domain'],$p['secure'],$p['httponly']); } session_destroy();
header('Location: login.php?timeout=1');exit;
}
$_SESSION['last_activity']=time();
} else {
// Restore a remember-me login only when the persistent token validates.
$cookie=$_COOKIE['studenthub_remember']??'';
if($cookie && preg_match('/^([a-f0-9]{24}):([a-f0-9]{64})$/',$cookie,$m)){
$selector=$m[1];$validator=$m[2];
$stmt=$conn->prepare("SELECT r.student_id,r.validator_hash,r.expires_at,s.user_id,s.name,s.role FROM remember_tokens r JOIN students s ON s.student_id=r.student_id WHERE r.selector=? LIMIT 1");
$stmt->bind_param('s',$selector);$stmt->execute();$row=$stmt->get_result()->fetch_assoc();
if($row && strtotime($row['expires_at'])>time() && hash_equals($row['validator_hash'],hash('sha256',$validator))){
session_regenerate_id(true);$_SESSION['student_id']=(int)$row['student_id'];$_SESSION['user_id']=$row['user_id'];$_SESSION['name']=$row['name'];$_SESSION['role']=$row['role'];$_SESSION['last_activity']=time();
} else {
$del=$conn->prepare("DELETE FROM remember_tokens WHERE selector=?");$del->bind_param('s',$selector);$del->execute();
setcookie('studenthub_remember','',time()-3600,'/','',!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off',true);
}
}
}
function require_login(): void { if(empty($_SESSION['user_id'])){header('Location: login.php');exit;} }
function e($value): string { return htmlspecialchars((string)$value,ENT_QUOTES,'UTF-8'); }
