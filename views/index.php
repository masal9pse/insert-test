<?php
session_start();
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\PostController;
use App\Controllers\AuthController;
use App\Controllers\LikeController;


$postInstance = new PostController();
$lists = $postInstance->getAllData();

if (empty($_SESSION['auth_id'])) {
 (string)$_SESSION['auth_id'] = "名無しのごんべ";
}

if (isset($_POST['logout'])) {
 $authInstance = new AuthController();
 $authInstance->logout($_SESSION, 'index.php');
}

$likeInstance = new LikeController();
$likeInstance->setToken();
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
 <div class="container mt-5">
  <h1>一覧リスト</h1>
  <a href="./search_form.php">検索リンク</a>
  <a href="./insert_form.php">投稿リンク</a>
  <form action="../auth/admin_form.php" method="get">
   <button type="submit" class="btn btn-success">管理画面</button>
  </form>
  <?php if (is_string($_SESSION['auth_id'])) : ?>
   <form action="../auth/login.php" method="get">
    <button type="submit" class="btn btn-danger">ログイン</button>
   </form>
   <form action="../auth/signup_form.php" method="get">
    <button type="submit" class="btn btn-danger">新規投稿</button>
   </form>
  <?php else : ?>
   <form action="" method="post">
    <button type="submit" name="logout" class="btn btn-danger">ログアウト</button>
   </form>
   <?php if (is_int($_SESSION['auth_id'])) : ?>
    <button type="button" onclick="location.href='./mypage.php'">マイページ</button>
   <?php endif; ?>
  <?php endif; ?>

  <?php foreach ($lists as $list) : ?>
   <div>
    <td><?php echo $list['id']; ?></td>
    <td>
     <a href="show.php?post_id=<?php print($list['id']) ?>&user_id=<?php print($list['user_id']) ?>">
      <?php echo $list['title']; ?>
     </a>
    </td>
    <td><?php echo $list['detail']; ?></td>

    <!-- いいね機能 -->
    <?php if ($likeInstance->isLike($list['id'], $_SESSION['auth_id'])) : ?>
     <form action="../Execute/rmLike.php" method="post" style="display:inline;">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
      <input type="hidden" name="post_id" value="<?php echo $list['id']; ?>">
      <button type="submit" class="btn p-0 border-0">
       <i class="fas fa-heart fa-fw text-danger"></i>
      </button>
     </form>
    <?php else : ?>
     <form action="../Execute/addLike.php" method="post" style="display:inline;">
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
    <!-- tableからフェッチした値はstringになってしまう -->
    <?php if ((int)$list['user_id'] === $_SESSION['auth_id']) : ?>
     <td><button type="button" onclick="location.href='./update_form.php?id=<?php print($list['id']) ?>'">編集</button></td>
     <form action="../Execute/archive.php" method="post" style="display:inline;">
      <input type="hidden" name="delete_id" value="<?php echo $postInstance->sanitize($list['id']); ?>">
      <button type="submit">アーカイブ</button>
     </form>
     <td>
      <button type="button" class="btn btn-danger btn-sm deleteBtn" id="<?php echo $list['id'] ?>" data-target="#deletemodal" data-toggle="modal" data-backdrop="false">
       削除
      </button>
     <?php endif; ?>

   </div>
  <?php endforeach ?>
 </div>
</body>

</html>