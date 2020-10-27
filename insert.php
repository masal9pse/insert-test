<?php
var_dump($_POST);
?>
<html>

<body>
 <form action="" method="post">
  <!--ファイル、methodの指定-->
  <table border="1">
   <tr>
    <td>タイトル</td>
    <td><input type="text" name="title" required></td>
    <!--名前の入力フォーム作成-->
    <td>本文</td>
    <td><input type="text" name="detail" required></td>
    <!--コメント入力フォーム作成-->
    <td>画像</td>
    <td><input type="text" name="image" required></td>
    <!--パスワード入力フォーム作成-->
    <td colspan="2" align="center">
     <input type="submit" value="送信">
     <!--送信ボタン作成-->
   </tr>
  </table>
 </form>
</body>

</html>