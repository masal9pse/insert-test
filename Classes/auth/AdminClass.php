<?php
require_once dirname(__FILE__) . '/./AuthClass.php';

class AdminClass extends AuthClass
{
 function adminLogin()
 {
  try {
   //var_dump($_POST);
   $db = $this->dbConnect();
   $sql = "SELECT * from admins where name = :name and password = :password";
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
   $stmt->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
   $stmt->execute();
   $result = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
   echo $e->getMessage();
  }
  var_dump($result);
  if (!isset($result['name'])) {
   exit('メールアドレス又はパスワードが間違っています。');
  }

  $_SESSION['admin'] = $_POST;
  header("Location: ./login.php"); // 戻るページがない場合、トップページへ
 }
 function adminLogout()
 {
  if (isset($_SESSION["admin"])) {
   echo 'Logoutしました。';
  } else {
   echo 'SessionがTimeoutしました。';
  }
  //セッション変数のクリア
  $_SESSION['admin'] = array();
  //セッションクッキーも削除   
  //セッションクリア
  @session_destroy();
 }
}
