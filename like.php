<?php
require('util.php');
session_start();
auth_check('./auth/login.php');
var_dump($_POST);
// issetが空文字でもtrueであるか調べる
var_dump($_SESSION);
//exit;
$db = dbConnect();
//var_dump($list);
// submitは空文字でtrueになるissetを使用する
if (isLike($_POST['post_id'], $_SESSION['auth_id'])) {
 $sql = 'DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':post_id', $_POST['post_id'], PDO::PARAM_INT);
 $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
 $stmt->execute();
 echo 'いいねを削除しました';
 //header("Location: ./list.php");
} else {
 $sql = 'INSERT INTO likes(post_id,user_id) values (:post_id,:user_id)';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':post_id', $_POST['post_id'], PDO::PARAM_INT);
 $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
 $stmt->execute();
 echo 'いいねしました';
 //header("Location: ./list.php");
}
?>
<a href="list.php">トップページへ</a>