<?php
require('dbconnect.php');
//var_dump($_GET);

if (!empty($_GET['category'] && empty($_GET['search']))) {
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
 $search2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search2);
}
//var_dump($stmt);
//exit;
if (empty($_GET['category']) && !empty($_GET['search'])) {
 //if (!empty($_GET['search'])) {
 $sql = 'SELECT * FROM posts 
 WHERE posts.title LIKE :title OR posts.detail LIKE :detail';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':title', '%' . $_GET["search"] . '%', PDO::PARAM_STR);
 $stmt->bindValue(':detail', '%' . $_GET["search"] . '%', PDO::PARAM_STR);
 $stmt->execute();
 var_dump($stmt);
 $test = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($test);
 //exit;
}

if (!empty($_GET['category'] && $_GET['search'])) {
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
categories.category = :category and posts.title like :title or posts.detail like :detail';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
 $stmt->bindValue(':title', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 $stmt->bindValue(':detail', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 var_dump($stmt);
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
