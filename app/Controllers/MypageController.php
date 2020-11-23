<?php

namespace App\Controllers;

use PDO;
use App\Models\MypageModel;

class MypageController
{
 protected $table_name = "users";
 protected $sort = "asc";

 public function myPageList()
 {
  $model = new MypageModel;
  $db = $model->dbConnect();
  $sql = 'SELECT posts.* from posts 
          inner join users 
          on posts.user_id = users.id
          where posts.delete_flag = 0 and users.id=:user_id';

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':user_id', $_SESSION['auth_id'], PDO::PARAM_INT);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $results = $model->sanitize($results);
  return $results;
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
}
