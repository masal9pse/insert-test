<?php
ini_set('display_errors', "On");
require('../Models/Function/FollowClass.php');
session_start();
$followInstance = new FollowClass;
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