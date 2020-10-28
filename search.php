<?php
require('dbconnect.php');
//var_dump($_GET);
$where = [];
$binds = [];
if (!empty($_GET['category'])) {
 $where[] = 'LEFT JOIN
 post_category
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category';

 $binds[':category'] = $_GET['category'];
}

if (!empty($_GET['search'])) {
 $where[] = 'posts.title like :title or posts.detail like :detail';
 $binds[':title'] = '%' . $_GET['search'] . '%';
 $binds[':detail'] = '%' . $_GET['search'] . '%';
}
//var_dump($binds);
//var_dump($where);

if (isset($where)) {
 $whereSql = implode(' AND ', $where);
 $sql = 'SELECT * from posts ' . $whereSql;
 $stmt = $db->prepare($sql);
 foreach ($binds as $key => $val) {
  // foreach ($binds as $val) {
  $stmt->bindValue($key, $val, PDO::PARAM_STR);
  //$stmt->bindValue($val, PDO::PARAM_INT);
  //var_dump($key); // カラム取得
  //var_dump($val); // 検索のために入力した値を取得
  //var_dump($stmt);
 }
 $stmt->execute();
} else {
 $sql = 'SELECT * from posts';
 $stmt = $db->query($sql);
}
var_dump($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($stmt);
var_dump($results);

foreach ($results as $result) {
 echo $result['title'] . ' ';
}
