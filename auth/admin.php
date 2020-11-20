<?php
session_start();
ini_set('display_errors', "On");
require_once dirname(__FILE__) . '/../Classes/auth/AdminClass.php';

$admin = new AdminClass();
$post = $admin->sanitize($_POST);

$err = [];
if (!$name = filter_input(INPUT_POST, 'name')) {
 $err[] = "ユーザー名を入力してください";
}

$password = filter_input(INPUT_POST, 'password');
if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
 $err[] = 'パスワードは英数字8文字以上100文字以内にしてください';
}

if (count($err) === 0) {
 $admin->login();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>バリデーション</title>
</head>

<body>
 <?php if (count($err) > 0) : ?>
  <?php foreach ($err as $e) : ?>
   <p><?php echo $e; ?></p>
  <?php endforeach ?>
 <?php endif; ?>
 <a href="admin_form.php">戻る</a>
</body>

</html>