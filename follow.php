<?php
ini_set('display_errors', "On");
require('./Classes/Function/FollowClass.php');
session_start();
$followInstance = new FollowClass;
$followInstance->auth_check('./auth/login.php');
var_dump($_POST);
var_dump($_SESSION);

if ($followInstance->check_follow($_SESSION['auth_id'], $_POST['follower_id'])) {
 $followInstance->unfollow();
} else {
 $followInstance->follow();
}
?>
<a href="index.php">トップページへ</a>