<?php
session_start();
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\LikeController;

$likeInstance = new LikeController();
$likeInstance->auth_check('../auth/login.php');
// issetが空文字でもtrueであるか調べる
var_dump($_SESSION);

if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
 echo "正常なリクエストです。" . "\n";
 echo "いいねしました";
 $likeInstance->addLike();
} else {
 echo "不正なリクエストです。";
}
?>
<a href="../views/index.php">トップページへ</a>