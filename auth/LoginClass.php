<?php
require('../util.php');

class LoginClass extends Util
{
 function login(string $err_msg)
 {
  $db = $this->dbConnect();
  if (isset($_POST['login'])) {
   // echo $password; // これ付けたら処理が止まった。
   $sql = 'SELECT * from users where name = :name';
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
   $stmt->execute();
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   // var_dump($password);
   //exit;
   if (password_verify($_POST['password'], $row['password'])) {
    //echo '認証成功';
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['auth_id'] = $row['id'];
    if (!empty($_SESSION['return'])) {
     $url = $_SESSION['return'];
     header("Location: $url");
     exit;
    } else {
     header("Location: ../list.php"); // 戻るページがない場合、トップページへ
     exit;
    }
   } else {
    echo '<p>' . $err_msg . '</p>';
   }
  }
 }
}
