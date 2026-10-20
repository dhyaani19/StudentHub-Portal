<?php
require_once __DIR__.'/auth.php';
if(!empty($_SESSION['user_id'])) {
header('Location: dashboard.php');
exit;
}
$error='';
$success='';
if($_SERVER['REQUEST_METHOD']==='POST') {
$name=trim($_POST['name']??'');
$enrollment=strtoupper(trim($_POST['enrollment_no']??''));
$email=trim($_POST['email']??'');
$password=$_POST['password']??'';
$confirm=$_POST['confirm_password']??'';
$semester=(int)($_POST['semester']??3);
if($name===''||$enrollment===''||$email===''||$password==='')$error='Please complete all fields.';
elseif(!preg_match('/^\d {
2
}
DCE\d {
3
}
$/',$enrollment))$error='Enrollment must look like 25DCE032.';
elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))$error='Enter a valid email address.';
elseif(strlen($password)<8)$error='Password must contain at least 8 characters.';
elseif($password!==$confirm)$error='Passwords do not match.';
elseif($semester<1||$semester>8)$error='Choose a valid semester.';
else {
$check=$conn->prepare("SELECT student_id FROM students WHERE user_id=? OR enrollment_no=? OR email=?");
$check->bind_param('sss',$enrollment,$enrollment,$email);
$check->execute();
if($check->get_result()->fetch_assoc())$error='That enrollment number or email is already registered.';
else {
$hash=password_hash($password,PASSWORD_DEFAULT);
$course='B.Tech CE';
$stmt=$conn->prepare("INSERT INTO students(enrollment_no,name,email,course,semester,user_id,password,role) VALUES(?,?,?,?,?,?,?,'student')");
$stmt->bind_param('ssssiss',$enrollment,$name,$email,$course,$semester,$enrollment,$hash);
$stmt->execute();
$success='Registration successful. You can now log in using your enrollment number and password.';
}

}

}
$pageTitle='Register';
require __DIR__.'/_header.php';
?>
<div class="narrow">
    <div class="card">
        <h2>Create Student Account
        </h2><?php if($error):?>
        <div class="message error"><?=e($error)?>
        </div><?php endif;
?><?php if($success):?>
        <div class="message"><?=e($success)?>
        </div>
        <a class="btn" href="login.php">Go to Login
        </a><?php else:?>
        <form method="post">
            <label for="name">Full Name
            </label>
            <input id="name" name="name" maxlength="100" required value="<?=e($_POST['name']??'')?>">
            <label for="enrollment_no">Enrollment Number
            </label>
            <input id="enrollment_no" name="enrollment_no" pattern="[0-9]{2}DCE[0-9]{3}" placeholder="25DCE032" required value="<?=e($_POST['enrollment_no']??'')?>">
            <label for="email">Email
            </label>
            <input id="email" name="email" type="email" required value="<?=e($_POST['email']??'')?>">
            <label for="semester">Current Semester
            </label>
            <select id="semester" name="semester"><?php for($i=1;
$i<=8;
$i++):?><option value="<?=$i?>" <?=((int)($_POST['semester']??3)===$i?'selected':'')?>>Semester <?=$i?>
            </option><?php endfor;
?>
        </select>
        <label for="password">Password (minimum 8 characters)
        </label>
        <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" required>
        <label for="confirm_password">Confirm Password
        </label>
        <input id="confirm_password" name="confirm_password" type="password" minlength="8" autocomplete="new-password" required>
        <button class="full" type="submit">Register
        </button>
    </form><?php endif;
?>
    <div class="links">
        <a href="login.php">Already registered? Login
        </a>
    </div>
</div>
</div><?php require __DIR__.'/_footer.php';
?>
