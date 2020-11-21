<?php
session_start();
// APIを実行するファイルにheaderを定義する
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
require('../Models/Function/LikeClass.php');

$likeApi = new LikeClass;

$likeApi->post_id = $_POST['post_id'];

if (!$likeApi->isLike($likeApi->post_id, $_SESSION['auth_id'])) {
 $likeApi->addLikeApi();
 echo count($likeApi->getLike($likeApi->post_id));
} else {
 $likeApi->rmLikeApi();
 echo count($likeApi->getLike($likeApi->post_id));
}
