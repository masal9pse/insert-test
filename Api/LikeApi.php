<?php
require('../Classes/Function/LikeClass.php');

class LikeApi extends LikeClass
{
 public function addLike()
 {
  $db = $this->dbConnect();
  if (!$this->isLike($_POST['post_id'], $_SESSION['auth_id'])) {
   $sql = 'INSERT INTO likes(post_id,user_id) values (:post_id,:user_id)';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':post_id', $_POST['post_id'], PDO::PARAM_INT);
   $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);

   // Execute query
   if ($stmt->execute()) {
    return true;
   }
   // Print error if something goes wrong
   printf("Error: %s.\n", $stmt->error);

   return false;
  }
 }
}
$likeApi = new LikeApi;

$data = json_decode(file_get_contents("php://input"));

if ($likeApi->addLike()) {
 echo json_encode(
  array('message' => 'Like Created')
 );
} else {
 echo json_encode(
  array('message' => 'Like Not Created')
 );
}
