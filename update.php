<?php
include('dbconnect.php');
var_dump($_POST);
//var_dump($_FILES);

try {
 //$select_sql = 'SELECT * from posts where id=:id';
 //$select_stmt = $db->prepare($sql);
 //$select_stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
 //$select_stmt->execute();
 //$update_post =  $select_stmt->fetch(PDO::FETCH_ASSOC);
 //var_dump($update_post);
 //exit;
 $update_sql = 'UPDATE posts set title=:title,detail=:detail,image=:image created_at=now(),updated_at=now() where id=:id';
 $image = uniqid(mt_rand(), true); //ファイル名をユニーク化
 //var_dump($image);
 //$image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
 $image = $image . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
 //var_dump($image);
 //exit;
 $update_stmt = $db->prepare($update_sql);
 $update_stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
 $update_stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
 $update_stmt->bindValue(':detail', $_POST['detail'], PDO::PARAM_STR);
 $update_stmt->bindValue(':image', $image, PDO::PARAM_STR);
 if (!empty($_FILES['image']['name'])) {
  unlink('images/' . $update_post['image']);
  move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);
 }
 $update_stmt->execute();
 $result = $update_stmt->fetch();
 var_dump($result);
 echo '更新にせいこうしました';
} catch (PDOException $e) {
 echo $e . '更新できませんでした';
}
echo "<a href='./list.php'>一覧フォームへ</a>";
