<?php
require('dbconnect.php');
$posts = $_POST;
var_dump($posts);
//$db->beginTransaction();

//$sql = 'INSERT INTO posts(title,detail,image,created_at,updated_at) set :title,:detail,:image,now(),now()';
$sql = 'INSERT INTO posts(title,detail,image,created_at,updated_at) VALUES (:title,:detail,:image,now(),now())';

try {
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':title', $posts['title'], PDO::PARAM_STR);
 $stmt->bindValue(':detail', $posts['detail'], PDO::PARAM_STR);
 $stmt->bindValue(':image', $posts['image'], PDO::PARAM_STR);
 $stmt->execute();
 var_dump($stmt);
 echo '成功';
} catch (PDOException $e) {
 echo $e;
}
