<?php
require('../dbconnect.php');
//var_dump($_POST);
//exit();
if (empty($_POST['name'] && $_POST['password'])) {
 exit('未入力の箇所があります');
}

if (!empty($_POST['name'] && $_POST['password'])) {
 $_SESSION['join'] = $_POST;
 $name = $_POST['name'];
 $password = $_POST['password'];
 $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 $sql = 'INSERT into users(name, password) values (?, ?)';
 $db = dbConnect();
 $stmt = $db->prepare($sql);
 $stmt->execute(array($name, $password));
 $user_id = $db->lastinsertid();
 $_SESSION['join'] = $user_id;

 //header('Location: ../list.php');
 echo '認証成功';
 var_dump($_SESSION);
 exit();
}
?>

<body>
 <button type="button" onclick="location.href='./login_form.php'">ログインページへ</button>
 <button type="button" onclick="location.href='./signup_form.php'">新規登録画面へ</button>
</body>