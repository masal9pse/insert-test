<?php
ini_set('display_errors', "On");
session_start();
require_once dirname(__FILE__) . '/../Classes/Auth/AuthClass.php';
$authInstance = new AuthClass;
$authInstance->signUp();
