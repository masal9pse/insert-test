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
   $_SESSION['admin'] = $_POST;
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

  //header("Location: /../../auth/admin_user.php"); // 戻るページがない場合、トップページへ
  header("Location: ../auth/admin_user.php"); // 戻るページがない場合、トップページへ
 }

 function adminLogout()
 {
  if (isset($_SESSION["admin"])) {
   echo 'Logoutしました。';
  } else {
   echo 'SessionがTimeoutしました。';
  }
  //セッション変数のクリア
  //$_SESSION['admin'] = array();
  unset($_SESSION["admin"]);
 }

 function admin_check($redirectPath)
 {
  if (!isset($_SESSION['admin'])) {
   // ログインする前にそのページのurlを取得する
   $_SESSION['return'] = $_SERVER["REQUEST_URI"];
   header("Location: $redirectPath");
   exit();
  }
 }
}
