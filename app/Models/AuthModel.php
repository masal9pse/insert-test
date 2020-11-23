<?php

namespace App\Models;

class AuthModel
{
 // AuthControllerに継承していないので、インスタンス化する。 => protectedやprivateは使えない
 public $table_name = 'users';
 public $redirect = '../views/index.php';

 public function getRedirect()
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

 public function cookieStore()
 {
  // クッキーに保存
  setcookie('name', $_POST['name'], time() + 60 * 60 * 24 * 14);
  setcookie('password', $_POST['password'], time() + 60 * 60 * 24 * 14);
 }

 public function sessionStore($row)
 {
  $_SESSION['name'] = $_POST['name'];
  $_SESSION['password'] = $_POST['password'];
  $_SESSION['auth_id'] = (int)$row;
 }
}
