<?php
session_start();
require('../util.php');
//$db = dbConnect();
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
 $db = dbConnect();
 $stmt = $db->prepare($sql);
 $stmt->execute(array($name, $password));
 $user_id = $db->lastinsertid();
 $_SESSION['auth_id'] = (int)$user_id;

 header('Location: ../list.php');
 exit();
}
