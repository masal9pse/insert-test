<?php
ini_set('display_errors', "On");
session_start();
require_once dirname(__FILE__) . '/../Classes/UtilClass.php';
$util = new UtilClass;
//var_dump($_POST);
//exit();
$db = $util->dbConnect();
$stmt = $db->prepare('SELECT * FROM users WHERE name = :name limit 1');
$stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch();

if ($result > 0) {
 exit('重複しています');
}
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

 header('Location: ../index.php');
 exit();
}
