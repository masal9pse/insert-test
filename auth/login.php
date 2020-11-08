<?php
session_start();
ini_set('display_errors', "On");
require_once dirname(__FILE__) . '/../Classes/auth/AuthClass.php';

$loginInstance = new AuthClass();
$err_msg = "";
$post = $loginInstance->sanitize($_POST);
$loginInstance->login($err_msg);
if (isset($post['name'], $post['password'])) {
 $err_msg = '未入力の項目があります。';
}
//if (isset($_COOKIE['name'], $_COOKIE['password'])) {
// $name = $_COOKIE['name'];
// $password = $_COOKIE['password'];
//}
?>
<html>

<head>
 <title>ログイン</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<div class="container mt-5">

 <body>
  <form action="" method="post">
   <?php if ($err_msg !== null && $err_msg !== '') {
    echo $err_msg . "<br>";
   } ?>
   名前<input type="text" name="name" value="<?php print($loginInstance->empty_check($post, 'name')); ?>"><br />
   パスワード<input type="text" name="password" value="<?php print($loginInstance->empty_check($post, 'name')); ?>"><br />
   <!--<dd>

    <input id="save" type="checkbox" name="save" value="on">
    <label for="save">次回からは自動的にログインする</label>
   </dd>-->
   <button type="submit" name="login" class="btn btn-success">ログイン</button>
  </form>
  <button type="button" onclick="location.href='./signup_form.php'">新規登録画面へ</button>
  <button type="button" onclick="location.href='../index.php'">トップページへ</button>
 </body>
</div>

</html>