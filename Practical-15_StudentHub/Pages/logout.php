<?php
require_once __DIR__.'/auth.php';
if(isset($_COOKIE['studenthub_remember'])){
$cookie=$_COOKIE['studenthub_remember'];
if(preg_match('/^([a-f0-9]{24}):([a-f0-9]{64})$/',$cookie,$m)){$stmt=$conn->prepare("DELETE FROM remember_tokens WHERE selector=?");$stmt->bind_param('s',$m[1]);$stmt->execute();}
setcookie('studenthub_remember','',['expires'=>time()-3600,'path'=>'/','secure'=>!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off','httponly'=>true,'samesite'=>'Lax']);
}
$_SESSION=[];if(ini_get('session.use_cookies')){$p=session_get_cookie_params();setcookie(session_name(),'',time()-42000,$p['path'],$p['domain'],$p['secure'],$p['httponly']);}session_destroy();header('Location: ../index.php?logout=1');exit;
