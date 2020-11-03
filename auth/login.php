<?php
session_start();
require('../dbconnect.php');
require('../util.php');
$err_msg = "";
$db = dbConnect();
login($db, $err_msg);

if (isset($_POST['name'], $_POST['password'])) {
 $err_msg = '未入力の項目があります。';
}
if (isset($_COOKIE['name'], $_COOKIE['password'])) {
 $name = $_COOKIE['name'];
 $password = $_COOKIE['password'];
}
?>
<html>

<head>
 <title>ログイン</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<div class="container mt-5">

 <body>
  <form action="" method="post">
   <?php if ($err_msg !== null && $err_msg !== '') {
    echo $err_msg . "<br>";
   } ?>
   名前<input type="text" name="name" value="<?php print(htmlspecialchars($name, ENT_QUOTES)); ?>"><br />
   パスワード<input type="text" name="password" value="<?php print(htmlspecialchars($password, ENT_QUOTES)); ?>"><br />
   <dd>

    <input id="save" type="checkbox" name="save" value="on">
    <label for="save">次回からは自動的にログインする</label>
   </dd>
   <button type="submit" name="login" class="btn btn-success">ログイン</button>
  </form>
  <button type="button" onclick="location.href='./register_form.php'">新規登録画面へ</button>
 </body>
</div>

</html>