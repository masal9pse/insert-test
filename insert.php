<?php
//ini_set('display_errors', "On");
require('dbconnect.php');

if (empty($_POST['title'])) {
 exit('タイトルを入力してください');
}
$image = uniqid(mt_rand(), true); //ファイル名をユニーク化
$image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
//var_dump($image);
//exit;
$posts_sql = 'INSERT INTO posts(title,detail,image,created_at,updated_at) VALUES (:title,:detail,:image,now(),now())';
$tag_sql = "INSERT INTO post_tag(post_id,tag_id) VALUES (:post_id,:tag_id)";
$db->beginTransaction();
try {
 $post_stmt = $db->prepare($posts_sql);
 $post_stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
 $post_stmt->bindValue(':detail', $_POST['detail'], PDO::PARAM_STR);
 $post_stmt->bindValue(':image', $image, PDO::PARAM_STR);
 $now_insert_post_id = $_POST['id'] + 1;
 foreach ($_POST['tags'] as $tag) {
  $tag_stmt = $db->prepare($tag_sql);
  var_dump($tag);
  // 投稿したpostsTableのidを取得したい
  $tag_stmt->bindValue(':post_id', $now_insert_post_id, PDO::PARAM_INT);
  $tag_stmt->bindValue(':tag_id', $tag, PDO::PARAM_INT);
  $tag_stmt->execute();
 }
 //exit;
 if (!empty($_FILES['image']['name'])) { //ファイルが選択されていれば$imageにファイル名を代入
  move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);
 }
 $post_stmt->execute();
 var_dump($db->lastInsertId());
 $db->commit();
 echo '投稿に成功しました';
 echo "<img src=\" ./images/$image \">";
 echo '<p>' . $_POST['title'] . "のアップロードに成功しました</p>";
 echo "<a href='./insert_form.php'>投稿フォームへ</a>";
} catch (PDOException $e) {
 $db->rollBack();
 exit($e);
}
