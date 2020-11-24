<?php
session_start();
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\FollowController;

$followInstance = new FollowController;
$followInstance->auth_check('../auth/login.php');
var_dump($_POST);
var_dump($_SESSION);

if ($followInstance->check_follow($_SESSION['auth_id'], $_POST['follower_id'])) {
 $followInstance->unfollow();
} else {
 $followInstance->follow();
}
?>
<!-- 詳細ページに入ったらページのリンクを取得 -->
<a href="<?php echo $_SESSION['show_page'] ?>">戻る</a>
<a href="../views/index.php">トップページへ</a>