<?php
require('dbconnect.php');
//var_dump($_GET);
if (!empty($_GET['category'])) {

 $sql = 'SELECT * FROM posts
 LEFT JOIN
 post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category';

 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET["category"], PDO::PARAM_STR);
 $stmt->execute();
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 //var_dump($stmt);
 var_dump($search);
}

if (!empty($_GET['search'])) {
 $sql = 'SELECT * from posts where title=:title or detail=:detail';
 //$sql = 'SELECT * from posts where title=:title';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':title', $_GET['search'], PDO::PARAM_STR);
 $stmt->bindValue(':detail', $_GET['search'], PDO::PARAM_STR);
 $stmt->execute();
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search);
}
