<?php
require_once('util.php');

class LikeClass extends Util
{
 // いいねしているか判定する
 function isLike($post_id, $user_id)
 {
  try {
   $db = $this->dbConnect();
   $sql = 'SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
   $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
   $stmt->execute();
   $results = $stmt->fetchAll();
   //var_dump($results);
   return $results;
   //return true;
  } catch (Exception $e) {
   error_log('エラー発生:' . $e->getMessage());
  }
 }
 // いいねのカウント数を数える
 function getLike($post_id)
 {
  try {
   $db = $this->dbConnect();
   $sql = 'SELECT * FROM likes WHERE post_id = :post_id';
   $stmt = $db->prepare($sql);
   // クエリ実行
   $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
   $stmt->execute();

   if ($stmt) {
    return $stmt->fetchAll();
   } else {
    return false;
   }
  } catch (Exception $e) {
   exit('エラー発生：' . $e->getMessage());
  }
 }

 public function likeCount()
 {
  $db = $this->dbConnect();
  if ($this->isLike($_POST['post_id'], $_SESSION['auth_id'])) {
   $sql = 'DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':post_id', $_POST['post_id'], PDO::PARAM_INT);
   $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
   $stmt->execute();
   echo 'いいねを削除しました';
   //header("Location: ./list.php");
  } else {
   $sql = 'INSERT INTO likes(post_id,user_id) values (:post_id,:user_id)';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':post_id', $_POST['post_id'], PDO::PARAM_INT);
   $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
   $stmt->execute();
   echo 'いいねしました';
   //header("Location: ./list.php");
  }
 }
}
