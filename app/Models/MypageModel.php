<?php

namespace App\Models;

use PDO;
use App\Models\InterfaceModel;

class MypageModel implements InterfaceModel
{
 protected $table_name;
 protected $sort;

 function dbConnect()
 {
  try {
   $db = new PDO(
    'pgsql:host=db;dbname=offshoa_db;',
    'test_user',
    'secret'
   );
   //$db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
  } catch (PDOException $e) {
   echo $e . 'エラーです';
  }
  return $db;
 }

 function getAllData()
 {
  $db = $this->dbConnect();
  $sql = "SELECT * from $this->table_name order by id $this->sort";
  $stmt = $db->query($sql);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $this->sanitize($results);
  return $results;
  $db = null;
 }

 function getById(int $id)
 {
  $db = $this->dbConnect();
  $sql = "SELECT * from $this->table_name where id=:id";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $result = $this->sanitize($result);
  return $result;
 }

 function sanitize($inputs)
 {
  if (is_array($inputs)) {
   $_input = array();
   foreach ($inputs as $key => $val) {
    if (is_array($val)) {
     $key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
     $_input[$key] = $this->sanitize($val);
    } else {
     $key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
     $_input[$key] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
    }
   }
   return $_input;
  } else {
   return htmlspecialchars($inputs, ENT_QUOTES, 'UTF-8');
  }
 }

 public function setToken()
 {
  $toke_byte = openssl_random_pseudo_bytes(16);
  $csrf_token = bin2hex($toke_byte);
  // 生成したトークンをセッションに保存します
  $_SESSION['csrf_token'] = $csrf_token;
 }

 function empty_check($key, $name)
 {
  if (!empty($key[$name])) {
   print($key[$name]);
  }
 }

 public function queryPost($stmt)
 {
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $this->sanitize($results);
  var_dump($results);
 }
}
