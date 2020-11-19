<?php
require_once dirname(__FILE__) . '/../UtilClass.php';

class AuthClass extends UtilClass
{
 protected $table_name = 'users';
 protected $redirect = '../index.php';

 function login()
 {
  $db = $this->dbConnect();
  $sql = 'SELECT * from ' . $this->table_name . ' where name = :name';
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if (password_verify($_POST['password'], $row['password'])) {
   $this->sessionStore($row['id']);

   // クッキーに保存
   $this->cookieStore();

   // リダイレクト処理
   $this->getRedirect();
  }
 }

 private function getRedirect()
 {
  if (!empty($_SESSION['return'])) {
   $url = $_SESSION['return'];
   header("Location: $url");
   exit;
  } else {
   header("Location: $this->redirect");
   exit;
  }
 }

 protected function cookieStore()
 {
  // クッキーに保存
  setcookie('name', $_POST['name'], time() + 60 * 60 * 24 * 14);
  setcookie('password', $_POST['password'], time() + 60 * 60 * 24 * 14);
 }

 protected function sessionStore($row)
 {
  $_SESSION['name'] = $_POST['name'];
  $_SESSION['password'] = $_POST['password'];
  $_SESSION['auth_id'] = (int)$row;
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
   $name = $_POST['name'];
   $password = $_POST['password'];
   $password = password_hash($password, PASSWORD_DEFAULT);
   $sql = 'INSERT into ' . $this->table_name . '(name, password) values (?, ?)';
   $db = $this->dbConnect();
   $stmt = $db->prepare($sql);
   $stmt->execute(array($name, $password));
   $user_id = $db->lastinsertid();

   // データをクッキーに保存
   setcookie('name', $_POST['name'], time() + 60 * 60 * 24 * 14);
   setcookie('password', $_POST['password'], time() + 60 * 60 * 24 * 14);

   // セッションにログイン情報を保存
   $this->sessionStore($user_id);

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
  unset($_SESSION["name"]);
  unset($_SESSION["password"]);
  unset($_SESSION["auth_id"]);
  unset($_SESSION["return"]);

  (string)$session['auth_id'] = "名無しのごんべ";
  return $session;
 }

 private function duplicateCheck()
 {
  $db = $this->dbConnect();
  $stmt = $db->prepare('SELECT * FROM ' . $this->table_nane . ' WHERE name = :name limit 1');
  $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetch();
  return $result;
 }
}
