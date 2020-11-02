<?php
require('dbconnect.php');
//var_dump($_FILES);
var_dump($_POST);
//foreach($tag as )
$count_tags = count($_POST['tags']);
var_dump($count_tags);
//exit;
foreach ($_POST['tags'] as $tag) {
 var_dump($tag);
}
//exit;
if (empty($_POST['title'])) {
 exit('タイトルを入力してください');
}
$image = uniqid(mt_rand(), true); //ファイル名をユニーク化
$image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
//var_dump($image);
//exit;
$posts_sql = 'INSERT INTO posts(title,detail,image,created_at,updated_at) VALUES (:title,:detail,:image,now(),now())';
$tag_sql = "INSERT INTO post_tag(post_id,tag_id) VALUES (3,6)";
$db->beginTransaction();
try {
 $post_stmt = $db->prepare($posts_sql);
 $post_stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
 $post_stmt->bindValue(':detail', $_POST['detail'], PDO::PARAM_STR);
 $post_stmt->bindValue(':image', $image, PDO::PARAM_STR);
 //for ($i = 1; $i <= $count_tags; $i++) {
 // $tag_sql = "INSERT INTO post_tag VALUES(:post_id,:tag_id)";
 // $tag_stmt = $db->prepare($tag_sql);
 // $tag_stmt->bindValue(':post_id', 3, PDO::PARAM_INT);
 // $tag_stmt->bindValue(':tag_id', $tag, PDO::PARAM_INT);
 //}
 //for ($i = 1; $i <= $count_tags; $i++) {
 //$tag_sql = "INSERT INTO post_tag VALUES(3,6)";
 //$tag_stmt = $db->query($tag_sql);
 //$tag_stmt = $db->prepare($tag_sql);
 //$tag_stmt->bindValue(':post_id', 3, PDO::PARAM_INT);
 //$tag_stmt->bindValue(':tag_id', $tag, PDO::PARAM_INT);
 //}
 if (!empty($_FILES['image']['name'])) { //ファイルが選択されていれば$imageにファイル名を代入
  move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);
 }
 $post_stmt->execute();
 $tag_stmt = $db->prepare($tag_sql);
 $tag_stmt->execute();
 $db->commit();
 echo '投稿に成功しました';
 echo "<img src=\" ./images/$image \">";
 echo '<p>' . $_POST['title'] . "のアップロードに成功しました</p>";
 echo "<a href='./insert_form.php'>投稿フォームへ</a>";
} catch (PDOException $e) {
 $db->rollBack();
 exit($e);
}
