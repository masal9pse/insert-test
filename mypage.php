<?php
ini_set('display_errors', "On");
session_start();
require('./Classes/MypageClass.php');
require('./Classes/Function/LikeClass.php');
require('./Classes/auth/AuthClass.php');

$mypageInstance = new MypageClass;
$likeInstance = new LikeClass;
$mypageInstance->auth_check('./auth/login.php');

$lists = $mypageInstance->myPageList();
$authInstance = new AuthClass();
if (isset($_POST['logout'])) {
 $authInstance->logout($_SESSION, 'index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
 <title>マイページ</title>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
 <script src="like.js"></script>
</head>

<body>
 <h1>マイページ</h1>
 <form action="" method="post">
  <button type="submit" name="logout" class="btn btn-danger">ログアウト</button>
 </form>
 <?php foreach ($lists as $list) : ?>
  <div>
   <td><?php echo $list['id']; ?></td>
   <td><?php echo $list['title']; ?></td>
   <td><?php echo $list['detail']; ?></td>

   <!--<form id="apiform">

    <input type="text" name="title" placeholder="title" autocomplete="on"><br>
    <textarea name="detail" id="" cols="30" rows="10" placeholder="detail" autocomplete="on"></textarea><br>
    <input type="hidden" name="user_id" placeholder="user_id" autocomplete="on" value="<?php /* echo $_SESSION['auth_id']; */ ?>"><br>

    <button id="postMessage"> Post Message </button>
   </form>-->

   <!-- いいね機能 -->
   <?php if ($likeInstance->isLike($list['id'], $_SESSION['auth_id'])) : ?>
    <form action="rmLike.php" method="post" style="display:inline;">
     <input type="hidden" name="post_id" value="<?php echo $list['id']; ?>">
     <button type="submit" class="btn p-0 border-0">
      <i class="fas fa-heart fa-fw text-danger"></i>
     </button>
    </form>
   <?php else : ?>
    <form action="addLike.php" method="post" style="display:inline;">
     <input type="hidden" name="post_id" value="<?php echo $list['id']; ?>">
     <button type="submit" class="btn p-0 border-0">
      <i class="fas fa-heart"></i>
     </button>
    </form>
   <?php endif;  ?>

   <span>
    <?php echo count($likeInstance->getLike($list['id']));  ?>
   </span>
   <td><button type="button" onclick="location.href='./update_form.php?id=<?php print($list['id']) ?>'">編集</button></td>
  </div>
 <?php endforeach ?>
 <a href="index.php">トップページへ</a>
</body>

</html>