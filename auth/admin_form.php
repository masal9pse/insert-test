<?php
session_start();
if (!empty($_SESSION['admin_name'])) {
 header("Location: ./admin_user.php");
}
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AdminController;

//var_dump($_SESSION);
$admin = new AdminController();
$post = $admin->sanitize($_POST);
//var_dump($_COOKIE);

if (isset($_COOKIE['admin_name'], $_COOKIE['admin_password'])) {
 $post['name'] = $_COOKIE['admin_name'];
 $post['password'] = $_COOKIE['admin_password'];
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
  <button type="button" onclick="location.href='../views/index.php'">トップページへ</button>
 </body>
</div>

</html>