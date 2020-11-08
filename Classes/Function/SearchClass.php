<?php
require_once dirname(__FILE__) . '/../UtilClass.php';

class SearchClass extends UtilClass
{
  public function AllSearch()
  {
    if (!empty($_GET['tags'] && $_GET['search'] && $_GET['category'])) {
      $category_count = count($_GET['tags']);
      $where = [];
      $binds = [];
      foreach ($_GET['tags'] as $key =>  $tag) {
        $where[] = ":tag" . $key;
        $binds[":tag" . $key] = $tag;
      }
      // explodeが使えるかチェック
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
      $db = $this->dbConnect();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
      foreach ($binds as $whereSql => $val) {
        $stmt->bindValue($whereSql, $val, PDO::PARAM_STR);
      }
      $stmt->bindValue(':title', "%{$_GET['search']}%", PDO::PARAM_STR);
      $stmt->bindValue(':detail', "%{$_GET['search']}%", PDO::PARAM_STR);
      $stmt->bindValue(':category_count', $category_count, PDO::PARAM_INT);
      $this->queryPost($stmt);
    }
  }

  // tagとカテゴリーの絞り込み検索
  public function tagCategorySearch()
  {
    if (!empty($_GET['tags'] && $_GET['category']) && empty($_GET['search'])) {
      $where = [];
      $binds = [];
      foreach ($_GET['tags'] as $key =>  $tag) {
        $where[] = ":tag" . $key;
        $binds[":tag" . $key] = $tag;
      }
      $whereSql = implode(' , ', $where);
      var_dump($whereSql);
      $sql = "SELECT distinct posts.*
   FROM posts
    INNER JOIN post_category
    ON posts.id = post_category.post_id
    LEFT JOIN categories
    ON categories.id = post_category.category_id
    JOIN post_tag
    ON posts.id = post_tag.post_id
    JOIN tags
    ON post_tag.tag_id = tags.id
   WHERE  categories.category = :category
    AND tags.tag IN ($whereSql)";

      var_dump($sql);
      $db = $this->dbConnect();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
      // タグ検索
      foreach ($binds as $whereSql => $val) {
        $stmt->bindValue($whereSql, $val, PDO::PARAM_STR);
      }
      $this->queryPost($stmt);
    }
  }


  public function tagTextSearch()
  {
    if (!empty($_GET['tags'] && $_GET['search']) && empty($_GET['category'])) {
      $first_sql = "SELECT p.*
  FROM post_tag pt, posts p, tags t
  WHERE pt.tag_id = t.id
   AND (t.tag IN (";

      $second_sql = "AND p.id = pt.post_id
   AND p.title LIKE :title
   OR p.detail LIKE :detail
  GROUP BY p.id
  HAVING COUNT( p.id )= ";

      $where = [];
      $binds = [];
      foreach ($_GET['tags'] as $key =>  $tag) {
        $where[] = ":tag" . $key;
        $binds[":tag" . $key] = $tag;
      }
      //var_dump($where);
      //$whereSql = implode(' OR ', $where);
      $whereSql = implode(' , ', $where);
      $sql = $first_sql . $whereSql . '))' . ' ' .  $second_sql . ':category_count';
      //$sql .= $whereSql;
      var_dump($sql);
      $category_count = count($_GET['tags']);
      $db = $this->dbConnect();
      $stmt = $db->prepare($sql);
      foreach ($binds as $whereSql => $val) {
        $stmt->bindValue($whereSql, $val, PDO::PARAM_STR);
      }
      $stmt->bindValue(':title', "%{$_GET['search']}%", PDO::PARAM_STR);
      $stmt->bindValue(':detail', "%{$_GET['search']}%", PDO::PARAM_STR);
      $stmt->bindValue(':category_count', $category_count, PDO::PARAM_INT);
      $this->queryPost($stmt);
    }
  }

  public function tagSearch()
  {
    if (!empty($_GET['tags']) && empty($_GET['search']) && empty($_GET['category'])) {
      $first_sql = "SELECT distinct p.*
 FROM post_tag pt, posts p, tags t
 WHERE pt.tag_id = t.id
  AND (t.tag IN (";

      $second_sql = "AND p.id = pt.post_id";

      $where = [];
      $binds = [];
      foreach ($_GET['tags'] as $key =>  $tag) {
        $where[] = ":tag" . $key;
        $binds[":tag" . $key] = $tag;
      }
      //var_dump($where);
      //$whereSql = implode(' OR ', $where);
      $whereSql = implode(' , ', $where);
      $sql = $first_sql . $whereSql . '))' . ' ' .  $second_sql;
      //$sql .= $whereSql;
      var_dump($sql);
      $db = $this->dbConnect();
      $stmt = $db->prepare($sql);
      foreach ($binds as $key => $val) {
        $stmt->bindValue($key, $val, PDO::PARAM_STR);
      }
      $this->queryPost($stmt);
    }
  }

  //exit;
  // カテゴリーのみが入力されている条件
  public function categorySearch()
  {
    if (!empty($_GET['category'] && empty($_GET['search']) && empty($_GET['tags']))) {
      $sql = 'SELECT * FROM posts 
   LEFT JOIN post_category 
   ON posts.id = post_category.post_id
   LEFT JOIN categories
   ON categories.id = post_category.category_id
  WHERE categories.category = :category';

      var_dump($sql);
      $db = $this->dbConnect();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':category', $_GET["category"], PDO::PARAM_STR);
      $this->queryPost($stmt);
    }
  }

  //var_dump($stmt);
  //exit;
  public function textSearch()
  {
    if (!empty($_GET['search']) && empty($_GET['category']) && empty($_GET['tags'])) {
      //if (!empty($_GET['search'])) {
      $sql = 'SELECT * FROM posts 
   WHERE posts.title LIKE :title OR posts.detail LIKE :detail';
      $db = $this->dbConnect();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':title', '%' . $_GET["search"] . '%', PDO::PARAM_STR);
      $stmt->bindValue(':detail', '%' . $_GET["search"] . '%', PDO::PARAM_STR);
      $this->queryPost($stmt);
    }
  }

  public function categoryTextSearch()
  {
    if (!empty($_GET['category'] && $_GET['search']) && empty($_GET['tags'])) {
      $sql = 'SELECT distinct posts.* FROM posts 
   LEFT JOIN post_category 
   ON posts.id = post_category.post_id
   LEFT JOIN categories
   ON categories.id = post_category.category_id
  WHERE categories.category = :category
  AND (posts.title like :title 
  OR posts.detail like :detail)';
      var_dump($sql);
      $db = $this->dbConnect();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':category', $_GET['category'], PDO::PARAM_STR);
      $stmt->bindValue(':title', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
      $stmt->bindValue(':detail', '%' . $_GET['search'] . '%', PDO::PARAM_STR);
      //var_dump($stmt); 
      $this->queryPost($stmt);
    }
  }
  private function queryPost($stmt)
  {
    $stmt->execute();
    $search = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $search = $this->sanitize($search);
    var_dump($search);
  }

  public function AllNotSearch()
  {
    if (empty($_GET['search']) && empty($_GET['category']) && empty($_GET['tags'])) {
      echo '結果は０件です';
    }
  }
}
