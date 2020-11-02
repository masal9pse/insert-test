<?php
include('dbconnect.php');
$tag_sql = 'SELECT * from tags';
$stmt = $db->query($tag_sql);
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 最新のidを一件取得する => タグ付けのpost_tag.post_idにバインドするため
$posts_sql = 'SELECT * FROM posts ORDER BY id DESC LIMIT 1';
$stmt = $db->query($posts_sql);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($post);
//exit;
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
        <td><input type="hidden" name="id" value="<?php echo $post['id']; ?>"></td>
        <td><input type="text" name="title" value="<?php print(htmlspecialchars($_POST['title'])); ?>"></td>
        <td>本文</td>
        <!--XSS対策は後ほど-->
        <td><input type="text" name="detail"></td>
        <td>画像</td>
        <td><input type="file" name="image"></td>
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