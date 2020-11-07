<?php
ini_set('display_errors', "On");
session_start();
include('./Classes/Function/PostClass.php');
$postInstance = new PostClass();
$db = $postInstance->dbConnect();
//var_dump($_POST);
//var_dump($_FILES);
if (empty($_POST['title'])) {
 echo "<a href='./list.php'>一覧フォームへ</a>";
 exit('タイトルが未入力です');
}
//var_dump($new_image);
//exit;
try {
 $db->beginTransaction();
 $postInstance->postUpdate($_POST);
 $db->commit();
 echo '更新に成功しました';
} catch (PDOException $e) {
 $db->rollBack();
 echo $e . '更新できませんでした';
}
echo "<a href='./list.php'>一覧フォームへ</a>";
