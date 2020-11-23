<?php
ini_set('display_errors', "On");
session_start();
require('../Models/Function/LikeClass.php');
$likeInstance = new LikeClass();
$likeInstance->auth_check('../auth/login.php');
var_dump($_POST);
// issetが空文字でもtrueであるか調べる
var_dump($_SESSION);
//exit;
//var_dump($list);
if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
 echo "正常なリクエストです。";
 $likeInstance->addLike();
} else {
 echo "不正なリクエストです。";
}
?>
<a href="../views/index.php">トップページへ</a>