<?php
require('dbconnect.php');

// tag,category,searchの絞り込み検索 => インジェクション対策はこれから
if (!empty($_GET['tags'] && $_GET['search'] && $_GET['category'])) {
 $category_count = count($_GET['tags']);
 $where = [];
 $binds = [];
 foreach ($_GET['tags'] as $key =>  $tag) {
  $where[] = ":tag" . $key;
  $binds[":tag" . $key] = $tag;
 }
 //var_dump($where);
 //var_dump($binds);
 //exit;
 $whereSql = implode(' , ', $where);
 //var_dump($whereSql);
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
 WHERE  categories.category = :category
  AND tags.tag IN ($whereSql)  
  AND (posts.title like :title OR posts.detail like :detail )
 GROUP BY posts.id
 HAVING COUNT(posts.id) = :category_count";
 //{$_GET['category']}
 var_dump($sql);
 //$stmt = $db->query($sql);
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
 foreach ($binds as $whereSql => $val) {
  $stmt->bindValue($whereSql, $val, PDO::PARAM_STR);
 }
 $stmt->bindValue(':title', "%{$_GET['search']}%", PDO::PARAM_STR);
 $stmt->bindValue(':detail', "%{$_GET['search']}%", PDO::PARAM_STR);
 $stmt->bindValue(':category_count', $category_count, PDO::PARAM_INT);

 $stmt->execute();
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search);
 //exit;
}

// tagとカテゴリーの絞り込み検索
if (!empty($_GET['tags'] && $_GET['category']) && empty($_GET['search'])) {
 $category_count = count($_GET['tags']);
 $where = [];
 foreach ($_GET['tags'] as $tag) {
  $where[] = "'$tag'";
 }
 $whereSql = implode(' , ', $where);
 //var_dump($where);
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
  AND tags.tag IN ($whereSql)  
 GROUP BY posts.id
 HAVING COUNT(posts.id) = $category_count";

 //var_dump($sql);
 //$stmt = $db->query($sql);
 $stmt = $db->prepare($sql);
 $stmt->execute();
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search);
 //exit;
}

if (!empty($_GET['tags'] && $_GET['search']) && empty($_GET['category'])) {
 $first_sql = "SELECT p.*
FROM post_tag pt, posts p, tags t
WHERE pt.tag_id = t.id
 AND (t.tag IN (";

 $second_sql = "AND p.id = pt.post_id
 AND p.title LIKE '%{$_GET['search']}%' 
 OR p.detail LIKE '%{$_GET['search']}%'
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
 //var_dump($sql);
 //$stmt = $db->query($sql);
 $stmt = $db->prepare($sql);
 $stmt->execute();
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search);
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
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search);
}
//exit;
// カテゴリーのみが入力されている条件
if (!empty($_GET['category'] && empty($_GET['search']) && empty($_GET['tags']))) {
 $sql = 'SELECT * FROM posts 
 LEFT JOIN post_category 
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category';

 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET["category"], PDO::PARAM_STR);
 $stmt->execute();
 //var_dump($sql);
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search);
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
 //var_dump($stmt);
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search);
 //exit;
}

if (!empty($_GET['category'] && $_GET['search']) && empty($_GET['tags'])) {
 $sql = 'SELECT distinct posts.* FROM posts 
 LEFT JOIN post_category 
 ON posts.id = post_category.post_id
 LEFT JOIN categories
 ON categories.id = post_category.category_id
WHERE categories.category = :category 
AND (posts.title like :title 
OR posts.detail like :detail)';

 $stmt = $db->prepare($sql);
 $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
 $stmt->bindValue(':title', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 $stmt->bindValue(':detail', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
 //var_dump($stmt);
 $stmt->execute();
 $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
 var_dump($search);
}

//if (empty($_GET)) {
if (empty($_GET['search']) && empty($_GET['category']) && empty($_GET['tags'])) {
 echo '結果は０件です';
}
