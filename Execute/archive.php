<?php
session_start();
//var_dump($_POST);
//exit;
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\PostController;

$post = new PostController;
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
 <a href="../views/index.php">トップページ</a>
 <a href="../views/mypage.php">マイページへ</a>
</body>

</html>