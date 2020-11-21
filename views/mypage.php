<?php
session_start();
ini_set('display_errors', "On");
require('../Models/MypageClass.php');
require('../Models/Function/LikeClass.php');
require('../Models/auth/AuthClass.php');

$mypageInstance = new MypageClass;
$likeInstance = new LikeClass;
$mypageInstance->auth_check('../auth/login.php');
//var_dump($_SESSION);
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
 <script src="../public/js/like.js"></script>
 <link rel="stylesheet" href="../public/css/like.css">
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

   <!-- いいね機能 -->
   <td>

    <section class="post_id" data-postid="<?php echo $likeInstance->sanitize($list['id']); ?>">
     <!-- nameだとserializeArrayで一番上しか取得できない -->
     <div class="btn-good <?php if ($likeInstance->isLike($list['id'], $_SESSION['auth_id'])) echo 'active'; ?>">
      <i class=" fa-heart fa-lg px-16 <?php
                                      if ($likeInstance->isLike($list['id'], $_SESSION['auth_id'])) {
                                       echo ' active fas';
                                      } else { //いいねを取り消したらハートのスタイルが取り消される
                                       echo ' far';
                                      }; ?>"></i><span><?php echo count($likeInstance->getLike($list['id'])); ?></span>
     </div>
    </section>
  </div>
  </td>
  <td><button type="button" onclick="location.href='./update_form.php?id=<?php print($list['id']) ?>'">編集</button></td>
  <form action="../Controller/archive.php" method="post" style="display:inline;">
   <input type="hidden" name="delete_id" value="<?php echo $list['id']; ?>">
   <button type="submit">アーカイブ</button>
  </form>
  </div>
 <?php endforeach ?>
 <a href="./mypage_archive_list.php">アーカイブした記事一覧</a>
 <br>
 <a href="index.php">トップページへ</a>
</body>

</html>