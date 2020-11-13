<?php
header('Content-Type: text/html; charset=UTF-8');
require('../Classes/Function/LikeClass.php');

$like = new LikeClass;
//$result_data = $like->isLikeApi(2, 14);
$result_data2 = $like->isLike(2, 14);
//echo $result_data;
echo '<br>';
echo json_encode($result_data2);
