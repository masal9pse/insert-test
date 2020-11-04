<?php
try {
 $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
} catch (PDOException $e) {
 echo $e . 'エラーです';
}

// テーブル作成のSQLを作成
$sql = 'CREATE TABLE posts (
 id SERIAL NOT NULL,
 title VARCHAR(255),
 detail VARCHAR(255),
 image VARCHAR(255),
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY (id)
)';

$add_sql = 'ALTER TABLE posts ADD user_id INT';
$add_like_count_column = 'ALTER TABLE posts ADD like_count INT';



// SQLを実行
$res = $db->query($sql);
$add_columd_res = $db->query($add_sql);
$add_like_count_column_res = $db->query($add_like_count_column);
