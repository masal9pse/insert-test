<?php
require_once dirname(__FILE__) . '/../auth/AuthClass.php';

class FollowClass extends AuthClass
{
 function check_follow($follow_user, $follower_user)
 {
  $db = $this->dbConnect();
  $sql = "SELECT *
          FROM follows
          WHERE follow_id = :follow_id AND follower_id = :follower_id";

  $stmt = $db->prepare($sql);
  $stmt->execute(array(
   ':follow_id' => $follow_user,
   ':follower_id' => $follower_user
  ));
  return  $stmt->fetch();
 }

 function getFollow($follower_id)
 {
  try {
   $db = $this->dbConnect();
   $sql = 'SELECT * FROM follows WHERE follower_id = :follower_id';
   $stmt = $db->prepare($sql);
   // クエリ実行
   $stmt->bindValue(':follower_id', $follower_id, PDO::PARAM_INT);
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

 public function follow()
 {
  $db = $this->dbConnect();
  $sql = 'INSERT INTO follows(follow_id,follower_id) values (:follow_id,:follower_id)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':follow_id', $_POST['follow_id'], PDO::PARAM_INT);
  $stmt->bindValue(':follower_id', $_POST['follower_id'], PDO::PARAM_INT);
  $stmt->execute();
  echo 'フォローしました';
  //header("Location: ./index.php");
 }

 public function unfollow()
 {
  $db = $this->dbConnect();
  $sql = 'DELETE FROM follows WHERE follow_id = :follow_id AND follower_id = :follower_id';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':follow_id', $_POST['follow_id'], PDO::PARAM_INT);
  $stmt->bindValue(':follower_id', $_POST['follower_id'], PDO::PARAM_INT);
  $stmt->execute();
  echo 'フォローを解除しました';
 }
}
