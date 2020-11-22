<?php
ini_set('display_errors', "On");
require('../Models/Function/SearchClass.php');
$searchInstance = new SearchClass;

var_dump($_GET);
$searchInstance->AllSearch();
$searchInstance->tagCategorySearch();
$searchInstance->tagTextSearch();
$searchInstance->tagSearch();
$searchInstance->categorySearch();
$searchInstance->textSearch();
$searchInstance->categoryTextSearch();
$searchInstance->AllNotSearch();
?>
<a href="../views/index.php">トップページへ</a>