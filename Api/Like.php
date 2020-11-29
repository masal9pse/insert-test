<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

// APIを実行するファイルにheaderを定義する
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


use App\Controllers\LikeController;

$likeApi = new LikeController;

$likeApi->post_id = $_POST['post_id'];

if (!$likeApi->isLike($likeApi->post_id, $_SESSION['auth_id'])) {
 $likeApi->addLikeApi();
 echo count($likeApi->getLike($likeApi->post_id));
} else {
 $likeApi->rmLikeApi();
 echo count($likeApi->getLike($likeApi->post_id));
}
