<?php
include('dbconnect.php');
//var_dump($_GET);
$sql = 'SELECT * from posts where id=:id';
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$update_post = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($update_post);
