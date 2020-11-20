<?php
try {
 $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
} catch (PDOException $e) {
 echo $e . 'エラーです';
}

$sql = 'CREATE TABLE admins (
 id SERIAL NOT NULL,
 name VARCHAR(255) NOT NULL, 
 password VARCHAR(255),
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY (id)
)';

// SQLを実行
$res = $db->query($sql);
