<?php
session_start();
ini_set('display_errors', "On");
$_SESSION['show_page'] = $_SERVER["REQUEST_URI"];

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\UserController;
use App\Controllers\FollowController;

$user = new UserController;
$user = $user->getUserId($_GET['post_id'], $_GET['user_id']);
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
  この記事を作成したユーザ <?php echo $user['name']; ?>
  <!-- フォロー機能 -->
  <?php $followInstance = new FollowController; ?>
  <?php if ($user['name'] !== $_SESSION['name']) : ?>
   <form action="../Execute/follow.php" method="post" style="display:inline;">
    <input type="hidden" name="follow_id" value="<?php echo $_SESSION['auth_id']; ?>">
    <input type="hidden" name="follower_id" value="<?php echo $user['user_id']; ?>">
    <?php if ($followInstance->check_follow($_SESSION['auth_id'], $user['user_id'])) : ?>
     <button class="btn btn-danger" type="submit" name="follow">フォロー中</button>
    <?php else : ?>
     <button class="btn btn-primary" type="submit" name="follow">フォロー</button>
    <?php endif; ?>
   </form>
   <?php echo count($followInstance->getFollow($user['user_id'])); ?>
  <?php endif; ?>
 </p>
 <ul>
  <li>記事タイトル <?php echo $user['title'] ?></li>
  <li>記事 <?php echo $user['detail'] ?></li>
 </ul>
 <a href="./index.php">トップページへ</a>
</body>

</html>