<?php
ini_set('display_errors', "On");
require_once dirname(__FILE__) . '/../Classes/Function/UserClass.php';

$user = new UserClass;
$user = $user->getAllData();

var_dump($user);
