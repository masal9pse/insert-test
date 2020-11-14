<?php
//require_once dirname(__FILE__) . '/./LikeClass.php';

trait LikeApi
{
 public $id;
 public $post_id;
 public $user_id;

 public function addLikeApi()
 {
  $db = $this->dbConnect();
  $sql = 'INSERT INTO likes(post_id,user_id) values (:post_id,:user_id)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':post_id', $this->post_id, PDO::PARAM_INT);
  $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
  $stmt->execute();
 }

 public function rmLikeApi()
 {
  $db = $this->dbConnect();
  $sql = 'DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':post_id', $this->post_id, PDO::PARAM_INT);
  $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
  $stmt->execute();
 }
}
