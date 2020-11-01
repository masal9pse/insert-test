<?php
//　/user_posts_form.php?id={num} でアクセスしてください
include('dbconnect.php');
$sql = 'SELECT * from posts 
inner join users 
on posts.user_id = users.id
where users.id=:user_id';

$stmt = $db->prepare($sql);
$stmt->bindValue(':user_id', $_GET['id'], PDO::PARAM_INT);
//$stmt->bindValue(':user_id', 1, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($results);
foreach ($results as $result) {
 echo $result['title'] . ' ';
 echo $result['detail'] . ' ';
}
