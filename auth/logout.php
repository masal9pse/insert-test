<?php
ini_set('display_errors', "On");
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;

$auth = new AuthController;
$auth->logout($_SESSION, "../views/index.php");
