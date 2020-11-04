<?php
//　/user_posts_form.php?id={num} でアクセスしてください
session_start();
include('dbconnect.php');
include('util.php');
auth_check('./auth/login.php');
$db = dbConnect();

$sql = 'SELECT * from posts 
inner join users 
on posts.user_id = users.id
where users.id=:user_id';

$stmt = $db->prepare($sql);
$stmt->bindValue(':user_id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
 $result = sanitize($result);
 echo $result['title'] . '<br>';
 echo $result['detail'] . ' ';
}
