<?php
require('dbconnect.php');
//var_dump($_GET);
//exit;
// まずはタグの検索オンリーで結果を取得したい。 => getをどう検索結果に加えるか
if (!empty($_GET['tags'])) {
 $sql = "SELECT * FROM posts LEFT JOIN post_tag ON posts.id = post_tag.post_id
 LEFT JOIN tags ON tags.id = post_tag.tag_id where ";

 //where tags.tag = :tags';
 $where = [];
 //$binds = [];
 foreach ($_GET['tags'] as $tag) {
  $where[] = "tags.tag='$tag'";
  //$binds[''] = $tag;
 }
 //var_dump($where);
 //$whereSql = implode(' OR ', $where);
 $whereSql = implode(' AND ', $where);
 $sql = $sql . $whereSql;
 //$sql .= $whereSql;
 var_dump($sql);
 $stmt = $db->query($sql);
 $tag_search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($tag_search);
 exit;
 //var_dump($whereSql);
 //$stmt->bindValue(':tags', $tag, PDO::PARAM_STR);
 //$stmt->execute();
 //$tag_searches[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
 //var_dump($tag_searches);
 foreach ($tag_searches as $tag_search) {
  //var_dump($tag_search);
  foreach ($tag_search as $result) {
   //var_dump($result);
   echo $result['title'] . ' ';
  }
 }
 exit;
}

if (!empty($_GET['category'] && empty($_GET['search']))) {
 $sql = 'SELECT * FROM posts LEFT JOIN post_category ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category';
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
 $sql = 'SELECT * FROM posts LEFT JOIN post_category ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category and posts.title like :title or posts.detail like :detail';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
 $stmt->bindValue(':title', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 $stmt->bindValue(':detail', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 //var_dump($stmt);
 $stmt->execute();
 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($results);
}
