<?php
session_start();
ini_set('display_errors', "On");
require_once dirname(__FILE__) . '/../Classes/auth/AdminClass.php';

//var_dump($_SESSION);
$admin = new AdminClass();
$post = $admin->sanitize($_POST);
//$admin->adminLogin();
$admin->login();
//var_dump($result);
