<?php
session_start();
//include('../dbconnect.php');
//$db = dbConnect();
function logout($session, $php_file)
{
 if (isset($session)) {
  header("Location: $php_file");
 }
 //セッション変数のクリア
 $session = array();

 //セッションクリア
 session_destroy();
 return $session;
}
//$params = [
// $_SESSION['id'],
// $_SESSION['name'],
// $_SESSION['password']
//];
logout($_SESSION, './signup_form.php');
