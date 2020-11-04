<?php
ini_set('display_errors', "On");
session_start();
include('../util.php');
logout($_SESSION, './login.php');
