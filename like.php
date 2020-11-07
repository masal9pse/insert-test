<?php
ini_set('display_errors', "On");
session_start();
require('LikeClass.php');
$likeInstance = new LikeClass();
$likeInstance->auth_check('./auth/login.php');
var_dump($_POST);
// issetが空文字でもtrueであるか調べる
var_dump($_SESSION);
//exit;
//var_dump($list);
$likeInstance->likeCount();
?>
<a href="list.php">トップページへ</a>