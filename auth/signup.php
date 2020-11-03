<?php
require('../dbconnect.php');
//var_dump($_POST);
//exit();
if (empty($_POST['name'] && $_POST['password'])) {
 exit('未入力の箇所があります');
}

if (!empty($_POST['name'] && $_POST['password'])) {
 $_SESSION['id'] = $_POST['id'];
 $_SESSION['name'] = $_POST['name'];
 $_SESSION['password'] = $_POST['password'];
 $password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
 $sql = 'INSERT into users(name, password) values(:name, :password)';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
 $stmt->bindValue(':password', $_SESSION['password'], PDO::PARAM_STR);
 $results = $stmt->execute();

 header('Location: ../list.php');
 exit();
}
?>

<body>
 <button type="button" onclick="location.href='./login_form.php'">ログインページへ</button>
 <button type="button" onclick="location.href='./signup_form.php'">新規登録画面へ</button>
</body>