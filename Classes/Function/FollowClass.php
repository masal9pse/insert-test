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
}
