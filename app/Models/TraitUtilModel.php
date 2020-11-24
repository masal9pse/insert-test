<?php

namespace App\Models;

use PDO;

trait TraitUtilModel
{
 protected $table_name;
 protected $sort;

 function dbConnect()
 {
  try {
   $db = new PDO('pgsql:dbname=offshoa_db;host=127.0.0.1;port=5432;', 'yamamotohiroto', '');
   //echo '接続成功です';
  } catch (PDOException $e) {
   ini_set('display_errors', "On");
   echo $e . 'エラーです';
  }
  return $db;
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

 function auth_check($redirectPath)
 {
  if (!isset($_SESSION['name'])) {
   // ログインする前にそのページのurlを取得する
   $_SESSION['return'] = $_SERVER["REQUEST_URI"];
   header("Location: $redirectPath");
   exit();
  }
 }

 function empty_check($key, $name)
 {
  if (!empty($key[$name])) {
   print($key[$name]);
  }
 }

 protected function queryPost($stmt)
 {
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $this->sanitize($results);
  if (count($results) == 0) {
   echo '結果は0件です';
  }
  //var_dump($results);
  foreach ($results as $result) {
   //echo $result['title'];
   return $result['title'];
  }
 }
}
