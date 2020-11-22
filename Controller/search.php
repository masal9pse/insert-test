<?php
ini_set('display_errors', "On");
require('../Models/Function/SearchClass.php');
$searchInstance = new SearchClass;

var_dump($_GET);

if (!empty($_GET['tags'] && $_GET['search'] && $_GET['category'])) {
 $searchInstance->AllSearch();
}
if (!empty($_GET['tags'] && $_GET['category']) && empty($_GET['search'])) {
 $searchInstance->tagCategorySearch();
}

if (!empty($_GET['tags'] && $_GET['search']) && empty($_GET['category'])) {
 $searchInstance->tagTextSearch();
}

if (!empty($_GET['tags']) && empty($_GET['search']) && empty($_GET['category'])) {
 $searchInstance->tagSearch();
}

if (!empty($_GET['category'] && empty($_GET['search']) && empty($_GET['tags']))) {
 $searchInstance->categorySearch();
}

if (!empty($_GET['search']) && empty($_GET['category']) && empty($_GET['tags'])) {
 $searchInstance->textSearch();
}

if (!empty($_GET['category'] && $_GET['search']) && empty($_GET['tags'])) {
 $searchInstance->categoryTextSearch();
}

if (empty($_GET['search']) && empty($_GET['category']) && empty($_GET['tags'])) {
 $result = $searchInstance->AllNotSearch();
 echo $result;
}
?>
<a href="../views/index.php">トップページへ</a>