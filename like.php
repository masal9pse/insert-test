<?php
require('dbconnect.php');
require('util.php');
session_start();
var_dump($_POST);
// issetが空文字でもtrueであるか調べる
var_dump($_SESSION);
//exit;
$db = dbConnect();
//var_dump($list);
// submitは空文字でtrueになるissetを使用する
if (isGood($_POST['post_id'], $_SESSION['auth_id'])) {
 echo 'いいねを削除しました';
} else {
 $sql = 'INSERT INTO likes(post_id,user_id) values (:post_id,:user_id)';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':post_id', $_POST['post_id'], PDO::PARAM_INT);
 $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
 $stmt->execute();
 echo 'いいねしました';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
</head>

<body>
 <a href="list.php">トップページへ</a>
</body>

</html>