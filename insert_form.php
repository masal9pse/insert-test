<?php
session_start();
include('dbconnect.php');
include('util.php');
auth_check('./auth/login.php');
$db = dbConnect();
$tags = getAllData($db, 'tags');
$post = sanitize($_POST);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>投稿フォーム</title>
</head>

<body>
  <h1>投稿フォーム</h1>
  <a href="./list.php">一覧表示リンク</a>
  <a href="./search_form.php">検索リンク</a>
  <form action="insert.php" method="post" enctype="multipart/form-data">
    <table border="1">
      <tr>
        <td>タイトル</td>
        <!-- 空文字判定して変数にまとめる -->
        <td><input type="text" name="title" value="<?php empty_check($post, 'title') ?>"></td>
        <td>本文</td>
        <!--XSS対策は後ほど-->
        <td><input type="text" name="detail" value="<?php empty_check($post, 'detail') ?>"></td>
        <td>画像</td>
        <!-- valueを指定したい -->
        <td><input type="file" name="image"></td>
        <td><input type="hidden" name="user_id" value="<?php print(htmlspecialchars($_SESSION['auth_id'])); ?>"></td>
        <td>
          <?php foreach ($tags as $tag) : ?>
            <input type="checkbox" name="tags[]" value="<?php echo $tag['id']; ?>">
            <label for="<?php echo $tag['tag']; ?>"><?php echo $tag['tag']; ?></label>
          <?php endforeach; ?>
        </td>
        <td colspan="2" align="center">
          <input type="submit" value="送信">
      </tr>
    </table>
  </form>
</body>

</html>
<html>