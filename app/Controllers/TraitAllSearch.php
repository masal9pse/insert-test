<?php

namespace App\Controllers;

use PDO;

trait TraitAllSearch
{
 public function AllSearch()
 {
  list($tag_binds, $whereSql) = $this->tagWhere();
  // explodeが使えるかチェック
  //var_dump($whereSql);
  $sql = "SELECT distinct posts.*
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
              AND (posts.title like :title OR posts.detail like :detail )";

  //var_dump($sql);
  // dbconnectをコメントアウトしてもエラーにならなかった
  $db = $this->dbConnect();
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);

  // タグ検索 $tag_bindsのキーと$whereSqlは同じ
  $this->tagBinds($tag_binds, $stmt);

  $stmt->bindValue(':title', "%{$_GET['search']}%", PDO::PARAM_STR);
  $stmt->bindValue(':detail', "%{$_GET['search']}%", PDO::PARAM_STR);
  $this->queryPost($stmt);
 }
}
