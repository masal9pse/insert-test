<?php
require_once dirname(__FILE__) . '/../UtilClass.php';

abstract class AbstractAuthClass extends UtilClass
{
 // 練習用に無理やり抽象クラスを作成
 abstract public function getFollow($follower_id);

 function login()
 {
  $db = $this->dbConnect();

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

    // クッキーに保存
    setcookie('name', $_POST['name'], time() + 60 * 60 * 24 * 14);
    setcookie('password', $_POST['password'], time() + 60 * 60 * 24 * 14);

    if (!empty($_SESSION['return'])) {
     $url = $_SESSION['return'];
     header("Location: $url");
     exit;
    } else {
     header("Location: ../index.php"); // 戻るページがない場合、トップページへ
     exit;
    }
   }
  }
 }

 function signUp()
 {
  // 重複ユーザーのチェック
  $result = $this->duplicateCheck();
  if ($result > 0) {
   exit('重複しています');
  }

  // バリデーション
  if (empty($_POST['name'] && $_POST['password'])) {
   exit('未入力の箇所があります');
  }

  // サインアップ処理
  if (!empty($_POST['name'] && $_POST['password'])) {
   $_SESSION['name'] = $_POST['name'];
   $_SESSION['password'] = $_POST['password'];
   $name = $_SESSION['name'];
   $password = $_SESSION['password'];
   $password = password_hash($password, PASSWORD_DEFAULT);
   $sql = 'INSERT into users(name, password) values (?, ?)';
   $db = $this->dbConnect();
   $stmt = $db->prepare($sql);
   $stmt->execute(array($name, $password));
   $user_id = $db->lastinsertid();
   $_SESSION['auth_id'] = (int)$user_id;

   header('Location: ../index.php');
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

 private function duplicateCheck()
 {
  $db = $this->dbConnect();
  $stmt = $db->prepare('SELECT * FROM users WHERE name = :name limit 1');
  $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetch();
  return $result;
 }
}
