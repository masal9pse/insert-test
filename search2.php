<?php
require('dbconnect.php');
//var_dump($_GET);
//$where = [];
//$binds = [];
//if (!empty($_GET['category']) && empty($_GET['search'])) {
if (!empty($_GET['category']) && isset($_GET['search'])) {
 $sql = 'SELECT * from posts　LEFT JOIN
 post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category';
}

$stmt = $db->prepare($sql);
$stmt->bindValue(':category', $_GET["category"], PDO::PARAM_STR);
$stmt->execute();
var_dump($stmt);
//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt);
var_dump($result2);
//if (!empty($results[0])) {
// echo 'test_tableからidが取得できました';
//} else {
// echo 'test_tableからidを取得できませんでした';
//}
exit;

if (!empty($_GET['search'])) {
 $sql = 'SELECT * from posts where posts.title like :title or posts.detail like :detail';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':title', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 $stmt->bindValue(':category', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 $stmt->execute();
 var_dump($stmt);
 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($results);
}

if (!empty($_GET['category'] && $_GET['search'])) {
 $sql = 'SELECT * from posts　LEFT JOIN
 post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category and posts.title like :title or posts.detail like :detail';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
 $stmt->bindValue(':title', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 $stmt->bindValue(':category', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 $stmt->execute();
 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($results);
}

//if (!empty($_GET['category'] && $_GET['search'] && $_GET['tag'])) {
// $sql = 'SELECT * from posts　LEFT JOIN
// post_category
// ON posts.id = post_category.post_id
// LEFT JOIN categories
// ON categories.id = post_category.category_id
// ON tags.id = post_tag.tag_id
// LEFT JOIN post_category
// ON posts.id = post_category.post_id
// LEFT JOIN categories
// ON categories.id = post_category.category_id
//WHERE categories.category = :category 
//and 
//posts.title like :title or posts.detail like :detail
//and  tags.tag = :tag';
//}
//var_dump($sql);
