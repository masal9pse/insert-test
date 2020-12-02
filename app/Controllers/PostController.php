<?php

namespace App\Controllers;

use PDO;
use App\Models\PostModel;
use App\Controllers\UtilController;

class PostController extends UtilController
{
 protected $table_name;
 protected $sort;

 public function __construct()
 {
  $this->table_name = 'posts';
  $this->sort = 'asc';
 }
 public function getAllData(): array
 {
  $db = $this->dbConnect();
  $sql = "SELECT * from $this->table_name where delete_flag = 0 order by id $this->sort";
  $stmt = $db->query($sql);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $this->sanitize($results);
  return $results;
  $db = null;
 }

 // 記事投稿
 function postInsert($post)
 {
  $db = $this->dbConnect();
  $sql = 'INSERT INTO posts(title,detail,image,created_at,updated_at,user_id) VALUES (:title,:detail,:image,now(),now(),:user_id)';
  $image = uniqid(mt_rand(), true);
  $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':image', $image, PDO::PARAM_STR);
  $stmt->bindValue(':title', $post['title'], PDO::PARAM_STR);
  $stmt->bindValue(':detail', $post['detail'], PDO::PARAM_STR);
  $stmt->bindValue(':user_id', $post['user_id'], PDO::PARAM_INT);
  if (!empty($_FILES['image']['name'])) {
   move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);
   echo "<img src=\" ../images/$image \">";
  }
  $stmt->execute();
  $id = $db->lastInsertId();
  $_SESSION['now_post_insert_id'] = $id;
  echo '<p>' . $id . "のアップロードに成功しました</p>";
  echo '<p>' . $post['title'] . "のアップロードに成功しました</p>";
 }

 // 記事に紐づいたタグを中間テーブルにインサート
 function postTagInsert($tags)
 {
  $db = $this->dbConnect();
  $sql = "INSERT INTO post_tag(post_id,tag_id) VALUES (:post_id,:tag_id)";
  $now_post_insert_id = $_SESSION['now_post_insert_id'];
  var_dump($now_post_insert_id);
  foreach ($tags['tags'] as $tag_num) {
   $tag_stmt = $db->prepare($sql);
   $tag_stmt->bindValue(':post_id', $now_post_insert_id, PDO::PARAM_INT);
   $tag_stmt->bindValue(':tag_id', $tag_num, PDO::PARAM_INT);
   $tag_stmt->execute();
  }
  unset($_SESSION['now_post_insert_id']);
 }

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
   if (file_exists('../images/' . $result['image'])) {
    unlink('../images/' . $result['image']);
   }
   move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $new_image);
  }
  $new_stmt->execute();
 }

 function postLogicalDelete($post)
 {
  $db = $this->dbConnect();
  $sql = 'UPDATE posts set delete_flag = 1 where id = :id';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $post, PDO::PARAM_INT);
  $result = $stmt->execute();
  return $result;
 }

 function postLogicalUpdate($post)
 {
  $db = $this->dbConnect();
  $sql = 'UPDATE posts set delete_flag = 0 where id = :id';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $post, PDO::PARAM_INT);
  $stmt->execute();
  header("Location: ../views/mypage.php");
 }

 function postLogicalDeleteList()
 {
  $db = $this->dbConnect();
  $post = new PostModel;
  $sql = "SELECT * from $post->table_name where delete_flag = 1 and user_id=:user_id order by id $post->sort";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $this->sanitize($results);
  return $results;
  $db = null;
 }
}
