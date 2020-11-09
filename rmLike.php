<?php
ini_set('display_errors', "On");
session_start();
require('./Classes/Function/LikeClass.php');
$likeInstance = new LikeClass();
$likeInstance->auth_check('./auth/login.php');
var_dump($_POST);
var_dump($_SESSION);
//exit;
if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
 echo "正常なリクエストです。";
 $likeInstance->rmLike();
} else {
 echo "不正なリクエストです。";
}
?>
<a href="index.php">トップページへ</a>