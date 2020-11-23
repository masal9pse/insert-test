<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Controllers\UtilController;
use PDO;

class AuthController extends UtilController
{
 public function login()
 {
  $model = new AuthModel;
  $duble = $this->duplicateCheck();

  if ((int)$duble === 0) {
   exit('パスワードかユーザー名が間違っています');
  }

  $row = false;

  try {
   $db = $this->dbConnect();
   $sql = 'SELECT * from ' . $model->table_name . ' where name = :name';
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
   $stmt->execute();
   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if (password_verify($_POST['password'], $row['password'])) {
    $model->sessionStore($row['id']);

    // クッキーに保存
    $model->cookieStore();

    // リダイレクト処理
    $model->getRedirect();
   }
  } catch (\Exception $e) {
   return $row;
  }
 }

 function signUp()
 {
  // 重複ユーザーのチェック
  $result = $this->duplicateCheck();
  if ($result > 0) {
   exit('重複しています');
  }
  $model = new AuthModel;
  $result = false;

  try {
   $name = $_POST['name'];
   $password = $_POST['password'];
   $password = password_hash($password, PASSWORD_DEFAULT);
   $sql = 'INSERT into ' . $model->table_name . '(name, password) values (?, ?)';
   $db = $this->dbConnect();
   $stmt = $db->prepare($sql);
   $result =  $stmt->execute(array($name, $password));
   $user_id = $db->lastinsertid();

   // データをクッキーに保存
   $model->cookieStore();

   // セッションにログイン情報を保存
   $model->sessionStore($user_id);

   $model->getRedirect();
  } catch (\Exception $e) {
   return $result;
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

 protected function duplicateCheck()
 {
  $model = new AuthModel;
  $db = $this->dbConnect();
  $stmt = $db->prepare('SELECT * FROM ' . $model->table_name . ' WHERE name = :name limit 1');
  $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
  $stmt->execute();

  $result = $stmt->fetch();
  return $result;
 }
}
