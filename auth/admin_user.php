<?php
session_start();
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AdminController;
use App\Controllers\UserController;

//var_dump($_SESSION);
$admin = new AdminController;
$admin->admin_check('./admin_form.php');

$user = new UserController;
$users = $user->getAllData();
if (isset($_POST['admin-logout'])) {
 $admin->adminLogout();
 header("Location: ../views/index.php");
}
//var_dump($user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>顧客一覧</title>
</head>

<body>
 <h1>ユーザー一覧</h1>
 <a href="../views/index.php">トップページへ</a>
 <form action="" method="post">
  <input type="submit" name="admin-logout" value="ログアウト">
 </form>
 <?php foreach ($users as $user) : ?>
  <ul>
   <li>
    <?php echo $user['name']; ?>
    <button type="button" onclick="location.href='./admin_user_like.php?id=<?php echo $user['id'] ?>'">いいねした記事</button>
   </li>
  </ul>
 <?php endforeach; ?>
</body>

</html>