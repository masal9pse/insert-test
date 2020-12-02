<?php
ini_set('display_errors', "On");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\SearchController;

$search = new SearchController;

//var_dump($_GET);
?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
</head>

<body>
 <a href="../views/index.php">トップページへ</a>
 <br>
 <?php
 if (!empty($_GET['tags'] && $_GET['search'] && $_GET['category'])) {
  $search->AllSearch();
 }

 if (!empty($_GET['tags'] && $_GET['category']) && empty($_GET['search'])) {
  $search->tagCategorySearch();
 }

 if (!empty($_GET['tags'] && $_GET['search']) && empty($_GET['category'])) {
  $search->tagTextSearch();
 }

 if (!empty($_GET['tags']) && empty($_GET['search']) && empty($_GET['category'])) {
  $search->tagSearch();
 }

 if (!empty($_GET['category'] && empty($_GET['search']) && empty($_GET['tags']))) {
  $search->categorySearch();
 }

 if (!empty($_GET['search']) && empty($_GET['category']) && empty($_GET['tags'])) {
  $search->textSearch();
 }

 if (!empty($_GET['category'] && $_GET['search']) && empty($_GET['tags'])) {
  $search->categoryTextSearch();
 }

 if (empty($_GET['search']) && empty($_GET['category']) && empty($_GET['tags'])) {
  $result = $search->AllNotSearch();
  echo $result;
 }
 ?>
</body>

</html>