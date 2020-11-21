<?php
session_start();
require_once("../Classes/Function/PostClass.php");
require_once("../Classes/Function/UserClass.php");

$post = new PostClass;
$post = $post->getById($_GET['id']);
$user = new UserClass;
$user = $user->getUserId();
var_dump($user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>詳細ページ</title>
</head>

<body>
 <h1>詳細ページ</h1>
 <p>
  <?php echo $user['name']; ?>
 </p>
 <ul>
  <li>記事タイトル <?php echo $post['title'] ?></li>
  <li>記事 <?php echo $post['detail'] ?></li>
 </ul>
</body>

</html>