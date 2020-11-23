<?php
//final class UtilClass => 別のクラスに継承されているのでfinalは使えない
class UtilClass
{
 protected $table_name;
 protected $sort;
 protected $where;
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

 function getAllData(): array
 {
  $db = $this->dbConnect();
  $sql = "SELECT * from $this->table_name order by id $this->sort";
  $stmt = $db->query($sql);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $this->sanitize($results);
  return $results;
  $db = null;
 }

 //function getById(int $id): int // err
 function getById(int $id): array
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

 /**
  * @param void
  * @return string $csrf_token
  */
 public function setToken()
 {
  if (!isset($_SESSION)) {
   session_start();
  }
  $csrf_token = bin2hex(random_bytes(32));
  $_SESSION['csrf_token'] = $csrf_token;

  return $csrf_token;
 }

 function auth_check(string $redirectPath)
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

 // あとで返り値から呼び出すように変更する
 protected function queryPost($stmt)
 {
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $this->sanitize($results);
  var_dump($results);
 }

 // staticキーワード内で、staticキーワードでないメソッドを呼ぶことはできない
 public static function searchFormStatic()
 {
  return '検索フォーム';
 }
}
