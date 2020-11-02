<?php
try {
 $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
} catch (PDOException $e) {
 echo $e . 'エラーです';
}

//alter table bbs_thread add foreign key (creator_id) references accounts_user(id);

// テーブル作成のSQLを作成
$sql = 'CREATE TABLE post_tag (
 id SERIAL NOT NULL,
 post_id INT ,
 tag_id INT,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY (id)
)';

$foreign_post_id_sql = 'ALTER table post_tag add foreign key (post_id) references posts(id)';
$foreign_tag_id_sql = 'ALTER table post_tag add foreign key (tag_id) references tags(id)';
// SQLを実行
$res = $db->query($sql);
$res2 = $db->query($foreign_post_id_sql);
$res3 = $db->query($foreign_tag_id_sql);
