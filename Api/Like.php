<?php
session_start();
// APIを実行するファイルにheaderを定義する
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
require('../Classes/Function/LikeClass.php');

$likeApi = new LikeClass;

//$data = json_decode(file_get_contents("php://input"));
//$data = json_decode($_POST['post_id']);
//$data2 = json_decode($_SESSION['auth_id']);

//$likeApi->post_id = $data->post_id;
$likeApi->post_id = $_POST['post_id'];
//$likeApi->user_id = $data2->user_id;
//$likeApi->user_id = $_SESSION['auth_id'];
$likeApi->user_id = $_POST['auth_id'];


if (!$likeApi->isLike($likeApi->post_id, $likeApi->user_id)) {
 $likeApi->addLikeApi();
 echo count($likeApi->getLike($likeApi->post_id));
 echo json_encode(array('message' => 'いいねしました'));
} else {
 $likeApi->rmLikeApi();
 echo count($likeApi->getLike($likeApi->post_id));
 echo json_encode(array('message' => 'いいねを削除しました'));
}
