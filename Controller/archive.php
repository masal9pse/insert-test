<?php
//var_dump($_POST);
ini_set('display_errors', "On");
require('./Classes/Function/PostClass.php');

$post = new PostClass;
$post->postLogicalDelete($_POST['delete_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>アーカイブ</title>
</head>

<body>
 <p>アーカイブしました</p>
 <a href="./index.php">トップページ</a>
</body>

</html>