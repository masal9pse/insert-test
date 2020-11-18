<?php
var_dump($_GET);
session_start();
ini_set('display_errors', "On");
require_once dirname(__FILE__) . '/../Classes/Function/LikeClass.php';
require_once dirname(__FILE__) . '/../Classes/auth/AdminClass.php';

$admin = new AdminClass;
$admin->admin_check('./admin_form.php');

$like = new LikeClass;
$like_users = $like->like_user_list();
//var_dump($like_users);
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>いいねしたユーザーの一覧</title>
</head>

<body>
 <h1>いいねしたユーザー一覧</h1>
 <?php foreach ($like_users as $like_user) : ?>
  <ul>
   <li>
    <?php echo $like_user['id']; ?>
    <?php echo $like_user['title']; ?>
   </li>
  </ul>
 <?php endforeach ?>
</body>

</html>