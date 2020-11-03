<?php
function getAllData($db, $table_name)
{
 $sql = "SELECT * from  {$table_name}";
 $stmt = $db->query($sql);
 $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
 $results = sanitize($results);
 return $results;
 $db = null;
}

function getById($db, $id)
{
 $sql = 'SELECT * from posts where id=:id';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':id', $id, PDO::PARAM_INT);
 $stmt->execute();
 $result = $stmt->fetch(PDO::FETCH_ASSOC);
 $result = sanitize($result);
 return $result;
}

// 記事投稿
function postInsert($db, $post)
{
 $sql = 'INSERT INTO posts(title,detail,image,created_at,updated_at,user_id) VALUES (:title,:detail,:image,now(),now(),:user_id)';
 $image = uniqid(mt_rand(), true);
 $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':image', $image, PDO::PARAM_STR);
 $stmt->bindValue(':title', $post['title'], PDO::PARAM_STR);
 $stmt->bindValue(':detail', $post['detail'], PDO::PARAM_STR);
 $stmt->bindValue(':user_id', $post['user_id'], PDO::PARAM_STR);
 if (!empty($_FILES['image']['name'])) {
  move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);
  echo "<img src=\" ./images/$image \">";
 }
 $stmt->execute();
 echo '<p>' . $post['title'] . "のアップロードに成功しました</p>";
}

// 記事に紐づいたタグを中間テーブルにインサート
function postTagInsert($db, $tags)
{
 $sql = "INSERT INTO post_tag(post_id,tag_id) VALUES (:post_id,:tag_id)";
 $now_post_insert_id = $db->lastInsertId();
 var_dump($now_post_insert_id);
 foreach ($tags['tags'] as $tag_num) {
  $tag_stmt = $db->prepare($sql);
  //var_dump($tag_num);
  $tag_stmt->bindValue(':post_id', $now_post_insert_id, PDO::PARAM_INT);
  $tag_stmt->bindValue(':tag_id', $tag_num, PDO::PARAM_INT);
  $tag_stmt->execute();
 }
}

function sanitize($inputs)
{
 if (is_array($inputs)) {
  $_input = array();
  foreach ($inputs as $key => $val) {
   if (is_array($val)) {
    $key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
    $_input[$key] = sanitize($val);
   } else {
    $key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
    $_input[$key] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
   }
  }
  return $_input;
 } else {
  return htmlspecialchars($inputs, ENT_QUOTES, 'UTF-8');
 }
}

// 記事更新
function postUpdate($db, $post)
{
 $result = getById($db, $_GET['id']);
 //exit;
 $new_sql = 'UPDATE posts SET title=:title,detail=:detail,image=:image,created_at=now(),updated_at=now() where id=:id';
 $new_image = uniqid(mt_rand(), true); //ファイル名をユニーク化
 //var_dump($new_image);
 $new_image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
 $new_stmt = $db->prepare($new_sql);
 $new_stmt->bindValue(':title', $post['title'], PDO::PARAM_STR);
 $new_stmt->bindValue(':detail', $post['detail'], PDO::PARAM_STR);
 $new_stmt->bindValue(':image', $new_image, PDO::PARAM_STR);
 $new_stmt->bindValue(':id', $post['id'], PDO::PARAM_INT);
 if (!empty($_FILES['image']['name'])) {
  unlink('./images/' . $result['image']);
  move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $new_image);
 }
 $new_stmt->execute();
}

function login($db, $err_msg)
{
 if (isset($_POST['login'])) {
  // echo $password; // これ付けたら処理が止まった。
  $sql = 'SELECT * from users where name = :name';
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($password);
  //exit;
  if (password_verify($_POST['password'], $row['password'])) {
   //echo '認証成功';
   $_SESSION['name'] = $_POST['name'];
   $_SESSION['password'] = $_POST['password'];
   $_SESSION['id'] = $row['id'];
   header("Location: ../list.php");
  } else {
   echo '<p>' . $err_msg . '</p>';
  }
  //return false;
 }
}

function auth_check($redirectPath)
{
 if (!isset($_SESSION['name'])) {
  // if (empty($_SESSION['join'])) {
  header("Location: $redirectPath");
  exit();
 }
}

function logout($session, $php_file)
{
 if (isset($session)) {
  header("Location: $php_file");
 }
 //セッション変数のクリア
 $session = array();

 //セッションクリア
 session_destroy();
 return $session;
}
