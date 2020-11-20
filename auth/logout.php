<?php
ini_set('display_errors', "On");
session_start();
include('AuthClass.php');
logout($_SESSION, 'index.php');
