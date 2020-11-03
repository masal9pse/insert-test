<?php
function dbConnect()
{
 try {
  //ini_set('display_errors', "On");
  $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
  //echo '接続成功です';
 } catch (PDOException $e) {
  echo $e . 'エラーです';
 }
 return $db;
}
