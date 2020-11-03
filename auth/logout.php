<?php
session_start();
include('../util.php');
logout($_SESSION, './login.php');
