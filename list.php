<?php
require('dbconnect.php');

$sql = 'SELECT * from posts';
$stmt = $db->query($sql);
$lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>一覧表示</title>
</head>

<body>
 <h1>一覧リスト</h1>
 <a href="./search_form.php">検索リンク</a>
 <a href="./insert_form.html">投稿リンク</a>
 <?php foreach ($lists as $list) : ?>
  <ul>
   <li><?php echo $list['title']; ?></li>
  </ul>
 <?php endforeach ?>
</body>

</html>