<?php
try {
 $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
 //echo '接続成功です';
} catch (PDOException $e) {
 echo $e . 'エラーです';
}

//// テーブル作成のSQLを作成
//$sql = 'CREATE TABLE posts (
// id SERIAL NOT NULL,
// title VARCHAR(255) NOT NULL,
// detail VARCHAR(10000) NOT NULL,
// image VARCHAR(255) NOT NULL,
// created_at TIMESTAMP,
// updated_at TIMESTAMP,
// PRIMARY KEY (id)
//)';

//// SQLを実行
//$res = $db->query($sql);
