<?php
ini_set('display_errors', "On");
session_start();
require('./Classes/auth/AuthClass.php');
require('./Classes/Function/PostClass.php');
require('./Classes/Function/LikeClass.php');
require('./Classes/Function/FollowClass.php');

$postInstance = new PostClass();
$lists = $postInstance->getAllData();
//var_dump($lists);
//exit;
var_dump($_SESSION);
if (empty($_SESSION['auth_id'])) {
  (string)$_SESSION['auth_id'] = "名無しのごんべ";
}

$authInstance = new AuthClass();
if (isset($_POST['logout'])) {
  $authInstance->logout($_SESSION, 'index.php');
}
// ログイン画面だけ表示
//var_dump($_COOKIE);
$likeInstance = new LikeClass();
$likeInstance->saveCsrf();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>一覧表示</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
</head>

<body>
  <h1>一覧リスト</h1>
  <a href="./search_form.php">検索リンク</a>
  <a href="./insert_form.php">投稿リンク</a>
  <form action="./auth/admin_form.php" method="get">
    <button type="submit" class="btn btn-danger">管理画面</button>
  </form>
  <?php if (is_string($_SESSION['auth_id'])) : ?>
    <form action="./auth/login.php" method="get">
      <button type="submit" class="btn btn-danger">ログイン</button>
    </form>
    <form action="./auth/signup_form.php" method="get">
      <button type="submit" class="btn btn-danger">新規投稿</button>
    </form>
  <?php else : ?>
    <!--<form action="./auth/logout.php" method="post">-->
    <form action="" method="post">
      <button type="submit" name="logout" class="btn btn-danger">ログアウト</button>
    </form>
    <?php if (is_int($_SESSION['auth_id'])) : ?>
      <button type="button" onclick="location.href='./mypage.php?id=<?php echo $_SESSION['auth_id'] ?>'">マイページ</button>
    <?php endif; ?>
  <?php endif; ?>

  <?php foreach ($lists as $list) : ?>
    <div>
      <td><?php echo $list['id']; ?></td>
      <td><?php echo $list['title']; ?></td>
      <td><?php echo $list['detail']; ?></td>
      <!-- いいね機能 -->
      <?php if ($likeInstance->isLike($list['id'], $_SESSION['auth_id'])) : ?>
        <form action="rmLike.php" method="post" style="display:inline;">
          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
          <input type="hidden" name="post_id" value="<?php echo $list['id']; ?>">
          <button type="submit" class="btn p-0 border-0">
            <i class="fas fa-heart fa-fw text-danger"></i>
          </button>
        </form>
      <?php else : ?>
        <form action="addLike.php" method="post" style="display:inline;">
          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
          <input type="hidden" name="post_id" value="<?php echo $list['id']; ?>">
          <button type="submit" class="btn p-0 border-0">
            <i class="fas fa-heart"></i>
          </button>
        </form>
      <?php endif;  ?>
      <span>
        <?php echo count($likeInstance->getLike($list['id']));  ?>
      </span>

      <!-- フォロー機能 -->
      <?php $followInstance = new FollowClass; ?>
      <form action="follow.php" method="post">
        <input type="hidden" name="follower_id" value="<?= $list['id']; ?>">
        <?php if ($followInstance->check_follow($_SESSION['auth_id'], $list['id'])) : ?>
          <button class="btn btn-danger" type="submit" name="follow">フォロー中</button>
        <?php else : ?>
          <button class="btn btn-primary" type="submit" name="follow">フォロー</button>
        <?php endif; ?>
      </form>

      <td><button type="button" onclick="location.href='./update_form.php?id=<?php print($list['id']) ?>'">編集</button></td>
    </div>
  <?php endforeach ?>
</body>

</html>