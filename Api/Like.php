<?php
require('../Classes/Function/LikeClass.php');

$likeApi = new LikeClass;

$data = json_decode(file_get_contents("php://input"));

$likeApi->post_id = $data->post_id;
$likeApi->user_id = $data->user_id;


if (!$likeApi->isLike($likeApi->post_id, $likeApi->user_id)) {
 $likeApi->addLikeApi();
 echo json_encode(
  array('message' => 'Like Created')
 );
} else {
 echo json_encode(
  array('message' => 'Like Not Created because theLike already exist')
 );
}
