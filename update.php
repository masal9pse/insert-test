<?php
include('dbconnect.php');
//var_dump($_POST);
//var_dump($_FILES);

if (empty($_POST['title'])) {
 echo "<a href='./list.php'>一覧フォームへ</a>";
 exit('タイトルが未入力です');
}

$old_sql = 'SELECT * from posts where id=:id';
$old_stmt = $db->prepare($old_sql);
$old_stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$old_stmt->execute();
$old_result =  $old_stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($old_result);
$old_image = $old_result['image'];
//exit;
$new_sql = 'UPDATE posts SET title=:title,detail=:detail,image=:image,created_at=now(),updated_at=now() where id=:id';
$new_image = uniqid(mt_rand(), true); //ファイル名をユニーク化
//var_dump($new_image);
$new_image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
//var_dump($new_image);
//exit;
try {
 $db->beginTransaction();
 $new_stmt = $db->prepare($new_sql);
 $new_stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
 $new_stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
 $new_stmt->bindValue(':detail', $_POST['detail'], PDO::PARAM_STR);
 $new_stmt->bindValue(':image', $new_image, PDO::PARAM_STR);
 if (!empty($_FILES['image']['name'])) {
  unlink('./images/' . $old_image);
  move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $new_image);
 }
 $new_stmt->execute();
 $db->commit();
 echo '更新に成功しました';
} catch (PDOException $e) {
 $db->rollBack();
 echo $e . '更新できませんでした';
}
echo "<a href='./list.php'>一覧フォームへ</a>";
