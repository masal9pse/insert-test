<?php
ini_set('display_errors', "On");
session_start();
require('../util.php');
$util = new Util;
//var_dump($_POST);
//exit();
if (empty($_POST['name'] && $_POST['password'])) {
 exit('未入力の箇所があります');
}

if (!empty($_POST['name'] && $_POST['password'])) {
 $_SESSION['name'] = $_POST['name'];
 $_SESSION['password'] = $_POST['password'];
 $name = $_SESSION['name'];
 $password = $_SESSION['password'];
 $password = password_hash($password, PASSWORD_DEFAULT);
 $sql = 'INSERT into users(name, password) values (?, ?)';
 $db = $util->dbConnect();
 $stmt = $db->prepare($sql);
 $stmt->execute(array($name, $password));
 $user_id = $db->lastinsertid();
 $_SESSION['auth_id'] = (int)$user_id;

 header('Location: ../list.php');
 exit();
}
