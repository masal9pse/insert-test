<?php
try {
 $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
} catch (PDOException $e) {
 echo $e . 'エラーです';
}

// テーブル作成のSQLを作
$sql = 'CREATE TABLE if not exists tags (
 id SERIAL NOT NULL,
 tag VARCHAR(255) NOT NULL, 
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY (id)
)';

// SQLを実行
$res = $db->query($sql);
