<?php
session_start();
ini_set('display_errors', "On");
require_once dirname(__FILE__) . '/../Models/auth/AdminClass.php';

var_dump($_SESSION);
$admin = new AdminClass();
$post = $admin->sanitize($_POST);
//var_dump($_COOKIE);
if (isset($_COOKIE['admin_name'], $_COOKIE['admin_password'])) {
 $post['name'] = $_COOKIE['admin_name'];
 $post['password'] = $_COOKIE['admin_password'];
}

if (isset($post['admin-logout'])) {
 $admin->adminLogout();
}
?>
<html>

<head>
 <title>管理ログイン</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<div class="container mt-5">

 <body>
  <h1>管理画面</h1>
  <form action="admin.php" method="post">
   名前<input type="text" name="name" value="<?php print($admin->empty_check($post, 'name')); ?>"><br />
   パスワード<input type="text" name="password" value="<?php print($admin->empty_check($post, 'password')); ?>"><br />
   <button type="submit" name="admin" class="btn btn-success">ログイン</button>
  </form>
  <form action="" method="post">
   <input type="submit" name="admin-logout" value="ログアウト">
  </form>
  <button type="button" onclick="location.href='../views/index.php'">トップページへ</button>
 </body>
</div>

</html>