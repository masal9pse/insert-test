<?php

namespace App\Controllers;

use App\Controllers\AuthController;

final class AdminController extends AuthController
{

 protected $table_name = 'admins';
 protected $redirect = '../auth/admin_user.php';

 protected function cookieStore()
 {
  // クッキーに保存
  setcookie('admin_name', $_POST['name'], time() + 60 * 60 * 24 * 14);
  setcookie('admin_password', $_POST['password'], time() + 60 * 60 * 24 * 14);
 }

 protected function sessionStore($row)
 {
  $_SESSION['admin_name'] = $_POST['name'];
  $_SESSION['admin_password'] = $_POST['password'];
  $_SESSION['admin_id'] = $row['id'];
 }

 function adminLogout()
 {
  if (isset($_SESSION["admin_name"])) {
   echo 'Logoutしました。';
  } else {
   echo 'SessionがTimeoutしました。';
  }
  //セッション変数のクリア
  unset($_SESSION["admin_name"]);
  unset($_SESSION["admin_password"]);
  unset($_SESSION["admin_id"]);
 }

 function admin_check($redirectPath)
 {
  if (!isset($_SESSION['admin_name'])) {
   // ログインする前にそのページのurlを取得する
   $_SESSION['return'] = $_SERVER["REQUEST_URI"];
   header("Location: $redirectPath");
   exit();
  }
 }
}
