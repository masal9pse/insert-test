<?php
// APIを実行するファイルにheaderを定義する
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
require('../Classes/Function/LikeClass.php');

$likeApi = new LikeClass;

$data = json_decode(file_get_contents("php://input"));

$likeApi->post_id = $data->post_id;
$likeApi->user_id = $data->user_id;


if (!$likeApi->isLike($likeApi->post_id, $likeApi->user_id)) {
 $likeApi->addLikeApi();
 echo count($likeApi->getLike($likeApi->post_id));
 echo json_encode(array('message' => 'いいねしました'));
} else {
 $likeApi->rmLikeApi();
 echo count($likeApi->getLike($likeApi->post_id));
 echo json_encode(array('message' => 'いいねを削除しました'));
}
