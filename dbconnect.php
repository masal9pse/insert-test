<?php
try {
 //ini_set('display_errors', "On");
 $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
 //echo '接続成功です';
} catch (PDOException $e) {
 echo $e . 'エラーです';
}

// 記事投稿
function postInsert($db, $post)
{
 $sql = 'INSERT INTO posts(title,detail,image,created_at,updated_at) VALUES (:title,:detail,:image,now(),now())';
 $image = uniqid(mt_rand(), true); //ファイル名をユニーク化
 $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':image', $image, PDO::PARAM_STR);
 $stmt->bindValue(':title', $post['title'], PDO::PARAM_STR);
 $stmt->bindValue(':detail', $post['detail'], PDO::PARAM_STR);
 if (!empty($_FILES['image']['name'])) { //ファイルが選択されていれば$imageにファイル名を代入
  move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);
 }
 $stmt->execute();
}

function postTagInsert($db, $tags)
{
 $sql = "INSERT INTO post_tag(post_id,tag_id) VALUES (:post_id,:tag_id)";
 $now_post_insert_id = $db->lastInsertId();
 var_dump($now_post_insert_id);
 foreach ($tags['tags'] as $tag_num) {
  $tag_stmt = $db->prepare($sql);
  //var_dump($tag_num);
  $tag_stmt->bindValue(':post_id', $now_post_insert_id, PDO::PARAM_INT);
  $tag_stmt->bindValue(':tag_id', $tag_num, PDO::PARAM_INT);
  $tag_stmt->execute();
 }
}
