<?php
//ini_set('display_errors', "On");
require('dbconnect.php');

if (empty($_POST['title'])) {
 exit('タイトルを入力してください');
}
//var_dump($image);
//exit;
$db->beginTransaction();
try {
 postInsert($db, $_POST);
 postTagInsert($db, $_POST);
 echo '投稿に成功しました';
 echo "<img src=\" ./images/$image \">";
 echo '<p>' . $_POST['title'] . "のアップロードに成功しました</p>";
 echo "<a href='./insert_form.php'>投稿フォームへ</a>";
 $db->commit();
} catch (PDOException $e) {
 $db->rollBack();
 exit($e);
}
