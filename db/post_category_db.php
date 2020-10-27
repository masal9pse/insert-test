<?php
try {
 $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
} catch (PDOException $e) {
 echo $e . 'エラーです';
}

// テーブル作成のSQLを作成
$sql = 'CREATE TABLE post_category (
 id SERIAL NOT NULL,
 post_id INT,
 category_id INT,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY (id)
)';

// SQLを実行
$res = $db->query($sql);
