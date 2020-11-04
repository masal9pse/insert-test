<?php
session_start();
require_once __DIR__ . '/dbconnect.php';
require_once __DIR__ . '/util.php';
$db = dbConnect();
$lists = getAllData($db, 'posts');
//echo $_SESSION['auth_id'];
function isGood($u_id, $p_id)
{
 debug('いいねした情報があるか確認');
 debug('ユーザーID' . $u_id);
 debug('投稿ID：' . $p_id);

 try {
  $db = dbConnect();
  $sql = 'SELECT * FROM likes WHERE post_id = :p_id AND user_id = :u_id';
  $data = array(':u_id' => $u_id, ':p_id' => $p_id);
  // クエリ実行
  $stmt = queryPost($db, $sql, $data);

  if ($stmt->rowCount()) {
   debug('お気に入りです');
   return true;
  } else {
   debug('特に気に入ってません');
   return false;
  }
 } catch (Exception $e) {
  error_log('エラー発生:' . $e->getMessage());
 }
}
// SQL実行関数
function queryPost($db, $sql, $data)
{
 // クエリ作成
 $stmt = $db->prepare($sql);
 // SQL文を実行
 if (!$stmt->execute($data)) {
  debug('クエリ失敗しました。');
  debug('失敗したSQL：' . print_r($stmt, true));
  $err_msg['common'] = MSG07;
  return 0;
 }
 debug('クエリ成功');
 return $stmt;
}

// デバッグフラグ
$debug_flg = true;
// デバッグログ関数
function debug($str)
{
 global $debug_flg;
 if (!empty($debug_flg)) {
  error_log('デバッグ：' . $str);
 }
}


var_dump($_SESSION);
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

 <?php if (empty($_SESSION['auth_id'])) : ?>
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
   <td><?php echo $list['title']; ?></td>
   <td><?php echo $list['detail']; ?></td>
   <form action="like.php" method="post">
    <i class="fas fa-heart"></i>
    <!--<button type="submit" class="btn p-0 border-0 text-danger">-->
    <i class="fas fa-heart fa-fw text-danger"></i>
    <!--</button>-->
    <?php echo $list['like_count']; ?>
   </form>
   <td><button type="button" onclick="location.href='./update_form.php?id=<?php print($list['id']) ?>'">編集</button></td>
  </div>
 <?php endforeach ?>
 <?php if (!empty($_SESSION['auth_id'])) : ?>
  <button type="button" onclick="location.href='./mypage.php?id=<?php echo $_SESSION['auth_id'] ?>'">マイページ</button>
 <?php endif; ?>
</body>

</html>