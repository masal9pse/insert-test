<?php
//https://itsakura.com/php_session
session_start(); //セッションを開始

if (!isset($_SESSION["count1"])) { //issetでセッションを確認
 $rec = "初回表示時";
 $_SESSION["count1"] = 1; //セッションにkeyとvalueをセット

} else {
 $rec = $_SESSION["count1"]++; //再アクセス時はcount1に1加算
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
 <meta charset="utf-8">
 <title>sessionのサンプル</title>
</head>

<body>
 <?= ($rec) ?>
</body>

</html>