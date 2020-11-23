<?php
session_start();
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;

$loginInstance = new AuthController();
//var_dump($_COOKIE);
//var_dump($_SESSION);
$post = $loginInstance->sanitize($_POST);
$err = [];
if (isset($_POST['login'])) {

 if (!$name = filter_input(INPUT_POST, 'name')) {
  $err[] = "ユーザー名を入力してください";
 }

 $password = filter_input(INPUT_POST, 'password');
 if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
  $err[] = 'パスワードは英数字8文字以上100文字以内にしてください';
 }

 if (count($err) === 0) {
  $loginInstance->login();
 }
}

if (isset($_COOKIE['name'], $_COOKIE['password'])) {
 $post['name'] = $_COOKIE['name'];
 $post['password'] = $_COOKIE['password'];
}
?>
<html>

<head>
 <title>ログイン</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<div class="container mt-5">

 <body>
  <form action="" method="post">
   <?php if (count($err) > 0) : ?>
    <?php foreach ($err as $e) : ?>
     <p><?php echo $e; ?></p>
    <?php endforeach ?>
   <?php endif; ?>
   名前<input type="text" name="name" value="<?php print($loginInstance->empty_check($post, 'name')); ?>"><br />
   パスワード<input type="password" name="password" value="<?php print($loginInstance->empty_check($post, 'password')); ?>"><br />
   <button type="submit" name="login" class="btn btn-success">ログイン</button>
  </form>
  <button type="button" onclick="location.href='./signup_form.php'">新規登録画面へ</button>
  <button type="button" onclick="location.href='../views/index.php'">トップページへ</button>
  <button type="button" onclick="location.href='./admin_form.php'">管理ユーザーログイン</button>
 </body>
</div>

</html>