<?php
include('dbconnect.php');
include('util.php');
$db = dbConnect();
$lists = getAllData($db, 'posts');
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
 <a href="./insert_form.php">投稿リンク</a>
 <?php foreach ($lists as $list) : ?>
  <div>
   <td><?php echo $list['title']; ?></td>
   <td><?php echo $list['detail']; ?></td>
   <td><button type="button" onclick="location.href='./update_form.php?id=<?php print($list['id']) ?>'">編集</button></td>
  </div>
 <?php endforeach ?>
</body>

</html>