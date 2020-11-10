<?php
ini_set('display_errors', "On");
try {
 $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
} catch (PDOException $e) {
 echo $e . 'エラーです';
}

//alter table bbs_thread add foreign key (creator_id) references accounts_user(id);

// テーブル作成のSQLを作成
$sql = 'CREATE TABLE follows (
 id SERIAL NOT NULL primary key, 
 follow_id INT not null references  users(id) ON DELETE CASCADE ON Update CASCADE,
 follower_id INT not null references posts(id) ON DELETE CASCADE ON Update CASCADE,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 UNIQUE(follow_id, follower_id))';
// バルクインサートで値を挿入
$insert_sql = 'INSERT INTO follows values (1,2,3),(2,3,1),(3,10,11)';
// SQLを実行
$res = $db->query($sql);
$inser_res = $db->query($insert_sql);
