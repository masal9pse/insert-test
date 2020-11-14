<?php
//require_once dirname(__FILE__) . '/./LikeClass.php';

trait LikeApi
{
 //protected $table_name = 'posts';
 public $id;
 public $post_id;
 public $user_id;

 public function addLikeApi()
 {
  $db = $this->dbConnect();
  //if (!$this->isLike($this->post_id, $this->user_id)) {
  $sql = 'INSERT INTO likes(post_id,user_id) values (:post_id,:user_id)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':post_id', $this->post_id, PDO::PARAM_INT);
  $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);

  // Execute query
  if ($stmt->execute()) {
   return true;
  }
  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
  //}
 }
}
