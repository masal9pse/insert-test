<?php
session_start();
require('util.php');
auth_check('./auth/login.php');
var_dump($_POST);
// issetが空文字でもtrueであるか調べる
var_dump($_SESSION);
//exit;
//var_dump($list);
// submitは空文字でtrueになるissetを使用する
class Like
{

 private function dbConnect()
 {
  ini_set('display_errors', "On");
  try {
   $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
   //echo '接続成功です';
  } catch (PDOException $e) {
   echo $e . 'エラーです';
  }
  return $db;
 }

 private function isLike($post_id, $user_id)
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
 public function like()
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
$likeClass = new Like();
$likeClass->like();
?>
<a href="list.php">トップページへ</a>