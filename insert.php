<?php
require('dbconnect.php');
var_dump($_FILES);
//$db->beginTransaction();
$image = uniqid(mt_rand(), true); //ファイル名をユニーク化
$image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
var_dump($image);
//exit;
$sql = 'INSERT INTO posts(title,detail,image,created_at,updated_at) VALUES (:title,:detail,:image,now(),now())';

try {
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
 $stmt->bindValue(':detail', $_POST['detail'], PDO::PARAM_STR);
 $stmt->bindValue(':image', $image, PDO::PARAM_STR);
 if (!empty($_FILES['image']['name'])) { //ファイルが選択されていれば$imageにファイル名を代入
  move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);
 }
 $stmt->execute();
 echo '投稿に成功しました';
 echo "<img src=\" ./images/$image \">";
 echo '<p>' . $_POST['title'] . "のアップロードに成功しました</p>";
 echo "<a href='./insert_form.html'>投稿フォームへ</a>";
} catch (PDOException $e) {
 echo $e;
}
