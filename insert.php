<?php
ini_set('display_errors', "On");
session_start();
var_dump($_POST);
//exit;
include('util.php');
$util = new Util;
$db = $util->dbConnect();

if (empty($_POST['title'])) {
 exit('タイトルを入力してください');
}

$db->beginTransaction();
try {
 postInsert($_POST);
 postTagInsert($_POST);

 echo '投稿に成功しました';
 // 空の場合
 echo "<a href='./insert_form.php'>投稿フォームへ</a>";
 $db->commit();
} catch (PDOException $e) {
 $db->rollBack();
 exit($e);
}
