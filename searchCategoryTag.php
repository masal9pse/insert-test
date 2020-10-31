<?php
require('dbconnect.php');
//var_dump(count($_GET['tags']));
//echo count($_GET['tags']);

// tagとカテゴリーの絞り込み検索
if (!empty($_GET['tags'] && $_GET['category']) && empty($_GET['search'])) {
 echo count($_GET['tags']);
 //exit;
 //if (!empty($_GET['tags'] && $_GET['category'])) {
 $where = [];
 $sql = "SELECT count(*), posts.*
 FROM posts
  LEFT JOIN post_category
  ON posts.id = post_category.post_id
  LEFT JOIN categories
  ON categories.id = post_category.category_id
  JOIN post_tag
  ON posts.id = post_tag.post_id
  JOIN tags
  ON post_tag.tag_id = tags.id
 WHERE  categories.category = '{$_GET['category']}'
  AND tags.tag IN ($where)  
 GROUP BY posts.id
 HAVING COUNT(posts.id) = count({$_GET['tags']})";

 foreach ($_GET['tags'] as $tag) {
  $where[] = "'$tag'";
 }
 var_dump($sql);
 $stmt = $db->query($sql);
 $tag_search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($tag_search);
 //exit;
}

// tag,category,searchの絞り込み検索
if (!empty($_GET['tags'] && $_GET['search'] && $_GET['category'])) {
 //if (!empty($_GET['tags'] && $_GET['category'])) {
 $sql = "SELECT count(*), posts.*
 FROM posts
  LEFT JOIN post_category
  ON posts.id = post_category.post_id
  LEFT JOIN categories
  ON categories.id = post_category.category_id
  JOIN post_tag
  ON posts.id = post_tag.post_id
  JOIN tags
  ON post_tag.tag_id = tags.id
 WHERE  categories.category = 'アニメ'
  AND tags.tag IN ('感動できる','面白い')
  AND posts.title like '%N%' or posts.detail like '%N%'
 GROUP BY posts.id
 HAVING COUNT(posts.id) = 2";
 var_dump($sql);
 $stmt = $db->query($sql);
 $tag_search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($tag_search);
 //exit;
}

if (!empty($_GET['tags'] && $_GET['search']) && empty($_GET['category'])) {
 $first_sql = "SELECT p.*
FROM post_tag pt, posts p, tags t
WHERE pt.tag_id = t.id
 AND (t.tag IN (";

 $second_sql = "AND p.id = pt.post_id
 AND p.title LIKE '%{$_GET['search']}%' or p.detail LIKE '%{$_GET['search']}%'
GROUP BY p.id
HAVING COUNT( p.id )= ";

 $where = [];
 //$binds = [];
 foreach ($_GET['tags'] as $tag) {
  $where[] = "'$tag'";
  //$binds[''] = $tag;
 }
 //var_dump($where);
 //$whereSql = implode(' OR ', $where);
 $whereSql = implode(' , ', $where);
 $sql = $first_sql . $whereSql . '))' . ' ' .  $second_sql . count($_GET['tags']);
 //$sql .= $whereSql;
 var_dump($sql);
 $stmt = $db->query($sql);
 $tag_search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($tag_search);
}

if (!empty($_GET['tags']) && empty($_GET['search']) && empty($_GET['tags'])) {
 $first_sql = "SELECT p.*
FROM post_tag pt, posts p, tags t
WHERE pt.tag_id = t.id
 AND (t.tag IN (";

 $second_sql = "AND p.id = pt.post_id
GROUP BY p.id
HAVING COUNT( p.id )= ";

 //where tags.tag='面白い' OR tags.tag='感動できる

 //where tags.tag = :tags';
 $where = [];
 //$binds = [];
 foreach ($_GET['tags'] as $tag) {
  $where[] = "'$tag'";
  //$binds[''] = $tag;
 }
 //var_dump($where);
 //$whereSql = implode(' OR ', $where);
 $whereSql = implode(' , ', $where);
 $sql = $first_sql . $whereSql . '))' . ' ' .  $second_sql . count($_GET['tags']);
 //$sql .= $whereSql;
 var_dump($sql);
 $stmt = $db->query($sql);
 $tag_search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($tag_search);
}
//exit;
if (!empty($_GET['category'] && empty($_GET['search']) && empty($_GET['tags']))) {
 $sql = 'SELECT * FROM posts LEFT JOIN post_category ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET["category"], PDO::PARAM_STR);
 $stmt->execute();
 var_dump($sql);
 $search2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search2);
}
//var_dump($stmt);
//exit;
if (!empty($_GET['search']) && empty($_GET['category']) && empty($_GET['tags'])) {
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

if (!empty($_GET['category'] && $_GET['search']) && empty($_GET['tags'])) {
 $sql = 'SELECT * FROM posts LEFT JOIN post_category ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category and posts.title like :title or posts.detail like :detail';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
 $stmt->bindValue(':title', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 $stmt->bindValue(':detail', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 var_dump($stmt);
 $stmt->execute();
 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($results);
}
