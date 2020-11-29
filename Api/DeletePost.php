<?php
session_start();
// APIを実行するファイルにheaderを定義する
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
require('../Models/Function/LikeClass.php');

require_once __DIR__ . '/../vendor/autoload.php';
