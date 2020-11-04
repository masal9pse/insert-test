<?php
require('dbconnect.php');
require('util.php');
session_start();
var_dump($_POST);
// issetが空文字でもtrueであるか調べる
echo isset($_POST['submit']) ? 'ok' : 'no';
var_dump($_SESSION);
//exit;
$db = dbConnect();
//$list = getById($db, $_POST['post_id']);
//var_dump($list);
// submitは空文字でtrueになるissetを使用する
if (isset($_POST['submit'])) {
 //$sql = 'INSERT INTO likes(id,post_id,user_id) values (5,:post_id,:user_id)';
 $sql = 'INSERT INTO likes(post_id,user_id) values (:post_id,:user_id)';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':post_id', $_POST['post_id'], PDO::PARAM_INT);
 $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
 $stmt->execute();
 echo '投稿に成功';
}
//header()