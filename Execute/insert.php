<?php
ini_set('display_errors', "On");
session_start();
var_dump($_POST);
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\PostController;

$post = new PostController;

if (empty($_POST['title'])) {
 exit('タイトルを入力してください');
}

$db = $post->dbConnect();
$db->beginTransaction();
try {
 $post->postInsert($_POST);
 $post->postTagInsert($_POST);
 if (!empty($_POST['tags'])) {
 }
 echo '投稿に成功しました';
 // 空の場合
 echo "<a href='../views/insert_form.php'>投稿フォームへ</a>";
 $db->commit();
} catch (PDOException $e) {
 $db->rollBack();
 exit($e);
}
