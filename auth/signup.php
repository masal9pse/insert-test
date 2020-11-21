<?php
ini_set('display_errors', "On");
session_start();
require_once dirname(__FILE__) . '/../Models/Auth/AuthClass.php';
$authInstance = new AuthClass;

$err = [];

$token = filter_input(INPUT_POST, 'csrf_token');
// トークンがない or 一致しない場合処理を中止
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
 exit('不正なリクエストです');
}

unset($_SESSION['csrf_token']);

if (!$name = filter_input(INPUT_POST, 'name')) {
 $err[] = "ユーザー名を入力してください<br>";
}

$password = filter_input(INPUT_POST, 'password');
if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
 $err[] = 'パスワードは英数字8文字以上100文字以内にしてください<br>';
}

$password_conf = filter_input(INPUT_POST, 'password_conf');
if ($password !== $password_conf) {
 $err[] = "確認用パスワードと異なっています<br>";
}

if (count($err) === 0) {
 $authInstance->signUp();
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
 <a href="../views/signup_form.php">戻る</a>
</body>

</html>