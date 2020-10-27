<?php
require('dbconnect.php');
var_dump($_GET);
$sql = 'SELECT * FROM posts
 LEFT JOIN
 post_category
 ON
posts.id = post_category.post_id
 LEFT JOIN
 categories
 ON
categories.id = post_category.category_id
WHERE
categories.category = :category';

$stmt = $db->prepare($sql);
$stmt->bindValue(':category', $_GET["category"], PDO::PARAM_STR);
$stmt->execute();
$search = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt);
var_dump($search);
