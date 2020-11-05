<?php
session_start();
require_once __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/util.php';
$db = dbConnect();
$lists = getAllData($db, 'posts');
//echo $_SESSION['auth_id'];
var_dump($_SESSION);
if (empty($_SESSION)) {
 $_SESSION['auth_id'] = "名無しのごんべ";
}
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

 <?php if (is_string($_SESSION['auth_id'])) : ?>
  <form action="./auth/login.php" method="get">
   <button type="submit" class="btn btn-danger">ログイン</button>
  </form>
  <form action="./auth/signup_form.php" method="get">
   <button type="submit" class="btn btn-danger">新規投稿</button>
  </form>
 <?php else : ?>
  <form action="./auth/logout.php" method="post">
   <button type="submit" name="logout" class="btn btn-danger">ログアウト</button>
  </form>
 <?php endif; ?>

 <?php foreach ($lists as $list) : ?>
  <div>
   <td><?php echo $list['id']; ?></td>
   <td><?php echo $list['title']; ?></td>
   <td><?php echo $list['detail']; ?></td>
   <form action="like.php" method="post" style="display:inline;">
    <?php if (isLike($list['id'], $_SESSION['auth_id'])) : ?>
     <button type="submit" class="btn p-0 border-0">
      <input type="hidden" name="post_id" value="<?php echo $list['id']; ?>">
      <i class="fas fa-heart fa-fw text-danger"></i>
     </button>
   </form>
  <?php else : ?>
   <form action="like.php" method="post" style="display:inline;">
    <button type="submit" class="btn p-0 border-0">
     <input type="hidden" name="post_id" value="<?php echo $list['id']; ?>">
     <i class="fas fa-heart"></i>
    </button>
   <?php endif; ?>
   </form>
   <span>
    <?php echo count(getLike($list['id'])); ?>
   </span>
   <td><button type="button" onclick="location.href='./update_form.php?id=<?php print($list['id']) ?>'">編集</button></td>
  </div>
 <?php endforeach ?>
 <?php if (is_int($_SESSION['auth_id'])) : ?>
  <button type="button" onclick="location.href='./mypage.php?id=<?php echo $_SESSION['auth_id'] ?>'">マイページ</button>
 <?php endif; ?>
</body>

</html>