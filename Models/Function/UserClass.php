<?php
require_once dirname(__FILE__) . '/../UtilClass.php';

final class UserClass extends UtilClass
{
 protected $table_name = 'users';

 public function getUserId(int $p_id, int $u_id)
 {
  $db = $this->dbConnect();
  $sql = "SELECT u.*,p.*
  FROM users u, posts p
  WHERE u.id=p.user_id AND p.id = :p_id AND u.id=:u_id";

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':p_id', $p_id, PDO::PARAM_INT);
  $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $result = $this->sanitize($result);
  return $result;
 }
}
