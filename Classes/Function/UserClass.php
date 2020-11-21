<?php
require_once dirname(__FILE__) . '/../UtilClass.php';

class UserClass extends UtilClass
{
 protected $table_name = 'users';

 public function getUserId(int $id)
 {
  $db = $this->dbConnect();
  $sql = "SELECT users.*
  from users
   inner join posts
   on users.id = posts.user_id
  where users.id= :id
  group by users.id";

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $result = $this->sanitize($result);
  return $result;
 }
}
