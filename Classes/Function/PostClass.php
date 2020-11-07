<?php

require_once dirname(__FILE__) . '/../UtilClass.php';

class PostClass extends UtilClass
{
 protected $table_name = 'posts';

 // 記事更新
 function postUpdate($post)
 {
  $db = $this->dbConnect();
  $result = $this->getById($post['id']);
  //exit;
  $new_sql = 'UPDATE posts SET title=:title,detail=:detail,image=:image,created_at=now(),updated_at=now(),user_id=:user_id where id=:id';
  $new_image = uniqid(mt_rand(), true); //ファイル名をユニーク化
  //var_dump($new_image);
  $new_image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
  $new_stmt = $db->prepare($new_sql);
  $new_stmt->bindValue(':title', $post['title'], PDO::PARAM_STR);
  $new_stmt->bindValue(':detail', $post['detail'], PDO::PARAM_STR);
  $new_stmt->bindValue(':image', $new_image, PDO::PARAM_STR);
  $new_stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
  $new_stmt->bindValue(':id', $post['id'], PDO::PARAM_INT);
  if (!empty($_FILES['image']['name'])) {
   unlink('./images/' . $result['image']);
   move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $new_image);
  }
  $new_stmt->execute();
 }
}
