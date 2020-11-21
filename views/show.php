<?php
session_start();
$_SESSION['show_page'] = $_SERVER["REQUEST_URI"];
var_dump($_SESSION);

require_once("../Models/Function/PostClass.php");
require_once("../Models/Function/UserClass.php");
require_once("../Models/Function/FollowClass.php");

$post = new PostClass;
$post = $post->getById($_GET['id']);
$user = new UserClass;
$user = $user->getUserId($_GET['user_id']);
var_dump($user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
 <title>詳細ページ</title>
</head>

<body>
 <h1>詳細ページ</h1>
 <p>
  <?php echo $user['name']; ?>
  <!-- フォロー機能 -->
  <?php $followInstance = new FollowClass; ?>
  <form action="../Controller/follow.php" method="post" style="display:inline;">
   <input type="hidden" name="follow_id" value="<?php echo $_SESSION['auth_id']; ?>">
   <input type="hidden" name="follower_id" value="<?php echo $user['id']; ?>">
   <?php if ($followInstance->check_follow($_SESSION['auth_id'], $user['id'])) : ?>
    <button class="btn btn-danger" type="submit" name="follow">フォロー中</button>
   <?php else : ?>
    <button class="btn btn-primary" type="submit" name="follow">フォロー</button>
   <?php endif; ?>
  </form>
  <?php echo count($followInstance->getFollow($user['id'])); ?>

 </p>
 <ul>
  <li>記事タイトル <?php echo $post['title'] ?></li>
  <li>記事 <?php echo $post['detail'] ?></li>
 </ul>
 <a href="./index.php">トップページへ</a>
</body>

</html>