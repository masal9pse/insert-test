<?php
require('UtilClass.php');

class MypageClass extends UtilClass
{
 public function myPageList()
 {
  $db = $this->dbConnect();
  $sql = 'SELECT posts.* from posts 
 inner join users 
 on posts.user_id = users.id
 where users.id=:user_id';

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':user_id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // 基本テキストフォームはないのでXSS対策はやる必要ないかも
  $results = $this->sanitize($results);
  //var_dump($results);
  return $results;
 }
}
