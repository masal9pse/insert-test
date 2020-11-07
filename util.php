<?php

class Util
{
 protected $table_name;

 function dbConnect()
 {
  try {
   ini_set('display_errors', "On");
   $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
   //echo '接続成功です';
  } catch (PDOException $e) {
   ini_set('display_errors', "On");
   echo $e . 'エラーです';
  }
  return $db;
 }

 function getAllData()
 {
  $db = $this->dbConnect();
  $sql = "SELECT * from $this->table_name order by id desc";
  $stmt = $db->query($sql);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $this->sanitize($results);
  return $results;
  $db = null;
 }

 function getById(int $id)
 {
  $db = dbConnect();
  $sql = "SELECT * from $this->table_name where id=:id";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $result = sanitize($result);
  return $result;
 }

 // 記事投稿
 function postInsert($post)
 {
  $db = dbConnect();
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
 function postTagInsert($tags)
 {
  $db = dbConnect();
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
     $_input[$key] = $this->sanitize($val);
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
 function postUpdate($post)
 {
  $db = dbConnect();
  $result = getById($post['id']);
  //exit;
  $new_sql = 'UPDATE posts SET title=:title,detail=:detail,image=:image,created_at=now(),updated_at=now(),user_id=:user_id where id=:id';
  $new_image = uniqid(mt_rand(), true); //ファイル名をユニーク化
  //var_dump($new_image);
  $new_image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
  $new_stmt = $db->prepare($new_sql);
  $new_stmt->bindValue(':title', $post['title'], PDO::PARAM_STR);
  $new_stmt->bindValue(':detail', $post['detail'], PDO::PARAM_STR);
  $new_stmt->bindValue(':image', $new_image, PDO::PARAM_STR);
  $new_stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
  $new_stmt->bindValue(':id', $post['id'], PDO::PARAM_INT);
  if (!empty($_FILES['image']['name'])) {
   unlink('./images/' . $result['image']);
   move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $new_image);
  }
  $new_stmt->execute();
 }

 function login(string $err_msg)
 {
  $db = dbConnect();
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
    $_SESSION['auth_id'] = $row['id'];
    if (!empty($_SESSION['return'])) {
     $url = $_SESSION['return'];
     header("Location: $url");
     exit;
    } else {
     header("Location: ../list.php"); // 戻るページがない場合、トップページへ
     exit;
    }
   } else {
    echo '<p>' . $err_msg . '</p>';
   }
  }
 }

 function auth_check($redirectPath)
 {
  if (!isset($_SESSION['name'])) {
   // ログインする前にそのページのurlを取得する
   $_SESSION['return'] = $_SERVER["REQUEST_URI"];
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
  (string)$session['auth_id'] = "名無しのごんべ";
  return $session;
 }

 function empty_check($key, $name)
 {
  if (!empty($key[$name])) {
   print($key[$name]);
  }
 }
 // いいねしているか判定する
 function isLike($post_id, $user_id)
 {
  try {
   $db = $this->dbConnect();
   $sql = 'SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
   $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
   $stmt->execute();
   $results = $stmt->fetchAll();
   //var_dump($results);
   return $results;
   //return true;
  } catch (Exception $e) {
   error_log('エラー発生:' . $e->getMessage());
  }
 }
 // いいねのカウント数を数える
 function getLike($post_id)
 {
  try {
   $db = dbConnect();
   $sql = 'SELECT * FROM likes WHERE post_id = :post_id';
   $stmt = $db->prepare($sql);
   // クエリ実行
   $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
   $stmt->execute();

   if ($stmt) {
    return $stmt->fetchAll();
   } else {
    return false;
   }
  } catch (Exception $e) {
   exit('エラー発生：' . $e->getMessage());
  }
 }

 function myPageList()
 {
  $db = dbConnect();
  $sql = 'SELECT posts.* from posts 
 inner join users 
 on posts.user_id = users.id
 where users.id=:user_id';

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':user_id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // 基本テキストフォームはないのでXSS対策はやる必要ないかも
  $results = sanitize($results);
  //var_dump($results);
  return $results;
 }
}
