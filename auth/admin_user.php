<?php
session_start();
ini_set('display_errors', "On");
require_once dirname(__FILE__) . '/../Classes/Function/UserClass.php';
require_once dirname(__FILE__) . '/../Classes/auth/AdminClass.php';

$admin = new AdminClass;
$admin->admin_check('./admin_form.php');
$user = new UserClass;
$users = $user->getAllData();

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