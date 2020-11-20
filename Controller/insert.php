<?php
ini_set('display_errors', "On");
session_start();
var_dump($_POST);
//exit;
require('./Classes/Function/PostClass.php');
$postInstance = new PostClass;
$db = $postInstance->dbConnect();

if (empty($_POST['title'])) {
 exit('タイトルを入力してください');
}

$db->beginTransaction();
try {
 $postInstance->postInsert($_POST);
 if (!empty($_POST['tags'])) {
  $postInstance->postTagInsert($_POST);
 }
 echo '投稿に成功しました';
 // 空の場合
 echo "<a href='./insert_form.php'>投稿フォームへ</a>";
 $db->commit();
} catch (PDOException $e) {
 $db->rollBack();
 exit($e);
}
