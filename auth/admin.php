<?php
session_start();
ini_set('display_errors', "On");
require_once dirname(__FILE__) . '/../Classes/auth/AdminClass.php';

//var_dump($_SESSION);
$admin = new AdminClass();
$post = $admin->sanitize($_POST);

$err = [];
if (!$name = filter_input(INPUT_POST, 'name')) {
 $err[] = "ユーザー名を入力してください";
}

$password = filter_input(INPUT_POST, 'password');
if (!preg_match("/\A[a-z\d]{7,100}+\z/i", $password)) {
 $err[] = 'パスワードは英数字8文字以上100文字以内にしてください';
}

if (count($err) === 0) {
 $admin->login();
}

if (count($err) > 0) {
 foreach ($err as $e) {
  echo $e;
 }
}
