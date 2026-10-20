<?php require_once __DIR__.'/auth.php';
require_login();
$message='';
$error='';
$stmt=$conn->prepare("SELECT name,email,enrollment_no,course,semester FROM students WHERE student_id=?");
$stmt->bind_param('i',$_SESSION['student_id']);
$stmt->execute();
$student=$stmt->get_result()->fetch_assoc();
if($_SERVER['REQUEST_METHOD']==='POST') {
$name=trim($_POST['name']??'');
$email=trim($_POST['email']??'');
$semester=(int)($_POST['semester']??3);
if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL))$error='Enter a name and valid email.';
elseif($semester<1||$semester>8)$error='Choose a valid semester.';
else {
$check=$conn->prepare("SELECT student_id FROM students WHERE email=? AND student_id<>?");
$check->bind_param('si',$email,$_SESSION['student_id']);
$check->execute();
if($check->get_result()->fetch_assoc())$error='That email is already used by another account.';
else {
$upd=$conn->prepare("UPDATE students SET name=?,email=?,semester=? WHERE student_id=?");
$upd->bind_param('ssii',$name,$email,$semester,$_SESSION['student_id']);
$upd->execute();
$_SESSION['name']=$name;
$message='Profile updated successfully.';
$student['name']=$name;
$student['email']=$email;
$student['semester']=$semester;
}

}

}
$pageTitle='My Profile';
require __DIR__.'/_header.php';
?>
<div class="narrow">
    <div class="card">
        <h2>My Profile
        </h2><?php if($message):?>
        <div class="message"><?=e($message)?>
        </div><?php endif;
?><?php if($error):?>
        <div class="message error"><?=e($error)?>
        </div><?php endif;
?>
        <form method="post">
            <label>Enrollment Number
            </label>
            <input value="<?=e($student['enrollment_no'])?>" readonly>
            <label for="name">Full Name
            </label>
            <input id="name" name="name" required maxlength="100" value="<?=e($student['name'])?>">
            <label for="email">Email
            </label>
            <input id="email" name="email" type="email" required value="<?=e($student['email'])?>">
            <label for="semester">Semester
            </label>
            <select id="semester" name="semester"><?php for($i=1;
$i<=8;
$i++):?><option value="<?=$i?>" <?=((int)$student['semester']===$i?'selected':'')?>>Semester <?=$i?>
            </option><?php endfor;
?>
        </select>
        <label>Course
        </label>
        <input value="<?=e($student['course'])?>" readonly>
        <button class="full">Save Changes
        </button>
    </form>
</div>
</div><?php require __DIR__.'/_footer.php';
?>
