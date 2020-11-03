<?php

?>
<!DOCTYPE html>
<html lang="ja">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
</head>

<body>
 <form action="signup.php" method="post">
  <!--<input type="hidden" name="id" value=""><br />-->
  名前<input type="text" name="name" value=""><br />
  パスワード<input type="text" name="password" value=""><br />
  <button type="submit">新規登録</button>
 </form>
 <button type="button" onclick="location.href='./login_form.php'">ログイン画面へ</button>
</body>

</html>
<html>